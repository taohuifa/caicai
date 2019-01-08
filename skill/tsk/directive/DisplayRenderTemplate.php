<?php
require_once dirname(__FILE__).'/'."Directive.php";
require_once dirname(__FILE__).'/'."Template.php";
class DisplayRenderTemplate extends Directive{
	public $token;
	public $template;
	public $url;
	public $type;
	public $destinationName;
	public function __construct($body) {
        $this->type = "URI.Open";
		$this->token = $body['token'];
		$this->url = "https://blog.chiyl.info/caicai/word_caicai.php?id=2&step=2";
        $this->destinationName = "destinationName";
        $this->template="";
        #$this->template = new Template($body['template']);
	}
}
?>
