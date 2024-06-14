<?php

class Model_pmb_proses extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	public function getDataStore($result, $search_name = "", $length = "", $start = "", $column = "", $order = "")
	{

		$this->db->select('*');
        $this->db->from('trn_pmb');
		$this->db->where('is_bayar', TRUE);
        $this->db->order_by('no_pendaftaran', 'ASC');

        if($search_name !="" || $search_name != NULL){
			$this->db->like('no_pendaftaran',$search_name);
			$this->db->or_like('nik',$search_name);
            $this->db->or_like('nama',$search_name);
            $this->db->or_like('email',$search_name);
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

	// ---- Action Start
	function saveProses()
	{
		$data = $_POST;
		$insert = $this->db->insert($this->table, $data);

		return ($insert)?TRUE:FALSE;
	}


	// ---- Action END


}