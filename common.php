<?php

// 参数获取(支持post和get的参数)
function get($key, $default)
{
    // $_REQUEST 默认情况下包含了 $_GET，$_POST 和 $_COOKIE 的数组
    $val = isset($_REQUEST[$key]) ? $_REQUEST[$key] : null;
    return ($val != null) ? $val : $default;
}

// 获取请求头
function get_request_header()
{
    $header = array();
    foreach ($_SERVER as $key => $value) {
        if ('HTTP_' == substr($key, 0, 5)) {
            $header[str_replace('_', '-', substr($key, 5))] = $value;
        }
    }

    if (isset($_SERVER['CONTENT_TYPE'])) {
        $header['content-type'] = $_SERVER['CONTENT_TYPE'];
    }
    if (isset($_SERVER['CONTENT_LENGTH'])) {
        $header['content-length'] = $_SERVER['CONTENT_LENGTH'];
    }
    return $header;
}

// 获取请求内容(Get模式模拟成context的参数)
function get_request_context()
{
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        return isset($_GET["context"]) ? $_GET["context"] : "";
    }
    return file_get_contents('php://input');
}

function set_log_path($path)
{
    $GLOBALS["log_path"] = $path;
    // echo "logpath: " . dirname(__FILE__) . " " . $path;
    
    // 判断路径是否存在
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
}

// 日志输出
function log_write($data)
{
    // 数据类型检测
    if (is_array($data)) {
        $data = json_encode($data);
    }
    // 日志路径
    $logpath = "./log";
    if (isset($GLOBALS["log_path"])) {
        $logpath = $GLOBALS["log_path"];
    }
    // 输出文件
    $filename = $logpath . "/" . date("Y-m-d") . ".log";
    // 字符拼接
    $str = date("Y-m-d H:i:s") . " $data" . "\n";
    // 输出
    file_put_contents($filename, $str, FILE_APPEND | LOCK_EX);
    return null;
}

function log_debug($data)
{
    return log_write("DEBUG " . $data);
}

function log_info($data)
{
    return log_write("INFO " . $data);
}

function log_warn($data)
{
    return log_write("WARN " . $data);
}

function log_error($data)
{
    return log_write("ERROR " . $data);
}


// 读取文件
function read_file($filepath)
{
    $f = fopen($filepath, "r");
    $fstr = fread($f, filesize($filepath));
    fclose($f);
    return $fstr;
}


?>


