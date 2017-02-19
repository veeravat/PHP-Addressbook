SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for contact
-- ----------------------------
DROP TABLE IF EXISTS `contact`;
CREATE TABLE `addr_contact` (
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
CREATE TABLE `addr_phone` (
  `PID` int(5) NOT NULL,
  `CID` int(4) DEFAULT NULL,
  `tel_number` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`PID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
