-- MySQL dump 10.13  Distrib 5.6.42, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: caicai
-- ------------------------------------------------------
-- Server version	5.6.42

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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `word_caicai`
--

LOCK TABLES `word_caicai` WRITE;
/*!40000 ALTER TABLE `word_caicai` DISABLE KEYS */;
INSERT INTO `word_caicai` VALUES (1,'I am a test',0,'','','','','',''),(2,'某地劳动部门租用甲、乙两个教室开展农村实用人才培训。两教室均有5 排座位，甲教室每排可坐10人，乙教室每排可坐9人。',2,'本身 转换为数字变量 ：','医学我的剑，编程我的酒。 仗剑走天涯，偶尔喝喝酒','','','','');
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

-- Dump completed on 2019-01-08 11:21:44
