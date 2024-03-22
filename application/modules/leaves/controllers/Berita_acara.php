<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Berita_acara extends Admin_Controller  {

    private $hrd;
	public function __construct()
	{
		$this->data['modul'] = "Leaves";
		parent::__construct();
		$this->not_logged_in();
		$this->data['page_title'] = 'Berita Acara';
		$this->load->model('Model_leave');
        $this->load->model('Model_report');
        $this->load->model('Model_berita_acara');

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
		$this->data['app'] 	        = $this->Model_berita_acara->getDataApp();
	}

	public function index()
	{
		$this->form();
		$this->render_template('berita_acara/index',$this->data);
	}

	public function detail($faktur_id)
	{

		$cek = $this->Model_berita_acara->headerDok($faktur_id);
        // tesx($cek);
		if(empty($cek)){
			redirect('404_override', 'refresh');
		}
		$this->form_validation->set_rules('faktur_id' ,'No Faktur' , 'trim|required',$this->val_error);
		if ($this->form_validation->run() == TRUE) {

			$save = $this->Model_berita_acara->appDeptHead();

			if($save) {
				$this->session->set_flashdata('success', 'Approve "'.$save.'" Berhasil Disimpan');
				redirect('leaves/berita_acara', 'refresh');
			} else {
				$this->session->set_flashdata('errors', 'Error occurred!!');
				redirect('leaves/berita_acara/'.$faktur_id, 'refresh');
			}
		} else {
			$this->data['headerdok'] = $this->Model_berita_acara->headerDok($faktur_id);
            $this->data['nilaijasa'] = $this->Model_berita_acara->getNilaiJasa($this->data['headerdok']['pr_h_id']);
            $this->data['total_akhir'] = $this->data['headerdok']['new_r_total'] + $this->data['headerdok']['new_l_total'] + $this->data['nilaijasa']['total_jasa'];


            // tesx($this->data['totalakhir'],$this->data['headerdok']['new_r_total'],$this->data['headerdok']['new_r_total'], $this->data['nilaijasa']['total_jasa']);
			// $this->data['detaildok'] = $this->Model_berita_acara->detailDok($faktur_id);

			$this->form();
			$this->render_template('berita_acara/detail',$this->data);

		}

	}

	public function reject()
	{
		$reject = $this->Model_berita_acara->rejectAction();
		if($reject) {
			$this->session->set_flashdata('success', 'Reject "'.$reject.'" Berhasil Disimpan');
			redirect('leaves/kas_kecil', 'refresh');
		}
		else {
			$this->session->set_flashdata('errors', 'Error occurred!!');
			redirect('leaves/kas_kecil', 'refresh');
		}

	}


	/** feetching Data */
	public function fetchDataApproval()
	{

		$output = array('data' => array());
		$draw			= $_REQUEST['draw'];
		$length			= $_REQUEST['length'];
		$start			= $_REQUEST['start'];
		$column 		= $_REQUEST['order'][0]['column'];
		$order 			= $_REQUEST['order'][0]['dir'];
		$search_no   	= $_REQUEST['columns'][0]['search']["value"];
		//$output['data']=array();

		#Get Model by App
		$cek_app 	= $this->Model_berita_acara->getDataApp();
        // tesx($cek_app);
		if(!empty($cek_app)){
			$urutan_app 	= $cek_app['urutan'];
            $data 			= $this->Model_berita_acara->getDataDeptHead1($urutan_app, $search_no,$length,$start,$column,$order);
            $data_jum 		= $this->Model_berita_acara->getDataDeptHead2($urutan_app, $search_no);
		}else{
            $data       = '';
            $data_jum   = '0';
		}
		#Get Model by App

		$output					= array();
		$output['draw']			= $draw;
		$output['recordsTotal']	= $output['recordsFiltered']= $data_jum;

		if($data){

			foreach ($data as $key => $value) {
					$buttons = '';
					$buttons .= '	<a href="'.base_url('leaves/berita_acara/detail/'.$value['faktur_id']).'"
									class="btn btn-success btn-xs mb-2"><i class="iconsminds-yes" title="Approve"></i> App</a>

						';
						// <button onclick="reject('."'".$value['faktur_id']."'".')"
						// class="btn btn-danger btn-xs mb-2"><i class="iconsminds-close" ></i> Rej</button>
					$output['data'][$key] = array(
						$value['no_faktur'],
                        $value['no_pr'],
						$value['user_name'],
						$value['keterangan'],
						nominal($value['new_total_lensa']),
						$value['wkt_input'],
						$buttons
					);
			}
		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}


}