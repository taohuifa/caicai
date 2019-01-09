-- MySQL dump 10.13  Distrib 5.5.42, for Linux (x86_64)
--
-- Host: localhost    Database: caicai
-- ------------------------------------------------------
-- Server version	5.5.42-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `pic_caicai`
--

DROP TABLE IF EXISTS `pic_caicai`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pic_caicai` (
  `id` int(11) NOT NULL,
  `pic_total` int(11) DEFAULT '0',
  `pic_prefix` varchar(256) DEFAULT '',
  `first_show` varchar(512) NOT NULL DEFAULT '',
  `prompt_total` int(11) DEFAULT '0',
  `prompt_1` varchar(256) DEFAULT '',
  `prompt_2` varchar(256) DEFAULT '',
  `prompt_3` varchar(256) DEFAULT '',
  `prompt_4` varchar(256) DEFAULT '',
  `prompt_5` varchar(256) DEFAULT '',
  `prompt_6` varchar(256) DEFAULT '',
  `answer` varchar(128) DEFAULT '',
  `outspeech` varchar(512) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pic_caicai`
--

LOCK TABLES `pic_caicai` WRITE;
/*!40000 ALTER TABLE `pic_caicai` DISABLE KEYS */;
INSERT INTO `pic_caicai` VALUES (0,9,'bwl','0,2,3,5,7',4,'1','4','6','8','','','霸王龙','猜猜这只恐龙叫什么名字'),(1,9,'ledi','2,5,6,8',5,'1','3','4','7','0','','乐迪','猜猜这个超级飞侠的名称'),(3,4,'change','2',2,'1','0','','','','','嫦娥','猜一个女性神话人物'),(4,9,'lanyangyang','0,1,2,3,5,',4,'6','8','4','7','','','懒羊羊','猜猜这是羊村里面的谁'),(5,4,'china','1',2,'0','2','','','','','中国','猜这是哪个国家'),(6,4,'GrassCarp','1',2,'0','2','','','','','草鱼','猜这是什么鱼'),(8,9,'xionger','0,2,3,5,6',4,'7','8','4','1','','','熊二','猜猜这是谁'),(10,9,'jijiguowang','0,1,2,3,6',4,'5','8','4','7','','','吉吉国王','猜猜这是森林里面的谁');
/*!40000 ALTER TABLE `pic_caicai` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_u_rank`
--

DROP TABLE IF EXISTS `t_u_rank`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_u_rank` (
  `UserId` char(64) NOT NULL COMMENT '用户Id',
  `GameType` int(11) NOT NULL COMMENT '游戏类型',
  `RankType` int(11) NOT NULL COMMENT '排行榜类型',
  `ScoreA` int(11) DEFAULT NULL COMMENT '分数1',
  `ScoreB` int(11) DEFAULT NULL COMMENT '分数2',
  `ScoreC` int(11) DEFAULT NULL COMMENT '分数3',
  `UpdateTime` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`UserId`,`GameType`,`RankType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_u_rank`
--

LOCK TABLES `t_u_rank` WRITE;
/*!40000 ALTER TABLE `t_u_rank` DISABLE KEYS */;
INSERT INTO `t_u_rank` VALUES ('cfcd208495d565ef66e7dff9f98764da',1,0,60,-1,0,1546972228);
/*!40000 ALTER TABLE `t_u_rank` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_u_userdata`
--

DROP TABLE IF EXISTS `t_u_userdata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_u_userdata` (
  `UserId` char(64) NOT NULL COMMENT '账号Id',
  `Data` varchar(1024) DEFAULT NULL COMMENT '数据内容',
  `UpdateTime` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_u_userdata`
--

LOCK TABLES `t_u_userdata` WRITE;
/*!40000 ALTER TABLE `t_u_userdata` DISABLE KEYS */;
INSERT INTO `t_u_userdata` VALUES ('24186d77ff9ed16438cc71b841b4b121','%7B%22rcount%22%3A408%2C%22ctMaxScore%22%3A0%7D',1547048513),('407dd1153c132e09becc05181b4d1790','{\"rcount\":17}',1546888884),('cfcd208495d565ef66e7dff9f98764da','%7B%22rcount%22%3A191%2C%22ctMaxScore%22%3A60%7D',1547048244);
/*!40000 ALTER TABLE `t_u_userdata` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tiezhi_caicai`
--

DROP TABLE IF EXISTS `tiezhi_caicai`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tiezhi_caicai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sessionid` varchar(256) DEFAULT '',
  `ques_id` int(11) DEFAULT '0',
  `ques_type` varchar(56) DEFAULT '',
  `right_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tiezhi_caicai`
--

LOCK TABLES `tiezhi_caicai` WRITE;
/*!40000 ALTER TABLE `tiezhi_caicai` DISABLE KEYS */;
/*!40000 ALTER TABLE `tiezhi_caicai` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `video_caicai`
--

DROP TABLE IF EXISTS `video_caicai`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `video_caicai` (
  `id` int(11) NOT NULL,
  `content` varchar(512) NOT NULL,
  `video_total` int(11) DEFAULT '0',
  `video_1` varchar(256) DEFAULT '',
  `video_2` varchar(256) DEFAULT '',
  `video_3` varchar(256) DEFAULT '',
  `video_4` varchar(256) DEFAULT '',
  `video_5` varchar(256) DEFAULT '',
  `video_6` varchar(256) DEFAULT '',
  `answer` varchar(128) DEFAULT '',
  `outspeech` varchar(512) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `video_caicai`
--

LOCK TABLES `video_caicai` WRITE;
/*!40000 ALTER TABLE `video_caicai` DISABLE KEYS */;
INSERT INTO `video_caicai` VALUES (6,'猜一猜这是什么乐器',3,'video8.gif','video8_tips1.png','video8_tips8.png','','','','架子鼓','猜一猜这是什么乐器'),(8,'猜一猜这是什么运动',3,'video4.gif','video4_tips1.png','video4_tips4.png','','','','踢足球','猜一猜这是什么运动'),(5,'猜一猜这是什么动物',3,'video2.gif','video2_tips1.png','video2_tips2.png','','','','企鹅','猜一猜这是什么动物'),(1,'猜一猜这是什么动物',3,'video1.gif','video1_tips2.png','video1_tips1.png','','','','斑马','猜一猜这是什么动物'),(9,'猜一猜这里有几只动物',3,'video7.gif','video7_tips1.png','video7_tips2.png','','','','6只','猜一猜这里有几只动物'),(10,'猜一猜这里有几种动物',3,'video6.gif','video6_tips1.png','video6_tips2.png','','','','3种','猜一猜这里有几种动物'),(11,'猜一猜这是什么',3,'video5.gif','video5_tips1.png','video5_tips5.png','','','','飞机','猜一猜这是什么'),(12,'猜一猜这是什么车',3,'video9.gif','video9_tips1.png','video9_tips9.png','','','','自行车','猜一猜这是什么车');
/*!40000 ALTER TABLE `video_caicai` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `word_caicai`
--

DROP TABLE IF EXISTS `word_caicai`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `word_caicai` (
  `id` int(11) NOT NULL,
  `content` varchar(512) NOT NULL,
  `prompt_total` int(11) DEFAULT '0',
  `prompt_1` varchar(256) DEFAULT '',
  `prompt_2` varchar(256) DEFAULT '',
  `prompt_3` varchar(256) DEFAULT '',
  `prompt_4` varchar(256) DEFAULT '',
  `prompt_5` varchar(256) DEFAULT '',
  `prompt_6` varchar(256) DEFAULT '',
  `answer` varchar(128) DEFAULT '',
  `outspeech` varchar(512) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `word_caicai`
--

LOCK TABLES `word_caicai` WRITE;
/*!40000 ALTER TABLE `word_caicai` DISABLE KEYS */;
INSERT INTO `word_caicai` VALUES (1004,'弟兄七八个，围着柱子坐，只要一分开，衣服就扯破',3,'是一种厨房的配料','剥了皮是一掰一掰的','生吃会很辣','','','','大蒜','弟兄七八个，围着柱子坐，只要一分开，衣服就扯破'),(1002,'披黄衣，不用剥，酸眯眼， 泡泡水 ，猜一水果',2,'有青的，也有黄的哟','很酸很酸的水果哟','','','','','柠檬','披黄衣，不用剥，酸眯眼， 泡泡水 ，猜一水果'),(1003,'四四方方像块糖，写错字儿用它擦',2,'是学习用品哟','可以擦掉铅笔字','','','','','橡皮擦','四四方方像块糖，写错字儿用它擦'),(1005,'山上不长树， 河里鱼不游，地方不太大，五湖四海装得下',1,'它是一张纸 或者 一个球 ','','','','','','地图','山上不长树， 河里鱼不游，地方不太大，五湖四海装得下 '),(1006,'五个兄弟，住在一起，名字不同，高矮不齐',3,'每天起床后就可以看到它','吃饭要用它，写作业也要靠它','是你身体的一部分','','','','手指','五个兄弟，住在一起，名字不同，高矮不齐'),(1007,'屋子方方，有门没窗，屋外热烘，里面冰霜',3,'一般放在厨房','里面可以放水果，也可以放菜','夏天靠它吃冰棍','','','','冰箱','屋子方方，有门没窗，屋外热烘，里面冰霜'),(1008,'一个小姑娘，生在水中央，身穿粉红衫，坐在绿船上',3,'夏天才可以在水中看到哟','它的根可以吃','它是印度和越南的国花','','','','荷花','一个小姑娘，生在水中央，身穿粉红衫，坐在绿船上');
/*!40000 ALTER TABLE `word_caicai` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-01-09 23:41:57
