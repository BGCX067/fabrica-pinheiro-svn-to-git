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
-- Table structure for table `banners_tbl`
--

DROP TABLE IF EXISTS `banners_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `banners_tbl` (
  `id_banners` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` blob,
  `link` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `data_cadastro` datetime DEFAULT NULL,
  `data_exclusao` datetime DEFAULT NULL,
  `id_banners_tipos` int(11) NOT NULL,
  `id_usuarios` int(11) NOT NULL,
  PRIMARY KEY (`id_banners`),
  KEY `fk_banners_tbl_banners_tipos_tbl1` (`id_banners_tipos`),
  KEY `fk_banners_tbl_usuarios_tbl1` (`id_usuarios`),
  CONSTRAINT `fk_banners_tbl_banners_tipos_tbl1` FOREIGN KEY (`id_banners_tipos`) REFERENCES `banners_tipos_tbl` (`id_banners_tipos`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_banners_tbl_usuarios_tbl1` FOREIGN KEY (`id_usuarios`) REFERENCES `usuarios_tbl` (`id_usuarios`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banners_tbl`
--

LOCK TABLES `banners_tbl` WRITE;
/*!40000 ALTER TABLE `banners_tbl` DISABLE KEYS */;
/*!40000 ALTER TABLE `banners_tbl` ENABLE KEYS */;
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
