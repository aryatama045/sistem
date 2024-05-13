<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis_biaya extends Admin_Controller  {

	public function __construct()
	{
		parent::__construct();
		$this->auth->route_access();
		$cn 	= $this->router->fetch_class(); // Controller
		$this->data['pagetitle']	= capital($cn);
		$f 		= $this->router->fetch_method(); // Function
		$this->data['function'] 	= capital($f);
		$this->data['modul'] 		= 'Master'; // name modul

		//  Load Model
		$this->load->model('Model_jenis_biaya');

	}

	public function starter()
	{

	}


	public function index()
	{
		$this->starter();
		$this->render_template('jenis_biaya/index',$this->data);
	}


	public function getDataStore()
	{

		$draw           = $_REQUEST['draw'];
		$length         = $_REQUEST['length'];
		$start          = $_REQUEST['start'];
		$column 		= $_REQUEST['order'][0]['column'];
		$order 			= $_REQUEST['order'][0]['dir'];

        $output['data']	= array();
		$search_no      = $this->input->post('kd_jenis');
        $search_nama    = $this->input->post('nama_biaya');

		$data           = $this->Model_jenis_biaya->getDataStore('result',$search_no,$search_nama,$length,$start,$column,$order);
		$data_jum       = $this->Model_jenis_biaya->getDataStore('numrows',$search_no,$search_nama);

		$output=array();
		$output['draw'] = $draw;
		$output['recordsTotal'] = $output['recordsFiltered'] = $data_jum;

		if($search_no !="" || $search_nama !="" ){
			$data_jum = $this->Model_jenis_biaya->getDataStore('numrows',$search_no,$search_nama);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){
			foreach ($data as $key => $value) {
				$btn = '';
				$btn .= '<a href="'.base_url('master/jenis_biaya/detail/'.$value['kd_jenis']).'"
						class="btn btn-primary btn-sm btn-shadow">
                        <i class="iconsminds-magnifi-glass" ></i> Detail</a>';
				$output['data'][$key] = array(
					$value['kd_jenis'],
					capital(uppercase($value['nama_biaya'])),
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
