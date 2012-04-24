--
-- Database: `solarteam_watersheddata`
--
CREATE DATABASE `solarteam_watersheddata` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `solarteam_watersheddata`;

-- --------------------------------------------------------

--
-- Table structure for table `datapoints`
--

CREATE TABLE IF NOT EXISTS `datapoints` (
  `PointID` int(11) NOT NULL,
  `System` varchar(50) NOT NULL,
  `Sensor` varchar(50) NOT NULL,
  `Value` varchar(50) NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`PointID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
