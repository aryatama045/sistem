<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mata_kuliah extends Admin_Controller  {

	public function __construct()
	{
		parent::__construct();
		$this->auth->route_access();
		$this->data['modul'] = 'Master';
		$cn 	= $this->router->fetch_class(); // Controller
		$f 		= $this->router->fetch_method(); // Function
		$this->data['pagetitle'] = capital($cn);
		$this->data['function'] = capital($f);

		$this->load->model('Model_global');
		$this->load->model('Model_mata_kuliah');

	}

	public function starter()
	{
		$this->data['prodi'] = $this->Model_global->getKodeProgram();
	}


	public function index()
	{
		$this->starter();
		$this->render_template('mata_kuliah/index',$this->data);
	}


	public function store()
	{
		$draw           = $_REQUEST['draw'];
		$length         = $_REQUEST['length'];
		$start          = $_REQUEST['start'];
		$column 		= $_REQUEST['order'][0]['column'];
		$order 			= $_REQUEST['order'][0]['dir'];

        $output['data']	= array();
		$search_name   = $this->input->post('search_name');

		$data           = $this->Model_mata_kuliah->getDataStore('result',$search_name,$length,$start,$column,$order);
		$data_jum       = $this->Model_mata_kuliah->getDataStore('numrows',$search_name);

		$output=array();
		$output['draw'] = $draw;
		$output['recordsTotal'] = $output['recordsFiltered'] = $data_jum;

		if($search_name !=""  ){
			$data_jum = $this->Model_mata_kuliah->getDataStore('numrows',$search_name);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){
			foreach ($data as $key => $value) {
				$btn = '';
				$btn .= '<div class="btn-group">
							<button type="button" class="btn btn-sm btn btn-light dropdown-toggle mb-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Opsi
							</button>
							<div class="dropdown-menu">
								<a href="'.base_url('master/mata_kuliah/edit/'.$value['kode_matkul']).'" class="dropdown-item">
									<i data-acorn-icon="edit-square"></i> Edit</a>

								<div class="dropdown-divider"></div>
								<a href="'.base_url('master/mata_kuliah/delete/'.$value['kode_matkul']).'" class="dropdown-item">
									<i data-acorn-icon="bin"></i> Delete</a>
							</div>
						</div>';

                if($value['aktif'] == 1){
                    $aktif = '<div class="btn-group"><span class=" btn-outline-info btn-sm">Aktif</span></div>';
                }else{
                    $aktif = '<div class="btn-group"><span class=" btn-outline-danger btn-sm">Nonktif</span></div>';
                }

                $matkul = '<strong>'.capital(lowercase($value['nama_matkul'])).'</strong>';

				$output['data'][$key] = array(
					$value['kode_matkul'],
					$value['nama_prog'],
                    $matkul,
					$value['sks'],
                    $value['smt'],
                    $aktif,
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

		$this->form_validation->set_rules('kode_matkul' ,'Kode Mata Kuliah' , 'required');

        if ($this->form_validation->run() == TRUE) {

			$create_form = $this->Model_mata_kuliah->saveTambahMatkul();

			if($create_form) {
				$this->session->set_flashdata('success', 'Mata Kuliah Berhasil Disimpan !!');
				redirect('master/mata_kuliah', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
				redirect('master/mata_kuliah/tambah', 'refresh');
			}

		}else{
			$this->starter();
			$this->render_template('mata_kuliah/tambah',$this->data);
		}

	}

	public function edit($id)
	{
		$this->form_validation->set_rules('kode_matkul' ,'Kode Mata Kuliah' , 'required');

        if ($this->form_validation->run() == TRUE) {

			$edit_form = $this->Model_mata_kuliah->saveEditMatkul();

			if($edit_form) {
				$this->session->set_flashdata('success', 'Kode Mata Kuliah : "'.$_POST['kode_matkul'].'" <br> Berhasil Di Update !!');
				redirect('master/mata_kuliah', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
				redirect('master/mata_kuliah/edit/'.$id, 'refresh');
			}

		}else{
			$this->starter();
			$this->data['matkul'] = $this->Model_global->getMataKuliah($id);

			if($this->data['matkul']['kode_matkul']){
				$this->render_template('mata_kuliah/edit',$this->data);
			}else{
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
				redirect('master/mata_kuliah/edit/'.$id, 'refresh');
			}
		}
	}


	public function delete($id)
	{
		tesx($id);
	}

}

?>
