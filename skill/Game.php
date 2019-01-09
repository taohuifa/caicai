<?php

// 游戏基类
class Game
{
    protected $skill;   // 技能
    protected $type;    // 游戏类型

    protected $body;   // 请求数据(skill->body)
    protected $userdata;    // 玩家数据
    protected $conn;        // mysql conn
    protected $sessionId;   // 玩家Id
    
    // 游戏状态, public才能打入json
    public $gameState;

    public function __construct($skill, $type)
    {
        $this->skill = $skill;
        $this->type = $type;
        $this->gameState = GAMESTATE_NULL;

        $this->body = $skill->getBody();
        $this->userdata = $skill->getUserData();
        $this->conn = $skill->getConn();
        $this->sessionId = $skill->getSessionId();

        log_debug("userdata by game: " . json_encode($this->userdata));
    }

        // 上传排行榜分数
    protected function updateToRank($rankType, $scoreA, $scoreB = 0, $scoreC = 0)
    {
        $sql = sprintf(
            "REPLACE INTO t_u_rank (UserId, GameType, RankType, ScoreA,ScoreB,ScoreC, UpdateTime) VALUES ('%s', %d, %d, %d, %d, %d, %d)",
            $this->sessionId,
            $this->type,
            $rankType,
            $scoreA,
            $scoreB,
            $scoreC,
            time()
        );
        log_debug("upload score, sql=" . $sql);
        // 执行保存
        if (!mysqli_query($this->conn, $sql)) {
            log_error("save mysql fail! sql=" . $sql);
            return false;
        }
        return true;
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