<?php
require_once dirname(__FILE__).'/'."Request.php";
require_once dirname(__FILE__).'/'."SessionEndedError.php";
class SessionEndedRequest extends Request{
	public $reason;
	public $error;
	public function __construct($body) {
        parent::__construct($body);
		$this->reason = $body->reason;
		$this->error = new SessionEndedError($body->error);
    }
}
?>
