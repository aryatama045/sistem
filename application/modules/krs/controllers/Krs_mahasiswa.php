<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Krs_mahasiswa extends Admin_Controller  {

	public function __construct()
	{
		parent::__construct();
		$this->auth->route_access();
		$this->data['modul'] = 'Admin';
		$cn 	= $this->router->fetch_class(); // Controller
		$f 		= $this->router->fetch_method(); // Function
		$this->data['pagetitle'] = capital($cn);
		$this->data['function'] = capital($f);

		$this->load->model('Model_krs_mahasiswa');

	}

	public function starter()
	{

	}


	public function index()
	{
		$this->starter();
		$this->render_template('periode_pmb/index',$this->data);
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

		$data           = $this->Model_jadwal_pengajaran->getDataStore('result',$search_name,$length,$start,$column,$order);
		$data_jum       = $this->Model_jadwal_pengajaran->getDataStore('numrows',$search_name);

		$output=array();
		$output['draw'] = $draw;
		$output['recordsTotal'] = $output['recordsFiltered'] = $data_jum;

		if($search_name !=""  ){
			$data_jum = $this->Model_jadwal_pengajaran->getDataStore('numrows',$search_name);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){
			foreach ($data as $key => $value) {
				$id		= $value['kode'];

				$btn 	= '';
				$btn 	.= '<div class="btn-group">
							<button type="button" class="btn btn-sm btn btn-light dropdown-toggle mb-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Opsi
							</button>
							<div class="dropdown-menu">
								<a href="'.base_url('admin/'.$cn.'/edit/'.$id).'" class="dropdown-item">
									<i data-acorn-icon="edit-square"></i> Edit</a>';

								$btn .= ' <a class="dropdown-item" onclick="';
								$btn .= "remove('".$id."')";
								$btn .= '" data-bs-toggle="modal" data-bs-target="#removeModal" >
										<i data-acorn-icon="bin"></i> Delete</a>

							</div>
						</div>';

				$output['data'][$key] = array(
					$value['gel'],
					$value['ta'],
                    $value['tgl_awal'],
                    $value['tgl_akhir'],
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

			$create_form = $this->Model_jadwal_pengajaran->saveTambah();

			if($create_form) {
				$this->session->set_flashdata('success', ' Berhasil Disimpan !!');
				redirect('admin/periode_pmb', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
				redirect('admin/periode_pmb/tambah', 'refresh');
			}

		}else{
			$this->starter();
            $this->data['ta']           = $this->Model_global->getTahunAjaran();
			$this->render_template('periode_pmb/tambah',$this->data);
		}

	}

	public function edit($id)
	{

		$this->form_validation->set_rules('gel' ,'Periode ' , 'required');

        if ($this->form_validation->run() == TRUE) {

			$edit_form = $this->Model_jadwal_pengajaran->saveEdit($id);

			if($edit_form) {
				$this->session->set_flashdata('success', 'Gelombang  : "'.$_POST['gel'].'" <br> Berhasil Di Update !!');
				redirect('admin/periode_pmb', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
				redirect('admin/periode_pmb' , 'refresh');
			}

		}else{
			$this->starter();
            $this->data['ta']           = $this->Model_global->getTahunAjaran();
            $this->data['periode_pmb']  = $this->Model_global->getPeriodeDaftar($id);

			if($this->data['periode_pmb']['kode']){
				$this->render_template('periode_pmb/edit',$this->data);
			}else{
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
				redirect('admin/periode_pmb' , 'refresh');
			}
		}
	}


	public function delete()
	{
		$id = $_POST['id'];

		$response = array();
		if($id) {
			$delete = $this->Model_jadwal_pengajaran->saveDelete($id);

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
