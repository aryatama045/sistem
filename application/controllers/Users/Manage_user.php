<?php

class Manage_user extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Manage_user';
		$this->load->model('Model_auth');
		$this->load->model('Model_manage_user');


	}

	/*
	* It only redirects to the manage category page information into the frontend.
	*/
	public function form()
	{
		$nip 		= $this->session->userdata('nama_login');
		$biodata 	= $this->hrd->select('biodata_id')
					->get_where( 'hrd_all.mst_biodata',array('nip' => $nip))->row_array();
		$no = $biodata['biodata_id'];
			$this->data['approval']  	= $this->Model_leave->PicApproval();
			$this->data['verifikasi']  	= $this->Model_leave->PicVerifikasiHrd();
			$this->data['jum_cuti'] 	= $this->Model_cuti->getApprovalData2($nip);
			$this->data['jum_cuti_dispensasi'] 	= $this->Model_cuti_dispensasi->getApprovalData2($nip);
			$this->data['jum_cuti_pengganti'] 	= $this->Model_cuti_tambahan->getApprovalData2($nip);
			$this->data['jum_ijin'] 	= $this->Model_ijin->getApprovalData2($nip);
			$this->data['jum_terlambat'] 	= $this->Model_terlambat->getApprovalData2($nip);
			$this->data['jum_ver'] 		= $this->Model_ijin->getVerifikasi2($nip);
		$ni 		= $this->session->userdata('nama_login');
			$this->data['sum_cuti'] 			= $this->Model_cuti->getCutiData2($no);
			$this->data['sum_cuti_dispensasi'] 	= $this->Model_cuti_dispensasi->getCutiData2($no);
			$this->data['sum_cuti_pengganti'] 	= $this->Model_cuti_tambahan->getPengajuanCutiTambahanAll2($ni);
			$this->data['sum_ijin'] 			= $this->Model_ijin->getCutiData2($no);
			$this->data['sum_terlambat'] 		= $this->Model_terlambat->getCutiData2($no);

		$dates =date('Y-m-d');
		$this->data['saldo_normatif'] 			= $this->Model_cuti->getDataNormatif($no);
		$this->data['saldo_bonus'] 				= $this->Model_cuti->getDataBonus($no,$dates);
		$this->data['saldo_tambahan'] 			= $this->Model_cuti->getDataTambahan($no,$dates);
		// die(json_encode($this->data['saldo_tambahan']));
	}
	public function index()
	{
		$this->form();
		$this->render_template('users/manage_user/index',$this->data);
	}

	public function fetchDataUser()
	{
		$output = array('data' => array());

		$draw		=$_REQUEST['draw'];
		$length		=$_REQUEST['length'];
		$start		=$_REQUEST['start'];
		$column 	=$_REQUEST['order'][0]['column'];
		$order 		=$_REQUEST['order'][0]['dir'];
		$search_no  =$_REQUEST['columns'][0]['search']["value"];

		$data 		= $this->Model_manage_user->getManageUser1($search_no,$length,$start,$column,$order);
		$data_jum 	= $this->Model_manage_user->getManageUser2($search_no);
		$output		= array();
		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		if($search_no !="" ){
			$data_jum = $this->Model_manage_user->getManageUser2($search_no);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){
			foreach ($data as $key => $value) {
					$buttons = '';
					$buttons .= ' <button onclick="edit_person('."'".$value['nama_login']."'".')"
					class="btn btn-primary mb-1"><i class="simple-icon-note" ></i> Edit</button>';
					$buttons .= ' <a href="'.base_url('leaves/cuti/detail/'.$value['nama_login']).'"
					class="btn btn-primary mb-1"><i class="simple-icon-note" title="Detail"></i> Detail</a>';

					$output['data'][$key] = array(
						$value['nama_login'],
						$value['nama_karyawan'],
						$value['email'],
						$buttons
					);
			}
		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}


}
