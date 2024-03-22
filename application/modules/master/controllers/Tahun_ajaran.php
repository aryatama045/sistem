<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tahun_ajaran extends Admin_Controller  {

	public function __construct()
	{
		parent::__construct();
		$this->auth->route_access();
		$this->data['modul'] = 'Master';
		$cn 	= $this->router->fetch_class(); // Controller
		$f 		= $this->router->fetch_method(); // Function
		$this->data['pagetitle'] = capital($cn);
		$this->data['function'] = capital($f);

	}

	public function starter()
	{

	}


	public function index()
	{
		$this->starter();
		$this->render_template('tahun_ajaran/index',$this->data);
	}



}

?>
