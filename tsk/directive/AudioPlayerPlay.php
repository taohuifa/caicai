<?php
require_once dirname(__FILE__).'/'."AudioInfo.php";
require_once dirname(__FILE__).'/'."Directive.php";
class AudioPlayer extends Directive{
	public $playlist;
	public function __construct($body) {
        $this->type = "AudioPlayer.Play";
        $this->playlist = array();
    }
}
?>
