<?php

class Model_generate_krs extends CI_Model
{
	public $table;
	function __construct()
	{
		parent::__construct();
		$this->table = 'trn_krs_paket';
	}

	// ---- Get Data Start
	public function getDataStore($result, $search_name = "", $length = "", $start = "", $column = "", $order = "")
	{

		$this->db->select('a.*, b.nama_mhs, c.nama_matkul, d.ta, d.smt');
        $this->db->from('trn_krs_paket a');
        $this->db->join('mst_mhs b','a.nim = b.nim', 'left');
        $this->db->join('mst_matkul c','a.kode_matkul = c.kode_matkul', 'left');
        $this->db->join('mst_ta d','a.kd_ta = d.kd_ta', 'left');
        $this->db->order_by('nim', 'ASC');

        if($search_name !=""){
			$this->db->like('a.nim',$search_name);
            $this->db->or_like('b.nama_mhs',$search_name);
            $this->db->or_like('c.nama_matkul',$search_name);
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

    function getMatkulKrsBySmt($kd_prog,$smt)
    {
        $this->db->select('*');
		$this->db->from('mst_matkul');
        $this->db->where('kd_prog', $kd_prog);
        $this->db->where('smt', $smt);
        $this->db->order_by('nama_matkul', 'ASC');

        $query=$this->db->get();
        return $query->result_array();
    }

    function getCekKrs($kd_ta,$nim,$kode_matkul)
    {
        $this->db->select('*');
		$this->db->from('trn_krs_paket');
        $this->db->where('kd_ta', $kd_ta);
        $this->db->where('nim', $nim);
        $this->db->where('kode_matkul', $kode_matkul);
        $query=$this->db->get();
        return $query->row_array();
    }
	// ---- Get Data END


	// ---- Action Start
	function saveTambah()
	{
		$data_add   = $_POST;
        #-- Get Data Mahasiswa Semester Aktif
        #-- *Note : Belum ada validasi status
        $dataMhsAktif   = $this->Model_global->getSemesterMahasiswaAktif('', $data_add['kd_ta']);

        $save_krs_mhs = array();
        foreach ($dataMhsAktif as $key => $val) {

            $getMatkul = $this->getMatkulKrsBySmt($val['kd_prog'],$val['zem']);

            foreach ($getMatkul as $key2 => $val2) {

                #-- Data Krs
                $data_mhs = array(
                    'kd_ta' => $val['kd_ta'],
                    'nim' => $val['nim'],
                    'kode_matkul' => $val2['kode_matkul'],
                );
                array_push($save_krs_mhs, $data_mhs);

                if($data_mhs){
                    #-- Get Data KRS for check
                    $chekKrs = $this->getCekKrs($data_mhs['kd_ta'], $data_mhs['nim'], $data_mhs['kode_matkul']);

                    #-- Cek Insert if Sudah ada
                    if($chekKrs==NULL){
                        $this->db->insert($this->table, $data_mhs);
                    }
                }

            }

        }

		return ($save_krs_mhs)?TRUE:FALSE;
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