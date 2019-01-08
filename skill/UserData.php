<?php

// 用户持久数据
class UserData
{
    protected $userId;  //用户Id

    // 储存数据, public才能打入json
    public $rcount;     // 总访问次数
    public $ctMaxScore; // ctgame最高分数

    public function __construct($userId)
    {
        $this->userId = $userId;
        $this->rcount = 0;
        $this->ctMaxScore = 0;
    }

    public function getUserId()
    {
        return $userId;
    }
};



?>




