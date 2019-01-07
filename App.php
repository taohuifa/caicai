<?php

require_once "framework/uitls/utils.php";
require_once "framework/uitls/file.php";
require_once "framework/uitls/http.php";
// require_once dirname(__FILE__).'/'."framework/utils/json.php";
require_once "framework/component/log.php";

require_once "skill/Skill.php";

// App
class App
{
    protected $config;    // 配置
    protected $debug;     // debug标记 -> config中定义
    // 请求数据
    protected $header;
    protected $context;

    protected function __construct($config)
    {
        $this->config = $config;
    }

    // 初始化(每次请求)
    protected function init()
    {
        ignore_user_abort(true); // 后台运行
        set_time_limit(0); // 取消脚本运行时间的超时上限
        srand((float)microtime() * 1000000); // 随机种子
        
        // 参数
        $this->debug = get($this->config, "debug", true);
        
        // 日志初始化
        $logconfig = get($this->config, "log", array());
        $logpath = get($logconfig, "path", "./logs");
        $loglv = get($logconfig, "level", LOGGER_DEBUG);
        Log::getInstance()->reset($logpath, $loglv);
        
        
        // 测试功能
        $prev_request = "prev_request.txt";
        if ($this->debug) {
            // 如果请求数据为空, 读取上次数据
            if (empty($this->context)) {
                // 测试代码, 读取上次请求内容
                $request_file = read_file($prev_request);
                if (!empty($request_file)) {
                    $this->context = $request_file;
                }
                log_debug("get prev request context: \"" . $this->context . "\" -> \"" . $request_file . "\"");
            } else {
                // 非空, 储存起来
                write_file($prev_request, $this->context);
            }
        }
        return true;
    }

    protected function finish($result)
    {
    }
    
    // 请求操作
    protected function request()
    {
        return $this->responseNoFind();
    }
    
    
    // 回复
    public function responseNoFind()
    {
        return $this->response("404 No Find", "HTTP/1.1 404 Not Found");
    }
    
    
    // 回复
    public function response($body, $header = "Content-Type:application/json;charset=UTF-8;")
    {
        $body_str = "404 No Find";
        if (is_string($body)) {
            $body_str = $body;
        } else if (is_object($body)) {
            $body_str = json_encode($body);
        } else if (is_array($body)) {
            $body_str = json_encode($body);
        }

        return array(
            "header" => $header,
            "body" => $body_str,
        );
    }
    
    // main函数入口
    public function main()
    {
        // 提取请求
        $this->header = http_request_header();
        $this->context = http_request_context();
        log_info("request:\nheader: " . json_encode($this->header) . "\nbody: " . $this->context);
        
        // 初始化
        if (!$this->init()) {
            log_error("init failt! ");
            header("HTTP/1.1 404 Not Found");
            echo "404 No Find";
            return;
        }
        
        // 执行请求操作
        $result = $this->request();
        
        // 结束处理
        $this->finish($result);
        
        // 检测返回值
        if (!isset($result) || !isset($result["header"]) || !isset($result["body"])) {
            header('HTTP/1.1 404 Not Found');
            header("status: 404 Not Found");
            echo "404 Not Found";
            return;
        }
        log_info("response:\nhander: " . $result["header"] . "\nbody: " . $result["body"]);
        
        // 回复
        header($result["header"]);
        echo $result["body"];
    }



}


?>


