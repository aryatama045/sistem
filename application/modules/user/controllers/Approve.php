<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Approve extends Admin_Controller  {
	private $hrd;
	public function __construct()
	{
		parent::__construct();
		$this->not_logged_in();
		$this->data['page_title'] = 'User Approve';
		$this->load->model('leaves/Model_report');
		$this->load->model('leaves/Model_cuti');
		$this->load->model('leaves/Model_leave');

        $this->load->model('Model_approve');
		$this->hrd 		= $this->load->database('hrd',TRUE);
		$this->hrdsave 	= $this->load->database('hrd_save',TRUE);
	}

	public function form()
	{
		$this->data['approval']  	= $this->Model_leave->PicApproval();
		$this->data['verifikasi']  	= $this->Model_leave->PicVerifikasiHrd();
		$this->data['nm_divisi'] 	= $this->Model_report->getDataDivisi()->result();

		$this->data['data_karyawan'] 	= $this->Model_approve->getDataKaryawan();


	}

    public function index()
	{
		$this->form();
		$this->data['pic_approve'] 	= $this->Model_approve->getPicApprove();
		$this->render_template('approve/index',$this->data);
	}

	public function fetchDataApprove()
	{
		// $output = array('data' => array());

		$draw=$_REQUEST['draw'];
		$length=$_REQUEST['length'];
		$start=$_REQUEST['start'];
		//$search=$_REQUEST['search']["value"];
		$column 		= $_REQUEST['order'][0]['column'];
		$order 			= $_REQUEST['order'][0]['dir'];
		$search_no   	= $_REQUEST['columns'][0]['search']["value"];

		$output['data']	= array();
		$karyawan		= $this->input->post('karyawan');
		$kd_store 		= $this->input->post('kd_store');

		$data = $this->Model_approve->getListApprove1($kd_store,$karyawan, $search_no,$length,$start,$column,$order);
		// tesx($data);

		$data_jum = $this->Model_approve->getListApprove2($kd_store,$karyawan);
		$output=array();

		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		if($search_no !="" || $karyawan !=""  ){
			$data_jum = $this->Model_approve->getListApprove2($kd_store,$karyawan);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){
			foreach ($data as $key => $value) {
				$btn = '';
				// <button onclick="edit_person('."'".$value['id_app']."'".')" class="btn btn-primary mb-1"><i class="simple-icon-note" ></i> Edit</button>';
				$btn .= '

						<button onclick="remove_pic('."'".$value['id_app']."'".')"
						class="btn btn-sm btn-warning mb-1"><i class="simple-icon-trash" ></i> Remove</button>';
				$output['data'][$key] = array(
					$value['urutan_approval'],
					$value['nip_app'],
					$value['nama_app'],
					$btn,
				);
			}

		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}

	public function get_karyawan()
	{
		$biodata_id = $this->input->post('id');
		$data = $this->Model_approve->getDataKaryawanId($biodata_id);
		echo json_encode($data);
	}

	public function get_data_karyawan()
	{
		$search 	= $this->input->get("pic_approve");
		$pglm 		= $this->input->get("page_limit");
		$limit 		= (empty($pglm) ? 10 : $pglm);
		$pg 		= $this->input->get("page");
		$page 		= (empty($pg) ? 0 : $pg);
		$start 		= $page * $limit;

		tesx($search);

		$filtered 	= $this->Model_approve->SelectKaryawan($start,$limit);
		$count		= count($filtered);

		// tesx($count);

		echo json_encode(array(
				'incomplete_results' => false,
				'items' => $filtered,
				'total' => $count // Total rows without LIMIT on SQL query
		));
	}

	public function get_pic_app()
	{
		$biodata_id = $this->input->post('id');
		$id_app 	= $this->input->post('biodata_id');
		// tesx($biodata_id,$id_app);
		$data = $this->Model_approve->getDataPicApp($id_app, $biodata_id);
		echo json_encode($data);
	}

	public function get_pic_app_cp()
	{
		$biodata_id = $this->input->post('id');
		$id_app 	= $this->input->post('biodata_id');
		// tesx($biodata_id,$id_app);
		$data = $this->Model_approve->getDataPicAppCP($id_app, $biodata_id);
		echo json_encode($data);
	}

	public function get_pic_approve()
	{

		$name = $this->input->get("pic");

		$data = $this->Model_approve->getPicApproveSearch($name, 'nama_lengkap');
		echo json_encode($data);

	}


	/*-- Action --- */
	public function save_action()
	{
		$biodata_id 	= $this->input->post('karyawan');
		$cekKaryawan01	= $this->Model_approve->getDataKaryawan01($biodata_id);

		// tesx($cekKaryawan01['karyawan_id'], $cekKaryawan01);

		if(empty($cekKaryawan01) || $cekKaryawan01 == NULL || $cekKaryawan01 == ""){
			$saveKaryawan 	= $this->Model_approve->saveKaryawan($biodata_id);
			if($saveKaryawan == false) {
				$this->session->set_flashdata('error', 'Data Karyawan Gagal Disimpan!!');
				redirect('user/approve', 'refresh');
			}
		}


		$save_form = $this->Model_approve->saveAction($biodata_id);
		if($save_form) {
			$this->session->set_flashdata('success', '"'.$save_form.'" Berhasil Disimpan');
			redirect('user/approve', 'refresh');
			// redirect(''. $_SERVER['HTTP_REFERER']);
		} else {
			$this->session->set_flashdata('error', 'Error occurred!!');
			redirect('user/approve', 'refresh');
		}
	}

	public function tambah_pic()
	{
		$biodata_id 	= $this->input->post('karyawan');
		$cekKaryawan01	= $this->Model_approve->getDataKaryawan01($biodata_id);
		$cekPic			= $this->Model_approve->cekPicApp($cekKaryawan01['karyawan_id'], $cekKaryawan01['biodata']);

		// tesx($cekPic);
		if(empty($cekPic) || $cekPic == NULL || $cekPic == ""){
			$savePic	= $this->Model_approve->savePicApp($cekKaryawan01['biodata']);
			if($savePic == false) {
				$this->session->set_flashdata('error', 'Data Pic Gagal Disimpan!!');
				redirect('leaves/data_app', 'refresh');
			}else{
				$this->session->set_flashdata('success', 'Berhasil Disimpan');
				redirect('leaves/data_app', 'refresh');
			}
		}else{
			$this->session->set_flashdata('error', 'Data Pic Sudah ada !!');
			redirect('leaves/data_app', 'refresh');
		}

	}

	public function edit_action()
	{

		$save_form = $this->Model_approve->editAction();
		if($save_form) {
			$this->session->set_flashdata('success', '"'.$save_form.'" Berhasil Disimpan');
			redirect('user/approve', 'refresh');
		} else {
			$this->session->set_flashdata('error', 'Error occurred!!');
			redirect('user/approve', 'refresh');
		}

	}

	public function remove_action()
	{

			$remove_form = $this->Model_approve->removeAction();
			if($remove_form) {
				$this->session->set_flashdata('success', 'Berhasil Disimpan');
				redirect('user/approve', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Error occurred!!');
				redirect('user/approve', 'refresh');
			}
	}
	/*-- Action --- */



	public function cp()
	{
		$this->form();
		$this->data['pic_approve'] 	= $this->Model_approve->getPicApprove();
		$this->render_template('approve/cp',$this->data);
	}

	public function fetchDataApproveCP()
	{
		// $output = array('data' => array());

		$draw=$_REQUEST['draw'];
		$length=$_REQUEST['length'];
		$start=$_REQUEST['start'];
		//$search=$_REQUEST['search']["value"];
		$column 		= $_REQUEST['order'][0]['column'];
		$order 			= $_REQUEST['order'][0]['dir'];
		$search_no   	= $_REQUEST['columns'][0]['search']["value"];

		$output['data']	= array();
		$karyawan		= $this->input->post('karyawan');
		$kd_store 		= $this->input->post('kd_store');

		$data = $this->Model_approve->getListApproveCP1($kd_store,$karyawan, $search_no,$length,$start,$column,$order);
		// tesx($data);

		$data_jum 	= $this->Model_approve->getListApproveCP2($kd_store,$karyawan);
		$output		= array();

		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		if($search_no !="" || $karyawan !=""  ){
			$data_jum = $this->Model_approve->getListApproveCP2($kd_store,$karyawan);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){
			foreach ($data as $key => $value) {
				$btn = '';
				// $btn .= '<button onclick="edit_person('."'".$value['biodata_app']."'".')"class="btn btn-primary mb-1"><i class="simple-icon-note" ></i> Edit</button>';
				$btn .= '
						<button onclick="remove_pic('."'".$value['biodata_app']."'".')"
						class="btn btn-sm btn-warning mb-1"><i class="simple-icon-trash" ></i> Remove</button>';
				$output['data'][$key] = array(
					$value['urutan_app'],
					$value['nip_app'],
					$value['nama_app'],
					$btn,
				);
			}

		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}

	/*-- Action --- */
	public function save_action_cp()
	{
		$biodata_id 	= $this->input->post('karyawan');
		$cekKaryawan01	= $this->Model_approve->getDataKaryawan01($biodata_id);

		// tesx($cekKaryawan01['karyawan_id'], $cekKaryawan01);

		if(empty($cekKaryawan01) || $cekKaryawan01 == NULL || $cekKaryawan01 == ""){
			$saveKaryawan 	= $this->Model_approve->saveKaryawan($biodata_id);
			if($saveKaryawan == false) {
				$this->session->set_flashdata('error', 'Data Karyawan Gagal Disimpan!!');
				redirect('user/approve/cp', 'refresh');
			}
		}


		$save_form = $this->Model_approve->saveActionCP($biodata_id);
		if($save_form) {
			$this->session->set_flashdata('success', '"'.$save_form.'" Berhasil Disimpan');
			redirect('user/approve/cp', 'refresh');
			// redirect(''. $_SERVER['HTTP_REFERER']);
		} else {
			$this->session->set_flashdata('error', 'Error occurred!!');
			redirect('user/approve/cp', 'refresh');
		}
	}

	public function edit_action_cp()
	{

		$save_form = $this->Model_approve->editActionCP();
		if($save_form) {
			$this->session->set_flashdata('success', '"'.$save_form.'" Berhasil Disimpan');
			redirect('user/approve/cp', 'refresh');
		} else {
			$this->session->set_flashdata('error', 'Error occurred!!');
			redirect('user/approve/cp', 'refresh');
		}

	}

	public function remove_action_cp()
	{

			$remove_form = $this->Model_approve->removeActionCP();
			if($remove_form) {
				$this->session->set_flashdata('success', 'Berhasil Disimpan');
				redirect('user/approve/cp', 'refresh');
			} else {
				$this->session->set_flashdata('error', 'Error occurred!!');
				redirect('user/approve/cp', 'refresh');
			}
	}
	/*-- Action --- */

}