<?php

class Model_role extends CI_Model
{
	public $table;

	function __construct()
	{
		parent::__construct();
		$this->table = 'roles';
	}

	public function getDataStore($result, $search_name = "", $length = "", $start = "", $column = "", $order = "")
	{

		$this->db->select("roles.*,
            CASE WHEN (status)= '1' THEN 'Aktif'
			WHEN (status)='0' THEN 'Nonaktif'
			ELSE 'Belum Ada Status' END sts
        ");
        $this->db->from($this->table);
        $this->db->where_not_in('id', 1);
        $this->db->order_by('name', 'ASC');

        if($search_name !=""){
			$this->db->like('name',$search_name);
        }

		if($column == 0){
			$this->db->order_by('name', $order);
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

    public function getDataRow($id = NULL)
    {
        $this->db->select("roles.*,
            CASE WHEN (status)= '1' THEN 'Aktif'
			WHEN (status)='0' THEN 'Nonaktif'
			ELSE 'Belum Ada Status' END sts");
		$this->db->from($this->table);

        if($id){
            $this->db->where('id', $id);
            $query=$this->db->get();
            return $query->row_array();
        }else{
            $query=$this->db->get();
            return $query->result_array();
        }
    }

	// ---- Action Start
	function saveTambah()
	{
		$data = $_POST;
		$insert = $this->db->insert($this->table, $data);

		return ($insert)?TRUE:FALSE;
	}

	function saveEdit($id)
	{
		$data = $_POST;
		$this->db->where(['id' => $id]);
		$update = $this->db->update($this->table, $data);

		return ($update)?TRUE:FALSE;
	}

	function saveDelete($id)
	{
		$this->db->where(['id' => $id]);
		$delete = $this->db->delete($this->table);

		return ($delete)?TRUE:FALSE;
	}
	// ---- Action END


}