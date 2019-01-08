<?php

define("GAMESTATE_DT_PLAY", 1);    // 问答开始


// 答题游戏
class DtGame extends Game
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
        return $this->response(SkillRsp::BuildH5("你好", "https://blog.chiyl.info/caicai/word_caicai.php?id=2&step=2", false));
    }


}



?>