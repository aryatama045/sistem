<?php

class MY_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
}

class Admin_Controller extends MY_Controller
{
	var $permission = array();

	public function __construct()
	{
		parent::__construct();
		$group_data = array();
		$this->load->model('Model_menu');

	}

	public function logged_in()
	{
		$session_data = $this->session->userdata();
		if(!empty($session_data['loginStatus'])){
			if($session_data['loginStatus'] == TRUE) {
				redirect('dashboard', 'refresh');
			}
		}
	}

	public function not_logged_in()
	{
		$session_data = $this->session->userdata();
		if($session_data['loginStatus'] == FALSE) {
			redirect('login', 'refresh');
		}
	}


	public function render_template($page = null, $data = array())
	{

		$this->auth->route_access();

		$items	= $this->Model_menu->get_items();
		$menu	= $this->Model_menu->generateTree($items);
		$this->data['menu'] = $menu;


		$this->load->view('templates/header',$this->data);
		$this->load->view($page, $this->data);
		$this->load->view('templates/footer',$this->data);
	}


	public function template_email($page = null, $data = array())
	{
		$this->load->view($page, $data);
	}



}
