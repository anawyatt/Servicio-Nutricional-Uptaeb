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
  KEY `cedula` (`cedula`),
  CONSTRAINT `bitacora_ibfk_1` FOREIGN KEY (`cedula`) REFERENCES `usuario` (`cedula`)
) ENGINE=InnoDB AUTO_INCREMENT=22593 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bitacora`
--

LOCK TABLES `bitacora` WRITE;
/*!40000 ALTER TABLE `bitacora` DISABLE KEYS */;
INSERT INTO `bitacora` VALUES (22369,'Login','El usuario Servicio Nutricional   cerró sesión ','2024-11-30','20:41:56',12345678,1),(22370,'Inventario de Alimentos - Entrada','Registró una entrada de alimentos en la fecha y hora: 2024-12-01 - 19:19 la cual describe que es :  lacteos y proteinas','2024-12-01','19:20:03',12345678,1),(22371,'Inventario de los Alimentos - Entrada','Consultó las entradas de los alimentos','2024-12-01','19:20:07',12345678,1),(22372,'Inventario de los Alimentos - Entrada','Consultó las entradas de los alimentos','2024-12-01','19:20:22',12345678,1),(22373,'Inventario de los Alimentos - Entrada','Consultó las entradas de los alimentos','2024-12-01','19:22:00',12345678,1),(22374,'Inventario de los Alimentos - Entrada','Consultó las entradas de los alimentos','2024-12-01','19:24:16',12345678,1),(22375,'Inventario de los Alimentos - Entrada','Consultó las entradas de los alimentos','2024-12-01','19:25:00',12345678,1),(22376,'Inventario de los Alimentos - Entrada','Consultó las entradas de los alimentos','2024-12-01','19:27:25',12345678,1),(22377,'Inventario de los Alimentos - Entrada','Consultó las entradas de los alimentos','2024-12-01','19:27:58',12345678,1),(22378,'Inventario de los Alimentos - Entrada','Consultó las entradas de los alimentos','2024-12-01','19:29:04',12345678,1),(22379,'Inventario de los Alimentos - Entrada','Consultó las entradas de los alimentos','2024-12-01','19:30:43',12345678,1),(22380,'Inventario de Alimentos - Salida','Registró una salida de alimentos  en la fecha y hora: 2024-12-01 - 2024-12-01 la cual describe el motivo :  se daño','2024-12-01','19:33:05',12345678,1),(22381,'Inventario de los Alimentos - Salida','Consultó las salidas de los alimentos','2024-12-01','19:33:08',12345678,1),(22382,'Menú','Se registró un menú para el dia: 2024-12-03 n° comensales: 60','2024-12-01','19:35:49',12345678,1),(22383,'Menú','Se despachó el alimento Crema De Leche cantidad: 10 Unidad','2024-12-01','19:35:49',12345678,1),(22384,'Menú','Se despachó el alimento Pollo Entero cantidad: 15 Kl','2024-12-01','19:35:49',12345678,1),(22385,'Menú','Se descontaron los alimentos del Menú 37','2024-12-01','19:37:22',12345678,1),(22386,'Eventos','Se registró un evento para el dia: 2024-12-03 n° comensales: 50','2024-12-01','19:44:17',12345678,1),(22387,'Menú','Se despachó el alimento Crema De Leche cantidad: 8 Unidad','2024-12-01','19:44:17',12345678,1),(22388,'Menú','Se despachó el alimento Pollo Entero cantidad: 10 Kl','2024-12-01','19:44:17',12345678,1),(22389,'Menú','Se descontaron los alimentos del Menú 38','2024-12-01','19:44:45',12345678,1),(22390,'Entrada Utensilios','Registró una entrada de Utensilios el día 2024-12-01 a la hora 19:45 con la siguiente descripción: compra','2024-12-01','19:45:23',12345678,1),(22391,'Salida Utensilios','Registró una salida de Utensilios el día 2024-12-01 con la siguiente descripción: se daño','2024-12-01','19:57:43',12345678,1),(22392,'Consultar Salida Utensilios','Se realizó una consulta de la fecha 2024-12-17 hasta la fecha ','2024-12-01','19:59:38',12345678,1),(22393,'Consultar Salida Utensilios','Se realizó una consulta de la fecha 2024-12-17 hasta la fecha 2024-11-17','2024-12-01','19:59:45',12345678,1),(22394,'Consultar Salida Utensilios','Se realizó una consulta de la fecha 2024-11-17 hasta la fecha 2024-11-17','2024-12-01','19:59:51',12345678,1),(22395,'Consultar Salida Utensilios','Se realizó una consulta de la fecha 2024-11-17 hasta la fecha 2024-11-19','2024-12-01','19:59:55',12345678,1),(22396,'Consultar Salida Utensilios','Se realizó una consulta de la fecha 2024-12-17 hasta la fecha ','2024-12-01','20:01:51',12345678,1),(22397,'Consultar Salida Utensilios','Se realizó una consulta de la fecha 2024-12-17 hasta la fecha 2024-12-19','2024-12-01','20:01:55',12345678,1),(22398,'Consultar Salida Utensilios','Se realizó una consulta de la fecha 2024-11-17 hasta la fecha 2024-12-19','2024-12-01','20:02:00',12345678,1),(22399,'Consultar Salida Utensilios','Se realizó una consulta de la fecha 2024-11-17 hasta la fecha 2024-11-19','2024-12-01','20:02:06',12345678,1),(22400,'Inventario de los Alimentos - Entrada','Consultó las entradas de los alimentos','2024-12-01','20:03:00',12345678,1),(22401,'Inventario de Alimentos - Entrada','Registró una entrada de alimentos en la fecha y hora: 2024-12-01 - 20:03 la cual describe que es :  compras','2024-12-01','20:04:12',12345678,1),(22402,'Inventario de los Alimentos - Entrada','Consultó las entradas de los alimentos','2024-12-01','20:04:14',12345678,1),(22403,'Inventario de los Alimentos - Entrada','Consultó las entradas de los alimentos','2024-12-01','20:04:59',12345678,1),(22404,'Inventario de los Alimentos - Entrada','Consultó las entradas  de los alimentos de la fecha : 2024-12-01 hasta la fecha: 2024-12-01','2024-12-01','20:05:01',12345678,1),(22405,'Inventario de los Alimentos - Entrada','Consultó las entradas de los alimentos','2024-12-01','20:26:41',12345678,1),(22406,'Inventario de los Alimentos - Entrada','Consultó las entradas de los alimentos','2024-12-01','20:27:34',12345678,1),(22407,'Inventario de los Alimentos - Entrada','Consultó las entradas de los alimentos','2024-12-01','20:27:43',12345678,1),(22408,'Inventario de los Alimentos - Entrada','Consultó las entradas  de los alimentos de la fecha : 2024-12-01 hasta la fecha: 2024-12-02','2024-12-01','20:27:49',12345678,1),(22409,'Inventario de los Alimentos - Entrada','Consultó las entradas de los alimentos','2024-12-01','20:41:54',12345678,1),(22410,'Consultar Salida Utensilios','Se realizó una consulta de la fecha 2024-11-26 hasta la fecha ','2024-12-01','20:42:26',12345678,1),(22411,'Consultar Salida Utensilios','Se realizó una consulta de la fecha 2024-11-17 hasta la fecha ','2024-12-01','20:42:33',12345678,1),(22412,'Consultar Salida Utensilios','Se realizó una consulta de la fecha 2024-11-17 hasta la fecha 2024-12-19','2024-12-01','20:42:37',12345678,1),(22413,'Consultar Salida Utensilios','Se realizó una consulta de la fecha 2024-11-17 hasta la fecha 2024-11-28','2024-12-01','20:42:41',12345678,1),(22414,'Inventario de los Alimentos - Entrada','Consultó las entradas de los alimentos','2024-12-01','20:43:40',12345678,1),(22415,'Inventario de los Alimentos - Entrada','Consultó las entradas de los alimentos','2024-12-01','20:43:46',12345678,1),(22416,'Inventario de los Alimentos - Entrada','Consultó las entradas  de los alimentos de la fecha : 2024-12-01 hasta la fecha: 2024-12-02','2024-12-01','20:43:50',12345678,1),(22417,'Perfil','Modifico sus datos personales ','2024-12-01','20:44:25',12345678,1),(22418,'Estudiantes','Se han registrado un total de 1231 estudiantes.','2024-12-03','13:02:19',12345678,1),(22419,'Login','El usuario Servicio Nutricional  cerró sesión ','2024-12-03','13:06:00',12345678,1),(22420,'Perfil','Modifico sus datos personales ','2024-12-07','19:48:56',12345678,1),(22421,'Login','El usuario Servicio Nutricional  cerró sesión ','2024-12-07','19:49:02',12345678,1),(22422,'Login','El Usuario Ana Wyatt: Inició al sistema en el horario de Desayuno','2024-12-07','19:49:14',30483987,1),(22423,'Login','El Usuario Ana Wyatt: Inició al sistema en el horario de Almuerzo','2024-12-07','19:50:27',30483987,1),(22424,'Login','El usuario Ana Wyatt  cerró sesión ','2024-12-07','19:50:45',30483987,1),(22425,'Inventario de los Alimentos - Entrada','Consultó las entradas de los alimentos','2025-01-08','19:38:06',12345678,1),(22426,'Inventario de los Alimentos - Entrada','Consultó las entradas de los alimentos','2025-01-08','19:38:09',12345678,1),(22427,'Inventario de los Alimentos - Entrada','Consultó las entradas de los alimentos','2025-01-08','19:38:15',12345678,1),(22428,'Inventario de los Alimentos - Entrada','Consultó las entradas de los alimentos','2025-01-08','19:41:02',12345678,1),(22429,'Inventario de los Alimentos - Salida','Consultó las salidas de los alimentos','2025-01-08','19:48:40',12345678,1),(22430,'Perfil','cambio su foto de perfil ','2025-01-08','19:49:13',12345678,1),(22431,'Login','La cuenta del usuario  Servicio Nutricional se cerró por inactividad ','2025-01-16','20:15:18',12345678,1),(22432,'Login','La cuenta del usuario  Servicio Nutricional se cerró por inactividad ','2025-01-16','20:15:19',12345678,1),(22433,'Login','La cuenta del usuario  Servicio Nutricional se cerró por inactividad ','2025-01-16','20:15:19',12345678,1),(22434,'Login','La cuenta del usuario  Servicio Nutricional se cerró por inactividad ','2025-01-16','20:15:19',12345678,1),(22435,'Alimentos','Registró un Alimento llamado: Queso Crema','2025-02-06','17:23:44',12345678,1),(22436,'Inventario de Alimentos - Stock','Consultó los estocks de los alimentos','2025-02-06','19:59:44',12345678,1),(22437,'Inventario de Alimentos - Stock','Consultó los estocks de los alimentos','2025-02-06','19:59:51',12345678,1),(22438,'Inventario de Alimentos - Stock','Consultó los estocks de los alimentos','2025-02-06','19:59:56',12345678,1),(22439,'Inventario de Alimentos - Stock','Consultó los estocks de los alimentos','2025-02-06','20:00:10',12345678,1),(22440,'Reportes Estadísticos','Consultó el total de menus por horario ','2025-02-06','20:00:28',12345678,1),(22441,'Reportes Estadísticos','Consultó los alimentos mas ingresados al inventario','2025-02-06','20:00:59',12345678,1),(22442,'Reportes Estadísticos','Consultó el total el tipo de alimentos mas sacados por menus','2025-02-06','20:01:43',12345678,1),(22443,'Reportes Estadísticos','Consultó los tipos de alimentos mas sacados por Donación o Merma','2025-02-06','20:02:05',12345678,1),(22444,'Reportes Estadísticos','Consultó los utensilios mas ingresados al inventario','2025-02-06','20:02:47',12345678,1),(22445,'Reportes Estadísticos','Consultó los utensilios mas ingresados al inventario','2025-02-06','20:03:19',12345678,1),(22446,'Reportes Estadísticos','Consultó los tipos de utensilios mas sacados en el inventario','2025-02-06','20:03:27',12345678,1),(22447,'Reportes Estadísticos','Consultó los utensilios mas ingresados al inventario','2025-02-06','20:03:44',12345678,1),(22448,'Reportes Estadísticos','Consultó los tipos de utensilios mas sacados en el inventario','2025-02-06','20:03:55',12345678,1),(22449,'Reportes Estadísticos','Consultó el total de entradas de utensilios','2025-02-06','20:03:59',12345678,1),(22450,'Inventario de Alimentos - Stock','Consultó los estocks de los alimentos','2025-02-06','20:07:20',12345678,1),(22451,'Reportes Estadísticos','Consultó el total de eventos por horario de Menu','2025-06-13','21:58:25',12345678,1),(22452,'Reportes Estadísticos','Consultó el total de entradas de alimentos','2025-06-13','22:21:52',12345678,1),(22453,'Reportes Estadísticos','Consultó los alimentos mas ingresados al inventario','2025-06-13','22:21:56',12345678,1),(22454,'Reportes Estadísticos','Consultó los utensilios mas ingresados al inventario','2025-06-13','22:21:59',12345678,1),(22455,'Tipos De Alimentos','Registró un Tipo de Alimento llamado: Granos','2025-06-13','22:25:39',12345678,1),(22456,'Tipos de Alimentos','Se Modificó un Tipo de Alimento llamado:Grano','2025-06-13','22:25:52',12345678,1),(22457,'Tipos de Alimentos','Se anuló un Tipo de alimento llamado: Grano','2025-06-13','22:26:00',12345678,1),(22458,'Login','El Usuario Servicio Nutricional: Inició sesión','2025-06-13','23:47:30',12345678,1),(22459,'Login','El Usuario Servicio Nutricional: Inició sesión','2025-06-14','09:23:58',12345678,1),(22460,'Consultar Alimentos','Se Modificó los datos del Alimento:Calabazina','2025-06-14','12:56:18',12345678,1),(22461,'Consultar Alimentos','Se Modificó los datos del Alimento:Calabazin','2025-06-14','12:56:24',12345678,1),(22462,'Alimentos','Registró un Alimento llamado: Hola','2025-06-14','12:56:47',12345678,1),(22463,'Consultar Alimentos','Se anuló un alimento llamado: Hola','2025-06-14','12:57:03',12345678,1),(22464,'Inventario de Alimentos - Entrada','Registró una entrada de alimentos en la fecha y hora: 2025-06-14 - 13:26 la cual describe que es :  verduras','2025-06-14','13:27:09',12345678,1),(22465,'Inventario de los Alimentos - Entrada','Consultó las entradas de los alimentos','2025-06-14','13:27:12',12345678,1),(22466,'Inventario de Alimentos - Stock','Consultó los estocks de los alimentos','2025-06-14','13:27:35',12345678,1),(22467,'Inventario de Alimentos - Stock','Consultó los estocks de los alimentos','2025-06-14','13:52:48',12345678,1),(22468,'Inventario de los Alimentos - Entrada','Consultó las entradas de los alimentos','2025-06-14','13:52:54',12345678,1),(22469,'Inventario de los Alimentos - Entrada','Consultó las entradas de los alimentos','2025-06-14','13:53:01',12345678,1),(22470,'Inventario de los Alimentos - Entrada','Consultó las entradas de los alimentos','2025-06-14','13:53:10',12345678,1),(22471,'Inventario de los Alimentos - Entrada','Consultó las entradas  de los alimentos de la fecha : 2025-06-14 hasta la fecha: 2025-06-14','2025-06-14','13:53:12',12345678,1),(22472,'Inventario de los Alimentos - Entrada','Consultó las entradas de los alimentos','2025-06-14','13:53:32',12345678,1),(22473,'Inventario de Alimentos - Entrada','Se anuló la entrada de alimentos de la fecha: 2025-06-14con la descripcion: verduras','2025-06-14','13:53:35',12345678,1),(22474,'Inventario de los Alimentos - Entrada','Consultó las entradas de los alimentos','2025-06-14','13:53:35',12345678,1),(22475,'Inventario de Alimentos - Stock','Consultó los estocks de los alimentos','2025-06-14','13:53:40',12345678,1),(22476,'Inventario de Alimentos - Stock','Consultó los estocks de los alimentos','2025-06-14','14:33:27',12345678,1),(22477,'Inventario de Alimentos - Salida','Registró una salida de alimentos  en la fecha y hora: 2025-06-14 - 2025-06-14 la cual describe el motivo :  se daño','2025-06-14','14:34:01',12345678,1),(22478,'Inventario de los Alimentos - Salida','Consultó las salidas de los alimentos','2025-06-14','14:34:04',12345678,1),(22479,'Inventario de los Alimentos - Salida','Consultó las salidas de los alimentos','2025-06-14','14:34:18',12345678,1),(22480,'Inventario de los Alimentos - Salida','Consultó las salidas de los alimentos de la fecha : 2025-06-14 hasta la fecha: 2025-06-14','2025-06-14','14:34:22',12345678,1),(22481,'Inventario de los Alimentos - Salida','Consultó las salidas de los alimentos','2025-06-14','14:34:32',12345678,1),(22482,'Inventario de Alimentos - Stock','Consultó los estocks de los alimentos','2025-06-14','14:34:37',12345678,1),(22483,'Inventario de los Alimentos - Salida','Consultó las salidas de los alimentos','2025-06-14','14:35:04',12345678,1),(22484,'Inventario de Alimentos - Salida','Se anuló la salida de alimentos de la fecha: 2025-06-14con la descripcion: se daño','2025-06-14','14:35:09',12345678,1),(22485,'Inventario de los Alimentos - Salida','Consultó las salidas de los alimentos','2025-06-14','14:35:09',12345678,1),(22486,'Inventario de Alimentos - Stock','Consultó los estocks de los alimentos','2025-06-14','14:35:16',12345678,1),(22487,'Login','El Usuario Servicio Nutricional: Inició sesión','2025-06-14','17:04:30',12345678,1),(22488,'Login','El Usuario Servicio Nutricional: Inició sesión','2025-06-14','18:55:48',12345678,1),(22489,'Login','El Usuario Servicio Nutricional: Inició sesión','2025-06-14','19:00:07',12345678,1),(22490,'Alimentos','Registró un Alimento llamado: Calabazin','2025-06-14','19:00:27',12345678,1),(22491,'Consultar Alimentos','Se Modificó los datos del Alimento:Calabazina','2025-06-14','19:00:54',12345678,1),(22492,'Consultar Alimentos','Se anuló un alimento llamado: Calabazina','2025-06-14','19:00:58',12345678,1),(22493,'Consultar Alimentos','Se anuló un alimento llamado: Tamarindo','2025-06-14','19:05:28',12345678,1),(22494,'Inventario de Alimentos - Entrada','Registró una entrada de alimentos en la fecha y hora: 2025-06-14 - 19:07 la cual describe que es :  compra de verduras','2025-06-14','19:16:45',12345678,1),(22495,'Inventario de los Alimentos - Entrada','Consultó las entradas de los alimentos','2025-06-14','19:16:48',12345678,1),(22496,'Inventario de Alimentos - Stock','Consultó los estocks de los alimentos','2025-06-14','19:17:16',12345678,1),(22497,'Inventario de los Alimentos - Entrada','Consultó las entradas de los alimentos','2025-06-14','19:17:38',12345678,1),(22498,'Inventario de Alimentos - Entrada','Se anuló la entrada de alimentos de la fecha: 2025-06-14con la descripcion: compra de verduras','2025-06-14','19:17:49',12345678,1),(22499,'Inventario de los Alimentos - Entrada','Consultó las entradas de los alimentos','2025-06-14','19:17:49',12345678,1),(22500,'Inventario de Alimentos - Stock','Consultó los estocks de los alimentos','2025-06-14','19:17:58',12345678,1),(22501,'Inventario de Alimentos - Stock','Consultó los estocks de los alimentos','2025-06-14','19:18:14',12345678,1),(22502,'Inventario de Alimentos - Stock','Consultó los estocks de los alimentos','2025-06-14','19:18:18',12345678,1),(22503,'Inventario de Alimentos - Stock','Consultó los estocks de los alimentos','2025-06-14','19:18:23',12345678,1),(22504,'Inventario de Alimentos - Stock','Consultó los estocks de los alimentos','2025-06-14','19:18:26',12345678,1),(22505,'Inventario de Alimentos - Stock','Consultó los estocks de los alimentos','2025-06-14','19:18:28',12345678,1),(22506,'Inventario de los Alimentos - Entrada','Consultó las entradas de los alimentos','2025-06-14','19:19:25',12345678,1),(22507,'Inventario de Alimentos - Salida','Registró una salida de alimentos  en la fecha y hora: 2025-06-14 - 2025-06-14 la cual describe el motivo :  se rompio','2025-06-14','19:20:25',12345678,1),(22508,'Inventario de los Alimentos - Salida','Consultó las salidas de los alimentos','2025-06-14','19:20:28',12345678,1),(22509,'Inventario de Alimentos - Stock','Consultó los estocks de los alimentos','2025-06-14','19:25:57',12345678,1),(22510,'Inventario de los Alimentos - Salida','Consultó las salidas de los alimentos','2025-06-14','19:36:48',12345678,1),(22511,'Inventario de los Alimentos - Salida','Consultó las salidas de los alimentos','2025-06-14','19:36:59',12345678,1),(22512,'Inventario de los Alimentos - Salida','Consultó las salidas de los alimentos','2025-06-14','19:39:22',12345678,1),(22513,'Inventario de los Alimentos - Salida','Consultó las salidas de los alimentos','2025-06-14','19:39:29',12345678,1),(22514,'Inventario de los Alimentos - Salida','Consultó las salidas de los alimentos de la fecha : 2025-06-13 hasta la fecha: 2025-06-13','2025-06-14','19:39:31',12345678,1),(22515,'Inventario de los Alimentos - Salida','Consultó las salidas de los alimentos de la fecha : 2025-06-14 hasta la fecha: 2025-06-14','2025-06-14','19:39:39',12345678,1),(22516,'Inventario de los Alimentos - Salida','Consultó las salidas de los alimentos','2025-06-14','19:40:40',12345678,1),(22517,'Inventario de los Alimentos - Salida','Consultó las salidas de los alimentos','2025-06-14','20:02:05',12345678,1),(22518,'Inventario de los Alimentos - Salida','Consultó las salidas de los alimentos','2025-06-14','20:02:12',12345678,1),(22519,'Inventario de los Alimentos - Salida','Consultó las salidas de los alimentos','2025-06-14','20:02:14',12345678,1),(22520,'Inventario de los Alimentos - Salida','Consultó las salidas de los alimentos de la fecha : 2025-06-14 hasta la fecha: 2025-06-21','2025-06-14','20:02:17',12345678,1),(22521,'Inventario de los Alimentos - Salida','Consultó las salidas de los alimentos de la fecha : 2025-06-14 hasta la fecha: 2025-06-14','2025-06-14','20:02:20',12345678,1),(22522,'Inventario de los Alimentos - Salida','Consultó las salidas de los alimentos','2025-06-14','20:09:03',12345678,1),(22523,'Inventario de los Alimentos - Salida','Consultó las salidas de los alimentos','2025-06-14','20:14:39',12345678,1),(22524,'Inventario de los Alimentos - Salida','Consultó las salidas de los alimentos','2025-06-14','20:14:56',12345678,1),(22525,'Inventario de los Alimentos - Salida','Consultó las salidas de los alimentos','2025-06-14','20:14:59',12345678,1),(22526,'Inventario de los Alimentos - Salida','Consultó las salidas de los alimentos de la fecha : 2025-06-14 hasta la fecha: 2025-06-21','2025-06-14','20:15:02',12345678,1),(22527,'Inventario de los Alimentos - Salida','Consultó las salidas de los alimentos de la fecha : 2025-06-14 hasta la fecha: 2025-06-14','2025-06-14','20:15:05',12345678,1),(22528,'Inventario de los Alimentos - Salida','Consultó las salidas de los alimentos','2025-06-14','20:15:21',12345678,1),(22529,'Inventario de los Alimentos - Entrada','Consultó las entradas de los alimentos','2025-06-14','20:16:36',12345678,1),(22530,'Inventario de los Alimentos - Entrada','Consultó las entradas de los alimentos','2025-06-14','20:17:07',12345678,1),(22531,'Inventario de los Alimentos - Entrada','Consultó las entradas  de los alimentos de la fecha : 2025-06-14 hasta la fecha: 2025-06-14','2025-06-14','20:17:13',12345678,1),(22532,'Inventario de los Alimentos - Entrada','Consultó las entradas de los alimentos','2025-06-14','20:17:16',12345678,1),(22533,'Inventario de los Alimentos - Entrada','Consultó las entradas de los alimentos','2025-06-14','20:17:34',12345678,1),(22534,'Inventario de los Alimentos - Entrada','Consultó las entradas  de los alimentos de la fecha : 2024-12-02 hasta la fecha: 2024-12-02','2025-06-14','20:17:51',12345678,1),(22535,'Login','El Usuario Servicio Nutricional: Inició sesión','2025-06-14','20:18:14',12345678,1),(22536,'Login','El Usuario Servicio Nutricional: Inició sesión','2025-06-14','20:44:37',12345678,1),(22537,'Login','El Usuario Servicio Nutricional: Inició sesión','2025-06-15','11:24:02',12345678,1),(22538,'Login','El Usuario Servicio Nutricional: Inició sesión','2025-06-15','11:24:18',12345678,1),(22539,'Reportes Estadísticos','Consultó el total de menus por horario ','2025-06-15','11:25:03',12345678,1),(22540,'Reportes Estadísticos','Consultó el total de menus por horario ','2025-06-15','11:25:09',12345678,1),(22541,'Reportes Estadísticos','Consultó el total de menus por horario ','2025-06-15','11:25:20',12345678,1),(22542,'Inventario de los Alimentos - Entrada','Consultó las entradas de los alimentos','2025-06-15','11:37:09',12345678,1),(22543,'Inventario de los Alimentos - Entrada','Consultó las entradas de los alimentos','2025-06-15','11:44:19',12345678,1),(22544,'Inventario de Alimentos - Stock','Consultó los estocks de los alimentos','2025-06-15','11:44:35',12345678,1),(22545,'Inventario de Alimentos - Stock','Consultó los estocks de los alimentos','2025-06-15','11:44:39',12345678,1),(22546,'Inventario de los Alimentos - Salida','Consultó las salidas de los alimentos','2025-06-15','11:44:57',12345678,1),(22547,'Inventario de los Alimentos - Salida','Consultó las salidas de los alimentos','2025-06-15','11:54:25',12345678,1),(22548,'Inventario de los Alimentos - Entrada','Consultó las entradas de los alimentos','2025-06-15','11:57:11',12345678,1),(22549,'Inventario de los Alimentos - Entrada','Consultó las entradas de los alimentos','2025-06-15','11:59:18',12345678,1),(22550,'Inventario de los Alimentos - Entrada','Consultó las entradas de los alimentos','2025-06-15','11:59:57',12345678,1),(22551,'Inventario de los Alimentos - Entrada','Consultó las entradas  de los alimentos de la fecha : 2024-12-02 hasta la fecha: 2024-12-02','2025-06-15','12:00:07',12345678,1),(22552,'Inventario de los Alimentos - Entrada','Consultó las entradas  de los alimentos de la fecha : 2024-12-01 hasta la fecha: 2024-12-02','2025-06-15','12:00:29',12345678,1),(22553,'Inventario de Alimentos - Stock','Consultó los estocks de los alimentos','2025-06-15','12:00:50',12345678,1),(22554,'Inventario de Alimentos - Stock','Consultó los estocks de los alimentos','2025-06-15','12:00:55',12345678,1),(22555,'Inventario de los Alimentos - Salida','Consultó las salidas de los alimentos','2025-06-15','12:01:13',12345678,1),(22556,'Inventario de los Alimentos - Salida','Consultó las salidas de los alimentos','2025-06-15','12:01:39',12345678,1),(22557,'Inventario de los Alimentos - Salida','Consultó las salidas de los alimentos de la fecha : 2025-06-14 hasta la fecha: 2025-06-14','2025-06-15','12:01:42',12345678,1),(22558,'Inventario de los Alimentos - Salida','Consultó las salidas de los alimentos de la fecha : 2025-06-13 hasta la fecha: 2025-06-14','2025-06-15','12:01:51',12345678,1),(22559,'Inventario de los Alimentos - Entrada','Consultó las entradas de los alimentos','2025-06-15','12:09:39',12345678,1),(22560,'Inventario de los Alimentos - Entrada','Consultó las entradas de los alimentos','2025-06-15','12:11:46',12345678,1),(22561,'Reportes Estadísticos','Consultó el total de menus por horario ','2025-06-15','12:13:56',12345678,1),(22562,'Reportes Estadísticos','Consultó el total el tipo de alimentos mas sacados por menus','2025-06-15','12:14:06',12345678,1),(22563,'Reportes Estadísticos','Consultó el total el tipo de alimentos mas sacados por menus','2025-06-15','12:14:15',12345678,1),(22564,'Reportes Estadísticos','Consultó los alimentos mas ingresados al inventario','2025-06-15','12:16:45',12345678,1),(22565,'Reportes Estadísticos','Consultó los alimentos mas ingresados al inventario','2025-06-15','12:16:52',12345678,1),(22566,'Login','El Usuario Servicio Nutricional: Inició sesión','2025-06-15','12:23:36',12345678,1),(22567,'Reportes Estadísticos','Consultó los alimentos mas ingresados al inventario','2025-06-15','12:23:48',12345678,1),(22568,'Reportes Estadísticos','Consultó los alimentos mas ingresados al inventario','2025-06-15','12:23:53',12345678,1),(22569,'Inventario de los Alimentos - Entrada','Consultó las entradas de los alimentos','2025-06-15','12:24:06',12345678,1),(22570,'Inventario de Alimentos - Stock','Consultó los estocks de los alimentos','2025-06-15','12:24:26',12345678,1),(22571,'Inventario de Alimentos - Stock','Consultó los estocks de los alimentos','2025-06-15','12:24:29',12345678,1),(22581,'Mantenimiento','Última importación de la BD realizada el 2025-06-15 21:25:17','2025-06-15','15:25:17',12345678,1),(22582,'Mantenimiento','Última exportación de la BD realizada el 2025-06-15 21:25:27','2025-06-15','15:25:27',12345678,1),(22583,'Mantenimiento','Última exportación de la BD realizada el 2025-06-15 21:25:41','2025-06-15','15:25:41',12345678,1),(22584,'Mantenimiento','Última exportación de la BD realizada el 2025-06-15 21:26:08','2025-06-15','15:26:08',12345678,1),(22585,'Mantenimiento','Última importación de la BD realizada el 2025-06-15 15:34:41','2025-06-15','15:34:41',12345678,1),(22586,'Mantenimiento','Última importación de la BD realizada el 2025-06-15 15:37:22','2025-06-15','15:37:23',12345678,1),(22587,'Mantenimiento','Última exportación de la BD realizada el 2025-06-15 15:37:32','2025-06-15','15:37:32',12345678,1),(22588,'Mantenimiento','Último Mantenimiento (Importación) realizado el 2025-06-15 15:44:03','2025-06-15','15:44:03',12345678,1),(22589,'Login','El Usuario Servicio Nutricional: Inició sesión','2025-06-15','18:36:39',12345678,1),(22590,'Mantenimiento','Último Mantenimiento (Importación) realizado el 2025-06-15 18:36:55','2025-06-15','18:36:55',12345678,1),(22591,'Mantenimiento','Último Mantenimiento (Importación) realizado el 2025-06-15 18:37:12','2025-06-15','18:37:12',12345678,1),(22592,'Mantenimiento','Último Mantenimiento (Importación) realizado el 2025-06-15 18:38:31','2025-06-15','18:38:31',12345678,1);
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
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notificaciones`
--

LOCK TABLES `notificaciones` WRITE;
/*!40000 ALTER TABLE `notificaciones` DISABLE KEYS */;
INSERT INTO `notificaciones` VALUES (48,'Registro de Entrada de Alimentos','Se registro una entrada de alimentos en la fecha y hora: 2024-12-01 - 19:19 la cual describe que es :  lacteos y proteinas','informacion','0000-00-00'),(49,'Registro de Salida de Alimentos','Se registro una salida de alimentos en la fecha y hora: 2024-12-01 - 19:32 la cual describe que es :  se daño','informacion','0000-00-00'),(50,'Salida de Merma','Se ha realizado una salida por motivo de Merma en la fecha y hora:2024-12-01-19:32','informacion','0000-00-00'),(51,'Menú Del Dia - Almuerzo','Descripción: Pollo en crema hecho para 60° comensales. Su asistencia esta disponible para el registro','Almuerzo','2024-12-03'),(52,'Registro de menú','Se registro un menú para 60° Comensales  para el dia 2024-12-03 en el horario: Almuerzo','informacion','0000-00-00'),(53,'Evento Del Dia - Reunion ','Descripción: reunion estudiantil hecho para 50° comensales.','Almuerzo','2024-12-03'),(54,'Registro de Evento','Se registro el evento Reunion  para 50° comensales. Para el dia 2024-12-03','informacion','0000-00-00'),(55,'Registro de Entrada de Utensilios','Se registro una entrada de utensilios en la fecha y hora: 2024-12-01 - 19:45 la cual describe que es :  compra','informacion','0000-00-00'),(56,'Registro de Salida de Utensilios','Se registro una salida de Utensilios en la fecha y hora: 2024-12-01 - 19:57 la cual describe que es :  se daño','informacion','0000-00-00'),(57,'Registro de Entrada de Alimentos','Se registro una entrada de alimentos en la fecha y hora: 2024-12-01 - 20:03 la cual describe que es :  compras','informacion','0000-00-00'),(58,'Registro de Entrada de Alimentos','Se registro una entrada de alimentos en la fecha y hora: 2025-06-14 - 13:26 la cual describe que es :  verduras','informacion','0000-00-00'),(59,'Registro de Salida de Alimentos','Se registro una salida de alimentos en la fecha y hora: 2025-06-14 - 14:33 la cual describe que es :  se daño','informacion','0000-00-00'),(60,'Salida de Merma','Se ha realizado una salida por motivo de Merma en la fecha y hora:2025-06-14-14:33','informacion','0000-00-00'),(61,'Registro de Entrada de Alimentos','Se registro una entrada de alimentos en la fecha y hora: 2025-06-14 - 19:07 la cual describe que es :  compra de verduras','informacion','0000-00-00'),(62,'Registro de Salida de Alimentos','Se registro una salida de alimentos en la fecha y hora: 2025-06-14 - 19:19 la cual describe que es :  se rompio','informacion','0000-00-00'),(63,'Salida de Merma','Se ha realizado una salida por motivo de Merma en la fecha y hora:2025-06-14-19:19','informacion','0000-00-00');
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
INSERT INTO `notificaciones_usuarios` VALUES (12345678,48,0),(12345678,49,0),(12345678,50,0),(12345678,51,0),(12345678,52,0),(12345678,53,0),(12345678,54,0),(12345678,55,0),(12345678,56,0),(12345678,57,1),(12345678,58,0),(12345678,59,0),(12345678,60,0),(12345678,61,0),(12345678,62,0),(12345678,63,0),(24668212,48,0),(24668212,49,0),(24668212,50,0),(24668212,51,0),(24668212,52,0),(24668212,53,0),(24668212,54,0),(24668212,55,0),(24668212,56,0),(24668212,57,0),(24668212,58,0),(24668212,59,0),(24668212,60,0),(24668212,61,0),(24668212,62,0),(24668212,63,0),(29762480,51,0),(29762480,52,0),(29762480,53,0),(29762480,54,0),(29762480,55,0),(29762480,56,0),(29972192,48,0),(29972192,49,0),(29972192,50,0),(29972192,51,0),(29972192,52,0),(29972192,53,0),(29972192,54,0),(29972192,57,0),(29972192,58,0),(29972192,59,0),(29972192,60,0),(29972192,61,0),(29972192,62,0),(29972192,63,0),(30483987,48,0),(30483987,49,0),(30483987,50,0),(30483987,51,0),(30483987,52,0),(30483987,53,0),(30483987,54,0),(30483987,55,0),(30483987,56,0),(30483987,57,0),(30483987,58,0),(30483987,59,0),(30483987,60,0),(30483987,61,0),(30483987,62,0),(30483987,63,0);
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
) ENGINE=InnoDB AUTO_INCREMENT=558 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permiso`
--

LOCK TABLES `permiso` WRITE;
/*!40000 ALTER TABLE `permiso` DISABLE KEYS */;
INSERT INTO `permiso` VALUES (1,'consultar',1,1,1),(3,'consultar',1,2,1),(4,'registrar',1,2,1),(5,'modificar',1,2,1),(6,'eliminar',1,2,1),(7,'consultar',1,3,1),(8,'registrar',1,3,1),(9,'modificar',1,3,1),(10,'eliminar',1,3,1),(11,'consultar',1,4,1),(12,'modificar',1,4,1),(13,'consultar',1,5,1),(14,'modificar',1,5,1),(15,'consultar',1,6,1),(16,'consultar',1,7,1),(17,'registrar',1,7,1),(18,'consultar',1,8,1),(19,'registrar',1,8,1),(20,'modificar',1,8,1),(21,'eliminar',1,8,1),(22,'consultar',1,9,1),(23,'registrar',1,9,1),(24,'modificar',1,9,1),(25,'eliminar',1,9,1),(26,'consultar',1,10,1),(27,'registrar',1,10,1),(28,'modificar',1,10,1),(29,'modificar',1,10,1),(30,'eliminar',1,10,1),(31,'consultar',1,11,1),(32,'registrar',1,11,1),(33,'modificar',1,11,1),(34,'eliminar',1,11,1),(35,'consultar',1,12,1),(36,'registrar',1,12,1),(37,'modificar',1,12,1),(38,'eliminar',1,12,1),(39,'consultar',1,13,1),(40,'registrar',1,13,1),(41,'eliminar',1,13,1),(42,'consultar',1,14,1),(43,'registrar',1,14,1),(44,'modificar',1,14,1),(45,'eliminar',1,14,1),(46,'consultar',1,15,1),(47,'registrar',1,15,1),(48,'modificar',1,15,1),(49,'eliminar',1,15,1),(50,'consultar',1,16,1),(51,'registrar',1,16,1),(52,'eliminar',1,16,1),(53,'consultar',1,17,1),(54,'registrar',1,17,1),(55,'modificar',1,17,1),(56,'eliminar',1,17,1),(57,'consultar',1,18,1),(220,'Exportar',1,19,1),(221,'Importar',1,19,1),(228,'consultar',5,1,1),(229,'consultar',5,2,0),(230,'registrar',5,2,0),(231,'modificar',5,2,0),(232,'eliminar',5,2,0),(233,'consultar',5,3,0),(234,'registrar',5,3,0),(235,'modificar',5,3,0),(236,'eliminar',5,3,0),(237,'consultar',5,4,0),(238,'modificar',5,4,0),(239,'consultar',5,5,0),(240,'modificar',5,5,0),(241,'consultar',5,6,0),(242,'consultar',5,7,0),(243,'registrar',5,7,0),(244,'consultar',5,8,0),(245,'registrar',5,8,0),(246,'consultar',5,9,1),(247,'registrar',5,9,1),(248,'modificar',5,9,1),(249,'eliminar',5,9,0),(250,'consultar',5,10,1),(251,'registrar',5,10,1),(252,'modificar',5,10,1),(253,'eliminar',5,10,0),(254,'consultar',5,11,1),(255,'registrar',5,11,0),(256,'modificar',5,11,0),(257,'eliminar',5,11,0),(258,'consultar',5,12,1),(259,'registrar',5,12,0),(260,'modificar',5,12,0),(261,'eliminar',5,12,0),(262,'consultar',5,13,0),(263,'registrar',5,13,0),(264,'eliminar',5,13,0),(265,'consultar',5,14,0),(266,'registrar',5,14,0),(267,'modificar',5,14,0),(268,'eliminar',5,14,0),(269,'consultar',5,15,1),(270,'registrar',5,15,0),(271,'modificar',5,15,0),(272,'eliminar',5,15,0),(273,'consultar',5,16,1),(274,'registrar',5,16,0),(275,'eliminar',5,16,0),(276,'consultar',5,17,1),(277,'registrar',5,17,0),(278,'modificar',5,17,0),(279,'eliminar',5,17,0),(280,'consultar',5,18,1),(281,'Exportar',5,19,0),(282,'Importar',5,19,0),(283,'consultar',6,1,1),(284,'consultar',6,2,0),(285,'registrar',6,2,0),(286,'modificar',6,2,0),(287,'eliminar',6,2,0),(288,'consultar',6,3,0),(289,'registrar',6,3,0),(290,'modificar',6,3,0),(291,'eliminar',6,3,0),(292,'consultar',6,4,0),(293,'modificar',6,4,0),(294,'consultar',6,5,0),(295,'modificar',6,5,0),(296,'consultar',6,6,0),(297,'consultar',6,7,0),(298,'registrar',6,7,0),(299,'consultar',6,8,0),(300,'registrar',6,8,0),(301,'consultar',6,9,1),(302,'registrar',6,9,0),(303,'modificar',6,9,0),(304,'eliminar',6,9,0),(305,'consultar',6,10,1),(306,'registrar',6,10,0),(307,'modificar',6,10,0),(308,'eliminar',6,10,0),(309,'consultar',6,11,0),(310,'registrar',6,11,0),(311,'modificar',6,11,0),(312,'eliminar',6,11,0),(313,'consultar',6,12,0),(314,'registrar',6,12,0),(315,'modificar',6,12,0),(316,'eliminar',6,12,0),(317,'consultar',6,13,1),(318,'registrar',6,13,0),(319,'eliminar',6,13,0),(320,'consultar',6,14,0),(321,'registrar',6,14,0),(322,'modificar',6,14,0),(323,'eliminar',6,14,0),(324,'consultar',6,15,0),(325,'registrar',6,15,0),(326,'modificar',6,15,0),(327,'eliminar',6,15,0),(328,'consultar',6,16,0),(329,'registrar',6,16,0),(330,'eliminar',6,16,0),(331,'consultar',6,17,1),(332,'registrar',6,17,0),(333,'modificar',6,17,0),(334,'eliminar',6,17,0),(335,'consultar',6,18,0),(336,'Exportar',6,19,0),(337,'Importar',6,19,0),(338,'consultar',7,1,1),(339,'consultar',7,2,0),(340,'registrar',7,2,0),(341,'modificar',7,2,0),(342,'eliminar',7,2,0),(343,'consultar',7,3,0),(344,'registrar',7,3,0),(345,'modificar',7,3,0),(346,'eliminar',7,3,0),(347,'consultar',7,4,0),(348,'modificar',7,4,0),(349,'consultar',7,5,0),(350,'modificar',7,5,0),(351,'consultar',7,6,0),(352,'consultar',7,7,1),(353,'registrar',7,7,1),(354,'consultar',7,8,1),(355,'registrar',7,8,0),(356,'consultar',7,9,0),(357,'registrar',7,9,0),(358,'modificar',7,9,0),(359,'eliminar',7,9,0),(360,'consultar',7,10,0),(361,'registrar',7,10,0),(362,'modificar',7,10,0),(363,'eliminar',7,10,0),(364,'consultar',7,11,0),(365,'registrar',7,11,0),(366,'modificar',7,11,0),(367,'eliminar',7,11,0),(368,'consultar',7,12,0),(369,'registrar',7,12,0),(370,'modificar',7,12,0),(371,'eliminar',7,12,0),(372,'consultar',7,13,0),(373,'registrar',7,13,0),(374,'eliminar',7,13,0),(375,'consultar',7,14,0),(376,'registrar',7,14,0),(377,'modificar',7,14,0),(378,'eliminar',7,14,0),(379,'consultar',7,15,0),(380,'registrar',7,15,0),(381,'modificar',7,15,0),(382,'eliminar',7,15,0),(383,'consultar',7,16,0),(384,'registrar',7,16,0),(385,'eliminar',7,16,0),(386,'consultar',7,17,0),(387,'registrar',7,17,0),(388,'modificar',7,17,0),(389,'eliminar',7,17,0),(390,'consultar',7,18,1),(391,'Exportar',7,19,0),(392,'Importar',7,19,0),(393,'consultar',8,1,1),(394,'consultar',8,2,1),(395,'registrar',8,2,1),(396,'modificar',8,2,0),(397,'eliminar',8,2,0),(398,'consultar',8,3,0),(399,'registrar',8,3,0),(400,'modificar',8,3,0),(401,'eliminar',8,3,0),(402,'consultar',8,4,0),(403,'modificar',8,4,0),(404,'consultar',8,5,1),(405,'modificar',8,5,1),(406,'consultar',8,6,1),(407,'consultar',8,7,1),(408,'registrar',8,7,0),(409,'consultar',8,8,1),(410,'registrar',8,8,1),(411,'consultar',8,9,1),(412,'registrar',8,9,1),(413,'modificar',8,9,1),(414,'eliminar',8,9,1),(415,'consultar',8,10,1),(416,'registrar',8,10,1),(417,'modificar',8,10,1),(418,'eliminar',8,10,1),(419,'consultar',8,11,1),(420,'registrar',8,11,1),(421,'modificar',8,11,1),(422,'eliminar',8,11,1),(423,'consultar',8,12,1),(424,'registrar',8,12,1),(425,'modificar',8,12,1),(426,'eliminar',8,12,1),(427,'consultar',8,13,1),(428,'registrar',8,13,1),(429,'eliminar',8,13,1),(430,'consultar',8,14,1),(431,'registrar',8,14,1),(432,'modificar',8,14,1),(433,'eliminar',8,14,1),(434,'consultar',8,15,1),(435,'registrar',8,15,1),(436,'modificar',8,15,1),(437,'eliminar',8,15,1),(438,'consultar',8,16,1),(439,'registrar',8,16,1),(440,'eliminar',8,16,1),(441,'consultar',8,17,1),(442,'registrar',8,17,1),(443,'modificar',8,17,1),(444,'eliminar',8,17,1),(445,'consultar',8,18,1),(446,'Exportar',8,19,1),(447,'Importar',8,19,1);
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
  PRIMARY KEY (`idRol`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rol`
--

LOCK TABLES `rol` WRITE;
/*!40000 ALTER TABLE `rol` DISABLE KEYS */;
INSERT INTO `rol` VALUES (1,'Super Usuario',1),(5,'Jefe De Cocina',1),(6,'Cocinero',1),(7,'Bienestar Estudiantil',1),(8,'Coordinador',1);
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
  KEY `idRol` (`idRol`),
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`idRol`) REFERENCES `rol` (`idRol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (12345678,'assets/images/perfil/123456782244.png','Servicio','Andres','Nutricional','Eloy','Servicionutricional2024@gmail.com','0424 - 0000099','$2y$10$M.vMxIOMqGZGDDW6RLoOOOkmDC5AIDzAkM0J2WeNtlGeV6OwcHYL.',1,1),(24668212,'assets/images/perfil/user.png','Alison','','Brown','','Alisonbronw1234@gmail.com','0412 0339511','$2y$10$zfJIPHm7BZv8naXhT3yZRubnZtrd31l602DX/Hqz1MNJOGKlMfI42',8,1),(29762480,'assets/images/perfil/297624803533.png','Dairon','','Santeliz','','Fdhtyh@gmail.com','0412 7585922','$2y$10$SswRWYzRtNAh2CaSN.BC2OvKnRIJnCx22U1lO808lkHElCRGgn4d.',5,1),(29913499,'assets/images/perfil/299134994321.png','Marianny','','Flores','','Floresmarianny17@gmail.com','0412 0546170','$2y$10$Fat9klg6LpxTY9.bFfJmBeFHuyxXLWobV9lNnhMkbGbGhkXoRmW1G',7,1),(29972192,'assets/images/perfil/299721921400.png','Samuel','Alejandro','Pereira','Araujo','Shame652003@gmail.com','0412 1510342','$2y$10$M8DMBamIJDPauWKCD09qh..df6dLMKzAms8YhhELIsAsN92FP8hse',6,1),(30483987,'assets/images/perfil/304839876362.png','Ana','Maria','Wyatt','Almao','Wayando06.xd@gmail.com','0412 1873382','$2y$10$zyZWmhqSl99Orcsk6DhoRePCBxpBlgvaWiRRG.k20XirlqyNAXUKi',8,1);
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
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-15 18:38:38
