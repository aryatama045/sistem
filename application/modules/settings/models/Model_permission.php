<?php

class Model_permission extends CI_Model
{
	public $table;

	function __construct()
	{
		parent::__construct();
		$this->table = 'permissions';
	}

	public function getDataStore($result, $search_name = "",$search_role = "", $length = "", $start = "", $column = "", $order = "")
	{

		$limit = "";
		if($result == 'result'){
			$limit = "ORDER BY sort_id,parent_id,urut LIMIT $start,$length";
		}

		$where_name = "";
		if($search_name !==""){
			$where_name = "WHERE display_name LIKE '%".$search_name."%'";
		}

		$sql = "SELECT *
			FROM (SELECT a.id,
						a.display_name,
						a.parent_id,
						a.sequence as urut,
						a.id as sort_id,
						pr.role_id,
						pr.permission_id
					FROM permissions as a
					LEFT JOIN permission_roles as pr ON a.id = pr.permission_id AND pr.role_id = '$search_role'
					WHERE a.parent_id = '0'
				UNION ALL
					SELECT b.id,
						CONCAT('-', b.display_name) display_name,
						b.parent_id,
						b.sequence as urut,
						b.parent_id as sort_id,
						pr.role_id,
						pr.permission_id
					FROM permissions as b
					LEFT JOIN permission_roles as pr ON b.id = pr.permission_id AND pr.role_id = '$search_role'
					WHERE b.parent_id != '0'
				) alias
			$where_name
			$limit
		";

		$query = $this->db->query($sql);
		// die(nl2br($this->db->last_query()));

		if($result == 'result'){
			return $query->result_array();
		}else{
			return $query->num_rows();
		}

	}

	public function getDataRow($id = NULL)
    {
        $this->db->select("permissions.*,
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
	function saveTambah($data)
	{
		$insert = $this->db->insert($this->table, $data);

		return ($insert)?TRUE:FALSE;
	}

    function saveUpdate($data)
	{
		$insert = $this->db->insert_batch('permission_roles', $data);

		return ($insert)?TRUE:FALSE;
	}

	function saveDelete($id_role)
	{
		$this->db->where(['role_id' => $id_role]);
		$delete = $this->db->delete('permission_roles');

		return ($delete)?TRUE:FALSE;
	}
	// ---- Action END


}