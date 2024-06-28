<?php

class Model_tahun_ajaran extends CI_Model
{
	public $table;

	function __construct()
	{
		parent::__construct();
		$this->table = 'mst_ta';
	}

	public function getDataStore($result, $search_name = "", $length = "", $start = "", $column = "", $order = "")
	{

		$this->db->select("*,
			CASE WHEN (smt)= '1' THEN '<b>GASAL</b>'
			WHEN (smt)='2' THEN '<b>GENAP</b>'
			ELSE 'Belum Ada Status' END smt
		");
        $this->db->from($this->table);
        $this->db->order_by('ta', 'DESC');

        if($search_name !="")
			$this->db->like('kd_ta',$search_name);
			$this->db->or_like('ta',$search_name);

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
	function saveTambah()
	{
		$data = $_POST;
		$insert = $this->db->insert($this->table, $data);

		return ($insert)?TRUE:FALSE;
	}

	function saveEdit()
	{
		$data = $_POST;
		if($data['aktif']=='1'){
			$update_aktif = array('aktif' => '0');
			$this->db->where(['aktif' => $data['aktif']]);
			$this->db->update($this->table, $update_aktif);
		}
		$this->db->where(['kd_ta' => $data['kd_ta']]);
		$update = $this->db->update($this->table, $data);

		return ($update)?TRUE:FALSE;
	}

	function saveDelete($id)
	{
		$this->db->where(['kd_ta' => $id]);
		$delete = $this->db->delete($this->table);

		return ($delete)?TRUE:FALSE;
	}
	// ---- Action END

}