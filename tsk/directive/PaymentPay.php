<?php
require_once dirname(__FILE__).'/'."Directive.php";
class PaymentPay extends Directive{
	public $order;
	public function __construct($order) {
        $this->type = "Payment.Pay";
        $this->order = $order;
    }
}
?>
