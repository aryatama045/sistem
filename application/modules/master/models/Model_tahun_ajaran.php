<?php

class Model_tahun_ajaran extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function getDataStore(){
		$this->db->select('*');
		$this->db->from('db_lep.mst_ta');
		$query=$this->db->get();
		// die(nl2br($this->db->last_query()));
		return $query->result_array();

	}

	public function getCutiData1($search_no = "", $length = "", $start = "", $column = "", $order = "")
	{

		if($search_no != "") $this->db->like('ta',$search_no);
		$this->db->select('*');
		$this->db->from('db_lep.mst_ta');

		$this->db->limit($length,$start);
		$query=$this->db->get();

		// die(nl2br($this->db->last_query()));
		return $query->result_array();
	}

	public function getCutiData2($search_no = "")
	{
		$this->db->select('*');
		$this->db->from('db_lep.mst_ta');
		$jum=$this->db->get();

		return $jum->num_rows();
	}

}