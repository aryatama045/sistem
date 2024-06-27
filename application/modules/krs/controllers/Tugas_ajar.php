<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tugas_ajar extends Admin_Controller  {

	public function __construct()
	{
		parent::__construct();
		$this->auth->route_access();
		$this->data['modul'] = 'Krs';
		$cn 	= $this->router->fetch_class(); // Controller
		$f 		= $this->router->fetch_method(); // Function
		$this->data['pagetitle'] = capital($cn);
		$this->data['function'] = capital($f);

		$this->load->model('Model_tugas_ajar');

	}

	public function starter()
	{
		$this->data['dataDosen'] = $this->Model_global->getDosen();
        $this->data['dataProdi'] = $this->Model_global->getProdi();
	}


	public function index()
	{
		$this->starter();
		$this->render_template('tugas_ajar/index',$this->data);
	}

	public function store()
	{
		$cn 	= $this->router->fetch_class(); // Controller

		$draw           = $_REQUEST['draw'];
		// $length         = $_REQUEST['length'];
        $length         = 50;
		$start          = $_REQUEST['start'];
		$column 		= $_REQUEST['order'][0]['column'];
		$order 			= $_REQUEST['order'][0]['dir'];

        $output['data']	= array();
		$search_name   	= $this->input->post('search_name');
		$search_prodi   = $this->input->post('search_prodi');
		$search_dosen   = $this->input->post('search_dosen');


		$data           = $this->Model_tugas_ajar->getDataStore('result',$search_name,$search_prodi,$search_dosen,$length,$start,$column,$order);
		$data_jum       = $this->Model_tugas_ajar->getDataStore('numrows',$search_name,$search_prodi,$search_dosen);

		$output=array();
		$output['draw'] = $draw;
		$output['recordsTotal'] = $output['recordsFiltered'] = $data_jum;

		if($search_name !="" || $search_prodi !="" || $search_dosen !=""  ){
			$data_jum = $this->Model_tugas_ajar->getDataStore('numrows',$search_name,$search_prodi,$search_dosen);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){
			foreach ($data as $key => $value) {
				$id		= $value['id'];

				$checked ='';
				if($id){
					$checked .= 'checked';
				}

				$btn 	= '';
				$btn 	.= '<label class="form-check w-100 checked-line-through checked-opacity-75">
								<input type="checkbox" name="id_tugas_ajar[]" value="'.$value['kdmatkul'].'" class="form-check-input" '.$checked.'  />
							</label>';

				$output['data'][$key] = array(
					$btn,
                    $value['kdmatkul'],
                    uppercase(strtolower($value['nama_matkul'])),

				);
			}

		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}


	public function tambah()
	{

        $this->form_validation->set_rules('search_dosen' ,'Dosen Belum Dipilih ' , 'required');

        if ($this->form_validation->run() == TRUE)
        {
            $data = $_POST;

            // Delete Data sebelumnya
            if($data['search_dosen']){
                $delete = $this->Model_tugas_ajar->saveDelete($data['search_dosen'], $data['search_prodi']);
            }

            if(!empty($data['id_tugas_ajar'])){
                $saveData = array();
                for ($i=0; $i < count($data['id_tugas_ajar']); $i++) {
                    $dataMatkul = array(
                        'kd_ta'         => $this->Model_global->getTahunAjaranAktif()['kd_ta'],
                        'nip'           => $data['search_dosen'],
                        'kd_prog'       => $data['search_prodi'],
                        'kode_matkul'   => $data['id_tugas_ajar'][$i]

                    );
                    array_push($saveData,$dataMatkul);
                }

                $create_form = $this->Model_tugas_ajar->saveTambah($saveData);

                if($create_form) {
                    $this->session->set_flashdata('success', ' Berhasil Disimpan !!');
                    redirect('krs/tugas_ajar', 'refresh');
                } else {
                    $this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
                    redirect('krs/tugas_ajar', 'refresh');
                }
            }else{
                $this->session->set_flashdata('success', ' Berhasil Disimpan !!');
                redirect('krs/tugas_ajar', 'refresh');
            }

		}else{
			$this->session->set_flashdata('error', 'Silahkan Checklist Dosen, belum dipilih !!');
			redirect('krs/tugas_ajar', 'refresh');
		}

	}




}

?>
