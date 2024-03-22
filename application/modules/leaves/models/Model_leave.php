<?php

class Model_leave extends CI_Model
{
	private $hrd;
	function __construct()
	{
		parent::__construct();
		$this->load->config('email');
		$this->hrd = $this->load->database('hrd',TRUE);
		$this->hrdsave = $this->load->database('hrd_save',TRUE);
		$this->dbakses = $this->load->database('db_akses',TRUE);
	}



	# --- Approval CP ---
		public function get_app_cp($nip_user,$nip_app)
		{
			$sql = "SELECT a.nip_approval nip_app, b.nama_lengkap nama_app, a.nip_user,
				c.nama_lengkap nama_user, a.urutan_app, a.email
				FROM hrd_all.trn_app_cp a
				LEFT JOIN hrd_all.mst_biodata b ON a.nip_approval = b.nip
				LEFT JOIN hrd_all.mst_biodata c ON a.nip_user = c.nip
				WHERE a.nip_user = '$nip_user'
				AND a.nip_approval = '$nip_app'
			";
			$query = $this->hrd->query($sql);
			// die($this->hrd->last_query());
			return 	$query->row_array();
		}

		public function get_app_cp_detail($nip_user)
		{
			$sql = "SELECT a.nip_approval nip_app, b.nama_lengkap nama_app, a.nip_user,
				c.nama_lengkap nama_user, a.urutan_app,a.urutan_app urutan_approval, a.email
				FROM hrd_all.trn_app_cp a
				LEFT JOIN hrd_all.mst_biodata b ON a.nip_approval = b.nip
				LEFT JOIN hrd_all.mst_biodata c ON a.nip_user = c.nip
				WHERE a.nip_user = '$nip_user'
			";
			$query = $this->hrd->query($sql);
			// die($this->hrd->last_query());
			return 	$query->result_array();
		}

		public function get_app_cp_urutan($nip_user,$urutan)
		{
			$sql = "SELECT a.nip_approval nip_app, b.nama_lengkap nama_app, a.nip_user,
				c.nama_lengkap nama_user, a.urutan_app, a.email
				FROM hrd_all.trn_app_cp a
				LEFT JOIN hrd_all.mst_biodata b ON a.nip_approval = b.nip
				LEFT JOIN hrd_all.mst_biodata c ON a.nip_user = c.nip
				WHERE a.nip_user = '$nip_user'
				AND a.urutan_app = '$urutan'
			";
			$query = $this->hrd->query($sql);
			// die($this->hrd->last_query());
			return 	$query->row_array();
		}

		public function get_app_cp_count($nip_user)
		{
			$sql = "SELECT a.nip_approval nip_app, b.nama_lengkap nama_app, a.nip_user,
				c.nama_lengkap nama_user, a.urutan_app, a.email
				FROM hrd_all.trn_app_cp a
				LEFT JOIN hrd_all.mst_biodata b ON a.nip_approval = b.nip
				LEFT JOIN hrd_all.mst_biodata c ON a.nip_user = c.nip
				WHERE a.nip_user = '$nip_user'
				GROUP BY urutan_approval
			";
			$query = $this->hrd->query($sql);
			// die($this->hrd->last_query());
			return 	$query->num_rows();
		}
	# --- Approval CP ---


	# --- Approval CUTI ---
		public function get_app_cuti($nip_user,$nip_app){
			$sql = "SELECT e.biodata_id,e.nip, e.nama_lengkap,
				c.biodata_id,c.nip,c.nama_lengkap, urutan_approval, f.email
				FROM hrd_web_master.mst_user_approval_detail a
				LEFT JOIN hrd_web_master.mst_karyawan_01 b ON a.karyawan_id=b.karyawan_id
				LEFT JOIN hrd_all.mst_biodata c ON b.biodata=c.biodata_id
				LEFT JOIN hrd_web_master.mst_karyawan_01 d ON a.approved_user=d.karyawan_id
				LEFT JOIN hrd_all.mst_biodata e ON d.biodata=e.biodata_id
				LEFT JOIN hrd_web_master.mst_pic_app f ON c.nip = f.nip
				WHERE e.nip = '$nip_user'
				AND c.nip = '$nip_app'
				";
			$query = $this->hrd->query($sql);
			// die($this->hrd->last_query());
			return 	$query->row_array();
		}

		public function get_app_cuti_detail($biodata_id)
		{
			$sql = "SELECT e.biodata_id id, e.nip nip, e.nama_lengkap nama, d.biodata_id id_app, d.nip nip_app, d.nama_lengkap nama_app, a.urutan_approval
				FROM  hrd_web_master.mst_user_approval_detail a
				LEFT JOIN hrd_web_master.mst_karyawan_01 b ON a.karyawan_id = b.karyawan_id
				LEFT JOIN hrd_web_master.mst_karyawan_01 c ON a.approved_user = c.karyawan_id
				LEFT JOIN hrd_all.mst_biodata d ON b.biodata = d.biodata_id
				LEFT JOIN hrd_all.mst_biodata e ON c.biodata = e.biodata_id
				WHERE e.biodata_id='$biodata_id'
				GROUP BY urutan_approval";
			$query = $this->hrd->query($sql);
			// die($this->hrd->last_query());
			return $query->result_array();
		}

		public function get_app_cuti_urutan($nip_user,$urutan_app){
			$sql = "SELECT e.biodata_id,e.nip, e.nama_lengkap,
				c.biodata_id,c.nip,c.nama_lengkap, urutan_approval, f.email
				FROM hrd_web_master.mst_user_approval_detail a
				LEFT JOIN hrd_web_master.mst_karyawan_01 b ON a.karyawan_id=b.karyawan_id
				LEFT JOIN hrd_all.mst_biodata c ON b.biodata=c.biodata_id
				LEFT JOIN hrd_web_master.mst_karyawan_01 d ON a.approved_user=d.karyawan_id
				LEFT JOIN hrd_all.mst_biodata e ON d.biodata=e.biodata_id
				LEFT JOIN hrd_web_master.mst_pic_app f ON c.nip = f.nip
				WHERE e.nip = '$nip_user'
				AND urutan_approval = '$urutan_app'
				";
			$query = $this->hrd->query($sql);
			// die($this->hrd->last_query());
			return 	$query->row_array();
		}

		public function get_app_cuti_count($nip_user){
			$sql = "SELECT e.biodata_id,e.nip, e.nama_lengkap,
				c.biodata_id,c.nip,c.nama_lengkap, urutan_approval, f.email
				FROM hrd_web_master.mst_user_approval_detail a
				LEFT JOIN hrd_web_master.mst_karyawan_01 b ON a.karyawan_id=b.karyawan_id
				LEFT JOIN hrd_all.mst_biodata c ON b.biodata=c.biodata_id
				LEFT JOIN hrd_web_master.mst_karyawan_01 d ON a.approved_user=d.karyawan_id
				LEFT JOIN hrd_all.mst_biodata e ON d.biodata=e.biodata_id
				LEFT JOIN hrd_web_master.mst_pic_app f ON c.nip = f.nip
				WHERE e.nip = '$nip_user'
				";
			$query = $this->hrd->query($sql);
			// die($this->hrd->last_query());
			return 	$query->num_rows();
		}
	# --- Approval CUTI ---


	public function getDataPosting($no_dok_h)
	{
		$sql = "SELECT a.*,
		b.nama_lengkap app_1, c.nama_lengkap app_2, d.nama_lengkap app_3, a.tgl_app_1,
		a.tgl_app_2, a.tgl_app_3
		FROM hrd_all.trn_posting a
		LEFT JOIN hrd_all.mst_biodata b ON a.app_1 = b.nip
		LEFT JOIN hrd_all.mst_biodata c ON a.app_2 = c.nip
		LEFT JOIN hrd_all.mst_biodata d ON a.app_3 = d.nip
		WHERE tdk_masuk_h_id = ?";
		$query = $this->hrd->query($sql, array($no_dok_h));
		// die(nl2br($this->hrd->last_query()));
		return $query->row_array();
	}

	public function PicApprovalMenu()
	{
		$nip = $this->session->userdata('nama_login');
		$sql = "SELECT c.nip, nama_lengkap, biodata_id
		FROM hrd_web_master.mst_user_approval a
		INNER JOIN hrd_web_master.mst_karyawan_01 b ON a.karyawan_id = b.karyawan_id
		INNER JOIN hrd_all.mst_biodata c ON b.nip = c.nip
		WHERE c.nip = $nip
		UNION ALL
		SELECT nip_user,nm_user,nm_app FROM hrd_web_master.mst_st_app_1
		WHERE nip_user = $nip
		";
		$query = $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return $query->row_array();
	}

	public function PicApproval()
	{
		$nip = $this->session->userdata('nama_login');
		$sql = "SELECT c.nip, nama_lengkap, biodata_id
		FROM hrd_web_master.mst_user_approval a
		INNER JOIN hrd_web_master.mst_karyawan_01 b ON a.karyawan_id = b.karyawan_id
		INNER JOIN hrd_all.mst_biodata c ON b.nip = c.nip
		WHERE c.nip = $nip
		";
		$query = $this->hrd->query($sql);
		// die($this->hrd->last_query());

		$this->sql = nl2br($this->hrd->last_query());


		return $query->row_array();
	}

	public function PicVerifikasiHrd()
	{
		$nip 	= $this->session->userdata('nama_login');
		$sql 	= "SELECT * FROM hrd_all.trn_pic_dewa WHERE nip=$nip AND LEVEL IN ('2','3')";
		$query 	= $this->hrd->query($sql);
		return $query->row_array();
	}


	public function get_email_pic($biodata_id)
	{
        $query = $this->hrd->select('a.nama_lengkap, a.nip, d.dept_id, e.nama_dept')
		->from('hrd_all.mst_biodata a')
		->join('hrd_all.biodata_pekerjaan_d d', 'a.biodata_id = d.biodata_id','left')
		->join('hrd_all.mst_dept e','d.dept_id = e.dept_id','left')
		->where('a.biodata_id', $biodata_id)
		->get();
        return 	$query->row_array();
	}


	public function get_email_app($biodata_id,$urutan_app)
	{
		$sql = "SELECT
		e.biodata_id,e.nip, e.nama_lengkap,
		c.biodata_id,c.nip,c.nama_lengkap, urutan_approval, f.email
		FROM hrd_web_master.mst_user_approval_detail a
		LEFT JOIN hrd_web_master.mst_karyawan_01 b ON a.karyawan_id=b.karyawan_id
		LEFT JOIN hrd_all.mst_biodata c ON b.biodata=c.biodata_id
		LEFT JOIN hrd_web_master.mst_karyawan_01 d ON a.approved_user=d.karyawan_id
		LEFT JOIN hrd_all.mst_biodata e ON d.biodata=e.biodata_id
		LEFT JOIN hrd_web_master.mst_pic_app f ON c.nip = f.nip
		WHERE e.biodata_id = '$biodata_id'
		AND urutan_approval = '$urutan_app'";
		$query = $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return 	$query->row_array();
	}

	public function get_email_app_overtime($biodata_id,$urutan_app)
	{
		$sql = "SELECT
		e.biodata_id,e.nip, e.nama_lengkap,
		c.biodata_id,c.nip,c.nama_lengkap, urutan_approval, f.email
		FROM hrd_web_master.mst_user_approval_detail a
		LEFT JOIN hrd_web_master.mst_karyawan_01 b ON a.karyawan_id=b.karyawan_id
		LEFT JOIN hrd_all.mst_biodata c ON b.biodata=c.biodata_id
		LEFT JOIN hrd_web_master.mst_karyawan_01 d ON a.approved_user=d.karyawan_id
		LEFT JOIN hrd_all.mst_biodata e ON d.biodata=e.biodata_id
		LEFT JOIN hrd_web_master.mst_pic_app f ON c.nip = f.nip
		WHERE e.biodata_id = '$biodata_id'
		AND urutan_approval = '$urutan_app'";
		$query = $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return 	$query->row_array();
	}



	/*  Approval CP & COUNT */
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
			";

			$jum 	= $this->hrd->query($sql);
			return $jum->num_rows();
		}

	/*  Approval CP & COUNT */


	/*  Get Data Karyawan, Jabatan */

		public function getKaryawanByID($nip)
		{
			$sql = "SELECT a.*, c.kode k_d, c.nama n_d, d.kode k_j, d.nama n_j
					FROM hrd_all.mst_biodata a
					LEFT JOIN hrd_web_master.mst_karyawan_01 b on a.biodata_id = b.biodata
					LEFT JOIN hrd_web_master.mst_departemen c ON b.departemen = c.hash
					LEFT JOIN hrd_web_master.mst_jabatan d ON b.jabatan = d.hash
					LEFT JOIN hrd_web_master.db_akses_dept e  ON b.nip = e.nip
					WHERE a.nip = '$nip'
			";
			$query = $this->hrd->query($sql);
			// die($this->hrd->last_query());
			return $query->row_array();

		}

		public function getDataKaryawan()
		{
			$nip = $this->session->userdata('nama_login');
			$sql = "SELECT b.nip, c.kode k_d, c.nama n_d, d.kode k_j, d.nama n_j, e.*
					FROM hrd_web_master.mst_karyawan_01 b
					LEFT JOIN hrd_web_master.mst_departemen c ON b.departemen = c.hash
					LEFT JOIN hrd_web_master.mst_jabatan d ON b.jabatan = d.hash
					LEFT JOIN hrd_web_master.db_akses_dept e  ON b.nip = e.nip
					WHERE b.nip = '$nip'
			";
			$query = $this->hrd->query($sql);
			// die($this->hrd->last_query());
			return $query->row_array();

		}

		public function getKodeStore($biodataid)
		{
			$sql = "SELECT kd_store FROM hrd_all.biodata_pekerjaan_d bp WHERE bp.biodata_id = '".$biodataid."' AND bp.aktif='1'";
			// die($this->hrd->last_query());
			$query 	= $this->hrd->query($sql);
			return 	$query->row_array();
		}

		#Tabel usernya ada di hrd_web_master.db_akses_dept

		public function getDept($nip)
		{

			$sql = "SELECT * FROM db_akses.mst_manager a
					LEFT JOIN gl_mim.mst_dept_induk b ON a.kode_dept = b.kode_dept
					WHERE nip = '$nip'
					AND nip != '14090032'
					AND a.aktif = 1
					LIMIT 1
			";
			$query = $this->dbakses->query($sql);
			// die($this->dbakses->last_query());
			return $query->row_array();

		}

		public function getFin($nip)
		{

			$sql = "SELECT *
					FROM db_akses.mst_finance_controller
					WHERE nip = '$nip'
					AND nip != '14090032'
					AND aktif = 1
			";
			$query = $this->dbakses->query($sql);
			return $query->row_array();

		}

		public function getDir($nip)
		{

			$sql = "SELECT *
					FROM db_akses.mst_general_manager
					WHERE nip = '$nip'
					AND aktif = 1
			";
			$query = $this->dbakses->query($sql);
			return $query->row_array();

		}

		public function getAksesDept($nip)
		{

			$sql = "SELECT *
					FROM hrd_web_master.db_akses_dept
					WHERE nip = '$nip'
					LIMIT 1

			";
			$query = $this->dbakses->query($sql);
			// die($this->dbakses->last_query());
			return $query->row_array();

		}

		public function getDataPicDewaHrd()
		{
			$nip 				= $this->session->userdata('nama_login');
			$sql = "SELECT * FROM hrd_all.trn_pic_dewa WHERE nip='$nip' AND LEVEL IN ('2','3') ";
			$query = $this->hrd->query($sql);
			return $query->row_array();
		}

	/*  Get Data Karyawan, Jabatan */

	/*-----  Data Absense & History ----- */
		public function getAbsensi($biodataid,$tgl_lembur)
		{
			$sql = "SELECT *
					FROM hrd_all.trn_absensi
					WHERE biodata_id='$biodataid'
					AND tgl_absensi = '$tgl_lembur'";
			$query = $this->hrd->query($sql);
			// die($this->hrd->last_query());
			return $query->row_array();
		}

		public function getHistory($nip,$tgl_lembur)
		{
			$sql = "SELECT * FROM hrd_all.inoutdata_hist
					WHERE nip ='$nip' AND checkdate = '$tgl_lembur' AND checktype='1'
					";
			$query = $this->hrd->query($sql);
			// die($this->hrd->last_query());
			return $query->row_array();
		}
	/*----- END Data Absense & History ----- */

	/*  Send Mail Cuti */
		public function send_mail_cuti_create($data_header, $log_detail)
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

		public function send_mail_cuti_approve($tdk_masuk_h_id)
		{

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
	/*  Send Mail Cuti */


	public function saveAbsensi()
	{
		$nip			= $this->input->post('nip');
		$biodataid		= $this->input->post('biodata_id');
		$tgl_lembur		= $this->input->post('tgl_lembur');
		$jam_in			= $this->input->post('jam_in');
		$keterangan		= $this->input->post('status');

		$getAbsen		= $this->getAbsensi($biodataid,$tgl_lembur);
		$getHistory		= $this->getHistory($nip,$tgl_lembur);

		// tesx($jam_in);
		if(!empty($getAbsen)|| $getAbsen != NULL)
		{
			if(!empty($keterangan)|| $keterangan != NULL){
				$data_absensi = array(
					'jam_masuk'  				=> $jam_in,
					'status_absen'  			=> '1',
					'keterangan'  				=> $keterangan,
				);
			} else {
				$data_absensi = array(
					'jam_masuk'  				=> $jam_in,
					'status_absen'  			=> '1',
					'keterangan'  				=> 'HD',
				);
			}
			$this->hrd->where('biodata_id', $biodataid);
			$this->hrd->where('tgl_absensi', $tgl_lembur);
			$this->hrd->update('hrd_all.trn_absensi',$data_absensi);
		}

		// tesx($data_absensi);


		if(!empty($getHistory)|| $getHistory != NULL)
		{
			$data_history = array(
				'checktime'  				=> $jam_in,
			);
			$this->hrd->where('nip', $nip);
			$this->hrd->where('checkdate', $tgl_lembur);
			$this->hrd->where('checktype', 1);
			$this->hrd->update('hrd_all.inoutdata_hist',$data_history);
		}

		// tesx($data_absensi,$data_history);

		return ($nip)?true:false;

	}

}




