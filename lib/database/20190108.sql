/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50615
Source Host           : localhost:3306
Source Database       : caicai

Target Server Type    : MYSQL
Target Server Version : 50615
File Encoding         : 65001

Date: 2019-01-08 02:45:05
*/

SET FOREIGN_KEY_CHECKS=0;

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
