<?php

class Model_biaya extends CI_Model
{
	public $table;

	function __construct()
	{
		parent::__construct();
		$this->table = 'mst_biaya';
	}

	public function getDataStore($result, $search_name = "", $length = "", $start = "", $column = "", $order = "")
	{

		$this->db->select('*');
        $this->db->from($this->table);
		$this->db->join('mst_jenma', 'mst_biaya.kd_jenma = mst_jenma.kd_jenma', 'left');
		$this->db->join('mst_ta', 'mst_biaya.kd_ta = mst_ta.kd_ta', 'left');

        $this->db->order_by('kd_biaya', 'ASC');

        if($search_name !="")
			$this->db->like('nilai',$search_name);
			$this->db->or_like('kd_biaya',$search_name);
			$this->db->or_like('jenis_mhs',$search_name);
			$this->db->or_like('ta',$search_name);

		if($result == 'result'){
			$this->db->limit($length,$start);
			$query=$this->db->get();
			return $query->result_array();
		}else{
			$query=$this->db->get();
			return $query->num_rows();
		}
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
		$this->db->where(['kd_biaya' => $data['kd_biaya']]);
		$update = $this->db->update($this->table, $data);

		return ($update)?TRUE:FALSE;
	}

	function saveDelete($id)
	{
		$this->db->where(['kd_biaya' => $id]);
		$delete = $this->db->delete($this->table);

		return ($delete)?TRUE:FALSE;
	}
	// ---- Action END

}