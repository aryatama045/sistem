<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Data_app extends Admin_Controller  {
	private $hrd;
	public function __construct()
	{
		$this->data['modul'] = "Leaves";
		parent::__construct();
		$this->not_logged_in();
		$this->data['page_title'] = 'Report';
		$this->load->model('Model_report');
		$this->load->model('User/Model_approve');
		$this->load->model('Model_cuti');
		$this->load->model('Model_leave');
		$this->load->model('user/Model_approve');
		$this->hrd 		= $this->load->database('hrd',TRUE);
		$this->hrdsave 	= $this->load->database('hrd_save',TRUE);
	}

	public function form()
	{
		$this->data['approval']  	= $this->Model_leave->PicApproval();
		$this->data['verifikasi']  	= $this->Model_leave->PicVerifikasiHrd();
		$this->data['nm_divisi'] = $this->Model_report->getDataDivisi()->result();
		$this->data['data_karyawan'] 	= $this->Model_approve->getDataKaryawan();
		$this->data['pic_approve'] 	= $this->Model_approve->getPicApprove();

	}

	public function index()
	{
		$this->form();
		$this->data['data_karyawan'] 	= $this->Model_approve->getDataKaryawan();
		$this->render_template('data_app/index',$this->data);
	}

	public function create()
	{
		$this->form_validation->set_rules('tgl_tdk_masuk[]','Tanggal Cuti','required|callback_tgl_unique',
			array(	'required' 	=> 'Tanggal Cuti Tidak Boleh Kosong !!',
			));
		if ($this->form_validation->run() == TRUE) {
			$create_form = $this->Model_report->create();
			if($create_form) {
				$this->session->set_flashdata('success', 'Cuti "'.$create_form.'" Berhasil Disimpan');
				redirect('leaves/data_app/index/', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Error occurred!!');
				redirect('leaves/data_app/create', 'refresh');
			}
		} else {
			$this->form();
			$this->render_template('data_app/create', $this->data);
		}
	}

	public function get_data_departement()
	{
		$divisi_id = $this->input->post('id');
		$data = $this->Model_report->getDataDepartement($divisi_id)->result();
		echo json_encode($data);
	}

	public function get_data_store()
	{
		$divisi_id = $this->input->post('divisi_id');
		$departement_id = $this->input->post('id');
		$data = $this->Model_report->getDataStore($divisi_id,$departement_id)->result();
		echo json_encode($data);
	}


	public function fetchDataAbsen()
	{
		// $output = array('data' => array());

		$draw=$_REQUEST['draw'];
		$length=$_REQUEST['length'];
		$start=$_REQUEST['start'];
		//$search=$_REQUEST['search']["value"];
		$column = $_REQUEST['order'][0]['column'];
		$order 		= $_REQUEST['order'][0]['dir'];
		$search_no  = $_REQUEST['columns'][0]['search']["value"];

		$output['data']=array();
		$nip 		= $this->session->userdata('nama_login');
		$id_divisi = $this->input->post('id_divisi');
		$id_dept = $this->input->post('id_dept');
		$kd_store = $this->input->post('kd_store');
		$nip = $this->input->post('nip_cuti');

		$data = $this->Model_report->getDataApprovalPersonil($id_divisi,$id_dept,$nip,$length,$start);


		$data_jum = $this->Model_report->getJumlahDataApprovalPersonil($id_divisi,$id_dept,$nip);
		$output=array();

		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		if($search_no !="" ){
			$data_jum = $this->Model_report->getJumlahDataApprovalPersonil($id_divisi,$id_dept,$nip);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}
		if($data){
			foreach ($data as $key => $value) {
					$output['data'][$key] = array(
						$value['nip'],
						$value['nama_lengkap'],
						$value['cnama_lengkap'],
						$value['urutan_approval'],
						$value['kd_store'],
					);
			}
		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}

	public function fetchDataPic()
	{

		$draw=$_REQUEST['draw'];
		$length=$_REQUEST['length'];
		$start=$_REQUEST['start'];
		$column = $_REQUEST['order'][0]['column'];
		$order 		= $_REQUEST['order'][0]['dir'];
		$search_no  = $_REQUEST['columns'][0]['search']["value"];

		$output['data']=array();

		$data = $this->Model_report->getDataPic($length,$start);
		$data_jum = $this->Model_report->getJumlahDataPic();
		$output=array();

		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		if($search_no !="" ){
			$data_jum = $this->Model_report->getJumlahDataPic();
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){
			foreach ($data as $key => $value) {
					$output['data'][$key] = array(
						$value['nip'],
						$value['nama_lengkap'],
						$value['nama_dept'],
						$value['kd_store'],
					);
			}
		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}

	public function fetchListCP()
	{

		$draw		= $_REQUEST['draw'];
		$length		= $_REQUEST['length'];
		$start		= $_REQUEST['start'];
		$column 	= $_REQUEST['order'][0]['column'];
		$order 		= $_REQUEST['order'][0]['dir'];
		$search_no  = $_REQUEST['columns'][0]['search']["value"];

		$output['data']=array();
		$nip 	= $this->input->post('nip');

		// tesx($nip);

		$data = $this->Model_report->getDataListCP($nip,$length,$start);
		$data_jum = $this->Model_report->getCountListCP($nip);
		$output=array();
		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		if($search_no !="" ){
			$data_jum = $this->Model_report->getCountListCP($nip);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}
		if($data){
			foreach ($data as $key => $value) {
					$output['data'][$key] = array(
						$value['nip_user'],
						$value['nama_user'],
						$value['nip_app'],
						$value['nama_app'],
						$value['urutan_app'],
					);
			}
		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}

	public function print_action($check=false){
		// if(!in_array('viewReportMasterStockNormal', $this->permission)) {
		// 	$this->session->set_flashdata('print', true);
		// 	$this->session->set_flashdata('messages', "Aksses Ditolak");
		// 	redirect('report/master_stock_normal', 'refresh');
		// }
		// $draw=$_REQUEST['draw'];
		// $length=$_REQUEST['length'];
		// $start=$_REQUEST['start'];
		// $column = $_REQUEST['order'][0]['column'];
		// $order 			= $_REQUEST['order'][0]['dir'];
		// $search_no   = $_REQUEST['columns'][0]['search']["value"];

		$output['data']=array();
		$nip 		= $this->session->userdata('nama_login');
		$id_divisi = $this->input->post('nm_divisi');
		$id_dept = $this->input->post('nm_departement');
		$kd_store = $this->input->post('nm_store');
		$tanggal1 = $this->input->post('tanggal1');
		$tanggal2 = $this->input->post('tanggal2');
		// die(json_encode($tanggal1));

		$data = $this->Model_report->getDataAbsenPDF($tanggal1,$tanggal2,$id_divisi,$id_dept,$kd_store);
		// die(json_encode($data));
		if (count($data)) {
			$output['data']['detail'] = $data ;
			$output['data']['header']['divisi'] = $id_divisi;
			$output['data']['header']['dept'] = $id_dept;
			$output['data']['header']['kd_store'] = $kd_store;
			$output['data']['header']['tanggal1'] = $tanggal1;
			$output['data']['header']['tanggal2'] = $tanggal2;
			// die(json_encode($this->input->post('action')));

			if($this->input->post('action')=='excel'){
				$this->Model_report->exportExcelCuti($output['data']);
			}else{
				$this->load->view('data_app/print', $output);
			}
		}else{
			$this->session->set_flashdata('print', true);
			$this->session->set_flashdata('messages', "Tidak Ada Data Yang Dicetak");
			redirect('data_app/index', 'refresh');
		}
	}

}

 ?>
