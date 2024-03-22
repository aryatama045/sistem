<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Hrd_cuti extends Admin_Controller  {
    private $hrd;
	public function __construct()
	{
		$this->data['modul'] = "Leaves";
		parent::__construct();
		$this->not_logged_in();
		$this->data['page_title'] = 'Cuti';
		$this->load->model('Model_cuti');
		$this->load->model('Model_hrd_cuti');
		$this->load->model('Model_leave');
        $this->load->model('user/Model_approve');
        $this->load->model('Model_report');
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


    function index(){


        $this->render_template('hrd_cuti/index',$this->data);
    }


    function create()
	{
		$this->form_validation->set_rules('potong_cuti_dari' ,'Sumber Potong Cuti' , 'trim|required',$this->val_error);
		$this->form_validation->set_rules('tgl_tdk_masuk[]','Tanggal Cuti','required|callback_tgl_unique',
                                            array('required' => 'Tanggal Cuti Tidak Boleh Kosong !!'));

        if ($this->form_validation->run() == TRUE) {
			// Jumlah Ambil Cuti
				if($this->input->post('jumlah_hari')=='1'){
					$jml_ambil = count($this->input->post('tgl_tdk_masuk'));
				}else{
					$jml_ambil = count($this->input->post('tgl_tdk_masuk'))*'0.5';
				}
			//end

			// Sumber Potong Cuti
				$potong_cuti = $this->input->post('potong_cuti_dari');
				if($potong_cuti=='NORMATIF'){

					$saldo              = $this->input->post('sisa_normatif');
					$tgl_cuti_potong    = $this->input->post('tgl_tdk_masuk');
					rsort($tgl_cuti_potong);

					foreach($tgl_cuti_potong as $k => $v){

						$get_tgl_cuti_ncek 	= end($tgl_cuti_potong);

						$tgl_cuti_ncek		= date('Y', strtotime($get_tgl_cuti_ncek));

						$tgl_cuti_n 		= date('Y', strtotime($v));

						if($tgl_cuti_ncek != $tgl_cuti_n){
							$this->session->set_flashdata('error', $get_tgl_cuti_ncek.' / '. $v.' Tanggal Cuti tidak boleh mengajukan beda Tahun, silahkan ajukan di dokumen yang baru!!');
							redirect('leaves/hrd_cuti/create', 'refresh');
						}
					}
				}
				if($potong_cuti=='BONUS'){
					$saldo = $this->input->post('sisa_bonus');
				}
				if($potong_cuti=='TAMBAHAN'){
					$saldo = $this->input->post('sisa_tambahan');
				}
			//end

			$tgl_tdk_masuk	= $this->input->post('tgl_tdk_masuk');
			$biodataids		= $this->input->post('biodata_id');

			foreach($tgl_tdk_masuk as $k => $v){

				$cek_tgl_cuti = $this->Model_cuti->getTglCuti($biodataids, $v);
				if($v == $cek_tgl_cuti['tgl_tdk_masuk']){
					$this->session->set_flashdata('error', $v.' Tanggal Cuti Sudah Ada!!');
					redirect('leaves/hrd_cuti/create', 'refresh');
				}
			}

			if($potong_cuti == 'BONUS' ){
				if ($jml_ambil <= $saldo){
					// tesx('ok');
					$create_form = $this->Model_hrd_cuti->create();

					if($create_form) {
						$this->session->set_flashdata('success', 'Cuti "'.$create_form.'" Berhasil Disimpan');
						redirect('leaves/hrd_cuti/index/', 'refresh');
					}
					else {
						$this->session->set_flashdata('error', 'Error occurred!!');
						redirect('leaves/hrd_cuti/create', 'refresh');
					}
				} else {
					// tesx('saldo kurang');
					$this->session->set_flashdata('error', 'Jumlah Pengajuan Cuti "'.$jml_ambil.'"  Tidak Boleh Melebihi Dari Saldo "'.$saldo.'" Sumber Potong Cuti !!');
					redirect('leaves/hrd_cuti/create', 'refresh');
				}
			} else {
				$create_form = $this->Model_hrd_cuti->create();
				if($create_form) {
					$this->session->set_flashdata('success', 'Cuti "'.$create_form.'" Berhasil Disimpan');
					redirect('leaves/hrd_cuti/index/', 'refresh');
				}
				else {
					$this->session->set_flashdata('error', 'Error occurred!!');
					redirect('leaves/hrd_cuti/create', 'refresh');
				}
			}
		} else {
            $this->form();
			$this->render_template('hrd_cuti/create', $this->data);
		}
	}


    function fetchDataCuti()
	{
		$output = array('data' => array());

		$draw       = $_REQUEST['draw'];
		$length     = $_REQUEST['length'];
		$start      = $_REQUEST['start'];
		$column     = $_REQUEST['order'][0]['column'];
		$order 		= $_REQUEST['order'][0]['dir'];
		$search_no  = $_REQUEST['columns'][0]['search']["value"];

		$nip 		= $this->session->userdata('nama_login');
		$biodata 	= $this->hrd->select('biodata_id')
                        ->get_where( 'hrd_all.mst_biodata',array('nip' => $nip))->row_array();
		$no         = $biodata['biodata_id'];

		$data       = $this->Model_cuti->getCutiData1($no, $search_no,$length,$start,$column,$order);
		$data_jum   = $this->Model_cuti->getCutiData2($no,$search_no);
        $output     = array();

		$output['draw']         = $draw;
		$output['recordsTotal'] = $output['recordsFiltered']=$data_jum;

        if($search_no !="" ){
			$data_jum               = $this->Model_cuti->getCutiData2($no,$search_no);
			$output['recordsTotal'] = $output['recordsFiltered']=$data_jum;
		}

		if($data){
			foreach ($data as $key => $value) {
                $buttons = '';
                $buttons .= ' <a href="'.base_url('leaves/hrd_cuti/detail/'.$value['tdk_masuk_h_id']).'"
                                class="btn btn-primary mb-1"><i class="simple-icon-note" title="Detail"></i> Detail</a>';

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



// ------- Helper

    function form(){
        $docCode	='HRC';
		$date		= date('ym');
		$this->data['no_doc'] 	= $this->Model_cuti->getDataNoDoc($docCode,$date);
        $this->data['data_karyawan']= $this->Model_approve->getDataKaryawan();
    }

    function tgl_unique(){
		$array = $this->input->post('tgl_tdk_masuk');// get value
		$this->form_validation->set_message('tgl_unique', '%s tidak boleh sama. ');
		if(count(array_unique($array))!==count($array)){
			// Array has duplicates
			return FALSE;
		} else {
			// Array does not have duplicates
			return TRUE;
		}
	}

    function ket_check($str){
		$this->form_validation->set_message('ket_checks', 'The field can not be the word ');
		$count_array = array_count_values($str);

		$results = array();
		foreach($count_array as $key=>$val){
			if($val == 1){
				return TRUE;
			} else{
				return FALSE;
			}
		}
	}

    function getKaryawan(){

		$nip 	= $this->input->post('nip',TRUE);
        $datas 	= $this->Model_leave->getKaryawanByID($nip);

		if ($datas == null){
			$data = array( 'error' => "Tidak ada data");
		}else{
			$data['karyawan'] 	    = $this->Model_leave->getKaryawanByID($nip);
			$data['biodata_id'] 	= $data['karyawan']['biodata_id'];
            $data['normatif'] 	    = $this->Model_cuti->getDataNormatif($data['karyawan']['biodata_id']);
            $data['tambahan'] 	    = $this->Model_cuti->getSaldoTambahan($data['karyawan']['biodata_id']);

		}

        echo json_encode($data);
	}


// ------- END Helper

}