<!DOCTYPE HTML>
<html>
<head>
<?php
	require_once("./mysql_api.php");
	$id=$_GET["id"];
	$step=intval($_GET["step"]);
	
	$sql = "select * from pic_caicai where id=".$id;
	$mysqlapi = new MysqlApi();
	$result = $mysqlapi->query($sql);
	
	$pic_total = intval($result[0]["pic_total"]);
	$column = 0;
	if($pic_total === 9)
	{
		$column = 3;
	}
	else
	{
		$column = 2;
	}
?>
<style>
	body{
		width:940px;
		height:400px;
	}
	div {
		width:<?php echo ceil(920/$column); ?>px;
		height:<?php echo ceil(380/$column); ?>px;
		padding:2px;
		border:solid 1px blue;
		display:inline-block;
		float:left;
	}
	img {
		width:<?php echo ceil(920/$column - 5); ?>px;
		height:<?php echo ceil(380/$column - 5); ?>px;
	}
</style>
</head>
<body>
<?php
	$first_show = split(',',$result[0]["first_show"]);
	for($i = 0; $i < $pic_total; ++$i)
	{
		//从firstshow来填数据
		$show = null;
		$j = 0;
		for($j = 0; $j < count($first_show); $j++)
		{
			if(intval($first_show[$j]) == $i)
			{
				$show = $first_show[$j];
				break;
			}
		}
		if(!is_null($show))
		{
			printf("<div><img src='./res/%s_%s.jpg'/></div>",$result[0]["pic_prefix"],$show);
			continue;
		}
		
		//从propmt中找下是否存在
		for($j = 1; $j <= $step && $j <= intval($result[0]["prompt_total"]); ++$j)
		{
			$p = intval($result[0]["prompt_".$j]);
			if($p == $i)
			{
				$show = $p;
				break;
			}
		}
		if(!is_null($show))
		{
			printf("<div><img src='./res/%s_%s.jpg'/></div>",$result[0]["pic_prefix"],$show);
			continue;
		}
		
		//div
		printf("<div></div>");
	}
?>
<center>
</center>
</body>
</html>
