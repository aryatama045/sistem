<?php

class Role extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
	}


	public function index()
	{

		$this->render_template('users/role/index');
	}


}
