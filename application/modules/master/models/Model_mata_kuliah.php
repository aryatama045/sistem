<?php

class Model_mata_kuliah extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function getDataStore($result, $search_name = "", $length = "", $start = "", $column = "", $order = "")
	{

		$this->db->select('*');
        $this->db->from('mst_matkul');
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

}