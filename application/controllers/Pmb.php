<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pmb extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_pmb');
    }

	public function form()
	{
		$this->data['pagetitle'] = 'PMB';
		$this->data['gel_daftar'] 	= $this->Model_pmb->getGelDaftar();
		$this->data['jenma'] 		= $this->Model_pmb->getJenma();
		$this->data['prodi'] 		= $this->Model_pmb->getProdi();
	}

    public function index()
    {
		$pmb = $this->session->userdata('pmb_proses');
		// tesx($pmb);

		if (empty($pmb)){
			$this->form();
			$this->render_template_pmb('pmb/index', $this->data);
		}else{
			$this->redirect('pmb/dashboard_pmb');
		}

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

		$time 			=  new DateTime();
		$date 			= $time->format('Y-m-d H:i:s');
		$gel_daftar		= $this->Model_pmb->getGelDaftar();

		$dataCama  = array(
            'no_pendaftaran'=> $this->Model_pmb->getDataNoDoc(),
			'nama' 			=> $_POST['nama'],
			'nik'	        => $_POST['nik'],
            'no_hp'         => $_POST['no_hp'],
            'email'         => $_POST['email'],
            'tahun_lulus'   => $_POST['tahun_lulus'],
			'kd_prog' 		=> $_POST['kd_prog'],
			'kd_jenma' 		=> $_POST['kd_jenma'],
			'kd_gel' 		=> $gel_daftar['kode'],
			'tgl_input' 	=> $date,

		);

		$prodi 		= $this->Model_pmb->getProdi($_POST['kd_prog']);
		$jenma 		= $this->Model_pmb->getJenma($_POST['kd_jenma']);
		$notif ='
		<div class="d-flex align-items-left flex-column mb-4">
			<div class="d-flex align-items-left flex-column">
				<div class="h4 mb-0"> NAMA LENGKAP : '. capital($_POST['nama']) .' </div>
				<div class="h4 mb-0"> NIK : '.$_POST['nik'].' </div>
				<div class="h4 mb-0"> EMAIL : '.$_POST['email'].' </div>
				<div class="text-muted"> GELOMBANG : '.$gel_daftar['gel'].' </div>
				<div class="text-muted"> PRODI : '.$prodi['nama_prog'].'</div>
				<div class="text-muted"> SISTEM KULIAH : '.$jenma['jenis_mhs'].' </div>
			</div>
        </div>';

        $save_form = $this->Model_pmb->saveCama($dataCama);
		if($save_form) {
			$this->session->set_flashdata('success', $notif);
			redirect('pmb/index', 'refresh');
		} else {
			$this->session->set_flashdata('error', 'Data Gagal Disimpan!!');
			redirect('pmb/index', 'refresh');
		}

    }


	public function dashboard_pmb()
	{
		$this->auth->route_access();

		$pmb = $this->session->userdata('pmb_proses');
		// tesx($pmb);

		if (!empty($pmb)){
			$this->form();
			$this->render_template_pmb('pmb/dashboard', $this->data);
		}else{
			// normal flow
			$this->redirect('dashboard');
		}

	}

	public function biodata()
	{
		$this->form();
		$this->render_template_pmb('pmb/biodata', $this->data);
	}

	public function page404()
	{
        $this->form();
		$this->render_template_pmb('pages/page404',$this->data);

    }

}