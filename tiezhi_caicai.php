<!DOCTYPE HTML>
<html>
<head>
<style>
	body{
		width:940px;
		height:400px;
		background-color:#fffdde;
		font-size:15px;
	}
	table,table tr th, table tr td { border:1px solid #0094ff;border-collapse: collapse;}
</style>
</head>
<body>
<?php
	require_once("./mysql_api.php");
	$sessionid=$_GET["sessionid"];
	$step=intval($_GET["step"]);
	
	$sql = sprintf("select ques_type from tiezhi_caicai where sessionid='%s' limit %d,%d",$sessionid,$step,$step+50);
	$mysqlapi = new MysqlApi();
	$result = $mysqlapi->query($sql);
?>
<center>
<table>
<?php 
	$i = 0;
	$iNext = 0;
	$total =count($result); 
	$total = 50;
	while($i <= $total)
	{
		if($i % 5 == 0)
		{
			printf("<tr>");
			$iNext = $i + 5;
		}
		printf("<td><img src='./res/tiezhi_%d.png' /></td>",rand(1,7));
		$i++;
		if($i == $iNext)
		{
			printf("</tr>");
		}
	}
?>

</table>
	

</center>
</body>
</html>