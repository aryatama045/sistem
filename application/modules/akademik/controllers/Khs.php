<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Khs extends Admin_Controller  {

	public function __construct()
	{
		parent::__construct();
		$this->auth->route_access();
		$this->data['modul'] = 'Akademik';
		$cn 	= $this->router->fetch_class(); // Controller
		$f 		= $this->router->fetch_method(); // Function
		$this->data['pagetitle'] = capital($cn);
		$this->data['function'] = capital($f);

		// $this->load->model('Model_krs');

	}

	public function starter()
	{}


	public function index()
	{
		$this->starter();
        $ta_aktif       = $this->Model_global->getTahunAjaranAktif();
        $username  		= $this->session->userdata('username');
        $getdatauser 	= $this->Model_global->getDataUsername($username);
        $this->data['data_khs']           = $this->Model_global->krs_khs($getdatauser['nim'], $ta_aktif['kd_ta']);

		$this->render_template('khs/index',$this->data);
	}





}

?>
