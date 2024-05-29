<?php

class Model_tahun_ajaran extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function getDataStore($result, $tahun_ajaran = "", $length = "", $start = "", $column = "", $order = "")
	{

		$this->db->select('*');
        $this->db->from('mst_ta');
        $this->db->order_by('ta', 'DESC');

        if($tahun_ajaran !="")
			$this->db->like('kd_ta',$tahun_ajaran);
			$this->db->or_like('ta',$tahun_ajaran);

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