<?php

class Model_mahasiswa extends CI_Model
{
	public $table;

	function __construct()
	{
		parent::__construct();
		$this->table = 'mst_mhs';
	}


	public function getDataStore($result, $search_name = "", $length = "", $start = "", $column = "", $order = "")
	{

		$this->db->select('*');
        $this->db->from($this->table);
		$this->db->join('mst_prodi', 'mst_mhs.kd_prog = mst_prodi.kd_prog', 'left');
		$this->db->join('mst_ta', 'mst_mhs.kd_ta = mst_ta.kd_ta', 'left');

        if($search_name !=""){
			$this->db->like('nama_mhs',$search_name);
			$this->db->or_like('nim',$search_name);
		}

		if($column == 0){
			$this->db->order_by('nim', $order);
		}elseif($column == 1){
			$this->db->order_by('nama_mhs', $order);
		}elseif($column == 4){
			$this->db->order_by('ta', $order);
		}


		if($result == 'result'){
			$this->db->limit($length,$start);
			$query=$this->db->get();
			return $query->result_array();

		}else{
			$query=$this->db->get();
			return $query->num_rows();
		}

	}

	public function detail($id)
	{
		$this->db->select("*,
		CASE WHEN (jk)= 'L' THEN 'Laki-Laki'
		WHEN (jk)='P' THEN 'Perempuan'
		ELSE 'Belum Input' END jk");
        $this->db->from($this->table);
		$this->db->join('mst_prodi', 'mst_mhs.kd_prog = mst_prodi.kd_prog', 'left');
		$this->db->join('mst_ta', 'mst_mhs.kd_ta = mst_ta.kd_ta', 'left');
		$this->db->where('nim',$id);
		$query	= $this->db->get();
		// die(nl2br($this->db->last_query()));
		return $query->row_array();

	}

	function getMhsUserlogin($id)
	{
		$this->db->select('*');
        $this->db->from('users');
		$this->db->where('nim',$id);
		$query	= $this->db->get();
		// die(nl2br($this->db->last_query()));
		return $query->row_array();
	}

	// ---- Action Start
	function saveTambah()
	{
		$data = $_POST;
		$insert = $this->db->insert($this->table, $data);

		return ($insert)?TRUE:FALSE;
	}

	function saveEdit()
	{
		$data = $_POST;
		$this->db->where(['nim' => $data['nim']]);
		$update = $this->db->update($this->table, $data);

		return ($update)?TRUE:FALSE;
	}

	function saveDelete($id)
	{
		$this->db->where(['nim' => $id]);
		$delete = $this->db->delete($this->table);

		return ($delete)?TRUE:FALSE;
	}
	// ---- Action END


}