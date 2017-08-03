REATE DATABASE IF NOT EXISTS `DieLibrary`;

USE `DieLibrary`;

--
-- Table structure for table `dies`
--

DROP TABLE IF EXISTS `dies`;
CREATE TABLE `dies` (
  `dieID` int(11) NOT NULL AUTO_INCREMENT,
  `datePurchased` date NOT NULL,
  `tags` text,
  `flatWidth` float DEFAULT NULL,
  `flatHeight` float DEFAULT NULL,
  `finishedWidth` float DEFAULT NULL,
  `finishedHeight` float DEFAULT NULL,
  `numPockets` int(11) DEFAULT NULL,
  `pocketSize` float DEFAULT NULL,
  `machine` enum('Sanwa','Heidelberg','Kluge') DEFAULT NULL,
  `location` enum('Green Inventory','Sanwa','Heidelberg','Kluge','Awaiting Arrival','Trashed') DEFAULT 'Awaiting Arrival',
  `expectedUsage` enum('One time use','More than once','Regular','Unknown') DEFAULT 'Unknown',
  `numberUp` int(11) DEFAULT NULL,
  `dieReviewed` enum('false','true') DEFAULT 'false',
  `description` text,
  `dateModified` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`dieID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `entryID` int(11) NOT NULL AUTO_INCREMENT,
  `jobNumber` int(11) NOT NULL,
  `dieID` int(11) NOT NULL,
  `customerName` varchar(50) DEFAULT NULL,
  `newDie` enum('no','yes') DEFAULT 'no',
  `jobDate` date NOT NULL,
  PRIMARY KEY (`entryID`),
  KEY `dieID` (`dieID`),
  CONSTRAINT `jobs_ibfk_1` FOREIGN KEY (`dieID`) REFERENCES `dies` (`dieID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;