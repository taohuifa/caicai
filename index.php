<?php
// phpinfo();

// php设置
set_include_path(dirname(__FILE__));    // 文件路径
ini_set('display_errors', 1);           // 错误信息
ini_set('display_startup_errors', 1);   // php启动错误信息
error_reporting(-1);                    // 打印出所有的 错误信息
ini_set('error_log', dirname(__FILE__) . '/logs/error_log.txt'); // 将出错信息输出到一个文本
// echo dirname(__FILE__) . '/logs/error_log.txt';

require_once "Config.php";
require_once "App.php";
require_once "skill/Skill.php";

// 执行处理
try {
    $skill = new Skill($config);
    $skill->main();
} catch (Exception $e) {
    echo "ERROR: " + $e->getMessage();
}
?>








