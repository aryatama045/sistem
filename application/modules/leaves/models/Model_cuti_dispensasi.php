<?php

class Model_cuti_dispensasi extends CI_Model
{
	private $hrd;
	function __construct()
	{
		parent::__construct();
		$this->hrd = $this->load->database('hrd',TRUE);
		$this->hrdsave = $this->load->database('hrd_save',TRUE);
	}

	public function getDataNoDoc($docCode, $date)
	{
		$sno_doc = $docCode.$date;
		$hasil=$this->hrd->query("SELECT RIGHT(no_dok_cuti,3)+1 as gencode FROM hrd_all.trn_cuti_dispensasi_h
		WHERE no_dok_cuti LIKE '".$sno_doc."%' ORDER BY no_dok_cuti DESC LIMIT 1");
        $result = $hasil->row_array();
		// die(json_encode($result));
		if($result){
			$urut = $result['gencode'];
			for ($i=3; $i > strlen($result['gencode']) ; $i--) {
				$urut = "0".$urut;
			}
			return $sno_doc.$urut;
		}else{
			return $sno_doc."001";
        }
	}

	public function get_sub_cuti($id)
	{
		$nip = $this->session->userdata('nama_login');
		$sql = "SELECT
		CASE
		WHEN
			(
			SELECT jabatan_id  FROM hrd_all.mst_biodata a
			LEFT JOIN hrd_all.biodata_pekerjaan_d b ON a.biodata_id = b.biodata_id WHERE nip='$nip'
			) IN ('000000000006','000000000002 ')
			THEN (
				SELECT biaya FROM hrd_all.mst_rujukan_cuti WHERE jabatan_id=(SELECT jabatan_id  FROM hrd_all.mst_biodata a
				LEFT JOIN hrd_all.biodata_pekerjaan_d b ON a.biodata_id = b.biodata_id WHERE nip='$nip')
				AND jenis_cuti ='$id'
					)
			ELSE (SELECT biaya FROM hrd_all.mst_rujukan_cuti WHERE jabatan_id=0 AND jenis_cuti ='$id')
		END j2, jumlah_hari, jenis, jenis_cuti, absensi_id, jabatan_id, b.ket_status_absensi ket_absen
		FROM hrd_all.mst_rujukan_cuti a
		LEFT JOIN hrd_all.mst_status_absensi b ON a.jenis_cuti = b.kode_status_absensi
		WHERE jenis_cuti='$id'
		GROUP BY jenis_cuti";
		$query = $this->hrd->query($sql);
		// die($this->hrd->last_query());
        return $query;
    }

	public function selStatusCuti($id)
	{
		$sql = "SELECT * FROM hrd_all.mst_status_absensi
		WHERE kode_status_absensi = ?";
		$query = $this->hrd->query($sql, array($id));
		// die(nl2br($this->hrd->last_query()));
		return $query->row_array();
    }

	public function getStatusCuti(){
		$sql 	= "SELECT * FROM hrd_all.mst_status_absensi
		WHERE kode_status_absensi IN('CBT','CD','CDC','CIL','CM','CMK','CSN','CDB','CDA','CKG','CIG')
		ORDER BY ket_status_absensi ASC";
		$query 	= $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return 	$query->result_array();
	}

	public function getStatusAbsen($id){
		$sql 	= "SELECT kode_status_absensi FROM hrd_all.mst_status_absensi WHERE status_absensi_id= '".$id."'";
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
		$sql 	= 	"SELECT  IFNULL(cn.sisa_cuti,0) sisa_normatif,saldo_awal,saldo_tahunan,saldo_cuti_normatif_id,tgl_mulai_berlaku,tgl_akhir_berlaku FROM hrd_all.trn_saldo_cuti_normatif cn
					WHERE cn.biodata_id = '".$biodataid."' AND '".$dates."' >= DATE(tgl_mulai_berlaku) AND '".$dates."' <= DATE(tgl_akhir_berlaku)";
		$query 	= $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return 	$query->row_array();
	}

	public function getDataBonus($biodataid,$dates){
		$sql 	= "SELECT biodata_id,SUM(sisa_cuti) sisa_cuti,saldo_cuti_bonus_id,urut_bonus,saldo_awal,saldo_bonus, tgl_mulai_berlaku,tgl_akhir_berlaku FROM hrd_all.trn_saldo_cuti_bonus 
					WHERE biodata_id = '".$biodataid."' AND '".$dates."' >= DATE(tgl_mulai_berlaku) AND '".$dates."' <= DATE(tgl_akhir_berlaku) GROUP BY biodata_id";
		$query 	= $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return 	$query->row_array();
	}

	public function getDataTambahan($biodataid,$dates){
		$sql 	= "SELECT  ct.biodata_id,ct.saldo_cuti_tambahan_id,ct.saldo_awal, IFNULL(SUM(ct.sisa_cuti),0) sisa_cuti_tambahan, ct.tgl_mulai_berlaku, ct.tgl_akhir_berlaku 
					FROM hrd_all.trn_saldo_cuti_tambahan ct WHERE ct.biodata_id = '".$biodataid."' AND ct.is_batal <> 1 AND ct.sisa_cuti > 0 
					AND '".$dates."' >= DATE(tgl_mulai_berlaku) AND '".$dates."' <= DATE(tgl_akhir_berlaku)
					GROUP BY biodata_id";
		$query 	= $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return 	$query->row_array();
	}

	public function getKodeStore($biodataid)
	{
		$sql = "SELECT kd_store FROM hrd_all.biodata_pekerjaan_d bp WHERE bp.biodata_id = '".$biodataid."' ";
		$query 	= $this->hrd->query($sql);
		// die($this->hrd->last_query());
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
		$this->hrd->where('t0.biodata_id', $no);
		// $this->hrd->like('t0.no_dok_cuti','HRCD');
		if($search_no != "") $this->hrd->like('t0.biodata_id',$search_no);

		$this->hrd->select('t0.cuti_dispensasi_h_id, t0.biodata_id, t0.no_dok_cuti, t0.is_posting, 
		CASE WHEN (status_dokumen)="R" THEN "DITOLAK"
		WHEN (status_dokumen)="O" THEN "OPEN"
		WHEN (status_dokumen)="P" THEN "SEDANG PROSES"
		ELSE "APPROVED"
		END posting,
		DATE_FORMAT(t0.tgl_dok_cuti, "%d-%m-%Y") tgl_dok,
		CONCAT_WS(" | ", t1.kode_status_absensi, t1.ket_status_absensi) STATUS, CONCAT_WS(" | ", t2.nip, t2.nama_lengkap) nama_pic, 
		t2.nip, t0.keterangan, t0.tgl_input,t3.*');
		$this->hrd->from('hrd_all.trn_cuti_dispensasi_h t0');
		$this->hrd->join('hrd_all.mst_status_absensi t1', 't0.status_absensi_id = t1.status_absensi_id', 'left');
		$this->hrd->join('hrd_all.mst_biodata t2', 't0.biodata_id = t2.biodata_id', 'left');
		$this->hrd->join('hrd_all.trn_posting t3', 't0.cuti_dispensasi_h_id = t3.tdk_masuk_h_id', 'left');

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
		$this->hrd->where('t0.biodata_id', $no);
		// $this->hrd->like('t0.no_dok_cuti','HRCD');
		if($search_no != "") $this->hrd->like('t0.biodata_id',$search_no);

		$this->hrd->select('t0.cuti_dispensasi_h_id, t0.biodata_id, t0.no_dok_cuti, t0.is_posting, 
		CASE WHEN (status_dokumen)="R" THEN "DITOLAK"
		WHEN (status_dokumen)="O" THEN "OPEN"
		WHEN (status_dokumen)="P" THEN "SEDANG PROSES"
		ELSE "APPROVED"
		END posting,
		DATE_FORMAT(t0.tgl_dok_cuti, "%d-%m-%Y") tgl_dok,  
		CONCAT_WS(" | ", t1.kode_status_absensi, t1.ket_status_absensi) STATUS, CONCAT_WS(" | ", t2.nip, t2.nama_lengkap) nama_pic, 
		t2.nip, t0.keterangan, t0.tgl_input,t3.*');
		$this->hrd->from('hrd_all.trn_cuti_dispensasi_h t0');
		$this->hrd->join('hrd_all.mst_status_absensi t1', 't0.status_absensi_id = t1.status_absensi_id', 'left');
		$this->hrd->join('hrd_all.mst_biodata t2', 't0.biodata_id = t2.biodata_id', 'left');
		$this->hrd->join('hrd_all.trn_posting t3', 't0.cuti_dispensasi_h_id = t3.tdk_masuk_h_id', 'left');

		
		$jum=$this->hrd->get();
		// die(nl2br($this->hrd->last_query()));
		return $jum->num_rows();
	}

	public function getHeaderDataBC($no_dok_h = null)
	{
		if($no_dok_h) {
			$sql = "SELECT a.*, b.*,r.tgl_reject tgl_reject_hrd,r.alasan_reject, s.nama_lengkap pic_reject,t.nip, t.nama_lengkap
			FROM hrd_all.trn_cuti_dispensasi_h a
			LEFT JOIN hrd_all.trn_dokumen_ijin b ON a.no_dok_cuti  = b.no_dok
			LEFT JOIN hrd_all.trn_app_3rd r ON a.cuti_dispensasi_h_id = r.no_dok
			LEFT JOIN hrd_all.mst_biodata s ON r.pic_reject = s.nip
			LEFT JOIN hrd_all.mst_biodata t ON a.biodata_id = t.biodata_id
			WHERE cuti_dispensasi_h_id = ?";
			$query = $this->hrd->query($sql, array($no_dok_h));
			// die(nl2br($this->hrd->last_query()));
			return $query->row_array();
		}
		$sql = "SELECT * FROM hrd_all.trn_cuti_dispensasi_h ORDER BY cuti_dispensasi_h_id DESC";
		$query = $this->hrd->query($sql);
		return $query->result_array();
	}

	public function getHeaderData($no_dok_h = null)
	{
		if($no_dok_h) {
			$nip = $this->session->userdata('nama_login');
			$sql = "SELECT a.* ,k.*,jml_app
				, d.nip,d.nama_lengkap
				, e.nip, e.nama_lengkap
				, f.*
				, g.status
				, h.nama,
				CASE WHEN g.status = 0 THEN 'OPEN' 
				WHEN g.status = 1 THEN 'PENDING'
				END st
				FROM hrd_web_master.mst_user_approval_detail a
				LEFT JOIN hrd_web_master.mst_karyawan_01 b ON a.karyawan_id = b.karyawan_id
				LEFT JOIN hrd_web_master.mst_karyawan_01 c ON a.approved_user = c.karyawan_id
				LEFT JOIN hrd_all.mst_biodata d ON b.biodata = d.biodata_id
				LEFT JOIN hrd_all.mst_biodata e ON c.biodata = e.biodata_id
				LEFT JOIN hrd_all.trn_cuti_dispensasi_h f ON e.biodata_id = f.biodata_id
				LEFT JOIN hrd_all.trn_posting g ON f.cuti_dispensasi_h_id = g.tdk_masuk_h_id
				LEFT JOIN hrd_all.trn_dokumen_ijin k ON f.no_dok_cuti  = k.no_dok
				LEFT JOIN hrd_web_master.mst_departemen h ON a.dept_user = h.hash
				LEFT JOIN
					(SELECT  a.approved_user, COUNT(a.karyawan_id)jml_app FROM hrd_web_master.mst_user_approval_detail a
						LEFT JOIN hrd_web_master.mst_karyawan_01 b ON a.karyawan_id=b.karyawan_id
						GROUP BY a.approved_user) i ON a.approved_user=i.approved_user
				WHERE f.cuti_dispensasi_h_id = ?
				AND d.nip='$nip' AND YEAR(tgl_dok_cuti)>='2021'
				AND is_posting=0 AND is_batal=0 
				AND urutan_approval = g.status+1
				ORDER BY e.nip, f.tgl_dok_cuti;";
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
		WHEN DATE_FORMAT(DATE(tgl_cuti),"%w") <> 0 THEN DATE_FORMAT(DATE(tgl_cuti),"%w")
		ELSE "7"
		END hr
		FROM hrd_all.trn_cuti_dispensasi_d
		WHERE cuti_dispensasi_h_id = ? ORDER BY tgl_cuti ASC';
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
			WHEN (is_posting = 0) AND IFNULL(tgl_batal,"")<>"" THEN "DITOLAK" ELSE "BELUM" END posting,
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

	public function getApprovalData1($nip , $search_no = "", $length = "", $start = "", $column = "", $order = "")
	{
		// $this->hrd->like('e.nip',$search_no);
		// $this->hrd->where('t0.tgl_dok_tdk_masuk >"2021-09-20"');
		$this->hrd->select("a.*
		, d.nip,d.nama_lengkap
		, e.nip, e.nama_lengkap as pic
		, f.jenis_cuti
		, f.no_dok_cuti, f.tgl_dok_cuti,f.cuti_dispensasi_h_id
		, g.status
		, h.nama,
		CASE WHEN g.status = 0 THEN 'OPEN'
		WHEN g.status = 1 THEN 'PENDING'
		END st");
		$this->hrd->from('hrd_web_master.mst_user_approval_detail a');
		$this->hrd->join('hrd_web_master.mst_karyawan_01 b', 'a.karyawan_id = b.karyawan_id', 'left');
		$this->hrd->join('hrd_web_master.mst_karyawan_01 c', 'a.approved_user = c.karyawan_id', 'left');
		$this->hrd->join('hrd_all.mst_biodata d', 'b.biodata = d.biodata_id', 'left');
		$this->hrd->join('hrd_all.mst_biodata e', 'c.biodata = e.biodata_id', 'left');
		$this->hrd->join('hrd_all.trn_cuti_dispensasi_h f', 'e.biodata_id = f.biodata_id', 'left');
		$this->hrd->join('hrd_all.trn_posting g', 'f.cuti_dispensasi_h_id = g.tdk_masuk_h_id', 'left');
		$this->hrd->join('hrd_web_master.mst_departemen h', 'a.dept_user = h.hash', 'left');
		$this->hrd->where('d.nip', $nip);
		$this->hrd->where('is_posting=0 AND is_batal=0 AND  YEAR(tgl_dok_cuti) >= 2021');
		$this->hrd->where('urutan_approval=','g.status+1',FALSE);
		$this->hrd->order_by('tgl_dok_cuti','DESC');

		if($column == 0){
			$this->hrd->order_by('e.nip', $order);
		}
		$this->hrd->limit($length,$start);
		$query=$this->hrd->get();
		die(nl2br($this->hrd->last_query()));
		// die(json_encode($query));
		return $query->result_array();
	}

	public function getApprovalData2($nip , $search_no = "")
	{
		$this->hrd->select("a.*
		, d.nip,d.nama_lengkap
		, e.nip, e.nama_lengkap as pic
		, f.no_dok_cuti, f.tgl_dok_cuti,f.cuti_dispensasi_h_id
		, g.status
		, h.nama,
		CASE WHEN g.status = 0 THEN 'OPEN'
		WHEN g.status = 1 THEN 'PENDING'
		END st");
		$this->hrd->from('hrd_web_master.mst_user_approval_detail a');
		$this->hrd->join('hrd_web_master.mst_karyawan_01 b', 'a.karyawan_id = b.karyawan_id', 'left');
		$this->hrd->join('hrd_web_master.mst_karyawan_01 c', 'a.approved_user = c.karyawan_id', 'left');
		$this->hrd->join('hrd_all.mst_biodata d', 'b.biodata = d.biodata_id', 'left');
		$this->hrd->join('hrd_all.mst_biodata e', 'c.biodata = e.biodata_id', 'left');
		$this->hrd->join('hrd_all.trn_cuti_dispensasi_h f', 'e.biodata_id = f.biodata_id', 'left');
		$this->hrd->join('hrd_all.trn_posting g', 'f.cuti_dispensasi_h_id = g.tdk_masuk_h_id', 'left');
		$this->hrd->join('hrd_web_master.mst_departemen h', 'a.dept_user = h.hash', 'left');
		$this->hrd->where('d.nip', $nip);
		$this->hrd->where('is_posting=0 AND is_batal=0 AND  YEAR(tgl_dok_cuti) >= 2021');
		$this->hrd->where('urutan_approval=','g.status+1',FALSE);
		$this->hrd->order_by('tgl_dok_cuti','DESC');
		$jum=$this->hrd->get();
		return $jum->num_rows();
	}

	public function getCutiDispensasi($nip,$search_no = "",$search_nama = "", $length = "", $start = "", $column = "", $order = "")
	{

		$where_search_nama = "";
		if($search_nama !== ""){
			$where_search_nama = "AND nama_lengkap LIKE '%".$search_nama."%'";
		}
		$sql = "SELECT no_dok_cuti,tgl_dok_cuti,c.nip,nama_lengkap,e.nama_dept,b.keterangan,date(tgl_app_1) tgl_app_1,
				CASE WHEN status_dokumen = 'C' THEN 'CLOSED'
				WHEN status_dokumen ='P' THEN 'PROCESS'
				WHEN status_dokumen ='R' THEN 'REJECT'
				ELSE 'OPEN'
				END posting
				FROM(
					SELECT tdk_masuk_h_id,tgl_app_1, status_dokumen,'' kom FROM hrd_all.trn_posting
					WHERE app_1 = '$nip'
					UNION ALL
					SELECT tdk_masuk_h_id,tgl_app_2, status_dokumen,'' kom FROM hrd_all.trn_posting
					WHERE app_2 = '$nip'
					UNION ALL
					SELECT tdk_masuk_h_id,tgl_rej_1, status_dokumen, rej_komentar_1 FROM hrd_all.trn_posting
					WHERE rej_1 = '$nip'
					UNION ALL
					SELECT tdk_masuk_h_id,tgl_rej_2, status_dokumen, rej_komentar_2 FROM hrd_all.trn_posting
					WHERE rej_2 = '$nip')a
				LEFT JOIN hrd_all.trn_cuti_dispensasi_h b ON a.tdk_masuk_h_id = b.cuti_dispensasi_h_id
				LEFT JOIN hrd_all.mst_biodata c ON b.biodata_id = c.biodata_id
				LEFT JOIN hrd_all.biodata_pekerjaan_d d ON c.biodata_id = d.biodata_id
				LEFT JOIN hrd_all.mst_dept e ON d.dept_id = e.dept_id
				WHERE no_dok_cuti LIKE 'HRCD%' $where_search_nama
				ORDER BY tgl_dok_cuti DESC
				LIMIT $start,$length";
		$query = $this->hrd->query($sql);
		// die(nl2br($this->hrd->last_query()));
		return $query->result_array();
	}

	public function getCountCutiDispensasi($nip,$search_no="", $search_nama="")
	{
		$where_search_nama = "";
		if($search_nama !== ""){
			$where_search_nama = "AND nama_lengkap LIKE '%".$search_nama."%'";
		}
		$sql = "SELECT no_dok_cuti,tgl_dok_cuti,c.nip,nama_lengkap,e.nama_dept,b.keterangan,date(tgl_app_1) tgl_app_1,
				CASE WHEN status_dokumen = 'C' THEN 'CLOSED'
				WHEN status_dokumen ='P' THEN 'PROCESS'
				WHEN status_dokumen ='R' THEN 'REJECT'
				ELSE 'OPEN'
				END posting
				FROM(
					SELECT tdk_masuk_h_id,tgl_app_1, status_dokumen,'' kom FROM hrd_all.trn_posting
					WHERE app_1 = '$nip'
					UNION ALL
					SELECT tdk_masuk_h_id,tgl_app_2, status_dokumen,'' kom FROM hrd_all.trn_posting
					WHERE app_2 = '$nip'
					UNION ALL
					SELECT tdk_masuk_h_id,tgl_rej_1, status_dokumen, rej_komentar_1 FROM hrd_all.trn_posting
					WHERE rej_1 = '$nip'
					UNION ALL
					SELECT tdk_masuk_h_id,tgl_rej_2, status_dokumen, rej_komentar_2 FROM hrd_all.trn_posting
					WHERE rej_2 = '$nip')a
				LEFT JOIN hrd_all.trn_cuti_dispensasi_h b ON a.tdk_masuk_h_id = b.cuti_dispensasi_h_id
				LEFT JOIN hrd_all.mst_biodata c ON b.biodata_id = c.biodata_id
				LEFT JOIN hrd_all.biodata_pekerjaan_d d ON c.biodata_id = d.biodata_id
				LEFT JOIN hrd_all.mst_dept e ON d.dept_id = e.dept_id
				WHERE no_dok_cuti LIKE 'HRCD%' $where_search_nama
				ORDER BY tgl_dok_cuti DESC";
		$query = $this->hrd->query($sql);
		// die(nl2br($this->hrd->last_query()));
		return $query->num_rows();
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

	public function getDataPicDewaHrd()
	{
		$nip 				= $this->session->userdata('nama_login');
		$sql 	= "SELECT * FROM hrd_all.trn_pic_dewa WHERE nip=$nip AND LEVEL IN ('2','3')";
		$query = $this->hrd->query($sql);
		return $query->row_array();
	}

	public function getHariLibur()
	{
		$sql = "SELECT tgl_libur as dates FROM hrd_all.mst_hari_libur WHERE aktif =1 ";
		$query 	= $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return 	$query->result_array();
	}

	public function getApp3rd($no_dok)
	{

		$sql 	= "SELECT a.*, b.nama_lengkap nama
					FROM hrd_all.trn_app_3rd a
					LEFT JOIN hrd_all.mst_biodata b ON a.pic_koreksi = b.nip
					WHERE a.no_dok = '$no_dok'";
		$query 	= $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return 	$query->row_array();
	}

	/* Create & Approve Action */

		public function create()
		{
			$docCode	= 'HRCD';
			$date		= date('ym');
			$cuti_id	= $this->input->post('status_absensi_id');
			$selCuti 	= $this->selStatusCuti($cuti_id);
			$jeniscutis	= $selCuti['ket_status_absensi'];
			$j_cuti	= substr($jeniscutis,5);

			// die(json_encode($j_cuti));
			if($this->input->post('jenis_tunjangan')=='1'){
				$tj_sukacita = $this->input->post('biaya');
				$tj_dukacita = '0';
			}else{
				$tj_dukacita = $this->input->post('biaya');
				$tj_sukacita = '0';
			}

			$data_header = array(
				'cuti_dispensasi_h_id'		=> $this->uuid->v4(),
				'biodata_id'				=> $this->input->post('biodata_id'),
				'status_absensi_id' 		=> $this->input->post('status_absensi_id'),
				'kode_status_absensi' 		=> $this->input->post('kode_status_absensi'),
				'jenis_cuti' 				=> $j_cuti,
				'no_dok_cuti'  				=> $this->getDataNoDoc($docCode, $date),
				'tgl_dok_cuti'				=> date('Y-m-d'),
				'tgl_cuti_dokter'			=> $this->input->post('tgl_mulai_cuti'),
				'tgl_mulai_cuti'			=> $this->input->post('tgl_mulai_cuti'),
				'tgl_klaim'					=> $this->input->post('tgl_klaim'),
				'tj_sukacita'				=> $tj_sukacita,
				'tj_dukacita'				=> $tj_dukacita,
				'is_posting'	  			=> '0',
				'no_ref'	  				=> $this->getDataNoDoc($docCode, $date),
				'keterangan'	  			=> $this->input->post('keterangan'),
				'pic_input'    				=> $this->input->post('biodata_id'),
				'tgl_input'    				=> date('Y-m-d H:i:s'),
			);
			$insert = $this->hrd->insert('hrd_all.trn_cuti_dispensasi_h', $data_header);

			$sno_doc        = $data_header['no_dok_cuti'];

			/* Manage Image */
				$config['upload_path']          = FCPATH . 'upload/ijin/';
				$config['allowed_types'] 		= 'gif|jpg|jpeg|png';
				$config['encrypt_name'] 		= TRUE;
				// $this->load->library('upload',$config);
				$this->upload->initialize($config);

				$this->upload->do_upload('file_1');
				$post_img1 = $this->upload->data();
					$config['image_library'] = 'gd2';
					$config['source_image'] = FCPATH . 'upload/ijin/'.$post_img1["file_name"];
					$config['maintain_ratio'] = TRUE;
					$config['quality']	= '100%';
					// $config['width']	= 800;
					// $config['height']	= 650;

					$config['new_image'] = FCPATH . 'upload/ijin/'.$post_img1["file_name"];
					$this->load->library('image_lib',$config);
					$this->image_lib->resize();
					$post_image1 = $post_img1["file_name"];
					unset($config);
					$this->load->library('image_lib');
					$this->image_lib->clear();

				$this->upload->do_upload('file_2');
				$post_img2 = $this->upload->data();
					$config2['image_library'] = 'gd2';
					$config2['source_image'] = FCPATH . 'upload/ijin/'.$post_img2["file_name"];
					$config2['maintain_ratio'] = TRUE;
					$config2['quality']	= '100%';
					// $config2['width']	= 800;
					// $config2['height']	= 650;
					$config2['new_image'] = FCPATH . 'upload/ijin/'.$post_img2["file_name"];
					$this->load->library('image_lib');
					$this->image_lib->initialize($config2);
					$this->image_lib->resize();
					$post_image2 = $post_img2["file_name"];
					unset($config2);
					$this->load->library('image_lib');
					$this->image_lib->clear();


				$this->upload->do_upload('file_3');
				$post_img3 = $this->upload->data();
					$config3['image_library'] = 'gd2';
					$config3['source_image'] = FCPATH . 'upload/ijin/'.$post_img3["file_name"];
					$config3['maintain_ratio'] = TRUE;
					$config3['quality']	= '100%';
					// $config3['width']	= 800;
					// $config3['height']	= 650;
					$config3['new_image'] = FCPATH . 'upload/ijin/'.$post_img3["file_name"];
					$this->load->library('image_lib');
					$this->image_lib->initialize($config3);
					$this->image_lib->resize();
					$post_image3 = $post_img3["file_name"];
					unset($config3);
					$this->load->library('image_lib');
					$this->image_lib->clear();

				$data_dokumen = array(
						'no_dok' => $data_header['no_dok_cuti'],
						'file_1' => $post_image1,
						'file_2' => $post_image2,
						'file_3' => $post_image3,
				);
				$this->hrd->insert('hrd_all.trn_dokumen_ijin', $data_dokumen);

        	/* End Manage Image */


			$log_detail = array();
			$count_cuti = $this->input->post('jum_cuti');
			//Looping Hari & Tanggal
			$count_cutis=0;
			$count_cutis2=0;
			for($x = 0; $x < $count_cuti; $x++) {

				$uuid_d = $this->uuid->v4($x);
				$date = $this->input->post('tgl_mulai_cuti');
				$namaharis = format_indo(date('D', strtotime($date.'+'.$count_cutis++.'Days')));
				$tomorrows = date('Y-m-d',strtotime($date.'+'.$count_cutis2++.'Days'));

				$items = array(
					'cuti_dispensasi_d_id' 	=> $uuid_d,
					'cuti_dispensasi_h_id'	=> $data_header['cuti_dispensasi_h_id'],
					'tgl_cuti'				=> $tomorrows,
					'nama_hari' 	   		=> $namaharis,
					'nilai_hari'			=> '1',
					'keterangan'			=> $data_header['jenis_cuti'],
					'pic_input'				=> $data_header['pic_input'],
					'tgl_input'    			=> date('Y-m-d H:i:s'),
				);
				array_push($log_detail,$items);
				$this->hrd->insert('hrd_all.trn_cuti_dispensasi_d', $items);

			}

			// tesx($post_image1,$post_image2,$post_image3,$data_header, $log_detail );

			$data_posting = array(
				'tdk_masuk_h_id'	=> $data_header['cuti_dispensasi_h_id'],
				'status' 			=> '0',
				'status_dokumen' 	=> 'O'
			);
			// die(json_encode($data_posting));
			$this->hrd->set($data_posting);
			$this->hrd->insert('hrd_all.trn_posting');


			return ($sno_doc) ? $sno_doc : false;
		}



		public function ApproveAction()
		{
			$biodata_id 		=$this->input->post('biodata_id');
			$cuti_dispensasi_id =$this->input->post('cuti_dispensasi_h_id');
			// $jml_ambil 			=$this->input->post('jml_ambil');
			$tgl_cuti 			= $this->input->post('tgl_mulai_cuti');
			$nip 				= $this->session->userdata('nama_login');

			$getcount				= $this->count_nip($biodata_id);
			if($getcount['nips'] 	!= NULL){
				$count				= $getcount['nips'];
			}else{ $count= '0';}

			$urutan_cek 		= $this->getHeaderData($cuti_dispensasi_id);

			$urutan_approval 	= $urutan_cek['urutan_approval'];

			// tesx($urutan_approval, $count);

			if($urutan_approval==$count){


				$data_dok = array(
					'cuti_dispensasi_h_id'	=> $cuti_dispensasi_id,
					'is_posting'			=> '1',
					'pic_posting' 			=> $this->input->post('biodata_id'),
					'tgl_posting'			=> date('Y-m-d'),
				);
				// die(json_encode($data_dok));
				$this->hrd->set($data_dok);
				$this->hrd->where('cuti_dispensasi_h_id', $cuti_dispensasi_id);
				$this->hrd->update('hrd_all.trn_cuti_dispensasi_h');

				$data_posting = array(
					'tdk_masuk_h_id'	=> $cuti_dispensasi_id,
					'app_2'				=> $nip,
					'tgl_app_2' 		=> date('Y-m-d h:i:s'),
					'status' 			=> $urutan_approval,
					'status_dokumen' 	=> 'C'
				);
				// die(json_encode($data_posting));
				$this->hrd->set($data_posting);
				$this->hrd->where('tdk_masuk_h_id', $cuti_dispensasi_id);
				$this->hrd->update('hrd_all.trn_posting');
			}else{
				$data_dok = array(
					'cuti_dispensasi_h_id'	=> $cuti_dispensasi_id,
					'is_posting'			=> '0',
					'pic_posting' 			=> $this->input->post('biodata_id'),
					'tgl_posting'			=> date('Y-m-d'),
				);
				// die(json_encode($data_dok));
				$this->hrd->set($data_dok);
				$this->hrd->where('cuti_dispensasi_h_id', $cuti_dispensasi_id);
				$this->hrd->update('hrd_all.trn_cuti_dispensasi_h');

				$data_posting = array(
					'tdk_masuk_h_id'	=> $cuti_dispensasi_id,
					'app_1'				=> $nip,
					'tgl_app_1' 		=> date('Y-m-d'),
					'status' 			=> $urutan_approval,
					'status_dokumen' 	=> 'P'
				);
				// die(json_encode($data_posting));
				$this->hrd->set($data_posting);
				$this->hrd->where('tdk_masuk_h_id', $cuti_dispensasi_id);
				$this->hrd->update('hrd_all.trn_posting');
			}

			$sno_doc        = $this->input->post('no_doc');
			return ($sno_doc) ? $sno_doc : false;
		}



		public function VerifikasiAction()
		{
			$biodata_id 		=$this->input->post('biodata_id');
			$cuti_dispensasi_id =$this->input->post('cuti_dispensasi_h_id');
			// $jml_ambil 			=$this->input->post('jml_ambil');
			$tgl_cuti 			= $this->input->post('tgl_mulai_cuti');
			$nip 				= $this->session->userdata('nama_login');
			$count 				= $this->input->post('jml_app');
			$urutan_approval 	= $this->input->post('urutan_approval');

			$nip 				= $this->session->userdata('nama_login');
			$sql_pic 			= $this->getDataPicDewaHrd();


			if($nip==$sql_pic['nip']){
				// tesx($nip, $sql_pic['nip'], $cuti_dispensasi_id);

				$log_absen = array();
				$count_absen =  count($this->input->post('tgl_cuti'));
				//Looping Hari & Tanggal
				for($x = 0; $x < $count_absen; $x++) {
					$date = $this->input->post('tgl_cuti')[$x];
					$namaharis = format_indo(date('D', strtotime($date)));
					$data_absensi = array(
						'biodata_id'				=> $this->input->post('biodata_id'),
						'gol_absensi_d_id'			=> $this->input->post('gol_absensi_d_id'),
						'no_trn_absen'  			=> $this->input->post('no_doc'),
						'no_reff'  					=> $this->input->post('no_doc'),
						'kode_store'  				=> $this->input->post('kode_store'),
						'hari'  					=> $namaharis,
						'jam_masuk'  				=> $this->input->post('jam_masuk'),
						'jam_keluar'  				=> $this->input->post('jam_keluar'),
						'jam_shift_masuk'  			=> $this->input->post('jam_masuk'),
						'jam_shift_keluar'  		=> $this->input->post('jam_keluar'),
						'status_absen'  			=> $this->input->post('kode_status_absensi'),
						'keterangan'  				=> $this->input->post('kode_status_absensi'),
						'keterangan2'  				=> $this->input->post('status_cuti'),
						'is_manual'  				=> '1',
						'tgl_absensi'				=> $this->input->post('tgl_cuti')[$x],
						'pic_input'					=> $this->session->userdata('nama_login'),
						'wkt_input'					=> date('Y-m-d')
					);
					array_push($log_absen,$data_absensi);
					$this->hrd->insert('hrd_all.trn_absensi', $data_absensi);
				}

				// Edit detail cuti
				$cuti_dispensasi_id 	= $this->input->post('cuti_dispensasi_h_id');
				$log_detail = array();
				$count_detail =  count($this->input->post('tgl_cuti'));
				//Looping Hari & Tanggal
				for($x = 0; $x < $count_detail; $x++) {
					$date = $this->input->post('tgl_cuti')[$x];
					$namaharis = format_indo(date('D', strtotime($date)));
					$data_detail = array(
						'tgl_cuti'					=> $date,
						'nama_hari'					=> $namaharis,
						'pic_edit'					=> $this->session->userdata('nama_login'),
						'tgl_edit'					=> date('Y-m-d H:i:s')
					);
					array_push($log_detail,$data_detail);
					$this->hrd->set($data_detail);
					$this->hrd->where('cuti_dispensasi_h_id', $cuti_dispensasi_id);
					$this->hrd->update('hrd_all.trn_cuti_dispensasi_d');
				}

				// tesx($log_detail);

				$data_dok2 = array(
					'cuti_dispensasi_h_id'	=> $cuti_dispensasi_id,
					'pic_input' 		=> $nip,
					'tgl_input'			=> date('Y-m-d'),
				);
				$this->hrd->set($data_dok2);
				$this->hrd->where('cuti_dispensasi_h_id', $cuti_dispensasi_id);
				$this->hrd->update('hrd_all.trn_cuti_dispensasi_h');

				$app3 = array(
					'no_dok'			=> $cuti_dispensasi_id,
					'pic_koreksi' 		=> $nip,
					'tgl_koreksi'		=> date('Y-m-d H:i:s'),
				);
				$this->hrd->set($app3);
				$this->hrd->insert('hrd_all.trn_app_3rd');


			}

			$sno_doc        = $this->input->post('no_doc');
			return ($sno_doc) ? $sno_doc : false;
		}

		public function VerifikasiReject()
		{
			$cuti_dispensasi_id =$this->input->post('cuti_dispensasi_h_id_r');
			$nip 				= $this->session->userdata('nama_login');
			$alasan 			= $this->input->post('alasan_reject');
			$count 				= $this->input->post('jml_app');
			$urutan_approval 	= $this->input->post('urutan_approval');

			$nip 				= $this->session->userdata('nama_login');
			$sql_pic 			= $this->getDataPicDewaHrd();

			// tesx($cuti_dispensasi_id, $alasan, $sql_pic);
			if($nip==$sql_pic['nip']){

				$data_dok2 = array(
					'cuti_dispensasi_h_id'	=> $cuti_dispensasi_id,
					'is_hrd'				=> 'Y',
					'pic_input' 			=> $nip,
					'tgl_input'				=> date('Y-m-d'),
				);
				$this->hrd->set($data_dok2);
				$this->hrd->where('cuti_dispensasi_h_id', $cuti_dispensasi_id);
				$this->hrd->update('hrd_all.trn_cuti_dispensasi_h');

				$posting = array(
					'status_dokumen'			=> 'R',
				);
				$this->hrd->set($posting);
				$this->hrd->where('tdk_masuk_h_id', $cuti_dispensasi_id );
				$this->hrd->update('hrd_all.trn_posting');

				$app3 = array(
					'no_dok'			=> $cuti_dispensasi_id,
					'pic_koreksi' 		=> $nip,
					'tgl_koreksi'		=> date('Y-m-d H:i:s'),
					'pic_reject'		=> $nip,
					'tgl_reject'		=> date('Y-m-d H:i:s'),
					'alasan_reject'		=> $this->input->post('alasan_reject')
				);
				$this->hrd->set($app3);
				$this->hrd->insert('hrd_all.trn_app_3rd');
			}

			$sno_doc        = $this->input->post('no_doc');
			return ($sno_doc) ? $sno_doc : false;
		}



		public function rejectApp($h_id,$pic,$nip,$ket)
		{
			$sel_dok 			= $this->getHeaderData($h_id);
			$urutan_approval 	= $sel_dok['urutan_approval'];
			$count				= $sel_dok['jml_app'];
			$nip = $this->session->userdata('nama_login');
			// die(json_encode($urutan_approval));
			if($urutan_approval==$count){
				$data_header = array(
					'is_batal'				=> '1',
					'tgl_batal'				=> date('Y-m-d'),
					'pic_batal'				=> $nip,
					'ket_batal'				=> $ket
				);
				// die(json_encode($data_header));
				$this->hrd->set($data_header);
				$this->hrd->where('tdk_masuk_h_id', $h_id);
				$this->hrd->update('hrd_all.trn_cuti_dispensasi_h');
				$data_posting = array(
					'rej_2'				=> $nip,
					'tgl_rej_2' 		=> date('Y-m-d'),
					'status' 			=> $urutan_approval,
					'status_dokumen' 	=> 'R',
					'rej_komentar_2' 	=> $ket,
				);
				// die(json_encode($data_posting));
				$this->hrd->set($data_posting);
				$this->hrd->where('tdk_masuk_h_id', $h_id);
				$this->hrd->update('hrd_all.trn_posting');
			}else {
				$data_header = array(
					'is_batal'				=> '1',
					'tgl_batal'				=> date('Y-m-d'),
					'pic_batal'				=> $nip,
					'ket_batal'				=> $ket
				);
				// die(json_encode($data_header));
				$this->hrd->set($data_header);
				$this->hrd->where('tdk_masuk_h_id', $h_id);
				$this->hrd->update('hrd_all.trn_cuti_dispensasi_h');

				$data_posting = array(
					'rej_1'				=> $nip,
					'tgl_rej_1' 		=> date('Y-m-d h:i:s'),
					'status' 			=> $urutan_approval,
					'status_dokumen' 	=> 'R',
					'rej_komentar_1' 	=> $ket
				);
				// die(json_encode($data_posting));
				$this->hrd->set($data_posting);
				$this->hrd->where('tdk_masuk_h_id', $h_id);
				$this->hrd->update('hrd_all.trn_posting');
			}

			return  $h_id;
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



	/* End Create & Approve Action */


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
						'judul' 		=> 'Cuti Dispensasi',
						'nama_user'		=> $this->session->userdata('nama_karyawan'),
						'nip'			=> $this->session->userdata('nama_login'),
						'header_data'	=> $data_header,
						'detail_data'	=> $log_detail,
						// 'email_from'	=> $this->config->item('smtp_user'),
						// 'email_to'		=> $pic_app['email'],
						'divisi'		=> $biodata['nama_dept'],
				);

        $subject = 'Pengajuan '.$data['judul'].' - '.$data['nama_user'];
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

		$header_data 		= $this->Model_cuti->getHeaderData($tdk_masuk_h_id);
		$urutan_app 		= '2';
		$result['header'] 	= $header_data;

		// die(json_encode($header_data));

		$biodata_id 		= $header_data['biodata_id'];
		$biodata 			= $this->Model_leave->get_email_pic($biodata_id );

		$pic_app 			= $this->Model_leave->get_email_app($biodata_id, $urutan_app);

		$data = array(	'judul' 		=> 'Cuti Dispensasi',
						'nama_user'		=> $biodata['nama_lengkap'],
						'nip'			=> $biodata['nip'],
						'divisi'		=> $biodata['nama_dept'],
						// 'jml_app'		=> $header_data['jml_app'],
						// 'mailto'		=> $pic_app['email']
					);
					// die(json_encode($data));
		$detail_item = $this->Model_cuti->getDetailData($header_data['tdk_masuk_h_id']);

		foreach($detail_item as $k => $v) {
			$result['detail_item'][] = $v;
		}
		$data['header_data'] = $result;

		// die(json_encode($data));

        $subject 	= 'Pengajuan '.$data['judul'].' - '.$data['nama_user'];
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




