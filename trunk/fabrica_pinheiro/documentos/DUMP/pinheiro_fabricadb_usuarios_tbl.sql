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
-- Table structure for table `usuarios_tbl`
--

DROP TABLE IF EXISTS `usuarios_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios_tbl` (
  `id_usuarios` int(11) NOT NULL AUTO_INCREMENT,
  `id_pessoas` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(32) NOT NULL,
  `status` varchar(1) NOT NULL COMMENT '1 - Ativo\n2 - Inativo',
  PRIMARY KEY (`id_usuarios`),
  KEY `fk_usuarios_tbl_pessoas_tbl1` (`id_pessoas`),
  CONSTRAINT `fk_usuarios_tbl_pessoas_tbl1` FOREIGN KEY (`id_pessoas`) REFERENCES `pessoas_tbl` (`id_pessoas`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 DELAY_KEY_WRITE=1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios_tbl`
--

LOCK TABLES `usuarios_tbl` WRITE;
/*!40000 ALTER TABLE `usuarios_tbl` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuarios_tbl` ENABLE KEYS */;
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
