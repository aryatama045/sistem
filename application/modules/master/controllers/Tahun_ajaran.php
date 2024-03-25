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
		$output = array('data' => array());

		$data 		= $this->Model_tahun_ajaran->getDataStore();


		foreach($data as $key => $value){

			$output['data'][$key] = [
				"Name" => $value['kd_ta'],
				"Sales" =>$value['ta'],
				"Stock" =>$value['smt'],
				"Category" =>$value['aktif'],
				"Tag" =>$value['aktif'],
				"Check" =>$value['aktif']
			];
		}


		echo json_encode($output);

	}

	public function store2()
	{
		$output = array('data' => array());

		$draw			= $_REQUEST['draw'];
		$length 		= $_REQUEST['length'];
		$start			= $_REQUEST['start'];
		$column 		= $_REQUEST['order'][0]['column'];
		$order			= $_REQUEST['order'][0]['dir'];
		$search_no   	= $_REQUEST['columns'][0]['search']["value"];

		$data 			= $this->Model_tahun_ajaran->getDataStore($search_no,$length,$start,$column,$order);
		$data_jum 		= $this->Model_tahun_ajaran->getDataStore2($search_no);
		$output			= array();
		// $output['draw']	= $draw;
		$output['recordsTotal'] = $output['recordsFiltered'] = $data_jum;

		if($search_no !="" ){
			$data_jum = $this->Model_tahun_ajaran->getDataStore2($search_no);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){
			foreach ($data as $key => $value) {
				$output['data'][$key] = array(
					$value['no_dok_tdk_masuk'],
					$value['tgl_dok'],
					$value['keterangan'],
					$value['potong_cuti_dari'],
					$value['status'],
					$value['posting']
				);
			}
		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}

}

?>
