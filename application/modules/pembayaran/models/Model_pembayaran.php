<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Model_pembayaran extends CI_Model {

    function __construct() {
        parent::__construct();

    }


    function detil_bayar($nim, $kd_ta)
    {
        #detil bayar
        $sql = "SELECT  ke,wkt_bayar, b.nilai, tipe, keterangan FROM trn_bayar a
        LEFT JOIN trn_bayar_d b
        ON a.id_bayar = b.id_bayar
        WHERE nim = $nim AND kd_ta=$kd_ta
        ORDER BY ke";

        $query= $this->db->query($sql);
        return $query->result_array();
    }

    function totalbayar($nim, $kd_ta)
    {

        #totalbayar
        $sql = "SELECT  SUM(b.nilai) total FROM trn_bayar a
        LEFT JOIN trn_bayar_d b
        ON a.id_bayar = b.id_bayar
        WHERE nim = $nim AND kd_ta=$kd_ta
        ORDER BY ke";
        $query= $this->db->query($sql);
        return $query->row_array();

    }

    function sisa_bayar($nim, $kd_ta)
    {

        #sisa bayar
        $sql = "SELECT a.nilai-SUM(b.nilai) sisa FROM trn_bayar a
        LEFT JOIN trn_bayar_d b
        ON a.id_bayar = b.id_bayar
        WHERE nim = $nim AND kd_ta=$kd_ta
        ORDER BY ke";
        $query= $this->db->query($sql);
        return $query->row_array();
    }

}