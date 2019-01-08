<!DOCTYPE HTML>
<html>
<head>
<style>
	body{
		width:940px;
		height:400px;
		background-color:#dede84;
		font-size:15px;
	}
	.word_div {
		text-align:left;
		width:80%;
		padding-top:10%;
	}
	.word_prompt {
		color:#3e1f2d;
		font-size:20px;
	}
</style>
</head>
<body>
<?php
	require_once("./mysql_api.php");
	$id=$_GET["id"];
	$step=intval($_GET["step"]);
	
	$sql = "select * from word_caicai where id=".$id;
	$mysqlapi = new MysqlApi();
	$result = $mysqlapi->query($sql);
	//var_dump($result);
?>
<center>
<div class="word_div">
<h2><?php echo $result[0]["content"]; ?></h2>
<span class="word_prompt" style="font-weight:bold;padding-top:20px">提示（<?php printf("%d/%d",$step,$result[0]["prompt_total"]); ?>）：</span>
<ul>
<?php 
	$i = 1;
	while($i <= $step)
	{
		printf("<li class='word_prompt'>%s</li>",$result[0]["prompt_".$i]);
		$i++;
	}
?>
</ul>
</div>
</center>
</body>
</html>
