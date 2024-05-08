<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Biaya extends Admin_Controller  {

	public function __construct()
	{
		parent::__construct();
		$this->auth->route_access();
		$cn 	= $this->router->fetch_class(); // Controller
		$f 		= $this->router->fetch_method(); // Function
		$this->data['pagetitle'] = capital($cn);
		$this->data['function'] = capital($f);

        $this->data['modul'] = 'Master';
		$this->load->model('Model_tahun_ajaran');

	}

	public function starter()
	{

	}


	public function index()
	{
		$this->starter();
		$this->render_template('tahun_ajaran/index',$this->data);
	}

    public function jenis()
	{
		$this->starter();
		$this->render_template('biaya/jenis/index',$this->data);
	}


}

?>
