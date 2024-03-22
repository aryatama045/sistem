<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2023-11-16 13:37:52 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-11-16 13:37:52 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-11-16 13:37:57 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-11-16 13:37:57 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-11-16 13:37:58 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2023-11-16 13:37:58 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-11-16 13:37:58 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2023-11-16 13:40:23 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-11-16 13:40:23 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-11-16 13:40:28 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-11-16 13:40:28 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2023-11-16 13:40:28 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-11-16 13:40:35 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-11-16 13:40:36 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-11-16 13:40:36 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-11-16 13:40:54 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-11-16 13:46:05 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-11-16 13:46:05 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-11-16 13:46:05 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-11-16 13:46:09 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-11-16 13:46:10 --> Query error: Unknown column 'nik' in 'where clause' - Invalid query: SELECT * FROM(
			SELECT no_dok_cuti,no_dok_cuti no_dok_history,tgl_dok_cuti, i.nip, i.biodata_id, nama_lengkap, nama_dept, a.cuti_dispensasi_h_id as id_doc, p.file_1 as lam1, p.file_2 as lam2, p.file_3 as lam3, n.ket_status_absensi AS jn
			,CASE WHEN b.status_dokumen ='C' THEN 'APPROVED' ELSE 'REJECT' END catatan
			FROM hrd_all.trn_cuti_dispensasi_h a
			LEFT JOIN hrd_all.trn_posting b ON a.cuti_dispensasi_h_id = b.tdk_masuk_h_id
			LEFT JOIN hrd_all.trn_app_3rd r ON a.cuti_dispensasi_h_id = r.no_dok
			LEFT JOIN hrd_all.mst_biodata i ON a.biodata_id = i.biodata_id
			LEFT JOIN hrd_all.biodata_pekerjaan_d k ON i.biodata_id = k.biodata_id
			LEFT JOIN hrd_all.mst_dept m ON k.dept_id = m.dept_id
			LEFT JOIN hrd_all.trn_dokumen_ijin p ON a.no_dok_cuti = p.no_dok
			INNER JOIN hrd_all.mst_status_absensi n ON a.status_absensi_id = n.kode_status_absensi
			WHERE LEFT(no_dok_cuti,'4') = 'HRCD'
			AND YEAR(tgl_dok_cuti) >= '2021'
			AND (b.status_dokumen ='C' OR b.status_dokumen ='R' )
			AND IFNULL(r.no_dok,'')<>''
			AND (nik LIKE '%10071433%' OR nama_lengkap LIKE '%10071433%'  ) 
			AND k.kd_store IN ("SP_HO","OT_HO","OT_ME1","TOL_HO","TOL_JK","TOL_PL","TOL_SB","TOL_YG")
			UNION ALL
			SELECT
			no_dok_tdk_masuk, no_dok_tdk_masuk no_dok_history, tgl_dok_tdk_masuk,nip,i.biodata_id,nama_lengkap, nama_dept, a.tdk_masuk_h_id as id_doc, p.file_1 as lam1, p.file_2 as lam2, p.file_3 as lam3,'SAKIT SURAT KETERANGAN' AS jn
			,CASE WHEN b.status_dokumen ='C' THEN 'APPROVED' ELSE 'REJECT' END catatan
			FROM hrd_all.trn_tidak_masuk_h a
			LEFT JOIN hrd_all.trn_posting b ON a.tdk_masuk_h_id = b.tdk_masuk_h_id
			LEFT JOIN hrd_all.trn_app_3rd r ON a.tdk_masuk_h_id = r.no_dok
			LEFT JOIN hrd_all.mst_biodata i ON a.biodata_id = i.biodata_id
			LEFT JOIN hrd_all.biodata_pekerjaan_d k ON i.biodata_id = k.biodata_id
			LEFT JOIN hrd_all.mst_dept m ON k.dept_id = m.dept_id
			LEFT JOIN hrd_all.trn_dokumen_ijin p ON a.no_dok_tdk_masuk = p.no_dok
			WHERE status_absensi_id IN ('000000000009')
			AND (nik LIKE '%10071433%' OR nama_lengkap LIKE '%10071433%'  ) 
			AND k.kd_store IN ("SP_HO","OT_HO","OT_ME1","TOL_HO","TOL_JK","TOL_PL","TOL_SB","TOL_YG")
			AND YEAR(tgl_dok_tdk_masuk) >= '2021'
			AND (b.status_dokumen ='C' OR b.status_dokumen ='R' )
			AND IFNULL(r.no_dok,'')<>'') h
			
			GROUP BY no_dok_history
			ORDER BY tgl_dok_cuti DESC
			LIMIT 0, 10
		
ERROR - 2023-11-16 13:46:10 --> Severity: error --> Exception: Call to a member function result_array() on bool D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_ijin.php 1046
ERROR - 2023-11-16 13:46:14 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-11-16 13:46:14 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-11-16 13:46:14 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-11-16 13:46:14 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-11-16 13:46:14 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-11-16 13:46:18 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-11-16 13:46:18 --> Query error: Unknown column 'nik' in 'where clause' - Invalid query: SELECT * FROM(
			SELECT no_dok_cuti,no_dok_cuti no_dok_history,tgl_dok_cuti, i.nip, i.biodata_id, nama_lengkap, nama_dept, a.cuti_dispensasi_h_id as id_doc, p.file_1 as lam1, p.file_2 as lam2, p.file_3 as lam3, n.ket_status_absensi AS jn
			,CASE WHEN b.status_dokumen ='C' THEN 'APPROVED' ELSE 'REJECT' END catatan
			FROM hrd_all.trn_cuti_dispensasi_h a
			LEFT JOIN hrd_all.trn_posting b ON a.cuti_dispensasi_h_id = b.tdk_masuk_h_id
			LEFT JOIN hrd_all.trn_app_3rd r ON a.cuti_dispensasi_h_id = r.no_dok
			LEFT JOIN hrd_all.mst_biodata i ON a.biodata_id = i.biodata_id
			LEFT JOIN hrd_all.biodata_pekerjaan_d k ON i.biodata_id = k.biodata_id
			LEFT JOIN hrd_all.mst_dept m ON k.dept_id = m.dept_id
			LEFT JOIN hrd_all.trn_dokumen_ijin p ON a.no_dok_cuti = p.no_dok
			INNER JOIN hrd_all.mst_status_absensi n ON a.status_absensi_id = n.kode_status_absensi
			WHERE LEFT(no_dok_cuti,'4') = 'HRCD'
			AND YEAR(tgl_dok_cuti) >= '2021'
			AND (b.status_dokumen ='C' OR b.status_dokumen ='R' )
			AND IFNULL(r.no_dok,'')<>''
			AND (nik LIKE '%10071433%' OR nama_lengkap LIKE '%10071433%'  ) 
			AND k.kd_store IN ("SP_HO","OT_HO","OT_ME1","TOL_HO","TOL_JK","TOL_PL","TOL_SB","TOL_YG")
			UNION ALL
			SELECT
			no_dok_tdk_masuk, no_dok_tdk_masuk no_dok_history, tgl_dok_tdk_masuk,nip,i.biodata_id,nama_lengkap, nama_dept, a.tdk_masuk_h_id as id_doc, p.file_1 as lam1, p.file_2 as lam2, p.file_3 as lam3,'SAKIT SURAT KETERANGAN' AS jn
			,CASE WHEN b.status_dokumen ='C' THEN 'APPROVED' ELSE 'REJECT' END catatan
			FROM hrd_all.trn_tidak_masuk_h a
			LEFT JOIN hrd_all.trn_posting b ON a.tdk_masuk_h_id = b.tdk_masuk_h_id
			LEFT JOIN hrd_all.trn_app_3rd r ON a.tdk_masuk_h_id = r.no_dok
			LEFT JOIN hrd_all.mst_biodata i ON a.biodata_id = i.biodata_id
			LEFT JOIN hrd_all.biodata_pekerjaan_d k ON i.biodata_id = k.biodata_id
			LEFT JOIN hrd_all.mst_dept m ON k.dept_id = m.dept_id
			LEFT JOIN hrd_all.trn_dokumen_ijin p ON a.no_dok_tdk_masuk = p.no_dok
			WHERE status_absensi_id IN ('000000000009')
			AND (nik LIKE '%10071433%' OR nama_lengkap LIKE '%10071433%'  ) 
			AND k.kd_store IN ("SP_HO","OT_HO","OT_ME1","TOL_HO","TOL_JK","TOL_PL","TOL_SB","TOL_YG")
			AND YEAR(tgl_dok_tdk_masuk) >= '2021'
			AND (b.status_dokumen ='C' OR b.status_dokumen ='R' )
			AND IFNULL(r.no_dok,'')<>'') h
			
			GROUP BY no_dok_history
			ORDER BY tgl_dok_cuti DESC
			LIMIT 0, 10
		
ERROR - 2023-11-16 13:46:18 --> Severity: error --> Exception: Call to a member function result_array() on bool D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_ijin.php 1046
ERROR - 2023-11-16 13:46:35 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-11-16 13:46:36 --> Query error: Unknown column 'nik' in 'where clause' - Invalid query: SELECT * FROM(
			SELECT no_dok_cuti,no_dok_cuti no_dok_history,tgl_dok_cuti, i.nip, i.biodata_id, nama_lengkap, nama_dept, a.cuti_dispensasi_h_id as id_doc, p.file_1 as lam1, p.file_2 as lam2, p.file_3 as lam3, n.ket_status_absensi AS jn
			,CASE WHEN b.status_dokumen ='C' THEN 'APPROVED' ELSE 'REJECT' END catatan
			FROM hrd_all.trn_cuti_dispensasi_h a
			LEFT JOIN hrd_all.trn_posting b ON a.cuti_dispensasi_h_id = b.tdk_masuk_h_id
			LEFT JOIN hrd_all.trn_app_3rd r ON a.cuti_dispensasi_h_id = r.no_dok
			LEFT JOIN hrd_all.mst_biodata i ON a.biodata_id = i.biodata_id
			LEFT JOIN hrd_all.biodata_pekerjaan_d k ON i.biodata_id = k.biodata_id
			LEFT JOIN hrd_all.mst_dept m ON k.dept_id = m.dept_id
			LEFT JOIN hrd_all.trn_dokumen_ijin p ON a.no_dok_cuti = p.no_dok
			INNER JOIN hrd_all.mst_status_absensi n ON a.status_absensi_id = n.kode_status_absensi
			WHERE LEFT(no_dok_cuti,'4') = 'HRCD'
			AND YEAR(tgl_dok_cuti) >= '2021'
			AND (b.status_dokumen ='C' OR b.status_dokumen ='R' )
			AND IFNULL(r.no_dok,'')<>''
			AND (nik LIKE '%10071433%' OR nama_lengkap LIKE '%10071433%'  ) 
			AND k.kd_store IN ("SP_HO","OT_HO","OT_ME1","TOL_HO","TOL_JK","TOL_PL","TOL_SB","TOL_YG")
			UNION ALL
			SELECT
			no_dok_tdk_masuk, no_dok_tdk_masuk no_dok_history, tgl_dok_tdk_masuk,nip,i.biodata_id,nama_lengkap, nama_dept, a.tdk_masuk_h_id as id_doc, p.file_1 as lam1, p.file_2 as lam2, p.file_3 as lam3,'SAKIT SURAT KETERANGAN' AS jn
			,CASE WHEN b.status_dokumen ='C' THEN 'APPROVED' ELSE 'REJECT' END catatan
			FROM hrd_all.trn_tidak_masuk_h a
			LEFT JOIN hrd_all.trn_posting b ON a.tdk_masuk_h_id = b.tdk_masuk_h_id
			LEFT JOIN hrd_all.trn_app_3rd r ON a.tdk_masuk_h_id = r.no_dok
			LEFT JOIN hrd_all.mst_biodata i ON a.biodata_id = i.biodata_id
			LEFT JOIN hrd_all.biodata_pekerjaan_d k ON i.biodata_id = k.biodata_id
			LEFT JOIN hrd_all.mst_dept m ON k.dept_id = m.dept_id
			LEFT JOIN hrd_all.trn_dokumen_ijin p ON a.no_dok_tdk_masuk = p.no_dok
			WHERE status_absensi_id IN ('000000000009')
			AND (nik LIKE '%10071433%' OR nama_lengkap LIKE '%10071433%'  ) 
			AND k.kd_store IN ("SP_HO","OT_HO","OT_ME1","TOL_HO","TOL_JK","TOL_PL","TOL_SB","TOL_YG")
			AND YEAR(tgl_dok_tdk_masuk) >= '2021'
			AND (b.status_dokumen ='C' OR b.status_dokumen ='R' )
			AND IFNULL(r.no_dok,'')<>'') h
			
			GROUP BY no_dok_history
			ORDER BY tgl_dok_cuti DESC
			LIMIT 0, 10
		
ERROR - 2023-11-16 13:46:36 --> Severity: error --> Exception: Call to a member function result_array() on bool D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_ijin.php 1044
ERROR - 2023-11-16 13:47:15 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-11-16 13:47:15 --> Query error: Unknown column 'nik' in 'where clause' - Invalid query: SELECT * FROM(
			SELECT no_dok_cuti,no_dok_cuti no_dok_history,tgl_dok_cuti, i.nip, i.biodata_id, nama_lengkap, nama_dept, a.cuti_dispensasi_h_id as id_doc, p.file_1 as lam1, p.file_2 as lam2, p.file_3 as lam3, n.ket_status_absensi AS jn
			,CASE WHEN b.status_dokumen ='C' THEN 'APPROVED' ELSE 'REJECT' END catatan
			FROM hrd_all.trn_cuti_dispensasi_h a
			LEFT JOIN hrd_all.trn_posting b ON a.cuti_dispensasi_h_id = b.tdk_masuk_h_id
			LEFT JOIN hrd_all.trn_app_3rd r ON a.cuti_dispensasi_h_id = r.no_dok
			LEFT JOIN hrd_all.mst_biodata i ON a.biodata_id = i.biodata_id
			LEFT JOIN hrd_all.biodata_pekerjaan_d k ON i.biodata_id = k.biodata_id
			LEFT JOIN hrd_all.mst_dept m ON k.dept_id = m.dept_id
			LEFT JOIN hrd_all.trn_dokumen_ijin p ON a.no_dok_cuti = p.no_dok
			INNER JOIN hrd_all.mst_status_absensi n ON a.status_absensi_id = n.kode_status_absensi
			WHERE LEFT(no_dok_cuti,'4') = 'HRCD'
			AND YEAR(tgl_dok_cuti) >= '2021'
			AND (b.status_dokumen ='C' OR b.status_dokumen ='R' )
			AND IFNULL(r.no_dok,'')<>''
			AND nik LIKE '%10071433%' OR nama_lengkap LIKE '%10071433%'
			AND k.kd_store IN ("SP_HO","OT_HO","OT_ME1","TOL_HO","TOL_JK","TOL_PL","TOL_SB","TOL_YG")
			UNION ALL
			SELECT
			no_dok_tdk_masuk, no_dok_tdk_masuk no_dok_history, tgl_dok_tdk_masuk,nip,i.biodata_id,nama_lengkap, nama_dept, a.tdk_masuk_h_id as id_doc, p.file_1 as lam1, p.file_2 as lam2, p.file_3 as lam3,'SAKIT SURAT KETERANGAN' AS jn
			,CASE WHEN b.status_dokumen ='C' THEN 'APPROVED' ELSE 'REJECT' END catatan
			FROM hrd_all.trn_tidak_masuk_h a
			LEFT JOIN hrd_all.trn_posting b ON a.tdk_masuk_h_id = b.tdk_masuk_h_id
			LEFT JOIN hrd_all.trn_app_3rd r ON a.tdk_masuk_h_id = r.no_dok
			LEFT JOIN hrd_all.mst_biodata i ON a.biodata_id = i.biodata_id
			LEFT JOIN hrd_all.biodata_pekerjaan_d k ON i.biodata_id = k.biodata_id
			LEFT JOIN hrd_all.mst_dept m ON k.dept_id = m.dept_id
			LEFT JOIN hrd_all.trn_dokumen_ijin p ON a.no_dok_tdk_masuk = p.no_dok
			WHERE status_absensi_id IN ('000000000009')
			AND nik LIKE '%10071433%' OR nama_lengkap LIKE '%10071433%'
			AND k.kd_store IN ("SP_HO","OT_HO","OT_ME1","TOL_HO","TOL_JK","TOL_PL","TOL_SB","TOL_YG")
			AND YEAR(tgl_dok_tdk_masuk) >= '2021'
			AND (b.status_dokumen ='C' OR b.status_dokumen ='R' )
			AND IFNULL(r.no_dok,'')<>'') h
			
			GROUP BY no_dok_history
			ORDER BY tgl_dok_cuti DESC
			LIMIT 0, 10
		
ERROR - 2023-11-16 13:47:15 --> Severity: error --> Exception: Call to a member function result_array() on bool D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_ijin.php 1044
ERROR - 2023-11-16 13:48:06 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-11-16 13:48:28 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-11-16 13:48:29 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-11-16 13:48:29 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-11-16 13:48:29 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-11-16 13:48:29 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-11-16 13:48:29 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-11-16 13:48:29 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-11-16 13:48:29 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-11-16 13:48:38 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-11-16 13:48:44 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
