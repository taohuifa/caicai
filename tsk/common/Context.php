<?php
// require_once "System.php";   // 这个php限制读取了
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