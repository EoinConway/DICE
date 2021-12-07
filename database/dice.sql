CREATE DATABASE  IF NOT EXISTS `softwareproject` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `softwareproject`;
-- MySQL dump 10.13  Distrib 5.7.12, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: softwareproject
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.14-MariaDB

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
-- Table structure for table `attendee`
--

DROP TABLE IF EXISTS `attendee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attendee` (
  `User_ID` int(11) NOT NULL,
  `event_ID` int(11) NOT NULL,
  PRIMARY KEY (`User_ID`,`event_ID`),
  KEY `fk_user_has_event_user1_idx` (`User_ID`),
  KEY `fk_user_has_event_event1_idx` (`event_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendee`
--

LOCK TABLES `attendee` WRITE;
/*!40000 ALTER TABLE `attendee` DISABLE KEYS */;
INSERT INTO `attendee` VALUES (21,12),(23,32),(23,36),(24,32),(25,32),(26,32),(27,36);
/*!40000 ALTER TABLE `attendee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event` (
  `event_ID` int(11) NOT NULL AUTO_INCREMENT,
  `admin_ID` int(11) NOT NULL,
  `event_name` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `sport` int(20) NOT NULL,
  `fee` float DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `starttime` time(6) DEFAULT NULL,
  `endtime` time(6) DEFAULT NULL,
  `nr_attendees` int(11) DEFAULT NULL,
  `max_nr_attendees` int(11) DEFAULT NULL,
  `min_nr_attendees` int(11) DEFAULT NULL,
  `event_type` int(11) NOT NULL,
  `recurring` int(11) NOT NULL,
  `location` varchar(45) CHARACTER SET utf8 NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`event_ID`,`admin_ID`,`event_type`,`recurring`,`status`),
  KEY `fk_event_event_admin1_idx` (`admin_ID`),
  KEY `fk_event_sportlookup_idx` (`sport`),
  KEY `fk_event_recurringlookup_idx` (`recurring`),
  KEY `fk_event_eventtypelookup_idx` (`event_type`),
  CONSTRAINT `fk_event_adminID` FOREIGN KEY (`admin_ID`) REFERENCES `event_admin` (`admin_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_event_eventtypelookup` FOREIGN KEY (`event_type`) REFERENCES `eventtypelookup` (`Type_Nr`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_event_recurringlookup` FOREIGN KEY (`recurring`) REFERENCES `recurringlookup` (`recurring_nr`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_event_sportlookup` FOREIGN KEY (`sport`) REFERENCES `sportlookup` (`sport_nr`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event`
--

LOCK TABLES `event` WRITE;
/*!40000 ALTER TABLE `event` DISABLE KEYS */;
INSERT INTO `event` VALUES (12,4,'Badminton Double\'s Night',2,5,'2021-06-14','18:30:00.000000','20:30:00.000000',1,10,6,2,2,'Shuttle Badminton Club, Limerick',1),(17,5,'Casual Pitch & Putt ',5,2.5,'2021-07-15','10:00:00.000000','11:00:00.000000',0,20,4,4,3,'Taylors Hill Pitch and Putt Club',1),(18,4,'Self Defence for Women',7,3,'2021-05-10','18:30:00.000000','19:30:00.000000',0,10,4,2,3,'St Pauls Karate Club',1),(21,11,'Over 65\'s 7-a-side',8,5,'2021-06-12','20:30:00.000000','21:30:00.000000',0,16,6,4,1,'Nemo Rangers, Douglas',1),(27,11,'Tuesday Tag',9,5,'2021-05-18','20:00:00.000000','21:00:00.000000',0,16,12,3,1,'Douglas Gaa Pitch',1),(28,11,'Karate Tournament',7,12,'2021-08-01','18:30:00.000000','20:30:00.000000',0,12,6,2,1,'Moylish Campus',1),(29,11,'Indoor Mens Soccer',8,5,'2021-01-02','17:00:00.000000','19:00:00.000000',0,16,8,2,1,'Ashton Hockey Pitch',1),(30,12,'Gaelic for girls',4,2,'2021-07-02','12:00:00.000000','14:00:00.000000',0,12,4,2,1,'St Michael\'s Gaa Club',1),(31,12,'Blitz',8,10,'2021-08-01','10:00:00.000000','18:00:00.000000',0,40,20,1,1,'Turner\'s Cross',1),(32,4,'Cross-Country',1,0,'2021-06-25','06:30:00.000000','16:30:00.000000',4,4,3,1,1,'Beaumont School',1),(33,4,'Women\'s Volleyball',10,5,'2021-06-02','14:00:00.000000','15:00:00.000000',0,10,6,2,1,'Myrtelville Beach',1),(34,5,'Couples Basketball',3,5,'2021-07-14','20:00:00.000000','21:30:00.000000',0,12,6,3,1,'Neptune Stadium',1),(35,5,'Mindfulness Hour',11,3,'2021-05-15','20:00:00.000000','21:00:00.000000',0,10,2,3,1,'Wild Atlantic Way Yoga',1),(36,11,'Guitar Open Jam ',12,0,'2021-06-10','17:00:00.000000','18:00:00.000000',2,12,2,3,1,'Crane Lane Theatre',1),(37,11,'Breaking Badminton',2,3.5,'2021-06-11','20:15:00.000000','21:00:00.000000',0,8,4,1,1,'Garyduff Sports Hall',1),(38,11,'Fighting Fitness ',7,5,'2021-05-25','14:00:00.000000','16:00:00.000000',0,6,2,1,1,'Mahon Boxing Club',1);
/*!40000 ALTER TABLE `event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_admin`
--

DROP TABLE IF EXISTS `event_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event_admin` (
  `admin_ID` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `mobile_nr` varchar(45) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `join_date` date DEFAULT NULL,
  PRIMARY KEY (`admin_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_admin`
--

LOCK TABLES `event_admin` WRITE;
/*!40000 ALTER TABLE `event_admin` DISABLE KEYS */;
INSERT INTO `event_admin` VALUES (4,'mark','test4','test1@test.com','0854444444','86985e105f79b95d6bc918fb45ec7727','2021-01-31'),(5,'john','doe','joe@gmail.com','0851111111','2829fc16ad8ca5a79da932f910afad1c','2021-02-01'),(11,'Daire','Hill','admin@email.com','0851231234','cf8f0c0d32522bc3d2ebe59d1fa46611d3369c96','2021-02-18'),(12,'John','Doe','johndoe@yahoo.com','0871234567','cf8f0c0d32522bc3d2ebe59d1fa46611d3369c96','2021-03-22');
/*!40000 ALTER TABLE `event_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_archive`
--

DROP TABLE IF EXISTS `event_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event_archive` (
  `event_ID` int(11) NOT NULL,
  `admin_ID` int(11) NOT NULL,
  `event_name` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sport` int(20) DEFAULT NULL,
  `fee` float DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `starttime` time(6) DEFAULT NULL,
  `endtime` time(6) DEFAULT NULL,
  `nr_attendees` int(11) DEFAULT NULL,
  `max_nr_attendees` int(11) DEFAULT NULL,
  `min_nr_attendees` int(11) DEFAULT NULL,
  `event_type` int(11) DEFAULT NULL,
  `recurring` int(11) DEFAULT NULL,
  `location` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`event_ID`,`admin_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_archive`
--

LOCK TABLES `event_archive` WRITE;
/*!40000 ALTER TABLE `event_archive` DISABLE KEYS */;
/*!40000 ALTER TABLE `event_archive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eventtypelookup`
--

DROP TABLE IF EXISTS `eventtypelookup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eventtypelookup` (
  `Type_Nr` int(11) NOT NULL AUTO_INCREMENT,
  `Type` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`Type_Nr`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eventtypelookup`
--

LOCK TABLES `eventtypelookup` WRITE;
/*!40000 ALTER TABLE `eventtypelookup` DISABLE KEYS */;
INSERT INTO `eventtypelookup` VALUES (1,'Mens Only'),(2,'Womens Only'),(3,'Men and Women'),(4,'Over 65');
/*!40000 ALTER TABLE `eventtypelookup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recurringlookup`
--

DROP TABLE IF EXISTS `recurringlookup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recurringlookup` (
  `recurring_nr` int(11) NOT NULL AUTO_INCREMENT,
  `recurring_type` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`recurring_nr`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recurringlookup`
--

LOCK TABLES `recurringlookup` WRITE;
/*!40000 ALTER TABLE `recurringlookup` DISABLE KEYS */;
INSERT INTO `recurringlookup` VALUES (1,'No'),(2,'Weekly'),(3,'Monthly');
/*!40000 ALTER TABLE `recurringlookup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sportlookup`
--

DROP TABLE IF EXISTS `sportlookup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sportlookup` (
  `sport_nr` int(11) NOT NULL AUTO_INCREMENT,
  `sport` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`sport_nr`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sportlookup`
--

LOCK TABLES `sportlookup` WRITE;
/*!40000 ALTER TABLE `sportlookup` DISABLE KEYS */;
INSERT INTO `sportlookup` VALUES (1,'Athletics'),(2,'Badminton'),(3,'Basketball'),(4,'Gaelic Football'),(5,'Golf'),(6,'Hurling/Camogie'),(7,'Martial Arts'),(8,'Soccer'),(9,'Tag Rugby'),(10,'Volleyball'),(11,'Yoga'),(12,'Other');
/*!40000 ALTER TABLE `sportlookup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `User_ID` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `mobile_nr` varchar(45) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `join_date` date DEFAULT NULL,
  PRIMARY KEY (`User_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (22,'Jack','Frost','eoinconway@live.com','0893333333','cf8f0c0d32522bc3d2ebe59d1fa46611d3369c96','2021-03-07'),(23,'Mark','Murphy','markmurphy@example.com','0861234567','cf8f0c0d32522bc3d2ebe59d1fa46611d3369c96','2021-03-22'),(24,'Paul','McGrath','paulmcgrath@example.com','0851234567','cf8f0c0d32522bc3d2ebe59d1fa46611d3369c96','2021-04-19'),(25,'Lauren','O\'Connell','laurenoconnell@example.com','0891234569','cf8f0c0d32522bc3d2ebe59d1fa46611d3369c96','2021-04-19'),(26,'Michelle','Higgins','michellehiggins@example.com','0871234567','cf8f0c0d32522bc3d2ebe59d1fa46611d3369c96','2021-04-20'),(27,'Sam','Smith','samsmith@example.com','0855555555','cf8f0c0d32522bc3d2ebe59d1fa46611d3369c96','2021-04-20');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'softwareproject'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-05-02 13:08:15
