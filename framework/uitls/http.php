<?php



// 参数获取(支持post和get的参数)
function http_get($key, $default)
{
    // $_REQUEST 默认情况下包含了 $_GET，$_POST 和 $_COOKIE 的数组
    $val = isset($_REQUEST[$key]) ? $_REQUEST[$key] : null;
    return ($val != null) ? $val : $default;
}

// 获取请求头
function http_request_header()
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
function http_request_context()
{
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        return isset($_GET["context"]) ? $_GET["context"] : "";
    }
    return file_get_contents('php://input');
}



?>