<?php



// 游戏状态
define("STATE_NULL", 0);    // 无状态
define("STATE_SELECT", 1);   // 选择模式
define("STATE_START", 2);   // 开始
define("STATE_PLAYING", 3); // 游戏中
define("STATE_EXIT", 4);    // 退出

// 游戏状态
define("GAMESTATE_NULL", 0);    // 无状态

// 游戏类型
define("GAMETYPE_NULL", 0);
define("GAMETYPE_CT", 1);    // 猜题游戏
define("GAMETYPE_DT", 2);    // 答题游戏


// 游戏常量
class GameConst
{
    public static $GAMETYPE_NAMES = array("猜题", "答题");// 游戏类型名数组
    
    
};


?>