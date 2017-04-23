/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50717
Source Host           : localhost:3306
Source Database       : tool_system

Target Server Type    : MYSQL
Target Server Version : 50717
File Encoding         : 65001

Date: 2017-04-16 15:24:59
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `tl_borrow_return`
-- ----------------------------
DROP TABLE IF EXISTS `tl_borrow_return`;
CREATE TABLE `tl_borrow_return` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `u_name` varchar(11) DEFAULT NULL,
  `u_jn` int(11) DEFAULT NULL,
  `borrow_barcode` varchar(50) DEFAULT NULL,
  `borrow_date` int(20) DEFAULT '0',
  `is_return` int(1) DEFAULT '0' COMMENT '全部还完状态为1',
  `borrow_no` varchar(255) NOT NULL,
  `tl_return_barcode` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=175 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of tl_borrow_return
-- ----------------------------
INSERT INTO `tl_borrow_return` VALUES ('173', 'wyyd', '90245', '9505901', '1492323395', '0', '20170416141635902452', null);
INSERT INTO `tl_borrow_return` VALUES ('174', 'wyyd', '90246', '9505902', '1492323476', '0', '20170416141756902462', null);

-- ----------------------------
-- Table structure for `tl_b_return_info`
-- ----------------------------
DROP TABLE IF EXISTS `tl_b_return_info`;
CREATE TABLE `tl_b_return_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `u_name` varchar(11) NOT NULL,
  `borrow_admin` varchar(11) NOT NULL,
  `u_jn` int(11) NOT NULL,
  `borrow_barcode` varchar(50) NOT NULL,
  `borrow_no` varchar(20) NOT NULL,
  `borrow_date` int(20) NOT NULL,
  `is_return` varchar(1) NOT NULL,
  `return_ujn` varchar(11) DEFAULT NULL,
  `return_admin` int(11) DEFAULT NULL,
  `return_date` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=247 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tl_b_return_info
-- ----------------------------
INSERT INTO `tl_b_return_info` VALUES ('245', 'wyyd', '刘某', '90245', '9505901', '20170416141635902452', '1492323395', '0', null, null, null);
INSERT INTO `tl_b_return_info` VALUES ('246', 'wyyd', '刘某', '90246', '9505902', '20170416141756902462', '1492323476', '0', null, null, null);

-- ----------------------------
-- Table structure for `tl_tool`
-- ----------------------------
DROP TABLE IF EXISTS `tl_tool`;
CREATE TABLE `tl_tool` (
  `tl_id` int(11) NOT NULL AUTO_INCREMENT,
  `tl_name` varchar(20) NOT NULL,
  `tl_barcode` int(11) NOT NULL,
  `tl_pn` varchar(20) NOT NULL,
  `tl_position` varchar(20) NOT NULL,
  `tl_type` varchar(20) DEFAULT NULL,
  `tl_standard` varchar(20) DEFAULT NULL,
  `tl_status` varchar(10) NOT NULL,
  PRIMARY KEY (`tl_id`),
  KEY `tl_barcode` (`tl_barcode`),
  KEY `tl_pn` (`tl_pn`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tl_tool
-- ----------------------------
INSERT INTO `tl_tool` VALUES ('1', '耳机包', '9505900', '14', '现场', '消耗件', '耳机，销子', '1');
INSERT INTO `tl_tool` VALUES ('2', '板干', '9505901', 'G27-02-13', '02015', '常用', '单件', '1');
INSERT INTO `tl_tool` VALUES ('3', '耳机包', '9505902', '13', '现场', '消耗件', '耳机，销子', '1');

-- ----------------------------
-- Table structure for `tl_user`
-- ----------------------------
DROP TABLE IF EXISTS `tl_user`;
CREATE TABLE `tl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `u_name` varchar(20) DEFAULT NULL,
  `u_jn` int(11) NOT NULL COMMENT '工号',
  `u_role` varchar(20) NOT NULL COMMENT '1为超级管理员，2为部门经理，3为生产管理员，4为航线经理|班组长，5为普通员工',
  `u_tel` int(11) DEFAULT NULL COMMENT '电话',
  `u_department` varchar(20) DEFAULT NULL COMMENT '部门',
  `u_status` int(1) DEFAULT NULL COMMENT '用户状态，0离职，1在职',
  PRIMARY KEY (`id`),
  KEY `u_jn` (`u_jn`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tl_user
-- ----------------------------
INSERT INTO `tl_user` VALUES ('1', '张某', '90245', '5', null, '航线', '1');
INSERT INTO `tl_user` VALUES ('2', '王某', '90246', '5', null, '航线', '1');
