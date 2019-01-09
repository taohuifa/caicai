/*
Navicat MySQL Data Transfer

Source Server         : 119.29.135.151
Source Server Version : 50542
Source Host           : localhost:3306
Source Database       : caicai

Target Server Type    : MYSQL
Target Server Version : 50542
File Encoding         : 65001

Date: 2019-01-09 23:34:14
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for pic_caicai
-- ----------------------------
DROP TABLE IF EXISTS `pic_caicai`;
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

-- ----------------------------
-- Table structure for t_u_rank
-- ----------------------------
DROP TABLE IF EXISTS `t_u_rank`;
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

-- ----------------------------
-- Table structure for t_u_userdata
-- ----------------------------
DROP TABLE IF EXISTS `t_u_userdata`;
CREATE TABLE `t_u_userdata` (
  `UserId` char(64) NOT NULL COMMENT '账号Id',
  `Data` varchar(1024) DEFAULT NULL COMMENT '数据内容',
  `UpdateTime` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for tiezhi_caicai
-- ----------------------------
DROP TABLE IF EXISTS `tiezhi_caicai`;
CREATE TABLE `tiezhi_caicai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sessionid` varchar(256) DEFAULT '',
  `ques_id` int(11) DEFAULT '0',
  `ques_type` varchar(56) DEFAULT '',
  `right_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for video_caicai
-- ----------------------------
DROP TABLE IF EXISTS `video_caicai`;
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

-- ----------------------------
-- Table structure for word_caicai
-- ----------------------------
DROP TABLE IF EXISTS `word_caicai`;
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
