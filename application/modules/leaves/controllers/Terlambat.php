<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Terlambat extends Admin_Controller  {
	private $hrd;
	public function __construct()
	{
		$this->data['modul'] = "Leaves";
		parent::__construct();
		$this->not_logged_in();
		$this->data['page_title'] = 'Terlambat';
		$this->load->model('Model_terlambat');
		$this->load->model('Model_cuti');
		$this->load->model('Model_leave');
		$this->load->helper('file');
		$this->hrd 		= $this->load->database('hrd',TRUE);
		$this->hrdsave 	= $this->load->database('hrd_save',TRUE);
	}

	public function form()
	{
		$this->data['approval']  	= $this->Model_leave->PicApproval();
		$this->data['verifikasi']  	= $this->Model_leave->PicVerifikasiHrd();
		$data_status = $this->Model_terlambat->getStatusCuti();
		$list_status_absensi_id = array(""=>"");
		foreach ($data_status as $key => $value) {
			$list_status_absensi_id[$value['status_absensi_id']]= $value['ket_status_absensi'];
		}
		$this->data['status_absensi_id'] = [
			'name'   	=> 'status_absensi_id',
			'id'   		=> 'status_absensi_id',
			'class'  	=> 'form-control select2-single',
			'required'	=> 'required',
			'style'		=> 'width:100%;'
		];
		$this->data['status_absensi_id_option'] = $list_status_absensi_id;
		$docCode	='HRT';
			$date		= date('ym');
			$dates		= date('Y-m-d');
			$nip 		= $this->session->userdata('nama_login');
			$biodata 	= $this->hrd->select('biodata_id')
						->get_where('hrd_all.mst_biodata',array('nip' => $nip))->row_array();
			$biodataid= $biodata['biodata_id'];
			$this->data['biodataid']	= $biodata['biodata_id'];
			$this->data['no_doc'] 		= $this->Model_terlambat->getDataNoDoc($docCode,$date);
			$this->data['biodata'] 		= $this->Model_terlambat->getDataUser();
			$this->data['normatifs'] 	= $this->Model_terlambat->getDataNormatif($biodataid);
			$this->data['bonus'] 		= $this->Model_terlambat->getDataBonus($biodataid,$dates);
			$this->data['tambahan'] 	= $this->Model_terlambat->getDataTambahan($biodataid,$dates);
			$this->data['kodestore'] 	= $this->Model_terlambat->getKodeStore($biodataid);
			$this->data['golabsen'] 	= $this->Model_terlambat->getGolAbsen($biodataid);
		// die(json_encode($this->data['golabsen']));
		// SELECT  id FROM hrd_all.mst_biodata
		// 	WHERE nip ='".$nip."'
	}

	public function index()
	{
		$this->data['js'] = 'index';
		$this->form();
		$this->render_template('terlambat/index',$this->data);
	}

	function tgl_unique()
	{
		$array = $this->input->post('tgl_tdk_masuk');// get value
		// die(json_encode($array));
		$this->form_validation->set_message('tgl_unique', '%s tidak boleh sama. ');

		if(count(array_unique($array))!==count($array))
		{
			// Array has duplicates
			return FALSE;
		}
		else
		{
			// Array does not have duplicates
			return TRUE;
		}
	}


	public function create()
	{

		// $this->form_validation->set_rules('file_1', '', 'callback_file_check_1');


		if($this->input->post('status_absensi_id') == '000000000061'){

			if (empty($_FILES['file_1']['name'])) {
				$this->form_validation->set_rules('file_1','Lampiran 1','trim|required',
					array(	'required' 	=> 'Lampiran 1 Tidak Boleh Kosong !!'
				));
			}

			if (empty($_FILES['file_2']['name'])) {
				$this->form_validation->set_rules('file_2','Lampiran 2','trim|required',
					array(	'required' 	=> 'Lampiran 2 Tidak Boleh Kosong !!',
				));
			}

			if (empty($_FILES['file_3']['name']) ) {
				$this->form_validation->set_rules('file_3','Lampiran 3','trim|required',
					array(	'required' 	=> 'Lampiran 3 Tidak Boleh Kosong !!',
				));
			}

		}

		$this->form_validation->set_rules('tgl_tdk_masuk[]','Tanggal','required|callback_tgl_unique',
			array(	'required' 	=> 'Tanggal Tidak Boleh Kosong !!',
		));

		if ($this->form_validation->run() == TRUE) {

			$create_form = $this->Model_terlambat->create();

			if($create_form) {
				$this->session->set_flashdata('success', 'Terlambat "'.$create_form.'" Berhasil Disimpan');
				redirect('leaves/terlambat/index/', 'refresh');
			}
			else {
				$this->session->set_flashdata('errors', 'Error !!');
				redirect('leaves/terlambat/create', 'refresh');
			}
		} else {
			$this->form();
			$this->data['js'] 		= 'create';
			$this->render_template('terlambat/create', $this->data);
		}

	}


	public function file_validate()
	{
		$this->form_validation->set_rules('file_1', '', 'callback_file_check_1');
		if ($_FILES['file_1']['max_size']='2000') {
			$this->form_validation->set_rules('file_1','Lampiran 1','required',
							array(	'required' 	=> 'Lampiran 1 Max 2mb !!',
						));
		}

		if($this->input->post('status_absensi_id') == '000000000061'){
			// tesx($file_1,$file_2,$file_3);
			if (empty($_FILES['file_1']['name'])) {
				$this->form_validation->set_rules('file_1','Lampiran 1','trim|required|max_size[100]',
								array(	'required' 	=> 'Lampiran 1 Tidak Boleh Kosong !!',
										'file_size'	=> 'File Upload Max 2mb'
							));
			}

			if (empty($_FILES['file_2']['name'])) {
				$this->form_validation->set_rules('file_2','Lampiran 2','trim|required',
								array(	'required' 	=> 'Lampiran 2 Tidak Boleh Kosong !!',
							));
			}

			if (empty($_FILES['file_3']['name']) ) {
				$this->form_validation->set_rules('file_3','Lampiran 3','trim|required',
								array(	'required' 	=> 'Lampiran 3 Tidak Boleh Kosong !!',
							));
			}

		}
	}

	/*
     * file value and type check during validation
     */
    public function file_check_1($str){
        $allowed_mime_type_arr = array('application/pdf','image/gif','image/jpeg','image/pjpeg','image/png','image/x-png');
        $mime = get_mime_by_extension($_FILES['file_1']['name']);


        if(isset($_FILES['file_1']['name']) && $_FILES['file_1']['name']!=""){
            if(in_array($mime, $allowed_mime_type_arr)){
                return true;
            } else{
                $this->form_validation->set_message('file_check_1', 'Lampiran  hanya jpg/png file.');
                return false;
            }
        } else{
            $this->form_validation->set_message('file_check_1', 'Lampiran 1, Please choose a file to upload.');
            return false;
        }

		if(filesize($_FILES['file_1']['tmp_name']) > 20000) {
            $this->form_validation->set_message('validate_image', 'The Image file size shoud not exceed 2MB!');
            $check = FALSE;
        }
    }

	/**
		* Manage uploadImage
		*
	*/
	public function resizeImage($filename)
	{
		$source_path = FCPATH . '/upload/ijin/' . $filename;
		$target_path = FCPATH . '/upload/ijin/';
		$config_manip = array(
			'image_library' 	=> 'gd2',
			'source_image' 		=> $source_path,
			'new_image' 		=> $target_path,
			'maintain_ratio' 	=> TRUE,
			'width' 			=> 500,
		);

		$this->load->library('image_lib', $config_manip);
		if (!$this->image_lib->resize()) {
			echo $this->image_lib->display_errors();
		}

		$this->image_lib->clear();
	}

	public function fetchDataCuti()
	{
		$output = array('data' => array());

		$draw			= $_REQUEST['draw'];
		$length			= $_REQUEST['length'];
		$start			= $_REQUEST['start'];
		// $search			= $_REQUEST['search']["value"];
		$column 		= $_REQUEST['order'][0]['column'];
		$order 			= $_REQUEST['order'][0]['dir'];
		$search_no   	= $_REQUEST['columns'][0]['search']["value"];

		$nip 		= $this->session->userdata('nama_login');
		$biodata 	= $this->hrd->select('biodata_id')
					->get_where( 'hrd_all.mst_biodata',array('nip' => $nip))->row_array();
		$no = $biodata['biodata_id'];
		$data = $this->Model_terlambat->getCutiData1($no, $search_no,$length,$start,$column,$order);
		$data_jum = $this->Model_terlambat->getCutiData2($no,$search_no);
		$output=array();
		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		if($search_no !="" ){
			$data_jum = $this->Model_terlambat->getCutiData2($no,$search_no);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){

			foreach ($data as $key => $value) {
					$buttons = '';
					$link_po = str_replace("/","_",$value['no_dok_tdk_masuk']);
					$buttons .= ' <a href="'.base_url('leaves/terlambat/detail/'.$value['tdk_masuk_h_id']).'" 
					class="btn btn-primary mb-1"><i class="simple-icon-note" title="Detail"></i> Detail</a>';
					$output['data'][$key] = array(
						$value['no_dok_tdk_masuk'],
						$value['tgl_dok'],
						$value['keterangan'],
						$value['posting'],
						$buttons
					);
			}
		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}


	public function detail($no_dok_h)
	{
		$this->form();
		$this->data['js'] 				= 'create';
		$header_data = $this->Model_terlambat->getHeaderDataBC($no_dok_h);
		$result['header'] = $header_data;
		$detail_item = $this->Model_terlambat->getDetailData($header_data['tdk_masuk_h_id']);

		foreach($detail_item as $k => $v) {
			$result['detail_item'][] = $v;
		}
		$this->data['header_data'] = $result;
		$this->data['kode_status'] = $this->Model_terlambat->getIdStatusCuti($header_data['status_absensi_id']);
		$this->render_template('terlambat/detail',$this->data);
	}

	public function approval()
	{
		$this->form();
		$this->render_template('terlambat/approval',$this->data);
	}

	public function fetchDataApproval()
	{
		$output = array('data' => array());

		$draw		  = $_REQUEST['draw'];
		$length		  = $_REQUEST['length'];
		$start		  = $_REQUEST['start'];
		$column 	  = $_REQUEST['order'][0]['column'];
		$order  	  = $_REQUEST['order'][0]['dir'];
		$search_no 	  = $_REQUEST['columns'][0]['search']["value"];

		$nip 		= $this->session->userdata('nama_login');
		$biodata 	= $this->hrd->select('kode_dept')
					->get_where('db_akses.mst_user',array('nip_user' => $nip))->row_array();
		// die(json_encode($biodata));
		$no = $biodata['kode_dept'];
		$data = $this->Model_terlambat->getApprovalData1($nip, $search_no,$length,$start,$column,$order);
		$data_jum = $this->Model_terlambat->getApprovalData2($nip,$search_no);
		$output=array();
		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		if($search_no !="" ){
			$data_jum = $this->Model_terlambat->getApprovalData2($nip,$search_no);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){
			foreach ($data as $key => $value) {
					$buttons = '';
					$buttons .= '<div class="mb-4">
								<a href="'.base_url('leaves/terlambat/approval_detail/'.$value['tdk_masuk_h_id']).'"
								class="btn btn-success btn-xs mb-2"><i class="iconsminds-yes" title="Approve"></i> APP</a>
								';
					$buttons .= '<div class="mb-4">
								<a href="'.base_url('leaves/terlambat/reject_detail/'.$value['tdk_masuk_h_id']).'"
								class="btn btn-danger btn-xs mb-2"><i class="iconsminds-yes" title="Reject"></i> REJ</a>
								';

					$arr_result = array(
						$value['tdk_masuk_h_id'],
						$value['no_dok_tdk_masuk'],
						$value['nama_lengkap'],
						$value['keterangan'],
						$value['tgl_dok_tdk_masuk'],
						$buttons
					);
					$array_secondary = array();
						$data_detail = $this->Model_terlambat->getDetailData($value['tdk_masuk_h_id']);
						foreach ($data_detail as $key => $row2)
						{
							$arr_result2 = array(
								$row2['tgl_tdk_masuk'],
								$row2['nama_hari'],
								$row2['keterangan'],
							);
							$array_secondary[] = $arr_result2;
						}
					$arr_result['secondary'] =  $array_secondary;

					$output['data'][] = $arr_result;

			}
		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}

	public function fetchDataApprovalHistory()
	{
		$output 	= array('data' => array());
		$draw		= $_REQUEST['draw'];
		$length		= $_REQUEST['length'];
		$start		= $_REQUEST['start'];
		$column 	= $_REQUEST['order'][0]['column'];
		$order  	= $_REQUEST['order'][0]['dir'];
		$search_no 	= $_REQUEST['columns'][0]['search']["value"];

		$nip 		= $this->session->userdata('nama_login');
		$data 		= $this->Model_terlambat->getDataTerlambatHistory($nip, $search_no,$length,$start,$column,$order);
		$data_jum 	= $this->Model_terlambat->getCountDataTerlambatHistory($nip,$search_no);
		$output		= array();
		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		if($search_no !="" ){
			$data_jum = $this->Model_terlambat->getCountDataTerlambatHistory($no,$search_no);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){
			foreach ($data as $key => $value) {
				$arr_result = array(
					$value['no_dok_tdk_masuk'],
					$value['tgl_dok_tdk_masuk'],
					$value['nip'],
					$value['nama_lengkap'],
					$value['nama_dept'],
					$value['tgl_app_1'],
					$value['posting'],
				);
				$array_secondary = array();
				$data_detail = $this->Model_terlambat->getDataTerlambatHistoryDetail($value['no_dok_tdk_masuk']);
				foreach ($data_detail as $key => $row2)
				{
					$arr_result2 = array(
						$row2['nama_hari'],
						$row2['tgl_tdk_masuk'],
						$row2['jam_ijin'],
						$row2['jam_kembali'],
						$row2['potong_cuti_dari'],
						$row2['keterangan'],
					);
					$array_secondary[] = $arr_result2;
				}
				$arr_result['secondary'] = $array_secondary;
				$output['data'][] = $arr_result;
			}			
		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}

	public function fetchDataApprovalPosting()
	{
		$output = array('data' => array());

		$draw		= $_REQUEST['draw'];
		$length		= $_REQUEST['length'];
		$start		= $_REQUEST['start'];
		$column 	= $_REQUEST['order'][0]['column'];
		$order  	= $_REQUEST['order'][0]['dir'];
		$search_no 	= $_REQUEST['columns'][0]['search']["value"];

		$nip 		= $this->session->userdata('nama_login');
		$data 		= $this->Model_terlambat->getDataTerlambatPosting($nip, $search_no,$length,$start,$column,$order);
		$data_jum 	= $this->Model_terlambat->getCountDataTerlambatPosting($nip,$search_no);
		$output=array();
		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		if($search_no !="" ){
			$data_jum = $this->Model_terlambat->getCountDataTerlambatPosting($no,$search_no);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}
		
		if($data){
			$no =0;
			foreach ($data as $key => $value) {
					$arr_result = array(
						$value['no_dok_tdk_masuk'],
						$value['tgl_dok_tdk_masuk'],
						$value['nip'],
						$value['nama_lengkap'],
						$value['nama_dept'],
						$value['tgl_app_1'],
						// $value['status_dokumen'],
						$value['posting'],
						// $buttons
					);
					// $array_secondary = array();
					// 	$data_detail = $this->Model_terlambat->getDetailData($value['tdk_masuk_h_id']);
					// 	foreach ($data_detail as $key => $row2)
					// 	{
					// 		// print_r($row['no_doc_trans']);
					// 		$arr_result2 = array(
					// 			$row2['tgl_tdk_masuk'],
					// 			$row2['nama_hari'],
					// 			$row2['keterangan'],
					// 		);
					// 		$array_secondary[] = $arr_result2;
					// 	}
					// $arr_result['secondary'] =  $array_secondary;

					$output['data'][] = $arr_result;
			}			
		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}

	public function fetchDataApprovalReject()
	{
		$output = array('data' => array());

		$draw		  = $_REQUEST['draw'];
		$length		  = $_REQUEST['length'];
		$start		  = $_REQUEST['start'];
		$column 	  = $_REQUEST['order'][0]['column'];
		$order  	  = $_REQUEST['order'][0]['dir'];
		$search_no 	  = $_REQUEST['columns'][0]['search']["value"];

		$nip 		= $this->session->userdata('nama_login');
		$biodata 	= $this->hrd->select('kode_dept')
					->get_where('db_akses.mst_user',array('nip_user' => $nip))->row_array();
		// die(json_encode($biodata));
		$no = $biodata['kode_dept'];
		$data = $this->Model_terlambat->getApprovalDataReject1($no, $search_no,$length,$start,$column,$order);
		// die(json_encode($data));
		$data_jum = $this->Model_terlambat->getApprovalDataReject2($no,$search_no);
		$output=array();
		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		if($search_no !="" ){
			$data_jum = $this->Model_terlambat->getApprovalDataReject2($no,$search_no);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}
		
		if($data){
			$nip 		= $this->session->userdata('nama_login');
			$biodata 	= $this->hrd->select('biodata_id')
							->get_where( 'hrd_all.mst_biodata',array('nip' => $nip))->row_array();
			// die(json_encode($biodata));
			$no =0;
			foreach ($data as $key => $value) {
				// if($biodata['biodata_id']==$value['biodata_id']){
					// button
					$buttons = '';

					$arr_result = array(
						$value['tdk_masuk_h_id'],
						$value['no_dok_tdk_masuk'],
						$value['tgl_dok'],
						$value['keterangan'],
						// $value['potong_cuti_dari'],
						// $value['status'],
						$value['nama_pic'],
						// $buttons
					);
					$array_secondary = array();
						$data_detail = $this->Model_terlambat->getDetailData($value['tdk_masuk_h_id']);
						foreach ($data_detail as $key => $row2)
						{
							// print_r($row['no_doc_trans']);
							$arr_result2 = array(
								$row2['tgl_tdk_masuk'],
								$row2['nama_hari'],
								$row2['keterangan'],
							);
							$array_secondary[] = $arr_result2;
						}
					$arr_result['secondary'] =  $array_secondary;

					$output['data'][] = $arr_result;

			}
		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}

	public function approval_detail($no_dok_h)
	{
		$this->form_validation->set_rules('no_doc' ,'No Dokumen' , 'trim|required');
		if ($this->form_validation->run() == TRUE) {
			if($this->session->userdata('nama_login')!= '99999999'){
				$create_form = $this->Model_terlambat->ApproveAction();
			}else{
				$create_form = $this->Model_terlambat->ApproveDireksi();
			}

			if($create_form) {
				$this->session->set_flashdata('success', 'Approve "'.$create_form.'" Berhasil Disimpan');
				redirect('approval_terlambat', 'refresh');
			}
			else {
				$this->session->set_flashdata('errors', 'Error occurred!!');
				redirect('approval_terlambat', 'refresh');
			}
		} else {
			$this->data['js'] 				= 'create';
			$this->form();
			$date		= date('ym');
				$dates		= date('Y-m-d');
				$biodatas 	= $this->hrd->select('biodata_id')
							->get_where('hrd_all.trn_tidak_masuk_h',array('tdk_masuk_h_id' => $no_dok_h))->row_array();
				$biodataids = $biodatas['biodata_id'];
				$this->data['normatifs'] 	= $this->Model_cuti->getDataNormatif($biodataids);
				$this->data['bonus'] 		= $this->Model_cuti->getDataBonus($biodataids,$dates);
				$this->data['tambahan'] 	= $this->Model_cuti->getDataTambahan($biodataids,$dates);
				$this->data['kodestore'] 	= $this->Model_cuti->getKodeStore($biodataids);
				$this->data['golabsen'] 	= $this->Model_cuti->getGolAbsen($biodataids);
				// die(json_encode($this->data['golabsen']));
			if($this->session->userdata('nama_login')!= '99999999'){
				$header_data = $this->Model_terlambat->getHeaderDataBC($no_dok_h);
			}else{
				$header_data = $this->Model_terlambat->getHeaderDataBC($no_dok_h);
			}
			// tesx($header_data);
			$result['header'] = $header_data;
			$detail_item = $this->Model_terlambat->getDetailData($header_data['tdk_masuk_h_id']);
			foreach($detail_item as $k => $v) {
				$result['detail_item'][] = $v;
			}
			$this->data['header_data'] = $result;
			$this->data['kode_status'] = $this->Model_terlambat->getIdStatusCuti($header_data['status_absensi_id']);
			$this->render_template('terlambat/approval_detail',$this->data);
		}

	}

	public function verifikasi()
	{
		$this->form();
		$this->render_template('terlambat/verifikasi',$this->data);
	}

	public function fetchDataVerifikasi()
	{
		$output = array('data' => array());

		$draw		  = $_REQUEST['draw'];
		$length		  = $_REQUEST['length'];
		$start		  = $_REQUEST['start'];
		$column 	  = $_REQUEST['order'][0]['column'];
		$order  	  = $_REQUEST['order'][0]['dir'];
		$search_no 	  = $_REQUEST['columns'][0]['search']["value"];

		$nip 		= $this->session->userdata('nama_login');
		$biodata 	= $this->hrd->select('kode_dept')
					->get_where('db_akses.mst_user',array('nip_user' => $nip))->row_array();
		// die(json_encode($biodata));
		$no = $biodata['kode_dept'];
		$data = $this->Model_terlambat->getVerifikasi1($nip, $search_no,$length,$start,$column,$order);
		$data_jum = $this->Model_terlambat->getVerifikasi2($nip,$search_no);
		$output=array();
		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		if($search_no !="" ){
			$data_jum = $this->Model_terlambat->getVerifikasi2($nip,$search_no);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){
			$nip 		= $this->session->userdata('nama_login');
			$biodata 	= $this->hrd->select('biodata_id')
							->get_where('hrd_all.mst_biodata',array('nip' => $nip))->row_array();
			// die(json_encode($biodata));
			$no =0;
			foreach ($data as $key => $value) {

					$buttons = '';
					if($value['jn']=='IJIN'){
						$buttons .= '<div class="mb-4">
									<a href="'.base_url('leaves/terlambat/verifikasi_detail/'.$value['tdk_masuk_h_id']).'"
									class="btn btn-success btn-xs mb-2"><i class="iconsminds-yes" title="Approve"></i> Verifikasi</a>
						';
						// $buttons .= '<div class="mb-4">
						// 			<a href="'.base_url('leaves/terlambat/reject_verifikasi/'.$value['tdk_masuk_h_id']).'"
						// 			class="btn btn-danger btn-xs mb-2"><i class="iconsminds-yes" title="Reject"></i> REJ</a>
						// ';
					} else {
						$buttons .= '<div class="mb-4">
								<a href="'.base_url('leaves/cuti_dispensasi/verifikasi_detail/'.$value['tdk_masuk_h_id']).'"
								class="btn btn-success btn-xs mb-2"><i class="iconsminds-yes" title="Approve"></i> Verifikasi</a>
						';
						// $buttons .= '<div class="mb-4">
						// 			<a href="'.base_url('leaves/cuti_dispensasi/reject_verifikasi/'.$value['tdk_masuk_h_id']).'"
						// 			class="btn btn-danger btn-xs mb-2"><i class="iconsminds-yes" title="Reject"></i> REJ</a>
						// ';
					}
					$arr_result = array(
						// $value['tdk_masuk_h_id'],
						$value['jn'],
						$value['no_dok_tdk_masuk'],
						$value['nama_lengkap'],
						$value['nama_dept'],
						$value['tgl_dok_tdk_masuk'],
						$buttons
					);
					$array_secondary = array();
						$data_detail = $this->Model_terlambat->getDetailData($value['tdk_masuk_h_id']);
						foreach ($data_detail as $key => $row2)
						{
							// print_r($row['no_doc_trans']);
							$arr_result2 = array(
								$row2['tgl_tdk_masuk'],
								$row2['nama_hari'],
								$row2['keterangan'],
							);
							$array_secondary[] = $arr_result2;
						}
					$arr_result['secondary'] =  $array_secondary;

					$output['data'][] = $arr_result;

			}
		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}

	public function verifikasi_detail($no_dok_h)
	{
		$this->form_validation->set_rules('no_doc' ,'No Dokumen' , 'trim|required',$this->val_error);
		if ($this->form_validation->run() == TRUE) {
			$create_form = $this->Model_terlambat->VerifikasiAction();

			if($create_form) {
				$this->session->set_flashdata('success', 'Approve "'.$create_form.'" Berhasil Disimpan');
				redirect('verifikasi_ijin', 'refresh');
			}
			else {
				$this->session->set_flashdata('errors', 'Error occurred!!');
				redirect('verifikasi_ijin', 'refresh');
			}
		} else {
			$this->data['js'] 				= 'create';
			$this->form();
			$header_data = $this->Model_terlambat->getHeaderDataBC($no_dok_h);
			$result['header'] = $header_data;
			$detail_item = $this->Model_terlambat->getDetailData($header_data['tdk_masuk_h_id']);
			foreach($detail_item as $k => $v) {
				$result['detail_item'][] = $v;
			}
			$this->data['header_data'] = $result;
			$this->data['kode_status'] = $this->Model_terlambat->getIdStatusCuti($header_data['status_absensi_id']);
			$this->render_template('terlambat/verifikasi_detail',$this->data);
		}

	}

	public function reject_verifikasi($no_dok_h)
	{
		$this->form_validation->set_rules('reject_komentar','Reject ','required',
				array(	'required' 	=> 'Reject Komentar Tidak Boleh Kosong !!',
				));
		$pic_data = $this->Model_cuti->getHeaderData($no_dok_h);
		$biodata_rej = $pic_data['biodata_id'];
		$jml_reject = $this->Model_cuti->rejectData($biodata_rej);
		// die(json_encode($jml_reject['jml']));

		// if ($jml_reject['jml'] > 3) {
		// 		$this->session->set_flashdata('error', 'Tidak Bisa Proses, "'.$pic_data['nama_lengkap'].'" Sudah Reject  3x !!');
		// 		redirect('approval_terlambat', 'refresh');
		// } else {
			if ($this->form_validation->run() == TRUE) {

				$nip 		= $this->session->userdata('nama_login');
				$biodata 	= $this->hrd->select('biodata_id')
								->get_where('hrd_all.mst_biodata',array('nip' => $nip))
								->row_array();
				$pic = $biodata['biodata_id'];
				$ket = $this->input->post('reject_komentar');

				$create_form = $this->Model_terlambat->rejectApp($no_dok_h,$pic,$nip,$ket);

				if($create_form) {
					$this->session->set_flashdata('success', 'Approve "'.$create_form.'" Berhasil Disimpan');
					redirect('approval_terlambat', 'refresh');
				}
				else {
					$this->session->set_flashdata('errors', 'Error occurred!!');
					redirect('approval_terlambat', 'refresh');
				}
			} else {
				$this->data['js'] 				= 'create';
				$this->form();
				$header_data = $this->Model_terlambat->getHeaderDataBC($no_dok_h);
				$result['header'] = $header_data;
				$detail_item = $this->Model_terlambat->getDetailData($header_data['tdk_masuk_h_id']);
				foreach($detail_item as $k => $v) {
					$result['detail_item'][] = $v;
				}
				$this->data['header_data'] = $result;
				$this->data['kode_status'] = $this->Model_terlambat->getIdStatusCuti($header_data['status_absensi_id']);
				$this->render_template('terlambat/reject_detail',$this->data);
			}
		// }
	}

	public function reject_detail($no_dok_h)
	{
		$this->form_validation->set_rules('reject_komentar','Reject ','required',
				array(	'required' 	=> 'Reject Komentar Tidak Boleh Kosong !!',
				));
		$pic_data = $this->Model_cuti->getHeaderData($no_dok_h);
		$biodata_rej = $pic_data['biodata_id'];
		$jml_reject = $this->Model_cuti->rejectData($biodata_rej);
		// die(json_encode($jml_reject['jml']));

		// if ($jml_reject['jml'] > 3) {
		// 		$this->session->set_flashdata('error', 'Tidak Bisa Proses, "'.$pic_data['nama_lengkap'].'" Sudah Reject  3x !!');
		// 		redirect('approval_terlambat', 'refresh');
		// } else {
			if ($this->form_validation->run() == TRUE) {

				$nip 		= $this->session->userdata('nama_login');
				$biodata 	= $this->hrd->select('biodata_id')
								->get_where('hrd_all.mst_biodata',array('nip' => $nip))
								->row_array();
				$pic = $biodata['biodata_id'];
				$ket = $this->input->post('reject_komentar');

				$create_form = $this->Model_terlambat->rejectApp($no_dok_h,$pic,$nip,$ket);

				if($create_form) {
					$this->session->set_flashdata('success', 'Approve "'.$create_form.'" Berhasil Disimpan');
					redirect('approval_terlambat', 'refresh');
				}
				else {
					$this->session->set_flashdata('errors', 'Error occurred!!');
					redirect('approval_terlambat', 'refresh');
				}
			} else {
				$this->data['js'] 				= 'create';
				$this->form();
				$header_data = $this->Model_terlambat->getHeaderData($no_dok_h);
				$result['header'] = $header_data;
				$detail_item = $this->Model_terlambat->getDetailData($header_data['tdk_masuk_h_id']);
				foreach($detail_item as $k => $v) {
					$result['detail_item'][] = $v;
				}
				$this->data['header_data'] = $result;
				$this->data['kode_status'] = $this->Model_terlambat->getIdStatusCuti($header_data['status_absensi_id']);
				$this->render_template('terlambat/reject_detail',$this->data);
			}
		// }
	}

	public function tolak_action($id)
	{
		$nip 		= $this->session->userdata('nama_login');
		$biodata 	= $this->hrd->select('biodata_id')
						->get_where('db_akses.mst_biodata',array('nip' => $nip))
						->row_array();
		$pic = $biodata['biodata_id'];
		// die(json_encode($pic));
		$ket = 'BATAL DITOLAK';
		$data = $this->Model_terlambat->rejectApp($id,$pic,$nip,$ket);

		$this->session->set_flashdata('success', 'Dokumen Berhasil Proses');
		echo json_encode($data);
		redirect(''. $_SERVER['HTTP_REFERER']);
	}


	public function hari_libur()
	{

		// die(json_encode($data));
		$parent   = array();
		$data = $this->Model_terlambat->getHariLibur();
		if($data){
			for($i = 0; $i < count($data); $i++)
			{
				$parent[$i]['dates'] = $data[$i]['dates'];
			}
		}else{
			$output['data'] = [];
		}
		echo json_encode($parent);
	}
}

