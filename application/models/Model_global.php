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

    function getKodeProgram($kode_prog = NULL)
    {
        $this->db->select('*');
		$this->db->from('mst_prodi');

        if($kode_prog){
            $this->db->where('kd_prog', $kode_prog);
            $query=$this->db->get();
            return $query->row_array();
        }else{
            $query=$this->db->get();
            return $query->result_array();
        }
    }

    function getMataKuliah($kode_matkul = NULL)
    {
        $this->db->select('*');
		$this->db->from('mst_matkul');
        $this->db->join('mst_prodi', 'mst_matkul.kd_prog = mst_prodi.kd_prog', 'left');
        if($kode_matkul){
            $this->db->where('kode_matkul', $kode_matkul);
            $query=$this->db->get();
            return $query->row_array();
        }else{
            $query=$this->db->get();
            return $query->result_array();
        }
    }

}