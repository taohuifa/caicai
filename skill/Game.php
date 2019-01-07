<?php

// 游戏基类
class Game
{
    protected $skill;   // 技能
    protected $body;   // 请求数据(skill->body)
    protected $type;    // 游戏类型
    
    // 游戏状态, public才能打入json
    public $gameState;

    public function __construct($skill, $type)
    {
        $this->skill = $skill;
        $this->body = $skill->getBody();
        $this->type = $type;
        $this->GameState = GAMESTATE_NULL;
    }

    public function request()
    {
        return $this->skill->response(SkillRsp::Build("服务器运行中", "服务器运行中, 请继续.", false));
    }

    
    // 回复
    public function response($body, $header = "Content-Type:application/json;charset=UTF-8;")
    {
        return $this->skill->response($body, $header);
    }
    
    
    // 回复
    public function responseNoFind()
    {
        return $this->skill->responseNoFind();
    }
};




?>