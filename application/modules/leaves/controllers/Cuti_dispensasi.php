<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cuti_dispensasi extends Admin_Controller  {
	private $hrd;
	public function __construct()
	{
		$this->data['modul'] = "Leaves";
		parent::__construct();
		$this->not_logged_in();
		$this->data['page_title'] = 'Cuti Dispensasi';
		$this->load->model('Model_cuti_dispensasi');
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
		$docCode	='HRCD';
		$date		= date('ym');
		$dates		= date('Y-m-d');
		$nip 		= $this->session->userdata('nama_login');
		$biodata 	= $this->hrd->select('biodata_id,status_menikah,gender')
					->get_where('hrd_all.mst_biodata',array('nip' => $nip))->row_array();
		$biodataid= $biodata['biodata_id'];
		$this->data['biodataid']	= $biodata['biodata_id'];
		$this->data['no_doc'] 		= $this->Model_cuti_dispensasi->getDataNoDoc($docCode,$date);
		$this->data['biodata'] 		= $this->Model_cuti_dispensasi->getDataUser();
		$this->data['normatifs'] 	= $this->Model_cuti_dispensasi->getDataNormatif($biodataid);
		$this->data['bonus'] 		= $this->Model_cuti_dispensasi->getDataBonus($biodataid,$dates);
		$this->data['tambahan'] 	= $this->Model_cuti_dispensasi->getDataTambahan($biodataid,$dates);
		$this->data['kodestore'] 	= $this->Model_cuti_dispensasi->getKodeStore($biodataid);
		$this->data['golabsen'] 	= $this->Model_cuti_dispensasi->getGolAbsen($biodataid);

		$data_status = $this->Model_cuti_dispensasi->getStatusCuti();
		$sm= $biodata['status_menikah']; //$biodata['status_menikah']
		$gender= $biodata['gender'];
		// die(json_encode($sm));

		$list_status_absensi_id = array(""=>"");
		foreach ($data_status as $key => $value) {
			// if($value['kode_status_absensi'] = 'CDB' || $value['kode_status_absensi'] = 'CDA'){
			// 	$nilai= $value['ket_status_absensi'] ;
			// } else {
				$nilai=substr($value['ket_status_absensi'],5);
			// }
			if($gender=='WANITA' && $sm=='MENIKAH' ){
				if( $nilai!=='ISTRI LAHIRAN' && $nilai!==$sm && $nilai!=='DISPENSASI' && $nilai!=='ISTRI KEGUGURAN') {
					$list_status_absensi_id[$value['kode_status_absensi']]= $nilai;
				}
			}else if($gender=='PRIA' && $sm=='MENIKAH' ){
				if( $nilai!=='MELAHIRKAN' && $nilai!==$sm && $nilai!=='DISPENSASI' && $nilai!=='KEGUGURAN') {
					$list_status_absensi_id[$value['kode_status_absensi']]= $nilai;
				}
			}else if($gender=='PRIA' && $sm=='DUDA' || $gender=='WANITA' && $sm=='JANDA' ){
				if( $nilai!==$sm && $nilai!=='DISPENSASI') {
					$list_status_absensi_id[$value['kode_status_absensi']]= $nilai;
				}
			}else{
				if($nilai!=='DISPENSASI' && $nilai!=='SUNATAN' && $nilai!=='BAPTISAN' && $nilai!=='ISTRI LAHIRAN' && $nilai!=='MELAHIRKAN' && $nilai!=='KEGUGURAN' && $nilai!=='ISTRI KEGUGURAN') {
					$list_status_absensi_id[$value['kode_status_absensi']]= $nilai;
				}
			}
		}
		$this->data['status_absensi_id'] = [
			'name'   	=> 'status_absensi_id',
			'id'   		=> 'status_absensi_id',
			'class'  	=> 'form-control select2-single',
			'required'	=> 'required',
			'style'		=> 'width:100%;'
		];
		$this->data['status_absensi_id_option'] = $list_status_absensi_id;
		// die(json_encode($this->data['normatifs']));
		// SELECT  id FROM hrd_all.mst_biodata
		// 	WHERE nip ='".$nip."'
	}

	public function sub_cuti()
	{
		$id 	= $this->input->post('id',TRUE);
        $data 	= $this->Model_cuti_dispensasi->get_sub_cuti($id)->result();
        echo json_encode($data);
	}

	public function index()
	{
		$this->form();
		$this->render_template('cuti_dispensasi/index',$this->data);
	}


	function _notMatch($tgl_tdk_masuk){
		if($tgl_tdk_masuk != $this->input->post($tgl_tdk_masuk)){
			$this->form_validation->set_message('_notMatch','Tanggal Tidak Boleh Sama');
			return false;
		}
		return true;
	}

	public function create()
	{
		$this->form_validation->set_rules('jum_cuti' ,'Silahkan Pilih Jenis Cuti' , 'trim|required',$this->val_error);
		// $this->form_validation->set_rules('file_1', '', 'callback_file_check_1');
		// $this->form_validation->set_rules('tgl_tdk_masuk[]','Tanggal Cuti','is_unique|callback__notMatch[tgl_tdk_masuk]');
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
		if ($this->form_validation->run() == TRUE) {
			// tesx('test');
			$create_form = $this->Model_cuti_dispensasi->create();

			if($create_form) {
				$this->session->set_flashdata('success', 'Cuti Dispensasi"'.$create_form.'" Berhasil Disimpan');
				redirect('leaves/cuti_dispensasi/index/', 'refresh');
			}
			else {
				$this->session->set_flashdata('errors', 'Cuti Dispensasi"'.$create_form.'" Gagal Disimpan');
				redirect('cuti_dispensasi/create', 'refresh');
			}
		} else {

			$this->form();
			$this->data['js'] 		= 'create';
			$this->render_template('cuti_dispensasi/create', $this->data);
		}
	}

	/*
     * file value and type check during validation
     */
    public function file_check_1($str){
        $allowed_mime_type_arr = array('image/gif','image/jpeg','image/pjpeg','image/png','image/x-png');
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
		$nip 		= $this->session->userdata('nama_login');
		$biodata 	= $this->hrd->select('biodata_id')
					->get_where( 'hrd_all.mst_biodata',array('nip' => $nip))->row_array();
		// die(json_encode($biodata));
		$no = $biodata['biodata_id'];
		$data = $this->Model_cuti_dispensasi->getCutiData1($no, $search_no,$length,$start,$column,$order);
		$data_jum = $this->Model_cuti_dispensasi->getCutiData2($no,$search_no);
		$output=array();
		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		if($search_no !="" ){
			$data_jum = $this->Model_cuti_dispensasi->getCutiData2($no,$search_no);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){
			foreach ($data as $key => $value) {
					$buttons = '';
					$link_po = str_replace("/","_",$value['no_dok_cuti']);
					$buttons .= ' <a href="'.base_url('leaves/cuti_dispensasi/detail/'.$value['cuti_dispensasi_h_id']).'"
					class="btn btn-primary mb-1"><i class="simple-icon-note" title="Detail"></i> Detail</a>';

					if($value['posting']=='OPEN' && $value['is_posting']==0){
						$buttons .= ' <a href="'.base_url('leaves/batal/detail/'.$value['no_dok_cuti']).'"
						class="btn btn-danger mb-1"><i class="simple-icon-trash" title="Batal"></i> Batal</a>';
					}
					$output['data'][$key] = array(
						$value['no_dok_cuti'],
						$value['tgl_dok'],
						$value['keterangan'],
						$value['nama_pic'],
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
		$header_data = $this->Model_cuti_dispensasi->getHeaderDataBC($no_dok_h);
		$result['header'] = $header_data;
		$detail_item = $this->Model_cuti_dispensasi->getDetailData($header_data['cuti_dispensasi_h_id']);

		foreach($detail_item as $k => $v) {
			$result['detail_item'][] = $v;
		}
		$this->data['header_data'] = $result;

		$this->data['approval_data'] 	= $this->Model_cuti_dispensasi->getDataPosting($header_data['cuti_dispensasi_h_id']);
		$urutan_app	= $this->Model_cuti_dispensasi->urutanApp($header_data['biodata_id']);
		foreach($urutan_app as $k => $v) {
			$result_app['urutan_app'][] = $v;
		}
		$this->data['urutan_data'] 	= $this->Model_cuti_dispensasi->urutanApp($header_data['biodata_id']);
		$this->data['status_hrd'] = $this->Model_cuti_dispensasi->getApp3rd($header_data['cuti_dispensasi_h_id']);
		$this->render_template('cuti_dispensasi/detail',$this->data);
	}

	public function approval()
	{
		$this->form();
		$this->render_template('cuti_dispensasi/approval',$this->data);
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
		$data = $this->Model_cuti_dispensasi->getApprovalData1($nip, $search_no,$length,$start,$column,$order);
		$data_jum = $this->Model_cuti_dispensasi->getApprovalData2($nip,$search_no);
		$output=array();
		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		if($search_no !="" ){
			$data_jum = $this->Model_cuti_dispensasi->getApprovalData2($nip,$search_no);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){
			$no =0;
			foreach ($data as $key => $value) {
					$buttons = '';
					$buttons .= '<div class="mb-4">
								<a href="'.base_url('leaves/cuti_dispensasi/approval_detail/'.$value['cuti_dispensasi_h_id']).'"
								class="btn btn-success btn-xs mb-2"><i class="iconsminds-yes" title="Approve"></i> APP</a>
								';

					$buttons .= '<div class="mb-4">
					<a href="'.base_url('leaves/cuti_dispensasi/reject_detail/'.$value['cuti_dispensasi_h_id']).'"
					class="btn btn-danger btn-xs mb-2"><i class="iconsminds-yes" title="Reject"></i> REJ</a>
					';

					// $buttons .= '<a class="btn rounded btn-danger btn-xs mb-2" href="javascript:void(0)" title="Hapus"
					// onclick="delete_person('."'".$value['cuti_dispensasi_h_id']."'".')">
					// <i class="iconsminds-close" title="Tolak"></i> REJ</a>
					// </div>';

					$arr_result = array(
						$value['cuti_dispensasi_h_id'],
						$value['nip'],
						$value['pic'],
						$value['no_dok_cuti'],
						$value['tgl_dok_cuti'],
						$value['jenis_cuti'],
						$buttons
					);
					$array_secondary = array();
						$data_detail = $this->Model_cuti_dispensasi->getDetailData($value['cuti_dispensasi_h_id']);
						foreach ($data_detail as $key => $row2)
						{
							$arr_result2 = array(
								$row2['tgl_cuti'],
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

	public function fetchCutiDispensasi()
	{
		$output = array('data' => array());

		$draw		=	$_REQUEST['draw'];
		$length		=	$_REQUEST['length'];
		$start		=	$_REQUEST['start'];
		$column 	= 	$_REQUEST['order'][0]['column'];
		$order 		= 	$_REQUEST['order'][0]['dir'];
		$search_no  = 	$_REQUEST['columns'][0]['search']["value"];
		$search_nama  	= 	$_REQUEST['columns'][3]['search']["value"];
		$nip 			= 	$this->session->userdata('nama_login');

		$data = $this->Model_cuti_dispensasi->getCutiDispensasi($nip, $search_no, $search_nama,$length,$start,$column,$order);
		$data_jum = $this->Model_cuti_dispensasi->getCountCutiDispensasi($nip,$search_no,$search_nama);
		// die(json_encode($data_jum));

		$output=array();
		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		if($search_no !="" || $search_nama !=""){
			$data_jum = $this->Model_cuti_dispensasi->getCountCutiDispensasi($nip,$search_no,$search_nama);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){
			foreach ($data as $key => $value) {
				$output['data'][$key] = array(
					$value['no_dok_cuti'],
					$value['tgl_dok_cuti'],
					$value['nip'],
					$value['nama_lengkap'],
					$value['nama_dept'],
					$value['keterangan'],
					$value['tgl_app_1'],
					$value['posting'],
				);
			}
		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}

	public function approval_detail($no_dok_h)
	{
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
			$this->render_template('cuti_dispensasi/approval_detail',$this->data);
		}

	}

	public function reject_detail($no_dok_h)
	{
		$this->form_validation->set_rules('reject_komentar','Reject Cuti','required',
				array(	'required' 	=> 'Reject Komentar Tidak Boleh Kosong !!',
				));
		$pic_data = $this->Model_cuti_dispensasi->getHeaderData($no_dok_h);
		$biodata_rej = $pic_data['biodata_id'];
		$jml_reject = $this->Model_cuti->rejectData($biodata_rej);
		// die(json_encode($jml_reject['jml']));

		// if ($jml_reject['jml'] >= 3) {
		// 		$this->session->set_flashdata('error', 'Tidak Bisa Proses, "'.$pic_data['nama_lengkap'].'" Sudah Reject  3x !!');
		// 		redirect('approval_cuti_dispensasi', 'refresh');
		// } else {
			if ($this->form_validation->run() == TRUE) {

					$nip 		= $this->session->userdata('nama_login');
					$biodata 	= $this->hrd->select('biodata_id')
									->get_where('hrd_all.mst_biodata',array('nip' => $nip))
									->row_array();
					$pic = $biodata['biodata_id'];
					$ket = $this->input->post('reject_komentar');

					$create_form = $this->Model_cuti->rejectApp($no_dok_h,$pic,$nip,$ket);

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
				$this->render_template('cuti_dispensasi/reject_detail',$this->data);
			}
		// }
	}

	public function verifikasi_detail($no_dok_h)
	{
		// tesx($no_dok_h);
		$this->form_validation->set_rules('no_doc' ,'No Dokumen' , 'trim|required',$this->val_error);
		// $this->form_validation->set_rules('alasan_reject' ,'Keterangan' , 'trim|required',$this->val_error);
		if ($this->form_validation->run() == TRUE) {
			if (empty($this->input->post('alasan_reject'))) {
				$create_form = $this->Model_cuti_dispensasi->VerifikasiAction();
			} else {
				$create_form = $this->Model_cuti_dispensasi->VerifikasiReject();
			}

			if($create_form) {
				$this->session->set_flashdata('success', 'Verifikasi "'.$create_form.'" Berhasil Disimpan');
				redirect('verifikasi_ijin', 'refresh');
			}
			else {
				$this->session->set_flashdata('errors', 'Error occurred!!');
				redirect('verifikasi_ijin', 'refresh');
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

			$header_data 				= $this->Model_cuti_dispensasi->getHeaderDataBC($no_dok_h);
			$result['header'] = $header_data;
			$detail_item = $this->Model_cuti_dispensasi->getDetailData($header_data['cuti_dispensasi_h_id']);

			foreach($detail_item as $k => $v) {
				$result['detail_item'][] = $v;
			}

			$this->data['header_data'] = $result;
			$this->render_template('cuti_dispensasi/verifikasi_detail',$this->data);
		}

	}


	public function reject_verifikasi($no_dok_h)
	{
		$this->form_validation->set_rules('reject_komentar','Reject Cuti','required',
				array(	'required' 	=> 'Reject Komentar Tidak Boleh Kosong !!',
				));
		$pic_data = $this->Model_cuti_dispensasi->getHeaderData($no_dok_h);
		$biodata_rej = $pic_data['biodata_id'];
		$jml_reject = $this->Model_cuti->rejectData($biodata_rej);
		// die(json_encode($jml_reject['jml']));

		// if ($jml_reject['jml'] >= 3) {
		// 		$this->session->set_flashdata('error', 'Tidak Bisa Proses, "'.$pic_data['nama_lengkap'].'" Sudah Reject  3x !!');
		// 		redirect('approval_cuti_dispensasi', 'refresh');
		// } else {
			if ($this->form_validation->run() == TRUE) {

					$nip 		= $this->session->userdata('nama_login');
					$biodata 	= $this->hrd->select('biodata_id')
									->get_where('hrd_all.mst_biodata',array('nip' => $nip))
									->row_array();
					$pic = $biodata['biodata_id'];
					$ket = $this->input->post('reject_komentar');

					$create_form = $this->Model_cuti->rejectApp($no_dok_h,$pic,$nip,$ket);

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

				$header_data 				= $this->Model_cuti_dispensasi->getHeaderDataBC($no_dok_h);
				$result['header'] = $header_data;
				$detail_item = $this->Model_cuti_dispensasi->getDetailData($header_data['cuti_dispensasi_h_id']);
				// die(json_encode($header_data));
				foreach($detail_item as $k => $v) {
					$result['detail_item'][] = $v;
				}

				$this->data['header_data'] = $result;
				$this->render_template('cuti_dispensasi/reject_verifikasi',$this->data);
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
		$data = $this->Model_cuti_dispensasi->rejectApp($id,$pic,$nip,$ket);

		$this->session->set_flashdata('success', 'Dokumen Berhasil Proses');
		echo json_encode($data);
		redirect(''. $_SERVER['HTTP_REFERER']);
	}

	public function hari_libur()
	{

		// die(json_encode($data));
		$parent   = array();
		$data = $this->Model_cuti_dispensasi->getHariLibur();
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

	public function reupload_image(){
		$config['upload_path'] = FCPATH. 'upload/ijin/'; //path folder
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
		$config['max_size']      = 1524;
		$config['encrypt_name'] = TRUE; //Enkripsi nama yang terupload
		$this->upload->initialize($config);

		$tdk_masuk_h_id = $this->input->post('id_doc');
		$no_doc = $this->input->post('no_docs');

		// tesx($tdk_masuk_h_id,$no_doc);

		$list = array('1','2','3');
		$file = array('no_dok' => $no_doc);
		foreach($list as $key => $val){

			if(!empty($_FILES['lampiran'.$val]['name'])){

				if($this->upload->do_upload('lampiran'.$val)){
					$query = $this->hrd->get_where('hrd_all.trn_dokumen_ijin', array('no_dok' => $no_doc));
					$row = $query->row_array();
					$foto = $row['file_'.$val];

					if(!empty($foto)){
						$path = FCPATH. 'upload/ijin/';
						unlink($path . $foto);
					}

					$gbr = $this->upload->data();
					//Compress Image
					$config['image_library']='gd2';
					$config['source_image']= FCPATH. 'upload/ijin/'.$gbr['file_name'];
					$config['create_thumb']= FALSE;
					$config['maintain_ratio']= TRUE;

					if($_FILES['lampiran'.$val]['size'] <= '1565000'){
						$config['quality']	= '95%';
						$config['width']	= 800;
						$config['height']	= 650;
					} else if($_FILES['lampiran'.$val]['size'] > '1565000'){
						$this->session->set_flashdata('errors', ' Lampiran '.$val.' Max File Size 1Mb !!');
						redirect('leaves/cuti_dispensasi/detail/'.$tdk_masuk_h_id , 'refresh');
					}else {
						$config['quality']	= '100%';
						$config['width']	= '100%';
						$config['height']	= '100%';
					}

					$config['new_image']=  FCPATH. 'upload/ijin/'.$gbr['file_name'];
					$file['file_'.$val] = $gbr['file_name'];
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();
					$this->image_lib->clear();


				}

			} else {
				$this->session->set_flashdata('error', 'Lampiran '.$val.' Image Kosong');
				redirect('leaves/cuti_dispensasi/detail/'.$tdk_masuk_h_id , 'refresh');
			}
		}

		$this->hrd->set($file);
		$this->hrd->where('no_dok', $no_doc);
		$this->hrd->update('hrd_all.trn_dokumen_ijin');

		// tesx($file);

		$this->session->set_flashdata('success', 'Berhasil Re-upload');
		redirect('leaves/cuti_dispensasi/detail/'.$tdk_masuk_h_id , 'refresh');


	}
}

