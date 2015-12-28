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
-- Table structure for table `pedidos_tbl`
--

DROP TABLE IF EXISTS `pedidos_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pedidos_tbl` (
  `id_pedidos` int(11) NOT NULL AUTO_INCREMENT,
  `id_clientes` int(11) NOT NULL,
  `data_hora` datetime NOT NULL,
  `moip_token` varchar(500) DEFAULT NULL,
  `unique_id` varchar(32) DEFAULT NULL,
  `cod_moip` varchar(20) DEFAULT NULL,
  `forma_pagamento` varchar(255) DEFAULT NULL,
  `tipo_pagamento` varchar(32) DEFAULT NULL,
  `email_consumidor` varchar(255) DEFAULT NULL,
  `valor_pago` varchar(45) DEFAULT NULL,
  `situacao` int(11) NOT NULL,
  PRIMARY KEY (`id_pedidos`),
  KEY `fk_pedidos_tbl_clientes_tbl1` (`id_clientes`),
  KEY `fk_pedidos_tbl_forma_pagamentos_tbl1` (`situacao`),
  CONSTRAINT `fk_pedidos_tbl_clientes_tbl1` FOREIGN KEY (`id_clientes`) REFERENCES `clientes_tbl` (`id_clientes`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedidos_tbl_forma_pagamentos_tbl1` FOREIGN KEY (`situacao`) REFERENCES `forma_pagamentos_tbl` (`id_forma_pagamentos`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 DELAY_KEY_WRITE=1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedidos_tbl`
--

LOCK TABLES `pedidos_tbl` WRITE;
/*!40000 ALTER TABLE `pedidos_tbl` DISABLE KEYS */;
/*!40000 ALTER TABLE `pedidos_tbl` ENABLE KEYS */;
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
