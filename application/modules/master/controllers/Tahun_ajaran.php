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
		$tahun_ajaran   = $this->input->post('tahun_ajaran');
        $semester    	= $this->input->post('semester');

		$data           = $this->Model_tahun_ajaran->getDataStore('result',$tahun_ajaran,$length,$start,$column,$order);
		$data_jum       = $this->Model_tahun_ajaran->getDataStore('numrows',$tahun_ajaran);

		$output=array();
		$output['draw'] = $draw;
		$output['recordsTotal'] = $output['recordsFiltered'] = $data_jum;

		if($tahun_ajaran !=""  ){
			$data_jum = $this->Model_tahun_ajaran->getDataStore('numrows',$tahun_ajaran);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){
			foreach ($data as $key => $value) {
				$btn = '';
				$btn .= '<a href="'.base_url('master/tahun_ajaran/detail/').'"
						class="btn btn-info btn-sm btn-shadow">
						<i class="iconsminds-magnifi-glass" ></i> Detail</a>';

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
