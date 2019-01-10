<?php

require_once "DtLanguage.php";

define("GAMESTATE_DT_PLAY", 1);    // 问答开始
define("GAMESTATE_DT_TIEZHI", 2);    // 查看贴纸

define("PROBLEM_COUNT", 3);    // 题库数量, 4种: 文本, 图文, 视频
define("PROBLEM_TYPE_WORD", 1); // 文本题
define("PROBLEM_TYPE_PIC", 2); // 图片题
define("PROBLEM_TYPE_VIDEO", 3); // 视频题


// 答题游戏
class DtGame extends Game
{
    protected $mysql;   // 数据库API
    
    // 游戏状态: public才能打入json
    public $problem_type;   // 题库类型
    public $problem_index;
    public $problem_count; // 问题数量
    public $tips_count; // 当前提示数
    public $score;  //分数
    public $used_problem_ids;   // 出过的题

    public function __construct($skill, $type)
    {
        parent::__construct($skill, $type);
        $this->problem_type = 0;
        $this->problem_index = -1;
        $this->problem_count = 0;
        $this->tips_count = 0;
        $this->score = 0;
        $this->used_problem_ids = array();

        $this->mysql = new MysqlApi();
        log_debug("create dt game");

    }

    
    // 图文
    public function BuildH5View($problem, $shouldEndSession = true, $istip = false, $prevOutSpeech = "")
    {
        // https://blog.chiyl.info/caicai/word_caicai.php?id=1004&step=1&sessionid=abc
        $url = "";
        $voice = $prevOutSpeech . $problem["outspeech"];
        if ($this->problem_type == PROBLEM_TYPE_WORD) {
            $url = "https://blog.chiyl.info/caicai/word_caicai.php?id=" . $this->problem_index . "&step=" . $this->tips_count . "&sessionid=" . $this->sessionId;
            if ($istip) {
                $voice = $problem["prompt_" . $this->tips_count];
            }
        } else if ($this->problem_type == PROBLEM_TYPE_PIC) {
            $url = "https://blog.chiyl.info/caicai/pic_caicai.php?id=" . $this->problem_index . "&step=" . $this->tips_count . "&sessionid=" . $this->sessionId;
            if ($istip) {
                $voice = "再给你个提示";
            }
        } else if ($this->problem_type == PROBLEM_TYPE_VIDEO) {
            $url = "https://blog.chiyl.info/caicai/video_caicai.php?id=" . $this->problem_index . "&step=" . $this->tips_count . "&sessionid=" . $this->sessionId;
            if ($istip) {
                $voice = "再给你个提示";
            }
        }

        log_info("url: " . $url);
        return SkillRsp::BuildH5($voice, $url, $shouldEndSession);
    }
    
    
    // 图文
    public function BuildH5TZView()
    {
        $url = "https://blog.chiyl.info/caicai/tiezhi_caicai.php?sessionid=$this->sessionId&step=0";
        return SkillRsp::BuildH5("看一看你的贴纸吧", $url, false);
    }
    
    // 添加贴纸记录
    protected function AddTieZhiToSql($problem_type, $problem_id)
    {
        log_debug("add tiezhi  $this->sessionId$problem_type, $problem_id");
        // // 判断是否拥有这个贴纸
        // $sql = "select `sessionid`, `ques_id`, `ques_type` from `tiezhi_caicai` where sessionid='$this->sessionId' and `ques_id`=$problem_id and `ques_type`='$problem_type' limit 1";
        // $result = $this->mysql->query_once($sql);
        // if (!empty($result)) {
        //     log_debug("has tiezhi  $this->sessionId$problem_type, $problem_id");
        //     return false;
        // }
        
        // 插入贴纸
        $sql = "insert into `tiezhi_caicai` ( `sessionid`, `ques_id`, `ques_type`) values ('" . $this->sessionId . "', " . $problem_id . ", '" . $problem_type . "')";
        $this->mysql->update($sql);
        return true;
    }
    
    // 检测答案
    protected function checkAnswer($queryText, $answer)
    {
        // 全文检测
        if ($queryText == $answer) {
            return true;
        }
        
        // 正则检测
        // $pattern = $answer;
        // log_debug("preg_match: $pattern $queryText");
        // if (preg_match($pattern, $queryText) > 0) {
        //     return true;
        // }
            
        // 检测是否包括
        if (strpos($queryText, $answer, 0) != false) {
            return true;
        }
        
        // 关键字检测
        $itemTexts = array(
            "是不是" . $answer,
            "我猜是" . $answer,
        );
        $cr = Language::checkInputByTexts($queryText, $itemTexts);
        log_debug("checkInputByTexts: $cr");
        if ($cr >= 0) {
            return true;
        }

        return false;
    }
    
    // 获取提示总数
    protected function getPromptTotal($problem, $problem_type, $problem_index)
    {
        if ($problem_type == PROBLEM_TYPE_VIDEO) {
            return (!empty($problem["video_total"])) ? $problem["video_total"] : 0;
        }
        return (!empty($problem["prompt_total"])) ? $problem["prompt_total"] : 0;
    }

    public function request()
    {
        log_debug("dtgame request: " . $this->skill->state);
        // 判断技能状态
        if ($this->skill->state == STATE_START) {
            $this->skill->state = STATE_PLAYING;
            $this->gameState = GAMESTATE_DT_PLAY;
            // 先说明
            return $this->response(SkillRsp::Build(DtLanguage::GameStart_Text, DtLanguage::GameStart_Voice, false));
        }
        log_debug("dt test 1");
        // 提取问题
        if ($this->problem_type <= 0 || $this->problem_index < 0) {
            // 随机下一题
            return $this->nextProblem();
        }
        
        // 获取题目
        $problem = $this->getProblem($this->problem_type, $this->problem_index);
        if (empty($problem)) {
            $this->problem_type = 0;
            $this->problem_index = 0;
            $this->tips_count = 0;
            log_error("no find problem by index! index=" . $this->problem_index);
            return $this->response(SkillRsp::Build(Language::AppError_Voice, Language::AppError_Text, true));
        }
        
        // TODO 继续, 不做处理, 刷新页面
        if ($this->gameState == GAMESTATE_DT_TIEZHI || DtLanguage::checkJiXuInput($this->body->request)) {
            $this->gameState = GAMESTATE_DT_PLAY;
            return $this->response($this->BuildH5View($problem, false, false, ""));
        }
        
        
        // 展现贴纸
        if (DtLanguage::checkOpenTieZhiInput($this->body->request)) {
            $this->gameState = GAMESTATE_DT_TIEZHI;
            return $this->response($this->BuildH5TZView());
        }
        
        // 检测答案
        log_debug("answer : " . $this->body->request->queryText);
        if (!$this->checkAnswer($this->body->request->queryText, $problem["answer"])) {
            $isNeedTips = DtLanguage::checkNeedTipInput($this->body->request);
            
            // 检测提示数
            $max_tips_count = $this->getPromptTotal($problem, $this->problem_type, $this->problem_index);
            if ($this->tips_count >= $max_tips_count) {
                if ($isNeedTips) {
                    // 请求提示
                    return $this->response(SkillRsp::Build(Language::GameNoTip_Voice, null, false));
                }
                return $this->nextProblem("回答错误, 下一题.", "");
            }
            // 转成提示
            $this->tips_count++;
            // $pstr = $problem["prompt_" . $this->tips_count];
            // return $this->response(SkillRsp::Build($pstr, null, false));
            return $this->response($this->BuildH5View($problem, false, true));
        }
        
        // 增加分数
        $this->score = $this->score + 1;
        $this->updateToRank(0, $this->score);
        
        // 下一题
        log_debug("answer success! " . $this->problem_type . " " . $this->problem_index);
        $this->AddTieZhiToSql($this->problem_type, $this->problem_index);
        return $this->nextProblem("回答正确, 下一题.", "");
        // return $this->response(SkillRsp::BuildH5("你好", "https://blog.chiyl.info/caicai/word_caicai.php?id=2&step=2", false));
    }
    
    // 获取不同题库的表
    protected function getProblemTableNameBy($problem_type)
    {
        switch ($problem_type) {
            case PROBLEM_TYPE_WORD:
                return "word_caicai";
            case PROBLEM_TYPE_PIC:
                return "pic_caicai";
            case PROBLEM_TYPE_VIDEO:
                return "video_caicai";
        }
        return null;
    }
    
    // 获取
    protected function getProblem($problem_type, $problem_index)
    {
        log_debug("getProblem: " . $problem_type . " " . $problem_index);
        
        // 根据提取选择表名
        $table_name = $this->getProblemTableNameBy($problem_type);
        if (empty($table_name)) {
            log_error("getProblemTableNameBy fail! type=" . $problem_type);
            return null;
        }
        
        // 生成sql
        $sql = "select * from `" . $table_name . "` where id='" . $problem_index . "' limit 1";
        log_debug("sql: " . $sql);
        
        // 数据库查询
        $result = $this->mysql->query_once($sql);
        if (empty($result)) {
            log_error("no find problem! sql=" . $sql);
            return null;
        }
        // 标记下类型
        $result["type"] = $problem_type;
        log_debug("getProblem2: " . json_encode($result));
        return $result;
    }

    // 转化成列表
    protected static function getListStr($array)
    {
        $used_count = count($array);
        if ($used_count <= 0) {
            return "";
        }
        
        // 遍历生成字段
        $str = "";
        for ($i = 0; $i < $used_count; $i++) {
            if ($i > 0) {
                $str = $str . ",";
            }
            $str = $str . $array[$i];
        }
        return $str;
    }
    
    // 获取
    protected function getRandProblemId($problem_type)
    {
        log_debug("getRandProblemId $problem_type");
        // 根据提取选择表名
        $table_name = $this->getProblemTableNameBy($problem_type);
        if (empty($table_name)) {
            log_error("getProblemTableNameBy fail! type=" . $problem_type);
            return null;
        }
        
        // 生成sql
        $sql = "select `id` from `" . $table_name . "` ";
        $used_count = count($this->used_problem_ids);
        if ($used_count > 0) {
            $sql = $sql . " where `id` NOT IN (" . self::getListStr($this->used_problem_ids) . ") ";
        }
        $sql = $sql . " order by rand() limit 1";
        log_debug("sql: " . $sql);
        
        // 数据库查询
        $result = $this->mysql->query_once($sql);
        if (empty($result)) {
            log_debug("no result by " . $sql);
            return 0;   // 没有题目
        }

        log_debug("rand problemId: " . $result["id"]);
        return $result["id"];
    }
     // 获取
    protected function getRandProblem()
    {
        // $problem_type = PROBLEM_TYPE_VIDEO;
        // $problem_id = $this->getRandProblemId($problem_type);
        // return array("id" => $problem_id, "type" => $problem_type);
        
        // $problem_type_start = rand(PROBLEM_TYPE_WORD, PROBLEM_COUNT);
        $problem_type_start = 1 + ($this->problem_count % PROBLEM_COUNT);
        for ($i = 0; $i < PROBLEM_COUNT; $i++) {
            $problem_type = 1 + ($problem_type_start + $i) % PROBLEM_COUNT;
            $problem_id = $this->getRandProblemId($problem_type);
            log_debug("get t=$problem_type id=$problem_id");
            if ($problem_id <= 0) {
                continue;   // 下个题库试试
            }
            return array("id" => $problem_id, "type" => $problem_type);
        }
        return array("id" => 0, "type" => 0);
    }
    
    // 完成游戏
    protected function finishGame()
    {
        $this->skill->state = STATE_EXIT;

        $rankIndex = $this->getRankIndex(0);

        $text = "恭喜你答完所有题目";
        return $this->response(SkillRsp::Build($text, $text, true));
    }
    
    // 下个问题
    protected function nextProblem($prevOutSpeech = "", $prevText = "")
    {
        log_debug("next_problem index start. ");
        // 读取所有题目
        // $this->problem_type = PROBLEM_TYPE_VIDEO;
        $problemInfo = $this->getRandProblem();
        $this->problem_type = $problemInfo["type"];
        $this->problem_index = $problemInfo["id"];
        $this->tips_count = 0;

        if ($this->problem_index <= 0) {
            // 判断是否有题目过
            if ($this->problem_count <= 0) {
                log_error("no problem! ");
                return $this->response(SkillRsp::Build(Language::AppError_Voice, Language::AppError_Text, true));
            }
            // 没有题目了, 算完成
            return $this->finishGame();
        }
        
        // 插入到出题列表中
        array_push($this->used_problem_ids, $this->problem_index);
        $this->problem_count = $this->problem_count + 1;
     
        // 获取题目
        $problem = $this->getProblem($this->problem_type, $this->problem_index);
        if (empty($problem)) {
            log_error("no find problem by index! index=" . $this->problem_index);
            return $this->response(SkillRsp::Build(Language::AppError_Voice, Language::AppError_Text, true));
        }

        $this->problem_count = $this->problem_count + 1;
        log_debug("next_problem index: " . $this->problem_index);
      
        // 生成问题
        // $text = self::getProblemSelectText($problem);
        // log_debug("csz_next_problem 1 " . $text);
        // return $this->response(SkillRsp::Build($prevOutSpeech . $problem["outspeech"], $prevText . $problem["content"], false));
        return $this->response($this->BuildH5View($problem, false, false, $prevOutSpeech));
    }

}



?>