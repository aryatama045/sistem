<?php

class Model_auth extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/*
		This function checks if the nim exists in the database
	*/
	public function check_nama_login($nim)
	{
		if($nim) {
			$sql = 'SELECT * FROM mst_mhs WHERE nim = ?';
			$query = $this->db->query($sql, array($nim));
			$result = $query->row_array();
			return $result;
		}

		return false;
	}




	/*
		This function checks if the nim and password matches with the database
	*/
	public function login($nim, $password) {
		if($nim && $password) {

			$sql = "SELECT *
					FROM mst_mhs
					WHERE nim = $nim";
			$query = $this->db->query($sql);

			// die(nl2br($this->db->last_query()));

			// if($query->num_rows() == 1) {
				$result = $query->row_array();

			// 	$hash_password = password_verify($password, $result['password']);
			// 	if($hash_password === true) {
					return $result;
			// 	}
			// 	else {
			// 		return false;
			// 	}

			// }
			// else {
			// 	return false;
			// }

		}
	}

	public function single_login($nim){
		if($nim) {
			$sql = "SELECT * FROM session WHERE nim = ?";

			$query = $this->db->query($sql, array($nim));

			if($query->num_rows() == 0) {
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}



	/*
		This function checks if the hash exists in the database
	*/
	public function check_user_hash($hash)
	{
		if($hash) {
			$sql = 'SELECT * FROM mst_mhs WHERE gender = ?';
			$query = $this->db->query($sql, array($hash));
			// die($this->db->last_query());
			$result = $query->row_array();
			return ($result)?true:false;
		}

		return false;
	}

	function email_exists($key)
	{
		$this->db->where('nim', $key);
		$query = $this->db->get('mst_mhs');
		// die($this->db->last_query());
		return $query->row_array();
	}

	public function create_new_pass($nim, $email)
	{
		$hash 	= password_hash($nim, PASSWORD_DEFAULT);
		$hash 	= substr($hash, 0, 50);
		$hash 	= str_replace("'\'","",$hash);
		$hash 	= str_replace("/","",$hash);
		$hash 	= str_replace(".","",$hash);

		$data = array(
			'password_hash'      => $hash,
		);
		$this->db->where('nim', $nim);
		$this->db->update('mst_mhs', $data);

		$data_email = array(
			'nip'	=> $nim,
			'email'	=> $email,
			'hash' 	=> $hash
		);


		// $this->send_forgot_pass($data_email);
		$create = true;
		return ($create)?true:false;
	}

	public function update_forgot_pass($hash, $data)
	{
		$this->db->where('gender', $hash);
		$this->db->update('mst_mhs', $data);

		return ($update)?true:false;
	}

	public function send_forgot_pass($data_email)
	{
        $this->load->config('email');
        $this->load->library('email');

		$data = array(
			'judul' 		=> 'Forgot Password',
			'nip'			=> $data_email['nip'],
			'hash'			=> $data_email['hash'],
			'header_data'	=> $data_email,
			'email_from'	=> $this->config->item('smtp_user'),
			'email_to'		=> $data_email['email'],
		);

        $subject = $data['judul'].' - '.$data_email['nip'];
		$from 	= $this->config->item('smtp_user');
        $to 	= $data_email['email'];

        $this->email->set_newline("\r\n");
        $this->email->from($from);
        $this->email->to(array($to));
		$this->email->cc(array('rizky.it@optiktunggal.com'));
        $this->email->subject($subject);
		$this->email->message($this->load->view('leaves/email/forgot_pass',$data,true));
		$this->email->send();
    }



}
