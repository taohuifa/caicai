/*
Navicat MySQL Data Transfer

Source Server         : 119.29.135.151
Source Server Version : 50542
Source Host           : localhost:3306
Source Database       : caicai

Target Server Type    : MYSQL
Target Server Version : 50542
File Encoding         : 65001

Date: 2019-01-09 23:34:25
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
-- Records of pic_caicai
-- ----------------------------
INSERT INTO `pic_caicai` VALUES ('3001', '9', 'bwl', '0,2,3,5,7', '4', '1', '4', '6', '8', '', '', '霸王龙', '猜猜这只恐龙叫什么名字');
INSERT INTO `pic_caicai` VALUES ('3002', '9', 'ledi', '2,5,6,8', '5', '1', '3', '4', '7', '0', '', '乐迪', '猜猜这个超级飞侠的名称');
INSERT INTO `pic_caicai` VALUES ('3003', '4', 'change', '2', '2', '1', '0', '', '', '', '', '嫦娥', '猜一个女性神话人物');
INSERT INTO `pic_caicai` VALUES ('3004', '9', 'lanyangyang', '0,1,2,3,5,', '4', '6', '8', '4', '7', '', '', '懒羊羊', '猜猜这是羊村里面的谁');
INSERT INTO `pic_caicai` VALUES ('3005', '4', 'china', '1', '2', '0', '2', '', '', '', '', '中国', '猜这是哪个国家');
INSERT INTO `pic_caicai` VALUES ('3006', '4', 'GrassCarp', '1', '2', '0', '2', '', '', '', '', '草鱼', '猜这是什么鱼');
INSERT INTO `pic_caicai` VALUES ('3007', '9', 'xionger', '0,2,3,5,6', '4', '7', '8', '4', '1', '', '', '熊二', '猜猜这是谁');
INSERT INTO `pic_caicai` VALUES ('3008', '9', 'jijiguowang', '0,1,2,3,6', '4', '5', '8', '4', '7', '', '', '吉吉国王', '猜猜这是森林里面的谁');

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
-- Records of t_u_rank
-- ----------------------------
INSERT INTO `t_u_rank` VALUES ('cfcd208495d565ef66e7dff9f98764da', '1', '0', '60', '-1', '0', '1546972228');

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
-- Records of t_u_userdata
-- ----------------------------
INSERT INTO `t_u_userdata` VALUES ('24186d77ff9ed16438cc71b841b4b121', '%7B%22rcount%22%3A391%2C%22ctMaxScore%22%3A0%7D', '1547046849');
INSERT INTO `t_u_userdata` VALUES ('407dd1153c132e09becc05181b4d1790', '{\"rcount\":17}', '1546888884');
INSERT INTO `t_u_userdata` VALUES ('cfcd208495d565ef66e7dff9f98764da', '%7B%22rcount%22%3A187%2C%22ctMaxScore%22%3A60%7D', '1547047087');

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
-- Records of tiezhi_caicai
-- ----------------------------

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
-- Records of video_caicai
-- ----------------------------
INSERT INTO `video_caicai` VALUES ('2001', '猜一猜这是什么动物', '3', 'video1.gif', 'video1_tips2.png', 'video1_tips1.png', '', '', '', '斑马', '猜一猜这是什么动物');

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

-- ----------------------------
-- Records of word_caicai
-- ----------------------------
INSERT INTO `word_caicai` VALUES ('1004', '弟兄七八个，围着柱子坐，只要一分开，衣服就扯破', '3', '是一种厨房的配料', '剥了皮是一掰一掰的', '生吃会很辣', '', '', '', '大蒜', '弟兄七八个，围着柱子坐，只要一分开，衣服就扯破');
INSERT INTO `word_caicai` VALUES ('1002', '披黄衣，不用剥，酸眯眼， 泡泡水 ，猜一水果', '2', '有青的，也有黄的哟', '很酸很酸的水果哟', '', '', '', '', '柠檬', '披黄衣，不用剥，酸眯眼， 泡泡水 ，猜一水果');
INSERT INTO `word_caicai` VALUES ('1003', '四四方方像块糖，写错字儿用它擦', '2', '是学习用品哟', '可以擦掉铅笔字', '', '', '', '', '橡皮擦', '四四方方像块糖，写错字儿用它擦');
INSERT INTO `word_caicai` VALUES ('1005', '山上不长树， 河里鱼不游，地方不太大，五湖四海装得下', '1', '它是一张纸 或者 一个球 ', '', '', '', '', '', '地图', '山上不长树， 河里鱼不游，地方不太大，五湖四海装得下 ');
INSERT INTO `word_caicai` VALUES ('1006', '五个兄弟，住在一起，名字不同，高矮不齐', '3', '每天起床后就可以看到它', '吃饭要用它，写作业也要靠它', '是你身体的一部分', '', '', '', '手指', '五个兄弟，住在一起，名字不同，高矮不齐');
INSERT INTO `word_caicai` VALUES ('1007', '屋子方方，有门没窗，屋外热烘，里面冰霜', '3', '一般放在厨房', '里面可以放水果，也可以放菜', '夏天靠它吃冰棍', '', '', '', '冰箱', '屋子方方，有门没窗，屋外热烘，里面冰霜');
INSERT INTO `word_caicai` VALUES ('1008', '一个小姑娘，生在水中央，身穿粉红衫，坐在绿船上', '3', '夏天才可以在水中看到哟', '它的根可以吃', '它是印度和越南的国花', '', '', '', '荷花', '一个小姑娘，生在水中央，身穿粉红衫，坐在绿船上');
