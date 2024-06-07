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

	public function tambah()
	{

		$this->form_validation->set_rules('gel' ,'Periode ' , 'required');

        if ($this->form_validation->run() == TRUE) {

			$create_form = $this->Model_pmb_proses->saveTambah();

			if($create_form) {
				$this->session->set_flashdata('success', ' Berhasil Disimpan !!');
				redirect('admin/pmb', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
				redirect('admin/pmb/tambah', 'refresh');
			}

		}else{
			$this->starter();
            $this->data['ta']           = $this->Model_global->getTahunAjaran();
			$this->render_template('pmb/tambah',$this->data);
		}

	}

	public function edit($id)
	{
		$this->form_validation->set_rules('gel' ,'Periode ' , 'required');

        if ($this->form_validation->run() == TRUE) {

			$edit_form = $this->Model_pmb_proses->saveEdit();

			if($edit_form) {
				$this->session->set_flashdata('success', 'Kode  : "'.$_POST['no_pendaftaran'].'" <br> Berhasil Di Update !!');
				redirect('admin/pmb', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
				redirect('admin/pmb/edit/'.$id, 'refresh');
			}

		}else{
			$this->starter();
            $this->data['ta']           = $this->Model_global->getTahunAjaran();
            $this->data['pmb']  = $this->Model_global->getPeriodeDaftar($id);

            // tesx($this->data['ta']);

			if($this->data['pmb']['no_pendaftaran']){
				$this->render_template('pmb/edit',$this->data);
			}else{
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
				redirect('admin/pmb/edit/'.$id, 'refresh');
			}
		}
	}


	public function delete()
	{
		$id = $_POST['id'];

		$response = array();
		if($id) {
			$delete = $this->Model_pmb_proses->saveDelete($id);

			if($delete == true) {
				$response['success'] 	= true;
				$response['messages'] 	= " <strong>Kode '".$id."'</strong> Berhasil Di Remove";
			} else {
				$response['success'] 	= false;
				$response['messages'] 	= " <strong>Kode '".$id."'</strong> Gagal Di Remove";
			}
		}
		else {
			$response['success'] 	= false;
			$response['messages'] 	= "Refersh the page again!!";
		}

		echo json_encode($response);
	}


}

?>
