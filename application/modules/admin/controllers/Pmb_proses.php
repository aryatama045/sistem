<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pmb_proses extends Admin_Controller  {

	public function __construct()
	{
		parent::__construct();
		$this->auth->route_access();
		$this->data['modul'] = 'Admin';
		$cn 	= $this->router->fetch_class(); // Controller
		$f 		= $this->router->fetch_method(); // Function
		$this->data['pagetitle'] = capital($cn);
		$this->data['function'] = capital($f);

		$this->load->model('Model_pmb_proses');

	}

	public function starter()
	{}


	public function index()
	{
		$this->starter();
		$this->render_template('pmb_proses/index',$this->data);
	}

	public function store()
	{
		$cn 	= $this->router->fetch_class(); // Controller

		$draw           = $_REQUEST['draw'];
		$length         = $_REQUEST['length'];
		$start          = $_REQUEST['start'];
		$column 		= $_REQUEST['order'][0]['column'];
		$order 			= $_REQUEST['order'][0]['dir'];

        $output['data']	= array();
		$search_name   = $this->input->post('search_name');

		$data           = $this->Model_pmb_proses->getDataStore('result',$search_name,$length,$start,$column,$order);
		$data_jum       = $this->Model_pmb_proses->getDataStore('numrows',$search_name);

		$output=array();
		$output['draw'] = $draw;
		$output['recordsTotal'] = $output['recordsFiltered'] = $data_jum;

		if($search_name !=""  ){
			$data_jum = $this->Model_pmb_proses->getDataStore('numrows',$search_name);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){
			foreach ($data as $key => $value) {
				$id		= $value['no_pendaftaran'];

				$btn 	= '';
				$btn 	.= '<a href='.base_url('admin/'.$cn.'/detail/'.$id).' class="btn btn-sm btn-primary"> Proses Nim</a>';


				$output['data'][$key] = array(
					$value['no_pendaftaran'],
					$value['nik'],
                    $value['nama'],
                    $value['email'],
					$btn,
				);
			}

		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}

	public function detail($id)
	{
		$this->form_validation->set_rules('no_pmb' ,'Periode ' , 'required');

        if ($this->form_validation->run() == TRUE) {

			$edit_form = $this->Model_pmb_proses->saveProses();

			if($edit_form) {
				$this->session->set_flashdata('success', 'PMB No.  : "'.$id.'" <br> Berhasil Di Proses Nim !!');
				redirect('admin/pmb_proses', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
				redirect('admin/pmb_proses/detail/'.$id, 'refresh');
			}

		}else{
			$this->starter();
            $this->data['ta']            = $this->Model_global->getTahunAjaran();
			$this->data['pmb_proses']    = $this->Model_pmb->getDataPendaftaran($id);
			$this->data['dok_pmb']    	 = $this->Model_pmb->getDokPendaftaran($id);

			if($this->data['pmb_proses']['no_pendaftaran']){
				$this->render_template('pmb_proses/detail',$this->data);
			}else{
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
				redirect('admin/pmb_proses/detail/'.$id, 'refresh');
			}
		}
	}




}

?>
