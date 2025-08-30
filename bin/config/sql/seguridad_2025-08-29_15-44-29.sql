-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: seguridadUptaeb
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
-- Table structure for table `bitacora`
--

DROP TABLE IF EXISTS `bitacora`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bitacora` (
  `idBitacora` int(11) NOT NULL AUTO_INCREMENT,
  `modulo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `acciones` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` date NOT NULL DEFAULT current_timestamp(),
  `hora` time NOT NULL DEFAULT current_timestamp(),
  `cedula` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`idBitacora`),
  KEY `idx_bitacora_cedula` (`cedula`),
  KEY `idx_bitacora_fecha` (`fecha`),
  KEY `idx_bitacora_hora` (`hora`),
  CONSTRAINT `bitacora_ibfk_1` FOREIGN KEY (`cedula`) REFERENCES `usuario` (`cedula`)
) ENGINE=InnoDB AUTO_INCREMENT=217 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bitacora`
--

LOCK TABLES `bitacora` WRITE;
/*!40000 ALTER TABLE `bitacora` DISABLE KEYS */;
INSERT INTO `bitacora` VALUES (1,'Tipos De Alimentos','Registró un Tipo de Alimento llamado: Verduras Y Hortalizas','2025-08-03','11:51:42',12345678,1),(2,'Tipos De Alimentos','Registró un Tipo de Alimento llamado: Frutas','2025-08-03','11:52:59',12345678,1),(3,'Tipos De Alimentos','Registró un Tipo de Alimento llamado: Cereales Y Derivados','2025-08-03','11:53:09',12345678,1),(4,'Tipos De Alimentos','Registró un Tipo de Alimento llamado: Legumbres Y Granos Secos','2025-08-03','11:53:39',12345678,1),(5,'Tipos De Alimentos','Registró un Tipo de Alimento llamado: Tubérculos Y Raíces','2025-08-03','11:53:50',12345678,1),(6,'Tipos De Alimentos','Registró un Tipo de Alimento llamado: Carnes Y Derivados','2025-08-03','11:54:01',12345678,1),(7,'Tipos De Alimentos','Registró un Tipo de Alimento llamado: Pescados Y Mariscos','2025-08-03','11:54:20',12345678,1),(8,'Tipos De Alimentos','Registró un Tipo de Alimento llamado: Huevos','2025-08-03','11:54:33',12345678,1),(9,'Tipos De Alimentos','Registró un Tipo de Alimento llamado: Lácteos Y Derivados','2025-08-03','11:54:57',12345678,1),(10,'Tipos De Alimentos','Registró un Tipo de Alimento llamado: Grasas Y Aceites','2025-08-03','11:55:14',12345678,1),(11,'Tipos De Alimentos','Registró un Tipo de Alimento llamado: Azúcares Y Dulces','2025-08-03','11:55:25',12345678,1),(12,'Tipos De Alimentos','Registró un Tipo de Alimento llamado: Bebidas','2025-08-03','11:55:34',12345678,1),(13,'Tipos De Alimentos','Registró un Tipo de Alimento llamado: Condimentos Y Especias','2025-08-03','11:55:43',12345678,1),(14,'Tipos De Alimentos','Registró un Tipo de Alimento llamado: Víveres','2025-08-03','11:56:02',12345678,1),(15,'Tipos De Alimentos','Registró un Tipo de Alimento llamado: Alimentos Ultraprocesados','2025-08-03','11:56:18',12345678,1),(16,'Tipos De Alimentos','Registró un Tipo de Alimento llamado: Suplementos Y Productos Nutricionales','2025-08-03','11:56:28',12345678,1),(17,'Tipos de Alimentos','Se Modificó un Tipo de Alimento llamado:Frutas','2025-08-03','11:56:52',12345678,1),(18,'Tipos de Alimentos','Se Modificó un Tipo de Alimento llamado:Verduras Y Hortalizas','2025-08-03','11:57:55',12345678,1),(19,'Tipos de Alimentos','Se Modificó un Tipo de Alimento llamado:Bebidas','2025-08-03','11:58:49',12345678,1),(20,'Tipos de Alimentos','Se Modificó un Tipo de Alimento llamado:Bebidas','2025-08-03','12:00:02',12345678,1),(21,'Tipos de Alimentos','Se Modificó un Tipo de Alimento llamado:Bebidas','2025-08-03','12:00:59',12345678,1),(22,'Tipos De Alimentos','Registró un Tipo de Alimento llamado: Verduras Y Hortalizas','2025-08-03','12:03:33',12345678,1),(23,'Tipos De Alimentos','Registró un Tipo de Alimento llamado: Frutas','2025-08-03','12:03:45',12345678,1),(24,'Tipos De Alimentos','Registró un Tipo de Alimento llamado: Cereales','2025-08-03','12:03:57',12345678,1),(25,'Tipos De Alimentos','Registró un Tipo de Alimento llamado: Legumbres Y Granos Secos','2025-08-03','12:04:07',12345678,1),(26,'Tipos De Alimentos','Registró un Tipo de Alimento llamado: Tubérculos Y Raíces','2025-08-03','12:04:16',12345678,1),(27,'Tipos De Alimentos','Registró un Tipo de Alimento llamado: Carnes Y Derivados','2025-08-03','12:04:26',12345678,1),(28,'Tipos De Alimentos','Registró un Tipo de Alimento llamado: Pescados Y Mariscos','2025-08-03','12:04:36',12345678,1),(29,'Tipos De Alimentos','Registró un Tipo de Alimento llamado: Huevos','2025-08-03','12:04:45',12345678,1),(30,'Tipos De Alimentos','Registró un Tipo de Alimento llamado: Lácteos Y Derivados','2025-08-03','12:04:54',12345678,1),(31,'Tipos De Alimentos','Registró un Tipo de Alimento llamado: Grasas Y Aceites','2025-08-03','12:05:05',12345678,1),(32,'Tipos De Alimentos','Registró un Tipo de Alimento llamado: Azúcares Y Dulces','2025-08-03','12:05:13',12345678,1),(33,'Tipos De Alimentos','Registró un Tipo de Alimento llamado: Bebidas','2025-08-03','12:05:26',12345678,1),(34,'Tipos De Alimentos','Registró un Tipo de Alimento llamado: Condimentos Y Especias','2025-08-03','12:05:36',12345678,1),(35,'Tipos De Alimentos','Registró un Tipo de Alimento llamado: Viveres','2025-08-03','12:05:49',12345678,1),(36,'Tipos De Alimentos','Registró un Tipo de Alimento llamado: Alimentos Ultraprocesados','2025-08-03','12:06:00',12345678,1),(37,'Tipos De Alimentos','Registró un Tipo de Alimento llamado: Suplementos Y Productos Nutricionales','2025-08-03','12:06:08',12345678,1),(38,'Tipos de Alimentos','Se Modificó un Tipo de Alimento llamado:Lácteos','2025-08-03','12:06:17',12345678,1),(39,'Tipos de Alimentos','Se Modificó un Tipo de Alimento llamado:Carnes','2025-08-03','12:06:26',12345678,1),(40,'Tipos de Alimentos','Se anuló un Tipo de alimento llamado: Suplementos Y Productos Nutricionales','2025-08-03','12:08:09',12345678,1),(41,'Tipos De Alimentos','Registró un Tipo de Alimento llamado: Suplementos Y Productos Nutricionales','2025-08-03','12:08:21',12345678,1),(42,'Tipos de Alimentos','Se Modificó un Tipo de Alimento llamado:Carne','2025-08-03','12:30:06',12345678,1),(43,'Tipos de Alimentos','Se Modificó un Tipo de Alimento llamado:Carnes','2025-08-03','12:30:12',12345678,1),(44,'Tipos De Alimentos','Registró un Tipo de Alimento llamado: Lsxklsl','2025-08-03','12:32:05',12345678,1),(45,'Tipos de Alimentos','Se anuló un Tipo de alimento llamado: Lsxklsl','2025-08-03','12:32:18',12345678,1),(46,'Roles','Registró un rol llamado: Cocinero','2025-08-03','13:17:45',12345678,1),(47,'Roles','Registró un rol llamado: Jefe De Cocina','2025-08-03','13:34:27',12345678,1),(48,'Roles','Registró un rol llamado: Coord Serv Nutricional','2025-08-03','13:38:31',12345678,1),(49,'Roles','Registró un rol llamado: Asistente De Bienestar Estudiantil','2025-08-03','13:38:58',12345678,1),(50,'Roles','Registró un rol llamado: Control De Estudio','2025-08-03','13:39:12',12345678,1),(51,'Roles','Registró un rol llamado: Encargado','2025-08-03','14:01:14',12345678,1),(52,'Alimentos','Registró un Alimento llamado: Zanahoria','2025-08-03','14:02:15',12345678,1),(53,'Alimentos','Registró un Alimento llamado: Lechuga','2025-08-03','14:06:13',12345678,1),(54,'Alimentos','Registró un Alimento llamado: Tomate','2025-08-03','14:08:22',12345678,1),(55,'Alimentos','Registró un Alimento llamado: Cebolla','2025-08-03','14:08:40',12345678,1),(56,'Alimentos','Registró un Alimento llamado: Brocoli','2025-08-03','14:09:44',12345678,1),(57,'Alimentos','Registró un Alimento llamado: Papa','2025-08-03','14:10:26',12345678,1),(58,'Alimentos','Registró un Alimento llamado: Acelga','2025-08-03','14:11:12',12345678,1),(59,'Alimentos','Registró un Alimento llamado: Calabazin','2025-08-03','14:37:17',12345678,1),(60,'Alimentos','Registró un Alimento llamado: Berengena','2025-08-03','14:37:32',12345678,1),(61,'Alimentos','Registró un Alimento llamado: Pimenton','2025-08-03','14:37:55',12345678,1),(62,'Alimentos','Registró un Alimento llamado: Apio','2025-08-03','14:38:44',12345678,1),(63,'Alimentos','Registró un Alimento llamado: Pepino','2025-08-03','14:39:09',12345678,1),(64,'Alimentos','Registró un Alimento llamado: Remolacha','2025-08-03','14:39:52',12345678,1),(65,'Alimentos','Registró un Alimento llamado: Coliflor','2025-08-03','14:40:33',12345678,1),(66,'Alimentos','Registró un Alimento llamado: Rabano','2025-08-03','14:41:22',12345678,1),(67,'Alimentos','Registró un Alimento llamado: Repollo','2025-08-03','14:41:42',12345678,1),(68,'Alimentos','Registró un Alimento llamado: Aji Dulce','2025-08-03','14:41:57',12345678,1),(69,'Alimentos','Registró un Alimento llamado: Cebollin','2025-08-03','14:42:11',12345678,1),(70,'Alimentos','Registró un Alimento llamado: Cilantro','2025-08-03','14:42:28',12345678,1),(71,'Alimentos','Registró un Alimento llamado: Manzana','2025-08-03','14:43:57',12345678,1),(72,'Alimentos','Registró un Alimento llamado: Naranja','2025-08-03','14:44:13',12345678,1),(73,'Alimentos','Registró un Alimento llamado: Platano','2025-08-03','14:44:39',12345678,1),(74,'Alimentos','Registró un Alimento llamado: Fresa','2025-08-03','14:44:57',12345678,1),(75,'Alimentos','Registró un Alimento llamado: Mango','2025-08-03','14:45:14',12345678,1),(76,'Alimentos','Registró un Alimento llamado: Uva','2025-08-03','14:54:28',12345678,1),(77,'Alimentos','Registró un Alimento llamado: Sandia','2025-08-03','14:54:53',12345678,1),(78,'Alimentos','Registró un Alimento llamado: Melon','2025-08-03','14:55:11',12345678,1),(79,'Alimentos','Registró un Alimento llamado: Pera','2025-08-03','14:55:55',12345678,1),(80,'Alimentos','Registró un Alimento llamado: Piña','2025-08-03','14:56:52',12345678,1),(81,'Alimentos','Registró un Alimento llamado: Mandarina','2025-08-03','14:57:21',12345678,1),(82,'Alimentos','Registró un Alimento llamado: Kiwi','2025-08-03','14:58:17',12345678,1),(83,'Alimentos','Registró un Alimento llamado: Lechoza','2025-08-03','14:58:37',12345678,1),(84,'Alimentos','Registró un Alimento llamado: Tamarindo','2025-08-03','14:58:57',12345678,1),(85,'Alimentos','Registró un Alimento llamado: Guayaba','2025-08-03','14:59:16',12345678,1),(86,'Alimentos','Registró un Alimento llamado: Cereza','2025-08-03','15:00:18',12345678,1),(87,'Alimentos','Registró un Alimento llamado: Durazno','2025-08-03','15:00:31',12345678,1),(88,'Alimentos','Registró un Alimento llamado: Guanabana','2025-08-03','15:00:43',12345678,1),(89,'Alimentos','Registró un Alimento llamado: Lentejas','2025-08-03','15:03:30',12345678,1),(90,'Alimentos','Registró un Alimento llamado: Caraotas Negras','2025-08-03','15:07:45',12345678,1),(91,'Alimentos','Registró un Alimento llamado: Caraotas Negras','2025-08-03','15:08:26',12345678,1),(92,'Alimentos','Registró un Alimento llamado: Caraotas Blancas','2025-08-03','15:08:48',12345678,1),(93,'Alimentos','Registró un Alimento llamado: Caraotas Rojas','2025-08-03','15:09:09',12345678,1),(94,'Alimentos','Registró un Alimento llamado: Frijoles Bayos','2025-08-03','15:09:35',12345678,1),(95,'Alimentos','Registró un Alimento llamado: Arvejas','2025-08-03','15:10:05',12345678,1),(96,'Alimentos','Registró un Alimento llamado: Jenjibre','2025-08-03','15:13:58',12345678,1),(97,'Alimentos','Registró un Alimento llamado: Nabo','2025-08-03','15:14:10',12345678,1),(98,'Alimentos','Registró un Alimento llamado: Ñame','2025-08-03','15:14:24',12345678,1),(99,'Alimentos','Registró un Alimento llamado: Ocumo','2025-08-03','15:14:38',12345678,1),(100,'Alimentos','Registró un Alimento llamado: Yuca','2025-08-03','15:15:11',12345678,1),(101,'Alimentos','Registró un Alimento llamado: Carne De Res','2025-08-03','15:20:19',12345678,1),(102,'Alimentos','Registró un Alimento llamado: Carne De Cerdo','2025-08-03','15:20:34',12345678,1),(103,'Alimentos','Registró un Alimento llamado: Pollo','2025-08-03','15:20:52',12345678,1),(104,'Alimentos','Registró un Alimento llamado: Salchicha De Pollo','2025-08-03','15:22:31',12345678,1),(105,'Alimentos','Registró un Alimento llamado: Bistec','2025-08-03','15:26:57',12345678,1),(106,'Alimentos','Registró un Alimento llamado: Chorizo','2025-08-03','15:27:13',12345678,1),(107,'Alimentos','Registró un Alimento llamado: Chuleta','2025-08-03','15:27:25',12345678,1),(108,'Alimentos','Registró un Alimento llamado: Jamon Arepero','2025-08-03','15:27:45',12345678,1),(109,'Alimentos','Registró un Alimento llamado: Jamon','2025-08-03','15:28:08',12345678,1),(110,'Alimentos','Registró un Alimento llamado: Jamon','2025-08-03','15:28:26',12345678,1),(111,'Alimentos','Registró un Alimento llamado: Carne Molida','2025-08-03','15:28:45',12345678,1),(112,'Alimentos','Registró un Alimento llamado: Mortadela Tapara','2025-08-03','15:29:07',12345678,1),(113,'Alimentos','Registró un Alimento llamado: Mortadela De Pollo','2025-08-03','15:29:38',12345678,1),(114,'Alimentos','Registró un Alimento llamado: Pepperoni','2025-08-03','15:30:02',12345678,1),(115,'Alimentos','Registró un Alimento llamado: Tocino','2025-08-03','15:30:44',12345678,1),(116,'Alimentos','Registró un Alimento llamado: Atun','2025-08-03','15:38:04',12345678,1),(117,'Alimentos','Registró un Alimento llamado: Bacalao','2025-08-03','15:38:18',12345678,1),(118,'Alimentos','Registró un Alimento llamado: Macarones','2025-08-03','15:39:01',12345678,1),(119,'Alimentos','Registró un Alimento llamado: Carite','2025-08-03','15:39:23',12345678,1),(120,'Alimentos','Registró un Alimento llamado: Mejillones','2025-08-03','15:39:52',12345678,1),(121,'Alimentos','Registró un Alimento llamado: Merlusa','2025-08-03','15:40:10',12345678,1),(122,'Alimentos','Registró un Alimento llamado: Salmon','2025-08-03','15:40:23',12345678,1),(123,'Alimentos','Registró un Alimento llamado: Sardina','2025-08-03','15:40:37',12345678,1),(124,'Consultar Alimentos','Se Modificó los datos del Alimento:Merluza','2025-08-03','15:40:55',12345678,1),(125,'Alimentos','Registró un Alimento llamado: Trucha','2025-08-03','15:43:13',12345678,1),(126,'Alimentos','Registró un Alimento llamado: Cachama','2025-08-03','15:43:30',12345678,1),(127,'Alimentos','Registró un Alimento llamado: Huevo De Gallina','2025-08-03','15:54:06',12345678,1),(128,'Alimentos','Registró un Alimento llamado: Huevo De Codorniz','2025-08-03','15:54:26',12345678,1),(129,'Alimentos','Registró un Alimento llamado: Leche Liquida','2025-08-03','16:14:47',12345678,1),(130,'Alimentos','Registró un Alimento llamado: Crema De Leche','2025-08-03','16:15:16',12345678,1),(131,'Alimentos','Registró un Alimento llamado: Queso Blanco','2025-08-03','16:15:41',12345678,1),(132,'Alimentos','Registró un Alimento llamado: Queso Mozzarella','2025-08-03','16:16:01',12345678,1),(133,'Alimentos','Registró un Alimento llamado: Queso Parmesano','2025-08-03','16:16:20',12345678,1),(134,'Alimentos','Registró un Alimento llamado: Suero','2025-08-03','16:16:42',12345678,1),(135,'Alimentos','Registró un Alimento llamado: Yogurt','2025-08-03','16:17:15',12345678,1),(136,'Alimentos','Registró un Alimento llamado: Agua Potable','2025-08-03','16:37:52',12345678,1),(137,'Alimentos','Registró un Alimento llamado: Refresco Coca Cola','2025-08-03','16:38:46',12345678,1),(138,'Alimentos','Registró un Alimento llamado: Jugo De Naranja','2025-08-03','16:39:07',12345678,1),(139,'Alimentos','Registró un Alimento llamado: Jugo De Naranja','2025-08-03','16:39:26',12345678,1),(140,'Alimentos','Registró un Alimento llamado: Jugo De Manzana','2025-08-03','16:39:48',12345678,1),(141,'Alimentos','Registró un Alimento llamado: Jugo De Pera','2025-08-03','16:40:13',12345678,1),(142,'Alimentos','Registró un Alimento llamado: Malta','2025-08-03','16:40:57',12345678,1),(143,'Alimentos','Registró un Alimento llamado: Refresco','2025-08-03','16:41:13',12345678,1),(144,'Consultar Alimentos','Se Modificó los datos del Alimento:Jugo De Naranja','2025-08-03','16:41:38',12345678,1),(145,'Alimentos','Registró un Alimento llamado: Curry En Polvo','2025-08-03','16:59:18',12345678,1),(146,'Alimentos','Registró un Alimento llamado: Adobo','2025-08-03','17:00:11',12345678,1),(147,'Alimentos','Registró un Alimento llamado: Ajo En Polvo','2025-08-03','17:00:36',12345678,1),(148,'Alimentos','Registró un Alimento llamado: Canela En Polvo','2025-08-03','17:01:11',12345678,1),(149,'Alimentos','Registró un Alimento llamado: Comino','2025-08-03','17:01:30',12345678,1),(150,'Alimentos','Registró un Alimento llamado: Mayonesa','2025-08-03','17:01:53',12345678,1),(151,'Alimentos','Registró un Alimento llamado: Mostaza','2025-08-03','17:02:16',12345678,1),(152,'Alimentos','Registró un Alimento llamado: Oregano','2025-08-03','17:02:36',12345678,1),(153,'Alimentos','Registró un Alimento llamado: Pimienta Negra','2025-08-03','17:03:11',12345678,1),(154,'Alimentos','Registró un Alimento llamado: Sal','2025-08-03','17:03:40',12345678,1),(155,'Alimentos','Registró un Alimento llamado: Salsa De Tomate Bologna','2025-08-03','17:04:18',12345678,1),(156,'Alimentos','Registró un Alimento llamado: Salsa De Soya','2025-08-03','17:04:40',12345678,1),(157,'Alimentos','Registró un Alimento llamado: Salsa De Tomate','2025-08-03','17:05:15',12345678,1),(158,'Consultar Alimentos','Se Modificó los datos del Alimento:Salsa De Soya','2025-08-03','17:06:10',12345678,1),(159,'Alimentos','Registró un Alimento llamado: Harina De Maiz','2025-08-03','17:20:00',12345678,1),(160,'Alimentos','Registró un Alimento llamado: Harina De Maiz','2025-08-03','17:21:13',12345678,1),(161,'Alimentos','Registró un Alimento llamado: Arroz','2025-08-03','17:21:47',12345678,1),(162,'Alimentos','Registró un Alimento llamado: Arroz','2025-08-03','17:22:40',12345678,1),(163,'Alimentos','Registró un Alimento llamado: Pasta Larga','2025-08-03','17:23:06',12345678,1),(164,'Alimentos','Registró un Alimento llamado: Pasta Corta De Pluma','2025-08-03','17:24:06',12345678,1),(165,'Alimentos','Registró un Alimento llamado: Pasta Corta De Codo','2025-08-03','17:24:46',12345678,1),(166,'Alimentos','Registró un Alimento llamado: Harina De Trigo','2025-08-03','17:25:16',12345678,1),(167,'Alimentos','Registró un Alimento llamado: Harina De Trigo','2025-08-03','17:26:49',12345678,1),(168,'Alimentos','Registró un Alimento llamado: Cheddar','2025-08-03','17:27:15',12345678,1),(169,'Alimentos','Registró un Alimento llamado: Diablitos','2025-08-03','17:28:00',12345678,1),(170,'Alimentos','Registró un Alimento llamado: Sardinas En Salsa De Tomate','2025-08-03','17:28:40',12345678,1),(171,'Alimentos','Registró un Alimento llamado: Mantequilla','2025-08-03','17:29:02',12345678,1),(172,'Alimentos','Registró un Alimento llamado: Aceite De Soja','2025-08-03','17:29:47',12345678,1),(173,'Alimentos','Registró un Alimento llamado: Sardinas En Aceite Vegetal','2025-08-03','17:32:06',12345678,1),(174,'Alimentos','Registró un Alimento llamado: Cafe','2025-08-03','17:32:28',12345678,1),(175,'Alimentos','Registró un Alimento llamado: Atun Enlatado','2025-08-03','17:32:54',12345678,1),(176,'Alimentos','Registró un Alimento llamado: Atun Enlatado','2025-08-03','17:33:38',12345678,1),(177,'Alimentos','Registró un Alimento llamado: Avena','2025-08-03','17:34:06',12345678,1),(178,'Alimentos','Registró un Alimento llamado: Cereal','2025-08-03','17:36:19',12345678,1),(179,'Alimentos','Registró un Alimento llamado: Cereal','2025-08-03','17:36:37',12345678,1),(180,'Alimentos','Registró un Alimento llamado: Cereal','2025-08-03','17:37:06',12345678,1),(181,'Alimentos','Registró un Alimento llamado: Pan Arabe','2025-08-03','17:39:58',12345678,1),(182,'Alimentos','Registró un Alimento llamado: Sandwich','2025-08-03','17:40:22',12345678,1),(183,'Alimentos','Registró un Alimento llamado: Pan Canilla','2025-08-03','17:40:44',12345678,1),(184,'Alimentos','Registró un Alimento llamado: Pan Piñita','2025-08-03','17:41:00',12345678,1),(185,'Alimentos','Registró un Alimento llamado: Pan Sobado','2025-08-03','17:41:29',12345678,1),(186,'Alimentos','Registró un Alimento llamado: Pan Frances','2025-08-03','17:41:46',12345678,1),(187,'Login','El Usuario Servicio Nutricional : Inició sesión','2025-08-03','17:45:48',12345678,1),(188,'Alimentos','Registró un Alimento llamado: Mini Pan De Guayaba','2025-08-03','17:46:18',12345678,1),(189,'Alimentos','Registró un Alimento llamado: Mini Pan De Arequipe','2025-08-03','17:46:39',12345678,1),(190,'Alimentos','Registró un Alimento llamado: Catalina','2025-08-03','17:47:07',12345678,1),(191,'Alimentos','Registró un Alimento llamado: Vinagre Blanco','2025-08-03','18:12:50',12345678,1),(192,'Alimentos','Registró un Alimento llamado: Maíz En Grano','2025-08-03','18:14:17',12345678,1),(193,'Alimentos','Registró un Alimento llamado: Mermelada De Fresa','2025-08-03','18:21:26',12345678,1),(194,'Alimentos','Registró un Alimento llamado: Chocolate En Polvo','2025-08-03','18:21:49',12345678,1),(195,'Alimentos','Registró un Alimento llamado: Galleta De Leche','2025-08-03','18:22:16',12345678,1),(196,'Alimentos','Registró un Alimento llamado: Azucar','2025-08-03','18:22:35',12345678,1),(197,'Alimentos','Registró un Alimento llamado: Crema De Mani','2025-08-03','18:22:55',12345678,1),(198,'Alimentos','Registró un Alimento llamado: Galleta Con Relleno De Fresa','2025-08-03','18:23:34',12345678,1),(199,'Alimentos','Registró un Alimento llamado: Galleta Con Relleno De Chocolate','2025-08-03','18:24:00',12345678,1),(200,'Alimentos','Registró un Alimento llamado: Galleta Con Relleno De Vainilla','2025-08-03','18:24:36',12345678,1),(201,'Alimentos','Registró un Alimento llamado: Galleta','2025-08-03','18:25:11',12345678,1),(202,'Alimentos','Registró un Alimento llamado: Mermelada De Guayaba','2025-08-03','18:25:45',12345678,1),(203,'Alimentos','Registró un Alimento llamado: Galleta De Chocolate','2025-08-03','18:26:11',12345678,1),(204,'Alimentos','Registró un Alimento llamado: Gelatina De Limon','2025-08-03','18:28:13',12345678,1),(205,'Alimentos','Registró un Alimento llamado: Gelatina De Fresa','2025-08-03','18:28:45',12345678,1),(206,'Alimentos','Registró un Alimento llamado: Leche Condensada','2025-08-03','18:31:14',12345678,1),(207,'Login','El Usuario Servicio Nutricional : Inició sesión','2025-08-03','21:07:30',12345678,1),(208,'Login','El Usuario Servicio Nutricional : Inició sesión','2025-08-11','17:26:25',12345678,1),(209,'Tipos Utensilios','Registró un Tipo Utensilios llamado: Bandejas','2025-08-11','17:26:48',12345678,1),(210,'Login','El usuario Servicio Nutricional   cerró sesión ','2025-08-11','17:27:19',12345678,1),(211,'Login','El Usuario Servicio Nutricional : Inició sesión','2025-08-11','17:28:11',12345678,1),(212,'Mantenimiento','Último Mantenimiento (Importación) realizado el 2025-08-29 15:35:00','2025-08-29','15:35:00',12345678,1),(213,'Mantenimiento','Último Mantenimiento (Importación) realizado el 2025-08-29 15:39:42','2025-08-29','15:39:42',12345678,1),(214,'Alimentos','Registró un Alimento llamado: Avena','2025-08-29','15:39:51',12345678,1),(215,'Alimentos','Registró un Alimento llamado: Diablito','2025-08-29','15:39:51',12345678,1),(216,'Mantenimiento','Último Mantenimiento (Exportación) realizado el 2025-08-29 15:44:00','2025-08-29','15:44:00',12345678,1);
/*!40000 ALTER TABLE `bitacora` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modulo`
--

DROP TABLE IF EXISTS `modulo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modulo` (
  `idModulo` int(11) NOT NULL AUTO_INCREMENT,
  `nombreModulo` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`idModulo`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modulo`
--

LOCK TABLES `modulo` WRITE;
/*!40000 ALTER TABLE `modulo` DISABLE KEYS */;
INSERT INTO `modulo` VALUES (1,'Home',1),(2,'Usuarios',1),(3,'Roles',1),(4,'Modulos',1),(5,'Permisos',1),(6,'Bitacora',1),(7,'Estudiantes',1),(8,'Asistencias',1),(9,'Menú',1),(10,'Eventos',1),(11,'Tipos de Alimentos',1),(12,'Alimentos',1),(13,'Inventario de Alimentos',1),(14,'Tipos de Utensilios',1),(15,'Utensilios',1),(16,'Inventario de Utensilios',1),(17,'Tipos de Salidas',1),(18,'Reporte Estadistico',1),(19,'Mantenimiento',1);
/*!40000 ALTER TABLE `modulo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notificaciones`
--

DROP TABLE IF EXISTS `notificaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notificaciones` (
  `idNotificaciones` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `mensaje` text NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `fechaNoti` date NOT NULL,
  PRIMARY KEY (`idNotificaciones`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notificaciones`
--

LOCK TABLES `notificaciones` WRITE;
/*!40000 ALTER TABLE `notificaciones` DISABLE KEYS */;
INSERT INTO `notificaciones` VALUES (1,'Nuevo Tipo de Utensilio','Se ha registrado un nuevo tipo de utensilio llamado: Bandejas','informacion','0000-00-00');
/*!40000 ALTER TABLE `notificaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notificaciones_usuarios`
--

DROP TABLE IF EXISTS `notificaciones_usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notificaciones_usuarios` (
  `cedula` int(11) NOT NULL,
  `idNotificaciones` int(11) NOT NULL,
  `leida` int(11) DEFAULT NULL,
  PRIMARY KEY (`cedula`,`idNotificaciones`),
  KEY `idNotificaciones` (`idNotificaciones`),
  CONSTRAINT `notificaciones_usuarios_ibfk_1` FOREIGN KEY (`cedula`) REFERENCES `usuario` (`cedula`),
  CONSTRAINT `notificaciones_usuarios_ibfk_2` FOREIGN KEY (`idNotificaciones`) REFERENCES `notificaciones` (`idNotificaciones`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notificaciones_usuarios`
--

LOCK TABLES `notificaciones_usuarios` WRITE;
/*!40000 ALTER TABLE `notificaciones_usuarios` DISABLE KEYS */;
INSERT INTO `notificaciones_usuarios` VALUES (12345678,1,0);
/*!40000 ALTER TABLE `notificaciones_usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permiso`
--

DROP TABLE IF EXISTS `permiso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permiso` (
  `idPermiso` int(11) NOT NULL AUTO_INCREMENT,
  `nombrePermiso` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `idRol` int(11) NOT NULL,
  `idModulo` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`idPermiso`),
  KEY `idRol` (`idRol`),
  KEY `idModulo` (`idModulo`),
  CONSTRAINT `permiso_ibfk_1` FOREIGN KEY (`idRol`) REFERENCES `rol` (`idRol`),
  CONSTRAINT `permiso_ibfk_2` FOREIGN KEY (`idModulo`) REFERENCES `modulo` (`idModulo`)
) ENGINE=InnoDB AUTO_INCREMENT=390 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permiso`
--

LOCK TABLES `permiso` WRITE;
/*!40000 ALTER TABLE `permiso` DISABLE KEYS */;
INSERT INTO `permiso` VALUES (1,'consultar',1,1,1),(3,'consultar',1,2,1),(4,'registrar',1,2,1),(5,'modificar',1,2,1),(6,'eliminar',1,2,1),(7,'consultar',1,3,1),(8,'registrar',1,3,1),(9,'modificar',1,3,1),(10,'eliminar',1,3,1),(11,'consultar',1,4,1),(12,'modificar',1,4,1),(13,'consultar',1,5,1),(14,'modificar',1,5,1),(15,'consultar',1,6,1),(16,'consultar',1,7,1),(17,'registrar',1,7,1),(18,'consultar',1,8,1),(19,'registrar',1,8,1),(20,'modificar',1,8,1),(21,'eliminar',1,8,1),(22,'consultar',1,9,1),(23,'registrar',1,9,1),(24,'modificar',1,9,1),(25,'eliminar',1,9,1),(26,'consultar',1,10,1),(27,'registrar',1,10,1),(28,'modificar',1,10,1),(29,'modificar',1,10,1),(30,'eliminar',1,10,1),(31,'consultar',1,11,1),(32,'registrar',1,11,1),(33,'modificar',1,11,1),(34,'eliminar',1,11,1),(35,'consultar',1,12,1),(36,'registrar',1,12,1),(37,'modificar',1,12,1),(38,'eliminar',1,12,1),(39,'consultar',1,13,1),(40,'registrar',1,13,1),(41,'eliminar',1,13,1),(42,'consultar',1,14,1),(43,'registrar',1,14,1),(44,'modificar',1,14,1),(45,'eliminar',1,14,1),(46,'consultar',1,15,1),(47,'registrar',1,15,1),(48,'modificar',1,15,1),(49,'eliminar',1,15,1),(50,'consultar',1,16,1),(51,'registrar',1,16,1),(52,'eliminar',1,16,1),(53,'consultar',1,17,1),(54,'registrar',1,17,1),(55,'modificar',1,17,1),(56,'eliminar',1,17,1),(57,'consultar',1,18,1),(58,'Exportar',1,19,1),(59,'Importar',1,19,1),(60,'consultar',2,1,1),(61,'consultar',2,2,0),(62,'registrar',2,2,0),(63,'modificar',2,2,0),(64,'eliminar',2,2,0),(65,'consultar',2,3,0),(66,'registrar',2,3,0),(67,'modificar',2,3,0),(68,'eliminar',2,3,0),(69,'consultar',2,4,0),(70,'modificar',2,4,0),(71,'consultar',2,5,0),(72,'modificar',2,5,0),(73,'consultar',2,6,0),(74,'consultar',2,7,0),(75,'registrar',2,7,0),(76,'consultar',2,8,0),(77,'registrar',2,8,0),(78,'consultar',2,9,0),(79,'registrar',2,9,0),(80,'modificar',2,9,0),(81,'eliminar',2,9,0),(82,'consultar',2,10,0),(83,'registrar',2,10,0),(84,'modificar',2,10,0),(85,'eliminar',2,10,0),(86,'consultar',2,11,0),(87,'registrar',2,11,0),(88,'modificar',2,11,0),(89,'eliminar',2,11,0),(90,'consultar',2,12,0),(91,'registrar',2,12,0),(92,'modificar',2,12,0),(93,'eliminar',2,12,0),(94,'consultar',2,13,0),(95,'registrar',2,13,0),(96,'eliminar',2,13,0),(97,'consultar',2,14,0),(98,'registrar',2,14,0),(99,'modificar',2,14,0),(100,'eliminar',2,14,0),(101,'consultar',2,15,0),(102,'registrar',2,15,0),(103,'modificar',2,15,0),(104,'eliminar',2,15,0),(105,'consultar',2,16,0),(106,'registrar',2,16,0),(107,'eliminar',2,16,0),(108,'consultar',2,17,0),(109,'registrar',2,17,0),(110,'modificar',2,17,0),(111,'eliminar',2,17,0),(112,'consultar',2,18,0),(113,'Exportar',2,19,0),(114,'Importar',2,19,0),(115,'consultar',3,1,1),(116,'consultar',3,2,0),(117,'registrar',3,2,0),(118,'modificar',3,2,0),(119,'eliminar',3,2,0),(120,'consultar',3,3,0),(121,'registrar',3,3,0),(122,'modificar',3,3,0),(123,'eliminar',3,3,0),(124,'consultar',3,4,0),(125,'modificar',3,4,0),(126,'consultar',3,5,0),(127,'modificar',3,5,0),(128,'consultar',3,6,0),(129,'consultar',3,7,0),(130,'registrar',3,7,0),(131,'consultar',3,8,0),(132,'registrar',3,8,0),(133,'consultar',3,9,0),(134,'registrar',3,9,0),(135,'modificar',3,9,0),(136,'eliminar',3,9,0),(137,'consultar',3,10,0),(138,'registrar',3,10,0),(139,'modificar',3,10,0),(140,'eliminar',3,10,0),(141,'consultar',3,11,0),(142,'registrar',3,11,0),(143,'modificar',3,11,0),(144,'eliminar',3,11,0),(145,'consultar',3,12,0),(146,'registrar',3,12,0),(147,'modificar',3,12,0),(148,'eliminar',3,12,0),(149,'consultar',3,13,0),(150,'registrar',3,13,0),(151,'eliminar',3,13,0),(152,'consultar',3,14,0),(153,'registrar',3,14,0),(154,'modificar',3,14,0),(155,'eliminar',3,14,0),(156,'consultar',3,15,0),(157,'registrar',3,15,0),(158,'modificar',3,15,0),(159,'eliminar',3,15,0),(160,'consultar',3,16,0),(161,'registrar',3,16,0),(162,'eliminar',3,16,0),(163,'consultar',3,17,0),(164,'registrar',3,17,0),(165,'modificar',3,17,0),(166,'eliminar',3,17,0),(167,'consultar',3,18,0),(168,'Exportar',3,19,0),(169,'Importar',3,19,0),(170,'consultar',4,1,1),(171,'consultar',4,2,0),(172,'registrar',4,2,0),(173,'modificar',4,2,0),(174,'eliminar',4,2,0),(175,'consultar',4,3,0),(176,'registrar',4,3,0),(177,'modificar',4,3,0),(178,'eliminar',4,3,0),(179,'consultar',4,4,0),(180,'modificar',4,4,0),(181,'consultar',4,5,0),(182,'modificar',4,5,0),(183,'consultar',4,6,0),(184,'consultar',4,7,0),(185,'registrar',4,7,0),(186,'consultar',4,8,0),(187,'registrar',4,8,0),(188,'consultar',4,9,0),(189,'registrar',4,9,0),(190,'modificar',4,9,0),(191,'eliminar',4,9,0),(192,'consultar',4,10,0),(193,'registrar',4,10,0),(194,'modificar',4,10,0),(195,'eliminar',4,10,0),(196,'consultar',4,11,0),(197,'registrar',4,11,0),(198,'modificar',4,11,0),(199,'eliminar',4,11,0),(200,'consultar',4,12,0),(201,'registrar',4,12,0),(202,'modificar',4,12,0),(203,'eliminar',4,12,0),(204,'consultar',4,13,0),(205,'registrar',4,13,0),(206,'eliminar',4,13,0),(207,'consultar',4,14,0),(208,'registrar',4,14,0),(209,'modificar',4,14,0),(210,'eliminar',4,14,0),(211,'consultar',4,15,0),(212,'registrar',4,15,0),(213,'modificar',4,15,0),(214,'eliminar',4,15,0),(215,'consultar',4,16,0),(216,'registrar',4,16,0),(217,'eliminar',4,16,0),(218,'consultar',4,17,0),(219,'registrar',4,17,0),(220,'modificar',4,17,0),(221,'eliminar',4,17,0),(222,'consultar',4,18,0),(223,'Exportar',4,19,0),(224,'Importar',4,19,0),(225,'consultar',5,1,1),(226,'consultar',5,2,0),(227,'registrar',5,2,0),(228,'modificar',5,2,0),(229,'eliminar',5,2,0),(230,'consultar',5,3,0),(231,'registrar',5,3,0),(232,'modificar',5,3,0),(233,'eliminar',5,3,0),(234,'consultar',5,4,0),(235,'modificar',5,4,0),(236,'consultar',5,5,0),(237,'modificar',5,5,0),(238,'consultar',5,6,0),(239,'consultar',5,7,0),(240,'registrar',5,7,0),(241,'consultar',5,8,0),(242,'registrar',5,8,0),(243,'consultar',5,9,0),(244,'registrar',5,9,0),(245,'modificar',5,9,0),(246,'eliminar',5,9,0),(247,'consultar',5,10,0),(248,'registrar',5,10,0),(249,'modificar',5,10,0),(250,'eliminar',5,10,0),(251,'consultar',5,11,0),(252,'registrar',5,11,0),(253,'modificar',5,11,0),(254,'eliminar',5,11,0),(255,'consultar',5,12,0),(256,'registrar',5,12,0),(257,'modificar',5,12,0),(258,'eliminar',5,12,0),(259,'consultar',5,13,0),(260,'registrar',5,13,0),(261,'eliminar',5,13,0),(262,'consultar',5,14,0),(263,'registrar',5,14,0),(264,'modificar',5,14,0),(265,'eliminar',5,14,0),(266,'consultar',5,15,0),(267,'registrar',5,15,0),(268,'modificar',5,15,0),(269,'eliminar',5,15,0),(270,'consultar',5,16,0),(271,'registrar',5,16,0),(272,'eliminar',5,16,0),(273,'consultar',5,17,0),(274,'registrar',5,17,0),(275,'modificar',5,17,0),(276,'eliminar',5,17,0),(277,'consultar',5,18,0),(278,'Exportar',5,19,0),(279,'Importar',5,19,0),(280,'consultar',6,1,1),(281,'consultar',6,2,0),(282,'registrar',6,2,0),(283,'modificar',6,2,0),(284,'eliminar',6,2,0),(285,'consultar',6,3,0),(286,'registrar',6,3,0),(287,'modificar',6,3,0),(288,'eliminar',6,3,0),(289,'consultar',6,4,0),(290,'modificar',6,4,0),(291,'consultar',6,5,0),(292,'modificar',6,5,0),(293,'consultar',6,6,0),(294,'consultar',6,7,0),(295,'registrar',6,7,0),(296,'consultar',6,8,0),(297,'registrar',6,8,0),(298,'consultar',6,9,0),(299,'registrar',6,9,0),(300,'modificar',6,9,0),(301,'eliminar',6,9,0),(302,'consultar',6,10,0),(303,'registrar',6,10,0),(304,'modificar',6,10,0),(305,'eliminar',6,10,0),(306,'consultar',6,11,0),(307,'registrar',6,11,0),(308,'modificar',6,11,0),(309,'eliminar',6,11,0),(310,'consultar',6,12,0),(311,'registrar',6,12,0),(312,'modificar',6,12,0),(313,'eliminar',6,12,0),(314,'consultar',6,13,0),(315,'registrar',6,13,0),(316,'eliminar',6,13,0),(317,'consultar',6,14,0),(318,'registrar',6,14,0),(319,'modificar',6,14,0),(320,'eliminar',6,14,0),(321,'consultar',6,15,0),(322,'registrar',6,15,0),(323,'modificar',6,15,0),(324,'eliminar',6,15,0),(325,'consultar',6,16,0),(326,'registrar',6,16,0),(327,'eliminar',6,16,0),(328,'consultar',6,17,0),(329,'registrar',6,17,0),(330,'modificar',6,17,0),(331,'eliminar',6,17,0),(332,'consultar',6,18,0),(333,'Exportar',6,19,0),(334,'Importar',6,19,0),(335,'consultar',7,1,1),(336,'consultar',7,2,0),(337,'registrar',7,2,0),(338,'modificar',7,2,0),(339,'eliminar',7,2,0),(340,'consultar',7,3,0),(341,'registrar',7,3,0),(342,'modificar',7,3,0),(343,'eliminar',7,3,0),(344,'consultar',7,4,0),(345,'modificar',7,4,0),(346,'consultar',7,5,0),(347,'modificar',7,5,0),(348,'consultar',7,6,0),(349,'consultar',7,7,0),(350,'registrar',7,7,0),(351,'consultar',7,8,0),(352,'registrar',7,8,0),(353,'consultar',7,9,0),(354,'registrar',7,9,0),(355,'modificar',7,9,0),(356,'eliminar',7,9,0),(357,'consultar',7,10,0),(358,'registrar',7,10,0),(359,'modificar',7,10,0),(360,'eliminar',7,10,0),(361,'consultar',7,11,0),(362,'registrar',7,11,0),(363,'modificar',7,11,0),(364,'eliminar',7,11,0),(365,'consultar',7,12,0),(366,'registrar',7,12,0),(367,'modificar',7,12,0),(368,'eliminar',7,12,0),(369,'consultar',7,13,0),(370,'registrar',7,13,0),(371,'eliminar',7,13,0),(372,'consultar',7,14,0),(373,'registrar',7,14,0),(374,'modificar',7,14,0),(375,'eliminar',7,14,0),(376,'consultar',7,15,0),(377,'registrar',7,15,0),(378,'modificar',7,15,0),(379,'eliminar',7,15,0),(380,'consultar',7,16,0),(381,'registrar',7,16,0),(382,'eliminar',7,16,0),(383,'consultar',7,17,0),(384,'registrar',7,17,0),(385,'modificar',7,17,0),(386,'eliminar',7,17,0),(387,'consultar',7,18,0),(388,'Exportar',7,19,0),(389,'Importar',7,19,0);
/*!40000 ALTER TABLE `permiso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rol`
--

DROP TABLE IF EXISTS `rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rol` (
  `idRol` int(11) NOT NULL AUTO_INCREMENT,
  `nombreRol` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`idRol`),
  KEY `idx_rol_idRol` (`idRol`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rol`
--

LOCK TABLES `rol` WRITE;
/*!40000 ALTER TABLE `rol` DISABLE KEYS */;
INSERT INTO `rol` VALUES (1,'Super Usuario',1),(2,'Cocinero',1),(3,'Jefe De Cocina',1),(4,'Coord Serv Nutricional',1),(5,'Asistente De Bienestar Estudiantil',1),(6,'Control De Estudio',1),(7,'Encargado',1);
/*!40000 ALTER TABLE `rol` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `cedula` int(11) NOT NULL,
  `img` varchar(10000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `segNombre` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `segApellido` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `clave` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `idRol` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`cedula`),
  KEY `idx_usuario_idRol` (`idRol`),
  KEY `idx_usuario_cedula` (`cedula`),
  KEY `idx_usuario_correo` (`correo`),
  KEY `idx_usuario_telefono` (`telefono`),
  KEY `idx_usuario_status` (`status`),
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`idRol`) REFERENCES `rol` (`idRol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (12345678,'assets/images/perfil/user.png','Servicio','Andres','Nutricional ','Eloy','ydjYy701fmCFBES2ecJ1SZm0WBfzpLfIVL0IAnlf52VBbvcNHQ/Ey1csGeE6ASwN','0424 - 0000099','$2y$10$M.vMxIOMqGZGDDW6RLoOOOkmDC5AIDzAkM0J2WeNtlGeV6OwcHYL.',1,1);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `vista_bitacora_usuario`
--

DROP TABLE IF EXISTS `vista_bitacora_usuario`;
/*!50001 DROP VIEW IF EXISTS `vista_bitacora_usuario`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `vista_bitacora_usuario` AS SELECT
 1 AS `idBitacora`,
  1 AS `modulo`,
  1 AS `fecha`,
  1 AS `hora`,
  1 AS `cedula`,
  1 AS `nombre`,
  1 AS `apellido`,
  1 AS `img`,
  1 AS `idRol` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `vista_usuarios_info`
--

DROP TABLE IF EXISTS `vista_usuarios_info`;
/*!50001 DROP VIEW IF EXISTS `vista_usuarios_info`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `vista_usuarios_info` AS SELECT
 1 AS `cedula`,
  1 AS `img`,
  1 AS `nombre`,
  1 AS `segNombre`,
  1 AS `apellido`,
  1 AS `segApellido`,
  1 AS `correo`,
  1 AS `telefono`,
  1 AS `status`,
  1 AS `idRol`,
  1 AS `nombreRol` */;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `vista_bitacora_usuario`
--

/*!50001 DROP VIEW IF EXISTS `vista_bitacora_usuario`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vista_bitacora_usuario` AS select `b`.`idBitacora` AS `idBitacora`,`b`.`modulo` AS `modulo`,`b`.`fecha` AS `fecha`,`b`.`hora` AS `hora`,`b`.`cedula` AS `cedula`,`u`.`nombre` AS `nombre`,`u`.`apellido` AS `apellido`,`u`.`img` AS `img`,`u`.`idRol` AS `idRol` from (`bitacora` `b` join `usuario` `u` on(`u`.`cedula` = `b`.`cedula`)) where `b`.`status` = 1 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vista_usuarios_info`
--

/*!50001 DROP VIEW IF EXISTS `vista_usuarios_info`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vista_usuarios_info` AS select `u`.`cedula` AS `cedula`,`u`.`img` AS `img`,`u`.`nombre` AS `nombre`,`u`.`segNombre` AS `segNombre`,`u`.`apellido` AS `apellido`,`u`.`segApellido` AS `segApellido`,`u`.`correo` AS `correo`,`u`.`telefono` AS `telefono`,`u`.`status` AS `status`,`r`.`idRol` AS `idRol`,`r`.`nombreRol` AS `nombreRol` from (`usuario` `u` join `rol` `r` on(`u`.`idRol` = `r`.`idRol`)) where `r`.`idRol` <> 1 and `u`.`status` <> 0 */;
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

-- Dump completed on 2025-08-29 15:44:30
