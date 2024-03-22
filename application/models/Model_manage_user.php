<?php

class Model_manage_user extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}


    public function getManageUser1( $search_no = "", $length = "", $start = "", $column = "", $order = "")
	{

        if($search_no != "") $this->hrd->like('t1.biodata_id',$search_no);
		$this->db->select('t0.*,t1.nama_lengkap');
		$this->db->from('inv_webot.auth_users t0');
		$this->db->join('hrd_all.mst_biodata t1', 't0.nama_login = t1.nip', 'left');
		$this->db->limit($length,$start);
		$query=$this->db->get();
		// die(nl2br($this->db->last_query()));
		return $query->result_array();
	}

	public function getManageUser2( $search_no = "")
    {
        if($search_no != "") $this->db->like('t1.biodata_id',$search_no);
        $this->db->select('t0.*,t1.nama_lengkap');
		$this->db->from('inv_webot.auth_users t0');
		$this->db->join('hrd_all.mst_biodata t1', 't0.nama_login = t1.nip', 'left');
        $jum=$this->db->get();
		return $jum->num_rows();
    }


}