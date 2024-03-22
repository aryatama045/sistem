<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Batal extends Admin_Controller  {

    private $hrd;
	public function __construct()
	{
		$this->data['modul'] = "Leaves";
		parent::__construct();
		$this->not_logged_in();
		$this->data['page_title'] = 'Batal';
		$this->load->model('Model_leave');
        $this->load->model('Model_report');
        $this->load->model('Model_batal');
		$this->load->model('Model_cuti');

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
	}

    public function index()
	{
		$this->clear_all_cache();
		$verifikasi = $this->Model_leave->PicVerifikasiHrd();

		if($this->session->userdata('nama_login') != $verifikasi['nip']) {
			$this->session->set_flashdata('error', 'Tidak ada access');
			redirect('dashboard', 'refresh');
		}
		$this->form();
		$this->render_template('batal/index',$this->data);
	}

	public function detail($no_dok)
	{
		$verifikasi = $this->Model_leave->PicVerifikasiHrd();

		$cek = $this->Model_batal->headerDokUser($no_dok);

		if(empty($cek)){
			if($this->session->userdata('nama_login') === $verifikasi['nip']) {
				$this->session->set_flashdata('error', 'Silahkan Cek Dokumen tidak ada data');
				redirect('leaves/batal', 'refresh');
			}else{
				$this->session->set_flashdata('error', 'Silahkan Cek Dokumen tidak ada data');
				redirect('dashboard', 'refresh');
			}
		}

		$this->form_validation->set_rules('no_dok' ,'No. Dok Tidak Ada' , 'trim|required',$this->val_error);
		$this->form_validation->set_rules('keterangan_batal' ,'Keterangan Batal' , 'trim|required',$this->val_error);
		if ($this->form_validation->run() == TRUE) {

			$save = $this->Model_batal->actionBatal();

			if($save) {

					$this->session->set_flashdata('success', 'Batal Dokumen  "'.$save.'" Berhasil Disimpan');
					redirect('dashboard', 'refresh');

			} else {
				$this->session->set_flashdata('errors', 'Error occurred!!');
				redirect('leaves/batal/detail/'.$no_dok, 'refresh');
			}

		} else {

            $this->data['detailK'] 		= $this->Model_leave->getKaryawanByID($cek['nip']);

			$this->data['headerdok']	= $this->Model_batal->headerDokUser($no_dok);

			$this->data['lampiran']		= $this->Model_batal->getLampiran($no_dok);


			if($cek['jenis']=='CUTI DISPENSASI'){
				$this->data['detaildok'] = $this->Model_batal->getDetailDispensasi($cek['tdk_masuk_h_id']);
			}elseif($cek['jenis']=='CUTI PENGGANTI'){
				$this->data['detaildok'] = $this->Model_batal->getDetailPengganti($cek['tdk_masuk_h_id']);
			}else{
				$this->data['detaildok'] = $this->Model_batal->getDetailCutiIjin($cek['tdk_masuk_h_id']);
			}

			$this->data['jumlah_hari'] = count($this->data['detaildok']);

			$this->form();
			$this->render_template('batal/detail',$this->data);

		}

	}



	public function detail_hrd($no_dok)
	{

		$cek = $this->Model_batal->headerDok($no_dok);

		if(empty($cek)){
			$this->session->set_flashdata('error', 'Silahkan Cek Dokumen tidak ada data');
			redirect('leaves/batal', 'refresh');redirect('dashboard', 'refresh');
		}

		$this->form_validation->set_rules('no_dok' ,'No. Dok Tidak Ada' , 'trim|required',$this->val_error);
		$this->form_validation->set_rules('keterangan_batal' ,'Keterangan Batal' , 'trim|required',$this->val_error);
		if ($this->form_validation->run() == TRUE) {

			if($cek['status_dokumen']=='C'){

				if($cek['jenis']=='CUTI PENGGANTI'){

					$save = $this->Model_batal->actionBatalCutiPengganti();

				}elseif($cek['jenis']=='CUTI DISPENSASI'){

					$save = $this->Model_batal->actionBatalCutiDispensasi();

				}elseif($cek['jenis']=='CUTI'){

					$tgl_cuti = $this->input->post('tgl_cuti');

					// tesx($tgl_cuti);

					if(empty($tgl_cuti)){
						$this->session->set_flashdata('error', 'Silahkan Cek Tanggal ');
						redirect('leaves/batal/detail_hrd/'.$no_dok,  'refresh');
					}

					if($cek['sumber_potong']=='TAMBAHAN'){
						$save = $this->Model_batal->actionBatalCutiTambahan();
					}elseif($cek['sumber_potong']=='NORMATIF'){
						$save = $this->Model_batal->actionBatalCutiNormatif();
					}

				}else{

					$tgl_cuti = $this->input->post('tgl_cuti');

					if(empty($tgl_cuti)){
						$this->session->set_flashdata('error', 'Silahkan Cek Tanggal ');
						redirect('leaves/batal/detail_hrd/'.$no_dok,  'refresh');
					}

					$save = $this->Model_batal->actionBatalIjin();
				}

			}else{
				// tesx($cek, $_POST['keterangan_batal'], 'batal proses');
				$save = $this->Model_batal->actionBatalHrd();
			}


			if($save) {

				$this->session->set_flashdata('success', 'Batal Dokumen  "'.$save.'" Berhasil Disimpan');
				redirect('leaves/batal', 'refresh');

			} else {
				$this->session->set_flashdata('errors', 'Error occurred!!');
				redirect('leaves/batal/detail_hrd/'.$no_dok, 'refresh');
			}
		} else {

            $this->data['detailK'] 		= $this->Model_leave->getKaryawanByID($cek['nip']);

			$this->data['headerdok'] 	= $this->Model_batal->headerDok($no_dok);

			$this->data['lampiran']		= $this->Model_batal->getLampiran($no_dok);


			if($cek['jenis']=='CUTI DISPENSASI'){
				$this->data['detaildok'] = $this->Model_batal->getDetailDispensasi($cek['tdk_masuk_h_id']);
			}elseif($cek['jenis']=='CUTI PENGGANTI'){
				$this->data['detaildok'] = $this->Model_batal->getDetailPengganti($cek['tdk_masuk_h_id']);
			}else{
				$this->data['detaildok'] = $this->Model_batal->getDetailCutiIjin($cek['tdk_masuk_h_id']);
			}

			$this->data['jumlah_hari'] = count($this->data['detaildok']);

			if($cek['jenis']=='CUTI PENGGANTI'){
				$this->data['approval_data'] 	= $this->Model_leave->getDataPosting($cek['tdk_masuk_h_id']);
				$urutan_app	= $this->Model_leave->get_app_cp_detail($cek['nip']);
				foreach($urutan_app as $k => $v) {
					$result_app['urutan_app'][] = $v;
				}
				$this->data['urutan_data'] 	= $urutan_app;

			}else{
				$this->data['approval_data'] 	= $this->Model_leave->getDataPosting($cek['tdk_masuk_h_id']);
				$urutan_app	= $this->Model_leave->get_app_cuti_detail($cek['biodata_id']);
				foreach($urutan_app as $k => $v) {
					$result_app['urutan_app'][] = $v;
				}
				$this->data['urutan_data'] 	= $urutan_app;
			}

			// tesx($this->data['detaildok']);


			$this->form();
			$this->render_template('batal/detail_hrd',$this->data);

		}

	}

	/**---- feetching Data */
	public function fetchDataApproval()
	{

		$output = array('data' => array());
		$draw			= $_REQUEST['draw'];
		$length			= $_REQUEST['length'];
		$start			= $_REQUEST['start'];
		$column 		= $_REQUEST['order'][0]['column'];
		$order 			= $_REQUEST['order'][0]['dir'];

		// $search_no   	= $_REQUEST['columns'][0]['search']["value"];
		$search_no      = $this->input->post('search_no_dokumen');

		#Get Model by App
        $data 			= $this->Model_batal->getDataBatal1($search_no,$length,$start,$column,$order);
		// tesx($data);
        $data_jum 		= $this->Model_batal->getDataBatal2($search_no);
		#Get Model by App

		$output					= array();
		$output['draw']			= $draw;
		$output['recordsTotal']	= $output['recordsFiltered']= $data_jum;

		if($data){

			foreach ($data as $key => $value) {
                $buttons = '';
				if($value['status_dokumen']=='P'){
					$buttons .= '<a href="'.base_url('leaves/batal/detail_hrd/'.$value['no_dok_tdk_masuk']).'"
                        class="btn btn-warning btn-xs mb-2"><i class="iconsminds-folder-close" title="Batal"></i> Batal Proses</a>';
				}elseif($value['status_dokumen']=='C'){
					$buttons .= '<a href="'.base_url('leaves/batal/detail_hrd/'.$value['no_dok_tdk_masuk']).'"
						class="btn btn-danger btn-xs mb-2"><i class="iconsminds-folder-close" title="Batal"></i> Batal Posting</a>';
				}
                $arr_result = array(
                    $value['no_dok_tdk_masuk'],
                    $value['nip'],
                    $value['nama_lengkap'],
                    $value['tgl_dok_tdk_masuk'],
                    $value['jenis'],
                    $buttons
                );

				if($value['jenis']=='CUTI DISPENSASI'){
					$data_detail = $this->Model_batal->getDetailDispensasi($value['tdk_masuk_h_id']);
				}elseif($value['jenis']=='CUTI PENGGANTI'){
					$data_detail = $this->Model_batal->getDetailPengganti($value['tdk_masuk_h_id']);
				}else{
					$data_detail = $this->Model_batal->getDetailCutiIjin($value['tdk_masuk_h_id']);
				}

                $array_secondary = array();
                    foreach ($data_detail as $key => $row2)
                    {

						if($value['jenis']=='CUTI PENGGANTI'){
							$nama_hari = format_indo(date('D', strtotime($row2['nama_hari'])));
						}else{
							$nama_hari = $row2['nama_hari'];
						}
                        $arr_result2 = array(
                            date('d-m-Y', strtotime($row2['tgl_tdk_masuk'])),
                            $nama_hari,
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

	public function fetchDataHistory()
	{

		$output = array('data' => array());
		$draw			= $_REQUEST['draw'];
		$length			= $_REQUEST['length'];
		$start			= $_REQUEST['start'];
		$column 		= $_REQUEST['order'][0]['column'];
		$order 			= $_REQUEST['order'][0]['dir'];

		// $search_no   	= $_REQUEST['columns'][0]['search']["value"];
		$search_no      = $this->input->post('search_no_dokumen_hist');

		#Get Model by App
        $data 			= $this->Model_batal->getDataHistory1($search_no,$length,$start,$column,$order);
        $data_jum 		= $this->Model_batal->getDataHistory2($search_no);
		#Get Model by App

		$output					= array();
		$output['draw']			= $draw;
		$output['recordsTotal']	= $output['recordsFiltered']= $data_jum;

		if($data){

			foreach ($data as $key => $value) {
                $buttons = '';
                $buttons .= '<a href="'.base_url('leaves/batal/detail_hrd/'.$value['no_dok_tdk_masuk']).'"
                        class="btn btn-danger btn-xs mb-2"><i class="iconsminds-yes" title="Batal"></i> Batal</a>';

                $arr_result = array(
                    $value['no_dok_tdk_masuk'],
                    $value['nip'],
                    $value['nama_lengkap'],
                    $value['tgl_dok_tdk_masuk'],
                    $value['jenis'],
					$value['rej_komentar_2'],
                );

				if($value['jenis']=='CUTI DISPENSASI'){
					$data_detail = $this->Model_batal->getDetailDispensasi($value['tdk_masuk_h_id']);
				}elseif($value['jenis']=='CUTI PENGGANTI'){
					$data_detail = $this->Model_batal->getDetailPengganti($value['tdk_masuk_h_id']);
				}else{
					$data_detail = $this->Model_batal->getDetailCutiIjin($value['tdk_masuk_h_id']);
				}

				$array_history = array();
					foreach ($data_detail as $key => $row2)
                    {
						if($value['jenis']=='CUTI PENGGANTI'){
							$nama_hari = format_indo(date('D', strtotime($row2['nama_hari'])));
						}else{
							$nama_hari = $row2['nama_hari'];
						}
                        $arr_result3 = array(
                            $row2['tgl_tdk_masuk'],
                            $nama_hari,
                            $row2['keterangan'],
                        );
                        $array_history[] = $arr_result3;
                    }
                $arr_result['history'] =  $array_history;

                $output['data'][] = $arr_result;
			}

		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}
    /**---- END feetching Data */


	/**
	* Clears all cache from the cache directory
	*/
	public function clear_all_cache()
	{
		$CI =& get_instance();
		$path = $CI->config->item('cache_path');

		$cache_path = ($path == '') ? APPPATH.'cache/' : $path;

		$handle = opendir($cache_path);
		while (($file = readdir($handle))!== FALSE) 
		{
			//Leave the directory protection alone
			if ($file != '.htaccess' && $file != 'index.html')
			{
			@unlink($cache_path.'/'.$file);
			}
		}
		closedir($handle);       
	}

	public function test_path()
	{
		// $path = 'application/modules/leaves/controllers/file.php';
		$path = APPPATH. 'modules\leaves\controllers\file.php';
		$info = array();

		$info['title'] = 'example title';
		$info['description'] = 'description';
		$info['code'] = 'code';

		$data = json_encode($info);

		if ( ! write_file($path, $data))
		{
			echo 'Unable to write the file';

		} else {

			$txt = json_encode($data);
			file_put_contents($path, $txt.PHP_EOL , FILE_APPEND | LOCK_EX);

			write_file($path, $data);

			echo $string = read_file($path);

			$controllers = get_dir_file_info(APPPATH.'models/');

			tesx($controllers);

		}
	}

	public function test_aja()
	{
		$kets = "test , test 2 ,SAKIT";

		// $ket_list = implode(' OR ',
		// array_map(function($x) { return "FIND_IN_SET('$x', a.keterangan)"; }, explode(',', $kets)));
		$ket_list = "a.keterangan REGEXP REPLACE('".$kets."', ',', '(\\,|$)|')";
		// tesx($ket_list);

		// tesx($sql);
		// tesx(date('m-d-Y H:i:s '), time());
		$str = "tes, koma, ppapp";
		$sa = str_replace(',','',$str);
		// tesx($sa);
		// tesx($this->data['approval_data'], $urutan_app);
	}


}