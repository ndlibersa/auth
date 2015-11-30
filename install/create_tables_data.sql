CREATE TABLE `Session` (
  `sessionID` varchar(100) NOT NULL default '',
  `loginID` varchar(50) default NULL,
  `timestamp` timestamp NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`sessionID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `User` (
  `loginID` varchar(50) NOT NULL,
  `password` varchar(250) default NULL,
  `passwordPrefix` varchar(50) default NULL,
  `adminInd` varchar(1) default 'N',
  PRIMARY KEY  USING BTREE (`loginID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
