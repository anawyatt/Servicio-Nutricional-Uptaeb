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
) ENGINE=InnoDB AUTO_INCREMENT=154 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alimento`
--

LOCK TABLES `alimento` WRITE;
/*!40000 ALTER TABLE `alimento` DISABLE KEYS */;
INSERT INTO `alimento` VALUES (1,'ZANSIN43','assets/images/alimentos/ZANSIN43.png','Zanahoria','Kg','Sin Marca',4300,0,1,1),(2,'LECSIN89','assets/images/alimentos/LECSIN89.png','Lechuga','Kg','Sin Marca',2900,0,1,1),(3,'TOMSIN89','assets/images/alimentos/TOMSIN89.png','Tomate','Kg','Sin Marca',10380,0,1,1),(4,'CEBSIN59','assets/images/alimentos/CEBSIN59.png','Cebolla','Kg','Sin Marca',3650,0,1,1),(5,'BROSIN56','assets/images/alimentos/BROSIN56.png','Brocoli','Kg','Sin Marca',980,0,1,1),(6,'PAPSIN29','assets/images/alimentos/PAPSIN29.png','Papa','Kg','Sin Marca',4650,0,1,1),(7,'ACESIN76','assets/images/alimentos/ACESIN76.png','Acelga','Kg','Sin Marca',800,0,1,1),(8,'CALSIN36','assets/images/alimentos/CALSIN36.png','Calabazin','Kg','Sin Marca',3800,0,1,1),(9,'BERSIN56','assets/images/alimentos/BERSIN56.png','Berengena','Kg','Sin Marca',4400,0,1,1),(10,'PIMSIN48','assets/images/alimentos/PIMSIN48.png','Pimenton','Kg','Sin Marca',900,0,1,1),(11,'APISIN94','assets/images/alimentos/APISIN94.png','Apio','Kg','Sin Marca',500,0,1,1),(12,'PEPSIN64','assets/images/alimentos/PEPSIN64.png','Pepino','Kg','Sin Marca',3100,0,1,1),(13,'REMSIN58','assets/images/alimentos/REMSIN58.png','Remolacha','Kg','Sin Marca',300,0,1,1),(14,'COLSIN14','assets/images/alimentos/COLSIN14.png','Coliflor','Kg','Sin Marca',800,0,1,1),(15,'RABSIN25','assets/images/alimentos/RABSIN25.png','Rabano','Kg','Sin Marca',500,0,1,1),(16,'REPSIN32','assets/images/alimentos/REPSIN32.png','Repollo','Kg','Sin Marca',1100,0,1,1),(17,'AJISIN26','assets/images/alimentos/AJISIN26.png','Aji Dulce','Kg','Sin Marca',1900,0,1,1),(18,'CEBSIN88','assets/images/alimentos/CEBSIN88.png','Cebollin','Kg','Sin Marca',2298,0,1,1),(19,'CILSIN88','assets/images/alimentos/CILSIN88.png','Cilantro','Kg','Sin Marca',1997,0,1,1),(20,'MANSIN66','assets/images/alimentos/MANSIN66.png','Manzana','Kg','Sin Marca',4200,0,2,1),(21,'NARSIN53','assets/images/alimentos/NARSIN53.png','Naranja','Kg','Sin Marca',3800,0,2,1),(22,'PLASIN76','assets/images/alimentos/PLASIN76.png','Platano','Kg','Sin Marca',6200,0,2,1),(23,'FRESIN33','assets/images/alimentos/FRESIN33.png','Fresa','Kg','Sin Marca',1080,0,2,1),(24,'MANSIN79','assets/images/alimentos/MANSIN79.png','Mango','Kg','Sin Marca',3800,0,2,1),(25,'UVASIN60','assets/images/alimentos/UVASIN60.png','Uva','Kg','Sin Marca',600,0,2,1),(26,'SANSIN36','assets/images/alimentos/SANSIN36.png','Sandia','Kg','Sin Marca',1400,0,2,1),(27,'MELSIN17','assets/images/alimentos/MELSIN17.png','Melon','Kg','Sin Marca',1900,0,2,1),(28,'PERSIN17','assets/images/alimentos/PERSIN17.png','Pera','Kg','Sin Marca',600,0,2,1),(29,'PINSIN82','assets/images/alimentos/PINSIN82.png','Piña','Kg','Sin Marca',1800,0,2,1),(30,'MANSIN56','assets/images/alimentos/MANSIN35.png','Mandarina','Kg','Sin Marca',1800,0,2,1),(31,'KIWSIN87','assets/images/alimentos/KIWSIN87.png','Kiwi','Kg','Sin Marca',0,0,2,1),(32,'LECSIN60','assets/images/alimentos/LECSIN60.png','Lechoza','Kg','Sin Marca',2600,0,2,1),(33,'TAMSIN37','assets/images/alimentos/TAMSIN95.png','Tamarindo','Kg','Sin Marca',4200,0,2,1),(34,'GUASIN49','assets/images/alimentos/GUASIN49.png','Guayaba','Kg','Sin Marca',2400,0,2,1),(35,'CERSIN87','assets/images/alimentos/CERSIN87.png','Cereza','Kg','Sin Marca',5200,0,2,1),(36,'DURSIN91','assets/images/alimentos/DURSIN91.png','Durazno','Kg','Sin Marca',3700,0,2,1),(37,'GUASIN89','assets/images/alimentos/GUASIN89.png','Guanabana','Kg','Sin Marca',1500,0,2,1),(38,'LENSIN94','assets/images/alimentos/LENSIN94.png','Lentejas','500 Gr','El Maizalito',2100,0,4,1),(39,'CARAMA54','assets/images/alimentos/CARAMA54.png','Caraotas Negras','400 Gr','Amanecer',1900,0,4,1),(40,'CARELM89','assets/images/alimentos/CARELM89.png','Caraotas Negras','500 Gr','El Maizalito',700,0,4,1),(41,'CARMAR75','assets/images/alimentos/CARMAR75.png','Caraotas Blancas','500 Gr','Mary',1200,0,4,1),(42,'CARSIN91','assets/images/alimentos/CARSIN91.png','Caraotas Rojas','500 Gr','Mary',4400,0,4,1),(43,'FRIPAN98','assets/images/alimentos/FRIPAN98.png','Frijoles Bayos','1 Kg','Pantera',600,0,4,1),(44,'ARVMAR38','assets/images/alimentos/ARVMAR38.png','Arvejas','500 Gr','Mary',2500,0,4,1),(45,'JENSIN78','assets/images/alimentos/JENSIN78.png','Jenjibre','Kg','Sin Marca',200,0,5,1),(46,'NABSIN97','assets/images/alimentos/NABSIN97.png','Nabo','Kg','Sin Marca',800,0,5,1),(47,'NAMSIN19','assets/images/alimentos/NAMSIN19.png','Ñame','Kg','Sin Marca',500,0,5,1),(48,'OCUSIN79','assets/images/alimentos/OCUSIN79.png','Ocumo','Kg','Sin Marca',1100,0,5,1),(49,'YUCSIN33','assets/images/alimentos/YUCSIN33.png','Yuca','Kg','Sin Marca',1900,0,5,1),(50,'CARSIN94','assets/images/alimentos/CARSIN94.png','Carne De Res','Kg','Sin Marca',7600,0,6,1),(51,'CARSIN78','assets/images/alimentos/CARSIN78.png','Carne De Cerdo','Kg','Sin Marca',6734,0,6,1),(52,'POLSIN68','assets/images/alimentos/POLSIN68.png','Pollo','Kg','Sin Marca',9700,0,6,1),(53,'SALSIN23','assets/images/alimentos/SALSIN23.png','Salchicha De Pollo','Kg','Sin Marca',2000,0,6,1),(54,'BISSIN22','assets/images/alimentos/BISSIN22.png','Bistec','Kg','Sin Marca',1700,0,6,1),(55,'CHOSIN62','assets/images/alimentos/CHOSIN62.png','Chorizo','Kg','Sin Marca',2980,0,6,1),(56,'CHUSIN22','assets/images/alimentos/CHUSIN43.png','Chuleta','Kg','Sin Marca',4200,0,6,1),(57,'JAMSIN18','assets/images/alimentos/JAMSIN18.png','Jamon Arepero','Kg','Sin Marca',1800,0,6,1),(58,'JAMPLU76','assets/images/alimentos/JAMPLU76.png','Jamon','7 Kg','Plumrose',900,0,6,1),(59,'JAMALI67','assets/images/alimentos/JAMALI67.png','Jamon','250 Gr','Alibal',1200,0,6,1),(60,'CARSIN90','assets/images/alimentos/CARSIN90.png','Carne Molida','Kg','Sin Marca',3000,0,6,1),(61,'MORPLU70','assets/images/alimentos/MORPLU70.png','Mortadela Tapara','7 Kl','Plumrose',1000,0,6,1),(62,'MORPLU97','assets/images/alimentos/MORPLU97.png','Mortadela De Pollo','1 kg','Plumrose',2000,0,6,1),(63,'PEPSIN85','assets/images/alimentos/PEPSIN85.png','Pepperoni','Kg','Sin Marca',600,0,6,1),(64,'TOCTOL41','assets/images/alimentos/TOCTOL41.png','Tocino','172 Gr','Toledo',1500,0,6,1),(65,'ATUSIN73','assets/images/alimentos/ATUSIN73.png','Atun','Kg','Sin Marca',2200,0,7,1),(66,'BACSIN92','assets/images/alimentos/BACSIN92.png','Bacalao','Kg','Sin Marca',1400,0,7,1),(67,'MACSIN63','assets/images/alimentos/MACSIN63.png','Macarones','Kg','Sin Marca',4500,0,7,1),(68,'CARSIN96','assets/images/alimentos/CARSIN96.png','Carite','Kg','Sin Marca',1200,0,7,1),(69,'MEJSIN78','assets/images/alimentos/MEJSIN78.png','Mejillones','Kg','Sin Marca',1800,0,7,1),(70,'MERSIN24','assets/images/alimentos/MERSIN70.png','Merluza','Kg','Sin Marca',600,0,7,1),(71,'SALSIN49','assets/images/alimentos/SALSIN49.png','Salmon','Kg','Sin Marca',2200,0,7,1),(72,'SARSIN28','assets/images/alimentos/SARSIN28.png','Sardina','Kg','Sin Marca',2000,0,7,1),(73,'TRUSIN68','assets/images/alimentos/TRUSIN68.png','Trucha','Kg','Sin Marca',1700,0,7,1),(74,'CACSIN34','assets/images/alimentos/CACSIN34.png','Cachama','Kg','Sin Marca',2000,0,7,1),(75,'HUESIN83','assets/images/alimentos/HUESIN83.png','Huevo De Gallina','Unidad','Sin Marca',31370,0,8,1),(76,'HUESIN14','assets/images/alimentos/HUESIN14.png','Huevo De Codorniz','Unidad','Sin Marca',7400,0,8,1),(77,'LECPUR67','assets/images/alimentos/LECPUR67.png','Leche Liquida','1 Lt','Purisima',7200,0,9,1),(78,'CRESIN30','assets/images/alimentos/CRESIN30.png','Crema De Leche','500 Gr','La Baragueña',6600,0,9,1),(79,'QUESIN54','assets/images/alimentos/QUESIN54.png','Queso Blanco','Kg','Sin Marca',4800,0,9,1),(80,'QUESIN23','assets/images/alimentos/QUESIN23.png','Queso Mozzarella','Kg','Sin Marca',2600,0,9,1),(81,'QUESIN93','assets/images/alimentos/QUESIN93.png','Queso Parmesano','Kg','Sin Marca',1900,0,9,1),(82,'SUESAN91','assets/images/alimentos/SUESAN91.png','Suero','1 Lt','San Pedro',6000,0,9,1),(83,'YOGMIG23','assets/images/alimentos/YOGMIG23.png','Yogurt','125 Gr','Migurt',11200,0,9,1),(84,'AGUSIN47','assets/images/alimentos/AGUSIN47.png','Agua Potable','7 Lt','Sin Marca',6070,0,12,1),(85,'REFSIN52','assets/images/alimentos/REFSIN52.png','Refresco ','2 Lt','Coca Cola',2983,0,12,1),(86,'JUGVAL45','assets/images/alimentos/JUGVAL45.png','Jugo De Naranja','1.5 Lt','Valle',7000,0,12,1),(87,'JUGJUS54','assets/images/alimentos/JUGSIN25.png','Jugo De Naranja','1.5 Lt','Justy',2200,0,12,1),(88,'JUGNAT96','assets/images/alimentos/JUGNAT96.png','Jugo De Manzana','1.5 Lt','Natulac',8100,0,12,1),(89,'JUGYUK71','assets/images/alimentos/JUGYUK71.png','Jugo De Pera','1.5 Lt','Yukeri',5000,0,12,1),(90,'MALMAL44','assets/images/alimentos/MALMAL62.png','Malta','1.5 Lt','Maltin Polar',2100,0,12,1),(91,'REFPEP85','assets/images/alimentos/REFPEP85.png','Refresco','2 Lt','Pepsi',2400,0,12,1),(92,'CURIBE24','assets/images/alimentos/CURIBE24.png','Curry En Polvo','70 Gr','Iberia',160,0,13,1),(93,'ADOLAC93','assets/images/alimentos/ADOLAC93.png','Adobo','200 Gr','La Comadre',400,0,13,1),(94,'AJOIBE27','assets/images/alimentos/AJOIBE27.png','Ajo En Polvo','90 Gr','Iberia',572,0,13,1),(95,'CANIBE87','assets/images/alimentos/CANIBE87.png','Canela En Polvo','75 Gr','Iberia',100,0,13,1),(96,'COMIBE11','assets/images/alimentos/COMIBE11.png','Comino','56 Gr','Iberia',300,0,13,1),(97,'MAYKRA18','assets/images/alimentos/MAYKRA18.png','Mayonesa','445 Gr','Kraft',2500,0,13,1),(98,'MOSEUR58','assets/images/alimentos/MOSEUR58.png','Mostaza','285 Gr','Eureka',1850,0,13,1),(99,'OREIBE25','assets/images/alimentos/OREIBE25.png','Oregano','50 Gr','Iberia',1200,0,13,1),(100,'PIMMCC61','assets/images/alimentos/PIMMCC61.png','Pimienta Negra','53 Gr','Mc Cornick',1100,0,13,1),(101,'SALBAH42','assets/images/alimentos/SALBAH42.png','Sal','1 Kg','Bahia',1700,0,13,1),(102,'SALCAP85','assets/images/alimentos/SALCAP85.png','Salsa De Tomate Bologna','490 Gr','Capri',3300,0,13,1),(103,'SALIBE25','assets/images/alimentos/SALIBE19.png','Salsa De Soya','300 Ml','Iberia',2500,0,13,1),(104,'SALHEI15','assets/images/alimentos/SALHEI15.png','Salsa De Tomate','397 Gr','Heinz',4300,0,13,1),(105,'HARPAN21','assets/images/alimentos/HARPAN21.png','Harina De Maiz','1 Kg','Pan',7100,0,14,1),(106,'HARJUA50','assets/images/alimentos/HARJUA50.png','Harina De Maiz','1 Kg','Juana',11700,0,14,1),(107,'ARRMAR18','assets/images/alimentos/ARRMAR18.png','Arroz','1 Kg','Mary',8800,0,14,1),(108,'ARRPRI75','assets/images/alimentos/ARRPRI75.png','Arroz','1 Kg','Primor',3600,0,14,1),(109,'PASLAE34','assets/images/alimentos/PASLAE34.png','Pasta Larga','1 Kg','La Especial',5350,0,14,1),(110,'PASLAE91','assets/images/alimentos/PASLAE91.png','Pasta Corta De Pluma','1 Kg','La Especial',6600,0,14,1),(111,'PASLAE17','assets/images/alimentos/PASLAE17.png','Pasta Corta De Codo','1 Kg','La Especial',4000,0,14,1),(112,'HARROB45','assets/images/alimentos/HARROB45.png','Harina De Trigo','1 Kg','Robin Hood',6400,0,14,1),(113,'HARDON92','assets/images/alimentos/HARDON92.png','Harina De Trigo','1 Kg','Dona Maria',2400,0,14,1),(114,'CHERIK83','assets/images/alimentos/CHERIK83.png','Cheddar','300 Gr','Rikesa',3400,0,14,1),(115,'DIAUND58','assets/images/alimentos/DIAUND58.png','Diablitos','115 Gr','Under Wood',4100,0,14,1),(116,'SARMAR47','assets/images/alimentos/SARMAR47.png','Sardinas En Salsa De Tomate','170 Gr','Margarita',1300,0,14,1),(117,'MANMAV10','assets/images/alimentos/MANMAV10.png','Mantequilla','1 Kg','Mavesa',1900,0,14,1),(118,'ACECOA50','assets/images/alimentos/ACECOA50.png','Aceite De Soja','900 Ml','Coamo',4210,0,10,1),(119,'SARMAR62','assets/images/alimentos/SARMAR62.png','Sardinas En Aceite Vegetal','170 Gr','Margarita',1300,0,14,1),(120,'CAFAMA50','assets/images/alimentos/CAFAMA50.png','Cafe','500 Gr','Amanecer',500,0,14,1),(121,'ATUWIL27','assets/images/alimentos/ATUWIL27.png','Atun Enlatado','170 Gr','Willinger',2000,0,14,1),(122,'ATUMAR20','assets/images/alimentos/ATUMAR20.png','Atun Enlatado','140 Gr','Margarita',3285,0,14,1),(123,'AVEQUA15','assets/images/alimentos/AVEQUA15.png','Avena','400 Gr','Quaker',3500,0,3,1),(124,'CERZUC53','assets/images/alimentos/CERZUC53.png','Cereal','250 Gr','Zucaritas',1920,0,3,1),(125,'CERFRU60','assets/images/alimentos/CERFRU60.png','Cereal','240 Gr','Fruty Aros',2900,0,3,1),(126,'CERCRO82','assets/images/alimentos/CERCRO82.png','Cereal','300 Gr','Cronch Flakes',2800,0,3,1),(127,'PANSIN23','assets/images/alimentos/PANSIN23.png','Pan Arabe','Unidad','Sin Marca',5700,0,3,1),(128,'SANSIN16','assets/images/alimentos/SANSIN16.png','Sandwich','Unidad','Sin Marca',6900,0,3,1),(129,'PANSIN27','assets/images/alimentos/PANSIN27.png','Pan Canilla','Unidad','Sin Marca',5400,0,3,1),(130,'PANSIN81','assets/images/alimentos/PANSIN81.png','Pan Piñita','Unidad','Sin Marca',6000,0,3,1),(131,'PANSIN52','assets/images/alimentos/PANSIN52.png','Pan Sobado','Unidad','Sin Marca',3400,0,3,1),(132,'PANSIN45','assets/images/alimentos/PANSIN45.png','Pan Frances','Unidad','Sin Marca',10300,0,3,1),(133,'MINSIN62','assets/images/alimentos/MINSIN62.png','Mini Pan De Guayaba','Unidad','Sin Marca',8000,0,3,1),(134,'MINSIN13','assets/images/alimentos/MINSIN13.png','Mini Pan De Arequipe','Unidad','Sin Marca',14000,0,3,1),(135,'CATSIN38','assets/images/alimentos/CATSIN38.png','Catalina','Unidad','Sin Marca',7100,0,3,1),(136,'VINMAV70','assets/images/alimentos/VINMAV70.png','Vinagre Blanco','500 Ml','Mavesa',550,0,14,1),(137,'MAITIG73','assets/images/alimentos/MAITIG73.png','Maíz En Grano','300 Gr','Tigo',2800,0,14,1),(138,'MERKIE93','assets/images/alimentos/MERKIE93.png','Mermelada De Fresa','270 Gr','Kiero',2300,0,11,1),(139,'CHOTOD11','assets/images/alimentos/CHOTOD11.png','Chocolate En Polvo','1 Kg','Toddy',1410,0,11,1),(140,'GALMAR30','assets/images/alimentos/GALMAR30.png','Galleta De Leche','6 Unidad','Maria',6900,0,11,1),(141,'AZUKON29','assets/images/alimentos/AZUKON29.png','Azucar','1 Kg','Konfit',3700,0,11,1),(142,'CREKAL16','assets/images/alimentos/CREKAL16.png','Crema De Mani','227 Gr','Kaldint',3330,0,11,1),(143,'GALMAR98','assets/images/alimentos/GALMAR98.png','Galleta De Fresa','6 Unidad','Marilu',4100,0,11,1),(144,'GALMAR17','assets/images/alimentos/GALMAR17.png','Galleta De Chocolate','6 Unidad','Marilu',1700,0,11,1),(145,'GALMAR31','assets/images/alimentos/GALMAR31.png','Galleta De Vainilla','6 Unidad','Marilu',1400,0,11,1),(146,'GALCLU12','assets/images/alimentos/GALCLU12.png','Galleta','6 Unidad','Club Social',1500,0,11,1),(147,'MERKIE26','assets/images/alimentos/MERKIE26.png','Mermelada De Guayaba','270 Gr','Kiero',1300,0,11,1),(148,'GALORE14','assets/images/alimentos/GALORE14.png','Galleta De Chocolate','6 Unidad','Oreo',2200,0,11,1),(149,'GELSON83','assets/images/alimentos/GELSON83.png','Gelatina De Limon','66 Gr','Sonrissa',600,0,11,1),(150,'GELSON84','assets/images/alimentos/GELSON84.png','Gelatina De Fresa','66 Gr','Sonrissa',800,0,11,1),(151,'LECLAL91','assets/images/alimentos/LECLAL91.png','Leche Condensada','395 Gr','La Lechera Nestle',1750,0,11,1),(152,'LECLOS64','assets/images/alimentos/LECLOS64.png','Leche En Polvo','250 Gr','Los Andes',2000,0,14,1),(153,'CERNES14','assets/images/alimentos/CERNES14.png','Cerelac','900 Gr','Nestle',5000,0,14,1);
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
) ENGINE=InnoDB AUTO_INCREMENT=670 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalleentradaa`
--

LOCK TABLES `detalleentradaa` WRITE;
/*!40000 ALTER TABLE `detalleentradaa` DISABLE KEYS */;
INSERT INTO `detalleentradaa` VALUES (1,500,2,1,1),(2,500,3,1,1),(3,750,6,1,1),(4,600,4,1,1),(5,400,7,1,1),(6,400,5,1,1),(7,400,8,1,1),(8,500,1,1,1),(9,300,23,2,1),(10,1000,26,2,1),(11,400,20,2,1),(12,500,24,2,1),(13,700,21,2,1),(14,500,27,2,1),(15,400,29,2,1),(16,300,28,2,1),(17,100,37,2,1),(18,300,32,2,1),(19,1000,50,3,1),(20,300,39,3,1),(21,200,41,3,1),(22,300,44,3,1),(23,1500,51,3,1),(24,300,38,3,1),(25,200,40,3,1),(26,2000,52,3,1),(27,780,55,3,1),(28,500,123,4,1),(29,900,128,4,1),(30,700,124,4,1),(31,1000,125,4,1),(32,800,132,4,1),(33,2000,127,4,1),(34,3000,135,4,1),(35,600,126,4,1),(36,300,78,4,1),(37,2300,77,4,1),(38,3000,133,5,1),(39,4000,132,5,1),(40,600,65,5,1),(41,600,66,5,1),(42,300,37,5,1),(43,6000,75,5,1),(44,600,68,5,1),(45,3000,82,5,1),(46,500,138,6,1),(47,500,118,6,1),(48,670,139,6,1),(49,4000,140,6,1),(50,40,93,6,1),(51,34,51,6,1),(52,23,85,6,1),(53,3000,143,6,1),(54,400,12,7,1),(55,400,9,7,1),(56,300,13,7,1),(57,300,10,7,1),(58,400,80,8,1),(59,300,81,8,1),(60,400,82,8,1),(61,500,78,8,1),(62,400,110,9,1),(63,600,106,9,1),(64,400,112,9,1),(65,600,105,9,1),(66,450,109,9,1),(67,700,107,9,1),(68,300,120,10,1),(69,600,122,10,1),(70,200,110,10,1),(71,2000,115,10,1),(72,700,88,11,1),(73,4000,130,11,1),(74,70,94,11,1),(75,400,91,11,1),(76,4000,134,11,1),(77,4000,86,11,1),(78,300,106,12,1),(79,300,114,12,1),(80,500,97,12,1),(81,400,117,12,1),(82,1000,148,12,1),(83,400,104,12,1),(84,300,137,12,1),(85,200,47,13,1),(86,400,131,13,1),(87,300,15,13,1),(88,300,14,13,1),(89,300,123,13,1),(90,300,132,13,1),(91,500,122,14,1),(92,400,106,14,1),(93,4000,75,14,1),(94,300,116,15,1),(95,50,136,15,1),(96,30,93,15,1),(97,400,123,15,1),(98,400,21,15,1),(99,300,119,15,1),(100,200,4,16,1),(101,400,3,16,1),(102,200,2,16,1),(103,500,6,16,1),(104,200,46,16,1),(105,200,101,16,1),(106,200,96,16,1),(107,100,103,16,1),(108,300,1,16,1),(109,200,99,16,1),(110,400,52,16,1),(111,1000,127,17,1),(112,2000,130,17,1),(113,400,129,17,1),(114,1200,132,17,1),(115,2000,134,17,1),(116,400,113,18,1),(117,200,87,18,1),(118,400,18,18,1),(119,40,84,18,1),(120,300,19,18,1),(121,200,17,18,1),(122,300,4,18,1),(123,400,106,19,1),(124,200,5,19,1),(125,300,105,19,1),(126,300,2,19,1),(127,400,123,19,1),(128,500,69,19,1),(129,300,65,19,1),(130,400,67,19,1),(131,500,71,19,1),(132,300,23,20,1),(133,200,21,20,1),(134,300,24,20,1),(135,200,22,20,1),(136,100,20,20,1),(137,400,42,21,1),(138,300,94,21,1),(139,200,118,21,1),(140,300,38,21,1),(141,200,88,22,1),(142,200,85,22,1),(143,200,137,23,1),(144,200,3,23,1),(145,100,8,23,1),(146,200,1,23,1),(147,400,22,23,1),(148,100,126,24,1),(149,100,124,24,1),(150,400,144,24,1),(151,500,146,24,1),(152,200,140,24,1),(153,200,151,24,1),(154,200,147,24,1),(155,200,145,24,1),(156,500,141,24,1),(157,200,110,25,1),(158,200,109,25,1),(159,300,111,25,1),(160,300,36,26,1),(161,200,21,26,1),(162,100,98,26,1),(163,200,26,26,1),(164,2000,76,26,1),(165,300,47,27,1),(166,200,66,27,1),(167,400,3,27,1),(168,40,94,27,1),(169,200,123,28,1),(170,300,21,28,1),(171,200,77,28,1),(172,100,20,28,1),(173,30,84,29,1),(174,200,118,29,1),(175,10,92,29,1),(176,100,149,29,1),(177,300,150,29,1),(178,200,22,29,1),(179,100,109,30,1),(180,100,107,30,1),(181,100,105,30,1),(182,200,25,31,1),(183,100,24,31,1),(184,100,20,31,1),(185,200,23,31,1),(186,200,83,32,1),(187,200,81,32,1),(188,200,78,32,1),(189,200,82,32,1),(190,2,94,33,1),(191,30,85,33,1),(192,40,139,33,1),(193,20,124,33,1),(194,100,115,34,1),(195,50,151,34,1),(196,30,142,34,1),(197,200,22,35,1),(198,200,29,35,1),(199,100,16,35,1),(200,100,12,35,1),(201,200,32,35,1),(202,100,11,35,1),(203,300,52,36,1),(204,200,141,36,1),(205,100,46,36,1),(206,30,94,36,1),(207,200,3,36,1),(208,100,76,37,1),(209,100,147,37,1),(210,100,118,37,1),(211,400,75,37,1),(212,200,33,38,1),(213,200,34,38,1),(214,100,37,38,1),(215,200,35,38,1),(216,200,27,38,1),(217,200,30,38,1),(218,200,44,39,1),(219,100,43,39,1),(220,200,38,39,1),(221,100,41,39,1),(222,300,53,40,1),(223,200,52,40,1),(224,200,55,40,1),(225,100,50,40,1),(226,100,65,41,1),(227,200,72,41,1),(228,100,67,41,1),(229,100,21,42,1),(230,200,26,42,1),(231,100,20,42,1),(232,200,24,42,1),(233,100,48,43,1),(234,200,49,43,1),(235,100,45,43,1),(236,100,143,44,1),(237,100,139,44,1),(238,100,144,44,1),(239,100,135,44,1),(240,100,142,44,1),(241,30,85,44,1),(242,100,118,45,1),(243,100,90,45,1),(244,200,88,45,1),(245,50,98,45,1),(246,50,4,46,1),(247,80,5,46,1),(248,100,8,46,1),(249,100,1,46,1),(250,10,93,46,1),(251,200,122,47,1),(252,100,105,47,1),(253,100,114,47,1),(254,200,120,47,1),(255,300,76,48,1),(256,200,56,48,1),(257,100,36,48,1),(258,10,118,48,1),(259,200,25,48,1),(260,100,32,49,1),(261,100,28,49,1),(262,100,20,49,1),(263,100,2,50,1),(264,20,93,50,1),(265,100,69,50,1),(266,1000,106,51,1),(267,800,110,51,1),(268,500,117,51,1),(269,1000,105,51,1),(270,1000,107,51,1),(271,500,21,52,1),(272,500,22,52,1),(273,300,20,52,1),(274,300,23,52,1),(275,500,24,52,1),(276,600,126,53,1),(277,400,125,53,1),(278,400,123,53,1),(279,200,124,53,1),(280,300,38,54,1),(281,300,39,54,1),(282,400,41,54,1),(283,500,40,54,1),(284,300,51,55,1),(285,500,50,55,1),(286,800,52,55,1),(287,200,59,56,1),(288,900,58,56,1),(289,600,55,56,1),(290,700,57,56,1),(291,500,65,57,1),(292,200,66,57,1),(293,400,67,57,1),(294,600,68,57,1),(295,2000,76,58,1),(296,4000,75,58,1),(297,500,81,59,1),(298,600,78,59,1),(299,700,77,59,1),(300,2000,83,59,1),(301,1000,79,59,1),(302,700,80,59,1),(303,1000,82,59,1),(304,500,139,60,1),(305,700,118,60,1),(306,600,138,60,1),(307,1000,140,60,1),(308,1000,141,60,1),(309,2000,142,60,1),(310,1000,86,61,1),(311,1000,84,61,1),(312,1000,87,61,1),(313,700,85,61,1),(314,1000,89,61,1),(315,2000,88,61,1),(316,400,104,62,1),(317,300,103,62,1),(318,1000,102,62,1),(319,500,101,62,1),(320,100,100,62,1),(321,1000,122,63,1),(322,1000,116,63,1),(323,1000,106,63,1),(324,1000,105,63,1),(325,1000,121,63,1),(326,300,137,63,1),(327,500,4,64,1),(328,500,6,64,1),(329,200,2,64,1),(330,200,5,64,1),(331,500,3,64,1),(332,200,1,64,1),(333,200,8,64,1),(334,1000,30,65,1),(335,500,29,65,1),(336,500,27,65,1),(337,200,28,65,1),(338,200,25,65,1),(339,1000,20,65,1),(340,1000,127,66,1),(341,2000,129,66,1),(342,1000,128,66,1),(343,1000,135,67,1),(344,2000,133,67,1),(345,2000,134,67,1),(346,1000,44,68,1),(347,500,43,68,1),(348,2000,42,68,1),(349,500,46,69,1),(350,700,49,69,1),(351,100,45,69,1),(352,500,48,69,1),(353,1000,60,70,1),(354,1000,50,70,1),(355,2000,56,70,1),(356,1000,62,71,1),(357,600,57,71,1),(358,200,64,71,1),(359,400,63,71,1),(360,1000,72,72,1),(361,1000,73,72,1),(362,1000,74,72,1),(363,1000,80,73,1),(364,1000,78,73,1),(365,1000,77,73,1),(366,1000,75,73,1),(367,500,151,74,1),(368,1000,118,74,1),(369,500,150,74,1),(370,500,149,74,1),(371,1000,90,75,1),(372,1000,85,75,1),(373,1000,91,75,1),(374,1000,97,76,1),(375,1000,98,76,1),(376,1000,102,76,1),(377,1000,104,76,1),(378,1000,112,77,1),(379,500,136,77,1),(380,1000,114,77,1),(381,1000,113,77,1),(382,1000,115,77,1),(383,1000,18,78,1),(384,1000,17,78,1),(385,1000,19,78,1),(386,700,36,79,1),(387,400,37,79,1),(388,800,33,79,1),(389,700,34,79,1),(390,400,124,80,1),(391,900,126,80,1),(392,300,123,80,1),(393,600,125,80,1),(394,300,39,81,1),(395,1000,38,81,1),(396,500,41,81,1),(397,500,48,82,1),(398,1000,49,82,1),(399,400,55,83,1),(400,200,63,83,1),(401,700,53,83,1),(402,400,71,84,1),(403,200,67,84,1),(404,600,69,84,1),(405,2000,78,85,1),(406,2000,75,85,1),(407,1000,79,85,1),(408,200,148,86,1),(409,200,144,86,1),(410,200,145,86,1),(411,400,118,86,1),(412,1000,84,87,1),(413,1000,86,87,1),(414,2000,89,87,1),(415,3000,88,87,1),(416,1000,87,87,1),(417,100,93,88,1),(418,100,92,88,1),(419,100,95,88,1),(420,100,94,88,1),(421,100,96,88,1),(422,2000,106,89,1),(423,2000,107,89,1),(424,1000,105,89,1),(425,1000,108,89,1),(426,1000,109,90,1),(427,1000,111,90,1),(428,2000,110,90,1),(429,1000,4,91,1),(430,600,2,91,1),(431,1000,1,91,1),(432,1000,3,91,1),(433,900,6,91,1),(434,1000,9,92,1),(435,2000,12,92,1),(436,1000,8,92,1),(437,400,11,92,1),(438,600,10,92,1),(439,1000,22,93,1),(440,800,32,93,1),(441,700,34,93,1),(442,400,21,93,1),(443,300,124,94,1),(444,500,125,94,1),(445,600,123,94,1),(446,300,126,94,1),(447,2000,128,95,1),(448,2000,129,95,1),(449,2000,132,95,1),(450,700,127,95,1),(451,1000,131,95,1),(452,2000,134,96,1),(453,1000,133,96,1),(454,1000,135,96,1),(455,1000,39,97,1),(456,1000,42,97,1),(457,1000,44,97,1),(458,2000,50,98,1),(459,2000,52,98,1),(460,700,54,98,1),(461,1000,51,98,1),(462,700,67,98,1),(463,1000,76,99,1),(464,2000,75,99,1),(465,2000,83,100,1),(466,2000,79,100,1),(467,1000,78,100,1),(468,1000,77,100,1),(469,1000,112,101,1),(470,2000,106,101,1),(471,1000,105,101,1),(472,200,15,102,1),(473,500,14,102,1),(474,400,7,102,1),(475,1000,16,102,1),(476,200,33,103,1),(477,700,24,103,1),(478,1000,20,103,1),(479,600,37,103,1),(480,1000,128,104,1),(481,1000,131,104,1),(482,900,51,105,1),(483,1000,52,105,1),(484,700,65,105,1),(485,1000,77,106,1),(486,2000,75,106,1),(487,2000,83,106,1),(488,700,82,106,1),(489,200,138,107,1),(490,700,140,107,1),(491,100,139,107,1),(492,2000,141,107,1),(493,200,142,107,1),(494,2000,88,108,1),(495,2000,84,108,1),(496,1000,89,108,1),(497,300,102,109,1),(498,100,104,109,1),(499,100,103,109,1),(500,600,108,110,1),(501,2000,107,110,1),(502,600,109,110,1),(503,1000,110,110,1),(504,700,111,110,1),(505,200,17,111,1),(506,1000,2,111,1),(507,600,12,111,1),(508,600,3,111,1),(509,500,18,111,1),(510,600,36,112,1),(511,600,30,112,1),(512,2000,35,112,1),(513,1000,133,113,1),(514,2000,134,113,1),(515,1000,135,113,1),(516,500,64,114,1),(517,1000,61,114,1),(518,1000,59,114,1),(519,1000,62,114,1),(520,500,57,114,1),(521,700,67,115,1),(522,600,69,115,1),(523,500,80,116,1),(524,2000,83,116,1),(525,1000,78,116,1),(526,4000,75,116,1),(527,2000,52,117,1),(528,1000,50,117,1),(529,2000,60,117,1),(530,700,73,118,1),(531,800,72,118,1),(532,500,74,118,1),(533,700,82,119,1),(534,800,79,119,1),(535,3000,83,119,1),(536,700,81,119,1),(537,30,94,120,1),(538,50,92,120,1),(539,100,93,120,1),(540,600,3,121,1),(541,1000,8,121,1),(542,1000,1,121,1),(543,1000,6,121,1),(544,100,5,121,1),(545,1000,9,121,1),(546,500,24,122,1),(547,500,32,122,1),(548,700,29,122,1),(549,700,27,122,1),(550,200,124,123,1),(551,400,123,123,1),(552,300,126,123,1),(553,400,125,123,1),(554,1000,107,124,1),(555,1000,113,124,1),(556,1000,105,124,1),(557,2000,112,124,1),(558,1000,111,124,1),(559,1000,91,125,1),(560,1000,90,125,1),(561,1000,85,125,1),(562,1000,97,126,1),(563,700,98,126,1),(564,400,104,126,1),(565,1000,145,127,1),(566,1000,146,127,1),(567,1000,143,127,1),(568,1000,144,127,1),(569,1000,140,127,1),(570,1000,148,127,1),(571,1000,147,128,1),(572,1000,151,128,1),(573,1000,142,128,1),(574,1000,138,128,1),(575,1000,121,129,1),(576,1000,119,129,1),(577,1000,122,129,1),(578,1000,56,130,1),(579,1000,51,130,1),(580,1000,54,130,1),(581,1000,52,130,1),(582,1000,50,130,1),(583,1000,115,131,1),(584,1000,114,131,1),(585,1000,117,131,1),(586,1000,24,132,1),(587,1000,21,132,1),(588,700,32,132,1),(589,800,34,132,1),(590,700,22,132,1),(591,1000,20,132,1),(592,1000,129,133,1),(593,1000,131,133,1),(594,2000,132,133,1),(595,1000,127,133,1),(596,2000,128,133,1),(597,2000,134,134,1),(598,1000,133,134,1),(599,1000,135,134,1),(600,1000,1,135,1),(601,1000,4,135,1),(602,1000,3,135,1),(603,500,17,135,1),(604,400,18,136,1),(605,1000,9,136,1),(606,700,19,136,1),(607,1000,105,137,1),(608,1000,106,137,1),(609,1000,112,137,1),(610,1000,111,137,1),(611,1000,107,137,1),(612,1000,109,137,1),(613,1000,50,138,1),(614,1000,51,138,1),(615,1000,84,138,1),(616,1000,53,138,1),(617,800,64,139,1),(618,1000,56,139,1),(619,2000,76,140,1),(620,2000,75,140,1),(621,2000,106,141,1),(622,1000,112,141,1),(623,2000,108,141,1),(624,2000,110,141,1),(625,1000,152,142,1),(626,1000,153,142,1),(627,2000,3,143,1),(628,1000,114,143,1),(629,1000,137,143,1),(630,1000,42,143,1),(631,1000,51,144,1),(632,1000,55,144,1),(633,1000,100,144,1),(634,1000,104,144,1),(635,1000,99,144,1),(636,2000,67,144,1),(637,1000,71,144,1),(638,1000,103,144,1),(639,1000,102,144,1),(640,1000,9,145,1),(641,1000,118,145,1),(642,100,93,145,1),(643,1000,3,145,1),(644,1000,6,145,1),(645,1000,8,145,1),(646,1000,106,146,1),(647,1000,107,146,1),(648,1000,104,146,1),(649,1000,103,146,1),(650,4000,153,147,1),(651,1000,137,147,1),(652,1000,152,147,1),(653,2000,109,147,1),(654,2000,36,148,1),(655,3000,22,148,1),(656,2000,3,148,1),(657,3000,33,148,1),(658,3000,35,148,1),(659,600,70,149,1),(660,400,66,149,1),(661,300,71,149,1),(662,500,74,149,1),(663,1000,77,150,1),(664,1000,101,150,1),(665,4000,75,150,1),(666,200,81,150,1),(667,1000,89,151,1),(668,1000,86,151,1),(669,1000,84,151,1);
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detallesalidaa`
--

LOCK TABLES `detallesalidaa` WRITE;
/*!40000 ALTER TABLE `detallesalidaa` DISABLE KEYS */;
INSERT INTO `detallesalidaa` VALUES (1,20,23,1,1),(2,20,3,1,1),(3,30,75,2,1),(4,15,122,3,1),(5,3,19,4,1),(6,2,18,4,1);
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
) ENGINE=InnoDB AUTO_INCREMENT=152 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entradaalimento`
--

LOCK TABLES `entradaalimento` WRITE;
/*!40000 ALTER TABLE `entradaalimento` DISABLE KEYS */;
INSERT INTO `entradaalimento` VALUES (1,'2025-07-25','15:31:00','Compra de verduras',1),(2,'2025-07-25','15:36:00','Entrada de Frutas',1),(3,'2025-07-25','15:38:00',' Compra de Granos y Carnes',1),(4,'2025-07-25','15:43:00','Entrada de alimentos',1),(5,'2025-07-25','15:45:00',' Alimentos comprados',1),(6,'2025-07-25','15:47:00',' Entrada de alimentos',1),(7,'2025-07-25','15:56:00','Entrada de verduras',1),(8,'2025-07-25','15:59:00',' Entrada de lacteos',1),(9,'2025-07-25','16:01:00','Entrada de Viveres',1),(10,'2025-07-25','16:03:00','Entrada de alimentos',1),(11,'2025-07-25','16:04:00',' entrada de productos comprados',1),(12,'2025-07-25','16:07:00','Entrada de viveres y condimentos',1),(13,'2025-07-25','16:29:00','entrada de alimentos',1),(14,'2025-07-25','16:31:00',' Compra de alimentos',1),(15,'2025-07-25','17:56:00','Compra de alimentos',1),(16,'2025-07-25','17:58:00','Compra de verduras y condimentos',1),(17,'2025-07-25','18:00:00',' Compra de Panes',1),(18,'2025-07-25','18:04:00','Bebidas y Aliños verdes',1),(19,'2025-07-25','18:07:00','Mariscos y verduras',1),(20,'2025-07-25','18:09:00','Compra de frutas',1),(21,'2025-07-28','18:10:00',' Entrada de alimentos',1),(22,'2025-07-28','18:11:00',' Bebidas',1),(23,'2025-07-28','18:17:00','Entrada de viveres y verduras',1),(24,'2025-07-28','18:19:00',' Entrada de Azúcar',1),(25,'2025-07-28','18:40:00','Compra de Espaguetis',1),(26,'2025-07-28','19:08:00',' Compra de alimentos',1),(27,'2025-07-28','19:10:00',' Entrada de alimentos',1),(28,'2025-07-28','19:11:00','Compra de alimentos',1),(29,'2025-07-28','19:13:00','Compra de alimentos',1),(30,'2025-07-28','19:14:00',' Compra de Viveres',1),(31,'2025-07-30','19:15:00',' Compra de frutas',1),(32,'2025-07-30','19:19:00','Entrada de Lácteos',1),(33,'2025-07-30','19:27:00',' Compras de viveres',1),(34,'2025-07-30','19:28:00',' Compra de Enlatados',1),(35,'2025-07-30','19:30:00','Compra de frutas y Verduras',1),(36,'2025-08-01','19:48:00','Compra de alimentos',1),(37,'2025-08-01','19:49:00',' Entrada de alimentos',1),(38,'2025-08-01','19:53:00','Compra de frutas',1),(39,'2025-08-01','19:54:00',' Compra de Granos',1),(40,'2025-08-01','19:55:00','Compra de Carnes y Proteinas',1),(41,'2025-08-04','19:56:00','Entrada de Pescado y Marisco',1),(42,'2025-08-04','19:58:00','Compra de frutas',1),(43,'2025-08-04','19:58:00',' Entrada de alimentos',1),(44,'2025-08-04','19:59:00',' Entrada de alimentos azucarados',1),(45,'2025-08-04','20:02:00','Compra de alimentos',1),(46,'2025-08-04','20:03:00',' Entrada de alimentos',1),(47,'2025-08-04','20:04:00',' Compra de viveres',1),(48,'2025-08-04','20:06:00','Compra de alimentos',1),(49,'2025-08-16','20:07:00',' Compra de frutas',1),(50,'2025-08-07','20:07:00',' compra de alimentos',1),(51,'2025-08-07','16:06:00','Entrada de viveres',1),(52,'2025-08-07','16:07:00',' Entrada de Frutas',1),(53,'2025-08-07','16:08:00',' Compra de Cereales',1),(54,'2025-08-07','16:09:00','Entrada de Granos',1),(55,'2025-08-07','16:10:00',' Entrada de Carnes',1),(56,'2025-08-07','16:10:00',' Entrada de Proteinas',1),(57,'2025-08-07','16:12:00',' Entrada de Pescados',1),(58,'2025-08-07','16:12:00',' Entrada de Huevos',1),(59,'2025-08-07','16:13:00','Compra de Lacteos',1),(60,'2025-08-07','16:16:00',' Compra de Grasa y Azucares',1),(61,'2025-08-07','16:19:00',' Entrada de Bebidas',1),(62,'2025-08-07','16:21:00','Entrada de condimentos',1),(63,'2025-08-07','16:22:00',' Enlatados y Viveres',1),(64,'2025-08-07','16:23:00',' Entrada de Verduras',1),(65,'2025-08-07','16:24:00',' Entrada de Frutas',1),(66,'2025-08-07','16:25:00','Entrada de Panes Salados',1),(67,'2025-08-07','16:26:00',' Entrada de Panes Dulces',1),(68,'2025-08-07','16:27:00',' Entrada de Granos',1),(69,'2025-08-07','16:28:00','Entrada de Tuberculos y raices',1),(70,'2025-08-07','16:29:00',' Entrada de Carnes',1),(71,'2025-08-09','16:30:00',' Entrada de Proteinas',1),(72,'2025-08-09','17:06:00','Entrada de Pescado',1),(73,'2025-08-09','17:07:00',' Entrada de Lacteos',1),(74,'2025-08-09','17:08:00',' Entrada de Dulces',1),(75,'2025-08-09','17:09:00',' Entrada de Refresco',1),(76,'2025-08-09','17:18:00','Entrada de Salsas',1),(77,'2025-08-09','17:19:00',' Entrada de Viveres',1),(78,'2025-08-09','17:20:00',' Entrada de Aliños verdes',1),(79,'2025-08-09','17:21:00','Entrada de Frutas',1),(80,'2025-08-09','17:22:00',' Entrada de Cereales',1),(81,'2025-08-10','17:23:00',' Entrada de Caraotas y Lentejas',1),(82,'2025-08-10','17:24:00',' Entrada de Tuberculos',1),(83,'2025-08-10','17:25:00',' Entrada de Salchichas',1),(84,'2025-08-10','17:26:00','Entrada de Mariscos y Pescados',1),(85,'2025-08-10','17:27:00',' Entrada de Lacteos',1),(86,'2025-08-10','17:44:00',' Galletas y Aceites',1),(87,'2025-08-10','17:46:00','Entrada de Jugos',1),(88,'2025-08-10','17:47:00',' Condimentos y Especias',1),(89,'2025-08-10','17:48:00','Entrada de Harinas y Arroz',1),(90,'2025-08-12','17:49:00','Entrada de Spaguetis',1),(91,'2025-08-12','17:50:00',' Entrada de Verduras',1),(92,'2025-08-12','17:51:00',' Entrada de Verduras',1),(93,'2025-08-12','17:52:00',' Compra de Frutas',1),(94,'2025-08-12','17:53:00','Entrada de Cereales',1),(95,'2025-08-12','17:54:00',' Compra de Panes Salados',1),(96,'2025-08-12','17:55:00',' Panes Dulces',1),(97,'2025-08-12','17:58:00','Entrada de Granos',1),(98,'2025-08-12','17:59:00',' Entrada de Carnes y Mariscos',1),(99,'2025-08-12','18:00:00',' Entrada de Huevos',1),(100,'2025-08-12','18:01:00','Entrada de Lacteos',1),(101,'2025-08-13','18:40:00','Entrada de Harinas ',1),(102,'2025-08-13','18:41:00',' Entrada de Verduras',1),(103,'2025-08-13','18:42:00',' Compra de Frutas',1),(104,'2025-08-13','18:43:00','Entrada de Panes',1),(105,'2025-08-13','18:45:00',' Entrada de Carnes',1),(106,'2025-08-13','18:46:00',' Compra de productos lacteos',1),(107,'2025-08-13','18:48:00','Entrada de Dulces',1),(108,'2025-08-13','18:49:00',' Entrada de Agua potable y jugos naturales',1),(109,'2025-08-13','18:50:00',' Entrada de Salsas',1),(110,'2025-08-13','18:50:00',' Entrada de Viveres',1),(111,'2025-08-14','18:54:00','Entrada de Verduras',1),(112,'2025-08-14','18:55:00',' Compra de Frutas',1),(113,'2025-08-14','18:56:00',' Compra de panes dulces',1),(114,'2025-08-14','18:56:00',' Entrada de Mortadela y Jamon',1),(115,'2025-08-14','18:58:00',' Entrada de Mariscos',1),(116,'2025-08-14','18:59:00',' Compra de productos lacteos',1),(117,'2025-08-14','19:00:00','Compra de carnes',1),(118,'2025-08-14','19:07:00',' Entrada de pescado',1),(119,'2025-08-14','19:08:00',' Compra de Lacteos',1),(120,'2025-08-14','19:09:00',' Entrada de Especias',1),(121,'2025-08-15','19:51:00','Entrada de Verduras',1),(122,'2025-08-15','19:52:00',' Entrada de Frutas',1),(123,'2025-08-15','19:53:00',' Entrada de Cereales',1),(124,'2025-08-15','19:55:00','Entrada de viveres',1),(125,'2025-08-15','19:59:00',' Compra de refrescos',1),(126,'2025-08-15','20:00:00',' Entrada de Salsas',1),(127,'2025-08-15','20:00:00',' Compra de Galletas',1),(128,'2025-08-15','20:02:00',' Entrada de Productos dulces',1),(129,'2025-08-15','20:03:00','Entrada de enlatados',1),(130,'2025-08-15','20:04:00',' Entrada de Carnes',1),(131,'2025-08-15','20:13:00','Entrada de Viveres ',1),(132,'2025-08-15','20:16:00','Entrada de Frutas',1),(133,'2025-08-15','20:17:00',' Entrada de Panes Salados',1),(134,'2025-08-15','20:18:00',' Compra de Panes Dulces',1),(135,'2025-08-15','20:20:00','Entrada de verduras',1),(136,'2025-08-15','20:22:00',' compra de verduras',1),(137,'2025-08-15','20:26:00','Entrada de Alimentos',1),(138,'2025-08-15','20:38:00','Entrada de alimentos',1),(139,'2025-08-15','20:40:00',' Entrada de Proteinas',1),(140,'2025-08-15','20:45:00','Entrada de Huevos',1),(141,'2025-08-16','21:27:00','Entrada de Alimentos',1),(142,'2025-08-16','21:28:00',' 2000',1),(143,'2025-08-16','21:29:00',' Entrada de alimentos',1),(144,'2025-08-16','21:30:00','Entrada de Alimentos',1),(145,'2025-08-16','21:34:00','Entrada de Alimentos',1),(146,'2025-08-17','21:39:00','Entrada de Alimentos',1),(147,'2025-08-17','21:41:00',' Compra de productos de viveres',1),(148,'2025-08-17','21:43:00',' Entrada de Frutas',1),(149,'2025-08-17','21:44:00','Compra de pescados',1),(150,'2025-08-17','21:45:00','Compra de alimentos',1),(151,'2025-08-17','21:46:00',' Compra de bebidas',1);
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salidaalimentos`
--

LOCK TABLES `salidaalimentos` WRITE;
/*!40000 ALTER TABLE `salidaalimentos` DISABLE KEYS */;
INSERT INTO `salidaalimentos` VALUES (1,'2025-08-30','15:44:00','Se pudrieron',2,1),(2,'2025-08-30','15:44:00','Se partieron',2,1),(3,'2025-08-30','15:45:00','Se venció ',2,1),(4,'2025-09-02','20:05:00','Se dañaron los aliños verdes',2,1);
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
INSERT INTO `tipoalimento` VALUES (1,'Verduras Y Hortalizas',1),(2,'Frutas',1),(3,'Cereales',1),(4,'Legumbres Y Granos Secos',1),(5,'Tubérculos Y Raíces',1),(6,'Carnes',1),(7,'Pescados Y Mariscos',1),(8,'Huevos',1),(9,'Lácteos',1),(10,'Grasas Y Aceites',1),(11,'Azúcares Y Dulces',1),(12,'Bebidas',1),(13,'Condimentos Y Especias',1),(14,'Viveres',1),(15,'Suplementos Y Productos Nutricionales',1);
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tiposalidas`
--

LOCK TABLES `tiposalidas` WRITE;
/*!40000 ALTER TABLE `tiposalidas` DISABLE KEYS */;
INSERT INTO `tiposalidas` VALUES (1,'Menú',1),(2,'Merma',1);
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
  1 AS `horarioComida`,
  1 AS `marca` */;
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
  1 AS `horarioComida`,
  1 AS `marca` */;
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
/*!50001 VIEW `vista_tipo_alimento_evento` AS select distinct `ta`.`idTipoA` AS `idTipoA`,`ta`.`tipo` AS `tipo`,`e`.`nomEvent` AS `nomEvent`,`e`.`idEvento` AS `idEvento`,`e`.`idMenu` AS `idMenu`,`m`.`feMenu` AS `feMenu`,`m`.`horarioComida` AS `horarioComida`,`a`.`marca` AS `marca` from (((((`evento` `e` join `menu` `m` on(`m`.`idMenu` = `e`.`idMenu` and `m`.`status` = 1)) left join `detallesalidamenu` `dsm` on(`dsm`.`idMenu` = `m`.`idMenu` and `dsm`.`status` = 1)) left join `salidaalimentos` `sa` on(`sa`.`idSalidaA` = `dsm`.`idSalidaA` and `sa`.`status` = 1)) left join `alimento` `a` on(`a`.`idAlimento` = `dsm`.`idAlimento` and `a`.`status` = 1)) left join `tipoalimento` `ta` on(`a`.`idTipoA` = `ta`.`idTipoA` and `ta`.`status` = 1)) where `e`.`status` = 1 */;
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
/*!50001 VIEW `vista_tipo_alimentos_por_menu` AS select `ta`.`idTipoA` AS `idTipoA`,`ta`.`tipo` AS `tipo`,`m`.`idMenu` AS `idMenu`,`m`.`feMenu` AS `feMenu`,`m`.`horarioComida` AS `horarioComida`,`a`.`marca` AS `marca` from (((`detallesalidamenu` `dsm` join `alimento` `a` on(`a`.`idAlimento` = `dsm`.`idAlimento`)) join `tipoalimento` `ta` on(`a`.`idTipoA` = `ta`.`idTipoA`)) join `menu` `m` on(`m`.`idMenu` = `dsm`.`idMenu`)) group by `ta`.`idTipoA`,`ta`.`tipo`,`m`.`idMenu`,`m`.`feMenu`,`m`.`horarioComida` */;
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

-- Dump completed on 2025-09-02 20:07:07
