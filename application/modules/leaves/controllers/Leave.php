<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Leave extends Admin_Controller  {
	private $hrd;
	public function __construct()
	{
		$this->data['modul'] = "Leave";
		parent::__construct();
		$this->not_logged_in();
		$this->data['page_title'] = 'Leaves';
		$this->load->model('model_leave');
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
		$data_status = $this->model_leave->getStatusCuti();
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
		$docCode	='HRC';
		$date		= date('ym');
		$dates		= date('Y-m-d');
		$nip 		= $this->session->userdata('nama_login');
		$biodata 	= $this->hrd->select('biodata_id')
					->get_where('hrd_all.mst_biodata',array('nip' => $nip))->row_array();
		$biodataid= $biodata['biodata_id'];
		$this->data['biodataid']	= $biodata['biodata_id'];
		$this->data['no_doc'] 		= $this->model_leave->getDataNoDoc($docCode,$date);
		$this->data['biodata'] 		= $this->model_leave->getDataUser();
		$this->data['normatifs'] 	= $this->model_leave->getDataNormatif($biodataid);
		$this->data['bonus'] 		= $this->model_leave->getDataBonus($biodataid,$dates);
		$this->data['tambahan'] 	= $this->model_leave->getDataTambahan($biodataid,$dates);
		$this->data['kodestore'] 	= $this->model_leave->getKodeStore($biodataid);
		$this->data['golabsen'] 	= $this->model_leave->getGolAbsen($biodataid);
		// die(json_encode($this->data['tambahan']));
		// SELECT  id FROM hrd_all.mst_biodata
		// 	WHERE nip ='".$nip."'
	}

	public function index()
	{
		$this->form();
		$this->render_template('index',$this->data);
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
		$this->form_validation->set_rules('potong_cuti_dari' ,'Sumber Potong Cuti' , 'trim|required',$this->val_error);
		// $this->form_validation->set_rules('tgl_tdk_masuk[]','Tanggal Cuti','required');
		// $this->form_validation->set_rules('tgl_tdk_masuk[]','Tanggal Cuti','is_unique|callback__notMatch[tgl_tdk_masuk]');
		if ($this->form_validation->run() == TRUE) {

			$create_form = $this->model_leave->create();

			if($create_form) {
				$this->session->set_flashdata('success', 'Cuti "'.$create_form.'" Berhasil Disimpan');
				redirect('leaves/leave/index/', 'refresh');
			}
			else {
				$this->session->set_flashdata('errors', 'Error occurred!!');
				redirect('leaves/leave/create', 'refresh');
			}
		} else {

			$this->form();
			$this->data['js'] 		= 'create';
			$this->render_template('create', $this->data);
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

		// $this->hrd->where('biodata_id','60fbb75e1071');
		// $total=$this->hrd->count_all_results('hrd_all.trn_tdk_masuk_h');
		// die(json_encode($total));

		//$output['data']=array();
		$nip 		= $this->session->userdata('nama_login');
		$biodata 	= $this->hrd->select('biodata_id')
					->get_where( 'hrd_all.mst_biodata',array('nip' => $nip))->row_array();
		// die(json_encode($biodata));
		$no = $biodata['biodata_id'];
		$data = $this->model_leave->getCutiData1($no, $search_no,$length,$start,$column,$order);
		$data_jum = $this->model_leave->getCutiData2($no,$search_no);
		$output=array();
		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		if($search_no !="" ){
			$data_jum = $this->model_leave->getCutiData2($no,$search_no);
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
					$buttons .= ' <a href="'.base_url('leaves/leave/detail/'.$value['tdk_masuk_h_id']).'" 
					class="btn btn-primary mb-1"><i class="simple-icon-note" title="Detail"></i> Detail</a>';
					if($value['is_posting']=='0'){$posting='Belum';}else{$posting='Sudah';}
					$output['data'][$key] = array(
						$value['no_dok_tdk_masuk'],
						$value['tgl_dok'],
						$value['keterangan'],
						$value['potong_cuti_dari'],
						$value['status'],
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
		$header_data = $this->model_leave->getHeaderData($no_dok_h);
		$result['header'] = $header_data;
		$detail_item = $this->model_leave->getDetailData($header_data['tdk_masuk_h_id']);

		foreach($detail_item as $k => $v) {
			$result['detail_item'][] = $v;
		}
		$this->data['header_data'] = $result;
		$this->render_template('detail',$this->data);
	}


	public function approval()
	{
		$this->form();
		$this->render_template('approval',$this->data);
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
		$data = $this->model_leave->getApprovalData1($no, $search_no,$length,$start,$column,$order);
		$data_jum = $this->model_leave->getApprovalData2($no,$search_no);
		$output=array();
		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		if($search_no !="" ){
			$data_jum = $this->model_leave->getApprovalData2($no,$search_no);
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
								<a href="'.base_url('leaves/leave/approval_detail/'.$value['tdk_masuk_h_id']).'"
								class="btn btn-success btn-xs mb-2"><i class="iconsminds-yes" title="Approve"></i> APP</a>
								';

					$buttons .= '<a href="'.base_url('leaves/leave/tolak_action/'.$value['tdk_masuk_h_id']).'"
					class="btn rounded btn-danger btn-xs mb-2"><i class="iconsminds-close" title="Tolak"></i> REJ</a>
					</div>';
					if($value['is_posting']=='0'){$posting='Belum';}else{$posting='Sudah';}

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
						$value['tgl_dok'],
						$value['keterangan'],
						$value['potong_cuti_dari'],
						$value['status'],
						$value['nama_pic'],
						$buttons
					);
					$array_secondary = array();
						$data_detail = $this->model_leave->getDetailData($value['tdk_masuk_h_id']);
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
		$this->form_validation->set_rules('potong_cuti_dari' ,'Sumber Potong Cuti' , 'trim|required',$this->val_error);

		if ($this->form_validation->run() == TRUE) {
			$create_form = $this->model_leave->ApproveAction();

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
			$header_data = $this->model_leave->getHeaderData($no_dok_h);
			$result['header'] = $header_data;
			$detail_item = $this->model_leave->getDetailData($header_data['tdk_masuk_h_id']);

			foreach($detail_item as $k => $v) {
				$result['detail_item'][] = $v;
			}
			$this->data['header_data'] = $result;
			$this->render_template('approval_detail',$this->data);
		}

	}

	public function approve_action()
	{
		$this->form_validation->set_rules('potong_cuti_dari' ,'Sumber Potong Cuti' , 'trim|required',$this->val_error);

		if ($this->form_validation->run() == TRUE) {
			$create_form = $this->model_leave->ApproveAction();

			if($create_form) {
				$this->session->set_flashdata('success', 'Approve "'.$create_form.'" Berhasil Disimpan');
				redirect('approval_cuti', 'refresh');
			}
			else {
				$this->session->set_flashdata('errors', 'Error occurred!!');
				redirect('approval_cuti', 'refresh');
			}
		} else {

			$this->form();
			$this->data['js'] 		= 'create';
			$this->render_template('create', $this->data);
		}
	}

	public function tolak_action($id)
	{
		$no_dok = 1;
		$nip 		= $this->session->userdata('nama_login');
		$biodata 	= $this->hrd->select('biodata_id')
						->get_where('hrd_all.mst_biodata',array('nip' => $nip))
						->row_array();
		$pic = $biodata['biodata_id'];
		$ket = 'BATAL DITOLAK';
		// Model Update
		$this->model_leave->tolakHeader($id,$pic,$ket);
		$this->model_leave->tolakDetail($id,$pic,$ket);

		// Notif
		$this->session->set_flashdata('success', 'NO.DOK "'.$id.'" Berhasil Proses');
		redirect(''. $_SERVER['HTTP_REFERER']);
	}

	public function hari_libur()
	{

		// die(json_encode($data));
		$parent   = array();
		$data = $this->model_leave->getHariLibur();
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

	public function mail_tampil()
	{
		$this->form();
		$this->data['judul'] 				= 'CUTI';
		$this->template_email('email/billing', $this->data);
	}

	public function send_mail() {
        $this->load->config('email');
        $this->load->library('email');

        $from = $this->config->item('smtp_user');
        $to = 'rizky.it@optiktunggal.com';
        $cc = array(
            // 'handri.it@optiktunggal.com',
            'rizky.it@optiktunggal.com'
        );
        $subject = $this->input->post('subject');
        $message = $this->input->post('header_body');
        $message .= '<br>'.$this->input->post('body');
        $message .='<br><br>Email ini dibuat otomatis oleh system';
        $this->email->set_newline("\r\n");
        $this->email->from($from);
        $this->email->to($to);
        foreach ($cc as  $value) {
            $this->email->cc($value);
        }
        //CC Ke PIC INPUT
        // $email_pic = $this->model_email->get_email_pic();
        // if ($email_pic) {
        //     $this->email->cc($email_pic);
        // }
        $this->email->subject($subject);
        $this->email->message($message);

        if ($this->email->send()) {
            $response = array(
                'success' => true,
                'messages' => 'Email Berhasil Di kirim',
            );
        } else {
            $response = array(
                'success' => false,
                'messages' => 'Email Gagal Di kirim',
            );
        }
        echo json_encode($response);
    }
}

