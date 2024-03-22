<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cuti_tambahan extends Admin_Controller  {
	private $hrd;
	public function __construct()
	{
		$this->data['modul'] = "Leave";
		parent::__construct();
		$this->not_logged_in();
		$this->data['page_title'] = 'Leaves';
		$this->load->model('Model_cuti_tambahan');
		$this->load->model('Model_cuti_dispensasi');
		$this->load->model('Model_ijin');
		$this->load->model('Model_leave');
		$this->hrd = $this->load->database('hrd',TRUE);
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
			// if($value['ket_status_absensi'] == 'CUTI 1/2 HARI'){
			// 	$list_status_absensi_id[$value['ket_status_absensi']]= $value['ket_status_absensi'];
			// } else {
			// 	$list_status_absensi_id[$value['status_absensi_id']]= $value['ket_status_absensi'];
			// }
		}
		$this->data['status_absensi_id'] = [
			'name'   	=> 'status_absensi_id',
			'id'   		=> 'status_absensi_id',
			'class'  	=> 'form-control select2-single',
			'required'	=> 'required',
			'style'		=> 'width:100%;'
		];
		$this->data['status_absensi_id_option'] = $list_status_absensi_id;
		$docCode	='HRCT';
		$date		= date('ym');
		$dates		= date('Y-m-d');
		$nip 		= $this->session->userdata('nama_login');
		$biodata 	= $this->hrd->select('biodata_id')
					->get_where('hrd_all.mst_biodata',array('nip' => $nip))->row_array();
		$biodataid= $biodata['biodata_id'];
		$this->data['biodataid']	= $biodata['biodata_id'];
		$this->data['no_docs'] 		= $this->Model_cuti_tambahan->getNoDocs($docCode,$date);

		$this->data['biodata'] 		= $this->Model_ijin->getDataUser();
		$this->data['normatifs'] 	= $this->Model_ijin->getDataNormatif($biodataid);
		$this->data['bonus'] 		= $this->Model_ijin->getDataBonus($biodataid,$dates);
		$this->data['tambahan'] 	= $this->Model_ijin->getDataTambahan($biodataid,$dates);
		$this->data['kodestore'] 	= $this->Model_ijin->getKodeStore($biodataid);
		$this->data['golabsen'] 	= $this->Model_ijin->getGolAbsen($biodataid);

	}

	public function index()
	{
		$this->form();
		// print_r($this->data);die;
		$this->render_template('cuti_tambahan/index',$this->data);
	}


	function check_tgl($tgl_awal) {
        if($this->input->post('nip'))
            $nip = $this->input->post('nip');
        else
            $nip = '';
        $result = $this->Model_cuti_tambahan->check_unique_tgl($nip, $tgl_awal);
        if($result == 0 || $result == null)
            $response = true;
        else {
            $this->form_validation->set_message('check_tgl', 'Tanggal pengajuan sudah ada !!');
            $response = false;
        }
        return $response;
    }

	public function create()
	{

		$tgl_awal = $this->input->post('tgl_awal');

		$this->form_validation->set_rules('no_doc' ,'NOMOR DOKUMEN' , 'trim|required',$this->val_error);
		$this->form_validation->set_rules('tgl_doc','TANGGAL DOKUMEN','required',$this->val_error);
		$this->form_validation->set_rules('nip','NIP','trim|required',$this->val_error);
		$this->form_validation->set_rules('tgl_awal','TANGGAL AWAL','required|callback_check_tgl',$this->val_error);
		$this->form_validation->set_rules('jml_hari','JUMLAH HARI','required',$this->val_error);
		$this->form_validation->set_rules('keterangan','KETERANGAN','trim|required',$this->val_error);

		$nip 		= $this->session->userdata('nama_login');
		$biodata 	= $this->hrd->select('biodata_id,nama_lengkap')
					->get_where('hrd_all.mst_biodata',array('nip' => $nip))->row_array();
		// $biodataid= $biodata['biodata_id'];
		$this->data['biodataid']= $biodata['biodata_id'];
		// $this->data['biodata'] 	= $biodata['biodata_id'];//$this->Model_cuti_tambahan->getDataUser();
		// $biodata_id 			= $this->hrd->select('biodata_id')
		// 						  ->get_where('hrd_all.mst_biodata',array('nip' => $nip))->row_array();



		if ($this->form_validation->run() == TRUE) {

			// tesx('keproses');

			$create_form = $this->Model_cuti_tambahan->create();
			if($create_form) {
				$this->session->set_flashdata('success', 'Cuti "'.$create_form.'" Berhasil Disimpan');
				redirect('cuti_pengganti', 'refresh');
			}
			else {
				$this->session->set_flashdata('errors', 'Error occurred!!');
				redirect('leaves/cuti_tambahan/create', 'refresh');
			}
		} else {
			$this->form();
			$this->data['js'] = 'create';
			$this->render_template('leaves/cuti_tambahan/create', $this->data);
		}

	}

	public function getPengajuanCutiTambahanAll()
	{
		$output = array('data' => array());

		$draw	= $_REQUEST['draw'];
		$length	= $_REQUEST['length'];
		$start	= $_REQUEST['start'];
		$column = $_REQUEST['order'][0]['column'];
		$order 	= $_REQUEST['order'][0]['dir'];
		$search_no = $_REQUEST['columns'][0]['search']["value"];

		$nip 		= $this->session->userdata('nama_login');
		$data 		= $this->Model_cuti_tambahan->getPengajuanCutiTambahanAll1($nip, $search_no,$length,$start,$column,$order);
		$data_jum 	= $this->Model_cuti_tambahan->getPengajuanCutiTambahanAll2($nip,$search_no);
		$output		= array();
		$output['draw']	= $draw;
		$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		if($search_no !="" ){
			$data_jum = $this->Model_cuti_tambahan->getPengajuanCutiTambahanAll2($nip,$search_no);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}


		if($data){
			foreach ($data as $key => $value) {

					$buttons = '';
					if($value['st']=='OPEN'){
						$buttons .= ' <a href="'.base_url('leaves/batal/detail/'.$value['no_doc']).'"
						class="btn btn-danger mb-1"><i class="simple-icon-trash" title="Batal"></i> Batal </a>';
					}

					$arr_result = array(
						'',
						$value['no_doc'],
						$value['tgl_doc'],
						$value['nip'],
						$value['nama_lengkap'],
						$value['tgl_awal'],
						$value['tgl_akhir'],
						$value['jml_hari'],
						$value['keterangan'],
						$value['st'],
						$buttons
					);

					$data_detail = $this->Model_cuti_tambahan->getDetailPosting($value['no_doc']);

					$array_secondary = array(
						($data_detail['app_1'])?$data_detail['app_1']:' Kosong ',
						($data_detail['app_2'])?$data_detail['app_2']:' Kosong ',
						($data_detail['app_3'])?$data_detail['app_3']:' Kosong ',
						($data_detail['rej_komentar_1'])?$data_detail['rej_komentar_1']:' Kosong ',
						($data_detail['rej_komentar_2'])?$data_detail['rej_komentar_2']:' Kosong ',
						($data_detail['rej_komentar_3'])?$data_detail['rej_komentar_3']:' Kosong ',
					);

					$arr_result['secondary'] =  $array_secondary;

					// tesx($data_detail, $array_secondary);

					$output['data'][] = $arr_result;

			}
		}else{
			$output['data'] = [];
		}
		echo json_encode($output);

	}


	public function detail($no_doc)
	{
		$this->form();
		$this->data['js'] = 'create';
		$data = $this->Model_cuti_tambahan->getDataByNoDoc($no_doc);
		$result['data'] = $data;

		// foreach($data as $k => $v) {
		// 	$result['detail'][] = $v;
		// }
		// $this->data['data'] = $result;
		$this->render_template('detail',$this->data);
	}

	public function approval()
	{
		$this->form();

		$this->render_template('cuti_tambahan/approval',$this->data);
	}


	public function approval_detail($no_dok_h)
	{
		$this->form_validation->set_rules('no_doc' ,'NO. Dokumen' , 'trim|required',$this->val_error);

		if ($this->form_validation->run() == TRUE) {
			$create_form = $this->Model_cuti_tambahan->ApproveAction();

			if($create_form) {
				$this->session->set_flashdata('success', 'Approve "'.$create_form.'" Berhasil Disimpan');
				redirect('approval_cuti_pengganti', 'refresh');
			}
			else {
				$this->session->set_flashdata('errors', 'Error occurred!!');
				redirect('approval_cuti_pengganti', 'refresh');
			}
		} else {
			$this->form();
			$date		= date('ym');
			$dates		= date('Y-m-d');
			#--Biodata
				$biodatas 	= $this->hrd->select('nip')
							->get_where('hrd_all.trn_pengajuan_cuti_tambahan',array('no_doc' => $no_dok_h))->row_array();
				$biodataids = $biodatas['nip'];

				$biodata 	= $this->hrd->select('biodata_id,status_menikah,gender')
						->get_where('hrd_all.mst_biodata',array('nip' => $biodataids))->row_array();
				$biodataid= $biodata['biodata_id'];
			#--Biodata

			$this->data['kodestore'] 	= $this->Model_cuti_dispensasi->getKodeStore($biodataid);
			$this->data['golabsen'] 	= $this->Model_cuti_dispensasi->getGolAbsen($biodataid);

			$header_data 		= $this->Model_cuti_tambahan->getHeaderData($no_dok_h);
			$header_tgl 		= $this->Model_cuti_tambahan->getHeaderData($no_dok_h);

			// tesx($header_data);

			$result['header'] 			= $header_data;
			$this->data['header_data'] 	= $result;

			$tgl_masuk 		= $header_tgl['tgl_awal'];
			$tgl_keluar 	= $header_tgl['tgl_awal'];
			$tgl_lintas 	= $header_tgl['tgl_lintas'];

			$jam_masuk = $this->Model_cuti_tambahan->getTglJamMasuk($biodatas['nip'], $tgl_masuk);
			if(!!empty($jam_masuk == NULL || $jam_masuk == "")){
				$this->data['tgl_masuk'] = $header_tgl['tgl_awal'];
				$this->data['jam_masuk'] = $header_tgl['jam_masuk'];
			} else {
				$this->data['tgl_masuk'] = $jam_masuk['tgl_masuk'];
				$this->data['jam_masuk'] = $jam_masuk['jam_masuk'];
			}

			$cek_lintas		= $this->Model_cuti_tambahan->getTglJamLintas($biodataids, $tgl_lintas);

			// tesx($jam_masuk, $this->data['jam_masuk'], $header_tgl['jam_masuk'], $jam_masuk['jam_masuk'] );
			if($cek_lintas !== Null){
				// $this->data['tgl_jam_keluar'] = $cek_lintas;

				$this->data['tgl_keluar'] =  $cek_lintas['tgl_keluar'];
				$this->data['jam_keluar'] =  $cek_lintas['jam_keluar'];
			}else{
				$jam_keluar = $this->Model_cuti_tambahan->getTglJamkeluar($biodataids, $tgl_keluar);

				if(!!empty($jam_keluar == NULL || $jam_keluar == "")){
					// $this->data['tgl_jam_keluar'] = $header_tgl;

					$this->data['tgl_keluar'] =  $header_tgl['tgl_awal'];
					$this->data['jam_keluar'] =  $header_tgl['jam_keluar'];
				}else{
					$this->data['tgl_keluar'] =  $jam_keluar['tgl_keluar'];
					$this->data['jam_keluar'] =  $jam_keluar['jam_keluar'];
				}

			}

			// tesx($this->data['jam_masuk'], $this->data['tgl_masuk'], $this->data['tgl_keluar'], $this->data['jam_keluar']);

			#-- Cek Dok Overtime
				$get_overtime 	= $this->Model_cuti_tambahan->getCekOvertime($biodataid, $tgl_masuk);
				if (!!empty($get_overtime)){
					$dok_overtime = "Tidak Ada Dokumen Overtime";
				}else{
					$dok_overtime = $get_overtime['no_dokumen'];
				}
				$this->data['dok_overtime']		= $dok_overtime;
			#-- Cek Dok Overtime

			// tesx($this->data['header_data']);

			$this->render_template('cuti_tambahan/approval_detail',$this->data);
		}

	}

	public function reject_detail($no_dok_h)
	{
		$this->form_validation->set_rules('reject_komentar','Reject Cuti','required',
				array(	'required' 	=> 'Reject Komentar Cuti Tidak Boleh Kosong !!',
		));
		$pic_data = $this->Model_cuti_tambahan->getHeaderData($no_dok_h);
		$biodata_rej = $pic_data['biodata_id'];
		$jml_reject = $this->Model_cuti_tambahan->rejectData($biodata_rej);

		#-- For Reject > 3x
			// if ($jml_reject['jml'] > 3) {
			// 		$this->session->set_flashdata('error', 'Tidak Bisa Proses, "'.$pic_data['nama_lengkap'].'" Sudah Reject  3x !!');
			// 		redirect('approval_cuti_pengganti', 'refresh');
			// } else {
			// }
		#-- For Reject > 3x

		if ($this->form_validation->run() == TRUE) {

				$nip 		= $this->session->userdata('nama_login');
				$biodata 	= $this->hrd->select('biodata_id')
								->get_where('hrd_all.mst_biodata',array('nip' => $nip))
								->row_array();
				$pic 		= $biodata['biodata_id'];
				$ket 		= $this->input->post('reject_komentar');

				$create_form = $this->Model_cuti_tambahan->rejectApp($no_dok_h,$pic,$nip,$ket);

				if($create_form) {
					$this->session->set_flashdata('success', 'Approve "'.$create_form.'" Berhasil Disimpan');
					redirect('approval_cuti_pengganti', 'refresh');
				}
				else {
					$this->session->set_flashdata('errors', 'Error occurred!!');
					redirect('approval_cuti_pengganti', 'refresh');
				}

		} else {
			$this->form();
			$date		= date('ym');
			$dates		= date('Y-m-d');
			#--Biodata
				$biodatas 	= $this->hrd->select('nip')
							->get_where('hrd_all.trn_pengajuan_cuti_tambahan',array('no_doc' => $no_dok_h))->row_array();
				$biodataids = $biodatas['nip'];

				$biodata 	= $this->hrd->select('biodata_id,status_menikah,gender')
						->get_where('hrd_all.mst_biodata',array('nip' => $biodataids))->row_array();
				$biodataid= $biodata['biodata_id'];
			#--Biodata

			#--Jam Absensi
				$this->data['kodestore'] 	= $this->Model_cuti_dispensasi->getKodeStore($biodataid);
				$this->data['golabsen'] 	= $this->Model_cuti_dispensasi->getGolAbsen($biodataid);

				$header_data 		= $this->Model_cuti_tambahan->getHeaderData($no_dok_h);
				$header_tgl 		= $this->Model_cuti_tambahan->getHeaderData($no_dok_h);

				$result['header'] 			= $header_data;
				$this->data['header_data'] 	= $result;

				$tgl_masuk 		= $header_tgl['tgl_awal'];
				$tgl_keluar 	= $header_tgl['tgl_awal'];
				$tgl_lintas 	= $header_tgl['tgl_lintas'];

				$cek_lintas		= $this->Model_cuti_tambahan->getTglJamLintas($biodataids, $tgl_lintas);

				$jam_masuk = $this->Model_cuti_tambahan->getTglJamMasuk($biodatas['nip'], $tgl_masuk);

				if(!!empty($jam_masuk == NULL || $jam_masuk == "")){
					$this->data['tgl_jam_masuk'] = $header_tgl;
				} else {
					$this->data['tgl_jam_masuk'] = $jam_masuk;
				}

				if($cek_lintas !== Null){
					$this->data['tgl_jam_keluar'] = $this->Model_cuti_tambahan->getTglJamLintas($biodataids, $tgl_lintas);
				}else{
					$jam_keluar = $this->Model_cuti_tambahan->getTglJamkeluar($biodataids, $tgl_keluar);

					if(!!empty($jam_keluar == NULL || $jam_keluar == "")){
						$this->data['tgl_jam_keluar'] = $header_tgl;
					}else{
						$this->data['tgl_jam_keluar'] = $jam_keluar;
					}
				}
			#--Jam Absensi

			#-- Cek Dok Overtime
				$get_overtime 	= $this->Model_cuti_tambahan->getCekOvertime($biodataid, $tgl_masuk);
				if (!!empty($get_overtime)){
					$dok_overtime = "Tidak Ada Dokumen Overtime";
				}else{
					$dok_overtime = $get_overtime['no_dokumen'];
				}
				$this->data['dok_overtime']		= $dok_overtime;
			#-- Cek Dok Overtime
			$this->render_template('cuti_tambahan/reject_detail',$this->data);
		}

	}


	public function getAbsenMasuk()
	{
		$tgl 	= $this->input->post('tgl',TRUE);
		// die(json_encode($tgl));
		$nip=$this->session->userdata('nama_login');
		$biodata 	= $this->hrd->select('biodata_id,status_menikah,gender')
					->get_where('hrd_all.mst_biodata',array('nip' => $nip))->row_array();
		$biodataid= $biodata['biodata_id'];

        $datas 	= $this->Model_cuti_tambahan->getAbsenMasuk($tgl,$biodataid,$nip)->row_array();
		if ($datas == null){
			$data = array( 'jm' => 'Tidak_ada_data_absen');
		}else{
			$data 	= $this->Model_cuti_tambahan->getAbsenMasuk($tgl,$biodataid,$nip)->row_array();
		}

        echo json_encode($data);
	}

	public function getAbsenKeluar()
	{
		$tgl 	= $this->input->post('tgl',TRUE);
		// die(json_encode($tgl));
		$nip=$this->session->userdata('nama_login');
		$biodata 	= $this->hrd->select('biodata_id,status_menikah,gender')
					->get_where('hrd_all.mst_biodata',array('nip' => $nip))->row_array();
		$biodataid= $biodata['biodata_id'];

        $datas 	= $this->Model_cuti_tambahan->getAbsenKeluar($tgl,$biodataid,$nip)->row_array();
		if ($datas == null){
			$data = array( 'jk' => 'Tidak_ada_data_absen');
		}else{
			$data 	= $this->Model_cuti_tambahan->getAbsenKeluar($tgl,$biodataid,$nip)->row_array();
		}
        echo json_encode($data);
	}

	public function getOvertime()
	{
		$tgl 		= $this->input->post('tgl',TRUE);
		$nip		= $this->session->userdata('nama_login');
		$biodata 	= $this->hrd->select('biodata_id')
						->get_where('hrd_all.mst_biodata',array('nip' => $nip))
						->row_array();
		$biodataid	= $biodata['biodata_id'];

        $datas 	= $this->Model_cuti_tambahan->getCekOvertime($biodataid, $tgl);
		if ($datas == null){
			$data = array( 'no_dokumen' => "Tidak_Ada_Dokumen_Overtime");
		}else{
			$data 	= $this->Model_cuti_tambahan->getCekOvertime($biodataid, $tgl);
		}
        echo json_encode($data);
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
		$data = $this->Model_cuti_tambahan->getApprovalData1($nip, $search_no,$length,$start,$column,$order);
		$data_jum = $this->Model_cuti_tambahan->getApprovalData2($nip,$search_no);
		$output=array();
		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		if($search_no !="" ){
			$data_jum = $this->Model_cuti_tambahan->getApprovalData2($nip,$search_no);
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
								<a href="'.base_url('leaves/cuti_tambahan/approval_detail/'.$value['no_doc']).'"
								class="btn btn-success btn-xs mb-2"><i class="iconsminds-yes" title="Approve"></i> APP</a>
								';
					$buttons .= '<div class="mb-4">
							<a href="'.base_url('leaves/cuti_tambahan/reject_detail/'.$value['no_doc']).'"
							class="btn btn-danger btn-xs mb-2"><i class="iconsminds-yes" title="Reject"></i> REJ</a>
							';


					// $output['data'][] = $arr_result;

					$output['data'][$key] = array(
						$value['no_doc'],
						$value['tgl_doc'],
						$value['nip'],
						$value['nama_lengkap'],
						// $value['st'],
						$buttons
					);

			}
		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}

	public function getHistoryCutiPengganti()
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
		$data = $this->Model_cuti_tambahan->getHistoryCutiPengganti($nip, $search_no, $search_nama,$length,$start,$column,$order);
		$data_jum = $this->Model_cuti_tambahan->getCountHistoryCutiPengganti($nip,$search_no, $search_nama);
		// tesx($data_jum);
		$output=array();
		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		if($search_no !="" || $search_nama !=""){
			$data_jum = $this->Model_cuti_tambahan->getCountHistoryCutiPengganti($nip,$search_no,$search_nama);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){
			foreach ($data as $key => $value) {

					$output['data'][$key] = array(
						$value['no_doc'],
						$value['tgl_doc'],
						$value['nip'],
						$value['nama_lengkap'],
						$value['jml_hari'],
						$value['keterangan'],
						$value['tgl_app_1'],
						$value['jam_masuk']!=""?$value['jam_masuk']:'Tidak ada absen',
						$value['jam_keluar']!=""?$value['jam_keluar']:'Tidak ada absen',
						$value['posting'],
					);
			}
		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
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
		$data = $this->Model_cuti_tambahan->rejectApp($id,$pic,$nip,$ket);
		// Notif
		// echo json_encode(array("status" => TRUE));

		$this->session->set_flashdata('success', 'Dokumen Berhasil Proses');
		echo json_encode($data);
		redirect(''. $_SERVER['HTTP_REFERER']);
	}
}

