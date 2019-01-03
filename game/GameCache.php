<?php
require_once "game/GameConst.php";

class GameCache
{
    public $state;  // ��ǰ״̬
    public $gameType;   // ѡ�����Ϸģʽ
    public $gameState;  // ��Ϸ״̬
    public $prevTime;   // �ϴδ���ʱ��

    public $csz_problem_index; // �������

    public function __construct($data)
    {
        // var_dump($data);
        $this->state = isset($data->state) ? $data->state : STATE_NULL;
        $this->gameType = isset($data->gameType) ? $data->gameType : GAMETYPE_NULL;
        $this->gameState = isset($data->gameState) ? $data->gameState : GAMESTATE_NULL;
        $this->prevTime = isset($data->prevTime) ? $data->prevTime : 0;

        $this->csz_problem_index = isset($data->csz_problem_index) ? $data->csz_problem_index : 0;
    }

}
?>