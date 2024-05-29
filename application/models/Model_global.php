<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Model_global extends CI_Model {

    function __construct() {
        parent::__construct();

        $this->load->library('auth');
    }


    function getTahunAjaranAktif() {
        $this->db->select('*');
        $this->db->from('mst_ta');
        $this->db->where('aktif', '1');
        $this->db->order_by('kd_ta', 'ASC');
        $query = $this->db->get();
        // die(nl2br($this->db->last_query()));
        return $query->row_array();
    }

    function getMhsNik($nik)
    {
        $this->db->select('*');
		$this->db->from('mst_mhs');
        $this->db->where('nik', $nik);
		$query=$this->db->get();
		return $query->row_array();
    }

    function getMhsNim($nim)
    {
        $this->db->select('*');
		$this->db->from('mst_mhs');
        $this->db->where('nim', $nim);
		$query=$this->db->get();
		return $query->row_array();
    }

}