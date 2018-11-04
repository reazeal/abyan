-- MySQL dump 10.13  Distrib 5.7.23, for Linux (x86_64)
--
-- Host: localhost    Database: abyan_jaya
-- ------------------------------------------------------
-- Server version	5.7.23-0ubuntu0.16.04.1

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
  `id` varchar(45) NOT NULL,
  `kode` varchar(45) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `satuan` varchar(10) DEFAULT NULL,
  `batas_stok` int(11) DEFAULT NULL,
  `status_stok` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_user` varchar(45) DEFAULT NULL,
  `updated_user` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `nama` (`nama`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barang`
--

LOCK TABLES `barang` WRITE;
/*!40000 ALTER TABLE `barang` DISABLE KEYS */;
INSERT INTO `barang` VALUES ('26ec31a8a3ffaad42575461a5c56707c','OXHCE','Oxtail','','KG',10,NULL,NULL,NULL,NULL,NULL),('576b70f1c53508506897f038309d7eb6','D0003','Rawonan','','KG',10,NULL,NULL,NULL,NULL,NULL),('69e825160f2dd092b2d5cd93187679e3','A001','Tes Barang','tes ket','KG',10,NULL,NULL,NULL,NULL,NULL),('895e6036c4d6fe30716510eb914a62df','D002','Dori B','Tes','KG',8,NULL,NULL,NULL,NULL,NULL),('943399e280ab1bef4e82b33210ef03e6','D001','Dori A','','KG',10,NULL,NULL,NULL,NULL,NULL),('da96d3cd3ad66ac673e78ca0df0c483d','K0001','Kikil','','KG',10,NULL,NULL,NULL,NULL,NULL),('e6cf4063b3f622d2cb17ea231c9ab95b','D0004','Daging','','KG',5,NULL,NULL,NULL,NULL,NULL),('f8533209a533da01696e88970d06da3a','S0001','Teripang','','KG',3,NULL,NULL,NULL,NULL,NULL),('fae327c8a51b99cf6be1c63c21daadf1','T0001','Tenderloin','','KG',5,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `barang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `barang_keluar`
--

DROP TABLE IF EXISTS `barang_keluar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `barang_keluar` (
  `id` varchar(40) NOT NULL,
  `kode_barang_keluar` varchar(45) DEFAULT NULL,
  `nomor_referensi` varchar(45) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `jenis_trans` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_user` varchar(45) DEFAULT NULL,
  `updated_user` varchar(45) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barang_keluar`
--

LOCK TABLES `barang_keluar` WRITE;
/*!40000 ALTER TABLE `barang_keluar` DISABLE KEYS */;
/*!40000 ALTER TABLE `barang_keluar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `barang_masuk`
--

DROP TABLE IF EXISTS `barang_masuk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `barang_masuk` (
  `id` varchar(50) NOT NULL,
  `tanggal` date NOT NULL,
  `nomor_referensi` varchar(255) NOT NULL,
  `jenis_trans` varchar(45) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `created_user` varchar(50) DEFAULT NULL,
  `updated_user` varchar(50) DEFAULT NULL,
  `kode_barang_masuk` varchar(45) DEFAULT NULL,
  `kode_penerimaan` varchar(45) DEFAULT NULL,
  `kode_barang` varchar(45) DEFAULT NULL,
  `nama_barang` varchar(45) DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `harga_beli` double DEFAULT NULL,
  `buttom_supplier` double DEFAULT NULL,
  `buttom_retail` double DEFAULT NULL,
  `keluar` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barang_masuk`
--

LOCK TABLES `barang_masuk` WRITE;
/*!40000 ALTER TABLE `barang_masuk` DISABLE KEYS */;
INSERT INTO `barang_masuk` VALUES ('11d3d5d571b391589f20965c8cec3d1c','2018-10-31','002/PO/10/2018','PEMBELIAN',NULL,NULL,NULL,NULL,NULL,NULL,'00003/BM/10/2018',NULL,'D0003','Rawonan',4,NULL,0,0,NULL),('2d077bcef8143eda5f1b29abfe95b406','2018-10-31','002/PO/10/2018','PEMBELIAN',NULL,NULL,NULL,NULL,NULL,NULL,'00004/BM/10/2018',NULL,'OXHCE','Oxtail',2,NULL,0,0,NULL),('3377761d5145d8b712a3a808c57111fe','2018-10-31','002/PO/10/2018','PEMBELIAN',NULL,NULL,NULL,NULL,NULL,NULL,'00011/BM/10/2018',NULL,'D0003','Rawonan',2,NULL,0,0,NULL),('5421da3b08a8017f8ee2598a9f77bde0','2018-10-31','002/PO/10/2018','PEMBELIAN',NULL,NULL,NULL,NULL,NULL,NULL,'00005/BM/10/2018',NULL,'D0003','Rawonan',2,NULL,0,0,NULL),('9abeea10d63d6b3182a5b63b17b389b4','2018-10-31','002/PO/10/2018','PEMBELIAN',NULL,NULL,NULL,NULL,NULL,NULL,'00006/BM/10/2018',NULL,'OXHCE','Oxtail',3,NULL,0,0,NULL),('9c59a47fcd2d74d0fb1ca25ad05abd0a','2018-10-31','002/PO/10/2018','PEMBELIAN',NULL,NULL,NULL,NULL,NULL,NULL,'00002/BM/10/2018',NULL,'D0003','Rawonan',4,NULL,0,0,NULL),('c75e0fcc536157578d749deba070b743','2018-10-31','002/PO/10/2018','PEMBELIAN',NULL,NULL,NULL,NULL,NULL,NULL,'00009/BM/10/2018',NULL,'D0003','Rawonan',2,NULL,0,0,NULL),('cf93bafcf94d57f5cfa6ebaba3a9e54e','2018-10-31','002/PO/10/2018','PEMBELIAN',NULL,NULL,NULL,NULL,NULL,NULL,'000010/BM/10/2018',NULL,'D0003','Rawonan',2,NULL,0,0,NULL),('e3162f10367b85d5656cbe28318d0cb2','2018-10-31','002/PO/10/2018','PEMBELIAN',NULL,NULL,NULL,NULL,NULL,NULL,'00008/BM/10/2018',NULL,'D0003','Rawonan',2,NULL,0,0,NULL),('ec17e97935fe02e8cbd68a2f4cac7baa','2018-10-31','002/PO/10/2018','PEMBELIAN',NULL,NULL,NULL,NULL,NULL,NULL,'00007/BM/10/2018',NULL,'D0003','Rawonan',2,NULL,0,0,NULL),('f1f890f70211b3430b9f295ee20adae5','2018-10-30','001/PO/10/2018','PEMBELIAN',NULL,NULL,NULL,NULL,NULL,NULL,'00001/BM/10/2018',NULL,'D0004','Daging',10,NULL,0,0,NULL);
/*!40000 ALTER TABLE `barang_masuk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers` (
  `id` varchar(255) NOT NULL,
  `kode_customer` varchar(45) DEFAULT NULL,
  `nama_customer` varchar(150) DEFAULT NULL,
  `alamat_customer` varchar(255) DEFAULT NULL,
  `no_telp` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_user` varchar(45) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(45) DEFAULT NULL,
  `jenis` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES ('',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Customer Retail'),('5cfdf4c6a0c3a3e4a15a97df0dd53724','COO12','Customer baru','di rumah customer','141231413',NULL,NULL,NULL,NULL,'Customer Retail'),('78f1571553e298222f69a831cdba439f','C002','C2','g','123',NULL,NULL,NULL,NULL,'Customer Retail');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detail_barang_keluar`
--

DROP TABLE IF EXISTS `detail_barang_keluar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detail_barang_keluar` (
  `id` varchar(25) NOT NULL,
  `id_barang_keluar` varchar(45) DEFAULT NULL,
  `nomor_referensi` varchar(45) DEFAULT NULL,
  `kode_barang` varchar(45) DEFAULT NULL,
  `nama_barang` varchar(45) DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_user` varchar(45) DEFAULT NULL,
  `updated_user` varchar(45) DEFAULT NULL,
  `saldo_awal` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detail_barang_keluar`
--

LOCK TABLES `detail_barang_keluar` WRITE;
/*!40000 ALTER TABLE `detail_barang_keluar` DISABLE KEYS */;
/*!40000 ALTER TABLE `detail_barang_keluar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detail_barang_masuk`
--

DROP TABLE IF EXISTS `detail_barang_masuk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detail_barang_masuk` (
  `id` varchar(40) NOT NULL,
  `kode_barang_masuk` varchar(40) NOT NULL,
  `nomor_referensi` varchar(40) NOT NULL,
  `kode_barang` varchar(40) NOT NULL,
  `nama_barang` varchar(255) DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `expired` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_user` varchar(255) DEFAULT NULL,
  `updated_user` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `keluar` double DEFAULT NULL,
  `harga_beli` double DEFAULT NULL,
  `buttom_supplier` double DEFAULT NULL,
  `buttom_retail` double DEFAULT NULL,
  `kode_penerimaan_po` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detail_barang_masuk`
--

LOCK TABLES `detail_barang_masuk` WRITE;
/*!40000 ALTER TABLE `detail_barang_masuk` DISABLE KEYS */;
/*!40000 ALTER TABLE `detail_barang_masuk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detail_penerimaan_po`
--

DROP TABLE IF EXISTS `detail_penerimaan_po`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detail_penerimaan_po` (
  `id` varchar(255) NOT NULL,
  `kode_penerimaan_po` varchar(45) DEFAULT NULL,
  `kode_barang` varchar(45) DEFAULT NULL,
  `nama_barang` varchar(45) DEFAULT NULL,
  `qty_terima` double DEFAULT NULL,
  `qty_return` double DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_user` varchar(45) DEFAULT NULL,
  `updated_user` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detail_penerimaan_po`
--

LOCK TABLES `detail_penerimaan_po` WRITE;
/*!40000 ALTER TABLE `detail_penerimaan_po` DISABLE KEYS */;
INSERT INTO `detail_penerimaan_po` VALUES ('3000adb8280556b98462763dd9955e9c','002/PP/10/2018','D0003','Rawonan',2,NULL,NULL,NULL,NULL,NULL),('42d3c807ca65bba057542819150903b6','002/PP/10/2018','D0003','Rawonan',2,NULL,NULL,NULL,NULL,NULL),('484b23c9b3ea5dad48c1f06b50993744','002/PP/10/2018','D0003','Rawonan',2,NULL,NULL,NULL,NULL,NULL),('566a8882ca3b0daf2c13d3db95bc7a96','002/PP/10/2018','OXHCE','Oxtail',3,NULL,NULL,NULL,NULL,NULL),('57334229db879ad68584a67d29061f62','002/PP/10/2018','D0003','Rawonan',2,NULL,NULL,NULL,NULL,NULL),('779a15c1801b24af1b4450bd38dbd449','002/PP/10/2018','D0003','Rawonan',2,NULL,NULL,NULL,NULL,NULL),('895f6e1b87992431ebaf2ca94e49528e','001/PP/10/2018','D0003','Rawonan',2,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `detail_penerimaan_po` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detail_po`
--

DROP TABLE IF EXISTS `detail_po`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detail_po` (
  `id` varchar(50) NOT NULL,
  `kode_po` varchar(45) DEFAULT NULL,
  `kode_barang` varchar(45) DEFAULT NULL,
  `nama_barang` varchar(45) DEFAULT NULL,
  `qty` varchar(45) DEFAULT NULL,
  `harga` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `buttom_retail` double DEFAULT NULL,
  `buttom_supplier` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detail_po`
--

LOCK TABLES `detail_po` WRITE;
/*!40000 ALTER TABLE `detail_po` DISABLE KEYS */;
INSERT INTO `detail_po` VALUES ('7c14576fd3f87cf7061e2c2e7d4cebaf','001/PO/10/2018','D0004','Daging','10','13000','Proses','2018-10-30 22:20:45',NULL,130000,15000),('86d8224d20c85ee8d25afa5edf1cc018','002/PO/10/2018','OXHCE','Oxtail','10','10000','Proses','2018-10-31 12:55:03',NULL,100000,100000),('9019b490245daac42e1aa64edc2cefb5','002/PO/10/2018','D0003','Rawonan','10','100000','Proses','2018-10-31 12:55:03',NULL,1000000,100000);
/*!40000 ALTER TABLE `detail_po` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detail_so`
--

DROP TABLE IF EXISTS `detail_so`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detail_so` (
  `id` varchar(55) NOT NULL,
  `kode_so` varchar(45) DEFAULT NULL,
  `kode_barang` varchar(45) DEFAULT NULL,
  `nama_barang` varchar(45) DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `satuan` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(45) DEFAULT NULL,
  `created_user` varchar(45) DEFAULT NULL,
  `harga` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detail_so`
--

LOCK TABLES `detail_so` WRITE;
/*!40000 ALTER TABLE `detail_so` DISABLE KEYS */;
/*!40000 ALTER TABLE `detail_so` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `id` int(11) DEFAULT NULL,
  `name` text,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
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
-- Table structure for table `hutang`
--

DROP TABLE IF EXISTS `hutang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hutang` (
  `id` varchar(50) NOT NULL,
  `kode_hutang` varchar(45) DEFAULT NULL,
  `kode_relasi` varchar(45) DEFAULT NULL,
  `nama_relasi` varchar(45) DEFAULT NULL,
  `nomor_referensi` varchar(45) DEFAULT NULL,
  `jenis` varchar(45) DEFAULT NULL,
  `nominal` varchar(45) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `tanggal_jatuh_tempo` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_user` varchar(45) DEFAULT NULL,
  `updated_user` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hutang`
--

LOCK TABLES `hutang` WRITE;
/*!40000 ALTER TABLE `hutang` DISABLE KEYS */;
INSERT INTO `hutang` VALUES ('06e2b7d8f4e094d93bf81813fec45791','00006/HT/10/2018','S002','Supplier 2','002/PP/10/2018','PEMBELIAN','30000','2018-10-31','2018-11-01','2018-10-31 12:59:20',NULL,NULL,NULL,'Belum Lunas'),('1267fbbfc915747a96098cd2636ab953','000010/HT/10/2018','S002','Supplier 2',NULL,'PEMBELIAN','200000','2018-10-31','2018-11-01','2018-10-31 13:02:46',NULL,NULL,NULL,'Belum Lunas'),('48f9a17ef71c740d02de007e592b6fe7','00009/HT/10/2018','S002','Supplier 2',NULL,'PEMBELIAN','200000','2018-10-31','2018-11-01','2018-10-31 13:02:11',NULL,NULL,NULL,'Belum Lunas'),('4d2d1677d126268dad4d3527a71627fa','00008/HT/10/2018','S002','Supplier 2',NULL,'PEMBELIAN','200000','2018-10-31','2018-11-01','2018-10-31 13:01:54',NULL,NULL,NULL,'Belum Lunas'),('9958426b84ab4ac185bc4cab7223f040','00002/HT/10/2018','S002','Supplier 2','002/PP/10/2018','PEMBELIAN','400000','2018-10-31','2018-11-01','2018-10-31 12:56:22',NULL,NULL,NULL,'Belum Lunas'),('a42e78013434881e3666b8f87cd48a8a','00007/HT/10/2018','S002','Supplier 2',NULL,'PEMBELIAN','200000','2018-10-31','2018-11-01','2018-10-31 13:01:17',NULL,NULL,NULL,'Belum Lunas'),('a64eca391c5328fbed088f77c035c088','00004/HT/10/2018','S002','Supplier 2','004/PP/10/2018','PEMBELIAN','20000','2018-10-31','2018-11-01','2018-10-31 12:57:20',NULL,NULL,NULL,'Belum Lunas'),('d2373e0422944f88b639b85a5e84add6','00005/HT/10/2018','S002','Supplier 2','001/PP/10/2018','PEMBELIAN','200000','2018-10-31','2018-11-01','2018-10-31 12:59:01',NULL,NULL,NULL,'Belum Lunas'),('d25c39ba57a8af1a3ec352116552acb3','00001/HT/10/2018','S002','Supplier 2','001/PP/10/2018','PEMBELIAN','130000','2018-10-30','2018-11-09','2018-10-30 22:20:57',NULL,NULL,NULL,'Belum Lunas'),('e2aee16719171f1308eb8a17f317ae0c','00011/HT/10/2018','S002','Supplier 2','002/PP/10/2018','PEMBELIAN','200000','2018-10-31','2018-11-01','2018-10-31 13:03:10',NULL,NULL,NULL,'Belum Lunas'),('eb67a56d6300287a0056874e135a029b','00003/HT/10/2018','S002','Supplier 2','003/PP/10/2018','PEMBELIAN','400000','2018-10-31','2018-11-01','2018-10-31 12:57:01',NULL,NULL,NULL,'Belum Lunas');
/*!40000 ALTER TABLE `hutang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pegawai`
--

DROP TABLE IF EXISTS `pegawai`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pegawai` (
  `id` varchar(50) NOT NULL,
  `kode_pegawai` varchar(45) DEFAULT NULL,
  `nama_pegawai` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_user` varchar(45) DEFAULT NULL,
  `updated_user` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pegawai`
--

LOCK TABLES `pegawai` WRITE;
/*!40000 ALTER TABLE `pegawai` DISABLE KEYS */;
INSERT INTO `pegawai` VALUES ('','D001','Pegawai Satu',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `pegawai` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pembayaran_hutang`
--

DROP TABLE IF EXISTS `pembayaran_hutang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pembayaran_hutang` (
  `id` varchar(50) NOT NULL,
  `kode_pembayaran_hutang` varchar(45) DEFAULT NULL,
  `kode_hutang` varchar(45) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `nominal` double DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_user` varchar(45) DEFAULT NULL,
  `updated_user` varchar(45) DEFAULT NULL,
  `kode_relasi` varchar(45) DEFAULT NULL,
  `nama_relasi` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pembayaran_hutang`
--

LOCK TABLES `pembayaran_hutang` WRITE;
/*!40000 ALTER TABLE `pembayaran_hutang` DISABLE KEYS */;
/*!40000 ALTER TABLE `pembayaran_hutang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pembayaran_piutang`
--

DROP TABLE IF EXISTS `pembayaran_piutang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pembayaran_piutang` (
  `id` varchar(50) NOT NULL,
  `kode_pembayaran_piutang` varchar(45) DEFAULT NULL,
  `kode_piutang` varchar(45) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `nominal` double DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_user` varchar(45) DEFAULT NULL,
  `updated_user` varchar(45) DEFAULT NULL,
  `kode_relasi` varchar(45) DEFAULT NULL,
  `nama_relasi` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pembayaran_piutang`
--

LOCK TABLES `pembayaran_piutang` WRITE;
/*!40000 ALTER TABLE `pembayaran_piutang` DISABLE KEYS */;
/*!40000 ALTER TABLE `pembayaran_piutang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penerimaan_po`
--

DROP TABLE IF EXISTS `penerimaan_po`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `penerimaan_po` (
  `id` varchar(255) NOT NULL,
  `kode_penerimaan_po` varchar(45) DEFAULT NULL,
  `kode_po` varchar(45) DEFAULT NULL,
  `tanggal` varchar(45) DEFAULT NULL,
  `kode_supplier` varchar(45) DEFAULT NULL,
  `nama_supplier` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_user` varchar(45) DEFAULT NULL,
  `updated_user` varchar(45) DEFAULT NULL,
  `kode_barang` varchar(45) DEFAULT NULL,
  `nama_barang` varchar(45) DEFAULT NULL,
  `qty_terima` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penerimaan_po`
--

LOCK TABLES `penerimaan_po` WRITE;
/*!40000 ALTER TABLE `penerimaan_po` DISABLE KEYS */;
INSERT INTO `penerimaan_po` VALUES ('52d00057cc027908fd8077b881f0bc5e','001/PP/10/2018','002/PO/10/2018','2018-10-31','S002','Supplier 2',NULL,NULL,NULL,NULL,NULL,NULL,NULL),('eab1975d166c5f923884c92e9d8a9a8b','002/PP/10/2018','002/PO/10/2018','2018-10-31','S002','Supplier 2',NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `penerimaan_po` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengiriman_so`
--

DROP TABLE IF EXISTS `pengiriman_so`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pengiriman_so` (
  `id` varchar(50) NOT NULL,
  `kode_pengiriman` varchar(45) DEFAULT NULL,
  `kode_so` varchar(45) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `nama_kurir` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_user` varchar(45) DEFAULT NULL,
  `updated_user` varchar(45) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `kode_barang` varchar(45) DEFAULT NULL,
  `nama_barang` varchar(45) DEFAULT NULL,
  `kode_kurir` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengiriman_so`
--

LOCK TABLES `pengiriman_so` WRITE;
/*!40000 ALTER TABLE `pengiriman_so` DISABLE KEYS */;
/*!40000 ALTER TABLE `pengiriman_so` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `piutang`
--

DROP TABLE IF EXISTS `piutang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `piutang` (
  `id` varchar(50) NOT NULL,
  `kode_piutang` varchar(45) DEFAULT NULL,
  `kode_referensi` varchar(45) DEFAULT NULL,
  `kode_relasi` varchar(45) DEFAULT NULL,
  `nama_relasi` varchar(100) DEFAULT NULL,
  `jenis` varchar(45) DEFAULT NULL,
  `nominal` double DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `tanggal_jatuh_tempo` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_user` varchar(45) DEFAULT NULL,
  `updated_user` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `piutang`
--

LOCK TABLES `piutang` WRITE;
/*!40000 ALTER TABLE `piutang` DISABLE KEYS */;
/*!40000 ALTER TABLE `piutang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchase_order`
--

DROP TABLE IF EXISTS `purchase_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchase_order` (
  `id` varchar(50) NOT NULL,
  `kode_po` varchar(45) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `kode_supplier` varchar(45) DEFAULT NULL,
  `nama_supplier` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `top` double DEFAULT NULL,
  `created_user` varchar(45) DEFAULT NULL,
  `updated_user` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchase_order`
--

LOCK TABLES `purchase_order` WRITE;
/*!40000 ALTER TABLE `purchase_order` DISABLE KEYS */;
INSERT INTO `purchase_order` VALUES ('23de4dd82763f89a9c530fb4e063781b','002/PO/10/2018','2018-10-31','S002','Supplier 2','2018-10-31 12:55:03',NULL,1,NULL,NULL,'Proses'),('7b6e06b8e28a324b14001ee91955c187','001/PO/10/2018','2018-10-30','S002','Supplier 2','2018-10-30 22:20:45',NULL,10,NULL,NULL,'Selesai');
/*!40000 ALTER TABLE `purchase_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales_order`
--

DROP TABLE IF EXISTS `sales_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales_order` (
  `id` varchar(50) NOT NULL,
  `kode_so` varchar(45) DEFAULT NULL,
  `kode_customer` varchar(45) DEFAULT NULL,
  `nama_customer` varchar(45) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_user` varchar(45) DEFAULT NULL,
  `updated_user` varchar(45) DEFAULT NULL,
  `top` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales_order`
--

LOCK TABLES `sales_order` WRITE;
/*!40000 ALTER TABLE `sales_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `sales_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stok`
--

DROP TABLE IF EXISTS `stok`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stok` (
  `id` varchar(50) NOT NULL,
  `kode` varchar(45) DEFAULT NULL,
  `nama_barang` varchar(45) DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_user` varchar(45) DEFAULT NULL,
  `updated_user` varchar(45) DEFAULT NULL,
  `status_stok` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stok`
--

LOCK TABLES `stok` WRITE;
/*!40000 ALTER TABLE `stok` DISABLE KEYS */;
/*!40000 ALTER TABLE `stok` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stok_opname`
--

DROP TABLE IF EXISTS `stok_opname`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stok_opname` (
  `id` varchar(50) NOT NULL,
  `kode_stok_opname` varchar(45) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `kode_barang` varchar(45) DEFAULT NULL,
  `nama_barang` varchar(45) DEFAULT NULL,
  `qty` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_user` varchar(45) DEFAULT NULL,
  `updated_user` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stok_opname`
--

LOCK TABLES `stok_opname` WRITE;
/*!40000 ALTER TABLE `stok_opname` DISABLE KEYS */;
/*!40000 ALTER TABLE `stok_opname` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supplier`
--

DROP TABLE IF EXISTS `supplier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `supplier` (
  `id` varchar(255) NOT NULL,
  `kode_supplier` varchar(45) DEFAULT NULL,
  `nama_supplier` varchar(150) DEFAULT NULL,
  `alamat_supplier` varchar(255) DEFAULT NULL,
  `nomor_telp` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_user` varchar(45) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_user` varchar(45) DEFAULT NULL,
  `jenis` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplier`
--

LOCK TABLES `supplier` WRITE;
/*!40000 ALTER TABLE `supplier` DISABLE KEYS */;
INSERT INTO `supplier` VALUES ('8c194d2a8008ebc2ba1ecd006bb74a5d','C001','Cust Satu','Gresik','01988',NULL,NULL,NULL,NULL,NULL),('e6a770b0860b249a08d4adb036661c1a','S002','Supplier 2','Gresik','389098',NULL,NULL,NULL,NULL,NULL),('eb74a32c4a62996b272e0dbfde1f8fe4','S0001','Supplier 1','Alamat Supplier 1','9090909',NULL,NULL,NULL,NULL,NULL),('ef671fe8c81d56e3b96bf5df6300e7f1','C002','Cust Dua','Gresik','677',NULL,NULL,NULL,NULL,'Customer Supplier');
/*!40000 ALTER TABLE `supplier` ENABLE KEYS */;
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
INSERT INTO `users` VALUES (1,'127.0.0.1','administrator','$2y$08$G0h47xFzvBDD3DjwWD13XeCfwGuZgqtSodh5ARhDJLLWPRv0jSgfG','','admin@admin.com','','',0,'',1268889823,1540965219,1,'Administrator','','ADMIN','0'),(2,'172.17.0.1','coba@coba.com','$2y$08$uGrWVA6PAMqe.5nbGjBpvufetRdq24dM/3rRE5XbJVxyaLYXE3LYa','','coba@coba.com','','',0,'',1503046181,1503047865,1,'coba','coba','','');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_groups`
--

DROP TABLE IF EXISTS `users_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_groups` (
  `id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
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

-- Dump completed on 2018-11-04 14:57:56
