<?php

class Model_terlambat extends CI_Model
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

		$hasil=$this->hrd->query("SELECT RIGHT(no_dok_tdk_masuk,4)+1 as gencode FROM hrd_all.trn_tidak_masuk_h
		WHERE no_dok_tdk_masuk LIKE '".$sno_doc."%' ORDER BY no_dok_tdk_masuk DESC LIMIT 1");

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
		$sql 	= "SELECT status_absensi_id, ket_status_absensi FROM hrd_all.mst_status_absensi WHERE kode_status_absensi IN ('IJ','SK') ORDER BY ket_status_absensi ASC";
		$query 	= $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return 	$query->result_array();
	}

	public function getIdStatusCuti($id){
		$sql 	= "SELECT status_absensi_id, ket_status_absensi, kode_status_absensi
		FROM hrd_all.mst_status_absensi WHERE status_absensi_id = '".$id."'
		ORDER BY kode_status_absensi ASC";
		$query 	= $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return 	$query->result_array();
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
				AND gad.hari = 3";

		// die($this->hrd->last_query());
		$query 	= $this->hrd->query($sql);
		return 	$query->row_array();
	}

	public function getCutiData1($no , $search_no = "", $length = "", $start = "", $column = "", $order = "")
	{

		if($search_no != "") $this->hrd->like('t0.biodata_id',$search_no);
		$this->hrd->select('t0.tdk_masuk_h_id, t0.biodata_id, t0.no_dok_tdk_masuk, t0.is_posting,
			CASE WHEN (status_dokumen)="R" THEN "DITOLAK"
			WHEN (status_dokumen)="O" THEN "OPEN"
			WHEN (status_dokumen)="P" THEN "SEDANG PROSES"
			ELSE "APPROVED"
			END posting,
			DATE_FORMAT(t0.tgl_dok_tdk_masuk, "%d-%m-%Y") tgl_dok,
			t0.potong_cuti_dari,
			CONCAT_WS(" | ", t1.kode_status_absensi, t1.ket_status_absensi) STATUS,
			CONCAT_WS(" | ", t2.nip, t2.nama_lengkap) nama_pic,
			t2.nip, t0.keterangan, t0.tgl_input');
		$this->hrd->from('hrd_all.trn_tidak_masuk_h t0');
		$this->hrd->join('hrd_all.mst_status_absensi t1', 't0.status_absensi_id = t1.status_absensi_id', 'left');
		$this->hrd->join('hrd_all.mst_biodata t2', 't0.biodata_id = t2.biodata_id', 'left');
		$this->hrd->join('hrd_all.trn_posting t3', 't0.tdk_masuk_h_id = t3.tdk_masuk_h_id', 'left');
		$this->hrd->join('hrd_all.trn_app_3rd r', 't0.tdk_masuk_h_id =  r.no_dok', 'left');
		$this->hrd->where('t0.biodata_id', $no);
		$this->hrd->like('t0.no_dok_tdk_masuk','HRT');
		$this->hrd->where('t0.status_absensi_id IN  ("000000000061" )');
		$this->hrd->order_by('t0.tgl_input','DESC');


		// if($column == 0){
		// 	$this->hrd->order_by('t0.tgl_input', $order);
		// }
		$this->hrd->limit($length,$start);
		$query=$this->hrd->get();
		// die(nl2br($this->hrd->last_query()));
		return $query->result_array();
	}

	public function getCutiData2($no , $search_no = "")
	{
		if($search_no != "") $this->hrd->like('t0.biodata_id',$search_no);

		$this->hrd->select('t0.tdk_masuk_h_id, t0.biodata_id, t0.no_dok_tdk_masuk, t0.is_posting,
			CASE WHEN (status_dokumen)="R" THEN "DITOLAK"
			WHEN (status_dokumen)="O" THEN "OPEN"
			WHEN (status_dokumen)="P" THEN "SEDANG PROSES"
			ELSE "APPROVED"
			END posting,
			DATE_FORMAT(t0.tgl_dok_tdk_masuk, "%d-%m-%Y") tgl_dok,
			t0.potong_cuti_dari,
			CONCAT_WS(" | ", t1.kode_status_absensi, t1.ket_status_absensi) STATUS,
			CONCAT_WS(" | ", t2.nip, t2.nama_lengkap) nama_pic,
			t2.nip, t0.keterangan, t0.tgl_input');
		$this->hrd->from('hrd_all.trn_tidak_masuk_h t0');
		$this->hrd->join('hrd_all.mst_status_absensi t1', 't0.status_absensi_id = t1.status_absensi_id', 'left');
		$this->hrd->join('hrd_all.mst_biodata t2', 't0.biodata_id = t2.biodata_id', 'left');
		$this->hrd->join('hrd_all.trn_posting t3', 't0.tdk_masuk_h_id = t3.tdk_masuk_h_id', 'left');
		$this->hrd->join('hrd_all.trn_app_3rd r', 't0.tdk_masuk_h_id =  r.no_dok', 'left');
		$this->hrd->where('t0.biodata_id', $no);
		$this->hrd->like('t0.no_dok_tdk_masuk','HRT');
		$this->hrd->where('t0.status_absensi_id IN  ("000000000061" )');
		$this->hrd->order_by('t0.tgl_input','DESC');
		$jum=$this->hrd->get();
		return $jum->num_rows();
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
				, h.nama, i.*,k.*,
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
				LEFT JOIN hrd_all.trn_dokumen_ijin k ON f.no_dok_tdk_masuk = k.no_dok
				LEFT JOIN hrd_all.mst_status_absensi i ON f.status_absensi_id  = i.status_absensi_id
				LEFT JOIN hrd_web_master.mst_departemen h ON a.dept_user = h.hash
				LEFT JOIN
				(SELECT  a.approved_user, COUNT(a.karyawan_id)jml_app FROM hrd_web_master.mst_user_approval_detail a
				LEFT JOIN hrd_web_master.mst_karyawan_01 b ON a.karyawan_id=b.karyawan_id
				GROUP BY a.approved_user) i ON a.approved_user=i.approved_user
				WHERE f.tdk_masuk_h_id = ?
				AND d.nip='$nip' AND YEAR(tgl_dok_tdk_masuk)>='2021'
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
	public function getHeaderDataV($no_dok_h = null)
	{
		if($no_dok_h) {
			$nip = $this->session->userdata('nama_login');
			$sql = "SELECT a.* ,jml_app
				, d.nip,d.nama_lengkap
				, e.nip, e.nama_lengkap
				, f.*
				, g.status
				, h.nama, i.*,k.*,
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
				LEFT JOIN hrd_all.trn_dokumen_ijin k ON f.no_dok_tdk_masuk = k.no_dok
				LEFT JOIN hrd_all.mst_status_absensi i ON f.status_absensi_id  = i.status_absensi_id
				LEFT JOIN hrd_web_master.mst_departemen h ON a.dept_user = h.hash
				LEFT JOIN
				(SELECT  a.approved_user, COUNT(a.karyawan_id)jml_app FROM hrd_web_master.mst_user_approval_detail a
				LEFT JOIN hrd_web_master.mst_karyawan_01 b ON a.karyawan_id=b.karyawan_id
				GROUP BY a.approved_user) i ON a.approved_user=i.approved_user
				WHERE f.tdk_masuk_h_id = ?
				AND YEAR(tgl_dok_tdk_masuk)>='2021'
				AND is_posting=0 AND is_batal=0
				AND urutan_approval = 2
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

	public function getHeaderDataBC($no_dok_h = null)
	{
		if($no_dok_h) {
			$sql = "SELECT a.*,k.*, ket_status_absensi,kode_status_absensi
			FROM hrd_all.trn_tidak_masuk_h a
			LEFT JOIN hrd_all.mst_status_absensi b ON a.status_absensi_id  = b.status_absensi_id
			LEFT JOIN hrd_all.trn_dokumen_ijin k ON a.no_dok_tdk_masuk = k.no_dok
			WHERE tdk_masuk_h_id = ?";
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
		WHERE tdk_masuk_h_id = ? ORDER BY tgl_tdk_masuk DESC';
		$query = $this->hrd->query($sql, array($no_dok_h));
		// die(nl2br($this->hrd->last_query()));
		return $query->result_array();
	}

	public function getApprovalData1($nip , $search_no = "", $length = "", $start = "", $column = "", $order = "")
	{
		if($this->session->userdata('nama_login')!='99999999'){
			$this->hrd->select("a.no_dok_tdk_masuk,a.tdk_masuk_h_id,a.keterangan, tgl_dok_tdk_masuk,
				c.nip,c.biodata_id,c.nama_lengkap,
				e.nip,e.biodata_id, b.status, b.status_dokumen,g.nama_dept");
				$this->hrd->from('hrd_all.trn_tidak_masuk_h a');
				$this->hrd->join('hrd_all.trn_posting b', 'a.tdk_masuk_h_id = b.tdk_masuk_h_id', 'left');
				$this->hrd->join('hrd_all.mst_biodata c', 'a.biodata_id = c.biodata_id', 'left');
				$this->hrd->join('hrd_all.trn_app_cp d', 'c.nip = d.nip_user', 'left');
				$this->hrd->join('hrd_all.mst_biodata e', 'd.nip_approval = e.nip', 'left');
				$this->hrd->join('hrd_all.biodata_pekerjaan_d f', 'c.biodata_id = f.biodata_id', 'left');
				$this->hrd->join('hrd_all.mst_dept g', 'f.dept_id = g.dept_id', 'left');
				$this->hrd->where('d.nip_approval', $nip);
				$this->hrd->where('is_posting=0 AND is_batal=0 AND LEFT(no_dok_tdk_masuk,3) = "HRT"');
				$this->hrd->where('urutan_app=','b.status+1',FALSE);
			$this->hrd->order_by('tgl_dok_tdk_masuk','DESC');

		}else{
			$this->hrd->select('t0.tdk_masuk_h_id,t0.biodata_id, t0.no_dok_tdk_masuk,t0.is_posting,t0.is_batal,
				CASE WHEN (status_dokumen)="R" THEN "DITOLAK"
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
			$this->hrd->where('t0.is_posting=0 AND t0.is_batal=0  AND LEFT(no_dok_tdk_masuk,3)="HRT"');
			$this->hrd->where_in('t3.status_dokumen',array('P','O'));
			$this->hrd->order_by('tgl_dok_tdk_masuk','DESC');
		}
		$this->hrd->limit($length,$start);
		$query=$this->hrd->get();
		// die(nl2br($this->hrd->last_query()));
		return $query->result_array();


	}

	public function getApprovalData2($nip , $search_no = "")
	{
		if($this->session->userdata('nama_login')!='99999999'){
			$this->hrd->select("a.no_dok_tdk_masuk,a.tdk_masuk_h_id,a.keterangan, tgl_dok_tdk_masuk,
				c.nip,c.biodata_id,c.nama_lengkap,
				e.nip,e.biodata_id, b.status, b.status_dokumen,g.nama_dept");
				$this->hrd->from('hrd_all.trn_tidak_masuk_h a');
				$this->hrd->join('hrd_all.trn_posting b', 'a.tdk_masuk_h_id = b.tdk_masuk_h_id', 'left');
				$this->hrd->join('hrd_all.mst_biodata c', 'a.biodata_id = c.biodata_id', 'left');
				$this->hrd->join('hrd_all.trn_app_cp d', 'c.nip = d.nip_user', 'left');
				$this->hrd->join('hrd_all.mst_biodata e', 'd.nip_approval = e.nip', 'left');
				$this->hrd->join('hrd_all.biodata_pekerjaan_d f', 'c.biodata_id = f.biodata_id', 'left');
				$this->hrd->join('hrd_all.mst_dept g', 'f.dept_id = g.dept_id', 'left');
				$this->hrd->where('d.nip_approval', $nip);
				$this->hrd->where('is_posting=0 AND is_batal=0 AND LEFT(no_dok_tdk_masuk,3) = "HRT"');
				$this->hrd->where('urutan_app=','b.status+1',FALSE);
			$this->hrd->order_by('tgl_dok_tdk_masuk','DESC');
		}else{
			$this->hrd->select('t0.tdk_masuk_h_id,t0.biodata_id, t0.no_dok_tdk_masuk,t0.is_posting,
				CASE WHEN (status_dokumen)="R" THEN "DITOLAK"
				WHEN (status_dokumen)="O" THEN "OPEN"
				WHEN (status_dokumen)="P" THEN "SEDANG PROSES"
				ELSE "APPROVED"
				END posting, t0.tgl_dok_tdk_masuk,
				t0.potong_cuti_dari,CONCAT_WS(" | ", t1.kode_status_absensi,t1.ket_status_absensi) status,
				t2.nama_lengkap,t2.nip,
				t0.keterangan,t0.tgl_input');
			$this->hrd->from('hrd_all.trn_tidak_masuk_h t0');
			$this->hrd->join('hrd_all.mst_status_absensi t1', 't0.status_absensi_id = t1.status_absensi_id', 'left');
			$this->hrd->join('hrd_all.mst_biodata t2', 't0.biodata_id = t2.biodata_id', 'left');
			$this->hrd->join('hrd_all.trn_posting t3', 't0.tdk_masuk_h_id = t3.tdk_masuk_h_id', 'left');
			$this->hrd->where_in('t0.biodata_id', array('d6cc08986fa7','6734021e8980','06d0e9c23a66','000000000178'));
			$this->hrd->where('t0.is_posting=0 AND t0.is_batal=0 AND LEFT(no_dok_tdk_masuk,3)="HRT"');
			$this->hrd->where_in('t3.status_dokumen',array('P','O'));
			$this->hrd->order_by('tgl_dok_tdk_masuk','DESC');
		}
		$jum=$this->hrd->get();
		return $jum->num_rows();
	}

	public function getDataTerlambatHistory($nip,$search_no="",$length="",$start="",$column="",$order="")
	{
		$sql = "SELECT no_dok_tdk_masuk,tgl_dok_tdk_masuk,nip,nama_lengkap,e.nama_dept,date(tgl_app_1) tgl_app_1, status_dokumen, 
				CASE WHEN (is_posting = 1 AND status_dokumen ='C') THEN 'CLOSED' 
				WHEN status_dokumen ='P' THEN 'PROCESS'
				WHEN status_dokumen ='O' THEN 'OPEN'
				ELSE 'REJECT'
				END posting
				FROM(
					SELECT tdk_masuk_h_id,tgl_app_1, status_dokumen,'' kom FROM hrd_all.trn_posting
					WHERE app_1 = ".$nip."
					UNION ALL
					SELECT tdk_masuk_h_id,tgl_app_2, status_dokumen,'' kom FROM hrd_all.trn_posting
					WHERE app_2 = ".$nip."
					UNION ALL
					SELECT tdk_masuk_h_id,tgl_rej_1, status_dokumen, rej_komentar_1 FROM hrd_all.trn_posting
					WHERE rej_1 = ".$nip."
					UNION ALL
					SELECT tdk_masuk_h_id,tgl_rej_2, status_dokumen, rej_komentar_2 FROM hrd_all.trn_posting
					WHERE rej_2 = ".$nip."
					)a
				LEFT JOIN hrd_all.trn_tidak_masuk_h b ON a.tdk_masuk_h_id = b.tdk_masuk_h_id
				LEFT JOIN hrd_all.mst_biodata c ON b.biodata_id = c.biodata_id
				LEFT JOIN hrd_all.biodata_pekerjaan_d d ON c.biodata_id = d.biodata_id
				LEFT JOIN hrd_all.mst_dept e ON d.dept_id = e.dept_id
				WHERE no_dok_tdk_masuk LIKE 'HRT%'
				ORDER BY no_dok_tdk_masuk
				LIMIT $start,$length ";
				#print_r($sql);die;
		$query = $this->hrd->query($sql);
		return $query->result_array();
	}

	public function getDataTerlambatHistoryDetail($no_dok_tdk_masuk)
	{
		$sql = "SELECT a.nama_hari,a.tgl_tdk_masuk,a.jam_ijin,a.jam_kembali,a.potong_cuti_dari,a.keterangan
				FROM hrd_all.trn_tidak_masuk_d a
				JOIN hrd_all.trn_tidak_masuk_h b ON a.tdk_masuk_h_id=b.tdk_masuk_h_id
				WHERE b.no_dok_tdk_masuk = '$no_dok_tdk_masuk' ORDER BY a.tgl_tdk_masuk DESC";
				#print_r($sql);die;
		$query = $this->hrd->query($sql);
		return $query->result_array();
	}

	public function getCountDataTerlambatHistory($nip)
	{
		$sqls = "SELECT no_dok_tdk_masuk,tgl_dok_tdk_masuk,nip,nama_lengkap,e.nama_dept,date(tgl_app_1) tgl_app_1, status_dokumen, 
					CASE WHEN (is_posting = 1 AND status_dokumen ='C') THEN 'CLOSED' 
					WHEN status_dokumen ='P' THEN 'PROCESS'
					WHEN status_dokumen ='O' THEN 'OPEN'
					ELSE 'REJECT'
					END posting
					FROM( SELECT tdk_masuk_h_id,tgl_app_1, status_dokumen,'' kom FROM hrd_all.trn_posting
						WHERE app_1 = ".$nip."
						UNION ALL
						SELECT tdk_masuk_h_id,tgl_app_2, status_dokumen,'' kom FROM hrd_all.trn_posting
						WHERE app_2 = ".$nip."
						UNION ALL
						SELECT tdk_masuk_h_id,tgl_rej_1, status_dokumen, rej_komentar_1 FROM hrd_all.trn_posting
						WHERE rej_1 = ".$nip."
						UNION ALL
						SELECT tdk_masuk_h_id,tgl_rej_2, status_dokumen, rej_komentar_2 FROM hrd_all.trn_posting
						WHERE rej_2 =".$nip."
						)a
					LEFT JOIN hrd_all.trn_tidak_masuk_h b ON a.tdk_masuk_h_id = b.tdk_masuk_h_id
					LEFT JOIN hrd_all.mst_biodata c ON b.biodata_id = c.biodata_id
					LEFT JOIN hrd_all.biodata_pekerjaan_d d ON c.biodata_id = d.biodata_id
					LEFT JOIN hrd_all.mst_dept e ON d.dept_id = e.dept_id
					WHERE no_dok_tdk_masuk LIKE 'HRT%'
					ORDER BY no_dok_tdk_masuk
				";

		$jum = $this->hrd->query($sqls);
		// die($this->hrd->last_query());
		return $jum->num_rows();
	}

	public function getDataTerlambatPosting($nip ,$search_no="",$length="",$start="",$column="",$order="")
	{
		$sql = "SELECT no_dok_tdk_masuk,tgl_dok_tdk_masuk,nip,nama_lengkap,e.nama_dept,date(tgl_app_1) tgl_app_1, status_dokumen, 
				CASE WHEN (is_posting = 1 AND status_dokumen ='C') THEN 'APPROVED' 
				WHEN status_dokumen ='P' THEN 'PROCESS'
				WHEN status_dokumen ='O' THEN 'OPEN'
				ELSE 'REJECT'
				END posting
				FROM(
					SELECT tdk_masuk_h_id,tgl_app_1, status_dokumen,'' kom FROM hrd_all.trn_posting
					WHERE app_1 = ".$nip."
					UNION ALL
					SELECT tdk_masuk_h_id,tgl_app_2, status_dokumen,'' kom FROM hrd_all.trn_posting
					WHERE app_2 = ".$nip."
					UNION ALL
					SELECT tdk_masuk_h_id,tgl_rej_1, status_dokumen, rej_komentar_1 FROM hrd_all.trn_posting
					WHERE rej_1 = ".$nip."
					UNION ALL
					SELECT tdk_masuk_h_id,tgl_rej_2, status_dokumen, rej_komentar_2 FROM hrd_all.trn_posting
					WHERE rej_2 =".$nip."
					)a
				LEFT JOIN hrd_all.trn_tidak_masuk_h b ON a.tdk_masuk_h_id = b.tdk_masuk_h_id
				LEFT JOIN hrd_all.mst_biodata c ON b.biodata_id = c.biodata_id
				LEFT JOIN hrd_all.biodata_pekerjaan_d d ON c.biodata_id = d.biodata_id
				LEFT JOIN hrd_all.mst_dept e ON d.dept_id = e.dept_id
				WHERE no_dok_tdk_masuk LIKE 'HRT%'
				ORDER BY no_dok_tdk_masuk
				LIMIT $start,$length ";
		$query = $this->hrd->query($sql);
		// die(nl2br($this->hrd->last_query()));
		return $query->result_array();
	}

	public function getCountDataTerlambatPosting($nip)
	{
		$sqls = "SELECT no_dok_tdk_masuk,tgl_dok_tdk_masuk,nip,nama_lengkap,e.nama_dept,date(tgl_app_1) tgl_app_1, status_dokumen, 
					CASE WHEN (is_posting = 1 AND status_dokumen ='C') THEN 'APPROVED'
					WHEN status_dokumen ='P' THEN 'PROCESS'
					WHEN status_dokumen ='O' THEN 'OPEN'
					ELSE 'REJECT'
					END posting
					FROM(
						SELECT tdk_masuk_h_id,tgl_app_1, status_dokumen,'' kom FROM hrd_all.trn_posting
						WHERE app_1 = ".$nip."
						UNION ALL
						SELECT tdk_masuk_h_id,tgl_app_2, status_dokumen,'' kom FROM hrd_all.trn_posting
						WHERE app_2 = ".$nip."
						UNION ALL
						SELECT tdk_masuk_h_id,tgl_rej_1, status_dokumen, rej_komentar_1 FROM hrd_all.trn_posting
						WHERE rej_1 = ".$nip."
						UNION ALL
						SELECT tdk_masuk_h_id,tgl_rej_2, status_dokumen, rej_komentar_2 FROM hrd_all.trn_posting
						WHERE rej_2 =".$nip."
						)a
					LEFT JOIN hrd_all.trn_tidak_masuk_h b ON a.tdk_masuk_h_id = b.tdk_masuk_h_id
					LEFT JOIN hrd_all.mst_biodata c ON b.biodata_id = c.biodata_id
					LEFT JOIN hrd_all.biodata_pekerjaan_d d ON c.biodata_id = d.biodata_id
					LEFT JOIN hrd_all.mst_dept e ON d.dept_id = e.dept_id
					WHERE no_dok_tdk_masuk LIKE 'HRT%'
					ORDER BY no_dok_tdk_masuk
				";

		$jum = $this->hrd->query($sqls);
		// die($this->hrd->last_query());
		return $jum->num_rows();
	}

	public function getVerifikasi1($nip , $search_no = "", $length = "", $start = "", $column = "", $order = "")
	{
		$nips 				= $this->session->userdata('nama_login');
		$sql_pic 			= $this->getDataPicDewaHrd();
		if($nips==$sql_pic['nip']){

			$sql = 'SELECT * FROM (
				SELECT
				no_dok_tdk_masuk, tgl_dok_tdk_masuk,nip,nama_lengkap, nama_dept, a.tdk_masuk_h_id,"IJIN" AS jn
				FROM hrd_all.trn_tidak_masuk_h a
				LEFT JOIN hrd_all.trn_posting b ON a.tdk_masuk_h_id = b.tdk_masuk_h_id
				LEFT JOIN hrd_all.trn_app_3rd r ON a.tdk_masuk_h_id = r.no_dok
				LEFT JOIN hrd_all.mst_biodata i ON a.biodata_id = i.biodata_id
				LEFT JOIN hrd_all.biodata_pekerjaan_d k ON i.biodata_id = k.biodata_id
				LEFT JOIN hrd_all.mst_dept m ON k.dept_id = m.dept_id
				WHERE LEFT(no_dok_tdk_masuk,3) = "HRT" AND status_absensi_id IN ("000000000061","000000000009")
				AND YEAR(tgl_dok_tdk_masuk) = 2021
				AND b.status_dokumen ="C"
				AND IFNULL(r.no_dok,"")=""
				UNION ALL
				SELECT no_dok_cuti,tgl_dok_cuti, i.nip, nama_lengkap, nama_dept, a.cuti_dispensasi_h_id,"CUTI DISPENSASI" as jn
				FROM hrd_all.trn_cuti_dispensasi_h a
				LEFT JOIN hrd_all.trn_posting b ON a.cuti_dispensasi_h_id = b.tdk_masuk_h_id
				LEFT JOIN hrd_all.trn_app_3rd r ON a.cuti_dispensasi_h_id = r.no_dok
				LEFT JOIN hrd_all.mst_biodata i ON a.biodata_id = i.biodata_id
				LEFT JOIN hrd_all.biodata_pekerjaan_d k ON i.biodata_id = k.biodata_id
				LEFT JOIN hrd_all.mst_dept m ON k.dept_id = m.dept_id
				WHERE LEFT(no_dok_cuti,4) = "HRCD"
				AND YEAR(tgl_dok_cuti) = 2021
				AND b.status_dokumen ="C"
				AND IFNULL(r.no_dok,"")="") h
				order by tgl_dok_tdk_masuk DESC
				limit '.$start.','.$length.'
			';
			$query = $this->hrd->query($sql);
			// die(nl2br($this->hrd->last_query()));
			return $query->result_array();
		}

	}

	public function getVerifikasi2($nip , $search_no = "")
	{
		$nips 				= $this->session->userdata('nama_login');
		$sql_pic 			= $this->getDataPicDewaHrd();
		if($nips==$sql_pic['nip']){
			$sql = '
				SELECT
				no_dok_tdk_masuk, tgl_dok_tdk_masuk,nip,nama_lengkap, nama_dept, a.tdk_masuk_h_id
				FROM hrd_all.trn_tidak_masuk_h a
				LEFT JOIN hrd_all.trn_posting b ON a.tdk_masuk_h_id = b.tdk_masuk_h_id
				LEFT JOIN hrd_all.trn_app_3rd r ON a.tdk_masuk_h_id = r.no_dok
				LEFT JOIN hrd_all.mst_biodata i ON a.biodata_id = i.biodata_id
				LEFT JOIN hrd_all.biodata_pekerjaan_d k ON i.biodata_id = k.biodata_id
				LEFT JOIN hrd_all.mst_dept m ON k.dept_id = m.dept_id
				WHERE LEFT(no_dok_tdk_masuk,3) = "HRT" AND status_absensi_id = "000000000061"
				AND YEAR(tgl_dok_tdk_masuk) = 2021
				AND b.status_dokumen ="C"
				AND IFNULL(r.no_dok,"")=""
				UNION ALL
				SELECT no_dok_cuti,tgl_dok_cuti, i.nip, nama_lengkap, nama_dept, a.cuti_dispensasi_h_id
				FROM hrd_all.trn_cuti_dispensasi_h a
				LEFT JOIN hrd_all.trn_posting b ON a.cuti_dispensasi_h_id = b.tdk_masuk_h_id
				LEFT JOIN hrd_all.trn_app_3rd r ON a.cuti_dispensasi_h_id = r.no_dok
				LEFT JOIN hrd_all.mst_biodata i ON a.biodata_id = i.biodata_id
				LEFT JOIN hrd_all.biodata_pekerjaan_d k ON i.biodata_id = k.biodata_id
				LEFT JOIN hrd_all.mst_dept m ON k.dept_id = m.dept_id
				WHERE LEFT(no_dok_cuti,4) = "HRCD"
				AND YEAR(tgl_dok_cuti) = 2021
				AND b.status_dokumen ="C"
				AND IFNULL(r.no_dok,"")=""
			';
			$jum=$this->hrd->query($sql);
		return $jum->num_rows();
		}
	}

	public function getDataPicDewaHrd()
	{
		$nip 				= $this->session->userdata('nama_login');
		$sql = "SELECT * FROM hrd_all.trn_pic_dewa WHERE nip='$nip' AND LEVEL =2";
		$query = $this->hrd->query($sql);
		return $query->row_array();
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
			WHERE e.biodata_id=$biodata_id GROUP BY urutan_approval)a";
		$query = $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return $query->row_array();
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

	public function getUrutanApp($nip_app,$nip_user)
	{
		$sql = "SELECT
				c.biodata_id,c.nip, c.nama_lengkap,
				b.biodata_id,b.nip, b.nama_lengkap, urutan_app urutan_approval,a.email
				FROM hrd_all.trn_app_cp a
				LEFT JOIN hrd_all.mst_biodata b ON a.nip_approval=b.nip
				LEFT JOIN hrd_all.mst_biodata c ON a.nip_user = c.nip
				WHERE a.nip_approval ='$nip_app'
				AND a.nip_user= '$nip_user'";
		$query = $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return $query->row_array();
	}

	public function count_nip_cp($biodata_id)
	{

		$sql = "SELECT c.biodata_id,c.nip, c.nama_lengkap,
			b.biodata_id,b.nip , b.nama_lengkap, urutan_app urutan_approval,a.email
			FROM hrd_all.trn_app_cp a
			LEFT JOIN hrd_all.mst_biodata b ON a.nip_approval=b.nip
			LEFT JOIN hrd_all.mst_biodata c ON a.nip_user = c.nip
			WHERE c.biodata_id ='$biodata_id'
			GROUP BY urutan_approval";

		$jum 	= $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return $jum->num_rows();
	}


/*** Manage Action  ***/

	public function create()
	{
		$docCode	='HRT';
		$date		= date('ym');

		$data_header = array(
			'tdk_masuk_h_id'			=> $this->uuid->v4(),
			'biodata_id'				=> $this->input->post('biodata_id'),
			'pic_input'    				=> $this->input->post('biodata_id'),
			'no_dok_tdk_masuk'  		=> $this->getDataNoDoc($docCode, $date),
			'jml_ambil' 				=> '0',
			'jml_ambil_normatif'		=> '0',
			'jml_ambil_bonus'   		=> '0',
            'jml_ambil_tambahan'		=> '0',
			'status_absensi_id'	  		=> $this->input->post('status_absensi_id'),
			'keterangan'	  			=> $this->input->post('keterangan'),
			'is_posting'	  			=> '0',
			'is_batal'	  				=> '0',
			'tgl_dok_tdk_masuk'			=> date('Y-m-d'),
			'tgl_input'    				=> date('Y-m-d H:i:s'),
		);
		// die(json_encode($data_header));
		$insert = $this->hrd->insert('hrd_all.trn_tidak_masuk_h', $data_header);

		$sno_doc        = $data_header['no_dok_tdk_masuk'];
		$tdk_masuk_h_id = $data_header['tdk_masuk_h_id'];


		$log_detail = array();
		$count_tgl_tdk_masuk = count($this->input->post('tgl_tdk_masuk'));
		for($x = 0; $x < $count_tgl_tdk_masuk; $x++) {
			$uuid_d = $this->uuid->v4($x);
			$tgl_tdk_masuks =  $this->input->post('tgl_tdk_masuk')[$x];
			$tgl_kembalis 	=  $this->input->post('tgl_kembali')[$x];
			$namahari = format_indo(date('D', strtotime($tgl_tdk_masuks)));
			$jam_ijin = date('H:i:s', strtotime($tgl_tdk_masuks));
			$tgl_ijin = date('Y-m-d', strtotime($tgl_tdk_masuks));
			// if($this->input->post('tgl_kembali')!=='' || $this->input->post('tgl_kembali')!==null){
			// 	$jam_kembali = date('h:i:s', strtotime($tgl_kembalis));
			// 	$kembali 		= '1';
			// } else {
				$kembali 		= '0';
				$jam_kembali 	= '00:00:00';
			// }
			$items = array(
				'tdk_masuk_h_id'	=> $data_header['tdk_masuk_h_id'],
				'tdk_masuk_d_id' 	=> $uuid_d,
				'keterangan' 		=> $this->input->post('keterangan_cuti')[$x],
				'is_potong_cuti'	=> '1',
				'is_ijin'			=> '1',
				'is_kembali'		=> $kembali,
				'jam_ijin'			=> $jam_ijin,
				'jam_kembali'		=> $jam_kembali,
				'nilai_hari' 	    => '1',
				'nama_hari' 	    => $namahari,
				'tgl_tdk_masuk' 	=> $tgl_ijin,
				'pic_input'         => $this->input->post('biodata_id'),
				'tgl_input'    		=> date('Y-m-d H:i:s'),
			);
			array_push($log_detail,$items);
			$this->hrd->insert('hrd_all.trn_tidak_masuk_d', $items);

		}

		// tesx($log_detail);

		$data_posting = array(
			'tdk_masuk_h_id'	=> $data_header['tdk_masuk_h_id'],
			'status' 			=> '0',
			'status_dokumen' 	=> 'O'
		);
		// die(json_encode($data_posting));
		$this->hrd->set($data_posting);
		$this->hrd->insert('hrd_all.trn_posting');


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
				$config['quality'] = '60%';
				$config['width'] = '750';
				$config['height'] = '500';
				$config['new_image'] = FCPATH . 'upload/ijin/'.$post_img1["file_name"];
				$this->load->library('image_lib',$config);
				$this->image_lib->resize();
				$post_image1 = $post_img1["file_name"];
				unset($config);
                $this->load->library('image_lib');
                $this->image_lib->clear();
			// die(json_encode($post_image1));


			$this->upload->do_upload('file_2');
			$post_img2 = $this->upload->data();
				$config2['image_library'] = 'gd2';
				$config2['source_image'] = FCPATH . 'upload/ijin/'.$post_img2["file_name"];
				$config2['maintain_ratio'] = TRUE;
				$config2['quality'] = '60%';
				$config2['width'] = '750';
				$config2['height'] = '500';
				$config2['new_image'] = FCPATH . 'upload/ijin/'.$post_img2["file_name"];
				$this->load->library('image_lib');
				$this->image_lib->initialize($config2);
				$this->image_lib->resize();
				$post_image2 = $post_img2["file_name"];
				unset($config2);
                $this->load->library('image_lib');
                $this->image_lib->clear();
			// die(json_encode($post_image2));

			$this->upload->do_upload('file_3');
				$post_img3 = $this->upload->data();
				$config3['image_library'] = 'gd2';
				$config3['source_image'] = FCPATH . 'upload/ijin/'.$post_img3["file_name"];
				$config3['maintain_ratio'] = TRUE;
				$config3['quality'] = '60%';
				$config3['width'] = '750';
				$config3['height'] = '500';
				$config3['new_image'] = FCPATH . 'upload/ijin/'.$post_img3["file_name"];
				$this->load->library('image_lib');
				$this->image_lib->initialize($config3);
				$this->image_lib->resize();
				$post_image3 = $post_img3["file_name"];
				unset($config3);
                $this->load->library('image_lib');
                $this->image_lib->clear();

			// die(json_encode($post_image3));


			// tesx($post_image1,$post_image2,$post_image3);


			$data_dokumen = array(
					'no_dok' => $data_header['no_dok_tdk_masuk'],
					'file_1' => $post_image1,
					'file_2' => $post_image2,
					'file_3' => $post_image3,
			);
			// die(json_encode($data_dokumen));
			$this->hrd->insert('hrd_all.trn_dokumen_ijin', $data_dokumen);

        /* End Manage Image */

		$this->send_mail_create($data_header, $log_detail);

		return ($sno_doc) ? $sno_doc : false;
	}

	public function ApproveAction()
	{
		$biodata_id 		= $this->input->post('biodata_id');
			$tdk_masuk_h_id 	= $this->input->post('tdk_masuk_h_id');
			$no_doc        		= $this->input->post('no_doc');
			$sel_dok 			= $this->getHeaderData($tdk_masuk_h_id);
			// $urutan_approval 	= $sel_dok['urutan_approval'];
			// $count				= $sel_dok['jml_app'];
			$kode_abesensi		= $sel_dok['kode_status_absensi'];
			$status_abesensi	= $sel_dok['status_absensi_id'];
			$nip 				= $this->session->userdata('nama_login');
		$sql_pic 			= $this->getDataPicDewaHrd();

		$nip_app 			= $this->session->userdata('nama_login');
		$biodata 			= $this->hrd->select('nip')
								->get_where('hrd_all.mst_biodata',array('biodata_id' => $biodata_id))
								->row_array();
		$nip_user			= $biodata['nip'];

		$tdk_masuk_h_id 	= $this->input->post('tdk_masuk_h_id');
		$sno_doc        	= $this->input->post('no_doc');
		$sel_dok 			= $this->getHeaderDataBC($tdk_masuk_h_id);

		$getUrutan			= $this->getUrutanApp($nip_app,$nip_user);
		$getCount			= $this->count_nip_cp($biodata_id);

		$count				= $getCount;
		$urutan_approval 	= $getUrutan['urutan_approval'];

		if($urutan_approval==$count){

			// tesx($urutan_approval);
				// if($nip==$sql_pic['nip'] ){
					$log_absen = array();
					$count_absen =  count($this->input->post('tgl_tdk_masuk'));
					//Looping Hari & Tanggal
					for($x = 0; $x < $count_absen; $x++) {
						$tgl_absen = $this->input->post('tgl_tdk_masuk')[$x];
						$cek_absen = $this->getDataAbsensi($biodata_id,$tgl_absen);

						if($tgl_absen == $cek_absen['tgl_absensi']){
							$data_absensi = array(
								'gol_absensi_d_id'			=> $this->input->post('gol_absensi_d_id'),
								'no_trn_absen'  			=> $this->input->post('no_doc'),
								'no_reff'  					=> $this->input->post('no_doc'),
								'status_absen'  			=> $sel_dok['kode_status_absensi'],
								'is_manual'  				=> '1',
								'keterangan'  				=> $sel_dok['kode_status_absensi'],
								'keterangan2'  				=> $sel_dok['keterangan']
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
								'status_absen'  			=> $sel_dok['kode_status_absensi'],
								'keterangan'  				=> $sel_dok['kode_status_absensi'],
								'keterangan2'  				=> $sel_dok['keterangan'],
								'is_manual'  				=> '1',
								'tgl_absensi'				=> $this->input->post('tgl_tdk_masuk')[$x],
								'pic_input'					=> $nip_user,
								'wkt_input'					=> date('Y-m-d')
							);
							array_push($log_absen,$data_absensi);
							$this->hrd->insert('hrd_all.trn_absensi', $data_absensi);
						}
					}

					// tesx($data_absensi);

					$data_dok = array(
						'tdk_masuk_h_id'=> $tdk_masuk_h_id,
						'is_posting'	=> '1',
						'pic_posting' 	=> $this->input->post('biodata_id'),
						'pic_input' 	=> $nip_user,
						'tgl_posting'	=> date('Y-m-d'),
					);
					$this->hrd->set($data_dok);
					$this->hrd->where('tdk_masuk_h_id', $tdk_masuk_h_id);
					$this->hrd->update('hrd_all.trn_tidak_masuk_h');

					$data_posting = array(
						'app_'.$urutan_approval.''		=> $nip,
						'tgl_app_'.$urutan_approval.'' 	=> date('Y-m-d h:i:s'),
						'status' 						=> $urutan_approval,
						'status_dokumen' 				=> 'C'
					);
					$this->hrd->set($data_posting);
					$this->hrd->where('tdk_masuk_h_id', $tdk_masuk_h_id);
					$this->hrd->update('hrd_all.trn_posting');

					// $app3 = array(
					// 	'no_dok'			=> $no_doc,
					// 	'pic_koreksi' 		=> $nip,
					// 	'tgl_koreksi'		=> date('Y-m-d'),
					// );
					// $this->hrd->set($app3);
					// $this->hrd->insert('hrd_all.trn_app_3rd');

				// }else{

				// 	$data_dok2 = array(
				// 		'tdk_masuk_h_id'	=> $tdk_masuk_h_id,
				// 		'is_posting'		=> '1',
				// 		'pic_input' 		=> $nip,
				// 		'tgl_input'			=> date('Y-m-d'),
				// 	);
				// 	$this->hrd->set($data_dok2);
				// 	$this->hrd->where('tdk_masuk_h_id', $tdk_masuk_h_id);
				// 	$this->hrd->update('hrd_all.trn_tidak_masuk_h');

				// 	$data_posting = array(
				// 		'tdk_masuk_h_id'				=> $tdk_masuk_h_id,
				// 		'app_'.$urutan_approval.''		=> $nip,
				// 		'tgl_app_'.$urutan_approval.'' 	=> date('Y-m-d h:i:s'),
				// 		'status' 						=> $urutan_approval,
				// 		'status_dokumen' 				=> 'C'
				// 	);
				// 	$this->hrd->set($data_posting);
				// 	$this->hrd->where('tdk_masuk_h_id', $tdk_masuk_h_id);
				// 	$this->hrd->update('hrd_all.trn_posting');
				// }
		} else {
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
					'app_'.$urutan_approval.''		=> $nip,
					'tgl_app_'.$urutan_approval.'' 	=> date('Y-m-d'),
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

	public function ApproveDireksi()
	{
		$biodata_id 		= $this->input->post('biodata_id');
			$tdk_masuk_h_id 	= $this->input->post('tdk_masuk_h_id');
			$no_doc        		= $this->input->post('no_doc');
			$sel_dok 			= $this->getHeaderData($tdk_masuk_h_id);
			// $urutan_approval 	= $sel_dok['urutan_approval'];
			// $count				= $sel_dok['jml_app'];
			$kode_abesensi		= $sel_dok['kode_status_absensi'];
			$status_abesensi	= $sel_dok['status_absensi_id'];
			$nip 				= $this->session->userdata('nama_login');
		$sql_pic 			= $this->getDataPicDewaHrd();

		$nip_app 			= $this->session->userdata('nama_login');
		$biodata 			= $this->hrd->select('nip')
								->get_where('hrd_all.mst_biodata',array('biodata_id' => $biodata_id))
								->row_array();
		$nip_user			= $biodata['nip'];
		$getUrutan			= $this->getUrutanApp($nip_app,$nip_user);
		$getCount			= $this->count_nip_cp($biodata_id);

		$count				= $getCount;
		$urutan_approval 	= $getUrutan['urutan_approval'];

		if($nip==$sql_pic['nip'] ){
			$log_absen = array();
			$count_absen =  count($this->input->post('tgl_tdk_masuk'));
			//Looping Hari & Tanggal
			for($x = 0; $x < $count_absen; $x++) {
				$tgl_absen = $this->input->post('tgl_tdk_masuk')[$x];
				$cek_absen = $this->getDataAbsensi($biodata_id,$tgl_absen);

				if($tgl_absen == $cek_absen['tgl_absensi']){
					$data_absensi = array(
						'gol_absensi_d_id'			=> $this->input->post('gol_absensi_d_id'),
						'no_trn_absen'  			=> $this->input->post('no_doc'),
						'no_reff'  					=> $this->input->post('no_doc'),
						'status_absen'  			=> $sel_dok['kode_status_absensi'],
						'is_manual'  				=> '1',
						'keterangan'  				=> $sel_dok['kode_status_absensi'],
						'keterangan2'  				=> $sel_dok['keterangan']
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
						'status_absen'  			=> $sel_dok['kode_status_absensi'],
						'keterangan'  				=> $sel_dok['kode_status_absensi'],
						'keterangan2'  				=> $sel_dok['keterangan'],
						'is_manual'  				=> '1',
						'tgl_absensi'				=> $this->input->post('tgl_tdk_masuk')[$x],
						'pic_input'					=> $this->session->userdata('nama_login'),
						'wkt_input'					=> date('Y-m-d')
					);
					array_push($log_absen,$data_absensi);
					$this->hrd->insert('hrd_all.trn_absensi', $data_absensi);
				}
			}

			$data_dok = array(
				'tdk_masuk_h_id'=> $tdk_masuk_h_id,
				'is_posting'	=> '1',
				'pic_posting' 	=> $this->input->post('biodata_id'),
				'tgl_posting'	=> date('Y-m-d'),
			);
			$this->hrd->set($data_dok);
			$this->hrd->where('tdk_masuk_h_id', $tdk_masuk_h_id);
			$this->hrd->update('hrd_all.trn_tidak_masuk_h');

			$app3 = array(
				'no_dok'			=> $no_doc,
				'pic_koreksi' 		=> $nip,
				'tgl_koreksi'		=> date('Y-m-d'),
			);
			$this->hrd->set($app3);
			$this->hrd->insert('hrd_all.trn_app_3rd');

		}else{

			$data_dok2 = array(
				'tdk_masuk_h_id'	=> $tdk_masuk_h_id,
				'is_posting'		=> '1',
				'pic_input' 		=> $nip,
				'tgl_input'			=> date('Y-m-d'),
			);
			$this->hrd->set($data_dok2);
			$this->hrd->where('tdk_masuk_h_id', $tdk_masuk_h_id);
			$this->hrd->update('hrd_all.trn_tidak_masuk_h');

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
		}

		$sno_doc        = $this->input->post('no_doc');
		return ($sno_doc) ? $sno_doc : false;
	}

	public function VerifikasiAction()
	{
		$biodata_id 		= $this->input->post('biodata_id');
		$tdk_masuk_h_id 	= $this->input->post('tdk_masuk_h_id');
		$sno_doc        	= $this->input->post('no_doc');
		$sel_dok 			= $this->getHeaderDataV($tdk_masuk_h_id);
		$urutan_approval 	= $sel_dok['urutan_approval'];
		$count				= $sel_dok['jml_app'];
		$kode_abesensi		= $sel_dok['kode_status_absensi'];
		$nip 				= $this->session->userdata('nama_login');
		$sql_pic 			= $this->getDataPicDewaHrd();

		// die(json_encode($sno_doc));

		if($nip==$sql_pic['nip']){
			// die(json_encode($biodata_id));
			$tdk_masuk_h_id 	= $this->input->post('tdk_masuk_h_id');
			$log_absen = array();
			$count_absen =  count($this->input->post('tgl_tdk_masuk'));
			//Looping Hari & Tanggal
			for($x = 0; $x < $count_absen; $x++) {
				$tgl_absen = $this->input->post('tgl_tdk_masuk')[$x];
				// die(json_encode($tgl_absen));

				$cek_absen = $this->getDataAbsensi($biodata_id,$tgl_absen);
				// die(json_encode($cek_absen));

				if($tgl_absen == $cek_absen['tgl_absensi']){
					$data_absensi = array(
						'gol_absensi_d_id'			=> $this->input->post('gol_absensi_d_id'),
						'no_trn_absen'  			=> $this->input->post('no_doc'),
						'no_reff'  					=> $this->input->post('no_doc'),
						'status_absen'  			=> $sel_dok['kode_status_absensi'],
						'is_manual'  				=> '1',
						'keterangan'  				=> $sel_dok['kode_status_absensi'],
						'keterangan2'  				=> $sel_dok['keterangan']
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
						'status_absen'  			=> $sel_dok['kode_status_absensi'],
						'keterangan'  				=> $sel_dok['kode_status_absensi'],
						'keterangan2'  				=> $sel_dok['keterangan'],
						'is_manual'  				=> '1',
						'tgl_absensi'				=> $this->input->post('tgl_tdk_masuk')[$x],
						'pic_input'					=> $this->session->userdata('nama_login'),
						'wkt_input'					=> date('Y-m-d')
					);
					array_push($log_absen,$data_absensi);
					$this->hrd->insert('hrd_all.trn_absensi', $data_absensi);

				}
				// die(json_encode($data_absensi));
			}
			$data_dok2 = array(
				'tdk_masuk_h_id'	=> $tdk_masuk_h_id,
				'is_hrd'			=> 'Y',
				'pic_input' 		=> $nip,
				'tgl_input'			=> date('Y-m-d'),
			);
			// die(json_encode($data_dok2));
			$this->hrd->set($data_dok2);
			$this->hrd->where('tdk_masuk_h_id', $tdk_masuk_h_id);
			$this->hrd->update('hrd_all.trn_tidak_masuk_h');

			$app3 = array(
				'no_dok'			=> $tdk_masuk_h_id,
				'pic_koreksi' 		=> $nip,
				'tgl_koreksi'		=> date('Y-m-d H:i:s'),
			);
			// die(json_encode($app3));
			$this->hrd->set($app3);
			$this->hrd->insert('hrd_all.trn_app_3rd');
		}
		return ($sno_doc) ? $sno_doc : false;
	}

	public function tolakHeader($h_id,$pic,$ket)
	{
		$date= date('Y-m-d');
		$sql =	"UPDATE hrd_all.trn_tidak_masuk_h
				SET is_batal = 1,is_posting = 1, tgl_batal= '$date', pic_batal = '$pic',ket_batal='$ket'
				WHERE tdk_masuk_h_id = '$h_id'";
		$query = $this->hrd->query($sql);
		// print($query);die;
		return $query;
	}

	public function rejectApp($h_id,$pic,$nip,$ket)
	{
		$sel_dok 			= $this->getHeaderData($h_id);
		$urutan_approval 	= $sel_dok['urutan_approval'];
		$count				= $sel_dok['jml_app'];
		// die(json_encode($count));
		if($urutan_approval==$count){
			$data_header = array(
				'is_batal'				=> 1,
				'tgl_batal'				=> date('Y-m-d'),
				'pic_batal'				=> $nip,
				'ket_batal'				=> $ket
			);
			// die(json_encode($data_header));
			$this->hrd->set($data_header);
			$this->hrd->where('tdk_masuk_h_id', $h_id);
			$this->hrd->update('hrd_all.trn_tidak_masuk_h');
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
				'is_batal'				=> 1,
				'tgl_batal'				=> date('Y-m-d'),
				'pic_batal'				=> $nip,
				'ket_batal'				=> $ket
			);
			// die(json_encode($data_header));
			$this->hrd->set($data_header);
			$this->hrd->where('tdk_masuk_h_id', $h_id);
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
			$this->hrd->where('tdk_masuk_h_id', $h_id);
			$this->hrd->update('hrd_all.trn_posting');
		}

		return  $h_id;
	}

	public function getHariLibur()
	{
		$sql = "SELECT tgl_libur as dates FROM hrd_all.mst_hari_libur WHERE aktif =1 ";
		$query 	= $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return 	$query->result_array();
	}

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
						'judul' 		=> 'Keterlambatan',
						'nama_user'		=> $this->session->userdata('nama_karyawan'),
						'nip'			=> $this->session->userdata('nama_login'),
						'header_data'	=> $data_header,
						'detail_data'	=> $log_detail,
						'email_from'	=> $this->config->item('smtp_user'),
						'email_to'		=> $pic_app['email'],
						'divisi'		=> $biodata['nama_dept'],
				);

        $subject = 'Pengajuan '.$data['judul'].' -'.$data_header['no_dok_tdk_masuk'].' - '.$data['nama_user'];
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

		$header_data 		= $this->Model_terlambat->getHeaderDataBC($tdk_masuk_h_id);
		$urutan_app 		= '2';
		$result['header'] 	= $header_data;

		// die(json_encode($header_data));

		$biodata_id 		= $header_data['biodata_id'];
		$biodata 			= $this->Model_leave->get_email_pic($biodata_id);

		$pic_app 			= $this->Model_leave->get_email_app($biodata_id, $urutan_app);

		$data = array(	'judul' 		=> 'Keterlambatan',
						'nama_user'		=> $biodata['nama_lengkap'],
						'nip'			=> $biodata['nip'],
						'divisi'		=> $biodata['nama_dept'],
						'mailto'		=> $pic_app['email']
					);
		$detail_item = $this->Model_terlambat->getDetailData($header_data['tdk_masuk_h_id']);

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

/*** Manage Action  ***/

}




