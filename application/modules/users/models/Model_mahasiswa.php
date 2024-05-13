<?php

class Model_mahasiswa extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}


	public function getDataStore($result, $search_no = "", $search_nama = "", $length = "", $start = "", $column = "", $order = "")
	{

		$this->db->select('*');
        $this->db->from('mst_mhs');
        $this->db->order_by('nim', 'ASC');

        if($search_no !="") $this->db->like('nim',$search_no);
        if($search_nama !="")
			$this->db->like('nama_mhs',$search_nama);
			$this->db->or_like('nim',$search_nama);

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


	public function detail($id)
	{
		$this->db->select('*');
        $this->db->from('mst_mhs');
		$this->db->where('nim',$id);
		$query	= $this->db->get();
		// die(nl2br($this->db->last_query()));
		return $query->row_array();

	}
}