<?php
require_once dirname(__FILE__).'/'."Directive.php";
class DialogElicitSlot extends Directive{
	public $slotToElicit;
	public $updatedIntent;
	public function __construct($body) {
        $this->type = "Dialog.ElicitSlot";
		$this->slotToElicit = $body['slotToElicit'];
        $this->updatedIntent = $body['updatedIntent'];
    }
}
?>
