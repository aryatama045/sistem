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
		$this->data['pagetitle'] 	= 'PMB';
		$this->data['gel_daftar'] 	= $this->Model_pmb->getGelDaftar();
		$this->data['jenma'] 		= $this->Model_pmb->getJenma();
		$this->data['prodi'] 		= $this->Model_pmb->getProdi();
		$this->data['cek_gel'] 		= $this->Model_global->cek_gel_daftar();

	}

	public function page404()
	{
        $this->form();
		$this->render_template_pmb('pages/page404',$this->data);

    }

    public function index()
    {
		$pmb = $this->session->userdata('pmb_proses');

		if (empty($pmb)){
			$this->form();
			$this->render_template_pmb('pmb/index', $this->data);
		}else{
			$this->redirect('pmb/dashboard_pmb');
		}

    }

    public function form_daftar()
    {

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

		$username = $this->session->userdata('username');

		$getdatauser = $this->Model_pmb->getDataUsername($username);

		if (!empty($pmb)){
			$this->form();
			$this->data['no_pendaftaran'] = $getdatauser['no_pmb'];
			$this->data['get_data_pmb']   = $this->Model_pmb->getDataPendaftaran($getdatauser['no_pmb']);
			$this->data['get_dok_pmb']    = $this->Model_pmb->getDokPendaftaran($getdatauser['no_pmb']);
			$this->data['status']         = $this->data['get_data_pmb']['status_terkini'];
			$this->data['get_agama']   	  = $this->Model_global->getAgama();

			$this->render_template_pmb('pmb/dashboard', $this->data);
		}else{
			// normal flow
			$this->redirect('dashboard');
		}

	}

	public function action_biodata_diri()
	{

		$no_pmb = $_POST['no_pendaftaran'];

		$pmb	= $this->Model_pmb->getDataPendaftaran($no_pmb);

		if(!$pmb) {
			$this->session->set_flashdata('error', 'Data Gagal Disimpan!!');
			redirect('pmb/index', 'refresh');
		}

		$data_mhs = $_POST;


		// tesx($no_pmb,$data_mhs, $pmb);

		// $this->db->insert('mst_mhs', $data_mhs);

		$save_form = $this->Model_pmb->updateBiodataDiri();

		if($save_form) {
			$this->session->set_flashdata('success', 'Biodata Diri Berhasil Disimpan');
			redirect('pmb/dashboard_pmb', 'refresh');
		} else {
			$this->session->set_flashdata('error', 'Data Gagal Disimpan!!');
			redirect('pmb/dashboard_pmb', 'refresh');
		}

	}

	public function action_orang_tua()
	{

		// $data_mhs = array(
		// 	'nik' => $_POST['nik'],
		// 	'nama_mhs' => $_POST['nama_lengkap'],
		// 	'tempat_lahir' => $_POST['tempat_lahir'],
		// 	'tgl_lahir' => $_POST['tanggal_lahir'],
		// 	'agama' => $_POST['agama'],
		// 	'alamat' => $_POST['alamat'],
		// );

		// $save_form = $this->Model_pmb->saveBiodataDiri($data_mhs);
		// if($save_form) {
		// 	$this->session->set_flashdata('success', $notif);
		// 	redirect('pmb/index', 'refresh');
		// } else {
			$this->session->set_flashdata('error', 'Database belum bisa Disimpan!!');
			redirect('pmb/dashboard_pmb', 'refresh');
		// }

	}

	public function action_upload_foto()
	{
		$this->UploadFoto();
		$count_berkas 	= count($_FILES['foto_profil']['name']);

		$log_berkas 	= array();
		for($x=0; $x < $count_berkas; $x++ ){
			$data_foto = array(
				'foto_profil'	 => $_POST['no_pendaftaran'].'-'.$_FILES['foto_profil']['name'][$x],
				'status_terkini' => '4',
			);
			array_push($log_berkas, $data_foto);

			$where = array('no_pendaftaran' => $_POST['no_pendaftaran']);
			$this->db->where($where);
			$update = $this->db->update('trn_pmb',$data_foto);
		}


		if($update) {
			$this->session->set_flashdata('success', 'Upload Foto Berhasil Disimpan!!');
			redirect('pmb/dashboard_pmb', 'refresh');
		} else {
			$this->session->set_flashdata('error', 'Database belum bisa Disimpan!!');
			redirect('pmb/dashboard_pmb', 'refresh');
		}

	}

	public function action_upload_berkas()
	{
		/* Manage Image */
		$this->UploadBerkas();

		$count_berkas 	= count($_FILES['berkas']['name']);

		$log_berkas 	= array();
		for($x=0; $x < $count_berkas; $x++ ){
			$data_berkas = array(
				'no_pendaftaran' => $_POST['no_pendaftaran'],
				'nama_dok'		 => $_POST['dok'][$x],
				'dokumen'		 => $_POST['no_pendaftaran'].'-'.$x.'-'.$_FILES['berkas']['name'][$x],
				'validasi' 		 => '0',
				'ket_validasi'   => 'Belum Validasi',
				'tgl_input'		 => date('d-m-y h:i:s')
			);
			array_push($log_berkas, $data_berkas);
			$this->Model_pmb->saveUploadBerkas($data_berkas);
		}

		$update_status = array(
			'status_terkini' => '4'
		);
		$where = array('no_pendaftaran' => $_POST['no_pendaftaran']);
		$this->db->where($where);
		$update = $this->db->update('trn_pmb',$update_status);


		if($count_berkas>0) {
			$this->session->set_flashdata('success', 'Upload Berkas Berhasil Disimpan!!');
			redirect('pmb/dashboard_pmb', 'refresh');
		} else {
			$this->session->set_flashdata('error', 'Database belum bisa Disimpan!!');
			redirect('pmb/dashboard_pmb', 'refresh');
		}

	}

	public function action_pembayaran_pmb()
	{
		$this->UploadPembayaran();
		$count_berkas 	= count($_FILES['foto_bukti']['name']);

		$log_berkas 	= array();
		for($x=0; $x < $count_berkas; $x++ ){
			$data_foto = array(
				'foto_bukti'	 => $_POST['no_pendaftaran'].'-'.$_FILES['foto_bukti']['name'][$x],
				'status_terkini' => '6',
				'tgl_bayar'		 => date('d-m-y h:i:s')
			);
			array_push($log_berkas, $data_foto);

			$where = array('no_pendaftaran' => $_POST['no_pendaftaran']);
			$this->db->where($where);
			$update = $this->db->update('trn_pmb',$data_foto);
		}

		// tesx($log_berkas);


		if($update) {
			$this->session->set_flashdata('success', 'Pembayaran Berhasil Disimpan!!');
			redirect('pmb/dashboard_pmb', 'refresh');
		} else {
			$this->session->set_flashdata('error', 'Database belum bisa Disimpan!!');
			redirect('pmb/dashboard_pmb', 'refresh');
		}

	}

	public function UploadFoto()
	{
		if(!empty($_FILES['foto_profil']['name']) && count(array_filter($_FILES['foto_profil']['name'])) > 0){
			$filesCount = count($_FILES['foto_profil']['name']);

			for($i = 0; $i < $filesCount; $i++){
				$_FILES['file']['name']     	= $_POST['no_pendaftaran'].'-'.$_FILES['foto_profil']['name'][$i];
				$_FILES['file']['type']     	= $_FILES['foto_profil']['type'][$i];
				$_FILES['file']['tmp_name'] 	= $_FILES['foto_profil']['tmp_name'][$i];
				$_FILES['file']['error']     	= $_FILES['foto_profil']['error'][$i];
				$_FILES['file']['size']     	= $_FILES['foto_profil']['size'][$i];

				// File upload configuration
				$uploadPath = FCPATH. 'upload/berkas/'.$_POST['no_pendaftaran'].'/foto';
				$config['upload_path'] 		= $uploadPath;
				$config['allowed_types'] 	= 'jpg|jpeg|png';
				$config['overwrite']     	= true;
				$config['max_size']         = 1024; // 1MB
				//$config['max_width'] = '1024';
				//$config['max_height'] = '768';

				// Load and initialize upload library
				$this->load->library('upload', $config);
				$this->upload->initialize($config);

				// If username folder does not exist, create it
				if(!is_dir($config['upload_path'])) {
					mkdir($config['upload_path'], 0777, TRUE);
				}

				// Upload file
				if($this->upload->do_upload('file')){
					// Uploaded file data
					$fileData = $this->upload->data();
				}else{
					$this->session->set_flashdata('error', 'Silahkan Cek Size/Format Foto Profil Anda Kembali!!');
					redirect('pmb/dashboard_pmb', 'refresh');
				}
			}
		}
	}

	public function UploadBerkas()
	{
		if(!empty($_FILES['berkas']['name']) && count(array_filter($_FILES['berkas']['name'])) > 0){
			$filesCount = count($_FILES['berkas']['name']);

			for($i = 0; $i < $filesCount; $i++){
				$_FILES['file']['name']     	= $_POST['no_pendaftaran'].'-'.$i.'-'.$_FILES['berkas']['name'][$i];
				$_FILES['file']['type']     	= $_FILES['berkas']['type'][$i];
				$_FILES['file']['tmp_name'] 	= $_FILES['berkas']['tmp_name'][$i];
				$_FILES['file']['error']     	= $_FILES['berkas']['error'][$i];
				$_FILES['file']['size']     	= $_FILES['berkas']['size'][$i];

				// File upload configuration
				$uploadPath = FCPATH. 'upload/berkas/'.$_POST['no_pendaftaran'];
				$config['upload_path'] 		= $uploadPath;
				$config['allowed_types'] 	= 'pdf|jpg|jpeg|png|gif';
				$config['overwrite']     	= true;
				$config['max_size']         = 5024; // 1MB
				//$config['max_width'] = '1024';
				//$config['max_height'] = '768';

				// Load and initialize upload library
				$this->load->library('upload', $config);
				$this->upload->initialize($config);

				// If username folder does not exist, create it
				if(!is_dir($config['upload_path'])) {
					mkdir($config['upload_path'], 0777, TRUE);
				}

				// Upload file
				if($this->upload->do_upload('file')){
					// Uploaded file data
					$fileData = $this->upload->data();
				}else{
					$this->session->set_flashdata('error', 'Silahkan Cek Dokumen Anda Kembali!!');
					redirect('pmb/dashboard_pmb', 'refresh');
				}
			}
		}
	}

	public function UploadPembayaran()
	{
		if(!empty($_FILES['foto_bukti']['name']) && count(array_filter($_FILES['foto_bukti']['name'])) > 0){
			$filesCount = count($_FILES['foto_bukti']['name']);

			for($i = 0; $i < $filesCount; $i++){
				$_FILES['file']['name']     	= $_POST['no_pendaftaran'].'-'.$_FILES['foto_bukti']['name'][$i];
				$_FILES['file']['type']     	= $_FILES['foto_bukti']['type'][$i];
				$_FILES['file']['tmp_name'] 	= $_FILES['foto_bukti']['tmp_name'][$i];
				$_FILES['file']['error']     	= $_FILES['foto_bukti']['error'][$i];
				$_FILES['file']['size']     	= $_FILES['foto_bukti']['size'][$i];

				// File upload configuration
				$uploadPath = FCPATH. 'upload/berkas/'.$_POST['no_pendaftaran'].'/';
				$config['upload_path'] 		= $uploadPath;
				$config['allowed_types'] 	= 'jpg|jpeg|png';
				$config['overwrite']     	= true;
				$config['max_size']         = 1024; // 1MB
				//$config['max_width'] = '1024';
				//$config['max_height'] = '768';

				// Load and initialize upload library
				$this->load->library('upload', $config);
				$this->upload->initialize($config);

				// If username folder does not exist, create it
				if(!is_dir($config['upload_path'])) {
					mkdir($config['upload_path'], 0777, TRUE);
				}

				// Upload file
				if($this->upload->do_upload('file')){
					// Uploaded file data
					$fileData = $this->upload->data();
				}else{
					$this->session->set_flashdata('error', 'Silahkan Cek Size/Format Foto Profil Anda Kembali!!');
					redirect('pmb/dashboard_pmb', 'refresh');
				}
			}
		}
	}

}