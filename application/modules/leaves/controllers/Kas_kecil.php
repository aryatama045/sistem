<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Kas_kecil extends Admin_Controller  {

    private $hrd;
	public function __construct()
	{
		$this->data['modul'] = "Leaves";
		parent::__construct();
		$this->not_logged_in();
		$this->data['page_title'] = 'Kas Kecil';
		$this->load->model('Model_ijin');
		$this->load->model('Model_cuti');
		$this->load->model('Model_cuti_tambahan');
		$this->load->model('Model_leave');
		$this->load->model('Model_kas');
		$this->load->model('Model_report');
		$this->load->helper('file');
		$this->hrd 		= $this->load->database('hrd',TRUE);
		$this->hrdsave 	= $this->load->database('hrd_save',TRUE);
		$this->val_error = array(
			'required'	=> '<b>{field} </b> Harus diisi',
			'numeric'	=> '<b>{field} </b> Hanya Angka',
			'min_length'=> '<b>{field} </b> Minimal 8 Karakter',
			'max_length'=> '<b>{field} </b> Maximal 8 Karakter',
			'matches'	=> '<b>{field} </b> Tidak Sesuai',
			'is_unique'	=> '<b>{field} </b> Sudah Terdaftar'
		);
	}

	public function form()
	{
		$this->data['nm_divisi'] 	= $this->Model_report->getDataDivisi()->result();
		// tesx($biodata);
	}

	public function index()
	{
		$this->form();
		$this->render_template('kas_kecil/index',$this->data);
	}

	public function finance()
	{
		$this->form();

		$this->render_template('kas_kecil/approval_finance',$this->data);
	}

	public function direksi()
	{
		$this->form();
		$this->render_template('kas_kecil/approval_direksi',$this->data);
	}

	public function detail_dept($no_request)
	{

		$cek = $this->Model_kas->headerDok($no_request);
		if(empty($cek)){
			redirect('404_override', 'refresh');
		}
		$this->form_validation->set_rules('no_request' ,'No Request' , 'trim|required',$this->val_error);
		if ($this->form_validation->run() == TRUE) {

			$save = $this->Model_kas->appDeptHead();

			if($save) {
				$this->session->set_flashdata('success', 'Approve "'.$save.'" Berhasil Disimpan');
				redirect('leaves/kas_kecil', 'refresh');
			} else {
				$this->session->set_flashdata('errors', 'Error occurred!!');
				redirect('leaves/kas_kecil/'.$no_request, 'refresh');
			}
		} else {
			$this->data['headerdok'] = $this->Model_kas->headerDok($no_request);
			$this->data['detaildok'] = $this->Model_kas->detailDok($no_request);

			// tesx($this->data['detaildok']);
			$this->form();
			$this->render_template('kas_kecil/detail',$this->data);

		}

	}

	public function detail_finance($no_request)
	{
		$cek = $this->Model_kas->headerDok($no_request);
		if(empty($cek)){
			redirect('404_override', 'refresh');
		}
		$this->form_validation->set_rules('no_request' ,'No Request' , 'trim|required',$this->val_error);
		if ($this->form_validation->run() == TRUE) {


			$save = $this->Model_kas->appFinance();


			if($save) {
				$this->session->set_flashdata('success', 'Approve "'.$save.'" Berhasil Disimpan');
				redirect('leaves/kas_kecil/finance', 'refresh');
			} else {
				$this->session->set_flashdata('errors', 'Error occurred!!');
				redirect('leaves/kas_kecil/detail_finance/'.$no_request, 'refresh');
			}
		} else {

			$this->data['headerdok'] = $this->Model_kas->headerDok($no_request);
			$this->data['detaildok'] = $this->Model_kas->detailDok($no_request);
			// tesx($this->data['detaildok']);
			$this->form();
			$this->render_template('kas_kecil/detail',$this->data);

		}

	}

	public function detail_direksi($no_request)
	{
		$cek = $this->Model_kas->headerDok($no_request);
		if(empty($cek)){
			redirect('404_override', 'refresh');
		}
		$this->form_validation->set_rules('no_request' ,'No Request' , 'trim|required',$this->val_error);
		if ($this->form_validation->run() == TRUE) {


			$save = $this->Model_kas->appDireksi();


			if($save) {
				$this->session->set_flashdata('success', 'Approve "'.$save.'" Berhasil Disimpan');
				redirect('leaves/kas_kecil/direksi', 'refresh');
			} else {
				$this->session->set_flashdata('errors', 'Error occurred!!');
				redirect('leaves/kas_kecil/detail/'.$no_request, 'refresh');
			}
		} else {

			$this->data['headerdok'] = $this->Model_kas->headerDok($no_request);
			$this->data['detaildok'] = $this->Model_kas->detailDok($no_request);
			$this->form();
			$this->render_template('kas_kecil/detail',$this->data);

		}

	}

	public function get_request($id)
	{
		$data = $this->Model_kas->headerDok($id);
		// tesx($data);
		echo json_encode($data);
	}

	public function get_history($id)
	{
		$header = $this->Model_kas->headerDok($id);
		$data 	= $this->Model_kas->detailDok($id);

		if($data){
			$output['no_request'] = $header['no_request'];
			$output['jenis'] = $header['jenis'];
			$output['tgl_request'] = $header['tgl_request'];
			$output['nip'] = $header['nip_req'].'-'.$header['nama_req'];
			$output['dept'] = $header['kode_dept_req'].'-'.$header['nama_dept_req'];
			$output['keterangan'] = $header['keterangan'];

			$output['total_um'] = nominal($header['total_um']);
			$output['total_biaya'] = nominal($header['total_biaya']);
			$output['total_biaya_sebelumnya'] = nominal($header['total_biaya_sebelumnya']);

			$sum_total=0;
			foreach ($data as $key => $value) {
				$periode = $value['periode_awal'].'-'.$value['periode_akhir'];
				$output['data'][$key] = array(
					$value['kode_biaya'],
					$value['nama_biaya'],
					$value['keterangan'],
					$value['qty'],
					$value['satuan'],
					nominal($value['harga_satuan']),
					nominal($value['total'])
				);
				$sum_total += $value['total'];
			}
			$output['total_detail'] = nominal($sum_total);

		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}

	public function reject()
	{
		$reject = $this->Model_kas->rejectAction();
		if($reject) {
			$this->session->set_flashdata('success', 'Reject "'.$reject.'" Berhasil Disimpan');
			redirect('leaves/kas_kecil', 'refresh');
		}
		else {
			$this->session->set_flashdata('errors', 'Error occurred!!');
			redirect('leaves/kas_kecil', 'refresh');
		}

	}

	public function reject_finance()
	{
		$reject = $this->Model_kas->rejectAction();
		if($reject) {
			$this->session->set_flashdata('success', 'Reject "'.$reject.'" Berhasil Disimpan');
			redirect('leaves/kas_kecil/finance', 'refresh');
		}
		else {
			$this->session->set_flashdata('errors', 'Error occurred!!');
			redirect('leaves/kas_kecil/finance', 'refresh');
		}

	}

	public function reject_direksi()
	{
		$reject = $this->Model_kas->rejectAction();
		if($reject) {
			$this->session->set_flashdata('success', 'Reject "'.$reject.'" Berhasil Disimpan');
			redirect('leaves/kas_kecil/direksi', 'refresh');
		}
		else {
			$this->session->set_flashdata('errors', 'Error occurred!!');
			redirect('leaves/kas_kecil/direksi', 'refresh');
		}

	}


	/** feetching Data */
	public function fetchDataApproval()
	{


		$output = array('data' => array());

		$draw			= $_REQUEST['draw'];
		$length			= $_REQUEST['length'];
		$start			= $_REQUEST['start'];
		$column 		= $_REQUEST['order'][0]['column'];
		$order 			= $_REQUEST['order'][0]['dir'];
		$search_no   	= $_REQUEST['columns'][0]['search']["value"];

		//$output['data']=array();

		#Get Model by Jabatan
		$nip 	= $this->session->userdata('nama_login');
		$data['karyawan'] = $this->Model_kas->getDataKaryawan($nip);

		$cek_dept 	= $this->Model_leave->getDept($nip);
		if(!empty($cek_dept)){
			$dept 	= $cek_dept['kode_dept_induk'];
		}else{
			$dept	= '';
		}

		$data 					= $this->Model_kas->getDataDeptHead1($dept, $search_no,$length,$start,$column,$order);
		$data_jum 				= $this->Model_kas->getDataDeptHead2($dept, $search_no);

		#Get Model by Jabatan

		$output					= array();
		$output['draw']			= $draw;
		$output['recordsTotal']	= $output['recordsFiltered']= $data_jum;


		if($data){

			foreach ($data as $key => $value) {
					$buttons = '';
					$buttons .= '	<a href="'.base_url('leaves/kas_kecil/detail_dept/'.$value['no_request']).'"
									class="btn btn-success btn-xs mb-2"><i class="iconsminds-yes" title="Approve"></i> App</a>

									<button onclick="reject('."'".$value['no_request']."'".')"
									class="btn btn-danger btn-xs mb-2"><i class="iconsminds-close" ></i> Rej</button>
						';
					$output['data'][$key] = array(
						$value['no_request'],
						$value['nama_req'],
						$value['jenis'],
						// $value['nama_supplier'],
						$value['keterangan'],
						nominal($value['total_um']),
						$value['tgl_request'],
						$buttons
					);
			}
		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}

	public function fetchDataHistoryDept()
	{

		$output = array('data' => array());

		$draw			= $_REQUEST['draw'];
		$length			= $_REQUEST['length'];
		$start			= $_REQUEST['start'];
		$column 		= $_REQUEST['order'][0]['column'];
		$order 			= $_REQUEST['order'][0]['dir'];
		$search_no   	= $_REQUEST['columns'][0]['search']["value"];

		//$output['data']=array();

		#Get Model by Jabatan
			$nip 	= $this->session->userdata('nama_login');
			$data['karyawan'] = $this->Model_kas->getDataKaryawan($nip);

			$cek_dept 	= $this->Model_leave->getDept($nip);
			if(!empty($cek_dept)){
				$dept 	= $cek_dept['kode_dept_induk'];
			}else{
				$dept	= '';
			}
			$data 					= $this->Model_kas->getDataDeptHistory1($dept, $search_no,$length,$start,$column,$order);
			$data_jum 				= $this->Model_kas->getDataDeptHistory2($dept, $search_no);
		#Get Model by Jabatan

		$output					= array();
		$output['draw']			= $draw;
		$output['recordsTotal']	= $output['recordsFiltered']= $data_jum;

		if($data){

			foreach ($data as $key => $value) {
					$buttons = '
							<button onclick="detail('."'".$value['no_request']."'".')"
							class="btn btn-primary btn-xs"><i class="fa fa-eye" ></i> Detail</button>
						';
					$output['data'][$key] = array(
						$buttons,
						$value['no_request'],
						$value['nama_req'],
						$value['jenis'],
						$value['keterangan'],
						nominal($value['total_um']),
						$value['tgl_request']
					);
			}
		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}

	public function fetchApprovalFinance()
	{
		$nip 	= $this->session->userdata('nama_login');
		$fin 	= $this->Model_leave->getFin($nip);

		$output = array('data' => array());

		$draw			= $_REQUEST['draw'];
		$length			= $_REQUEST['length'];
		$start			= $_REQUEST['start'];
		$column 		= $_REQUEST['order'][0]['column'];
		$order 			= $_REQUEST['order'][0]['dir'];
		$search_no   	= $_REQUEST['columns'][0]['search']["value"];

		//$output['data']=array();

		// tesx($fin);

		#Get Model by Jabatan
			$data 		= $this->Model_kas->getDataFinance1($fin['kode_divisi'],$search_no,$length,$start,$column,$order);
			$data_jum 	= $this->Model_kas->getDataFinance2($fin['kode_divisi'],$search_no);
		#Get Model by Jabatan

		$output					= array();
		$output['draw']			= $draw;
		$output['recordsTotal']	= $output['recordsFiltered']= $data_jum;


		if($data){

			foreach ($data as $key => $value) {
					$buttons = '';
					$buttons .= '	<a href="'.base_url('leaves/kas_kecil/detail_finance/'.$value['no_request']).'"
									class="btn btn-success btn-xs mb-2"><i class="iconsminds-yes" title="Approve"></i> App</a>

									<button onclick="reject('."'".$value['no_request']."'".')"
									class="btn btn-danger btn-xs mb-2"><i class="iconsminds-close" ></i> Rej</button>
						';
					$output['data'][$key] = array(
						$value['no_request'],
						$value['nama_req'],
						$value['jenis'],
						// $value['nama_supplier'],
						$value['keterangan'],
						nominal($value['total_um']),
						$value['tgl_request'],
						$buttons
					);
			}
		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}

	public function fetchDataHistoryFin()
	{
		$nip 	= $this->session->userdata('nama_login');
		$fin 	= $this->Model_leave->getFin($nip);

		$output = array('data' => array());

		$draw			= $_REQUEST['draw'];
		$length			= $_REQUEST['length'];
		$start			= $_REQUEST['start'];
		$column 		= $_REQUEST['order'][0]['column'];
		$order 			= $_REQUEST['order'][0]['dir'];
		$search_no   	= $_REQUEST['columns'][0]['search']["value"];

		$no_req     	= $this->input->post('no_req');
        $nama_req    	= $this->input->post('nama_req');


		#Get Model by Jabatan
			$data 		= $this->Model_kas->getHistoryFinance1($fin['kode_divisi'],$search_no,$no_req,$nama_req,$length,$start,$column,$order);
			$data_jum 	= $this->Model_kas->getHistoryFinance2($fin['kode_divisi'],$search_no,$no_req,$nama_req);
		#Get Model by Jabatan

		$output					= array();
		$output['draw']			= $draw;
		$output['recordsTotal']	= $output['recordsFiltered']= $data_jum;

		if($search_no !="" || $no_req !="" || $nama_req !="" ){
			$data_jum 	= $this->Model_kas->getHistoryFinance2($fin['kode_divisi'],$search_no,$no_req,$nama_req);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}


		if($data){

			foreach ($data as $key => $value) {
					$buttons = '';
					$buttons .= '
							<button onclick="detail('."'".$value['no_request']."'".')"
							class="btn btn-primary btn-xs"><i class="fa fa-eye" ></i> Detail</button>
						';
					$nip = $value['nip_req'].'<br />'.$value['nama_req'];
					$output['data'][$key] = array(
						$buttons,
						$value['no_request'],
						$value['nama_req'],
						$value['kode_dept_req'],
						$value['jenis'],
						$value['keterangan'],
						nominal($value['total_um']),
						$value['tgl_request']
					);
			}
		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}

	public function fetchApprovalDireksi()
	{
		$nip 	= $this->session->userdata('nama_login');
		// $dept 	= $this->Model_leave->getDept($nip);

		$output = array('data' => array());

		$draw			= $_REQUEST['draw'];
		$length			= $_REQUEST['length'];
		$start			= $_REQUEST['start'];
		$column 		= $_REQUEST['order'][0]['column'];
		$order 			= $_REQUEST['order'][0]['dir'];
		$search_no   	= $_REQUEST['columns'][0]['search']["value"];

		//$output['data']=array();

		#Get Model by Jabatan
			$data 					= $this->Model_kas->getDataDireksi1($search_no,$length,$start,$column,$order);
			$data_jum 				= $this->Model_kas->getDataDireksi2($search_no);


		$output					= array();
		$output['draw']			= $draw;
		$output['recordsTotal']	= $output['recordsFiltered']= $data_jum;


		if($data){

			foreach ($data as $key => $value) {
					$buttons = '';
					$buttons .= '	<a href="'.base_url('leaves/kas_kecil/detail_direksi/'.$value['no_request']).'"
									class="btn btn-success btn-xs mb-2"><i class="iconsminds-yes" title="Approve"></i> App</a>

									<button onclick="reject('."'".$value['no_request']."'".')"
									class="btn btn-danger btn-xs mb-2"><i class="iconsminds-close" ></i> Rej</button>
						';
					$output['data'][$key] = array(
						$value['no_request'],
						$value['nama_req'],
						$value['jenis'],
						// $value['nama_supplier'],
						$value['keterangan'],
						nominal($value['total_um']),
						$value['tgl_request'],
						$buttons
					);
			}
		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}

	public function fetchDataHistoryDir()
	{

		$output = array('data' => array());

		$draw			= $_REQUEST['draw'];
		$length			= $_REQUEST['length'];
		$start			= $_REQUEST['start'];
		$column 		= $_REQUEST['order'][0]['column'];
		$order 			= $_REQUEST['order'][0]['dir'];
		$search_no   	= $_REQUEST['columns'][0]['search']["value"];

		#Get Model by Jabatan
			$data 					= $this->Model_kas->getHistoryDireksi1($search_no,$length,$start,$column,$order);
			$data_jum 				= $this->Model_kas->getHistoryDireksi2($search_no);

		$output					= array();
		$output['draw']			= $draw;
		$output['recordsTotal']	= $output['recordsFiltered']= $data_jum;

		if($data){

			foreach ($data as $key => $value) {
				$buttons = '';
				$buttons .= '
						<a href="#" onclick="detail('."'".$value['no_request']."'".')"
						class="btn btn-primary btn-xs"><i class="fa fa-eye" ></i> Detail</a>
					';
				$output['data'][$key] = array(
					$buttons,
					$value['no_request'],
					$value['nama_req'],
					$value['jenis'],
					$value['keterangan'],
					nominal($value['total_um']),
					$value['tgl_request']
				);
			}
		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}

	// Approval Detail
	public function approval_detail($noreq)
	{
		tesx($noreq);

		$this->form_validation->set_rules('status_cuti' ,'Jenis Cuti Kosong' , 'trim|required',$this->val_error);

		if ($this->form_validation->run() == TRUE) {
			$create_form = $this->Model_cuti_dispensasi->ApproveAction();

			if($create_form) {
				$this->session->set_flashdata('success', 'Approve "'.$create_form.'" Berhasil Disimpan');
				redirect('approval_cuti_dispensasi', 'refresh');
			}
			else {
				$this->session->set_flashdata('errors', 'Error occurred!!');
				redirect('approval_cuti_dispensasi', 'refresh');
			}
		} else {
			$this->form();
			$date		= date('ym');
			$dates		= date('Y-m-d');
			$biodatas 	= $this->hrd->select('biodata_id')
						->get_where('hrd_all.trn_cuti_dispensasi_h',array('cuti_dispensasi_h_id' => $no_dok_h))->row_array();
			$biodataids = $biodatas['biodata_id'];

			$this->data['kodestore'] 	= $this->Model_cuti_dispensasi->getKodeStore($biodataids);
			$this->data['golabsen'] 	= $this->Model_cuti_dispensasi->getGolAbsen($biodataids);

			$header_data 				= $this->Model_cuti_dispensasi->getHeaderData($no_dok_h);
			$result['header'] = $header_data;
			$detail_item = $this->Model_cuti_dispensasi->getDetailData($header_data['cuti_dispensasi_h_id']);

			foreach($detail_item as $k => $v) {
				$result['detail_item'][] = $v;
			}

			$this->data['header_data'] = $result;
			$this->render_template('kas_kecil/approval_detail',$this->data);
		}
	}

}