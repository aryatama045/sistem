<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2022-09-09 08:19:45 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 08:19:46 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 08:45:13 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 08:45:13 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-09-09 08:45:13 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 08:45:17 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 08:45:18 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 08:45:24 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 08:45:29 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 08:45:49 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 08:46:21 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 08:46:37 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 08:46:38 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 08:58:35 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 08:58:35 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 08:58:41 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 08:58:41 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-09-09 08:58:41 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 08:58:44 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 08:58:45 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 08:58:45 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:17:19 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:17:19 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:17:19 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:17:27 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:17:27 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:17:27 --> Severity: Notice --> Undefined variable: where D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_report.php 87
ERROR - 2022-09-09 09:17:27 --> Severity: Notice --> Undefined variable: where D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_report.php 106
ERROR - 2022-09-09 09:17:27 --> Severity: Notice --> Undefined variable: where D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_report.php 126
ERROR - 2022-09-09 09:17:27 --> Severity: Notice --> Undefined variable: where D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_report.php 150
ERROR - 2022-09-09 09:17:27 --> Severity: Notice --> Undefined variable: where D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_report.php 198
ERROR - 2022-09-09 09:17:27 --> Severity: Notice --> Undefined variable: search_no D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_report.php 199
ERROR - 2022-09-09 09:17:27 --> Severity: Notice --> Undefined variable: where D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_report.php 217
ERROR - 2022-09-09 09:17:27 --> Severity: Notice --> Undefined variable: where D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_report.php 237
ERROR - 2022-09-09 09:17:27 --> Severity: Notice --> Undefined variable: where D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_report.php 261
ERROR - 2022-09-09 09:17:27 --> Severity: Notice --> Undefined variable: start D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_report.php 269
ERROR - 2022-09-09 09:17:27 --> Severity: Notice --> Undefined variable: length D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_report.php 269
ERROR - 2022-09-09 09:17:27 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 66 - Invalid query: SELECT * FROM(
				SELECT * FROM(SELECT 'CUTI',no_dok_tdk_masuk, nip, nama_lengkap, b.tgl_tdk_masuk, j.nama_jabatan, e.nama_dept, f.nama_divisi, kd_store,
					CASE WHEN IFNULL(p.tgl_absensi, '')='' THEN 'SEDANG PROSES' ELSE 'FIXED' END status_absen
					FROM hrd_all.trn_tidak_masuk_h a
					LEFT JOIN hrd_all.trn_tidak_masuk_d b ON a.tdk_masuk_h_id=b.tdk_masuk_h_id
					LEFT JOIN hrd_all.trn_absensi p ON a.biodata_id=p.biodata_id AND b.tgl_tdk_masuk=p.tgl_absensi
					LEFT JOIN hrd_all.mst_biodata c ON a.biodata_id=c.biodata_id
					LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
					LEFT JOIN hrd_all.mst_dept e ON d.dept_id = e.dept_id
					LEFT JOIN hrd_all.mst_divisi f ON d.divisi_id = f.divisi_id
					LEFT JOIN hrd_all.trn_posting t ON a.tdk_masuk_h_id=t.tdk_masuk_h_id
					LEFT JOIN hrd_all.mst_jabatan j ON d.jabatan_id = j.jabatan_id
					WHERE b.tgl_tdk_masuk BETWEEN '2022-09-01' AND '2022-09-30'
					
					AND (b.is_batal =0 OR a.is_batal =0)
					AND (t.status_dokumen <> 'R' OR IFNULL(t.status_dokumen,'') = '')
				AND LEFT(a.no_dok_tdk_masuk,3)='HRC')a
			UNION ALL
				SELECT * FROM (SELECT 'IJIN',
					no_dok_tdk_masuk, nip, nama_lengkap, b.tgl_tdk_masuk, j.nama_jabatan, e.nama_dept, f.nama_divisi, kd_store,
					CASE WHEN t.status_dokumen='R' THEN 'REJECT'
					WHEN t.status_dokumen='O' THEN 'OPEN'
					WHEN t.status_dokumen='P' THEN 'SEDANG PROSES'
					ELSE 'FIXED' END status_absen
					FROM hrd_all.trn_tidak_masuk_h a
					LEFT JOIN hrd_all.trn_tidak_masuk_d b ON a.tdk_masuk_h_id=b.tdk_masuk_h_id
					LEFT JOIN hrd_all.mst_biodata c ON a.biodata_id=c.biodata_id
					LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
					LEFT JOIN hrd_all.mst_dept e ON d.dept_id = e.dept_id
					LEFT JOIN hrd_all.mst_divisi f ON d.divisi_id = f.divisi_id
					LEFT JOIN hrd_all.trn_posting t ON a.tdk_masuk_h_id=t.tdk_masuk_h_id
					LEFT JOIN hrd_all.mst_jabatan j ON d.jabatan_id = j.jabatan_id
					WHERE b.tgl_tdk_masuk BETWEEN '2022-09-01' AND '2022-09-30'
					
					AND (b.is_batal =0 OR a.is_batal =0)
					AND (t.status_dokumen <> 'R' OR IFNULL(t.status_dokumen,'') = '')
					AND (LEFT(a.no_dok_tdk_masuk,3)='HRI' AND a.status_absensi_id <>'000000000009')
					ORDER BY tgl_tdk_masuk ASC, c.nip ASC)a
			UNION ALL
				SELECT * FROM(SELECT 'SAKIT',no_dok_tdk_masuk, nip, nama_lengkap, b.tgl_tdk_masuk, j.nama_jabatan, e.nama_dept, f.nama_divisi, kd_store,
					CASE
					WHEN t.status_dokumen='R' THEN 'REJECT'
					WHEN t.status_dokumen='O' THEN 'OPEN'
					WHEN t.status_dokumen='P' THEN 'SEDANG PROSES'
					WHEN (t.status_dokumen='C') AND (IFNULL(r.no_dok,'')='') AND(IFNULL(r.pic_reject,'')='')  THEN 'SEDANG VERIFIKASI HRD'
					WHEN (t.status_dokumen='C') AND (IFNULL(r.no_dok,'')<>'') AND(IFNULL(r.pic_reject,'')<>'')  THEN 'REJECT VERIFIKASI HRD'
					ELSE 'FIXED' END status_absen
					FROM hrd_all.trn_tidak_masuk_h a
					LEFT JOIN hrd_all.trn_tidak_masuk_d b ON a.tdk_masuk_h_id=b.tdk_masuk_h_id
					LEFT JOIN hrd_all.mst_biodata c ON a.biodata_id=c.biodata_id
					LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
					LEFT JOIN hrd_all.mst_dept e ON d.dept_id = e.dept_id
					LEFT JOIN hrd_all.mst_divisi f ON d.divisi_id = f.divisi_id
					LEFT JOIN hrd_all.trn_posting t ON a.tdk_masuk_h_id=t.tdk_masuk_h_id
					LEFT JOIN hrd_all.mst_jabatan j ON d.jabatan_id = j.jabatan_id
					LEFT JOIN hrd_all.trn_app_3rd r ON a.tdk_masuk_h_id = r.no_dok
					WHERE b.tgl_tdk_masuk BETWEEN '2022-09-01' AND '2022-09-30'
					
					AND (b.is_batal = 0 OR a.is_batal =0)
					AND (t.status_dokumen <> 'R' OR IFNULL(t.status_dokumen,'') = '')
					AND (LEFT(a.no_dok_tdk_masuk,3)='HRI' AND a.status_absensi_id ='000000000009')
					ORDER BY tgl_tdk_masuk ASC, c.nip ASC
					)a
				)a
			ORDER BY tgl_tdk_masuk,nip
			LIMIT ,
ERROR - 2022-09-09 09:17:27 --> Severity: error --> Exception: Call to a member function num_rows() on bool D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_report.php 271
ERROR - 2022-09-09 09:17:27 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at D:\xampp\htdocs\hrd_cuti\system\core\Exceptions.php:272) D:\xampp\htdocs\hrd_cuti\system\core\Common.php 571
ERROR - 2022-09-09 09:17:31 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:17:31 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:17:31 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:17:31 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:17:31 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:17:33 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:17:34 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:17:34 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:17:34 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:17:34 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:17:34 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:17:34 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:17:36 --> Severity: Notice --> Undefined variable: where D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_report.php 87
ERROR - 2022-09-09 09:17:36 --> Severity: Notice --> Undefined variable: where D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_report.php 106
ERROR - 2022-09-09 09:17:36 --> Severity: Notice --> Undefined variable: where D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_report.php 126
ERROR - 2022-09-09 09:17:36 --> Severity: Notice --> Undefined variable: where D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_report.php 150
ERROR - 2022-09-09 09:17:36 --> Severity: Notice --> Undefined variable: where D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_report.php 198
ERROR - 2022-09-09 09:17:36 --> Severity: Notice --> Undefined variable: search_no D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_report.php 199
ERROR - 2022-09-09 09:17:36 --> Severity: Notice --> Undefined variable: where D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_report.php 217
ERROR - 2022-09-09 09:17:36 --> Severity: Notice --> Undefined variable: where D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_report.php 237
ERROR - 2022-09-09 09:17:36 --> Severity: Notice --> Undefined variable: where D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_report.php 261
ERROR - 2022-09-09 09:17:36 --> Severity: Notice --> Undefined variable: start D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_report.php 269
ERROR - 2022-09-09 09:17:36 --> Severity: Notice --> Undefined variable: length D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_report.php 269
ERROR - 2022-09-09 09:17:36 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 66 - Invalid query: SELECT * FROM(
				SELECT * FROM(SELECT 'CUTI',no_dok_tdk_masuk, nip, nama_lengkap, b.tgl_tdk_masuk, j.nama_jabatan, e.nama_dept, f.nama_divisi, kd_store,
					CASE WHEN IFNULL(p.tgl_absensi, '')='' THEN 'SEDANG PROSES' ELSE 'FIXED' END status_absen
					FROM hrd_all.trn_tidak_masuk_h a
					LEFT JOIN hrd_all.trn_tidak_masuk_d b ON a.tdk_masuk_h_id=b.tdk_masuk_h_id
					LEFT JOIN hrd_all.trn_absensi p ON a.biodata_id=p.biodata_id AND b.tgl_tdk_masuk=p.tgl_absensi
					LEFT JOIN hrd_all.mst_biodata c ON a.biodata_id=c.biodata_id
					LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
					LEFT JOIN hrd_all.mst_dept e ON d.dept_id = e.dept_id
					LEFT JOIN hrd_all.mst_divisi f ON d.divisi_id = f.divisi_id
					LEFT JOIN hrd_all.trn_posting t ON a.tdk_masuk_h_id=t.tdk_masuk_h_id
					LEFT JOIN hrd_all.mst_jabatan j ON d.jabatan_id = j.jabatan_id
					WHERE b.tgl_tdk_masuk BETWEEN '2022-09-01' AND '2022-09-30'
					
					AND (b.is_batal =0 OR a.is_batal =0)
					AND (t.status_dokumen <> 'R' OR IFNULL(t.status_dokumen,'') = '')
				AND LEFT(a.no_dok_tdk_masuk,3)='HRC')a
			UNION ALL
				SELECT * FROM (SELECT 'IJIN',
					no_dok_tdk_masuk, nip, nama_lengkap, b.tgl_tdk_masuk, j.nama_jabatan, e.nama_dept, f.nama_divisi, kd_store,
					CASE WHEN t.status_dokumen='R' THEN 'REJECT'
					WHEN t.status_dokumen='O' THEN 'OPEN'
					WHEN t.status_dokumen='P' THEN 'SEDANG PROSES'
					ELSE 'FIXED' END status_absen
					FROM hrd_all.trn_tidak_masuk_h a
					LEFT JOIN hrd_all.trn_tidak_masuk_d b ON a.tdk_masuk_h_id=b.tdk_masuk_h_id
					LEFT JOIN hrd_all.mst_biodata c ON a.biodata_id=c.biodata_id
					LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
					LEFT JOIN hrd_all.mst_dept e ON d.dept_id = e.dept_id
					LEFT JOIN hrd_all.mst_divisi f ON d.divisi_id = f.divisi_id
					LEFT JOIN hrd_all.trn_posting t ON a.tdk_masuk_h_id=t.tdk_masuk_h_id
					LEFT JOIN hrd_all.mst_jabatan j ON d.jabatan_id = j.jabatan_id
					WHERE b.tgl_tdk_masuk BETWEEN '2022-09-01' AND '2022-09-30'
					
					AND (b.is_batal =0 OR a.is_batal =0)
					AND (t.status_dokumen <> 'R' OR IFNULL(t.status_dokumen,'') = '')
					AND (LEFT(a.no_dok_tdk_masuk,3)='HRI' AND a.status_absensi_id <>'000000000009')
					ORDER BY tgl_tdk_masuk ASC, c.nip ASC)a
			UNION ALL
				SELECT * FROM(SELECT 'SAKIT',no_dok_tdk_masuk, nip, nama_lengkap, b.tgl_tdk_masuk, j.nama_jabatan, e.nama_dept, f.nama_divisi, kd_store,
					CASE
					WHEN t.status_dokumen='R' THEN 'REJECT'
					WHEN t.status_dokumen='O' THEN 'OPEN'
					WHEN t.status_dokumen='P' THEN 'SEDANG PROSES'
					WHEN (t.status_dokumen='C') AND (IFNULL(r.no_dok,'')='') AND(IFNULL(r.pic_reject,'')='')  THEN 'SEDANG VERIFIKASI HRD'
					WHEN (t.status_dokumen='C') AND (IFNULL(r.no_dok,'')<>'') AND(IFNULL(r.pic_reject,'')<>'')  THEN 'REJECT VERIFIKASI HRD'
					ELSE 'FIXED' END status_absen
					FROM hrd_all.trn_tidak_masuk_h a
					LEFT JOIN hrd_all.trn_tidak_masuk_d b ON a.tdk_masuk_h_id=b.tdk_masuk_h_id
					LEFT JOIN hrd_all.mst_biodata c ON a.biodata_id=c.biodata_id
					LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
					LEFT JOIN hrd_all.mst_dept e ON d.dept_id = e.dept_id
					LEFT JOIN hrd_all.mst_divisi f ON d.divisi_id = f.divisi_id
					LEFT JOIN hrd_all.trn_posting t ON a.tdk_masuk_h_id=t.tdk_masuk_h_id
					LEFT JOIN hrd_all.mst_jabatan j ON d.jabatan_id = j.jabatan_id
					LEFT JOIN hrd_all.trn_app_3rd r ON a.tdk_masuk_h_id = r.no_dok
					WHERE b.tgl_tdk_masuk BETWEEN '2022-09-01' AND '2022-09-30'
					
					AND (b.is_batal = 0 OR a.is_batal =0)
					AND (t.status_dokumen <> 'R' OR IFNULL(t.status_dokumen,'') = '')
					AND (LEFT(a.no_dok_tdk_masuk,3)='HRI' AND a.status_absensi_id ='000000000009')
					ORDER BY tgl_tdk_masuk ASC, c.nip ASC
					)a
				)a
			ORDER BY tgl_tdk_masuk,nip
			LIMIT ,
ERROR - 2022-09-09 09:17:36 --> Severity: error --> Exception: Call to a member function num_rows() on bool D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_report.php 271
ERROR - 2022-09-09 09:17:36 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at D:\xampp\htdocs\hrd_cuti\system\core\Exceptions.php:272) D:\xampp\htdocs\hrd_cuti\system\core\Common.php 571
ERROR - 2022-09-09 09:17:57 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:17:57 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:17:57 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:17:57 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:17:57 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:17:57 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:17:57 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:17:59 --> Severity: Notice --> Undefined variable: where D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_report.php 87
ERROR - 2022-09-09 09:17:59 --> Severity: Notice --> Undefined variable: where D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_report.php 106
ERROR - 2022-09-09 09:17:59 --> Severity: Notice --> Undefined variable: where D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_report.php 126
ERROR - 2022-09-09 09:17:59 --> Severity: Notice --> Undefined variable: where D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_report.php 150
ERROR - 2022-09-09 09:17:59 --> Severity: Notice --> Undefined variable: search_no D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_report.php 199
ERROR - 2022-09-09 09:17:59 --> Severity: Notice --> Undefined variable: start D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_report.php 269
ERROR - 2022-09-09 09:17:59 --> Severity: Notice --> Undefined variable: length D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_report.php 269
ERROR - 2022-09-09 09:17:59 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 66 - Invalid query: SELECT * FROM(
				SELECT * FROM(SELECT 'CUTI',no_dok_tdk_masuk, nip, nama_lengkap, b.tgl_tdk_masuk, j.nama_jabatan, e.nama_dept, f.nama_divisi, kd_store,
					CASE WHEN IFNULL(p.tgl_absensi, '')='' THEN 'SEDANG PROSES' ELSE 'FIXED' END status_absen
					FROM hrd_all.trn_tidak_masuk_h a
					LEFT JOIN hrd_all.trn_tidak_masuk_d b ON a.tdk_masuk_h_id=b.tdk_masuk_h_id
					LEFT JOIN hrd_all.trn_absensi p ON a.biodata_id=p.biodata_id AND b.tgl_tdk_masuk=p.tgl_absensi
					LEFT JOIN hrd_all.mst_biodata c ON a.biodata_id=c.biodata_id
					LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
					LEFT JOIN hrd_all.mst_dept e ON d.dept_id = e.dept_id
					LEFT JOIN hrd_all.mst_divisi f ON d.divisi_id = f.divisi_id
					LEFT JOIN hrd_all.trn_posting t ON a.tdk_masuk_h_id=t.tdk_masuk_h_id
					LEFT JOIN hrd_all.mst_jabatan j ON d.jabatan_id = j.jabatan_id
					WHERE b.tgl_tdk_masuk BETWEEN '2022-09-01' AND '2022-09-30'
					
					AND (b.is_batal =0 OR a.is_batal =0)
					AND (t.status_dokumen <> 'R' OR IFNULL(t.status_dokumen,'') = '')
				AND LEFT(a.no_dok_tdk_masuk,3)='HRC')a
			UNION ALL
				SELECT * FROM (SELECT 'IJIN',
					no_dok_tdk_masuk, nip, nama_lengkap, b.tgl_tdk_masuk, j.nama_jabatan, e.nama_dept, f.nama_divisi, kd_store,
					CASE WHEN t.status_dokumen='R' THEN 'REJECT'
					WHEN t.status_dokumen='O' THEN 'OPEN'
					WHEN t.status_dokumen='P' THEN 'SEDANG PROSES'
					ELSE 'FIXED' END status_absen
					FROM hrd_all.trn_tidak_masuk_h a
					LEFT JOIN hrd_all.trn_tidak_masuk_d b ON a.tdk_masuk_h_id=b.tdk_masuk_h_id
					LEFT JOIN hrd_all.mst_biodata c ON a.biodata_id=c.biodata_id
					LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
					LEFT JOIN hrd_all.mst_dept e ON d.dept_id = e.dept_id
					LEFT JOIN hrd_all.mst_divisi f ON d.divisi_id = f.divisi_id
					LEFT JOIN hrd_all.trn_posting t ON a.tdk_masuk_h_id=t.tdk_masuk_h_id
					LEFT JOIN hrd_all.mst_jabatan j ON d.jabatan_id = j.jabatan_id
					WHERE b.tgl_tdk_masuk BETWEEN '2022-09-01' AND '2022-09-30'
					
					AND (b.is_batal =0 OR a.is_batal =0)
					AND (t.status_dokumen <> 'R' OR IFNULL(t.status_dokumen,'') = '')
					AND (LEFT(a.no_dok_tdk_masuk,3)='HRI' AND a.status_absensi_id <>'000000000009')
					ORDER BY tgl_tdk_masuk ASC, c.nip ASC)a
			UNION ALL
				SELECT * FROM(SELECT 'SAKIT',no_dok_tdk_masuk, nip, nama_lengkap, b.tgl_tdk_masuk, j.nama_jabatan, e.nama_dept, f.nama_divisi, kd_store,
					CASE
					WHEN t.status_dokumen='R' THEN 'REJECT'
					WHEN t.status_dokumen='O' THEN 'OPEN'
					WHEN t.status_dokumen='P' THEN 'SEDANG PROSES'
					WHEN (t.status_dokumen='C') AND (IFNULL(r.no_dok,'')='') AND(IFNULL(r.pic_reject,'')='')  THEN 'SEDANG VERIFIKASI HRD'
					WHEN (t.status_dokumen='C') AND (IFNULL(r.no_dok,'')<>'') AND(IFNULL(r.pic_reject,'')<>'')  THEN 'REJECT VERIFIKASI HRD'
					ELSE 'FIXED' END status_absen
					FROM hrd_all.trn_tidak_masuk_h a
					LEFT JOIN hrd_all.trn_tidak_masuk_d b ON a.tdk_masuk_h_id=b.tdk_masuk_h_id
					LEFT JOIN hrd_all.mst_biodata c ON a.biodata_id=c.biodata_id
					LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
					LEFT JOIN hrd_all.mst_dept e ON d.dept_id = e.dept_id
					LEFT JOIN hrd_all.mst_divisi f ON d.divisi_id = f.divisi_id
					LEFT JOIN hrd_all.trn_posting t ON a.tdk_masuk_h_id=t.tdk_masuk_h_id
					LEFT JOIN hrd_all.mst_jabatan j ON d.jabatan_id = j.jabatan_id
					LEFT JOIN hrd_all.trn_app_3rd r ON a.tdk_masuk_h_id = r.no_dok
					WHERE b.tgl_tdk_masuk BETWEEN '2022-09-01' AND '2022-09-30'
					
					AND (b.is_batal = 0 OR a.is_batal =0)
					AND (t.status_dokumen <> 'R' OR IFNULL(t.status_dokumen,'') = '')
					AND (LEFT(a.no_dok_tdk_masuk,3)='HRI' AND a.status_absensi_id ='000000000009')
					ORDER BY tgl_tdk_masuk ASC, c.nip ASC
					)a
				)a
			ORDER BY tgl_tdk_masuk,nip
			LIMIT ,
ERROR - 2022-09-09 09:17:59 --> Severity: error --> Exception: Call to a member function num_rows() on bool D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_report.php 271
ERROR - 2022-09-09 09:17:59 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at D:\xampp\htdocs\hrd_cuti\system\core\Exceptions.php:272) D:\xampp\htdocs\hrd_cuti\system\core\Common.php 571
ERROR - 2022-09-09 09:18:15 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:18:16 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:18:16 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:18:16 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:18:16 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:18:16 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:18:16 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:18:17 --> Severity: Notice --> Undefined variable: search_no D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_report.php 199
ERROR - 2022-09-09 09:18:17 --> Severity: Notice --> Undefined variable: start D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_report.php 269
ERROR - 2022-09-09 09:18:17 --> Severity: Notice --> Undefined variable: length D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_report.php 269
ERROR - 2022-09-09 09:18:17 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 66 - Invalid query: SELECT * FROM(
				SELECT * FROM(SELECT 'CUTI',no_dok_tdk_masuk, nip, nama_lengkap, b.tgl_tdk_masuk, j.nama_jabatan, e.nama_dept, f.nama_divisi, kd_store,
					CASE WHEN IFNULL(p.tgl_absensi, '')='' THEN 'SEDANG PROSES' ELSE 'FIXED' END status_absen
					FROM hrd_all.trn_tidak_masuk_h a
					LEFT JOIN hrd_all.trn_tidak_masuk_d b ON a.tdk_masuk_h_id=b.tdk_masuk_h_id
					LEFT JOIN hrd_all.trn_absensi p ON a.biodata_id=p.biodata_id AND b.tgl_tdk_masuk=p.tgl_absensi
					LEFT JOIN hrd_all.mst_biodata c ON a.biodata_id=c.biodata_id
					LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
					LEFT JOIN hrd_all.mst_dept e ON d.dept_id = e.dept_id
					LEFT JOIN hrd_all.mst_divisi f ON d.divisi_id = f.divisi_id
					LEFT JOIN hrd_all.trn_posting t ON a.tdk_masuk_h_id=t.tdk_masuk_h_id
					LEFT JOIN hrd_all.mst_jabatan j ON d.jabatan_id = j.jabatan_id
					WHERE b.tgl_tdk_masuk BETWEEN '2022-09-01' AND '2022-09-30'
					
					AND (b.is_batal =0 OR a.is_batal =0)
					AND (t.status_dokumen <> 'R' OR IFNULL(t.status_dokumen,'') = '')
				AND LEFT(a.no_dok_tdk_masuk,3)='HRC')a
			UNION ALL
				SELECT * FROM (SELECT 'IJIN',
					no_dok_tdk_masuk, nip, nama_lengkap, b.tgl_tdk_masuk, j.nama_jabatan, e.nama_dept, f.nama_divisi, kd_store,
					CASE WHEN t.status_dokumen='R' THEN 'REJECT'
					WHEN t.status_dokumen='O' THEN 'OPEN'
					WHEN t.status_dokumen='P' THEN 'SEDANG PROSES'
					ELSE 'FIXED' END status_absen
					FROM hrd_all.trn_tidak_masuk_h a
					LEFT JOIN hrd_all.trn_tidak_masuk_d b ON a.tdk_masuk_h_id=b.tdk_masuk_h_id
					LEFT JOIN hrd_all.mst_biodata c ON a.biodata_id=c.biodata_id
					LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
					LEFT JOIN hrd_all.mst_dept e ON d.dept_id = e.dept_id
					LEFT JOIN hrd_all.mst_divisi f ON d.divisi_id = f.divisi_id
					LEFT JOIN hrd_all.trn_posting t ON a.tdk_masuk_h_id=t.tdk_masuk_h_id
					LEFT JOIN hrd_all.mst_jabatan j ON d.jabatan_id = j.jabatan_id
					WHERE b.tgl_tdk_masuk BETWEEN '2022-09-01' AND '2022-09-30'
					
					AND (b.is_batal =0 OR a.is_batal =0)
					AND (t.status_dokumen <> 'R' OR IFNULL(t.status_dokumen,'') = '')
					AND (LEFT(a.no_dok_tdk_masuk,3)='HRI' AND a.status_absensi_id <>'000000000009')
					ORDER BY tgl_tdk_masuk ASC, c.nip ASC)a
			UNION ALL
				SELECT * FROM(SELECT 'SAKIT',no_dok_tdk_masuk, nip, nama_lengkap, b.tgl_tdk_masuk, j.nama_jabatan, e.nama_dept, f.nama_divisi, kd_store,
					CASE
					WHEN t.status_dokumen='R' THEN 'REJECT'
					WHEN t.status_dokumen='O' THEN 'OPEN'
					WHEN t.status_dokumen='P' THEN 'SEDANG PROSES'
					WHEN (t.status_dokumen='C') AND (IFNULL(r.no_dok,'')='') AND(IFNULL(r.pic_reject,'')='')  THEN 'SEDANG VERIFIKASI HRD'
					WHEN (t.status_dokumen='C') AND (IFNULL(r.no_dok,'')<>'') AND(IFNULL(r.pic_reject,'')<>'')  THEN 'REJECT VERIFIKASI HRD'
					ELSE 'FIXED' END status_absen
					FROM hrd_all.trn_tidak_masuk_h a
					LEFT JOIN hrd_all.trn_tidak_masuk_d b ON a.tdk_masuk_h_id=b.tdk_masuk_h_id
					LEFT JOIN hrd_all.mst_biodata c ON a.biodata_id=c.biodata_id
					LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
					LEFT JOIN hrd_all.mst_dept e ON d.dept_id = e.dept_id
					LEFT JOIN hrd_all.mst_divisi f ON d.divisi_id = f.divisi_id
					LEFT JOIN hrd_all.trn_posting t ON a.tdk_masuk_h_id=t.tdk_masuk_h_id
					LEFT JOIN hrd_all.mst_jabatan j ON d.jabatan_id = j.jabatan_id
					LEFT JOIN hrd_all.trn_app_3rd r ON a.tdk_masuk_h_id = r.no_dok
					WHERE b.tgl_tdk_masuk BETWEEN '2022-09-01' AND '2022-09-30'
					
					AND (b.is_batal = 0 OR a.is_batal =0)
					AND (t.status_dokumen <> 'R' OR IFNULL(t.status_dokumen,'') = '')
					AND (LEFT(a.no_dok_tdk_masuk,3)='HRI' AND a.status_absensi_id ='000000000009')
					ORDER BY tgl_tdk_masuk ASC, c.nip ASC
					)a
				)a
			ORDER BY tgl_tdk_masuk,nip
			LIMIT ,
ERROR - 2022-09-09 09:18:17 --> Severity: error --> Exception: Call to a member function num_rows() on bool D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_report.php 271
ERROR - 2022-09-09 09:18:44 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:18:45 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:18:45 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:18:45 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:18:45 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:18:45 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:18:45 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:18:47 --> Severity: Notice --> Undefined variable: search_no D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_report.php 199
ERROR - 2022-09-09 09:18:47 --> Severity: Notice --> Undefined variable: start D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_report.php 269
ERROR - 2022-09-09 09:18:47 --> Severity: Notice --> Undefined variable: length D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_report.php 269
ERROR - 2022-09-09 09:18:47 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 66 - Invalid query: SELECT * FROM(
				SELECT * FROM(SELECT 'CUTI',no_dok_tdk_masuk, nip, nama_lengkap, b.tgl_tdk_masuk, j.nama_jabatan, e.nama_dept, f.nama_divisi, kd_store,
					CASE WHEN IFNULL(p.tgl_absensi, '')='' THEN 'SEDANG PROSES' ELSE 'FIXED' END status_absen
					FROM hrd_all.trn_tidak_masuk_h a
					LEFT JOIN hrd_all.trn_tidak_masuk_d b ON a.tdk_masuk_h_id=b.tdk_masuk_h_id
					LEFT JOIN hrd_all.trn_absensi p ON a.biodata_id=p.biodata_id AND b.tgl_tdk_masuk=p.tgl_absensi
					LEFT JOIN hrd_all.mst_biodata c ON a.biodata_id=c.biodata_id
					LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
					LEFT JOIN hrd_all.mst_dept e ON d.dept_id = e.dept_id
					LEFT JOIN hrd_all.mst_divisi f ON d.divisi_id = f.divisi_id
					LEFT JOIN hrd_all.trn_posting t ON a.tdk_masuk_h_id=t.tdk_masuk_h_id
					LEFT JOIN hrd_all.mst_jabatan j ON d.jabatan_id = j.jabatan_id
					WHERE b.tgl_tdk_masuk BETWEEN '2022-09-01' AND '2022-09-30'
					
					AND (b.is_batal =0 OR a.is_batal =0)
					AND (t.status_dokumen <> 'R' OR IFNULL(t.status_dokumen,'') = '')
				AND LEFT(a.no_dok_tdk_masuk,3)='HRC')a
			UNION ALL
				SELECT * FROM (SELECT 'IJIN',
					no_dok_tdk_masuk, nip, nama_lengkap, b.tgl_tdk_masuk, j.nama_jabatan, e.nama_dept, f.nama_divisi, kd_store,
					CASE WHEN t.status_dokumen='R' THEN 'REJECT'
					WHEN t.status_dokumen='O' THEN 'OPEN'
					WHEN t.status_dokumen='P' THEN 'SEDANG PROSES'
					ELSE 'FIXED' END status_absen
					FROM hrd_all.trn_tidak_masuk_h a
					LEFT JOIN hrd_all.trn_tidak_masuk_d b ON a.tdk_masuk_h_id=b.tdk_masuk_h_id
					LEFT JOIN hrd_all.mst_biodata c ON a.biodata_id=c.biodata_id
					LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
					LEFT JOIN hrd_all.mst_dept e ON d.dept_id = e.dept_id
					LEFT JOIN hrd_all.mst_divisi f ON d.divisi_id = f.divisi_id
					LEFT JOIN hrd_all.trn_posting t ON a.tdk_masuk_h_id=t.tdk_masuk_h_id
					LEFT JOIN hrd_all.mst_jabatan j ON d.jabatan_id = j.jabatan_id
					WHERE b.tgl_tdk_masuk BETWEEN '2022-09-01' AND '2022-09-30'
					
					AND (b.is_batal =0 OR a.is_batal =0)
					AND (t.status_dokumen <> 'R' OR IFNULL(t.status_dokumen,'') = '')
					AND (LEFT(a.no_dok_tdk_masuk,3)='HRI' AND a.status_absensi_id <>'000000000009')
					ORDER BY tgl_tdk_masuk ASC, c.nip ASC)a
			UNION ALL
				SELECT * FROM(SELECT 'SAKIT',no_dok_tdk_masuk, nip, nama_lengkap, b.tgl_tdk_masuk, j.nama_jabatan, e.nama_dept, f.nama_divisi, kd_store,
					CASE
					WHEN t.status_dokumen='R' THEN 'REJECT'
					WHEN t.status_dokumen='O' THEN 'OPEN'
					WHEN t.status_dokumen='P' THEN 'SEDANG PROSES'
					WHEN (t.status_dokumen='C') AND (IFNULL(r.no_dok,'')='') AND(IFNULL(r.pic_reject,'')='')  THEN 'SEDANG VERIFIKASI HRD'
					WHEN (t.status_dokumen='C') AND (IFNULL(r.no_dok,'')<>'') AND(IFNULL(r.pic_reject,'')<>'')  THEN 'REJECT VERIFIKASI HRD'
					ELSE 'FIXED' END status_absen
					FROM hrd_all.trn_tidak_masuk_h a
					LEFT JOIN hrd_all.trn_tidak_masuk_d b ON a.tdk_masuk_h_id=b.tdk_masuk_h_id
					LEFT JOIN hrd_all.mst_biodata c ON a.biodata_id=c.biodata_id
					LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
					LEFT JOIN hrd_all.mst_dept e ON d.dept_id = e.dept_id
					LEFT JOIN hrd_all.mst_divisi f ON d.divisi_id = f.divisi_id
					LEFT JOIN hrd_all.trn_posting t ON a.tdk_masuk_h_id=t.tdk_masuk_h_id
					LEFT JOIN hrd_all.mst_jabatan j ON d.jabatan_id = j.jabatan_id
					LEFT JOIN hrd_all.trn_app_3rd r ON a.tdk_masuk_h_id = r.no_dok
					WHERE b.tgl_tdk_masuk BETWEEN '2022-09-01' AND '2022-09-30'
					
					AND (b.is_batal = 0 OR a.is_batal =0)
					AND (t.status_dokumen <> 'R' OR IFNULL(t.status_dokumen,'') = '')
					AND (LEFT(a.no_dok_tdk_masuk,3)='HRI' AND a.status_absensi_id ='000000000009')
					ORDER BY tgl_tdk_masuk ASC, c.nip ASC
					)a
				)a
			ORDER BY tgl_tdk_masuk,nip
			LIMIT ,
ERROR - 2022-09-09 09:18:47 --> Severity: error --> Exception: Call to a member function num_rows() on bool D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_report.php 271
ERROR - 2022-09-09 09:19:25 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:19:25 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:19:25 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:19:25 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:19:25 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:19:25 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:19:25 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:19:27 --> Severity: error --> Exception: Too few arguments to function Model_report::getJumlahDataAbsen(), 5 passed in D:\xampp\htdocs\hrd_cuti\application\modules\leaves\controllers\Report.php on line 122 and exactly 6 expected D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_report.php 196
ERROR - 2022-09-09 09:20:08 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:20:09 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:20:09 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:20:09 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:20:09 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:20:09 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:20:09 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:20:11 --> Severity: Notice --> Undefined variable: start D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_report.php 269
ERROR - 2022-09-09 09:20:11 --> Severity: Notice --> Undefined variable: length D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_report.php 269
ERROR - 2022-09-09 09:20:11 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 66 - Invalid query: SELECT * FROM(
				SELECT * FROM(SELECT 'CUTI',no_dok_tdk_masuk, nip, nama_lengkap, b.tgl_tdk_masuk, j.nama_jabatan, e.nama_dept, f.nama_divisi, kd_store,
					CASE WHEN IFNULL(p.tgl_absensi, '')='' THEN 'SEDANG PROSES' ELSE 'FIXED' END status_absen
					FROM hrd_all.trn_tidak_masuk_h a
					LEFT JOIN hrd_all.trn_tidak_masuk_d b ON a.tdk_masuk_h_id=b.tdk_masuk_h_id
					LEFT JOIN hrd_all.trn_absensi p ON a.biodata_id=p.biodata_id AND b.tgl_tdk_masuk=p.tgl_absensi
					LEFT JOIN hrd_all.mst_biodata c ON a.biodata_id=c.biodata_id
					LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
					LEFT JOIN hrd_all.mst_dept e ON d.dept_id = e.dept_id
					LEFT JOIN hrd_all.mst_divisi f ON d.divisi_id = f.divisi_id
					LEFT JOIN hrd_all.trn_posting t ON a.tdk_masuk_h_id=t.tdk_masuk_h_id
					LEFT JOIN hrd_all.mst_jabatan j ON d.jabatan_id = j.jabatan_id
					WHERE b.tgl_tdk_masuk BETWEEN '2022-09-01' AND '2022-09-30'
					
					AND (b.is_batal =0 OR a.is_batal =0)
					AND (t.status_dokumen <> 'R' OR IFNULL(t.status_dokumen,'') = '')
				AND LEFT(a.no_dok_tdk_masuk,3)='HRC')a
			UNION ALL
				SELECT * FROM (SELECT 'IJIN',
					no_dok_tdk_masuk, nip, nama_lengkap, b.tgl_tdk_masuk, j.nama_jabatan, e.nama_dept, f.nama_divisi, kd_store,
					CASE WHEN t.status_dokumen='R' THEN 'REJECT'
					WHEN t.status_dokumen='O' THEN 'OPEN'
					WHEN t.status_dokumen='P' THEN 'SEDANG PROSES'
					ELSE 'FIXED' END status_absen
					FROM hrd_all.trn_tidak_masuk_h a
					LEFT JOIN hrd_all.trn_tidak_masuk_d b ON a.tdk_masuk_h_id=b.tdk_masuk_h_id
					LEFT JOIN hrd_all.mst_biodata c ON a.biodata_id=c.biodata_id
					LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
					LEFT JOIN hrd_all.mst_dept e ON d.dept_id = e.dept_id
					LEFT JOIN hrd_all.mst_divisi f ON d.divisi_id = f.divisi_id
					LEFT JOIN hrd_all.trn_posting t ON a.tdk_masuk_h_id=t.tdk_masuk_h_id
					LEFT JOIN hrd_all.mst_jabatan j ON d.jabatan_id = j.jabatan_id
					WHERE b.tgl_tdk_masuk BETWEEN '2022-09-01' AND '2022-09-30'
					
					AND (b.is_batal =0 OR a.is_batal =0)
					AND (t.status_dokumen <> 'R' OR IFNULL(t.status_dokumen,'') = '')
					AND (LEFT(a.no_dok_tdk_masuk,3)='HRI' AND a.status_absensi_id <>'000000000009')
					ORDER BY tgl_tdk_masuk ASC, c.nip ASC)a
			UNION ALL
				SELECT * FROM(SELECT 'SAKIT',no_dok_tdk_masuk, nip, nama_lengkap, b.tgl_tdk_masuk, j.nama_jabatan, e.nama_dept, f.nama_divisi, kd_store,
					CASE
					WHEN t.status_dokumen='R' THEN 'REJECT'
					WHEN t.status_dokumen='O' THEN 'OPEN'
					WHEN t.status_dokumen='P' THEN 'SEDANG PROSES'
					WHEN (t.status_dokumen='C') AND (IFNULL(r.no_dok,'')='') AND(IFNULL(r.pic_reject,'')='')  THEN 'SEDANG VERIFIKASI HRD'
					WHEN (t.status_dokumen='C') AND (IFNULL(r.no_dok,'')<>'') AND(IFNULL(r.pic_reject,'')<>'')  THEN 'REJECT VERIFIKASI HRD'
					ELSE 'FIXED' END status_absen
					FROM hrd_all.trn_tidak_masuk_h a
					LEFT JOIN hrd_all.trn_tidak_masuk_d b ON a.tdk_masuk_h_id=b.tdk_masuk_h_id
					LEFT JOIN hrd_all.mst_biodata c ON a.biodata_id=c.biodata_id
					LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
					LEFT JOIN hrd_all.mst_dept e ON d.dept_id = e.dept_id
					LEFT JOIN hrd_all.mst_divisi f ON d.divisi_id = f.divisi_id
					LEFT JOIN hrd_all.trn_posting t ON a.tdk_masuk_h_id=t.tdk_masuk_h_id
					LEFT JOIN hrd_all.mst_jabatan j ON d.jabatan_id = j.jabatan_id
					LEFT JOIN hrd_all.trn_app_3rd r ON a.tdk_masuk_h_id = r.no_dok
					WHERE b.tgl_tdk_masuk BETWEEN '2022-09-01' AND '2022-09-30'
					
					AND (b.is_batal = 0 OR a.is_batal =0)
					AND (t.status_dokumen <> 'R' OR IFNULL(t.status_dokumen,'') = '')
					AND (LEFT(a.no_dok_tdk_masuk,3)='HRI' AND a.status_absensi_id ='000000000009')
					ORDER BY tgl_tdk_masuk ASC, c.nip ASC
					)a
				)a
			ORDER BY tgl_tdk_masuk,nip
			LIMIT ,
ERROR - 2022-09-09 09:20:11 --> Severity: error --> Exception: Call to a member function num_rows() on bool D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_report.php 271
ERROR - 2022-09-09 09:20:30 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:20:30 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:20:31 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:20:31 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:20:31 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:20:31 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:20:31 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:20:39 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:20:42 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:20:48 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:22:48 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:22:48 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:22:48 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:22:48 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:22:48 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:22:48 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:22:48 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:22:57 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:22:57 --> Severity: Notice --> Undefined index: cuti D:\xampp\htdocs\hrd_cuti\application\modules\leaves\controllers\Report.php 139
ERROR - 2022-09-09 09:22:57 --> Severity: Notice --> Undefined index: cuti D:\xampp\htdocs\hrd_cuti\application\modules\leaves\controllers\Report.php 139
ERROR - 2022-09-09 09:22:57 --> Severity: Notice --> Undefined index: cuti D:\xampp\htdocs\hrd_cuti\application\modules\leaves\controllers\Report.php 139
ERROR - 2022-09-09 09:22:57 --> Severity: Notice --> Undefined index: cuti D:\xampp\htdocs\hrd_cuti\application\modules\leaves\controllers\Report.php 139
ERROR - 2022-09-09 09:22:57 --> Severity: Notice --> Undefined index: cuti D:\xampp\htdocs\hrd_cuti\application\modules\leaves\controllers\Report.php 139
ERROR - 2022-09-09 09:22:57 --> Severity: Notice --> Undefined index: cuti D:\xampp\htdocs\hrd_cuti\application\modules\leaves\controllers\Report.php 139
ERROR - 2022-09-09 09:22:57 --> Severity: Notice --> Undefined index: cuti D:\xampp\htdocs\hrd_cuti\application\modules\leaves\controllers\Report.php 139
ERROR - 2022-09-09 09:22:57 --> Severity: Notice --> Undefined index: cuti D:\xampp\htdocs\hrd_cuti\application\modules\leaves\controllers\Report.php 139
ERROR - 2022-09-09 09:22:57 --> Severity: Notice --> Undefined index: cuti D:\xampp\htdocs\hrd_cuti\application\modules\leaves\controllers\Report.php 139
ERROR - 2022-09-09 09:22:57 --> Severity: Notice --> Undefined index: cuti D:\xampp\htdocs\hrd_cuti\application\modules\leaves\controllers\Report.php 139
ERROR - 2022-09-09 09:24:34 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:24:34 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:24:35 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:24:35 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:24:35 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:24:35 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:24:35 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:24:41 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:30:48 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:30:57 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:30:59 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:31:00 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:31:13 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:31:18 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:31:29 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:31:31 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:31:41 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:31:50 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:57:05 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:57:05 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:57:10 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 09:57:10 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-09-09 10:34:19 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 10:34:19 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-09-09 10:34:19 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 10:34:22 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 10:34:23 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 10:34:24 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 10:34:24 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 10:34:33 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 10:34:36 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 10:34:40 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 10:34:40 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-09-09 10:34:40 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 10:34:56 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 10:34:57 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 10:35:26 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 10:35:26 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-09-09 10:35:28 --> Language file contains no data: language/indonesian/email_lang.php
ERROR - 2022-09-09 10:35:28 --> Language file contains no data: language/indonesian/email_lang.php
ERROR - 2022-09-09 10:35:28 --> Language file contains no data: language/indonesian/email_lang.php
ERROR - 2022-09-09 10:35:28 --> Could not find the language line "email_sent"
ERROR - 2022-09-09 10:35:28 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 10:35:28 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 10:49:52 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 10:49:53 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 10:50:06 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 10:50:11 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 10:50:14 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 10:50:15 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-09-09 10:50:15 --> Language file contains no data: language/indonesian/email_lang.php
ERROR - 2022-09-09 10:50:15 --> Language file contains no data: language/indonesian/email_lang.php
ERROR - 2022-09-09 10:50:15 --> Language file contains no data: language/indonesian/email_lang.php
ERROR - 2022-09-09 10:50:15 --> Could not find the language line "email_sent"
ERROR - 2022-09-09 10:50:15 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 10:50:16 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 10:50:35 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 10:50:35 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 10:50:48 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 10:50:49 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 10:50:52 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 10:50:55 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 10:51:01 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 10:52:16 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 10:52:16 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-09-09 10:53:19 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 10:53:19 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-09-09 10:53:20 --> Language file contains no data: language/indonesian/email_lang.php
ERROR - 2022-09-09 10:53:20 --> Language file contains no data: language/indonesian/email_lang.php
ERROR - 2022-09-09 10:53:20 --> Language file contains no data: language/indonesian/email_lang.php
ERROR - 2022-09-09 10:53:20 --> Could not find the language line "email_sent"
ERROR - 2022-09-09 10:53:20 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 10:53:21 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 10:54:22 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 10:54:23 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 10:54:33 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 10:54:35 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 10:54:40 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 10:54:40 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-09-09 10:54:40 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 10:54:40 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 10:59:32 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 10:59:36 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 10:59:40 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 10:59:40 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-09-09 10:59:40 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 10:59:40 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 11:18:48 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 11:18:49 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 11:18:53 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 11:18:54 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 11:18:55 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 11:18:55 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-09-09 11:18:56 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:13:31 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:13:31 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:13:32 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:13:32 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-09-09 14:13:32 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:15:41 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:15:41 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:15:42 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:15:43 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:15:56 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:15:57 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:15:59 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:15:59 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-09-09 14:15:59 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:15:59 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:16:24 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:16:24 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:16:25 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:16:25 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-09-09 14:17:25 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:17:25 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-09-09 14:17:54 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:17:55 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-09-09 14:17:57 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:17:57 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-09-09 14:18:11 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:18:11 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-09-09 14:18:11 --> Severity: Notice --> Undefined variable: kdstore D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_ijin.php 178
ERROR - 2022-09-09 14:18:25 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:18:25 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-09-09 14:18:58 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:18:59 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-09-09 14:19:30 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:19:30 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-09-09 14:23:13 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:23:14 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-09-09 14:23:41 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:23:41 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-09-09 14:23:41 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:23:41 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:25:09 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:25:09 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:25:12 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:25:12 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:25:15 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:25:15 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:27:23 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:27:23 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:27:24 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:27:25 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:27:35 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:27:37 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:27:44 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:27:44 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-09-09 14:27:44 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:27:45 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:28:34 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:28:35 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:28:37 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:28:37 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-09-09 14:28:51 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:28:51 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-09-09 14:36:17 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:36:18 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:36:24 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:36:24 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:36:28 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:36:28 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-09-09 14:36:28 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:36:32 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:36:33 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:36:34 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:36:34 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:38:02 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:38:03 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:38:12 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:38:14 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:38:16 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:38:17 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:38:20 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:38:36 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:38:37 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:38:38 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:38:39 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:38:44 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:38:44 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-09-09 14:38:59 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:38:59 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-09-09 14:39:00 --> Language file contains no data: language/indonesian/email_lang.php
ERROR - 2022-09-09 14:39:00 --> Language file contains no data: language/indonesian/email_lang.php
ERROR - 2022-09-09 14:39:00 --> Language file contains no data: language/indonesian/email_lang.php
ERROR - 2022-09-09 14:39:00 --> Could not find the language line "email_sent"
ERROR - 2022-09-09 14:39:00 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:39:00 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:39:25 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:39:25 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:39:53 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:39:54 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:39:59 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:39:59 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-09-09 14:40:22 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:40:22 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-09-09 14:40:42 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:40:43 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-09-09 14:42:03 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:42:03 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-09-09 14:42:21 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:42:21 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-09-09 14:42:48 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:42:48 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-09-09 14:42:57 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:42:58 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-09-09 14:43:06 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:43:06 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-09-09 14:43:25 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:43:25 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-09-09 14:51:11 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:51:11 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:51:37 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:51:41 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:52:02 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:52:03 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:52:14 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:52:19 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:52:25 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 14:52:25 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-09-09 15:35:17 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 15:35:17 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-09-09 15:35:17 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 15:35:17 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 16:32:26 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 16:32:27 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 16:53:09 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-09-09 16:53:20 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
