<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auasdth extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('Model_auth');
		$this->val_error = array(
			'required'	=> '<b>{field} </b> Harus diisi',
			'numeric'	=> '<b>{field} </b> Hanya Angka',
			'min_length'=> '<b>{field} </b> Minimal 8 Karakter',
			'max_length'=> '<b>{field} </b> Maximal 8 Karakter',
			'matches'	=> '<b>{field} </b> Tidak Sesuai',
			'is_unique'	=> '<b>{field} </b> Sudah Terdaftar'
		);
	}


	/*
		Check if the login form is submitted, and validates the user credential
		If not submitted it redirects to the login page
	*/
	public function login()
	{

		$this->form_validation->set_rules('nim','User Login','required',
				array(	'required' 	=> 'User Login Tidak Boleh Kosong !!',
				));
		$this->form_validation->set_rules('password','Password','required',
				array(	'required' 	=> 'Password Tidak Boleh Kosong !!',
				));
		if ($this->form_validation->run() == TRUE) {
			// true case
			$nip = $this->input->post('nim');

				$name_login_exists = $this->Model_auth->check_nama_login($this->input->post('nim'));

				if($name_login_exists == TRUE) {
					$login = $this->Model_auth->login($this->input->post('nim'), $this->input->post('password'));

					if($login) {

						if($login['jk'] == 'L'){
							$avatar = "avatar_L.png";
						}elseif($login['jk'] == 'P'){
							$avatar = "avatar_P.png";
						}

						$logged_in_sess = array(
							'nim' 				=> $login['nim'],
							'nama'  			=> $login['nama_mhs'],
							'email'     		=> $login['nim'],
							'logged_in' 		=> TRUE,
						);
						$this->session->set_userdata($logged_in_sess);
						redirect('dashboard', 'refresh');

					} else {
						$this->session->set_flashdata('error', 'Incorrect user login/password combination');
						redirect('login' , 'refresh');
					}

				} else {
					$this->session->set_flashdata('error', 'User login does not exists');
					redirect('login' , 'refresh');
				}


		} else {
			// false case
			$this->logged_in();
			$this->session->set_flashdata('error', 'Check Again your data !!');
			redirect('login' , 'refresh');
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url(), 'refresh');
	}

	public function register()
	{

		$this->form_validation->set_rules('nim'		, 'NIP'	,
				'trim|required|numeric|min_length[8]|max_length[8]|is_unique[auth_users.nim]',$this->val_error);
		// $this->form_validation->set_rules('password'		, 'Password',
		// 		'trim|required|min_length[8]',$this->val_error);
		// $this->form_validation->set_rules('cpassword'		, 'Konfirmasi Password',
		// 		'trim|required|matches[password]',$this->val_error);

		if ($this->form_validation->run() == TRUE) {
			// true case
			$nip 		= $this->input->post('nim');

			$user_exists 		= $this->Model_auth->check_nama_login($nip);
			$karyawan_exists 	= $this->Model_auth->check_karyawan($nip);
			$get_biodata 		= $this->Model_auth->get_biodata($nip);
			$biodata_id			= $get_biodata['biodata_id'];
			// tesx($biodata_id);

			if(empty($get_biodata)|| $get_biodata=='' || $get_biodata ==NULL){
				$this->session->set_flashdata('error', 'NIP Tidak terdaftar');
				redirect('auth/register', 'refresh');
			}else{

				if($get_biodata['aktif'] == 1){
					if(empty($karyawan_exists)|| $karyawan_exists=='' || $karyawan_exists == NULL){
						$saveKaryawan 	= $this->Model_auth->saveKaryawan($biodata_id);
						if($saveKaryawan == false) {
							$this->session->set_flashdata('error', 'Data Karyawan Gagal Disimpan!!');
							redirect('auth/register', 'refresh');
						}
					}

					$create = $this->Model_auth->create_user();
					if($create == true) {
						$this->session->set_flashdata('success', ' Berhasil Disimpan, Silahkan konfirmasi kepada dept headnya untuk user approval ');
						redirect('auth/register', 'refresh');
					} else {
						$this->session->set_flashdata('error', 'Error occurred!!');
						redirect('auth/register', 'refresh');
					}
				} else {
					$this->session->set_flashdata('error', 'Nip tidak aktif !!');
					redirect('auth/register', 'refresh');
				}

			}

		} else {
			$this->logged_in();
			$this->load->view('register', $this->data);
		}
	}


	public function forgot_password()
	{

		$this->form_validation->set_rules('email_forgot','Email','required',
			array(	'required' 		=> 'Email Tidak Boleh Kosong !!',)
		);

		if ($this->form_validation->run() == TRUE) {

			$email 		= strtolower($this->input->post('email_forgot'));
			$cek_email  = $this->Model_auth->email_exists($email);

			// tesx($email, strtolower($cek_email['email']));

			if($email  == strtolower($cek_email['email'])){

				$nip =  $cek_email['nip'];
				$user_exists 		= $this->Model_auth->check_nama_login($nip);
				$karyawan_exists 	= $this->Model_auth->check_karyawan($nip);

				// tesx($user_exists, $karyawan_exists );

				if(empty($user_exists) || $user_exists=='' || $user_exists ==NULL){
					$this->session->set_flashdata('error', 'NIP Tidak Terdaftar, Silahkan Register');
					redirect('auth/register', 'refresh');
				}else{

					if(empty($karyawan_exists)|| $karyawan_exists=='' || $karyawan_exists == NULL){
						$this->session->set_flashdata('error', 'Karyawan Tidak Terdaftar, Silahkan Register');
						redirect('auth/register', 'refresh');
					}else{

						$create = $this->Model_auth->create_new_pass($nip, $email);
						$verified_email  = $this->Model_auth->email_exists($email);
						$create = True;
						if($create == true) {
							$this->session->set_flashdata('success', ' Berhasil Terkirim Ke - Email : ' .$email. ' <br> Silahkan Periksa Email' );
							redirect('auth/login', 'refresh');
						} else {
							$this->session->set_flashdata('error', 'Gagal Terkirim !!');
							redirect('auth/login', 'refresh');
						}

					}

				}

			}else{
				$this->session->set_flashdata('error', ' Email tidak terdaftar !!');
				redirect('auth/login', 'refresh');
			}

		} else {
			redirect('auth/login', 'refresh');
		}
	}

	public function verified_forgot($hash)
	{

		$check_hash_user 	= $this->Model_auth->check_user_hash($hash);

		$data['hash'] = $hash;
		// tesx($hash, $check_hash_user);

		if($check_hash_user == true){
			$this->load->view('verified_password', $data);
		}else{
			redirect('login', 'refresh');
		}

	}

	public function save_forgot_password($hash)
	{

		$this->form_validation->set_rules('password' ,'New Password' 		, 'trim|required|min_length[8]',$this->val_error);
		$this->form_validation->set_rules('cpassword','Konfirmasi Password'	, 'trim|required|matches[password]'	,$this->val_error);
		if ($this->form_validation->run() == TRUE) {

			$password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);

			// tesx($this->input->post('password'),$password);

			$data = array(
				'password'      => $password,
				'gender'        => $this->input->post('password'),
				'last_update'   => date('Y-m-d H:i:s')
			);
			$update = $this->Model_auth->update_forgot_pass($hash,$data);
			$update=true;
			if($update == true) {
				$this->session->set_flashdata('success', 'Password Berhasil Disimpan, Silahkan Login');
				redirect('auth/login', 'refresh');
			}
			else {
				$this->session->set_flashdata('error', 'Error occurred!!');
				redirect('verified_forgot', 'refresh');
			}
		}else{
			$this->session->set_flashdata('error', 'Password Belum Sesuai silahkan cek kembali');
			redirect('verified_forgot/'.$hash, 'refresh');
		}
	}


	public function cek_email()
    {
		// tesx($_POST["email"]);
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            echo "<label class='text-danger'><span class='fa fa-times'></span> Email Tidak Valid</label>";
        } else {
			$cekEmail = $this->Model_auth->email_exists($_POST["email"]);
			// tesx($cekEmail);
            if ($cekEmail == TRUE) {
				echo '<label class="text-success"><span class="fa fa-check"></span> Email Terdaftar</label>';
            } else {
                echo '<label class="text-danger"><span class="fa fa-times"></span> Email Belum Terdaftar</label>';
            }
        }
    }



}
