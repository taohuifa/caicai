<?php
require_once dirname(__FILE__).'/'."Application.php";
require_once dirname(__FILE__).'/'."Device.php";
require_once dirname(__FILE__).'/'."User.php";
class System{
	public $application;
	public $device;
	public $user;

    public function __construct($body) {
        $this->application = new Application($body->application);
		$this->device = new Device($body->device);
        $this->user = new User($body->user);
    }
}
?>
