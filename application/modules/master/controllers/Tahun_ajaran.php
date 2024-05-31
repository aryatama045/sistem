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

	public function store()
	{
		$draw           = $_REQUEST['draw'];
		$length         = $_REQUEST['length'];
		$start          = $_REQUEST['start'];
		$column 		= $_REQUEST['order'][0]['column'];
		$order 			= $_REQUEST['order'][0]['dir'];

        $output['data']	= array();
		$search_name   	= $this->input->post('search_name');

		$data           = $this->Model_tahun_ajaran->getDataStore('result',$search_name,$length,$start,$column,$order);
		$data_jum       = $this->Model_tahun_ajaran->getDataStore('numrows',$search_name);

		$output=array();
		$output['draw'] = $draw;
		$output['recordsTotal'] = $output['recordsFiltered'] = $data_jum;

		if($search_name !=""  ){
			$data_jum = $this->Model_tahun_ajaran->getDataStore('numrows',$search_name);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){
			foreach ($data as $key => $value) {
				$btn = '';
				$btn .= '<div class="d-inline-block " >
                            <button class="btn p-0" data-bs-toggle="dropdown" type="button" data-bs-offset="0,3">
                                <span class="btn btn-icon btn-icon-only btn-foreground-alternate shadow dropdown"
                                data-bs-delay="0" data-bs-placement="top" data-bs-toggle="tooltip"
                                title="Action" >
                                    <i data-acorn-icon="gear"></i>
                                </span>
                            </button>
                            <div class="dropdown-menu shadow dropdown-menu-end">
                                <a href="'.base_url('master/mata_kuliah/edit/'.$value['kd_ta']).'" class="dropdown-item">
                                    <i data-acorn-icon="edit-square"></i> Edit</a>
                                <a href="'.base_url('master/mata_kuliah/delete/'.$value['kd_ta']).'" class="dropdown-item">
                                    <i data-acorn-icon="bin"></i> Delete</a>
                            </div>
                        </div>';

				if($value['aktif'] == 1){
					$aktif = '<span class="btn btn-primary btn-sm">Aktif</span>';
				}else{
					$aktif = '';
				}

				$output['data'][$key] = array(
					$value['kd_ta'],
					$value['ta'],
					$value['smt'],
					$aktif,
					$btn,
				);
			}

		} else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}

}

?>
