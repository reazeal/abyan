-- MySQL dump 10.13  Distrib 5.7.20, for Linux (x86_64)
--
-- Host: 192.168.11.25    Database: abyan_jaya
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
INSERT INTO `barang` VALUES ('895e6036c4d6fe30716510eb914a62df','D002','Dori B','Tes','KG',8,NULL,NULL,NULL,NULL,NULL),('943399e280ab1bef4e82b33210ef03e6','D001','Dori A','','KG',10,NULL,NULL,NULL,NULL,NULL),('e6cf4063b3f622d2cb17ea231c9ab95b','D0004','Daging','','KG',5,NULL,NULL,NULL,NULL,NULL),('f8533209a533da01696e88970d06da3a','S0001','Teripang','','KG',3,NULL,NULL,NULL,NULL,NULL);
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
INSERT INTO `barang_keluar` VALUES ('250caa2e659f89a7d551cc1ff238c59e','000010/BK/10/2018','e23e2312','2018-10-08',NULL,NULL,NULL,NULL,NULL,'321'),('6095e8a829e31c0e0084a3c3e88fc685','00001/BK/10/2018',NULL,'2018-10-08',NULL,NULL,NULL,NULL,NULL,'tes'),('62c39617d09be137dcc5f5c92ec96e82','00003/BK/10/2018','32323','2018-10-08',NULL,NULL,NULL,NULL,NULL,'2121'),('73ee5c665729d94981f70666eecf091f','00006/BK/10/2018','32321','2018-10-08',NULL,NULL,NULL,NULL,NULL,'ew'),('7d163fc21dbf34ac1bcfec9f3b10a5d8','00005/BK/10/2018','1223','2018-10-08',NULL,NULL,NULL,NULL,NULL,'434'),('8bab809360f9c00c164bfde912c04122','00008/BK/10/2018','e23e2312','2018-10-08',NULL,NULL,NULL,NULL,NULL,'321'),('8de3fdfa2d00e8f55c0e80e157cb3a44','00007/BK/10/2018','32321','2018-10-08',NULL,NULL,NULL,NULL,NULL,'ew'),('9a5408440be22a2aa6797694f1cfedf3','00009/BK/10/2018','e23e2312','2018-10-08',NULL,NULL,NULL,NULL,NULL,'321'),('9ea19aaff6a5a613bb4f0caa2911ad23','00002/BK/10/2018',NULL,'2018-10-08',NULL,NULL,NULL,NULL,NULL,'232'),('e9ddf2937f7d41ed10a111bf23f33a38','00012/BK/10/2018','32131','2018-10-09',NULL,NULL,NULL,NULL,NULL,'23123'),('ede9ea5eb6d5ed7d19808b594c109e88','00011/BK/10/2018','32131','2018-10-09',NULL,NULL,NULL,NULL,NULL,'23123'),('fd0c6b5fb79392251e87addb4ac6baac','00004/BK/10/2018','32323','2018-10-08',NULL,NULL,NULL,NULL,NULL,'21');
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barang_masuk`
--

LOCK TABLES `barang_masuk` WRITE;
/*!40000 ALTER TABLE `barang_masuk` DISABLE KEYS */;
INSERT INTO `barang_masuk` VALUES ('0ddfe1a60f3dcf0f37b6959c354c8641','2018-10-12','00002/PO/10/2018','PEMBELIAN',NULL,NULL,NULL,NULL,NULL,NULL,'00001/BM/10/2018'),('12d2b62df3c8c03058407e3e0dd3a674','2018-10-12','00002/PO/10/2018','PEMBELIAN',NULL,NULL,NULL,NULL,NULL,NULL,'00002/BM/10/2018'),('dd7cbfe7c94bef7a3a73b184926ac372','2018-10-12','00002/PO/10/2018','PEMBELIAN',NULL,NULL,NULL,NULL,NULL,NULL,'00003/BM/10/2018');
/*!40000 ALTER TABLE `barang_masuk` ENABLE KEYS */;
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
INSERT INTO `detail_barang_keluar` VALUES ('','250caa2e659f89a7d551cc1ff238c59e',NULL,'D001','Dori A (KG )',1,'2018-10-08 14:28:33',NULL,NULL,NULL,12),('fd58d3dee7cca0b458521a68c','e9ddf2937f7d41ed10a111bf23f33a38',NULL,'D001','Dori A (KG )',5,'2018-10-08 14:30:17',NULL,NULL,NULL,11);
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
  `id_barang_masuk` varchar(40) NOT NULL,
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detail_barang_masuk`
--

LOCK TABLES `detail_barang_masuk` WRITE;
/*!40000 ALTER TABLE `detail_barang_masuk` DISABLE KEYS */;
INSERT INTO `detail_barang_masuk` VALUES ('097d35285e413d5a6d6226359f38b7e6','0ddfe1a60f3dcf0f37b6959c354c8641','00002/PO/10/2018','S0001','Teripang',15,NULL,'2018-10-12 16:38:40',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL),('21774f65de9362efdd3959e3305eee09','dd7cbfe7c94bef7a3a73b184926ac372','00002/PO/10/2018','S0001','Teripang',15,NULL,'2018-10-12 16:39:41',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL),('5b40c39a430ffe1bf57fd479be52888e','12d2b62df3c8c03058407e3e0dd3a674','00002/PO/10/2018','S0001','Teripang',15,NULL,'2018-10-12 16:39:08',NULL,NULL,NULL,NULL,0,NULL,NULL,NULL);
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
INSERT INTO `detail_penerimaan_po` VALUES ('4caa126431f8f71a557aacb807117a37','00002/PP/10/2018','S0001','Teripang',15,NULL,NULL,NULL,NULL,NULL),('4dfb922593a55197ea5f05750b740af5','00001/PP/10/2018','S0001','Teripang',15,NULL,NULL,NULL,NULL,NULL),('5e506a53545813c6101ace2193fbe632','00003/PP/10/2018','S0001','Teripang',15,NULL,NULL,NULL,NULL,NULL);
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detail_po`
--

LOCK TABLES `detail_po` WRITE;
/*!40000 ALTER TABLE `detail_po` DISABLE KEYS */;
INSERT INTO `detail_po` VALUES ('5a91009a32572567a8a5b5b88f475476','00001/PO/10/2018','D001','Dori A','100','12000','Proses','2018-10-12 15:33:01',NULL),('d2f6b36b178e771d6e7956480e31b434','00002/PO/10/2018','S0001','Teripang','15','25000','Finish','2018-10-12 16:17:51',NULL);
/*!40000 ALTER TABLE `detail_po` ENABLE KEYS */;
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penerimaan_po`
--

LOCK TABLES `penerimaan_po` WRITE;
/*!40000 ALTER TABLE `penerimaan_po` DISABLE KEYS */;
INSERT INTO `penerimaan_po` VALUES ('548ff449ca801a127456659bc7e6964c','00003/PP/10/2018','00002/PO/10/2018','2018-10-12','S0001','Supplier 1',NULL,NULL,NULL,NULL),('6b47190e5d66a0077e5d2a8d88204383','00001/PP/10/2018','00002/PO/10/2018','2018-10-12','S0001','Supplier 1',NULL,NULL,NULL,NULL),('95e7f8e9dd431d0972e4ee7b8c48a619','00002/PP/10/2018','00002/PO/10/2018','2018-10-12','S0001','Supplier 1',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `penerimaan_po` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchase_order`
--

DROP TABLE IF EXISTS `purchase_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchase_order` (
  `id` int(11) NOT NULL,
  `kode_po` varchar(45) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `kode_supplier` varchar(45) DEFAULT NULL,
  `nama_supplier` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `top` double DEFAULT NULL,
  `created_user` varchar(45) DEFAULT NULL,
  `updated_user` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchase_order`
--

LOCK TABLES `purchase_order` WRITE;
/*!40000 ALTER TABLE `purchase_order` DISABLE KEYS */;
INSERT INTO `purchase_order` VALUES (908,'00001/PO/10/2018','2018-10-12','S0001','Supplier 1','2018-10-12 15:33:01',NULL,NULL,NULL,NULL),(6669678,'00002/PO/10/2018','2018-10-12','S0001','Supplier 1','2018-10-12 16:17:51',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `purchase_order` ENABLE KEYS */;
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
INSERT INTO `stok` VALUES ('1875b7ab10989cd6b8ce8b987da59c9f','D001','Dori A',0,'2018-10-07 20:20:32',NULL,NULL,NULL,'Stok Baik'),('39b9b5ec5fafc3f21b6fc107fe28bb20','D002','Dori B',0,'2018-10-10 22:44:30',NULL,NULL,NULL,'Stok Limit'),('aa071a383b20e18d0a3f4578c706560e','S0001','Teripang',45,'2018-10-12 15:42:12',NULL,NULL,NULL,'Stok Baik'),('e4afe9703c29a190ec4399e19ffac205','D0004','Daging',0,'2018-10-12 15:27:24',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `stok` ENABLE KEYS */;
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplier`
--

LOCK TABLES `supplier` WRITE;
/*!40000 ALTER TABLE `supplier` DISABLE KEYS */;
INSERT INTO `supplier` VALUES ('eb74a32c4a62996b272e0dbfde1f8fe4','S0001','Supplier 1','Alamat Supplier 1','9090909',NULL,NULL,NULL,NULL);
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
INSERT INTO `users` VALUES (1,'127.0.0.1','administrator','$2y$08$G0h47xFzvBDD3DjwWD13XeCfwGuZgqtSodh5ARhDJLLWPRv0jSgfG','','admin@admin.com','','',0,'',1268889823,1539323910,1,'Administrator','','ADMIN','0'),(2,'172.17.0.1','coba@coba.com','$2y$08$uGrWVA6PAMqe.5nbGjBpvufetRdq24dM/3rRE5XbJVxyaLYXE3LYa','','coba@coba.com','','',0,'',1503046181,1503047865,1,'coba','coba','','');
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

--
-- Dumping events for database 'abyan_jaya'
--

--
-- Dumping routines for database 'abyan_jaya'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-10-12 16:57:04
