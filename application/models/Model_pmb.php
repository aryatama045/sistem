<?php

class Model_pmb extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}


	public function getDataNoDoc()
	{
		$docCode	 ='PMB-';
		$date		 = date('ym');

		$sno_doc = $docCode.$date;

		$hasil = $this->db->query("SELECT RIGHT(no_pendaftaran,4)+1 as no_pmb FROM trn_pmb WHERE no_pendaftaran LIKE '".$sno_doc."%' ORDER BY no_pendaftaran DESC LIMIT 1");

        $result = $hasil->row_array();

		if($result){
			$urut = $result['no_pmb'];
			for ($i=4; $i > strlen($result['no_pmb']) ; $i--) {
				$urut = "0".$urut;
			}
			return $sno_doc.$urut;
		}else{
			return $sno_doc."0001";
        }
	}

	public function getCamaUsername()
	{
		$date		 = date('ym');

		$sno_doc = $date;

		$hasil = $this->db->query("SELECT RIGHT(username,4)+1 as username FROM users WHERE username LIKE '".$sno_doc."%' ORDER BY id DESC LIMIT 1");

        $result = $hasil->row_array();

		if($result){
			$urut = $result['username'];
			for ($i=4; $i > strlen($result['username']) ; $i--) {
				$urut = "0".$urut;
			}
			return $sno_doc.$urut;
		}else{
			return $sno_doc."0001";
        }
	}

	public function getGelDaftar(){
		$sql = "SELECT *
				FROM mst_gel_daftar
				WHERE NOW() >= DATE(tgl_awal) AND NOW() <= DATE(tgl_akhir)
		";
		$query 	= $this->db->query($sql);
		// die(nl2br($this->db->last_query()));
		return $query->row_array();
	}

	public function getDataPendaftaran($no_pendaftaran)
	{
		$this->db->select("a.*, b.id id_agama, b.nama nama_agama,
		CASE WHEN (jenis_kelamin)= 'L' THEN 'Laki-Laki'
		WHEN (jenis_kelamin)='P' THEN 'Perempuan'
		ELSE 'Belum Input' END jk");
		$this->db->from('trn_pmb a');
		$this->db->join('mst_agama b', 'a.agama = b.id', 'left');
        $this->db->where('a.no_pendaftaran', $no_pendaftaran);
		$query=$this->db->get();
		return $query->row_array();
	}

	public function getDokPendaftaran($no_pendaftaran)
	{
		$this->db->select('*');
		$this->db->from('trn_pmb_dok a');
        $this->db->where('a.no_pendaftaran', $no_pendaftaran);
		$query=$this->db->get();
		return $query->result_array();
	}

	public function getProdi($id = null){
		$this->db->select('*');
		$this->db->from('mst_prodi');
		if($id){
			$this->db->where('kd_prog', $id);
			$query=$this->db->get();
			return $query->row_array();
		}else{
			$query=$this->db->get();
			return $query->result_array();
		}

	}

	public function getJenma($id = null){
		$this->db->select('*');
		$this->db->from('mst_jenma');
		if($id){
			$this->db->where('kd_jenma', $id);
			$query=$this->db->get();
			return $query->row_array();
		}else{
			$query=$this->db->get();
			return $query->result_array();
		}
	}

	public function getDataCama($nik){
		$this->db->select('*');
		$this->db->from('trn_pmb');
        $this->db->where('nik', $nik);
		$query=$this->db->get();
		return $query->row_array();
	}

	public function getDataUsername($username)
	{
		$this->db->select('*');
		$this->db->from('users');
        $this->db->where('username', $username);
		$query=$this->db->get();
		return $query->row_array();
	}


	//------- Save Data
	public function saveCama($dataCama)
    {
        if(!empty($dataCama)){
            $insert = $this->db->insert('trn_pmb', $dataCama);
        }

		$pass_set 	= $this->getCamaUsername();
		$password 	= password_hash($pass_set, PASSWORD_DEFAULT);
		$data_user = array(
			'name'		=> $dataCama['nama'],
			'username' => $this->getCamaUsername(),
			'password' => $password ,
			'pmb'	   => 'aktif',
			'status'   => '1',
			'no_pmb'   => $dataCama['no_pendaftaran'],
			'created_at' => date('d-m-Y h:i:s')
		);
		$this->db->insert('users', $data_user);

		$this->send_mail_create($dataCama['no_pendaftaran'], $data_user);
		return ($insert)?true:false;
	}

	public function saveUploadBerkas($data_berkas)
	{
		$cek_berkas = $this->cek_berkas($data_berkas);

		if(!$cek_berkas){
            $insert = $this->db->insert('trn_pmb_dok', $data_berkas);
        } else{
			$this->db->where('no_pendaftaran',$data_berkas['no_pendaftaran']);
			$this->db->like('nama_dok', $data_berkas['nama_dok']);
			$insert = $this->db->update('trn_pmb_dok', $data_berkas);
		}


		return ($insert)?true:false;
	}


	//------- Update Data
	function updateBiodataDiri()
	{
		$data = $_POST;
		$this->db->where(['no_pendaftaran' => $data['no_pendaftaran']]);
		$update = $this->db->update('trn_pmb', $data);

		return ($update)?TRUE:FALSE;

	}


	// Cek Data
	function cek_berkas($data)
	{
		$this->db->select('*');
		$this->db->from('trn_pmb_dok');
		$this->db->where('no_pendaftaran',$data['no_pendaftaran']);
		$this->db->like('nama_dok', $data['nama_dok']);
		$query=$this->db->get();
		return $query->row_array();
	}


	//--------- Send Email
	public function send_mail_create($no_pendaftaran, $data_user)
	{
        $this->load->config('email');
        $this->load->library('email');

		$data_mhs 	= $this->getDataPendaftaran($no_pendaftaran);
		$get_user   = $this->getDataUsername($data_user['username']);
		$set_roles = array(
			'user_id'   => $get_user['id'],
			'role_id'  	=> '2',
		);
		$this->db->insert('roles_users', $set_roles);

		$data = array(
			'no_pendaftaran'=> $data_mhs['no_pendaftaran'],
			'nama'			=> $data_mhs['nama'],
			'username'		=> $data_user['username'],
			'password'		=> $data_user['password'],
			'email_from'	=> $this->config->item('smtp_user'),
			'email_to'		=> $data_mhs['email'],
		);

        $subject 	= 'Akun Pendaftaran  ('.$data_mhs['no_pendaftaran'].')';
		$from 		= $this->config->item('smtp_user');
        $to 		= $data_mhs['email'];

        $this->email->set_newline("\r\n");
        $this->email->from($from);
        $this->email->to($to);
        $this->email->subject($subject);
		$this->email->message($this->load->view('pmb/email_template',$data,true));
		$this->email->send();

		if($this->email->send()){
			echo "Mail Sent ok";
		}else{
			echo "Error";
		}

		// tesx($data_user, $data_mhs);

    }

}