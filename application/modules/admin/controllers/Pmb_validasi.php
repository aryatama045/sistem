<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pmb_validasi extends Admin_Controller  {

	public function __construct()
	{
		parent::__construct();
		$this->auth->route_access();
		$this->data['modul'] = 'Admin';
		$cn 	= $this->router->fetch_class(); // Controller
		$f 		= $this->router->fetch_method(); // Function
		$this->data['pagetitle'] = capital($cn);
		$this->data['function'] = capital($f);

		$this->load->model('Model_pmb');
        $this->load->model('Model_pmb_validasi');

	}

	public function starter()
	{}


	public function index()
	{
		$this->starter();
		$this->render_template('pmb_validasi/index',$this->data);
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

		$data           = $this->Model_pmb_validasi->getDataStore('result',$search_name,$length,$start,$column,$order);
		$data_jum       = $this->Model_pmb_validasi->getDataStore('numrows',$search_name);

		$output=array();
		$output['draw'] = $draw;
		$output['recordsTotal'] = $output['recordsFiltered'] = $data_jum;

		if($search_name !=""  ){
			$data_jum = $this->Model_pmb_validasi->getDataStore('numrows',$search_name);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){
			foreach ($data as $key => $value) {
				$id		= $value['no_pendaftaran'];

				$btn 	= '';
                $btn 	.= '<a href='.base_url('admin/'.$cn.'/detail/'.$id).' class="btn btn-sm btn-primary"> Validasi</a>';

				$output['data'][$key] = array(
					$value['no_pendaftaran'],
                    $value['nama'],
					$btn,
				);
			}

		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}

	public function berkas_validasi($no_pmb)
	{

		$validasi = $this->input->post('id');

		$get_dok  = $this->Model_pmb->getDokPendaftaran($no_pmb);

		if($validasi){

			$count 				= count($validasi);
			for($x=0; $x < $count;  $x++){
				$id_dok = $this->input->post('id')[$x];
				$data_berkas = array(
					'nama_dok' 		=> $this->input->post('nama_dok')[$x],
					'ket_validasi' 	=> $this->input->post('ket_validasi')[$x],
					'validasi' 		=> '1',
					'pic_validasi' 	=> $this->session->userdata('userID'),
					'tgl_validasi' 	=> date('Y-m-d'),
				);
				$this->Model_pmb_validasi->saveBerkasValidasi($no_pmb, $id_dok, $data_berkas);
			}

			if($count == '6'){
				$save = $this->Model_pmb_validasi->saveValidasi($no_pmb);
			}else{
				$save = TRUE;
			}

			if($save){
				$this->session->set_flashdata('success', 'PMB Validasi, No. Pendaftaran : '.$no_pmb.' Berhasil di simpan !!');
				redirect('admin/pmb_validasi', 'refresh');
			}else{
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
				redirect('admin/pmb_validasi/detail/'.$no_pmb, 'refresh');
			}

		}else{
			$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
			redirect('admin/pmb_validasi/detail/'.$no_pmb, 'refresh');
		}


	}

	public function detail($id)
	{
		$this->form_validation->set_rules('gel' ,'Periode ' , 'required');

        if ($this->form_validation->run() == TRUE) {

			$edit_form = $this->Model_pmb_validasi->saveProses();

			if($edit_form) {
				$this->session->set_flashdata('success', 'Kode  : "'.$_POST['no_pendaftaran'].'" <br> Berhasil Di Update !!');
				redirect('admin/pmb_validasi', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
				redirect('admin/pmb_validasi/edit/'.$id, 'refresh');
			}

		}else{
			$this->starter();
            $this->data['ta']            = $this->Model_global->getTahunAjaran();
            $this->data['pmb_validasi']  = $this->Model_pmb->getDataPendaftaran($id);
			$this->data['dok_pmb']    	 = $this->Model_pmb->getDokPendaftaran($id);

			if($this->data['pmb_validasi']['no_pendaftaran']){
				$this->render_template('pmb_validasi/detail',$this->data);
			}else{
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
				redirect('admin/pmb_validasi/detail/'.$id, 'refresh');
			}
		}
	}

	public function tambah()
	{

		$this->form_validation->set_rules('gel' ,'Periode ' , 'required');

        if ($this->form_validation->run() == TRUE) {

			$create_form = $this->Model_pmb_validasi->saveTambah();

			if($create_form) {
				$this->session->set_flashdata('success', ' Berhasil Disimpan !!');
				redirect('admin/pmb_validasi', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Silahkan Cek kembali data yang di input !!');
				redirect('admin/pmb_validasi/tambah', 'refresh');
			}

		}else{
			$this->starter();
            $this->data['ta']           = $this->Model_global->getTahunAjaran();
			$this->render_template('pmb_validasi/tambah',$this->data);
		}

	}

	public function delete()
	{
		$id = $_POST['id'];

		$response = array();
		if($id) {
			$delete = $this->Model_pmb_validasi->saveDelete($id);

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
