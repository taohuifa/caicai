<?php
require_once "tsk/common/Session.php";
require_once "tsk/common/Context.php";
require_once "tsk/request/LaunchRequest.php";
require_once "tsk/request/IntentRequest.php";
require_once "tsk/request/SessionEndedRequest.php";
require_once "tsk/request/RetryIntentRequest.php";

// 技能请求
class SkillReq
{
    public $version;
    public $session;
    public $context;
    public $request;

    // 请求解析
    public function __construct($context)
    {
        $body = json_decode($context);

        $this->version = $body->version;
        $this->session = new Session($body->session);
        $this->context = new Context($body->context);
        $request = "";
        switch ($body->request->type) {
            case "LaunchRequest":
                $request = new LaunchRequest($body->request);
                break;
            case "IntentRequest":
                $request = new IntentRequest($body->request);
                break;
            case "SessionEndedRequest":
                $request = new SessionEndedRequest($body->request);
                break;
            case "RetryIntentRequest":
                $request = new RetryIntentRequest($body->request);
                break;
            default:
                $request = new IntentRequest($body->request);
        }
        $this->request = $request;
    }



};



?>