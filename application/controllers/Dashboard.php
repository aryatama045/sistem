<?php

class Dashboard extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();


		$this->data['page_title'] = 'Dashboard';
		$this->load->model('Model_dashboard');
		$this->load->model('Model_auth');

	}

	/*
	* It only redirects to the manage category page information into the frontend.
	*/
	public function form()
	{

		// tesx($this->data);
	}
	public function index()
	{

		try {
			// normal flow
			$this->form();
			$this->render_template('dashboard');

		} catch( Exception $e ) {
			$trace = $e->getTrace();

			$result = 'Exception: "';
			$result .= $e->getMessage();
			$result .= '" @ ';
			if($trace[4]['file'] != '') {
				$result .= ' File : '.$trace[4]['file'].'::: Line : '.$trace[4]['line'].' ::: Source :'.$trace[5]['class'].' -> '.$trace[5]['function'].' ::: Function : '.$trace[4]['class'].' -> '.$trace[4]['function'].' ::: Inputs :'.http_build_query($trace[4]['args']);
			}
			tesx( 'error', $result );
		}


	}

	public function page404(){

        $this->form();
		$this->render_template('pages/page404',$this->data);

    }

	public function password_hash($pass = '')
	{
		if($pass) {
			$password = password_hash($pass, PASSWORD_DEFAULT);
			return $password;
		}
	}

	public function change_password()
	{

		$this->form_validation->set_rules('password' ,'New Password' 		, 'trim|required|min_length[8]',$this->val_error);
		$this->form_validation->set_rules('cpassword','Konfirmasi Password'	, 'trim|required|matches[password]'	,$this->val_error);
		if ($this->form_validation->run() == TRUE) {

			$password = $this->password_hash($this->input->post('password'));

			$data = array(
				'nama_login'    => $this->session->userdata('nama_login'),
				'password'      => $password,
				'gender'        => $this->input->post('password'),
				'last_update'   => date('Y-m-d H:i:s'),
				'user_update'   => $this->session->userdata('nama_login'),
			);
			$update = $this->Model_auth->edit($data, $this->session->userdata('nama_login'));

			if($update) {
				$this->session->set_flashdata('success', 'Password "'.$update.'" Berhasil Disimpan');
				// redirect('dashboard', 'refresh');
				redirect('dashboard/change_password', 'refresh');
			}
			else {
				$this->session->set_flashdata('error', 'Error occurred!!');
				redirect('dashboard/change_password', 'refresh');
			}
		}else{
			$this->form();
			$this->render_template('change_password',$this->data);
		}
	}
}
