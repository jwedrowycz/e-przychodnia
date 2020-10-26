-- MySQL dump 10.13  Distrib 8.0.20, for Linux (x86_64)
--
-- Host: localhost    Database: przychodnia
-- ------------------------------------------------------
-- Server version	8.0.20-0ubuntu0.20.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `clinic`
--

DROP TABLE IF EXISTS `clinic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clinic` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clinic`
--

LOCK TABLES `clinic` WRITE;
/*!40000 ALTER TABLE `clinic` DISABLE KEYS */;
INSERT INTO `clinic` VALUES (1,'Poradnia laryngologiczna'),(2,'Poradnia okulistyczna'),(3,'Poradnia neurologiczna'),(4,'Poradnia kardiologiczna'),(7,'Poradnia chorób płuc');
/*!40000 ALTER TABLE `clinic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctor`
--

DROP TABLE IF EXISTS `doctor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doctor` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `num_pwz` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `spec` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctor`
--

LOCK TABLES `doctor` WRITE;
/*!40000 ALTER TABLE `doctor` DISABLE KEYS */;
INSERT INTO `doctor` VALUES (1,'Adam','Nowak','1234532','Okulista',1),(2,'Janusz','Tracz','1234212','Laryngolog',0),(3,'Beata','Nowakowska','4322123','Neurolog',1),(4,'Adam','Brzozowski','4433321','Okulista',1),(6,'Piotr','Jędrzejski','3214212','Kardiolog, pulmonolog',1),(18,'Wojciech','Jarząbek','3534346','Neurolog',1),(19,'Tomasz','Baranowski','5435436','Ginekolog',1);
/*!40000 ALTER TABLE `doctor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medical_history`
--

DROP TABLE IF EXISTS `medical_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `medical_history` (
  `id` int NOT NULL AUTO_INCREMENT,
  `test_field` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medical_history`
--

LOCK TABLES `medical_history` WRITE;
/*!40000 ALTER TABLE `medical_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `medical_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration_versions`
--

LOCK TABLES `migration_versions` WRITE;
/*!40000 ALTER TABLE `migration_versions` DISABLE KEYS */;
INSERT INTO `migration_versions` VALUES ('20200524163141','2020-05-24 16:32:55');
/*!40000 ALTER TABLE `migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unit`
--

DROP TABLE IF EXISTS `unit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `unit` (
  `id` int NOT NULL AUTO_INCREMENT,
  `doctor_id` int NOT NULL,
  `clinic_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_DCBB0C5387F4FB17` (`doctor_id`),
  KEY `IDX_DCBB0C53CC22AD4` (`clinic_id`),
  CONSTRAINT `FK_DCBB0C5387F4FB17` FOREIGN KEY (`doctor_id`) REFERENCES `doctor` (`id`),
  CONSTRAINT `FK_DCBB0C53CC22AD4` FOREIGN KEY (`clinic_id`) REFERENCES `clinic` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unit`
--

LOCK TABLES `unit` WRITE;
/*!40000 ALTER TABLE `unit` DISABLE KEYS */;
INSERT INTO `unit` VALUES (1,1,2),(3,4,2),(4,2,1),(6,3,3),(7,6,4),(8,18,3),(9,6,7);
/*!40000 ALTER TABLE `unit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pesel` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `num_phone` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_code` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `birthday` date DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `voivodeship` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin@admin.pl','[\"ROLE_ADMIN\"]','$2y$13$hFtKNmUuEl5vgNcfxSuPgeslJEDE1PpFB3S.qbW76UEqG.Kf3IiKy','98012806930','622323423','09-400','2020-05-15 15:17:47','1998-01-28','','','','',NULL,NULL),(3,'j.nowak@wp.pl','[\"ROLE_USER\"]','$2y$13$jkTJRosC2IW.d.hKmbKcDutk24nijwDrdRjATPhCczuQ.NGQEmiaS','12335345345','553242342','09-400','2020-05-16 23:07:15','1998-01-28','Jan','Nowak','Bielska 3','Płock','Mężczyzna','mazowieckie'),(4,'j.kop@wp.pl','[\"ROLE_USER\"]','$2y$13$jkvU/i/VbdvpoqJ/4YxxDOEAjPPdn./AyzR5GWOVPTcg5x5VV7yS.','23112312312','213123123','09-400','2020-05-17 00:46:58','1997-01-28','Jakub','Kopniewski','Skłodowskiej','Płock','Mężczyzna','mazowieckie'),(7,'a.nowakowska@wp.pl','[\"ROLE_USER\"]','$2y$13$rhUfjAJJfmtg5fsFYSLfIesX3Pit/Xl1T11imuDS8AjRTMGrPCBcO','86123454353','334546757','09-400','2020-05-29 00:04:41','1992-07-04','Anna','Nowakowska','Jachowicza 2','Płock','Mężczyzna','mazowieckie'),(8,'j.kasztanski@wp.pl','[\"ROLE_USER\"]','$2y$13$PIPZr7Fh0k3Ayc5uUDPEj.Q0V.18n4qAotXXjk843ZigPeqnf/GCq','31231432141','321434352','09-400','2020-06-07 00:35:23','1997-08-16','Jarosław','Kasztański','Podolszyce 2','Płock','Mężczyzna','mazowieckie');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visit`
--

DROP TABLE IF EXISTS `visit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `visit` (
  `id` int NOT NULL AUTO_INCREMENT,
  `unit_id` int NOT NULL,
  `user_id` int NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `submit_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_437EE939F8BD700D` (`unit_id`),
  KEY `IDX_437EE939A76ED395` (`user_id`),
  CONSTRAINT `FK_437EE939A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_437EE939F8BD700D` FOREIGN KEY (`unit_id`) REFERENCES `unit` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=172 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visit`
--

LOCK TABLES `visit` WRITE;
/*!40000 ALTER TABLE `visit` DISABLE KEYS */;
INSERT INTO `visit` VALUES (51,4,1,'2020-05-20 11:00:00','2020-05-20 11:20:00','2020-05-17 19:59:00'),(100,3,1,'2020-06-01 10:00:00','2020-06-01 10:20:00','2020-05-20 02:25:25'),(106,4,4,'2020-05-27 13:00:00','2020-05-27 13:20:00','2020-05-22 01:36:38'),(107,7,4,'2020-05-25 10:40:00','2020-05-25 11:00:00','2020-05-22 01:36:44'),(108,6,4,'2020-05-25 10:20:00','2020-05-25 10:40:00','2020-05-22 01:36:49'),(109,3,4,'2020-06-03 13:40:00','2020-06-03 14:00:00','2020-05-22 01:36:54'),(110,6,4,'2020-06-08 10:00:00','2020-06-08 10:20:00','2020-05-22 01:36:59'),(111,6,4,'2020-06-08 09:00:00','2020-06-08 09:20:00','2020-05-22 01:37:03'),(112,4,4,'2020-06-11 12:20:00','2020-06-11 12:40:00','2020-05-22 01:37:08'),(113,4,1,'2020-05-28 12:40:00','2020-05-28 13:00:00','2020-05-24 02:01:32'),(114,4,1,'2020-05-29 12:00:00','2020-05-29 12:20:00','2020-05-24 02:01:36'),(115,4,1,'2020-05-29 11:20:00','2020-05-29 11:40:00','2020-05-24 02:01:40'),(126,4,1,'2020-05-27 11:40:00','2020-05-27 12:00:00','2020-05-25 23:51:50'),(127,6,1,'2020-05-28 12:20:00','2020-05-28 12:40:00','2020-05-27 00:51:43'),(128,7,1,'2020-05-29 13:20:00','2020-05-29 13:40:00','2020-05-27 00:51:47'),(130,7,1,'2020-05-29 14:20:00','2020-05-29 14:40:00','2020-05-27 02:56:32'),(131,6,1,'2020-06-01 09:40:00','2020-06-01 10:00:00','2020-05-28 22:15:46'),(132,6,1,'2020-05-29 11:40:00','2020-05-29 12:00:00','2020-05-28 22:15:54'),(133,7,1,'2020-05-29 13:00:00','2020-05-29 13:20:00','2020-05-28 22:16:18'),(134,7,1,'2020-05-29 15:00:00','2020-05-29 15:20:00','2020-05-28 22:16:24'),(135,6,1,'2020-05-29 10:40:00','2020-05-29 11:00:00','2020-05-28 22:17:54'),(136,4,1,'2020-05-29 13:00:00','2020-05-29 13:20:00','2020-05-28 22:18:08'),(139,6,7,'2020-06-02 11:20:00','2020-06-02 11:40:00','2020-05-29 00:07:08'),(140,7,7,'2020-06-02 11:40:00','2020-06-02 12:00:00','2020-05-29 00:20:39'),(144,7,7,'2020-06-09 13:00:00','2020-06-09 13:20:00','2020-06-05 02:09:21'),(145,4,7,'2020-06-11 14:00:00','2020-06-11 14:20:00','2020-06-05 02:14:08'),(146,4,7,'2020-06-11 13:00:00','2020-06-11 13:20:00','2020-06-05 02:15:41'),(147,9,7,'2020-06-09 11:00:00','2020-06-09 11:20:00','2020-06-05 02:16:49'),(148,7,7,'2020-06-09 11:00:00','2020-06-09 11:20:00','2020-06-05 02:16:56'),(149,7,7,'2020-06-09 12:20:00','2020-06-09 12:40:00','2020-06-05 02:19:40'),(150,8,7,'2020-06-10 10:40:00','2020-06-10 11:00:00','2020-06-05 02:19:48'),(151,4,7,'2020-06-11 15:20:00','2020-06-11 15:40:00','2020-06-05 02:21:39'),(152,6,7,'2020-06-09 09:40:00','2020-06-09 10:00:00','2020-06-05 02:21:58'),(153,6,7,'2020-06-10 13:00:00','2020-06-10 13:20:00','2020-06-05 02:22:21'),(154,6,7,'2020-06-11 13:20:00','2020-06-11 13:40:00','2020-06-05 02:22:37'),(155,6,7,'2020-06-10 09:00:00','2020-06-10 09:20:00','2020-06-05 02:24:12'),(156,4,7,'2020-06-12 13:20:00','2020-06-12 13:40:00','2020-06-05 02:24:27'),(157,6,7,'2020-06-11 11:20:00','2020-06-11 11:40:00','2020-06-05 02:24:43'),(159,9,1,'2020-06-09 12:00:00','2020-06-09 12:20:00','2020-06-05 16:29:30'),(160,4,4,'2020-06-12 13:00:00','2020-06-12 13:20:00','2020-06-05 16:46:36'),(161,6,4,'2020-06-12 14:20:00','2020-06-12 14:40:00','2020-06-05 16:46:40'),(162,8,1,'2020-06-09 12:20:00','2020-06-09 12:40:00','2020-06-06 02:35:18'),(163,7,1,'2020-06-10 10:40:00','2020-06-10 11:00:00','2020-06-07 00:59:15'),(164,7,4,'2020-06-10 11:40:00','2020-06-10 12:00:00','2020-06-07 15:00:07'),(165,6,4,'2020-06-12 11:00:00','2020-06-12 11:20:00','2020-06-07 15:00:51'),(166,9,4,'2020-06-10 11:00:00','2020-06-10 11:20:00','2020-06-07 17:34:08'),(167,6,4,'2020-06-15 08:20:00','2020-06-15 08:40:00','2020-06-07 17:34:22'),(168,7,4,'2020-06-10 10:00:00','2020-06-10 10:20:00','2020-06-07 18:15:44'),(169,7,4,'2020-06-10 13:00:00','2020-06-10 13:20:00','2020-06-07 20:02:23'),(170,7,4,'2020-07-07 10:00:00','2020-07-07 10:20:00','2020-06-07 21:17:39'),(171,9,4,'2020-06-12 14:00:00','2020-06-12 14:20:00','2020-06-08 00:36:09');
/*!40000 ALTER TABLE `visit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `work_time`
--

DROP TABLE IF EXISTS `work_time`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `work_time` (
  `id` int NOT NULL AUTO_INCREMENT,
  `unit_id` int DEFAULT NULL,
  `start` time NOT NULL,
  `end` time NOT NULL,
  `day` smallint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9657297DF8BD700D` (`unit_id`),
  CONSTRAINT `FK_9657297DF8BD700D` FOREIGN KEY (`unit_id`) REFERENCES `unit` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `work_time`
--

LOCK TABLES `work_time` WRITE;
/*!40000 ALTER TABLE `work_time` DISABLE KEYS */;
INSERT INTO `work_time` VALUES (1,1,'08:00:00','15:00:00',1),(2,1,'08:00:00','15:00:00',2),(3,1,'10:00:00','17:00:00',3),(4,1,'08:00:00','15:00:00',4),(11,4,'11:00:00','15:00:00',3),(12,4,'10:00:00','17:00:00',4),(13,4,'08:00:00','15:00:00',5),(14,3,'08:00:00','12:00:00',1),(15,3,'08:00:00','12:00:00',2),(16,3,'12:00:00','17:00:00',3),(17,3,'12:00:00','17:00:00',4),(18,3,'09:00:00','12:00:00',5),(19,6,'08:00:00','12:00:00',1),(20,6,'08:00:00','12:00:00',2),(21,6,'08:00:00','15:00:00',3),(22,6,'08:00:00','10:00:00',4),(23,6,'11:00:00','15:00:00',4),(24,6,'08:00:00','12:00:00',5),(25,6,'13:00:00','15:00:00',5),(27,7,'08:00:00','15:30:00',1),(28,7,'08:00:00','15:00:00',2),(30,7,'12:00:00','18:00:00',5),(31,7,'08:00:00','12:00:00',3),(33,7,'13:00:00','15:00:00',3),(34,8,'08:00:00','12:00:00',1),(35,8,'12:00:00','15:00:00',2),(36,8,'09:00:00','12:00:00',3),(37,8,'00:00:00','00:00:00',4),(40,9,'10:00:00','15:00:00',1),(41,9,'08:00:00','15:00:00',2),(42,9,'08:00:00','15:00:00',3),(43,9,'08:00:00','15:00:00',5);
/*!40000 ALTER TABLE `work_time` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-06-15 15:54:02
