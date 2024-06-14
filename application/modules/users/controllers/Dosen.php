<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dosen extends Admin_Controller  {

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
		$this->load->model('Model_dosen');

	}

	public function starter()
	{
		$this->data['agama'] = $this->Model_global->getAgama();
		$this->data['jabatan'] = $this->Model_global->getJabatan();
		$this->data['kota'] = $this->Model_global->getKota();
	}


	public function index()
	{
		$this->starter();
		$this->render_template('dosen/index',$this->data);
	}

    public function store()
	{
		$cn 			= $this->router->fetch_class(); // Controller

		$draw           = $_REQUEST['draw'];
		$length         = $_REQUEST['length'];
		$start          = $_REQUEST['start'];
		$column 		= $_REQUEST['order'][0]['column'];
		$order 			= $_REQUEST['order'][0]['dir'];

        $output['data']	= array();
        $search_name    = $this->input->post('search_name');

		$data           = $this->Model_dosen->getDataStore('result',$search_name,$length,$start,$column,$order);
		$data_jum       = $this->Model_dosen->getDataStore('numrows',$search_name);

		$output=array();
		$output['draw'] = $draw;
		$output['recordsTotal'] = $output['recordsFiltered'] = $data_jum;

		if($search_name !="" ){
			$data_jum = $this->Model_dosen->getDataStore('numrows',$search_name);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){
			foreach ($data as $key => $value) {

				$id		= $value['nip'];
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

				if($value['aktif'] == 1){
					$aktif = '<div class="btn-group"><span class=" btn-outline-info btn-sm">Aktif</span></div>';
				}else{
					$aktif = '<div class="btn-group"><span class=" btn-outline-danger btn-sm">Nonktif</span></div>';
				}

				$nama_dosen = $value['gelar_depan'].' '.capital(strtolower($value['nama'])) .', '.$value['gelar_blk'];
				$output['data'][$key] = array(
					$value['nip'],
					$value['nidn'],
					$nama_dosen,
					capital(uppercase($value['nm_jabatan'])),
                    $value['status'],
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
		$this->data['dosen'] = $this->Model_dosen->detail($id);

		if($this->data['dosen']['nip']){
			$this->starter();
			$this->data['dosen'] = $this->Model_dosen->detail($id);

			$this->render_template('dosen/detail',$this->data);
		}else{
			$this->session->set_flashdata('error', 'Tidak Terdaftar, Silahkan Cek kembali !!');
			redirect('users/dosen', 'refresh');
		}

	}

	public function tambah()
	{

		$this->form_validation->set_rules('nip' ,'Nip ' , 'required');

        if ($this->form_validation->run() == TRUE) {

			$create_form = $this->Model_dosen->saveTambah();

			if($create_form) {
				$this->session->set_flashdata('success', ' Berhasil Disimpan !!');
				redirect('users/dosen', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
				redirect('users/dosen/tambah', 'refresh');
			}

		}else{
			$this->starter();
			$this->render_template('dosen/tambah',$this->data);
		}

	}

	public function edit($id)
	{

		$this->form_validation->set_rules('nip' ,'Nip ' , 'required');
        if ($this->form_validation->run() == TRUE) {

			$edit_form = $this->Model_dosen->saveEdit($id);

			if($edit_form) {
				$this->session->set_flashdata('success', 'Nip  : "'.$_POST['nip'].'" <br> Berhasil Di Update !!');
				redirect('users/dosen', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
				redirect('users/dosen/edit/'.$id, 'refresh');
			}

		}else{
			$this->starter();
			$this->data['dosen'] = $this->Model_dosen->detail($id);

			if($this->data['dosen']['nip']){
				$this->starter();
				$this->data['dosen'] = $this->Model_dosen->detail($id);

				$this->render_template('dosen/edit',$this->data);
			}else{
				$this->session->set_flashdata('error', 'NIP Tidak Terdaftar, Silahkan Cek kembali !!');
				redirect('users/dosen', 'refresh');
			}
		}
	}


	public function delete()
	{
		$id = $_POST['id'];

		$response = array();
		if($id) {
			$delete = $this->Model_dosen->saveDelete($id);

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
