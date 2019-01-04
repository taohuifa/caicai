<?php
require_once dirname(__FILE__).'/'."GameConst.php";

class GameCache
{
    public $state;  // 当前状态
    public $gameType;   // 选择的游戏模式
    public $gameState;  // 游戏状态
    public $prevTime;   // 上次处理时间

    public $csz_problem_index; // 问题序号
    public $csz_score;          // 分数

    public function __construct($data)
    {
        // var_dump($data);
        $this->state = isset($data->state) ? $data->state : STATE_NULL;
        $this->gameType = isset($data->gameType) ? $data->gameType : GAMETYPE_NULL;
        $this->gameState = isset($data->gameState) ? $data->gameState : GAMESTATE_NULL;
        $this->prevTime = isset($data->prevTime) ? $data->prevTime : 0;

        $this->csz_problem_index = isset($data->csz_problem_index) ? $data->csz_problem_index : 0;
        $this->csz_score = isset($data->csz_score) ? $data->csz_score : 0;
    }

}
?>
