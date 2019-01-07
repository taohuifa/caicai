<?php
require_once dirname(__FILE__).'/'."Request.php";
require_once dirname(__FILE__).'/'."RetryMeta.php";
class RetryIntentRequest extends Request{
	public $dialogState;
	public $sourceIntent;
	public $retryMeta;
	public function __construct($body) {
        parent::__construct($body);
		$this->dialogState = $body->dialogState;
		$this->sourceIntent = $body->sourceIntent;
		$this->retryMeta = new RetryMeta($body->retryMeta);
    }
}
?>
