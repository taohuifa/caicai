<?php

define("GAMESTATE_CT_PLAY", 1);    // 问答开始



// 题库
$ct_problems = array(
    array(
        "problem" => "你觉得你帅吗 ",
        "selectItems" => array(
            "帅", "不帅",
        ),
        "answer" => 2,
    ),

    array(
        "problem" => "你觉得你丑吗 ",
        "selectItems" => array(
            "丑", "很丑", "灰常丑",
        ),
        "answer" => 3,
    ),
    array(
        "problem" => "信春哥就选1",
        "selectItems" => array(
            "1", "2", "3",
        ),
        "answer" => 1,
    ),
    array(
        "problem" => "随意选就好了",
        "selectItems" => array(
            "1", "2", "3",
        ),
        "answer" => 3,
    ),
);

// 猜题游戏
class CtGame extends Game
{
    // 游戏状态: public才能打入json
    public $problem_index;
    public $problem_count; // 问题数量
    public $score;  //分数

    public function __construct($skill, $type)
    {
        parent::__construct($skill, $type);
        $this->problem_index = -1;
        $this->problem_count = 0;
        $this->score = 0;
    }

    public function request()
    {
        // 判断技能状态
        if ($this->skill->state == STATE_START) {
            $this->skill->state = STATE_PLAYING;
            $this->gameState = GAMESTATE_CT_PLAY;
            // 先说明
            $text = "答对一题+10分, 打错失败, 明白请继续";
            return $this->response(SkillRsp::Build($text, $text, false));
        }
        // 运行状态
        global $ct_problems;
        
        // 提取问题
        if ($this->problem_index < 0) {
            // 随机下一题
            $r = rand(0, count($ct_problems) - 1);
            return $this->nextProblem($ct_problems, $r);
        }
        // 提取问题
        $problem = $ct_problems[$this->problem_index];
        if (empty($problem)) {
            log_error("no find problem by index! index=" . $this->problem_index);
            return $this->response(SkillRsp::Build(Language::AppError_Voice, Language::AppError_Text, true));
        }
        // 遍历检测答案
        $selectIndex = 0;
         // 直接选项名字比对
        $selectIndex = Language::checkInputByTexts($this->body->request->queryText, $problem["selectItems"]);
        if ($selectIndex < 0) {
             // 识别选项
            $selectIndex = Language::checkSelectInput($this->body->request, count($problem["selectItems"]));
        }
        log_debug("change state 2, select:" . $selectIndex);

        // 检测回答
        if ($selectIndex < 0) {
            // 不在选项中, 再问一边.
            $text = self::getProblemSelectText($problem);
            return $this->response(SkillRsp::Build(Language::GameUnknow_Voice, Language::GameUnknow_Text . $text, false));
        }
        log_debug("select index: " . $selectIndex);
        
        // 检测答案
        if ($problem["answer"] != ($selectIndex + 1)) {
            $this->skill->state = STATE_EXIT;
            $text = "回答错误, 垃圾. 当前分数: " . $this->score . " 答对数: " . ($this->problem_count - 1) . ", 请继续.";
            return $this->response(SkillRsp::Build("回答错误, 垃圾", $text, false));
        }
        // 回答正确 
        $this->problem_index = -1;  // 清除题目索引
        $this->score = $this->score + 10;
        log_debug("answer ok: " . $this->score);

        $text = "恭喜回答正确. 当前分数: " . $this->score . " 答对数: " . $this->problem_count . ", 请继续.";
        return $this->response(SkillRsp::Build("恭喜回答正确", $text, false));
        
        // return $this->response(SkillRsp::Build("服务器运行中", "服务器运行中, 请继续.", false));
    }
    
    
    // 下个问题
    protected function nextProblem($problems, $problem_index)
    {
        log_info("ct game next problem: " . $problem_index);
        // 获取题目
        $problem = $problems[$problem_index];
        if ($problem == null) {
            log_error("no find problem by index! index=" . $problem_index . '/' . count($problems));
            return $this->response(SkillRsp::Build(Language::AppError_Voice, Language::AppError_Text, true));
        }
        $this->problem_index = $problem_index;
        $this->problem_count = $this->problem_count + 1;
        log_debug("csz_next_problem index: " . $problem_index . '/' . count($problems));
      
        // 生成问题
        $text = self::getProblemSelectText($problem);
        log_debug("csz_next_problem 1 " . $text);
        return $this->response(SkillRsp::Build($problem["problem"], $problem["problem"] . $text, false));
    }
    
    // 获取问题选项文本
    private static function getProblemSelectText($problem)
    {
        return Language::createGameSelectText($problem["selectItems"], "选项%d是%s ");
    }
}



?>