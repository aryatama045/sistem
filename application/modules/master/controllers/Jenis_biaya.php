<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis_biaya extends Admin_Controller  {

	public function __construct()
	{
		parent::__construct();
		$this->auth->route_access();
		$this->data['modul'] = 'Master'; // Modul
		$cn 	= $this->router->fetch_class(); // Controller
		$f 		= $this->router->fetch_method(); // Function
		$this->data['pagetitle'] = capital($cn);
		$this->data['function'] = capital($f);

		//  Load Model
		$this->load->model('Model_jenis_biaya');

	}

	public function starter()
	{}

	public function index()
	{
		$this->starter();
		$this->render_template('jenis_biaya/index',$this->data);
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
        $search_name    = $this->input->post('search_name');

		$data           = $this->Model_jenis_biaya->getDataStore('result',$search_name,$length,$start,$column,$order);
		$data_jum       = $this->Model_jenis_biaya->getDataStore('numrows',$search_name);

		$output=array();
		$output['draw'] = $draw;
		$output['recordsTotal'] = $output['recordsFiltered'] = $data_jum;

		if($search_name !="" ){
			$data_jum = $this->Model_jenis_biaya->getDataStore('numrows',$search_name);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){
			foreach ($data as $key => $value) {
				$id		= $value['kd_jenis'];
				$btn 	= '';
				$btn 	.= '<div class="btn-group">
							<button type="button" class="btn btn-sm btn btn-light dropdown-toggle mb-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opsi</button>
							<div class="dropdown-menu">
								<a href="'.base_url('master/'.$cn.'/edit/'.$id).'" class="dropdown-item">
									<i data-acorn-icon="edit-square"></i> Edit</a>';
								$btn .= ' <a class="dropdown-item" onclick="';
								$btn .= "remove('".$id."')";
								$btn .= '" data-bs-toggle="modal" data-bs-target="#removeModal"><i data-acorn-icon="bin"></i> Delete</a>
							</div>
						</div>';
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



	public function tambah()
	{

		$this->form_validation->set_rules('nama_biaya' ,'Kode ' , 'required');

        if ($this->form_validation->run() == TRUE) {

			$create_form = $this->Model_jenis_biaya->saveTambah();

			if($create_form) {
				$this->session->set_flashdata('success', ' Berhasil Disimpan !!');
				redirect('master/jenis_biaya', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
				redirect('master/jenis_biaya/tambah', 'refresh');
			}

		}else{
			$this->starter();
			$this->data['ta'] 			= $this->Model_global->getTahunAjaran();
			$this->data['jenma'] 		= $this->Model_global->getJenma();
			$this->render_template('jenis_biaya/tambah',$this->data);
		}

	}

	public function edit($id)
	{
		$this->form_validation->set_rules('kd_jenis' ,'Kode ' , 'required');

        if ($this->form_validation->run() == TRUE) {

			$edit_form = $this->Model_jenis_biaya->saveEdit();

			if($edit_form) {
				$this->session->set_flashdata('success', 'Kode  : "'.$_POST['kd_jenis'].'" <br> Berhasil Di Update !!');
				redirect('master/jenis_biaya', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
				redirect('master/jenis_biaya/edit/'.$id, 'refresh');
			}

		}else{
			$this->starter();
			$this->data['jenis_biaya'] 	= $this->Model_global->getJenisBiaya($id);

			if($this->data['jenis_biaya']['kd_jenis']){
				$this->render_template('jenis_biaya/edit',$this->data);
			}else{
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
				redirect('master/jenis_biaya/edit/'.$id, 'refresh');
			}
		}
	}

	public function delete()
	{
		$id = $_POST['id'];

		$response = array();
		if($id) {
			$delete = $this->Model_jenis_biaya->saveDelete($id);

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
