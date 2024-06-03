<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawan extends Admin_Controller  {

	public function __construct()
	{
		parent::__construct();
		$this->auth->route_access();
		$cn 	= $this->router->fetch_class(); // Controller
		$this->data['pagetitle']	= capital($cn);
		$f 		= $this->router->fetch_method(); // Function
		$this->data['function'] 	= capital($f);
		$this->data['modul'] 		= 'Users'; // name modul
	}


    public function index()
	{
		$this->render_template('karyawan/index');
	}

	public function detail()
	{

		$this->render_template('karyawan/detail');
	}



}