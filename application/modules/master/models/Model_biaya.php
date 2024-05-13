<?php

class Model_biaya extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	// die(nl2br($this->db->last_query()));

	public function getDataStore($result, $search_no = "", $search_nama = "", $length = "", $start = "", $column = "", $order = "")
	{

		$this->db->select('*');
        $this->db->from('mst_biaya');
        $this->db->order_by('kd_biaya', 'ASC');

        if($search_no !="") $this->db->like('kd_biaya',$search_no);
        if($search_nama !="")
			$this->db->like('nilai',$search_nama);
			$this->db->or_like('kd_biaya',$search_nama);

		if($result == 'result'){
			$this->db->limit($length,$start);
			$query=$this->db->get();
			return $query->result_array();

		}else{
			$query=$this->db->get();
			return $query->num_rows();
		}

	}

}