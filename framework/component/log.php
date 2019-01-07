<?php

define("LOGGER_DEBUG", 0);
define("LOGGER_INFO", 1);
define("LOGGER_WARN", 2);
define("LOGGER_ERROR", 3);

// 日志
class Log
{
    private $path = "./logs";  // 日志输出路径
    private $loglv = LOGGER_DEBUG; // 输出级别
    
    // 重新初始化路径
    public function reset($path, $loglv)
    {
        if (!is_string($path)) {
            die("set log path fail! " . json_encode($path));
        }
        $this->path = $path;
        $this->loglv = $loglv;
        
        // 判断路径是否存在
        if (!file_exists($this->path)) {
            mkdir($this->path, 0777, true);
        }
    }

    // 获取日志等级名称
    private static function getLogLvName($loglv)
    {
        switch ($loglv) {
            case LOGGER_DEBUG:
                return "DEBUG";
            case LOGGER_INFO:
                return "INFO";
            case LOGGER_WARN:
                return "WARN";
            case LOGGER_ERROR:
                return "ERROR";
        }
        return "UNKNOW";
    }
    
    // 输出日志 堆栈: https://blog.csdn.net/newjueqi/article/details/6865722
    public function write($loglv, $logdata)
    {
        // 检测日志级别
        if ($loglv < $this->loglv) {
            return false;
        }
        
        // 数据类型检测
        $logstr = $logdata;
        if (is_array($logdata)) {
            $logstr = json_encode($logdata);
        }
        // 日志路径, 输出文件
        $filename = $this->path . "/" . date("Y-m-d") . ".log";
        // 字符拼接
        $str = self::getLogLvName($loglv) . " " . date("Y-m-d H:i:s") . " $logdata" . "\n";
        // 输出
        file_put_contents($filename, $str, FILE_APPEND | LOCK_EX);
        return true;
    }

    private static $instance;   // 单例
    public static function getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }

}


function log_debug($logdata)
{
    return Log::getInstance()->write(LOGGER_DEBUG, $logdata);
}

function log_info($logdata)
{
    return Log::getInstance()->write(LOGGER_INFO, $logdata);
}

function log_warn($logdata)
{
    return Log::getInstance()->write(LOGGER_WARN, $logdata);
}

function log_error($logdata)
{
    return Log::getInstance()->write(LOGGER_ERROR, $logdata);
}

?>


