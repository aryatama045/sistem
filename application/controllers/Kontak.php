<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Kontak extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
        $this->load->model('leaves/Model_cuti');
    }

    // GET Menampilkan data kontak
    function index_get() {
        $id = $this->get('nama_login');
        if ($id == '') {
            $kontak = $this->db->get('auth_users')->result();
        } else {
            $this->db->where('nama_login', $id);
            $kontak = $this->db->get('auth_users')->result();
        }
        $this->response($kontak, 200);
    }

    //PUT Memperbarui data kontak yang telah ada
    function index_put() {
        $id = $this->put('nama_login');
        $data = array(
                    'nama_karyawan'          => $this->put('nama_karyawan'),
                );
        $this->db->where('nama_login', $id);
        $update = $this->db->update('auth_users', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

    //POST Mengirim atau menambah data kontak baru
    function index_post() {
        $data = array(
                    'id'           => $this->post('id'),
                    'nama'          => $this->post('nama'),
                    'nomor'    => $this->post('nomor'));
        $insert = $this->db->insert('telepon', $data);
        if ($insert) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }


}
?>