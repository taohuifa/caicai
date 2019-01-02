<?php
require_once dirname(__FILE__).'/'."GameConst.php";

class GameCache
{
    public $state;  // 当前游戏状态
    public $gameType;   // 选择的游戏模式

    public function __construct($data)
    {
        // var_dump($data);
        $this->state = isset($data->state) ? $data->state : GAMESTATE_NULL;
        $this->gameType = isset($data->gameType) ? $data->gameType : GAMETYPE_NULL;
    }

}
?>
