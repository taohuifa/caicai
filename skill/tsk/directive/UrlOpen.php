<?php
require_once dirname(__FILE__) . '/' . "Directive.php";

// H5页面展示
class UrlOpen extends Directive
{
	public $token;
	public $template;
	public $url;
	public $type;
	public $destinationName;

	public function __construct($body, $url = "https://blog.chiyl.info/caicai/word_caicai.php?id=2&step=2")
	{
		$this->type = "URI.Open";
		$this->token = $body['token'];
		$this->url = $url;
		$this->destinationName = "destinationName";
		$this->template = null;
	}
}



?>