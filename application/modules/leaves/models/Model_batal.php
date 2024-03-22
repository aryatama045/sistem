<?php

class Model_batal extends CI_Model
{
	private $hrd;
	function __construct()
	{
		parent::__construct();
        $this->hrd = $this->load->database('hrd',TRUE);
	}

	/* get datables */
    public function getDataBatal1($search_no="",$length="",$start="",$column="",$order="")
	{
        $sql_pic 			= $this->Model_leave->getDataPicDewaHrd();
        $where_app = "";
		if($search_no !== ""){
			$where_app = "WHERE no_dok_tdk_masuk LIKE '%$search_no%' ";
		}

        if($sql_pic['level'] == '2'){
            $where = 'AND kd_store IN ("SP_HO","OT_HO","OT_ME1","TOL_HO","TOL_JK","TOL_PL","TOL_SB","TOL_YG","TOL_BD","TOL_MD","TOL_ML","TOL_PK","TOL_SM")';
        } else if($sql_pic['level'] == '3') {
            $where = 'AND kd_store NOT IN ("SP_HO","OT_HO","OT_ME1","TOL_HO","TOL_JK","TOL_PL","TOL_SB","TOL_YG","TOL_BD","TOL_MD","TOL_ML","TOL_PK","TOL_SM")';
        }

        $date_year  = date('Y');
        $date_month = date('m');

		$sql = "SELECT * FROM(
            SELECT
            CASE WHEN LEFT(no_dok_tdk_masuk,3)='HRI' THEN 'IJIN' ELSE 'CUTI' END jenis,
            nip,nama_lengkap,no_dok_tdk_masuk, a.tdk_masuk_h_id, tgl_dok_tdk_masuk,  a.keterangan,c.status_dokumen
            FROM hrd_all.trn_tidak_masuk_h a
            LEFT JOIN hrd_all.trn_posting c ON a.tdk_masuk_h_id = c.tdk_masuk_h_id
            LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
            LEFT JOIN hrd_all.mst_biodata e ON d.biodata_id = e.biodata_id
            WHERE c.status_dokumen IN('P','C')
            -- AND is_posting = 0
            $where
            AND IFNULL(a.pic_edit,'')=''
            -- AND YEAR(tgl_dok_tdk_masuk)>= $date_year
            -- AND MONTH(tgl_dok_tdk_masuk)>= $date_month

            UNION ALL
            SELECT
            'CUTI DISPENSASI',
            nip,nama_lengkap,no_dok_cuti no_dok_tdk_masuk,cuti_dispensasi_h_id tdk_masuk_h_id,tgl_dok_cuti tgl_dok_tdk_masuk,  a.keterangan
            ,c.status_dokumen
            FROM hrd_all.trn_cuti_dispensasi_h a
            LEFT JOIN hrd_all.trn_posting c ON a.cuti_dispensasi_h_id = c.tdk_masuk_h_id
            LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
            LEFT JOIN hrd_all.mst_biodata e ON d.biodata_id = e.biodata_id
            WHERE status_dokumen IN('P','C')
            -- AND is_posting =0
            $where
            AND IFNULL(a.pic_edit,'')=''
            AND YEAR(tgl_dok_cuti)>= $date_year
            AND MONTH(tgl_dok_cuti)>= $date_month

            UNION ALL
            SELECT
            'CUTI PENGGANTI',
            a.nip,e.nama_lengkap,a.no_doc no_dok_tdk_masuk,a.no_doc tdk_masuk_h_id,tgl_doc tgl_dok_tdk_masuk, a.keterangan,c.status_dokumen
            FROM hrd_all.trn_pengajuan_cuti_tambahan a
            LEFT JOIN hrd_all.trn_posting c ON a.no_doc = c.tdk_masuk_h_id
            LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.pic_input = d.biodata_id
            LEFT JOIN hrd_all.mst_biodata e ON d.biodata_id = e.biodata_id
            WHERE status_dokumen IN('P','C')
            AND IFNULL(a.is_ditolak,'')=''
            -- AND IFNULL(a.is_hrd,'')=''
            AND IFNULL(a.tgl_tolak,'')=''
            $where
            AND YEAR(a.tgl_doc)>=$date_year
            AND MONTH(a.tgl_doc)>=$date_month
            )a
            $where_app
            ORDER BY tgl_dok_tdk_masuk DESC,nip, no_dok_tdk_masuk
			LIMIT $start,$length
		";

		$query = $this->hrd->query($sql);
		// die(nl2br($this->hrd->last_query()));
		return $query->result_array();

	}

	public function getDataBatal2($search_no = "")
	{
        $sql_pic 			= $this->Model_leave->getDataPicDewaHrd();
        $where_app = "";
		if($search_no !== ""){
			$where_app = "WHERE no_dok_tdk_masuk LIKE '%$search_no%' ";
		}

        if($sql_pic['level'] == '2'){
            $where = 'AND kd_store IN ("SP_HO","OT_HO","OT_ME1","TOL_HO","TOL_JK","TOL_PL","TOL_SB","TOL_YG","TOL_BD","TOL_MD","TOL_ML","TOL_PK","TOL_SM")';
        } else if($sql_pic['level'] == '3') {
            $where = 'AND kd_store NOT IN ("SP_HO","OT_HO","OT_ME1","TOL_HO","TOL_JK","TOL_PL","TOL_SB","TOL_YG","TOL_BD","TOL_MD","TOL_ML","TOL_PK","TOL_SM")';
        }

        $date_year  = date('Y');
        $date_month = date('m');

		$sql = "SELECT * FROM(
            SELECT
            CASE WHEN LEFT(no_dok_tdk_masuk,3)='HRI' THEN 'IJIN' ELSE 'CUTI' END jenis,
            nip,nama_lengkap,no_dok_tdk_masuk, a.tdk_masuk_h_id, tgl_dok_tdk_masuk,  a.keterangan,c.status_dokumen
            FROM hrd_all.trn_tidak_masuk_h a
            LEFT JOIN hrd_all.trn_posting c ON a.tdk_masuk_h_id = c.tdk_masuk_h_id
            LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
            LEFT JOIN hrd_all.mst_biodata e ON d.biodata_id = e.biodata_id
            WHERE c.status_dokumen IN('P','C')
            -- AND is_posting = 0
            $where
            AND IFNULL(a.pic_edit,'')=''
            AND YEAR(tgl_dok_tdk_masuk)>= $date_year
            AND MONTH(tgl_dok_tdk_masuk)>= $date_month

            UNION ALL
            SELECT
            'CUTI DISPENSASI',
            nip,nama_lengkap,no_dok_cuti no_dok_tdk_masuk,cuti_dispensasi_h_id tdk_masuk_h_id,tgl_dok_cuti tgl_dok_tdk_masuk,  a.keterangan
            ,c.status_dokumen
            FROM hrd_all.trn_cuti_dispensasi_h a
            LEFT JOIN hrd_all.trn_posting c ON a.cuti_dispensasi_h_id = c.tdk_masuk_h_id
            LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
            LEFT JOIN hrd_all.mst_biodata e ON d.biodata_id = e.biodata_id
            WHERE status_dokumen IN('P','C')
            -- AND is_posting =0
            $where
            AND IFNULL(a.pic_edit,'')=''
            AND YEAR(tgl_dok_cuti)>= $date_year
            AND MONTH(tgl_dok_cuti)>= $date_month

            UNION ALL
            SELECT
            'CUTI PENGGANTI',
            a.nip,e.nama_lengkap,a.no_doc no_dok_tdk_masuk,a.no_doc tdk_masuk_h_id,tgl_doc tgl_dok_tdk_masuk, a.keterangan,c.status_dokumen
            FROM hrd_all.trn_pengajuan_cuti_tambahan a
            LEFT JOIN hrd_all.trn_posting c ON a.no_doc = c.tdk_masuk_h_id
            LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.pic_input = d.biodata_id
            LEFT JOIN hrd_all.mst_biodata e ON d.biodata_id = e.biodata_id
            WHERE status_dokumen IN('P','C')
            AND IFNULL(a.is_ditolak,'')=''
            -- AND IFNULL(a.is_hrd,'')=''
            AND IFNULL(a.tgl_tolak,'')=''
            $where
            AND YEAR(a.tgl_doc)>=$date_year
            AND MONTH(a.tgl_doc)>=$date_month
            )a
            $where_app
            ORDER BY tgl_dok_tdk_masuk DESC,nip, no_dok_tdk_masuk
        ";
		$jum= $this->hrd->query($sql);
		return $jum->num_rows();
	}

    public function getDataHistory1($search_no="",$length="",$start="",$column="",$order="")
	{

        $where_app = "";
		if($search_no !== ""){
			$where_app = "WHERE no_dok_tdk_masuk LIKE '%$search_no%' ";
		}

		$sql = "SELECT a.* FROM(
            SELECT
            CASE WHEN LEFT(no_dok_tdk_masuk,3)='HRI' THEN 'IJIN' ELSE 'CUTI' END jenis,
            e.nip,e.nama_lengkap, a.no_dok_tdk_masuk, a.tdk_masuk_h_id,
            a.tgl_dok_tdk_masuk, a.keterangan,
            c.tgl_rej_2, c.rej_komentar_2
            FROM hrd_all.trn_tidak_masuk_h a
            LEFT JOIN hrd_all.trn_tidak_masuk_d b ON a.tdk_masuk_h_id = b.tdk_masuk_h_id
            LEFT JOIN hrd_all.trn_posting c ON a.tdk_masuk_h_id = c.tdk_masuk_h_id
            LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
            LEFT JOIN hrd_all.mst_biodata e ON d.biodata_id = e.biodata_id
            WHERE c.status_dokumen ='R'
            AND kd_store IN('OT_HO','TOL_HO','TOL_BD','TOL_JK','TOL_MD','TOL_ML','TOL_PK','TOL_PL','TOL_SB','TOL_SM','TOL_YG')
            AND YEAR(tgl_dok_tdk_masuk)>='2023'
            AND rej_komentar_2 LIKE '%(BATAL-HRD)%'

            UNION ALL
            SELECT
            'CUTI DISPENSASI',
            e.nip,e.nama_lengkap,a.no_dok_cuti no_dok_tdk_masuk,a.cuti_dispensasi_h_id tdk_masuk_h_id,
            a.tgl_dok_cuti tgl_dok_tdk_masuk,a.keterangan, 
            c.tgl_rej_2, c.rej_komentar_2
            FROM hrd_all.trn_cuti_dispensasi_h a
            LEFT JOIN hrd_all.trn_cuti_dispensasi_d b ON a.cuti_dispensasi_h_id = b.cuti_dispensasi_h_id
            LEFT JOIN hrd_all.trn_posting c ON a.cuti_dispensasi_h_id = c.tdk_masuk_h_id
            LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
            LEFT JOIN hrd_all.mst_biodata e ON d.biodata_id = e.biodata_id
            WHERE c.status_dokumen ='R'
            AND kd_store IN('OT_HO','TOL_HO','TOL_BD','TOL_JK','TOL_MD','TOL_ML','TOL_PK','TOL_PL','TOL_SB','TOL_SM','TOL_YG')
            AND YEAR(tgl_dok_cuti)>='2023' AND rej_komentar_2 LIKE '%(BATAL-HRD)%'
            UNION ALL
            SELECT
            'CUTI PENGGANTI',
            a.nip,e.nama_lengkap,a.no_doc no_dok_tdk_masuk,a.no_doc tdk_masuk_h_id,tgl_doc tgl_dok_tdk_masuk, a.keterangan,
            c.tgl_rej_2, c.rej_komentar_2
            FROM hrd_all.trn_pengajuan_cuti_tambahan a
            LEFT JOIN hrd_all.trn_posting c ON a.no_doc = c.tdk_masuk_h_id
            LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.pic_input = d.biodata_id
            LEFT JOIN hrd_all.mst_biodata e ON d.biodata_id = e.biodata_id
            WHERE c.status_dokumen ='R'
            AND kd_store IN('OT_HO','TOL_HO','TOL_BD','TOL_JK','TOL_MD','TOL_ML','TOL_PK','TOL_PL','TOL_SB','TOL_SM','TOL_YG')
            AND YEAR(a.tgl_doc)>='2023' AND c.rej_komentar_2 LIKE '%(BATAL-HRD)%'
            ) a
            $where_app

            GROUP BY no_dok_tdk_masuk ORDER BY tgl_dok_tdk_masuk DESC
			LIMIT $start,$length
		";

		$query = $this->hrd->query($sql);
		// die(nl2br($this->hrd->last_query()));
		return $query->result_array();

	}

	public function getDataHistory2($search_no = "")
	{

        $where_app = "";
		if($search_no !== ""){
			$where_app = "WHERE no_dok_tdk_masuk LIKE '%$search_no%' ";
		}

        $sql = "SELECT a.* FROM(
            SELECT
            CASE WHEN LEFT(no_dok_tdk_masuk,3)='HRI' THEN 'IJIN' ELSE 'CUTI' END jenis,
            e.nip,e.nama_lengkap, a.no_dok_tdk_masuk, a.tdk_masuk_h_id,
            a.tgl_dok_tdk_masuk, a.keterangan,
            c.tgl_rej_2, c.rej_komentar_2
            FROM hrd_all.trn_tidak_masuk_h a
            LEFT JOIN hrd_all.trn_tidak_masuk_d b ON a.tdk_masuk_h_id = b.tdk_masuk_h_id
            LEFT JOIN hrd_all.trn_posting c ON a.tdk_masuk_h_id = c.tdk_masuk_h_id
            LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
            LEFT JOIN hrd_all.mst_biodata e ON d.biodata_id = e.biodata_id
            WHERE c.status_dokumen ='R'
            AND kd_store IN('OT_HO','TOL_HO','TOL_BD','TOL_JK','TOL_MD','TOL_ML','TOL_PK','TOL_PL','TOL_SB','TOL_SM','TOL_YG')
            AND YEAR(tgl_dok_tdk_masuk)>='2023'
            AND rej_komentar_2 LIKE '%(BATAL-HRD)%'

            UNION ALL
            SELECT
            'CUTI DISPENSASI',
            e.nip,e.nama_lengkap,a.no_dok_cuti no_dok_tdk_masuk,a.cuti_dispensasi_h_id tdk_masuk_h_id,
            a.tgl_dok_cuti tgl_dok_tdk_masuk,a.keterangan,
            c.tgl_rej_1, c.rej_komentar_2
            FROM hrd_all.trn_cuti_dispensasi_h a
            LEFT JOIN hrd_all.trn_cuti_dispensasi_d b ON a.cuti_dispensasi_h_id = b.cuti_dispensasi_h_id
            LEFT JOIN hrd_all.trn_posting c ON a.cuti_dispensasi_h_id = c.tdk_masuk_h_id
            LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
            LEFT JOIN hrd_all.mst_biodata e ON d.biodata_id = e.biodata_id
            WHERE c.status_dokumen ='R'
            AND kd_store IN('OT_HO','TOL_HO','TOL_BD','TOL_JK','TOL_MD','TOL_ML','TOL_PK','TOL_PL','TOL_SB','TOL_SM','TOL_YG')
            AND YEAR(tgl_dok_cuti)>='2023' AND rej_komentar_2 LIKE '%(BATAL-HRD)%'
            UNION ALL
            SELECT
            'CUTI PENGGANTI',
            a.nip,e.nama_lengkap,a.no_doc no_dok_tdk_masuk,a.no_doc tdk_masuk_h_id,tgl_doc tgl_dok_tdk_masuk, a.keterangan,
            c.tgl_rej_1, c.rej_komentar_2
            FROM hrd_all.trn_pengajuan_cuti_tambahan a
            LEFT JOIN hrd_all.trn_posting c ON a.no_doc = c.tdk_masuk_h_id
            LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.pic_input = d.biodata_id
            LEFT JOIN hrd_all.mst_biodata e ON d.biodata_id = e.biodata_id
            WHERE c.status_dokumen ='R'
            AND kd_store IN('OT_HO','TOL_HO','TOL_BD','TOL_JK','TOL_MD','TOL_ML','TOL_PK','TOL_PL','TOL_SB','TOL_SM','TOL_YG')
            AND YEAR(a.tgl_doc)>='2023' AND c.rej_komentar_2 LIKE '%(BATAL-HRD)%'
            ) a
            $where_app

            GROUP BY no_dok_tdk_masuk ORDER BY tgl_dok_tdk_masuk DESC
        ";
		$jum= $this->hrd->query($sql);
		return $jum->num_rows();
	}
    /*--END  get datables */


    /* get data */
    public function headerDok($no_dok = null, $test = NULL)
	{
		if(!$no_dok) {
			return false;
		}

        $sql_pic 			= $this->Model_leave->getDataPicDewaHrd();


        if($sql_pic['level'] == '2'){
            $where = 'AND kd_store IN ("SP_HO","OT_HO","OT_ME1","TOL_HO","TOL_JK","TOL_PL","TOL_SB","TOL_YG","TOL_BD","TOL_MD","TOL_ML","TOL_PK","TOL_SM")';
        } else if($sql_pic['level'] == '3') {
            $where = 'AND kd_store NOT IN ("SP_HO","OT_HO","OT_ME1","TOL_HO","TOL_JK","TOL_PL","TOL_SB","TOL_YG","TOL_BD","TOL_MD","TOL_ML","TOL_PK","TOL_SM")';
        }

        $sql = "SELECT * FROM(
            SELECT
            CASE WHEN LEFT(no_dok_tdk_masuk,3)='HRI' THEN 'IJIN' ELSE 'CUTI' END jenis,
            nip,nama_lengkap,no_dok_tdk_masuk, a.tdk_masuk_h_id, tgl_dok_tdk_masuk,  a.keterangan, c.status_dokumen, e.biodata_id,
            f.ket_status_absensi status_absensi, a.potong_cuti_dari sumber_potong
            FROM hrd_all.trn_tidak_masuk_h a
            LEFT JOIN hrd_all.trn_posting c ON a.tdk_masuk_h_id = c.tdk_masuk_h_id
            LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
            LEFT JOIN hrd_all.mst_biodata e ON d.biodata_id = e.biodata_id
            LEFT JOIN hrd_all.mst_status_absensi f ON a.status_absensi_id = f.status_absensi_id
            WHERE c.status_dokumen IN('P','C')
            -- AND is_posting = 0
            $where
            AND IFNULL(a.pic_edit,'')='' AND YEAR(tgl_dok_tdk_masuk)>='2023'
            UNION ALL
            SELECT
            'CUTI DISPENSASI',
            nip,nama_lengkap,no_dok_cuti no_dok_tdk_masuk,cuti_dispensasi_h_id tdk_masuk_h_id,tgl_dok_cuti tgl_dok_tdk_masuk,  a.keterangan
            , c.status_dokumen, e.biodata_id,f.ket_status_absensi status_absensi, NULL sumber_potong
            FROM hrd_all.trn_cuti_dispensasi_h a
            LEFT JOIN hrd_all.trn_posting c ON a.cuti_dispensasi_h_id = c.tdk_masuk_h_id
            LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
            LEFT JOIN hrd_all.mst_biodata e ON d.biodata_id = e.biodata_id
            LEFT JOIN hrd_all.mst_status_absensi f ON a.kode_status_absensi = f.kode_status_absensi
            WHERE c.status_dokumen IN('P','C')
            -- AND is_posting =0
            $where
            AND IFNULL(a.pic_edit,'')='' AND YEAR(tgl_dok_cuti)>='2023'
            UNION ALL
            SELECT
            'CUTI PENGGANTI',
            a.nip,e.nama_lengkap,a.no_doc no_dok_tdk_masuk,a.no_doc tdk_masuk_h_id,tgl_doc tgl_dok_tdk_masuk,
            a.keterangan, c.status_dokumen, e.biodata_id, NULL status_absensi, NULL sumber_potong
            FROM hrd_all.trn_pengajuan_cuti_tambahan a
            LEFT JOIN hrd_all.trn_posting c ON a.no_doc = c.tdk_masuk_h_id
            LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.pic_input = d.biodata_id
            LEFT JOIN hrd_all.mst_biodata e ON d.biodata_id = e.biodata_id
            WHERE c.status_dokumen IN('P','C')
            AND IFNULL(a.is_ditolak,'')=''
            -- AND IFNULL(a.is_hrd,'')=''
            AND IFNULL(a.tgl_tolak,'')=''
            $where
            AND YEAR(a.tgl_doc)>='2023'
            )a
            WHERE  a.no_dok_tdk_masuk = '$no_dok'
            ";

		$query = $this->hrd->query($sql);
		// die(nl2br($this->hrd->last_query()));
		return $query->row_array();
	}

    public function headerDokUser($no_dok = null)
	{
		if(!$no_dok) {
			return false;
		}

        $sql = "SELECT * FROM(
            SELECT
            CASE WHEN LEFT(no_dok_tdk_masuk,3)='HRI' THEN 'IJIN' ELSE 'CUTI' END jenis,
            nip,nama_lengkap,no_dok_tdk_masuk, a.tdk_masuk_h_id, tgl_dok_tdk_masuk,  a.keterangan
            FROM hrd_all.trn_tidak_masuk_h a
            LEFT JOIN hrd_all.trn_posting c ON a.tdk_masuk_h_id = c.tdk_masuk_h_id
            LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
            LEFT JOIN hrd_all.mst_biodata e ON d.biodata_id = e.biodata_id
            WHERE c.status_dokumen ='O'
            -- AND is_posting = 0
            -- AND kd_store IN('OT_HO','TOL_HO','TOL_BD','TOL_JK','TOL_MD','TOL_ML','TOL_PK','TOL_PL','TOL_SB','TOL_SM','TOL_YG')
            AND IFNULL(a.pic_edit,'')='' AND YEAR(tgl_dok_tdk_masuk)>='2023'
            UNION ALL
            SELECT
            'CUTI DISPENSASI',
            nip,nama_lengkap,no_dok_cuti no_dok_tdk_masuk,cuti_dispensasi_h_id tdk_masuk_h_id,tgl_dok_cuti tgl_dok_tdk_masuk,  a.keterangan
            FROM hrd_all.trn_cuti_dispensasi_h a
            LEFT JOIN hrd_all.trn_posting c ON a.cuti_dispensasi_h_id = c.tdk_masuk_h_id
            LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
            LEFT JOIN hrd_all.mst_biodata e ON d.biodata_id = e.biodata_id
            WHERE status_dokumen ='O'
            -- AND is_posting =0
            -- AND kd_store IN('OT_HO','TOL_HO','TOL_BD','TOL_JK','TOL_MD','TOL_ML','TOL_PK','TOL_PL','TOL_SB','TOL_SM','TOL_YG')
            AND IFNULL(a.pic_edit,'')='' AND YEAR(tgl_dok_cuti)>='2023'
            UNION ALL
            SELECT
            'CUTI PENGGANTI',
            a.nip,e.nama_lengkap,a.no_doc no_dok_tdk_masuk,a.no_doc tdk_masuk_h_id,tgl_doc tgl_dok_tdk_masuk, a.keterangan
            FROM hrd_all.trn_pengajuan_cuti_tambahan a
            LEFT JOIN hrd_all.trn_posting c ON a.no_doc = c.tdk_masuk_h_id
            LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.pic_input = d.biodata_id
            LEFT JOIN hrd_all.mst_biodata e ON d.biodata_id = e.biodata_id
            WHERE status_dokumen ='O'
            AND IFNULL(a.is_ditolak,'')=''
            AND IFNULL(a.is_hrd,'')=''
            AND IFNULL(a.tgl_tolak,'')=''
            -- AND kd_store IN('OT_HO','TOL_HO','TOL_BD','TOL_JK','TOL_MD','TOL_ML','TOL_PK','TOL_PL','TOL_SB','TOL_SM','TOL_YG')
            AND YEAR(a.tgl_doc)>='2023'
            )a
            WHERE a.no_dok_tdk_masuk = '$no_dok'";

		$query = $this->hrd->query($sql);
		// die(nl2br($this->hrd->last_query()));
		return $query->row_array();
	}

    public function getDetailCutiIjin($tdk_masuk_h_id = null)
	{
		if(!$tdk_masuk_h_id) {
			return false;
		}

        $sql = "SELECT tgl_tdk_masuk, nama_hari, keterangan, is_batal FROM hrd_all.trn_tidak_masuk_d
        WHERE tdk_masuk_h_id = ?
        ORDER BY tgl_tdk_masuk";

		$query = $this->hrd->query($sql, array($tdk_masuk_h_id));
		// die(nl2br($this->hrd->last_query()));
		return $query->result_array();
	}

    public function getDetailDispensasi($tdk_masuk_h_id = null)
	{
		if(!$tdk_masuk_h_id) {
			return false;
		}

        $sql = "SELECT tgl_cuti as tgl_tdk_masuk,nama_hari,keterangan, cuti_dispensasi_d_id FROM hrd_all.trn_cuti_dispensasi_d
        WHERE cuti_dispensasi_h_id = ?
        ORDER BY tgl_cuti";

		$query = $this->hrd->query($sql, array($tdk_masuk_h_id));
		return $query->result_array();
	}

    public function getDetailPengganti($tdk_masuk_h_id = null)
	{
		if(!$tdk_masuk_h_id) {
			return false;
		}

        $sql = "SELECT tgl_awal as tgl_tdk_masuk,tgl_awal nama_hari,keterangan
        FROM hrd_all.trn_pengajuan_cuti_tambahan
        WHERE no_doc = ?
        ORDER BY tgl_awal DESC";

		$query = $this->hrd->query($sql, array($tdk_masuk_h_id));
		return $query->result_array();
	}

    public function getLampiran($no_dok = null)
    {
        if(!$no_dok) {
			return false;
		}

        $sql = "SELECT * FROM hrd_all.trn_dokumen_ijin WHERE no_dok = ? ";

		$query = $this->hrd->query($sql, array($no_dok));
		return $query->row_array();
        // return $query->num_fields();
        // return $query->field_data();
    }

    public function getDetilTambahan($no_dok, $tgl_cuti)
    {
        if(!$no_dok) {
			return false;
		}

        $sql = "SELECT * FROM hrd_all.trn_detil_cuti_tambahan
        WHERE no_dok_tdk_masuk = '$no_dok'
        AND tgl_tdk_masuk = '$tgl_cuti'
        ORDER BY tgl_tdk_masuk DESC";

		$query = $this->hrd->query($sql);

        // die($this->hrd->last_query());
		return $query->row_array();
    }

    public function getDetilNormatif($no_dok, $tgl_cuti)
    {
        if(!$no_dok) {
			return false;
		}

        $sql = "SELECT * FROM hrd_all.trn_detil_cuti_normatif
        WHERE no_dok_tdk_masuk = '$no_dok'
        AND tgl_tdk_masuk = '$tgl_cuti'
        ORDER BY tgl_tdk_masuk DESC";

		$query = $this->hrd->query($sql);

        // die($this->hrd->last_query());
		return $query->row_array();
    }

    public function getDetailDocNormatif($trn_tdk_masuk_id, $tgl_cuti)
    {
        if(!$trn_tdk_masuk_id) {
			return false;
		}

        $sql = "SELECT * FROM hrd_all.trn_tidak_masuk_d
        WHERE tdk_masuk_h_id = '$trn_tdk_masuk_id'
        AND tgl_tdk_masuk = '$tgl_cuti'
        ORDER BY tgl_tdk_masuk DESC";

		$query = $this->hrd->query($sql);

        // die($this->hrd->last_query());
		return $query->row_array();
    }

    public function sumDetailNormatifBatal($trn_tdk_masuk_id)
    {
        if(!$trn_tdk_masuk_id) {
			return false;
		}

        $sql = "SELECT * FROM hrd_all.trn_tidak_masuk_d
        WHERE tdk_masuk_h_id = '$trn_tdk_masuk_id'
        AND is_batal = '0'
        ORDER BY tgl_tdk_masuk DESC";

		$query = $this->hrd->query($sql);

        // die($this->hrd->last_query());
		return $query->num_rows();
    }

    public function getSaldoTambahan($no_reff)
    {
		$sql 	= "SELECT * FROM hrd_all.trn_saldo_cuti_tambahan
					WHERE no_dok_cuti_tambahan = '$no_reff' ";
		$query 	= $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return 	$query->row_array();
	}

    public function cekLogSaldoTambahan($no_reff)
    {
        if(!$no_reff) {
			return false;
		}

        $sql = "SELECT * FROM hrd_all.trn_detil_cuti_tambahan
        WHERE no_reff = '$no_reff'
        GROUP BY no_dok_tdk_masuk
        ";
		$query = $this->hrd->query($sql);

        // die($this->hrd->last_query());
		return $query->result_array();
    }

    /*--END get data */


/*------- Proses Action ------*/

    #--- Batal Proses Hrd & User
    public function actionBatal()
    {
        $verifikasi = $this->Model_leave->PicVerifikasiHrd();
        $no_dok     = $_POST['no_dok'];

        $ket_batal  = $_POST['keterangan_batal'];


        $pic_batal  = $this->session->userdata('nama_login');

        $cek            = $this->headerDokUser($no_dok);
        $posting = array(
            'status_dokumen'        => 'R',
            'rej_1'				    => $pic_batal,
            'tgl_rej_1'				=> date('Y-m-d h:i:s'),
            'rej_komentar_1'		=> '(BATAL-USER) '.$_POST['keterangan_batal']
        );


        $tdk_masuk_h_id = $cek['tdk_masuk_h_id'];

        $header = array(
            'is_posting'            => 0,
            'is_batal'				=> 1,
            'tgl_batal'				=> date('Y-m-d'),
            'pic_batal'				=> $pic_batal,
            'ket_batal'				=> $ket_batal
        );

        $header_pengganti = array(
            'is_hrd'			=> 'N',
            'is_ditolak'		=> 'Y',
            'tgl_tolak'			=> date('Y-m-d')
        );

        $detail = array(
            'is_batal'				=> 1,
            'tgl_batal'				=> date('Y-m-d'),
            'pic_batal'				=> $pic_batal,
            'ket_batal'				=> $ket_batal
        );


        // tesx($header, $detail, $posting);

        #Proses Simpan Data
        if($cek['jenis']=='CUTI DISPENSASI'){

            $this->hrd->set($header);
            $this->hrd->where('cuti_dispensasi_h_id', $tdk_masuk_h_id);
            $this->hrd->update('hrd_all.trn_cuti_dispensasi_h');

            $this->hrd->set($detail);
            $this->hrd->where('cuti_dispensasi_h_id', $tdk_masuk_h_id);
            $this->hrd->update('hrd_all.trn_cuti_dispensasi_d');

        }elseif($cek['jenis']=='CUTI PENGGANTI'){

            $this->hrd->set($header_pengganti);
            $this->hrd->where('no_doc', $tdk_masuk_h_id);
            $this->hrd->update('hrd_all.trn_pengajuan_cuti_tambahan');

        }else{

            $this->hrd->set($header);
            $this->hrd->where('tdk_masuk_h_id', $tdk_masuk_h_id);
            $this->hrd->update('hrd_all.trn_tidak_masuk_h');

            $this->hrd->set($detail);
            $this->hrd->where('tdk_masuk_h_id', $tdk_masuk_h_id);
            $this->hrd->update('hrd_all.trn_tidak_masuk_d');
        }


        $this->hrd->set($posting);
        $this->hrd->where('tdk_masuk_h_id', $tdk_masuk_h_id);
        $this->hrd->update('hrd_all.trn_posting');


        return $no_dok;
    }

    public function actionBatalHrd()
    {
        $verifikasi = $this->Model_leave->PicVerifikasiHrd();
        $no_dok     = $_POST['no_dok'];

        $ket_batal  = $_POST['keterangan_batal'];


        $pic_batal  = $this->session->userdata('nama_login');

        $cek            = $this->headerDokUser($no_dok);
        $posting = array(
            'status_dokumen'        => 'R',
            'rej_1'				    => $pic_batal,
            'tgl_rej_1'				=> date('Y-m-d h:i:s'),
            'rej_komentar_1'		=> '(BATAL-USER) '.$_POST['keterangan_batal']
        );


        $tdk_masuk_h_id = $cek['tdk_masuk_h_id'];

        $header = array(
            'is_posting'            => 0,
            'is_batal'				=> 1,
            'tgl_batal'				=> date('Y-m-d'),
            'pic_batal'				=> $pic_batal,
            'ket_batal'				=> $ket_batal
        );

        $header_pengganti = array(
            'is_hrd'			=> 'N',
            'is_ditolak'		=> 'Y',
            'tgl_tolak'			=> date('Y-m-d')
        );

        $detail = array(
            'is_batal'				=> 1,
            'tgl_batal'				=> date('Y-m-d'),
            'pic_batal'				=> $pic_batal,
            'ket_batal'				=> $ket_batal
        );


        // tesx($header, $detail, $posting);

        #Proses Simpan Data
        if($cek['jenis']=='CUTI DISPENSASI'){

            $this->hrd->set($header);
            $this->hrd->where('cuti_dispensasi_h_id', $tdk_masuk_h_id);
            $this->hrd->update('hrd_all.trn_cuti_dispensasi_h');

            $this->hrd->set($detail);
            $this->hrd->where('cuti_dispensasi_h_id', $tdk_masuk_h_id);
            $this->hrd->update('hrd_all.trn_cuti_dispensasi_d');

        }elseif($cek['jenis']=='CUTI PENGGANTI'){

            $this->hrd->set($header_pengganti);
            $this->hrd->where('no_doc', $tdk_masuk_h_id);
            $this->hrd->update('hrd_all.trn_pengajuan_cuti_tambahan');

        }else{

            $this->hrd->set($header);
            $this->hrd->where('tdk_masuk_h_id', $tdk_masuk_h_id);
            $this->hrd->update('hrd_all.trn_tidak_masuk_h');

            $this->hrd->set($detail);
            $this->hrd->where('tdk_masuk_h_id', $tdk_masuk_h_id);
            $this->hrd->update('hrd_all.trn_tidak_masuk_d');
        }


        $this->hrd->set($posting);
        $this->hrd->where('tdk_masuk_h_id', $tdk_masuk_h_id);
        $this->hrd->update('hrd_all.trn_posting');


        return $no_dok;
    }
    #--- END Batal Proses Hrd & User




    #--- Batal Posting Cuti Dispensasi
    public function actionBatalCutiDispensasi()
    {
        $no_dok     = $_POST['no_dok'];

        $ket_batal  = $_POST['keterangan_batal'];

        $pic_batal  = $this->session->userdata('nama_login');

        #Get Header Cuti Normatif
        $header_dok         = $this->headerDok($no_dok);
        $tdk_masuk_h_id     = $header_dok['tdk_masuk_h_id'];

        $detail_dok         = $this->getDetailDispensasi($tdk_masuk_h_id);

        #--- Proses Looping Tgl Cuti
        $log_detil_batal = array();
        for($x=0; $x < count($detail_dok); $x++){

            #Get Tgl Absen
            $cek_tgl_absen      = $this->Model_leave->getAbsensi($header_dok['biodata_id'], $detail_dok[$x]['tgl_tdk_masuk']);
            $cuti_dispensasi_d_id     = $detail_dok[$x]['cuti_dispensasi_d_id'];

            #--- Delete Absen
            if($cek_tgl_absen == TRUE){

                tesx($cek_tgl_absen);

                $where_delete_absen = array(
                    'biodata_id'        => $header_dok['biodata_id'],
                    'no_reff'           => $header_dok['no_dok_tdk_masuk'],
                    'tgl_absensi'       => $detail_dok[$x]['tgl_tdk_masuk'],
                    'is_manual'         => $cek_tgl_absen['is_manual'],
                );
                $this->hrd->where($where_delete_absen);
                $this->hrd->delete('hrd_all.trn_absensi');

            }

            #--- Update Detail
            $detail_batal = array(
                'is_batal'          => '1',
                'tgl_batal'         => date('Y-m-d h:i:s'),
                'pic_batal'         => $pic_batal,
                'ket_batal'         => '(BATAL-HRD) '.$_POST['keterangan_batal'],
                'cuti_dispensasi_d_id' => $cuti_dispensasi_d_id
            );
            $this->hrd->set($detail_batal);
            $this->hrd->where('cuti_dispensasi_d_id', $cuti_dispensasi_d_id);
            $this->hrd->update('hrd_all.trn_cuti_dispensasi_d');

        }

        #--- Update Header Dok
        $header_batal = array(
            'is_batal'          => '1',
            'tgl_batal'         => date('Y-m-d h:i:s'),
            'pic_batal'         => $pic_batal,
            'ket_batal'         => '(BATAL-HRD) '.$_POST['keterangan_batal'],
        );
        $this->hrd->set($header_batal);
        $this->hrd->where('cuti_dispensasi_d_id', $tdk_masuk_h_id);
        $this->hrd->update('hrd_all.trn_cuti_dispensasi_h');

        #--- Update Posting Dok
        $posting = array(
            'status_dokumen'        => 'R',
            'rej_2'				    => $pic_batal,
            'tgl_rej_2'				=> date('Y-m-d h:i:s'),
            'rej_komentar_2'		=> '(BATAL-HRD) '.$_POST['keterangan_batal']
        );
        $this->hrd->set($posting);
        $this->hrd->where('tdk_masuk_h_id', $tdk_masuk_h_id);
        $this->hrd->update('hrd_all.trn_posting');


        return ($no_dok) ? $no_dok : false;

    }


    #--- Batal Posting Ijin
    public function actionBatalIjin()
    {
        $no_dok     = $_POST['no_dok'];

        $tgl_cuti   = $_POST['tgl_cuti'];

        $ket_batal  = $_POST['keterangan_batal'];

        $pic_batal  = $this->session->userdata('nama_login');

        #Get Header Cuti Normatif
        $cek_dok        = $this->headerDok($no_dok);
        $tdk_masuk_h_id = $cek_dok['tdk_masuk_h_id'];

        #Get Detil Cuti Normatif Batal
        $sum_batal      = $this->sumDetailNormatifBatal($tdk_masuk_h_id);

        $tgl_sort = $_POST['tgl_cuti'];
        asort($tgl_cuti);

        $log_detil_batal = array();
        for($x=0; $x < count($tgl_cuti); $x++ ){

            #Get Log Detil Cuti Normatif
            $detail_normatif    = $this->getDetailDocNormatif($tdk_masuk_h_id , $tgl_cuti[$x]);
            $tdk_masuk_d_id     = $detail_normatif['tdk_masuk_d_id'];

            #Get Tgl Absen
            $cek_tgl_absen      = $this->Model_leave->getAbsensi($cek_dok['biodata_id'], $tgl_cuti[$x]);


            if($cek_tgl_absen == TRUE){

                #--- Delete Absen
                $where_delete_absen = array(
                    'biodata_id'        => $cek_dok['biodata_id'],
                    'no_reff'           => $cek_dok['no_dok_tdk_masuk'],
                    'tgl_absensi'       => $tgl_cuti[$x],
                    'is_manual'         => $cek_tgl_absen['is_manual'],
                );
                $this->hrd->where($where_delete_absen);
                $this->hrd->delete('hrd_all.trn_absensi');

            }

            #--- Update Detail Ijin
            $detail_batal = array(
                'is_batal'          => '1',
                'tgl_batal'         => date('Y-m-d h:i:s'),
                'pic_batal'         => $pic_batal,
                'ket_batal'         => '(BATAL-HRD) '.$_POST['keterangan_batal'],
            );
            $this->hrd->set($detail_batal);
            $this->hrd->where('tdk_masuk_d_id', $tdk_masuk_d_id);
            $this->hrd->update('hrd_all.trn_tidak_masuk_d');

        }

        $sum_tgl   = count($tgl_cuti);

        if($sum_tgl == $sum_batal){

            #--- Update Header
            $header_batal = array(
                'is_batal'          => '1',
                'tgl_batal'         => date('Y-m-d h:i:s'),
                'pic_batal'         => $pic_batal,
                'ket_batal'         => '(BATAL-HRD) '.$_POST['keterangan_batal'],
            );
            $this->hrd->set($header_batal);
            $this->hrd->where('tdk_masuk_h_id', $tdk_masuk_h_id);
            $this->hrd->update('hrd_all.trn_tidak_masuk_h');

            #--- Update Posting
            $posting = array(
                'status_dokumen'        => 'R',
                'rej_2'				    => $pic_batal,
                'tgl_rej_2'				=> date('Y-m-d h:i:s'),
                'rej_komentar_2'		=> '(BATAL-HRD) '.$_POST['keterangan_batal']
            );
            $this->hrd->set($posting);
            $this->hrd->where('tdk_masuk_h_id', $tdk_masuk_h_id);
            $this->hrd->update('hrd_all.trn_posting');

        }

        return ($no_dok) ? $no_dok : false;
    }


    #--- Batal Posting Cuti Normatif
    public function actionBatalCutiNormatif()
    {

        $no_dok     = $_POST['no_dok'];

        $tgl_cuti   = $_POST['tgl_cuti'];

        $ket_batal  = $_POST['keterangan_batal'];

        $pic_batal  = $this->session->userdata('nama_login');

        #Get Header Cuti Normatif
        $cek_dok        = $this->headerDok($no_dok);
        $tdk_masuk_h_id = $cek_dok['tdk_masuk_h_id'];

        #Get Detil Cuti Normatif Batal
        $sum_batal      = $this->sumDetailNormatifBatal($tdk_masuk_h_id);

        $tgl_sort = $_POST['tgl_cuti'];
        asort($tgl_cuti);

        $log_detil_batal = array();
        for($x=0; $x < count($tgl_cuti); $x++ ){

            #Get Log Detil Cuti Normatif
            $log_normatif       = $this->getDetilNormatif($no_dok, $tgl_cuti[$x]);
            $detail_normatif    = $this->getDetailDocNormatif($tdk_masuk_h_id , $tgl_cuti[$x]);

            $tdk_masuk_d_id     = $detail_normatif['tdk_masuk_d_id'];

            #Get Saldo Cuti Normatif
            $saldo_normatif     = $this->Model_cuti->getDataNormatif($log_normatif['biodata_id']);

            #Get Tgl Absen
            $cek_tgl_absen      = $this->Model_leave->getAbsensi($log_normatif['biodata_id'], $tgl_cuti[$x]);


            if($cek_tgl_absen == TRUE){

                #--- Delete Absen
                $where_delete_absen = array(
                    'biodata_id'        => $log_normatif['biodata_id'],
                    'no_reff'           => $log_normatif['no_dok_tdk_masuk'],
                    'tgl_absensi'       => $tgl_cuti[$x],
                    'is_manual'         => $cek_tgl_absen['is_manual'],
                );
                $this->hrd->where($where_delete_absen);
                $this->hrd->delete('hrd_all.trn_absensi');

            }


            #--- Update Saldo Normatif
            $saldo_update = $saldo_normatif['sisa_normatif'] + $log_normatif['nilai'];
            $saldo_awal   = $saldo_update + $log_normatif['nilai'];
            $data_saldo   = array(
                'saldo_awal'      => $saldo_awal,
                'sisa_cuti'       => $saldo_update
            );
            $where_update_saldo= array(
                'biodata_id'                => $log_normatif['biodata_id'],
                'saldo_cuti_normatif_id'    => $saldo_normatif['saldo_cuti_normatif_id']
            );
            $this->hrd->set($data_saldo);
            $this->hrd->where($where_update_saldo);
            $this->hrd->update('hrd_all.trn_saldo_cuti_normatif');


            #--- Update Detail
            $detail_batal = array(
                'is_batal'          => '1',
                'tgl_batal'         => date('Y-m-d h:i:s'),
                'pic_batal'         => $pic_batal,
                'ket_batal'         => '(BATAL-HRD) '.$_POST['keterangan_batal'],
            );
            $this->hrd->set($detail_batal);
            $this->hrd->where('tdk_masuk_d_id', $tdk_masuk_d_id);
            $this->hrd->update('hrd_all.trn_tidak_masuk_d');

        }

        $sum_tgl   = count($tgl_cuti);

        if($sum_tgl == $sum_batal){

            #--- Update Header Dok
            $header_batal = array(
                'is_batal'          => '1',
                'tgl_batal'         => date('Y-m-d h:i:s'),
                'pic_batal'         => $pic_batal,
                'ket_batal'         => '(BATAL-HRD) '.$_POST['keterangan_batal'],
            );
            $this->hrd->set($header_batal);
            $this->hrd->where('tdk_masuk_h_id', $tdk_masuk_h_id);
            $this->hrd->update('hrd_all.trn_tidak_masuk_h');

            #--- Update Posting Dok
            $posting = array(
                'status_dokumen'        => 'R',
                'rej_2'				    => $pic_batal,
                'tgl_rej_2'				=> date('Y-m-d h:i:s'),
                'rej_komentar_2'		=> '(BATAL-HRD) '.$_POST['keterangan_batal']
            );
            $this->hrd->set($posting);
            $this->hrd->where('tdk_masuk_h_id', $tdk_masuk_h_id);
            $this->hrd->update('hrd_all.trn_posting');

        }

        return ($no_dok) ? $no_dok : false;

    }


    #--- Batal Posting Cuti Tambahan
    public function actionBatalCutiTambahan()
    {

        $no_dok         = $_POST['no_dok'];

        $tgl_cuti       = $_POST['tgl_cuti'];

        $ket_batal      = $_POST['keterangan_batal'];

        $pic_batal      = $this->session->userdata('nama_login');

        $cek_dok        = $this->headerDok($no_dok);
        $tdk_masuk_h_id = $cek_dok['tdk_masuk_h_id'];

        #Get Detil Cuti Normatif Batal
        $sum_batal      = $this->sumDetailNormatifBatal($tdk_masuk_h_id);

        $tgl_sort       =   $_POST['tgl_cuti'];
                            ($tgl_cuti);

        $log_detil_batal = array();
        for($x=0; $x < count($tgl_cuti); $x++ ){

            #Get Log Detil Cuti Tambahan
            $log_tambahan       = $this->getDetilTambahan($no_dok, $tgl_cuti[$x]);

            #Get Tgl Absen
            $cek_tgl_absen      = $this->Model_leave->getAbsensi($log_tambahan['biodata_id'], $tgl_cuti[$x]);

            $detail_normatif    = $this->getDetailDocNormatif($tdk_masuk_h_id , $tgl_cuti[$x]);
            $tdk_masuk_d_id     = $detail_normatif['tdk_masuk_d_id'];

            #--- Delete Absen
            if($cek_tgl_absen == TRUE){

                #--- where id
                $where_delete_absen = array(
                    'biodata_id'        => $log_tambahan['biodata_id'],
                    'no_reff'           => $log_tambahan['no_dok_tdk_masuk'],
                    'tgl_absensi'       => $tgl_cuti[$x],
                    'is_manual'         => $cek_tgl_absen['is_manual'],
                );
                $this->hrd->where($where_delete_absen);
                $this->hrd->delete('hrd_all.trn_absensi');

            }

            #Get Saldo Cuti Tambahan
            $saldo_tambahan     = $this->getSaldoTambahan($log_tambahan['no_reff']);

            #--- Update Saldo Tambahan
            $saldo_update = $saldo_tambahan['sisa_cuti'] + $log_tambahan['nilai'];
            $saldo_awal   = $saldo_tambahan['saldo_awal'] - $log_tambahan['nilai'];
            $data_saldo   = array(
                'saldo_awal'      => $saldo_awal,
                'sisa_cuti'       => $saldo_update
            );
            $where_update_saldo= array(
                'no_dok_cuti_tambahan'      => $saldo_tambahan['no_dok_cuti_tambahan']
            );
            $this->hrd->set($data_saldo);
            $this->hrd->where($where_update_saldo);
            $this->hrd->update('hrd_all.trn_saldo_cuti_tambahan');


            #--- Update Detail
            $detail_batal = array(
                'is_batal'          => '1',
                'tgl_batal'         => date('Y-m-d h:i:s'),
                'pic_batal'         => $pic_batal,
                'ket_batal'         => '(BATAL-HRD) '.$_POST['keterangan_batal'],
            );
            $this->hrd->set($detail_batal);
            $this->hrd->where('tdk_masuk_d_id', $tdk_masuk_d_id);
            $this->hrd->update('hrd_all.trn_tidak_masuk_d');


            #--- Delete Log Detil Tambahan
            if($log_tambahan == TRUE){

                $where_delete_log = array(
                    'id'                => $log_tambahan['id'],
                    'no_reff'           => $log_tambahan['no_reff'],
                    'tgl_tdk_masuk'     => $tgl_cuti[$x],
                );
                $this->hrd->where($where_delete_log);
                $this->hrd->delete('hrd_all.trn_detil_cuti_tambahan');
            }

        }

        $sum_tgl   = count($tgl_cuti);

        if($sum_tgl == $sum_batal){

            #--- Update Header Dok
            $header_batal = array(
                'is_batal'          => '1',
                'tgl_batal'         => date('Y-m-d h:i:s'),
                'pic_batal'         => $pic_batal,
                'ket_batal'         => '(BATAL-HRD) '.$_POST['keterangan_batal'],
            );
            $this->hrd->set($header_batal);
            $this->hrd->where('tdk_masuk_h_id', $tdk_masuk_h_id);
            $this->hrd->update('hrd_all.trn_tidak_masuk_h');

            #--- Update Posting Dok
            $posting = array(
                'status_dokumen'        => 'R',
                'rej_2'				    => $pic_batal,
                'tgl_rej_2'				=> date('Y-m-d h:i:s'),
                'rej_komentar_2'		=> '(BATAL-HRD) '.$_POST['keterangan_batal']
            );
            $this->hrd->set($posting);
            $this->hrd->where('tdk_masuk_h_id', $tdk_masuk_h_id);
            $this->hrd->update('hrd_all.trn_posting');
        }

        return ($no_dok) ? $no_dok : false;

    }


    #--- Batal Posting Cuti Pengganti
    public function actionBatalCutiPengganti()
    {

        $no_dok     = $_POST['no_dok'];

        $ket_batal  = $_POST['keterangan_batal'];

        $pic_batal  = $this->session->userdata('nama_login');

        $cek_dok    = $this->headerDok($no_dok);

        #--- Cek Saldo Cuti Tambahan Is Terpakai
        $log_tambahan      = $this->cekLogSaldoTambahan($no_dok);

        #--- Cek Saldo Tambahan Terpakai Pada LOG
        $log_no_dok = array();
        for($x=0; $x < count($log_tambahan); $x++){
            $no_dok_tdk_masuk = $log_tambahan[$x]['no_dok_tdk_masuk'];
            array_push($log_no_dok,$no_dok_tdk_masuk);
        }

        #--- search & replace to on line
        $log_no_doks        = json_encode(array_values($log_no_dok));
        $firstReplace       = str_replace('[','',$log_no_doks);
        $second             = str_replace(']','',$firstReplace);
        $tree               = str_replace('"','',$second);
        $log_no_dokss       = str_replace(',',' / ',$tree);

        #--- Validasi jika ada saldo tambahan terpakai
        if(!empty($log_tambahan)){
            $this->session->set_flashdata('error', 'Saldo Cuti sudah Terpakai, Silahkan Batalkan
            Dokumen Cuti Berikut : <b>'.$log_no_dokss.' </b> ');
			redirect('leaves/batal/detail_hrd/'.$no_dok,  'refresh');
        }


        #--- Update Dok Saldo Cuti Tambahan
        $data_saldo = array(
            'sisa_cuti'             => '0',
            'is_batal'				=> '1',
            'pic_batal'				=> $pic_batal,
            'tgl_batal'				=> date('Y-m-d h:i:s'),
            'ket_batal'		        => '(BATAL-HRD) '.$_POST['keterangan_batal']
        );
        $this->hrd->set($data_saldo);
        $this->hrd->where('no_dok_cuti_tambahan', $no_dok);
        $this->hrd->update('hrd_all.trn_saldo_cuti_tambahan');


        #--- Update Header Dok
        $header_batal = array(
            'is_ditolak'        => 'Y',
            'tgl_tolak'         => date('Y-m-d h:i:s'),
        );
        $this->hrd->set($header_batal);
        $this->hrd->where('no_doc', $no_dok);
        $this->hrd->update('hrd_all.trn_pengajuan_cuti_tambahan');

        #--- Update Posting Dok
        $posting = array(
            'status_dokumen'        => 'R',
            'rej_2'				    => $pic_batal,
            'tgl_rej_2'				=> date('Y-m-d h:i:s'),
            'rej_komentar_2'		=> '(BATAL-HRD) '.$_POST['keterangan_batal']
        );
        $this->hrd->set($posting);
        $this->hrd->where('tdk_masuk_h_id', $no_dok);
        $this->hrd->update('hrd_all.trn_posting');

        return ($no_dok) ? $no_dok : false;



    }



/*------- END Proses Action ------*/



}