<?php

// ������ȡ(֧��post��get�Ĳ���)
function get($key, $default)
{
    // $_REQUEST Ĭ������°����� $_GET��$_POST �� $_COOKIE ������
    $val = isset($_REQUEST[$key]) ? $_REQUEST[$key] : null;
    return ($val != null) ? $val : $default;
}

// ��ȡ����ͷ
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

// ��ȡ��������(Getģʽģ���context�Ĳ���)
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
    
    // �ж�·���Ƿ����
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
}

// ��־���
function log_write($data)
{
    // �������ͼ��
    if (is_array($data)) {
        $data = json_encode($data);
    }
    // ��־·��
    $logpath = "./log";
    if (isset($GLOBALS["log_path"])) {
        $logpath = $GLOBALS["log_path"];
    }
    // ����ļ�
    $filename = $logpath . "/" . date("Y-m-d") . ".log";
    // �ַ�ƴ��
    $str = date("Y-m-d H:i:s") . " $data" . "\n";
    // ���
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


// ��ȡ�ļ�
function read_file($filepath)
{
    $f = fopen($filepath, "r");
    $fstr = fread($f, filesize($filepath));
    fclose($f);
    return $fstr;
}


?>


