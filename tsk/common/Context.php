<?php
// require_once "System.php";   // ���php���ƶ�ȡ��
require_once "SystemA.php";

class Context{
	public $System;
	public $AudioPlayer;
    public function __construct($body) {
        $this->System = new System($body->System);
        $this->AudioPlayer = $body->AudioPlayer;
    }
}
?>