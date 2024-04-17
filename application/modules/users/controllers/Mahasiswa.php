<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa extends Admin_Controller  {

	public function __construct()
	{
		parent::__construct();
		$this->auth->route_access();
		$this->data['modul'] = 'Manage Users';
		$cn 	= $this->router->fetch_class(); // Controller
		$f 		= $this->router->fetch_method(); // Function
		$this->data['pagetitle'] = capital($cn);
		$this->data['function'] = capital($f);

		//  Load Model
		$this->load->model('Model_mahasiswa');

	}

	public function starter()
	{

	}


	public function index()
	{
		$this->starter();
		$this->render_template('mahasiswa/index',$this->data);
	}

	public function detail($id)
	{
		$this->starter();
		$this->render_template('mahasiswa/detail',$this->data);
	}

    public function getDataStore()
	{

		$draw           = $_REQUEST['draw'];
		$length         = $_REQUEST['length'];
		$start          = $_REQUEST['start'];
		$column 		= $_REQUEST['order'][0]['column'];
		$order 			= $_REQUEST['order'][0]['dir'];
		// $search_nama   	= $_REQUEST['columns'][0]['search']["value"];

		// tesx($search_nama);

        $output['data']	= array();
		$search_no      = $this->input->post('nim');
        $search_nama    = $this->input->post('nama_mhs');

		$data           = $this->Model_mahasiswa->getDataStore('result',$search_no,$search_nama,$length,$start,$column,$order);
		$data_jum       = $this->Model_mahasiswa->getDataStore('numrows',$search_no,$search_nama);

		$output=array();
		$output['draw'] = $draw;
		$output['recordsTotal'] = $output['recordsFiltered'] = $data_jum;

		if($search_no !="" || $search_nama !="" ){
			$data_jum = $this->Model_mahasiswa->getDataStore('numrows',$search_no,$search_nama);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

        // tesx($data_jum);

		if($data){
			foreach ($data as $key => $value) {
				$btn = '';
				$btn .= '<a href="'.base_url('users/mahasiswa/detail/'.$value['nim']).'"
						class="btn btn-primary btn-sm btn-shadow">
                        <i class="iconsminds-magnifi-glass" ></i> Detail</a>';
				$output['data'][$key] = array(
					$value['nim'],
					capital(uppercase($value['nama_mhs'])),
					$value['kd_prog'],
                    $value['kd_ta'],
                    nominal($value['kd_biaya']),
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
