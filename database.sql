-- MySQL dump 10.13  Distrib 5.7.9, for Win32 (AMD64)
--
-- Host: localhost    Database: popcom2018ticketingdb
-- ------------------------------------------------------
-- Server version	5.7.23-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tblemployee`
--

DROP TABLE IF EXISTS `tblemployee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblemployee` (
  `EmployeeID` int(11) NOT NULL AUTO_INCREMENT,
  `DlastName` varchar(50) NOT NULL,
  `DfirstName` varchar(50) NOT NULL,
  `DmiddleName` varchar(50) NOT NULL,
  `Dbirthday` date NOT NULL,
  `Daddress` varchar(200) NOT NULL,
  `Dgender` varchar(10) NOT NULL,
  `Designation` varchar(30) NOT NULL,
  `emp_stamp` date NOT NULL,
  PRIMARY KEY (`EmployeeID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblemployee`
--

LOCK TABLES `tblemployee` WRITE;
/*!40000 ALTER TABLE `tblemployee` DISABLE KEYS */;
INSERT INTO `tblemployee` VALUES (1,'Cruz','Reynaldo','M','2018-05-10','Mandaluyong City','Male','0','2018-05-01'),(2,'Sarmiento','Elpidio','B','2018-02-22','Mandaluyong City','Male','0','2018-05-02'),(3,'Sura ','Kenjay','S','2018-05-16','Hulo, Mandaluyong City','Male','1','2018-05-03'),(5,'Borleo','Cesar','L','2018-05-16','Pasig City','Male','0','2018-05-05'),(6,'Butil','Anastacion,Jr','D','2018-05-11','Fairview City','Male','0','2018-05-07'),(7,'Ababa','Ramir','C','2018-05-08','Mandaluyong City','Male','0','2018-05-08'),(8,'Natividad','Cloyd','B','2018-05-20','Manila','Male','0','2018-05-06'),(9,'Arcilla,Jr','Angelito','T','2018-01-02','Malate, Manila','Male','0','2018-05-08'),(10,'Vicente','Baptista','L','2018-03-22','Quezon City','Male','0','2018-05-08');
/*!40000 ALTER TABLE `tblemployee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblmainmodule`
--

DROP TABLE IF EXISTS `tblmainmodule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblmainmodule` (
  `mID` int(11) NOT NULL AUTO_INCREMENT,
  `ModuleCode` varchar(20) NOT NULL,
  `ModuleName` varchar(20) NOT NULL,
  `imgFile` varchar(150) NOT NULL,
  `stamp` datetime NOT NULL,
  PRIMARY KEY (`mID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblmainmodule`
--

LOCK TABLES `tblmainmodule` WRITE;
/*!40000 ALTER TABLE `tblmainmodule` DISABLE KEYS */;
INSERT INTO `tblmainmodule` VALUES (1,'Schedule','Schedule','none','2018-04-09 00:00:00'),(2,'Driver','Driver','none','2018-04-09 00:00:00'),(3,'Vehicle','Vehicle','none','2018-04-09 00:00:00'),(4,'Report','Report','none','2018-04-09 00:00:00'),(5,'Dashboard','Dashboard','none','2018-05-07 00:00:00');
/*!40000 ALTER TABLE `tblmainmodule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblmainmoduleaccess`
--

DROP TABLE IF EXISTS `tblmainmoduleaccess`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblmainmoduleaccess` (
  `uid` int(11) NOT NULL,
  `uname` varchar(50) NOT NULL,
  `ModuleCode` varchar(20) NOT NULL,
  `page` varchar(20) NOT NULL,
  `icon` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblmainmoduleaccess`
--

LOCK TABLES `tblmainmoduleaccess` WRITE;
/*!40000 ALTER TABLE `tblmainmoduleaccess` DISABLE KEYS */;
INSERT INTO `tblmainmoduleaccess` VALUES (2,'admin','Ticket','main.php','');
/*!40000 ALTER TABLE `tblmainmoduleaccess` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblserved`
--

DROP TABLE IF EXISTS `tblserved`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblserved` (
  `serveID` int(11) NOT NULL AUTO_INCREMENT,
  `Tid` int(11) NOT NULL,
  `ticketNo` varchar(50) NOT NULL,
  `EmployeeID` int(11) NOT NULL,
  `vehicleID` int(11) NOT NULL,
  `Status` varchar(20) NOT NULL,
  `ustamp` date NOT NULL,
  PRIMARY KEY (`serveID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblserved`
--

LOCK TABLES `tblserved` WRITE;
/*!40000 ALTER TABLE `tblserved` DISABLE KEYS */;
INSERT INTO `tblserved` VALUES (1,1,'2018-O6G0',1,2,'Posted','2018-05-07'),(2,2,'2018-KPHB',2,5,'Posted','2018-05-07'),(3,3,'2018-B4JE',1,1,'Posted','2018-05-07'),(4,4,'2018-KG3O',4,2,'Posted','2018-05-07'),(5,7,'2018-QF5H',6,5,'Posted','2018-05-07'),(6,14,'2018-9QJI',1,1,'Posted','2018-05-10'),(7,12,'2018-ZXTK',10,3,'Posted','2018-05-10'),(8,13,'2018-ZXTK',10,3,'Posted','2018-05-10');
/*!40000 ALTER TABLE `tblserved` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblsubmodule`
--

DROP TABLE IF EXISTS `tblsubmodule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblsubmodule` (
  `uid` int(11) NOT NULL,
  `ModuleCode` varchar(20) NOT NULL,
  `SubModuleCode` varchar(20) NOT NULL,
  `SubModuleName` varchar(20) NOT NULL,
  `SubModulePage` varchar(50) NOT NULL,
  `imgFile` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblsubmodule`
--

LOCK TABLES `tblsubmodule` WRITE;
/*!40000 ALTER TABLE `tblsubmodule` DISABLE KEYS */;
INSERT INTO `tblsubmodule` VALUES (2,'Ticket','AddTicket','Add Ticket','addticket.php','wa');
/*!40000 ALTER TABLE `tblsubmodule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblsubmoduleaccess`
--

DROP TABLE IF EXISTS `tblsubmoduleaccess`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblsubmoduleaccess` (
  `uid` int(11) NOT NULL,
  `uname` varchar(50) NOT NULL,
  `ModuleCode` varchar(20) NOT NULL,
  `SubModuleCode` varchar(50) NOT NULL,
  `SubModulePage` varchar(50) NOT NULL,
  `s_icon` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblsubmoduleaccess`
--

LOCK TABLES `tblsubmoduleaccess` WRITE;
/*!40000 ALTER TABLE `tblsubmoduleaccess` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblsubmoduleaccess` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblticket`
--

DROP TABLE IF EXISTS `tblticket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblticket` (
  `Tid` int(11) NOT NULL AUTO_INCREMENT,
  `ticketNo` varchar(50) NOT NULL,
  `upassenger` varchar(100) NOT NULL,
  `divisioN` varchar(50) NOT NULL,
  `udestination` varchar(150) NOT NULL,
  `udate` date NOT NULL,
  `utime` varchar(20) NOT NULL,
  `EmployeeID` int(11) NOT NULL,
  `vehicleID` int(11) NOT NULL,
  `Status` varchar(20) NOT NULL,
  `Remarks` varchar(40) NOT NULL,
  `Purpose` text NOT NULL,
  `Approvedby` varchar(50) NOT NULL,
  `ustamp` date NOT NULL,
  PRIMARY KEY (`Tid`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblticket`
--

LOCK TABLES `tblticket` WRITE;
/*!40000 ALTER TABLE `tblticket` DISABLE KEYS */;
INSERT INTO `tblticket` VALUES (1,'2018-O6G0','JAMES ANTOR','ORS','Pasit City','2018-05-07','07:00',1,2,'Posted','Conduction To and From','Audie','ROGELIO MALVECINO','2018-05-07'),(2,'2018-KPHB','PATRICK SALVADOR','Marketing','Batangas City','2018-05-09','09:00',2,5,'Posted','Conduction To and From','Sales','ROGELIO MALVECINO','2018-05-07'),(3,'2018-B4JE','RAMON LOPEZ','IT','Makati City','2018-05-17','09:00',1,1,'Posted','Conduction Only','Seminar','Rogelio malvecino','2018-05-07'),(4,'2018-KG3O','A','ewan','pasig','2018-05-08','09:00',4,2,'Posted','Conduction To and From','data gathering','ADMINISTRATIVE ','2018-05-07'),(6,'2018-1J3P','ROBERT BARRIOS','Marketing','Makati City','2018-05-07','08:00',5,3,'Cancelled','Conduction To and From','sales','ROGELIO MALVECINO','2018-05-07'),(7,'2018-QF5H','REMARK PAJAR','ORS','Quezon City','2018-05-07','09:00',6,5,'Posted','Conduction To and From','Audit','ROGELIO MALVECINO','2018-05-07'),(8,'2018-VPFW','RICKY SOTTO','Accounting','Pasig City','2018-05-08','07:00',9,6,'Pending','Conduction To and From','Inventory','ADMIN','2018-05-07'),(9,'2018-VPFW','JEHAN TAN','Accounting','Pasig City','2018-05-08','07:00',9,6,'Pending','Conduction To and From','Inventory','ADMIN','2018-05-07'),(10,'2018-VPFW','CHA JIMENEZ','Accounting','Pasig City','2018-03-08','07:00',9,6,'Pending','Conduction To and From','Inventory','ADMIN','2018-05-07'),(12,'2018-ZXTK','JESA REBIDISO','Accounting','Caloocan City','2018-05-09','08:00',10,3,'Posted','Conduction only','Inventory','ROGELIO MALVECINO','2018-05-09'),(13,'2018-ZXTK','JHON CLAIRE AREOLA','Accounting','Caloocan City','2018-05-09','08:00',10,3,'Posted','Conduction To and From','Inventory','ROGELIO MALVECINO','2018-05-09'),(14,'2018-9QJI','MICHELLE ALARCON','MIS','Qc','2018-05-09','08:00',1,1,'Posted','Conduction To and From','tech support','ROGELIO MALVECINO','2018-05-09'),(15,'2018-MXYI','ANTHONY PASCUAL','warehouse','BGC','2018-05-10','07:00',1,1,'Pending','Conduction To and From','Delivery','ROGELIO MALVECINO','2018-05-10'),(16,'2019-OUL7','JAYSON DELA PAZ','IT Department','Baguio','2019-03-30','09:00',10,2,'Pending','Conduction Only','IT Seminar','','2019-03-29');
/*!40000 ALTER TABLE `tblticket` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbluser`
--

DROP TABLE IF EXISTS `tbluser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbluser` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `EmployeeID` int(11) NOT NULL,
  `uname` varchar(50) NOT NULL,
  `upasswd` varchar(100) NOT NULL,
  `uRole` varchar(30) NOT NULL,
  `user_stamp` date NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbluser`
--

LOCK TABLES `tbluser` WRITE;
/*!40000 ALTER TABLE `tbluser` DISABLE KEYS */;
INSERT INTO `tbluser` VALUES (5,1,'reynaldo','$2y$10$iM3n4CBcq9mqk4NWGsAe1.ko3XcLzfr0D94XnoX.Rfiu/SwtbpCNa','0','2018-05-02'),(7,2,'elpidio','$2y$10$iT4ICTwezlzr71iIRwn.1u0/GILiAGDjAd53tcXRlWOcI6S830hrW','0','2018-05-03'),(8,3,'admin','$2y$10$CMO6sMTRLEtyynkDE38KEOWdO4ij9I9.4QYJaoqCUXD3gTyHX1Pri','1','2018-05-07'),(10,10,'baptista','$2y$10$OO9JmzueY828G/h/UKuguuMZSb6QtSZbkGpsnbUqV/ezibQlxfiuS','0','2018-05-09');
/*!40000 ALTER TABLE `tbluser` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblvehicle`
--

DROP TABLE IF EXISTS `tblvehicle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblvehicle` (
  `vehicleID` int(11) NOT NULL AUTO_INCREMENT,
  `Vname` varchar(50) NOT NULL,
  `VengineNo` varchar(30) NOT NULL,
  `VchassisNo` varchar(30) NOT NULL,
  `VplateNo` varchar(15) NOT NULL,
  `Vcolor` varchar(50) NOT NULL,
  PRIMARY KEY (`vehicleID`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblvehicle`
--

LOCK TABLES `tblvehicle` WRITE;
/*!40000 ALTER TABLE `tblvehicle` DISABLE KEYS */;
INSERT INTO `tblvehicle` VALUES (1,'Ban L300','55656','JDFD898-JFF55','UVX 3302','White'),(2,'Toyota Innova','9849834','KDJALD93-D333','JAL 5623','Gray'),(3,'Mazda 3','855654','ELKSLKD22-K333','NKK 129','Green'),(4,'Toyota Vios','333324','KLKSA330-HHR422','UYT 330','Black'),(5,'Grandia','96323','KKE920-DK22','JDD 998','Blue'),(6,'Hyundai','743832','JKLSD9382-JJ33','FRL 933','Maroon'),(8,'Honda Civic','565433','HDF445-GD33','FFE 922','Black'),(9,'Hi ace','465645','GS87-FG34','FJD 883','skyblue'),(10,'ELF','6433441','GGFF56-G661','JFD 991','whites'),(13,'Toyota Fortuner','65563','FJ994-J333','SGA 217','Black');
/*!40000 ALTER TABLE `tblvehicle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblvehicleservice`
--

DROP TABLE IF EXISTS `tblvehicleservice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblvehicleservice` (
  `VserviceID` int(11) NOT NULL AUTO_INCREMENT,
  `vehicleID` int(11) NOT NULL,
  `Vdescription` varchar(150) NOT NULL,
  `Vamount` double NOT NULL,
  `Vservicedate` date NOT NULL,
  `PONumber` varchar(30) NOT NULL,
  `Scompany` varchar(150) NOT NULL,
  `Vstamp` date NOT NULL,
  PRIMARY KEY (`VserviceID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblvehicleservice`
--

LOCK TABLES `tblvehicleservice` WRITE;
/*!40000 ALTER TABLE `tblvehicleservice` DISABLE KEYS */;
INSERT INTO `tblvehicleservice` VALUES (1,4,'Change oil  ',1200,'2018-04-13','2018-1','JB Motors Inc.','2018-04-26'),(2,3,'Smoke belching  ',1200,'2018-04-01','2018-3','SEA OIL','2018-04-26'),(3,9,'Replace Tire  and Filter ',600,'2018-02-20','2018-4','All Service Motor','2018-04-26'),(4,3,'Overhaul Engine ',20000,'2018-02-13','2018-2','PGH Mechanical Service','2018-04-28'),(9,5,'Change alternator, filter and Oil',3000,'2018-05-26','2018-6','Fill Mechanical shop','2018-05-01');
/*!40000 ALTER TABLE `tblvehicleservice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'popcom2018ticketingdb'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-03-29 17:24:47
