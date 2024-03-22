
<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Menus extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('menus/Mdl_menus');
	}

	function index() {
		$items	= $this->Mdl_menus->get_items();
		$menu	= $this->Mdl_menus->generateTree($items); 
		$data = array(
			'menu' => $menu,
		);
		$this->load->view('menus/menu', $data, false);
	}

}