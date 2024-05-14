<?php

class Model_pmb extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

    public function getDataCama($nik){
		$this->db->select('*');
		$this->db->from('trn_pmb');
        $this->db->where('nik', $nik);
		$query=$this->db->get();
		// die(nl2br($this->db->last_query()));
		return $query->row_array();
	}

    public function getDataNoDoc()
	{
		$docCode	 ='PMB-';
		$date		 = date('ym');

		$sno_doc = $docCode.$date;

		$hasil = $this->db->query("SELECT RIGHT(no_pendaftaran,4)+1 as no_pmb FROM trn_pmb WHERE no_pendaftaran LIKE '".$sno_doc."%' ORDER BY no_pendaftaran DESC LIMIT 1");

        $result = $hasil->row_array();

		if($result){
			$urut = $result['no_pmb'];
			for ($i=4; $i > strlen($result['no_pmb']) ; $i--) {
				$urut = "0".$urut;
			}
			return $sno_doc.$urut;
		}else{
			return $sno_doc."0001";
        }
	}

    public function saveCama()
    {

		$dataCama  = array(
            'no_pendaftaran'=> $this->getDataNoDoc(),
			'nama' 			=> $_POST['nama'],
			'nik'	        => $_POST['nik'],
            'no_hp'         => $_POST['no_hp'],
            'email'         => $_POST['email'],
            'tahun_lulus'   => $_POST['tahun_lulus'],

		);

		// tesx($dataCama);

        if(!empty($dataCama)){
            $insert = $this->db->insert('trn_pmb', $dataCama);
        }

		return ($insert)?true:false;
	}


}