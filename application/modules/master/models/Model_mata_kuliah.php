<?php

class Model_mata_kuliah extends CI_Model
{
	public $table;
	function __construct()
	{
		parent::__construct();
		$this->table = 'mst_matkul';
	}

	// ---- Get Data Start
	public function getDataStore($result, $search_name = "", $length = "", $start = "", $column = "", $order = "")
	{

		$this->db->select('*');
        $this->db->from($this->table);
		$this->db->join('mst_prodi', 'mst_matkul.kd_prog = mst_prodi.kd_prog', 'left');
        $this->db->order_by('smt', 'ASC');
        $this->db->order_by('nama_matkul', 'ASC');

        if($search_name !="")
			$this->db->like('kode_matkul',$search_name);
			$this->db->or_like('nama_matkul',$search_name);

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
	// ---- Get Data END

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
		$this->db->where(['kode_matkul' => $data['kode_matkul']]);
		$update = $this->db->update($this->table, $data);

		return ($update)?TRUE:FALSE;
	}

	function saveDelete($id)
	{
		$this->db->where(['kode_matkul' => $id]);
		$delete = $this->db->delete($this->table);

		return ($delete)?TRUE:FALSE;
	}
	// ---- Action END


}