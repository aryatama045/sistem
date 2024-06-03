<?php

class Model_dosen extends CI_Model
{
	public $table;

	function __construct()
	{
		parent::__construct();
		$this->table = 'mst_dosen';
	}


	public function getDataStore($result, $search_name = "", $length = "", $start = "", $column = "", $order = "")
	{

		$this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('nip', 'ASC');

        if($search_name !="")
			$this->db->like('nip',$search_name);
			$this->db->or_like('nidn',$search_name);
            $this->db->or_like('nama',$search_name);

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
		$this->db->select('*');
        $this->db->from($this->table);
		$this->db->where('nip',$id);
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
		$this->db->where(['nip' => $data['nip']]);
		$update = $this->db->update($this->table, $data);

		return ($update)?TRUE:FALSE;
	}

	function saveDelete($id)
	{
		$this->db->where(['nip' => $id]);
		$delete = $this->db->delete($this->table);

		return ($delete)?TRUE:FALSE;
	}
	// ---- Action END


}