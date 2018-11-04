-- MySQL dump 10.13  Distrib 5.6.16, for debian-linux-gnu (x86_64)
--
-- Host: 192.168.11.25    Database: stok
-- ------------------------------------------------------
-- Server version	5.6.36

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
-- Table structure for table `barang`
--

DROP TABLE IF EXISTS `barang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `barang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(45) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `kategori` varchar(255) DEFAULT NULL,
  `satuan` enum('PCS','DOS','BOX','KODI') NOT NULL DEFAULT 'PCS',
  PRIMARY KEY (`id`),
  KEY `nama` (`nama`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barang`
--

LOCK TABLES `barang` WRITE;
/*!40000 ALTER TABLE `barang` DISABLE KEYS */;
INSERT INTO `barang` VALUES (1,'A001','PEPSODENT 125mg','','RUMAH TANGGA','PCS');
/*!40000 ALTER TABLE `barang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `barang_keluar`
--

DROP TABLE IF EXISTS `barang_keluar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `barang_keluar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `barang_id` int(11) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `no_bukti` varchar(50) DEFAULT NULL,
  `nama_barang` varchar(255) DEFAULT NULL,
  `qty` double NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `barang_id` (`barang_id`),
  KEY `no_bukti` (`no_bukti`),
  KEY `nama_barang` (`nama_barang`),
  CONSTRAINT `barang_keluar_ibfk_1` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barang_keluar`
--

LOCK TABLES `barang_keluar` WRITE;
/*!40000 ALTER TABLE `barang_keluar` DISABLE KEYS */;
INSERT INTO `barang_keluar` VALUES (1,1,'2017-11-15','001/MG/11/2017','PEPSODENT 125mg (PCS )',1,'',NULL,NULL),(2,NULL,'2017-11-24','002/MG/11/2017',NULL,0,'Hutang',NULL,NULL),(3,NULL,'2017-11-24','003/MG/11/2017',NULL,0,'1222',NULL,NULL),(4,NULL,'2017-11-24','003/MG/11/2017',NULL,0,'1222',NULL,NULL),(5,NULL,'2017-11-24','003/MG/11/2017',NULL,0,'1222',NULL,NULL),(6,NULL,'2017-11-24','003/MG/11/2017',NULL,0,'1222',NULL,NULL),(7,NULL,'2017-11-24','004/MG/11/2017',NULL,0,'222',NULL,NULL),(8,NULL,'2017-11-24','005/MG/11/2017',NULL,0,'tess5',NULL,NULL),(9,NULL,'2017-11-24','005/MG/11/2017',NULL,0,'tess5',NULL,NULL),(10,NULL,'2017-11-24','006/MG/11/2017',NULL,0,'2222',NULL,NULL),(11,NULL,'2017-11-24','007/MG/11/2017',NULL,0,'7',NULL,NULL),(12,NULL,'2017-11-24','008/MG/11/2017',NULL,0,'teeee',NULL,NULL),(13,NULL,'2017-11-24','009/MG/11/2017',NULL,0,'3333',NULL,NULL),(14,NULL,'2017-11-24','010/MG/11/2017',NULL,0,'4444',NULL,NULL),(15,NULL,'2017-11-24','011/MG/11/2017',NULL,0,'333',NULL,NULL),(16,NULL,'2017-11-24','012/MG/11/2017',NULL,0,'t',NULL,NULL),(17,NULL,'2017-11-24','013/MG/11/2017',NULL,0,'r4',NULL,NULL),(18,NULL,'2017-11-24','013/MG/11/2017',NULL,0,'r4',NULL,NULL),(19,NULL,'2017-11-24','013/MG/11/2017',NULL,0,'r4',NULL,NULL);
/*!40000 ALTER TABLE `barang_keluar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `barang_masuk`
--

DROP TABLE IF EXISTS `barang_masuk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `barang_masuk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `nomor_invoice` varchar(255) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nomor_invoice` (`nomor_invoice`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barang_masuk`
--

LOCK TABLES `barang_masuk` WRITE;
/*!40000 ALTER TABLE `barang_masuk` DISABLE KEYS */;
INSERT INTO `barang_masuk` VALUES (1,'2017-11-14','121312sfdsf/ghgfhf','',NULL,NULL),(2,'2017-11-20','122222222','tes',NULL,NULL),(3,'2017-11-20','2222222','ttt',NULL,NULL),(4,'2017-11-22','33333333','tes',NULL,NULL);
/*!40000 ALTER TABLE `barang_masuk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `fact` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` VALUES (1,'John','john@aaabbb.com','Loves coding XXX',NULL,'2017-05-31 04:24:48'),(2,'Jim','jim@example.com','Developed on CodeIgniter',NULL,NULL),(3,'Jane','jane@example.com','Lives in the USA',NULL,NULL),(4,'John X','john@example.com','Loves coding','2017-05-30 08:36:41',NULL),(5,'John X','john@example.com','Loves coding','2017-05-30 08:40:25',NULL),(6,'John XX','john@example.com','Loves coding','2017-05-30 08:41:35',NULL),(7,'John XX','john@example.com','Loves coding','2017-05-30 08:42:14',NULL),(8,'John XX','john@example.com','Loves coding','2017-05-30 08:42:29',NULL),(9,'John XX','john@example.com','Loves coding','2017-05-30 08:42:50',NULL),(10,'John XX','john@example.com','Loves coding','2017-05-30 08:43:03',NULL),(11,'John XX','john@example.com','Loves coding','2017-05-30 08:44:05',NULL),(12,'John XX','john@example.com','Loves coding','2017-05-30 08:48:02',NULL),(13,'John XX','john@example.com','Loves coding','2017-05-30 08:48:39',NULL),(14,'John XX','john@example.com','Loves coding','2017-05-30 08:50:06',NULL),(15,'John XX','john@example.com','Loves coding','2017-05-30 08:50:30',NULL),(16,'John XX','john@example.com','Loves coding','2017-05-30 08:51:18',NULL),(17,'John XX','john@example.com','Loves coding','2017-05-30 08:51:53',NULL),(18,'John XX','john@example.com','Loves coding','2017-05-30 08:52:16',NULL),(20,'John XX','john@example.com','Loves coding','2017-05-30 08:52:51',NULL);
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detail_barang`
--

DROP TABLE IF EXISTS `detail_barang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detail_barang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_barang` int(11) DEFAULT NULL,
  `jenis_barang` varchar(255) DEFAULT NULL,
  `barang` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detail_barang`
--

LOCK TABLES `detail_barang` WRITE;
/*!40000 ALTER TABLE `detail_barang` DISABLE KEYS */;
/*!40000 ALTER TABLE `detail_barang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detail_barang_keluar`
--

DROP TABLE IF EXISTS `detail_barang_keluar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detail_barang_keluar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_stok` varchar(225) DEFAULT NULL,
  `barang_id` int(11) DEFAULT NULL,
  `nama_barang` varchar(225) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `barang_keluar_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detail_barang_keluar`
--

LOCK TABLES `detail_barang_keluar` WRITE;
/*!40000 ALTER TABLE `detail_barang_keluar` DISABLE KEYS */;
INSERT INTO `detail_barang_keluar` VALUES (1,NULL,0,'121',0,6,'2017-11-24 10:55:45',NULL,NULL),(2,NULL,0,'111',0,7,'2017-11-24 11:00:13',NULL,NULL),(3,NULL,0,'555',0,8,'2017-11-24 11:00:53',NULL,NULL),(4,NULL,0,'555',0,9,'2017-11-24 11:00:57',NULL,NULL),(5,NULL,0,'333',0,10,'2017-11-24 11:02:04',NULL,NULL),(6,NULL,0,'2',0,11,'2017-11-24 11:03:28',NULL,NULL),(7,NULL,0,'1111',0,12,'2017-11-24 11:07:03',NULL,NULL),(8,NULL,0,'10',0,15,'2017-11-24 11:12:05',NULL,NULL),(9,NULL,1,'PEPSODENT 125mg (PCS )',121,16,'2017-11-24 11:14:32',NULL,NULL),(10,NULL,1,'PEPSODENT 125mg (PCS )',2222,17,'2017-11-24 16:57:33',NULL,NULL),(11,NULL,1,'PEPSODENT 125mg (PCS )',2222,18,'2017-11-24 16:58:01',NULL,NULL),(12,NULL,1,'PEPSODENT 125mg (PCS )',2222,19,'2017-11-24 16:59:40',NULL,NULL);
/*!40000 ALTER TABLE `detail_barang_keluar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detail_barang_masuk`
--

DROP TABLE IF EXISTS `detail_barang_masuk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detail_barang_masuk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `barang_masuk_id` int(11) NOT NULL,
  `barang_id` int(11) NOT NULL,
  `nama_barang` varchar(255) DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `gudang_id` int(11) DEFAULT NULL,
  `nama_gudang` varchar(255) DEFAULT NULL,
  `expired` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `barang_masuk_id` (`barang_masuk_id`),
  KEY `barang_id` (`barang_id`),
  CONSTRAINT `detail_barang_masuk_ibfk_1` FOREIGN KEY (`barang_masuk_id`) REFERENCES `barang_masuk` (`id`),
  CONSTRAINT `detail_barang_masuk_ibfk_2` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detail_barang_masuk`
--

LOCK TABLES `detail_barang_masuk` WRITE;
/*!40000 ALTER TABLE `detail_barang_masuk` DISABLE KEYS */;
INSERT INTO `detail_barang_masuk` VALUES (1,1,1,'PEPSODENT 125mg (PCS )',12,'2017-11-14 15:50:16',NULL,NULL,NULL,NULL),(2,2,1,'A001-PEPSODENT 125mg',2,'2017-11-20 22:20:10',NULL,NULL,NULL,NULL),(3,3,1,'A001-PEPSODENT 125mg',1,'2017-11-20 22:27:08',NULL,2,'G01-Gudang 1','2017-11-28'),(4,4,1,'A001-PEPSODENT 125mg',1000,'2017-11-22 22:41:40',NULL,2,'G01-Gudang 1','2017-11-21');
/*!40000 ALTER TABLE `detail_barang_masuk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (1,'admin','Administrator'),(2,'members','General User');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gudang`
--

DROP TABLE IF EXISTS `gudang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gudang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(5) NOT NULL,
  `nama` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gudang`
--

LOCK TABLES `gudang` WRITE;
/*!40000 ALTER TABLE `gudang` DISABLE KEYS */;
INSERT INTO `gudang` VALUES (2,'G01','Gudang 1');
/*!40000 ALTER TABLE `gudang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hobbies`
--

DROP TABLE IF EXISTS `hobbies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hobbies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `hobbies` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hobbies`
--

LOCK TABLES `hobbies` WRITE;
/*!40000 ALTER TABLE `hobbies` DISABLE KEYS */;
INSERT INTO `hobbies` VALUES (14,1,'AAAADDDDEEE','2017-05-31 03:28:14','2017-05-31 04:24:48'),(15,1,'BBBBCCCDDD','2017-05-31 03:54:42','2017-05-31 04:24:48'),(18,1,'EEEEECCCDDD','2017-05-31 04:24:48',NULL);
/*!40000 ALTER TABLE `hobbies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jenis_barang`
--

DROP TABLE IF EXISTS `jenis_barang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jenis_barang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jenis_barang` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jenis_barang`
--

LOCK TABLES `jenis_barang` WRITE;
/*!40000 ALTER TABLE `jenis_barang` DISABLE KEYS */;
INSERT INTO `jenis_barang` VALUES (1,'Elektronik','EK'),(2,'Perabot Rumah Tangga','PRR');
/*!40000 ALTER TABLE `jenis_barang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job`
--

DROP TABLE IF EXISTS `job`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job` (
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job`
--

LOCK TABLES `job` WRITE;
/*!40000 ALTER TABLE `job` DISABLE KEYS */;
INSERT INTO `job` VALUES ('PoliticianX'),('AccountantX');
/*!40000 ALTER TABLE `job` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `keys`
--

DROP TABLE IF EXISTS `keys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `keys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(40) NOT NULL,
  `level` int(2) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT '0',
  `is_private_key` tinyint(1) NOT NULL DEFAULT '0',
  `ip_addresses` text,
  `date_created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `keys`
--

LOCK TABLES `keys` WRITE;
/*!40000 ALTER TABLE `keys` DISABLE KEYS */;
INSERT INTO `keys` VALUES (1,'api/example/users',1,0,0,NULL,0);
/*!40000 ALTER TABLE `keys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login_attempts`
--

DROP TABLE IF EXISTS `login_attempts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_attempts`
--

LOCK TABLES `login_attempts` WRITE;
/*!40000 ALTER TABLE `login_attempts` DISABLE KEYS */;
/*!40000 ALTER TABLE `login_attempts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uri` varchar(255) NOT NULL,
  `method` varchar(6) NOT NULL,
  `params` text,
  `api_key` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `time` int(11) NOT NULL,
  `rtime` float DEFAULT NULL,
  `authorized` varchar(1) NOT NULL,
  `response_code` smallint(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logs`
--

LOCK TABLES `logs` WRITE;
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
INSERT INTO `logs` VALUES (1,'api/example/users','get',NULL,'','127.0.0.1',1496117142,0.074677,'1',200),(2,'api/example/users','get',NULL,'','127.0.0.1',1496117805,0.0905309,'1',200),(3,'api/example/users','get',NULL,'','127.0.0.1',1496118530,0.144681,'1',0),(4,'api/example/users','get',NULL,'','127.0.0.1',1496118576,0.117867,'1',404),(5,'api/example/users','get',NULL,'','127.0.0.1',1496118702,0.078768,'1',200),(6,'api/example/users','get',NULL,'','127.0.0.1',1496119259,0.102483,'1',0),(7,'api/example/users','get',NULL,'','127.0.0.1',1496119296,0.0738502,'1',200),(8,'api/example/users','get',NULL,'','127.0.0.1',1496119338,0.140558,'1',200),(9,'api/example/users','get',NULL,'','127.0.0.1',1496122795,0.126308,'1',200),(10,'api/example/users','get',NULL,'','127.0.0.1',1496123042,0.0670409,'1',200),(11,'api/example/users','get',NULL,'','127.0.0.1',1496123125,0.106953,'1',200),(12,'api/example/users','get',NULL,'','127.0.0.1',1496123159,0.06971,'1',200),(13,'api/example/users','get',NULL,'','127.0.0.1',1496123196,0.124738,'1',200),(14,'api/example/users','get',NULL,'','127.0.0.1',1496123318,0.096081,'1',200),(15,'api/example/users','get',NULL,'','127.0.0.1',1496123334,0.0718069,'1',200),(16,'api/example/users','get',NULL,'','127.0.0.1',1496123458,0.0992951,'1',200),(17,'api/example/users','get',NULL,'','127.0.0.1',1496123497,0.0948091,'1',200),(18,'api/example/users','get',NULL,'','127.0.0.1',1496123669,0.0857852,'1',200),(19,'api/example/users','get',NULL,'','127.0.0.1',1496123686,0.151381,'1',200),(20,'api/example/users','get',NULL,'','127.0.0.1',1496123837,0.0828459,'1',200),(21,'api/example/users/id/1','get','a:1:{s:2:\"id\";s:1:\"1\";}','','127.0.0.1',1496123847,0.0731189,'1',0),(22,'api/example/users/id/1','get','a:1:{s:2:\"id\";s:1:\"1\";}','','127.0.0.1',1496124032,0.0799241,'1',404),(23,'api/example/users/id/1','get','a:1:{s:2:\"id\";s:1:\"1\";}','','127.0.0.1',1496124061,0.0924251,'1',404),(24,'api/example/users/id/1','get','a:1:{s:2:\"id\";s:1:\"1\";}','','127.0.0.1',1496124082,0.256184,'1',404),(25,'api/example/users/id/1','get','a:1:{s:2:\"id\";s:1:\"1\";}','','127.0.0.1',1496124167,0.11669,'1',404),(26,'api/example/users/id/1','get','a:1:{s:2:\"id\";s:1:\"1\";}','','127.0.0.1',1496124205,0.0773292,'1',404),(27,'api/example/users/id/1','get','a:1:{s:2:\"id\";s:1:\"1\";}','','127.0.0.1',1496124236,0.0772748,'1',404),(28,'api/example/users/id/1','get','a:1:{s:2:\"id\";s:1:\"1\";}','','127.0.0.1',1496124323,0.109822,'1',404),(29,'api/example/users/id/1','get','a:1:{s:2:\"id\";s:1:\"1\";}','','127.0.0.1',1496124355,0.0932381,'1',200),(30,'api/example/users/id/1','get','a:1:{s:2:\"id\";s:1:\"1\";}','','127.0.0.1',1496124369,0.0999439,'1',200),(31,'api/example/users/id/2','get','a:1:{s:2:\"id\";s:1:\"2\";}','','127.0.0.1',1496124425,0.0714579,'1',200),(32,'api/example/users/id/2','get','a:1:{s:2:\"id\";s:1:\"2\";}','','127.0.0.1',1496124453,0.110648,'1',200),(33,'api/example/users/id/1','get','a:1:{s:2:\"id\";s:1:\"1\";}','','127.0.0.1',1496124464,0.101979,'1',200),(34,'api/example/users/id/1','get','a:1:{s:2:\"id\";s:1:\"1\";}','','127.0.0.1',1496124473,0.096652,'1',200),(35,'api/example/users','post','a:3:{s:4:\"name\";s:6:\"John X\";s:5:\"email\";s:16:\"john@example.com\";s:4:\"fact\";s:12:\"Loves coding\";}','','127.0.0.1',1496126084,0.0972679,'1',0),(36,'api/example/users','post','a:3:{s:4:\"name\";s:6:\"John X\";s:5:\"email\";s:16:\"john@example.com\";s:4:\"fact\";s:12:\"Loves coding\";}','','127.0.0.1',1496126201,0.242061,'1',201),(37,'api/example/users','post','a:3:{s:4:\"name\";s:6:\"John X\";s:5:\"email\";s:16:\"john@example.com\";s:4:\"fact\";s:12:\"Loves coding\";}','','127.0.0.1',1496126425,0.172727,'1',201),(38,'api/example/users','post','a:4:{s:4:\"name\";s:7:\"John XX\";s:5:\"email\";s:16:\"john@example.com\";s:4:\"fact\";s:12:\"Loves coding\";s:7:\"hobbies\";a:2:{i:0;a:3:{s:2:\"id\";s:1:\"1\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:4:\"AAAA\";}i:1;a:3:{s:2:\"id\";s:1:\"2\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:4:\"BBBB\";}}}','','127.0.0.1',1496126495,0.127612,'1',201),(39,'api/example/users','post','a:4:{s:4:\"name\";s:7:\"John XX\";s:5:\"email\";s:16:\"john@example.com\";s:4:\"fact\";s:12:\"Loves coding\";s:7:\"hobbies\";a:2:{i:0;a:3:{s:2:\"id\";s:1:\"1\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:4:\"AAAA\";}i:1;a:3:{s:2:\"id\";s:1:\"2\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:4:\"BBBB\";}}}','','127.0.0.1',1496126534,0.209381,'1',201),(40,'api/example/users','post','a:4:{s:4:\"name\";s:7:\"John XX\";s:5:\"email\";s:16:\"john@example.com\";s:4:\"fact\";s:12:\"Loves coding\";s:7:\"hobbies\";a:2:{i:0;a:3:{s:2:\"id\";s:1:\"1\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:4:\"AAAA\";}i:1;a:3:{s:2:\"id\";s:1:\"2\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:4:\"BBBB\";}}}','','127.0.0.1',1496126549,0.143759,'1',0),(41,'api/example/users','post','a:4:{s:4:\"name\";s:7:\"John XX\";s:5:\"email\";s:16:\"john@example.com\";s:4:\"fact\";s:12:\"Loves coding\";s:7:\"hobbies\";a:2:{i:0;a:3:{s:2:\"id\";s:1:\"1\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:4:\"AAAA\";}i:1;a:3:{s:2:\"id\";s:1:\"2\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:4:\"BBBB\";}}}','','127.0.0.1',1496126570,0.137136,'1',0),(42,'api/example/users','post','a:4:{s:4:\"name\";s:7:\"John XX\";s:5:\"email\";s:16:\"john@example.com\";s:4:\"fact\";s:12:\"Loves coding\";s:7:\"hobbies\";a:2:{i:0;a:3:{s:2:\"id\";s:1:\"1\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:4:\"AAAA\";}i:1;a:3:{s:2:\"id\";s:1:\"2\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:4:\"BBBB\";}}}','','127.0.0.1',1496126583,0.198734,'1',0),(43,'api/example/users','post','a:4:{s:4:\"name\";s:7:\"John XX\";s:5:\"email\";s:16:\"john@example.com\";s:4:\"fact\";s:12:\"Loves coding\";s:7:\"hobbies\";a:2:{i:0;a:3:{s:2:\"id\";s:1:\"1\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:4:\"AAAA\";}i:1;a:3:{s:2:\"id\";s:1:\"2\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:4:\"BBBB\";}}}','','127.0.0.1',1496126645,0.119795,'1',0),(44,'api/example/users','post','a:4:{s:4:\"name\";s:7:\"John XX\";s:5:\"email\";s:16:\"john@example.com\";s:4:\"fact\";s:12:\"Loves coding\";s:7:\"hobbies\";a:2:{i:0;a:3:{s:2:\"id\";s:1:\"1\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:4:\"AAAA\";}i:1;a:3:{s:2:\"id\";s:1:\"2\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:4:\"BBBB\";}}}','','127.0.0.1',1496126882,0.137248,'1',0),(45,'api/example/users','post','a:4:{s:4:\"name\";s:7:\"John XX\";s:5:\"email\";s:16:\"john@example.com\";s:4:\"fact\";s:12:\"Loves coding\";s:7:\"hobbies\";a:2:{i:0;a:3:{s:2:\"id\";s:1:\"1\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:4:\"AAAA\";}i:1;a:3:{s:2:\"id\";s:1:\"2\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:4:\"BBBB\";}}}','','127.0.0.1',1496126919,0.165653,'1',0),(46,'api/example/users','post','a:4:{s:4:\"name\";s:7:\"John XX\";s:5:\"email\";s:16:\"john@example.com\";s:4:\"fact\";s:12:\"Loves coding\";s:7:\"hobbies\";a:2:{i:0;a:3:{s:2:\"id\";s:1:\"1\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:4:\"AAAA\";}i:1;a:3:{s:2:\"id\";s:1:\"2\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:4:\"BBBB\";}}}','','127.0.0.1',1496127006,0.117209,'1',0),(47,'api/example/users','post','a:4:{s:4:\"name\";s:7:\"John XX\";s:5:\"email\";s:16:\"john@example.com\";s:4:\"fact\";s:12:\"Loves coding\";s:7:\"hobbies\";a:2:{i:0;a:3:{s:2:\"id\";s:1:\"1\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:4:\"AAAA\";}i:1;a:3:{s:2:\"id\";s:1:\"2\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:4:\"BBBB\";}}}','','127.0.0.1',1496127030,0.116015,'1',0),(48,'api/example/users','post','a:4:{s:4:\"name\";s:7:\"John XX\";s:5:\"email\";s:16:\"john@example.com\";s:4:\"fact\";s:12:\"Loves coding\";s:7:\"hobbies\";a:2:{i:0;a:3:{s:2:\"id\";s:1:\"1\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:4:\"AAAA\";}i:1;a:3:{s:2:\"id\";s:1:\"2\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:4:\"BBBB\";}}}','','127.0.0.1',1496127078,0.138249,'1',201),(49,'api/example/users','post','a:4:{s:4:\"name\";s:7:\"John XX\";s:5:\"email\";s:16:\"john@example.com\";s:4:\"fact\";s:12:\"Loves coding\";s:7:\"hobbies\";a:2:{i:0;a:3:{s:2:\"id\";s:1:\"1\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:4:\"AAAA\";}i:1;a:3:{s:2:\"id\";s:1:\"2\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:4:\"BBBB\";}}}','','127.0.0.1',1496127113,0.118997,'1',0),(50,'api/example/users','post','a:4:{s:4:\"name\";s:7:\"John XX\";s:5:\"email\";s:16:\"john@example.com\";s:4:\"fact\";s:12:\"Loves coding\";s:7:\"hobbies\";a:2:{i:0;a:3:{s:2:\"id\";s:1:\"1\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:4:\"AAAA\";}i:1;a:3:{s:2:\"id\";s:1:\"2\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:4:\"BBBB\";}}}','','127.0.0.1',1496127136,0.156057,'1',0),(51,'api/example/users','post','a:4:{s:4:\"name\";s:7:\"John XX\";s:5:\"email\";s:16:\"john@example.com\";s:4:\"fact\";s:12:\"Loves coding\";s:7:\"hobbies\";a:2:{i:0;a:3:{s:2:\"id\";s:1:\"1\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:4:\"AAAA\";}i:1;a:3:{s:2:\"id\";s:1:\"2\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:4:\"BBBB\";}}}','','127.0.0.1',1496127154,0.0992231,'1',0),(52,'api/example/users','post','a:4:{s:4:\"name\";s:7:\"John XX\";s:5:\"email\";s:16:\"john@example.com\";s:4:\"fact\";s:12:\"Loves coding\";s:7:\"hobbies\";a:2:{i:0;a:3:{s:2:\"id\";s:1:\"1\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:4:\"AAAA\";}i:1;a:3:{s:2:\"id\";s:1:\"2\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:4:\"BBBB\";}}}','','127.0.0.1',1496127171,0.170843,'1',0),(53,'api/example/users','post','a:4:{s:4:\"name\";s:7:\"John XX\";s:5:\"email\";s:16:\"john@example.com\";s:4:\"fact\";s:12:\"Loves coding\";s:7:\"hobbies\";a:2:{i:0;a:3:{s:2:\"id\";s:1:\"1\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:4:\"AAAA\";}i:1;a:3:{s:2:\"id\";s:1:\"2\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:4:\"BBBB\";}}}','','127.0.0.1',1496127275,0.117749,'1',0),(54,'api/example/users','post','a:4:{s:4:\"name\";s:7:\"John XX\";s:5:\"email\";s:16:\"john@example.com\";s:4:\"fact\";s:12:\"Loves coding\";s:7:\"hobbies\";a:2:{i:0;a:3:{s:2:\"id\";s:1:\"1\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:4:\"AAAA\";}i:1;a:3:{s:2:\"id\";s:1:\"2\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:4:\"BBBB\";}}}','','127.0.0.1',1496127299,0.223043,'1',201),(55,'api/example/users/22','delete','a:2:{s:2:\"id\";s:2:\"22\";s:97:\"{\r\n__\"name\":_\"John_XX\",\r\n__\"email\":_\"john@example_com\",\r\n__\"fact\":_\"Loves_coding\",\r\n__\"hobbies\":_\";a:1:{s:173:\"\r\n    {\r\n      \"id\": \"1\",\r\n      \"customer_id\": \"1\",\r\n      \"hobbies\": \"AAAA\"\r\n    },\r\n    {\r\n      \"id\": \"2\",\r\n      \"customer_id\": \"1\",\r\n      \"hobbies\": \"BBBB\"\r\n    }\r\n  \";s:0:\"\";}}','','127.0.0.1',1496129185,0.0489972,'1',0),(56,'api/example/users/22','delete','a:2:{s:2:\"id\";s:2:\"22\";s:97:\"{\r\n__\"name\":_\"John_XX\",\r\n__\"email\":_\"john@example_com\",\r\n__\"fact\":_\"Loves_coding\",\r\n__\"hobbies\":_\";a:1:{s:173:\"\r\n    {\r\n      \"id\": \"1\",\r\n      \"customer_id\": \"1\",\r\n      \"hobbies\": \"AAAA\"\r\n    },\r\n    {\r\n      \"id\": \"2\",\r\n      \"customer_id\": \"1\",\r\n      \"hobbies\": \"BBBB\"\r\n    }\r\n  \";s:0:\"\";}}','','127.0.0.1',1496129205,0.194541,'1',204),(57,'api/example/users/22','delete','a:2:{s:2:\"id\";s:2:\"22\";s:97:\"{\r\n__\"name\":_\"John_XX\",\r\n__\"email\":_\"john@example_com\",\r\n__\"fact\":_\"Loves_coding\",\r\n__\"hobbies\":_\";a:1:{s:173:\"\r\n    {\r\n      \"id\": \"1\",\r\n      \"customer_id\": \"1\",\r\n      \"hobbies\": \"AAAA\"\r\n    },\r\n    {\r\n      \"id\": \"2\",\r\n      \"customer_id\": \"1\",\r\n      \"hobbies\": \"BBBB\"\r\n    }\r\n  \";s:0:\"\";}}','','127.0.0.1',1496129218,0.073669,'1',204),(58,'api/example/users/22','delete','a:1:{s:2:\"id\";s:2:\"22\";}','','127.0.0.1',1496129260,0.077739,'1',204),(59,'api/example/users/22','delete','a:1:{s:2:\"id\";s:2:\"22\";}','','127.0.0.1',1496129294,0.085495,'1',204),(60,'api/example/users/22','get','a:1:{s:2:\"id\";s:2:\"22\";}','','127.0.0.1',1496129309,0.141071,'1',404),(61,'api/example/users','get',NULL,'','127.0.0.1',1496129315,0.0739141,'1',200),(62,'api/example/users/21','delete','a:1:{s:2:\"id\";s:2:\"21\";}','','127.0.0.1',1496129340,0.137978,'1',204),(63,'api/example/users','get',NULL,'','127.0.0.1',1496129346,0.071759,'1',200),(64,'api/example/users/19','delete','a:1:{s:2:\"id\";s:2:\"19\";}','','127.0.0.1',1496129396,0.127202,'1',200),(65,'api/example/users','get',NULL,'','127.0.0.1',1496191816,0.076838,'1',200),(66,'api/example/users/1','put','a:5:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:4:\"John\";s:5:\"email\";s:15:\"john@aaabbb.com\";s:4:\"fact\";s:16:\"Loves coding XXX\";s:7:\"hobbies\";a:2:{i:0;a:3:{s:2:\"id\";s:1:\"1\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:8:\"AAAADDDD\";}i:1;a:3:{s:2:\"id\";s:1:\"2\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:7:\"BBBBCCC\";}}}','','127.0.0.1',1496191887,0.0885398,'1',0),(67,'api/example/users/1','put','a:5:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:4:\"John\";s:5:\"email\";s:15:\"john@aaabbb.com\";s:4:\"fact\";s:16:\"Loves coding XXX\";s:7:\"hobbies\";a:2:{i:0;a:3:{s:2:\"id\";s:1:\"1\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:8:\"AAAADDDD\";}i:1;a:3:{s:2:\"id\";s:1:\"2\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:7:\"BBBBCCC\";}}}','','127.0.0.1',1496191955,0.110837,'1',0),(68,'api/example/users/1','put','a:5:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:4:\"John\";s:5:\"email\";s:15:\"john@aaabbb.com\";s:4:\"fact\";s:16:\"Loves coding XXX\";s:7:\"hobbies\";a:2:{i:0;a:3:{s:2:\"id\";s:1:\"1\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:8:\"AAAADDDD\";}i:1;a:3:{s:2:\"id\";s:1:\"2\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:7:\"BBBBCCC\";}}}','','127.0.0.1',1496191989,0.241593,'1',200),(69,'api/example/users','get',NULL,'','127.0.0.1',1496192013,0.106055,'1',200),(70,'api/example/users/1','put','a:5:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:4:\"John\";s:5:\"email\";s:15:\"john@aaabbb.com\";s:4:\"fact\";s:16:\"Loves coding XXX\";s:7:\"hobbies\";a:2:{i:0;a:3:{s:2:\"id\";s:1:\"1\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:8:\"AAAADDDD\";}i:1;a:3:{s:2:\"id\";s:1:\"2\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:7:\"BBBBCCC\";}}}','','127.0.0.1',1496192070,0.186649,'1',200),(71,'api/example/users/1','put','a:5:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:4:\"John\";s:5:\"email\";s:15:\"john@aaabbb.com\";s:4:\"fact\";s:16:\"Loves coding XXX\";s:7:\"hobbies\";a:2:{i:0;a:3:{s:2:\"id\";s:1:\"1\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:8:\"AAAADDDD\";}i:1;a:3:{s:2:\"id\";s:1:\"2\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:7:\"BBBBCCC\";}}}','','127.0.0.1',1496192137,0.104844,'1',0),(72,'api/example/users/1','put','a:5:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:4:\"John\";s:5:\"email\";s:15:\"john@aaabbb.com\";s:4:\"fact\";s:16:\"Loves coding XXX\";s:7:\"hobbies\";a:2:{i:0;a:3:{s:2:\"id\";s:1:\"1\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:8:\"AAAADDDD\";}i:1;a:3:{s:2:\"id\";s:1:\"2\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:7:\"BBBBCCC\";}}}','','127.0.0.1',1496192177,0.133644,'1',0),(73,'api/example/users/1','put','a:5:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:4:\"John\";s:5:\"email\";s:15:\"john@aaabbb.com\";s:4:\"fact\";s:16:\"Loves coding XXX\";s:7:\"hobbies\";a:2:{i:0;a:3:{s:2:\"id\";s:1:\"1\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:8:\"AAAADDDD\";}i:1;a:3:{s:2:\"id\";s:1:\"2\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:7:\"BBBBCCC\";}}}','','127.0.0.1',1496192189,0.101151,'1',0),(74,'api/example/users/1','put','a:5:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:4:\"John\";s:5:\"email\";s:15:\"john@aaabbb.com\";s:4:\"fact\";s:16:\"Loves coding XXX\";s:7:\"hobbies\";a:2:{i:0;a:3:{s:2:\"id\";s:1:\"1\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:8:\"AAAADDDD\";}i:1;a:3:{s:2:\"id\";s:1:\"2\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:7:\"BBBBCCC\";}}}','','127.0.0.1',1496192237,0.240928,'1',200),(75,'api/example/users/1','put','a:5:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:4:\"John\";s:5:\"email\";s:15:\"john@aaabbb.com\";s:4:\"fact\";s:16:\"Loves coding XXX\";s:7:\"hobbies\";a:2:{i:0;a:3:{s:2:\"id\";s:1:\"1\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:8:\"AAAADDDD\";}i:1;a:3:{s:2:\"id\";s:1:\"2\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:7:\"BBBBCCC\";}}}','','127.0.0.1',1496192249,0.203525,'1',200),(76,'api/example/users','get',NULL,'','127.0.0.1',1496192308,0.0773909,'1',200),(77,'api/example/users/1','put','a:5:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:4:\"John\";s:5:\"email\";s:15:\"john@aaabbb.com\";s:4:\"fact\";s:16:\"Loves coding XXX\";s:7:\"hobbies\";a:2:{i:0;a:3:{s:2:\"id\";s:1:\"8\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:8:\"AAAADDDD\";}i:1;a:3:{s:2:\"id\";s:1:\"9\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:7:\"BBBBCCC\";}}}','','127.0.0.1',1496192353,0.203109,'1',200),(78,'api/example/users','get',NULL,'','127.0.0.1',1496193339,0.071697,'1',200),(79,'api/example/users/1','put','a:5:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:4:\"John\";s:5:\"email\";s:15:\"john@aaabbb.com\";s:4:\"fact\";s:16:\"Loves coding XXX\";s:7:\"hobbies\";a:3:{i:0;a:3:{s:2:\"id\";s:1:\"8\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:8:\"AAAADDDD\";}i:1;a:3:{s:2:\"id\";s:1:\"9\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:8:\"AAAADDDD\";}i:2;a:3:{s:2:\"id\";s:2:\"10\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:7:\"BBBBCCC\";}}}','','127.0.0.1',1496193361,0.113544,'1',0),(80,'api/example/users','get',NULL,'','127.0.0.1',1496193426,0.168796,'1',200),(81,'api/example/users/1','put','a:5:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:4:\"John\";s:5:\"email\";s:15:\"john@aaabbb.com\";s:4:\"fact\";s:16:\"Loves coding XXX\";s:7:\"hobbies\";a:2:{i:0;a:3:{s:2:\"id\";s:1:\"8\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:8:\"AAAADDDD\";}i:1;a:3:{s:2:\"id\";s:2:\"10\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:7:\"BBBBCCC\";}}}','','127.0.0.1',1496193445,0.105406,'1',0),(82,'api/example/users/1','put','a:5:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:4:\"John\";s:5:\"email\";s:15:\"john@aaabbb.com\";s:4:\"fact\";s:16:\"Loves coding XXX\";s:7:\"hobbies\";a:2:{i:0;a:3:{s:2:\"id\";s:1:\"8\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:8:\"AAAADDDD\";}i:1;a:3:{s:2:\"id\";s:2:\"10\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:7:\"BBBBCCC\";}}}','','127.0.0.1',1496193806,0.101265,'1',0),(83,'api/example/users/1','put','a:5:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:4:\"John\";s:5:\"email\";s:15:\"john@aaabbb.com\";s:4:\"fact\";s:16:\"Loves coding XXX\";s:7:\"hobbies\";a:2:{i:0;a:3:{s:2:\"id\";s:1:\"8\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:8:\"AAAADDDD\";}i:1;a:3:{s:2:\"id\";s:2:\"10\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:7:\"BBBBCCC\";}}}','','127.0.0.1',1496193843,0.128615,'1',0),(84,'api/example/users/1','put','a:5:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:4:\"John\";s:5:\"email\";s:15:\"john@aaabbb.com\";s:4:\"fact\";s:16:\"Loves coding XXX\";s:7:\"hobbies\";a:2:{i:0;a:3:{s:2:\"id\";s:1:\"8\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:8:\"AAAADDDD\";}i:1;a:3:{s:2:\"id\";s:2:\"10\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:7:\"BBBBCCC\";}}}','','127.0.0.1',1496193884,0.125421,'1',0),(85,'api/example/users/1','put','a:5:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:4:\"John\";s:5:\"email\";s:15:\"john@aaabbb.com\";s:4:\"fact\";s:16:\"Loves coding XXX\";s:7:\"hobbies\";a:2:{i:0;a:3:{s:2:\"id\";s:1:\"8\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:8:\"AAAADDDD\";}i:1;a:3:{s:2:\"id\";s:2:\"10\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:7:\"BBBBCCC\";}}}','','127.0.0.1',1496193891,0.234174,'1',0),(86,'api/example/users/1','put','a:5:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:4:\"John\";s:5:\"email\";s:15:\"john@aaabbb.com\";s:4:\"fact\";s:16:\"Loves coding XXX\";s:7:\"hobbies\";a:2:{i:0;a:3:{s:2:\"id\";s:1:\"8\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:8:\"AAAADDDD\";}i:1;a:3:{s:2:\"id\";s:2:\"10\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:7:\"BBBBCCC\";}}}','','127.0.0.1',1496193922,0.222062,'1',0),(87,'api/example/users/1','put','a:5:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:4:\"John\";s:5:\"email\";s:15:\"john@aaabbb.com\";s:4:\"fact\";s:16:\"Loves coding XXX\";s:7:\"hobbies\";a:2:{i:0;a:3:{s:2:\"id\";s:1:\"8\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:8:\"AAAADDDD\";}i:1;a:3:{s:2:\"id\";s:2:\"10\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:7:\"BBBBCCC\";}}}','','127.0.0.1',1496194029,0.178115,'1',0),(88,'api/example/users/1','put','a:5:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:4:\"John\";s:5:\"email\";s:15:\"john@aaabbb.com\";s:4:\"fact\";s:16:\"Loves coding XXX\";s:7:\"hobbies\";a:2:{i:0;a:3:{s:2:\"id\";s:1:\"8\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:8:\"AAAADDDD\";}i:1;a:3:{s:2:\"id\";s:2:\"10\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:7:\"BBBBCCC\";}}}','','127.0.0.1',1496194060,0.19086,'1',0),(89,'api/example/users/1','put','a:5:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:4:\"John\";s:5:\"email\";s:15:\"john@aaabbb.com\";s:4:\"fact\";s:16:\"Loves coding XXX\";s:7:\"hobbies\";a:2:{i:0;a:3:{s:2:\"id\";s:1:\"8\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:8:\"AAAADDDD\";}i:1;a:3:{s:2:\"id\";s:2:\"10\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:7:\"BBBBCCC\";}}}','','127.0.0.1',1496194094,0.170164,'1',0),(90,'api/example/users/1','put','a:5:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:4:\"John\";s:5:\"email\";s:15:\"john@aaabbb.com\";s:4:\"fact\";s:16:\"Loves coding XXX\";s:7:\"hobbies\";a:2:{i:0;a:3:{s:2:\"id\";s:1:\"8\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:8:\"AAAADDDD\";}i:1;a:3:{s:2:\"id\";s:2:\"10\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:7:\"BBBBCCC\";}}}','','127.0.0.1',1496195682,0.272937,'1',200),(91,'api/example/users','get',NULL,'','127.0.0.1',1496197092,0.595644,'1',200),(92,'api/example/users','get',NULL,'','127.0.0.1',1496197120,0.096559,'1',200),(93,'api/example/users/1','put','a:5:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:4:\"John\";s:5:\"email\";s:15:\"john@aaabbb.com\";s:4:\"fact\";s:16:\"Loves coding XXX\";s:7:\"hobbies\";a:2:{i:0;a:3:{s:2:\"id\";s:2:\"14\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:11:\"AAAADDDDEEE\";}i:1;a:3:{s:2:\"id\";s:2:\"15\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:10:\"BBBBCCCDDD\";}}}','','127.0.0.1',1496197145,0.517957,'1',200),(94,'api/example/users/1','put','a:5:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:4:\"John\";s:5:\"email\";s:15:\"john@aaabbb.com\";s:4:\"fact\";s:16:\"Loves coding XXX\";s:7:\"hobbies\";a:2:{i:0;a:3:{s:2:\"id\";s:2:\"14\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:11:\"AAAADDDDEEE\";}i:1;a:3:{s:2:\"id\";s:2:\"15\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:10:\"BBBBCCCDDD\";}}}','','127.0.0.1',1496197212,0.191146,'1',200),(95,'api/example/users/1','put','a:5:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:4:\"John\";s:5:\"email\";s:15:\"john@aaabbb.com\";s:4:\"fact\";s:16:\"Loves coding XXX\";s:7:\"hobbies\";a:2:{i:0;a:3:{s:2:\"id\";s:2:\"14\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:11:\"AAAADDDDEEE\";}i:1;a:3:{s:2:\"id\";s:2:\"15\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:10:\"BBBBCCCDDD\";}}}','','127.0.0.1',1496197256,0.114279,'1',200),(96,'api/example/users/1','put','a:5:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:4:\"John\";s:5:\"email\";s:15:\"john@aaabbb.com\";s:4:\"fact\";s:16:\"Loves coding XXX\";s:7:\"hobbies\";a:2:{i:0;a:3:{s:2:\"id\";s:2:\"14\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:11:\"AAAADDDDEEE\";}i:1;a:3:{s:2:\"id\";s:2:\"15\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:10:\"BBBBCCCDDD\";}}}','','127.0.0.1',1496197300,0.135532,'1',200),(97,'api/example/users/1','put','a:5:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:4:\"John\";s:5:\"email\";s:15:\"john@aaabbb.com\";s:4:\"fact\";s:16:\"Loves coding XXX\";s:7:\"hobbies\";a:2:{i:0;a:3:{s:2:\"id\";s:2:\"14\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:11:\"AAAADDDDEEE\";}i:1;a:3:{s:2:\"id\";s:2:\"15\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:10:\"BBBBCCCDDD\";}}}','','127.0.0.1',1496197451,0.435196,'1',200),(98,'api/example/users/1','put','a:5:{s:2:\"id\";s:1:\"1\";s:4:\"name\";s:4:\"John\";s:5:\"email\";s:15:\"john@aaabbb.com\";s:4:\"fact\";s:16:\"Loves coding XXX\";s:7:\"hobbies\";a:3:{i:0;a:3:{s:2:\"id\";s:2:\"14\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:11:\"AAAADDDDEEE\";}i:1;a:3:{s:2:\"id\";s:2:\"15\";s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:10:\"BBBBCCCDDD\";}i:2;a:2:{s:11:\"customer_id\";s:1:\"1\";s:7:\"hobbies\";s:11:\"EEEEECCCDDD\";}}}','','127.0.0.1',1496197488,0.229864,'1',200),(99,'api/example/users/1','get','a:1:{s:2:\"id\";s:1:\"1\";}','','127.0.0.1',1496199374,0.068589,'1',200),(100,'api/example/users','get',NULL,'','127.0.0.1',1496199395,0.073669,'1',200),(101,'api/example/users','get',NULL,'','127.0.0.1',1496199405,0.0735459,'1',200),(102,'api/example/users','get',NULL,'','127.0.0.1',1496993395,0.209022,'1',200);
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `nama_menu` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `icons` varchar(255) DEFAULT NULL,
  `urutan` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus`
--

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` VALUES (1,0,'Menu 1','#',NULL,1),(2,0,'Menu 2','#',NULL,2),(3,0,'Menu 3','#',NULL,3),(4,0,'Menu 4','#',NULL,4),(5,4,'Menu 5','#',NULL,1),(6,4,'Menu 6','#',NULL,2),(7,0,'Menu 7','#',NULL,5),(8,5,'Menu 8','#',NULL,1);
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `misc`
--

DROP TABLE IF EXISTS `misc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `misc` (
  `key` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `misc`
--

LOCK TABLES `misc` WRITE;
/*!40000 ALTER TABLE `misc` DISABLE KEYS */;
INSERT INTO `misc` VALUES ('password','y$ErQlCj/Mo10il.FthAm0WOjYdf3chZEGPFqaPzjqOX2aj2uYf5Ihq');
/*!40000 ALTER TABLE `misc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rak`
--

DROP TABLE IF EXISTS `rak`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rak` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_rak` varchar(20) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `no_rak` (`no_rak`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rak`
--

LOCK TABLES `rak` WRITE;
/*!40000 ALTER TABLE `rak` DISABLE KEYS */;
INSERT INTO `rak` VALUES (1,'A-001',NULL,NULL),(2,'A-002',NULL,NULL),(3,'A-003',NULL,NULL),(4,'B-001',NULL,NULL),(5,'B-002',NULL,NULL),(6,'C-001',NULL,NULL),(7,'C-002',NULL,NULL);
/*!40000 ALTER TABLE `rak` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stok_fisik`
--

DROP TABLE IF EXISTS `stok_fisik`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stok_fisik` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `barang_id` int(11) NOT NULL,
  `rak_id` int(11) DEFAULT NULL,
  `no_rak` varchar(20) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `no_bukti` varchar(50) DEFAULT NULL,
  `nama_barang` varchar(255) DEFAULT NULL,
  `qty` double NOT NULL,
  `gudang_id` int(11) DEFAULT NULL,
  `nama_gudang` varchar(255) DEFAULT NULL,
  `expired` date DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `barang_id` (`barang_id`),
  KEY `no_bukti` (`no_bukti`),
  KEY `nama_barang` (`nama_barang`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stok_fisik`
--

LOCK TABLES `stok_fisik` WRITE;
/*!40000 ALTER TABLE `stok_fisik` DISABLE KEYS */;
INSERT INTO `stok_fisik` VALUES (1,1,1,'A-001','2017-11-16','001/STK/11/2017','PEPSODENT 125mg (PCS )',12,NULL,NULL,'2017-01-03','',NULL,NULL),(2,1,NULL,NULL,'2017-11-22','111','A001-PEPSODENT 125mg',1000,2,'G01-Gudang 1','2017-11-21',NULL,'2017-11-22 22:41:40',NULL);
/*!40000 ALTER TABLE `stok_fisik` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'127.0.0.1','administrator','$2y$08$G0h47xFzvBDD3DjwWD13XeCfwGuZgqtSodh5ARhDJLLWPRv0jSgfG','','admin@admin.com','',NULL,NULL,NULL,1268889823,1511493111,1,'Administrator','','ADMIN','0'),(2,'172.17.0.1','coba@coba.com','$2y$08$uGrWVA6PAMqe.5nbGjBpvufetRdq24dM/3rRE5XbJVxyaLYXE3LYa',NULL,'coba@coba.com',NULL,NULL,NULL,NULL,1503046181,1503047865,1,'coba','coba','','');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_groups`
--

DROP TABLE IF EXISTS `users_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`),
  CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_groups`
--

LOCK TABLES `users_groups` WRITE;
/*!40000 ALTER TABLE `users_groups` DISABLE KEYS */;
INSERT INTO `users_groups` VALUES (1,1,1),(2,1,2),(3,2,2);
/*!40000 ALTER TABLE `users_groups` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-11-24 17:06:20
