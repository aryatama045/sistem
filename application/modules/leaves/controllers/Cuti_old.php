<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cuti extends Admin_Controller  {
	private $hrd;
	public function __construct()
	{
		$this->data['modul'] = "Leaves";
		parent::__construct();
		$this->not_logged_in();
		$this->data['page_title'] = 'Cuti';
		$this->load->model('Model_cuti');
		$this->load->model('Model_leave');
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
		$data_status = $this->Model_cuti->getStatusCuti();
		$list_status_absensi_id = array(""=>"");
		foreach ($data_status as $key => $value) {
			$list_status_absensi_id[$value['status_absensi_id']]= $value['ket_status_absensi'];
			// if($value['ket_status_absensi'] == 'CUTI 1/2 HARI'){
			// 	$list_status_absensi_id[$value['ket_status_absensi']]= $value['ket_status_absensi'];
			// } else {
			// 	$list_status_absensi_id[$value['status_absensi_id']]= $value['ket_status_absensi'];
			// }
		}
		$this->data['status_absensi_id'] = [
			'name'   	=> 'status_absensi_id',
			'id'   		=> 'status_absensi_id',
			'class'  	=> 'form-control select2-single selectpicker',
			'required'	=> 'required',
			'style'		=> 'width:100%;'
		];
		$this->data['status_absensi_id_option'] = $list_status_absensi_id;
		$docCode	='HRC';
		$date		= date('ym');
		$dates		= date('Y-m-d');
		$nip 		= $this->session->userdata('nama_login');
		$biodata 	= $this->hrd->select('biodata_id,status_menikah,gender')
					->get_where('hrd_all.mst_biodata',array('nip' => $nip))->row_array();
		$biodataid= $biodata['biodata_id'];
		$this->data['biodataid']	= $biodata['biodata_id'];
		$this->data['no_doc'] 		= $this->Model_cuti->getDataNoDoc($docCode,$date);
		$this->data['biodata'] 		= $this->Model_cuti->getDataUser();
		$this->data['normatifs'] 	= $this->Model_cuti->getDataNormatif($biodataid);
		$this->data['bonus'] 		= $this->Model_cuti->getDataBonus($biodataid,$dates);
		$this->data['tambahan'] 	= $this->Model_cuti->getDataTambahan($biodataid,$dates);
		$this->data['masa_tambahan']= $this->Model_cuti->getMasaBerlakuTambahan($biodataid,$dates);
		$this->data['masa_ASC']= $this->Model_cuti->getMasaBerlakuTambahanASC($biodataid,$dates);
		$this->data['masa_DESC']= $this->Model_cuti->getMasaBerlakuTambahanDESC($biodataid,$dates);
		$this->data['kodestore'] 	= $this->Model_cuti->getKodeStore($biodataid);
		$this->data['golabsen'] 	= $this->Model_cuti->getGolAbsen($biodataid);

		// die(json_encode($this->data['no_doc']));
	}

	public function index()
	{
		$this->form();
		$this->render_template('cuti/index',$this->data);
	}

	public function fetchDataCuti()
	{
		$output = array('data' => array());

		$draw=$_REQUEST['draw'];
		$length=$_REQUEST['length'];
		$start=$_REQUEST['start'];
		$column = $_REQUEST['order'][0]['column'];
		$order 			= $_REQUEST['order'][0]['dir'];
		$search_no   = $_REQUEST['columns'][0]['search']["value"];


		$nip 		= $this->session->userdata('nama_login');
		$biodata 	= $this->hrd->select('biodata_id')
					->get_where( 'hrd_all.mst_biodata',array('nip' => $nip))->row_array();

		$no = $biodata['biodata_id'];


		$data = $this->Model_cuti->getCutiData1($no, $search_no,$length,$start,$column,$order);
		$data_jum = $this->Model_cuti->getCutiData2($no,$search_no);
		$output=array();
		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		if($search_no !="" ){
			$data_jum = $this->Model_cuti->getCutiData2($no,$search_no);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){

			foreach ($data as $key => $value) {
					$buttons = '';
					// $buttons .= ' <button onclick="edit_person('."'".$value['tdk_masuk_h_id']."'".')"
					// class="btn btn-primary mb-1"><i class="simple-icon-note" ></i> Edit</button>';

					$buttons .= ' <a href="'.base_url('leaves/cuti/detail/'.$value['tdk_masuk_h_id']).'" 
					class="btn btn-primary mb-1"><i class="simple-icon-note" title="Detail"></i> Detail</a>';

					if($value['status_dokumen']=='O' && $value['is_posting']==0){
						$buttons .= ' <a href="'.base_url('leaves/batal/detail/'.$value['no_dok_tdk_masuk']).'"
						class="btn btn-danger mb-1"><i class="simple-icon-trash" title="Batal"></i> Batal</a>';
					}

					$output['data'][$key] = array(
						$value['no_dok_tdk_masuk'],
						$value['tgl_dok'],
						$value['keterangan'],
						$value['potong_cuti_dari'],
						$value['posting'],
						$buttons
					);
			}
		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}

	public function ket_check($str)
	{
		// $str = $this->input->post('keterangan_cuti');
		$this->form_validation->set_message('ket_checks', 'The field can not be the word ');
		$count_array = array_count_values($str);

		$results = array();
		foreach($count_array as $key=>$val){
			if($val == 1){
				return TRUE;
			}
			else{
				return FALSE;
			}
		}
	}

	function all_unique()
	{
		$array = $this->input->post('keterangan_cuti');// get bonus value
		$this->form_validation->set_message('all_unique', '%s tidak boleh sama.');

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
		$this->form_validation->set_rules('potong_cuti_dari' ,'Sumber Potong Cuti' , 'trim|required',$this->val_error);
		// $this->form_validation->set_rules('keterangan_cuti[]','Ket Cuti','required|callback_all_unique',
		// 		array(	'required' 	=> 'Keterangan Cuti Tidak Boleh Kosong !!',
		// 		));
		$this->form_validation->set_rules('tgl_tdk_masuk[]','Tanggal Cuti','required|callback_tgl_unique',
				array(	'required' 	=> 'Tanggal Cuti Tidak Boleh Kosong !!',
				));
		if ($this->form_validation->run() == TRUE) {
			// Jumlah Ambil Cuti
				if($this->input->post('jumlah_hari')=='1'){
					$jml_ambil = count($this->input->post('tgl_tdk_masuk'));
				}else{
					$jml_ambil = count($this->input->post('tgl_tdk_masuk'))*'0.5';
				}
			//end
			$tgl_tdk_masuk	= $this->input->post('tgl_tdk_masuk');
			$biodataids		= $this->input->post('biodata_id');

			// Sumber Potong Cuti
				$potong_cuti = $this->input->post('potong_cuti_dari');
				if($potong_cuti=='NORMATIF'){
					$saldo = $this->input->post('sisa_normatif');
				}
				if($potong_cuti=='BONUS'){
					$saldo = $this->input->post('sisa_bonus');
					if($saldo < $jml_ambil){
						$this->session->set_flashdata('error', 'Jumlah Pengajuan Cuti "'.$jml_ambil.'"  Tidak Boleh Melebihi Dari Saldo "'.$saldo.'" Sumber Potong Cuti !!');
						redirect('leaves/cuti/create', 'refresh');
					}
				}
				if($potong_cuti=='TAMBAHAN'){
					$saldo = $this->input->post('sisa_tambahan');
					if($saldo < $jml_ambil){
						$this->session->set_flashdata('error', 'Jumlah Pengajuan Cuti "'.$jml_ambil.' hari",  Tidak Boleh Melebihi Dari Saldo "'.$saldo.'" Sumber Potong Cuti !!');
						redirect('leaves/cuti/create', 'refresh');
					}
				}
			//end
			// tesx($saldo,$jml_ambil);


			foreach($tgl_tdk_masuk as $k => $v){

				$cek_tgl_cuti = $this->Model_cuti->getTglCuti($biodataids, $v);
				if($v == $cek_tgl_cuti['tgl_tdk_masuk']){
					$this->session->set_flashdata('error', $v.' Tanggal Cuti Sudah Ada!!');
					redirect('leaves/cuti/create', 'refresh');
				}
			}

			if($potong_cuti == 'BONUS' ){
				if ($jml_ambil <= $saldo){

					$create_form = $this->Model_cuti->create();

					if($create_form) {
						$this->session->set_flashdata('success', 'Cuti "'.$create_form.'" Berhasil Disimpan');
						redirect('leaves/cuti/index/', 'refresh');
					}
					else {
						$this->session->set_flashdata('error', 'Error occurred!!');
						redirect('leaves/cuti/create', 'refresh');
					}
				} else {
					// tesx('saldo kurang');
					$this->session->set_flashdata('error', 'Jumlah Pengajuan Cuti "'.$jml_ambil.'"  Tidak Boleh Melebihi Dari Saldo "'.$saldo.'" Sumber Potong Cuti !!');
					redirect('leaves/cuti/create', 'refresh');
				}
			} else {
				// tesx('ok');
				$create_form = $this->Model_cuti->create();
				if($create_form) {
					$this->session->set_flashdata('success', 'Cuti "'.$create_form.'" Berhasil Disimpan');
					redirect('leaves/cuti/index/', 'refresh');
				}
				else {
					$this->session->set_flashdata('error', 'Error occurred!!');
					redirect('leaves/cuti/create', 'refresh');
				}
			}
		} else {

			$this->form();
			$this->data['js'] 		= 'create';
			$this->render_template('cuti/create', $this->data);
		}
	}

	public function detail($no_dok_h)
	{
		$this->form();
		$this->data['js'] 	= 'create';
		$header_data 		= $this->Model_cuti->getHeaderDataBC($no_dok_h);
		$result['header'] 	= $header_data;
		$detail_item 		= $this->Model_cuti->getDetailData($header_data['tdk_masuk_h_id']);
		foreach($detail_item as $k => $v) {
			$result['detail_item'][] = $v;
		}
		$this->data['header_data'] 	= $result;

		$this->data['approval_data'] 	= $this->Model_cuti->getDataPosting($header_data['tdk_masuk_h_id']);
		$urutan_app	= $this->Model_cuti->urutanApp($header_data['biodata_id']);
		foreach($urutan_app as $k => $v) {
			$result_app['urutan_app'][] = $v;
		}
		$this->data['urutan_data'] 	= $this->Model_cuti->urutanApp($header_data['biodata_id']);
		$this->render_template('cuti/detail',$this->data);
	}

	public function approval()
	{
		$this->form();

		$this->render_template('cuti/approval',$this->data);
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
		$search_nama  = $_REQUEST['columns'][1]['search']["value"];

		$nip 		= $this->session->userdata('nama_login');
		$data 		= $this->Model_cuti->getApprovalData1($nip, $search_no,$search_nama,$length,$start,$column,$order);
		$data_jum 	= $this->Model_cuti->getApprovalData2($nip,$search_no,$search_nama);
		$output		= array();
		$output['draw']			=$draw;
		$output['recordsTotal']	=$output['recordsFiltered']=$data_jum;
		if($search_no !="" || $search_nama !=""){
			$data_jum = $this->Model_cuti->getApprovalData2($nip,$search_no,$search_nama);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){
			$nip 		= $this->session->userdata('nama_login');
			$biodata 	= $this->hrd->select('biodata_id')
							->get_where( 'hrd_all.mst_biodata',array('nip' => $nip))->row_array();
			// die(json_encode($biodata));
			$no =0;
			foreach ($data as $key => $value) {
					$buttons = '';
					$buttons .= '<div class="mb-4">
								<a href="'.base_url('leaves/cuti/approval_detail/'.$value['tdk_masuk_h_id']).'"
								class="btn btn-success btn-xs mb-2"><i class="iconsminds-yes" title="Approve"></i> APP</a>
								';
					$buttons .= '<div class="mb-4">
								<a href="'.base_url('leaves/cuti/reject_detail/'.$value['tdk_masuk_h_id']).'"
								class="btn btn-danger btn-xs mb-2"><i class="iconsminds-yes" title="Reject"></i> REJ</a>
								';

					$arr_result = array(
						$buttons,
						$value['nama_lengkap'],
						$value['nip'],
						$value['no_dok_tdk_masuk'],
						$value['tgl_dok_tdk_masuk'],
						$value['tdk_masuk_h_id']
					);
					$array_secondary = array();
						$data_detail = $this->Model_cuti->getDetailData($value['tdk_masuk_h_id']);
						foreach ($data_detail as $key => $row2)
						{
							$arr_result2 = array(
								$row2['tgl_tdk_masuk'],
								$row2['nama_hari'],
								$row2['keterangan'],
							);
							$array_secondary[] = $arr_result2;
						}
					// die(json_encode($array_secondary));
					$arr_result['secondary'] =  $array_secondary;

					$output['data'][] = $arr_result;

			}
		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}

	public function fetchDataHistory()
	{
		$output = array('data' => array());

		$draw		  = $_REQUEST['draw'];
		$length		  = $_REQUEST['length'];
		$start		  = $_REQUEST['start'];
		$column 	  = $_REQUEST['order'][0]['column'];
		$order  	  = $_REQUEST['order'][0]['dir'];
		$search_no 	  = $_REQUEST['columns'][0]['search']["value"];
		$search_nama  = $_REQUEST['columns'][4]['search']["value"];

		$nip 		= $this->session->userdata('nama_login');
		$data 		= $this->Model_cuti->getApprovedHistory($nip, $search_no,$search_nama,$length,$start,$column,$order);
		$data_jum 	= $this->Model_cuti->getCountApprovedHistory($nip,$search_no,$search_nama);
		$output=array();
		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		if($search_no !="" || $search_nama !=""){
			$data_jum = $this->Model_cuti->getCountApprovedHistory($nip,$search_no,$search_nama);
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
						$value['posting'],
					);
					$array_secondary = array();
					$data_detail = $this->Model_cuti->getDetailData($value['tdk_masuk_h_id']);
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

	public function approval_detail($no_dok_h)
	{
		$this->form_validation->set_rules('potong_cuti_dari' ,'Sumber Potong Cuti' , 'trim|required',$this->val_error);

		if ($this->form_validation->run() == TRUE) {
			// tesx('mmm');
			if($this->session->userdata('nama_login') != '99999999'){
				$create_form = $this->Model_cuti->ApproveAction();
			}else{
				$create_form = $this->Model_cuti->ApproveDireksi();
			}

			if($create_form) {
				$this->session->set_flashdata('success', 'Approve "'.$create_form.'" Berhasil Disimpan');
				redirect('approval_cuti', 'refresh');
			}
			else {
				$this->session->set_flashdata('errors', 'Error occurred!!');
				redirect('approval_cuti', 'refresh');
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
			$this->data['getCount']		= $this->Model_cuti->count_nip($biodataids);
			if($this->session->userdata('nama_login') != '99999999'){
				$header_data = $this->Model_cuti->getHeaderDataBC($no_dok_h);
			}else{
				$header_data = $this->Model_cuti->getHeaderDataBC($no_dok_h);
			}

			$result['header'] = $header_data;
			$detail_item = $this->Model_cuti->getDetailData($header_data['tdk_masuk_h_id']);

			foreach($detail_item as $k => $v) {
				$result['detail_item'][] = $v;
			}
			$this->data['header_data'] = $result;
			$this->render_template('cuti/approval_detail',$this->data);
		}

	}

	public function reject_detail($no_dok_h)
	{
		$this->form_validation->set_rules('potong_cuti_dari' ,'Sumber Potong Cuti' , 'trim|required',$this->val_error);
		$this->form_validation->set_rules('reject_komentar','Reject Cuti','required',
				array(	'required' 	=> 'Reject Komentar Cuti Tidak Boleh Kosong !!',
				));
		$pic_data = $this->Model_cuti->getHeaderData($no_dok_h);
		$biodata_rej = $pic_data['biodata_id'];
		$jml_reject = $this->Model_cuti->rejectData($biodata_rej);
		// die(json_encode($jml_reject));

		// if ($jml_reject['jml'] > 3) {
		// 		$this->session->set_flashdata('error', 'Tidak Bisa Proses, "'.$pic_data['nama_lengkap'].'" Sudah Reject  3x !!');
		// 		redirect('approval_cuti', 'refresh');
		// } else {
			if ($this->form_validation->run() == TRUE) {

					$nip 		= $this->session->userdata('nama_login');
					$biodata 	= $this->hrd->select('biodata_id')
									->get_where('hrd_all.mst_biodata',array('nip' => $nip))
									->row_array();
					$pic = $biodata['biodata_id'];
					$ket = $this->input->post('reject_komentar');

					if($this->session->userdata('nama_login') != '99999999'){
						$create_form = $this->Model_cuti->rejectApp($no_dok_h,$pic,$nip,$ket);
					}else{
						$pic 		= $this->session->userdata('nama_login');
						$create_form = $this->Model_cuti->rejectDireksi($no_dok_h,$pic,$nip,$ket);
					}

					if($create_form) {
						$this->session->set_flashdata('success', 'Approve "'.$create_form.'" Berhasil Disimpan');
						redirect('approval_cuti', 'refresh');
					}
					else {
						$this->session->set_flashdata('errors', 'Error occurred!!');
						redirect('approval_cuti', 'refresh');
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
				if($this->session->userdata('nama_login') != '99999999'){
					$header_data = $this->Model_cuti->getHeaderData($no_dok_h);
				}else{
					$header_data = $this->Model_cuti->getHeaderDataBC($no_dok_h);
				}
				$result['header'] = $header_data;
				$detail_item = $this->Model_cuti->getDetailData($header_data['tdk_masuk_h_id']);

				foreach($detail_item as $k => $v) {
					$result['detail_item'][] = $v;
				}
				$this->data['header_data'] = $result;
				$this->render_template('cuti/reject_detail',$this->data);
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
		$data = $this->Model_cuti->rejectApp($id,$pic,$nip,$ket);

		$this->session->set_flashdata('success', 'Dokumen Berhasil Proses');
		echo json_encode($data);
		redirect(''. $_SERVER['HTTP_REFERER']);
	}

	public function hari_libur()
	{

		// die(json_encode($data));
		$parent   = array();
		$data = $this->Model_cuti->getHariLibur();
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

	public function email_cuti($no_dok_h)
	{

		$header_data = $this->Model_cuti->getHeaderData($no_dok_h);
		$urutan_app = $header_data['jml_app'];
		$result['header'] = $header_data;

		$biodata_id 		= $header_data['biodata_id'];
		$biodata 			= $this->Model_leave->get_email_pic($biodata_id );

		$pic_app 			= $this->Model_leave->get_email_app($biodata_id, $urutan_app);

		// die(json_encode($biodata_id));

		$data = array(	'judul' 		=> 'Cuti',
						'nama_user'		=> $biodata['nama_lengkap'],
						'nip'			=> $biodata['nip'],
						'divisi'		=> $biodata['nama_dept'],
						'jml_app'		=> $header_data['jml_app'],
						'mailto'		=> $pic_app['email']
					);

		$detail_item = $this->Model_cuti->getDetailData($header_data['tdk_masuk_h_id']);

		foreach($detail_item as $k => $v) {
			$result['detail_item'][] = $v;
		}
		$data['header_data'] = $result;

		// die(json_encode($data));

		$this->load->view('email/cuti_approval', $data);
	}

	public function get_no_doc($id)
	{
		$data = $this->Model_cuti->getHeaderDataBC($id);
		// tesx($data);
		echo json_encode($data);
	}

}

