<?php
require_once dirname(__FILE__).'/'."GameConst.php";

class GameCache
{
    public $state;  // ��ǰ��Ϸ״̬
    public $gameType;   // ѡ�����Ϸģʽ

    public function __construct($data)
    {
        // var_dump($data);
        $this->state = isset($data->state) ? $data->state : GAMESTATE_NULL;
        $this->gameType = isset($data->gameType) ? $data->gameType : GAMETYPE_NULL;
    }

}
?>
