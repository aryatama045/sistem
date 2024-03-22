<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2022-06-02 08:21:51 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:21:52 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:21:52 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:21:52 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:22:00 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:22:00 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-06-02 08:22:00 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:22:01 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:22:01 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:22:01 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:22:01 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:22:01 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:22:06 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:22:06 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:22:07 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:22:07 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:22:09 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:22:10 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-06-02 08:22:10 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:22:10 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:22:10 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:22:10 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:22:10 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:22:10 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:22:16 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:22:16 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:22:16 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:22:16 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:22:16 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:22:16 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:22:16 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:22:18 --> Query error: Table 'gl_mim.mst_jenis_request' doesn't exist - Invalid query: SELECT h.request_h_id ,	h.no_request , h.tgl_request ,	h.jenis ,
                    CASE h.jenis
                    WHEN 'PUM' THEN h.jenis
                    WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
                    ELSE mjr.nama_dokumen
                    END nama_dokumen,
                CASE h.jenis
                WHEN 'PUM' THEN
                        (SELECT h1.tgl_berangkat
                                FROM gl_mim.trn_request_h h1
                                WHERE h1.no_request = h.no_um
                                AND h1.jenis = 'UMPD'
                        )
                WHEN 'UMPD' THEN h.tgl_berangkat
                END tgl_berangkat ,
                CASE h.jenis
                WHEN 'PUM' THEN
                        (SELECT h1.tgl_pulang
                                FROM gl_mim.trn_request_h h1
                                WHERE h1.no_request = h.no_um
                                AND h1.jenis = 'UMPD'
                        )
                WHEN 'UMPD' THEN h.tgl_pulang
                END tgl_pulang ,
                h.no_um ,
                h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
                h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
                h.kode_divisi_req ,
                h.total_biaya ,	h.total_um ,	h.selisih ,
                h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
                h.keterangan , h.wkt_input,
                h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
                h.is_kas ,h.reimburse ,h.referenced , h.is_pum
                FROM gl_mim.trn_request_h h
                INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
                INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
                WHERE dept.kode_dept_induk = 'ACCT'
                AND h.jenis IN ('KLAIM','UM','UMPD')
                AND h.is_dept   = 0
                AND h.is_kas    = 0
                AND h.is_reject = 0
                UNION ALL
                SELECT
                h.request_h_id ,	h.no_request ,
                h.tgl_request ,	h.jenis ,
                    CASE h.jenis
                    WHEN 'PUM' THEN h.jenis
                    WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
                    ELSE mjr.nama_dokumen
                    END nama_dokumen,
                um.tgl_berangkat ,	um.tgl_pulang ,
                CONCAT(h.no_um,' (PD)') no_um,
                h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
                h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
                h.kode_divisi_req ,
                h.total_biaya ,	h.total_um ,	h.selisih ,
                h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
                h.keterangan ,  h.wkt_input,
                h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
                h.is_kas ,h.reimburse ,h.referenced , h.is_pum
                FROM gl_mim.trn_request_h h
                INNER JOIN (
                SELECT um.no_request,um.jenis,um.kode_dept_req ,
                        um.tgl_berangkat,um.tgl_pulang
                FROM gl_mim.trn_request_h um
                WHERE um.jenis = 'UMPD'
                AND um.referenced = 1
                AND um.is_reject = 0
                AND um.is_approve = 1
                ) um ON um.no_request = h.no_um
                INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
                INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
                WHERE h.jenis = 'PUM'
                AND dept.kode_dept_induk = 'ACCT'
                AND h.is_validasi_ga = 1
                AND h.is_dept   = 0
                AND h.is_kas    = 0
                AND h.is_reject = 0
                UNION ALL
                SELECT
                h.request_h_id ,	h.no_request ,
                h.tgl_request ,	h.jenis ,
                    CASE h.jenis
                    WHEN 'PUM' THEN h.jenis
                    WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
                    ELSE mjr.nama_dokumen
                    END nama_dokumen,
                CASE h.jenis
                WHEN 'PUM' THEN
                        (SELECT h1.tgl_berangkat
                                FROM gl_mim.trn_request_h h1
                                WHERE h1.no_request = h.no_um
                                AND h1.jenis ='UMPD'
                        )
                END tgl_berangkat ,
                CASE h.jenis
                WHEN 'PUM' THEN
                        (SELECT h1.tgl_pulang
                                FROM gl_mim.trn_request_h h1
                                WHERE h1.no_request = h.no_um
                                AND h1.jenis ='UMPD'
                        )
                END tgl_pulang ,
                CONCAT(h.no_um,' (UM)') no_um ,
                h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
                h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
                h.kode_divisi_req ,
                h.total_biaya ,	h.total_um ,	h.selisih ,
                h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
                h.keterangan ,  h.wkt_input,
                h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
                h.is_kas ,h.reimburse ,h.referenced , h.is_pum
                FROM gl_mim.trn_request_h h
                INNER JOIN (
                SELECT um.no_request,um.jenis,um.kode_dept_req ,
                        um.tgl_berangkat,um.tgl_pulang
                FROM gl_mim.trn_request_h um
                WHERE um.jenis = 'UM'
                AND um.referenced = 1
                AND um.is_reject = 0
                AND um.is_approve = 1
                ) um ON um.no_request = h.no_um
                INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
                INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
                WHERE h.jenis = 'PUM'
                AND dept.kode_dept_induk = 'ACCT'
                AND h.is_dept   = 0
                AND h.is_kas    = 0
                AND h.is_reject = 0
                ORDER BY wkt_input DESC
				LIMIT 0,10
		
ERROR - 2022-06-02 08:22:18 --> Severity: error --> Exception: Call to a member function result_array() on bool D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_kas.php 211
ERROR - 2022-06-02 08:29:04 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:29:05 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:29:05 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:29:05 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:29:05 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:29:05 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:29:05 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:29:06 --> Query error: Table 'gl_mim.mst_jenis_request' doesn't exist - Invalid query: SELECT h.request_h_id ,	h.no_request , h.tgl_request ,	h.jenis ,
                    CASE h.jenis
                    WHEN 'PUM' THEN h.jenis
                    WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
                    ELSE mjr.nama_dokumen
                    END nama_dokumen,
                CASE h.jenis
                WHEN 'PUM' THEN
                        (SELECT h1.tgl_berangkat
                                FROM gl_mim.trn_request_h h1
                                WHERE h1.no_request = h.no_um
                                AND h1.jenis = 'UMPD'
                        )
                WHEN 'UMPD' THEN h.tgl_berangkat
                END tgl_berangkat ,
                CASE h.jenis
                WHEN 'PUM' THEN
                        (SELECT h1.tgl_pulang
                                FROM gl_mim.trn_request_h h1
                                WHERE h1.no_request = h.no_um
                                AND h1.jenis = 'UMPD'
                        )
                WHEN 'UMPD' THEN h.tgl_pulang
                END tgl_pulang ,
                h.no_um ,
                h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
                h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
                h.kode_divisi_req ,
                h.total_biaya ,	h.total_um ,	h.selisih ,
                h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
                h.keterangan , h.wkt_input,
                h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
                h.is_kas ,h.reimburse ,h.referenced , h.is_pum
                FROM gl_mim.trn_request_h h
                INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
                INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
                WHERE dept.kode_dept_induk = 'ACCT'
                AND h.jenis IN ('KLAIM','UM','UMPD')
                AND h.is_dept   = 0
                AND h.is_kas    = 0
                AND h.is_reject = 0
                UNION ALL
                SELECT
                h.request_h_id ,	h.no_request ,
                h.tgl_request ,	h.jenis ,
                    CASE h.jenis
                    WHEN 'PUM' THEN h.jenis
                    WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
                    ELSE mjr.nama_dokumen
                    END nama_dokumen,
                um.tgl_berangkat ,	um.tgl_pulang ,
                CONCAT(h.no_um,' (PD)') no_um,
                h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
                h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
                h.kode_divisi_req ,
                h.total_biaya ,	h.total_um ,	h.selisih ,
                h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
                h.keterangan ,  h.wkt_input,
                h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
                h.is_kas ,h.reimburse ,h.referenced , h.is_pum
                FROM gl_mim.trn_request_h h
                INNER JOIN (
                SELECT um.no_request,um.jenis,um.kode_dept_req ,
                        um.tgl_berangkat,um.tgl_pulang
                FROM gl_mim.trn_request_h um
                WHERE um.jenis = 'UMPD'
                AND um.referenced = 1
                AND um.is_reject = 0
                AND um.is_approve = 1
                ) um ON um.no_request = h.no_um
                INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
                INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
                WHERE h.jenis = 'PUM'
                AND dept.kode_dept_induk = 'ACCT'
                AND h.is_validasi_ga = 1
                AND h.is_dept   = 0
                AND h.is_kas    = 0
                AND h.is_reject = 0
                UNION ALL
                SELECT
                h.request_h_id ,	h.no_request ,
                h.tgl_request ,	h.jenis ,
                    CASE h.jenis
                    WHEN 'PUM' THEN h.jenis
                    WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
                    ELSE mjr.nama_dokumen
                    END nama_dokumen,
                CASE h.jenis
                WHEN 'PUM' THEN
                        (SELECT h1.tgl_berangkat
                                FROM gl_mim.trn_request_h h1
                                WHERE h1.no_request = h.no_um
                                AND h1.jenis ='UMPD'
                        )
                END tgl_berangkat ,
                CASE h.jenis
                WHEN 'PUM' THEN
                        (SELECT h1.tgl_pulang
                                FROM gl_mim.trn_request_h h1
                                WHERE h1.no_request = h.no_um
                                AND h1.jenis ='UMPD'
                        )
                END tgl_pulang ,
                CONCAT(h.no_um,' (UM)') no_um ,
                h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
                h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
                h.kode_divisi_req ,
                h.total_biaya ,	h.total_um ,	h.selisih ,
                h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
                h.keterangan ,  h.wkt_input,
                h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
                h.is_kas ,h.reimburse ,h.referenced , h.is_pum
                FROM gl_mim.trn_request_h h
                INNER JOIN (
                SELECT um.no_request,um.jenis,um.kode_dept_req ,
                        um.tgl_berangkat,um.tgl_pulang
                FROM gl_mim.trn_request_h um
                WHERE um.jenis = 'UM'
                AND um.referenced = 1
                AND um.is_reject = 0
                AND um.is_approve = 1
                ) um ON um.no_request = h.no_um
                INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
                INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
                WHERE h.jenis = 'PUM'
                AND dept.kode_dept_induk = 'ACCT'
                AND h.is_dept   = 0
                AND h.is_kas    = 0
                AND h.is_reject = 0
                ORDER BY wkt_input DESC
				LIMIT 0,10
		
ERROR - 2022-06-02 08:29:06 --> Severity: error --> Exception: Call to a member function result_array() on bool D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_kas.php 210
ERROR - 2022-06-02 08:31:09 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:31:09 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:31:09 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:31:09 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:31:09 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:31:09 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:31:09 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:31:11 --> Query error: Table 'gl_mim.mst_jenis_request' doesn't exist - Invalid query: SELECT h.request_h_id ,	h.no_request , h.tgl_request ,	h.jenis ,
                    CASE h.jenis
                    WHEN 'PUM' THEN h.jenis
                    WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
                    ELSE mjr.nama_dokumen
                    END nama_dokumen,
                CASE h.jenis
                WHEN 'PUM' THEN
                        (SELECT h1.tgl_berangkat
                                FROM gl_mim.trn_request_h h1
                                WHERE h1.no_request = h.no_um
                                AND h1.jenis = 'UMPD'
                        )
                WHEN 'UMPD' THEN h.tgl_berangkat
                END tgl_berangkat ,
                CASE h.jenis
                WHEN 'PUM' THEN
                        (SELECT h1.tgl_pulang
                                FROM gl_mim.trn_request_h h1
                                WHERE h1.no_request = h.no_um
                                AND h1.jenis = 'UMPD'
                        )
                WHEN 'UMPD' THEN h.tgl_pulang
                END tgl_pulang ,
                h.no_um ,
                h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
                h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
                h.kode_divisi_req ,
                h.total_biaya ,	h.total_um ,	h.selisih ,
                h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
                h.keterangan , h.wkt_input,
                h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
                h.is_kas ,h.reimburse ,h.referenced , h.is_pum
                FROM gl_mim.trn_request_h h
                INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
                INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
                WHERE dept.kode_dept_induk = 'ACCT'
                AND h.jenis IN ('KLAIM','UM','UMPD')
                AND h.is_dept   = 0
                AND h.is_kas    = 0
                AND h.is_reject = 0
                UNION ALL
                SELECT
                h.request_h_id ,	h.no_request ,
                h.tgl_request ,	h.jenis ,
                    CASE h.jenis
                    WHEN 'PUM' THEN h.jenis
                    WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
                    ELSE mjr.nama_dokumen
                    END nama_dokumen,
                um.tgl_berangkat ,	um.tgl_pulang ,
                CONCAT(h.no_um,' (PD)') no_um,
                h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
                h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
                h.kode_divisi_req ,
                h.total_biaya ,	h.total_um ,	h.selisih ,
                h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
                h.keterangan ,  h.wkt_input,
                h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
                h.is_kas ,h.reimburse ,h.referenced , h.is_pum
                FROM gl_mim.trn_request_h h
                INNER JOIN (
                SELECT um.no_request,um.jenis,um.kode_dept_req ,
                        um.tgl_berangkat,um.tgl_pulang
                FROM gl_mim.trn_request_h um
                WHERE um.jenis = 'UMPD'
                AND um.referenced = 1
                AND um.is_reject = 0
                AND um.is_approve = 1
                ) um ON um.no_request = h.no_um
                INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
                INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
                WHERE h.jenis = 'PUM'
                AND dept.kode_dept_induk = 'ACCT'
                AND h.is_validasi_ga = 1
                AND h.is_dept   = 0
                AND h.is_kas    = 0
                AND h.is_reject = 0
                UNION ALL
                SELECT
                h.request_h_id ,	h.no_request ,
                h.tgl_request ,	h.jenis ,
                    CASE h.jenis
                    WHEN 'PUM' THEN h.jenis
                    WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
                    ELSE mjr.nama_dokumen
                    END nama_dokumen,
                CASE h.jenis
                WHEN 'PUM' THEN
                        (SELECT h1.tgl_berangkat
                                FROM gl_mim.trn_request_h h1
                                WHERE h1.no_request = h.no_um
                                AND h1.jenis ='UMPD'
                        )
                END tgl_berangkat ,
                CASE h.jenis
                WHEN 'PUM' THEN
                        (SELECT h1.tgl_pulang
                                FROM gl_mim.trn_request_h h1
                                WHERE h1.no_request = h.no_um
                                AND h1.jenis ='UMPD'
                        )
                END tgl_pulang ,
                CONCAT(h.no_um,' (UM)') no_um ,
                h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
                h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
                h.kode_divisi_req ,
                h.total_biaya ,	h.total_um ,	h.selisih ,
                h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
                h.keterangan ,  h.wkt_input,
                h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
                h.is_kas ,h.reimburse ,h.referenced , h.is_pum
                FROM gl_mim.trn_request_h h
                INNER JOIN (
                SELECT um.no_request,um.jenis,um.kode_dept_req ,
                        um.tgl_berangkat,um.tgl_pulang
                FROM gl_mim.trn_request_h um
                WHERE um.jenis = 'UM'
                AND um.referenced = 1
                AND um.is_reject = 0
                AND um.is_approve = 1
                ) um ON um.no_request = h.no_um
                INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
                INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
                WHERE h.jenis = 'PUM'
                AND dept.kode_dept_induk = 'ACCT'
                AND h.is_dept   = 0
                AND h.is_kas    = 0
                AND h.is_reject = 0
                ORDER BY wkt_input DESC
				LIMIT 0,10
		
ERROR - 2022-06-02 08:31:11 --> Severity: error --> Exception: Call to a member function result_array() on bool D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_kas.php 210
ERROR - 2022-06-02 08:32:34 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:32:34 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:32:35 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:32:35 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:32:35 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:32:35 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:32:35 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:32:36 --> Query error: Table 'gl_mim.mst_jenis_request' doesn't exist - Invalid query: SELECT h.request_h_id ,	h.no_request , h.tgl_request ,	h.jenis ,
                    CASE h.jenis
                    WHEN 'PUM' THEN h.jenis
                    WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
                    ELSE mjr.nama_dokumen
                    END nama_dokumen,
                CASE h.jenis
                WHEN 'PUM' THEN
                        (SELECT h1.tgl_berangkat
                                FROM gl_mim.trn_request_h h1
                                WHERE h1.no_request = h.no_um
                                AND h1.jenis = 'UMPD'
                        )
                WHEN 'UMPD' THEN h.tgl_berangkat
                END tgl_berangkat ,
                CASE h.jenis
                WHEN 'PUM' THEN
                        (SELECT h1.tgl_pulang
                                FROM gl_mim.trn_request_h h1
                                WHERE h1.no_request = h.no_um
                                AND h1.jenis = 'UMPD'
                        )
                WHEN 'UMPD' THEN h.tgl_pulang
                END tgl_pulang ,
                h.no_um ,
                h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
                h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
                h.kode_divisi_req ,
                h.total_biaya ,	h.total_um ,	h.selisih ,
                h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
                h.keterangan , h.wkt_input,
                h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
                h.is_kas ,h.reimburse ,h.referenced , h.is_pum
                FROM gl_mim.trn_request_h h
                INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
                INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
                WHERE dept.kode_dept_induk = 'ACCT'
                AND h.jenis IN ('KLAIM','UM','UMPD')
                AND h.is_dept   = 0
                AND h.is_kas    = 0
                AND h.is_reject = 0
                UNION ALL
                SELECT
                h.request_h_id ,	h.no_request ,
                h.tgl_request ,	h.jenis ,
                    CASE h.jenis
                    WHEN 'PUM' THEN h.jenis
                    WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
                    ELSE mjr.nama_dokumen
                    END nama_dokumen,
                um.tgl_berangkat ,	um.tgl_pulang ,
                CONCAT(h.no_um,' (PD)') no_um,
                h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
                h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
                h.kode_divisi_req ,
                h.total_biaya ,	h.total_um ,	h.selisih ,
                h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
                h.keterangan ,  h.wkt_input,
                h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
                h.is_kas ,h.reimburse ,h.referenced , h.is_pum
                FROM gl_mim.trn_request_h h
                INNER JOIN (
                SELECT um.no_request,um.jenis,um.kode_dept_req ,
                        um.tgl_berangkat,um.tgl_pulang
                FROM gl_mim.trn_request_h um
                WHERE um.jenis = 'UMPD'
                AND um.referenced = 1
                AND um.is_reject = 0
                AND um.is_approve = 1
                ) um ON um.no_request = h.no_um
                INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
                INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
                WHERE h.jenis = 'PUM'
                AND dept.kode_dept_induk = 'ACCT'
                AND h.is_validasi_ga = 1
                AND h.is_dept   = 0
                AND h.is_kas    = 0
                AND h.is_reject = 0
                UNION ALL
                SELECT
                h.request_h_id ,	h.no_request ,
                h.tgl_request ,	h.jenis ,
                    CASE h.jenis
                    WHEN 'PUM' THEN h.jenis
                    WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
                    ELSE mjr.nama_dokumen
                    END nama_dokumen,
                CASE h.jenis
                WHEN 'PUM' THEN
                        (SELECT h1.tgl_berangkat
                                FROM gl_mim.trn_request_h h1
                                WHERE h1.no_request = h.no_um
                                AND h1.jenis ='UMPD'
                        )
                END tgl_berangkat ,
                CASE h.jenis
                WHEN 'PUM' THEN
                        (SELECT h1.tgl_pulang
                                FROM gl_mim.trn_request_h h1
                                WHERE h1.no_request = h.no_um
                                AND h1.jenis ='UMPD'
                        )
                END tgl_pulang ,
                CONCAT(h.no_um,' (UM)') no_um ,
                h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
                h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
                h.kode_divisi_req ,
                h.total_biaya ,	h.total_um ,	h.selisih ,
                h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
                h.keterangan ,  h.wkt_input,
                h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
                h.is_kas ,h.reimburse ,h.referenced , h.is_pum
                FROM gl_mim.trn_request_h h
                INNER JOIN (
                SELECT um.no_request,um.jenis,um.kode_dept_req ,
                        um.tgl_berangkat,um.tgl_pulang
                FROM gl_mim.trn_request_h um
                WHERE um.jenis = 'UM'
                AND um.referenced = 1
                AND um.is_reject = 0
                AND um.is_approve = 1
                ) um ON um.no_request = h.no_um
                INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
                INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
                WHERE h.jenis = 'PUM'
                AND dept.kode_dept_induk = 'ACCT'
                AND h.is_dept   = 0
                AND h.is_kas    = 0
                AND h.is_reject = 0
                ORDER BY wkt_input DESC
				LIMIT 0,10
		
ERROR - 2022-06-02 08:33:51 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:33:51 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:33:51 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:33:51 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:33:51 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:33:51 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:33:51 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:33:53 --> Query error: Table 'gl_mim.mst_jenis_request' doesn't exist - Invalid query: SELECT h.request_h_id ,	h.no_request , h.tgl_request ,	h.jenis ,
                    CASE h.jenis
                    WHEN 'PUM' THEN h.jenis
                    WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
                    ELSE mjr.nama_dokumen
                    END nama_dokumen,
                CASE h.jenis
                WHEN 'PUM' THEN
                        (SELECT h1.tgl_berangkat
                                FROM gl_mim.trn_request_h h1
                                WHERE h1.no_request = h.no_um
                                AND h1.jenis = 'UMPD'
                        )
                WHEN 'UMPD' THEN h.tgl_berangkat
                END tgl_berangkat ,
                CASE h.jenis
                WHEN 'PUM' THEN
                        (SELECT h1.tgl_pulang
                                FROM gl_mim.trn_request_h h1
                                WHERE h1.no_request = h.no_um
                                AND h1.jenis = 'UMPD'
                        )
                WHEN 'UMPD' THEN h.tgl_pulang
                END tgl_pulang ,
                h.no_um ,
                h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
                h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
                h.kode_divisi_req ,
                h.total_biaya ,	h.total_um ,	h.selisih ,
                h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
                h.keterangan , h.wkt_input,
                h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
                h.is_kas ,h.reimburse ,h.referenced , h.is_pum
                FROM gl_mim.trn_request_h h
                INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
                INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
                WHERE dept.kode_dept_induk = 'ACCT'
                AND h.jenis IN ('KLAIM','UM','UMPD')
                AND h.is_dept   = 0
                AND h.is_kas    = 0
                AND h.is_reject = 0
                UNION ALL
                SELECT
                h.request_h_id ,	h.no_request ,
                h.tgl_request ,	h.jenis ,
                    CASE h.jenis
                    WHEN 'PUM' THEN h.jenis
                    WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
                    ELSE mjr.nama_dokumen
                    END nama_dokumen,
                um.tgl_berangkat ,	um.tgl_pulang ,
                CONCAT(h.no_um,' (PD)') no_um,
                h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
                h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
                h.kode_divisi_req ,
                h.total_biaya ,	h.total_um ,	h.selisih ,
                h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
                h.keterangan ,  h.wkt_input,
                h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
                h.is_kas ,h.reimburse ,h.referenced , h.is_pum
                FROM gl_mim.trn_request_h h
                INNER JOIN (
                SELECT um.no_request,um.jenis,um.kode_dept_req ,
                        um.tgl_berangkat,um.tgl_pulang
                FROM gl_mim.trn_request_h um
                WHERE um.jenis = 'UMPD'
                AND um.referenced = 1
                AND um.is_reject = 0
                AND um.is_approve = 1
                ) um ON um.no_request = h.no_um
                INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
                INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
                WHERE h.jenis = 'PUM'
                AND dept.kode_dept_induk = 'ACCT'
                AND h.is_validasi_ga = 1
                AND h.is_dept   = 0
                AND h.is_kas    = 0
                AND h.is_reject = 0
                UNION ALL
                SELECT
                h.request_h_id ,	h.no_request ,
                h.tgl_request ,	h.jenis ,
                    CASE h.jenis
                    WHEN 'PUM' THEN h.jenis
                    WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
                    ELSE mjr.nama_dokumen
                    END nama_dokumen,
                CASE h.jenis
                WHEN 'PUM' THEN
                        (SELECT h1.tgl_berangkat
                                FROM gl_mim.trn_request_h h1
                                WHERE h1.no_request = h.no_um
                                AND h1.jenis ='UMPD'
                        )
                END tgl_berangkat ,
                CASE h.jenis
                WHEN 'PUM' THEN
                        (SELECT h1.tgl_pulang
                                FROM gl_mim.trn_request_h h1
                                WHERE h1.no_request = h.no_um
                                AND h1.jenis ='UMPD'
                        )
                END tgl_pulang ,
                CONCAT(h.no_um,' (UM)') no_um ,
                h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
                h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
                h.kode_divisi_req ,
                h.total_biaya ,	h.total_um ,	h.selisih ,
                h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
                h.keterangan ,  h.wkt_input,
                h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
                h.is_kas ,h.reimburse ,h.referenced , h.is_pum
                FROM gl_mim.trn_request_h h
                INNER JOIN (
                SELECT um.no_request,um.jenis,um.kode_dept_req ,
                        um.tgl_berangkat,um.tgl_pulang
                FROM gl_mim.trn_request_h um
                WHERE um.jenis = 'UM'
                AND um.referenced = 1
                AND um.is_reject = 0
                AND um.is_approve = 1
                ) um ON um.no_request = h.no_um
                INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
                INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
                WHERE h.jenis = 'PUM'
                AND dept.kode_dept_induk = 'ACCT'
                AND h.is_dept   = 0
                AND h.is_kas    = 0
                AND h.is_reject = 0
                ORDER BY wkt_input DESC
				LIMIT 0,10
		
ERROR - 2022-06-02 08:33:53 --> Severity: error --> Exception: Call to a member function result_array() on bool D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_kas.php 210
ERROR - 2022-06-02 08:34:32 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:34:33 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:34:33 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:34:33 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:34:33 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:34:33 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:34:33 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:34:34 --> Query error: Table 'gl_mim.mst_jenis_request' doesn't exist - Invalid query: SELECT h.request_h_id ,	h.no_request , h.tgl_request ,	h.jenis ,
                    CASE h.jenis
                    WHEN 'PUM' THEN h.jenis
                    WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
                    ELSE mjr.nama_dokumen
                    END nama_dokumen,
                CASE h.jenis
                WHEN 'PUM' THEN
                        (SELECT h1.tgl_berangkat
                                FROM gl_mim.trn_request_h h1
                                WHERE h1.no_request = h.no_um
                                AND h1.jenis = 'UMPD'
                        )
                WHEN 'UMPD' THEN h.tgl_berangkat
                END tgl_berangkat ,
                CASE h.jenis
                WHEN 'PUM' THEN
                        (SELECT h1.tgl_pulang
                                FROM gl_mim.trn_request_h h1
                                WHERE h1.no_request = h.no_um
                                AND h1.jenis = 'UMPD'
                        )
                WHEN 'UMPD' THEN h.tgl_pulang
                END tgl_pulang ,
                h.no_um ,
                h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
                h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
                h.kode_divisi_req ,
                h.total_biaya ,	h.total_um ,	h.selisih ,
                h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
                h.keterangan , h.wkt_input,
                h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
                h.is_kas ,h.reimburse ,h.referenced , h.is_pum
                FROM gl_mim.trn_request_h h
                INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
                INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
                WHERE dept.kode_dept_induk = 'ACCT'
                AND h.jenis IN ('KLAIM','UM','UMPD')
                AND h.is_dept   = 0
                AND h.is_kas    = 0
                AND h.is_reject = 0
                UNION ALL
                SELECT
                h.request_h_id ,	h.no_request ,
                h.tgl_request ,	h.jenis ,
                    CASE h.jenis
                    WHEN 'PUM' THEN h.jenis
                    WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
                    ELSE mjr.nama_dokumen
                    END nama_dokumen,
                um.tgl_berangkat ,	um.tgl_pulang ,
                CONCAT(h.no_um,' (PD)') no_um,
                h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
                h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
                h.kode_divisi_req ,
                h.total_biaya ,	h.total_um ,	h.selisih ,
                h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
                h.keterangan ,  h.wkt_input,
                h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
                h.is_kas ,h.reimburse ,h.referenced , h.is_pum
                FROM gl_mim.trn_request_h h
                INNER JOIN (
                SELECT um.no_request,um.jenis,um.kode_dept_req ,
                        um.tgl_berangkat,um.tgl_pulang
                FROM gl_mim.trn_request_h um
                WHERE um.jenis = 'UMPD'
                AND um.referenced = 1
                AND um.is_reject = 0
                AND um.is_approve = 1
                ) um ON um.no_request = h.no_um
                INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
                INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
                WHERE h.jenis = 'PUM'
                AND dept.kode_dept_induk = 'ACCT'
                AND h.is_validasi_ga = 1
                AND h.is_dept   = 0
                AND h.is_kas    = 0
                AND h.is_reject = 0
                UNION ALL
                SELECT
                h.request_h_id ,	h.no_request ,
                h.tgl_request ,	h.jenis ,
                    CASE h.jenis
                    WHEN 'PUM' THEN h.jenis
                    WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
                    ELSE mjr.nama_dokumen
                    END nama_dokumen,
                CASE h.jenis
                WHEN 'PUM' THEN
                        (SELECT h1.tgl_berangkat
                                FROM gl_mim.trn_request_h h1
                                WHERE h1.no_request = h.no_um
                                AND h1.jenis ='UMPD'
                        )
                END tgl_berangkat ,
                CASE h.jenis
                WHEN 'PUM' THEN
                        (SELECT h1.tgl_pulang
                                FROM gl_mim.trn_request_h h1
                                WHERE h1.no_request = h.no_um
                                AND h1.jenis ='UMPD'
                        )
                END tgl_pulang ,
                CONCAT(h.no_um,' (UM)') no_um ,
                h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
                h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
                h.kode_divisi_req ,
                h.total_biaya ,	h.total_um ,	h.selisih ,
                h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
                h.keterangan ,  h.wkt_input,
                h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
                h.is_kas ,h.reimburse ,h.referenced , h.is_pum
                FROM gl_mim.trn_request_h h
                INNER JOIN (
                SELECT um.no_request,um.jenis,um.kode_dept_req ,
                        um.tgl_berangkat,um.tgl_pulang
                FROM gl_mim.trn_request_h um
                WHERE um.jenis = 'UM'
                AND um.referenced = 1
                AND um.is_reject = 0
                AND um.is_approve = 1
                ) um ON um.no_request = h.no_um
                INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
                INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
                WHERE h.jenis = 'PUM'
                AND dept.kode_dept_induk = 'ACCT'
                AND h.is_dept   = 0
                AND h.is_kas    = 0
                AND h.is_reject = 0
                ORDER BY wkt_input DESC
				LIMIT 0,10
		
ERROR - 2022-06-02 08:34:34 --> Severity: error --> Exception: Call to a member function result_array() on bool D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_kas.php 210
ERROR - 2022-06-02 08:37:15 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:37:15 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:37:15 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:37:15 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:37:15 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:37:15 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:37:15 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:37:16 --> Query error: Table 'gl_mim.mst_jenis_request' doesn't exist - Invalid query: SELECT h.request_h_id ,	h.no_request , h.tgl_request ,	h.jenis ,
                    CASE h.jenis
                    WHEN 'PUM' THEN h.jenis
                    WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
                    ELSE mjr.nama_dokumen
                    END nama_dokumen,
                CASE h.jenis
                WHEN 'PUM' THEN
                        (SELECT h1.tgl_berangkat
                                FROM gl_mim.trn_request_h h1
                                WHERE h1.no_request = h.no_um
                                AND h1.jenis = 'UMPD'
                        )
                WHEN 'UMPD' THEN h.tgl_berangkat
                END tgl_berangkat ,
                CASE h.jenis
                WHEN 'PUM' THEN
                        (SELECT h1.tgl_pulang
                                FROM gl_mim.trn_request_h h1
                                WHERE h1.no_request = h.no_um
                                AND h1.jenis = 'UMPD'
                        )
                WHEN 'UMPD' THEN h.tgl_pulang
                END tgl_pulang ,
                h.no_um ,
                h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
                h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
                h.kode_divisi_req ,
                h.total_biaya ,	h.total_um ,	h.selisih ,
                h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
                h.keterangan , h.wkt_input,
                h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
                h.is_kas ,h.reimburse ,h.referenced , h.is_pum
                FROM gl_mim.trn_request_h h
                INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
                INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
                WHERE dept.kode_dept_induk = 'ACCT'
                AND h.jenis IN ('KLAIM','UM','UMPD')
                AND h.is_dept   = 0
                AND h.is_kas    = 0
                AND h.is_reject = 0
                UNION ALL
                SELECT
                h.request_h_id ,	h.no_request ,
                h.tgl_request ,	h.jenis ,
                    CASE h.jenis
                    WHEN 'PUM' THEN h.jenis
                    WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
                    ELSE mjr.nama_dokumen
                    END nama_dokumen,
                um.tgl_berangkat ,	um.tgl_pulang ,
                CONCAT(h.no_um,' (PD)') no_um,
                h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
                h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
                h.kode_divisi_req ,
                h.total_biaya ,	h.total_um ,	h.selisih ,
                h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
                h.keterangan ,  h.wkt_input,
                h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
                h.is_kas ,h.reimburse ,h.referenced , h.is_pum
                FROM gl_mim.trn_request_h h
                INNER JOIN (
                SELECT um.no_request,um.jenis,um.kode_dept_req ,
                        um.tgl_berangkat,um.tgl_pulang
                FROM gl_mim.trn_request_h um
                WHERE um.jenis = 'UMPD'
                AND um.referenced = 1
                AND um.is_reject = 0
                AND um.is_approve = 1
                ) um ON um.no_request = h.no_um
                INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
                INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
                WHERE h.jenis = 'PUM'
                AND dept.kode_dept_induk = 'ACCT'
                AND h.is_validasi_ga = 1
                AND h.is_dept   = 0
                AND h.is_kas    = 0
                AND h.is_reject = 0
                UNION ALL
                SELECT
                h.request_h_id ,	h.no_request ,
                h.tgl_request ,	h.jenis ,
                    CASE h.jenis
                    WHEN 'PUM' THEN h.jenis
                    WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
                    ELSE mjr.nama_dokumen
                    END nama_dokumen,
                CASE h.jenis
                WHEN 'PUM' THEN
                        (SELECT h1.tgl_berangkat
                                FROM gl_mim.trn_request_h h1
                                WHERE h1.no_request = h.no_um
                                AND h1.jenis ='UMPD'
                        )
                END tgl_berangkat ,
                CASE h.jenis
                WHEN 'PUM' THEN
                        (SELECT h1.tgl_pulang
                                FROM gl_mim.trn_request_h h1
                                WHERE h1.no_request = h.no_um
                                AND h1.jenis ='UMPD'
                        )
                END tgl_pulang ,
                CONCAT(h.no_um,' (UM)') no_um ,
                h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
                h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
                h.kode_divisi_req ,
                h.total_biaya ,	h.total_um ,	h.selisih ,
                h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
                h.keterangan ,  h.wkt_input,
                h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
                h.is_kas ,h.reimburse ,h.referenced , h.is_pum
                FROM gl_mim.trn_request_h h
                INNER JOIN (
                SELECT um.no_request,um.jenis,um.kode_dept_req ,
                        um.tgl_berangkat,um.tgl_pulang
                FROM gl_mim.trn_request_h um
                WHERE um.jenis = 'UM'
                AND um.referenced = 1
                AND um.is_reject = 0
                AND um.is_approve = 1
                ) um ON um.no_request = h.no_um
                INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
                INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
                WHERE h.jenis = 'PUM'
                AND dept.kode_dept_induk = 'ACCT'
                AND h.is_dept   = 0
                AND h.is_kas    = 0
                AND h.is_reject = 0
                ORDER BY wkt_input DESC
				LIMIT 0,10
		
ERROR - 2022-06-02 08:37:16 --> Severity: error --> Exception: Call to a member function result_array() on bool D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_kas.php 155
ERROR - 2022-06-02 08:38:15 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:38:16 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:38:16 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:38:16 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:38:16 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:38:16 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:38:16 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:38:39 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:38:39 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:38:39 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:38:39 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:38:39 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:38:39 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:38:39 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:38:40 --> Query error: Table 'gl_mim.mst_jenis_request' doesn't exist - Invalid query: SELECT h.request_h_id ,	h.no_request , h.tgl_request ,	h.jenis ,
                    CASE h.jenis
                    WHEN 'PUM' THEN h.jenis
                    WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
                    ELSE mjr.nama_dokumen
                    END nama_dokumen,
                CASE h.jenis
                WHEN 'PUM' THEN
                        (SELECT h1.tgl_berangkat
                                FROM gl_mim.trn_request_h h1
                                WHERE h1.no_request = h.no_um
                                AND h1.jenis = 'UMPD'
                        )
                WHEN 'UMPD' THEN h.tgl_berangkat
                END tgl_berangkat ,
                CASE h.jenis
                WHEN 'PUM' THEN
                        (SELECT h1.tgl_pulang
                                FROM gl_mim.trn_request_h h1
                                WHERE h1.no_request = h.no_um
                                AND h1.jenis = 'UMPD'
                        )
                WHEN 'UMPD' THEN h.tgl_pulang
                END tgl_pulang ,
                h.no_um ,
                h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
                h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
                h.kode_divisi_req ,
                h.total_biaya ,	h.total_um ,	h.selisih ,
                h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
                h.keterangan , h.wkt_input,
                h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
                h.is_kas ,h.reimburse ,h.referenced , h.is_pum
                FROM gl_mim.trn_request_h h
                INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
                INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
                WHERE dept.kode_dept_induk = 'ACCT'
                AND h.jenis IN ('KLAIM','UM','UMPD')
                AND h.is_dept   = 0
                AND h.is_kas    = 0
                AND h.is_reject = 0
                UNION ALL
                SELECT
                h.request_h_id ,	h.no_request ,
                h.tgl_request ,	h.jenis ,
                    CASE h.jenis
                    WHEN 'PUM' THEN h.jenis
                    WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
                    ELSE mjr.nama_dokumen
                    END nama_dokumen,
                um.tgl_berangkat ,	um.tgl_pulang ,
                CONCAT(h.no_um,' (PD)') no_um,
                h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
                h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
                h.kode_divisi_req ,
                h.total_biaya ,	h.total_um ,	h.selisih ,
                h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
                h.keterangan ,  h.wkt_input,
                h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
                h.is_kas ,h.reimburse ,h.referenced , h.is_pum
                FROM gl_mim.trn_request_h h
                INNER JOIN (
                SELECT um.no_request,um.jenis,um.kode_dept_req ,
                        um.tgl_berangkat,um.tgl_pulang
                FROM gl_mim.trn_request_h um
                WHERE um.jenis = 'UMPD'
                AND um.referenced = 1
                AND um.is_reject = 0
                AND um.is_approve = 1
                ) um ON um.no_request = h.no_um
                INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
                INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
                WHERE h.jenis = 'PUM'
                AND dept.kode_dept_induk = 'ACCT'
                AND h.is_validasi_ga = 1
                AND h.is_dept   = 0
                AND h.is_kas    = 0
                AND h.is_reject = 0
                UNION ALL
                SELECT
                h.request_h_id ,	h.no_request ,
                h.tgl_request ,	h.jenis ,
                    CASE h.jenis
                    WHEN 'PUM' THEN h.jenis
                    WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
                    ELSE mjr.nama_dokumen
                    END nama_dokumen,
                CASE h.jenis
                WHEN 'PUM' THEN
                        (SELECT h1.tgl_berangkat
                                FROM gl_mim.trn_request_h h1
                                WHERE h1.no_request = h.no_um
                                AND h1.jenis ='UMPD'
                        )
                END tgl_berangkat ,
                CASE h.jenis
                WHEN 'PUM' THEN
                        (SELECT h1.tgl_pulang
                                FROM gl_mim.trn_request_h h1
                                WHERE h1.no_request = h.no_um
                                AND h1.jenis ='UMPD'
                        )
                END tgl_pulang ,
                CONCAT(h.no_um,' (UM)') no_um ,
                h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
                h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
                h.kode_divisi_req ,
                h.total_biaya ,	h.total_um ,	h.selisih ,
                h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
                h.keterangan ,  h.wkt_input,
                h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
                h.is_kas ,h.reimburse ,h.referenced , h.is_pum
                FROM gl_mim.trn_request_h h
                INNER JOIN (
                SELECT um.no_request,um.jenis,um.kode_dept_req ,
                        um.tgl_berangkat,um.tgl_pulang
                FROM gl_mim.trn_request_h um
                WHERE um.jenis = 'UM'
                AND um.referenced = 1
                AND um.is_reject = 0
                AND um.is_approve = 1
                ) um ON um.no_request = h.no_um
                INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
                INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
                WHERE h.jenis = 'PUM'
                AND dept.kode_dept_induk = 'ACCT'
                AND h.is_dept   = 0
                AND h.is_kas    = 0
                AND h.is_reject = 0
                ORDER BY wkt_input DESC
				LIMIT 0,10
		
ERROR - 2022-06-02 08:38:40 --> Severity: error --> Exception: Call to a member function result_array() on bool D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_kas.php 156
ERROR - 2022-06-02 08:38:51 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:38:51 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:38:51 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:38:51 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:38:51 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:38:51 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:38:52 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:40:24 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:40:25 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:40:25 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:40:25 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:40:25 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:40:25 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:40:25 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:41:44 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:41:44 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:41:44 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:41:44 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:41:44 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:41:44 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:41:44 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:41:56 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:41:57 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:41:57 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:41:57 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:41:57 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:41:57 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:41:57 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:42:19 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:42:20 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:42:20 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:42:20 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:42:20 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:42:20 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:42:20 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:43:09 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:43:10 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:43:10 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:43:10 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:43:10 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:43:10 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:43:10 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:56:56 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:56:57 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:56:57 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:56:57 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:56:57 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:56:57 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 08:56:57 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:05:58 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:05:58 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:05:58 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:05:59 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:05:59 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:05:59 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:05:59 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:06:00 --> Query error: Table 'gl_mim.mst_jenis_request' doesn't exist - Invalid query: SELECT h.request_h_id ,	h.no_request , h.tgl_request ,	h.jenis ,
                    CASE h.jenis
                    WHEN 'PUM' THEN h.jenis
                    WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
                    ELSE mjr.nama_dokumen
                    END nama_dokumen,
                CASE h.jenis
                WHEN 'PUM' THEN
                        (SELECT h1.tgl_berangkat
                                FROM gl_mim.trn_request_h h1
                                WHERE h1.no_request = h.no_um
                                AND h1.jenis = 'UMPD'
                        )
                WHEN 'UMPD' THEN h.tgl_berangkat
                END tgl_berangkat ,
                CASE h.jenis
                WHEN 'PUM' THEN
                        (SELECT h1.tgl_pulang
                                FROM gl_mim.trn_request_h h1
                                WHERE h1.no_request = h.no_um
                                AND h1.jenis = 'UMPD'
                        )
                WHEN 'UMPD' THEN h.tgl_pulang
                END tgl_pulang ,
                h.no_um ,
                h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
                h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
                h.kode_divisi_req ,
                h.total_biaya ,	h.total_um ,	h.selisih ,
                h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
                h.keterangan , h.wkt_input,
                h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
                h.is_kas ,h.reimburse ,h.referenced , h.is_pum
                FROM gl_mim.trn_request_h h
                INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
                INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
                WHERE dept.kode_dept_induk = 'ACCT'
                AND h.jenis IN ('KLAIM','UM','UMPD')
                AND h.is_dept   = 0
                AND h.is_kas    = 0
                AND h.is_reject = 0
                UNION ALL
                SELECT
                h.request_h_id ,	h.no_request ,
                h.tgl_request ,	h.jenis ,
                    CASE h.jenis
                    WHEN 'PUM' THEN h.jenis
                    WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
                    ELSE mjr.nama_dokumen
                    END nama_dokumen,
                um.tgl_berangkat ,	um.tgl_pulang ,
                CONCAT(h.no_um,' (PD)') no_um,
                h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
                h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
                h.kode_divisi_req ,
                h.total_biaya ,	h.total_um ,	h.selisih ,
                h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
                h.keterangan ,  h.wkt_input,
                h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
                h.is_kas ,h.reimburse ,h.referenced , h.is_pum
                FROM gl_mim.trn_request_h h
                INNER JOIN (
                SELECT um.no_request,um.jenis,um.kode_dept_req ,
                        um.tgl_berangkat,um.tgl_pulang
                FROM gl_mim.trn_request_h um
                WHERE um.jenis = 'UMPD'
                AND um.referenced = 1
                AND um.is_reject = 0
                AND um.is_approve = 1
                ) um ON um.no_request = h.no_um
                INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
                INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
                WHERE h.jenis = 'PUM'
                AND dept.kode_dept_induk = 'ACCT'
                AND h.is_validasi_ga = 1
                AND h.is_dept   = 0
                AND h.is_kas    = 0
                AND h.is_reject = 0
                UNION ALL
                SELECT
                h.request_h_id ,	h.no_request ,
                h.tgl_request ,	h.jenis ,
                    CASE h.jenis
                    WHEN 'PUM' THEN h.jenis
                    WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
                    ELSE mjr.nama_dokumen
                    END nama_dokumen,
                CASE h.jenis
                WHEN 'PUM' THEN
                        (SELECT h1.tgl_berangkat
                                FROM gl_mim.trn_request_h h1
                                WHERE h1.no_request = h.no_um
                                AND h1.jenis ='UMPD'
                        )
                END tgl_berangkat ,
                CASE h.jenis
                WHEN 'PUM' THEN
                        (SELECT h1.tgl_pulang
                                FROM gl_mim.trn_request_h h1
                                WHERE h1.no_request = h.no_um
                                AND h1.jenis ='UMPD'
                        )
                END tgl_pulang ,
                CONCAT(h.no_um,' (UM)') no_um ,
                h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
                h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
                h.kode_divisi_req ,
                h.total_biaya ,	h.total_um ,	h.selisih ,
                h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
                h.keterangan ,  h.wkt_input,
                h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
                h.is_kas ,h.reimburse ,h.referenced , h.is_pum
                FROM gl_mim.trn_request_h h
                INNER JOIN (
                SELECT um.no_request,um.jenis,um.kode_dept_req ,
                        um.tgl_berangkat,um.tgl_pulang
                FROM gl_mim.trn_request_h um
                WHERE um.jenis = 'UM'
                AND um.referenced = 1
                AND um.is_reject = 0
                AND um.is_approve = 1
                ) um ON um.no_request = h.no_um
                INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
                INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
                WHERE h.jenis = 'PUM'
                AND dept.kode_dept_induk = 'ACCT'
                AND h.is_dept   = 0
                AND h.is_kas    = 0
                AND h.is_reject = 0
                ORDER BY wkt_input DESC
				LIMIT 0,10
		
ERROR - 2022-06-02 09:06:00 --> Severity: error --> Exception: Call to a member function result_array() on bool D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_kas.php 156
ERROR - 2022-06-02 09:06:18 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:06:18 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:06:18 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:06:18 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:06:19 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:06:20 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-06-02 09:06:20 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:06:20 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:06:20 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:06:20 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:06:20 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:06:20 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:06:23 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:06:24 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:06:24 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:06:24 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:06:24 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:06:24 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:06:24 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:06:25 --> Query error: Table 'gl_mim.mst_jenis_request' doesn't exist - Invalid query: SELECT h.request_h_id ,	h.no_request , h.tgl_request ,	h.jenis ,
                    CASE h.jenis
                    WHEN 'PUM' THEN h.jenis
                    WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
                    ELSE mjr.nama_dokumen
                    END nama_dokumen,
                CASE h.jenis
                WHEN 'PUM' THEN
                        (SELECT h1.tgl_berangkat
                                FROM gl_mim.trn_request_h h1
                                WHERE h1.no_request = h.no_um
                                AND h1.jenis = 'UMPD'
                        )
                WHEN 'UMPD' THEN h.tgl_berangkat
                END tgl_berangkat ,
                CASE h.jenis
                WHEN 'PUM' THEN
                        (SELECT h1.tgl_pulang
                                FROM gl_mim.trn_request_h h1
                                WHERE h1.no_request = h.no_um
                                AND h1.jenis = 'UMPD'
                        )
                WHEN 'UMPD' THEN h.tgl_pulang
                END tgl_pulang ,
                h.no_um ,
                h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
                h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
                h.kode_divisi_req ,
                h.total_biaya ,	h.total_um ,	h.selisih ,
                h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
                h.keterangan , h.wkt_input,
                h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
                h.is_kas ,h.reimburse ,h.referenced , h.is_pum
                FROM gl_mim.trn_request_h h
                INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
                INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
                WHERE dept.kode_dept_induk = 'ACCT'
                AND h.jenis IN ('KLAIM','UM','UMPD')
                AND h.is_dept   = 0
                AND h.is_kas    = 0
                AND h.is_reject = 0
                UNION ALL
                SELECT
                h.request_h_id ,	h.no_request ,
                h.tgl_request ,	h.jenis ,
                    CASE h.jenis
                    WHEN 'PUM' THEN h.jenis
                    WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
                    ELSE mjr.nama_dokumen
                    END nama_dokumen,
                um.tgl_berangkat ,	um.tgl_pulang ,
                CONCAT(h.no_um,' (PD)') no_um,
                h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
                h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
                h.kode_divisi_req ,
                h.total_biaya ,	h.total_um ,	h.selisih ,
                h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
                h.keterangan ,  h.wkt_input,
                h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
                h.is_kas ,h.reimburse ,h.referenced , h.is_pum
                FROM gl_mim.trn_request_h h
                INNER JOIN (
                SELECT um.no_request,um.jenis,um.kode_dept_req ,
                        um.tgl_berangkat,um.tgl_pulang
                FROM gl_mim.trn_request_h um
                WHERE um.jenis = 'UMPD'
                AND um.referenced = 1
                AND um.is_reject = 0
                AND um.is_approve = 1
                ) um ON um.no_request = h.no_um
                INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
                INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
                WHERE h.jenis = 'PUM'
                AND dept.kode_dept_induk = 'ACCT'
                AND h.is_validasi_ga = 1
                AND h.is_dept   = 0
                AND h.is_kas    = 0
                AND h.is_reject = 0
                UNION ALL
                SELECT
                h.request_h_id ,	h.no_request ,
                h.tgl_request ,	h.jenis ,
                    CASE h.jenis
                    WHEN 'PUM' THEN h.jenis
                    WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
                    ELSE mjr.nama_dokumen
                    END nama_dokumen,
                CASE h.jenis
                WHEN 'PUM' THEN
                        (SELECT h1.tgl_berangkat
                                FROM gl_mim.trn_request_h h1
                                WHERE h1.no_request = h.no_um
                                AND h1.jenis ='UMPD'
                        )
                END tgl_berangkat ,
                CASE h.jenis
                WHEN 'PUM' THEN
                        (SELECT h1.tgl_pulang
                                FROM gl_mim.trn_request_h h1
                                WHERE h1.no_request = h.no_um
                                AND h1.jenis ='UMPD'
                        )
                END tgl_pulang ,
                CONCAT(h.no_um,' (UM)') no_um ,
                h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
                h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
                h.kode_divisi_req ,
                h.total_biaya ,	h.total_um ,	h.selisih ,
                h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
                h.keterangan ,  h.wkt_input,
                h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
                h.is_kas ,h.reimburse ,h.referenced , h.is_pum
                FROM gl_mim.trn_request_h h
                INNER JOIN (
                SELECT um.no_request,um.jenis,um.kode_dept_req ,
                        um.tgl_berangkat,um.tgl_pulang
                FROM gl_mim.trn_request_h um
                WHERE um.jenis = 'UM'
                AND um.referenced = 1
                AND um.is_reject = 0
                AND um.is_approve = 1
                ) um ON um.no_request = h.no_um
                INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
                INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
                WHERE h.jenis = 'PUM'
                AND dept.kode_dept_induk = 'ACCT'
                AND h.is_dept   = 0
                AND h.is_kas    = 0
                AND h.is_reject = 0
                ORDER BY wkt_input DESC
				LIMIT 0,10
		
ERROR - 2022-06-02 09:06:25 --> Severity: error --> Exception: Call to a member function result_array() on bool D:\xampp\htdocs\hrd_cuti\application\modules\leaves\models\Model_kas.php 156
ERROR - 2022-06-02 09:13:59 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:13:59 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:13:59 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:14:00 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:14:00 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:14:00 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:14:00 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:35:52 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:35:52 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:35:52 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:35:52 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:35:52 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:35:52 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:35:53 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:35:59 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:36:00 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:36:00 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:36:00 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:36:00 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:36:00 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 09:36:00 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 11:38:37 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 11:38:37 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 11:38:37 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 11:38:37 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 11:38:41 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 11:38:41 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-06-02 11:38:41 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 11:38:42 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 11:38:42 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 11:38:42 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 11:38:42 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 11:38:42 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 13:25:49 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 13:25:49 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 13:25:49 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 13:25:49 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 13:25:49 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 13:25:49 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 15:23:05 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 15:35:50 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 15:35:50 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 15:46:26 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
ERROR - 2022-06-02 15:46:26 --> Language file contains no data: language/indonesian/form_validation_lang.php
ERROR - 2022-06-02 15:46:27 --> Could not find the specified $config['composer_autoload'] path: vendor/autoload.php
