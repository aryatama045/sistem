<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawan extends Admin_Controller  {
	private $hrd;
	public function __construct()
	{
		parent::__construct();
		$this->not_logged_in();
		$this->data['page_title'] = 'Karyawan';
		$this->load->model('leaves/Model_report');
		$this->load->model('leaves/Model_cuti');
		$this->load->model('leaves/Model_leave');

        $this->load->model('Model_karyawan');
	}

	public function form()
	{
		$this->data['approval']  	= $this->Model_leave->PicApproval();
		$this->data['verifikasi']  	= $this->Model_leave->PicVerifikasiHrd();
		$this->data['nm_divisi'] 	= $this->Model_report->getDataDivisi()->result();


	}

    public function index()
	{
		$this->form();
		$this->render_template('karyawan/index',$this->data);
	}

	public function detail($nip)
	{
		$this->data['biodata']  	= $this->Model_karyawan->getBiodata($nip);
		$biodataid					= $this->data['biodata']['biodata_id'];
		if(empty($biodataid)||$biodataid==""||$biodataid==NULL){
			// $this->session->set_flashdata('error', 'Data Karyawan tidak ada!!');
			redirect('user/karyawan', 'refresh');
		}
		$this->form();
		$this->data['keluarga']  	= $this->Model_karyawan->getKeluarga($biodataid);
		$this->data['pendidikan']  	= $this->Model_karyawan->getPendidikan($biodataid);
		$this->data['pengalaman']  	= $this->Model_karyawan->getPengalaman($biodataid);
		$this->data['kepemilikan']  = $this->Model_karyawan->getKepemilikan($biodataid);
		$this->data['dokumen']  	= $this->Model_karyawan->getDokumen($biodataid);
		$this->data['dataot']  		= $this->Model_karyawan->getDataOt($biodataid);
		$this->data['surat']  		= $this->Model_karyawan->getSurat($biodataid);

		$this->data['saldo_normatif']  		= $this->Model_karyawan->saldoNormatif($biodataid);
		$this->data['saldo_tambahan']  		= $this->Model_karyawan->saldoTambahan($biodataid);


		$this->render_template('karyawan/detail',$this->data);
	}

	public function fetchDataKaryawan()
	{

		$draw           = $_REQUEST['draw'];
		$length         = $_REQUEST['length'];
		$start          = $_REQUEST['start'];
		$column 		= $_REQUEST['order'][0]['column'];
		$order 			= $_REQUEST['order'][0]['dir'];
		// $search_no   	= $_REQUEST['columns'][0]['search']["value"];

        $output['data']	= array();
		$search_no      = $this->input->post('nip');
        $search_nama    = $this->input->post('nama_lengkap');
		$divisi      	= $this->input->post('id_divisi');
        $dept		    = $this->input->post('id_dept');
		$store		    = $this->input->post('kd_store');

		$data           = $this->Model_karyawan->getListKaryawan1($search_no,$search_nama,$divisi,$dept,$store,$length,$start,$column,$order);
		$data_jum       = $this->Model_karyawan->getListKaryawan2($search_no,$search_nama,$divisi,$dept,$store);
        $output=array();

		$output['draw']=$draw;
		$output['recordsTotal']=$output['recordsFiltered']=$data_jum;

		if($search_no !="" || $search_nama !="" ){
			$data_jum = $this->Model_karyawan->getListKaryawan2($search_no,$search_nama,$divisi,$dept,$store);
			$output['recordsTotal']=$output['recordsFiltered']=$data_jum;
		}

		if($data){
			foreach ($data as $key => $value) {
				$btn = '';
				$btn .= '<a href="'.base_url('user/karyawan/detail/'.$value['nip']).'"
						class="btn btn-primary btn-sm btn-shadow">
                        <i class="iconsminds-magnifi-glass" ></i> Detail</a>';
				$output['data'][$key] = array(
					$value['nip'],
					$value['nama_lengkap'],
					$value['kode_divisi'],
                    $value['nama_dept'],
                    $value['kd_store'],
					$btn,
				);
			}

		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}



}