

<?php

class Model_overtime extends CI_Model
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

		$hasil=$this->hrd->query("SELECT RIGHT(no_dokumen,4)+1 as gencode FROM hrd_all.trn_overtime
		WHERE no_dokumen LIKE '".$sno_doc."%' ORDER BY no_dokumen DESC LIMIT 1");

        $result = $hasil->row_array();
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

	public function getHeader($no_dok)
	{
		$this->hrd->select('*');
		$this->hrd->from('hrd_all.trn_overtime a');
		$this->hrd->where('no_dokumen' , $no_dok);
		$query 	= $this->hrd->get()->row_array();
		return 	$query;
	}

    public function getDataKaryawan($nip){
		$sql = "SELECT a.biodata_id,a.nip,a.nama_lengkap, c.nama nama_dept
                FROM hrd_all.mst_biodata a
				LEFT JOIN hrd_web_master.mst_karyawan_01 b ON a.nip = b.nip
				LEFT JOIN hrd_web_master.mst_departemen c ON b.departemen = c.hash
                WHERE a.nip ='$nip'
                ";
		$query 	= $this->hrd->query($sql);
		return 	$query->row_array();
	}

	public function getDataKaryawan01($nip)
	{
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

    public function getDataAbsen($biodata_id, $tgl_lembur){
		$sql = "SELECT *
                FROM hrd_all.trn_absensi
                WHERE biodata_id='$biodata_id'
                AND tgl_absensi = '$tgl_lembur'
                ";
		$query 	= $this->hrd->query($sql);
		return 	$query->row_array();
	}

	public function getCekOvertime($tgl, $nip)
	{
		$this->hrd->select('*');
		$this->hrd->from('hrd_all.trn_overtime a');
		$this->hrd->where('tgl_dokumen' , $tgl);
		$this->hrd->where('nip' , $nip);
		$query 	= $this->hrd->get()->row_array();
		return 	$query;
	}


    /* Datatables */
    public function getDataOvertime1($no , $search_no = "", $length = "", $start = "", $column = "", $order = "")
	{

		if($search_no != "") $this->hrd->like('t0.nip',$search_no);
		$this->hrd->select('t0.nip, t0.no_dokumen,
			DATE_FORMAT(t0.tgl_lembur, "%d-%m-%Y") tgl_dok,
			CONCAT_WS(" | ", t2.nip, t2.nama_lengkap) nama_user,
			t2.nip, t0.keterangan, t0.tgl_lembur');
		$this->hrd->from('hrd_all.trn_overtime t0');
		$this->hrd->join('hrd_all.mst_biodata t2', 't0.nip = t2.nip', 'left');
		$this->hrd->join('hrd_all.trn_posting t3', 't0.no_dokumen = t3.tdk_masuk_h_id', 'left');
		$this->hrd->where('t0.nip', $no);
		$this->hrd->like('t0.no_dokumen','SPOT');
		$this->hrd->order_by('t0.tgl_lembur','DESC');
		$this->hrd->limit($length,$start);
		$query=$this->hrd->get();
		// die(nl2br($this->hrd->last_query()));
		return $query->result_array();
	}

	public function getDataOvertime2($no , $search_no = "")
	{
		if($search_no != "") $this->hrd->like('t0.nip',$search_no);
		$this->hrd->select('t0.nip, t0.no_dokumen,
			DATE_FORMAT(t0.tgl_lembur, "%d-%m-%Y") tgl_dok,
			CONCAT_WS(" | ", t2.nip, t2.nama_lengkap) nama_user,
			t2.nip, t0.keterangan, t0.tgl_lembur');
		$this->hrd->from('hrd_all.trn_overtime t0');
		$this->hrd->join('hrd_all.mst_biodata t2', 't0.nip = t2.nip', 'left');
		$this->hrd->join('hrd_all.trn_posting t3', 't0.no_dokumen = t3.tdk_masuk_h_id', 'left');
		$this->hrd->where('t0.nip', $no);
		$this->hrd->like('t0.no_dokumen','SPOT');
		$jum=$this->hrd->get();
		return $jum->num_rows();
	}

    public function getDataApproval1($nip , $search_no = "", $length = "", $start = "", $column = "", $order = "")
	{
		$sql = "SELECT
				a.*, d.nip, d.nama_lengkap, e.nip, e.nama_lengkap, f.no_dokumen, f.tgl_lembur, g.status, h.nama, e.biodata_id, f.keterangan
				FROM hrd_web_master.mst_user_approval_detail a
				LEFT JOIN hrd_web_master.mst_karyawan_01 b ON a.karyawan_id = b.karyawan_id
				LEFT JOIN hrd_web_master.mst_karyawan_01 c ON a.approved_user = c.karyawan_id
				LEFT JOIN hrd_all.mst_biodata d ON b.biodata = d.biodata_id
				LEFT JOIN hrd_all.mst_biodata e ON c.biodata = e.biodata_id
				LEFT JOIN hrd_all.trn_overtime f ON e.nip = f.nip
				LEFT JOIN hrd_all.trn_posting g ON f.no_dokumen = g.tdk_masuk_h_id
				LEFT JOIN hrd_web_master.mst_departemen h ON a.dept_user = h.hash
				WHERE d.nip = '$nip'
				AND g.status_dokumen <>'R'
				AND g.status_dokumen <>'C'
				AND urutan_approval= g.status+1
				ORDER BY tgl_lembur ASC
				LIMIT $start,$length";

		$query = $this->hrd->query($sql);
		return $query->result_array();
	}
	public function getDataApproval2($nip , $search_no = "")
	{
		$sql = "SELECT
				a.*, d.nip, d.nama_lengkap, e.nip, e.nama_lengkap, f.no_dokumen, f.tgl_lembur, g.status, h.nama, e.biodata_id, f.keterangan
				FROM hrd_web_master.mst_user_approval_detail a
				LEFT JOIN hrd_web_master.mst_karyawan_01 b ON a.karyawan_id = b.karyawan_id
				LEFT JOIN hrd_web_master.mst_karyawan_01 c ON a.approved_user = c.karyawan_id
				LEFT JOIN hrd_all.mst_biodata d ON b.biodata = d.biodata_id
				LEFT JOIN hrd_all.mst_biodata e ON c.biodata = e.biodata_id
				LEFT JOIN hrd_all.trn_overtime f ON e.nip = f.nip
				LEFT JOIN hrd_all.trn_posting g ON f.no_dokumen = g.tdk_masuk_h_id
				LEFT JOIN hrd_web_master.mst_departemen h ON a.dept_user = h.hash
				WHERE d.nip = '$nip'
				AND g.status_dokumen <>'R'
				AND g.status_dokumen <>'C'
				AND urutan_approval= g.status+1";
		$query = $this->hrd->query($sql);
		return $query->num_rows();
	}

    /* Datatables */



    public function saveAction()
    {
        $tgl_lembur     = $this->input->post('tgl_lembur');
        $biodata_id     = $this->input->post('biodata_id');
        $nip            = $this->input->post('nip');
        $data_karyawan  = $this->getDataKaryawan($nip);
        $cekTglAbsen    = $this->getDataAbsen($biodata_id,$tgl_lembur);

        if(empty($cekTglAbsen)) {
            $this->session->set_flashdata('error', 'Tidak ada absen pada tanggal "'.$tgl_lembur.'"');
            redirect('leaves/overtime/create/', 'refresh');
        }
        // tesx($tgl_lembur, $cekTglAbsen);

        $docCode	='SPOT';
        $date		= date('ym');
        $data_header = array(
            'no_dokumen'    => $this->getDataNoDoc($docCode,$date),
            'nip'           => $nip,
            'tgl_lembur'    => $this->input->post('tgl_lembur'),
            'jam_in'        => $this->input->post('jam_in'),
            'jam_out'       => $this->input->post('jam_out'),
            'keterangan'    => $this->input->post('keterangan'),
            'tgl_dokumen'   => date('Y-m-d H:i:s'),
        );
        $this->hrd->insert('hrd_all.trn_overtime', $data_header);

        $data_posting = array(
            'tdk_masuk_h_id'	=> $data_header['no_dokumen'],
            'status' 			=> '0',
            'status_dokumen' 	=> 'O'
        );
        $this->hrd->set($data_posting);
        $this->hrd->insert('hrd_all.trn_posting');

        // tesx($data_header);

        $this->send_mail_create($data_header);

        return ($data_header['no_dokumen'])?$data_header['no_dokumen']:false;
    }

	public function approvalAction()
	{

		#Get Dokumen
		$no_dokumen     = $this->input->post('no_dokumen');
		$getDok			= $this->getHeader($no_dokumen);
		$tgl_lembur		= $getDok['tgl_lembur'];
		#Get Biodata
		$data_karyawan  = $this->getDataKaryawan($getDok['nip']);
		$biodata_id     = $data_karyawan['biodata_id'];
		#Data Pic & User
        $nip_user       = $getDok['nip'];
		$nip_app		= $this->session->userdata('nama_login');

		#Get Urutan CP
		// $get_app		= $this->get_app($nip_user, $nip_app);
		// $urutan_app		= $get_app['urutan_app'];
		// $count			= $this->get_app_count($nip_user);

		#Get Urutan CUTI
		$id_user = $this->getDataKaryawan01($nip_user);
		$id_app	 = $this->getDataKaryawan01($nip_app);
		$get_app  		= $this->get_app_cuti($nip_user, $nip_app);
		$urutan_app 	= $get_app['urutan_approval'];
		$count			= $this->get_app_cuti_count($nip_user);

		// tesx($no_dokumen , $urutan_app, $count, $get_app);

		if ($urutan_app == $count)
		{
			$data_posting = array(
				'app_'.$urutan_app.''			=> $nip_app,
				'tgl_app_'.$urutan_app.'' 		=> date('Y-m-d h:i:s'),
				'status' 						=> $urutan_app,
				'status_dokumen' 				=> 'C'
			);

			$data_absensi = array(
				'no_reff'  					=> $getDok['no_dokumen'],
				'jam_masuk'  				=> $getDok['jam_in'],
				'jam_keluar'  				=> $getDok['jam_out'],
				'status_absen'  			=> 'PO',
				'keterangan'  				=> 'PO',
				'keterangan2'  				=> $getDok['keterangan'],
			);
			$this->hrd->where('biodata_id', $biodata_id);
			$this->hrd->where('tgl_absensi', $tgl_lembur);
			$this->hrd->update('hrd_all.trn_absensi',$data_absensi);

		} else {

			$data_posting = array(
				'app_'.$urutan_app.''			=> $nip_app,
				'tgl_app_'.$urutan_app.'' 		=> date('Y-m-d h:i:s'),
				'status' 						=> $urutan_app,
				'status_dokumen' 				=> 'P'
			);

		}


		// tesx($no_dokumen ,$urutan_app,$count,$urutan_send, $data_posting, empty($data_absensi) );

			#Update Data Posting
			$this->hrd->set($data_posting);
			$this->hrd->where('tdk_masuk_h_id', $no_dokumen);
			$this->hrd->update('hrd_all.trn_posting');

		$urutan_send	= $urutan_app+1;
		if($urutan_send <= $count )
		{
			$this->send_mail_approve($no_dokumen, $urutan_send);
		}

		return ($no_dokumen)?$no_dokumen:false;

	}

	public function rejectAction()
	{
		#Get Dokumen
		$no_dokumen     = $this->input->post('no_dokumen');
		$ket_rej		= $this->input->post('keterangan_rej');
		$getDok			= $this->getHeader($no_dokumen);
		$tgl_lembur		= $getDok['tgl_lembur'];
		#Get Biodata
		$data_karyawan  = $this->getDataKaryawan($getDok['nip']);
		$biodata_id     = $data_karyawan['biodata_id'];
		#Data Pic & User
        $nip_user       = $getDok['nip'];
		$nip_app		= $this->session->userdata('nama_login');
		#Get Urutan CUTI
		$id_user = $this->getDataKaryawan01($nip_user);
		$id_app	 = $this->getDataKaryawan01($nip_app);
		$get_app  		= $this->get_app_cuti($nip_user, $nip_app);
		$urutan_app 	= $get_app['urutan_approval'];
		$count			= $this->get_app_cuti_count($nip_user);

		$data_posting = array(
			'rej_'.$urutan_app.''			=> $nip_app,
			'tgl_rej_'.$urutan_app.'' 		=> date('Y-m-d h:i:s'),
			'rej_komentar_'.$urutan_app.'' 	=> $ket_rej,
			'status' 						=> $urutan_app,
			'status_dokumen' 				=> 'R'
		);
		// tesx($no_dokumen ,$urutan_app,$count,$data_posting);

		#Update Data Posting
		$this->hrd->set($data_posting);
		$this->hrd->where('tdk_masuk_h_id', $no_dokumen);
		$this->hrd->update('hrd_all.trn_posting');

		return ($no_dokumen)?$no_dokumen:false;

	}


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

		// $pic_app 			= $this->Model_leave->get_email_app($biodata_id, $urutan_app);

		$pic_app 			= $this->Model_leave->get_app_cuti_urutan($nip, $urutan_app);


		$data = array(
						'judul' 		=> 'Overtime',
						'nama_user'		=> $this->session->userdata('nama_karyawan'),
						'nip'			=> $this->session->userdata('nama_login'),
						'header_data'	=> $data_header,
						// 'detail_data'	=> $log_detail,
						'email_from'	=> $this->config->item('smtp_user'),
						'email_to'		=> $pic_app['email'],
						'divisi'		=> $biodata['nama_dept'],
				);

        $subject = 'Pengajuan '.$data['judul'].' - '.$data_header['no_dokumen'].' - '.$data['nama_user'];
		$from 	= $this->config->item('smtp_user');

		// $from = 'rizky.it@optiktunggal.com';
        $to 	= $pic_app['email'];

        // tesx($data);

        $this->email->set_newline("\r\n");
        $this->email->from($from);
        $this->email->to($to);

        $this->email->subject($subject);
		$this->email->message($this->load->view('email/overtime',$data,true));
		$this->email->send();

    }

	public function send_mail_approve($no_dokumen, $urutan_send)
	{
        $this->load->config('email');
        $this->load->library('email');

		$header_data 		= $this->getHeader($no_dokumen);

		$get_biodata 		= $this->getDataKaryawan($header_data['nip']);

		$pic_app 			= $this->get_app_cuti_urutan($header_data['nip'], $urutan_send);

		$data = array(	'judul' 		=> 'Overtime',
						'nama_user'		=> $get_biodata['nama_lengkap'],
						'nip'			=> $get_biodata['nip'],
						'divisi'		=> $get_biodata['nama_dept'],
						'jml_app'		=> $urutan_send,
						'mailto'		=> $pic_app['email'],
						'header_data'	=> $header_data,
		);

		// tesx($data, $urutan_send, $pic_app);

        $subject 	= 'Pengajuan '.$data['judul'].' - '.$header_data['no_dokumen'].' - '.$data['nama_user'];
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
		$this->email->message($this->load->view('email/overtime_approval',$data,true));
		$this->email->send();
    }

	# APP CP
	public function get_app($nip_user,$nip_app)
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

	public function get_app_urutan($nip_user,$urutan)
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

	public function get_app_count($nip_user)
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

	# APP Cuti
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


}