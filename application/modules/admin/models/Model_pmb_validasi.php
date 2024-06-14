<?php

class Model_pmb_validasi extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	public function getDataStore($result, $search_name = "", $length = "", $start = "", $column = "", $order = "")
	{

		$this->db->select('*');
        $this->db->from('trn_pmb');
		$this->db->where('pic_validasi', NULL);
        $this->db->where('status_terkini', '4');
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
	function saveValidasi($id)
	{

		$data_h = array(
			'pic_validasi' => $this->session->userdata('userID'),
			'tgl_validasi' => date('Y-m-d h:i:s'),
			'status_terkini' => '5',
		);
		$this->db->where(['no_pendaftaran' => $id]);
		$this->db->update('trn_pmb', $data_h);
		return ($id)?TRUE:FALSE;
	}

	function saveBerkasValidasi($no_pmb, $id_dok, $data)
	{

		$this->db->where(['no_pendaftaran' => $no_pmb, 'id' => $id_dok]);
		$this->db->update('trn_pmb_dok', $data);
		return ($no_pmb)?TRUE:FALSE;
	}

	function saveTambah()
	{
		$data = $_POST;
		$insert = $this->db->insert($this->table, $data);

		return ($insert)?TRUE:FALSE;
	}

	function saveEdit()
	{
		$data = $_POST;
		$this->db->where(['kode' => $data['kode']]);
		$update = $this->db->update($this->table, $data);

		return ($update)?TRUE:FALSE;
	}

	function saveDelete($id)
	{
		$this->db->where(['kode' => $id]);
		$delete = $this->db->delete($this->table);

		return ($delete)?TRUE:FALSE;
	}
	// ---- Action END


}