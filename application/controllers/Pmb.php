<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pmb extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_pmb');
    }

    public function index()
    {
        $this->render_template_pmb('pmb/index');
    }

    public function form_daftar()
    {

        // $nik 	= $_POST['nik'];
		// $cekCama	= $this->Model_pmb->getDataCama($nik);
		// tesx($cekCama);

		// if(empty($cekCama) || $cekCama == NULL || $cekCama == ""){
		// 	$saveCama 	= $this->Model_pmb->saveCama($nik);
		// 	if($saveCama == false) {
		// 		$this->session->set_flashdata('error', 'Data Gagal Disimpan!!');
		// 		redirect('pmb/index', 'refresh');
		// 	}
		// }

        $save_form = $this->Model_pmb->saveCama();
		if($save_form) {
			$this->session->set_flashdata('success', ' Data Berhasil Disimpan');
			redirect('pmb/index', 'refresh');
			// redirect(''. $_SERVER['HTTP_REFERER']);
		} else {
			$this->session->set_flashdata('error', 'Data Gagal Disimpan!!');
			redirect('pmb/index', 'refresh');
		}

    }


}