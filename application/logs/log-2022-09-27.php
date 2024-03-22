<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2022-09-27 08:39:55 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 08:39:56 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 08:39:59 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 08:39:59 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-09-27 08:39:59 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 08:51:27 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 08:51:27 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 08:51:32 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 08:52:55 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 08:53:14 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 08:53:47 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 09:10:54 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 09:11:13 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 09:11:27 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 09:14:02 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 11:44:59 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 11:44:59 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 11:45:06 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 11:45:06 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-09-27 11:45:07 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 11:45:10 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 11:45:10 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 11:45:10 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 11:45:18 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 11:45:18 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 11:45:18 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 11:45:18 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 11:45:18 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 11:45:21 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 11:45:21 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 11:45:22 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 11:45:22 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 11:45:22 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 11:45:22 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 11:45:22 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 11:45:22 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 11:45:28 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 11:45:28 --> Severity: Notice --> Undefined index: draw D:\xampp\htdocs\hrd_cuti\application\modules\leaves\controllers\Ijin.php 614
ERROR - 2022-09-27 11:45:28 --> Severity: Notice --> Undefined index: length D:\xampp\htdocs\hrd_cuti\application\modules\leaves\controllers\Ijin.php 615
ERROR - 2022-09-27 11:45:28 --> Severity: Notice --> Undefined index: start D:\xampp\htdocs\hrd_cuti\application\modules\leaves\controllers\Ijin.php 616
ERROR - 2022-09-27 11:45:28 --> Severity: Notice --> Undefined index: order D:\xampp\htdocs\hrd_cuti\application\modules\leaves\controllers\Ijin.php 617
ERROR - 2022-09-27 11:45:28 --> Severity: Notice --> Undefined index: order D:\xampp\htdocs\hrd_cuti\application\modules\leaves\controllers\Ijin.php 618
ERROR - 2022-09-27 11:45:28 --> Severity: Notice --> Undefined index: columns D:\xampp\htdocs\hrd_cuti\application\modules\leaves\controllers\Ijin.php 619
ERROR - 2022-09-27 11:45:28 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 29 - Invalid query: SELECT * FROM (
				SELECT
				no_dok_tdk_masuk, tgl_dok_tdk_masuk,nip,nama_lengkap, nama_dept, a.tdk_masuk_h_id,"IJIN" AS jn
				FROM hrd_all.trn_tidak_masuk_h a
				LEFT JOIN hrd_all.trn_posting b ON a.tdk_masuk_h_id = b.tdk_masuk_h_id
				LEFT JOIN hrd_all.trn_app_3rd r ON a.tdk_masuk_h_id = r.no_dok
				LEFT JOIN hrd_all.mst_biodata i ON a.biodata_id = i.biodata_id
				LEFT JOIN hrd_all.biodata_pekerjaan_d k ON i.biodata_id = k.biodata_id
				LEFT JOIN hrd_all.mst_dept m ON k.dept_id = m.dept_id
				WHERE status_absensi_id IN ("000000000009")
				AND YEAR(tgl_dok_tdk_masuk) >= 2021
				AND b.status_dokumen ="C"
				AND IFNULL(r.no_dok,"")=""
				AND k.kd_store IN ("SP_HO","OT_HO","TOL_HO","TOL_JK","TOL_PL","TOL_SB","TOL_YG")
				UNION ALL
				SELECT no_dok_cuti,tgl_dok_cuti, i.nip, nama_lengkap, nama_dept, a.cuti_dispensasi_h_id,"CUTI DISPENSASI" as jn
				FROM hrd_all.trn_cuti_dispensasi_h a
				LEFT JOIN hrd_all.trn_posting b ON a.cuti_dispensasi_h_id = b.tdk_masuk_h_id
				LEFT JOIN hrd_all.trn_app_3rd r ON a.cuti_dispensasi_h_id = r.no_dok
				LEFT JOIN hrd_all.mst_biodata i ON a.biodata_id = i.biodata_id
				LEFT JOIN hrd_all.biodata_pekerjaan_d k ON i.biodata_id = k.biodata_id
				LEFT JOIN hrd_all.mst_dept m ON k.dept_id = m.dept_id
				WHERE LEFT(no_dok_cuti,4) = "HRCD"
				AND YEAR(tgl_dok_cuti) >= 2021
				AND b.status_dokumen ="C"
				AND IFNULL(r.no_dok,"")=""
				AND k.kd_store IN ("SP_HO","OT_HO","TOL_HO","TOL_JK","TOL_PL","TOL_SB","TOL_YG")) h
				order by tgl_dok_tdk_masuk DESC
				limit ,
			
ERROR - 2022-09-27 11:45:28 --> Severity: error --> Exception: Call to a member function result_array() on bool D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_ijin.php 915
ERROR - 2022-09-27 11:46:09 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 11:46:09 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 11:46:09 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 11:46:09 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 11:46:09 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 11:46:09 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 11:46:09 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 11:46:09 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 14:00:01 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 14:00:01 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 14:00:01 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 14:00:02 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 14:00:05 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 14:00:05 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-09-27 14:00:05 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 14:00:06 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 14:00:06 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 14:00:06 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 14:00:06 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 14:00:06 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 14:00:11 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 14:00:11 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 14:00:11 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 14:00:11 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 14:00:17 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 14:00:17 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-09-27 14:00:17 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 14:00:17 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 14:00:18 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 14:00:18 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 14:00:18 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 14:00:18 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 14:00:21 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 14:00:22 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 14:00:22 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 14:00:22 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 14:00:22 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 14:00:22 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 14:00:22 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 14:00:25 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 14:00:25 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 14:00:25 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 14:00:25 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 14:00:25 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 14:00:25 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 14:46:26 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 14:46:27 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 14:46:27 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 14:46:27 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 14:46:27 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 14:46:27 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 15:08:59 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 15:08:59 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 15:09:21 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 15:09:21 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 15:09:21 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 15:09:21 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 15:16:56 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 15:16:56 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 15:17:18 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 15:17:18 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 15:17:18 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 15:17:18 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 15:32:12 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 15:32:13 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 15:32:35 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 15:32:35 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 15:32:35 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-27 15:32:35 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
