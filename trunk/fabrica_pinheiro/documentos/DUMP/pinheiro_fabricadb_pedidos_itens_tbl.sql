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
-- Table structure for table `pedidos_itens_tbl`
--

DROP TABLE IF EXISTS `pedidos_itens_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pedidos_itens_tbl` (
  `id_pedido_itens` int(11) NOT NULL AUTO_INCREMENT,
  `id_pedidos` int(11) NOT NULL,
  `id_produtos` int(11) NOT NULL,
  `qtd` float(5,0) NOT NULL DEFAULT '0',
  `valor` float(5,2) NOT NULL DEFAULT '0.00',
  `valor_total` float(5,2) DEFAULT '0.00',
  PRIMARY KEY (`id_pedido_itens`),
  KEY `fk_pedido_itens_tbl_pedidos_tbl1` (`id_pedidos`),
  KEY `fk_pedidos_itens_tbl_produtos_tbl1` (`id_produtos`),
  CONSTRAINT `fk_pedido_itens_tbl_pedidos_tbl1` FOREIGN KEY (`id_pedidos`) REFERENCES `pedidos_tbl` (`id_pedidos`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedidos_itens_tbl_produtos_tbl1` FOREIGN KEY (`id_produtos`) REFERENCES `produtos_tbl` (`id_produtos`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 DELAY_KEY_WRITE=1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedidos_itens_tbl`
--

LOCK TABLES `pedidos_itens_tbl` WRITE;
/*!40000 ALTER TABLE `pedidos_itens_tbl` DISABLE KEYS */;
/*!40000 ALTER TABLE `pedidos_itens_tbl` ENABLE KEYS */;
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
