<?php

class Model_cuti extends CI_Model
{
	private $hrd;
	function __construct()
	{
		parent::__construct();
		$this->hrd = $this->load->database('hrd',TRUE);
		$this->hrdsave = $this->load->database('hrd_save',TRUE);
		$this->hrd_web_master = $this->load->database('hrd_web_master',TRUE);
	}

	public function getDataNoDoc($docCode, $date)
	{
		$sno_doc = $docCode.$date;

		$hasil=$this->hrd->query("SELECT RIGHT(no_dok_tdk_masuk,4)+1 as gencode FROM hrd_all.trn_tidak_masuk_h 
		WHERE no_dok_tdk_masuk LIKE '".$sno_doc."%' ORDER BY no_dok_tdk_masuk DESC LIMIT 1");
		// die($this->hrd->last_query());
        $result = $hasil->row_array();

		// die(json_encode($result));

		if($result){
			$urut = $result['gencode'];
			for ($i=4; $i > strlen($result['gencode']) ; $i--) {
				$urut = "0".$urut;
			}
			return $sno_doc.$urut;
		}else{
			return $sno_doc."0001";
        }
	}

	public function getStatusCuti(){
		$sql 	= "SELECT status_absensi_id, ket_status_absensi FROM hrd_all.mst_status_absensi ORDER BY ket_status_absensi ASC";
		$query 	= $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return 	$query->result_array();
	}

	public function getStatusAbsen($id){
		$sql 	= "SELECT * FROM hrd_all.mst_status_absensi WHERE status_absensi_id= '".$id."'";
		$query 	= $this->hrd->query($sql);
		// die($this->hrd->last_query());
		// die(json_encode($sql));
		return 	$query->row_array();
	}

	public function getKetAbsen($id){
		$sql 	= "SELECT * FROM hrd_all.mst_status_absensi WHERE kode_status_absensi= '".$id."'";
		$query 	= $this->hrd->query($sql);
		// die($this->hrd->last_query());
		// die(json_encode($sql));
		return 	$query->row_array();
	}

	public function getDataAbsensi($biodata_id, $tgl_absen){
		$sql 	= "
			SELECT biodata_id, tgl_absensi FROM hrd_all.trn_absensi
			WHERE biodata_id = '$biodata_id' AND tgl_absensi = '$tgl_absen'
		";
		$query 	= $this->hrd->query($sql);
		// die($this->hrd->last_query());
		// die(json_encode($sql));
		return 	$query->row_array();
	}

	public function getDataUser(){
		$nip = $this->session->userdata('nama_login');
		$sql = "SELECT a.*, b.is_level FROM hrd_all.mst_biodata a
				LEFT JOIN db_akses.mst_user b ON a.nip = b.nip_user
				WHERE b.nip_user ='".$nip."' ";
		$query 	= $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return 	$query->row_array();
	}

	public function getDataNormatif($biodataid){
		$dates		= date('Y-m-d');
		$sql 	= 	"SELECT  IFNULL(cn.sisa_cuti,0) sisa_normatif,
					saldo_awal,saldo_tahunan,saldo_cuti_normatif_id,tgl_mulai_berlaku,tgl_akhir_berlaku
					FROM hrd_all.trn_saldo_cuti_normatif cn
					WHERE cn.biodata_id = '".$biodataid."' AND '".$dates."' >= DATE(tgl_mulai_berlaku) AND '".$dates."' <= DATE(tgl_akhir_berlaku)";
		$query 	= $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return 	$query->row_array();
	}

	public function getDataNormatifny($biodataid){
		$dates		= date('Y')+1;
		$sql 	= 	"SELECT  IFNULL(cn.sisa_cuti,0) sisa_normatif,
					saldo_awal,saldo_tahunan,saldo_cuti_normatif_id,tgl_mulai_berlaku,tgl_akhir_berlaku
					FROM hrd_all.trn_saldo_cuti_normatif cn
					WHERE cn.biodata_id = '".$biodataid."' AND '".$dates."' >= YEAR(tgl_mulai_berlaku) AND '".$dates."' <= YEAR(tgl_akhir_berlaku)";
		$query 	= $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return 	$query->row_array();
	}

	public function getAppDataNormatif($biodataid, $dates){
		$sql 	= 	"SELECT IFNULL(SUM(cn.sisa_cuti),null) sisa_normatif,
					saldo_awal,saldo_tahunan,saldo_cuti_normatif_id,tgl_mulai_berlaku,tgl_akhir_berlaku
					FROM hrd_all.trn_saldo_cuti_normatif cn
					WHERE cn.biodata_id = '".$biodataid."' AND '".$dates."' >= DATE(tgl_mulai_berlaku) AND '".$dates."' <= DATE(tgl_akhir_berlaku)";
		$query 	= $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return 	$query->row_array();
	}

	public function getDataBonus($biodataid,$dates){
		$sql 	= "SELECT biodata_id,SUM(sisa_cuti) sisa_cuti,saldo_cuti_bonus_id,urut_bonus,saldo_awal,saldo_bonus, tgl_mulai_berlaku,tgl_akhir_berlaku
		FROM hrd_all.trn_saldo_cuti_bonus
		WHERE biodata_id = '".$biodataid."' AND '".$dates."' >= DATE(tgl_mulai_berlaku) AND '".$dates."' <= DATE(tgl_akhir_berlaku) GROUP BY biodata_id";
		$query 	= $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return 	$query->row_array();
	}

	public function getSaldoBonus($biodataid,$dates){
		$sql 	= "SELECT biodata_id,SUM(sisa_cuti) sisa_cuti,saldo_cuti_bonus_id,urut_bonus,saldo_awal,saldo_bonus, tgl_mulai_berlaku,tgl_akhir_berlaku
		FROM hrd_all.trn_saldo_cuti_bonus
		WHERE biodata_id = '".$biodataid."' AND '".$dates."' >= DATE(tgl_mulai_berlaku) AND '".$dates."' <= DATE(tgl_akhir_berlaku) GROUP BY biodata_id";
		$query 	= $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return 	$query->row_array();
	}


	public function getDataTambahan($biodataid,$dates){
		$dates		= date('Y-m-d');
		$sql 	= " SELECT ct.no_dok_cuti_tambahan, ct.biodata_id,ct.saldo_cuti_tambahan_id,ct.saldo_awal,
					IFNULL(SUM(ct.sisa_cuti),0) sisa_cuti_tambahan, ct.tgl_mulai_berlaku, ct.tgl_akhir_berlaku
					FROM hrd_all.trn_saldo_cuti_tambahan ct
					WHERE ct.biodata_id = '".$biodataid."'
					AND ct.is_batal <> 1
					AND ct.sisa_cuti > 0
					AND DATEDIFF(NOW(), tgl_akhir_berlaku) <= 31
					ORDER BY tgl_mulai_berlaku ASC LIMIT 1";
		$query 	= $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return 	$query->row_array();
	}


	public function getSaldoTambahan($biodataid){
		$dates		= date('Y-m-d');
		$sql 	= "SELECT ct.biodata_id,saldo_cuti_tambahan_id, saldo_tambahan, ct.saldo_awal, sisa_cuti,
					ct.tgl_mulai_berlaku, ct.tgl_akhir_berlaku
					FROM hrd_all.trn_saldo_cuti_tambahan ct
					WHERE ct.biodata_id = '".$biodataid."' AND ct.is_batal <> 1 AND ct.sisa_cuti > 0
					AND NOW() >= DATE(tgl_mulai_berlaku) AND NOW() <= DATE(tgl_akhir_berlaku)
					ORDER BY tgl_akhir_berlaku ASC
					";
		$query 	= $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return 	$query->result_array();
	}

	public function getAwalTambahan($biodataid, $dates){
		$sql 	= "SELECT * FROM (
			SELECT ct.biodata_id,saldo_cuti_tambahan_id, saldo_tambahan, ct.saldo_awal, sisa_cuti,
			ct.tgl_mulai_berlaku, ct.tgl_akhir_berlaku
			FROM hrd_all.trn_saldo_cuti_tambahan ct
			WHERE ct.biodata_id = '$biodataid' AND ct.is_batal <> 1 AND ct.sisa_cuti > 0
			AND '$dates' >= DATE(tgl_mulai_berlaku) AND '$dates' <= DATE(tgl_akhir_berlaku)
			ORDER BY tgl_akhir_berlaku ASC)a
			WHERE (tgl_mulai_berlaku <='$dates' AND tgl_akhir_berlaku >='$dates') ORDER BY tgl_mulai_berlaku ASC LIMIT 1";
		$query 	= $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return 	$query->row_array();
	}

	public function getAkhirTambahan($biodataid, $dates){
		$sql 	= "SELECT * FROM (
			SELECT ct.biodata_id,saldo_cuti_tambahan_id, saldo_tambahan, ct.saldo_awal, sisa_cuti,
			ct.tgl_mulai_berlaku, ct.tgl_akhir_berlaku
			FROM hrd_all.trn_saldo_cuti_tambahan ct
			WHERE ct.biodata_id = '$biodataid' AND ct.is_batal <> 1 AND ct.sisa_cuti > 0
			AND '$dates' >= DATE(tgl_mulai_berlaku) AND '$dates' <= DATE(tgl_akhir_berlaku)
			ORDER BY tgl_akhir_berlaku ASC)a
			WHERE (tgl_mulai_berlaku <='$dates' AND tgl_akhir_berlaku >='$dates') ORDER BY tgl_akhir_berlaku DESC LIMIT 1";
		$query 	= $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return 	$query->row_array();
	}

	public function getMasaBerlakuTambahanRow($biodataid,$dates){
		$sql 	= "SELECT saldo_cuti_tambahan_id,no_dok_cuti_tambahan,tgl_dok_cuti_tambahan,tgl_mulai_berlaku, tgl_akhir_berlaku, saldo_tambahan, sisa_cuti
		FROM hrd_all.trn_saldo_cuti_tambahan WHERE biodata_id='$biodataid'
		AND is_batal <> 1
		AND sisa_cuti > 0
		AND DATEDIFF(NOW(), tgl_akhir_berlaku) <= 31
		ORDER BY tgl_akhir_berlaku ASC";
		$query 	= $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return 	$query->row_array();
	}

	public function getMasaBerlakuTambahan($biodataid,$dates){
		$sql 	= "SELECT saldo_cuti_tambahan_id,no_dok_cuti_tambahan,tgl_dok_cuti_tambahan,tgl_mulai_berlaku, tgl_akhir_berlaku, saldo_tambahan, sisa_cuti
		FROM hrd_all.trn_saldo_cuti_tambahan WHERE biodata_id='$biodataid'
		AND is_batal <> 1
		AND sisa_cuti > 0
		AND DATEDIFF(NOW(), tgl_akhir_berlaku) <= 31
		ORDER BY tgl_akhir_berlaku ASC";
		$query 	= $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return 	$query->result_array();
	}

	public function getMasaBerlakuTambahanASC($biodataid,$dates){
		$sql 	= "SELECT saldo_cuti_tambahan_id,no_dok_cuti_tambahan,tgl_dok_cuti_tambahan,tgl_mulai_berlaku, tgl_akhir_berlaku, saldo_tambahan, sisa_cuti
		FROM hrd_all.trn_saldo_cuti_tambahan WHERE biodata_id='$biodataid'
		AND is_batal <> 1
		AND sisa_cuti > 0
		AND DATEDIFF(NOW(), tgl_akhir_berlaku) <= 31
		ORDER BY tgl_akhir_berlaku ASC LIMIT 1";
		$query 	= $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return 	$query->row_array();
	}

	public function getMasaBerlakuTambahanDESC($biodataid,$dates){
		$sql 	= "SELECT * FROM 
		( SELECT ct.biodata_id,saldo_cuti_tambahan_id, saldo_tambahan, ct.saldo_awal, sisa_cuti, ct.tgl_mulai_berlaku, ct.tgl_akhir_berlaku 
		FROM hrd_all.trn_saldo_cuti_tambahan ct WHERE ct.biodata_id = '$biodataid'
		AND ct.is_batal <> 1
		AND ct.sisa_cuti > 0
		ORDER BY tgl_akhir_berlaku ASC)a
		ORDER BY tgl_mulai_berlaku DESC LIMIT 1";
		$query 	= $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return 	$query->row_array();
	}

	public function getKodeStore($biodataid)
	{
		$sql = "SELECT kd_store FROM hrd_all.biodata_pekerjaan_d bp WHERE bp.biodata_id = '".$biodataid."' AND bp.aktif='1'";
		// die($this->hrd->last_query());
		$query 	= $this->hrd->query($sql);
		return 	$query->row_array();
	}

	public function getGolAbsen($biodataid)
	{
		$sql = "SELECT gah.gol_absensi_h_id, gah.kode_gol_absensi,
						gad.gol_absensi_d_id,
						gad.jam_masuk, gad.jam_keluar, gad.hari
				FROM hrd_all.mst_gol_absensi_h gah
				INNER JOIN  hrd_all.mst_gol_absensi_d gad ON gad.gol_absensi_h_id = gah.gol_absensi_h_id
				INNER JOIN  hrd_all.mst_biodata mb ON mb.gol_absensi_h_id = gah.gol_absensi_h_id
				WHERE mb.biodata_id = '".$biodataid."'
				AND gad.hari = 3; ";
		// die($this->hrd->last_query());
		$query 	= $this->hrd->query($sql);
		return 	$query->row_array();
	}

	public function getCutiData1($no , $search_no = "", $length = "", $start = "", $column = "", $order = "")
	{
		// if($no){
			$this->hrd->where('t0.biodata_id', $no);
			// $this->hrd->where('t0.tgl_dok_tdk_masuk >"2021-09-20"');
			$this->hrd->like('t0.no_dok_tdk_masuk','HRC');
		// }
		if($search_no != "") $this->hrd->like('t0.biodata_id',$search_no);

		$this->hrd->select('t0.tdk_masuk_h_id,t0.biodata_id, t0.no_dok_tdk_masuk,t0.is_posting,
			CASE WHEN (status_dokumen)="R" THEN "DITOLAK/BATAL"
			WHEN (status_dokumen)="O" THEN "OPEN"
			WHEN (status_dokumen)="P" THEN "SEDANG PROSES"
			ELSE "APPROVED"
			END posting, DATE_FORMAT(t0.tgl_dok_tdk_masuk,"%d-%m-%Y") tgl_dok,
			t0.potong_cuti_dari,CONCAT_WS(" | ", t1.kode_status_absensi,t1.ket_status_absensi) status,
			CONCAT_WS(" | ", t2.nip,t2.nama_lengkap) nama_pic,t2.nip,
			t0.keterangan,t0.tgl_input');
		$this->hrd->from('hrd_all.trn_tidak_masuk_h t0');
		$this->hrd->join('hrd_all.mst_status_absensi t1', 't0.status_absensi_id = t1.status_absensi_id', 'left');
		$this->hrd->join('hrd_all.mst_biodata t2', 't0.biodata_id = t2.biodata_id', 'left');
		$this->hrd->join('hrd_all.trn_posting t3', 't0.tdk_masuk_h_id = t3.tdk_masuk_h_id', 'left');
		if($column == 0){
			$this->hrd->order_by('t0.tgl_input', $order);
		}
		$this->hrd->limit($length,$start);
		$query=$this->hrd->get();
		// die(nl2br($this->hrd->last_query()));
		return $query->result_array();
	}

	public function getCutiData2($no , $search_no = "")
	{
		// if($no){
			$this->hrd->where('t0.biodata_id', $no);
			// $this->hrd->where('t0.tgl_dok_tdk_masuk >"2021-09-20"');
			$this->hrd->like('t0.no_dok_tdk_masuk','HRC');
		// }
		if($search_no != "") $this->hrd->like('t0.biodata_id',$search_no);

		$this->hrd->select('t0.tdk_masuk_h_id,t0.biodata_id,t0.no_dok_tdk_masuk,  DATE_FORMAT(t0.tgl_dok_tdk_masuk,"%d-%m-%Y") tgl_dok,
		t0.potong_cuti_dari,CONCAT_WS(" | ", t1.kode_status_absensi,t1.ket_status_absensi) status,
		CONCAT_WS(" | ", t2.nip,t2.nama_lengkap) nama_pic,t2.nip,
		t0.keterangan');
		$this->hrd->from('hrd_all.trn_tidak_masuk_h t0');
		// $this->hrd->where('t0.biodata_id', 0000000000032);
		$this->hrd->join('hrd_all.mst_status_absensi t1', 't0.status_absensi_id = t1.status_absensi_id', 'left');
		$this->hrd->join('hrd_all.mst_biodata t2', 't0.biodata_id = t2.biodata_id', 'left');
		$this->hrd->order_by('t0.tgl_dok_tdk_masuk', 'DESC');
		$jum=$this->hrd->get();

		return $jum->num_rows();
	}

	public function getHeaderDataBC($no_dok_h = null)
	{
		if($no_dok_h) {
			$sql = "SELECT a.*, b.ket_status_absensi, b.kode_status_absensi, c.nip, c.nama_lengkap
			FROM hrd_all.trn_tidak_masuk_h a
			LEFT JOIN hrd_all.mst_status_absensi b ON a.status_absensi_id  = b.status_absensi_id
			LEFT JOIN hrd_all.mst_biodata c ON a.biodata_id = c.biodata_id
			WHERE tdk_masuk_h_id = ?";
			$query = $this->hrd->query($sql, array($no_dok_h));
			// die(nl2br($this->hrd->last_query()));
			return $query->row_array();
		}
		$sql = "SELECT * FROM hrd_all.trn_tidak_masuk_h ORDER BY tdk_masuk_h_id DESC";
		$query = $this->hrd->query($sql);
		return $query->result_array();
	}

	public function getHeaderData($no_dok_h = null)
	{
		if($no_dok_h) {
			$nip = $this->session->userdata('nama_login');
			$sql = "SELECT a.* ,jml_app
				, d.nip,d.nama_lengkap
				, e.nip, e.nama_lengkap
				, f.*
				, g.status
				, h.nama, i.*,
				CASE WHEN g.status = 0 THEN 'OPEN' 
				WHEN g.status = 1 THEN 'PENDING'
				END st
				FROM hrd_web_master.mst_user_approval_detail a
				LEFT JOIN hrd_web_master.mst_karyawan_01 b ON a.karyawan_id = b.karyawan_id
				LEFT JOIN hrd_web_master.mst_karyawan_01 c ON a.approved_user = c.karyawan_id
				LEFT JOIN hrd_all.mst_biodata d ON b.biodata = d.biodata_id
				LEFT JOIN hrd_all.mst_biodata e ON c.biodata = e.biodata_id
				LEFT JOIN hrd_all.trn_tidak_masuk_h f ON e.biodata_id = f.biodata_id
				LEFT JOIN hrd_all.trn_posting g ON f.tdk_masuk_h_id = g.tdk_masuk_h_id
				LEFT JOIN hrd_all.mst_status_absensi i ON f.status_absensi_id  = i.status_absensi_id
				LEFT JOIN hrd_web_master.mst_departemen h ON a.dept_user = h.hash
				LEFT JOIN
				(SELECT  a.approved_user, COUNT(a.karyawan_id)jml_app FROM hrd_web_master.mst_user_approval_detail a
				LEFT JOIN hrd_web_master.mst_karyawan_01 b ON a.karyawan_id=b.karyawan_id
				GROUP BY a.approved_user) i ON a.approved_user=i.approved_user
				WHERE f.tdk_masuk_h_id = ?
				AND d.nip=$nip AND YEAR(tgl_dok_tdk_masuk)>='2021'
				AND is_posting=0 AND is_batal=0
				AND urutan_approval = g.status+1
				ORDER BY e.nip, f.tgl_dok_tdk_masuk
			";
			$query = $this->hrd->query($sql, array($no_dok_h));
			// die(nl2br($this->hrd->last_query()));
			return $query->row_array();
		}
		$sql = "SELECT * FROM hrd_all.trn_tidak_masuk_h ORDER BY tdk_masuk_h_id DESC";
		$query = $this->hrd->query($sql);
		return $query->result_array();
	}

	public function getDetailData($no_dok_h = null)
	{
		if(!$no_dok_h) {
			return false;
		}

		$sql = 'SELECT *, CASE
		WHEN DATE_FORMAT(DATE(tgl_tdk_masuk),"%w") <> 0 THEN DATE_FORMAT(DATE(tgl_tdk_masuk),"%w")
		ELSE "7"
		END hr
		FROM hrd_all.trn_tidak_masuk_d
		WHERE tdk_masuk_h_id = ? ORDER BY tgl_tdk_masuk ASC';
		$query = $this->hrd->query($sql, array($no_dok_h));
		// die(nl2br($this->hrd->last_query()));
		return $query->result_array();
	}

	public function getApprovalData1BC($no , $search_no = "", $length = "", $start = "", $column = "", $order = "")
	{
		$this->hrd->like('t0.biodata_id',$search_no);
		$this->hrd->where('t0.tgl_dok_tdk_masuk >"2021-09-20"');

		$this->hrd->select('t0.tdk_masuk_h_id,t0.biodata_id, t0.no_dok_tdk_masuk,t0.is_posting,
			CASE WHEN (is_posting = 1) AND IFNULL(tgl_batal,"")="" THEN "POSTING"
			WHEN (is_posting = 0) AND IFNULL(tgl_batal,"")<>"" THEN "DITOLAK/BATAL" ELSE "BELUM" END posting,
			DATE_FORMAT(t0.tgl_dok_tdk_masuk,"%d-%m-%Y") tgl_dok,
			t0.potong_cuti_dari,CONCAT_WS(" | ", t1.kode_status_absensi,t1.ket_status_absensi) status,
			CONCAT_WS(" | ", t2.nip,t2.nama_lengkap) nama_pic,t2.nip,
			t0.keterangan,t0.tgl_input');
		$this->hrd->from('hrd_all.trn_tidak_masuk_h t0');
		$this->hrd->join('hrd_all.mst_status_absensi t1', 't0.status_absensi_id = t1.status_absensi_id', 'left');
		$this->hrd->join('hrd_all.mst_biodata t2', 't0.biodata_id = t2.biodata_id', 'left');
		$this->hrd->join('db_akses.mst_user t3', 't2.nip = t3.nip_user', 'left');
		$this->hrd->where('t3.kode_dept', $no);
		$this->hrd->where('is_posting=0 AND LEFT(no_dok_tdk_masuk,3)="HRC" AND IFNULL(tgl_batal,"")=""');

		if($column == 0){
			$this->hrd->order_by('t0.tgl_input', $order);
		}
		$this->hrd->limit($length,$start);
		$query=$this->hrd->get();
		// die(nl2br($this->hrd->last_query()));
		return $query->result_array();
	}
	public function getApprovalData2BC($no , $search_no = "")
	{
		$this->hrd->like('t0.biodata_id',$search_no);
		$this->hrd->where('t0.tgl_dok_tdk_masuk >"2021-09-20"');

		$this->hrd->select('t0.tdk_masuk_h_id,t0.biodata_id,t0.no_dok_tdk_masuk,  DATE_FORMAT(t0.tgl_dok_tdk_masuk,"%d-%m-%Y") tgl_dok,
			t0.potong_cuti_dari,CONCAT_WS(" | ", t1.kode_status_absensi,t1.ket_status_absensi) status,
			CONCAT_WS(" | ", t2.nip,t2.nama_lengkap) nama_pic,t2.nip,
			t0.keterangan');
		$this->hrd->from('hrd_all.trn_tidak_masuk_h t0');
		$this->hrd->join('hrd_all.mst_status_absensi t1', 't0.status_absensi_id = t1.status_absensi_id', 'left');
		$this->hrd->join('hrd_all.mst_biodata t2', 't0.biodata_id = t2.biodata_id', 'left');
		$this->hrd->join('db_akses.mst_user t3', 't2.nip = t3.nip_user', 'left');
		$this->hrd->where('t3.kode_dept', $no);
		$this->hrd->where('is_posting=0 AND LEFT(no_dok_tdk_masuk,3)="HRC" AND IFNULL(tgl_batal,"")=""');

		$this->hrd->order_by('t0.tgl_dok_tdk_masuk', 'DESC');
		$jum=$this->hrd->get();
		return $jum->num_rows();
	}

	public function getApprovalData1($nip , $search_no = "",$search_nama = "", $length = "", $start = "", $column = "", $order = "")
	{
		if($this->session->userdata('nama_login') != '99999999'){
			if($search_nama != "") $this->hrd->like('e.nama_lengkap',$search_nama);
			$this->hrd->select("a.*,d.nip,d.nama_lengkap, e.nip,
			e.nama_lengkap, f.no_dok_tdk_masuk, f.tgl_dok_tdk_masuk
			,f.tdk_masuk_h_id, g.status, h.nama, e.biodata_id,f.keterangan");
			$this->hrd->from('hrd_web_master.mst_user_approval_detail a');
			$this->hrd->join('hrd_web_master.mst_karyawan_01 b', 'a.karyawan_id = b.karyawan_id', 'left');
			$this->hrd->join('hrd_web_master.mst_karyawan_01 c', 'a.approved_user = c.karyawan_id', 'left');
			$this->hrd->join('hrd_all.mst_biodata d', 'b.biodata = d.biodata_id', 'left');
			$this->hrd->join('hrd_all.mst_biodata e', 'c.biodata = e.biodata_id', 'left');
			$this->hrd->join('hrd_all.trn_tidak_masuk_h f', 'e.biodata_id = f.biodata_id', 'left');
			$this->hrd->join('hrd_all.trn_posting g', 'f.tdk_masuk_h_id = g.tdk_masuk_h_id', 'left');
			$this->hrd->join('hrd_web_master.mst_departemen h', 'a.dept_user = h.hash', 'left');
			$this->hrd->where('d.nip', $nip);
			$this->hrd->where('is_posting=0 AND is_batal=0 AND LEFT(no_dok_tdk_masuk,3)="HRC" ');
			$this->hrd->where('urutan_approval=','g.status+1',FALSE);
			$this->hrd->order_by('tgl_dok_tdk_masuk','DESC');
		}else{
			if($search_nama != "") $this->hrd->like('t2.nama_lengkap',$search_nama);
			$this->hrd->select('t0.tdk_masuk_h_id,t0.biodata_id, t0.no_dok_tdk_masuk,t0.is_posting,
				CASE WHEN (status_dokumen)="R" THEN "DITOLAK/BATAL"
				WHEN (status_dokumen)="O" THEN "OPEN"
				WHEN (status_dokumen)="P" THEN "SEDANG PROSES"
				ELSE "APPROVED"
				END posting, DATE_FORMAT(t0.tgl_dok_tdk_masuk,"%d-%m-%Y") tgl_dok_tdk_masuk,
				t0.potong_cuti_dari,CONCAT_WS(" | ", t1.kode_status_absensi,t1.ket_status_absensi) status,
				t2.nama_lengkap,t2.nip,
				t0.keterangan,t0.tgl_input');
			$this->hrd->from('hrd_all.trn_tidak_masuk_h t0');
			$this->hrd->join('hrd_all.mst_status_absensi t1', 't0.status_absensi_id = t1.status_absensi_id', 'left');
			$this->hrd->join('hrd_all.mst_biodata t2', 't0.biodata_id = t2.biodata_id', 'left');
			$this->hrd->join('hrd_all.trn_posting t3', 't0.tdk_masuk_h_id = t3.tdk_masuk_h_id', 'left');
			$this->hrd->where_in('t0.biodata_id', array('d6cc08986fa7','6734021e8980','06d0e9c23a66','000000000178'));
			$this->hrd->where('t0.is_posting=0 AND t0.is_batal=0 AND LEFT(no_dok_tdk_masuk,3)="HRC"');
			$this->hrd->order_by('tgl_dok_tdk_masuk','DESC');
		}

		// if($column == 0){
		// 	$this->hrd->order_by('e.nip', $order);
		// }
		$this->hrd->limit($length,$start);
		$query=$this->hrd->get();
		// die(nl2br($this->hrd->last_query()));
		return $query->result_array();

	}

	public function getApprovalData2($nip , $search_no = "",$search_nama = "")
	{
		if($this->session->userdata('nama_login') != '99999999'){
			if($search_nama != "") $this->hrd->like('e.nama_lengkap',$search_nama);
			$this->hrd->select("a.*,d.nip,d.nama_lengkap, e.nip,
			e.nama_lengkap, f.no_dok_tdk_masuk, f.tgl_dok_tdk_masuk
			,f.tdk_masuk_h_id, g.status, h.nama, e.biodata_id,f.keterangan");
			$this->hrd->from('hrd_web_master.mst_user_approval_detail a');
			$this->hrd->join('hrd_web_master.mst_karyawan_01 b', 'a.karyawan_id = b.karyawan_id', 'left');
			$this->hrd->join('hrd_web_master.mst_karyawan_01 c', 'a.approved_user = c.karyawan_id', 'left');
			$this->hrd->join('hrd_all.mst_biodata d', 'b.biodata = d.biodata_id', 'left');
			$this->hrd->join('hrd_all.mst_biodata e', 'c.biodata = e.biodata_id', 'left');
			$this->hrd->join('hrd_all.trn_tidak_masuk_h f', 'e.biodata_id = f.biodata_id', 'left');
			$this->hrd->join('hrd_all.trn_posting g', 'f.tdk_masuk_h_id = g.tdk_masuk_h_id', 'left');
			$this->hrd->join('hrd_web_master.mst_departemen h', 'a.dept_user = h.hash', 'left');
			$this->hrd->where('d.nip', $nip);
			$this->hrd->where('is_posting=0 AND is_batal=0 AND LEFT(no_dok_tdk_masuk,3)="HRC" ');
			$this->hrd->where('urutan_approval=','g.status+1',FALSE);
			$this->hrd->order_by('tgl_dok_tdk_masuk','DESC');
		}else{
			if($search_nama != "") $this->hrd->like('t2.nama_lengkap',$search_nama);
			$this->hrd->select('t0.tdk_masuk_h_id,t0.biodata_id, t0.no_dok_tdk_masuk,t0.is_posting,
				CASE WHEN (status_dokumen)="R" THEN "DITOLAK/BATAL"
				WHEN (status_dokumen)="O" THEN "OPEN"
				WHEN (status_dokumen)="P" THEN "SEDANG PROSES"
				ELSE "APPROVED"
				END posting, DATE_FORMAT(t0.tgl_dok_tdk_masuk,"%d-%m-%Y") tgl_dok,
				t0.potong_cuti_dari,CONCAT_WS(" | ", t1.kode_status_absensi,t1.ket_status_absensi) status,
				t2.nama_lengkap,t2.nip,
				t0.keterangan,t0.tgl_input');
			$this->hrd->from('hrd_all.trn_tidak_masuk_h t0');
			$this->hrd->join('hrd_all.mst_status_absensi t1', 't0.status_absensi_id = t1.status_absensi_id', 'left');
			$this->hrd->join('hrd_all.mst_biodata t2', 't0.biodata_id = t2.biodata_id', 'left');
			$this->hrd->join('hrd_all.trn_posting t3', 't0.tdk_masuk_h_id = t3.tdk_masuk_h_id', 'left');
			$this->hrd->where_in('t0.biodata_id', array('d6cc08986fa7','6734021e8980','06d0e9c23a66','000000000178'));
			$this->hrd->where('t0.is_posting=0 AND t0.is_batal=0 AND LEFT(no_dok_tdk_masuk,3)="HRC"');
			$this->hrd->order_by('tgl_dok','DESC');
		}
		$jum=$this->hrd->get();
		return $jum->num_rows();
	}

	public function getApprovedHistory($nip, $search_no="",$search_nama = "",$length="",$start="",$column="",$order="")
	{
		//menampilkan siapa saja yang di approve oleh user yg login
		$where_search_nama = "";
		if($search_nama !== ""){
			$where_search_nama = "AND nama_lengkap LIKE '%".$search_nama."%'";
		}

		$sql = "SELECT no_dok_tdk_masuk,tgl_dok_tdk_masuk,nip,nama_lengkap,e.nama_dept,
				date(tgl_app_1)tgl_app_1,status_dokumen,a.tdk_masuk_h_id,
						CASE WHEN (is_posting = 1 AND status_dokumen ='C') THEN 'APPROVED'
						WHEN status_dokumen ='P' THEN 'PROCESS'
						WHEN status_dokumen ='O' THEN 'OPEN' ELSE 'REJECTED' END posting
				FROM(
					SELECT tdk_masuk_h_id,tgl_app_1,status_dokumen,'' kom FROM hrd_all.trn_posting
					WHERE app_1 = '$nip'
					UNION ALL
					SELECT tdk_masuk_h_id,tgl_app_2,status_dokumen,'' kom FROM hrd_all.trn_posting
					WHERE app_2 = '$nip'
					UNION ALL
					SELECT tdk_masuk_h_id,tgl_rej_1,status_dokumen, rej_komentar_1 FROM hrd_all.trn_posting
					WHERE rej_1 = '$nip'
					UNION ALL
					SELECT tdk_masuk_h_id,tgl_rej_2,status_dokumen, rej_komentar_2 FROM hrd_all.trn_posting
					WHERE rej_2 = '$nip'
					)a
				LEFT JOIN hrd_all.trn_tidak_masuk_h b ON a.tdk_masuk_h_id = b.tdk_masuk_h_id
				LEFT JOIN hrd_all.mst_biodata c ON b.biodata_id = c.biodata_id
				LEFT JOIN hrd_all.biodata_pekerjaan_d d ON c.biodata_id = d.biodata_id
				LEFT JOIN hrd_all.mst_dept e ON d.dept_id = e.dept_id
				WHERE no_dok_tdk_masuk LIKE 'HRC%' $where_search_nama
				ORDER BY tgl_dok_tdk_masuk DESC
				LIMIT $start,$length
		";

		$query = $this->hrd->query($sql);
		// die(nl2br($this->hrd->last_query()));
		return $query->result_array();

	}

	public function getCountApprovedHistory($nip, $search_no = "",$search_nama = "")
	{
		//menampilkan siapa saja yang di approve oleh user yg login
		$where_search_nama = "";
		if($search_nama !== ""){
			$where_search_nama = "AND nama_lengkap LIKE '%".$search_nama."%'";
		}

		$sql = "SELECT no_dok_tdk_masuk,tgl_dok_tdk_masuk,nip,nama_lengkap,e.nama_dept,
				date(tgl_app_1)tgl_app_1,status_dokumen,a.tdk_masuk_h_id,
						CASE WHEN (is_posting = 1 AND status_dokumen ='C') THEN 'APPROVED'
						WHEN status_dokumen ='P' THEN 'PROCESS'
						WHEN status_dokumen ='O' THEN 'OPEN' ELSE 'REJECTED' END posting
				FROM(
					SELECT tdk_masuk_h_id,tgl_app_1,status_dokumen,'' kom FROM hrd_all.trn_posting
					WHERE app_1 = '$nip'
					UNION ALL
					SELECT tdk_masuk_h_id,tgl_app_2,status_dokumen,'' kom FROM hrd_all.trn_posting
					WHERE app_2 = '$nip'
					UNION ALL
					SELECT tdk_masuk_h_id,tgl_rej_1,status_dokumen, rej_komentar_1 FROM hrd_all.trn_posting
					WHERE rej_1 = '$nip'
					UNION ALL
					SELECT tdk_masuk_h_id,tgl_rej_2,status_dokumen, rej_komentar_2 FROM hrd_all.trn_posting
					WHERE rej_2 = '$nip'
					)a
				LEFT JOIN hrd_all.trn_tidak_masuk_h b ON a.tdk_masuk_h_id = b.tdk_masuk_h_id
				LEFT JOIN hrd_all.mst_biodata c ON b.biodata_id = c.biodata_id
				LEFT JOIN hrd_all.biodata_pekerjaan_d d ON c.biodata_id = d.biodata_id
				LEFT JOIN hrd_all.mst_dept e ON d.dept_id = e.dept_id
				WHERE no_dok_tdk_masuk LIKE 'HRC%' $where_search_nama
				ORDER BY tgl_dok_tdk_masuk DESC
		";
		$jum= $this->hrd->query($sql);
		return $jum->num_rows();
	}


	public function count_nip($biodata_id)
	{
		$sql = "SELECT COUNT(nip) as nips FROM(
			SELECT e.biodata_id id, e.nip nip, e.nama_lengkap nama, d.biodata_id id_app, d.nip nip_app, d.nama_lengkap nama_app, a.urutan_approval 
			FROM  hrd_web_master.mst_user_approval_detail a
			LEFT JOIN hrd_web_master.mst_karyawan_01 b ON a.karyawan_id = b.karyawan_id
			LEFT JOIN hrd_web_master.mst_karyawan_01 c ON a.approved_user = c.karyawan_id
			LEFT JOIN hrd_all.mst_biodata d ON b.biodata = d.biodata_id
			LEFT JOIN hrd_all.mst_biodata e ON c.biodata = e.biodata_id
			WHERE e.biodata_id='$biodata_id' GROUP BY urutan_approval)a";
		$query = $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return $query->row_array();
	}

	public function urutanApp($biodata_id)
	{
		$sql = "SELECT e.biodata_id id, e.nip nip, e.nama_lengkap nama, d.biodata_id id_app, d.nip nip_app, d.nama_lengkap nama_app, a.urutan_approval 
			FROM  hrd_web_master.mst_user_approval_detail a
			LEFT JOIN hrd_web_master.mst_karyawan_01 b ON a.karyawan_id = b.karyawan_id
			LEFT JOIN hrd_web_master.mst_karyawan_01 c ON a.approved_user = c.karyawan_id
			LEFT JOIN hrd_all.mst_biodata d ON b.biodata = d.biodata_id
			LEFT JOIN hrd_all.mst_biodata e ON c.biodata = e.biodata_id
			WHERE e.biodata_id='$biodata_id' GROUP BY urutan_approval";
		$query = $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return $query->result_array();
	}

	public function approvalCutiUser($nip, $tdk_masuk_h_id)
	{
		$sql = "SELECT b.nip, b.nama_lengkap, c.nip, c.nama_lengkap, d.no_dok_tdk_masuk,
				d.tgl_dok_tdk_masuk, d.tdk_masuk_h_id, e.status,
				g.nama_dept, c.biodata_id, d.keterangan
				FROM hrd_all.trn_app_ct a
				LEFT JOIN hrd_all.mst_biodata b ON a.nip_approval = b.nip
				LEFT JOIN hrd_all.mst_biodata c ON a.nip_user = c.nip
				LEFT JOIN hrd_all.trn_tidak_masuk_h d ON c.biodata_id = d.biodata_id
				LEFT JOIN hrd_all.trn_posting e ON d.tdk_masuk_h_id = e.tdk_masuk_h_id
				LEFT JOIN hrd_all.biodata_pekerjaan_d f ON c.biodata_id = f.biodata_id
				LEFT JOIN hrd_all.mst_dept g ON f.dept_id = g.dept_id
				WHERE b.nip = '$nip' AND LEFT(no_dok_tdk_masuk,3) = 'HRC'
				-- AND d.tdk_masuk_h_id = '$tdk_masuk_h_id'
				AND is_posting =0 AND is_batal =0
				AND e.status_dokumen <>'R'
				AND urutan_app= e.status+1
				ORDER BY d.tgl_dok_tdk_masuk ASC";
		$query = $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return $query->result_array();
	}

	public function getDataPosting($no_dok_h)
	{
			$sql = "SELECT a.*,
			b.nama_lengkap app_1, c.nama_lengkap app_2, d.nama_lengkap app_3
			FROM hrd_all.trn_posting a
			LEFT JOIN hrd_all.mst_biodata b ON a.app_1 = b.nip
			LEFT JOIN hrd_all.mst_biodata c ON a.app_2 = c.nip
			LEFT JOIN hrd_all.mst_biodata d ON a.app_3 = d.nip
			WHERE tdk_masuk_h_id = ?";
			$query = $this->hrd->query($sql, array($no_dok_h));
			// die(nl2br($this->hrd->last_query()));
			return $query->row_array();
	}


	public function getHariLibur()
	{
		$sql = "SELECT tgl_libur as dates FROM hrd_all.mst_hari_libur WHERE aktif =1 ";
		$query 	= $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return 	$query->result_array();
	}


	function sortByGrade($a, $b)
	{
		// tesx($a, $b);
		if ($a == $b) {
			return $a - $b;
		}
		return strcmp($a, $b);
	}

	public function getTglCuti($biodata_id, $tgl){
		$sql =  "SELECT a.tgl_tdk_masuk
		FROM hrd_all.trn_tidak_masuk_d a
		LEFT JOIN hrd_all.trn_posting b ON a.tdk_masuk_h_id = b.tdk_masuk_h_id
		WHERE pic_input='$biodata_id'
		AND tgl_tdk_masuk ='$tgl'
		AND b.status_dokumen  <> 'R'";
		$query 	= $this->hrd->query($sql);
		return 	$query->row_array();
	}

	public function getTglCutiDetail($tdk_masuk_h_id, $tgl){
		$sql =  "SELECT a.*
		FROM hrd_all.trn_tidak_masuk_d a
		WHERE tdk_masuk_h_id	= '$tdk_masuk_h_id'
		AND tgl_tdk_masuk = '$tgl'
		";
		$query 	= $this->hrd->query($sql);
		return 	$query->row_array();
	}

	/* Create & Approce Action */

	public function create()
	{
		$docCode	 ='HRC';
		$date		 = date('ym');
		$jumlah_hari = $this->input->post('jumlah_hari');
		$potong_cuti = $this->input->post('potong_cuti_dari');
		$biodataids        = $this->input->post('biodata_id');

		/* Condition */
			#jumlah hari detail
			if($this->input->post('jumlah_hari')=='0.5'){
				$count_d = count($this->input->post('tgl_tdk_masuk'))*0.5;
			}else{
				$count_d = count($this->input->post('tgl_tdk_masuk'));
			}

			#sisa saldo
			if($potong_cuti =='NORMATIF'){
				$jml_normatif = $count_d;
			} else{ $jml_normatif ='0'; }
			if($potong_cuti =='BONUS'){
				$jml_bonus = $count_d;
			}else{ $jml_bonus ='0'; }
			if($potong_cuti =='TAMBAHAN'){
				$jml_tambahan = $count_d;
			}else{ $jml_tambahan ='0'; }

			#potong cuti normatif
			if($potong_cuti =='NORMATIF'){
				if($jumlah_hari =='1'){
					$status_absen 		= 'CN';
				}else{
					$status_absen 		= 'CH';
				}

				$tgl_cuti_potong = $this->input->post('tgl_tdk_masuk');
				rsort($tgl_cuti_potong);

				foreach($tgl_cuti_potong as $k => $v){
					// tesx(' oke boleh sipppp  ');

					$tgl_cuti_desc = $this->input->post('tgl_tdk_masuk');
					rsort($tgl_cuti_desc);
					$tgl_cuti_desc = $tgl_cuti_desc[array_key_last($tgl_cuti_desc)];

					/* Cek Saldo Normatif */
						$cek_cuti 			= $this->getAppDataNormatif($biodataids, $v);

						$tgl_akhir_berlaku 	= $cek_cuti['tgl_akhir_berlaku'];
						$tgl_awal_berlaku 	= $cek_cuti['tgl_mulai_berlaku'];
						#get Saldo Normatif Normal & 1/2 Hari
						$normatif 		= $cek_cuti['sisa_normatif'];
						$normatifst 	= $cek_cuti['sisa_normatif'];
					/* Cek Saldo Normatif */

					# Generate Saldo Normatif if Null
					if(empty($cek_cuti['sisa_normatif']) || $cek_cuti['sisa_normatif'] == null ){
						$generate_saldo = array(
							'saldo_cuti_normatif_id' 	=> $this->uuid->v4(),
							'biodata_id'				=> $biodataids,
							'tgl_ambil_terakhir'		=> $v,
							'pic_input'					=> $biodataids,
							'keterangan'				=> 'GENERATE SALDO CUTI MINUS',
							'tgl_mulai_berlaku' 		=> $tgl_cuti_desc,
							'tgl_akhir_berlaku' 		=> $v,
							'tgl_input'    				=> date('Y-m-d H:i:s'),
						);
						$insert = $this->hrd->insert('hrd_all.trn_saldo_cuti_normatif', $generate_saldo);
						// tesx($insert);
					}

				}

			}
			#potong cuti bonus
			if($potong_cuti =='BONUS'){
				$urutBonus 			= $this->input->post('urut_bonus');
				$biodata_id        	= $this->input->post('biodata_id');
				$dates		 		= date('y-m-d');
				$cek_saldo_bonus	= $this->getSaldoBonus($biodata_id, $dates);
				$tgl_akhir_berlaku 		= $cek_saldo_bonus['tgl_akhir_berlaku'];
				$tgl_awal_berlaku 		= $cek_saldo_bonus['tgl_mulai_berlaku'];
				if($jumlah_hari =='1'){
					$status_absen 		= 'CL';
					// $status_absen_id 	= '000000000013';
				}else{
					$status_absen 		= 'CH';
					// $status_absen_id 	= '000000000020';
				}
			}else{
				$urutBonus = '0';
			}

			#potong cuti tambahan
			if($potong_cuti =='TAMBAHAN'){
				if($jumlah_hari =='1'){
						$status_absen 		= 'CT';
						// $status_absen_id 	= '000000000017';
				}else{
						$status_absen 		= 'CH';
						// $status_absen_id 	= '000000000020';
				}
				#get Saldo Normatif Normal & 1/2 Hari
				$cek_saldo_tambahan = $this->getDataTambahan($biodataids, $date);
				$sisa_saldo_cuti		= $cek_saldo_tambahan['sisa_cuti_tambahan'];
				$sisa_saldo_cutist		= $cek_saldo_tambahan['sisa_cuti_tambahan'];
			}

			//get status_absensi_id, keterangan
			$search_status 		= $this->getKetAbsen($status_absen);
			$status_absen_id 	= $search_status['status_absensi_id'];
			$keterangan_d 		= 'AMBIL '.$search_status['ket_status_absensi'];


		/* End Condition */

		/* INSERT DATA */
			$data_header = array(
				'tdk_masuk_h_id'			=> $this->uuid->v4(),
				'biodata_id'				=> $this->input->post('biodata_id'),
				'pic_input'    				=> $this->input->post('biodata_id'),
				'no_dok_tdk_masuk'  		=> $this->getDataNoDoc($docCode, $date),
				'potong_cuti_dari'  		=> $potong_cuti,
				'status_absensi_id' 		=> $status_absen_id,
				'jml_ambil' 				=> $count_d,
				'jml_ambil_normatif'		=> $jml_normatif,
				'jml_ambil_bonus'   		=> $jml_bonus,
				'jml_ambil_tambahan'		=> $jml_tambahan,
				'sisa_saldo_normatif' 		=> $this->input->post('sisa_normatif'),
				'sisa_saldo_bonus' 			=> $this->input->post('sisa_bonus'),
				'sisa_saldo_tambahan' 		=> $this->input->post('sisa_tambahan'),
				'mulai_berlaku_normatif' 	=> $this->input->post('mulai_berlaku_normatif'),
				'akhir_berlaku_normatif' 	=> $this->input->post('akhir_berlaku_normatif'),
				'mulai_berlaku_bonus' 		=> $this->input->post('mulai_berlaku_bonus'),
				'akhir_berlaku_bonus' 		=> $this->input->post('akhir_berlaku_bonus'),
				'mulai_berlaku_tambahan' 	=> $this->input->post('mulai_berlaku_tambahan'),
				'akhir_berlaku_tambahan' 	=> $this->input->post('akhir_berlaku_tambahan'),
				'keterangan'	  			=> $this->input->post('keterangan'),
				'is_posting'	  			=> '0',
				'is_batal'	  				=> '0',
				'tgl_dok_tdk_masuk'			=> date('Y-m-d'),
				'tgl_input'    				=> date('Y-m-d H:i:s'),
			);

			// tesx($data_header);

			$sno_doc        = $data_header['no_dok_tdk_masuk'];
			$log_detail = array();
			$count_tgl_tdk_masuk = count($this->input->post('tgl_tdk_masuk'));

			for($x = 0; $x < $count_tgl_tdk_masuk ; $x++) {

				$uuid_d = $this->uuid->v4($x);

				#sort tanggal
				$dataTanggals	 	= $this->input->post('tgl_tdk_masuk');
				usort($dataTanggals, array($this,'sortByGrade'));
				$tgl_tdk_masuks 	=  $dataTanggals[$x];

				if($potong_cuti =='TAMBAHAN'){
					#cek saldo cuti tambahan per tanggal cuti
					$cek_awal_tambahan = $this->getAwalTambahan($biodataids, $tgl_tdk_masuks);
					$cek_akhir_tambahan = $this->getAkhirTambahan($biodataids, $tgl_tdk_masuks);
					$tgl_awal_berlaku 	= $cek_awal_tambahan['tgl_mulai_berlaku'];
					$tgl_akhir_berlaku 	= $cek_akhir_tambahan['tgl_akhir_berlaku'];

					if($jumlah_hari == '1'){

						if($sisa_saldo_cuti <= 0 ){
								$status_absen_d 	= 'CG';
						} else {

							if($sisa_saldo_cutist == 0.5 || $sisa_saldo_cuti == 0.5){
								$status_absen_d 		= 'CS';
							} else {
								$status_absen_d 		= 'CT';
							}
						}
						$sisa_saldo_cuti--;
						$sisa_saldo_cutist-= 0.5;

					}else{
						if($sisa_saldo_cuti < 0.5 ){
								$status_absen_d 	= 'CS';
						}else{
							$status_absen_d 		= 'CH';
						}
						$sisa_saldo_cuti-= 0.5;

					}
				}

				if($potong_cuti =='BONUS'){
					if($jumlah_hari =='1'){
						$status_absen_d		= 'CL';
					}else{
						$status_absen_d		= 'CH';
					}
				}

				if($potong_cuti =='NORMATIF'){

					$cek_cuti_detail  = $this->getAppDataNormatif($biodataids, $this->input->post('tgl_tdk_masuk')[$x]);

					$tgl_awal_berlaku = $cek_cuti_detail['tgl_mulai_berlaku'];

					$tgl_akhir_berlaku = $cek_cuti_detail['tgl_akhir_berlaku'];


					if($jumlah_hari == '1'){

						#// Pengecekan status saldo kurang lintas tahun
						if($normatif <= 0){
							$cek_cuti_ny 		= $this->getDataNormatifny($biodataids);
							$normatif			= $cek_cuti_ny['sisa_normatif'];
						}

						if($normatif <= 0 ){
								$status_absen_d 	= 'CG';
						} else {

							if($normatifst == 0.5 || $normatif == 0.5){
								$status_absen_d 		= 'CS';
							} else {
								$status_absen_d 		= 'CN';
							}
						}
						$normatif--;
						$normatifst-= 0.5;

					}else{
						if($normatif < 0.5 ){
								$status_absen_d 	= 'CS';
						}else{
							$status_absen_d 		= 'CH';
						}
						$normatif-= 0.5;

					}

				}

				#get keterangan status detail
				$search_status_d 		= $this->getKetAbsen($status_absen_d);
				$keterangan_d 			= 'AMBIL '.$search_status_d['ket_status_absensi'];
				#str nama hari
				$namahari = format_indo(date('D', strtotime($tgl_tdk_masuks)));

				#Data Detail
				$items = array(
					'tdk_masuk_h_id'	=> $data_header['tdk_masuk_h_id'],
					'tdk_masuk_d_id' 	=> $uuid_d,
					'potong_cuti_dari'	=> $potong_cuti,
					'keterangan' 		=> $keterangan_d,
					'is_potong_cuti'	=> '1',
					'urut_bonus'		=> $urutBonus,
					'nilai_hari' 	    => $jumlah_hari,
					'nama_hari' 	    => $namahari,
					'status_absen' 	    => $status_absen_d,
					'tgl_tdk_masuk' 	=> $tgl_tdk_masuks,
					'pic_input'         => $this->input->post('biodata_id'),
					'tgl_input'    		=> date('Y-m-d H:i:s'),
					// 'urut' 				=> $sisa_cuti_normatif,
				);

				#condition cek tanggal berlaku cuti
				if($this->input->post('tgl_tdk_masuk')[$x] >= $tgl_awal_berlaku && $this->input->post('tgl_tdk_masuk')[$x] <= $tgl_akhir_berlaku ){
					array_push($log_detail,$items);
					#insert data header & detail
					// $this->hrd->insert('hrd_all.trn_tidak_masuk_h', $data_header);
					// $this->hrd->insert('hrd_all.trn_tidak_masuk_d', $items);
				}else{
					$this->session->set_flashdata('error', $this->input->post('tgl_tdk_masuk')[$x].' Tidak sesuai dengan masa berlaku cuti!!');
					redirect('leaves/cuti/create', 'refresh');
				}
			}


			tesx($data_header,$log_detail);

			$data_posting = array(
				'tdk_masuk_h_id'	=> $data_header['tdk_masuk_h_id'],
				'status' 			=> '0',
				'status_dokumen' 	=> 'O'
			);
			$this->hrd->set($data_posting);
			$this->hrd->insert('hrd_all.trn_posting');

		/* END INSERT DATA */

		$this->send_mail_create($data_header, $log_detail);
		return ($sno_doc) ? $sno_doc : false;
	}

	public function ApproveAction()
	{
		$biodata_id =$this->input->post('biodata_id');
			$tdk_masuk_h_id =$this->input->post('tdk_masuk_h_id');
			$jml_ambil =$this->input->post('jml_ambil');
			$tgl_cuti = $this->input->post('tgl_cuti');
			$tgl_dokumen = $this->input->post('tgl_cuti');
			$no_dokumen	= $this->input->post('no_doc');
			$tgl_mulai_berlaku = $this->input->post('mulai_berlaku');
			$tgl_akhir_berlaku = $this->input->post('akhir_berlaku');
			$sisa_normatif = $this->input->post('sisa_normatif');
			$sisa_bonus = $this->input->post('sisa_bonus');
			$sisa_tambahan = $this->input->post('sisa_tambahan');
			$potong_cuti = $this->input->post('potong_cuti_dari');
		// $sisa_cuti = $sisa_normatif + $sisa_bonus + $sisa_tambahan;
		$id_saldo =$this->input->post('id_saldo_normatif');
		$nip = $this->session->userdata('nama_login');

		if ($this->input->post('status') == 'CH')
			$ambil_cuti = '0.5';
		else{
			$ambil_cuti = '1';
		}

		$getcount				= $this->count_nip($biodata_id);
		$getappuser				= $this->approvalCutiUser($nip,$tdk_masuk_h_id);

		if($getcount['nips'] 	!= NULL){
			$count				= $getcount['nips'];
		}else{ $count= '0';}
		// $count 				= $this->input->post('jml_app');
		$urutan_app 	 = $this->getHeaderData($tdk_masuk_h_id);
		$urutan_approval = $urutan_app['urutan_approval'];
		// $cek_cuti 		 = $this->getAppDataNormatif($biodata_id,$urutan_app['tgl_dok_tdk_masuk'] );


		if($urutan_approval==$count){


			$dates = date('Y-m-d');

			#update saldo cuti
			if($potong_cuti=='BONUS'){
				$dates = date('Y-m-d');
				$cek_bonus 		= $this->getDataBonus($biodata_id,$dates);
				if($ambil_cuti == '1'){
					$bonus 		= $cek_bonus['sisa_cuti'];
				}else{
					$bonus 		= $cek_bonus['sisa_cuti'];
				}

				$id_saldo =$this->input->post('id_saldo_bonus');
				$sisa = $cek_bonus['sisa_cuti'] - $jml_ambil;
				$data_update_saldo = array(
					'tgl_ambil_terakhir' => $tgl_dokumen,
					'saldo_awal'=> $cek_bonus['sisa_cuti'],
					'sisa_cuti' => $sisa,
				);
				$this->hrd->set($data_update_saldo);
				$this->hrd->where('saldo_cuti_bonus_id', $id_saldo);
				$this->hrd->update('hrd_all.trn_saldo_cuti_bonus');

				$log_history = array();
				$count_tgl_tdk_masuk = count($this->input->post('tgl_tdk_masuk'));
				for($x = 0; $x < $count_tgl_tdk_masuk; $x++) {
					if($ambil_cuti == '1'){
						$sisa_cuti_bonus		= $bonus--;
					}else{
						$sisa_cuti_bonus		= $bonus-= 0.5;
					}
					$jml_awal = $cek_bonus['sisa_cuti'];
					$items = array(
						'cuti_bonus_hist_id'	=> $this->uuid->v4(),
						'biodata_id'			=> $this->input->post('biodata_id'),
						'tdk_masuk_d_id' 		=> $this->input->post('tdk_masuk_d_id')[$x],
						'keterangan' 			=> $this->input->post('keterangan_cuti')[$x],
						'tgl' 					=> $this->input->post('tgl_tdk_masuk')[$x],
						'tgl_mulai_berlaku' 	=> $tgl_mulai_berlaku,
						'tgl_akhir_berlaku' 	=> $tgl_akhir_berlaku,
						'saldo_awal' 			=> $this->input->post('saldo_bonus'),
						'ambil_cuti' 			=> $jml_ambil,
						'jml_awal' 				=> $jml_awal,
						'jml_akhir' 			=> $sisa_cuti_bonus,
						'pic_input'         	=> $this->input->post('biodata_id'),
						'tgl_input'    			=> date('Y-m-d H:i:s'),
					);
					array_push($log_history,$items);
					$this->hrd->insert('hrd_all.trn_cuti_bonus_hist',$items);

				}
			}else if($potong_cuti=='NORMATIF'){


				$tgl_cuti_potong = $this->input->post('tgl_tdk_masuk');

				$log = array();

				for($x=0; $x < count($tgl_cuti_potong); $x++){

					/* CEK DATA CUTI*/
					$cek_cuti 	= $this->getAppDataNormatif($biodata_id, $this->input->post('tgl_tdk_masuk')[$x]);
					$normatif 	= $cek_cuti['sisa_normatif'];


					/* Update Saldo Normatif */
					if($cek_cuti['sisa_normatif'] == null){
						$saldo = '0';
						$sisa = $saldo  - $ambil_cuti;
						$data_update_saldo = array(
							'saldo_cuti_normatif_id' => $this->uuid->v4(),
							'biodata_id'	=> $biodata_id,
							'saldo_awal'	=> $sisa_normatif,
							'sisa_cuti' 	=> $sisa,
							'pic_input'		=> $biodata_id,
							'keterangan'	=> 'GENERATE SALDO CUTI MINUS',
							'tgl_input'			=> date('Y-m-d H:i:s'),
							'tgl_ambil_terakhir'=> date('Y-m-d'),
							'tgl_mulai_berlaku' => date('Y') . '-01-30',
							'tgl_akhir_berlaku'	=> date('Y') . '-12-31'
						);
						$this->hrd->insert('hrd_all.trn_saldo_cuti_normatif',$data_update_saldo);

					} else {

						#// Update tambahan - Pengecekan status saldo kurang lintas tahun
						if($cek_cuti['sisa_normatif'] <= 0){
							$cek_cuti 		= $this->getDataNormatifny($biodata_id);

							if($cek_cuti['sisa_normatif'] <= 0){
								$cek_cuti 	= $this->getAppDataNormatif($biodata_id, $this->input->post('tgl_tdk_masuk')[$x]);
							}
						}

						$sisa = $cek_cuti['sisa_normatif'] - $ambil_cuti;
						$data_update_saldo = array(
							'saldo_awal'	=> $cek_cuti['sisa_normatif'],
							'tgl_ambil_terakhir' => $this->input->post('tgl_tdk_masuk')[$x],
							'sisa_cuti' 	=> $sisa,
						);
						$this->hrd->set($data_update_saldo);
						$this->hrd->where('saldo_cuti_normatif_id', $cek_cuti['saldo_cuti_normatif_id']);
						$this->hrd->update('hrd_all.trn_saldo_cuti_normatif');


						array_push($log, $data_update_saldo);
					}
				}

				// tesx($log,$data_update_saldo);

				$log_history = array();
				$count_tgl_tdk_masuk = count($this->input->post('tgl_tdk_masuk'));

				$awal = $cek_cuti['sisa_normatif'];
				$akhir = $cek_cuti['sisa_normatif'];

				for($x = 0; $x < $count_tgl_tdk_masuk; $x++) {
					if($ambil_cuti == 1){
						$akhir--;
					}else{
						$akhir-= 0.5;
					}

					$items = array(
						'cuti_normatif_hist_id'	=> $this->uuid->v4(),
						'biodata_id'			=> $this->input->post('biodata_id'),
						'tdk_masuk_d_id' 		=> $this->input->post('tdk_masuk_d_id')[$x],
						'keterangan' 			=> $this->input->post('keterangan_cuti')[$x],
						'tgl' 					=> $this->input->post('tgl_tdk_masuk')[$x],
						'tgl_mulai_berlaku' 	=> $cek_cuti['tgl_mulai_berlaku'],
						'tgl_akhir_berlaku' 	=> $cek_cuti['tgl_akhir_berlaku'],
						'saldo_awal' 			=> $cek_cuti['sisa_normatif'],
						'ambil_cuti' 			=> $ambil_cuti,
						'jml_awal' 				=> $awal,
						'jml_akhir' 			=> $akhir,
						'pic_input'         	=> $this->input->post('biodata_id'),
						'tgl_input'    			=> date('Y-m-d H:i:s'),
					);
					array_push($log_history,$items);
					$this->hrd->insert('hrd_all.trn_cuti_normatif_hist', $items);

					if($ambil_cuti == 1){
						$awal--;
					}else{
						$awal-= 0.5;
					}

				}


			}

			// tesx($potong_cuti);

			$log_absen = array();
			$count_absen =  count($this->input->post('tgl_tdk_masuk'));

			$log_detil_tambahan = array();

			$log_datas_saldoR = array();
			$log_cuti_dR =array();

			$log_datas_saldo=array();
			$log_cuti_d =array();
			/*---- Insert Data Absen ----*/
			for($x = 0; $x < $count_absen; $x++) {

				#status cuti
				$id_status  = $this->input->post('status_absen')[$x];
				// $cek_status = $this->getStatusAbsen($id_status);
				$cek_status = $this->getKetAbsen($id_status);
				$kd_status 	= $cek_status['kode_status_absensi'];
				$ket_absen 	= $cek_status['ket_status_absensi'];

				if($potong_cuti=='TAMBAHAN'){


					$sct = $this->getMasaBerlakuTambahan($biodata_id, $this->input->post('tgl_tdk_masuk')[$x]);
					$tambahan_saldo = $this->getDataTambahan($biodata_id,$dates);
					$sctR = $this->getMasaBerlakuTambahanRow($biodata_id, $this->input->post('tgl_tdk_masuk')[$x]);

					if($ambil_cuti == '1'){
						$tambahan 		= $tambahan_saldo['sisa_cuti_tambahan'];
					}else{
						$tambahan 		= $tambahan_saldo['sisa_cuti_tambahan']+'0.5';
					}

					// CEK SALDO CUTI TAMBAHAN NOTIF
					if($tambahan_saldo['sisa_cuti_tambahan'] >= $jml_ambil){
						// tesx($urutan_approval,  'test', $ambil_cuti, $tambahan_saldo['sisa_cuti_tambahan'], $jml_ambil);

						$log_foreach = array();

						$tgl_tdk_masuk_tam = $this->input->post('tgl_tdk_masuk');

						if($ambil_cuti == '1'){
							foreach($sct as $k => $v){
								if($jml_ambil > 0) {
									if($jml_ambil <= $v['sisa_cuti']){
										#--- Pengurang Saldo
										$datas[$k]['hasil'] =  $v['sisa_cuti'] - $jml_ambil;
										$jml_ambil = '0';

										if($datas[$k]['hasil'] > 0){
											$detil_sisa_cuti = $datas[$k]['hasil'];
										}else{
											$detil_sisa_cuti = $v['sisa_cuti'];
										}

										$tgl_sort_t = $_POST['tgl_tdk_masuk'];
										asort($tgl_sort_t);// asort - DESC / rsort - ASC
										$tgl_sort_t = $tgl_sort_t[array_key_last($tgl_sort_t)];
										#-- Update 2023 Save Trn Detil Tambahan  Saldo Tambahan Id 16/05/2023
										if(!empty($_POST['tgl_tdk_masuk'][$k])){ $tgl_tdk_masuk_detil = $_POST['tgl_tdk_masuk'][$k]; }else{ $tgl_tdk_masuk_detil = $tgl_sort_t; };
										$detil_tambahan[$k] = array(
											'id'						=> $this->uuid->v4(),
											'tdk_masuk_h_id'			=> $tdk_masuk_h_id,
											'no_dok_tdk_masuk'  		=> $this->input->post('no_doc'),
											'no_reff'					=> $v['no_dok_cuti_tambahan'],
											'tgl_tdk_masuk'				=> $tgl_tdk_masuk_detil,
											'biodata_id'				=> $this->input->post('biodata_id'),
											'nilai'  					=> $detil_sisa_cuti,
											'jenis'  					=> $kd_status,
										);
										array_push($log_detil_tambahan,$detil_tambahan[$k]);
										$this->hrd->insert('hrd_all.trn_detil_cuti_tambahan', $detil_tambahan[$k]);

										#-- Data Saldo Cuti
										$datas_saldo[$k] = array(
											'saldo_cuti_tambahan_id'=> $v['saldo_cuti_tambahan_id'],
											'saldo_awal'            => $v['sisa_cuti'],
											'sisa_cuti'             => $datas[$k]['hasil'],
											'is_terpakai'			=> '1',
											'tgl_ambil_terakhir'	=> $tgl_dokumen,
											'keterangan'			=> $no_dokumen
										);
										array_push($datas_saldo[$k]);
										$id_saldo_tambahan = $v['saldo_cuti_tambahan_id'];
										$this->hrd->where('saldo_cuti_tambahan_id', $id_saldo_tambahan);
										$this->hrd->update('hrd_all.trn_saldo_cuti_tambahan',$datas_saldo[$k]);

										#--- Update Cuti Detail
										if(!empty($_POST['tgl_tdk_masuk'][$k])){
											$tdk_masuk_d_id = $this->getTglCutiDetail($tdk_masuk_h_id,$_POST['tgl_tdk_masuk'][$k]);
											$cuti_d[$k] = array(
												'saldo_cuti_tambahan_id'=> $v['saldo_cuti_tambahan_id'],
											);
											array_push($cuti_d[$k]);
											$this->hrd->where('tdk_masuk_d_id', $tdk_masuk_d_id['tdk_masuk_d_id']);
											$this->hrd->update('hrd_all.trn_tidak_masuk_d',$cuti_d[$k]);
										}

									} else {
										#--- Pengurang saldo
										$datas[$k]['hasil'] = $jml_ambil - $v['sisa_cuti'];
										$jml_ambil = $datas[$k]['hasil'];
										$hasil = '0';

										$tgl_sort_t = $_POST['tgl_tdk_masuk'];
										asort($tgl_sort_t);// asort - DESC / rsort - ASC
										$tgl_sort_t = $tgl_sort_t[array_key_last($tgl_sort_t)];
										#--- Update 2023 Save Trn Detil Tambahan
										if(!empty($_POST['tgl_tdk_masuk'][$k])){ $tgl_tdk_masuk_detil = $_POST['tgl_tdk_masuk'][$k]; }else{ $tgl_tdk_masuk_detil = $tgl_sort_t; };
										$detil_tambahan[$k] = array(
											'id'						=> $this->uuid->v4(),
											'tdk_masuk_h_id'			=> $tdk_masuk_h_id,
											'no_dok_tdk_masuk'  		=> $this->input->post('no_doc'),
											'no_reff'					=> $v['no_dok_cuti_tambahan'],
											'tgl_tdk_masuk'				=> $tgl_tdk_masuk_detil,
											'biodata_id'				=> $this->input->post('biodata_id'),
											'nilai'  					=> $v['sisa_cuti'],
											'jenis'  					=> $kd_status,
										);
										array_push($log_detil_tambahan,$detil_tambahan[$k]);
										$this->hrd->insert('hrd_all.trn_detil_cuti_tambahan', $detil_tambahan[$k]);

										$datas_saldo[$k] = array(
											'saldo_cuti_tambahan_id'=> $v['saldo_cuti_tambahan_id'],
											'saldo_awal'            => $v['sisa_cuti'],
											'sisa_cuti'             => $hasil,
											'is_terpakai'			=> '1',
											'tgl_ambil_terakhir'	=> $tgl_dokumen,
											'keterangan'			=> $no_dokumen
										);
										array_push($datas_saldo[$k]);
										$id_saldo_tambahan = $v['saldo_cuti_tambahan_id'];
										$this->hrd->where('saldo_cuti_tambahan_id', $id_saldo_tambahan);
										$this->hrd->update('hrd_all.trn_saldo_cuti_tambahan',$datas_saldo[$k]);

										#--- Update Cuti Detail
										if(!empty($_POST['tgl_tdk_masuk'][$k])){
											$tdk_masuk_d_id = $this->getTglCutiDetail($tdk_masuk_h_id,$_POST['tgl_tdk_masuk'][$k]);
											$cuti_d[$k] = array(
												'saldo_cuti_tambahan_id'=> $v['saldo_cuti_tambahan_id'],
											);
											array_push($cuti_d[$k]);
											$this->hrd->where('tdk_masuk_d_id', $tdk_masuk_d_id['tdk_masuk_d_id']);
											$this->hrd->update('hrd_all.trn_tidak_masuk_d',$cuti_d[$k]);
										}

									}
								}
							}

						} else {

							$datasR['hasil'] = $sctR['sisa_cuti'] - $ambil_cuti;

							// Update 2023 Save Trn Detil Tambahan
							$detil_tambahan = array(
								'id'						=> $this->uuid->v4(),
								'tdk_masuk_h_id'			=> $tdk_masuk_h_id,
								'no_dok_tdk_masuk'  		=> $this->input->post('no_doc'),
								'no_reff'					=> $sctR['no_dok_cuti_tambahan'],
								'tgl_tdk_masuk'				=> $this->input->post('tgl_tdk_masuk')[$x],
								'biodata_id'				=> $this->input->post('biodata_id'),
								'nilai'  					=> $ambil_cuti,
								'jenis'  					=> $kd_status,
							);
							array_push($log_detil_tambahan,$detil_tambahan);
							$this->hrd->insert('hrd_all.trn_detil_cuti_tambahan', $detil_tambahan);

							$datas_saldoR = array(
								'saldo_cuti_tambahan_id'=> $sctR['saldo_cuti_tambahan_id'],
								'saldo_awal'            => $sctR['sisa_cuti'],
								'sisa_cuti'             => $datasR['hasil'],
								'is_terpakai'			=> '1',
								'tgl_ambil_terakhir'	=> $this->input->post('tgl_tdk_masuk')[$x],
								'keterangan'			=> $no_dokumen
							);
							array_push($log_datas_saldoR,$datas_saldoR);
							$id_saldo_tambahan = $sctR['saldo_cuti_tambahan_id'];
							$this->hrd->where('saldo_cuti_tambahan_id', $id_saldo_tambahan);
							$this->hrd->update('hrd_all.trn_saldo_cuti_tambahan',$datas_saldoR);

							#Update Detail Cuti / Saldo Tambahan Id
							$tdk_masuk_d_id = $this->getTglCutiDetail($tdk_masuk_h_id,$this->input->post('tgl_tdk_masuk')[$x]);
							$cuti_d = array(
								'saldo_cuti_tambahan_id'=> $sctR['saldo_cuti_tambahan_id'],
							);
							array_push($log_cuti_dR,$cuti_d);
							$this->hrd->where('tdk_masuk_d_id', $tdk_masuk_d_id['tdk_masuk_d_id']);
							$this->hrd->update('hrd_all.trn_tidak_masuk_d',$cuti_d);

						}

					}else{
						$this->session->set_flashdata('error', 'Dokumen : <b>'.$no_dokumen.'</b>  Tidak bisa diajukan, Saldo Cuti Tidak Cukup, Sudah dipakai dokumen lain !!');
						redirect('leaves/cuti/approval_detail/'.$tdk_masuk_h_id , 'refresh');
					}

				}
				// } #----- End For Test

				#cek saldo cuti
				if($potong_cuti == 'NORMATIF'){
						$sisa_cuti		= $cek_cuti['sisa_normatif'];
						$sisa_cuti_st	= $cek_cuti['sisa_normatif'];
				}else if($potong_cuti == 'BONUS'){
					$sisa_cuti		= $cek_bonus['sisa_cuti'];
				}else if($potong_cuti == 'TAMBAHAN'){

					$sisa_cuti		= $tambahan_saldo['sisa_cuti_tambahan'];
				}


				#get tgl cuti untuk cek absensi
				$tgl_absen = $this->input->post('tgl_tdk_masuk')[$x];
				$cek_absen = $this->getDataAbsensi($biodata_id,$tgl_absen);
				#save data absensi
				if($tgl_absen == $cek_absen['tgl_absensi']){
					$data_absensi = array(
						'gol_absensi_d_id'			=> $this->input->post('gol_absensi_d_id'),
						'no_trn_absen'  			=> $this->input->post('no_doc'),
						'no_reff'  					=> $this->input->post('no_doc'),
						'is_manual'  				=> '1',
						'status_absen'  			=> $kd_status,
						'keterangan'  				=> $kd_status,
						'keterangan2'  				=> $ket_absen,
					);
					array_push($log_absen,$data_absensi);
					$where = array('biodata_id' => $biodata_id,'tgl_absensi' => $tgl_absen );
					$this->hrd->where($where);
					$this->hrd->update('hrd_all.trn_absensi',$data_absensi);
				}else{

					$data_absensi = array(
						'biodata_id'				=> $this->input->post('biodata_id'),
						'gol_absensi_d_id'			=> $this->input->post('gol_absensi_d_id'),
						'no_trn_absen'  			=> $this->input->post('no_doc'),
						'no_reff'  					=> $this->input->post('no_doc'),
						'kode_store'  				=> $this->input->post('kode_store'),
						'hari'  					=> $this->input->post('posisi_hari')[$x],
						'jam_masuk'  				=> $this->input->post('jam_masuk'),
						'jam_keluar'  				=> $this->input->post('jam_keluar'),
						'jam_shift_masuk'  			=> $this->input->post('jam_masuk'),
						'jam_shift_keluar'  		=> $this->input->post('jam_keluar'),
						'status_absen'  			=> $kd_status,
						'keterangan'  				=> $kd_status,
						'keterangan2'  				=> $ket_absen,
						'is_manual'  				=> '1',
						'tgl_absensi'				=> $this->input->post('tgl_tdk_masuk')[$x],
						'pic_input'					=> $this->session->userdata('nama_login'),
						'wkt_input'					=> date('Y-m-d'),
					);
					array_push($log_absen,$data_absensi);
					$this->hrd->insert('hrd_all.trn_absensi', $data_absensi);
				}

				if($potong_cuti=='NORMATIF'){
					// Update 2023 Save Trn Detil Normatif
					$detil_normatif = array(
						'tdk_masuk_h_id'			=> $tdk_masuk_h_id,
						'biodata_id'				=> $this->input->post('biodata_id'),
						'no_dok_tdk_masuk'  		=> $this->input->post('no_doc'),
						'tgl_tdk_masuk'				=> $this->input->post('tgl_tdk_masuk')[$x],
						'nilai'  					=> $ambil_cuti,
						'jenis'  					=> $kd_status,
					);
					$this->hrd->insert('hrd_all.trn_detil_cuti_normatif', $detil_normatif);

				}


			} #-- END For

			$data_posting = array(
				'tdk_masuk_h_id'				=> $tdk_masuk_h_id,
				'app_'.$urutan_approval.''		=> $nip,
				'tgl_app_'.$urutan_approval.'' 	=> date('Y-m-d h:i:s'),
				'status' 						=> $urutan_approval,
				'status_dokumen' 				=> 'C'
			);
			$this->hrd->set($data_posting);
			$this->hrd->where('tdk_masuk_h_id', $tdk_masuk_h_id);
			$this->hrd->update('hrd_all.trn_posting');

			$data_dok = array(
				'tdk_masuk_h_id'=> $tdk_masuk_h_id,
				'is_posting'	=> '1',
				'pic_posting' 	=> $this->input->post('biodata_id'),
				'tgl_posting'	=> date('Y-m-d'),
			);
			$this->hrd->set($data_dok);
			$this->hrd->where('tdk_masuk_h_id', $tdk_masuk_h_id);
			$this->hrd->update('hrd_all.trn_tidak_masuk_h');

		}else{
			$data_dok = array(
				'tdk_masuk_h_id'=> $tdk_masuk_h_id,
				'is_posting'	=> '0',
				'pic_posting' 	=> $this->input->post('biodata_id'),
				'tgl_posting'	=> date('Y-m-d'),
			);
			$this->hrd->set($data_dok);
			$this->hrd->where('tdk_masuk_h_id', $tdk_masuk_h_id);
			$this->hrd->update('hrd_all.trn_tidak_masuk_h');

			$data_posting = array(
				'tdk_masuk_h_id'				=> $tdk_masuk_h_id,
				'app_'.$urutan_approval.''		=> $nip,
				'tgl_app_'.$urutan_approval.'' 	=> date('Y-m-d h:i:s'),
				'status' 						=> $urutan_approval,
				'status_dokumen' 				=> 'P'
			);
			$this->hrd->set($data_posting);
			$this->hrd->where('tdk_masuk_h_id', $tdk_masuk_h_id);
			$this->hrd->update('hrd_all.trn_posting');
		}

		if($urutan_approval=='1'){
			$tdk_masuk_h_id =$this->input->post('tdk_masuk_h_id');
			$this->send_mail_approve($tdk_masuk_h_id);
		}
		$sno_doc        = $this->input->post('no_doc');
		return ($sno_doc) ? $sno_doc : false;
	}


	public function ApproveActionOLD()
	{
		$biodata_id =$this->input->post('biodata_id');
			$tdk_masuk_h_id =$this->input->post('tdk_masuk_h_id');
			$jml_ambil =$this->input->post('jml_ambil');
			$tgl_cuti = $this->input->post('tgl_cuti');
			$tgl_dokumen = $this->input->post('tgl_cuti');
			$no_dokumen	= $this->input->post('no_doc');
			$tgl_mulai_berlaku = $this->input->post('mulai_berlaku');
			$tgl_akhir_berlaku = $this->input->post('akhir_berlaku');
			$sisa_normatif = $this->input->post('sisa_normatif');
			$sisa_bonus = $this->input->post('sisa_bonus');
			$sisa_tambahan = $this->input->post('sisa_tambahan');
			$potong_cuti = $this->input->post('potong_cuti_dari');
		// $sisa_cuti = $sisa_normatif + $sisa_bonus + $sisa_tambahan;
		$id_saldo =$this->input->post('id_saldo_normatif');
		$nip = $this->session->userdata('nama_login');

		if ($this->input->post('status') == 'CH')
			$ambil_cuti = '0.5';
		else{
			$ambil_cuti = '1';
		}

		$getcount				= $this->count_nip($biodata_id);
		$getappuser				= $this->approvalCutiUser($nip,$tdk_masuk_h_id);

		if($getcount['nips'] 	!= NULL){
			$count				= $getcount['nips'];
		}else{ $count= '0';}
		// $count 				= $this->input->post('jml_app');
		$urutan_app 	 = $this->getHeaderData($tdk_masuk_h_id);
		$urutan_approval = $urutan_app['urutan_approval'];
		// $cek_cuti 		 = $this->getAppDataNormatif($biodata_id,$urutan_app['tgl_dok_tdk_masuk'] );

		// tesx($urutan_app);
		// tesx($count, $urutan_approval, $no_dokumen, $tgl_dokumen);

		if($urutan_approval==$count){
			$dates = date('Y-m-d');

			#update saldo cuti
			if($potong_cuti=='BONUS'){
				$dates = date('Y-m-d');
				$cek_bonus 		= $this->getDataBonus($biodata_id,$dates);
				if($ambil_cuti == '1'){
					$bonus 		= $cek_bonus['sisa_cuti'];
				}else{
					$bonus 		= $cek_bonus['sisa_cuti'];
				}

				$id_saldo =$this->input->post('id_saldo_bonus');
				$sisa = $cek_bonus['sisa_cuti'] - $jml_ambil;
				$data_update_saldo = array(
					'tgl_ambil_terakhir' => $tgl_dokumen,
					'saldo_awal'=> $cek_bonus['sisa_cuti'],
					'sisa_cuti' => $sisa,
				);
				$this->hrd->set($data_update_saldo);
				$this->hrd->where('saldo_cuti_bonus_id', $id_saldo);
				$this->hrd->update('hrd_all.trn_saldo_cuti_bonus');

				$log_history = array();
				$count_tgl_tdk_masuk = count($this->input->post('tgl_tdk_masuk'));
				for($x = 0; $x < $count_tgl_tdk_masuk; $x++) {
					if($ambil_cuti == '1'){
						$sisa_cuti_bonus		= $bonus--;
					}else{
						$sisa_cuti_bonus		= $bonus-= 0.5;
					}
					$jml_awal = $cek_bonus['sisa_cuti'];
					$items = array(
						'cuti_bonus_hist_id'	=> $this->uuid->v4(),
						'biodata_id'			=> $this->input->post('biodata_id'),
						'tdk_masuk_d_id' 		=> $this->input->post('tdk_masuk_d_id')[$x],
						'keterangan' 			=> $this->input->post('keterangan_cuti')[$x],
						'tgl' 					=> $this->input->post('tgl_tdk_masuk')[$x],
						'tgl_mulai_berlaku' 	=> $tgl_mulai_berlaku,
						'tgl_akhir_berlaku' 	=> $tgl_akhir_berlaku,
						'saldo_awal' 			=> $this->input->post('saldo_bonus'),
						'ambil_cuti' 			=> $jml_ambil,
						'jml_awal' 				=> $jml_awal,
						'jml_akhir' 			=> $sisa_cuti_bonus,
						'pic_input'         	=> $this->input->post('biodata_id'),
						'tgl_input'    			=> date('Y-m-d H:i:s'),
					);
					array_push($log_history,$items);
					$this->hrd->insert('hrd_all.trn_cuti_bonus_hist',$items);

				}
			}else if($potong_cuti=='NORMATIF'){

				$tgl_cuti_potong = $this->input->post('tgl_tdk_masuk');

				$log = array();

				for($x=0; $x < count($tgl_cuti_potong); $x++){

					/* CEK DATA CUTI*/
					$cek_cuti 	= $this->getAppDataNormatif($biodata_id, $this->input->post('tgl_tdk_masuk')[$x]);
					$normatif 	= $cek_cuti['sisa_normatif'];


					/* Update Saldo Normatif */
					if($cek_cuti['sisa_normatif'] == null){
						$saldo = '0';
						$sisa = $saldo  - $ambil_cuti;
						$data_update_saldo = array(
							'saldo_cuti_normatif_id' => $this->uuid->v4(),
							'biodata_id'	=> $biodata_id,
							'saldo_awal'	=> $sisa_normatif,
							'sisa_cuti' 	=> $sisa,
							'pic_input'		=> $biodata_id,
							'keterangan'	=> 'GENERATE SALDO CUTI MINUS',
							'tgl_input'			=> date('Y-m-d H:i:s'),
							'tgl_ambil_terakhir'=> date('Y-m-d'),
							'tgl_mulai_berlaku' => date('Y') . '-01-30',
							'tgl_akhir_berlaku'	=> date('Y') . '-12-31'
						);
						$this->hrd->insert('hrd_all.trn_saldo_cuti_normatif',$data_update_saldo);

					} else {
						$sisa = $cek_cuti['sisa_normatif'] - $ambil_cuti;
						$data_update_saldo = array(
							'saldo_awal'	=> $cek_cuti['sisa_normatif'],
							'tgl_ambil_terakhir' => $this->input->post('tgl_tdk_masuk')[$x],
							'sisa_cuti' 	=> $sisa,
						);
						$this->hrd->set($data_update_saldo);
						$this->hrd->where('saldo_cuti_normatif_id', $cek_cuti['saldo_cuti_normatif_id']);
						$this->hrd->update('hrd_all.trn_saldo_cuti_normatif');


						array_push($log, $data_update_saldo);
					}
				}


				$log_history = array();
				$count_tgl_tdk_masuk = count($this->input->post('tgl_tdk_masuk'));


				$awal = $cek_cuti['sisa_normatif'];
				$akhir = $cek_cuti['sisa_normatif'];

				for($x = 0; $x < $count_tgl_tdk_masuk; $x++) {

					if($ambil_cuti == 1){
						$akhir--;
					}else{
						$akhir-= 0.5;
					}

					$items = array(
						'cuti_normatif_hist_id'	=> $this->uuid->v4(),
						'biodata_id'			=> $this->input->post('biodata_id'),
						'tdk_masuk_d_id' 		=> $this->input->post('tdk_masuk_d_id')[$x],
						'keterangan' 			=> $this->input->post('keterangan_cuti')[$x],
						'tgl' 					=> $this->input->post('tgl_tdk_masuk')[$x],
						'tgl_mulai_berlaku' 	=> $cek_cuti['tgl_mulai_berlaku'],
						'tgl_akhir_berlaku' 	=> $cek_cuti['tgl_akhir_berlaku'],
						'saldo_awal' 			=> $cek_cuti['sisa_normatif'],
						'ambil_cuti' 			=> $ambil_cuti,
						'jml_awal' 				=> $awal,
						'jml_akhir' 			=> $akhir,
						'pic_input'         	=> $this->input->post('biodata_id'),
						'tgl_input'    			=> date('Y-m-d H:i:s'),
					);
					array_push($log_history,$items);
					$this->hrd->insert('hrd_all.trn_cuti_normatif_hist', $items);

					if($ambil_cuti == 1){
						$awal--;
					}else{
						$awal-= 0.5;
					}
				}


			}



			$log_absen = array();
			$count_absen =  count($this->input->post('tgl_tdk_masuk'));


			/*---- Insert Data Absen----*/
			for($x = 0; $x < $count_absen; $x++) {

				if($potong_cuti=='TAMBAHAN'){

					$sct = $this->getMasaBerlakuTambahan($biodata_id, $this->input->post('tgl_tdk_masuk')[$x]);

					$tambahan_saldo = $this->getDataTambahan($biodata_id,$dates);

					// tesx($sct, $this->input->post('tgl_tdk_masuk')[$x]);
					if($ambil_cuti == '1'){
						$tambahan 		= $tambahan_saldo['sisa_cuti_tambahan'];
					}else{
						$tambahan 		= $tambahan_saldo['sisa_cuti_tambahan']+'0.5';
					}

					// $jml_ambil = '0.5';
					// tesx($jml_ambil);

					foreach($sct as $k=>$v){
						// tesx($v['sisa_cuti']);
						if($jml_ambil > 0) {
							if($jml_ambil <= $v['sisa_cuti']){
								$datas[$k]['hasil'] =  $v['sisa_cuti'] - $jml_ambil;
								$jml_ambil = '0';

								// tesx($tmp);

								$datas_saldo[$k] = array(
									'saldo_cuti_tambahan_id'=> $v['saldo_cuti_tambahan_id'],
									'saldo_awal'            => $v['sisa_cuti'],
									'sisa_cuti'             => $datas[$k]['hasil'],
									'is_terpakai'			=> '1',
									'tgl_ambil_terakhir'	=> $tgl_dokumen,
									'keterangan'			=> $no_dokumen
								);
								array_push($datas_saldo[$k]);
								$id_saldo_tambahan = $v['saldo_cuti_tambahan_id'];
								$this->hrd->where('saldo_cuti_tambahan_id', $id_saldo_tambahan);
								$this->hrd->update('hrd_all.trn_saldo_cuti_tambahan',$datas_saldo[$k]);

								#Update Detail Cuti / Saldo Tambahan Id 16/05/2023
								$tdk_masuk_d_id = $this->getTglCutiDetail($tdk_masuk_h_id,$this->input->post('tgl_tdk_masuk')[$x]);
								$cuti_d[$k] = array(
									'saldo_cuti_tambahan_id'=> $v['saldo_cuti_tambahan_id'],
								);
								array_push($cuti_d[$k]);
								$this->hrd->where('tdk_masuk_d_id', $tdk_masuk_d_id['tdk_masuk_d_id']);
								$this->hrd->update('hrd_all.trn_tidak_masuk_d',$cuti_d[$k]);


							} else {
								$datas[$k]['hasil'] = $jml_ambil - $v['sisa_cuti'];
								$jml_ambil = $datas[$k]['hasil'];
								$hasil = '0';

								$datas_saldo[$k] = array(
									'saldo_cuti_tambahan_id'=> $v['saldo_cuti_tambahan_id'],
									'saldo_awal'            => $v['sisa_cuti'],
									'sisa_cuti'             => $hasil,
									'is_terpakai'			=> '1',
									'tgl_ambil_terakhir'	=> $tgl_dokumen,
									'keterangan'			=> $no_dokumen
								);
								array_push($datas_saldo[$k]);
								$id_saldo_tambahan = $v['saldo_cuti_tambahan_id'];
								$this->hrd->where('saldo_cuti_tambahan_id', $id_saldo_tambahan);
								$this->hrd->update('hrd_all.trn_saldo_cuti_tambahan',$datas_saldo[$k]);


								#Update Detail Cuti / Saldo Tambahan Id 16/05/2023
								$tdk_masuk_d_id = $this->getTglCutiDetail($tdk_masuk_h_id,$this->input->post('tgl_tdk_masuk')[$x]);
								$cuti_d[$k] = array(
									'saldo_cuti_tambahan_id'=> $v['saldo_cuti_tambahan_id'],
								);
								array_push($cuti_d[$k]);
								$this->hrd->where('tdk_masuk_d_id', $tdk_masuk_d_id['tdk_masuk_d_id']);
								$this->hrd->update('hrd_all.trn_tidak_masuk_d',$cuti_d[$k]);
							}
						}
					}

					// tesx($datas_saldo, $tambahan_saldo['sisa_cuti_tambahan'], $jml_ambil);
				}

				#cek saldo cuti
				if($potong_cuti == 'NORMATIF'){
						$sisa_cuti		= $cek_cuti['sisa_normatif'];
						$sisa_cuti_st	= $cek_cuti['sisa_normatif'];
				}else if($potong_cuti == 'BONUS'){
					$sisa_cuti		= $cek_bonus['sisa_cuti'];
				}else if($potong_cuti == 'TAMBAHAN'){
					$sisa_cuti		= $tambahan_saldo['sisa_cuti_tambahan'];
				}

				#status cuti
				$id_status  = $this->input->post('status_absen')[$x];
				// $cek_status = $this->getStatusAbsen($id_status);
				$cek_status = $this->getKetAbsen($id_status);
				$kd_status 	= $cek_status['kode_status_absensi'];
				$ket_absen 	= $cek_status['ket_status_absensi'];


				#get tgl cuti untuk cek absensi
				$tgl_absen = $this->input->post('tgl_tdk_masuk')[$x];
				$cek_absen = $this->getDataAbsensi($biodata_id,$tgl_absen);
				#save data absensi
				if($tgl_absen == $cek_absen['tgl_absensi']){
					$data_absensi = array(
						'gol_absensi_d_id'			=> $this->input->post('gol_absensi_d_id'),
						'no_trn_absen'  			=> $this->input->post('no_doc'),
						'no_reff'  					=> $this->input->post('no_doc'),
						'is_manual'  				=> '1',
						'status_absen'  			=> $kd_status,
						'keterangan'  				=> $kd_status,
						'keterangan2'  				=> $ket_absen,
					);
					array_push($log_absen,$data_absensi);
					$where = array('biodata_id' => $biodata_id,'tgl_absensi' => $tgl_absen );
					$this->hrd->where($where);
					$this->hrd->update('hrd_all.trn_absensi',$data_absensi);
				}else{

					$data_absensi = array(
						'biodata_id'				=> $this->input->post('biodata_id'),
						'gol_absensi_d_id'			=> $this->input->post('gol_absensi_d_id'),
						'no_trn_absen'  			=> $this->input->post('no_doc'),
						'no_reff'  					=> $this->input->post('no_doc'),
						'kode_store'  				=> $this->input->post('kode_store'),
						'hari'  					=> $this->input->post('posisi_hari')[$x],
						'jam_masuk'  				=> $this->input->post('jam_masuk'),
						'jam_keluar'  				=> $this->input->post('jam_keluar'),
						'jam_shift_masuk'  			=> $this->input->post('jam_masuk'),
						'jam_shift_keluar'  		=> $this->input->post('jam_keluar'),
						'status_absen'  			=> $kd_status,
						'keterangan'  				=> $kd_status,
						'keterangan2'  				=> $ket_absen,
						'is_manual'  				=> '1',
						'tgl_absensi'				=> $this->input->post('tgl_tdk_masuk')[$x],
						'pic_input'					=> $this->session->userdata('nama_login'),
						'wkt_input'					=> date('Y-m-d'),
					);
					array_push($log_absen,$data_absensi);
					$this->hrd->insert('hrd_all.trn_absensi', $data_absensi);
				}

				// Update 2023 Save Trn Detil Normatif
				if($potong_cuti=='NORMATIF'){
					$detil_normatif = array(
						'tdk_masuk_h_id'			=> $tdk_masuk_h_id,
						'biodata_id'				=> $this->input->post('biodata_id'),
						'no_dok_tdk_masuk'  		=> $this->input->post('no_doc'),
						'tgl_tdk_masuk'				=> $this->input->post('tgl_tdk_masuk')[$x],
						'nilai'  					=> $ambil_cuti,
						'jenis'  					=> $kd_status,
					);
					$this->hrd->insert('hrd_all.trn_detil_cuti_normatif', $detil_normatif);

				}

			}

			// tesx($potong_cuti,$ambil_cuti,  $log_absen, $log_history);

			$data_posting = array(
				'tdk_masuk_h_id'				=> $tdk_masuk_h_id,
				'app_'.$urutan_approval.''		=> $nip,
				'tgl_app_'.$urutan_approval.'' 	=> date('Y-m-d h:i:s'),
				'status' 						=> $urutan_approval,
				'status_dokumen' 				=> 'C'
			);
			$this->hrd->set($data_posting);
			$this->hrd->where('tdk_masuk_h_id', $tdk_masuk_h_id);
			$this->hrd->update('hrd_all.trn_posting');

			$data_dok = array(
				'tdk_masuk_h_id'=> $tdk_masuk_h_id,
				'is_posting'	=> '1',
				'pic_posting' 	=> $this->input->post('biodata_id'),
				'tgl_posting'	=> date('Y-m-d'),
			);
			$this->hrd->set($data_dok);
			$this->hrd->where('tdk_masuk_h_id', $tdk_masuk_h_id);
			$this->hrd->update('hrd_all.trn_tidak_masuk_h');

		}else{
			$data_dok = array(
				'tdk_masuk_h_id'=> $tdk_masuk_h_id,
				'is_posting'	=> '0',
				'pic_posting' 	=> $this->input->post('biodata_id'),
				'tgl_posting'	=> date('Y-m-d'),
			);
			// die(json_encode($data_dok));
			$this->hrd->set($data_dok);
			$this->hrd->where('tdk_masuk_h_id', $tdk_masuk_h_id);
			$this->hrd->update('hrd_all.trn_tidak_masuk_h');

			$data_posting = array(
				'tdk_masuk_h_id'				=> $tdk_masuk_h_id,
				'app_'.$urutan_approval.''		=> $nip,
				'tgl_app_'.$urutan_approval.'' 	=> date('Y-m-d h:i:s'),
				'status' 						=> $urutan_approval,
				'status_dokumen' 				=> 'P'
			);
			// die(json_encode($data_posting));
			$this->hrd->set($data_posting);
			$this->hrd->where('tdk_masuk_h_id', $tdk_masuk_h_id);
			$this->hrd->update('hrd_all.trn_posting');
		}

		// die(json_encode($tdk_masuk_h_id));
		if($urutan_approval=='1'){
			$tdk_masuk_h_id =$this->input->post('tdk_masuk_h_id');
			$this->send_mail_approve($tdk_masuk_h_id);
		}
		$sno_doc        = $this->input->post('no_doc');
		return ($sno_doc) ? $sno_doc : false;
	}


	public function ApproveDireksi()
	{
		$biodata_id =$this->input->post('biodata_id');
			$tdk_masuk_h_id =$this->input->post('tdk_masuk_h_id');
			$jml_ambil =$this->input->post('jml_ambil');
			$tgl_cuti = $this->input->post('tgl_cuti');
			$tgl_dokumen = $this->input->post('tgl_cuti');
			$no_dokumen	= $this->input->post('no_doc');
			$tgl_mulai_berlaku = $this->input->post('mulai_berlaku');
			$tgl_akhir_berlaku = $this->input->post('akhir_berlaku');
			$sisa_normatif = $this->input->post('sisa_normatif');
			$sisa_bonus = $this->input->post('sisa_bonus');
			$sisa_tambahan = $this->input->post('sisa_tambahan');
			$potong_cuti = $this->input->post('potong_cuti_dari');
		// $sisa_cuti = $sisa_normatif + $sisa_bonus + $sisa_tambahan;
		$id_saldo =$this->input->post('id_saldo_normatif');
		$nip = $this->session->userdata('nama_login');

		if ($this->input->post('status') == 'CH')
			$ambil_cuti = '0.5';
		else{
			$ambil_cuti = '1';
		}

		$getcount				= $this->count_nip($biodata_id);
		if($getcount['nips'] 	!= NULL){
			$count				= $getcount['nips'];
		}else{ $count= '0';}
		// $count 				= $this->input->post('jml_app');
		$urutan_app 	 = $this->getHeaderData($tdk_masuk_h_id);
		$urutan_approval = $urutan_app['urutan_approval'];
		$cek_cuti 		 = $this->getDataNormatif($biodata_id);

		// tesx($count, $urutan_approval, $no_dokumen, $tgl_dokumen);

			$dates = date('Y-m-d');

			#update saldo cuti
			if($potong_cuti=='BONUS'){
				$dates = date('Y-m-d');
				$cek_bonus 		= $this->getDataBonus($biodata_id,$dates);
				if($ambil_cuti == '1'){
					$bonus 		= $cek_bonus['sisa_cuti'];
				}else{
					$bonus 		= $cek_bonus['sisa_cuti'];
				}

				$id_saldo =$this->input->post('id_saldo_bonus');
				$sisa = $cek_bonus['sisa_cuti'] - $jml_ambil;
				$data_update_saldo = array(
					'tgl_ambil_terakhir' => $tgl_dokumen,
					'saldo_awal'=> $cek_bonus['sisa_cuti'],
					'sisa_cuti' => $sisa,
				);
				$this->hrd->set($data_update_saldo);
				$this->hrd->where('saldo_cuti_bonus_id', $id_saldo);
				$this->hrd->update('hrd_all.trn_saldo_cuti_bonus');

				$log_history = array();
				$count_tgl_tdk_masuk = count($this->input->post('tgl_tdk_masuk'));
				for($x = 0; $x < $count_tgl_tdk_masuk; $x++) {
					if($ambil_cuti == '1'){
						$sisa_cuti_bonus		= $bonus--;
					}else{
						$sisa_cuti_bonus		= $bonus-= 0.5;
					}
					$jml_awal = $cek_bonus['sisa_cuti'];
					$items = array(
						'cuti_bonus_hist_id'	=> $this->uuid->v4(),
						'biodata_id'			=> $this->input->post('biodata_id'),
						'tdk_masuk_d_id' 		=> $this->input->post('tdk_masuk_d_id')[$x],
						'keterangan' 			=> $this->input->post('keterangan_cuti')[$x],
						'tgl' 					=> $this->input->post('tgl_tdk_masuk')[$x],
						'tgl_mulai_berlaku' 	=> $tgl_mulai_berlaku,
						'tgl_akhir_berlaku' 	=> $tgl_akhir_berlaku,
						'saldo_awal' 			=> $this->input->post('saldo_bonus'),
						'ambil_cuti' 			=> $jml_ambil,
						'jml_awal' 				=> $jml_awal,
						'jml_akhir' 			=> $sisa_cuti_bonus,
						'pic_input'         	=> $this->input->post('biodata_id'),
						'tgl_input'    			=> date('Y-m-d H:i:s'),
					);
					array_push($log_history,$items);
					$this->hrd->insert('hrd_all.trn_cuti_bonus_hist',$items);

				}
			}else if($potong_cuti=='NORMATIF'){

				/* CEK DATA CUTI*/
					$cek_cuti 	= $this->getDataNormatif($biodata_id);
					if($ambil_cuti == '1'){
						$normatif 	= $cek_cuti['sisa_normatif'];
					}else{
						$normatif 	= $cek_cuti['sisa_normatif'];
					}
				/* END CEK DATA CUTI*/

				if($cek_cuti['sisa_normatif'] == null){
					$saldo = '0';
					$sisa = $saldo  - $jml_ambil;
					$data_update_saldo = array(
						'saldo_cuti_normatif_id' => $this->uuid->v4(),
						'biodata_id'	=> $biodata_id,
						'saldo_awal'	=> $sisa_normatif,
						'sisa_cuti' 	=> $sisa,
						'pic_input'		=> $biodata_id,
						'keterangan'	=> 'GENERATE SALDO CUTI MINUS',
						'tgl_input'			=> date('Y-m-d H:i:s'),
						'tgl_ambil_terakhir'=> date('Y-m-d'),
						'tgl_mulai_berlaku' => date('Y-m-d'),
						'tgl_akhir_berlaku'	=> date('Y') . '-12-31'
					);
					$this->hrd->insert('hrd_all.trn_saldo_cuti_normatif',$data_update_saldo);

				} else {
					$sisa = $cek_cuti['sisa_normatif'] - $jml_ambil;
					$data_update_saldo = array(
						'saldo_awal'	=> $cek_cuti['sisa_normatif'],
						'sisa_cuti' 	=> $sisa,
					);
					$this->hrd->set($data_update_saldo);
					$this->hrd->where('saldo_cuti_normatif_id', $id_saldo);
					$this->hrd->update('hrd_all.trn_saldo_cuti_normatif');
				}

				// tesx($jml_ambil);

				$log_history = array();
				$count_tgl_tdk_masuk = count($this->input->post('tgl_tdk_masuk'));
				$y = 1;
				$i = $cek_cuti['sisa_normatif'];
				for($x = 0; $x < $count_tgl_tdk_masuk; $x++) {
					if($ambil_cuti == '1'){
						$sisa_cuti_normatif		= $normatif--;
					}else{
						$sisa_cuti_normatif		= $normatif-= 0.5;
					}

					$jml_awal = $sisa_cuti_normatif + $ambil_cuti;
					$items = array(
						'cuti_normatif_hist_id'	=> $this->uuid->v4(),
						'biodata_id'			=> $this->input->post('biodata_id'),
						'tdk_masuk_d_id' 		=> $this->input->post('tdk_masuk_d_id')[$x],
						'keterangan' 			=> $this->input->post('keterangan_cuti')[$x],
						'tgl' 					=> $this->input->post('tgl_tdk_masuk')[$x],
						'tgl_mulai_berlaku' 	=> $cek_cuti['tgl_mulai_berlaku'],
						'tgl_akhir_berlaku' 	=> $cek_cuti['tgl_akhir_berlaku'],
						'saldo_awal' 			=> $cek_cuti['sisa_normatif'],
						'ambil_cuti' 			=> $ambil_cuti,
						'jml_awal' 				=> $jml_awal,
						'jml_akhir' 			=> $sisa_cuti_normatif,
						'pic_input'         	=> $this->input->post('biodata_id'),
						'tgl_input'    			=> date('Y-m-d H:i:s'),
					);
					array_push($log_history,$items);
					$this->hrd->insert('hrd_all.trn_cuti_normatif_hist', $items);
				}
				// tesx($log_history);

			}else if($potong_cuti=='TAMBAHAN'){

				$sct = $this->getSaldoTambahan($biodata_id);
				$tambahan_saldo = $this->getDataTambahan($biodata_id,$dates);
				if($ambil_cuti == '1'){
					$tambahan 		= $tambahan_saldo['sisa_cuti_tambahan'];
				}else{
					$tambahan 		= $tambahan_saldo['sisa_cuti_tambahan']+'0.5';
				}

				foreach($sct as $k=>$v){
					if($jml_ambil > 0) {
						if($jml_ambil <= $v['sisa_cuti']){
							$datas[$k]['hasil'] =  $v['sisa_cuti'] - $jml_ambil;
							$jml_ambil = '0';

							$datas_saldo[$k] = array(
								'saldo_cuti_tambahan_id'=> $v['saldo_cuti_tambahan_id'],
								'saldo_awal'            => $v['sisa_cuti'],
								'sisa_cuti'             => $datas[$k]['hasil'],
								'is_terpakai'			=> '1',
								'tgl_ambil_terakhir'	=> $tgl_dokumen,
								'keterangan'			=> $no_dokumen
							);
							array_push($datas_saldo[$k]);
							$id_saldo_tambahan = $v['saldo_cuti_tambahan_id'];
							$this->hrd->where('saldo_cuti_tambahan_id', $id_saldo_tambahan);
							$this->hrd->update('hrd_all.trn_saldo_cuti_tambahan',$datas_saldo[$k]);

						} else {
							$datas[$k]['hasil'] = $jml_ambil - $v['sisa_cuti'];
							$jml_ambil = $datas[$k]['hasil'];
							$hasil = '0';

							$datas_saldo[$k] = array(
								'saldo_cuti_tambahan_id'=> $v['saldo_cuti_tambahan_id'],
								'saldo_awal'            => $v['sisa_cuti'],
								'sisa_cuti'             => $hasil,
								'is_terpakai'			=> '1',
								'tgl_ambil_terakhir'	=> $tgl_dokumen,
								'keterangan'			=> $no_dokumen
							);
							array_push($datas_saldo[$k]);
							$id_saldo_tambahan = $v['saldo_cuti_tambahan_id'];
							$this->hrd->where('saldo_cuti_tambahan_id', $id_saldo_tambahan);
							$this->hrd->update('hrd_all.trn_saldo_cuti_tambahan',$datas_saldo[$k]);
						}
					}
				}
			}


			$log_absen = array();
			$count_absen =  count($this->input->post('tgl_tdk_masuk'));
			/*---- Looping Hari-Tanggal / Jml Ambil ----*/

			for($x = 0; $x < $count_absen; $x++) {

				#cek saldo cuti
				if($potong_cuti == 'NORMATIF'){
					if($ambil_cuti == '1'){
						$sisa_cuti		= $cek_cuti['sisa_normatif']--;
					}else{
						$sisa_cuti		= $cek_cuti['sisa_normatif']-= 0.5;
					}
				}else if($potong_cuti == 'BONUS'){
					// $saldo_cuti 	= $cek_bonus['sisa_cuti'];
					if($ambil_cuti == '1'){
						$sisa_cuti		= $cek_bonus['sisa_cuti']--;
					}else{
						$sisa_cuti		= $cek_bonus['sisa_cuti']-= 0.5;
					}
				}else if($potong_cuti == 'TAMBAHAN'){
					// $saldo_cuti 	= $tambahan_saldo['sisa_cuti_tambahan'];
					if($ambil_cuti == '1'){
						$sisa_cuti		= $tambahan_saldo['sisa_cuti_tambahan']--;
					}else{
						$sisa_cuti		= $tambahan_saldo['sisa_cuti_tambahan']-= '0.5';
					}
				}

				#status cuti
				if($ambil_cuti <= $sisa_cuti || '0' <= '0.0'){
					$id_status  = $this->input->post('status_absensi_id');
					// $id_status  = '000000000020';
					$cek_status = $this->getStatusAbsen($id_status);
					$kd_status 	= $cek_status['kode_status_absensi'];
					$ket_absen 	= $cek_status['ket_status_absensi'];
				}else{
					if($sisa_cuti == '0.5'){
						$id_status  = 'CS';
						$cek_status = $this->getKetAbsen($id_status);
						$kd_status 	= $cek_status['kode_status_absensi'];
						$ket_absen 	= $cek_status['ket_status_absensi'];
					}else{
						$id_status  = 'CG';
						$cek_status = $this->getKetAbsen($id_status);
						$kd_status 	= $cek_status['kode_status_absensi'];
						$ket_absen 	= $cek_status['ket_status_absensi'];
					}

				}

				#get tgl cuti untuk cek absensi
				$tgl_absen = $this->input->post('tgl_tdk_masuk')[$x];
				$cek_absen = $this->getDataAbsensi($biodata_id,$tgl_absen);
				#save data absensi
				if($tgl_absen == $cek_absen['tgl_absensi']){
					$data_absensi = array(
						'gol_absensi_d_id'			=> $this->input->post('gol_absensi_d_id'),
						'no_trn_absen'  			=> $this->input->post('no_doc'),
						'no_reff'  					=> $this->input->post('no_doc'),
						'is_manual'  				=> '1',
						'status_absen'  			=> $kd_status,
						'keterangan'  				=> $kd_status,
						'keterangan2'  				=> $ket_absen,
					);
					array_push($log_absen,$data_absensi);
					$where = array('biodata_id' => $biodata_id,'tgl_absensi' => $tgl_absen );
					$this->hrd->where($where);
					$this->hrd->update('hrd_all.trn_absensi',$data_absensi);
				}else{

					$data_absensi = array(
						'biodata_id'				=> $this->input->post('biodata_id'),
						'gol_absensi_d_id'			=> $this->input->post('gol_absensi_d_id'),
						'no_trn_absen'  			=> $this->input->post('no_doc'),
						'no_reff'  					=> $this->input->post('no_doc'),
						'kode_store'  				=> $this->input->post('kode_store'),
						'hari'  					=> $this->input->post('posisi_hari')[$x],
						'jam_masuk'  				=> $this->input->post('jam_masuk'),
						'jam_keluar'  				=> $this->input->post('jam_keluar'),
						'jam_shift_masuk'  			=> $this->input->post('jam_masuk'),
						'jam_shift_keluar'  		=> $this->input->post('jam_keluar'),
						'status_absen'  			=> $kd_status,
						'keterangan'  				=> $kd_status,
						'keterangan2'  				=> $ket_absen,
						'is_manual'  				=> '1',
						'tgl_absensi'				=> $this->input->post('tgl_tdk_masuk')[$x],
						'pic_input'					=> $this->session->userdata('nama_login'),
						'wkt_input'					=> date('Y-m-d'),
					);
					array_push($log_absen,$data_absensi);
					$this->hrd->insert('hrd_all.trn_absensi', $data_absensi);
				}
			}

			$data_posting = array(
				'tdk_masuk_h_id'				=> $tdk_masuk_h_id,
				'app_'.$urutan_approval.''		=> $nip,
				'tgl_app_'.$urutan_approval.'' 	=> date('Y-m-d h:i:s'),
				'status' 						=> $urutan_approval,
				'status_dokumen' 				=> 'C'
			);
			$this->hrd->set($data_posting);
			$this->hrd->where('tdk_masuk_h_id', $tdk_masuk_h_id);
			$this->hrd->update('hrd_all.trn_posting');

			$data_dok = array(
				'tdk_masuk_h_id'=> $tdk_masuk_h_id,
				'is_posting'	=> '1',
				'pic_posting' 	=> $this->input->post('biodata_id'),
				'tgl_posting'	=> date('Y-m-d'),
			);
			$this->hrd->set($data_dok);
			$this->hrd->where('tdk_masuk_h_id', $tdk_masuk_h_id);
			$this->hrd->update('hrd_all.trn_tidak_masuk_h');

		$sno_doc        = $this->input->post('no_doc');
		return ($sno_doc) ? $sno_doc : false;
	}


	public function rejectData($biodataid)
	{
		$sql = "SELECT COUNT(*)jml FROM hrd_all.trn_posting a
			LEFT JOIN hrd_all.trn_tidak_masuk_h b
			ON a.tdk_masuk_h_id = b.tdk_masuk_h_id
			WHERE biodata_id = ?
			AND status_dokumen ='R' AND no_dok_tdk_masuk LIKE 'HRC%'
			AND YEAR(tgl_dok_tdk_masuk)=YEAR(NOW())";
		$query = $this->hrd->query($sql, array($biodataid));
		// die(nl2br($this->hrd->last_query()));
		return $query->row_array();
	}

	public function rejectApp($no_dok_h,$pic,$nip,$ket)
	{
		$sel_dok 			= $this->getHeaderData($no_dok_h);
		$urutan_approval 	= $sel_dok['urutan_approval'];
		$count				= $sel_dok['jml_app'];
		// die(json_encode($ket));
		if($urutan_approval==$count){
			$data_header = array(
				'is_batal'				=> 1,
				'tgl_batal'				=> date('Y-m-d'),
				'pic_batal'				=> $pic,
				'ket_batal'				=> $ket
			);
			// die(json_encode($data_header));
			$this->hrd->set($data_header);
			$this->hrd->where('tdk_masuk_h_id', $no_dok_h);
			$this->hrd->update('hrd_all.trn_tidak_masuk_h');
			$data_posting = array(
				'rej_2'				=> $nip,
				'tgl_rej_2' 		=> date('Y-m-d h:i:s'),
				'status' 			=> $urutan_approval,
				'status_dokumen' 	=> 'R',
				'rej_komentar_2' 	=> $ket,
			);
			// die(json_encode($data_posting));
			$this->hrd->set($data_posting);
			$this->hrd->where('tdk_masuk_h_id', $no_dok_h);
			$this->hrd->update('hrd_all.trn_posting');
		}else {
			$data_header = array(
				'is_batal'				=> 1,
				'tgl_batal'				=> date('Y-m-d'),
				'pic_batal'				=> $pic,
				'ket_batal'				=> $ket
			);
			// die(json_encode($data_header));
			$this->hrd->set($data_header);
			$this->hrd->where('tdk_masuk_h_id', $no_dok_h);
			$this->hrd->update('hrd_all.trn_tidak_masuk_h');
			$data_posting = array(
				'rej_1'				=> $nip,
				'tgl_rej_1' 		=> date('Y-m-d h:i:s'),
				'status' 			=> $urutan_approval,
				'status_dokumen' 	=> 'R',
				'rej_komentar_1' 	=> $ket,
			);
			// die(json_encode($data_posting));
			$this->hrd->set($data_posting);
			$this->hrd->where('tdk_masuk_h_id', $no_dok_h);
			$this->hrd->update('hrd_all.trn_posting');
		}

		return  $no_dok_h;
	}

	public function rejectDireksi($no_dok_h,$pic,$nip,$ket)
	{
		$sel_dok 			= $this->getHeaderData($no_dok_h);

		// die(json_encode($ket));

			$data_header = array(
				'is_batal'				=> 1,
				'tgl_batal'				=> date('Y-m-d'),
				'pic_batal'				=> $pic,
				'ket_batal'				=> $ket
			);
			// die(json_encode($data_header));
			$this->hrd->set($data_header);
			$this->hrd->where('tdk_masuk_h_id', $no_dok_h);
			$this->hrd->update('hrd_all.trn_tidak_masuk_h');
			$data_posting = array(
				'rej_2'				=> $nip,
				'tgl_rej_2' 		=> date('Y-m-d h:i:s'),
				'status' 			=> '2',
				'status_dokumen' 	=> 'R',
				'rej_komentar_2' 	=> $ket,
			);
			// die(json_encode($data_posting));
			$this->hrd->set($data_posting);
			$this->hrd->where('tdk_masuk_h_id', $no_dok_h);
			$this->hrd->update('hrd_all.trn_posting');


		return  $no_dok_h;
	}

	/* End Create & Approce Action */




	public function send_mail_create($data_header, $log_detail)
	{
        $this->load->config('email');
        $this->load->library('email');

		$nip 			= $this->session->userdata('nama_login');
		$get_biodata 	= $this->hrd->select('biodata_id')
							->get_where('hrd_all.mst_biodata',array('nip' => $nip))->row_array();
		$biodata_id		= $get_biodata['biodata_id'];
		$biodata 		= $this->Model_leave->get_email_pic($biodata_id );

		$urutan_app		= '1';

		$pic_app 			= $this->Model_leave->get_email_app($biodata_id, $urutan_app);

		$data = array(
						'judul' 		=> 'Cuti',
						'nama_user'		=> $this->session->userdata('nama_karyawan'),
						'nip'			=> $this->session->userdata('nama_login'),
						'header_data'	=> $data_header,
						'detail_data'	=> $log_detail,
						'email_from'	=> $this->config->item('smtp_user'),
						'email_to'		=> $pic_app['email'],
						'divisi'		=> $biodata['nama_dept'],
				);

        $subject = 'Pengajuan '.$data['judul'].' - '.$data_header['no_dok_tdk_masuk'].' - '.$data['nama_user'];
		$from 	= $this->config->item('smtp_user');
        $to 	= $pic_app['email'];
		// die(json_encode($data));

        $this->email->set_newline("\r\n");
        $this->email->from($from);
        $this->email->to($to);

        $this->email->subject($subject);
		$this->email->message($this->load->view('email/cuti',$data,true));
		$this->email->send();
		// 	if($this->email->send()){
		// 	echo "Mail Sent ok";
		// 	}else{
		// 	echo "Error";
		// 	}
        // echo json_encode($response);
    }

	public function send_mail_approve($tdk_masuk_h_id)
	{
        $this->load->config('email');
        $this->load->library('email');

		$header_data 		= $this->Model_cuti->getHeaderDataBC($tdk_masuk_h_id);
		$urutan_app 		= '2';
		$result['header'] 	= $header_data;

		// die(json_encode($header_data));

		$biodata_id 		= $header_data['biodata_id'];
		$biodata 			= $this->Model_leave->get_email_pic($biodata_id );

		$pic_app 			= $this->Model_leave->get_email_app($biodata_id, $urutan_app);

		$data = array(	'judul' 		=> 'Cuti',
						'nama_user'		=> $biodata['nama_lengkap'],
						'nip'			=> $biodata['nip'],
						'divisi'		=> $biodata['nama_dept'],
						'jml_app'		=> '2',
						'mailto'		=> $pic_app['email']
					);
					// die(json_encode($data));
		$detail_item = $this->Model_cuti->getDetailData($header_data['tdk_masuk_h_id']);

		foreach($detail_item as $k => $v) {
			$result['detail_item'][] = $v;
		}
		$data['header_data'] = $result;

		// die(json_encode($data));

        $subject 	= 'Pengajuan '.$data['judul'].' - '.$header_data['no_dok_tdk_masuk'].' - '.$data['nama_user'];
		$to			= $pic_app['email'];
		$from 		= $this->config->item('smtp_user');
        // $to = 'rizky.it@optiktunggal.com';

        $cc = array(
            // 'rizky.it@optiktunggal.com'
        );

        $this->email->set_newline("\r\n");
        $this->email->from($from);
        $this->email->to($to);

        $this->email->subject($subject);
		$this->email->message($this->load->view('email/cuti_approval',$data,true));
		$this->email->send();
    }
}




