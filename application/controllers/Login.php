<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();

    }

    public function index()
    {
        $this->logged_in();
        $data = array();

        if($_POST) {
            $data = $this->auth->login($_POST);
        }

        return $this->auth->showLoginForm($data);
    }

    public function logout()
    {
        if($this->auth->logout())
            return redirect('login');

        return false;
    }

}