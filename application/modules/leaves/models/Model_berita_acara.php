<?php

class Model_berita_acara extends CI_Model
{
	private $hrd;
	function __construct()
	{
		parent::__construct();
		$this->db_tol = $this->load->database('db_tol',TRUE);
        $this->gl_mim = $this->load->database('gl_mim',TRUE);
        $this->hrd = $this->load->database('hrd',TRUE);
	}

    public function getDataApp()
    {
        $nip = $this->session->userdata('nama_login');

        // - Ambil data approval
        $sql="SELECT *
            FROM hrd_web_master.app_berita_acara
            WHERE nip='$nip'
        ";
        $query = $this->hrd->query($sql);
        // die($this->hrd->last_query());
        return $query->row_array();
    }

	public function headerDok($faktur_id)
    {
        // - get Faktur dapat nilai diskon Lensa R/L
        $sql="SELECT
                a.*,faktur_id,no_faktur,pr_h_id,no_pr,
                r_lensa,new_r_harga,new_r_diskon_persen,new_r_diskon_total,new_r_total,
                l_lensa,new_l_harga,new_l_diskon_persen,new_l_diskon_total,new_l_total,
                new_r_total+new_l_total AS new_total_lensa,pic_input,user_name
            FROM db_tol.tbl_upd_prs_faktur a
            LEFT JOIN db_akses.mst_user b ON a.pic_input = b.nip_user
            WHERE faktur_id='$faktur_id'
        ";
        $query = $this->db_tol->query($sql);
        // die($this->db_tol->last_query());
        return $query->row_array();
    }

    public function getNilaiJasa($pr_h_id)
    {
        // - Dapat Nilai Jasa
        $sql="SELECT SUM(sub_total) AS total_jasa
            FROM db_tol.trn_pr_jasa_d
            WHERE pr_h_id= '$pr_h_id'
        ";
        $query = $this->db_tol->query($sql);
        // die($this->db_tol->last_query());
        return $query->row_array();
    }


    public function appDeptHead()
    {

        $faktur_id  = $this->input->post('faktur_id');
        $app        = $this->getDataApp();
        $header     = $this->headerDok($faktur_id);
        $pr_h_id    = $header['pr_h_id'];
        $nilaijasa  = $this->getNilaiJasa($pr_h_id);

        $new_total_lensa = $header['new_r_total'] + $header['new_l_total'] + $nilaijasa['total_jasa'];

		#Simpan Header
        if($app['urutan'] == '2'){
            # Update Header
                $dataHeader = array(
                    'approve2'         => $this->session->userdata('nama_login'),
                    'tgl_approve2'     => date('Y-m-d H:i:s')
                );

            # Update PRH
            $data_prh = array(
                'total_akhir' => $new_total_lensa
            );
            $this->db_tol->set($data_prh);
            $this->db_tol->where('pr_h_id', $pr_h_id);
            $this->db_tol->update('trn_pr_h');

            # Update nilai Faktur Independent
            $data_faktur_i = array(
                'nilai_faktur' => $new_total_lensa
            );
            $this->db_tol->set($data_faktur_i);
            $this->db_tol->where('faktur_id', $faktur_id);
            $this->db_tol->update('trn_faktur_independent');

            # Update Harga Baru Lensa R
            if(!empty($header['r_lensa'])){
                $data_lensa_r = array(
                    'harga_brg'        => $header['new_r_total'],
                    'r_l'              => 'R'
                );
                $this->db_tol->set($data_lensa_r);
                $this->db_tol->where('faktur_id', $faktur_id);
                $this->db_tol->where('r_l', 'R');
                $this->db_tol->update('trn_faktur_independent_d_lensa');
            }

            # Update Harga Baru Lensa L
            if(!empty($header['l_lensa'])){
                $data_lensa_l = array(
                    'harga_brg'        => $header['new_l_total'],
                    'r_l'              => 'L'
                );
                $this->db_tol->set($dataHeader);
                $this->db_tol->where('faktur_id', $faktur_id);
                $this->db_tol->where('r_l', 'L');
                $this->db_tol->update('trn_faktur_independent_d_lensa');
            }

        }else{
			$dataHeader = array(
                'approve1'         => $this->session->userdata('nama_login'),
                'tgl_approve1'     => date('Y-m-d H:i:s')
            );
		}

        // tesx($app['urutan'], $dataHeader);

		$this->db_tol->set($dataHeader);
		$this->db_tol->where('faktur_id', $faktur_id);
		$this->db_tol->update('tbl_upd_prs_faktur');


        return ($faktur_id) ? $header['no_faktur'] : false;
    }

	public function rejectAction()
	{
		$no_req = $this->input->post('no_request');
		$ket 	= $this->input->post('ket');
        $headerReq = $this->headerDok($no_req);

		if($headerReq['jenis']=='PUM')
		{
			$dataH = array(
				'is_reject'  => 1,
				'pic_reject' => $this->session->userdata('nama_login'),
				'tgl_reject' => date('Y-m-d H:i:s'),
				'keterangan_reject' => $ket ,
				'referenced' => '0'
			);
		}else{
			$dataH = array(
				'is_reject'  => 1,
				'pic_reject' => $this->session->userdata('nama_login'),
				'tgl_reject' => date('Y-m-d H:i:s'),
				'keterangan_reject' => $ket
			);
		}

		// tesx($no_req,$dataH);
		$this->hrd->set($dataH);
		$this->hrd->where('no_request',$no_req);
		$this->hrd->update('gl_mim.trn_request_h');

		// tesx($no_req, $dataH);
		return ($no_req)?$no_req:false;
	}


	public function getDataKaryawan($nip)
	{
		$sql = "SELECT b.nip, c.kode k_d, c.nama n_d, d.kode k_j, d.nama n_j, e.*
				FROM hrd_web_master.mst_karyawan_01 b
				LEFT JOIN hrd_web_master.mst_departemen c ON b.departemen = c.hash
				LEFT JOIN hrd_web_master.mst_jabatan d ON b.jabatan = d.hash
				LEFT JOIN hrd_web_master.db_akses_dept e  ON b.nip = e.nip
				WHERE b.nip = '$nip'
		";
		$query = $this->hrd->query($sql);
		// die($this->hrd->last_query());
		return $query->row_array();

	}


	/* get datables approval dept head, finance dan direksi */

    public function getDataDeptHead1($urutan_app ="",$search_no="",$length="",$start="",$column="",$order="")
	{
        $where_app = "";
		if($urutan_app == "1"){
			$where_app = "WHERE IFNULL(approve1,'')='' ";
		}
        if($urutan_app == "2"){
			$where_app = "WHERE IFNULL(approve2,'')='' AND  IFNULL(approve1,'')<>''";
		}

		$sql = "SELECT
                *,
                faktur_id,no_faktur,pr_h_id,no_pr,
                r_lensa,new_r_harga,new_r_diskon_persen,new_r_diskon_total,new_r_total,
                l_lensa,new_l_harga,new_l_diskon_persen,new_l_diskon_total,new_l_total,
                new_r_total+new_l_total AS new_total_lensa,pic_input,user_name
            FROM
                db_tol.tbl_upd_prs_faktur a
            LEFT JOIN db_akses.mst_user b ON a.pic_input = b.nip_user
            $where_app
			ORDER BY no_faktur DESC
			LIMIT $start,$length
		";

		$query = $this->db_tol->query($sql);
		// die(nl2br($this->db_tol->last_query()));
		return $query->result_array();

	}

	public function getDataDeptHead2($urutan_app ="",$search_no = "")
	{
        $where_app = "";
		if($urutan_app == "1"){
			$where_app = "WHERE IFNULL(approve1,'')='' ";
		}
        if($urutan_app == "2"){
			$where_app = "WHERE IFNULL(approve2,'')='' AND  IFNULL(approve1,'')<>''";
		}
        $sql = "SELECT
                a.*,
                faktur_id,no_faktur,pr_h_id,no_pr,
                r_lensa,new_r_harga,new_r_diskon_persen,new_r_diskon_total,new_r_total,
                l_lensa,new_l_harga,new_l_diskon_persen,new_l_diskon_total,new_l_total,
                new_r_total+new_l_total AS new_total_lensa,pic_input,user_name
            FROM
                db_tol.tbl_upd_prs_faktur a
            LEFT JOIN db_akses.mst_user b ON a.pic_input = b.nip_user

            $where_app
            ORDER BY no_faktur DESC
        ";
		$jum= $this->db_tol->query($sql);
		return $jum->num_rows();
	}

	public function getDataDeptHistory1($urutan_app ="",$search_no="",$length="",$start="",$column="",$order="")
	{

		$where_app = "";
		if($urutan_app == "1"){
			$where_app = "WHERE IFNULL(approve1,'')='' ";
		}
        if($urutan_app == "2"){
			$where_app = "WHERE IFNULL(approve1,'')<>'' ";
		}

		$sql = "SELECT
                *,
                faktur_id,no_faktur,pr_h_id,no_pr,
                r_lensa,new_r_harga,new_r_diskon_persen,new_r_diskon_total,new_r_total,
                l_lensa,new_l_harga,new_l_diskon_persen,new_l_diskon_total,new_l_total,
                new_r_total+new_l_total AS new_total_lensa,pic_input,user_name
            FROM
                db_tol.tbl_upd_prs_faktur a
            LEFT JOIN db_akses.mst_user b ON a.pic_input = b.nip_user
            $where_app
			ORDER BY no_faktur DESC
			LIMIT $start,$length
		";

		$query = $this->db_tol->query($sql);
		// die(nl2br($this->db_tol->last_query()));
		return $query->result_array();

	}

	public function getDataDeptHistory2($urutan_app ="",$search_no = "")
	{

		$where_app = "";
		if($urutan_app == "1"){
			$where_app = "WHERE IFNULL(approve1,'')='' ";
		}
        if($urutan_app == "2"){
			$where_app = "WHERE IFNULL(approve1,'')<>'' ";
		}
        $sql = "SELECT
                a.*,
                faktur_id,no_faktur,pr_h_id,no_pr,
                r_lensa,new_r_harga,new_r_diskon_persen,new_r_diskon_total,new_r_total,
                l_lensa,new_l_harga,new_l_diskon_persen,new_l_diskon_total,new_l_total,
                new_r_total+new_l_total AS new_total_lensa,pic_input,user_name
            FROM
                db_tol.tbl_upd_prs_faktur a
            LEFT JOIN db_akses.mst_user b ON a.pic_input = b.nip_user

            $where_app
            ORDER BY no_faktur DESC
        ";
		$jum= $this->db_tol->query($sql);
		return $jum->num_rows();
	}


}