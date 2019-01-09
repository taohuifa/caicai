<?php

require_once "DtLanguage.php";

define("GAMESTATE_DT_PLAY", 1);    // 问答开始

define("PROBLEM_COUNT", 3);    // 题库数量, 4种: 文本, 图文, 视频

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
        
        // TODO 跳过(不做)
        
        
        // 检测答案
        log_debug("answer : " . $this->body->request->queryText);
        if ($this->body->request->queryText != $problem["answer"]) {
            $isNeedTips = DtLanguage::checkNeedTipInput($this->body->request);
            
            // 检测提示数
            $max_tips_count = (!empty($problem["prompt_total"])) ? $problem["prompt_total"] : 0;
            if ($this->tips_count >= $max_tips_count) {
                if ($isNeedTips) {
                    // 请求提示
                    return $this->response(SkillRsp::Build(Language::GameNoTip_Voice, null, false));
                }
                return $this->nextProblem("回答错误, 下一题.", "");
            }
            // 转成提示
            $this->tips_count++;
            $pstr = $problem["prompt_" . $this->tips_count];
            return $this->response(SkillRsp::Build($pstr, null, false));
        }
        
        // 下一题
        log_debug("answer success! " . $this->problem_type . " " . $this->problem_index);
        return $this->nextProblem("回答正确, 下一题.", "");
        // return $this->response(SkillRsp::BuildH5("你好", "https://blog.chiyl.info/caicai/word_caicai.php?id=2&step=2", false));
    }
    
    // 获取不同题库的表
    protected function getProblemTableNameBy($problem_type)
    {
        switch ($problem_type) {
            case 1:
                return "word_caicai";
            case 2:
                return "pic_caicai";
            case 3:
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
    
    // 完成游戏
    protected function finishGame()
    {
        $this->skill->state = STATE_EXIT;

        $text = "恭喜你答完所有题目";
        return $this->response(SkillRsp::Build($text, $text, true));
    }
    
    // 下个问题
    protected function nextProblem($prevOutSpeech = "", $prevText = "")
    {
        log_debug("next_problem index start. ");
        // 读取所有题目
        // $this->problem_type = rand(0, PROBLEM_COUNT) + 1;
        $this->problem_type = 1;
        $this->problem_index = $this->getRandProblemId($this->problem_type);
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
        return $this->response(SkillRsp::Build($prevOutSpeech . $problem["outspeech"], $prevText . $problem["content"], false));
    }

}



?>