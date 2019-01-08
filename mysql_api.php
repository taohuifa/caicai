<?php

require_once "Config.php";

class MysqlApi
{
	private $mysqli;
	public function __construct()
	{
		$hostname = $config['mysql']["host"];
		$port = 3306;
		$username = $config['mysql']["user"];
		$passwd = $config['mysql']["password"];
		$database = $config['mysql']["dbname"];
		$this->mysqli = mysqli_connect($hostname,$username,$passwd,$database);
		if (mysqli_connect_errno())
		{
			exit("connect mysql failed!");
		}
		$this->mysqli->set_charset("utf8");
	}
	
	public function query($sql)
	{
		$tmp_queryresult=$this->mysqli->query($sql);
		if(!$tmp_queryresult)
		{
			exit("query ".$sql." failed");
		}
		
		$tmp_allresult=array();
		while($row=$tmp_queryresult->fetch_assoc())
		{
			array_push($tmp_allresult,$row);
		}
		return $tmp_allresult;
	}
	
	public function update($sql)
	{
		$this->mysqli->query($sql);
	}
}
?>
