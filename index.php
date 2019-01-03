<?php
// phpinfo();
// header("Content-Type: text/html; charset=utf-8");

require_once "config.php";
require_once "common.php";
require_once "handler.php";

// main 函数
function main()
{
    ignore_user_abort(true); // 后台运行
    set_time_limit(0); // 取消脚本运行时间的超时上限
    srand((float)microtime() * 1000000); // 随机种子

    global $config;
    // var_dump($config);
    // var_dump($_SERVER['SCRIPT_URI']); 
    // var_dump(__FILE__);
    
    // 日志路径
    $log_config = $config["log"];
    set_log_path($log_config["path"]);
    
    // 提取请求
    $header = get_request_header();
    $context = get_request_context();
    log_info("request:\nheader: " . json_encode($header) . "\nbody: " . $context);
    
    // 执行请求
    $result = request($header, $context);
    // var_dump($result);
    if (!isset($result) || !isset($result["header"]) || !isset($result["body"])) {
        header('HTTP/1.1 404 Not Found');
        header("status: 404 Not Found");
        echo "404 Not Found";
        return;
    }

    // 回复
    log_info("response:\nhander: " . $result["header"] . "\nbody: " . $result["body"]);
    header($result["header"]);
    echo $result["body"];
}

// 执行处理
try {
    main();
} catch (Exception $e) {
    echo "ERROR: " + $e->getMessage();
}

?>








