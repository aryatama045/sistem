<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cuti extends Admin_Controller  {

	public function __construct()
	{
		$this->data['modul'] = "Leaves";
		parent::__construct();
		// $this->not_logged_in();
		$this->data['page_title'] = 'Cuti';
		$this->auth->route_access();
		$this->val_error = array(
			'required'	=> '<b>{field} </b> Harus diisi',
			'numeric'	=> '<b>{field} </b> Hanya Angka',
			'min_length'=> '<b>{field} </b> Minimal 8 Karakter',
			'max_length'=> '<b>{field} </b> Maximal 8 Karakter',
			'matches'	=> '<b>{field} </b> Tidak Sesuai',
			'is_unique'	=> '<b>{field} </b> Sudah Terdaftar'
		);
	}

	public function index()
	{
		$this->render_template('cuti/index',$this->data);
	}





}

