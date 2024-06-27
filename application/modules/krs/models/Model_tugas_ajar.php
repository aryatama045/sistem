<?php

class Model_tugas_ajar extends CI_Model
{
	public $table;

	function __construct()
	{
		parent::__construct();
		$this->table = 'trn_tugas_ajar';
	}

	public function getDataStore($result, $search_name = "",$search_prodi = "",$search_dosen = "", $length = "", $start = "", $column = "", $order = "")
	{
		// $ta_g 			= config_item('semester');

		$ta				= $this->Model_global->getTahunAjaranAktif();
		$semester		= $ta['smt'];
		if($semester == 1){ $mod = '2<>'; }else{ $mod = '2='; }

		$this->db->select('*, mst_matkul.kode_matkul kdmatkul');
        $this->db->from('mst_matkul');
		$this->db->join('trn_tugas_ajar', 'mst_matkul.kode_matkul = trn_tugas_ajar.kode_matkul AND trn_tugas_ajar.nip = "'.$search_dosen.'"', 'left');
		$this->db->join('mst_ta', 'trn_tugas_ajar.kd_ta = mst_ta.kd_ta', 'left');
		$this->db->join('mst_dosen', 'trn_tugas_ajar.nip = mst_dosen.nip', 'left');
		$this->db->join('mst_prodi', 'mst_matkul.kd_prog = mst_prodi.kd_prog', 'left');
		$this->db->where('mst_matkul.smt MOD '.$mod.'', '0' , FALSE);
		$this->db->where('mst_prodi.kd_prog',$search_prodi);

		$this->db->order_by('mst_matkul.nama_matkul', 'ASC');

        if($search_name !=""){
			$this->db->like('mst_matkul.kode_matkul',$search_name);
			$this->db->or_like('mst_matkul.nama_matkul',$search_name);
		}

		if($result == 'result'){
			$this->db->limit($length,$start);
			$query=$this->db->get();
			// die(nl2br($this->db->last_query()));
			return $query->result_array();

		}else{
			$query=$this->db->get();
			return $query->num_rows();
		}

	}

	// ---- Action Start
	function saveTambah($data)
	{

		$insert = $this->db->insert_batch($this->table, $data);

		return ($insert)?TRUE:FALSE;
	}

	function saveDelete($id_dosen, $id_prodi)
	{
		$this->db->where(['nip' => $id_dosen, 'kd_prog' => $id_prodi]);
		$delete = $this->db->delete($this->table);

		return ($delete)?TRUE:FALSE;
	}
	// ---- Action END


}