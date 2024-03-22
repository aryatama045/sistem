<?php

class Model_approve extends CI_Model
{
	private $hrd;
	function __construct()
	{
		parent::__construct();
		$this->hrd = $this->load->database('hrd',TRUE);
		$this->hrdsave = $this->load->database('hrd_save',TRUE);
		$this->hrd_web_master = $this->load->database('hrd_web_master',TRUE);
		$this->load->model('leaves/Model_leave', 'Model_leave');
	}

	# ------ Datatables ------
		public function getListApprove1($kd_store,$karyawan,$search_no = "", $length = "", $start = "", $column = "", $order = "")
		{


			$this->hrd->select('e.biodata_id,e.nip, e.nama_lengkap,
			c.biodata_id id_app,c.nip nip_app,c.nama_lengkap nama_app, urutan_approval, f.email,
			g.kd_store, g.dept_id, g.divisi_id, g.jabatan_id');
			$this->hrd->from('hrd_web_master.mst_user_approval_detail a');
			$this->hrd->join('hrd_web_master.mst_karyawan_01 b','a.karyawan_id=b.karyawan_id');
			$this->hrd->join('hrd_all.mst_biodata c','b.biodata=c.biodata_id');
			$this->hrd->join('hrd_web_master.mst_karyawan_01 d','a.approved_user=d.karyawan_id');
			$this->hrd->join('hrd_all.mst_biodata e','d.biodata=e.biodata_id');
			$this->hrd->join('hrd_web_master.mst_pic_app f','c.nip = f.nip');
			$this->hrd->join('hrd_all.biodata_pekerjaan_d g','e.biodata_id=g.biodata_id');
			$this->hrd->where('e.biodata_id',$karyawan);

			if($kd_store !="") $this->hrd->where('kd_store',$kd_store);

			if($column == 0){
				$this->hrd->order_by('urutan_approval', $order);
			}
			$this->hrd->limit($length,$start);
			$query=$this->hrd->get();
			// die(nl2br($this->hrd->last_query()));
			return $query->result_array();
		}

		public function getListApprove2($kd_store,$karyawan)
		{


			$this->hrd->select('e.biodata_id,e.nip, e.nama_lengkap,
			c.biodata_id id_app,c.nip nip_app,c.nama_lengkap nama_app, urutan_approval, f.email,
			g.kd_store, g.dept_id, g.divisi_id, g.jabatan_id');
			$this->hrd->from('hrd_web_master.mst_user_approval_detail a');
			$this->hrd->join('hrd_web_master.mst_karyawan_01 b','a.karyawan_id=b.karyawan_id');
			$this->hrd->join('hrd_all.mst_biodata c','b.biodata=c.biodata_id');
			$this->hrd->join('hrd_web_master.mst_karyawan_01 d','a.approved_user=d.karyawan_id');
			$this->hrd->join('hrd_all.mst_biodata e','d.biodata=e.biodata_id');
			$this->hrd->join('hrd_web_master.mst_pic_app f','c.nip = f.nip');
			$this->hrd->join('hrd_all.biodata_pekerjaan_d g','e.biodata_id=g.biodata_id');
			$this->hrd->where('e.biodata_id',$karyawan);
			if($kd_store !="") $this->hrd->where('kd_store',$kd_store);

			$this->hrd->order_by('urutan_approval', 'DESC');
			$jum=$this->hrd->get();
			return $jum->num_rows();
		}

		public function getListApproveCP1($kd_store,$karyawan,$search_no = "", $length = "", $start = "", $column = "", $order = "")
		{

			$this->hrd->select('a.nip_approval nip_app, b.nama_lengkap nama_app,
			a.nip_user, c.nama_lengkap nama_user, a.urutan_app, a.email,g.kd_store,
			b.biodata_id biodata_app, c.biodata_id biodata_user');
			$this->hrd->from('hrd_all.trn_app_cp a');
			$this->hrd->join('hrd_all.mst_biodata b','a.nip_approval = b.nip');
			$this->hrd->join('hrd_all.mst_biodata c','a.nip_user = c.nip');
			$this->hrd->join('hrd_all.biodata_pekerjaan_d g','c.biodata_id = g.biodata_id');

			$this->hrd->where('c.biodata_id',$karyawan);

			if($kd_store !="") $this->hrd->where('g.kd_store',$kd_store);

			if($column == 0){
				$this->hrd->order_by('a.urutan_app', $order);
			}
			$this->hrd->limit($length,$start);
			$query=$this->hrd->get();
			// die(nl2br($this->hrd->last_query()));
			return $query->result_array();
		}

		public function getListApproveCP2($kd_store,$karyawan)
		{


			$this->hrd->select('a.nip_approval nip_app, b.nama_lengkap nama_app,
			a.nip_user, c.nama_lengkap nama_user, a.urutan_app, a.email,g.kd_store,
			b.biodata_id biodata_app, c.biodata_id biodata_user');
			$this->hrd->from('hrd_all.trn_app_cp a');
			$this->hrd->join('hrd_all.mst_biodata b','a.nip_approval = b.nip');
			$this->hrd->join('hrd_all.mst_biodata c','a.nip_user = c.nip');
			$this->hrd->join('hrd_all.biodata_pekerjaan_d g','c.biodata_id = g.biodata_id');

			$this->hrd->where('c.biodata_id',$karyawan);
			if($kd_store !="") $this->hrd->where('g.kd_store',$kd_store);


			$this->hrd->order_by('a.urutan_app', 'DESC');
			$jum=$this->hrd->get();
			return $jum->num_rows();
		}
	# ------ Datatables ------

	public function getDataKaryawan(){
		$nip = $this->session->userdata('nama_login');
		$getDept = $this->Model_leave->getDataKaryawan($nip);

		$dept_id	= $getDept['dept_id'];

		$where_dept_id = "";
		if($nip =='21020010' || $nip =='01101027'|| $nip =='10071433' || $nip =='12060003'){
			$where_dept_id = "";
		}else{
			if(!empty($dept_id) || $dept_id != "" || $dept_id != NULL){
				$where_dept_id = "AND c.dept_id= $dept_id";
			}
		}

		$sql = "SELECT b.biodata_id,b.nip, nama_lengkap,
				c.dept_id , d.nama_dept, e.divisi_id,e.nama_divisi
				FROM hrd_web_master.mst_karyawan_01 a
				LEFT JOIN hrd_all.mst_biodata b ON a.biodata = b.biodata_id
				LEFT JOIN hrd_all.biodata_pekerjaan_d c ON b.biodata_id=c.biodata_id
				LEFT JOIN hrd_all.mst_dept d ON c.dept_id = d.dept_id
				LEFT JOIN hrd_all.mst_divisi e ON c.divisi_id = e.divisi_id
				WHERE b.aktif = 1 $where_dept_id
				ORDER BY nama_lengkap ASC
				";
		$query 	= $this->hrd->query($sql);
		// die(nl2br($this->hrd->last_query()));
		return 	$query->result();
	}

	public function SelectKaryawan($start,$length){
		$sql = "SELECT a.biodata_id,nip,nama_lengkap,kd_store,dept_id,divisi_id,jabatan_id
                FROM hrd_all.mst_biodata a
                LEFT JOIN hrd_all.biodata_pekerjaan_d b ON a.biodata_id=b.biodata_id
                ORDER BY nama_lengkap ASC
				-- LIMIT $start,$length
		";

		$query = $this->hrd->query($sql);
		// die(nl2br($this->hrd->last_query()));
		return $query->result_array();
	}

	public function getDataKaryawanId($biodata_id){
		$sql = "SELECT
				a.biodata_id,nip,nama_lengkap,kd_store,g.hash dept, h.hash divisi, f.hash jabatan,
				b.dept_id,b.divisi_id,e.nama_divisi,b.jabatan_id, c.nama_jabatan,c.gol_level,d.nama_dept, c.kode_jabatan
				FROM hrd_all.mst_biodata a
				LEFT JOIN hrd_all.biodata_pekerjaan_d b ON a.biodata_id=b.biodata_id
				LEFT JOIN hrd_all.mst_jabatan c ON b.jabatan_id = c.jabatan_id
				LEFT JOIN hrd_all.mst_dept d ON b.dept_id = d.dept_id
				LEFT JOIN hrd_all.mst_divisi e ON b.divisi_id=e.divisi_id

				LEFT JOIN hrd_web_master.mst_jabatan f ON c.kode_jabatan = f.kode
				LEFT JOIN hrd_web_master.mst_departemen g ON d.kode_dept = g.kode
				LEFT JOIN hrd_web_master.mst_divisi h ON e.kode_divisi = h.kode
				WHERE a.biodata_id='".$biodata_id."'";
		$query 	= $this->hrd->query($sql);
		// die(nl2br($this->hrd->last_query()));
		return 	$query->row_array();
	}

	public function getDataKaryawan01($biodata_id){
		$sql = "SELECT * FROM hrd_web_master.mst_karyawan_01
				WHERE biodata='".$biodata_id."'
				";
		$query 	= $this->hrd->query($sql);
		// die(nl2br($this->hrd->last_query()));
		return 	$query->row_array();
	}

	public function getUserApprovalDetail($approved_user,$urut){
		$sql = "SELECT * FROM hrd_web_master.mst_user_approval_detail
				WHERE approved_user='$approved_user' AND urutan_approval='$urut'
				";
		$query 	= $this->hrd->query($sql);
		// die(nl2br($this->hrd->last_query()));
		return 	$query->row_array();
	}

	public function getPicApprove(){
		$sql = "SELECT * FROM hrd_web_master.mst_pic_app ORDER BY nama_lengkap ASC";
		$query 	= $this->hrd->query($sql);
		return 	$query->result();

	}

	public function getDataPicNip($biodata_id){
		$this->hrd->select('*')
		->from('hrd_web_master.mst_pic_app')
		->where('biodata_id', $biodata_id);
		$query 	= $this->hrd->get();
		return 	$query->row_array();
	}

	public function getPicApproveSearch($name, $column){
		// $sql = "SELECT * FROM hrd_web_master.mst_pic_app ORDER BY nama_lengkap ASC";

		$this->hrd->select('*')
		// ->limit(10)
		->from('hrd_web_master.mst_pic_app')
		->like('nama_lengkap', $name)
		->order_by('nama_lengkap', 'ASC');
		$query 	= $this->hrd->get();
		return 	$query->result();

	}

	public function getDataPicApp($biodata_id,$id_app){

		$this->hrd->select('e.biodata_id, e.nip, e.nama_lengkap, d.karyawan_id k_user,
		c.biodata_id id_app, c.nip nip_app,c.nama_lengkap nama_app,b.karyawan_id k_pic,
		urutan_approval, f.email, g.kd_store, g.dept_id, g.divisi_id, g.jabatan_id');
		$this->hrd->from('hrd_web_master.mst_user_approval_detail a');
		$this->hrd->join('hrd_web_master.mst_karyawan_01 b','a.karyawan_id=b.karyawan_id');
		$this->hrd->join('hrd_all.mst_biodata c','b.biodata=c.biodata_id');
		$this->hrd->join('hrd_web_master.mst_karyawan_01 d','a.approved_user=d.karyawan_id');
		$this->hrd->join('hrd_all.mst_biodata e','d.biodata=e.biodata_id');
		$this->hrd->join('hrd_web_master.mst_pic_app f','c.nip = f.nip');
		$this->hrd->join('hrd_all.biodata_pekerjaan_d g','e.biodata_id=g.biodata_id');
		$this->hrd->where('e.biodata_id',$biodata_id);
		$this->hrd->where('c.biodata_id',$id_app);

		$query=$this->hrd->get();
		// die(nl2br($this->hrd->last_query()));
		return 	$query->row_array();
	}

	public function getPicAppOld($biodata_id)
	{

		$this->hrd->select('e.biodata_id, e.nip, e.nama_lengkap, d.karyawan_id k_user,
		c.biodata_id id_app, c.nip nip_app,c.nama_lengkap nama_app,b.karyawan_id k_pic,
		urutan_approval, f.email, g.kd_store, g.dept_id, g.divisi_id, g.jabatan_id');
		$this->hrd->from('hrd_web_master.mst_user_approval_detail a');
		$this->hrd->join('hrd_web_master.mst_karyawan_01 b','a.karyawan_id=b.karyawan_id');
		$this->hrd->join('hrd_all.mst_biodata c','b.biodata=c.biodata_id');
		$this->hrd->join('hrd_web_master.mst_karyawan_01 d','a.approved_user=d.karyawan_id');
		$this->hrd->join('hrd_all.mst_biodata e','d.biodata=e.biodata_id');
		$this->hrd->join('hrd_web_master.mst_pic_app f','c.nip = f.nip');
		$this->hrd->join('hrd_all.biodata_pekerjaan_d g','e.biodata_id=g.biodata_id');
		$this->hrd->where('e.biodata_id',$biodata_id);
		// $this->hrd->where('urutan_approval',$id_app);

		$query=$this->hrd->get();
		// die(nl2br($this->hrd->last_query()));
		return 	$query->row_array();
	}

	public function getPicAppOldUrutan($biodata_id,$id_app){

		$this->hrd->select('e.biodata_id, e.nip, e.nama_lengkap, d.karyawan_id k_user,
		c.biodata_id id_app, c.nip nip_app,c.nama_lengkap nama_app,b.karyawan_id k_pic,
		urutan_approval, f.email, g.kd_store, g.dept_id, g.divisi_id, g.jabatan_id');
		$this->hrd->from('hrd_web_master.mst_user_approval_detail a');
		$this->hrd->join('hrd_web_master.mst_karyawan_01 b','a.karyawan_id=b.karyawan_id');
		$this->hrd->join('hrd_all.mst_biodata c','b.biodata=c.biodata_id');
		$this->hrd->join('hrd_web_master.mst_karyawan_01 d','a.approved_user=d.karyawan_id');
		$this->hrd->join('hrd_all.mst_biodata e','d.biodata=e.biodata_id');
		$this->hrd->join('hrd_web_master.mst_pic_app f','c.nip = f.nip');
		$this->hrd->join('hrd_all.biodata_pekerjaan_d g','e.biodata_id=g.biodata_id');
		$this->hrd->where('e.biodata_id',$biodata_id);
		$this->hrd->where('urutan_approval',$id_app);

		$query=$this->hrd->get();
		// die(nl2br($this->hrd->last_query()));
		return 	$query->row_array();
	}

	# Get Data CUTI CP
	public function getPicAppOldCP($biodata_id){
		$this->hrd->select('a.nip_approval nip_app, b.nama_lengkap nama_app,
		a.nip_user, c.nama_lengkap nama_user, a.urutan_app, a.email,g.kd_store,
		b.biodata_id biodata_app, c.biodata_id biodata_user');
		$this->hrd->from('hrd_all.trn_app_cp a');
		$this->hrd->join('hrd_all.mst_biodata b','a.nip_approval = b.nip');
		$this->hrd->join('hrd_all.mst_biodata c','a.nip_user = c.nip');
		$this->hrd->join('hrd_all.biodata_pekerjaan_d g','c.biodata_id = g.biodata_id');
		$this->hrd->where('c.biodata_id',$biodata_id);
		$query=$this->hrd->get();
		// die(nl2br($this->hrd->last_query()));
		return $query->result_array();
	}

	public function getUserApprovalCp($nip_user,$urutan){
		$sql = "SELECT a.nip_approval nip_app, b.nama_lengkap nama_app, a.nip_user,
			c.nama_lengkap nama_user, a.urutan_app, a.email
			FROM hrd_all.trn_app_cp a
			LEFT JOIN hrd_all.mst_biodata b ON a.nip_approval = b.nip
			LEFT JOIN hrd_all.mst_biodata c ON a.nip_user = c.nip
			WHERE a.nip_user = '$nip_user'
			AND a.urutan_app = '$urutan'
		";
		$query = $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return 	$query->row_array();
	}

	public function getDataPicAppCP($biodata_id,$id_app){

		$sql = "SELECT a.nip_approval nip_app, b.nama_lengkap nama_app, a.nip_user,
			c.nama_lengkap nama_user, a.urutan_app, a.email, c.biodata_id
			FROM hrd_all.trn_app_cp a
			LEFT JOIN hrd_all.mst_biodata b ON a.nip_approval = b.nip
			LEFT JOIN hrd_all.mst_biodata c ON a.nip_user = c.nip
			WHERE b.biodata_id = '$id_app'
			AND c.biodata_id = '$biodata_id'
		";
		$query = $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return 	$query->row_array();

	}

	# ------ Data Pic Approval
	public function cekPicApp($karyawanid, $biodataid){
		$sql = "SELECT a.*, b.*, c.* FROM hrd_web_master.mst_pic_app a
		LEFT JOIN hrd_web_master.mst_karyawan_01 b ON a.nip = b.nip
		LEFT JOIN hrd_web_master.mst_user_approval c ON b.karyawan_id = c.karyawan_id
		WHERE a.biodata_id = '$biodataid'
		";
		$query 	= $this->hrd->query($sql);
		// die(nl2br($this->hrd->last_query()));
		return 	$query->row_array();
	}

	public function savePicApp($biodataid){
		$getDataPic 	= $this->getDataKaryawanId($biodataid);
		$getDataPic2 	= $this->getDataKaryawan01($biodataid);

		$dataMstPic  = array(
			'nip' 			=> $getDataPic['nip'],
			'biodata_id'	=> $getDataPic['biodata_id'],
			'nama_lengkap'	=> $getDataPic['nama_lengkap'],
			'jabatan_id'	=> $getDataPic['jabatan_id'],
			'nama_jabatan'	=> $getDataPic['nama_jabatan'],
			'dept_id'		=> $getDataPic['dept_id'],
			'nama_dept'		=> $getDataPic['nama_dept'],
			'divisi_id'		=> $getDataPic['divisi_id'],
			'nama_divisi'	=> $getDataPic['nama_divisi'],
			'kd_store'		=> $getDataPic2['kd_store'],
			'gol_level' 	=> $getDataPic['gol_level'],
			'email' 		=> $this->input->post('email_pic')
		);

		$dataMstUserApp  = array(
			'karyawan_id'	=> $getDataPic2['karyawan_id'],
			'divisi_id'		=> $getDataPic2['divisi'],
			'dept_id'		=> $getDataPic2['departemen'],
			'jabatan_id'	=> $getDataPic2['jabatan'],
			'group_approval'=> '1',
			'status'		=> '1'

		);

		$insert = $this->hrd->insert('hrd_web_master.mst_pic_app', $dataMstPic);
		$insert = $this->hrd->insert('hrd_web_master.mst_user_approval', $dataMstUserApp);

		return ($insert)?true:false;
	}




	# ------ Action CUTI ------

		/* Simpan	*/
		public function saveKaryawan($biodata_id)
		{
			$DataKaryawan	= $this->getDataKaryawanId($biodata_id);
			$data_karyawan = array(
				'karyawan_id'	=> $this->uuid->v4(),
				'biodata'		=> $DataKaryawan['biodata_id'],
				'nip'			=> $DataKaryawan['nip'],
				'jabatan'		=> $DataKaryawan['jabatan'],
				'divisi'		=> $DataKaryawan['divisi'],
				'departemen'	=> $DataKaryawan['dept'],
				'kd_store'		=> $DataKaryawan['kd_store'],
			);
			$insert = $this->hrd->insert('hrd_web_master.mst_karyawan_01', $data_karyawan);

			return ($insert)?true:false;
		}

		public function saveAction($biodata_id)
		{
			$UserBio		= $this->getDataKaryawanId($biodata_id);
			$DataKaryawan	= $this->getDataKaryawan01($biodata_id);
			$cekKaryawan	= $this->getDataKaryawan01($biodata_id);
			$approved_user 	= $cekKaryawan['karyawan_id'];

			// tesx($DataKaryawan,$approved_user);
			$listappold		= $this->getPicAppOld($biodata_id);

			# ------------- Data Log -------------
			$log_detail_old = array();
			for($x = 1; $x <= 3; $x++) {

				$listappoldurutan		= $this->getPicAppOldUrutan($biodata_id, $x);
				$items_log_old = array(
					'oldapp'.$x.'' => $listappoldurutan['nip_app'],
				);
				array_push($log_detail_old, $items_log_old);
				// $oldapp.$listappold['urutan_approval'] = $listappoldurutan['nip_app'];

			}

			# ------------- Data OLD App Log -------------
				$oldapp1 = $log_detail_old['0']['oldapp1'];
				$oldapp2 = $log_detail_old['1']['oldapp2'];
				$oldapp3 = $log_detail_old['2']['oldapp3'];
			# ------------- Data OLD App Log -------------

			$log_detail 	= array();
			$log_detail_cp 	= array();
			$log_new_pic 	= array();
			$arrayPic = $this->input->post('pic_approve');
			$count_pic = count(array_filter($arrayPic, function($x) { return !empty($x); }));
			$no_urut=1;
			$no_urut_cp=1;
			for($x = 0; $x < $count_pic; $x++) {
				$PicBiodata = $this->input->post('pic_approve')[$x];
				$dataPic = $this->getDataKaryawan01($PicBiodata);

				// tesx($dataPic);

				$items = array(
					'karyawan_id' 		=> $dataPic['karyawan_id'],
					'approved_user'		=> $DataKaryawan['karyawan_id'],
					'divisi_user'		=> $DataKaryawan['divisi'],
					'dept_user'			=> $DataKaryawan['departemen'],
					'status'			=> 1,
					'urutan_approval'	=> $no_urut++,
				);
				array_push($log_detail,$items);

				$new_pic= array(
					'nip' 		=> $dataPic['nip'],
				);
				array_push($log_new_pic,$new_pic);

				$items_cp = array(
					'nip_approval' 		=> $dataPic['nip'],
					'nip_user'			=> $DataKaryawan['nip'],
					'jenis'				=> 'CP',
					'urutan_app'		=> $no_urut_cp++,
				);
				array_push($log_detail_cp,$items_cp);

				#Get Id Approval
				$app_id 	= $items['approved_user'];
				$urutan		= $items['urutan_approval'];
				$nip_user 	= $items_cp['nip_user'];
				$nip_app	= $items_cp['nip_approval'];
				$urutan_cp	= $items_cp['urutan_app'];

				#Get Data Approval Cuti & Cp
				$dataUser 	= $this->getUserApprovalDetail($app_id, $urutan);
				$dataCp 	= $this->getUserApprovalCp($nip_user,$urutan_cp);
				// tesx($dataUser);

				#insert || Update data approval cuti
				if(empty($dataUser) || $dataUser == NULL || $dataUser == "")
				{
					$this->hrd->insert('hrd_web_master.mst_user_approval_detail', $items);
				}else{

					$this->hrd->set($items);
					$this->hrd->where('approved_user', $app_id);
					$this->hrd->where('urutan_approval', $urutan);
					$this->hrd->update('hrd_web_master.mst_user_approval_detail');
				}

				$cek_cp = $this->input->post('data_cp');
				if(!empty($cek_cp)){
					#insert || Update data approval cp
					if(empty($dataCp) || $dataCp == NULL || $dataCp == "")
					{
						$insert = $this->hrd->insert('hrd_all.trn_app_cp', $items_cp);
					}else{
						$this->hrd->set($items_cp);
						$this->hrd->where('nip_user', $nip_user);
						$this->hrd->where('urutan_app', $urutan_cp);
						$insert =  $this->hrd->update('hrd_all.trn_app_cp');
					}
				}

			}


			# ------------- Data NEW App Log -------------
				$newapp1 = !empty($log_new_pic['0']['nip'])?$log_new_pic['0']['nip']:'';
				$newapp2 = !empty($log_new_pic['1']['nip'])?$log_new_pic['1']['nip']:'';
				$newapp3 = !empty($log_new_pic['2']['nip'])?$log_new_pic['2']['nip']:'';
			# ------------- Data NEW App Log -------------

			$dataApp = "App-CUTI : $oldapp1,$oldapp2,$oldapp3,$newapp1,$newapp2,$newapp3";
			$log_app = array(
				'nip' 			=> $DataKaryawan['nip'],
				'data_edit'		=> $dataApp,
				'pic_edit'		=> $this->session->userdata('nama_login'),
				'date_edit'		=> date('Y-m-d H:i:s'),
			);
			$this->hrd->insert('hrd_all.log_app', $log_app);

			$cek_cp = $this->input->post('data_cp');
			if(!empty($cek_cp)){
				$dataAppCp = "App-CP : $oldapp1,$oldapp2,$oldapp3,$newapp1,$newapp2,$newapp3";
				$log_app_cp = array(
					'nip' 			=> $DataKaryawan['nip'],
					'data_edit'		=> $dataAppCp,
					'pic_edit'		=> $this->session->userdata('nama_login'),
					'date_edit'		=> date('Y-m-d H:i:s'),
				);
				$this->hrd->insert('hrd_all.log_app', $log_app_cp);
			}
			// tesx($log_detail);

			$saveaction        = $DataKaryawan['nip'].'-'. $UserBio['nama_lengkap'];
			return ($saveaction ) ? $saveaction : FALSE;

		}

		function editAction()
		{

			$biodata_id 	= $this->input->post('biodata_karyawan');
			$DataKaryawan	= $this->getDataKaryawanId($biodata_id);
			$dKaryawan01	= $this->getDataKaryawan01($biodata_id);
			$PicBiodata 	= $this->input->post('pic_approve');
			$dataPic 		= $this->getDataKaryawan01($PicBiodata);
			$urutan			= $this->input->post('app_urutan');


			$listappold		= $this->getPicAppOld($biodata_id);

			# ------------- Data Log -------------
			$log_detail_old = array();
			for($x = 1; $x <= 3; $x++) {

				$listappoldurutan		= $this->getPicAppOldUrutan($biodata_id, $x);
				$items_log_old = array(
					'oldapp'.$x.'' => $listappoldurutan['nip_app'],
				);
				array_push($log_detail_old, $items_log_old);
				// $oldapp.$listappold['urutan_approval'] = $listappoldurutan['nip_app'];

			}

			# ------------- Data OLD App Log -------------
				$oldapp1 = $log_detail_old['0']['oldapp1'];
				$oldapp2 = $log_detail_old['1']['oldapp2'];
				$oldapp3 = $log_detail_old['2']['oldapp3'];
			# ------------- Data OLD App Log -------------

			# ------------- Data new App Log -------------
				if($urutan == '1'){
					$newapp1 = $dataPic['nip'];
				} else { $newapp1 = $oldapp1; }

				if($urutan == '2'){
					$newapp2 = $dataPic['nip'];
				} else { $newapp2 = $oldapp2; }

				if($urutan == '3'){
					$newapp3 = $dataPic['nip'];
				} else { $newapp3 = $oldapp3; }
			# ------------- Data new App Log -------------


			$dataApp = "App-CUTI : $oldapp1,$oldapp2,$oldapp3,$newapp1,$newapp2,$newapp3";

			$log_app = array(
				'nip' 			=> $DataKaryawan['nip'],
				'data_edit'		=> $dataApp,
				'pic_edit'		=> $this->session->userdata('nama_login'),
				'date_edit'		=> date('Y-m-d H:i:s'),
			);
			$this->hrd->insert('hrd_all.log_app', $log_app);


			$items = array(

				'karyawan_id' 		=> $dataPic['karyawan_id'],
				'approved_user'		=> $dKaryawan01['karyawan_id'],
				'divisi_user'		=> $DataKaryawan['divisi'],
				'dept_user'			=> $DataKaryawan['dept'],
				'status'			=> '1',
				'urutan_approval'	=> $urutan,
			);

			#Get Data Approval Cuti & Cp
			$dataUser 	= $this->getUserApprovalDetail($items['approved_user'], $urutan);

			#insert || Update data approval cuti
			// if(empty($dataUser) || $dataUser == NULL || $dataUser == "")
			// {
			// 	$this->hrd->insert('hrd_web_master.mst_user_approval_detail', $items);
			// }else{
				$this->hrd->set($items);
				// $this->hrd->where('karyawan_id', $items['karyawan_id']);
				$this->hrd->where('approved_user', $items['approved_user']);
				$this->hrd->where('urutan_approval', $urutan);
				$this->hrd->update('hrd_web_master.mst_user_approval_detail');
			// }
			// tesx($log_app, $urutan);

			$saveaction        = $DataKaryawan['nip'].'-'. $DataKaryawan['nama_lengkap'];
			return ($saveaction) ? $saveaction : false;
		}

		function removeAction()
		{

			$id_karyawan 		= $this->input->post('id_karyawan');
			$id_karyawan_pic 	= $this->input->post('id_karyawan_pic');
			$urutan				= $this->input->post('pic_urutan');
			$bio_user 			= $this->input->post('biodata_user');
			$bio_pic 			= $this->input->post('biodata_pic');

			$karyawan	= $this->getDataKaryawanId($bio_user);
			$pic		= $this->getDataKaryawanId($bio_pic);

			$user	= $karyawan['nip'];
			$app	= $pic['nip'];

			$dataApp = "Remove-CUTI : User : $user, Pic : $app, Urutan : $urutan";

			$log_app = array(
				'nip' 			=> $user,
				'data_edit'		=> $dataApp,
				'pic_edit'		=> $this->session->userdata('nama_login'),
				'date_edit'		=> date('Y-m-d H:i:s'),
			);
			$this->hrd->insert('hrd_all.log_app', $log_app);

			// tesx($user, $app,$urutan , $log_app);

			$this->hrd->where('karyawan_id', $id_karyawan_pic);
			$this->hrd->where('approved_user', $id_karyawan);
			$this->hrd->where('urutan_approval', $urutan);
			$this->hrd->delete('hrd_web_master.mst_user_approval_detail');

			$removeaction        = $id_karyawan;
			return ($removeaction) ? $removeaction : false;
		}

	# ------ Action CUTI ------


	# ------ Action CP ------

		public function saveActionCP($biodata_id)
		{
			$UserBio		= $this->getDataKaryawanId($biodata_id);
			$DataKaryawan	= $this->getDataKaryawan01($biodata_id);
			$cekKaryawan	= $this->getDataKaryawan01($biodata_id);
			$approved_user 	= $cekKaryawan['karyawan_id'];

			// tesx($DataKaryawan,$approved_user);
			$listappold		= $this->getPicAppOldCP($biodata_id);

			# ------------- Data Log -------------
			$log_detail_old = array();
			for($x = 1; $x <= 3; $x++) {
				$listappoldurutan		= $this->getUserApprovalCp($UserBio['nip'], $x);
				$items_log_old = array(
					'oldapp'.$x.'' => $listappoldurutan['nip_app'],
				);
				array_push($log_detail_old, $items_log_old);
			}



			# ------------- Data OLD App Log -------------
				$oldapp1 = $log_detail_old['0']['oldapp1'];
				$oldapp2 = $log_detail_old['1']['oldapp2'];
				$oldapp3 = $log_detail_old['2']['oldapp3'];
			# ------------- Data OLD App Log -------------


			$log_detail_cp 	= array();
			$log_new_pic = array();

			$arrayPic = $this->input->post('pic_approve');
			$count_pic = count(array_filter($arrayPic, function($x) { return !empty($x); }));

			$no_urut_cp=1;
			for($x =0; $x < $count_pic; $x++) {
				$PicBiodata = $this->input->post('pic_approve')[$x];
				$dataPic = $this->getDataKaryawan01($PicBiodata);

				$items_cp = array(
					'nip_approval' 		=> $dataPic['nip'],
					'nip_user'			=> $UserBio['nip'],
					'jenis'				=> 'CP',
					'urutan_app'		=> $no_urut_cp++,
				);
				array_push($log_detail_cp,$items_cp);

				$new_pic= array(
					'nip' 		=> $dataPic['nip'],
				);
				array_push($log_new_pic,$new_pic);

				#Get Id Approval
				$nip_user 	= $items_cp['nip_user'];
				$nip_app	= $items_cp['nip_approval'];
				$urutan_cp	= $items_cp['urutan_app'];

				#Get Data Approval Cp
				$dataCp 	= $this->getUserApprovalCp($nip_user,$urutan_cp);

				#insert || Update data approval cp
				if(empty($dataCp) || $dataCp == NULL || $dataCp == "")
				{
					$insert = $this->hrd->insert('hrd_all.trn_app_cp', $items_cp);
				}else{
					$this->hrd->set($items_cp);
					$this->hrd->where('nip_user', $nip_user);
					$this->hrd->where('urutan_app', $urutan_cp);
					$insert =  $this->hrd->update('hrd_all.trn_app_cp');
				}

			}

			// tesx($log_detail_cp);

			# ------------- Data NEW App Log -------------
				$newapp1 = !empty($log_new_pic['0']['nip'])?$log_new_pic['0']['nip']:'';
				$newapp2 = !empty($log_new_pic['1']['nip'])?$log_new_pic['1']['nip']:'';
				$newapp3 = !empty($log_new_pic['2']['nip'])?$log_new_pic['2']['nip']:'';
			# ------------- Data NEW App Log -------------

				$dataAppCp = "App-CP : $oldapp1,$oldapp2,$oldapp3,$newapp1,$newapp2,$newapp3";

				// tesx($dataAppCp);
				$log_app_cp = array(
					'nip' 			=> $DataKaryawan['nip'],
					'data_edit'		=> $dataAppCp,
					'pic_edit'		=> $this->session->userdata('nama_login'),
					'date_edit'		=> date('Y-m-d H:i:s'),
				);
				$this->hrd->insert('hrd_all.log_app', $log_app_cp);

			// tesx($log_app_cp);

			$saveaction        = $DataKaryawan['nip'].'-'. $UserBio['nama_lengkap'];
			return ($saveaction ) ? $saveaction : FALSE;

		}

		function editActionCP()
		{

			$biodata_id 	= $this->input->post('biodata_karyawan');
			$biodata_app	= $this->input->post('pic_approve');

			$user			= $this->getDataKaryawanId($biodata_id);
			$app			= $this->getDataKaryawanId($biodata_app);
			$urutan			= $this->input->post('app_urutan');


			$listappold		= $this->getPicAppOldCP($biodata_id);

			// tesx($listappold);

			// tesx($biodata_id , $biodata_app, $user['nip'], $app['nip'], $urutan);

			# ------------- Data Log -------------
				$log_detail_old = array();
				for($x = 1; $x <= 3; $x++) {

						$listappoldurutan		= $this->getUserApprovalCp($user['nip'], $x);
						$items_log_old = array(
							'oldapp'.$x.'' => $listappoldurutan['nip_app'],
						);
						array_push($log_detail_old, $items_log_old);
				}
			# ------------- Data Log -------------

			# ------------- Data OLD App Log -------------
				$oldapp1 = $log_detail_old['0']['oldapp1'];
				$oldapp2 = $log_detail_old['1']['oldapp2'];
				$oldapp3 = $log_detail_old['2']['oldapp3'];
			# ------------- Data OLD App Log -------------

			# ------------- Data new App Log -------------
				if($urutan == '1'){
					$newapp1 = $app['nip'];
				} else { $newapp1 = $oldapp1; }

				if($urutan == '2'){
					$newapp2 = $app['nip'];
				} else { $newapp2 = $oldapp2; }

				if($urutan == '3'){
					$newapp3 = $app['nip'];
				} else { $newapp3 = $oldapp3; }
			# ------------- Data new App Log -------------

			$dataApp = "App-CP : $oldapp1,$oldapp2,$oldapp3,$newapp1,$newapp2,$newapp3";


			$log_app = array(
				'nip' 			=> $user['nip'],
				'data_edit'		=> $dataApp,
				'pic_edit'		=> $this->session->userdata('nama_login'),
				'date_edit'		=> date('Y-m-d H:i:s'),
			);
			$this->hrd->insert('hrd_all.log_app', $log_app);

			$items = array(

				'nip_approval' 		=> $app['nip'],
				'nip_user'			=> $user['nip'],
			);
			$this->hrd->set($items);
			$this->hrd->where('nip_user', $user['nip']);
			$this->hrd->where('urutan_app', $urutan);
			$this->hrd->update('hrd_all.trn_app_cp');

			// tesx($log_app, $items, $urutan, $user['nip']);

			$saveaction        = $user['nip'].'-'. $user['nama_lengkap'];
			return ($saveaction) ? $saveaction : false;
		}

		function removeActionCP()
		{

			$user 		= $this->input->post('id_karyawan');
			$app 		= $this->input->post('id_karyawan_pic');
			$urutan		= $this->input->post('pic_urutan');


			$dataApp = "Remove-CP : User : $user, Pic : $app, Urutan : $urutan";

			$log_app = array(
				'nip' 			=> $user,
				'data_edit'		=> $dataApp,
				'pic_edit'		=> $this->session->userdata('nama_login'),
				'date_edit'		=> date('Y-m-d H:i:s'),
			);
			$this->hrd->insert('hrd_all.log_app', $log_app);

			// tesx($user,$app,$urutan , $log_app);

			$this->hrd->where('nip_user', $user);
			$this->hrd->where('nip_approval', $app);
			$this->hrd->where('urutan_app', $urutan);
			$this->hrd->delete('hrd_all.trn_app_cp');

			$removeaction        = $user;
			return ($removeaction) ? TRUE : FALSE;
		}

	# ------ Action CP ------

}