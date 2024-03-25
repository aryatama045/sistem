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

/*Table structure for table `menus` */

DROP TABLE IF EXISTS `menus`;

CREATE TABLE `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `link` varchar(150) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `sequence` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

/*Data for the table `menus` */

insert  into `menus`(`id`,`parent_id`,`name`,`link`,`icon`,`sequence`) values 
(1,0,'Dashboard','dashboard','home',1),
(8,0,'Manage User',NULL,'online-class',2),
(9,0,'Master',NULL,'books',3),
(10,9,'Tahun Ajaran','master/tahun_ajaran',NULL,1),
(11,9,'Level 3.2',NULL,NULL,2),
(12,11,'Level 3.2.1',NULL,NULL,1),
(15,0,'Level 5','clipboard','presentation',5),
(16,0,'Level 4','dashboard','quiz',4),
(17,8,'Staff',NULL,NULL,3),
(18,8,'Dosen ',NULL,NULL,2),
(19,8,'Mahasiswa','users/mahasiswa',NULL,1),
(27,0,'General Setting',NULL,'abacus',6),
(28,27,'Tahun Ajaran',NULL,NULL,1),
(29,27,'Roles',NULL,NULL,2),
(30,27,'Permission',NULL,NULL,3);

/*Table structure for table `mst_biaya` */

DROP TABLE IF EXISTS `mst_biaya`;

CREATE TABLE `mst_biaya` (
  `kd_biaya` int(11) NOT NULL,
  `kd_ta` int(11) NOT NULL,
  `nilai` decimal(17,2) DEFAULT NULL,
  PRIMARY KEY (`kd_biaya`,`kd_ta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `mst_biaya` */

insert  into `mst_biaya`(`kd_biaya`,`kd_ta`,`nilai`) values 
(1,1,7500000.00),
(2,1,500000.00);

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
  `kd_prog` char(2) DEFAULT NULL COMMENT 'program studi',
  `tgl_masuk` date DEFAULT NULL,
  `kd_daftar` char(1) DEFAULT NULL COMMENT 'baru - pindahan',
  `status` tinyint(1) DEFAULT NULL COMMENT 'mahasiswa aktif',
  `jk` char(1) DEFAULT NULL,
  `kd_ta` int(11) DEFAULT NULL,
  `kd_biaya` int(11) DEFAULT NULL,
  `tempat_lahir` varchar(200) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `agama` char(8) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`nim`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `mst_mhs` */

insert  into `mst_mhs`(`nim`,`nik`,`nama_mhs`,`kd_prog`,`tgl_masuk`,`kd_daftar`,`status`,`jk`,`kd_ta`,`kd_biaya`,`tempat_lahir`,`tgl_lahir`,`agama`,`alamat`) values 
('20001','3172010305961000','ADIMAS SATRIO PRASIDA','1','2020-04-07','1',1,'L',1,0,'JAKARTA','1996-05-03','Budha','Jl. Pakubuwono Vi no. 68, Kebayoran Baru, Jakarta Selatan'),
('20002','7410016405030000','VELIZ MEIF LISTA','1','2020-04-24','1',1,'P',7,0,'LIPU','2003-05-24','Islam','Keraton'),
('20003','3324084504020000','IZZA TAZKIA FATMA','1','2020-04-30','1',1,'P',7,0,'KENDAL','2002-04-05','Islam','Gang Istiqomah'),
('20004','6311064507020000','Nabila Kamaliya','1','2020-05-01','1',1,'P',7,0,'Banjarmasin','2002-07-05','Islam','Jalan anggrek'),
('20005','3172010305961000','MUHAMMAD IRFAN NUR IHSAN','1','2020-05-01','1',1,'L',7,0,'BANJARMASIN','2002-04-07','Islam','JL. RTA. MILONO KM 3 PERUM. BOROBUDUR 2 NO 11B'),
('20006','3201376812020000','Desti Arum Fitriah','1','2020-05-02','1',1,'P',7,0,'Bantul','2002-12-28','Islam','Perum. Puri Shantika'),
('20007','1810016105020000','Thania vira rivanda','1','2020-05-04','1',1,'P',7,0,'Pringsewu','2002-05-21','Islam','Jl. Gotong royong pringsewu'),
('20008','3275010107020140','Muhammad Syalman Yanwar Wijaya','1','2020-05-06','1',1,'L',7,0,'bekasi','2002-07-01','Islam','IR H.JUANDA NO 335'),
('20009','3602142406010000','Rizky Dwi Pradipta','1','2020-05-13','1',1,'L',7,0,'LEBAK','2001-06-24','Islam','Jln.Kuncoro Jakti'),
('20010','6401045906020000','Kurnia Ari Sulistiawati','1','2020-05-16','1',1,'P',7,0,'Tanah Grogot','2002-06-19','Islam','Jl.Rantau Panjang'),
('20011','7173035409030000','Yngwie Thezalonika Nirvana Gibrani Polii','1','2020-05-18','1',1,'P',7,0,'Tomohon','2002-09-14','Kristen','Polii 1'),
('20012','1307116403020000','Shafira Sofyani','1','2020-05-19','1',1,'P',7,0,'Payakumbuh','2002-03-24','Islam','Jalan raya mungka'),
('20013','3804300109010000','Ida Faridatul Jannah','1','2020-05-21','1',1,'P',7,0,'Serang','2001-09-11','Islam','Kp Pakis Indah'),
('20014','3501086509020000','Dila Putri Puspita Rini','1','2020-05-21','1',1,'P',7,0,'Pacitan','2002-09-25','Islam','-'),
('20015','3275066205020000','Indah Ayu Regita Prameswari','1','2020-05-30','1',1,'P',7,0,'Bekasi','2002-05-22','Islam','Jembatan bola'),
('20016','3603285809020000','Stephani Devina Lau','1','2020-05-30','1',1,'P',7,0,'Tangerang','2002-09-18','Kristen','Kramat wates'),
('20017','3175102304020000','Dio Hilal Prakoso','1','2020-05-31','1',1,'L',7,0,'Jakarta','2002-04-23','Islam','Hj Moechtar'),
('20018','3602010706010000','NANDA HARIS ANGGRIAWAN','1','2020-09-07','1',1,'L',7,7500000,'Pacitan','2001-06-07','Islam','Jl.gn.kencana-malingping'),
('20019','3276021605020000','ARFINU ALIF','1','2020-09-07','1',1,'L',7,7500000,'Tegal','2002-05-16','Islam','Kebayunan'),
('20020','3174090707790000','HENDRA PRAWIRA NEGARA','1','2020-09-07','1',1,'L',7,7500000,'JAKARTA','1979-07-07','Islam','Jl.Raya Lenteng Agung, Kp.Srengseng No.26'),
('20021','3604334409010000','Fitri Nurasih','1','2020-06-08','1',1,'P',7,0,'Serang','2001-09-04','Islam','Kp.cilebak'),
('20022','3276020904020000','Bilal Firmansyah','1','2020-06-11','1',1,'L',7,0,'Purworejo','2002-04-09','Islam','Gasalam'),
('20023','6171012803020000','Mahendra Boydo Nathanael Silitonga','1','2020-06-12','1',1,'L',7,0,'Pontianak','2002-03-28','Kristen','KP. Soedarso No 14'),
('20024','1802010404990000','Wahyu','1','2020-06-14','1',1,'L',7,0,'kalirejo','1999-04-04','Islam','Jalan Majapahit'),
('20025','3173072205000000','Ananda Prasetyo Wibowo','1','2020-06-16','1',1,'L',7,0,'Jakarta','2000-05-22','Islam','Kemanggisan Pulo RT13/RW03 No32'),
('20026','3174034910010000','Desdiana Dwi Narsih','1','2020-08-28','1',1,'P',7,0,'Jakarta','2001-10-09','Islam','Bangka Raya No. 80'),
('20027','1708045110000000','Nadila Rahmawati','1','2020-08-29','1',1,'P',7,0,'KEPAHIANG','2000-10-11','Islam','Jln Lintas Pagar Alam'),
('20028','5105034102020000','NI LUH AYU DWI PRABASUARI','1','2020-09-07','1',1,'P',7,7500000,'Klungkung','2002-02-01','Hindu','-'),
('20029','3603220511010000','IBNU FAUZUL MUTAQIEN','1','2020-09-07','1',1,'L',7,7500000,'Tangerang','2001-11-05','Islam','-'),
('20030','3201022511010000','Ari Fajri Ramadhan','1','2020-06-30','1',1,'L',7,0,'Jakarta','2001-11-25','Islam','jalan dewa ciangsana kab.bogor'),
('20031','3501022610000000','MUHAMMAD IBNU AMIN CHOLIF','1','2020-09-07','1',1,'L',7,7500000,'Pacitan','2000-10-26','Islam','jln.Dadapan - watukarung'),
('20032','3327116503020000','Eka Nurhidayati Husna','1','2020-07-13','1',1,'P',7,0,'Pemalang','2002-03-25','Islam','Gulisari'),
('20033','3208101406010000','IKHSAN AKBAR ILHAMI','1','2020-07-13','1',1,'L',7,0,'KUNINGAN','2001-06-14','Islam','Desa Geresik'),
('20034','3173084611010000','Amelia Dwi Novitasari','1','2020-09-07','1',1,'P',7,0,'Klaten','2001-11-06','Islam','KOMP BPPT H-8/B-10'),
('20035','3326115302000000','Nur Fadilah','1','2020-07-24','1',1,'P',7,0,'Pekalongan','2000-02-13','Islam','-'),
('20036','3674045206000000','Veronica Vivin Rosalinda','1','2020-07-31','1',1,'P',7,0,'Semarang','2000-06-12','Katolik','Jl.mushola An Nur'),
('20037','1271075812990000','Karolina Kresensia Anatasya','1','2020-09-08','1',1,'P',7,0,'Medan Kota','1999-12-18','Kristen','Jln.senam komplek makam pahlawan'),
('20038','3175075304021000','Citra Vidi Beatha','1','2020-08-11','1',1,'P',7,0,'Jakarta','2002-04-13','Kristen','Cluster Tropical Garden Tg 6 No 90. Grand Galaxy City'),
('20039','3276041305940000','MUHAMMAD IQBAL FARIS','1','2020-08-12','1',1,'L',7,0,'JAKARTA','1994-05-13','Islam','KRAMAT'),
('20040','3301056907020000','Fatma Ayu Azzahro','1','2020-08-14','1',1,'P',7,0,'Cilacap','2002-07-29','Islam','Diponegoro'),
('20041','3501021210990000','RIDHO BAYU ENGGAR SADEWO','1','2020-05-25','1',1,'L',7,0,'RANGKAS BITUNG. LEBAK BANTEN','1999-10-12','Islam','-'),
('20043','7371110408020000','Manarul Fiqri Al Hikmah','1','2020-08-16','1',1,'L',7,0,'Makassar','2001-08-04','Islam','Jl. Perintis Kemerdekaan Km.14 No.195/81'),
('20044','3578080302940000','Aditya Harnanto PRatama','1','2020-05-26','1',1,'L',7,0,'Surabaya','1994-02-03','Islam','Grand Residence City komplek Senopati Park'),
('20045','3206394908990000','Sopi Ismiyati','1','2020-09-20','1',1,'P',7,0,'Tasikmalaya','1999-08-09','Islam','Kp. Ciomas'),
('20046','3202112707540000','TOTO FIRYANTO','1','2020-06-16','1',1,'L',7,0,'MATARAM','1954-07-25','Kristen','KARANG TENGAH'),
('20047','3172057001990000','Annisaa','1','2020-06-17','1',1,'P',7,0,'Jakarta Utara','1999-09-30','Islam','Jl lodan dalam 2b no 28'),
('20048','3203280702950000','Salman','1','2020-06-22','1',1,'L',7,0,'Cianjur','1995-02-07','Islam','Jl.kemang'),
('20049','3271056006960010','Yuni Sulistiawati','1','2020-06-24','1',1,'P',7,0,'Bogor','1996-06-20','Islam','Pemda Pangkalan 2'),
('20050','3173014107930010','Yoana Kosasi','1','2020-08-05','1',1,'P',7,0,'Kabanjahe','2020-07-01','Budha','Jalan Cengkareng Indah Blok Id No 13'),
('20051','1208204403960000','Elmida Purba','1','2020-08-05','1',1,'P',7,0,'Pongkalan Tongah','1996-03-04','Kristen','Gang melati 1 no 33f pondok labu, cilandak'),
('20052','3174102109930010','Rafid Rizkulloh','1','2020-07-06','1',1,'L',7,0,'Jakarta','1993-09-21','Islam','Jl.Sd Inpres'),
('20053','3601344308020000','Sevty Trie Gustin Lestari','1','2020-05-30','1',1,'P',7,0,'Pandeglang','2002-08-03','Islam','-'),
('20054','3509026510970000','Ayu Citra Dewi','1','2020-09-18','1',1,'P',7,0,'Lumajang','1997-10-25','Islam','-'),
('20055','3603120205020000','RIKI BAGAS ADI PRATAMA','1','2020-06-13','1',1,'L',7,0,'PACITAN','2002-05-02','Islam','JL.KENCANA BARAT 2 BLOK D-8/32 VILA TOMANG BARU II'),
('20056','1605156709020000','Febby Anggelia','1','2020-06-18','1',1,'P',7,0,'Karang Jaya','2002-09-27','Islam','-'),
('20057','1701054812020000','Herta Redha Musiada','1','2020-07-12','1',1,'P',7,0,'Manna','2002-12-08','Islam','Jendral Sudirman'),
('20058','3212080205020000','ILHAMU DZINURAIN MUHANDIS','1','2020-09-17','1',1,'L',7,0,'Indramayu','2002-05-02','Islam','Bypass Kertasemaya'),
('20059','3571015401020000','Diasti Machnafia Laili','1','2020-07-29','1',1,'P',7,0,'Kediri','2002-01-14','Islam','Perum Griya Intan Permai'),
('20061','3275024106020020','Yuniar Shalsabila','1','2020-08-14','1',1,'P',7,0,'Bekasi','2002-06-01','Islam','Pesut 2'),
('20064','3175085201020000','Melda Rizki Cahyaningrum','1','2020-08-26','1',1,'P',7,0,'Jakarta','2002-01-12','Islam','Kresno'),
('20065','3175042007970000','Zulfikar Ibnu Riad','1','2020-06-02','1',1,'L',7,0,'Jakarta','1997-07-20','Islam','Jl.H. Taiman B'),
('20067','1107190510870000','Isbuan','1','2020-07-06','1',1,'L',7,0,'Krueng Seukeuk','1987-01-05','Islam','Medan-banda Aceh'),
('20068','3275111312930000','ANDRYANSYAH SAPUTRA','1','2020-07-09','1',1,'L',7,0,'BEKASI','1993-12-13','Islam','Jl.Raya Binong'),
('20069','3403052508800000','Agus Suryono','1','2020-07-20','1',1,'L',7,0,'Gunungkidul','1980-08-25','Islam','-'),
('20071','1401191607910000','Prihadi Saputra','1','2020-08-10','1',1,'L',7,0,'Blitar','1991-07-16','Islam','Gg Anggrek, 57c Jl.kayen. Condongcatur'),
('20072','3174102304920000','Umar Rizal','1','2020-08-12','1',1,'L',7,0,'Jakarta','1992-04-23','Islam','Kayumanis VI'),
('20073','3671070105980000','Danar Dwi Cahyo','1','2020-08-19','1',1,'L',7,0,'Tangerang','1998-05-01','Islam','Jl. Gurame Raya No. 104'),
('20074','3174065002780000','Leny Wati','1','2020-08-27','1',1,'P',7,0,'Bekasi','1978-02-10','Katolik','Karang tengah raya'),
('20075','7404227110020000','Lutfiah Azzahra','1','2020-08-21','1',1,'P',7,0,'Baubau','2002-10-31','Islam','Jl. Poros Kapontori'),
('20076','1701114809020000','DINA FATURANI','1','2020-09-07','1',1,'P',7,7500000,'TEMBILAHAN','2002-09-08','Islam','Jl.Letnan Jahidin'),
('20077','3276062009020000','WISNU BANYU AJI','1','2020-09-07','1',1,'L',7,7500000,'DEPOK','2002-09-20','Islam','Hj. SHIBI'),
('20078','7306082909000000','AL HARITS','1','2020-09-07','1',1,'L',7,7500000,'MAKASSAR','2000-09-29','Islam','-'),
('20079','3273214508010000','THOFHANI AZKA MUZAKIYAH','1','2020-09-07','1',1,'P',7,7500000,'BANDUNG','2001-08-05','Islam','Trs. Buah Batu No.151'),
('20080','5202111508020000','M. SUKRON JAELANI','1','2020-09-07','1',1,'L',7,7500000,'TEGU','2002-05-08','Islam','Kabul batu jangkih'),
('20081','1312054502020000','KHAIRA AULIA PUTRI','1','2020-09-07','1',1,'P',7,7500000,'KINALI','2002-02-05','Islam','kinali'),
('20082','1804042011010000','ROBIY HARISTIANATA','1','2020-09-07','1',1,'L',7,7500000,'BANDAR LAMPUNG','2001-11-20','Islam','R.A Kartini'),
('20083','3171011506020000','KRISNA DUTA','1','2020-09-07','1',1,'L',7,7500000,'JAKARTA','2002-06-15','Islam','-'),
('20084','7171072604030000','CHRISTIAN PUTRA RUMAJAR','1','2020-09-07','1',1,'L',7,7500000,'MANADO','2003-04-26','Kristen','JL murbai no 146'),
('20085','3671026803990000','DELLA ANGGIASINTA','1','2020-09-07','1',1,'P',7,10500000,'TANGERANG','1999-03-28','Islam','Bhinnekaraya'),
('20086','1603056209010000','SEPTIA NABILA','1','2020-09-07','1',1,'P',7,7500000,'PENDOPO','2001-09-22','Islam','Jl. rumah sakit umum Bhayangkara'),
('20088','1608032802020000','BAMBANG RIANTO','1','2020-09-10','1',1,'L',7,0,'OKU TIMUR','2002-02-28','Islam','TANJUNG BULAN'),
('20089','3602221706020000','MUHAMAD ZAENUS SOLIHIN','1','2020-09-07','1',1,'L',7,7500000,'LEBAK','2002-01-17','Islam','Jl.raya kec.sobang'),
('20090','1801061602020000','THORIK KANEKO PUTRO','1','2020-09-07','1',1,'L',7,7500000,'KALIANDA','2001-11-15','Islam','JL Kolonel Makmun Rasyid No 59'),
('20091','6111015610020000','DITTA ZHARINA','1','2020-09-07','1',1,'P',7,7500000,'SUKADANA','2002-10-16','Islam','Simpang empat'),
('20092','3305122703000000','ADITYA PAMUNGKAS','1','2020-09-07','1',1,'L',7,10500000,'KEBUMEN','2000-03-27','Islam','-'),
('20093','3603124212960010','DESY ARNI MELATI','1','2020-09-07','1',1,'P',7,7500000,'PACITAN','1996-12-02','Islam','Perum Bumi Asri Blok. B No. 4'),
('20094','3175094107020000','NAAFILAH WIMANTARI','1','2020-09-07','1',1,'P',7,7500000,'JAKARTA','2002-07-01','Islam','Jl.raya susukan nanggela ,perumahan puri sentosa blok A.6'),
('20095','7202076404010000','SITI MAHMUDAH','1','2020-09-07','1',1,'P',7,7500000,'KOTA NAGAYA','2001-04-24','Islam','-'),
('20096','3671014210970000','SARAH ANGELINA','1','2020-09-04','1',1,'P',7,0,'JAKARTA','1997-10-02','Kristen','-'),
('20097','3525142802980000','Aminudin Rais Abdillah Bill Haq','1','2020-09-08','1',1,'L',7,0,'Gresik','1998-02-28','Islam','Jalan Raya Randuagung'),
('20098','3507145012010000','KEN ANDIEN JATI PRAMESWARI','1','2020-09-01','1',1,'P',7,0,'MALANG','2001-12-10','Islam','SIDODADI II'),
('20099','3510161710900000','R. Herdy Kurniawan Eka Putra','1','2020-09-01','1',1,'L',7,0,'SURABAYA','1990-10-17','Islam','Perum Mendut Hijau Regency BB.3 Banyuwangi'),
('20100','3578140803980000','Tri Cahyo Kurnianto','1','2020-09-01','1',1,'L',7,0,'Surabaya','1998-03-08','Islam','Jln Manukan Subur 1/17 Blok 32N'),
('20101','3515084104000000','Rizki Vika Wibian Anugrah','1','2020-09-01','1',1,'P',7,0,'Sidoarjo','2000-04-01','Islam','Werkudoro IV'),
('20102','3510072002840000','Sujud Durrohman','1','2020-09-01','1',1,'L',7,0,'Banyuwangi','1984-02-20','Islam','-'),
('20103','3524226807000000','Yulita Wahyuningtyas','1','2020-09-02','1',1,'P',7,0,'Lamongan','2000-07-28','Islam','Basuki Rahmad'),
('20104','3510164210790000','Eka Widy Astuti','1','2020-09-01','1',1,'P',7,0,'Banyuwangi','1979-10-02','Islam','Jalan Ikan Sepat No. 34'),
('20106','3274036105790010','Yosi Melani','1','2020-09-18','1',1,'P',7,0,'Cirebon','1979-05-21','Islam','Jl Nanas No 5 Bumi Kalijaga Permai Timur'),
('20107','3174050210990000','Muhamad Fahrul','1','2020-09-15','1',1,'L',7,0,'Jakarta','1999-10-02','Islam','Jl Jiban 2 No.18'),
('20108','3525102106920000','Eko Heri Safriyanto','1','2020-09-08','1',1,'L',7,0,'Kebumen','1992-06-21','Islam','-'),
('20109','6171054710910010','Dewi Rukmana','1','2020-09-25','1',1,'P',7,0,'Jakarta','1991-10-07','Katolik','-'),
('20110','3171070509990000','NAWWAF','1','2020-09-25','0',1,'L',7,0,'JAKARTA','1999-09-05','Islam','CIBEUREUM'),
('20112','3507205306000000','LOURA SILVIYANTI','1','2020-09-30','1',1,'P',7,0,'MALANG','2000-06-13','Islam','JL MELATI'),
('20113','3507016811980000','NOVIA GITA PRATIWI','1','2020-09-30','1',1,'P',7,0,'SURABAYA','1998-11-28','Islam','Jl Raya Pantai Ngliyep'),
('20114','3507134710930000','Okvitari Ayu Saputri','1','2020-09-30','1',1,'P',7,0,'Malang','1993-10-07','Islam','-'),
('20115','3523144402910000','PUJI SETIYO NINGRUM','1','2020-09-30','1',1,'P',7,0,'TUBAN','1991-02-04','Islam','Jl Pattimura'),
('20116','3471040809890000','Guntur Susilo Putra','1','2020-09-30','0',1,'L',7,0,'Manokwari','1989-09-08','Islam','Perum Permata Tegalsari Kav.54'),
('20117','3573042011980000','ABIT SUTOMO','1','2020-09-30','1',1,'L',7,0,'Malang','1998-11-20','Islam','JL. Raya Candi V / 599'),
('20118','3573042907970000','Jerry Leonard Legi','1','2020-09-30','0',1,'L',7,0,'Malang','1997-07-29','Kristen','Jl. Raya Kepuh 195'),
('20119','3273014512950000','VELYN HIDAYAT','1','2020-10-02','1',1,'P',7,0,'BANDUNG','1995-12-05','Kristen','-'),
('20120','3201046609000000','ANNISA HIDAYANTI NASUTION','1','2020-10-01','1',1,'P',7,0,'Depok','2000-09-26','Islam','jambudipa'),
('20121','3507204403940000','DIAH PARAMITA FITRIAWATI','1','2020-09-30','1',1,'P',7,0,'Malang','1994-03-14','Islam','-'),
('20122','3578021311990000','THOMAS ADI PRATAMA','1','2020-10-23','1',1,'L',7,0,'BENDUL MERISI BESAR SELATAN-45 S','1999-11-13','Islam','Bendul Merisi Besar Selatan 45'),
('20123','3603285805660000','Theresia Witnoe, SE','1','2020-09-04','1',2,'P',7,5000000,'TEGAL','1966-05-18','Kristen','Jl. Cemara Golf No. 61'),
('20124','3204461503970000','Muhammad Resha Bimantara Haryanto','1','2020-12-09','1',1,'L',7,0,'Bekasi','1997-03-15','Islam','Jl. Melati'),
('20125','1310012112610000','ALTI SOKKO DERYANTO','1','2020-09-07','1',2,'L',7,5000000,'TIKU','1961-12-19','Islam','Jorong Pasar Koto Baru'),
('20126','1806240607880000','DEDE SETIAWAN','1','2020-12-15','1',1,'L',7,0,'BANDUNG','1998-07-06','Islam','-'),
('20127','3201172912980000','TORI RAMDHANI','1','2020-12-22','1',1,'L',7,0,'Bogor','1998-12-29','Islam','Jl Babakan Raya'),
('20128','3171084605930000','SITI KHAERUNNISA','1','2020-12-23','1',1,'P',7,0,'JAKARTA','1993-05-06','Islam','Jl. Nusa Indah Raya Blok 40 No. 17 B');

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
(1,'Optometri','D3'),
(2,'Optometri','S1');

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
(1,'2017/2018',1,0),
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
(14,'2023/2024',2,1);

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
(1,3);

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `permissions` */

insert  into `permissions`(`id`,`name`,`display_name`,`description`,`status`,`parent_id`,`link`,`icon`,`sequence`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'dashboard','Dashboard','Dashboard\r\n',1,0,'dashboard','home',1,NULL,NULL,NULL),
(2,'master','Master','HEAD-MASTER\r\n',1,0,'#','books',3,NULL,NULL,NULL),
(3,'master-tahun_ajaran','Tahun Ajaran','SUB-MASTER',1,2,'master/tahun_ajaran',NULL,NULL,NULL,NULL,NULL),
(4,'master-prodi','Prodi','SUB-MASTER',1,2,NULL,NULL,NULL,NULL,NULL,NULL),
(5,'users','Manage Users','HEAD-USERS',1,0,'#','online-class',2,NULL,NULL,NULL),
(6,'users-mahasiswa','Mahasiswa','SUB-USERS',1,5,NULL,NULL,NULL,NULL,NULL,NULL),
(7,'users-dosen','Dosen','SUB-USERS',1,5,NULL,NULL,NULL,NULL,NULL,NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Data for the table `roles` */

insert  into `roles`(`id`,`name`,`display_name`,`description`,`status`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'admin','admin','admin',1,NULL,NULL,NULL),
(2,'mahasiswa','mahasiswa','mahasiswa',1,NULL,NULL,NULL),
(3,'dosen','dosen','dosen',1,NULL,NULL,NULL),
(4,'staff','staff','staff',1,NULL,NULL,NULL);

/*Table structure for table `roles_users` */

DROP TABLE IF EXISTS `roles_users`;

CREATE TABLE `roles_users` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `roles_users` */

insert  into `roles_users`(`user_id`,`role_id`) values 
(1,1);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `code` varchar(6) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`username`,`password`,`code`,`status`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'admin','admin','$2y$10$ZMQOPfEVLtMrp51j9i3JBeKeOrOXEbvK/XZ2NYx48QqdM766dJBB.','',1,NULL,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
