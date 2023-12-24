CREATE DATABASE  IF NOT EXISTS `smartsecurity` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `smartsecurity`;
-- MySQL dump 10.13  Distrib 5.5.16, for Win32 (x86)
--
-- Host: 127.0.0.1    Database: smartsecurity
-- ------------------------------------------------------
-- Server version	5.5.27

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
-- Table structure for table `celular`
--

DROP TABLE IF EXISTS `celular`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `celular` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `imei` bigint(20) DEFAULT NULL,
  `marca` varchar(50) DEFAULT NULL,
  `cor` varchar(20) DEFAULT NULL,
  `modelo` varchar(50) DEFAULT NULL,
  `usuario_id` int(11) NOT NULL,
  PRIMARY KEY (`cod`),
  KEY `celular_ibfk_1` (`usuario_id`),
  CONSTRAINT `celular_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `celular`
--

LOCK TABLES `celular` WRITE;
/*!40000 ALTER TABLE `celular` DISABLE KEYS */;
INSERT INTO `celular` VALUES (4,NULL,'MOTOROLA','Branco','G8',1);
/*!40000 ALTER TABLE `celular` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comentario`
--

DROP TABLE IF EXISTS `comentario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comentario` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `comentario` text,
  `usuario_id` int(11) NOT NULL,
  PRIMARY KEY (`cod`),
  KEY `comentario_ibfk_2` (`usuario_id`),
  CONSTRAINT `comentario_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comentario`
--

LOCK TABLES `comentario` WRITE;
/*!40000 ALTER TABLE `comentario` DISABLE KEYS */;
/*!40000 ALTER TABLE `comentario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ocorrencia`
--

DROP TABLE IF EXISTS `ocorrencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ocorrencia` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(7) DEFAULT NULL,
  `localizacao` varchar(80) DEFAULT NULL,
  `referencia` varchar(80) DEFAULT NULL,
  `dt_registro` date DEFAULT NULL,
  `hr_registro` time DEFAULT NULL,
  `titulo_registro` varchar(50) DEFAULT NULL,
  `marca` varchar(20) DEFAULT NULL,
  `modelo` varchar(50) DEFAULT NULL,
  `cor` varchar(20) DEFAULT NULL,
  `imei` varchar(20) DEFAULT NULL,
  `descricao` text,
  `usuario_id` int(11) NOT NULL,
  PRIMARY KEY (`cod`),
  KEY `ocorrencia_ibfk_1` (`usuario_id`),
  CONSTRAINT `ocorrencia_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ocorrencia`
--

LOCK TABLES `ocorrencia` WRITE;
/*!40000 ALTER TABLE `ocorrencia` DISABLE KEYS */;
INSERT INTO `ocorrencia` VALUES (7,'Assalto','Setor Habitacional Sol Nacente','No Trêm Bom','2019-11-13','18:00:00','Estava Comendo','APPLE','IPHONE X','Douraudo','25841201478962023698','Fui assaltado quando tava voltando do bomba, alem de pegar meu celular, pegou meu Bomba. >:[',1),(8,'Assalto','Ceilândia Sul','ao lado da parada do centro','2019-09-25','03:00:00','Fui assaltado saindo do ônibus','APPLE','Iphone 8','Branco','2154787945641321','',1),(9,'Assalto','Guariroba','Ao lado da estação','2019-08-15','13:00:00','Voltando do curso','LG','Lg K10','Preto','12459876321','',1),(10,'Perda','P Norte','Perto da padaria Bom pão','2019-11-05','18:45:00','Perdi meu celular voltando pra casa','XIAOMI','Redmi 9','Preto','154987623581','',1),(11,'Assalto','Setor Habitacional Sol Nacente','Perto da barbearia','2019-10-17','04:00:00','Assalto a mão armada','ASUS','Zenfone 9','Preto','82588258865858285277','',1),(12,'Perda','Setor Habitacional Sol Nacente','Na rua','2019-11-05','15:30:00','Perdi perto do campo de futebol','MOTOROLA','G6','Preto','78459621545874','',1),(13,'Assalto','Setor Habitacional Sol Nacente','Ao lado da escola','2019-10-04','19:23:00','Fui assaltado ao esperar meu filho sair da escola','APPLE','Iphone 5s','Preto','124598673251','',1),(14,NULL,'Incra(Ceilândia)','perto da chacara das palmeiras','2019-12-04','04:25:00','fui assaltado na festa ','SAMSUNG','samsung galaxy 8','Branco','798765498589847798','',1),(15,'Assalto','Setores de Indústria e de Materiais de Construção','perto da madereira de construção','2019-02-15','06:52:00','Chegou com um faca e levou o celular','MOTOROLA','moto g5','Prata','145286325841258','',1),(16,'Assalto','P Sul','perto do posto de gasolina','2019-11-13','16:30:00','Abastecendo o carro','APPLE','iphone x','Preto','5885513989876141417','',1),(17,'Assalto','QNQ','perto do fort atacadista','2019-10-20','19:30:00','Chegou de bicicleta armado','SONY','xperia z3','Branco','654565436546591494','',1);
/*!40000 ALTER TABLE `ocorrencia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perfil`
--

DROP TABLE IF EXISTS `perfil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `perfil` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `perfil` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`cod`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perfil`
--

LOCK TABLES `perfil` WRITE;
/*!40000 ALTER TABLE `perfil` DISABLE KEYS */;
INSERT INTO `perfil` VALUES (1,'Administrador'),(2,'Usuário');
/*!40000 ALTER TABLE `perfil` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(40) DEFAULT NULL,
  `sobrenome` varchar(40) DEFAULT NULL,
  `dt_nascimento` date DEFAULT NULL,
  `sexo` char(4) DEFAULT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `senha` varchar(150) DEFAULT NULL,
  `endereco` varchar(60) DEFAULT NULL,
  `perfil_cod` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario_ibfk_1` (`perfil_cod`),
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`perfil_cod`) REFERENCES `perfil` (`cod`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'João Victor','Aguiar Copes','2000-08-06','Masc','061.235.163-70','joaovictor.copes@gmail.com','17c8ef397a95be5737e302f730293088','Ceilândia Norte',1);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-11-14 15:36:55
