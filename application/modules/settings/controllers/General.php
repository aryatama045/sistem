<?php defined('BASEPATH') OR exit('No direct script access allowed');

class General extends Admin_Controller  {

	public function __construct()
	{
		parent::__construct();
		$this->auth->route_access();
		$cn 	= $this->router->fetch_class(); // Controller
		$f 		= $this->router->fetch_method(); // Function
		$this->data['pagetitle'] = capital($cn);
		$this->data['function'] = capital($f);

		//  Load Model
		$this->load->model('Model_general');

	}

	public function starter()
	{
		$this->data['modul'] 	= 'settings';
        $this->data['page']   	= $this->router->fetch_class();
		$this->data['getMenus'] = $this->Model_global->getMenuSetting();
	}


	public function index()
	{
		$this->starter();
		$this->render_template($this->data['page'].'/index',$this->data);
	}

	public function edit($id)
	{

		$this->form_validation->set_rules('name' ,'Name ' , 'required');

        if ($this->form_validation->run() == TRUE) {

			$edit_form = $this->Model_role->saveEdit($id);

			if($edit_form) {
				$this->session->set_flashdata('success', 'Role Name  : "'.$_POST['name'].'" <br> Berhasil Di Update !!');
				redirect($this->data['modul'].'/'.$this->data['page'], 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
				redirect($this->data['modul'].'/'.$this->data['page'] , 'refresh');
			}

		}else{
			$this->starter();
            $this->data['role']  	= $this->Model_role->getDataRow($id);

			if($this->data['role']['id']){
				$this->render_template($this->data['page'].'/edit',$this->data);
			}else{
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
				redirect($this->data['modul'].'/'.$this->data['page'] , 'refresh');
			}
		}
	}



}

?>
