<?php

require_once dirname(__FILE__) . '/' . "tsk/response/Response.php";
require_once dirname(__FILE__) . '/' . "tsk/response/OutputSpeech.php";
require_once dirname(__FILE__) . '/' . "tsk/directive/DisplayRenderTemplate.php";
require_once dirname(__FILE__) . '/' . "tsk/directive/DialogElicitSlot.php";
require_once dirname(__FILE__) . '/' . "tsk/directive/UrlOpen.php";
require_once dirname(__FILE__) . '/' . "tsk/entity/TextContentObj.php";

// 技能回复
class SkillRsp
{
    public $version;
    public $response;

    public function __construct()
    {
        $this->version = "1.0";
    }

    /**
     * H5页面结果
     * @param voice 语音文本
     * @param description 文字文本
     * 
     * 
     */
    public static function BuildH5($voice, $url, $shouldEndSession = true)
    {
        log_debug("build h5 " . $url);
        $reponse = array();
        $reponse['outputSpeech'] = new OutputSpeech(array(
            "type" => "PlainText",
            "text" => $voice,
        ));
        $reponse['shouldEndSession'] = $shouldEndSession;

        $skillBody = new SkillRsp();
        $rsp = new Response($reponse);
        
        // 输出模板
        $directiveCfg = array();
        $directiveCfg["token"] = self::get_token();
        
        // 生成h5视图
        $displayDirective = new UrlOpen($directiveCfg, $url);
        $rsp->add_direvtives($displayDirective);
        $skillBody->response = $rsp;
        return $skillBody;
    }

    /**
     * 页面结果
     * @param voice 语音文本
     * @param description 文字文本
     * 
     * 
     */
    public static function Build($voice, $description, $shouldEndSession = true)
    {
        $reponse = array();
        $reponse['outputSpeech'] = new OutputSpeech(array(
            "type" => "PlainText",
            "text" => $voice,
        ));
        $reponse['shouldEndSession'] = $shouldEndSession;

        $skillBody = new SkillRsp();
        $rsp = new Response($reponse);

        // 文本输出
        if (!empty($description)) {
            // 输出模板
            $directiveCfg = array(
                "type" => "Display.RenderTemplate",
                "template" => array(
                    "type" => "NewsBodyTemplate1",
                    "textContent" => array(
                        "title" => "",
                        "description" => "猜一猜测试"
                    ),
                    "backgroundImage" => array(
                        "contentDescription" => "string",
                        "source" => array(
                            "url" => "http://softimtt.myapp.com/browser/smart_service/ugc_skill/skill_demo_fangdai.jpg"
                        )
                    ),
                    "backgroundAudio" => array(
                        "source" => array(
                            "url" => "string"
                        )
                    ),
                    "url" => "string"
                )
            );
            $directiveCfg["token"] = self::get_token();
            $displayDirective = new DisplayRenderTemplate($directiveCfg);
            unset($displayDirective->template->backgroundAudio);
            unset($displayDirective->template->url);
            unset($displayDirective->template->listItems);
            unset($displayDirective->template->backgroundImage->contentDescription);
            $displayDirective->template->textContent = new TextContentObj(array(
                'title' => "",		//显示标题
                'description' => $description, // 显示内容
            ));
            
            // 添加展现视图
            $rsp->add_direvtives($displayDirective);
        }

        $skillBody->response = $rsp;
        return $skillBody;
    }


    public static function get_token($length = 16)
    {
        $str = substr(md5(time()), 0, $length);//md5加密，time()当前时间�?
        return $str;
    }
}


?>
