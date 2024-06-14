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

		$this->db->select("mst_dosen.*, mst_jabatan.nama nm_jabatan,
			CASE WHEN (status)= 'T' THEN 'TETAP'
			WHEN (status)='P' THEN 'PKWT'
			WHEN (status)='H' THEN 'Honorer'
			ELSE 'Belum Ada Status' END status
		");
        $this->db->from($this->table);
		$this->db->join('mst_jabatan', 'mst_dosen.jabatan = mst_jabatan.id', 'left');
        $this->db->order_by('nip', 'ASC');

        if($search_name !="")
			$this->db->like('nip',$search_name);
			$this->db->or_like('nidn',$search_name);
            $this->db->or_like('mst_dosen.nama',$search_name);

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
		$this->db->select("mst_dosen.*, mst_agama.nama nm_agama, mst_jabatan.nama nm_jabatan, mst_kota.nm_kota,
			CASE WHEN (status)= 'T' THEN 'TETAP'
			WHEN (status)='P' THEN 'PKWT'
			WHEN (status)='H' THEN 'Honorer'
			ELSE 'Belum Ada Status' END status
		");
        $this->db->from($this->table);
		$this->db->join('mst_agama', 'mst_dosen.agama = mst_agama.id', 'left');
		$this->db->join('mst_jabatan', 'mst_dosen.jabatan = mst_jabatan.id', 'left');
		$this->db->join('mst_kota', 'mst_dosen.kota = mst_kota.id', 'left');
		$this->db->where('nip',$id);
		$query	= $this->db->get();
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