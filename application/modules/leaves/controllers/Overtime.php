<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Overtime extends Admin_Controller  {
	private $hrd;
	public function __construct()
	{
		$this->data['modul'] = "Leaves";
		parent::__construct();
		$this->not_logged_in();
		$this->data['page_title'] = 'Overtime';
		$this->load->model('Model_overtime');
		$this->load->model('Model_cuti');
		$this->load->model('Model_leave');

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

	public function form()
	{
		$this->data['approval']  	= $this->Model_leave->PicApproval();
		$this->data['verifikasi']  	= $this->Model_leave->PicVerifikasiHrd();

		$docCode	='SPOT';
        $date		= date('ym');

        $nip 		= $this->session->userdata('nama_login');
        $biodata 	= $this->hrd->select('biodata_id')
                    ->get_where('hrd_all.mst_biodata',array('nip' => $nip))->row_array();
        $biodataid= $biodata['biodata_id'];
        $this->data['biodataid']	= $biodata['biodata_id'];
        $this->data['nip']	        = $nip;
		$this->data['no_doc'] 		= $this->Model_overtime->getDataNoDoc($docCode,$date);
	}


    public function index()
	{
		$this->form();
		$this->render_template('overtime/index',$this->data);
	}

	public function create()
	{
        /* Validasi */
            $this->form_validation->set_rules('no_dokumen','No Dokumen','required',
                array(	'required' 	=> 'No Dokumen Tidak Boleh Kosong !!',
            ));
            $this->form_validation->set_rules('tgl_lembur','Tgl Lembur','required',
                array(	'required' 	=> 'Tgl Lembur Tidak Boleh Kosong !!',
            ));
            $this->form_validation->set_rules('jam_in','Jam IN','required',
                array(	'required' 	=> 'Jam IN Tidak Boleh Kosong !!',
            ));
            $this->form_validation->set_rules('jam_out','Jam OUT','required',
                array(	'required' 	=> 'Jam OUT Tidak Boleh Kosong !!',
            ));
            $this->form_validation->set_rules('keterangan','Keterangan','required',
                array(	'required' 	=> 'Keterangan Tidak Boleh Kosong !!',
            ));
        /* Validasi */


		if ($this->form_validation->run() == TRUE) {

			$save = $this->Model_overtime->saveAction();

			if($save == true) {
				$this->session->set_flashdata('success', 'No Dokumen :  "'.$save.'" Berhasil Disimpan');
				redirect('leaves/overtime/index/', 'refresh');
			} else {
				$this->session->set_flashdata('errors', 'Error !!');
				redirect('leaves/overtime/create', 'refresh');
			}

		} else {
            $this->form();
            $this->render_template('overtime/create',$this->data);
        }
	}

	public function detail($no_dok)
	{
		$this->data['header'] = $this->Model_overtime->getHeader($no_dok);

		$nip 		= $this->data['header']['nip'];
        $biodata 	= $this->hrd->select('biodata_id')
                    ->get_where('hrd_all.mst_biodata',array('nip' => $nip))->row_array();

		$this->data['approval_data'] 	= $this->Model_cuti->getDataPosting($this->data['header']['no_dokumen']);
		$urutan_app						= $this->Model_cuti->urutanApp($biodata['biodata_id']);
		foreach($urutan_app as $k => $v) {
			$result_app['urutan_app'][] = $v;
		}
		$this->data['urutan_data'] 	= $this->Model_cuti->urutanApp($biodata['biodata_id']);

		$this->form();
		$this->render_template('overtime/detail',$this->data);
	}

	public function approval()
	{
		$this->form();
		$this->render_template('overtime/approval',$this->data);
	}

	public function approval_detail($no_dok)
	{

		$this->data['header'] = $this->Model_overtime->getHeader($no_dok);

		$this->form();
		$this->render_template('overtime/approval_detail',$this->data);

	}

	public function approval_action()
	{
		$no_dok = $this->input->post('no_dokumen');

		$save = $this->Model_overtime->approvalAction();

		if($save == true) {
			$this->session->set_flashdata('success', 'No Dokumen :  "'.$save.'" Berhasil Disimpan');
			redirect('leaves/overtime/approval/', 'refresh');
		} else {
			$this->session->set_flashdata('errors', 'Error !!');
			redirect('leaves/overtime/approval_detail/'.$no_dok, 'refresh');
		}

	}


	public function reject($no_dok)
	{

		$this->data['header'] = $this->Model_overtime->getHeader($no_dok);

		$this->form();
		$this->render_template('overtime/reject',$this->data);

	}

	public function reject_action()
	{
		$no_dok = $this->input->post('no_dokumen');

		$save = $this->Model_overtime->rejectAction();

		if($save == true) {
			$this->session->set_flashdata('success', 'No Dokumen :  "'.$save.'" Berhasil Disimpan');
			redirect('leaves/overtime/approval/', 'refresh');
		} else {
			$this->session->set_flashdata('errors', 'Error !!');
			redirect('leaves/overtime/reject/'.$no_dok, 'refresh');
		}

	}

    public function fetchDataOvertime()
	{
		$output = array('data' => array());

		$draw       = $_REQUEST['draw'];
		$length     = $_REQUEST['length'];
		$start      = $_REQUEST['start'];
		//$search=$_REQUEST['search']["value"];
		$column     = $_REQUEST['order'][0]['column'];
		$order 		= $_REQUEST['order'][0]['dir'];
		$search_no  = $_REQUEST['columns'][0]['search']["value"];

		$nip 		= $this->session->userdata('nama_login');
		$biodata 	= $this->hrd->select('biodata_id')
					->get_where( 'hrd_all.mst_biodata',array('nip' => $nip))->row_array();
		$no         = $biodata['biodata_id'];

		$data       = $this->Model_overtime->getDataOvertime1($nip, $search_no,$length,$start,$column,$order);
		$data_jum   = $this->Model_overtime->getDataOvertime2($nip, $search_no);

		$output     = array();
		$output['draw']         = $draw;
		$output['recordsTotal'] = $output['recordsFiltered'] = $data_jum;

		if($search_no !="" ){
			$data_jum               = $this->Model_overtime->getDataOvertime2($nip,$search_no);
			$output['recordsTotal'] = $output['recordsFiltered'] = $data_jum;
		}

		if($data){
			foreach ($data as $key => $value) {
					$buttons = '';
					$link_po = str_replace("/","_",$value['no_dokumen']);

					$buttons .= ' <a href="'.base_url('leaves/overtime/detail/'.$value['no_dokumen']).'"
					class="btn btn-primary mb-1"><i class="simple-icon-note" title="Detail"></i> Detail</a>';

					$output['data'][$key] = array(
						$value['no_dokumen'],
                        $value['nip'],
                        $value['keterangan'],
						$value['tgl_lembur'],
						$buttons
					);
			}
		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}

	public function fetchDataApproval()
	{
		$output = array('data' => array());

		$draw       = $_REQUEST['draw'];
		$length     = $_REQUEST['length'];
		$start      = $_REQUEST['start'];
		//$search=$_REQUEST['search']["value"];
		$column     = $_REQUEST['order'][0]['column'];
		$order 		= $_REQUEST['order'][0]['dir'];
		$search_no  = $_REQUEST['columns'][0]['search']["value"];

		$nip 		= $this->session->userdata('nama_login');

		$data       = $this->Model_overtime->getDataApproval1($nip, $search_no,$length,$start,$column,$order);
		$data_jum   = $this->Model_overtime->getDataApproval2($nip, $search_no);

		$output     = array();
		$output['draw']         = $draw;
		$output['recordsTotal'] = $output['recordsFiltered'] = $data_jum;

		if($search_no !="" ){
			$data_jum               = $this->Model_overtime->getDataOvertime2($nip,$search_no);
			$output['recordsTotal'] = $output['recordsFiltered'] = $data_jum;
		}

		if($data){
			foreach ($data as $key => $value) {
					$buttons 	= '';
					$link  		= str_replace("/","_",$value['no_dokumen']);

					$buttons .= ' <a href="'.base_url('leaves/overtime/approval_detail/'.$value['no_dokumen']).'"
					class="btn btn-sm btn-success mb-1"><i class="iconsminds-yes" title="Approval"></i> Approval</a>
					<br>
					<a href="'.base_url('leaves/overtime/reject/'.$value['no_dokumen']).'"
					class="btn btn-sm btn-danger mb-1"><i class="iconsminds-close" title="Reject"></i> Reject</a>
					';

					$output['data'][$key] = array(
						$value['no_dokumen'],
                        $value['nip'],
                        $value['keterangan'],
						$value['tgl_lembur'],
						$buttons
					);
			}
		}else{
			$output['data'] = [];
		}
		echo json_encode($output);
	}


	public function cek()
	{
		$this->form_validation->set_rules('jam_in','Jam IN','required',
			array(	'required' 	=> 'Jam IN Tidak Boleh Kosong !!',
		));
		if ($this->form_validation->run() == TRUE) {

			$save = $this->Model_leave->saveAbsensi();

			if($save == true) {
				$this->session->set_flashdata('success', ' Berhasil Disimpan');
				redirect('leaves/overtime/cek', 'refresh');
			} else {
				$this->session->set_flashdata('errors', 'Error !!');
				redirect('leaves/overtime/cek', 'refresh');
			}

		} else {
            $this->form();
			$this->render_template('overtime/cek',$this->data);
        }

	}



}