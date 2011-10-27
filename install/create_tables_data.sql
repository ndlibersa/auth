



CREATE TABLE `_DATABASE_NAME_`.`Session` (
  `sessionID` varchar(100) NOT NULL default '',
  `loginID` varchar(50) default NULL,
  `timestamp` timestamp NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`sessionID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;




CREATE TABLE `_DATABASE_NAME_`.`User` (
  `loginID` varchar(50) NOT NULL,
  `password` varchar(250) default NULL,
  `passwordPrefix` varchar(50) default NULL,
  `adminInd` varchar(1) default 'N',
  PRIMARY KEY  USING BTREE (`loginID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;




INSERT INTO `_DATABASE_NAME_`.`User` VALUES ('coral','1a5f55d06a3d1fcb709d6fcc7266bb49f668bc65a4117470cdca9d0162bc4e5294d1fa79bf4097ba54810a1902baf7fa5c0d506537f1fdba88bf27acc64d9275', 'E9RIQzB7N30p3ynJwMsih3FIE6jUGq2KpJT58U3MOu1Hi', '1');
