<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ijin extends Admin_Controller  {
	private $hrd;
	public function __construct()
	{
		$this->data['modul'] = "Leaves";
		parent::__construct();
		$this->not_logged_in();
		$this->data['page_title'] = 'Ijin';
		$this->load->model('Model_ijin');
		$this->load->model('Model_cuti');
		$this->load->model('Model_cuti_tambahan');
		$this->load->model('Model_leave');
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
		$this->data['approval']  	= $this->Model_leave->PicApproval();
		$this->data['verifikasi']  	= $this->Model_leave->PicVerifikasiHrd();
		$data_status = $this->Model_ijin->getStatusCuti();
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
		$docCode	='HRI';
			$date		= date('ym');
			$dates		= date('Y-m-d');
			$nip 		= $this->session->userdata('nama_login');
			$biodata 	= $this->hrd->select('biodata_id')
						->get_where('hrd_all.mst_biodata',array('nip' => $nip))->row_array();
			$biodataid= $biodata['biodata_id'];
			$this->data['biodataid']	= $biodata['biodata_id'];
			$this->data['no_doc'] 		= $this->Model_ijin->getDataNoDoc($docCode,$date);
			$this->data['biodata'] 		= $this->Model_ijin->getDataUser();
			$this->data['normatifs'] 	= $this->Model_ijin->getDataNormatif($biodataid);
			$this->data['bonus'] 		= $this->Model_ijin->getDataBonus($biodataid,$dates);
			$this->data['tambahan'] 	= $this->Model_ijin->getDataTambahan($biodataid,$dates);
			$this->data['kodestore'] 	= $this->Model_ijin->getKodeStore($biodataid);
			$this->data['golabsen'] 	= $this->Model_ijin->getGolAbsen($biodataid);
		// die(json_encode($this->data['golabsen']));
		// SELECT  id FROM hrd_all.mst_biodata
		// 	WHERE nip ='".$nip."'
	}

	public function index()
	{
		$this->data['js'] = 'index';
		$this->form();
		$this->render_template('ijin/index',$this->data);
	}

	function tgl_unique()
	{
		// $tgl_ijin 	= $this->input->post('tgl_tdk_masuk');
		$log_detail = array();
		$count_tgl_tdk_masuk = count($this->input->post('tgl_tdk_masuk'));
		for($x = 0; $x < $count_tgl_tdk_masuk; $x++) {
			$tgl_tdk_masuks =  $this->input->post('tgl_tdk_masuk')[$x];
			$jam_ijin = date('H:i:s', strtotime($tgl_tdk_masuks));
			$tgl_ijin = date('Y-m-d', strtotime($tgl_tdk_masuks));
			$items = $tgl_ijin;
			// array(
			// 	'tgl_tdk_masuk' 	=> $tgl_ijin
			// );
			array_push($log_detail,$items);
		}

		$array 		= $log_detail;// get value
		// tesx($log_detail);
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

		if($this->input->post('status_absensi_id') == '000000000009' ||  $this->input->post('status_absensi_id') == '000000000061'){

			$this->form_validation->set_rules('file_1', 'Lampiran 1', 'callback_file_check_1');
			$this->form_validation->set_rules('file_2', 'Lampiran 2', 'callback_file_check_2');
			$this->form_validation->set_rules('file_3', 'Lampiran 3', 'callback_file_check_3');

		}

		$this->form_validation->set_rules('keterangan','Keterangan','required',
			array(	'required' 	=> 'Keterangan Tidak Boleh Kosong !!',
		));

		$count_tgl_tdk 	= $this->input->post('tgl_tdk_masuk');
		$count_tgl		= count(array($count_tgl_tdk));
		// tesx($count_tgl);
		if($count_tgl == 0){
            $this->form_validation->set_message('tgl_tdk_masuk[]', 'Tanggal Tidak Boleh Kosong !!');
            return false;
        } else {
            $this->form_validation->set_rules('tgl_tdk_masuk[]','Tanggal','required|callback_tgl_unique',
				array(	'required' 	=> 'Tanggal Tidak Boleh Kosong !!',
			));
        }

		if ($this->form_validation->run() == TRUE) {

			$create_form = $this->Model_ijin->create();

			if($create_form == true) {
				$this->session->set_flashdata('success', 'Ijin "'.$create_form.'" Berhasil Disimpan');
				redirect('leaves/ijin/index/', 'refresh');
			} else {
				$this->session->set_flashdata('errors', 'Error !!');
				redirect('leaves/ijin/create', 'refresh');
			}

		} else {
			$this->form();
			$this->data['js'] 		= 'create';
			$this->render_template('ijin/create', $this->data);
		}

	}


	/*
     * file value and type check during validation
     */
    public function file_check_1($str){
        $allowed_mime_type_arr = array('image/gif','image/jpeg','image/pjpeg','image/png','image/x-png');
        $mime = get_mime_by_extension($_FILES['file_1']['name']);


        if(isset($_FILES['file_1']['name']) && $_FILES['file_1']['name']!="" ){
            if(in_array($mime, $allowed_mime_type_arr)){
                return true;
            } else{
                $this->form_validation->set_message('file_check_1', 'Lampiran 1 hanya jpg/png file.');
                return false;
            }
        }else {
            $this->form_validation->set_message('file_check_1', 'Lampiran 1 Tidak Boleh Kosong !!');
            return false;
        }

    }

	public function file_check_2($str){
        $allowed_mime_type_arr = array('image/gif','image/jpeg','image/pjpeg','image/png','image/x-png');
        $mime = get_mime_by_extension($_FILES['file_2']['name']);


        if(isset($_FILES['file_2']['name']) && $_FILES['file_2']['name']!="" ){
            if(in_array($mime, $allowed_mime_type_arr)){
                return true;
            } else{
                $this->form_validation->set_message('file_check_2', 'Lampiran 2 hanya jpg/png file.');
                return false;
            }
        }else {
            $this->form_validation->set_message('file_check_2', 'Lampiran 2 Tidak Boleh Kosong !!');
            return false;
        }

    }

	public function file_check_3($str){
        $allowed_mime_type_arr = array('image/gif','image/jpeg','image/pjpeg','image/png','image/x-png');
        $mime = get_mime_by_extension($_FILES['file_3']['name']);


        if(isset($_FILES['file_3']['name']) && $_FILES['file_3']['name']!="" ){
            if(in_array($mime, $allowed_mime_type_arr)){
                return true;
            } else{
                $this->form_validation->set_message('file_check_3', 'Lampiran 3 hanya jpg/png file.');
                return false;
            }
        }else {
            $this->form_validation->set_message('file_check_3', 'Lampiran 3 Tidak Boleh Kosong !!');
            return false;
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

		$draw=$_REQUEST['draw'];
		$length=$_REQUEST['length'];
		$start=$_REQUEST['start'];
		//$search=$_REQUEST['search']["value"];
		$column = $_REQUEST['order'][0]['column'];
		$order 			= $_REQUEST['order'][0]['dir'];
		$search_no   = $_REQUEST['columns'][0]['search']["value"];

		// $this->hrd->where('biodata_id','60fbb75e1071');
		// $total=$this->hrd->count_all_results('hrd_all.trn_tdk_masuk_h');
		// die(json_encode($total));

		//$output['data']=array();
		$nip 		= $this->session->userdata('nama_login');
		$biodata 	= $this->hrd->select('biodata_id')
					->get_where( 'hrd_all.mst_biodata',array('nip' => $nip))->row_array();
		// die(json_encode($biodata));
		$no = $biodata['biodata_id'];
		$data = $this->Model_ijin->getCutiData1($no, $search_no,$length,$start,$column,$order);
		$data_jum = $this->Model_ijin->getCutiData2($no,$search_no);
		$output=array();
		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		if($search_no !="" ){
			$data_jum = $this->Model_ijin->getCutiData2($no,$search_no);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){
			$nip 		= $this->session->userdata('nama_login');
			$biodata 	= $this->hrd->select('biodata_id')
							->get_where( 'hrd_all.mst_biodata',array('nip' => $nip))->row_array();
			// die(json_encode($biodata));
			foreach ($data as $key => $value) {
				// if($biodata['biodata_id']==$value['biodata_id']){
					// button
					$buttons = '';
					$link_po = str_replace("/","_",$value['no_dok_tdk_masuk']);
					// $buttons .= ' <button onclick="_detail(\''.$value['no_dok_tdk_masuk'].')"
					// class="btn btn-primary mb-1"><i class="simple-icon-note" ></i> Detail</button>';
					$buttons .= ' <a href="'.base_url('leaves/ijin/detail/'.$value['tdk_masuk_h_id']).'" 
					class="btn btn-primary mb-1"><i class="simple-icon-note" title="Detail"></i> Detail</a>';
					if($value['is_posting']=='0'){$posting='Belum';}else{$posting='Sudah';}
					$output['data'][$key] = array(
						$value['no_dok_tdk_masuk'],
						$value['tgl_dok'],
						$value['keterangan'],
						// $value['potong_cuti_dari'],
						// $value['status'],
						// $value['nama_pic'],
						$value['posting'],
						$buttons
					);
				// }
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
		$header_data = $this->Model_ijin->getHeaderDataBC($no_dok_h);
		$result['header'] = $header_data;
		$detail_item = $this->Model_ijin->getDetailData($header_data['tdk_masuk_h_id']);

		foreach($detail_item as $k => $v) {
			$result['detail_item'][] = $v;
		}
		$this->data['header_data'] = $result;

		$this->data['approval_data'] 	= $this->Model_cuti->getDataPosting($header_data['tdk_masuk_h_id']);
		$urutan_app	= $this->Model_cuti->urutanApp($header_data['biodata_id']);
		foreach($urutan_app as $k => $v) {
			$result_app['urutan_app'][] = $v;
		}
		$this->data['urutan_data'] 	= $this->Model_cuti->urutanApp($header_data['biodata_id']);
		$this->data['kode_status'] = $this->Model_ijin->getIdStatusCuti($header_data['status_absensi_id']);
		$this->render_template('ijin/detail',$this->data);
	}

	public function approval()
	{
		$this->form();
		$this->render_template('ijin/approval',$this->data);
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
		$search_nama  = $_REQUEST['columns'][2]['search']["value"];

		$nip 		= $this->session->userdata('nama_login');
		$biodata 	= $this->hrd->select('kode_dept')
					->get_where('db_akses.mst_user',array('nip_user' => $nip))->row_array();
		// die(json_encode($biodata));
		$no = $biodata['kode_dept'];
		$data = $this->Model_ijin->getApprovalData1($nip, $search_no,$length,$start,$column,$order);
		$data_jum = $this->Model_ijin->getApprovalData2($nip,$search_no);
		$output=array();
		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		if($search_no !="" ){
			$data_jum = $this->Model_ijin->getApprovalData2($nip,$search_no);
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
					$buttons .= '<div class="mb-4">
								<a href="'.base_url('leaves/ijin/approval_detail/'.$value['tdk_masuk_h_id']).'"
								class="btn btn-success btn-xs mb-2"><i class="iconsminds-yes" title="Approve"></i> APP</a>
								';
					$buttons .= '<div class="mb-4">
								<a href="'.base_url('leaves/ijin/reject_detail/'.$value['tdk_masuk_h_id']).'"
								class="btn btn-danger btn-xs mb-2"><i class="iconsminds-yes" title="Reject"></i> REJ</a>
								';

					// $buttons .= '<a class="btn rounded btn-danger btn-xs mb-2" href="javascript:void(0)" title="Reject"
					// onclick="delete_person('."'".$value['tdk_masuk_h_id']."'".')">
					// <i class="iconsminds-close" title="Tolak"></i> REJ</a>
					// </div>';

					// $output['data'][$key] = array(
						// 	$value['no_dok_tdk_masuk'],
						// 	$value['tgl_dok'],
						// 	$value['keterangan'],
						// 	$value['potong_cuti_dari'],
						// 	$value['status'],
						// 	$value['nama_pic'],
						// 	$buttons
					// );
					$arr_result = array(
						$value['tdk_masuk_h_id'],
						$value['no_dok_tdk_masuk'],
						$value['nama_lengkap'],
						$value['keterangan'],
						$value['tgl_dok_tdk_masuk'],
						$buttons
					);
					$array_secondary = array();
						$data_detail = $this->Model_ijin->getDetailData($value['tdk_masuk_h_id']);
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

	public function fetchDataApprovalHistory()
	{
		$output 	= array('data' => array());
		$draw		= $_REQUEST['draw'];
		$length		= $_REQUEST['length'];
		$start		= $_REQUEST['start'];
		$column 	= $_REQUEST['order'][0]['column'];
		$order  	= $_REQUEST['order'][0]['dir'];
		$search_no 	  = $_REQUEST['columns'][0]['search']["value"];
		$search_nama  = $_REQUEST['columns'][4]['search']["value"];
		// $search_nama  = $_REQUEST['search']["value"];
		$nip 		= $this->session->userdata('nama_login');

		$data 		= $this->Model_ijin->getDataIjinHistory($nip,$search_no,$search_nama,$length,$start,$column,$order);
		$data_jum 	= $this->Model_ijin->getCountHistory($nip,$search_no,$search_nama);

		$output			= array();
		$output['draw']	=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		if($search_no !="" || $search_nama !="" ){
			$data_jum = $this->Model_ijin->getCountHistory($nip,$search_no,$search_nama);
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

				$file1 = '	<div>
									<a class="portfolio-popup" target="_blank"
										href="'.base_url('upload/ijin/'.$value['file_1']).'">
										<img src="'.base_url('upload/ijin/'.$value['file_1']).'" width="90px">
									</a>
								</div>';
				$file2 = '	<div>
							<a class="portfolio-popup" target="_blank"
								href="'.base_url('upload/ijin/'.$value['file_2']).'">
								<img src="'.base_url('upload/ijin/'.$value['file_2']).'" width="90px">
							</a>
							</div>';
				$file3 = '	<div>
							<a class="portfolio-popup" target="_blank"
								href="'.base_url('upload/ijin/'.$value['file_3']).'">
								<img src="'.base_url('upload/ijin/'.$value['file_3']).'" width="90px">
							</a>
							</div>';

				$array_secondary = array();
				$data_detail = $this->Model_ijin->getDataIjinHistoryDetail($value['no_dok_tdk_masuk']);
				foreach ($data_detail as $key => $row2)
				{

					$arr_result2 = array(
						$row2['nama_hari'],
						$row2['tgl_tdk_masuk'],
						$row2['jam_ijin'],
						$row2['jam_kembali'],
						$row2['potong_cuti_dari'],
						$row2['keterangan'],
						$file1,
						$file2,
						$file3,
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
		$data = $this->Model_ijin->getApprovalDataReject1($no, $search_no,$length,$start,$column,$order);
		// die(json_encode($data));
		$data_jum = $this->Model_ijin->getApprovalDataReject2($no,$search_no);
		$output=array();
		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		if($search_no !="" ){
			$data_jum = $this->Model_ijin->getApprovalDataReject2($no,$search_no);
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
						$data_detail = $this->Model_ijin->getDetailData($value['tdk_masuk_h_id']);
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
		$this->form_validation->set_rules('no_doc' ,'No Dokumen' , 'trim|required',$this->val_error);
		if ($this->form_validation->run() == TRUE) {
			if($this->session->userdata('nama_login')!= '99999999'){
				$create_form = $this->Model_ijin->ApproveAction();
			}else{
				$create_form = $this->Model_ijin->ApproveDireksi();
			}

			if($create_form) {
				$this->session->set_flashdata('success', 'Approve "'.$create_form.'" Berhasil Disimpan');
				redirect('approval_ijin', 'refresh');
			}
			else {
				$this->session->set_flashdata('errors', 'Error occurred!!');
				redirect('approval_ijin', 'refresh');
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
				$header_data = $this->Model_ijin->getHeaderData($no_dok_h);
			}else{
				$header_data = $this->Model_ijin->getHeaderDataBC($no_dok_h);
			}
			$result['header'] = $header_data;
			$detail_item = $this->Model_ijin->getDetailData($header_data['tdk_masuk_h_id']);
			foreach($detail_item as $k => $v) {
				$result['detail_item'][] = $v;
			}
			$this->data['header_data'] = $result;
			$this->data['kode_status'] = $this->Model_ijin->getIdStatusCuti($header_data['status_absensi_id']);
			$this->render_template('ijin/approval_detail',$this->data);
		}

	}

	public function verifikasi()
	{
		$this->form();
		$this->render_template('ijin/verifikasi',$this->data);
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
		$data = $this->Model_ijin->getVerifikasi1($nip, $search_no,$length,$start,$column,$order);
		$data_jum = $this->Model_ijin->getVerifikasi2($nip,$search_no);
		$output=array();
		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		if($search_no !="" ){
			$data_jum = $this->Model_ijin->getVerifikasi2($nip,$search_no);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){
			foreach ($data as $key => $value) {

					$buttons = '';
					if($value['jn']=='IJIN'){
						$buttons .= '<div class="mb-4">
									<a href="'.base_url('leaves/ijin/verifikasi_detail/'.$value['tdk_masuk_h_id']).'"
									class="btn btn-success btn-xs mb-2"><i class="iconsminds-yes" title="Approve"></i> Verifikasi</a>
						';
						// $buttons .= '<div class="mb-4">
						// 			<a href="'.base_url('leaves/ijin/reject_verifikasi/'.$value['tdk_masuk_h_id']).'"
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
						$data_detail = $this->Model_ijin->getDetailData($value['tdk_masuk_h_id']);
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

	public function fetchDataVerifikasiHistory()
	{
		$output = array('data' => array());

		$draw		  = $_REQUEST['draw'];
		$length		  = $_REQUEST['length'];
		$start		  = $_REQUEST['start'];
		$column 	  = $_REQUEST['order'][0]['column'];
		$order  	  = $_REQUEST['order'][0]['dir'];
		$search_no 	  = $_REQUEST['columns'][0]['search']["value"];
		$search_nama  = $_REQUEST['columns'][3]['search']["value"];

		$nip 		= $this->session->userdata('nama_login');
		$data = $this->Model_ijin->getVerifikasiHistory1($nip, $search_no, $search_nama,$length,$start,$column,$order);
		$data_jum = $this->Model_ijin->getVerifikasiHistory2($nip,$search_no, $search_nama);
		$output=array();
		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		if($search_no !="" || $search_nama !="" ){
			$data_jum = $this->Model_ijin->getVerifikasiHistory2($nip,$search_no,$search_nama);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		// tesx($data);

		if($data){

			foreach ($data as $key => $value) {

					$arr_result = array(
						$value['no_dok_cuti'],
						$value['tgl_dok_cuti'],
						$value['nip'],
						$value['nama_lengkap'],
						$value['nama_dept'],
						$value['jn'],
						$value['catatan'],
					);

							$file1 ='<div>
										<a class="portfolio-popup" target="_blank"
											href="'.base_url('upload/ijin/'.$value['lam1']).'">
											<img src="'.base_url('upload/ijin/'.$value['lam1']).'" width="90px">
										</a>
									</div>';
							$file2 ='<div>
										<a class="portfolio-popup" target="_blank"
											href="'.base_url('upload/ijin/'.$value['lam2']).'">
											<img src="'.base_url('upload/ijin/'.$value['lam2']).'" width="90px">
										</a>
									</div>';
							$file3 ='<div>
										<a class="portfolio-popup" target="_blank"
											href="'.base_url('upload/ijin/'.$value['lam3']).'">
											<img src="'.base_url('upload/ijin/'.$value['lam3']).'" width="90px">
										</a>
									</div>';


					$array_secondary = array();
						$data_detail = $this->Model_ijin->getDetailHD($value['id_doc'], $value['jn']);


						foreach ($data_detail as $key => $row2)
						{
							$arr_result2 = array(
								$row2['tgl_ijin'],
								$row2['nama_hari'],
								$row2['keterangan'],
							);
							$array_secondary[] = $arr_result2;
						}
					$arr_result['secondary'] =  $array_secondary;

					$arr_result['file1'] =  $file1;
					$arr_result['file2'] =  $file2;
					$arr_result['file3'] =  $file3;

					// tesx($array_secondary);

					$output['data'][] = $arr_result;

			}

			// tesx($output);


		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}

	public function verifikasi_detail($no_dok_h)
	{
		$this->form_validation->set_rules('no_doc' ,'No Dokumen' , 'trim|required',$this->val_error);
		if ($this->form_validation->run() == TRUE) {

			if (empty($this->input->post('alasan_reject'))) {
				$create_form = $this->Model_ijin->VerifikasiAction();
			} else {
				$create_form = $this->Model_ijin->VerifikasiReject();
			}

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
			$header_data = $this->Model_ijin->getHeaderDataBC($no_dok_h);
			$result['header'] = $header_data;
			$detail_item = $this->Model_ijin->getDetailData($header_data['tdk_masuk_h_id']);
			foreach($detail_item as $k => $v) {
				$result['detail_item'][] = $v;
			}
			$this->data['header_data'] = $result;
			$this->data['kode_status'] = $this->Model_ijin->getIdStatusCuti($header_data['status_absensi_id']);
			$this->render_template('ijin/verifikasi_detail',$this->data);
		}

	}

	public function verifikasi_reject($no_dok_h)
	{
			$create_form = $this->Model_ijin->VerifikasiReject();

			if($create_form) {
				$this->session->set_flashdata('success', 'Approve "'.$create_form.'" Berhasil Disimpan');
				redirect('verifikasi_ijin', 'refresh');
			}
			else {
				$this->session->set_flashdata('errors', 'Error occurred!!');
				redirect('verifikasi_ijin', 'refresh');
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
		// 		redirect('approval_ijin', 'refresh');
		// } else {
			if ($this->form_validation->run() == TRUE) {

				$nip 		= $this->session->userdata('nama_login');
				$biodata 	= $this->hrd->select('biodata_id')
								->get_where('hrd_all.mst_biodata',array('nip' => $nip))
								->row_array();
				$pic = $biodata['biodata_id'];
				$ket = $this->input->post('reject_komentar');

				$create_form = $this->Model_ijin->rejectApp($no_dok_h,$pic,$nip,$ket);

				if($create_form) {
					$this->session->set_flashdata('success', 'Approve "'.$create_form.'" Berhasil Disimpan');
					redirect('approval_ijin', 'refresh');
				}
				else {
					$this->session->set_flashdata('errors', 'Error occurred!!');
					redirect('approval_ijin', 'refresh');
				}
			} else {
				$this->data['js'] 				= 'create';
				$this->form();
				$header_data = $this->Model_ijin->getHeaderDataBC($no_dok_h);
				$result['header'] = $header_data;
				$detail_item = $this->Model_ijin->getDetailData($header_data['tdk_masuk_h_id']);
				foreach($detail_item as $k => $v) {
					$result['detail_item'][] = $v;
				}
				$this->data['header_data'] = $result;
				$this->data['kode_status'] = $this->Model_ijin->getIdStatusCuti($header_data['status_absensi_id']);
				$this->render_template('ijin/reject_detail',$this->data);
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
		// 		redirect('approval_ijin', 'refresh');
		// } else {
			if ($this->form_validation->run() == TRUE) {

				$nip 		= $this->session->userdata('nama_login');
				$biodata 	= $this->hrd->select('biodata_id')
								->get_where('hrd_all.mst_biodata',array('nip' => $nip))
								->row_array();
				$pic = $biodata['biodata_id'];
				$ket = $this->input->post('reject_komentar');

				$create_form = $this->Model_ijin->rejectApp($no_dok_h,$pic,$nip,$ket);

				if($create_form) {
					$this->session->set_flashdata('success', 'Approve "'.$create_form.'" Berhasil Disimpan');
					redirect('approval_ijin', 'refresh');
				}
				else {
					$this->session->set_flashdata('errors', 'Error occurred!!');
					redirect('approval_ijin', 'refresh');
				}
			} else {
				$this->data['js'] 				= 'create';
				$this->form();
				$header_data = $this->Model_ijin->getHeaderData($no_dok_h);
				$result['header'] = $header_data;
				$detail_item = $this->Model_ijin->getDetailData($header_data['tdk_masuk_h_id']);
				foreach($detail_item as $k => $v) {
					$result['detail_item'][] = $v;
				}
				$this->data['header_data'] = $result;
				$this->data['kode_status'] = $this->Model_ijin->getIdStatusCuti($header_data['status_absensi_id']);
				$this->render_template('ijin/reject_detail',$this->data);
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
		$data = $this->Model_ijin->rejectApp($id,$pic,$nip,$ket);

		$this->session->set_flashdata('success', 'Dokumen Berhasil Proses');
		echo json_encode($data);
		redirect(''. $_SERVER['HTTP_REFERER']);
	}


	public function hari_libur()
	{

		// die(json_encode($data));
		$parent   = array();
		$data = $this->Model_ijin->getHariLibur();
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

	public function getAbsenMasuk(){
		$tgl_ijin 	= $this->input->post('tgl',TRUE);
		$tgl	 	= date('Y-m-d', strtotime($tgl_ijin));
		// die(json_encode($tgl));
		$nip=$this->session->userdata('nama_login');
		$biodata 	= $this->hrd->select('biodata_id,status_menikah,gender')
					->get_where('hrd_all.mst_biodata',array('nip' => $nip))->row_array();
		$biodataid= $biodata['biodata_id'];

        $datas 	= $this->Model_ijin->getAbsenMasuk($tgl,$biodataid,$nip)->row_array();
		if ($datas == null){
			$data = array( 'jm' => 'Tidak_ada_data_absen');
		}else{
			$data 	= $this->Model_ijin->getAbsenMasuk($tgl,$biodataid,$nip)->row_array();
		}

        echo json_encode($data);
	}


}

