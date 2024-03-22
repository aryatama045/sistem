<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends Admin_Controller  {
	private $hrd;
	public function __construct()
	{
		$this->data['modul'] = "Leaves";
		parent::__construct();
		$this->not_logged_in();
		$this->data['page_title'] = 'Report';
		$this->load->model('Model_report');
		$this->load->model('Model_cuti');
		$this->load->model('Model_cuti_tambahan');
		$this->load->model('Model_leave');
		$this->load->model('user/Model_approve');
		$this->hrd 		= $this->load->database('hrd',TRUE);
		$this->hrdsave 	= $this->load->database('hrd_save',TRUE);
	}

	public function form()
	{
		$this->data['approval']  	= $this->Model_leave->PicApproval();
		$this->data['verifikasi']  	= $this->Model_leave->PicVerifikasiHrd();
		$this->data['nm_divisi'] 	= $this->Model_report->getDataDivisi()->result();

		$this->data['karyawan'] 	= $this->Model_report->getDataKaryawan()->result();

		$this->data['data_karyawan']= $this->Model_approve->getDataKaryawan();

	}

	public function index()
	{
		$this->form();
		$this->render_template('report_absensi/index',$this->data);
	}


	public function cuti_pengganti()
	{
		$this->form();
		$this->render_template('report/cuti_pengganti/index',$this->data);
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

	public function detail_doc($id)
	{
		$header = $this->Model_report->HeaderDoc($id);
		$data 	= $this->Model_report->DetailDoc($id);

		// $app = $this->Model_report->DetailApp($id);
		$app_data 	= $this->Model_cuti->getDataPosting($header['tdk_masuk_h_id']);
		$urutan_app	= $this->Model_cuti->urutanApp($header['biodata_id']);

		// tesx($header);
		if($data){
			$output['potong'] = $header['potong_cuti_dari'];
			$output['nip'] = $header['nip'].'-'.$header['nama_lengkap'];
			$output['keterangan'] = $header['keterangan'];
			foreach ($data as $key => $value) {
				$output['data'][$key] = array(
					$value['tgl_tdk_masuk'],
					$value['nama_hari'],
					$value['keterangan']
				);
			}

			if(isset($urutan_app)){
				$no=0; foreach ($urutan_app as $key => $val) { $no++;
					$output['approve'][$key] = array(
						$val['nama_app']!=NULL?$val['nama_app']:'-',
						$app_data['tgl_app_'.$val['urutan_approval']]!=NULL?$app_data['tgl_app_'.$val['urutan_approval']]:'-',
						$app_data['tgl_rej_'.$val['urutan_approval']]!=NULL?$app_data['tgl_rej_'.$val['urutan_approval']]:'-',
						$app_data['rej_komentar_'.$val['urutan_approval']]!=NULL?$app_data['rej_komentar_'.$val['urutan_approval']]:'-'
					);
				}
			}


		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}


	public function fetchDataAbsen()
	{
		// $output = array('data' => array());

		$draw=$_REQUEST['draw'];
		$length=$_REQUEST['length'];
		$start=$_REQUEST['start'];
		//$search=$_REQUEST['search']["value"];
		$column = $_REQUEST['order'][0]['column'];
		$order 			= $_REQUEST['order'][0]['dir'];
		$search_no   = $_REQUEST['columns'][0]['search']["value"];

		$output['data']=array();
		$no_dok = $this->input->post('no_dok');
		$nip = $this->input->post('nip');
		$nama = $this->input->post('nama_lengkap');
		$id_divisi = $this->input->post('id_divisi');
		$id_dept = $this->input->post('id_dept');
		$kd_store = $this->input->post('kd_store');
		$tanggal1 = $this->input->post('tanggal1');
		$tanggal2 = $this->input->post('tanggal2');

		$data = $this->Model_report->getDataAbsen($no_dok,$tanggal1,$tanggal2,$id_divisi,$id_dept,$kd_store,$nip, $nama, $search_no,$length,$start,$column,$order);
		$data_jum = $this->Model_report->getJumlahDataAbsen($no_dok,$tanggal1,$tanggal2,$id_divisi,$id_dept,$kd_store,$nip, $nama);
		$output=array();

		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		if($search_no !="" ){
			$data_jum = $this->Model_report->getJumlahDataAbsen($no_dok,$tanggal1,$tanggal2,$id_divisi,$id_dept,$kd_store,$nip, $nama);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){
			foreach ($data as $key => $value) {
				$buttons = '';
				$buttons .= ' <a href="#" onclick="detail_doc('."'".$value['no_dok_tdk_masuk']."'".')">'.$value['no_dok_tdk_masuk'].'</a>';
				$store = "<span title='".$value['nama_store']."'> ".$value['kd_store']." </span>";

					$output['data'][$key] = array(
						$buttons,
						$value['nip'],
						$value['nama_lengkap'],
						$value['tgl_tdk_masuk'],
						$value['nama_jabatan'],
						$value['nama_dept'],
						$value['nama_divisi'],
						$store,
						$value['status_absen']
					);
			}

		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}

	public function fetchCutiPengganti()
	{

		$draw			= $_REQUEST['draw'];
		$length			= $_REQUEST['length'];
		$start			= $_REQUEST['start'];
		//$search		=$_REQUEST['search']["value"];
		$column 		= $_REQUEST['order'][0]['column'];
		$order 			= $_REQUEST['order'][0]['dir'];
		$search_no   	= $_REQUEST['columns'][0]['search']["value"];

		$output['data']=array();
		$nip 		= $this->session->userdata('nama_login');
		$karyawan 	= $this->input->post('karyawan');
		$id_divisi 	= $this->input->post('id_divisi');
		$id_dept 	= $this->input->post('id_dept');
		$kd_store 	= $this->input->post('kd_store');
		$tanggal1 	= $this->input->post('tanggal1');
		$tanggal2 	= $this->input->post('tanggal2');

		$data 		= $this->Model_report->getCutiPengganti("result",$karyawan,$tanggal1,$tanggal2,$id_divisi,$id_dept,$kd_store, $search_no,$length,$start,$column,$order);
		$data_jum 	= $this->Model_report->getCutiPengganti("count",$karyawan,$tanggal1,$tanggal2,$id_divisi,$id_dept,$kd_store);

		$output=array();
		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		if($search_no !="" || $karyawan !="" ){
			$data_jum = $this->Model_report->getCutiPengganti("count",$karyawan,$tanggal1,$tanggal2,$id_divisi,$id_dept,$kd_store);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		// tesx($data);

		if($data){

			foreach ($data as $key => $value) {

				$arr_result = array(
					'',
					$value['no_doc'],
					$value['nip'],
					$value['nama_lengkap'],
					$value['tgl_awal'],
					$value['tgl_akhir'],
					$value['kd_store'],
					$value['nama_dept'],
					$value['keterangan'],
					$value['status_dokumen']
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

				$output['data'][] = $arr_result;

			}

		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}

	public function print_action($check=false){

		$output['data']=array();
		$nip 		= $this->session->userdata('nama_login');
		$id_divisi = $this->input->post('nm_divisi');
		$id_dept = $this->input->post('nm_departement');
		$kd_store = $this->input->post('nm_store');
		$tanggal1 = $this->input->post('tanggal1');
		$tanggal2 = $this->input->post('tanggal2');

		$data = $this->Model_report->getDataAbsenPDF($tanggal1,$tanggal2,$id_divisi,$id_dept,$kd_store);

		if (count($data)) {
			$output['data']['detail'] = $data ;
			$output['data']['header']['divisi'] = $id_divisi;
			$output['data']['header']['dept'] = $id_dept;
			$output['data']['header']['kd_store'] = $kd_store;
			$output['data']['header']['tanggal1'] = $tanggal1;
			$output['data']['header']['tanggal2'] = $tanggal2;

			if($this->input->post('action')=='excel'){
				$this->Model_report->exportExcelCuti($output['data']);
			}else{
				$this->load->view('report_absensi/print', $output);
			}
		}else{
			$this->session->set_flashdata('print', true);
			$this->session->set_flashdata('messages', "Tidak Ada Data Yang Dicetak");
			redirect('report_absensi/index', 'refresh');
		}
	}

	#Cuti Dispensasi
	public function cuti_dispensasi()
	{
		$this->form();
		$this->data['title_page'] = 'Report Cuti Dispensasi';
		$this->render_template('report/cuti_dispensasi/index',$this->data);
	}

	public function fetchCutiDispensasi()
	{
		// $output = array('data' => array());

		$draw		= $_REQUEST['draw'];
		$length		= $_REQUEST['length'];
		$start		= $_REQUEST['start'];
		//$search=$_REQUEST['search']["value"];
		$column 	= $_REQUEST['order'][0]['column'];
		$order		= $_REQUEST['order'][0]['dir'];
		$output['data']=array();

		$search_no	= $this->input->post('karyawan');
		$id_divisi	= $this->input->post('id_divisi');
		$id_dept	= $this->input->post('id_dept');
		$kd_store	= $this->input->post('kd_store');
		$tanggal1	= $this->input->post('tanggal1');
		$tanggal2	= $this->input->post('tanggal2');

		$data 		= $this->Model_report->getCutiDispensasi($tanggal1,$tanggal2,$id_divisi,$id_dept,$kd_store, $search_no,$length,$start,$column,$order);
		$data_jum 	= $this->Model_report->getCutiDispensasiCount($tanggal1,$tanggal2,$id_divisi,$id_dept,$kd_store, $search_no);

		$output=array();
		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$data_jum;

		if($search_no !="" || $id_divisi !="" || $id_dept !="" || $kd_store !="" ){
			$data_jum = $this->Model_report->getCutiDispensasiCount($tanggal1,$tanggal2,$id_divisi,$id_dept,$kd_store, $search_no);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){
			foreach ($data as $key => $value) {
				$buttons = '';
				$buttons .= ' <a class="btn btn-primary mb-1" href="#" onclick="detail_doc('."'".$value['no_dok_cuti']."'".')"><i class="fa fa-eye"></i> '.$value['no_dok_cuti'].'</a>';
				$store = "<span title='".$value['nama_store']."'> ".$value['kd_store']." </span>";

					$output['data'][$key] = array(
						$buttons,
						$value['nip'],
						$value['nama_lengkap'],
						$value['tgl_mulai_cuti'],
						$value['nama_jabatan'],
						$value['nama_dept'],
						$value['nama_divisi'],
						$store,
						$value['jenis_cuti']
					);
			}

		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}

	public function detail_dispensasi($id)
	{
		$header = $this->Model_report->HeaderDispensasi($id);
		$data 	= $this->Model_report->DetailDispensasi($id);

		$app_data 	= $this->Model_cuti->getDataPosting($header['cuti_dispensasi_h_id']);
		$urutan_app	= $this->Model_cuti->urutanApp($header['biodata_id']);
		$lampiran 	= $this->Model_report->getDataLampiran($header['no_dok_cuti']);

		// tesx($header, $data);

		if($data){
			$output['jenis_cuti'] = $header['jenis_cuti'];
			$output['nip'] = $header['nip'].'-'.$header['nama_lengkap'];
			$output['tgl_mulai_cuti'] = $header['tgl_mulai_cuti'];
			$output['keterangan'] = $header['keterangan'];

			if($header['status_dokumen'] =='APPROVED'){
				$status_doc = '<span class="badge badge-pill badge-success mb-1">'.$header['status_dokumen'].'</span>';
			}else if($header['status_dokumen'] =='REJECT'){
				$status_doc =  '<span class="badge badge-pill badge-warning mb-1">'.$header['status_dokumen'].'</span>';
			}else{
				$status_doc =  '<span class="badge badge-pill badge-secondary mb-1">'.$header['status_dokumen'].'</span>';
			}
			$output['status_doc'] = $status_doc;


			$no=0;
			foreach ($data as $key => $value) { $no++;
				$output['data'][$key] = array(
					$no,
					$value['tgl_cuti'],
					$value['nama_hari'],
					$value['keterangan']
				);
			}

			if(isset($urutan_app)){
				$no=0; foreach ($urutan_app as $key => $val) { $no++;
					$output['approve'][$key] = array(
						$val['nama_app']!=NULL?$val['nama_app']:'-',
						$app_data['tgl_app_'.$val['urutan_approval']]!=NULL?$app_data['tgl_app_'.$val['urutan_approval']]:'-',
						$app_data['tgl_rej_'.$val['urutan_approval']]!=NULL?$app_data['tgl_rej_'.$val['urutan_approval']]:'-',
						$app_data['rej_komentar_'.$val['urutan_approval']]!=NULL?$app_data['rej_komentar_'.$val['urutan_approval']]:'-'
					);
				}
			}

			// if(isset($lampiran)){
				foreach ($lampiran as $key => $val) {
				$output['lampiran'][$key] = array(
					$val['file_1'],
					$val['file_2'],
					$val['file_3']
				);
				}
			// }

			// tesx($output['lampiran']);




		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}

}

?>
