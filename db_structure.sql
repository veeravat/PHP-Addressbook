/*
Navicat MySQL Data Transfer

Source Server         : Azure
Source Server Version : 50545
Source Host           : ap-cdbr-azure-southeast-b.cloudapp.net:3306
Source Database       : acsm_e92fbc56b87b79e

Target Server Type    : MYSQL
Target Server Version : 50545
File Encoding         : 65001

Date: 2016-11-22 01:12:29
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for contact
-- ----------------------------
DROP TABLE IF EXISTS `contact`;
CREATE TABLE `contact` (
  `CID` int(4) NOT NULL,
  `fname` varchar(40) DEFAULT NULL,
  `lname` varchar(40) DEFAULT NULL,
  `organization` varchar(40) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `note` text,
  `sex` varchar(7) DEFAULT NULL,
  PRIMARY KEY (`CID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for phone
-- ----------------------------
DROP TABLE IF EXISTS `phone`;
CREATE TABLE `phone` (
  `PID` int(5) NOT NULL,
  `CID` int(4) DEFAULT NULL,
  `tel_number` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`PID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
