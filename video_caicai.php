<!DOCTYPE HTML>
<html>
<head>
<style>
	body{
		width:940px;
		height:500px;
		background-color:#dede84;
		font-size:15px;
	}
	.word_div {
		text-align:left;
		width:80%;
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
	
	$sql = "select * from video_caicai where id=".$id;
	$mysqlapi = new MysqlApi();
	$result = $mysqlapi->query($sql);
?>
<center>
<div class="word_div">
<h2><?php echo $result[0]["content"]; ?></h2>

<?php 
	$i = $step+1;
	while($i >0)
	{
        printf("<span class='word_prompt' style='font-weight:bold;padding-top:20px'>提示（%d/%d）</span>",$i,$result[0]["video_total"]+1);
		printf("<img height='448' width='800' src='https://blog.chiyl.info/caicai/res/%s' /><br>",$result[0]["video_".$i]);
		$i--;
	}
?>

</div>
</center>
</body>
</html>
