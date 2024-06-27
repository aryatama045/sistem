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

    function getDosen($id = NULL)
    {
        $this->db->select('*');
		$this->db->from('mst_dosen');
        if($id){
            $this->db->where('nip', $id);
            $query=$this->db->get();
            return $query->row_array();
        }else{
            $query=$this->db->get();
            return $query->result_array();
        }
    }

    function getProdi($kode_prog = NULL)
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
        $this->db->order_by('nama_matkul', 'ASC');
        if($kode_matkul){
            $this->db->where('kode_matkul', $kode_matkul);
            $query=$this->db->get();
            return $query->row_array();
        }else{
            $query=$this->db->get();
            return $query->result_array();
        }
    }

    function getTahunAjaran($kd_ta = NULL)
    {
        $this->db->select('*');
		$this->db->from('mst_ta');
        $this->db->order_by('ta', 'DESC');

        if($kd_ta){
            $this->db->where('kd_ta', $kd_ta);
            $query=$this->db->get();
            return $query->row_array();
        }else{
            $query=$this->db->get();
            return $query->result_array();
        }
    }

    function getJenma($kd_jenma = NULL)
    {
        $this->db->select('*');
		$this->db->from('mst_jenma');

        if($kd_jenma){
            $this->db->where('kd_jenma', $kd_jenma);
            $query=$this->db->get();
            return $query->row_array();
        }else{
            $query=$this->db->get();
            return $query->result_array();
        }
    }

    function getBiaya($kd_biaya = NULL)
    {
        $this->db->select('*');
		$this->db->from('mst_biaya');
        $this->db->join('mst_jenma', 'mst_biaya.kd_jenma = mst_jenma.kd_jenma', 'left');
		$this->db->join('mst_ta', 'mst_biaya.kd_ta = mst_ta.kd_ta', 'left');

        if($kd_biaya){
            $this->db->where('kd_biaya', $kd_biaya);
            $query=$this->db->get();
            return $query->row_array();
        }else{
            $query=$this->db->get();
            return $query->result_array();
        }
    }

    function getJenisBiaya($kd_jenis = NULL)
    {
        $this->db->select('*');
		$this->db->from('mst_jenis_biaya');

        if($kd_jenis){
            $this->db->where('kd_jenis', $kd_jenis);
            $query=$this->db->get();
            return $query->row_array();
        }else{
            $query=$this->db->get();
            return $query->result_array();
        }
    }

    function getPeriodeDaftar($kode = NULL)
    {
        $this->db->select('*');
		$this->db->from('mst_gel_daftar');
        $this->db->join('mst_ta', 'mst_gel_daftar.kd_ta = mst_ta.kd_ta', 'left');

        if($kode){
            $this->db->where('kode', $kode);
            $query=$this->db->get();
            return $query->row_array();
        }else{
            $query=$this->db->get();
            return $query->result_array();
        }
    }

    function getJabatan($id = NULL)
    {
        $this->db->select('*');
		$this->db->from('mst_jabatan');
        $this->db->order_by('nama', 'ASC');

        if($id){
            $this->db->where('id', $id);
            $query=$this->db->get();
            return $query->row_array();
        }else{
            $query=$this->db->get();
            return $query->result_array();
        }
    }

    function getAgama($id = NULL)
    {
        $this->db->select('*');
		$this->db->from('mst_agama');
        $this->db->order_by('nama', 'ASC');
        if($id){
            $this->db->where('id', $id);
            $query=$this->db->get();
            return $query->row_array();
        }else{
            $query=$this->db->get();
            return $query->result_array();
        }
    }

    function getKota($id = NULL)
    {
        $this->db->select('*');
		$this->db->from('mst_kota');
        $this->db->order_by('nm_kota', 'ASC');

        if($id){
            $this->db->where('id', $id);
            $query=$this->db->get();
            return $query->row_array();
        }else{
            $query=$this->db->get();
            return $query->result_array();
        }
    }

    function cek_gel_daftar()
    {
        $dates = date('Y-m-d');
        $sql = "SELECT * FROM ( SELECT *
                            FROM mst_gel_daftar
                            WHERE '$dates' >= DATE(tgl_awal) AND '$dates' <= DATE(tgl_akhir)
                            ORDER BY tgl_akhir ASC
                        )a
                WHERE (tgl_awal <='$dates' AND tgl_akhir >='$dates') ORDER BY tgl_awal ASC";
        $query=$this->db->query($sql);
        return $query->row_array();

    }

}