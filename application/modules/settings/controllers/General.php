<?php defined('BASEPATH') OR exit('No direct script access allowed');

class General extends Admin_Controller  {

	public function __construct()
	{
		parent::__construct();
		$this->auth->route_access();
		$this->data['modul'] = 'Settings';
		$cn 	= $this->router->fetch_class(); // Controller
		$f 		= $this->router->fetch_method(); // Function
		$this->data['pagetitle'] = capital($cn);
		$this->data['function'] = capital($f);

		//  Load Model
		$this->load->model('Model_general');

	}

	public function starter()
	{

	}


	public function index()
	{
		$this->starter();
		$this->render_template('general/index',$this->data);
	}



}

?>
