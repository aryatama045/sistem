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

		$sql = "SELECT * FROM(
            SELECT
            CASE WHEN LEFT(no_dok_tdk_masuk,3)='HRI' THEN 'IJIN' ELSE 'CUTI' END jenis,
            nip,nama_lengkap,no_dok_tdk_masuk, a.tdk_masuk_h_id, tgl_dok_tdk_masuk,  a.keterangan
            FROM hrd_all.trn_tidak_masuk_h a
            LEFT JOIN hrd_all.trn_posting c ON a.tdk_masuk_h_id = c.tdk_masuk_h_id
            LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
            LEFT JOIN hrd_all.mst_biodata e ON d.biodata_id = e.biodata_id
            WHERE c.status_dokumen ='P'
            AND is_posting = 0
            $where
            AND IFNULL(a.pic_edit,'')='' AND YEAR(tgl_dok_tdk_masuk)>='2023'

            UNION ALL
            SELECT
            'CUTI DISPENSASI',
            nip,nama_lengkap,no_dok_cuti no_dok_tdk_masuk,cuti_dispensasi_h_id tdk_masuk_h_id,tgl_dok_cuti tgl_dok_tdk_masuk,  a.keterangan
            FROM hrd_all.trn_cuti_dispensasi_h a
            LEFT JOIN hrd_all.trn_posting c ON a.cuti_dispensasi_h_id = c.tdk_masuk_h_id
            LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
            LEFT JOIN hrd_all.mst_biodata e ON d.biodata_id = e.biodata_id
            WHERE status_dokumen ='P'
            AND is_posting =0
            $where
            AND IFNULL(a.pic_edit,'')='' AND YEAR(tgl_dok_cuti)>='2023'

            UNION ALL
            SELECT
            'CUTI PENGGANTI',
            a.nip,e.nama_lengkap,a.no_doc no_dok_tdk_masuk,a.no_doc tdk_masuk_h_id,tgl_doc tgl_dok_tdk_masuk, a.keterangan
            FROM hrd_all.trn_pengajuan_cuti_tambahan a
            LEFT JOIN hrd_all.trn_posting c ON a.no_doc = c.tdk_masuk_h_id
            LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.pic_input = d.biodata_id
            LEFT JOIN hrd_all.mst_biodata e ON d.biodata_id = e.biodata_id
            WHERE status_dokumen ='P'
            AND IFNULL(a.is_ditolak,'')=''
            AND IFNULL(a.is_hrd,'')=''
            AND IFNULL(a.tgl_tolak,'')=''
            $where
            AND YEAR(a.tgl_doc)>='2023'
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

        $sql = "SELECT * FROM(
            SELECT
            CASE WHEN LEFT(no_dok_tdk_masuk,3)='HRI' THEN 'IJIN' ELSE 'CUTI' END jenis,
            nip,nama_lengkap,no_dok_tdk_masuk, a.tdk_masuk_h_id, tgl_dok_tdk_masuk,  a.keterangan
            FROM hrd_all.trn_tidak_masuk_h a
            LEFT JOIN hrd_all.trn_posting c ON a.tdk_masuk_h_id = c.tdk_masuk_h_id
            LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
            LEFT JOIN hrd_all.mst_biodata e ON d.biodata_id = e.biodata_id
            WHERE c.status_dokumen ='P'
            AND is_posting = 0
            $where
            AND IFNULL(a.pic_edit,'')='' AND YEAR(tgl_dok_tdk_masuk)>='2023'

            UNION ALL
            SELECT
            'CUTI DISPENSASI',
            nip,nama_lengkap,no_dok_cuti no_dok_tdk_masuk,cuti_dispensasi_h_id tdk_masuk_h_id,tgl_dok_cuti tgl_dok_tdk_masuk,  a.keterangan
            FROM hrd_all.trn_cuti_dispensasi_h a
            LEFT JOIN hrd_all.trn_posting c ON a.cuti_dispensasi_h_id = c.tdk_masuk_h_id
            LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
            LEFT JOIN hrd_all.mst_biodata e ON d.biodata_id = e.biodata_id
            WHERE status_dokumen ='P'
            AND is_posting =0
            $where
            AND IFNULL(a.pic_edit,'')='' AND YEAR(tgl_dok_cuti)>='2023'

            UNION ALL
            SELECT
            'CUTI PENGGANTI',
            a.nip,e.nama_lengkap,a.no_doc no_dok_tdk_masuk,a.no_doc tdk_masuk_h_id,tgl_doc tgl_dok_tdk_masuk, a.keterangan
            FROM hrd_all.trn_pengajuan_cuti_tambahan a
            LEFT JOIN hrd_all.trn_posting c ON a.no_doc = c.tdk_masuk_h_id
            LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.pic_input = d.biodata_id
            LEFT JOIN hrd_all.mst_biodata e ON d.biodata_id = e.biodata_id
            WHERE status_dokumen ='P'
            AND IFNULL(a.is_ditolak,'')=''
            AND IFNULL(a.is_hrd,'')=''
            AND IFNULL(a.tgl_tolak,'')=''
            $where
            AND YEAR(a.tgl_doc)>='2023'
            )a
            $where_app
            ORDER BY tgl_dok_tdk_masuk DESC,nip, no_dok_tdk_masuk
        ";
		$jum= $this->hrd->query($sql);
		return $jum->num_rows();
	}
    /*--END  get datables */


    /* get detail */
    public function headerDok($no_dok = null)
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
            nip,nama_lengkap,no_dok_tdk_masuk, a.tdk_masuk_h_id, tgl_dok_tdk_masuk,  a.keterangan
            FROM hrd_all.trn_tidak_masuk_h a
            LEFT JOIN hrd_all.trn_posting c ON a.tdk_masuk_h_id = c.tdk_masuk_h_id
            LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
            LEFT JOIN hrd_all.mst_biodata e ON d.biodata_id = e.biodata_id
            WHERE c.status_dokumen ='P'
            AND is_posting = 0
            $where
            AND IFNULL(a.pic_edit,'')='' AND YEAR(tgl_dok_tdk_masuk)>='2023'
            UNION ALL
            SELECT
            'CUTI DISPENSASI',
            nip,nama_lengkap,no_dok_cuti no_dok_tdk_masuk,cuti_dispensasi_h_id tdk_masuk_h_id,tgl_dok_cuti tgl_dok_tdk_masuk,  a.keterangan
            FROM hrd_all.trn_cuti_dispensasi_h a
            LEFT JOIN hrd_all.trn_posting c ON a.cuti_dispensasi_h_id = c.tdk_masuk_h_id
            LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
            LEFT JOIN hrd_all.mst_biodata e ON d.biodata_id = e.biodata_id
            WHERE status_dokumen ='P'
            AND is_posting =0
            $where
            AND IFNULL(a.pic_edit,'')='' AND YEAR(tgl_dok_cuti)>='2023'
            UNION ALL
            SELECT
            'CUTI PENGGANTI',
            a.nip,e.nama_lengkap,a.no_doc no_dok_tdk_masuk,a.no_doc tdk_masuk_h_id,tgl_doc tgl_dok_tdk_masuk, a.keterangan
            FROM hrd_all.trn_pengajuan_cuti_tambahan a
            LEFT JOIN hrd_all.trn_posting c ON a.no_doc = c.tdk_masuk_h_id
            LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.pic_input = d.biodata_id
            LEFT JOIN hrd_all.mst_biodata e ON d.biodata_id = e.biodata_id
            WHERE status_dokumen ='P'
            AND IFNULL(a.is_ditolak,'')=''
            AND IFNULL(a.is_hrd,'')=''
            AND IFNULL(a.tgl_tolak,'')=''
            $where
            AND YEAR(a.tgl_doc)>='2023'
            )a
            WHERE a.no_dok_tdk_masuk = '$no_dok'";

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
            AND is_posting = 0
            AND kd_store IN('OT_HO','TOL_HO','TOL_BD','TOL_JK','TOL_MD','TOL_ML','TOL_PK','TOL_PL','TOL_SB','TOL_SM','TOL_YG')
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
            AND is_posting =0
            AND kd_store IN('OT_HO','TOL_HO','TOL_BD','TOL_JK','TOL_MD','TOL_ML','TOL_PK','TOL_PL','TOL_SB','TOL_SM','TOL_YG')
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
            AND kd_store IN('OT_HO','TOL_HO','TOL_BD','TOL_JK','TOL_MD','TOL_ML','TOL_PK','TOL_PL','TOL_SB','TOL_SM','TOL_YG')
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

        $sql = "SELECT tgl_tdk_masuk, nama_hari, keterangan FROM hrd_all.trn_tidak_masuk_d
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

        $sql = "SELECT tgl_cuti as tgl_tdk_masuk,nama_hari,keterangan FROM hrd_all.trn_cuti_dispensasi_d
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
    /*--END get detail */


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


    public function actionBatal()
    {
        $verifikasi = $this->Model_leave->PicVerifikasiHrd();
        $no_dok     = $_POST['no_dok'];

        $ket_batal  = $_POST['keterangan_batal'];


        $pic_batal  = $this->session->userdata('nama_login');

        if($this->session->userdata('nama_login') === $verifikasi['nip']) {
            $cek            = $this->headerDok($no_dok);

            $posting = array(
                'status_dokumen'        => 'R',
                'rej_2'				    => $pic_batal,
                'tgl_rej_2'				=> date('Y-m-d h:i:s'),
                'rej_komentar_2'		=> '(BATAL-HRD) '.$_POST['keterangan_batal']
            );
        }else{
            $cek            = $this->headerDokUser($no_dok);
            $posting = array(
                'status_dokumen'        => 'R',
                'rej_1'				    => $pic_batal,
                'tgl_rej_1'				=> date('Y-m-d h:i:s'),
                'rej_komentar_1'		=> '(BATAL-USER) '.$_POST['keterangan_batal']
            );
		}

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
            'is_ditolak'			=> 'Y',
            'tgl_tolak'				=> date('Y-m-d')
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

}