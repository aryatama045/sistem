<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa extends Admin_Controller  {

	public function __construct()
	{
		parent::__construct();
		$this->auth->route_access();
		$cn 	= $this->router->fetch_class(); // Controller
		$this->data['pagetitle']	= capital($cn);
		$f 		= $this->router->fetch_method(); // Function
		$this->data['function'] 	= capital($f);
		$this->data['modul'] 		= 'Users'; // name modul

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

		$this->data['data_mhs'] = $this->Model_mahasiswa->detail($id);

		if($this->data['data_mhs']['nim']){

			$this->data['mhs_user'] 	= $this->Model_mahasiswa->getMhsUserlogin($id);

			$this->data['smt_aktif'] 	= $this->Model_global->getSemesterMahasiswaAktif($id, '');

			$this->data['data_matkul'] 	= $this->Model_global->getMataKuliah();

			$this->data['data_matkulsmt'] 	= $this->Model_global->getMatkulPersmt();

			// tesx($this->data['data_matkulsmt'], $this->data['data_matkul']);

			$this->data['data_pmb'] 	= $this->Model_pmb->getDataPendaftaran($this->data['mhs_user']['no_pmb']);

			$this->data['dok_pmb']    	= $this->Model_pmb->getDokPendaftaran($this->data['mhs_user']['no_pmb']);

			$this->render_template('mahasiswa/detail',$this->data);
		}else{
			$this->session->set_flashdata('error', 'Tidak Terdaftar, Silahkan Cek kembali !!');
			redirect('users/mahasiswa', 'refresh');
		}

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

		$data           = $this->Model_mahasiswa->getDataStore('result',$search_name,$length,$start,$column,$order);
		$data_jum       = $this->Model_mahasiswa->getDataStore('numrows',$search_name);

		$output=array();
		$output['draw'] = $draw;
		$output['recordsTotal'] = $output['recordsFiltered'] = $data_jum;

		if($search_name !="" ){
			$data_jum = $this->Model_mahasiswa->getDataStore('numrows',$search_name);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){
			$no=1;
			foreach ($data as $key => $value) {

				$id		= $value['nim'];
				$btn 	= '';
				$btn 	.= '<div class="btn-group">
								<button type="button" class="btn btn-sm btn btn-light dropdown-toggle mb-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Opsi
								</button>
								<div class="dropdown-menu">
									<a href="'.base_url('users/'.$cn.'/detail/'.$id).'" class="dropdown-item">
										<i data-acorn-icon="search"></i> Detail</a>

									<a href="'.base_url('users/'.$cn.'/edit/'.$id).'" class="dropdown-item">
										<i data-acorn-icon="edit-square"></i> Edit</a>';

									$btn .= ' <a class="dropdown-item" onclick="';
									$btn .= "remove('".$id."')";
									$btn .= '" data-bs-toggle="modal" data-bs-target="#removeModal" >
											<i data-acorn-icon="bin"></i> Delete</a>

								</div>
							</div>';
				$output['data'][$key] = array(
					$no++,
					$value['nim'],
					capital(uppercase($value['nama_mhs'])),
					capital(uppercase($value['nama_prog'])),
                    $value['ta'],
                    nominal($value['kd_biaya']),
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

		$this->form_validation->set_rules('nim' ,'Nim ' , 'required');

        if ($this->form_validation->run() == TRUE) {

			$create_form = $this->Model_mahasiswa->saveTambah();

			if($create_form) {
				$this->session->set_flashdata('success', ' Berhasil Disimpan !!');
				redirect('users/mahasiswa', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
				redirect('users/mahasiswa/tambah', 'refresh');
			}

		}else{
			$this->starter();
			$this->data['prodi']        = $this->Model_global->getProdi();
            $this->data['ta'] 			= $this->Model_global->getTahunAjaran();
            $this->data['biaya']        = $this->Model_global->getBiaya();
			$this->data['agama']        = $this->Model_global->getAgama();
			$this->render_template('mahasiswa/tambah',$this->data);
		}

	}

	public function edit($id)
	{
		$this->form_validation->set_rules('nim' ,'Nim ' , 'required');
        if ($this->form_validation->run() == TRUE) {

			$edit_form = $this->Model_mahasiswa->saveEdit();

			if($edit_form) {
				$this->session->set_flashdata('success', 'Nim  : "'.$_POST['nim'].'" <br> Berhasil Di Update !!');
				redirect('users/mahasiswa', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
				redirect('users/mahasiswa/edit/'.$id, 'refresh');
			}

		}else{
			$this->starter();
			$this->data['mahasiswa'] = $this->Model_global->getMhsNim($id);

			if($this->data['mahasiswa']['nim']){
				$this->render_template('mahasiswa/edit',$this->data);
			}else{
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
				redirect('users/mahasiswa', 'refresh');
			}
		}
	}


	public function delete()
	{
		$id = $_POST['id'];

		$response = array();
		if($id) {
			$delete = $this->Model_mahasiswa->saveDelete($id);

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
			$response['messages'] 	= "Refresh the page again!!";
		}

		echo json_encode($response);
	}


}

?>
