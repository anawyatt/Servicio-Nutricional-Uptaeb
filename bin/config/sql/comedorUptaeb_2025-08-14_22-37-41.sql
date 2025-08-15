-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: comerdorUptaeb
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `alimento`
--

DROP TABLE IF EXISTS `alimento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alimento` (
  `idAlimento` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(20) NOT NULL,
  `imgAlimento` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `unidadMedida` varchar(50) NOT NULL,
  `marca` varchar(50) NOT NULL,
  `stock` int(11) NOT NULL,
  `reservado` int(11) NOT NULL,
  `idTipoA` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`idAlimento`),
  KEY `idx_alimento_idAlimento` (`idAlimento`),
  KEY `idx_alimento_idTipoAlimento` (`idTipoA`),
  KEY `idx_alimento_busqueda` (`idTipoA`,`nombre`,`marca`),
  KEY `idx_alimento_idTipoA_stock_status` (`idTipoA`,`stock`,`status`),
  KEY `idx_alimento_status_stock` (`status`,`stock`),
  KEY `idx_alimento_idTipoA` (`idTipoA`),
  CONSTRAINT `alimento_ibfk_1` FOREIGN KEY (`idTipoA`) REFERENCES `tipoalimento` (`idTipoA`)
) ENGINE=InnoDB AUTO_INCREMENT=152 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alimento`
--

LOCK TABLES `alimento` WRITE;
/*!40000 ALTER TABLE `alimento` DISABLE KEYS */;
INSERT INTO `alimento` VALUES (1,'ZANSIN43','assets/images/alimentos/ZANSIN43.png','Zanahoria','Kl','Sin Marca',0,0,1,1),(2,'LECSIN89','assets/images/alimentos/LECSIN89.png','Lechuga','Kl','Sin Marca',0,0,1,1),(3,'TOMSIN89','assets/images/alimentos/TOMSIN89.png','Tomate','Kl','Sin Marca',0,0,1,1),(4,'CEBSIN59','assets/images/alimentos/CEBSIN59.png','Cebolla','Kl','Sin Marca',0,0,1,1),(5,'BROSIN56','assets/images/alimentos/BROSIN56.png','Brocoli','Kl','Sin Marca',0,0,1,1),(6,'PAPSIN29','assets/images/alimentos/PAPSIN29.png','Papa','Kl','Sin Marca',0,0,1,1),(7,'ACESIN76','assets/images/alimentos/ACESIN76.png','Acelga','Kl','Sin Marca',0,0,1,1),(8,'CALSIN36','assets/images/alimentos/CALSIN36.png','Calabazin','Kl','Sin Marca',0,0,1,1),(9,'BERSIN56','assets/images/alimentos/BERSIN56.png','Berengena','Kl','Sin Marca',0,0,1,1),(10,'PIMSIN48','assets/images/alimentos/PIMSIN48.png','Pimenton','Kl','Sin Marca',0,0,1,1),(11,'APISIN94','assets/images/alimentos/APISIN94.png','Apio','Kl','Sin Marca',0,0,1,1),(12,'PEPSIN64','assets/images/alimentos/PEPSIN64.png','Pepino','Kl','Sin Marca',0,0,1,1),(13,'REMSIN58','assets/images/alimentos/REMSIN58.png','Remolacha','Kl','Sin Marca',0,0,1,1),(14,'COLSIN14','assets/images/alimentos/COLSIN14.png','Coliflor','Kl','Sin Marca',0,0,1,1),(15,'RABSIN25','assets/images/alimentos/RABSIN25.png','Rabano','Kl','Sin Marca',0,0,1,1),(16,'REPSIN32','assets/images/alimentos/REPSIN32.png','Repollo','Kl','Sin Marca',0,0,1,1),(17,'AJISIN26','assets/images/alimentos/AJISIN26.png','Aji Dulce','Kl','Sin Marca',0,0,1,1),(18,'CEBSIN88','assets/images/alimentos/CEBSIN88.png','Cebollin','Kl','Sin Marca',0,0,1,1),(19,'CILSIN88','assets/images/alimentos/CILSIN88.png','Cilantro','Kl','Sin Marca',0,0,1,1),(20,'MANSIN66','assets/images/alimentos/MANSIN66.png','Manzana','Kl','Sin Marca',0,0,2,1),(21,'NARSIN53','assets/images/alimentos/NARSIN53.png','Naranja','Kl','Sin Marca',0,0,2,1),(22,'PLASIN76','assets/images/alimentos/PLASIN76.png','Platano','Kl','Sin Marca',0,0,2,1),(23,'FRESIN33','assets/images/alimentos/FRESIN33.png','Fresa','Kl','Sin Marca',0,0,2,1),(24,'MANSIN79','assets/images/alimentos/MANSIN79.png','Mango','Kl','Sin Marca',0,0,2,1),(25,'UVASIN60','assets/images/alimentos/UVASIN60.png','Uva','Kl','Sin Marca',0,0,2,1),(26,'SANSIN36','assets/images/alimentos/SANSIN36.png','Sandia','Kl','Sin Marca',0,0,2,1),(27,'MELSIN17','assets/images/alimentos/MELSIN17.png','Melon','Kl','Sin Marca',0,0,2,1),(28,'PERSIN17','assets/images/alimentos/PERSIN17.png','Pera','Kl','Sin Marca',0,0,2,1),(29,'PINSIN82','assets/images/alimentos/PINSIN82.png','Piña','Kl','Sin Marca',0,0,2,1),(30,'MANSIN35','assets/images/alimentos/MANSIN35.png','Mandarina','Kl','Sin Marca',0,0,1,1),(31,'KIWSIN87','assets/images/alimentos/KIWSIN87.png','Kiwi','Kl','Sin Marca',0,0,2,1),(32,'LECSIN60','assets/images/alimentos/LECSIN60.png','Lechoza','Kl','Sin Marca',0,0,2,1),(33,'TAMSIN95','assets/images/alimentos/TAMSIN95.png','Tamarindo','Kl','Sin Marca',0,0,1,1),(34,'GUASIN49','assets/images/alimentos/GUASIN49.png','Guayaba','Kl','Sin Marca',0,0,2,1),(35,'CERSIN87','assets/images/alimentos/CERSIN87.png','Cereza','Kl','Sin Marca',0,0,2,1),(36,'DURSIN91','assets/images/alimentos/DURSIN91.png','Durazno','Kl','Sin Marca',0,0,2,1),(37,'GUASIN89','assets/images/alimentos/GUASIN89.png','Guanabana','Kl','Sin Marca',0,0,2,1),(38,'LENSIN94','assets/images/alimentos/LENSIN94.png','Lentejas','Gr','Sin Marca',0,0,4,1),(39,'CARAMA54','assets/images/alimentos/CARAMA54.png','Caraotas Negras','Gr','Amanecer',0,0,4,1),(40,'CARELM89','assets/images/alimentos/CARELM89.png','Caraotas Negras','Gr','El Maizalito',0,0,4,1),(41,'CARMAR75','assets/images/alimentos/CARMAR75.png','Caraotas Blancas','Gr','Mary',0,0,4,1),(42,'CARSIN91','assets/images/alimentos/CARSIN91.png','Caraotas Rojas','Gr','Sin Marca',0,0,4,1),(43,'FRIPAN98','assets/images/alimentos/FRIPAN98.png','Frijoles Bayos','Kl','Pantera',0,0,4,1),(44,'ARVMAR38','assets/images/alimentos/ARVMAR38.png','Arvejas','Gr','Mary',0,0,4,1),(45,'JENSIN78','assets/images/alimentos/JENSIN78.png','Jenjibre','Kl','Sin Marca',0,0,5,1),(46,'NABSIN97','assets/images/alimentos/NABSIN97.png','Nabo','Kl','Sin Marca',0,0,5,1),(47,'NAMSIN19','assets/images/alimentos/NAMSIN19.png','Ñame','Kl','Sin Marca',0,0,5,1),(48,'OCUSIN79','assets/images/alimentos/OCUSIN79.png','Ocumo','Kl','Sin Marca',0,0,5,1),(49,'YUCSIN33','assets/images/alimentos/YUCSIN33.png','Yuca','Kl','Sin Marca',0,0,5,1),(50,'CARSIN94','assets/images/alimentos/CARSIN94.png','Carne De Res','Kl','Sin Marca',0,0,6,1),(51,'CARSIN78','assets/images/alimentos/CARSIN78.png','Carne De Cerdo','Kl','Sin Marca',0,0,6,1),(52,'POLSIN68','assets/images/alimentos/POLSIN68.png','Pollo','Kl','Sin Marca',0,0,6,1),(53,'SALSIN23','assets/images/alimentos/SALSIN23.png','Salchicha De Pollo','Kl','Sin Marca',0,0,6,1),(54,'BISSIN22','assets/images/alimentos/BISSIN22.png','Bistec','Kl','Sin Marca',0,0,6,1),(55,'CHOSIN62','assets/images/alimentos/CHOSIN62.png','Chorizo','Kl','Sin Marca',0,0,6,1),(56,'CHUSIN43','assets/images/alimentos/CHUSIN43.png','Chuleta','Kl','Sin Marca',0,0,1,1),(57,'JAMSIN18','assets/images/alimentos/JAMSIN18.png','Jamon Arepero','Kl','Sin Marca',0,0,6,1),(58,'JAMPLU76','assets/images/alimentos/JAMPLU76.png','Jamon','Kl','Plumrose',0,0,6,1),(59,'JAMALI67','assets/images/alimentos/JAMALI67.png','Jamon','Kl','Alibal',0,0,6,1),(60,'CARSIN90','assets/images/alimentos/CARSIN90.png','Carne Molida','Kl','Sin Marca',0,0,6,1),(61,'MORPLU70','assets/images/alimentos/MORPLU70.png','Mortadela Tapara','Kl','Plumrose',0,0,6,1),(62,'MORPLU97','assets/images/alimentos/MORPLU97.png','Mortadela De Pollo','Kl','Plumrose',0,0,6,1),(63,'PEPSIN85','assets/images/alimentos/PEPSIN85.png','Pepperoni','Kl','Sin Marca',0,0,6,1),(64,'TOCTOL41','assets/images/alimentos/TOCTOL41.png','Tocino','Kl','Toledo',0,0,6,1),(65,'ATUSIN73','assets/images/alimentos/ATUSIN73.png','Atun','Kl','Sin Marca',0,0,7,1),(66,'BACSIN92','assets/images/alimentos/BACSIN92.png','Bacalao','Kl','Sin Marca',0,0,7,1),(67,'MACSIN63','assets/images/alimentos/MACSIN63.png','Macarones','Kl','Sin Marca',0,0,7,1),(68,'CARSIN96','assets/images/alimentos/CARSIN96.png','Carite','Kl','Sin Marca',0,0,7,1),(69,'MEJSIN78','assets/images/alimentos/MEJSIN78.png','Mejillones','Kl','Sin Marca',0,0,7,1),(70,'MERSIN24','assets/images/alimentos/MERSIN70.png','Merluza','Kl','Sin Marca',0,0,7,1),(71,'SALSIN49','assets/images/alimentos/SALSIN49.png','Salmon','Kl','Sin Marca',0,0,7,1),(72,'SARSIN28','assets/images/alimentos/SARSIN28.png','Sardina','Kl','Sin Marca',0,0,7,1),(73,'TRUSIN68','assets/images/alimentos/TRUSIN68.png','Trucha','Kl','Sin Marca',0,0,7,1),(74,'CACSIN34','assets/images/alimentos/CACSIN34.png','Cachama','Kl','Sin Marca',0,0,7,1),(75,'HUESIN83','assets/images/alimentos/HUESIN83.png','Huevo De Gallina','Unidad','Sin Marca',0,0,8,1),(76,'HUESIN14','assets/images/alimentos/HUESIN14.png','Huevo De Codorniz','Kl','Sin Marca',0,0,8,1),(77,'LECPUR67','assets/images/alimentos/LECPUR67.png','Leche Liquida','Lt','Purisima',0,0,9,1),(78,'CRESIN30','assets/images/alimentos/CRESIN30.png','Crema De Leche','Gr','Sin Marca',0,0,9,1),(79,'QUESIN54','assets/images/alimentos/QUESIN54.png','Queso Blanco','Kl','Sin Marca',0,0,9,1),(80,'QUESIN23','assets/images/alimentos/QUESIN23.png','Queso Mozzarella','Kl','Sin Marca',0,0,9,1),(81,'QUESIN93','assets/images/alimentos/QUESIN93.png','Queso Parmesano','Kl','Sin Marca',0,0,9,1),(82,'SUESAN91','assets/images/alimentos/SUESAN91.png','Suero','Lt','San Pedro',0,0,9,1),(83,'YOGMIG23','assets/images/alimentos/YOGMIG23.png','Yogurt','Unidad','Migurt',0,0,9,1),(84,'AGUSIN47','assets/images/alimentos/AGUSIN47.png','Agua Potable','Lt','Sin Marca',0,0,12,1),(85,'REFSIN52','assets/images/alimentos/REFSIN52.png','Refresco Coca Cola','Lt','Sin Marca',0,0,12,1),(86,'JUGVAL45','assets/images/alimentos/JUGVAL45.png','Jugo De Naranja','Lt','Valle',0,0,12,1),(87,'JUGJUS54','assets/images/alimentos/JUGSIN25.png','Jugo De Naranja','Lt','Justy',0,0,12,1),(88,'JUGNAT96','assets/images/alimentos/JUGNAT96.png','Jugo De Manzana','Lt','Natulac',0,0,12,1),(89,'JUGYUK71','assets/images/alimentos/JUGYUK71.png','Jugo De Pera','Lt','Yukeri',0,0,12,1),(90,'MALMAL44','assets/images/alimentos/MALMAL62.png','Malta','Lt','Maltin Polar',0,0,12,1),(91,'REFPEP85','assets/images/alimentos/REFPEP85.png','Refresco','Lt','Pepsi',0,0,12,1),(92,'CURIBE24','assets/images/alimentos/CURIBE24.png','Curry En Polvo','Gr','Iberia',0,0,13,1),(93,'ADOLAC93','assets/images/alimentos/ADOLAC93.png','Adobo','Gr','La Comadre',0,0,13,1),(94,'AJOIBE27','assets/images/alimentos/AJOIBE27.png','Ajo En Polvo','Gr','Iberia',0,0,13,1),(95,'CANIBE87','assets/images/alimentos/CANIBE87.png','Canela En Polvo','Gr','Iberia',0,0,13,1),(96,'COMIBE11','assets/images/alimentos/COMIBE11.png','Comino','Gr','Iberia',0,0,13,1),(97,'MAYKRA18','assets/images/alimentos/MAYKRA18.png','Mayonesa','Gr','Kraft',0,0,13,1),(98,'MOSEUR58','assets/images/alimentos/MOSEUR58.png','Mostaza','Gr','Eureka',0,0,13,1),(99,'OREIBE25','assets/images/alimentos/OREIBE25.png','Oregano','Gr','Iberia',0,0,13,1),(100,'PIMMCC61','assets/images/alimentos/PIMMCC61.png','Pimienta Negra','Gr','Mc Cornick',0,0,13,1),(101,'SALBAH42','assets/images/alimentos/SALBAH42.png','Sal','Kl','Bahia',0,0,13,1),(102,'SALCAP85','assets/images/alimentos/SALCAP85.png','Salsa De Tomate Bologna','Gr','Capri',0,0,13,1),(103,'SALIBE25','assets/images/alimentos/SALIBE19.png','Salsa De Soya','Ml','Iberia',0,0,13,1),(104,'SALHEI15','assets/images/alimentos/SALHEI15.png','Salsa De Tomate','Gr','Heinz',0,0,13,1),(105,'HARPAN21','assets/images/alimentos/HARPAN21.png','Harina De Maiz','Kl','Pan',0,0,14,1),(106,'HARJUA50','assets/images/alimentos/HARJUA50.png','Harina De Maiz','Kl','Juana',0,0,14,1),(107,'ARRMAR18','assets/images/alimentos/ARRMAR18.png','Arroz','Kl','Mary',0,0,14,1),(108,'ARRPRI75','assets/images/alimentos/ARRPRI75.png','Arroz','Kl','Primor',0,0,14,1),(109,'PASLAE34','assets/images/alimentos/PASLAE34.png','Pasta Larga','Kl','La Especial',0,0,14,1),(110,'PASLAE91','assets/images/alimentos/PASLAE91.png','Pasta Corta De Pluma','Kl','La Especial',0,0,14,1),(111,'PASLAE17','assets/images/alimentos/PASLAE17.png','Pasta Corta De Codo','Kl','La Especial',0,0,14,1),(112,'HARROB45','assets/images/alimentos/HARROB45.png','Harina De Trigo','Kl','Robin Hood',0,0,14,1),(113,'HARDON92','assets/images/alimentos/HARDON92.png','Harina De Trigo','Kl','Dona Maria',0,0,14,1),(114,'CHERIK83','assets/images/alimentos/CHERIK83.png','Cheddar','Gr','Rikesa',0,0,14,1),(115,'DIAUND58','assets/images/alimentos/DIAUND58.png','Diablitos','Gr','Under Wood',0,0,14,1),(116,'SARMAR47','assets/images/alimentos/SARMAR47.png','Sardinas En Salsa De Tomate','Gr','Margarita',0,0,14,1),(117,'MANMAV10','assets/images/alimentos/MANMAV10.png','Mantequilla','Gr','Mavesa',0,0,14,1),(118,'ACECOA50','assets/images/alimentos/ACECOA50.png','Aceite De Soja','Lt','Coamo',0,0,10,1),(119,'SARMAR62','assets/images/alimentos/SARMAR62.png','Sardinas En Aceite Vegetal','Gr','Margarita',0,0,14,1),(120,'CAFAMA50','assets/images/alimentos/CAFAMA50.png','Cafe','Gr','Amanecer',0,0,14,1),(121,'ATUWIL27','assets/images/alimentos/ATUWIL27.png','Atun Enlatado','Gr','Willinger',0,0,14,1),(122,'ATUMAR20','assets/images/alimentos/ATUMAR20.png','Atun Enlatado','Gr','Margarita',0,0,14,1),(123,'AVEQUA15','assets/images/alimentos/AVEQUA15.png','Avena','Kl','Quaker',0,0,3,1),(124,'CERZUC53','assets/images/alimentos/CERZUC53.png','Cereal','Gr','Zucaritas',0,0,3,1),(125,'CERFRU60','assets/images/alimentos/CERFRU60.png','Cereal','Gr','Fruty Aros',0,0,3,1),(126,'CERCRO82','assets/images/alimentos/CERCRO82.png','Cereal','Gr','Cronch Flakes',0,0,3,1),(127,'PANSIN23','assets/images/alimentos/PANSIN23.png','Pan Arabe','Unidad','Sin Marca',0,0,3,1),(128,'SANSIN16','assets/images/alimentos/SANSIN16.png','Sandwich','Unidad','Sin Marca',0,0,3,1),(129,'PANSIN27','assets/images/alimentos/PANSIN27.png','Pan Canilla','Unidad','Sin Marca',0,0,3,1),(130,'PANSIN81','assets/images/alimentos/PANSIN81.png','Pan Piñita','Unidad','Sin Marca',0,0,3,1),(131,'PANSIN52','assets/images/alimentos/PANSIN52.png','Pan Sobado','Unidad','Sin Marca',0,0,3,1),(132,'PANSIN45','assets/images/alimentos/PANSIN45.png','Pan Frances','Unidad','Sin Marca',0,0,3,1),(133,'MINSIN62','assets/images/alimentos/MINSIN62.png','Mini Pan De Guayaba','Unidad','Sin Marca',0,0,3,1),(134,'MINSIN13','assets/images/alimentos/MINSIN13.png','Mini Pan De Arequipe','Unidad','Sin Marca',0,0,3,1),(135,'CATSIN38','assets/images/alimentos/CATSIN38.png','Catalina','Unidad','Sin Marca',0,0,3,1),(136,'VINMAV70','assets/images/alimentos/VINMAV70.png','Vinagre Blanco','Lt','Mavesa',0,0,14,1),(137,'MAITIG73','assets/images/alimentos/MAITIG73.png','Maíz En Grano','Gr','Tigo',0,0,14,1),(138,'MERKIE93','assets/images/alimentos/MERKIE93.png','Mermelada De Fresa','Gr','Kiero',0,0,11,1),(139,'CHOTOD11','assets/images/alimentos/CHOTOD11.png','Chocolate En Polvo','Gr','Toddy',0,0,11,1),(140,'GALMAR30','assets/images/alimentos/GALMAR30.png','Galleta De Leche','Unidad','Maria',0,0,11,1),(141,'AZUKON29','assets/images/alimentos/AZUKON29.png','Azucar','Kl','Konfit',0,0,11,1),(142,'CREKAL16','assets/images/alimentos/CREKAL16.png','Crema De Mani','Gr','Kaldint',0,0,11,1),(143,'GALMAR98','assets/images/alimentos/GALMAR98.png','Galleta Con Relleno De Fresa','Unidad','Marilu',0,0,11,1),(144,'GALMAR17','assets/images/alimentos/GALMAR17.png','Galleta Con Relleno De Chocolate','Unidad','Marilu',0,0,11,1),(145,'GALMAR31','assets/images/alimentos/GALMAR31.png','Galleta Con Relleno De Vainilla','Unidad','Marilu',0,0,11,1),(146,'GALCLU12','assets/images/alimentos/GALCLU12.png','Galleta','Unidad','Club Social',0,0,11,1),(147,'MERKIE26','assets/images/alimentos/MERKIE26.png','Mermelada De Guayaba','Gr','Kiero',0,0,11,1),(148,'GALORE14','assets/images/alimentos/GALORE14.png','Galleta De Chocolate','Unidad','Oreo',0,0,11,1),(149,'GELSON83','assets/images/alimentos/GELSON83.png','Gelatina De Limon','Unidad','Sonrissa',0,0,11,1),(150,'GELSON84','assets/images/alimentos/GELSON84.png','Gelatina De Fresa','Unidad','Sonrissa',0,0,11,1),(151,'LECLAL91','assets/images/alimentos/LECLAL91.png','Leche Condensada','Gr','La Lechera Nestle',0,0,11,1);
/*!40000 ALTER TABLE `alimento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asistencia`
--

DROP TABLE IF EXISTS `asistencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asistencia` (
  `idAsistencia` int(11) NOT NULL AUTO_INCREMENT,
  `cedEstudiante` int(11) NOT NULL,
  `fecha` date NOT NULL DEFAULT curdate(),
  `hora` time NOT NULL DEFAULT curtime(),
  `idMenu` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`idAsistencia`),
  KEY `idx_asistencia_idmenu_fecha` (`idMenu`,`fecha`),
  KEY `idx_asistencia_fecha` (`fecha`),
  KEY `idx_asistencia_cedula_fecha` (`cedEstudiante`,`fecha`),
  KEY `idx_asistencia_fecha_cedula` (`fecha`,`cedEstudiante`),
  KEY `idx_asistencia_fecha_idmenu` (`fecha`,`idMenu`),
  CONSTRAINT `asistencia_ibfk_1` FOREIGN KEY (`cedEstudiante`) REFERENCES `estudiante` (`cedEstudiante`),
  CONSTRAINT `asistencia_ibfk_2` FOREIGN KEY (`idMenu`) REFERENCES `menu` (`idMenu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asistencia`
--

LOCK TABLES `asistencia` WRITE;
/*!40000 ALTER TABLE `asistencia` DISABLE KEYS */;
/*!40000 ALTER TABLE `asistencia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalleentradaa`
--

DROP TABLE IF EXISTS `detalleentradaa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detalleentradaa` (
  `idDetalleA` int(11) NOT NULL AUTO_INCREMENT,
  `cantidad` int(11) NOT NULL,
  `idAlimento` int(11) NOT NULL,
  `idEntradaA` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`idDetalleA`),
  KEY `idx_detalleentradaa_idEntradaA` (`idEntradaA`),
  KEY `idx_detalleentradaa_idAlimento` (`idAlimento`),
  KEY `idx_detalleentradaa_idAli` (`idAlimento`),
  CONSTRAINT `detalleentradaa_ibfk_1` FOREIGN KEY (`idAlimento`) REFERENCES `alimento` (`idAlimento`),
  CONSTRAINT `detalleentradaa_ibfk_2` FOREIGN KEY (`idEntradaA`) REFERENCES `entradaalimento` (`idEntradaA`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalleentradaa`
--

LOCK TABLES `detalleentradaa` WRITE;
/*!40000 ALTER TABLE `detalleentradaa` DISABLE KEYS */;
/*!40000 ALTER TABLE `detalleentradaa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalleentradau`
--

DROP TABLE IF EXISTS `detalleentradau`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detalleentradau` (
  `idDetalleU` int(11) NOT NULL AUTO_INCREMENT,
  `cantidad` int(11) NOT NULL,
  `idUtensilios` int(11) NOT NULL,
  `idEntradaU` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`idDetalleU`),
  KEY `idUtensilios` (`idUtensilios`),
  KEY `idEntradaU` (`idEntradaU`),
  CONSTRAINT `detalleentradau_ibfk_1` FOREIGN KEY (`idUtensilios`) REFERENCES `utensilios` (`idUtensilios`),
  CONSTRAINT `detalleentradau_ibfk_2` FOREIGN KEY (`idEntradaU`) REFERENCES `entradau` (`idEntradaU`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalleentradau`
--

LOCK TABLES `detalleentradau` WRITE;
/*!40000 ALTER TABLE `detalleentradau` DISABLE KEYS */;
/*!40000 ALTER TABLE `detalleentradau` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detallesalidaa`
--

DROP TABLE IF EXISTS `detallesalidaa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detallesalidaa` (
  `idDetalleSalidaA` int(11) NOT NULL AUTO_INCREMENT,
  `cantidad` int(11) NOT NULL,
  `idAlimento` int(11) NOT NULL,
  `idSalidaA` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`idDetalleSalidaA`),
  KEY `idx_detallesalidaa_idAlimento_status` (`idAlimento`,`status`),
  KEY `idx_detallesalidaa_idDetalleSalidaA` (`idDetalleSalidaA`),
  KEY `idx_detallesalidaa_idSalidaA_idAlimento` (`idSalidaA`,`idAlimento`),
  CONSTRAINT `detallesalidaa_ibfk_1` FOREIGN KEY (`idAlimento`) REFERENCES `alimento` (`idAlimento`),
  CONSTRAINT `detallesalidaa_ibfk_2` FOREIGN KEY (`idSalidaA`) REFERENCES `salidaalimentos` (`idSalidaA`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detallesalidaa`
--

LOCK TABLES `detallesalidaa` WRITE;
/*!40000 ALTER TABLE `detallesalidaa` DISABLE KEYS */;
/*!40000 ALTER TABLE `detallesalidaa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detallesalidamenu`
--

DROP TABLE IF EXISTS `detallesalidamenu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detallesalidamenu` (
  `idDetalleSalidaMenu` int(11) NOT NULL AUTO_INCREMENT,
  `cantidad` int(11) NOT NULL,
  `idMenu` int(11) NOT NULL,
  `idAlimento` int(11) NOT NULL,
  `idSalidaA` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`idDetalleSalidaMenu`),
  KEY `idMenu` (`idMenu`),
  KEY `idAlimento` (`idAlimento`),
  KEY `idSalidaA` (`idSalidaA`),
  CONSTRAINT `detallesalidamenu_ibfk_1` FOREIGN KEY (`idMenu`) REFERENCES `menu` (`idMenu`),
  CONSTRAINT `detallesalidamenu_ibfk_2` FOREIGN KEY (`idAlimento`) REFERENCES `alimento` (`idAlimento`),
  CONSTRAINT `detallesalidamenu_ibfk_3` FOREIGN KEY (`idSalidaA`) REFERENCES `salidaalimentos` (`idSalidaA`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detallesalidamenu`
--

LOCK TABLES `detallesalidamenu` WRITE;
/*!40000 ALTER TABLE `detallesalidamenu` DISABLE KEYS */;
/*!40000 ALTER TABLE `detallesalidamenu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detallesalidau`
--

DROP TABLE IF EXISTS `detallesalidau`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detallesalidau` (
  `idDetalleSalidaU` int(11) NOT NULL AUTO_INCREMENT,
  `cantidad` int(11) NOT NULL,
  `idUtensilios` int(11) NOT NULL,
  `idSalidaU` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`idDetalleSalidaU`),
  KEY `idUtensilios` (`idUtensilios`),
  KEY `idSalidaU` (`idSalidaU`),
  CONSTRAINT `detallesalidau_ibfk_1` FOREIGN KEY (`idUtensilios`) REFERENCES `utensilios` (`idUtensilios`),
  CONSTRAINT `detallesalidau_ibfk_2` FOREIGN KEY (`idSalidaU`) REFERENCES `salidautensilios` (`idSalidaU`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detallesalidau`
--

LOCK TABLES `detallesalidau` WRITE;
/*!40000 ALTER TABLE `detallesalidau` DISABLE KEYS */;
/*!40000 ALTER TABLE `detallesalidau` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `entradaalimento`
--

DROP TABLE IF EXISTS `entradaalimento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entradaalimento` (
  `idEntradaA` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `hora` time NOT NULL DEFAULT curtime(),
  `descripcion` varchar(300) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`idEntradaA`),
  KEY `idx_entradaalimento_status_fecha` (`status`,`fecha`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entradaalimento`
--

LOCK TABLES `entradaalimento` WRITE;
/*!40000 ALTER TABLE `entradaalimento` DISABLE KEYS */;
/*!40000 ALTER TABLE `entradaalimento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `entradau`
--

DROP TABLE IF EXISTS `entradau`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entradau` (
  `idEntradaU` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `hora` time NOT NULL DEFAULT curtime(),
  `descripcion` varchar(300) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`idEntradaU`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entradau`
--

LOCK TABLES `entradau` WRITE;
/*!40000 ALTER TABLE `entradau` DISABLE KEYS */;
/*!40000 ALTER TABLE `entradau` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estudiante`
--

DROP TABLE IF EXISTS `estudiante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estudiante` (
  `cedEstudiante` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `segNombre` varchar(50) DEFAULT NULL,
  `apellido` varchar(50) NOT NULL,
  `segApellido` varchar(50) DEFAULT NULL,
  `sexo` varchar(1) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `nucleo` varchar(100) NOT NULL,
  `carrera` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`cedEstudiante`),
  KEY `idx_estudiante_cedula` (`cedEstudiante`),
  KEY `idx_estudiante_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estudiante`
--

LOCK TABLES `estudiante` WRITE;
/*!40000 ALTER TABLE `estudiante` DISABLE KEYS */;
/*!40000 ALTER TABLE `estudiante` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estudiante_seccion`
--

DROP TABLE IF EXISTS `estudiante_seccion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estudiante_seccion` (
  `idEstudianteSeccion` int(11) NOT NULL AUTO_INCREMENT,
  `cedEstudiante` int(11) NOT NULL,
  `idSeccion` int(11) NOT NULL,
  PRIMARY KEY (`idEstudianteSeccion`),
  KEY `idx_estudianteSeccion_cedula` (`cedEstudiante`),
  KEY `idx_estudianteSeccion_idSeccion` (`idSeccion`),
  CONSTRAINT `estudiante_seccion_ibfk_1` FOREIGN KEY (`cedEstudiante`) REFERENCES `estudiante` (`cedEstudiante`),
  CONSTRAINT `estudiante_seccion_ibfk_2` FOREIGN KEY (`idSeccion`) REFERENCES `seccion` (`idSeccion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estudiante_seccion`
--

LOCK TABLES `estudiante_seccion` WRITE;
/*!40000 ALTER TABLE `estudiante_seccion` DISABLE KEYS */;
/*!40000 ALTER TABLE `estudiante_seccion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evento`
--

DROP TABLE IF EXISTS `evento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `evento` (
  `idEvento` int(11) NOT NULL AUTO_INCREMENT,
  `nomEvent` varchar(100) NOT NULL,
  `descripEvent` varchar(300) NOT NULL,
  `idMenu` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`idEvento`),
  KEY `idx_evento_idMenu` (`idMenu`),
  CONSTRAINT `evento_ibfk_1` FOREIGN KEY (`idMenu`) REFERENCES `menu` (`idMenu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evento`
--

LOCK TABLES `evento` WRITE;
/*!40000 ALTER TABLE `evento` DISABLE KEYS */;
/*!40000 ALTER TABLE `evento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `excepcion`
--

DROP TABLE IF EXISTS `excepcion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `excepcion` (
  `idExc` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(300) NOT NULL,
  `cedEstudiante` int(11) NOT NULL,
  `fecha` date NOT NULL DEFAULT curdate(),
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`idExc`),
  KEY `cedEstudiante` (`cedEstudiante`),
  CONSTRAINT `excepcion_ibfk_1` FOREIGN KEY (`cedEstudiante`) REFERENCES `estudiante` (`cedEstudiante`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `excepcion`
--

LOCK TABLES `excepcion` WRITE;
/*!40000 ALTER TABLE `excepcion` DISABLE KEYS */;
/*!40000 ALTER TABLE `excepcion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `horario`
--

DROP TABLE IF EXISTS `horario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `horario` (
  `idHorario` int(11) NOT NULL AUTO_INCREMENT,
  `dia` varchar(50) NOT NULL,
  `idSeccion` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`idHorario`),
  KEY `idx_horario_idSeccion` (`idSeccion`),
  KEY `idx_horario_status` (`status`),
  CONSTRAINT `horario_ibfk_1` FOREIGN KEY (`idSeccion`) REFERENCES `seccion` (`idSeccion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `horario`
--

LOCK TABLES `horario` WRITE;
/*!40000 ALTER TABLE `horario` DISABLE KEYS */;
/*!40000 ALTER TABLE `horario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu` (
  `idMenu` int(11) NOT NULL AUTO_INCREMENT,
  `feMenu` date NOT NULL,
  `horarioComida` varchar(50) NOT NULL,
  `cantPlatos` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`idMenu`),
  KEY `idx_menu_fecha_horario` (`feMenu`,`horarioComida`),
  KEY `idx_menu_status` (`status`),
  KEY `idx_menu_fecha_horario_status` (`feMenu`,`horarioComida`,`status`),
  KEY `idx_menu_horario` (`horarioComida`),
  KEY `idx_menufecha_horario` (`feMenu`,`horarioComida`,`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `salidaalimentos`
--

DROP TABLE IF EXISTS `salidaalimentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `salidaalimentos` (
  `idSalidaA` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `hora` time NOT NULL DEFAULT curtime(),
  `descripcion` varchar(300) NOT NULL,
  `idTipoSalidaA` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`idSalidaA`),
  KEY `idx_salidaalimentos_idSalidaA_status` (`idSalidaA`,`status`),
  KEY `idx_salidaalimentos_fecha_status` (`fecha`,`status`),
  KEY `idx_salidaalimentos_tiposalida` (`idTipoSalidaA`),
  CONSTRAINT `salidaalimentos_ibfk_1` FOREIGN KEY (`idTipoSalidaA`) REFERENCES `tiposalidas` (`idTipoSalidas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salidaalimentos`
--

LOCK TABLES `salidaalimentos` WRITE;
/*!40000 ALTER TABLE `salidaalimentos` DISABLE KEYS */;
/*!40000 ALTER TABLE `salidaalimentos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `salidautensilios`
--

DROP TABLE IF EXISTS `salidautensilios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `salidautensilios` (
  `idSalidaU` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `hora` time NOT NULL DEFAULT curtime(),
  `descripcion` varchar(300) NOT NULL,
  `idTipoSalidas` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`idSalidaU`),
  KEY `idTipoSalidas` (`idTipoSalidas`),
  CONSTRAINT `salidautensilios_ibfk_1` FOREIGN KEY (`idTipoSalidas`) REFERENCES `tiposalidas` (`idTipoSalidas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salidautensilios`
--

LOCK TABLES `salidautensilios` WRITE;
/*!40000 ALTER TABLE `salidautensilios` DISABLE KEYS */;
/*!40000 ALTER TABLE `salidautensilios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seccion`
--

DROP TABLE IF EXISTS `seccion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seccion` (
  `idSeccion` int(11) NOT NULL AUTO_INCREMENT,
  `seccion` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`idSeccion`),
  KEY `idx_seccion_idSeccion` (`idSeccion`),
  KEY `idx_seccion_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seccion`
--

LOCK TABLES `seccion` WRITE;
/*!40000 ALTER TABLE `seccion` DISABLE KEYS */;
/*!40000 ALTER TABLE `seccion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipoalimento`
--

DROP TABLE IF EXISTS `tipoalimento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipoalimento` (
  `idTipoA` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`idTipoA`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipoalimento`
--

LOCK TABLES `tipoalimento` WRITE;
/*!40000 ALTER TABLE `tipoalimento` DISABLE KEYS */;
INSERT INTO `tipoalimento` VALUES (1,'Verduras Y Hortalizas',1),(2,'Frutas',1),(3,'Cereales',1),(4,'Legumbres Y Granos Secos',1),(5,'Tubérculos Y Raíces',1),(6,'Carnes',1),(7,'Pescados Y Mariscos',1),(8,'Huevos',1),(9,'Lácteos',1),(10,'Grasas Y Aceites',1),(11,'Azúcares Y Dulces',1),(12,'Bebidas',1),(13,'Condimentos Y Especias',1),(14,'Viveres',1);
/*!40000 ALTER TABLE `tipoalimento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tiposalidas`
--

DROP TABLE IF EXISTS `tiposalidas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tiposalidas` (
  `idTipoSalidas` int(11) NOT NULL AUTO_INCREMENT,
  `tipoSalida` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`idTipoSalidas`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tiposalidas`
--

LOCK TABLES `tiposalidas` WRITE;
/*!40000 ALTER TABLE `tiposalidas` DISABLE KEYS */;
INSERT INTO `tiposalidas` VALUES (1,'Menú',1);
/*!40000 ALTER TABLE `tiposalidas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipoutensilios`
--

DROP TABLE IF EXISTS `tipoutensilios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipoutensilios` (
  `idTipoU` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`idTipoU`),
  KEY `idx_tipoStatus` (`status`,`idTipoU`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipoutensilios`
--

LOCK TABLES `tipoutensilios` WRITE;
/*!40000 ALTER TABLE `tipoutensilios` DISABLE KEYS */;
INSERT INTO `tipoutensilios` VALUES (1,'Bandejas',1);
/*!40000 ALTER TABLE `tipoutensilios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `utensilios`
--

DROP TABLE IF EXISTS `utensilios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `utensilios` (
  `idUtensilios` int(11) NOT NULL AUTO_INCREMENT,
  `imgUtensilios` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `material` varchar(100) NOT NULL,
  `stock` int(11) NOT NULL,
  `idTipoU` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`idUtensilios`),
  KEY `idTipoU` (`idTipoU`),
  CONSTRAINT `utensilios_ibfk_1` FOREIGN KEY (`idTipoU`) REFERENCES `tipoutensilios` (`idTipoU`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utensilios`
--

LOCK TABLES `utensilios` WRITE;
/*!40000 ALTER TABLE `utensilios` DISABLE KEYS */;
/*!40000 ALTER TABLE `utensilios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `vista_alimentos`
--

DROP TABLE IF EXISTS `vista_alimentos`;
/*!50001 DROP VIEW IF EXISTS `vista_alimentos`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `vista_alimentos` AS SELECT
 1 AS `idAlimento`,
  1 AS `codigo`,
  1 AS `imgAlimento`,
  1 AS `nombre`,
  1 AS `unidadMedida`,
  1 AS `marca`,
  1 AS `stock`,
  1 AS `reservado`,
  1 AS `idTipoA`,
  1 AS `status`,
  1 AS `tipo` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vista_alimentos_entrada`
--

DROP TABLE IF EXISTS `vista_alimentos_entrada`;
/*!50001 DROP VIEW IF EXISTS `vista_alimentos_entrada`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `vista_alimentos_entrada` AS SELECT
 1 AS `idEntradaA`,
  1 AS `fecha`,
  1 AS `hora`,
  1 AS `descripcion`,
  1 AS `status`,
  1 AS `idAlimento`,
  1 AS `imgAlimento`,
  1 AS `codigo`,
  1 AS `nombre`,
  1 AS `marca`,
  1 AS `unidadMedida`,
  1 AS `idTipoA`,
  1 AS `tipo`,
  1 AS `cantidad` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vista_detalle_alimentos_evento`
--

DROP TABLE IF EXISTS `vista_detalle_alimentos_evento`;
/*!50001 DROP VIEW IF EXISTS `vista_detalle_alimentos_evento`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `vista_detalle_alimentos_evento` AS SELECT
 1 AS `idAlimento`,
  1 AS `imgAlimento`,
  1 AS `nombre`,
  1 AS `marca`,
  1 AS `unidadMedida`,
  1 AS `cantidad`,
  1 AS `idTipoA`,
  1 AS `tipo`,
  1 AS `idMenu`,
  1 AS `feMenu`,
  1 AS `horarioComida`,
  1 AS `cantPlatos`,
  1 AS `descripcion`,
  1 AS `idSalidaA`,
  1 AS `idEvento`,
  1 AS `nomEvent`,
  1 AS `descripEvent`,
  1 AS `idMenuEvento` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vista_detalle_alimentos_por_menu`
--

DROP TABLE IF EXISTS `vista_detalle_alimentos_por_menu`;
/*!50001 DROP VIEW IF EXISTS `vista_detalle_alimentos_por_menu`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `vista_detalle_alimentos_por_menu` AS SELECT
 1 AS `idAlimento`,
  1 AS `imgAlimento`,
  1 AS `nombre`,
  1 AS `marca`,
  1 AS `unidadMedida`,
  1 AS `cantidad`,
  1 AS `idTipoA`,
  1 AS `tipo`,
  1 AS `idMenu`,
  1 AS `feMenu`,
  1 AS `horarioComida`,
  1 AS `cantPlatos`,
  1 AS `descripcion`,
  1 AS `idSalidaA` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vista_detalle_salida_alimentos`
--

DROP TABLE IF EXISTS `vista_detalle_salida_alimentos`;
/*!50001 DROP VIEW IF EXISTS `vista_detalle_salida_alimentos`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `vista_detalle_salida_alimentos` AS SELECT
 1 AS `idSalidaA`,
  1 AS `fecha`,
  1 AS `hora`,
  1 AS `descripcion`,
  1 AS `tipoSalida`,
  1 AS `idAlimento`,
  1 AS `nombre`,
  1 AS `codigo`,
  1 AS `marca`,
  1 AS `unidadMedida`,
  1 AS `stock`,
  1 AS `imgAlimento`,
  1 AS `idTipoA`,
  1 AS `tipo`,
  1 AS `cantidad`,
  1 AS `statusDetalle` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vista_estudiantes_con_secciones`
--

DROP TABLE IF EXISTS `vista_estudiantes_con_secciones`;
/*!50001 DROP VIEW IF EXISTS `vista_estudiantes_con_secciones`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `vista_estudiantes_con_secciones` AS SELECT
 1 AS `cedEstudiante`,
  1 AS `nombre`,
  1 AS `apellido`,
  1 AS `carrera`,
  1 AS `status`,
  1 AS `seccion` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vista_info_estudiante`
--

DROP TABLE IF EXISTS `vista_info_estudiante`;
/*!50001 DROP VIEW IF EXISTS `vista_info_estudiante`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `vista_info_estudiante` AS SELECT
 1 AS `cedEstudiante`,
  1 AS `nombre`,
  1 AS `segNombre`,
  1 AS `apellido`,
  1 AS `segApellido`,
  1 AS `sexo`,
  1 AS `telefono`,
  1 AS `nucleo`,
  1 AS `carrera`,
  1 AS `status`,
  1 AS `seccion`,
  1 AS `horario` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vista_resumen_general`
--

DROP TABLE IF EXISTS `vista_resumen_general`;
/*!50001 DROP VIEW IF EXISTS `vista_resumen_general`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `vista_resumen_general` AS SELECT
 1 AS `asistencias_hoy`,
  1 AS `menus_activos`,
  1 AS `eventos_activos`,
  1 AS `alimentos_disponibles`,
  1 AS `utensilios_disponibles` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vista_salida_alimentos`
--

DROP TABLE IF EXISTS `vista_salida_alimentos`;
/*!50001 DROP VIEW IF EXISTS `vista_salida_alimentos`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `vista_salida_alimentos` AS SELECT
 1 AS `idSalidaA`,
  1 AS `fecha`,
  1 AS `hora`,
  1 AS `descripcion`,
  1 AS `status`,
  1 AS `idTipoSalidaA`,
  1 AS `tipoSalida` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vista_tipo_alimento_evento`
--

DROP TABLE IF EXISTS `vista_tipo_alimento_evento`;
/*!50001 DROP VIEW IF EXISTS `vista_tipo_alimento_evento`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `vista_tipo_alimento_evento` AS SELECT
 1 AS `idTipoA`,
  1 AS `tipo`,
  1 AS `nomEvent`,
  1 AS `idEvento`,
  1 AS `idMenu`,
  1 AS `feMenu`,
  1 AS `horarioComida` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vista_tipo_alimentos_por_menu`
--

DROP TABLE IF EXISTS `vista_tipo_alimentos_por_menu`;
/*!50001 DROP VIEW IF EXISTS `vista_tipo_alimentos_por_menu`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `vista_tipo_alimentos_por_menu` AS SELECT
 1 AS `idTipoA`,
  1 AS `tipo`,
  1 AS `idMenu`,
  1 AS `feMenu`,
  1 AS `horarioComida` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vista_tipos_utensilios_activos`
--

DROP TABLE IF EXISTS `vista_tipos_utensilios_activos`;
/*!50001 DROP VIEW IF EXISTS `vista_tipos_utensilios_activos`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `vista_tipos_utensilios_activos` AS SELECT
 1 AS `idTipoU`,
  1 AS `tipo`,
  1 AS `status` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vistatiposalimentosconstock`
--

DROP TABLE IF EXISTS `vistatiposalimentosconstock`;
/*!50001 DROP VIEW IF EXISTS `vistatiposalimentosconstock`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `vistatiposalimentosconstock` AS SELECT
 1 AS `idTipoA`,
  1 AS `tipo` */;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `vista_alimentos`
--

/*!50001 DROP VIEW IF EXISTS `vista_alimentos`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vista_alimentos` AS select `a`.`idAlimento` AS `idAlimento`,`a`.`codigo` AS `codigo`,`a`.`imgAlimento` AS `imgAlimento`,`a`.`nombre` AS `nombre`,`a`.`unidadMedida` AS `unidadMedida`,`a`.`marca` AS `marca`,`a`.`stock` AS `stock`,`a`.`reservado` AS `reservado`,`a`.`idTipoA` AS `idTipoA`,`a`.`status` AS `status`,`ta`.`tipo` AS `tipo` from (`alimento` `a` join `tipoalimento` `ta` on(`a`.`idTipoA` = `ta`.`idTipoA`)) where `a`.`status` = 1 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vista_alimentos_entrada`
--

/*!50001 DROP VIEW IF EXISTS `vista_alimentos_entrada`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vista_alimentos_entrada` AS select `ea`.`idEntradaA` AS `idEntradaA`,`ea`.`fecha` AS `fecha`,`ea`.`hora` AS `hora`,`ea`.`descripcion` AS `descripcion`,`ea`.`status` AS `status`,`a`.`idAlimento` AS `idAlimento`,`a`.`imgAlimento` AS `imgAlimento`,`a`.`codigo` AS `codigo`,`a`.`nombre` AS `nombre`,`a`.`marca` AS `marca`,`a`.`unidadMedida` AS `unidadMedida`,`ta`.`idTipoA` AS `idTipoA`,`ta`.`tipo` AS `tipo`,`dea`.`cantidad` AS `cantidad` from (((`entradaalimento` `ea` join `detalleentradaa` `dea` on(`dea`.`idEntradaA` = `ea`.`idEntradaA`)) join `alimento` `a` on(`a`.`idAlimento` = `dea`.`idAlimento`)) join `tipoalimento` `ta` on(`a`.`idTipoA` = `ta`.`idTipoA`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vista_detalle_alimentos_evento`
--

/*!50001 DROP VIEW IF EXISTS `vista_detalle_alimentos_evento`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vista_detalle_alimentos_evento` AS select `a`.`idAlimento` AS `idAlimento`,`a`.`imgAlimento` AS `imgAlimento`,`a`.`nombre` AS `nombre`,`a`.`marca` AS `marca`,`a`.`unidadMedida` AS `unidadMedida`,`dsm`.`cantidad` AS `cantidad`,`ta`.`idTipoA` AS `idTipoA`,`ta`.`tipo` AS `tipo`,`m`.`idMenu` AS `idMenu`,`m`.`feMenu` AS `feMenu`,`m`.`horarioComida` AS `horarioComida`,`m`.`cantPlatos` AS `cantPlatos`,`sa`.`descripcion` AS `descripcion`,`sa`.`idSalidaA` AS `idSalidaA`,`e`.`idEvento` AS `idEvento`,`e`.`nomEvent` AS `nomEvent`,`e`.`descripEvent` AS `descripEvent`,`e`.`idMenu` AS `idMenuEvento` from (((((`evento` `e` join `menu` `m` on(`e`.`idMenu` = `m`.`idMenu` and `m`.`status` = 1)) join `detallesalidamenu` `dsm` on(`dsm`.`idMenu` = `m`.`idMenu` and `dsm`.`status` = 1)) join `salidaalimentos` `sa` on(`sa`.`idSalidaA` = `dsm`.`idSalidaA` and `sa`.`status` = 1)) join `alimento` `a` on(`a`.`idAlimento` = `dsm`.`idAlimento` and `a`.`status` = 1)) join `tipoalimento` `ta` on(`a`.`idTipoA` = `ta`.`idTipoA` and `ta`.`status` = 1)) where `e`.`status` = 1 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vista_detalle_alimentos_por_menu`
--

/*!50001 DROP VIEW IF EXISTS `vista_detalle_alimentos_por_menu`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vista_detalle_alimentos_por_menu` AS select `a`.`idAlimento` AS `idAlimento`,`a`.`imgAlimento` AS `imgAlimento`,`a`.`nombre` AS `nombre`,`a`.`marca` AS `marca`,`a`.`unidadMedida` AS `unidadMedida`,`dsm`.`cantidad` AS `cantidad`,`ta`.`idTipoA` AS `idTipoA`,`ta`.`tipo` AS `tipo`,`m`.`idMenu` AS `idMenu`,`m`.`feMenu` AS `feMenu`,`m`.`horarioComida` AS `horarioComida`,`m`.`cantPlatos` AS `cantPlatos`,`sa`.`descripcion` AS `descripcion`,`sa`.`idSalidaA` AS `idSalidaA` from ((((`salidaalimentos` `sa` join `detallesalidamenu` `dsm` on(`dsm`.`idSalidaA` = `sa`.`idSalidaA`)) join `alimento` `a` on(`a`.`idAlimento` = `dsm`.`idAlimento`)) join `tipoalimento` `ta` on(`a`.`idTipoA` = `ta`.`idTipoA`)) join `menu` `m` on(`m`.`idMenu` = `dsm`.`idMenu`)) where `m`.`status` = 1 and `sa`.`status` = 1 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vista_detalle_salida_alimentos`
--

/*!50001 DROP VIEW IF EXISTS `vista_detalle_salida_alimentos`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vista_detalle_salida_alimentos` AS select `sa`.`idSalidaA` AS `idSalidaA`,`sa`.`fecha` AS `fecha`,`sa`.`hora` AS `hora`,`sa`.`descripcion` AS `descripcion`,`ts`.`tipoSalida` AS `tipoSalida`,`a`.`idAlimento` AS `idAlimento`,`a`.`nombre` AS `nombre`,`a`.`codigo` AS `codigo`,`a`.`marca` AS `marca`,`a`.`unidadMedida` AS `unidadMedida`,`a`.`stock` AS `stock`,`a`.`imgAlimento` AS `imgAlimento`,`ta`.`idTipoA` AS `idTipoA`,`ta`.`tipo` AS `tipo`,`dsa`.`cantidad` AS `cantidad`,`dsa`.`status` AS `statusDetalle` from ((((`salidaalimentos` `sa` join `tiposalidas` `ts` on(`ts`.`idTipoSalidas` = `sa`.`idTipoSalidaA`)) join `detallesalidaa` `dsa` on(`dsa`.`idSalidaA` = `sa`.`idSalidaA`)) join `alimento` `a` on(`a`.`idAlimento` = `dsa`.`idAlimento`)) join `tipoalimento` `ta` on(`a`.`idTipoA` = `ta`.`idTipoA`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vista_estudiantes_con_secciones`
--

/*!50001 DROP VIEW IF EXISTS `vista_estudiantes_con_secciones`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vista_estudiantes_con_secciones` AS select `e`.`cedEstudiante` AS `cedEstudiante`,`e`.`nombre` AS `nombre`,`e`.`apellido` AS `apellido`,`e`.`carrera` AS `carrera`,`e`.`status` AS `status`,group_concat(`s`.`seccion` order by `s`.`seccion` ASC separator ', ') AS `seccion` from ((`estudiante` `e` join `estudiante_seccion` `es` on(`e`.`cedEstudiante` = `es`.`cedEstudiante`)) join `seccion` `s` on(`es`.`idSeccion` = `s`.`idSeccion`)) where `e`.`status` = 1 and `s`.`status` = 1 group by `e`.`cedEstudiante` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vista_info_estudiante`
--

/*!50001 DROP VIEW IF EXISTS `vista_info_estudiante`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vista_info_estudiante` AS select `e`.`cedEstudiante` AS `cedEstudiante`,`e`.`nombre` AS `nombre`,`e`.`segNombre` AS `segNombre`,`e`.`apellido` AS `apellido`,`e`.`segApellido` AS `segApellido`,`e`.`sexo` AS `sexo`,`e`.`telefono` AS `telefono`,`e`.`nucleo` AS `nucleo`,`e`.`carrera` AS `carrera`,`e`.`status` AS `status`,group_concat(distinct `s`.`seccion` order by `s`.`seccion` ASC separator ', ') AS `seccion`,group_concat(distinct `h`.`dia` order by field(`h`.`dia`,'Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo') ASC separator ', ') AS `horario` from (((`estudiante` `e` join `estudiante_seccion` `es` on(`e`.`cedEstudiante` = `es`.`cedEstudiante`)) join `seccion` `s` on(`es`.`idSeccion` = `s`.`idSeccion`)) join `horario` `h` on(`s`.`idSeccion` = `h`.`idSeccion`)) where `e`.`status` = 1 and `s`.`status` = 1 and `h`.`status` = 1 group by `e`.`cedEstudiante`,`e`.`nombre`,`e`.`segNombre`,`e`.`apellido`,`e`.`segApellido`,`e`.`sexo`,`e`.`telefono`,`e`.`nucleo`,`e`.`carrera`,`e`.`status` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vista_resumen_general`
--

/*!50001 DROP VIEW IF EXISTS `vista_resumen_general`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vista_resumen_general` AS select (select count(`a`.`idAsistencia`) from (`asistencia` `a` join `menu` `m` on(`a`.`idMenu` = `m`.`idMenu`)) where `a`.`status` = 1 and `a`.`fecha` = curdate()) AS `asistencias_hoy`,(select count(`menu`.`idMenu`) from `menu` where `menu`.`status` = 1) AS `menus_activos`,(select count(`e`.`idEvento`) from (`evento` `e` join `menu` `m` on(`e`.`idMenu` = `m`.`idMenu`)) where `e`.`status` = 1) AS `eventos_activos`,(select count(0) from `alimento` where `alimento`.`status` = 1 and (`alimento`.`stock` > 0 or `alimento`.`reservado` > 0)) AS `alimentos_disponibles`,(select count(0) from `utensilios` where `utensilios`.`status` = 1 and `utensilios`.`stock` > 0) AS `utensilios_disponibles` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vista_salida_alimentos`
--

/*!50001 DROP VIEW IF EXISTS `vista_salida_alimentos`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vista_salida_alimentos` AS select `sa`.`idSalidaA` AS `idSalidaA`,`sa`.`fecha` AS `fecha`,`sa`.`hora` AS `hora`,`sa`.`descripcion` AS `descripcion`,`sa`.`status` AS `status`,`sa`.`idTipoSalidaA` AS `idTipoSalidaA`,`ts`.`tipoSalida` AS `tipoSalida` from (`salidaalimentos` `sa` join `tiposalidas` `ts` on(`ts`.`idTipoSalidas` = `sa`.`idTipoSalidaA`)) where `ts`.`tipoSalida` <> 'Menú' and `sa`.`status` = 1 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vista_tipo_alimento_evento`
--

/*!50001 DROP VIEW IF EXISTS `vista_tipo_alimento_evento`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vista_tipo_alimento_evento` AS select distinct `ta`.`idTipoA` AS `idTipoA`,`ta`.`tipo` AS `tipo`,`e`.`nomEvent` AS `nomEvent`,`e`.`idEvento` AS `idEvento`,`e`.`idMenu` AS `idMenu`,`m`.`feMenu` AS `feMenu`,`m`.`horarioComida` AS `horarioComida` from (((((`evento` `e` join `menu` `m` on(`m`.`idMenu` = `e`.`idMenu` and `m`.`status` = 1)) left join `detallesalidamenu` `dsm` on(`dsm`.`idMenu` = `m`.`idMenu` and `dsm`.`status` = 1)) left join `salidaalimentos` `sa` on(`sa`.`idSalidaA` = `dsm`.`idSalidaA` and `sa`.`status` = 1)) left join `alimento` `a` on(`a`.`idAlimento` = `dsm`.`idAlimento` and `a`.`status` = 1)) left join `tipoalimento` `ta` on(`a`.`idTipoA` = `ta`.`idTipoA` and `ta`.`status` = 1)) where `e`.`status` = 1 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vista_tipo_alimentos_por_menu`
--

/*!50001 DROP VIEW IF EXISTS `vista_tipo_alimentos_por_menu`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vista_tipo_alimentos_por_menu` AS select `ta`.`idTipoA` AS `idTipoA`,`ta`.`tipo` AS `tipo`,`m`.`idMenu` AS `idMenu`,`m`.`feMenu` AS `feMenu`,`m`.`horarioComida` AS `horarioComida` from (((`detallesalidamenu` `dsm` join `alimento` `a` on(`a`.`idAlimento` = `dsm`.`idAlimento`)) join `tipoalimento` `ta` on(`a`.`idTipoA` = `ta`.`idTipoA`)) join `menu` `m` on(`m`.`idMenu` = `dsm`.`idMenu`)) group by `ta`.`idTipoA`,`ta`.`tipo`,`m`.`idMenu`,`m`.`feMenu`,`m`.`horarioComida` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vista_tipos_utensilios_activos`
--

/*!50001 DROP VIEW IF EXISTS `vista_tipos_utensilios_activos`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vista_tipos_utensilios_activos` AS select `tipoutensilios`.`idTipoU` AS `idTipoU`,`tipoutensilios`.`tipo` AS `tipo`,`tipoutensilios`.`status` AS `status` from `tipoutensilios` where `tipoutensilios`.`status` <> 0 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vistatiposalimentosconstock`
--

/*!50001 DROP VIEW IF EXISTS `vistatiposalimentosconstock`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vistatiposalimentosconstock` AS select distinct `ta`.`idTipoA` AS `idTipoA`,`ta`.`tipo` AS `tipo` from (`tipoalimento` `ta` join `alimento` `a` on(`ta`.`idTipoA` = `a`.`idTipoA`)) where `a`.`idAlimento` in (select `detalleentradaa`.`idAlimento` from `detalleentradaa` where `detalleentradaa`.`status` = 1 and `a`.`stock` > 0) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-08-14 22:37:42
