<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mata_kuliah extends Admin_Controller  {

	public function __construct()
	{
		parent::__construct();
		$this->auth->route_access();
		$this->data['modul'] = 'Master';
		$cn 	= $this->router->fetch_class(); // Controller
		$f 		= $this->router->fetch_method(); // Function
		$this->data['pagetitle'] = capital($cn);
		$this->data['function'] = capital($f);

		$this->load->model('Model_mata_kuliah');

	}

	public function starter()
	{

	}


	public function index()
	{
		$this->starter();
		$this->render_template('mata_kuliah/index',$this->data);
	}

	public function store()
	{
		$draw           = $_REQUEST['draw'];
		$length         = $_REQUEST['length'];
		$start          = $_REQUEST['start'];
		$column 		= $_REQUEST['order'][0]['column'];
		$order 			= $_REQUEST['order'][0]['dir'];

        $output['data']	= array();
		$search_name   = $this->input->post('search_name');

		$data           = $this->Model_mata_kuliah->getDataStore('result',$search_name,$length,$start,$column,$order);
		$data_jum       = $this->Model_mata_kuliah->getDataStore('numrows',$search_name);

		$output=array();
		$output['draw'] = $draw;
		$output['recordsTotal'] = $output['recordsFiltered'] = $data_jum;

		if($search_name !=""  ){
			$data_jum = $this->Model_mata_kuliah->getDataStore('numrows',$search_name);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){
			foreach ($data as $key => $value) {
				$btn = '';
				$btn .= '<a href="'.base_url('master/prodi/detail/').'"
						class="btn btn-info btn-sm btn-shadow">
                        <i class="iconsminds-magnifi-glass" ></i> Detail</a>';

                if($value['aktif'] == 1){
                    $aktif = '<span class="btn btn-primary btn-sm">Aktif</span>';
                }else{
                    $aktif = '<span class="btn btn-default btn-sm">Nonktif</span>';
                }

				$output['data'][$key] = array(
					$value['kd_prog'],
					$value['kode_matkul'],
                    $value['nama_matkul'],
					$value['sks'],
                    $value['smt'],
                    $aktif,
					$btn,
				);
			}

		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}

}

?>
