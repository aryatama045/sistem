<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Absensi_status extends Admin_Controller  {
	private $hrd;
	public function __construct()
	{
		$this->data['modul'] = "Leaves";
		parent::__construct();
		$this->not_logged_in();
		$this->data['page_title'] = 'Report';
		$this->load->model('Model_report');
		$this->load->model('Model_cuti');
		$this->load->model('Model_leave');
		$this->hrd 		= $this->load->database('hrd',TRUE);
		$this->hrdsave 	= $this->load->database('hrd_save',TRUE);
	}

	public function form()
	{
		$this->data['approval']  	= $this->Model_leave->PicApproval();
		$this->data['verifikasi']  	= $this->Model_leave->PicVerifikasiHrd();
		$this->data['nm_divisi'] = $this->Model_report->getDataDivisi()->result();
		$this->data['status_absensi'] = $this->Model_report->getStatusAbsensi()->result();
		$this->data['karyawan'] 	= $this->Model_report->getDataKaryawan()->result();

		$data_status = $this->Model_cuti->getStatusCuti();
		$list_status_absensi_id = array(""=>"");
		foreach ($data_status as $key => $value) {
			$list_status_absensi_id[$value['status_absensi_id']]= $value['ket_status_absensi'];
			if($value['ket_status_absensi'] == 'CUTI 1/2 HARI'){
				$list_status_absensi_id[$value['ket_status_absensi']]= $value['ket_status_absensi'];
			} else {
				$list_status_absensi_id[$value['status_absensi_id']]= $value['ket_status_absensi'];
			}
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
		$this->data['kodestore'] 	= $this->Model_cuti->getKodeStore($biodataid);
		$this->data['golabsen'] 	= $this->Model_cuti->getGolAbsen($biodataid);
	}

	public function index()
	{
		$this->form();
		$this->render_template('report_absensi_status/index',$this->data);
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

	public function print_action($check=false){

		$output['data']=array();
		$nip 		= $this->session->userdata('nama_login');
		$status_absensi = $this->input->post('status_absensi');
		$id_divisi = $this->input->post('nm_divisi');
		$id_dept = $this->input->post('nm_departement');
		$kd_store = $this->input->post('nm_store');
		$tanggal1 = $this->input->post('tanggal1');
		$tanggal2 = $this->input->post('tanggal2');

		$data = $this->Model_report->getDataAbsensiStatusPDF($tanggal1,$tanggal2,$id_divisi,$id_dept,$kd_store,$status_absensi);

		if (count($data)) {
			$output['data']['detail'] = $data ;
			$output['data']['header']['status_absensi'] = $status_absensi;
			$output['data']['header']['divisi'] = $id_divisi;
			$output['data']['header']['dept'] = $id_dept;
			$output['data']['header']['kd_store'] = $kd_store;
			$output['data']['header']['tanggal1'] = $tanggal1;
			$output['data']['header']['tanggal2'] = $tanggal2;

			if($this->input->post('action')=='excel'){
				$this->Model_report->exportExcelAbsensi($output['data']);
			}else{
				$this->load->view('report_absensi_status/print', $output);
			}
		}else{
			$this->session->set_flashdata('print', true);
			$this->session->set_flashdata('messages', "Tidak Ada Data Yang Dicetak");
			redirect('report_absensi_status/index', 'refresh');
		}
	}

	public function fetchDataAbsenStatus()
	{

		$draw=$_REQUEST['draw'];
		$length=$_REQUEST['length'];
		$start=$_REQUEST['start'];
		//$search=$_REQUEST['search']["value"];
		$column 		= $_REQUEST['order'][0]['column'];
		$order 			= $_REQUEST['order'][0]['dir'];
		$search_no   	= $_REQUEST['columns'][0]['search']["value"];


		$output['data']	= array();
		$nip = $this->input->post('nip');
		$nama = $this->input->post('nama_lengkap');
		$status_absensi = $this->input->post('status_absensi');
		$id_divisi 		= $this->input->post('id_divisi');
		$id_dept 		= $this->input->post('id_dept');
		$karyawan		= $this->input->post('karyawan');
		$kd_store 		= $this->input->post('kd_store');
		$tanggal1 		= $this->input->post('tanggal1');
		$tanggal2 		= $this->input->post('tanggal2');

		$data = $this->Model_report->getDataAbensiStatus($tanggal1,$tanggal2,$id_divisi,$id_dept,$kd_store,$status_absensi,$karyawan,$nip,$nama, $search_no,$length,$start,$column,$order);
		$data_jum = $this->Model_report->getJumlahDataAbsensiStatus($tanggal1,$tanggal2,$id_divisi,$id_dept,$kd_store,$status_absensi,$karyawan,$nip,$nama);
		$output=array();

		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		if($search_no !="" || $karyawan !=""  ){
			$data_jum = $this->Model_report->getJumlahDataAbsensiStatus($tanggal1,$tanggal2,$id_divisi,$id_dept,$kd_store,$status_absensi,$karyawan,$nip,$nama);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){
			foreach ($data as $key => $value) {
				$buttons = '';
				$buttons .= ' <a href="#" onclick="detail_doc('."'".$value['nip']."','".$value['tgl_absensi']."'".')">'.$value['nip'].'</a>';

					$output['data'][$key] = array(
						$buttons,
						$value['nama_lengkap'],
						$value['nama_dept'],
						$value['tgl_absensi'],
						$value['jam_masuk'],
						$value['jam_keluar'],
						$value['ket_status_absensi'],
						$value['keterangan2']
					);
			}

		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}

	public function absen_history($nip, $tgl)
	{

		$data = $this->Model_report->getAbsenHistory($nip,$tgl);

		if($data){
			foreach ($data as $key => $value) { ;
				$output['data'][$key] = array(
					$value['checkdate'],
					$value['jenis'],
					$value['checktime'],
					$value['lokasi']
				);
			}
		}else{
			$output['data'] = [];
		}

		echo json_encode($output);
	}




}

?>
