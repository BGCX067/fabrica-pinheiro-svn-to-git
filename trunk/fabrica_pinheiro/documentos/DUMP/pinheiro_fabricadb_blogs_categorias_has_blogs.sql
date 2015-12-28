CREATE DATABASE  IF NOT EXISTS `pinheiro_fabricadb` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `pinheiro_fabricadb`;
-- MySQL dump 10.13  Distrib 5.5.24, for Linux (x86_64)
--
-- Host: localhost    Database: pinheiro_fabricadb
-- ------------------------------------------------------
-- Server version	5.5.24

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
-- Table structure for table `blogs_categorias_has_blogs`
--

DROP TABLE IF EXISTS `blogs_categorias_has_blogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blogs_categorias_has_blogs` (
  `id_blogs` int(11) NOT NULL,
  `id_blogs_categorias` int(11) NOT NULL,
  PRIMARY KEY (`id_blogs`,`id_blogs_categorias`),
  KEY `fk_blogs_has_blogs_categorias_blogs_categorias1` (`id_blogs_categorias`),
  KEY `fk_blogs_has_blogs_categorias_blogs1` (`id_blogs`),
  CONSTRAINT `fk_blogs_has_blogs_categorias_blogs1` FOREIGN KEY (`id_blogs`) REFERENCES `blogs` (`id_blogs`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_blogs_has_blogs_categorias_blogs_categorias1` FOREIGN KEY (`id_blogs_categorias`) REFERENCES `blogs_categorias` (`id_blogs_categorias`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blogs_categorias_has_blogs`
--

LOCK TABLES `blogs_categorias_has_blogs` WRITE;
/*!40000 ALTER TABLE `blogs_categorias_has_blogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `blogs_categorias_has_blogs` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-06-22 11:30:56
