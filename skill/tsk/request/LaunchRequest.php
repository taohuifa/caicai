<?php
require_once dirname(__FILE__).'/'."Request.php";
class LaunchRequest extends Request{
	public function __construct($body) {
        parent::__construct($body);
    }
}
?>
