<?php

class Model_cuti_tambahan extends CI_Model
{
	private $hrd;
	private $masaCutiTambahan;
	function __construct()
	{
		parent::__construct();
		$this->hrd = $this->load->database('hrd',TRUE);
	}


#-- GET DATA
	public function getDetailPosting($no_dok_h)
	{
			$sql = "SELECT a.*
				FROM hrd_all.trn_posting a
				WHERE a.tdk_masuk_h_id = '$no_dok_h'
			";
			$query = $this->hrd->query($sql);
			// die(nl2br($this->hrd->last_query()));
			return $query->row_array();
	}

	public function check_unique_tgl($nip, $tgl_awal)
	{
		$sql = "SELECT * FROM hrd_all.trn_pengajuan_cuti_tambahan a
		LEFT JOIN hrd_all.trn_posting b
		ON a.no_doc=b.tdk_masuk_h_id
		WHERE nip= '$nip'
		AND tgl_awal= '$tgl_awal'
		AND status_dokumen <>'R'";

		$jum=$this->hrd->query($sql);
		// die($this->hrd->last_query());
		return $jum->num_rows();
	}

	public function getHeaderDataBC($no_dok_h = null)
	{
		if($no_dok_h) {
			$sql = "SELECT a.*, d.nama_lengkap, d.biodata_id
			FROM hrd_all.trn_pengajuan_cuti_tambahan a
			LEFT JOIN hrd_all.mst_biodata d ON a.nip = d.nip
			WHERE a.no_doc = ?";
			$query = $this->hrd->query($sql, array($no_dok_h));
			// die(nl2br($this->hrd->last_query()));
			return $query->row_array();
		}
		$sql = "SELECT * FROM hrd_all.trn_pengajuan_cuti_tambahan ORDER BY no_doc DESC";
		$query = $this->hrd->query($sql);
		return $query->result_array();
	}

	public function getHeaderData($no_dok_h = null)
	{
		// Revisi 12/10/2022
		$nips 				= $this->session->userdata('nama_login');
		$sql_pic 			= $this->getDataPicDewaDir();

		// tesx($nips, $sql_pic);
		if($nips=$sql_pic['nip']){
			if($no_dok_h) {
				$nip = $this->session->userdata('nama_login');
				$sql = "SELECT
				d.*,tgl_awal+INTERVAL '6' MONTH tgl_akhir,tgl_awal+INTERVAL '1' DAY tgl_lintas,jam_masuk, jam_keluar,
				a.urutan_app urutan_approval, nip_approval, b.nama_lengkap,nip_user nip, c.nama_lengkap, d.no_doc, d.tgl_doc,e.status, g.nama_dept nama
				FROM hrd_all.trn_app_cp a
				LEFT JOIN hrd_all.mst_biodata b ON a.nip_approval = b.nip
				LEFT JOIN hrd_all.mst_biodata c ON a.nip_user = c.nip
				LEFT JOIN hrd_all.trn_pengajuan_cuti_tambahan d ON a.nip_user = d.nip
				LEFT JOIN hrd_all.trn_posting e ON d.no_doc = e.tdk_masuk_h_id
				LEFT JOIN hrd_all.biodata_pekerjaan_d f ON c.biodata_id = f.biodata_id
				LEFT JOIN hrd_all.mst_dept g ON f.dept_id = g.dept_id
				LEFT JOIN hrd_all.trn_absensi ab ON ab.biodata_id=c.biodata_id AND tgl_absensi=tgl_awal
				WHERE d.no_doc='$no_dok_h' AND b.nip = '$nips' AND e.status_dokumen <>'R'
				AND IFNULL(is_hrd,'')='' AND IFNULL(is_ditolak,'')='' ";
				$query = $this->hrd->query($sql, array($no_dok_h));
				// die(nl2br($this->hrd->last_query()));
				return $query->row_array();
			}

			// if($no_dok_h) {
				// 	$nip = $this->session->userdata('nama_login');
				// 	$sql = 'SELECT a.*, jml_app
				// 		, d.nip,d.nama_lengkap,e.biodata_id
				// 		, e.nip, e.nama_lengkap
				// 		, f.*,tgl_awal+INTERVAL "6" MONTH tgl_akhir
				// 		,tgl_awal+INTERVAL "1" DAY tgl_lintas
				// 		, g.status
				// 		, h.nama,jam_masuk, jam_keluar,
				// 		CASE WHEN g.status = 0 THEN "OPEN"
				// 		WHEN g.status = 1 THEN "PENDING"
				// 		END st
				// 		FROM hrd_web_master.mst_user_approval_detail a
				// 		LEFT JOIN hrd_web_master.mst_karyawan_01 b ON a.karyawan_id = b.karyawan_id
				// 		LEFT JOIN hrd_web_master.mst_karyawan_01 c ON a.approved_user = c.karyawan_id
				// 		LEFT JOIN hrd_all.mst_biodata d ON b.biodata = d.biodata_id
				// 		LEFT JOIN hrd_all.mst_biodata e ON c.biodata = e.biodata_id
				// 		LEFT JOIN hrd_all.trn_pengajuan_cuti_tambahan f ON e.nip = f.nip
				// 		LEFT JOIN hrd_all.trn_posting g ON f.no_doc = g.tdk_masuk_h_id
				// 		LEFT JOIN hrd_web_master.mst_departemen h ON a.dept_user = h.hash
				// 		LEFT JOIN
				// 		(SELECT  a.approved_user, COUNT(a.karyawan_id)jml_app FROM hrd_web_master.mst_user_approval_detail a
				// 		LEFT JOIN hrd_web_master.mst_karyawan_01 b ON a.karyawan_id=b.karyawan_id
				// 		GROUP BY a.approved_user) i ON a.approved_user=i.approved_user
				// 		LEFT JOIN hrd_all.trn_absensi ab ON ab.biodata_id=e.biodata_id AND tgl_absensi=tgl_awal
				// 		WHERE f.no_doc = ?
				// 		AND d.nip="'.$nip.'" AND YEAR(tgl_doc)>="2021"
				// 		AND IFNULL(is_hrd,"")="" AND IFNULL(is_ditolak,"")=""

				// 		ORDER BY e.nip, f.tgl_doc'
				// 	;
				// 	// AND urutan_approval = g.status+1
				// 	$query = $this->hrd->query($sql, array($no_dok_h));
				// 	// die(nl2br($this->hrd->last_query()));
				// 	return $query->row_array();
			// }
			$sql = "SELECT * FROM hrd_all.trn_pengajuan_cuti_tambahan ORDER BY no_doc DESC";
			$query = $this->hrd->query($sql);
			return $query->result_array();
		}else{
			$sql = 'SELECT a.*, jml_app
				, d.nip,d.nama_lengkap,e.biodata_id
				, e.nip, e.nama_lengkap
				, f.*,tgl_awal+INTERVAL "6" MONTH tgl_akhir
				,tgl_awal+INTERVAL "1" DAY tgl_lintas
				, g.status
				, h.nama,jam_masuk, jam_keluar,
				CASE WHEN g.status = 0 THEN "OPEN"
				WHEN g.status = 1 THEN "PENDING"
				END st
				FROM hrd_web_master.mst_user_approval_detail a
				LEFT JOIN hrd_web_master.mst_karyawan_01 b ON a.karyawan_id = b.karyawan_id
				LEFT JOIN hrd_web_master.mst_karyawan_01 c ON a.approved_user = c.karyawan_id
				LEFT JOIN hrd_all.mst_biodata d ON b.biodata = d.biodata_id
				LEFT JOIN hrd_all.mst_biodata e ON c.biodata = e.biodata_id
				LEFT JOIN hrd_all.trn_pengajuan_cuti_tambahan f ON e.nip = f.nip
				LEFT JOIN hrd_all.trn_posting g ON f.no_doc = g.tdk_masuk_h_id
				LEFT JOIN hrd_web_master.mst_departemen h ON a.dept_user = h.hash
				LEFT JOIN
				(SELECT  a.approved_user, COUNT(a.karyawan_id)jml_app FROM hrd_web_master.mst_user_approval_detail a
				LEFT JOIN hrd_web_master.mst_karyawan_01 b ON a.karyawan_id=b.karyawan_id
				GROUP BY a.approved_user) i ON a.approved_user=i.approved_user
				LEFT JOIN hrd_all.trn_absensi ab ON ab.biodata_id=e.biodata_id AND tgl_absensi=tgl_awal
				WHERE f.no_doc = "'.$no_dok_h.'"
				AND d.nip="'.$nips.'" AND YEAR(tgl_doc)>="2021"
				AND IFNULL(is_hrd,"")="" AND IFNULL(is_ditolak,"")=""
				AND urutan_approval = g.status+1
				UNION ALL
				SELECT a.*, jml_app
				, d.nip,d.nama_lengkap,e.biodata_id
				, e.nip, e.nama_lengkap
				, f.*
				,tgl_awal+INTERVAL "6" MONTH tgl_akhir
				,tgl_awal+INTERVAL "1" DAY tgl_lintas
				, g.status
				, h.nama,jam_masuk, jam_keluar,
				CASE WHEN g.status = 0 THEN "OPEN"
				WHEN g.status = 1 THEN "PENDING"
				END st
				FROM hrd_web_master.mst_user_approval_detail a
				LEFT JOIN hrd_web_master.mst_karyawan_01 b ON a.karyawan_id = b.karyawan_id
				LEFT JOIN hrd_web_master.mst_karyawan_01 c ON a.approved_user = c.karyawan_id
				LEFT JOIN hrd_all.mst_biodata d ON b.biodata = d.biodata_id
				LEFT JOIN hrd_all.mst_biodata e ON c.biodata = e.biodata_id
				LEFT JOIN hrd_all.trn_pengajuan_cuti_tambahan f ON e.nip = f.nip
				LEFT JOIN hrd_all.trn_posting g ON f.no_doc = g.tdk_masuk_h_id
				LEFT JOIN hrd_web_master.mst_departemen h ON a.dept_user = h.hash
				LEFT JOIN
				(SELECT a.approved_user, COUNT(a.karyawan_id)jml_app FROM hrd_web_master.mst_user_approval_detail a
				LEFT JOIN hrd_web_master.mst_karyawan_01 b ON a.karyawan_id=b.karyawan_id
				GROUP BY a.approved_user) i ON a.approved_user=i.approved_user
				LEFT JOIN hrd_all.trn_absensi ab ON ab.biodata_id=e.biodata_id AND tgl_absensi=tgl_awal
				WHERE f.no_doc = "'.$no_dok_h.'"
				AND YEAR(tgl_doc)>="2021"
				AND IFNULL(is_hrd,"")=""
				GROUP BY approved_user
			';
			// AND is_dept="Y"
			// 	AND IFNULL(is_ditolak,"")=""
			$query = $this->hrd->query($sql);
			// die($this->hrd->last_query());
			return $query->row_array();

		}
	}

	public function getDataByNoDoc($no_doc)
	{
		$hasil=$this->hrd->query('select * from hrd_all.trn_pengajuan_cuti_tambahan where no_doc="'.$no_doc.'"');

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

	public function getNoDocs($docCode,$date)
	{
		$sno_doc = $docCode.$date;

		$hasil=$this->hrd->query("SELECT RIGHT(no_doc,4)+1 as gencode FROM hrd_all.trn_pengajuan_cuti_tambahan
		WHERE no_doc LIKE '".$sno_doc."%' ORDER BY no_doc DESC");
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

	public function getPengajuanCutiTambahanbyNoDoc()
	{
		$sql = "SELECT a.no_doc,a.nip,b.nama_lengkap,a.tgl_awal,
					DATE_ADD(a.tgl_awal,INTERVAL 6 MONTH) tgl_akhir,
					a.jml_hari,a.tgl_doc,a.keterangan
				FROM hrd_all.trn_pengajuan_cuti_tambahan a
				JOIN hrd_all.mst_biodata b ON a.nip=b.nip";
		$query 	= $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return 	$query->row_array();
	}

	public function getDataPicDewaDir()
	{
		$nip 				= $this->session->userdata('nama_login');
		$sql = "SELECT * FROM hrd_all.trn_pic_dewa WHERE nip='$nip' AND LEVEL =1";
		$query = $this->hrd->query($sql);
		return $query->row_array();
	}

	public function getAbsenMasuk($tgl=null,$biodataid, $nip)
	{
		if($tgl){
			$sql ="SELECT * FROM(
				SELECT * FROM (
				SELECT * FROM(
				SELECT checktime jm FROM hrd_all.inoutdata_hist WHERE nip='$nip' AND checkdate='$tgl' AND checktype=1 ORDER BY checktime ASC LIMIT 1)a
				UNION ALL
				SELECT jam_masuk jm FROM trn_absensi WHERE biodata_id='$biodataid' AND tgl_absensi='$tgl'
				)a ORDER BY jm ASC ) a LIMIT 1";
			$query = $this->hrd->query($sql, array($tgl));
			// die($this->hrd->last_query());
			return $query;
		}
		$sql = "SELECT * FROM hrd_all.trn_absensi ";
		$query = $this->hrd->query($sql);
		return $query->result_array();
	}

	public function getAbsenKeluar($tgl=null,$biodataid,$nip)
	{
		if($tgl){
			$sql 	=	" SELECT *
				FROM(
				SELECT * FROM(
					SELECT * FROM(
						SELECT checktype,checktime jk FROM hrd_all.inoutdata_hist WHERE nip='$nip' AND checkdate =DATE_ADD('$tgl', INTERVAL '1' DAY) AND checktype=4 ORDER BY checktime DESC LIMIT 1
					)a
					UNION ALL
					SELECT * FROM(
					SELECT checktype,checktime jk FROM hrd_all.inoutdata_hist WHERE nip='$nip' AND checkdate='$tgl' AND checktype=2 ORDER BY checktime DESC LIMIT 1
					)b
					UNION ALL
					SELECT 0 checktype,jam_keluar jk FROM trn_absensi WHERE biodata_id='$biodataid' AND tgl_absensi='$tgl'
					)c

				)c
				ORDER BY checktype
				LIMIT 1
			";
			$query = $this->hrd->query($sql, array($tgl));
			// die($this->hrd->last_query());
			return $query;
		}
		$sql = "SELECT * FROM hrd_all.trn_absensi ";
		$query = $this->hrd->query($sql);
		return $query->result_array();
	}

	public function getJumlahJam($biodata_id)
	{
		$sql = "SELECT a.biodata_id, nama_lengkap, jam_masuk, jam_keluar, a.keterangan 
		,SUBTIME(TIME(jam_keluar),TIME(jam_masuk))selisih
		FROM hrd_all.trn_absensi a
		LEFT JOIN hrd_all.mst_biodata b ON a.biodata_id = b.biodata_id
		WHERE tgl_absensi = '2021-09-21' AND a.biodata_id='$biodata_id'";
	}

	public function getTglJamMasuk($nip, $tgl_masuk)
	{
		// $sql = "SELECT checkdate tgl_masuk, checktime jam_masuk
		// 	FROM hrd_all.inoutdata_hist
		// 	WHERE nip='$nip' AND checkdate='$tgl_masuk'
		// 	AND checktype=1 ORDER BY checktime ASC LIMIT 1
		// 	";

		$sql = "SELECT checkdate tgl_masuk, checktime jam_masuk
						FROM hrd_all.inoutdata_hist
						WHERE nip='$nip' AND checkdate='$tgl_masuk'
						AND checktype=1
				UNION ALL
					SELECT tgl_absensi, jam_masuk
					FROM hrd_all.trn_absensi
					WHERE tgl_absensi='$tgl_masuk'
					AND biodata_id = (SELECT biodata_id FROM hrd_all.mst_biodata WHERE nip='$nip')
				LIMIT 1";
		$jum 	= $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return $jum->row_array();
	}

	public function getTglJamKeluar($nip, $tgl_keluar)
	{
		// $sql= "SELECT checkdate tgl_keluar, checktime jam_keluar
		// 	FROM hrd_all.inoutdata_hist
		// 	WHERE nip='$nip' AND checkdate='$tgl_keluar'
		// 	AND checktype=2 ORDER BY checktime DESC LIMIT 1
		// 	";

		$sql = "SELECT checkdate tgl_masuk, checktime jam_masuk
						FROM hrd_all.inoutdata_hist
						WHERE nip='$nip' AND checkdate='$tgl_keluar'
						AND checktype=2
				UNION ALL
					SELECT tgl_absensi, jam_masuk
					FROM hrd_all.trn_absensi
					WHERE tgl_absensi='$tgl_keluar'
					AND biodata_id = (SELECT biodata_id FROM hrd_all.mst_biodata WHERE nip='$nip')
				LIMIT 1";
		$jum 	= $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return $jum->row_array();
	}

	public function getTglJamLintas($nip, $tgl_lintas)
	{
		$sql= "SELECT checkdate tgl_keluar, checktime jam_keluar
			FROM hrd_all.inoutdata_hist
			WHERE nip='$nip' AND checkdate='$tgl_lintas'
			AND checktype=4 ORDER BY checktime DESC LIMIT 1";
		$jum 	= $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return $jum->row_array();
	}

	public function rejectData($biodata_rej)
	{
		$sql = "SELECT COUNT(*)jml FROM hrd_all.trn_posting a
			LEFT JOIN hrd_all.trn_tidak_masuk_h b
			ON a.tdk_masuk_h_id = b.tdk_masuk_h_id
			WHERE biodata_id = ?
			AND status_dokumen ='R' AND no_dok_tdk_masuk LIKE 'HRC%'
			AND YEAR(tgl_dok_tdk_masuk)=YEAR(NOW())";
		$query = $this->hrd->query($sql, array($biodata_rej));
		// die(nl2br($this->hrd->last_query()));
		return $query->row_array();
	}

	public function getCekOvertime($biodataid, $tgl)
	{
		$this->hrd->select('a.tgl_absensi, a.no_reff no_dokumen');
		$this->hrd->from('hrd_all.trn_absensi a');
		$this->hrd->join('hrd_all.trn_posting b' ,'a.no_reff = b.tdk_masuk_h_id','LEFT');
		$this->hrd->where('a.biodata_id' , $biodataid);
		$this->hrd->where('a.tgl_absensi' , $tgl);
		$this->hrd->where('b.status_dokumen' , 'C');
		$query 	= $this->hrd->get();
		// die(nl2br($this->hrd->last_query()));
		return 	$query->row_array();
	}

	public function getDataPic()
	{
		$nip 				= $this->session->userdata('nama_login');
		$sql = "SELECT * FROM hrd_all.trn_pic_dewa WHERE nip='$nip' AND LEVEL =1";
		$query = $this->hrd->query($sql);
		return $query->row_array();
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

	public function count_nip($biodata_id)
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

#-- GET DATA

#-- ACTION

	public function create()
	{
		$nip 	= $this->session->userdata('nama_login');
		$biodata= $this->hrd->select('biodata_id')
					->get_where('hrd_all.mst_biodata',array('nip' => $nip))->row_array();

		$data = array(
			'no_doc'  	=> $this->input->post('no_doc'),
			'tgl_doc' 	=> $this->input->post('tgl_doc'),
			'nip'    	=> $this->input->post('nip'),
			'jml_hari'	=> $this->input->post('jml_hari'),
			'tgl_awal' 	=> $this->input->post('tgl_awal'),
			'keterangan'=> $this->input->post('keterangan'),
			'pic_input' => $biodata['biodata_id'],
		);
		$insert = $this->hrd->insert('hrd_all.trn_pengajuan_cuti_tambahan', $data);

		$data_posting = array(
			'tdk_masuk_h_id'	=> $data['no_doc'],
			'status' 			=> '0',
			'status_dokumen' 	=> 'O'
		);
		$this->hrd->set($data_posting);
		$this->hrd->insert('hrd_all.trn_posting');

		// $this->send_mail_create($data);

		// tesx($data, $data_posting);

		$sno_doc = $data['no_doc'];
		return ($sno_doc) ? $sno_doc : false;
	}

	public function ApproveAction()
	{
		$biodata_id 		=$this->input->post('biodata_id');
		$no_doc 			=$this->input->post('no_doc');

		$getDoc				= $this->getHeaderData($no_doc);

		$tgl_cuti 			= $this->input->post('tgl_mulai_cuti');
		$nip 				= $this->session->userdata('nama_login');

		$nip_app 			= $this->session->userdata('nama_login');
		$biodata 			= $this->hrd->select('nip')
								->get_where('hrd_all.mst_biodata',array('biodata_id' => $biodata_id))->row_array();

		$get_nip_user		= $getDoc['pic_input'];
		$biodata_user		= $this->hrd->select('nip')
								->get_where('hrd_all.mst_biodata',array('biodata_id' => $get_nip_user))->row_array();
		$nip_user			= $getDoc['nip'];
		$biodataids			= $getDoc['pic_input'];

		$sql_pic 			= $this->getDataPic();

		$getUrutan			= $this->getUrutanApp($nip_app,$nip_user);
		$getCount			= $this->count_nip($biodataids);
		$count				= $getCount;
		$urutan_approval 	= $getUrutan['urutan_approval'];


		// tesx($urutan_approval, $count,$nip_user, $nip_app, $biodataids,$getDoc);
		if($urutan_approval==$count){

			$uuid_d = $this->uuid->v4();
			$update_saldo = array(
				'saldo_cuti_tambahan_id'	=> $uuid_d,
				'biodata_id'				=> $getDoc['pic_input'],
				'no_dok_cuti_tambahan' 		=> $getDoc['no_doc'],
				'tgl_dok_cuti_tambahan' 	=> $getDoc['tgl_doc'],
				'saldo_tambahan' 			=> $getDoc['jml_hari'],
				'saldo_awal' 				=> 0,
				'sisa_cuti' 				=> $getDoc['jml_hari'],
				'tgl_mulai_berlaku' 		=> $getDoc['tgl_awal'],
				'tgl_akhir_berlaku' 		=> $getDoc['tgl_akhir'],
				'keterangan' 				=> $getDoc['keterangan'],
				'pic_input' 				=> $getDoc['pic_input'],
				'tgl_input'					=> date('Y-m-d'),
			);
			$this->hrd->insert('hrd_all.trn_saldo_cuti_tambahan',$update_saldo);
			// tesx($update_saldo);
			$data_dok = array(
				'is_hrd'			=> '1',
				'is_dept'			=> '1',
			);
			$this->hrd->set($data_dok);
			$this->hrd->where('no_doc', $no_doc);
			$this->hrd->update('hrd_all.trn_pengajuan_cuti_tambahan');

			$app3 = array(
				'no_dok'			=> $no_doc,
				'pic_koreksi' 		=> $nip,
				'tgl_koreksi'		=> date('Y-m-d h:i:s'),
			);
			$this->hrd->set($app3);
			$this->hrd->insert('hrd_all.trn_app_3rd');

			$data_posting = array(
				'app_'.$urutan_approval			=> $nip,
				'tgl_app_'.$urutan_approval 	=> date('Y-m-d'),
				'status'						=> $urutan_approval,
				'status_dokumen' 				=> 'C'
			);
			$this->hrd->set($data_posting);
			$this->hrd->where('tdk_masuk_h_id', $no_doc);
			$this->hrd->update('hrd_all.trn_posting');

			// tesx($update_saldo, $data_dok2, $app3);
		} else {

			# Update Data Doc APP 1/2
			if($urutan_approval=='2'){
				$is_dept	= '1';
			}else{
				$is_dept	= '0';
			}

			$data_dok = array(
				'is_dept'	=> $is_dept,
			);
			$this->hrd->set($data_dok);
			$this->hrd->where('no_doc', $no_doc);
			$this->hrd->update('hrd_all.trn_pengajuan_cuti_tambahan');

			$data_posting = array(
				'app_'.$urutan_approval			=> $nip,
				'tgl_app_'.$urutan_approval 	=> date('Y-m-d'),
				'status' 						=> $urutan_approval,
				'status_dokumen' 				=> 'P'
			);
			$this->hrd->set($data_posting);
			$this->hrd->where('tdk_masuk_h_id', $no_doc);
			$this->hrd->update('hrd_all.trn_posting');
			// tesx($data_dok, $data_posting);
		}


		if($urutan_approval != $count){
			$no_doc =$this->input->post('no_doc');
			$this->send_mail_approve($no_doc, $urutan_approval);
		}

		$sno_doc        = $no_doc;
		return ($sno_doc) ? $sno_doc : false;
	}

	public function rejectApp($no_dok_h,$pic,$nip,$ket)
	{
		$sel_dok 			= $this->getHeaderData($no_dok_h);
		$biodata_id 		= $sel_dok['biodata_id'];
		$no_doc 			= $no_dok_h;

		#---- Approval
			$getDoc				= $this->getHeaderDataBC($no_doc);

			$nip_app 			= $this->session->userdata('nama_login');
			$nip_user			= $getDoc['nip'];
			$biodataids			= $getDoc['biodata_id'];


			$getUrutan			= $this->getUrutanApp($nip_app,$nip_user);
			$urutan_approval 	= $getUrutan['urutan_approval'];
			$count				= $this->count_nip($biodataids);

		#---- Approval

		// tesx($urutan_approval, $nip_app, $nip_user);

		$data_header = array(
			'is_ditolak'			=> 1,
			'tgl_tolak'				=> date('Y-m-d'),
		);
		$this->hrd->set($data_header);
		$this->hrd->where('no_doc', $no_dok_h);
		$this->hrd->update('hrd_all.trn_pengajuan_cuti_tambahan');


		$data_posting = array(
			'rej_'.$urutan_approval.''				=> $nip,
			'tgl_rej_'.$urutan_approval.'' 			=> date('Y-m-d h:i:s'),
			'status' 								=> $urutan_approval,
			'status_dokumen' 						=> 'R',
			'rej_komentar_'.$urutan_approval.'' 	=> $ket,
		);
		$this->hrd->set($data_posting);
		$this->hrd->where('tdk_masuk_h_id', $no_dok_h);
		$this->hrd->update('hrd_all.trn_posting');

		// tesx($data_header,$data_posting);

		return  $no_dok_h;
	}

#-- ACTION

#-- DATATABLES
	public function getPengajuanCutiTambahanAll1($no, $search_no,$length,$start,$column,$order)
	{
		$sql = "SELECT a.no_doc,a.nip,b.nama_lengkap,a.tgl_awal,
				DATE_ADD(a.tgl_awal,INTERVAL 6 MONTH) tgl_akhir, a.jml_hari,a.tgl_doc,a.keterangan ,c.* ,
				CASE WHEN is_hrd='Y' THEN 'APPROVED'
				WHEN status_dokumen ='O' THEN 'OPEN'
				WHEN status_dokumen = 'P' THEN 'PROCESS'
				WHEN status_dokumen ='R' THEN 'DITOLAK' END st
				FROM hrd_all.trn_pengajuan_cuti_tambahan a
				JOIN hrd_all.mst_biodata b ON a.nip=b.nip
				LEFT JOIN hrd_all.trn_posting c ON a.no_doc = c.tdk_masuk_h_id
				WHERE a.nip='".$no."'
				ORDER BY tgl_doc DESC
				LIMIT $start, $length";
		$query 	= $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return 	$query->result_array();
	}

	public function getPengajuanCutiTambahanAll2($no)
	{
		$sql = "SELECT a.no_doc,a.nip,b.nama_lengkap,a.tgl_awal,
			DATE_ADD(a.tgl_awal,INTERVAL 6 MONTH) tgl_akhir, a.jml_hari,a.tgl_doc,a.keterangan ,c.* ,
			CASE WHEN is_hrd='Y' THEN 'APPROVED'
			WHEN status_dokumen ='O' THEN 'OPEN'
			WHEN status_dokumen = 'P' THEN 'PROCESS'
			WHEN status_dokumen ='R' THEN 'DITOLAK' END st
			FROM hrd_all.trn_pengajuan_cuti_tambahan a
			JOIN hrd_all.mst_biodata b ON a.nip=b.nip
			LEFT JOIN hrd_all.trn_posting c ON a.no_doc = c.tdk_masuk_h_id
			WHERE a.nip='".$no."'";
		$jum=$this->hrd->query($sql);
		// die($this->hrd->last_query());
		return $jum->num_rows();
	}

	public function getApprovalData1($nip , $search_no = "", $length = "", $start = "", $column = "", $order = "")
	{
		$nips 				= $this->session->userdata('nama_login');
		$sql_pic 			= $this->getDataPicDewaDir();

		$sql = "SELECT
			a.urutan_app urutan_approval, nip_approval, b.nama_lengkap,nip_user nip, c.nama_lengkap, d.no_doc, d.tgl_doc,e.status, g.nama_dept nama
			FROM hrd_all.trn_app_cp a
			LEFT JOIN hrd_all.mst_biodata b ON a.nip_approval = b.nip
			LEFT JOIN hrd_all.mst_biodata c ON a.nip_user = c.nip 
			LEFT JOIN hrd_all.trn_pengajuan_cuti_tambahan d ON a.nip_user = d.nip 
			LEFT JOIN hrd_all.trn_posting e ON d.no_doc = e.tdk_masuk_h_id 
			LEFT JOIN hrd_all.biodata_pekerjaan_d f ON c.biodata_id = f.biodata_id
			LEFT JOIN hrd_all.mst_dept g ON f.dept_id = g.dept_id
			WHERE b.nip = '$nips' AND e.status_dokumen <>'R'
			AND IFNULL(is_hrd,'') = ''
			AND urutan_app= e.status+1
			ORDER BY tgl_doc ASC
			LIMIT $start,$length
		";
		$query 	= $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return $query->result_array();

	}

	public function getApprovalData2($nip , $search_no = "")
	{
		$nips 				= $this->session->userdata('nama_login');
		$sql_pic 			= $this->getDataPicDewaDir();

		$sql = "SELECT
			a.urutan_app urutan_approval, nip_approval, b.nama_lengkap,nip_user nip, c.nama_lengkap, d.no_doc, d.tgl_doc,e.status, g.nama_dept nama
			FROM hrd_all.trn_app_cp a
			LEFT JOIN hrd_all.mst_biodata b ON a.nip_approval = b.nip
			LEFT JOIN hrd_all.mst_biodata c ON a.nip_user = c.nip
			LEFT JOIN hrd_all.trn_pengajuan_cuti_tambahan d ON a.nip_user = d.nip
			LEFT JOIN hrd_all.trn_posting e ON d.no_doc = e.tdk_masuk_h_id 
			LEFT JOIN hrd_all.biodata_pekerjaan_d f ON c.biodata_id = f.biodata_id
			LEFT JOIN hrd_all.mst_dept g ON f.dept_id = g.dept_id
			WHERE b.nip = '$nips' AND e.status_dokumen <>'R'
			AND IFNULL(is_hrd,'') = ''
			AND urutan_app= e.status+1";
		$jum 	= $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return $jum->num_rows();

	}

	public function getHistoryCutiPengganti($nip, $search_no = "",$search_nama = "", $length = "", $start = "", $column = "", $order = "")
	{
		$where_search_nama = "";
		if($search_nama !== ""){
			$where_search_nama = "AND nama_lengkap LIKE '%".$search_nama."%'";
		}
		$sql = "SELECT no_doc,tgl_doc,b.nip,nama_lengkap,e.nama_dept,jml_hari,b.keterangan,f.jam_masuk,f.jam_keluar,
				DATE(tgl_app_1) tgl_app_1,status_dokumen ,
				CASE
				WHEN is_hrd = 'Y' THEN 'CLOSED'
				WHEN status_dokumen ='P' THEN 'PROCESS'
				WHEN status_dokumen ='R' THEN 'REJECT' ELSE 'OPEN' END posting
				FROM( SELECT tdk_masuk_h_id,tgl_app_1, status_dokumen,'' kom
					FROM hrd_all.trn_posting WHERE app_1 = '$nip'
					UNION ALL SELECT tdk_masuk_h_id,tgl_app_2, status_dokumen,'' kom
					FROM hrd_all.trn_posting WHERE app_2 = '$nip'
					UNION ALL SELECT tdk_masuk_h_id,tgl_app_3, status_dokumen,'' kom
					FROM hrd_all.trn_posting WHERE app_3 = '$nip'
					UNION ALL SELECT tdk_masuk_h_id,tgl_rej_1, status_dokumen, rej_komentar_1
					FROM hrd_all.trn_posting WHERE rej_1 = '$nip'
					UNION ALL SELECT tdk_masuk_h_id,tgl_rej_2, status_dokumen, rej_komentar_2
					FROM hrd_all.trn_posting WHERE rej_2 = '$nip'
					UNION ALL SELECT tdk_masuk_h_id,tgl_rej_3, status_dokumen, rej_komentar_3
					FROM hrd_all.trn_posting WHERE rej_3 = '$nip')a
				LEFT JOIN hrd_all.trn_pengajuan_cuti_tambahan b ON a.tdk_masuk_h_id = b.no_doc
				LEFT JOIN hrd_all.mst_biodata c ON b.nip = c.nip
				LEFT JOIN hrd_all.biodata_pekerjaan_d d ON c.biodata_id = d.biodata_id
				LEFT JOIN hrd_all.mst_dept e ON d.dept_id = e.dept_id
				LEFT JOIN hrd_all.trn_absensi f ON c.biodata_id =f.biodata_id AND b.tgl_awal= f.tgl_absensi
				WHERE tdk_masuk_h_id LIKE 'HRCT%' $where_search_nama
				ORDER BY no_doc DESC
				LIMIT $start,$length
				";
		$query 	= $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return 	$query->result_array();
	}

	public function getCountHistoryCutiPengganti($nip, $search_no = "",$search_nama = "")
	{
		$where_search_nama = "";
		if($search_nama !== ""){
			$where_search_nama = "AND nama_lengkap LIKE '%".$search_nama."%'";
		}
		$sql = "SELECT no_doc,tgl_doc,b.nip,nama_lengkap,e.nama_dept,jml_hari,b.keterangan,f.jam_masuk,f.jam_keluar,
				DATE(tgl_app_1) tgl_app_1,status_dokumen ,
				CASE
				WHEN is_hrd = 'Y' THEN 'CLOSED'
				WHEN status_dokumen ='P' THEN 'PROCESS'
				WHEN status_dokumen ='R' THEN 'REJECT' ELSE 'OPEN' END posting
				FROM( SELECT tdk_masuk_h_id,tgl_app_1, status_dokumen,'' kom
					FROM hrd_all.trn_posting WHERE app_1 = '$nip'
					UNION ALL SELECT tdk_masuk_h_id,tgl_app_2, status_dokumen,'' kom
					FROM hrd_all.trn_posting WHERE app_2 = '$nip'
					UNION ALL SELECT tdk_masuk_h_id,tgl_app_3, status_dokumen,'' kom
					FROM hrd_all.trn_posting WHERE app_3 = '$nip'
					UNION ALL SELECT tdk_masuk_h_id,tgl_rej_1, status_dokumen, rej_komentar_1
					FROM hrd_all.trn_posting WHERE rej_1 = '$nip'
					UNION ALL SELECT tdk_masuk_h_id,tgl_rej_2, status_dokumen, rej_komentar_2
					FROM hrd_all.trn_posting WHERE rej_2 = '$nip'
					UNION ALL SELECT tdk_masuk_h_id,tgl_rej_3, status_dokumen, rej_komentar_3
					FROM hrd_all.trn_posting WHERE rej_3 = '$nip')a
				LEFT JOIN hrd_all.trn_pengajuan_cuti_tambahan b ON a.tdk_masuk_h_id = b.no_doc
				LEFT JOIN hrd_all.mst_biodata c ON b.nip = c.nip
				LEFT JOIN hrd_all.biodata_pekerjaan_d d ON c.biodata_id = d.biodata_id
				LEFT JOIN hrd_all.mst_dept e ON d.dept_id = e.dept_id
				LEFT JOIN hrd_all.trn_absensi f ON c.biodata_id =f.biodata_id AND b.tgl_awal= f.tgl_absensi
				WHERE tdk_masuk_h_id LIKE 'HRCT%' $where_search_nama
				ORDER BY no_doc DESC";
		$jum 	= $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return $jum->num_rows();
	}
#-- DATATABLES

#-- SEND MAIL

	public function send_mail_create($data_header)
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
						'judul' 		=> 'Cuti Pengganti',
						'nama_user'		=> $this->session->userdata('nama_karyawan'),
						'nip'			=> $this->session->userdata('nama_login'),
						'header_data'	=> $data_header,
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
		$this->email->message($this->load->view('email/cuti_pengganti',$data,true));
		$this->email->send();
		// 	if($this->email->send()){
		// 	echo "Mail Sent ok";
		// 	}else{
		// 	echo "Error";
		// 	}
        // echo json_encode($response);
    }

	public function send_mail_approve($no_doc, $urutan_app )
	{
        $this->load->config('email');
        $this->load->library('email');

		$header_data 		= $this->Model_cuti_tambahan->getHeaderData($no_doc);

		$result['header'] 	= $header_data;

		$biodata_id 		= $header_data['pic_input'];
		$biodata 			= $this->Model_leave->get_email_pic($biodata_id);

		$pic_app 			= $this->Model_leave->get_email_app($biodata_id, $urutan_app);

		$data = array(	'judul' 		=> 'Cuti Pengganti',
						'nama_user'		=> $biodata['nama_lengkap'],
						'nip'			=> $biodata['nip'],
						'divisi'		=> $biodata['nama_dept'],
						// 'jml_app'		=> $header_data['jml_app'],
						// 'mailto'		=> $pic_app['email'],
						'divisi'		=> $biodata['nama_dept'],
					);

		$data['header_data'] = $result;


        $subject 	= 'Pengajuan '.$data['judul'].' - '.$data['nama_user'];
		$to			= $pic_app['email'];
		$from 		= $this->config->item('smtp_user');

        $cc = array(
            // 'rizky.it@optiktunggal.com'
        );

        $this->email->set_newline("\r\n");
        $this->email->from($from);
        $this->email->to($to);
        $this->email->subject($subject);
		$this->email->message($this->load->view('email/cuti_pengganti_approval',$data,true));
		$this->email->send();
    }

#-- SEND MAIL
}
