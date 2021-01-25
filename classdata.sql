-- MySQL dump 10.13  Distrib 5.7.23, for macos10.13 (x86_64)
--
-- Host: 127.0.0.1    Database: classdata
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.47-MariaDB-0ubuntu0.18.04.1

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
-- Database: `classdata`
--
DROP DATABASE IF EXISTS `classdata`;
CREATE DATABASE IF NOT EXISTS `classdata` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `classdata`;

--
-- Table structure for table `class`
--

DROP TABLE IF EXISTS `class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `class` (
  `MAJOR` varchar(6) NOT NULL,
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(40) NOT NULL,
  `LEVEL` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `class`
--

LOCK TABLES `class` WRITE;
/*!40000 ALTER TABLE `class` DISABLE KEYS */;
INSERT INTO `class` VALUES ('BIOL',1,'Organismal Biology',1104),('CHEM',2,'Elementary Chemistry',1110),('ENGL',3,'Spy Fiction',3007),('ECON',4,'Principles of Macroeconomics',2105),('MUSI',5,'Music and Film',2090),('HIST',6,'American History I',2111),('POLS',7,'American Government',1101),('CSCI',8,'Intro Programming',1301),('MATH',9,'Precalculus',1113),('ITAL',10,'Elementary Italian',1001),('COMM',11,'Intro to Public Speaking',1110),('ITAL',12,'Elementary Italian II',1102),('CSCI',13,'Software Development',1302),('MATH',14,'Calculus I',2250),('CSCI',15,'Computing, Ethics, and Society',3030),('PHYS',16,'Principles Of Physics I',1211),('GEOG',17,'Cultural Geography US',1103),('ENGL',18,'English Composition I',1101),('ENGL',19,'English Composition II',1102),('PSYC',20,'Elementary Psychology',1101),('CSCI',21,'Systems Programming',1730),('CSCI',22,'Discrete Mathematics',2610),('ITAL',23,'Intermediate Italian',2001),('CSCI',24,'Computer Networks',4760),('MATH',25,'Calculus II',2260),('STAT',26,'Introductory Statistics',2000),('CSCI',27,'Web Programming',4300),('CSCI',28,'Data Structures',2720),('CSCI',29,'Intro to Theory of Computing',2670),('CSCI',30,'Internship Computer Science',5007),('PEDB',31,'Intro to Walking',1001),('PEDB',32,'Expert Walking',1002);
/*!40000 ALTER TABLE `class` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `class_slot`
--

DROP TABLE IF EXISTS `class_slot`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `class_slot` (
  `crn` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) NOT NULL,
  `slot_monday` tinyint(1) NOT NULL DEFAULT '0',
  `monday_period` tinyint(4) DEFAULT NULL,
  `slot_tuesday` tinyint(1) NOT NULL DEFAULT '0',
  `tuesday_period` tinyint(4) DEFAULT NULL,
  `slot_wednesday` tinyint(1) NOT NULL DEFAULT '0',
  `wednesday_period` tinyint(4) DEFAULT NULL,
  `slot_thursday` tinyint(1) NOT NULL DEFAULT '0',
  `thursday_period` tinyint(4) DEFAULT NULL,
  `slot_friday` tinyint(1) NOT NULL DEFAULT '0',
  `friday_period` tinyint(4) DEFAULT NULL,
  `slots` int(11) NOT NULL DEFAULT '30',
  `semester` enum('Fall','Spring','Summer') NOT NULL,
  PRIMARY KEY (`crn`),
  KEY `class_id` (`class_id`),
  CONSTRAINT `class_slot_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `class` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1034 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `class_slot`
--

LOCK TABLES `class_slot` WRITE;
/*!40000 ALTER TABLE `class_slot` DISABLE KEYS */;
INSERT INTO `class_slot` VALUES (1005,2,1,3,1,5,0,-1,1,5,0,-1,15,'Fall'),(1010,3,1,1,1,3,0,NULL,1,3,0,NULL,30,'Fall'),(1013,6,1,1,1,3,0,NULL,1,3,0,NULL,30,'Spring'),(1014,3,1,1,1,3,0,NULL,1,3,0,NULL,30,'Spring'),(1015,3,1,2,1,4,0,NULL,1,4,0,NULL,30,'Spring'),(1016,3,1,2,0,NULL,1,2,0,NULL,1,2,30,'Spring'),(1017,6,1,1,1,3,0,NULL,1,3,0,NULL,30,'Summer'),(1018,3,1,2,1,4,0,NULL,1,4,0,NULL,30,'Summer'),(1019,8,1,2,1,4,0,NULL,1,4,0,NULL,30,'Fall'),(1020,8,1,1,1,2,1,3,1,4,1,5,23,'Fall'),(1024,6,0,-1,1,3,1,6,1,3,0,-1,33,'Fall'),(1025,13,1,9,1,8,0,-1,1,8,0,-1,22,'Fall'),(1026,13,1,12,0,-1,1,12,0,-1,1,12,60,'Fall'),(1027,18,1,1,0,-1,1,1,0,-1,1,1,300,'Fall'),(1028,29,0,-1,1,8,0,-1,1,8,0,-1,25,'Fall'),(1029,21,0,-1,1,3,0,-1,1,3,0,-1,30,'Spring'),(1030,2,1,7,1,6,0,-1,1,6,0,-1,30,'Fall'),(1031,27,1,10,1,7,0,-1,1,7,0,-1,70,'Fall'),(1032,28,1,1,0,-1,1,1,0,-1,1,1,12,'Fall'),(1033,32,0,-1,1,2,0,-1,1,2,0,-1,300,'Summer');
/*!40000 ALTER TABLE `class_slot` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registered`
--

DROP TABLE IF EXISTS `registered`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registered` (
  `STUDENT_ID` int(11) NOT NULL,
  `CRN` int(11) NOT NULL,
  KEY `FK_Stud_ID` (`STUDENT_ID`),
  KEY `FK_Class_Num` (`CRN`),
  CONSTRAINT `registered_ibfk_2` FOREIGN KEY (`STUDENT_ID`) REFERENCES `user` (`STUDENT_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `registered_ibfk_3` FOREIGN KEY (`CRN`) REFERENCES `class_slot` (`crn`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registered`
--

LOCK TABLES `registered` WRITE;
/*!40000 ALTER TABLE `registered` DISABLE KEYS */;
INSERT INTO `registered` VALUES (101,1019),(101,1013),(104,1005),(104,1020),(104,1025),(104,1031),(103,1005),(103,1025),(103,1028),(103,1016),(103,1013),(102,1005),(102,1019),(102,1026),(102,1032),(102,1031),(102,1027),(102,1015),(102,1017);
/*!40000 ALTER TABLE `registered` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `STUDENT_ID` int(11) NOT NULL AUTO_INCREMENT,
  `USERNAME` varchar(25) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  PRIMARY KEY (`STUDENT_ID`),
  UNIQUE KEY `USERNAME` (`USERNAME`)
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (100,'admin','$2y$10$r25TdgMmED91IzNK0EcaAu0KzQsnTjikbKPbveKxirXGWhT1AtH8S'),(101,'skyler','$2y$10$AX.QrOcwW9dHEXXzWcVFXOVQomtxKZ78wv5GG3SzWaM3aRTYlK.v2'),(102,'jackson','$2y$10$I/P885u1ysADyVUSLha5pOuA/X0EY5Qp.qMKqhZMgzVCnrLKaczMC'),(103,'jay','$2y$10$bwmNOtlwJ8TJ6gn0IExHiuKW3sOKnVXHB5OuEpJSqOcq.vGktn3hG'),(104,'ryan','$2y$10$e997HE0jAWaX4olcxPbpC.JeYXzqwT844NHuFGulDM060MfdKBfyC');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'classdata'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-12-02 15:12:17
