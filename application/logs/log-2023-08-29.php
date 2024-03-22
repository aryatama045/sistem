<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2023-08-29 07:28:58 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 07:28:59 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 07:28:59 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 07:29:04 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 07:29:05 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2023-08-29 07:29:05 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 07:29:08 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 07:29:09 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 07:29:09 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 07:29:13 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 07:50:34 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 07:50:35 --> Query error: Unknown column 'a.status_absensi_id' in 'on clause' - Invalid query: SELECT * FROM(
            SELECT
            CASE WHEN LEFT(no_dok_tdk_masuk,3)='HRI' THEN 'IJIN' ELSE 'CUTI' END jenis,
            nip,nama_lengkap,no_dok_tdk_masuk, a.tdk_masuk_h_id, tgl_dok_tdk_masuk,  a.keterangan, c.status_dokumen, e.biodata_id,
            f.ket_status_absensi status_absensi
            FROM hrd_all.trn_tidak_masuk_h a
            LEFT JOIN hrd_all.trn_posting c ON a.tdk_masuk_h_id = c.tdk_masuk_h_id
            LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
            LEFT JOIN hrd_all.mst_biodata e ON d.biodata_id = e.biodata_id
            LEFT JOIN hrd_all.mst_status_absensi f ON a.status_absensi_id = f.status_absensi_id
            WHERE c.status_dokumen IN('P','C')
            -- AND is_posting = 0
            AND kd_store IN ("SP_HO","OT_HO","OT_ME1","TOL_HO","TOL_JK","TOL_PL","TOL_SB","TOL_YG","TOL_BD","TOL_MD","TOL_ML","TOL_PK","TOL_SM")
            AND IFNULL(a.pic_edit,'')='' AND YEAR(tgl_dok_tdk_masuk)>='2023'
            UNION ALL
            SELECT
            'CUTI DISPENSASI',
            nip,nama_lengkap,no_dok_cuti no_dok_tdk_masuk,cuti_dispensasi_h_id tdk_masuk_h_id,tgl_dok_cuti tgl_dok_tdk_masuk,  a.keterangan
            , c.status_dokumen, e.biodata_id,f.ket_status_absensi status_absensi
            FROM hrd_all.trn_cuti_dispensasi_h a
            LEFT JOIN hrd_all.trn_posting c ON a.cuti_dispensasi_h_id = c.tdk_masuk_h_id
            LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
            LEFT JOIN hrd_all.mst_biodata e ON d.biodata_id = e.biodata_id
            LEFT JOIN hrd_all.mst_status_absensi f ON a.status_absensi_id = f.status_absensi_id
            WHERE c.status_dokumen IN('P','C')
            -- AND is_posting =0
            AND kd_store IN ("SP_HO","OT_HO","OT_ME1","TOL_HO","TOL_JK","TOL_PL","TOL_SB","TOL_YG","TOL_BD","TOL_MD","TOL_ML","TOL_PK","TOL_SM")
            AND IFNULL(a.pic_edit,'')='' AND YEAR(tgl_dok_cuti)>='2023'
            UNION ALL
            SELECT
            'CUTI PENGGANTI',
            a.nip,e.nama_lengkap,a.no_doc no_dok_tdk_masuk,a.no_doc tdk_masuk_h_id,tgl_doc tgl_dok_tdk_masuk, a.keterangan, c.status_dokumen, e.biodata_id
            ,f.ket_status_absensi status_absensi
            FROM hrd_all.trn_pengajuan_cuti_tambahan a
            LEFT JOIN hrd_all.trn_posting c ON a.no_doc = c.tdk_masuk_h_id
            LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.pic_input = d.biodata_id
            LEFT JOIN hrd_all.mst_biodata e ON d.biodata_id = e.biodata_id
            LEFT JOIN hrd_all.mst_status_absensi f ON a.status_absensi_id = f.status_absensi_id
            WHERE c.status_dokumen IN('P','C')
            AND IFNULL(a.is_ditolak,'')=''
            -- AND IFNULL(a.is_hrd,'')=''
            AND IFNULL(a.tgl_tolak,'')=''
            AND kd_store IN ("SP_HO","OT_HO","OT_ME1","TOL_HO","TOL_JK","TOL_PL","TOL_SB","TOL_YG","TOL_BD","TOL_MD","TOL_ML","TOL_PK","TOL_SM")
            AND YEAR(a.tgl_doc)>='2023'
            )a
            WHERE  a.no_dok_tdk_masuk = 'HRC23080012'
            
ERROR - 2023-08-29 07:50:35 --> Severity: error --> Exception: Call to a member function row_array() on bool D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_batal.php 211
ERROR - 2023-08-29 07:53:42 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 07:53:42 --> Query error: The used SELECT statements have a different number of columns - Invalid query: SELECT * FROM(
            SELECT
            CASE WHEN LEFT(no_dok_tdk_masuk,3)='HRI' THEN 'IJIN' ELSE 'CUTI' END jenis,
            nip,nama_lengkap,no_dok_tdk_masuk, a.tdk_masuk_h_id, tgl_dok_tdk_masuk,  a.keterangan, c.status_dokumen, e.biodata_id,
            f.ket_status_absensi status_absensi
            FROM hrd_all.trn_tidak_masuk_h a
            LEFT JOIN hrd_all.trn_posting c ON a.tdk_masuk_h_id = c.tdk_masuk_h_id
            LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
            LEFT JOIN hrd_all.mst_biodata e ON d.biodata_id = e.biodata_id
            LEFT JOIN hrd_all.mst_status_absensi f ON a.status_absensi_id = f.status_absensi_id
            WHERE c.status_dokumen IN('P','C')
            -- AND is_posting = 0
            AND kd_store IN ("SP_HO","OT_HO","OT_ME1","TOL_HO","TOL_JK","TOL_PL","TOL_SB","TOL_YG","TOL_BD","TOL_MD","TOL_ML","TOL_PK","TOL_SM")
            AND IFNULL(a.pic_edit,'')='' AND YEAR(tgl_dok_tdk_masuk)>='2023'
            UNION ALL
            SELECT
            'CUTI DISPENSASI',
            nip,nama_lengkap,no_dok_cuti no_dok_tdk_masuk,cuti_dispensasi_h_id tdk_masuk_h_id,tgl_dok_cuti tgl_dok_tdk_masuk,  a.keterangan
            , c.status_dokumen, e.biodata_id,f.ket_status_absensi status_absensi
            FROM hrd_all.trn_cuti_dispensasi_h a
            LEFT JOIN hrd_all.trn_posting c ON a.cuti_dispensasi_h_id = c.tdk_masuk_h_id
            LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
            LEFT JOIN hrd_all.mst_biodata e ON d.biodata_id = e.biodata_id
            LEFT JOIN hrd_all.mst_status_absensi f ON a.status_absensi_id = f.status_absensi_id
            WHERE c.status_dokumen IN('P','C')
            -- AND is_posting =0
            AND kd_store IN ("SP_HO","OT_HO","OT_ME1","TOL_HO","TOL_JK","TOL_PL","TOL_SB","TOL_YG","TOL_BD","TOL_MD","TOL_ML","TOL_PK","TOL_SM")
            AND IFNULL(a.pic_edit,'')='' AND YEAR(tgl_dok_cuti)>='2023'
            UNION ALL
            SELECT
            'CUTI PENGGANTI',
            a.nip,e.nama_lengkap,a.no_doc no_dok_tdk_masuk,a.no_doc tdk_masuk_h_id,tgl_doc tgl_dok_tdk_masuk, a.keterangan, c.status_dokumen, e.biodata_id

            FROM hrd_all.trn_pengajuan_cuti_tambahan a
            LEFT JOIN hrd_all.trn_posting c ON a.no_doc = c.tdk_masuk_h_id
            LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.pic_input = d.biodata_id
            LEFT JOIN hrd_all.mst_biodata e ON d.biodata_id = e.biodata_id
            WHERE c.status_dokumen IN('P','C')
            AND IFNULL(a.is_ditolak,'')=''
            -- AND IFNULL(a.is_hrd,'')=''
            AND IFNULL(a.tgl_tolak,'')=''
            AND kd_store IN ("SP_HO","OT_HO","OT_ME1","TOL_HO","TOL_JK","TOL_PL","TOL_SB","TOL_YG","TOL_BD","TOL_MD","TOL_ML","TOL_PK","TOL_SM")
            AND YEAR(a.tgl_doc)>='2023'
            )a
            WHERE  a.no_dok_tdk_masuk = 'HRC23080012'
            
ERROR - 2023-08-29 07:53:42 --> Severity: error --> Exception: Call to a member function row_array() on bool D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_batal.php 210
ERROR - 2023-08-29 07:53:58 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 07:53:58 --> Query error: The used SELECT statements have a different number of columns - Invalid query: SELECT * FROM(
            SELECT
            CASE WHEN LEFT(no_dok_tdk_masuk,3)='HRI' THEN 'IJIN' ELSE 'CUTI' END jenis,
            nip,nama_lengkap,no_dok_tdk_masuk, a.tdk_masuk_h_id, tgl_dok_tdk_masuk,  a.keterangan, c.status_dokumen, e.biodata_id,
            f.ket_status_absensi status_absensi
            FROM hrd_all.trn_tidak_masuk_h a
            LEFT JOIN hrd_all.trn_posting c ON a.tdk_masuk_h_id = c.tdk_masuk_h_id
            LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
            LEFT JOIN hrd_all.mst_biodata e ON d.biodata_id = e.biodata_id
            LEFT JOIN hrd_all.mst_status_absensi f ON a.status_absensi_id = f.status_absensi_id
            WHERE c.status_dokumen IN('P','C')
            -- AND is_posting = 0
            AND kd_store IN ("SP_HO","OT_HO","OT_ME1","TOL_HO","TOL_JK","TOL_PL","TOL_SB","TOL_YG","TOL_BD","TOL_MD","TOL_ML","TOL_PK","TOL_SM")
            AND IFNULL(a.pic_edit,'')='' AND YEAR(tgl_dok_tdk_masuk)>='2023'
            UNION ALL
            SELECT
            'CUTI DISPENSASI',
            nip,nama_lengkap,no_dok_cuti no_dok_tdk_masuk,cuti_dispensasi_h_id tdk_masuk_h_id,tgl_dok_cuti tgl_dok_tdk_masuk,  a.keterangan
            , c.status_dokumen, e.biodata_id,f.ket_status_absensi status_absensi
            FROM hrd_all.trn_cuti_dispensasi_h a
            LEFT JOIN hrd_all.trn_posting c ON a.cuti_dispensasi_h_id = c.tdk_masuk_h_id
            LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
            LEFT JOIN hrd_all.mst_biodata e ON d.biodata_id = e.biodata_id
            LEFT JOIN hrd_all.mst_status_absensi f ON a.status_absensi_id = f.status_absensi_id
            WHERE c.status_dokumen IN('P','C')
            -- AND is_posting =0
            AND kd_store IN ("SP_HO","OT_HO","OT_ME1","TOL_HO","TOL_JK","TOL_PL","TOL_SB","TOL_YG","TOL_BD","TOL_MD","TOL_ML","TOL_PK","TOL_SM")
            AND IFNULL(a.pic_edit,'')='' AND YEAR(tgl_dok_cuti)>='2023'
            UNION ALL
            SELECT
            'CUTI PENGGANTI',
            a.nip,e.nama_lengkap,a.no_doc no_dok_tdk_masuk,a.no_doc tdk_masuk_h_id,tgl_doc tgl_dok_tdk_masuk, a.keterangan, c.status_dokumen, e.biodata_id

            FROM hrd_all.trn_pengajuan_cuti_tambahan a
            LEFT JOIN hrd_all.trn_posting c ON a.no_doc = c.tdk_masuk_h_id
            LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.pic_input = d.biodata_id
            LEFT JOIN hrd_all.mst_biodata e ON d.biodata_id = e.biodata_id
            WHERE c.status_dokumen IN('P','C')
            AND IFNULL(a.is_ditolak,'')=''
            -- AND IFNULL(a.is_hrd,'')=''
            AND IFNULL(a.tgl_tolak,'')=''
            AND kd_store IN ("SP_HO","OT_HO","OT_ME1","TOL_HO","TOL_JK","TOL_PL","TOL_SB","TOL_YG","TOL_BD","TOL_MD","TOL_ML","TOL_PK","TOL_SM")
            AND YEAR(a.tgl_doc)>='2023'
            )a
            WHERE  a.no_dok_tdk_masuk = 'HRC23080012'
            
ERROR - 2023-08-29 07:55:41 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 07:55:47 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 07:55:48 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 07:55:48 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 07:55:50 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 07:55:54 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 07:55:55 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 07:55:55 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 07:56:00 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 07:56:07 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 07:56:07 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 07:56:07 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 07:56:12 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 07:56:21 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 07:56:21 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 07:56:21 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 07:56:27 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 07:59:06 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 07:59:18 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 07:59:19 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 07:59:19 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 07:59:22 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 07:59:46 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 07:59:56 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:00:01 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:00:01 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:00:01 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:00:04 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:00:08 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:00:09 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:00:09 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:00:12 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:00:53 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:00:53 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:00:53 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:00:55 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:00:58 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:01:11 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:01:11 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:01:11 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:01:15 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:01:17 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:28:19 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:28:20 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:28:20 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:33:54 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:33:56 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:33:57 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:33:57 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:33:59 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:34:03 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:34:03 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:34:03 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:34:06 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:35:46 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:36:37 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:36:40 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:36:40 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:36:40 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:36:44 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:37:06 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:37:07 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:37:07 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:37:09 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:37:46 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:37:46 --> Query error: The used SELECT statements have a different number of columns - Invalid query: SELECT * FROM(
            SELECT
            CASE WHEN LEFT(no_dok_tdk_masuk,3)='HRI' THEN 'IJIN' ELSE 'CUTI' END jenis,
            nip,nama_lengkap,no_dok_tdk_masuk, a.tdk_masuk_h_id, tgl_dok_tdk_masuk,  a.keterangan, c.status_dokumen, e.biodata_id,
            f.ket_status_absensi status_absensi, a.potong_cuti_dari
            FROM hrd_all.trn_tidak_masuk_h a
            LEFT JOIN hrd_all.trn_posting c ON a.tdk_masuk_h_id = c.tdk_masuk_h_id
            LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
            LEFT JOIN hrd_all.mst_biodata e ON d.biodata_id = e.biodata_id
            LEFT JOIN hrd_all.mst_status_absensi f ON a.status_absensi_id = f.status_absensi_id
            WHERE c.status_dokumen IN('P','C')
            -- AND is_posting = 0
            AND kd_store IN ("SP_HO","OT_HO","OT_ME1","TOL_HO","TOL_JK","TOL_PL","TOL_SB","TOL_YG","TOL_BD","TOL_MD","TOL_ML","TOL_PK","TOL_SM")
            AND IFNULL(a.pic_edit,'')='' AND YEAR(tgl_dok_tdk_masuk)>='2023'
            UNION ALL
            SELECT
            'CUTI DISPENSASI',
            nip,nama_lengkap,no_dok_cuti no_dok_tdk_masuk,cuti_dispensasi_h_id tdk_masuk_h_id,tgl_dok_cuti tgl_dok_tdk_masuk,  a.keterangan
            , c.status_dokumen, e.biodata_id,f.ket_status_absensi status_absensi
            FROM hrd_all.trn_cuti_dispensasi_h a
            LEFT JOIN hrd_all.trn_posting c ON a.cuti_dispensasi_h_id = c.tdk_masuk_h_id
            LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
            LEFT JOIN hrd_all.mst_biodata e ON d.biodata_id = e.biodata_id
            LEFT JOIN hrd_all.mst_status_absensi f ON a.kode_status_absensi = f.kode_status_absensi
            WHERE c.status_dokumen IN('P','C')
            -- AND is_posting =0
            AND kd_store IN ("SP_HO","OT_HO","OT_ME1","TOL_HO","TOL_JK","TOL_PL","TOL_SB","TOL_YG","TOL_BD","TOL_MD","TOL_ML","TOL_PK","TOL_SM")
            AND IFNULL(a.pic_edit,'')='' AND YEAR(tgl_dok_cuti)>='2023'
            UNION ALL
            SELECT
            'CUTI PENGGANTI',
            a.nip,e.nama_lengkap,a.no_doc no_dok_tdk_masuk,a.no_doc tdk_masuk_h_id,tgl_doc tgl_dok_tdk_masuk,
            a.keterangan, c.status_dokumen, e.biodata_id, NULL status_absensi
            FROM hrd_all.trn_pengajuan_cuti_tambahan a
            LEFT JOIN hrd_all.trn_posting c ON a.no_doc = c.tdk_masuk_h_id
            LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.pic_input = d.biodata_id
            LEFT JOIN hrd_all.mst_biodata e ON d.biodata_id = e.biodata_id
            WHERE c.status_dokumen IN('P','C')
            AND IFNULL(a.is_ditolak,'')=''
            -- AND IFNULL(a.is_hrd,'')=''
            AND IFNULL(a.tgl_tolak,'')=''
            AND kd_store IN ("SP_HO","OT_HO","OT_ME1","TOL_HO","TOL_JK","TOL_PL","TOL_SB","TOL_YG","TOL_BD","TOL_MD","TOL_ML","TOL_PK","TOL_SM")
            AND YEAR(a.tgl_doc)>='2023'
            )a
            WHERE  a.no_dok_tdk_masuk = 'HRC23080014'
            
ERROR - 2023-08-29 08:37:46 --> Severity: error --> Exception: Call to a member function row_array() on bool D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_batal.php 210
ERROR - 2023-08-29 08:38:25 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:38:43 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:38:44 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:38:44 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:38:46 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:39:04 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:39:05 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:39:05 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:39:08 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:39:12 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:39:12 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:39:12 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 08:39:14 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2023-08-29 11:30:53 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
