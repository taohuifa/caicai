<?php

require_once "Config.php";
require_once "framework/component/log.php";

class MysqlApi
{
	private $mysqli;
	public function __construct()
	{
		global $config;
		$hostname = $config['mysql']["host"];
		$port = 3306;
		$username = $config['mysql']["user"];
		$passwd = $config['mysql']["password"];
		$database = $config['mysql']["dbname"];
		$this->mysqli = mysqli_connect($hostname, $username, $passwd, $database);
		if (mysqli_connect_errno()) {
			exit("connect mysql failed!");
		}
		$this->mysqli->set_charset("utf8");
	}

	public function query($sql)
	{
		$tmp_queryresult = $this->mysqli->query($sql);
		if (!$tmp_queryresult) {
			log_error("query " . $sql . " failed");
			exit("query " . $sql . " failed");
		}

		$tmp_allresult = array();
		while ($row = $tmp_queryresult->fetch_assoc()) {
			array_push($tmp_allresult, $row);
		}
		return $tmp_allresult;
	}

	public function query_once($sql)
	{
		$result = $this->query($sql);
		if (count($result) <= 0) {
			return null;
		}
		return $result[0];
	}

	public function update($sql)
	{
		$this->mysqli->query($sql);
	}
}
?>
