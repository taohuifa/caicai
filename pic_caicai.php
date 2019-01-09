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
		padding-top:10px;
		padding-left:30px;
	}
	.div_img {
		width:<?php echo ceil(850/$column); ?>px;
		height:<?php echo ceil(430/$column); ?>px;
		padding:2px;
		border:solid 1px blue;
		display:inline-block;
		float:left;
	}
	img {
		width:<?php echo ceil(850/$column - 5); ?>px;
		height:<?php echo ceil(430/$column - 5); ?>px;
	}
	span {
		margin-right:50px;
	}
	.div_head {
		margin-bottom: 5px;
		background-color: #08879a;
		padding: 5px;
		text-align: center;
		color: white;
		font-weight: bold;
		width: 862px;
	}
</style>
</head>
<body>
<div class="div_head">
<span>总贴纸：10</span>
<span>本次已获得：1</span>
</div>
<center style>
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
			printf("<div class='div_img'><img src='./res/%s_%s.jpg'/></div>",$result[0]["pic_prefix"],$show);
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
			printf("<div class='div_img'><img src='./res/%s_%s.jpg'/></div>",$result[0]["pic_prefix"],$show);
			continue;
		}
		
		//div
		printf("<div></div>");
	}
?>
</center>
</body>
</html>
