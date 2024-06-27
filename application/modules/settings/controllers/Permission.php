<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Permission extends Admin_Controller  {

	public function __construct()
	{
		parent::__construct();
		$this->auth->route_access();
		$this->data['modul'] = 'Settings';
		$cn 	= $this->router->fetch_class(); // Controller
		$f 		= $this->router->fetch_method(); // Function
		$this->data['pagetitle'] = capital($cn);
		$this->data['function'] = capital($f);

		$this->load->model('Model_permission');
        $this->load->model('Model_role');
	}

	public function starter()
	{
		$this->data['dataRole'] = $this->Model_role->getDataRow();
		$this->data['dataMenu'] = $this->Model_permission->getDataRow();
	}

	public function index()
	{
		$this->starter();
		$this->render_template('permission/index',$this->data);
	}

	public function store()
	{
		$cn 	= $this->router->fetch_class(); // Controller

		$draw           = $_REQUEST['draw'];
        $length         = 100;
		$start          = $_REQUEST['start'];
		$column 		= $_REQUEST['order'][0]['column'];
		$order 			= $_REQUEST['order'][0]['dir'];

        $output['data']	= array();
		$search_name   	= $this->input->post('search_name');
		$search_role   = $this->input->post('search_role');


		$data           = $this->Model_permission->getDataStore('result',$search_name,$search_role,$length,$start,$column,$order);
		$data_jum       = $this->Model_permission->getDataStore('numrows',$search_name,$search_role);

		$output=array();
		$output['draw'] = $draw;
		$output['recordsTotal'] = $output['recordsFiltered'] = $data_jum;

		if($search_name !="" || $search_role !="" ){
			$data_jum = $this->Model_permission->getDataStore('numrows',$search_name,$search_role);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){
			foreach ($data as $key => $value) {
				$id		= $value['permission_id'];

				$checked ='';
				if($id){
					$checked .= 'checked';
				}

				$btn 	= '';
				$btn 	.= '<label class="form-check w-100 checked-line-through checked-opacity-75">
								<input type="checkbox" name="id_permission[]" value="'.$value['id'].'" class="form-check-input" '.$checked.'  />
							</label>';

                if($value['parent_id']=='0'){
                    $menu_name = '<strong>'.uppercase(strtolower($value['display_name'])).'</strong>';
                }else{
                    $menu_name = uppercase(strtolower($value['display_name']));
                }

				$output['data'][$key] = array(
                    $btn,
                    $menu_name,

				);
			}

		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}

	public function tambah()
	{
		$data = $_POST;

		$parent = '';
		$url 	= '';
		$path	= '';
		if(!empty($data['parent_id'])){
			$parent 		= $this->Model_permission->getDataRow($data['parent_id']);
			$url    		= $parent['name'].'/';
			$path    		= $parent['name'].'-';
		}

		$data_menu = array(
			'name'				=> $path.to_strip(lowercase($data['menu_name'])),
			'display_name'		=> capital(strtolower($data['menu_name'])),
			'link'				=> $url.to_strip(lowercase($data['menu_name'])),
			'parent_id'			=> $data['parent_id'],
			'icon'				=> $data['icon'],
			'status'			=> '1',
		);
		$insert = $this->Model_permission->saveTambah($data_menu);

		if($insert) {
			$this->session->set_flashdata('success', ' Berhasil Disimpan !!');
			redirect('settings/permission', 'refresh');
		} else {
			$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
			redirect('settings/permission', 'refresh');
		}
	}


	public function update()
	{

        $this->form_validation->set_rules('search_role' ,'Belum Dipilih ' , 'required');

        if ($this->form_validation->run() == TRUE)
        {
            $data = $_POST;

            // Delete Data sebelumnya
            if($data['search_role']){
                $delete = $this->Model_permission->saveDelete($data['search_role']);
            }

            if(!empty($data['id_permission'])){
                $saveData = array();
                for ($i=0; $i < count($data['id_permission']); $i++) {
                    $dataUpdate = array(
                        'role_id'           => $data['search_role'],
                        'permission_id'     => $data['id_permission'][$i]
                    );
                    array_push($saveData,$dataUpdate);
                }

                $create_form = $this->Model_permission->saveUpdate($saveData);
                if($create_form) {
                    $this->session->set_flashdata('success', ' Berhasil Disimpan !!');
                    redirect('settings/permission', 'refresh');
                } else {
                    $this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
                    redirect('settings/permission', 'refresh');
                }
            }else{
                $this->session->set_flashdata('success', ' Berhasil Disimpan !!');
                redirect('settings/permission', 'refresh');
            }

		}else{
			$this->session->set_flashdata('error', 'Silahkan Checklist, belum dipilih !!');
			redirect('settings/permission', 'refresh');
		}

	}


}

?>
