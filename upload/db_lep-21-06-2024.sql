/*
SQLyog Community v13.1.7 (64 bit)
MySQL - 5.1.42-community : Database - db_lep
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_lep` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `db_lep`;

/*Table structure for table `mst_agama` */

DROP TABLE IF EXISTS `mst_agama`;

CREATE TABLE `mst_agama` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `mst_agama` */

insert  into `mst_agama`(`id`,`nama`) values 
(1,'Islam'),
(2,'Kristen'),
(3,'Budha'),
(4,'Hindu'),
(5,'Konghuchu');

/*Table structure for table `mst_biaya` */

DROP TABLE IF EXISTS `mst_biaya`;

CREATE TABLE `mst_biaya` (
  `kd_biaya` int(11) NOT NULL AUTO_INCREMENT,
  `kd_jenma` int(11) NOT NULL,
  `kd_ta` int(11) NOT NULL,
  `nilai` decimal(17,2) DEFAULT NULL,
  PRIMARY KEY (`kd_biaya`,`kd_jenma`,`kd_ta`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `mst_biaya` */

insert  into `mst_biaya`(`kd_biaya`,`kd_jenma`,`kd_ta`,`nilai`) values 
(1,1,1,7500000.00),
(2,1,1,500000.00),
(3,2,1,8500000.00),
(4,1,16,6000000.00);

/*Table structure for table `mst_daftar` */

DROP TABLE IF EXISTS `mst_daftar`;

CREATE TABLE `mst_daftar` (
  `kd_daftar` int(11) NOT NULL,
  `keterangan` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`kd_daftar`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `mst_daftar` */

insert  into `mst_daftar`(`kd_daftar`,`keterangan`) values 
(0,'Pindahan'),
(1,'Peserta didik baru');

/*Table structure for table `mst_dosen` */

DROP TABLE IF EXISTS `mst_dosen`;

CREATE TABLE `mst_dosen` (
  `nip` varchar(12) NOT NULL,
  `nidn` varchar(12) DEFAULT NULL,
  `nama` varchar(75) DEFAULT NULL,
  `gelar_depan` char(10) DEFAULT NULL,
  `gelar_blk` char(10) DEFAULT NULL,
  `tgl_masuk` date DEFAULT NULL,
  `tmt_jabatan` date DEFAULT NULL,
  `alamat` varchar(60) DEFAULT NULL,
  `kota` int(11) DEFAULT NULL,
  `jabatan` char(1) DEFAULT NULL,
  `agama` char(8) DEFAULT NULL,
  `status` char(1) DEFAULT NULL COMMENT 'T=Tetap; P=PKWT ; H = Honorer',
  `aktif` int(1) DEFAULT '1',
  PRIMARY KEY (`nip`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `mst_dosen` */

insert  into `mst_dosen`(`nip`,`nidn`,`nama`,`gelar_depan`,`gelar_blk`,`tgl_masuk`,`tmt_jabatan`,`alamat`,`kota`,`jabatan`,`agama`,`status`,`aktif`) values 
('240605001','12345','Arya tama','ir.','S.Kom','2024-02-27','2024-12-28','',2,'1','3','T',1),
('456456','9090','Tio oOOO','Ir.','A.Md','2024-06-03','2024-06-11','TR',2,'6','5','P',1);

/*Table structure for table `mst_gel_daftar` */

DROP TABLE IF EXISTS `mst_gel_daftar`;

CREATE TABLE `mst_gel_daftar` (
  `kode` int(11) NOT NULL AUTO_INCREMENT,
  `kd_ta` int(11) DEFAULT NULL,
  `gel` int(1) DEFAULT NULL,
  `tgl_awal` datetime DEFAULT NULL,
  `tgl_akhir` datetime DEFAULT NULL,
  PRIMARY KEY (`kode`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `mst_gel_daftar` */

insert  into `mst_gel_daftar`(`kode`,`kd_ta`,`gel`,`tgl_awal`,`tgl_akhir`) values 
(1,14,1,'2023-04-01 00:00:00','2023-06-12 00:00:00'),
(2,16,1,'2025-01-14 00:00:00','2024-07-25 00:00:00'),
(3,15,2,'2024-02-26 00:00:00','2024-04-15 00:00:00'),
(4,15,3,'2024-05-01 00:00:00','2024-06-03 00:00:00'),
(5,16,1,'2024-06-04 00:00:00','2024-08-05 00:00:00');

/*Table structure for table `mst_jabatan` */

DROP TABLE IF EXISTS `mst_jabatan`;

CREATE TABLE `mst_jabatan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `mst_jabatan` */

insert  into `mst_jabatan`(`id`,`nama`) values 
(1,'Dekan'),
(2,'Direktur'),
(3,'Pudir I'),
(4,'Pudir II'),
(5,'Pudir III'),
(6,'Ketua Jurusan'),
(7,'Kepala Program Studi'),
(8,'Sekretaris Jurusan');

/*Table structure for table `mst_jenis_biaya` */

DROP TABLE IF EXISTS `mst_jenis_biaya`;

CREATE TABLE `mst_jenis_biaya` (
  `kd_jenis` int(11) NOT NULL AUTO_INCREMENT,
  `nama_biaya` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`kd_jenis`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `mst_jenis_biaya` */

insert  into `mst_jenis_biaya`(`kd_jenis`,`nama_biaya`) values 
(1,'Uang Pangkal'),
(2,'Uang Bangunan'),
(3,'Uang Almamater'),
(4,'Uang Opspek'),
(5,'Uang Wisuda'),
(6,'Uang SPP');

/*Table structure for table `mst_jenma` */

DROP TABLE IF EXISTS `mst_jenma`;

CREATE TABLE `mst_jenma` (
  `kd_jenma` int(11) NOT NULL,
  `jenis_mhs` char(15) DEFAULT NULL,
  PRIMARY KEY (`kd_jenma`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `mst_jenma` */

insert  into `mst_jenma`(`kd_jenma`,`jenis_mhs`) values 
(1,'Reguler'),
(2,'Karyawan');

/*Table structure for table `mst_kota` */

DROP TABLE IF EXISTS `mst_kota`;

CREATE TABLE `mst_kota` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kd_kota` varchar(3) DEFAULT NULL,
  `nm_kota` varchar(50) DEFAULT NULL,
  `kd_propinsi` varchar(10) DEFAULT NULL,
  `aktif` tinyint(1) DEFAULT NULL,
  `kd_regional` varchar(3) DEFAULT NULL,
  `pic_input` varchar(10) DEFAULT NULL,
  `pic_edit` varchar(10) DEFAULT NULL,
  `tgl_input` datetime DEFAULT NULL,
  `tgl_edit` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kd_kota` (`kd_kota`),
  UNIQUE KEY `nm_kota` (`nm_kota`)
) ENGINE=InnoDB AUTO_INCREMENT=161 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

/*Data for the table `mst_kota` */

insert  into `mst_kota`(`id`,`kd_kota`,`nm_kota`,`kd_propinsi`,`aktif`,`kd_regional`,`pic_input`,`pic_edit`,`tgl_input`,`tgl_edit`) values 
(1,'ABU','ATAMBUA','NTT',1,'200',NULL,NULL,NULL,NULL),
(2,'AMQ','AMBON','MALUKU',1,'300',NULL,NULL,NULL,NULL),
(3,'BDJ','BANJARMASIN','KALSEL',1,'300',NULL,'DBA2',NULL,'2008-12-01 11:14:44'),
(4,'BDO','BANDUNG','JABAR',1,'100',NULL,NULL,NULL,NULL),
(5,'BGL','BANGIL','JATIM',1,'100',NULL,'DBA2',NULL,'2008-12-01 10:45:27'),
(6,'BIJ','BINJAI','SUMUT',1,'100',NULL,NULL,NULL,NULL),
(7,'BJO','BOJONEGORO','JATIM',1,'100',NULL,'DBA2',NULL,'2008-12-01 10:45:38'),
(8,'BKL','BENGKALIS','RIAU',1,'100',NULL,'DBA2',NULL,'2008-12-01 17:21:36'),
(9,'BKS','BENGKULU','BKU',1,'100',NULL,NULL,NULL,NULL),
(10,'BLI','BLITAR','JATIM',1,'100',NULL,'DBA2',NULL,'2008-12-01 10:45:54'),
(11,'BMS','BANYUMAS','JATENG',1,'100',NULL,'DBA2',NULL,'2008-12-01 10:46:05'),
(12,'BMU','BIMA','NTB',1,'300',NULL,NULL,NULL,NULL),
(13,'BON','BONTANG','KEPRI',1,'300',NULL,'DBA2',NULL,'2008-12-02 16:26:52'),
(14,'BPN','BALIKPAPAN','KALTIM',1,'300',NULL,'DBA2',NULL,'2008-12-01 11:14:55'),
(15,'BRG','BOGOR','JABAR',1,'100',NULL,'DBA2',NULL,'2008-12-02 09:41:36'),
(16,'BRI','BRASTAGI','SUMUT',0,'100','DBA1','DBA1','2008-10-17 13:45:31','2008-10-17 13:47:35'),
(17,'BRS','BREBES','JATENG',1,'100',NULL,'DBA2',NULL,'2008-12-01 10:46:19'),
(18,'BSI','BEKASI','JABAR',1,'100',NULL,'DBA2',NULL,'2008-12-02 09:41:48'),
(19,'BTH','BATAM','KEPRI',1,'100',NULL,'DBA2',NULL,'2008-12-02 16:26:06'),
(20,'BTI','BUKIT TINGGI','SUMBAR',1,'100',NULL,NULL,NULL,NULL),
(21,'BTJ','BANDA ACEH','NAD',1,'200',NULL,'DBA2',NULL,'2008-12-01 11:20:13'),
(23,'BYL','BOYOLALI','JATENG',1,'100',NULL,'DBA2',NULL,'2008-12-02 15:20:31'),
(24,'BYW','BANYUWANGI','JATIM',1,'100',NULL,'DBA2',NULL,'2008-12-01 10:47:00'),
(25,'CBB','CIBUBUR','JABAR',1,'100',NULL,'DBA2',NULL,'2008-12-01 10:47:09'),
(26,'CBN','CIREBON','JABAR',1,'100',NULL,NULL,NULL,NULL),
(27,'CBO','CIBINONG','JABAR',1,'100',NULL,'DBA2',NULL,'2008-12-01 10:47:17'),
(28,'CHN','CHINA','CHN',0,'400','DBA1',NULL,'2008-10-30 08:35:23',NULL),
(29,'CIK','CIKAMPEK','JABAR',1,'100',NULL,'DBA2',NULL,'2008-12-01 10:47:27'),
(30,'CKR','CIKARANG','JABAR',1,'100',NULL,'DBA2',NULL,'2008-12-01 10:47:36'),
(31,'CLC','CILACAP','JATENG',1,'100',NULL,'DBA2',NULL,'2008-12-01 10:47:43'),
(32,'CLG','CILEGON','BTN',1,'100',NULL,'DBA2',NULL,'2008-12-02 16:27:49'),
(33,'CMG','CIMANGGIS','JABAR',1,'100',NULL,'DBA2',NULL,'2008-12-01 10:47:59'),
(34,'CMI','CIMAHI','JABAR',1,'100',NULL,NULL,NULL,NULL),
(35,'CRJ','CIANJUR','JABAR',1,'100',NULL,NULL,NULL,NULL),
(36,'DJJ','JAYAPURA','PAPUATM',1,'200',NULL,'DBA2',NULL,'2008-12-02 09:14:20'),
(37,'DPO','DEPOK','JABAR',1,'100',NULL,'DBA2',NULL,'2008-12-02 09:41:56'),
(38,'DPS','DENPASAR','BALI',1,'200',NULL,NULL,NULL,NULL),
(39,'DUM','DUMAI','RIAU',1,'100',NULL,NULL,NULL,NULL),
(40,'DUR','DURI','RIAU',1,'100',NULL,'DBA2',NULL,'2008-12-01 11:15:24'),
(41,'GMB','GOMBONG','JATENG',1,'100',NULL,'DBA2',NULL,'2008-12-01 10:48:17'),
(42,'GRU','GARUT','JABAR',1,'100',NULL,'DBA2',NULL,'2008-12-02 16:28:33'),
(43,'GTL','GORONTALO','GORON',1,'041',NULL,'DBA2',NULL,'2008-12-02 09:06:47'),
(44,'HKG','HONGKONG','HKG',0,'400','DBA1',NULL,'2008-10-30 08:34:22',NULL),
(45,'IDY','INDRAMAYU','JABAR',1,'100',NULL,NULL,NULL,NULL),
(46,'JBI','JAMBI','JAMBI',1,'100',NULL,'DBA2',NULL,'2008-12-01 11:19:40'),
(47,'JKB','JAKARTA BARAT','DKI',1,'100',NULL,'DBA2',NULL,'2008-12-02 08:59:11'),
(48,'JKP','JAKARTA PUSAT','DKI',1,'100',NULL,'DBA2',NULL,'2008-12-02 08:59:22'),
(49,'JKS','JAKARTA SELATAN','DKI',1,'100',NULL,'DBA2',NULL,'2008-12-02 08:59:25'),
(50,'JKT','JAKARTA TIMUR','DKI',1,'100',NULL,'DBA2',NULL,'2008-12-02 08:59:29'),
(51,'JKU','JAKARTA UTARA','DKI',1,'100',NULL,'DBA2',NULL,'2008-12-02 08:59:34'),
(52,'JMB','JEMBER','JATIM',1,'100',NULL,'DBA2',NULL,'2008-12-01 10:48:53'),
(53,'JOG','YOGYAKARTA','DYI',1,'100',NULL,'DBA2',NULL,'2008-12-02 09:01:49'),
(54,'JOM','JOMBANG','JATIM',1,'100',NULL,'DBA2',NULL,'2008-12-01 10:48:58'),
(55,'KBM','KEBUMEN','JATENG',1,'100',NULL,'DBA2',NULL,'2008-12-01 10:49:04'),
(56,'KDI','KENDARI','SULTEG',1,'200',NULL,'DBA2',NULL,'2008-12-02 09:09:33'),
(57,'KIS','KISARAN','SUMUT',1,'100',NULL,'DBA2',NULL,'2008-12-01 11:19:49'),
(58,'KLT','KLATEN','JATENG',1,'100',NULL,'DBA2',NULL,'2008-12-01 10:49:11'),
(59,'KOL','KOLAKA','SULTEG',1,'200',NULL,'DBA2',NULL,'2008-12-02 15:50:43'),
(60,'KPT','KUPANG','NTT',1,'300',NULL,'DBA2',NULL,'2008-12-02 09:03:27'),
(61,'KRI','KEDIRI','JATIM',1,'100',NULL,NULL,NULL,NULL),
(62,'KRW','KARAWANG','JABAR',1,'100',NULL,'DBA2',NULL,'2008-12-01 10:49:15'),
(63,'KUD','KUDUS','JATENG',1,'100',NULL,'DBA2',NULL,'2008-12-02 15:21:10'),
(64,'KUN','KUNINGAN','JABAR',1,'100',NULL,'DBA2',NULL,'2008-12-01 10:49:22'),
(65,'LBA','LUBUK ALUNG','SUMBAR',0,'100','DBA1',NULL,'2008-10-17 13:42:37',NULL),
(66,'LBL','LUBUK LINGGAU','SUMSEL',1,'100',NULL,'DBA2',NULL,'2008-12-01 11:14:06'),
(67,'LHT','LAHAT','NAD',1,'200',NULL,'DBA2',NULL,'2008-12-01 11:20:05'),
(68,'LLL','LAINNYA','LLL',1,'LLL',NULL,NULL,NULL,NULL),
(69,'LMB','LOMBOK','NTB',1,'200',NULL,'DBA2',NULL,'2008-12-02 15:27:41'),
(70,'LMG','LAMONGAN','JATIM',1,'100',NULL,'DBA2',NULL,'2008-12-01 10:49:34'),
(71,'LMJ','LUMAJANG','JATIM',1,'100',NULL,'DBA2',NULL,'2008-12-01 10:49:40'),
(72,'LSP','LUBUK SIKAPING','SUMBAR',1,'100',NULL,'DBA2',NULL,'2008-12-01 11:20:27'),
(73,'LSW','LHOKSUMAWE','NAD',1,'100',NULL,NULL,NULL,NULL),
(74,'MDU','MADIUN','JATIM',1,'100',NULL,'DBA2',NULL,'2008-12-01 10:49:49'),
(75,'MES','MEDAN','SUMUT',1,'100',NULL,NULL,NULL,NULL),
(76,'MGL','MAGELANG','JATENG',1,'100',NULL,NULL,NULL,NULL),
(77,'MKE','MERAUKE','PAPUATM',1,'300',NULL,'DBA2',NULL,'2008-12-02 09:26:31'),
(78,'MLG','MALANG','JATIM',1,'100',NULL,NULL,NULL,NULL),
(79,'MNO','MANADO','SULUT',1,'200',NULL,NULL,NULL,NULL),
(80,'MTR','MATARAM','NTB',0,'100','DBA2',NULL,'2008-12-02 09:02:57',NULL),
(81,'MUE','MUARA ENIM','SUMSEL',1,'200',NULL,'DBA2',NULL,'2008-12-02 16:04:19'),
(82,'MUN','MUNTILAN','JATENG',1,'100',NULL,'DBA2',NULL,'2008-12-01 10:43:01'),
(83,'NGJ','NGANJUK','JATIM',1,'100',NULL,'DBA2',NULL,'2008-12-01 10:43:19'),
(84,'PBG','PURBALINGGA','JATENG',1,'100',NULL,'DBA2',NULL,'2008-12-01 10:52:59'),
(85,'PBY','PULAU BRAYAN','SUMUT',1,'100',NULL,'DBA2',NULL,'2008-12-01 11:20:35'),
(86,'PDE','PANDEGLANG','BTN',1,'100',NULL,'DBA2',NULL,'2008-12-02 15:19:58'),
(87,'PDG','PADANG','SUMBAR',1,'100',NULL,NULL,NULL,NULL),
(88,'PDL','PADALARANG','JABAR',1,'100',NULL,NULL,NULL,NULL),
(89,'PES','PEMATANG SIANTAR','SUMUT',1,'100',NULL,'DBA2',NULL,'2008-12-01 11:20:40'),
(90,'PHL','PHILIPINA','PHL',0,'400','DBA1',NULL,'2008-10-30 08:38:08',NULL),
(91,'PKG','PANGKAL PINANG','BKBL',1,'100',NULL,'DBA2',NULL,'2008-12-01 17:36:38'),
(92,'PKL','PEKALONGAN','JATENG',1,'100',NULL,NULL,NULL,NULL),
(93,'PKU','PEKAN BARU','RIAU',1,'100',NULL,'DBA2',NULL,'2008-12-01 17:34:11'),
(94,'PKY','PALANGKARAYA','KALTENG',1,'300',NULL,'DBA2',NULL,'2008-12-01 11:15:44'),
(95,'PLG','PEMALANG','JATENG',1,'100',NULL,'DBA2',NULL,'2008-12-01 10:44:58'),
(96,'PLM','PALEMBANG','SUMSEL',1,'100',NULL,NULL,NULL,NULL),
(97,'PLW','PALU','SULTENG',1,'200',NULL,'DBA2',NULL,'2008-12-02 09:07:04'),
(98,'PNK','PONTIANAK','KALBAR',1,'300',NULL,'DBA2',NULL,'2008-12-01 11:15:50'),
(99,'PNO','PONOROGO','JATIM',1,'100',NULL,'DBA2',NULL,'2008-12-01 10:44:49'),
(100,'PPR','PADANG PARIAMAN','SUMBAR',1,'100',NULL,'DBA2',NULL,'2008-12-01 11:20:49'),
(101,'PRE','PARE PARE','SULSEL',1,'200',NULL,'DBA2',NULL,'2008-12-01 11:03:32'),
(102,'PRH','PRABUMULIH','SUMSEL',0,'100','DBA1',NULL,'2008-10-17 13:21:57',NULL),
(103,'PRO','PROBOLINGGO','JATIM',1,'100',NULL,'DBA2',NULL,'2008-12-01 10:44:43'),
(104,'PSP','PADANG SIDEMPUAN','SUMUT',1,'100',NULL,'DBA2',NULL,'2008-12-02 15:57:59'),
(105,'PTI','PATI','JATENG',1,'100',NULL,'DBA2',NULL,'2008-12-01 10:44:04'),
(106,'PWD','PURWODADI','JATENG',1,'100',NULL,'DBA2',NULL,'2008-12-01 10:53:18'),
(107,'PWJ','PURWOREJO','JATENG',1,'100',NULL,'DBA2',NULL,'2008-12-01 10:44:21'),
(108,'PWK','PURWAKARTA','JABAR',1,'100',NULL,NULL,NULL,NULL),
(109,'PWL','PURWOKERTO','JATENG',1,'100',NULL,NULL,NULL,NULL),
(110,'PYK','PAYAKUMBUH','SUMBAR',1,'100',NULL,'DBA2',NULL,'2008-12-01 11:21:09'),
(111,'RPR','RANTAU PRAPAT','SUMUT',0,'100','ACC1',NULL,'2009-06-09 11:18:18',NULL),
(112,'RSB','RANGKAS BITUNG','JABAR',1,'100',NULL,'DBA2',NULL,'2008-12-01 10:50:03'),
(113,'SBA','SIBOLGA','SUMUT',1,'100',NULL,'DBA2',NULL,'2008-12-01 11:21:13'),
(114,'SBG','SUBANG','JABAR',1,'100',NULL,'DBA2',NULL,'2008-12-01 10:50:10'),
(115,'SDO','SITUBONDO','JATIM',1,'100',NULL,'DBA2',NULL,'2008-12-01 10:50:15'),
(116,'SER','SERANG','BTN',1,'100',NULL,'DBA2',NULL,'2008-12-02 09:00:19'),
(117,'SID','SIDOARJO','JATIM',1,'100',NULL,'DBA2',NULL,'2008-12-01 10:50:23'),
(118,'SIN','SINGAPURA','SIN',1,'100',NULL,NULL,NULL,NULL),
(119,'SIW','SINGKAWANG','KALBAR',1,'300',NULL,'DBA2',NULL,'2008-12-01 11:16:01'),
(120,'SLA','SALATIGA','JATENG',1,'100',NULL,'DBA2',NULL,'2008-12-01 10:50:29'),
(121,'SMI','SUKABUMI','JABAR',1,'100',NULL,NULL,NULL,NULL),
(122,'SOC','SOLO','JATENG',1,'100',NULL,NULL,NULL,NULL),
(123,'SOG','SORONG','PAPUABR',0,'300','DBA1','DBA2','2008-10-17 13:19:30','2008-12-02 09:12:32'),
(124,'SOL','SOLOK','SUMBAR',1,'100',NULL,'DBA2',NULL,'2008-12-02 15:16:38'),
(125,'SPH','SUNGAI PINYUH','KALBAR',0,'300','ACC1',NULL,'2009-03-16 14:41:39',NULL),
(126,'SPO','SERPONG','JABAR',1,'100',NULL,'DBA2',NULL,'2008-12-02 09:43:52'),
(127,'SRA','SRAGEN','JATENG',1,'100',NULL,'DBA2',NULL,'2008-12-01 10:50:43'),
(128,'SRG','SEMARANG','JATENG',1,'100',NULL,NULL,NULL,NULL),
(129,'SRI','SAMARINDA','KALTIM',1,'300',NULL,'DBA2',NULL,'2008-12-01 11:16:07'),
(130,'SUB','SURABAYA','JATIM',1,'100',NULL,NULL,NULL,NULL),
(131,'TAB','TANJUNG BALAI','SUMUT',1,'100',NULL,'DBA2',NULL,'2008-12-02 15:58:23'),
(132,'TAM','TANJUNG ENIM','SUMSEL',1,'200',NULL,'DBA2',NULL,'2008-12-01 11:08:37'),
(133,'TBL','TEMBILAHAN','RIAU',1,'100',NULL,'DBA2',NULL,'2008-12-02 16:40:08'),
(134,'TBT','TEBING TINGGI','SUMUT',1,'100',NULL,'DBA2',NULL,'2008-12-01 11:21:34'),
(135,'TGG','TENGGARONG','KALTIM',1,'300',NULL,'DBA2',NULL,'2008-12-01 11:16:19'),
(136,'TGK','TANJUNG KARANG','LAMPUNG',1,'100',NULL,'DBA2',NULL,'2008-12-01 11:21:54'),
(137,'TGL','TEGAL','JATENG',1,'100',NULL,NULL,NULL,NULL),
(138,'TGR','TANGERANG','BTN',1,'100',NULL,'DBA2',NULL,'2008-12-02 15:19:39'),
(139,'TJP','TANJUNG PINANG','KEPRI',1,'100',NULL,'DBA2',NULL,'2008-12-01 17:34:25'),
(140,'TKG','LAMPUNG','LAMPUNG',1,'100',NULL,'DBA2',NULL,'2008-12-02 08:58:36'),
(141,'TLA','TULUNG AGUNG','JATIM',0,'100','DBA2',NULL,'2010-11-01 11:52:49',NULL),
(142,'TLB','TELUK BETUNG','LAMPUNG',1,'100',NULL,'DBA2',NULL,'2008-12-02 16:39:54'),
(143,'TMM','TIMIKA','PAPUATG',1,'300',NULL,'DBA2',NULL,'2008-12-02 09:13:33'),
(144,'TNE','TERNATE','MALU UT',1,'300',NULL,'DBA2',NULL,'2008-12-02 09:11:35'),
(146,'TRT','TARUTUNG','SUMUT',1,'100',NULL,'DBA2',NULL,'2008-12-01 11:16:31'),
(147,'TSY','TASIKMALAYA','JABAR',1,'100',NULL,NULL,NULL,NULL),
(148,'UGR','UNGARAN','JATENG',1,'100',NULL,'DBA2',NULL,'2008-12-01 10:50:55'),
(149,'UPG','MAKASSAR','SULSEL',1,'200',NULL,'DBA2',NULL,'2008-12-02 09:09:53'),
(150,'WNB','WONOSOBO','JATENG',1,'100',NULL,'DBA2',NULL,'2008-12-01 10:51:03'),
(151,'WON','WONOGIRI','JATENG',0,'100','DBA2',NULL,'2008-12-02 15:22:34',NULL),
(152,'MDR','MADURA','JATIM',1,'100',NULL,NULL,NULL,NULL),
(153,'SGT','SANGATA','KALTIM',1,NULL,NULL,NULL,NULL,NULL),
(154,'TAR','TARAKAN','KALTIM',1,NULL,NULL,NULL,NULL,NULL),
(155,'MLN','MALINAU','KALTIM',1,NULL,NULL,NULL,NULL,NULL),
(156,'BRU','BERAU','KALTIM',1,NULL,NULL,NULL,NULL,NULL),
(157,'MLK','MELAK','KALTIM',1,NULL,NULL,NULL,NULL,NULL),
(158,'SUR','SURAKARTA','JATENG',1,'100','DBA1',NULL,'2014-07-18 10:04:00',NULL),
(159,'PAS','PASURUAN','JATIM',1,'100','DBA1',NULL,'2014-07-18 10:04:37',NULL),
(160,'KUT','KUTA','BALI',1,NULL,NULL,NULL,NULL,NULL);

/*Table structure for table `mst_matkul` */

DROP TABLE IF EXISTS `mst_matkul`;

CREATE TABLE `mst_matkul` (
  `kd_prog` int(11) NOT NULL,
  `kode_matkul` char(6) NOT NULL,
  `nama_matkul` varchar(50) DEFAULT NULL,
  `sks` int(11) DEFAULT NULL,
  `smt` int(11) DEFAULT NULL,
  `aktif` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`kd_prog`,`kode_matkul`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `mst_matkul` */

insert  into `mst_matkul`(`kd_prog`,`kode_matkul`,`nama_matkul`,`sks`,`smt`,`aktif`) values 
(1,'OF2706','PENGLIHATAN BINOKULER ORTOPTIK',2,2,1),
(1,'OF4104','CLINICAL PROCEDURES',2,2,1),
(1,'OP104','Etika Profesi',2,3,1),
(1,'OP203','Pencegahan Kebutaan',2,4,1),
(1,'OP307','Farmakologi Umum dan Mata',2,3,1),
(1,'OP407','Penglihatan Binokuler',2,3,1),
(1,'OP408','Ergonomi Penglihatan',2,4,1),
(1,'OP409','Pediatrik Optometri',2,3,1),
(1,'OP410','Geriatrik Optometri',2,4,1),
(1,'OP412','Karya Tulis Ilmiah (KTI)',3,3,1),
(1,'OP413','Manajemen Optik',2,3,1),
(1,'OP414','Klinik Dasar',6,4,1),
(1,'OP501','ISBD',3,4,1),
(1,'OP505','PKL (Community Outreach)',3,4,1),
(1,'OP507','Clinic Conference',1,4,1),
(1,'RO101','AGAMA',3,1,1),
(1,'RO102','PENDIDIKAN KEWARGANEGARAAN',3,1,1),
(1,'RO103','BAHASA INDONESIA',3,1,1),
(1,'RO202','PENCEGAHAN KEBUTAAN',2,2,1),
(1,'RO203','FISIOLOGI PENGLIHATAN DAN PERSEPSI',2,1,1),
(1,'RO204','PATOLOGI UMUM',2,1,1),
(1,'RO301','INSTRUMENT REFRAKSI',2,1,1),
(1,'RO303','ANATOMI DAN FISIOLOGI UMUM',2,1,1),
(1,'RO304','FISIKA UMUM',2,1,1),
(1,'RO401','INSTRUMENTASI LABORATORIUM OPTIK',3,2,1),
(1,'RO402','KLINIK REFRAKSI II',3,2,1),
(1,'RO403','KLINIK OPTIK SURFACING II',2,2,1),
(1,'RO404','KLINIK OPTIK DISPENSING II',2,2,1),
(1,'RO405','LENSA KONTAK II',2,3,1),
(1,'RO406','LOW VISION',3,3,1),
(1,'TA001','Tugas Akhir',3,4,1),
(1,'TL101','ENGLISH',2,2,1),
(1,'XXXXX','Opto Medik Lanjut',2,4,1);

/*Table structure for table `mst_mhs` */

DROP TABLE IF EXISTS `mst_mhs`;

CREATE TABLE `mst_mhs` (
  `nim` char(10) NOT NULL,
  `nik` text,
  `nama_mhs` varchar(100) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `tempat_lahir` varchar(200) DEFAULT NULL,
  `jk` char(1) DEFAULT NULL,
  `agama` char(8) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT 'mahasiswa aktif',
  `tgl_masuk` date DEFAULT NULL,
  `kd_prog` char(2) DEFAULT NULL COMMENT 'program studi',
  `kd_ta` int(11) DEFAULT NULL,
  `kd_daftar` char(1) DEFAULT NULL COMMENT 'baru - pindahan',
  `kd_biaya` int(11) DEFAULT NULL,
  PRIMARY KEY (`nim`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `mst_mhs` */

insert  into `mst_mhs`(`nim`,`nik`,`nama_mhs`,`tgl_lahir`,`tempat_lahir`,`jk`,`agama`,`alamat`,`status`,`tgl_masuk`,`kd_prog`,`kd_ta`,`kd_daftar`,`kd_biaya`) values 
('20001','3172010305961000','ADIMAS SATRIO PRASIDA','1996-05-03','JAKARTA','L','Budha','Jl. Pakubuwono Vi no. 68, Kebayoran Baru, Jakarta Selatan',1,'2020-04-07','1',1,'1',0),
('20002','7410016405030000','VELIZ MEIF LISTA','2003-05-24','LIPU','P','Islam','Keraton',1,'2020-04-24','1',7,'1',4),
('20003','3324084504020000','IZZA TAZKIA FATMA','2002-04-05','KENDAL','P','Islam','Gang Istiqomah',1,'2020-04-30','1',7,'1',0),
('20004','6311064507020000','Nabila Kamaliya','2002-07-05','Banjarmasin','P','Islam','Jalan anggrek',1,'2020-05-01','1',7,'1',0),
('20005','3172010305961000','MUHAMMAD IRFAN NUR IHSAN','2002-04-07','BANJARMASIN','L','Islam','JL. RTA. MILONO KM 3 PERUM. BOROBUDUR 2 NO 11B',1,'2020-05-01','1',7,'1',0),
('20006','3201376812020000','Desti Arum Fitriah','2002-12-28','Bantul','P','Islam','Perum. Puri Shantika',1,'2020-05-02','1',7,'1',0),
('20007','1810016105020000','Thania vira rivanda','2002-05-21','Pringsewu','P','Islam','Jl. Gotong royong pringsewu',1,'2020-05-04','1',7,'1',0),
('20008','3275010107020140','Muhammad Syalman Yanwar Wijaya','2002-07-01','bekasi','L','Islam','IR H.JUANDA NO 335',1,'2020-05-06','1',7,'1',0),
('20009','3602142406010000','Rizky Dwi Pradipta','2001-06-24','LEBAK','L','Islam','Jln.Kuncoro Jakti',1,'2020-05-13','1',7,'1',0),
('20010','6401045906020000','Kurnia Ari Sulistiawati','2002-06-19','Tanah Grogot','P','Islam','Jl.Rantau Panjang',1,'2020-05-16','1',7,'1',0),
('20011','7173035409030000','Yngwie Thezalonika Nirvana Gibrani Polii','2002-09-14','Tomohon','P','Kristen','Polii 1',1,'2020-05-18','1',7,'1',0),
('20012','1307116403020000','Shafira Sofyani','2002-03-24','Payakumbuh','P','Islam','Jalan raya mungka',1,'2020-05-19','1',7,'1',0),
('20013','3804300109010000','Ida Faridatul Jannah','2001-09-11','Serang','P','Islam','Kp Pakis Indah',1,'2020-05-21','1',7,'1',0),
('20014','3501086509020000','Dila Putri Puspita Rini','2002-09-25','Pacitan','P','Islam','-',1,'2020-05-21','1',7,'1',0),
('20015','3275066205020000','Indah Ayu Regita Prameswari','2002-05-22','Bekasi','P','Islam','Jembatan bola',1,'2020-05-30','1',7,'1',0),
('20016','3603285809020000','Stephani Devina Lau','2002-09-18','Tangerang','P','Kristen','Kramat wates',1,'2020-05-30','1',7,'1',0),
('20017','3175102304020000','Dio Hilal Prakoso','2002-04-23','Jakarta','L','Islam','Hj Moechtar',1,'2020-05-31','1',7,'1',0),
('20018','3602010706010000','NANDA HARIS ANGGRIAWAN','2001-06-07','Pacitan','L','Islam','Jl.gn.kencana-malingping',1,'2020-09-07','1',7,'1',7500000),
('20019','3276021605020000','ARFINU ALIF','2002-05-16','Tegal','L','Islam','Kebayunan',1,'2020-09-07','1',7,'1',7500000),
('20020','3174090707790000','HENDRA PRAWIRA NEGARA','1979-07-07','JAKARTA','L','Islam','Jl.Raya Lenteng Agung, Kp.Srengseng No.26',1,'2020-09-07','1',7,'1',7500000),
('20021','3604334409010000','Fitri Nurasih','2001-09-04','Serang','P','Islam','Kp.cilebak',1,'2020-06-08','1',7,'1',0),
('20022','3276020904020000','Bilal Firmansyah','2002-04-09','Purworejo','L','Islam','Gasalam',1,'2020-06-11','1',7,'1',0),
('20023','6171012803020000','Mahendra Boydo Nathanael Silitonga','2002-03-28','Pontianak','L','Kristen','KP. Soedarso No 14',1,'2020-06-12','1',7,'1',0),
('20024','1802010404990000','Wahyu','1999-04-04','kalirejo','L','Islam','Jalan Majapahit',1,'2020-06-14','1',7,'1',0),
('20025','3173072205000000','Ananda Prasetyo Wibowo','2000-05-22','Jakarta','L','Islam','Kemanggisan Pulo RT13/RW03 No32',1,'2020-06-16','1',7,'1',0),
('20026','3174034910010000','Desdiana Dwi Narsih','2001-10-09','Jakarta','P','Islam','Bangka Raya No. 80',1,'2020-08-28','1',7,'1',0),
('20027','1708045110000000','Nadila Rahmawati','2000-10-11','KEPAHIANG','P','Islam','Jln Lintas Pagar Alam',1,'2020-08-29','1',7,'1',0),
('20028','5105034102020000','NI LUH AYU DWI PRABASUARI','2002-02-01','Klungkung','P','Hindu','-',1,'2020-09-07','1',7,'1',7500000),
('20029','3603220511010000','IBNU FAUZUL MUTAQIEN','2001-11-05','Tangerang','L','Islam','-',1,'2020-09-07','1',7,'1',7500000),
('20030','3201022511010000','Ari Fajri Ramadhan','2001-11-25','Jakarta','L','Islam','jalan dewa ciangsana kab.bogor',1,'2020-06-30','1',7,'1',0),
('20031','3501022610000000','MUHAMMAD IBNU AMIN CHOLIF','2000-10-26','Pacitan','L','Islam','jln.Dadapan - watukarung',1,'2020-09-07','1',7,'1',7500000),
('20032','3327116503020000','Eka Nurhidayati Husna','2002-03-25','Pemalang','P','Islam','Gulisari',1,'2020-07-13','1',7,'1',0),
('20033','3208101406010000','IKHSAN AKBAR ILHAMI','2001-06-14','KUNINGAN','L','Islam','Desa Geresik',1,'2020-07-13','1',7,'1',0),
('20034','3173084611010000','Amelia Dwi Novitasari','2001-11-06','Klaten','P','Islam','KOMP BPPT H-8/B-10',1,'2020-09-07','1',7,'1',0),
('20035','3326115302000000','Nur Fadilah','2000-02-13','Pekalongan','P','Islam','-',1,'2020-07-24','1',7,'1',0),
('20036','3674045206000000','Veronica Vivin Rosalinda','2000-06-12','Semarang','P','Katolik','Jl.mushola An Nur',1,'2020-07-31','1',7,'1',0),
('20037','1271075812990000','Karolina Kresensia Anatasya','1999-12-18','Medan Kota','P','Kristen','Jln.senam komplek makam pahlawan',1,'2020-09-08','1',7,'1',0),
('20038','3175075304021000','Citra Vidi Beatha','2002-04-13','Jakarta','P','Kristen','Cluster Tropical Garden Tg 6 No 90. Grand Galaxy City',1,'2020-08-11','1',7,'1',0),
('20039','3276041305940000','MUHAMMAD IQBAL FARIS','1994-05-13','JAKARTA','L','Islam','KRAMAT',1,'2020-08-12','1',7,'1',0),
('20040','3301056907020000','Fatma Ayu Azzahro','2002-07-29','Cilacap','P','Islam','Diponegoro',1,'2020-08-14','1',7,'1',0),
('20041','3501021210990000','RIDHO BAYU ENGGAR SADEWO','1999-10-12','RANGKAS BITUNG. LEBAK BANTEN','L','Islam','-',1,'2020-05-25','1',7,'1',0),
('20043','7371110408020000','Manarul Fiqri Al Hikmah','2001-08-04','Makassar','L','Islam','Jl. Perintis Kemerdekaan Km.14 No.195/81',1,'2020-08-16','1',7,'1',0),
('20044','3578080302940000','Aditya Harnanto PRatama','1994-02-03','Surabaya','L','Islam','Grand Residence City komplek Senopati Park',1,'2020-05-26','1',7,'1',0),
('20045','3206394908990000','Sopi Ismiyati','1999-08-09','Tasikmalaya','P','Islam','Kp. Ciomas',1,'2020-09-20','1',7,'1',0),
('20046','3202112707540000','TOTO FIRYANTO','1954-07-25','MATARAM','L','Kristen','KARANG TENGAH',1,'2020-06-16','1',7,'1',0),
('20047','3172057001990000','Annisaa','1999-09-30','Jakarta Utara','P','Islam','Jl lodan dalam 2b no 28',1,'2020-06-17','1',7,'1',0),
('20048','3203280702950000','Salman','1995-02-07','Cianjur','L','Islam','Jl.kemang',1,'2020-06-22','1',7,'1',0),
('20049','3271056006960010','Yuni Sulistiawati','1996-06-20','Bogor','P','Islam','Pemda Pangkalan 2',1,'2020-06-24','1',7,'1',0),
('20050','3173014107930010','Yoana Kosasi','2020-07-01','Kabanjahe','P','Budha','Jalan Cengkareng Indah Blok Id No 13',1,'2020-08-05','1',7,'1',0),
('20051','1208204403960000','Elmida Purba','1996-03-04','Pongkalan Tongah','P','Kristen','Gang melati 1 no 33f pondok labu, cilandak',1,'2020-08-05','1',7,'1',0),
('20052','3174102109930010','Rafid Rizkulloh','1993-09-21','Jakarta','L','Islam','Jl.Sd Inpres',1,'2020-07-06','1',7,'1',0),
('20053','3601344308020000','Sevty Trie Gustin Lestari','2002-08-03','Pandeglang','P','Islam','-',1,'2020-05-30','1',7,'1',0),
('20054','3509026510970000','Ayu Citra Dewi','1997-10-25','Lumajang','P','Islam','-',1,'2020-09-18','1',7,'1',0),
('20055','3603120205020000','RIKI BAGAS ADI PRATAMA','2002-05-02','PACITAN','L','Islam','JL.KENCANA BARAT 2 BLOK D-8/32 VILA TOMANG BARU II',1,'2020-06-13','1',7,'1',0),
('20056','1605156709020000','Febby Anggelia','2002-09-27','Karang Jaya','P','Islam','-',1,'2020-06-18','1',7,'1',0),
('20057','1701054812020000','Herta Redha Musiada','2002-12-08','Manna','P','Islam','Jendral Sudirman',1,'2020-07-12','1',7,'1',0),
('20058','3212080205020000','ILHAMU DZINURAIN MUHANDIS','2002-05-02','Indramayu','L','Islam','Bypass Kertasemaya',1,'2020-09-17','1',7,'1',0),
('20059','3571015401020000','Diasti Machnafia Laili','2002-01-14','Kediri','P','Islam','Perum Griya Intan Permai',1,'2020-07-29','1',7,'1',0),
('20061','3275024106020020','Yuniar Shalsabila','2002-06-01','Bekasi','P','Islam','Pesut 2',1,'2020-08-14','1',7,'1',0),
('20064','3175085201020000','Melda Rizki Cahyaningrum','2002-01-12','Jakarta','P','Islam','Kresno',1,'2020-08-26','1',7,'1',0),
('20065','3175042007970000','Zulfikar Ibnu Riad','1997-07-20','Jakarta','L','Islam','Jl.H. Taiman B',1,'2020-06-02','1',7,'1',0),
('20067','1107190510870000','Isbuan','1987-01-05','Krueng Seukeuk','L','Islam','Medan-banda Aceh',1,'2020-07-06','1',7,'1',0),
('20068','3275111312930000','ANDRYANSYAH SAPUTRA','1993-12-13','BEKASI','L','Islam','Jl.Raya Binong',1,'2020-07-09','1',7,'1',0),
('20069','3403052508800000','Agus Suryono','1980-08-25','Gunungkidul','L','Islam','-',1,'2020-07-20','1',7,'1',0),
('20071','1401191607910000','Prihadi Saputra','1991-07-16','Blitar','L','Islam','Gg Anggrek, 57c Jl.kayen. Condongcatur',1,'2020-08-10','1',7,'1',0),
('20072','3174102304920000','Umar Rizal','1992-04-23','Jakarta','L','Islam','Kayumanis VI',1,'2020-08-12','1',7,'1',0),
('20073','3671070105980000','Danar Dwi Cahyo','1998-05-01','Tangerang','L','Islam','Jl. Gurame Raya No. 104',1,'2020-08-19','1',7,'1',0),
('20074','3174065002780000','Leny Wati','1978-02-10','Bekasi','P','Katolik','Karang tengah raya',1,'2020-08-27','1',7,'1',0),
('20075','7404227110020000','Lutfiah Azzahra','2002-10-31','Baubau','P','Islam','Jl. Poros Kapontori',1,'2020-08-21','1',7,'1',0),
('20076','1701114809020000','DINA FATURANI','2002-09-08','TEMBILAHAN','P','Islam','Jl.Letnan Jahidin',1,'2020-09-07','1',7,'1',7500000),
('20077','3276062009020000','WISNU BANYU AJI','2002-09-20','DEPOK','L','Islam','Hj. SHIBI',1,'2020-09-07','1',7,'1',7500000),
('20078','7306082909000000','AL HARITS','2000-09-29','MAKASSAR','L','Islam','-',1,'2020-09-07','1',7,'1',7500000),
('20079','3273214508010000','THOFHANI AZKA MUZAKIYAH','2001-08-05','BANDUNG','P','Islam','Trs. Buah Batu No.151',1,'2020-09-07','1',7,'1',7500000),
('20080','5202111508020000','M. SUKRON JAELANI','2002-05-08','TEGU','L','Islam','Kabul batu jangkih',1,'2020-09-07','1',7,'1',7500000),
('20081','1312054502020000','KHAIRA AULIA PUTRI','2002-02-05','KINALI','P','Islam','kinali',1,'2020-09-07','1',7,'1',7500000),
('20082','1804042011010000','ROBIY HARISTIANATA','2001-11-20','BANDAR LAMPUNG','L','Islam','R.A Kartini',1,'2020-09-07','1',7,'1',7500000),
('20083','3171011506020000','KRISNA DUTA','2002-06-15','JAKARTA','L','Islam','-',1,'2020-09-07','1',7,'1',7500000),
('20084','7171072604030000','CHRISTIAN PUTRA RUMAJAR','2003-04-26','MANADO','L','Kristen','JL murbai no 146',1,'2020-09-07','1',7,'1',7500000),
('20085','3671026803990000','DELLA ANGGIASINTA','1999-03-28','TANGERANG','P','Islam','Bhinnekaraya',1,'2020-09-07','1',7,'1',10500000),
('20086','1603056209010000','SEPTIA NABILA','2001-09-22','PENDOPO','P','Islam','Jl. rumah sakit umum Bhayangkara',1,'2020-09-07','1',7,'1',7500000),
('20088','1608032802020000','BAMBANG RIANTO','2002-02-28','OKU TIMUR','L','Islam','TANJUNG BULAN',1,'2020-09-10','1',7,'1',0),
('20089','3602221706020000','MUHAMAD ZAENUS SOLIHIN','2002-01-17','LEBAK','L','Islam','Jl.raya kec.sobang',1,'2020-09-07','1',7,'1',7500000),
('20090','1801061602020000','THORIK KANEKO PUTRO','2001-11-15','KALIANDA','L','Islam','JL Kolonel Makmun Rasyid No 59',1,'2020-09-07','1',7,'1',7500000),
('20091','6111015610020000','DITTA ZHARINA','2002-10-16','SUKADANA','P','Islam','Simpang empat',1,'2020-09-07','1',7,'1',7500000),
('20092','3305122703000000','ADITYA PAMUNGKAS','2000-03-27','KEBUMEN','L','Islam','-',1,'2020-09-07','1',7,'1',10500000),
('20093','3603124212960010','DESY ARNI MELATI','1996-12-02','PACITAN','P','Islam','Perum Bumi Asri Blok. B No. 4',1,'2020-09-07','1',7,'1',7500000),
('20094','3175094107020000','NAAFILAH WIMANTARI','2002-07-01','JAKARTA','P','Islam','Jl.raya susukan nanggela ,perumahan puri sentosa blok A.6',1,'2020-09-07','1',7,'1',7500000),
('20095','7202076404010000','SITI MAHMUDAH','2001-04-24','KOTA NAGAYA','P','Islam','-',1,'2020-09-07','1',7,'1',7500000),
('20096','3671014210970000','SARAH ANGELINA','1997-10-02','JAKARTA','P','Kristen','-',1,'2020-09-04','1',7,'1',0),
('20097','3525142802980000','Aminudin Rais Abdillah Bill Haq','1998-02-28','Gresik','L','Islam','Jalan Raya Randuagung',1,'2020-09-08','1',7,'1',0),
('20098','3507145012010000','KEN ANDIEN JATI PRAMESWARI','2001-12-10','MALANG','P','Islam','SIDODADI II',1,'2020-09-01','1',7,'1',0),
('20099','3510161710900000','R. Herdy Kurniawan Eka Putra','1990-10-17','SURABAYA','L','Islam','Perum Mendut Hijau Regency BB.3 Banyuwangi',1,'2020-09-01','1',7,'1',0),
('20100','3578140803980000','Tri Cahyo Kurnianto','1998-03-08','Surabaya','L','Islam','Jln Manukan Subur 1/17 Blok 32N',1,'2020-09-01','1',7,'1',0),
('20101','3515084104000000','Rizki Vika Wibian Anugrah','2000-04-01','Sidoarjo','P','Islam','Werkudoro IV',1,'2020-09-01','1',7,'1',0),
('20102','3510072002840000','Sujud Durrohman','1984-02-20','Banyuwangi','L','Islam','-',1,'2020-09-01','1',7,'1',0),
('20103','3524226807000000','Yulita Wahyuningtyas','2000-07-28','Lamongan','P','Islam','Basuki Rahmad',1,'2020-09-02','1',7,'1',0),
('20104','3510164210790000','Eka Widy Astuti','1979-10-02','Banyuwangi','P','Islam','Jalan Ikan Sepat No. 34',1,'2020-09-01','1',7,'1',0),
('20106','3274036105790010','Yosi Melani','1979-05-21','Cirebon','P','Islam','Jl Nanas No 5 Bumi Kalijaga Permai Timur',1,'2020-09-18','1',7,'1',0),
('20107','3174050210990000','Muhamad Fahrul','1999-10-02','Jakarta','L','Islam','Jl Jiban 2 No.18',1,'2020-09-15','1',7,'1',0),
('20108','3525102106920000','Eko Heri Safriyanto','1992-06-21','Kebumen','L','Islam','-',1,'2020-09-08','1',7,'1',0),
('20109','6171054710910010','Dewi Rukmana','1991-10-07','Jakarta','P','Katolik','-',1,'2020-09-25','1',7,'1',0),
('20110','3171070509990000','NAWWAF','1999-09-05','JAKARTA','L','Islam','CIBEUREUM',1,'2020-09-25','1',7,'0',0),
('20112','3507205306000000','LOURA SILVIYANTI','2000-06-13','MALANG','P','Islam','JL MELATI',1,'2020-09-30','1',7,'1',0),
('20113','3507016811980000','NOVIA GITA PRATIWI','1998-11-28','SURABAYA','P','Islam','Jl Raya Pantai Ngliyep',1,'2020-09-30','1',7,'1',0),
('20114','3507134710930000','Okvitari Ayu Saputri','1993-10-07','Malang','P','Islam','-',1,'2020-09-30','1',7,'1',0),
('20115','3523144402910000','PUJI SETIYO NINGRUM','1991-02-04','TUBAN','P','Islam','Jl Pattimura',1,'2020-09-30','1',7,'1',0),
('20116','3471040809890000','Guntur Susilo Putra','1989-09-08','Manokwari','L','Islam','Perum Permata Tegalsari Kav.54',1,'2020-09-30','1',7,'0',0),
('20117','3573042011980000','ABIT SUTOMO','1998-11-20','Malang','L','Islam','JL. Raya Candi V / 599',1,'2020-09-30','1',7,'1',0),
('20118','3573042907970000','Jerry Leonard Legi','1997-07-29','Malang','L','Kristen','Jl. Raya Kepuh 195',1,'2020-09-30','1',7,'0',0),
('20119','3273014512950000','VELYN HIDAYAT','1995-12-05','BANDUNG','P','Kristen','-',1,'2020-10-02','1',7,'1',0),
('20120','3201046609000000','ANNISA HIDAYANTI NASUTION','2000-09-26','Depok','P','Islam','jambudipa',1,'2020-10-01','1',7,'1',0),
('20121','3507204403940000','DIAH PARAMITA FITRIAWATI','1994-03-14','Malang','P','Islam','-',1,'2020-09-30','1',7,'1',0),
('20122','3578021311990000','THOMAS ADI PRATAMA','1999-11-13','BENDUL MERISI BESAR SELATAN-45 S','L','Islam','Bendul Merisi Besar Selatan 45',1,'2020-10-23','1',7,'1',0),
('20123','3603285805660000','Theresia Witnoe, SE','1966-05-18','TEGAL','P','Kristen','Jl. Cemara Golf No. 61',2,'2020-09-04','1',7,'1',5000000),
('20124','3204461503970000','Muhammad Resha Bimantara Haryanto','1997-03-15','Bekasi','L','Islam','Jl. Melati',1,'2020-12-09','1',7,'1',0),
('20125','1310012112610000','ALTI SOKKO DERYANTO','1961-12-19','TIKU','L','Islam','Jorong Pasar Koto Baru',2,'2020-09-07','1',7,'1',5000000),
('20126','1806240607880000','DEDE SETIAWAN','1998-07-06','BANDUNG','L','Islam','-',1,'2020-12-15','1',7,'1',0),
('20127','3201172912980000','TORI RAMDHANI','1998-12-29','Bogor','L','Islam','Jl Babakan Raya',1,'2020-12-22','1',7,'1',0),
('20128','3171084605930000','SITI KHAERUNNISA','1993-05-06','JAKARTA','P','Islam','Jl. Nusa Indah Raya Blok 40 No. 17 B',1,'2020-12-23','1',7,'1',0);

/*Table structure for table `mst_prodi` */

DROP TABLE IF EXISTS `mst_prodi`;

CREATE TABLE `mst_prodi` (
  `kd_prog` int(11) NOT NULL,
  `nama_prog` varchar(50) DEFAULT NULL,
  `jenjang` char(2) DEFAULT NULL,
  PRIMARY KEY (`kd_prog`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `mst_prodi` */

insert  into `mst_prodi`(`kd_prog`,`nama_prog`,`jenjang`) values 
(1,'D3 - Optometri','D3'),
(2,'S1 - Optometri','S1');

/*Table structure for table `mst_ta` */

DROP TABLE IF EXISTS `mst_ta`;

CREATE TABLE `mst_ta` (
  `kd_ta` int(11) NOT NULL AUTO_INCREMENT,
  `ta` char(9) DEFAULT NULL,
  `smt` int(1) DEFAULT NULL,
  `aktif` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`kd_ta`)
) ENGINE=InnoDB AUTO_INCREMENT=18446744073709551615 DEFAULT CHARSET=latin1;

/*Data for the table `mst_ta` */

insert  into `mst_ta`(`kd_ta`,`ta`,`smt`,`aktif`) values 
(1,'2016/2017',1,0),
(2,'2017/2018',2,0),
(3,'2018/2019',1,0),
(4,'2018/2019',2,0),
(5,'2019/2020',1,0),
(6,'2019/2020',2,0),
(7,'2020/2021',1,0),
(8,'2020/2021',2,0),
(9,'2021/2022',1,0),
(10,'2021/2022',2,0),
(11,'2022/2023',1,0),
(12,'2022/2023',2,0),
(13,'2023/2024',1,0),
(14,'2023/2024',2,0),
(15,'2024/2025',1,0),
(16,'2024/2025',2,1),
(17,'2025/2026',1,0),
(18,'2026/2027',1,0);

/*Table structure for table `permission_roles` */

DROP TABLE IF EXISTS `permission_roles`;

CREATE TABLE `permission_roles` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`role_id`,`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `permission_roles` */

insert  into `permission_roles`(`role_id`,`permission_id`) values 
(1,1),
(1,2),
(1,3),
(1,4),
(1,5),
(1,6),
(1,7),
(1,8),
(1,9),
(1,10),
(1,11),
(1,12),
(1,13),
(1,14),
(1,17),
(1,18),
(1,19),
(1,20),
(1,21),
(1,22),
(1,23),
(1,24),
(1,25),
(1,26),
(1,27),
(1,28),
(1,29),
(1,30),
(1,31),
(1,32),
(1,33);

/*Table structure for table `permissions` */

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `display_name` varchar(100) DEFAULT NULL,
  `description` tinytext,
  `status` tinyint(1) DEFAULT '1',
  `parent_id` int(11) DEFAULT NULL,
  `link` varchar(150) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `sequence` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

/*Data for the table `permissions` */

insert  into `permissions`(`id`,`name`,`display_name`,`description`,`status`,`parent_id`,`link`,`icon`,`sequence`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'dashboard','Dashboard','Dashboard\r\n',1,0,'dashboard','home',1,NULL,NULL,NULL),
(2,'master','Master','HEAD-MASTER\r\n',1,0,'master','books',3,NULL,NULL,NULL),
(3,'master-tahun_ajaran','Tahun Ajaran','SUB-MASTER',1,2,'master/tahun_ajaran',NULL,7,NULL,NULL,NULL),
(4,'master-prodi','Prodi','SUB-MASTER',1,2,'master/prodi',NULL,6,NULL,NULL,NULL),
(5,'users','Manage Users','HEAD-USERS',1,0,'users','user',2,NULL,NULL,NULL),
(6,'users-mahasiswa','Mahasiswa','SUB-USERS',1,5,'users/mahasiswa',NULL,NULL,NULL,NULL,NULL),
(7,'users-dosen','Dosen','SUB-USERS',1,5,'users/dosen',NULL,NULL,NULL,NULL,NULL),
(8,'settings','Setting',NULL,1,0,'settings','tool',7,NULL,NULL,NULL),
(9,'settings-general','General',NULL,1,8,'settings/general',NULL,1,NULL,NULL,NULL),
(10,'settings-role','Role Permission',NULL,1,8,'settings/role',NULL,2,NULL,NULL,NULL),
(11,'master-mata_kuliah','Mata Kuliah',NULL,1,2,'master/mata_kuliah','books',5,NULL,NULL,NULL),
(12,'master-biaya','Biaya',NULL,1,2,'master/biaya',NULL,2,NULL,NULL,NULL),
(14,'master-jenis_biaya','Jenis Biaya',NULL,1,2,'master/jenis_biaya',NULL,4,NULL,NULL,NULL),
(15,'pmb-dashboard_pmb','Dashboard PMB',NULL,1,NULL,'pmb/dashboard_pmb',NULL,NULL,NULL,NULL,NULL),
(16,'pmb-biodata','Biodata',NULL,1,NULL,'pmb-biodata',NULL,NULL,NULL,NULL,NULL),
(17,'admin','PMB',NULL,1,0,'admin','quiz',4,NULL,NULL,NULL),
(18,'admin-pmb_proses','PMB Proses',NULL,1,17,'admin/pmb_proses',NULL,3,NULL,NULL,NULL),
(19,'users-karyawan','Karyawan','SUB-USERS',1,5,'users/karyawan',NULL,NULL,NULL,NULL,NULL),
(20,'krs','KRS',NULL,1,0,'krs','online-class',5,NULL,NULL,NULL),
(21,'krs-jadwal_pengajaran','Jadwal Pengajaran',NULL,1,20,'krs/jadwal_pengajaran',NULL,1,NULL,NULL,NULL),
(23,'krs-krs_mahasiswa','KRS Per Mahasiswa',NULL,1,20,'krs/krs_mahasiswa',NULL,2,NULL,NULL,NULL),
(24,'krs-pembayaran_semester','Pembayaran Semester',NULL,1,20,'krs/pembayaran_semester',NULL,3,NULL,NULL,NULL),
(25,'khs','KHS',NULL,1,0,'khs','presentation',6,NULL,NULL,NULL),
(26,'khs/uts','UTS',NULL,1,25,'khs/uts',NULL,1,NULL,NULL,NULL),
(27,'khs/uas','UAS',NULL,1,25,'khs/uas',NULL,2,NULL,NULL,NULL),
(28,'khs/absensi','Absensi',NULL,1,25,'khs/absensi',NULL,3,NULL,NULL,NULL),
(29,'admin-jadwal_seleksi','Jadwal Seleksi',NULL,1,17,'admin/jadwal_seleksi',NULL,4,NULL,NULL,NULL),
(30,'master-jabatan','Jabatan',NULL,1,2,'master/jabatan',NULL,3,NULL,NULL,NULL),
(31,'admin-periode_pmb','Periode PMB',NULL,1,17,'admin/periode_pmb',NULL,1,NULL,NULL,NULL),
(32,'admin-pmb_validasi','PMB Validasi Berkas',NULL,1,17,'admin/pmb_validasi',NULL,2,NULL,NULL,NULL),
(33,'master-agama','Agama',NULL,1,2,'master/agama',NULL,1,NULL,NULL,NULL);

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `display_name` varchar(30) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UK_user_roles_role_Name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Data for the table `roles` */

insert  into `roles`(`id`,`name`,`display_name`,`description`,`status`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'admin','admin','admin',1,NULL,NULL,NULL),
(2,'mahasiswa','mahasiswa','mahasiswa',1,NULL,NULL,NULL),
(3,'dosen','dosen','dosen',1,NULL,NULL,NULL),
(4,'staff','staff','staff',1,NULL,NULL,NULL),
(5,'pmb','pmb','pmb',1,NULL,NULL,NULL);

/*Table structure for table `roles_users` */

DROP TABLE IF EXISTS `roles_users`;

CREATE TABLE `roles_users` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `roles_users` */

insert  into `roles_users`(`user_id`,`role_id`) values 
(1,1),
(2,2),
(3,2),
(22,2),
(24,2),
(25,2),
(26,2),
(27,2),
(28,2),
(29,2),
(31,2);

/*Table structure for table `trn_distribusi_mk` */

DROP TABLE IF EXISTS `trn_distribusi_mk`;

CREATE TABLE `trn_distribusi_mk` (
  `kd_ta` int(11) NOT NULL,
  `kode_matkul` char(6) NOT NULL,
  `nip` varchar(12) NOT NULL,
  PRIMARY KEY (`kd_ta`,`kode_matkul`,`nip`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `trn_distribusi_mk` */

/*Table structure for table `trn_krs` */

DROP TABLE IF EXISTS `trn_krs`;

CREATE TABLE `trn_krs` (
  `id_krs` int(11) NOT NULL COMMENT 'id krs',
  `id` int(10) NOT NULL COMMENT 'id tugas ajar',
  `nim` char(10) NOT NULL,
  `tugas` decimal(10,2) DEFAULT NULL,
  `uts` decimal(10,2) DEFAULT NULL,
  `uas` decimal(10,2) DEFAULT NULL,
  `absen` decimal(10,2) DEFAULT NULL,
  `na` char(1) DEFAULT NULL COMMENT 'A,B,C,D,E',
  PRIMARY KEY (`id_krs`,`id`,`nim`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `trn_krs` */

/*Table structure for table `trn_pmb` */

DROP TABLE IF EXISTS `trn_pmb`;

CREATE TABLE `trn_pmb` (
  `no_pendaftaran` varchar(150) NOT NULL,
  `nik` varchar(20) DEFAULT NULL,
  `nama` varchar(150) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `nisn` varchar(50) DEFAULT NULL,
  `npwp` varchar(50) DEFAULT NULL,
  `asal_sekolah` varchar(50) DEFAULT NULL,
  `tahun_lulus` varchar(20) DEFAULT NULL,
  `tempat_lahir` varchar(50) DEFAULT NULL,
  `tanggal_lahir` datetime DEFAULT NULL,
  `agama` varchar(20) DEFAULT NULL,
  `jenis_kelamin` varchar(50) DEFAULT NULL,
  `jenis_tinggal` varchar(100) DEFAULT NULL,
  `nama_ibu_kandung` varchar(50) DEFAULT NULL,
  `kewarganegaraan` varchar(50) DEFAULT NULL,
  `alamat` text,
  `kelurahan` varchar(100) DEFAULT NULL,
  `kecamatan` varchar(100) DEFAULT NULL,
  `rt` varchar(20) DEFAULT NULL,
  `rw` varchar(20) DEFAULT NULL,
  `kode_pos` varchar(10) DEFAULT NULL,
  `kd_gel` int(11) DEFAULT NULL,
  `kd_prog` int(11) DEFAULT NULL,
  `kd_jenma` int(11) DEFAULT NULL,
  `kd_ta` int(11) DEFAULT NULL,
  `kd_biaya` int(11) DEFAULT NULL,
  `is_bayar` tinyint(1) DEFAULT '0',
  `status_terkini` int(2) DEFAULT '1',
  `foto_profil` text,
  `tgl_input` datetime DEFAULT NULL,
  `pic_validasi` varchar(50) DEFAULT NULL,
  `tgl_validasi` datetime DEFAULT NULL,
  `tgl_bayar` datetime DEFAULT NULL,
  PRIMARY KEY (`no_pendaftaran`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `trn_pmb` */

insert  into `trn_pmb`(`no_pendaftaran`,`nik`,`nama`,`email`,`no_hp`,`telepon`,`nisn`,`npwp`,`asal_sekolah`,`tahun_lulus`,`tempat_lahir`,`tanggal_lahir`,`agama`,`jenis_kelamin`,`jenis_tinggal`,`nama_ibu_kandung`,`kewarganegaraan`,`alamat`,`kelurahan`,`kecamatan`,`rt`,`rw`,`kode_pos`,`kd_gel`,`kd_prog`,`kd_jenma`,`kd_ta`,`kd_biaya`,`is_bayar`,`status_terkini`,`foto_profil`,`tgl_input`,`pic_validasi`,`tgl_validasi`,`tgl_bayar`) values 
('PMB-24050001','123456789123288','rizki aja','rizky.it@optiktunggal.com','082145698789',NULL,NULL,NULL,NULL,'2024',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,4,1,2,NULL,NULL,1,1,NULL,'2024-05-20 15:00:14',NULL,NULL,NULL),
('PMB-24050002','12345678','rizki aja','rizky.it@optiktunggal.com','082145698789',NULL,NULL,NULL,NULL,'2024',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,4,1,2,NULL,NULL,NULL,1,NULL,'2024-05-20 15:00:58',NULL,NULL,NULL),
('PMB-24050003','021554554545545545','Arayatama','rizky.it@optiktunggal.com','0812456548555654',NULL,NULL,NULL,NULL,'2022',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,4,1,1,NULL,NULL,NULL,1,NULL,'2024-05-20 15:10:44',NULL,NULL,NULL),
('PMB-24050004','021554554545545545','Arayatama','rizky.it@optiktunggal.com','0812456548555654',NULL,NULL,NULL,NULL,'2022',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,4,1,1,NULL,NULL,NULL,1,NULL,'2024-05-20 15:11:13',NULL,NULL,NULL),
('PMB-24050005','290384092834','Mang Dadang','aryatama045@gmail.com','08123908019283',NULL,NULL,NULL,NULL,'2022',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,4,1,2,NULL,NULL,NULL,1,NULL,'2024-05-20 15:17:49',NULL,NULL,NULL),
('PMB-24050006','02934890','Roror','aryatama045@gmail.com','098120983102',NULL,NULL,NULL,NULL,'2023',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,4,1,2,NULL,NULL,1,1,NULL,'2024-05-20 15:20:04',NULL,NULL,NULL),
('PMB-24050007','0912391239','kang handri','handri.it@optiktunggal.com','081234566778',NULL,NULL,NULL,NULL,'2024',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,4,1,1,NULL,NULL,NULL,1,NULL,'2024-05-21 09:10:14',NULL,NULL,NULL),
('PMB-24050008','123','asd','asd@asd.ghj','234',NULL,NULL,NULL,NULL,'2021',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,4,0,0,NULL,NULL,NULL,1,NULL,'2024-05-22 08:58:37',NULL,NULL,NULL),
('PMB-24050009','555666','aryatama','rizky.it@optiktunggal.com','0812121212',NULL,NULL,NULL,NULL,'2020',NULL,'1995-07-19 11:33:44','3','L','',NULL,NULL,'Jl. Hoschokroaminoto Larangan Indah',NULL,NULL,NULL,NULL,NULL,4,1,1,NULL,NULL,NULL,5,'PMB-24050009-banner1.png','2024-05-28 11:07:39','1','2024-06-10 02:40:12',NULL),
('PMB-24060002','1234567','Rian','rizky.it@optiktunggal.com','','','234','','','2024','ertert','2005-07-08 00:00:00','5','L','','test','indo','ghj','ghj','ghj','','','',5,1,1,NULL,NULL,0,4,'PMB-24060002-about-us1.png','2024-06-19 10:56:56',NULL,NULL,NULL);

/*Table structure for table `trn_pmb_dok` */

DROP TABLE IF EXISTS `trn_pmb_dok`;

CREATE TABLE `trn_pmb_dok` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_pendaftaran` varchar(50) DEFAULT NULL,
  `nama_dok` varchar(50) DEFAULT NULL,
  `dokumen` text,
  `tgl_input` datetime DEFAULT NULL,
  `validasi` int(1) DEFAULT NULL,
  `ket_validasi` text,
  `pic_validasi` int(11) DEFAULT NULL,
  `tgl_validasi` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

/*Data for the table `trn_pmb_dok` */

insert  into `trn_pmb_dok`(`id`,`no_pendaftaran`,`nama_dok`,`dokumen`,`tgl_input`,`validasi`,`ket_validasi`,`pic_validasi`,`tgl_validasi`) values 
(7,'PMB-24050009','Ijazah','PMB-24050009-0-11.JPG','2010-06-24 02:28:10',1,'Sudah',1,'2024-06-10 00:00:00'),
(8,'PMB-24050009','Ktp','PMB-24050009-1-22.JPG','2010-06-24 02:28:11',1,'Sudah',1,'2024-06-10 00:00:00'),
(9,'PMB-24050009','Pas Photo 3X4','PMB-24050009-2-about-us1.png','2010-06-24 02:28:11',1,'Sudah',1,'2024-06-10 00:00:00'),
(10,'PMB-24050009','Kartu Keluarga','PMB-24050009-3-wasa-crispbread-AOgRd7Ah8-U-unsplash (1).jpg','2010-06-24 02:28:11',1,'Sudah',1,'2024-06-10 00:00:00'),
(11,'PMB-24050009','Ijazah','PMB-24050009-4-wisata-di-kota-tangerang-foto-pemkot-tangerang-4y3qr-zste.jpg','2010-06-24 02:28:11',1,'Sudah',1,'2024-06-10 00:00:00'),
(12,'PMB-24050009','Ijazah','PMB-24050009-5-about-us1.png','2010-06-24 02:28:11',1,'Sudah',1,'2024-06-10 00:00:00'),
(13,'PMB-24060002','Ijazah','PMB-24060002-0-11.JPG','2019-06-24 04:51:21',0,'Belum Validasi',NULL,NULL),
(14,'PMB-24060002','Ktp','PMB-24060002-1-22.JPG','2019-06-24 04:51:21',0,'Belum Validasi',NULL,NULL),
(15,'PMB-24060002','Pas Photo 3X4','PMB-24060002-2-banner1.png','2019-06-24 04:51:21',0,'Belum Validasi',NULL,NULL),
(16,'PMB-24060002','Ijazah','PMB-24060002-3-image 1.png','2019-06-24 04:51:21',1,'Belum Validasi',1,'2024-06-19 00:00:00'),
(17,'PMB-24060002','Surat Keterangan Tidak Buta Warna','PMB-24060002-4-22.JPG','2019-06-24 04:51:21',0,'Belum Validasi',NULL,NULL),
(18,'PMB-24060002','Scan Rapor SMA/SMK','PMB-24060002-5-22.JPG','2019-06-24 04:51:22',0,'Belum Validasi',NULL,NULL);

/*Table structure for table `trn_tugas_ajar` */

DROP TABLE IF EXISTS `trn_tugas_ajar`;

CREATE TABLE `trn_tugas_ajar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kd_ta` int(11) NOT NULL,
  `nip` varchar(12) NOT NULL,
  `kode_matkul` char(6) NOT NULL,
  `kd_prog` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `trn_tugas_ajar` */

insert  into `trn_tugas_ajar`(`id`,`kd_ta`,`nip`,`kode_matkul`,`kd_prog`) values 
(1,16,'240605001','OF4104',1);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `pmb` varchar(15) DEFAULT NULL,
  `code` varchar(6) DEFAULT NULL,
  `nim` varchar(20) DEFAULT NULL,
  `no_pmb` varchar(50) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`username`,`password`,`pmb`,`code`,`nim`,`no_pmb`,`status`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'admin','admin','$2y$10$ZMQOPfEVLtMrp51j9i3JBeKeOrOXEbvK/XZ2NYx48QqdM766dJBB.',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(2,'Abdul','mahasiswa','$2y$10$ZMQOPfEVLtMrp51j9i3JBeKeOrOXEbvK/XZ2NYx48QqdM766dJBB.',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(3,'Tama','200265','$2y$10$ZMQOPfEVLtMrp51j9i3JBeKeOrOXEbvK/XZ2NYx48QqdM766dJBB.',NULL,NULL,NULL,NULL,1,NULL,NULL,NULL),
(29,'arya','24050026','$2y$10$pwiOEEXXuyznzqxJHdtCZOio9zhJtkOr/4gY8igon5005kYPmhQIu','aktif',NULL,'20001','PMB-24050009',1,'0000-00-00 00:00:00',NULL,NULL),
(31,'Rian','24060002','$2y$10$mNKyxOlZ4QY5GMywUHut6eTf0KZwnjmX6ypqEgKHVd383WwtJldWi','aktif',NULL,NULL,'PMB-24060002',1,'0000-00-00 00:00:00',NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
