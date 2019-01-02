<?php

// 游戏状态
define("GAMESTATE_NULL", 0);    // 无状态
define("GAMESTATE_SELECT", 1);   // 选择模式
define("GAMESTATE_START", 2);   // 开始
define("GAMESTATE_PLAYIN", 3); // 游戏中
define("GAMESTATE_EXIT", 4);    // 退出



// 游戏类型
define("GAMETYPE_NULL", 0);
define("GAMETYPE_CSZ", 1);    // 猜数字


// 游戏常量
class GameConst
{
    public static $GAMETYPE_NAMES = array("猜数字");// 游戏类型名数组

}

?>


