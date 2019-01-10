<!DOCTYPE HTML>
<html>
<head>
<?php header("Content-Type: text/html;charset=utf-8"); ?>
<style>
	body{
		width:1280px;
		height:800px;
		background-color:#dede84;
		font-size:20px;
	}
	.word_div {
		text-align:left;
		width:80%;
		padding-top:10%;
	}
	.word_prompt {
		color:#3e1f2d;
		font-size:25px;
	}
	.div_head {
		margin-bottom: 5px;
		background-color: #08879a;
		padding: 5px;
		text-align: center;
		color: yellow;
		font-weight: bold;
		width: 100%;
	}
</style>
</head>
<body>
<?php
	require_once("./mysql_api.php");
	$id=$_GET["id"];
	$step=intval($_GET["step"]);
	
	$mysqlapi = new MysqlApi();
	
	$tiezhi_count = 0;
	$tiezhi_sql = sprintf("select count(*) as total from tiezhi_caicai where sessionid='%s'",$_GET["sessionid"]);
	$result = $mysqlapi->query($tiezhi_sql);
	if(isset($result))
	{
		$tiezhi_count = $result[0]["total"];
	}
	
	$sql = "select * from word_caicai where id=".$id;
	$result = $mysqlapi->query($sql);
	//var_dump($result);
?>
<div class="div_head">
<span>总贴纸：<?php echo $tiezhi_count; ?></span>
</div>
<center>
<div class="word_div">
<h2 style="font-size:30px;"><?php echo $result[0]["content"]; ?></h2>
<span class="word_prompt" style="font-weight:bold;padding-top:25px">提示（<?php printf("%d/%d",$step,$result[0]["prompt_total"]); ?>）：</span>
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
