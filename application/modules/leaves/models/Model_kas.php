<?php

class Model_kas extends CI_Model
{
	private $hrd;
	function __construct()
	{
		parent::__construct();
		$this->hrd = $this->load->database('gl_mim',TRUE);
        $this->hrd_master = $this->load->database('hrd',TRUE);
	}

	public function headerDok($no_request)
    {
        // - Proses Saat Approve
        // - Saat klik/proses baris data Request yg akan di Approve/reject :
        $sql="SELECT *
                FROM gl_mim.trn_request_h
                WHERE no_request = '".$no_request."'";
        $query = $this->hrd->query($sql);
        // die($this->hrd->last_query());
        return $query->row_array();
    }

    public function detailDok($no_request)
    {
        // - Proses Saat Approve
        // - Saat klik/proses baris data Request yg akan di Approve/reject :
        $sql="SELECT request_d_id ,request_h_id ,
                kode_dept ,no_request ,
                kode_biaya ,nama_biaya ,
                subcabang ,singkatan_cabang ,coa_id ,
                kode_divisi_req ,nama_dept ,
                periode_awal ,periode_akhir ,
                qty ,	satuan , harga_satuan ,
                harga_satuan_sebelumnya,
                total ,	realisasi ,
                nilai_bm ,nilai_bk ,keterangan
                FROM gl_mim.trn_request_d
                WHERE no_request = '".$no_request."'";
        $query = $this->hrd->query($sql);
        // die($this->hrd->last_query());
        return $query->result_array();
    }

    public function appDeptHead()
    {

        $no_req = $this->input->post('no_request');
        $headerReq = $this->Model_kas->headerDok($no_req);
        $detailReq = $this->Model_kas->detailDok($no_req);

		#Simpan Header jika jenis Request KLAIM
        if($headerReq['jenis'] == "KLAIM"){
            $dataHeader = array(
                'total_um'                  => $headerReq['total_um'],
                'total_um_sebelumnya'       => $headerReq['total_um_sebelumnya'],
                'total_biaya'               => $headerReq['total_biaya'],
                'total_biaya_sebelumnya'    => $headerReq['total_biaya_sebelumnya'],
                'is_dept'                   => '1',
                'pic_approve_dept'          => $this->session->userdata('nama_login'),
                'tgl_approve_dept'          => date('Y-m-d H:i:s')
            );

        }else{
			$dataHeader = array(
                'is_dept'                   => '1',
                'pic_approve_dept'          => $this->session->userdata('nama_login'),
                'tgl_approve_dept'          => date('Y-m-d H:i:s')
            );
		}
		$this->hrd->set($dataHeader);
		$this->hrd->where('no_request', $no_req);
		$this->hrd->update('gl_mim.trn_request_h');


        #Simpan Detil jika jenis Request PUM
        # else Simpan Detil jika jenis Request NON PUM
		$count_row = count($detailReq);

		$log = array();
		foreach($detailReq as $detailReq){

			$total      = $detailReq['harga_satuan']*$detailReq['qty'];
			$realisasi  = $detailReq['realisasi'];

			if($headerReq['jenis'] == "PUM"){

				if($realisasi == $total){
					$nilai_bk = '0';
					$nilai_bm = '0';
				}

				if($realisasi > $total){
					$nilai_bk = $realisasi-$total;
					$nilai_bm = $detailReq['nilai_bm'];
				}

				if($realisasi < $total){
					$nilai_bm = $total-$realisasi;
					$nilai_bk = $detailReq['nilai_bk'];
				}

				$dataDetail = array(
					'harga_satuan'                  => $detailReq['harga_satuan'],
					'harga_satuan_sebelumnya'       => $detailReq['harga_satuan_sebelumnya'],
					'total'                         => $detailReq['total'],
					'realisasi'                     => $detailReq['realisasi'],
					'realisasi_sebelumnya'          => $detailReq['realisasi'],
					'nilai_bk'                      => $nilai_bk,
					'nilai_bm'                      => $nilai_bm,
				);
				array_push($log, $dataDetail);

			} else {

				$dataDetail = array(
					'harga_satuan'                  => $detailReq['harga_satuan'],
					'harga_satuan_sebelumnya'       => $detailReq['harga_satuan_sebelumnya'],
					'total'                         => $detailReq['total'],
					'realisasi'                     => $detailReq['realisasi'],
					'realisasi_sebelumnya'          => $detailReq['realisasi'],
				);
				array_push($log, $dataDetail);

			}

			$this->hrd->set($dataDetail);
			$this->hrd->where('no_request', $no_req);
			$this->hrd->where('kode_biaya', $detailReq['kode_biaya']);
			$this->hrd->where('singkatan_cabang', $detailReq['singkatan_cabang']);
			$this->hrd->update('gl_mim.trn_request_d');

		}

		// tesx($dataHeader, $log);

        return ($no_req) ? $no_req : false;
    }

	public function appFinance()
	{
		$no_req = $this->input->post('no_request');
        $headerReq = $this->Model_kas->headerDok($no_req);
		#Proses Saat Approve Finance

		// tesx('tes');
		$dataHeader = array(
			'is_fc'                  => '1',
			'pic_approve_fc'          => $this->session->userdata('nama_login'),
			'tgl_approve_fc'          => date('Y-m-d H:i:s')
		);

		$this->hrd->set($dataHeader);
		$this->hrd->where('no_request', $no_req);
		$this->hrd->update('gl_mim.trn_request_h');

		return ($no_req)?$no_req:false;
	}

	public function appDireksi()
	{
		$no_req = $this->input->post('no_request');
        $headerReq = $this->Model_kas->headerDok($no_req);

		// tesx($no_req, $headerReq['no_request'] );

		$dataHeader = array(
			'posting'                => '1',
			'is_gm'                  => '1',
			'is_approve'             => '1',
			'pic_approve_gm'         => $this->session->userdata('nama_login'),
			'tgl_approve_gm'         => date('Y-m-d H:i:s')
		);

		$this->hrd->set($dataHeader);
		$this->hrd->where('no_request', $no_req);
		$this->hrd->update('gl_mim.trn_request_h');

		return ($no_req)?$no_req:false;
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
		$query = $this->hrd_master->query($sql);
		// die($this->hrd->last_query());
		return $query->row_array();

	}


	/* get datables approval dept head, finance dan direksi */

    public function getDataDeptHead1($dept,$search_no="",$length="",$start="",$column="",$order="")
	{

		$sql = "SELECT
				h.request_h_id ,	h.no_request ,
				h.tgl_request ,	h.jenis ,
				CASE h.jenis
				WHEN 'PUM' THEN h.jenis
				WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
				ELSE mjr.nama_dokumen
				END nama_dokumen,
				CASE h.jenis
				WHEN 'PUM' THEN
						(SELECT h1.tgl_berangkat
								FROM gl_mim.trn_request_h h1
								WHERE h1.no_request = h.no_um
								AND h1.jenis = 'UMPD'
						)
				WHEN 'UMPD' THEN h.tgl_berangkat
				END tgl_berangkat ,
				CASE h.jenis
				WHEN 'PUM' THEN
						(SELECT h1.tgl_pulang
								FROM gl_mim.trn_request_h h1
								WHERE h1.no_request = h.no_um
								AND h1.jenis = 'UMPD'
						)
				WHEN 'UMPD' THEN h.tgl_pulang
				END tgl_pulang ,
				h.no_um ,
				h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
				h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
				h.kode_divisi_req ,
				h.total_biaya ,	h.total_um ,	h.selisih ,
				h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
				h.keterangan , h.wkt_input,
				h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
				h.is_kas ,h.reimburse ,h.referenced , h.is_pum
			FROM gl_mim.trn_request_h h
			INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
			INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
			WHERE
			dept.kode_dept_induk = '$dept'
			AND h.jenis IN ('KLAIM','UM','UMPD')
			AND h.is_dept   = 0
			AND h.is_kas    = 0
			AND h.is_reject = 0
			UNION ALL
			SELECT
				h.request_h_id ,	h.no_request ,
				h.tgl_request ,	h.jenis ,
				CASE h.jenis
				WHEN 'PUM' THEN h.jenis
				WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
				ELSE mjr.nama_dokumen
				END nama_dokumen,
				um.tgl_berangkat ,	um.tgl_pulang ,
				CONCAT(h.no_um,' (PD)') no_um,
				h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
				h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
				h.kode_divisi_req ,
				h.total_biaya ,	h.total_um ,	h.selisih ,
				h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
				h.keterangan ,  h.wkt_input,
				h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
				h.is_kas ,h.reimburse ,h.referenced , h.is_pum
			FROM gl_mim.trn_request_h h
			INNER JOIN (
				SELECT um.no_request,um.jenis,um.kode_dept_req ,
					um.tgl_berangkat,um.tgl_pulang
				FROM gl_mim.trn_request_h um
				WHERE um.jenis = 'UMPD'
				AND um.referenced = 1
				AND um.is_reject = 0
				AND um.is_approve = 1
			) um ON um.no_request = h.no_um
			INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
			INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
			WHERE h.jenis = 'PUM'
			AND dept.kode_dept_induk = '$dept'
			AND h.is_validasi_ga = 1
			AND h.is_dept   = 0
			AND h.is_kas    = 0
			AND h.is_reject = 0
			UNION ALL
			SELECT
				h.request_h_id ,	h.no_request ,
				h.tgl_request ,	h.jenis ,
				CASE h.jenis
				WHEN 'PUM' THEN h.jenis
				WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
				ELSE mjr.nama_dokumen
				END nama_dokumen,
				CASE h.jenis
				WHEN 'PUM' THEN
						(SELECT h1.tgl_berangkat
								FROM gl_mim.trn_request_h h1
								WHERE h1.no_request = h.no_um
								AND h1.jenis ='UMPD'
						)
				END tgl_berangkat ,
				CASE h.jenis
				WHEN 'PUM' THEN
						(SELECT h1.tgl_pulang
								FROM gl_mim.trn_request_h h1
								WHERE h1.no_request = h.no_um
								AND h1.jenis ='UMPD'
						)
				END tgl_pulang ,
				CONCAT(h.no_um,' (UM)') no_um ,
				h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
				h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
				h.kode_divisi_req ,
				h.total_biaya ,	h.total_um ,	h.selisih ,
				h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
				h.keterangan ,  h.wkt_input,
				h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
				h.is_kas ,h.reimburse ,h.referenced , h.is_pum
			FROM gl_mim.trn_request_h h
			INNER JOIN (
				SELECT um.no_request,um.jenis,um.kode_dept_req ,
					um.tgl_berangkat,um.tgl_pulang
				FROM gl_mim.trn_request_h um
				WHERE um.jenis = 'UM'
				AND um.referenced = 1
				AND um.is_reject = 0
				AND um.is_approve = 1
			) um ON um.no_request = h.no_um
			INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
			INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
			WHERE h.jenis = 'PUM'
			AND dept.kode_dept_induk = '$dept'
			AND h.is_dept   = 0
			AND h.is_kas    = 0
			AND h.is_reject = 0
			ORDER BY wkt_input DESC
			LIMIT $start,$length
		";

		$query = $this->hrd->query($sql);
		// die(nl2br($this->hrd->last_query()));
		return $query->result_array();

	}

	public function getDataDeptHead2($dept,$search_no = "")
	{

		$sql = "SELECT
				h.request_h_id ,	h.no_request ,
				h.tgl_request ,	h.jenis ,
				CASE h.jenis
				WHEN 'PUM' THEN h.jenis
				WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
				ELSE mjr.nama_dokumen
				END nama_dokumen,
				CASE h.jenis
				WHEN 'PUM' THEN
						(SELECT h1.tgl_berangkat
								FROM gl_mim.trn_request_h h1
								WHERE h1.no_request = h.no_um
								AND h1.jenis = 'UMPD'
						)
				WHEN 'UMPD' THEN h.tgl_berangkat
				END tgl_berangkat ,
				CASE h.jenis
				WHEN 'PUM' THEN
						(SELECT h1.tgl_pulang
								FROM gl_mim.trn_request_h h1
								WHERE h1.no_request = h.no_um
								AND h1.jenis = 'UMPD'
						)
				WHEN 'UMPD' THEN h.tgl_pulang
				END tgl_pulang ,
				h.no_um ,
				h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
				h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
				h.kode_divisi_req ,
				h.total_biaya ,	h.total_um ,	h.selisih ,
				h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
				h.keterangan , h.wkt_input,
				h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
				h.is_kas ,h.reimburse ,h.referenced , h.is_pum
			FROM gl_mim.trn_request_h h
			INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
			INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
			WHERE
			dept.kode_dept_induk = '$dept'
			AND h.jenis IN ('KLAIM','UM','UMPD')
			AND h.is_dept   = 0
			AND h.is_kas    = 0
			AND h.is_reject = 0
			UNION ALL
			SELECT
				h.request_h_id ,	h.no_request ,
				h.tgl_request ,	h.jenis ,
				CASE h.jenis
				WHEN 'PUM' THEN h.jenis
				WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
				ELSE mjr.nama_dokumen
				END nama_dokumen,
				um.tgl_berangkat ,	um.tgl_pulang ,
				CONCAT(h.no_um,' (PD)') no_um,
				h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
				h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
				h.kode_divisi_req ,
				h.total_biaya ,	h.total_um ,	h.selisih ,
				h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
				h.keterangan ,  h.wkt_input,
				h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
				h.is_kas ,h.reimburse ,h.referenced , h.is_pum
			FROM gl_mim.trn_request_h h
			INNER JOIN (
				SELECT um.no_request,um.jenis,um.kode_dept_req ,
					um.tgl_berangkat,um.tgl_pulang
				FROM gl_mim.trn_request_h um
				WHERE um.jenis = 'UMPD'
				AND um.referenced = 1
				AND um.is_reject = 0
				AND um.is_approve = 1
			) um ON um.no_request = h.no_um
			INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
			INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
			WHERE h.jenis = 'PUM'
			AND dept.kode_dept_induk = '$dept'
			AND h.is_validasi_ga = 1
			AND h.is_dept   = 0
			AND h.is_kas    = 0
			AND h.is_reject = 0
			UNION ALL
			SELECT
				h.request_h_id ,	h.no_request ,
				h.tgl_request ,	h.jenis ,
				CASE h.jenis
				WHEN 'PUM' THEN h.jenis
				WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
				ELSE mjr.nama_dokumen
				END nama_dokumen,
				CASE h.jenis
				WHEN 'PUM' THEN
						(SELECT h1.tgl_berangkat
								FROM gl_mim.trn_request_h h1
								WHERE h1.no_request = h.no_um
								AND h1.jenis ='UMPD'
						)
				END tgl_berangkat ,
				CASE h.jenis
				WHEN 'PUM' THEN
						(SELECT h1.tgl_pulang
								FROM gl_mim.trn_request_h h1
								WHERE h1.no_request = h.no_um
								AND h1.jenis ='UMPD'
						)
				END tgl_pulang ,
				CONCAT(h.no_um,' (UM)') no_um ,
				h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
				h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
				h.kode_divisi_req ,
				h.total_biaya ,	h.total_um ,	h.selisih ,
				h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
				h.keterangan ,  h.wkt_input,
				h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
				h.is_kas ,h.reimburse ,h.referenced , h.is_pum
			FROM gl_mim.trn_request_h h
			INNER JOIN (
				SELECT um.no_request,um.jenis,um.kode_dept_req ,
					um.tgl_berangkat,um.tgl_pulang
				FROM gl_mim.trn_request_h um
				WHERE um.jenis = 'UM'
				AND um.referenced = 1
				AND um.is_reject = 0
				AND um.is_approve = 1
			) um ON um.no_request = h.no_um
			INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
			INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
			WHERE h.jenis = 'PUM'
			AND dept.kode_dept_induk = '$dept'
			AND h.is_dept   = 0
			AND h.is_kas    = 0
			AND h.is_reject = 0
		";
		$jum= $this->hrd->query($sql);
		return $jum->num_rows();
	}

	public function getDataDeptHistory1($dept,$search_no="",$length="",$start="",$column="",$order="")
	{

		$sql = "SELECT
				h.request_h_id ,	h.no_request ,
				h.tgl_request ,	h.jenis ,
				CASE h.jenis
				WHEN 'PUM' THEN h.jenis
				WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
				ELSE mjr.nama_dokumen
				END nama_dokumen,
				CASE h.jenis
				WHEN 'PUM' THEN
						(SELECT h1.tgl_berangkat
								FROM gl_mim.trn_request_h h1
								WHERE h1.no_request = h.no_um
								AND h1.jenis = 'UMPD'
						)
				WHEN 'UMPD' THEN h.tgl_berangkat
				END tgl_berangkat ,
				CASE h.jenis
				WHEN 'PUM' THEN
						(SELECT h1.tgl_pulang
								FROM gl_mim.trn_request_h h1
								WHERE h1.no_request = h.no_um
								AND h1.jenis = 'UMPD'
						)
				WHEN 'UMPD' THEN h.tgl_pulang
				END tgl_pulang ,
				h.no_um ,
				h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
				h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
				h.kode_divisi_req ,
				h.total_biaya ,	h.total_um ,	h.selisih ,
				h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
				h.keterangan , h.wkt_input,
				h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
				h.is_kas ,h.reimburse ,h.referenced , h.is_pum
			FROM gl_mim.trn_request_h h
			INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
			INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
			WHERE
			dept.kode_dept_induk = '$dept'
			AND h.jenis IN ('KLAIM','UM','UMPD')
			AND h.is_dept   = 1
			AND h.is_kas    = 0
			AND h.is_reject = 0
			UNION ALL
			SELECT
				h.request_h_id ,	h.no_request ,
				h.tgl_request ,	h.jenis ,
				CASE h.jenis
				WHEN 'PUM' THEN h.jenis
				WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
				ELSE mjr.nama_dokumen
				END nama_dokumen,
				um.tgl_berangkat ,	um.tgl_pulang ,
				CONCAT(h.no_um,' (PD)') no_um,
				h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
				h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
				h.kode_divisi_req ,
				h.total_biaya ,	h.total_um ,	h.selisih ,
				h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
				h.keterangan ,  h.wkt_input,
				h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
				h.is_kas ,h.reimburse ,h.referenced , h.is_pum
			FROM gl_mim.trn_request_h h
			INNER JOIN (
				SELECT um.no_request,um.jenis,um.kode_dept_req ,
					um.tgl_berangkat,um.tgl_pulang
				FROM gl_mim.trn_request_h um
				WHERE um.jenis = 'UMPD'
				AND um.referenced = 1
				AND um.is_reject = 0
				AND um.is_approve = 1
			) um ON um.no_request = h.no_um
			INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
			INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
			WHERE h.jenis = 'PUM'
			AND dept.kode_dept_induk = '$dept'
			AND h.is_validasi_ga = 1
			AND h.is_dept   = 1
			AND h.is_kas    = 0
			AND h.is_reject = 0
			UNION ALL
			SELECT
				h.request_h_id ,	h.no_request ,
				h.tgl_request ,	h.jenis ,
				CASE h.jenis
				WHEN 'PUM' THEN h.jenis
				WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
				ELSE mjr.nama_dokumen
				END nama_dokumen,
				CASE h.jenis
				WHEN 'PUM' THEN
						(SELECT h1.tgl_berangkat
								FROM gl_mim.trn_request_h h1
								WHERE h1.no_request = h.no_um
								AND h1.jenis ='UMPD'
						)
				END tgl_berangkat ,
				CASE h.jenis
				WHEN 'PUM' THEN
						(SELECT h1.tgl_pulang
								FROM gl_mim.trn_request_h h1
								WHERE h1.no_request = h.no_um
								AND h1.jenis ='UMPD'
						)
				END tgl_pulang ,
				CONCAT(h.no_um,' (UM)') no_um ,
				h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
				h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
				h.kode_divisi_req ,
				h.total_biaya ,	h.total_um ,	h.selisih ,
				h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
				h.keterangan ,  h.wkt_input,
				h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
				h.is_kas ,h.reimburse ,h.referenced , h.is_pum
			FROM gl_mim.trn_request_h h
			INNER JOIN (
				SELECT um.no_request,um.jenis,um.kode_dept_req ,
					um.tgl_berangkat,um.tgl_pulang
				FROM gl_mim.trn_request_h um
				WHERE um.jenis = 'UM'
				AND um.referenced = 1
				AND um.is_reject = 0
				AND um.is_approve = 1
			) um ON um.no_request = h.no_um
			INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
			INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
			WHERE h.jenis = 'PUM'
			AND dept.kode_dept_induk = '$dept'
			AND h.is_dept   = 1
			AND h.is_kas    = 0
			AND h.is_reject = 0
			ORDER BY wkt_input DESC
			LIMIT $start,$length
		";

		$query = $this->hrd->query($sql);
		// die(nl2br($this->hrd->last_query()));
		return $query->result_array();

	}

	public function getDataDeptHistory2($dept,$search_no = "")
	{

		$sql = "SELECT
				h.request_h_id ,	h.no_request ,
				h.tgl_request ,	h.jenis ,
				CASE h.jenis
				WHEN 'PUM' THEN h.jenis
				WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
				ELSE mjr.nama_dokumen
				END nama_dokumen,
				CASE h.jenis
				WHEN 'PUM' THEN
						(SELECT h1.tgl_berangkat
								FROM gl_mim.trn_request_h h1
								WHERE h1.no_request = h.no_um
								AND h1.jenis = 'UMPD'
						)
				WHEN 'UMPD' THEN h.tgl_berangkat
				END tgl_berangkat ,
				CASE h.jenis
				WHEN 'PUM' THEN
						(SELECT h1.tgl_pulang
								FROM gl_mim.trn_request_h h1
								WHERE h1.no_request = h.no_um
								AND h1.jenis = 'UMPD'
						)
				WHEN 'UMPD' THEN h.tgl_pulang
				END tgl_pulang ,
				h.no_um ,
				h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
				h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
				h.kode_divisi_req ,
				h.total_biaya ,	h.total_um ,	h.selisih ,
				h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
				h.keterangan , h.wkt_input,
				h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
				h.is_kas ,h.reimburse ,h.referenced , h.is_pum
			FROM gl_mim.trn_request_h h
			INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
			INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
			WHERE
			dept.kode_dept_induk = '$dept'
			AND h.jenis IN ('KLAIM','UM','UMPD')
			AND h.is_dept   = 1
			AND h.is_kas    = 0
			AND h.is_reject = 0
			UNION ALL
			SELECT
				h.request_h_id ,	h.no_request ,
				h.tgl_request ,	h.jenis ,
				CASE h.jenis
				WHEN 'PUM' THEN h.jenis
				WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
				ELSE mjr.nama_dokumen
				END nama_dokumen,
				um.tgl_berangkat ,	um.tgl_pulang ,
				CONCAT(h.no_um,' (PD)') no_um,
				h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
				h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
				h.kode_divisi_req ,
				h.total_biaya ,	h.total_um ,	h.selisih ,
				h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
				h.keterangan ,  h.wkt_input,
				h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
				h.is_kas ,h.reimburse ,h.referenced , h.is_pum
			FROM gl_mim.trn_request_h h
			INNER JOIN (
				SELECT um.no_request,um.jenis,um.kode_dept_req ,
					um.tgl_berangkat,um.tgl_pulang
				FROM gl_mim.trn_request_h um
				WHERE um.jenis = 'UMPD'
				AND um.referenced = 1
				AND um.is_reject = 0
				AND um.is_approve = 1
			) um ON um.no_request = h.no_um
			INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
			INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
			WHERE h.jenis = 'PUM'
			AND dept.kode_dept_induk = '$dept'
			AND h.is_validasi_ga = 1
			AND h.is_dept   = 1
			AND h.is_kas    = 0
			AND h.is_reject = 0
			UNION ALL
			SELECT
				h.request_h_id ,	h.no_request ,
				h.tgl_request ,	h.jenis ,
				CASE h.jenis
				WHEN 'PUM' THEN h.jenis
				WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
				ELSE mjr.nama_dokumen
				END nama_dokumen,
				CASE h.jenis
				WHEN 'PUM' THEN
						(SELECT h1.tgl_berangkat
								FROM gl_mim.trn_request_h h1
								WHERE h1.no_request = h.no_um
								AND h1.jenis ='UMPD'
						)
				END tgl_berangkat ,
				CASE h.jenis
				WHEN 'PUM' THEN
						(SELECT h1.tgl_pulang
								FROM gl_mim.trn_request_h h1
								WHERE h1.no_request = h.no_um
								AND h1.jenis ='UMPD'
						)
				END tgl_pulang ,
				CONCAT(h.no_um,' (UM)') no_um ,
				h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
				h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
				h.kode_divisi_req ,
				h.total_biaya ,	h.total_um ,	h.selisih ,
				h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
				h.keterangan ,  h.wkt_input,
				h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
				h.is_kas ,h.reimburse ,h.referenced , h.is_pum
			FROM gl_mim.trn_request_h h
			INNER JOIN (
				SELECT um.no_request,um.jenis,um.kode_dept_req ,
					um.tgl_berangkat,um.tgl_pulang
				FROM gl_mim.trn_request_h um
				WHERE um.jenis = 'UM'
				AND um.referenced = 1
				AND um.is_reject = 0
				AND um.is_approve = 1
			) um ON um.no_request = h.no_um
			INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
			INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
			WHERE h.jenis = 'PUM'
			AND dept.kode_dept_induk = '$dept'
			AND h.is_dept   = 1
			AND h.is_kas    = 0
			AND h.is_reject = 0
		";
		$jum= $this->hrd->query($sql);
		return $jum->num_rows();
	}

	public function getDataFinance1($divisi,$search_no="",$length="",$start="",$column="",$order="")
	{
		$sql = "SELECT
				h.request_h_id ,	h.no_request ,
				h.tgl_request ,	h.jenis ,
				CASE h.jenis
				WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
				ELSE h.jenis
				END nama_dokumen,
				CASE h.jenis
				WHEN 'PUM' THEN
						(SELECT h1.tgl_berangkat 
								FROM gl_mim.trn_request_h h1
								WHERE h1.no_request = h.no_um 
								AND h1.jenis ='UMPD' 
						) 
				WHEN 'UMPD' THEN h.tgl_berangkat 
				END tgl_berangkat , 
				CASE h.jenis 
				WHEN 'PUM' THEN 
						(SELECT h1.tgl_pulang 
								FROM gl_mim.trn_request_h h1
								WHERE h1.no_request = h.no_um 
								AND h1.jenis ='UMPD' 
						) 
				WHEN 'UMPD' THEN h.tgl_pulang 
				END tgl_pulang , 
				h.no_um , 
				h.biodata_req_id ,	h.nip_req ,	h.nama_req , 
				h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req , 
				h.kode_divisi_req , 
				h.total_biaya ,	h.total_um ,	h.selisih , 
				h.supplier_id ,	h.kode_supplier ,	h.nama_supplier , 
				h.keterangan , h.wkt_input, 
				h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa , 
				h.is_kas ,h.reimburse ,h.referenced , h.is_pum 
			FROM gl_mim.trn_request_h h 
			INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis 
			INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req 
			WHERE 
			h.jenis IN ('KLAIM','UM','UMPD') 
			AND h.is_dept   = 1 
			AND h.is_fc   = 0 
			AND h.is_kas    = 0 
			AND h.is_reject = 0 
			UNION ALL 
			SELECT 
				h.request_h_id ,	h.no_request , 
				h.tgl_request ,	h.jenis , 
				CASE h.jenis 
				WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
				ELSE h.jenis 
				END nama_dokumen,  

				um.tgl_berangkat ,	um.tgl_pulang ,	
				CONCAT(h.no_um,' (PD)') no_um , 
				h.biodata_req_id ,	h.nip_req ,	h.nama_req , 
				h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req , 
				h.kode_divisi_req , 
				h.total_biaya ,	h.total_um ,	h.selisih , 
				h.supplier_id ,	h.kode_supplier ,	h.nama_supplier , 
				h.keterangan ,  h.wkt_input, 
				h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa , 
				h.is_kas ,h.reimburse ,h.referenced , h.is_pum 
			FROM gl_mim.trn_request_h h
			INNER JOIN (
				SELECT um.no_request,um.jenis,um.kode_dept_req ,
					um.tgl_berangkat,um.tgl_pulang
				FROM gl_mim.trn_request_h um
				WHERE um.jenis = 'UMPD'
				AND um.referenced = 1
				AND um.is_reject = 0
				AND um.is_approve = 1
			) um ON um.no_request = h.no_um
			INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
			INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
			WHERE h.jenis = 'PUM'
			AND h.is_validasi_ga = 1
			AND h.is_dept   = 1
			AND h.is_fc   = 0
			AND h.is_kas    = 0
			AND h.is_reject = 0
			UNION ALL
			SELECT
				h.request_h_id ,	h.no_request ,
				h.tgl_request ,	h.jenis ,
				CASE h.jenis
				WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
				ELSE h.jenis
				END nama_dokumen,
				CASE h.jenis
				WHEN 'PUM' THEN
						(SELECT h1.tgl_berangkat
								FROM gl_mim.trn_request_h h1
								WHERE h1.no_request = h.no_um
								AND h1.jenis ='UMPD'
						)
				END tgl_berangkat ,
				CASE h.jenis
				WHEN 'PUM' THEN
						(SELECT h1.tgl_pulang
								FROM gl_mim.trn_request_h h1
								WHERE h1.no_request = h.no_um
								AND h1.jenis ='UMPD'
						)
				END tgl_pulang ,
				CONCAT(h.no_um,' (UM)') no_um ,
				h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
				h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
				h.kode_divisi_req ,
				h.total_biaya ,	h.total_um ,	h.selisih ,
				h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
				h.keterangan ,  h.wkt_input,
				h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
				h.is_kas ,h.reimburse ,h.referenced , h.is_pum
			FROM gl_mim.trn_request_h h
			INNER JOIN (
				SELECT um.no_request,um.jenis,um.kode_dept_req ,
					um.tgl_berangkat,um.tgl_pulang
				FROM gl_mim.trn_request_h um
				WHERE um.jenis = 'UM'
				AND um.referenced = 1
				AND um.is_reject = 0
				AND um.is_approve = 1
			) um ON um.no_request = h.no_um
			INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
			INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
			WHERE h.jenis = 'PUM'
			AND h.is_dept   = 1
			AND h.is_fc   = 0
			AND h.is_kas    = 0
			AND h.is_reject = 0
			ORDER BY wkt_input DESC
			LIMIT $start,$length
		";

		$query = $this->hrd->query($sql);
		// die(nl2br($this->hrd->last_query()));
		return $query->result_array();

	}

	public function getDataFinance2($divisi,$search_no = "")
	{
		$sql = "SELECT
				h.request_h_id ,	h.no_request ,
				h.tgl_request ,	h.jenis ,
				CASE h.jenis
				WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
				ELSE h.jenis
				END nama_dokumen,
				CASE h.jenis
				WHEN 'PUM' THEN
						(SELECT h1.tgl_berangkat 
								FROM gl_mim.trn_request_h h1
								WHERE h1.no_request = h.no_um 
								AND h1.jenis ='UMPD' 
						) 
				WHEN 'UMPD' THEN h.tgl_berangkat 
				END tgl_berangkat , 
				CASE h.jenis 
				WHEN 'PUM' THEN 
						(SELECT h1.tgl_pulang 
								FROM gl_mim.trn_request_h h1
								WHERE h1.no_request = h.no_um 
								AND h1.jenis ='UMPD' 
						) 
				WHEN 'UMPD' THEN h.tgl_pulang 
				END tgl_pulang , 
				h.no_um , 
				h.biodata_req_id ,	h.nip_req ,	h.nama_req , 
				h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req , 
				h.kode_divisi_req , 
				h.total_biaya ,	h.total_um ,	h.selisih , 
				h.supplier_id ,	h.kode_supplier ,	h.nama_supplier , 
				h.keterangan , h.wkt_input, 
				h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa , 
				h.is_kas ,h.reimburse ,h.referenced , h.is_pum 
			FROM gl_mim.trn_request_h h 
			INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis 
			INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req 
			WHERE 
			h.jenis IN ('KLAIM','UM','UMPD') 
			AND h.is_dept   = 1 
			AND h.is_fc   = 0 
			AND h.is_kas    = 0 
			AND h.is_reject = 0 
			UNION ALL 
			SELECT 
				h.request_h_id ,	h.no_request , 
				h.tgl_request ,	h.jenis , 
				CASE h.jenis 
				WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
				ELSE h.jenis 
				END nama_dokumen,  

				um.tgl_berangkat ,	um.tgl_pulang ,	
				CONCAT(h.no_um,' (PD)') no_um , 
				h.biodata_req_id ,	h.nip_req ,	h.nama_req , 
				h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req , 
				h.kode_divisi_req , 
				h.total_biaya ,	h.total_um ,	h.selisih , 
				h.supplier_id ,	h.kode_supplier ,	h.nama_supplier , 
				h.keterangan ,  h.wkt_input, 
				h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa , 
				h.is_kas ,h.reimburse ,h.referenced , h.is_pum 
			FROM gl_mim.trn_request_h h
			INNER JOIN (
				SELECT um.no_request,um.jenis,um.kode_dept_req ,
					um.tgl_berangkat,um.tgl_pulang
				FROM gl_mim.trn_request_h um
				WHERE um.jenis = 'UMPD'
				AND um.referenced = 1
				AND um.is_reject = 0
				AND um.is_approve = 1
			) um ON um.no_request = h.no_um
			INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
			INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
			WHERE h.jenis = 'PUM'
			AND h.is_validasi_ga = 1
			AND h.is_dept   = 1
			AND h.is_fc   = 0
			AND h.is_kas    = 0
			AND h.is_reject = 0
			UNION ALL
			SELECT
				h.request_h_id ,	h.no_request ,
				h.tgl_request ,	h.jenis ,
				CASE h.jenis
				WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
				ELSE h.jenis
				END nama_dokumen,
				CASE h.jenis
				WHEN 'PUM' THEN
						(SELECT h1.tgl_berangkat
								FROM gl_mim.trn_request_h h1
								WHERE h1.no_request = h.no_um
								AND h1.jenis ='UMPD'
						)
				END tgl_berangkat ,
				CASE h.jenis
				WHEN 'PUM' THEN
						(SELECT h1.tgl_pulang
								FROM gl_mim.trn_request_h h1
								WHERE h1.no_request = h.no_um
								AND h1.jenis ='UMPD'
						)
				END tgl_pulang ,
				CONCAT(h.no_um,' (UM)') no_um ,
				h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
				h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
				h.kode_divisi_req ,
				h.total_biaya ,	h.total_um ,	h.selisih ,
				h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
				h.keterangan ,  h.wkt_input,
				h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
				h.is_kas ,h.reimburse ,h.referenced , h.is_pum
			FROM gl_mim.trn_request_h h
			INNER JOIN (
				SELECT um.no_request,um.jenis,um.kode_dept_req ,
					um.tgl_berangkat,um.tgl_pulang
				FROM gl_mim.trn_request_h um
				WHERE um.jenis = 'UM'
				AND um.referenced = 1
				AND um.is_reject = 0
				AND um.is_approve = 1
			) um ON um.no_request = h.no_um
			INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
			INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req
			WHERE h.jenis = 'PUM'
			AND h.is_dept   = 1
			AND h.is_fc   = 0
			AND h.is_kas    = 0
			AND h.is_reject = 0
		";
		$jum= $this->hrd->query($sql);
		return $jum->num_rows();
	}

	public function getHistoryFinance1($divisi,$search_no="",$no_req="",$nama_req="",$length="",$start="",$column="",$order="")
	{
		$where_no_req = "";
		if($no_req !== ""){
			$where_no_req = "AND h.no_request LIKE '%".$no_req."%'";
		}
		$where_nama_req = "";
		if($nama_req !== ""){
			$where_nama_req = "AND h.nama_req LIKE '%".$nama_req."%'";
		}
		$sql = "SELECT 
					xy.request_h_id ,	xy.no_request , 
					xy.tgl_request ,	xy.jenis ,
					CASE xy.jenis WHEN 'UMPD' THEN 'UM PERJALANAN DINAS' ELSE xy.jenis END nama_dokumen,  
				CASE xy.jenis WHEN 'PUM' THEN (SELECT h1.tgl_berangkat 
								FROM gl_mim.trn_request_h h1
								WHERE h1.no_request = xy.no_um 
								AND h1.jenis ='UMPD' 
					) 
				WHEN 'UMPD' THEN xy.tgl_berangkat 
				END tgl_berangkat , 
				CASE xy.jenis 
				WHEN 'PUM' THEN 
						(SELECT h1.tgl_pulang 
								FROM gl_mim.trn_request_h h1
								WHERE h1.no_request = xy.no_um 
								AND h1.jenis ='UMPD' 
						) 
				WHEN 'UMPD' THEN xy.tgl_pulang 
				END tgl_pulang , 
					CASE xy.jenis  
					WHEN 'PUM' THEN CONCAT(xy.no_um,' (',z.jenis,')')  END no_um, 
					xy.biodata_req_id ,	xy.nip_req ,	xy.nama_req , 
					xy.dept_id_req ,	xy.kode_dept_req, xy.nama_dept_req, 
					xy.kode_divisi_req ,xy.tgl_approve_dept, xy.tgl_reject, 
					xy.total_biaya ,	xy.total_um ,	xy.selisih , 
					xy.supplier_id ,	xy.kode_supplier ,	xy.nama_supplier , 
					xy.keterangan , xy.wkt_input, 		xy.is_reject, 
					xy.is_approve, xy.is_dept, xy.keterangan_reject, 
					xy.is_fc ,xy.is_gm ,xy.is_fa , xy.tgl_approve_fc,pic_approve_fc, 
					xy.is_kas ,xy.reimburse ,xy.referenced , xy.is_pum 
				FROM gl_mim.trn_request_h xy 
				INNER JOIN ( 
				SELECT 
					h.request_h_id ,	h.no_request ,      h.tgl_request ,	
					mjr.nama_dokumen,      h.tgl_berangkat ,	h.tgl_pulang ,	     h.no_um ,      h.biodata_req_id ,	h.nip_req ,	h.nama_req , 
					h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,      h.kode_divisi_req , h.jenis,
						h.total_biaya ,	h.total_um ,	h.selisih ,      h.supplier_id ,	h.kode_supplier ,	h.nama_supplier , 
					h.keterangan , h.wkt_input, 		h.is_reject,      h.is_approve, h.is_dept, 
					h.is_fc ,h.is_gm ,h.is_fa ,      h.is_kas ,h.reimburse ,h.referenced , h.is_pum 
				FROM gl_mim.trn_request_h h 
				INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis 
				WHERE  h.jenis IN ('KLAIM','UM','UMPD') 
				AND h.is_dept   = 1 
				AND h.is_kas    = 0 
				AND (h.is_reject = 1  OR h.is_fc  = 1 ) 
				$where_no_req
				$where_nama_req
			
				UNION ALL 
				SELECT 
					h.request_h_id ,	h.no_request , 
					h.tgl_request ,	
			
					mjr.nama_dokumen, 
					um.tgl_berangkat ,	um.tgl_pulang ,	h.no_um , 
					h.biodata_req_id ,	h.nip_req ,	h.nama_req , 
					h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req , 
					h.kode_divisi_req , 
					um.jenis, 
					h.total_biaya ,	h.total_um ,	h.selisih , 
					h.supplier_id ,	h.kode_supplier ,	h.nama_supplier , 
					h.keterangan ,  h.wkt_input, 
					h.is_reject,h.is_approve ,h.is_dept, 
					h.is_fc ,h.is_gm ,h.is_fa , 
					h.is_kas ,h.reimburse ,h.referenced , h.is_pum 
				FROM gl_mim.trn_request_h h 
				LEFT JOIN ( 
					SELECT um.no_request,um.kode_dept_req , 
						um.tgl_berangkat,um.tgl_pulang, 'PD' jenis 
					FROM gl_mim.trn_request_h um 
					WHERE um.jenis = 'UMPD' 
			
					AND um.is_approve = 1 
			
				) um ON um.no_request = h.no_um  
				INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis 
				INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req 
				WHERE h.jenis = 'PUM' 
			
				AND h.is_validasi_ga = 1 
				AND h.is_dept    = 1 
				AND h.is_kas    = 0 
				AND (h.is_reject = 1  OR h.is_fc   = 1 )
				$where_no_req
				$where_nama_req
			
				UNION ALL 
				SELECT 
					h.request_h_id ,	h.no_request , 
					h.tgl_request ,	
			
					mjr.nama_dokumen, 
					um.tgl_berangkat ,	um.tgl_pulang ,	h.no_um , 
					h.biodata_req_id ,	h.nip_req ,	h.nama_req , 
					h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req , 
					h.kode_divisi_req , um.jenis, 
					h.total_biaya ,	h.total_um ,	h.selisih , 
					h.supplier_id ,	h.kode_supplier ,	h.nama_supplier , 
					h.keterangan ,  h.wkt_input, 
					h.is_reject,h.is_approve ,h.is_dept, 
					h.is_fc ,h.is_gm ,h.is_fa , 
					h.is_kas ,h.reimburse ,h.referenced , h.is_pum 
				FROM gl_mim.trn_request_h h 
				INNER JOIN ( 
					SELECT um.no_request,um.kode_dept_req , 
						um.tgl_berangkat,um.tgl_pulang,'UM' jenis 
					FROM gl_mim.trn_request_h um 
					WHERE um.jenis = 'UM' 
			
					AND um.is_approve = 1 
			
				) um ON um.no_request = h.no_um 
				INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis 
				INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req 
				WHERE h.jenis = 'PUM' 
			
				AND h.is_dept    = 1 
				AND h.is_kas    = 0 
				AND (h.is_reject = 1  OR h.is_fc   = 1 )
				
				$where_no_req
				$where_nama_req

				) z ON z.no_request = xy.no_request
				ORDER BY xy.wkt_input DESC
			LIMIT $start,$length
		";

		$query = $this->hrd->query($sql);
		// die(nl2br($this->hrd->last_query()));
		return $query->result_array();

	}

	public function getHistoryFinance2($divisi,$search_no="",$no_req="",$nama_req="")
	{
		$where_no_req = "";
		if($no_req !== ""){
			$where_no_req = "AND h.no_request LIKE '%".$no_req."%'";
		}
		$where_nama_req = "";
		if($nama_req !== ""){
			$where_nama_req = "AND h.nama_req LIKE '%".$nama_req."%'";
		}
		$sql = "SELECT 
					xy.request_h_id ,	xy.no_request , 
					xy.tgl_request ,	xy.jenis ,
					CASE xy.jenis WHEN 'UMPD' THEN 'UM PERJALANAN DINAS' ELSE xy.jenis END nama_dokumen,  
				CASE xy.jenis WHEN 'PUM' THEN (SELECT h1.tgl_berangkat 
								FROM gl_mim.trn_request_h h1
								WHERE h1.no_request = xy.no_um 
								AND h1.jenis ='UMPD' 
					) 
				WHEN 'UMPD' THEN xy.tgl_berangkat 
				END tgl_berangkat , 
				CASE xy.jenis 
				WHEN 'PUM' THEN 
						(SELECT h1.tgl_pulang 
								FROM gl_mim.trn_request_h h1
								WHERE h1.no_request = xy.no_um 
								AND h1.jenis ='UMPD' 
						) 
				WHEN 'UMPD' THEN xy.tgl_pulang 
				END tgl_pulang , 
					CASE xy.jenis  
					WHEN 'PUM' THEN CONCAT(xy.no_um,' (',z.jenis,')')  END no_um, 
					xy.biodata_req_id ,	xy.nip_req ,	xy.nama_req , 
					xy.dept_id_req ,	xy.kode_dept_req, xy.nama_dept_req, 
					xy.kode_divisi_req ,xy.tgl_approve_dept, xy.tgl_reject, 
					xy.total_biaya ,	xy.total_um ,	xy.selisih , 
					xy.supplier_id ,	xy.kode_supplier ,	xy.nama_supplier , 
					xy.keterangan , xy.wkt_input, 		xy.is_reject, 
					xy.is_approve, xy.is_dept, xy.keterangan_reject, 
					xy.is_fc ,xy.is_gm ,xy.is_fa , xy.tgl_approve_fc,pic_approve_fc, 
					xy.is_kas ,xy.reimburse ,xy.referenced , xy.is_pum 
				FROM gl_mim.trn_request_h xy 
				INNER JOIN ( 
				SELECT 
					h.request_h_id ,	h.no_request ,      h.tgl_request ,	
					mjr.nama_dokumen,      h.tgl_berangkat ,	h.tgl_pulang ,	     h.no_um ,      h.biodata_req_id ,	h.nip_req ,	h.nama_req , 
					h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,      h.kode_divisi_req , h.jenis,
						h.total_biaya ,	h.total_um ,	h.selisih ,      h.supplier_id ,	h.kode_supplier ,	h.nama_supplier , 
					h.keterangan , h.wkt_input, 		h.is_reject,      h.is_approve, h.is_dept, 
					h.is_fc ,h.is_gm ,h.is_fa ,      h.is_kas ,h.reimburse ,h.referenced , h.is_pum 
				FROM gl_mim.trn_request_h h 
				INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis 
				WHERE  h.jenis IN ('KLAIM','UM','UMPD') 
				AND h.is_dept   = 1 
				AND h.is_kas    = 0 
				AND (h.is_reject = 1  OR h.is_fc  = 1 ) 
				$where_no_req
				$where_nama_req

				UNION ALL 
				SELECT 
					h.request_h_id ,	h.no_request , 
					h.tgl_request ,	

					mjr.nama_dokumen, 
					um.tgl_berangkat ,	um.tgl_pulang ,	h.no_um , 
					h.biodata_req_id ,	h.nip_req ,	h.nama_req , 
					h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req , 
					h.kode_divisi_req , 
					um.jenis, 
					h.total_biaya ,	h.total_um ,	h.selisih , 
					h.supplier_id ,	h.kode_supplier ,	h.nama_supplier , 
					h.keterangan ,  h.wkt_input, 
					h.is_reject,h.is_approve ,h.is_dept, 
					h.is_fc ,h.is_gm ,h.is_fa , 
					h.is_kas ,h.reimburse ,h.referenced , h.is_pum 
				FROM gl_mim.trn_request_h h 
				LEFT JOIN ( 
					SELECT um.no_request,um.kode_dept_req , 
						um.tgl_berangkat,um.tgl_pulang, 'PD' jenis 
					FROM gl_mim.trn_request_h um 
					WHERE um.jenis = 'UMPD' 

					AND um.is_approve = 1 

				) um ON um.no_request = h.no_um  
				INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis 
				INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req 
				WHERE h.jenis = 'PUM' 

				AND h.is_validasi_ga = 1 
				AND h.is_dept    = 1 
				AND h.is_kas    = 0 
				AND (h.is_reject = 1  OR h.is_fc   = 1 )
				$where_no_req
				$where_nama_req

				UNION ALL 
				SELECT 
					h.request_h_id ,	h.no_request , 
					h.tgl_request ,	

					mjr.nama_dokumen, 
					um.tgl_berangkat ,	um.tgl_pulang ,	h.no_um , 
					h.biodata_req_id ,	h.nip_req ,	h.nama_req , 
					h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req , 
					h.kode_divisi_req , um.jenis, 
					h.total_biaya ,	h.total_um ,	h.selisih , 
					h.supplier_id ,	h.kode_supplier ,	h.nama_supplier , 
					h.keterangan ,  h.wkt_input, 
					h.is_reject,h.is_approve ,h.is_dept, 
					h.is_fc ,h.is_gm ,h.is_fa , 
					h.is_kas ,h.reimburse ,h.referenced , h.is_pum 
				FROM gl_mim.trn_request_h h 
				INNER JOIN ( 
					SELECT um.no_request,um.kode_dept_req , 
						um.tgl_berangkat,um.tgl_pulang,'UM' jenis 
					FROM gl_mim.trn_request_h um 
					WHERE um.jenis = 'UM' 

					AND um.is_approve = 1 

				) um ON um.no_request = h.no_um 
				INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis 
				INNER JOIN gl_mim.mst_dept_induk dept ON dept.kode_dept = h.kode_dept_req 
				WHERE h.jenis = 'PUM' 

				AND h.is_dept    = 1 
				AND h.is_kas    = 0 
				AND (h.is_reject = 1  OR h.is_fc   = 1 )
				
				$where_no_req
				$where_nama_req

				) z ON z.no_request = xy.no_request
		";
		$jum= $this->hrd->query($sql);
		return $jum->num_rows();
	}


	public function getDataDireksi1($search_no="",$length="",$start="",$column="",$order="")
	{
		$sql = "SELECT
				h.request_h_id ,	h.no_request ,
				h.tgl_request ,	h.jenis , mjr.nama_dokumen ,

				CASE h.jenis
				WHEN 'PUM' THEN
						(SELECT h1.tgl_berangkat
								FROM gl_mim.trn_request_h h1
								WHERE h1.no_request = h.no_um
								AND h1.jenis = 'UMPD'
						)
				WHEN 'UMPD' THEN h.tgl_berangkat
				END tgl_berangkat ,
				CASE h.jenis
				WHEN 'PUM' THEN
						(SELECT h1.tgl_pulang
								FROM gl_mim.trn_request_h h1
								WHERE h1.no_request = h.no_um
								AND h1.jenis = 'UMPD'
						)
				WHEN 'UMPD' THEN h.tgl_pulang
				END tgl_pulang ,
				CONCAT(h.no_um,IFNULL(( SELECT CASE h1.jenis
				WHEN 'UMPD' THEN ' (PD)'
				ELSE ' (UM)'
				END jenis
				FROM gl_mim.trn_request_h h1
				WHERE h1.no_request = h.no_request
				),'')) no_um ,
				h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
				h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
				h.kode_divisi_req ,
				h.total_biaya ,	h.total_um ,	h.selisih ,
				h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
				h.keterangan ,
				h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
				h.is_kas ,h.reimburse ,h.referenced , h.is_pum,h.wkt_input
			FROM gl_mim.trn_request_h h
			INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
			WHERE
			h.jenis ='PUM'
			AND (h.total_biaya > h.total_um)
			AND h.is_dept 	= 1
			AND h.is_fc 	= 1
			AND h.is_gm 	= 0
			AND h.is_kas 	= 0
			AND h.is_reject = 0
			UNION ALL
			SELECT
				h.request_h_id ,	h.no_request ,
				h.tgl_request ,
				CASE h.jenis
				WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
				ELSE h.jenis
				END jenis,
				mjr.nama_dokumen,
				CASE h.jenis
				WHEN 'PUM' THEN
						(SELECT h1.tgl_berangkat
								FROM gl_mim.trn_request_h h1
								WHERE h1.no_request = h.no_um
						)
				WHEN 'UMPD' THEN h.tgl_berangkat
				END tgl_berangkat ,
				CASE h.jenis
				WHEN 'PUM' THEN
						(SELECT h1.tgl_pulang
								FROM gl_mim.trn_request_h h1
								WHERE h1.no_request = h.no_um
						)
				WHEN 'UMPD' THEN h.tgl_pulang
				END tgl_pulang ,
				h.no_um ,
				h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
				h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
				h.kode_divisi_req ,
				h.total_biaya ,	h.total_um ,	h.selisih ,
				h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
				h.keterangan ,
				h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
				h.is_kas ,h.reimburse ,h.referenced , h.is_pum,h.wkt_input
			FROM gl_mim.trn_request_h h
			INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
			WHERE
			h.jenis IN ('UM','UMPD','KLAIM')
			AND h.is_dept 	= 1
			AND h.is_fc 	= 1
			AND h.is_gm 	= 0
			AND h.is_kas 	= 0
			AND h.is_reject = 0
			ORDER BY wkt_input DESC
			LIMIT $start,$length
		";

		$query = $this->hrd->query($sql);
		// die(nl2br($this->hrd->last_query()));
		return $query->result_array();

	}

	public function getDataDireksi2($search_no = "")
	{
		$sql = "SELECT
				h.request_h_id ,	h.no_request ,
				h.tgl_request ,	h.jenis , mjr.nama_dokumen ,

				CASE h.jenis
				WHEN 'PUM' THEN
						(SELECT h1.tgl_berangkat
								FROM gl_mim.trn_request_h h1
								WHERE h1.no_request = h.no_um
								AND h1.jenis = 'UMPD'
						)
				WHEN 'UMPD' THEN h.tgl_berangkat
				END tgl_berangkat ,
				CASE h.jenis
				WHEN 'PUM' THEN
						(SELECT h1.tgl_pulang
								FROM gl_mim.trn_request_h h1
								WHERE h1.no_request = h.no_um
								AND h1.jenis = 'UMPD'
						)
				WHEN 'UMPD' THEN h.tgl_pulang
				END tgl_pulang ,
				CONCAT(h.no_um,IFNULL(( SELECT CASE h1.jenis
				WHEN 'UMPD' THEN ' (PD)'
				ELSE ' (UM)'
				END jenis
				FROM gl_mim.trn_request_h h1
				WHERE h1.no_request = h.no_request
				),'')) no_um ,
				h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
				h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
				h.kode_divisi_req ,
				h.total_biaya ,	h.total_um ,	h.selisih ,
				h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
				h.keterangan ,
				h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
				h.is_kas ,h.reimburse ,h.referenced , h.is_pum,h.wkt_input
			FROM gl_mim.trn_request_h h
			INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
			WHERE
			h.jenis ='PUM'
			AND (h.total_biaya > h.total_um)
			AND h.is_dept 	= 1
			AND h.is_fc 	= 1
			AND h.is_gm 	= 0
			AND h.is_kas 	= 0
			AND h.is_reject = 0
			UNION ALL
			SELECT
				h.request_h_id ,	h.no_request ,
				h.tgl_request ,
				CASE h.jenis
				WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
				ELSE h.jenis
				END jenis,
				mjr.nama_dokumen,
				CASE h.jenis
				WHEN 'PUM' THEN
						(SELECT h1.tgl_berangkat
								FROM gl_mim.trn_request_h h1
								WHERE h1.no_request = h.no_um
						)
				WHEN 'UMPD' THEN h.tgl_berangkat
				END tgl_berangkat ,
				CASE h.jenis
				WHEN 'PUM' THEN
						(SELECT h1.tgl_pulang
								FROM gl_mim.trn_request_h h1
								WHERE h1.no_request = h.no_um
						)
				WHEN 'UMPD' THEN h.tgl_pulang
				END tgl_pulang ,
				h.no_um ,
				h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
				h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
				h.kode_divisi_req ,
				h.total_biaya ,	h.total_um ,	h.selisih ,
				h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
				h.keterangan ,
				h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
				h.is_kas ,h.reimburse ,h.referenced , h.is_pum,h.wkt_input
			FROM gl_mim.trn_request_h h
			INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
			WHERE
			h.jenis IN ('UM','UMPD','KLAIM')
			AND h.is_dept 	= 1
			AND h.is_fc 	= 1
			AND h.is_gm 	= 0
			AND h.is_kas 	= 0
			AND h.is_reject = 0
		";
		$jum= $this->hrd->query($sql);
		return $jum->num_rows();
	}

	public function getHistoryDireksi1($search_no="",$length="",$start="",$column="",$order="")
	{
		$sql = "SELECT
				h.request_h_id ,	h.no_request ,
				h.tgl_request ,	h.jenis , mjr.nama_dokumen ,

				CASE h.jenis
				WHEN 'PUM' THEN
						(SELECT h1.tgl_berangkat
								FROM gl_mim.trn_request_h h1
								WHERE h1.no_request = h.no_um
								AND h1.jenis = 'UMPD'
						)
				WHEN 'UMPD' THEN h.tgl_berangkat
				END tgl_berangkat ,
				CASE h.jenis
				WHEN 'PUM' THEN
						(SELECT h1.tgl_pulang
								FROM gl_mim.trn_request_h h1
								WHERE h1.no_request = h.no_um
								AND h1.jenis = 'UMPD'
						)
				WHEN 'UMPD' THEN h.tgl_pulang
				END tgl_pulang ,
				CONCAT(h.no_um,IFNULL(( SELECT CASE h1.jenis
				WHEN 'UMPD' THEN ' (PD)'
				ELSE ' (UM)'
				END jenis
				FROM gl_mim.trn_request_h h1
				WHERE h1.no_request = h.no_request
				),'')) no_um ,
				h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
				h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
				h.kode_divisi_req ,
				h.total_biaya ,	h.total_um ,	h.selisih ,
				h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
				h.keterangan ,
				h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
				h.is_kas ,h.reimburse ,h.referenced , h.is_pum,h.wkt_input
			FROM gl_mim.trn_request_h h
			INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
			WHERE
			h.jenis ='PUM'
			AND (h.total_biaya > h.total_um)
			AND h.is_dept 	= 1
			AND h.is_fc 	= 1
			AND h.is_gm 	= 1
			AND h.is_kas 	= 0
			AND h.is_reject = 0
			UNION ALL
			SELECT
				h.request_h_id ,	h.no_request ,
				h.tgl_request ,
				CASE h.jenis
				WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
				ELSE h.jenis
				END jenis,
				mjr.nama_dokumen,
				CASE h.jenis
				WHEN 'PUM' THEN
						(SELECT h1.tgl_berangkat
								FROM gl_mim.trn_request_h h1
								WHERE h1.no_request = h.no_um
						)
				WHEN 'UMPD' THEN h.tgl_berangkat
				END tgl_berangkat ,
				CASE h.jenis
				WHEN 'PUM' THEN
						(SELECT h1.tgl_pulang
								FROM gl_mim.trn_request_h h1
								WHERE h1.no_request = h.no_um
						)
				WHEN 'UMPD' THEN h.tgl_pulang
				END tgl_pulang ,
				h.no_um ,
				h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
				h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
				h.kode_divisi_req ,
				h.total_biaya ,	h.total_um ,	h.selisih ,
				h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
				h.keterangan ,
				h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
				h.is_kas ,h.reimburse ,h.referenced , h.is_pum,h.wkt_input
			FROM gl_mim.trn_request_h h
			INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
			WHERE
			h.jenis IN ('UM','UMPD','KLAIM')
			AND h.is_dept 	= 1
			AND h.is_fc 	= 1
			AND h.is_gm 	= 1
			AND h.is_kas 	= 0
			AND h.is_reject = 0
			ORDER BY wkt_input DESC
			LIMIT $start,$length
		";

		$query = $this->hrd->query($sql);
		// die(nl2br($this->hrd->last_query()));
		return $query->result_array();

	}

	public function getHistoryDireksi2($search_no = "")
	{
		$sql = "SELECT
				h.request_h_id ,	h.no_request ,
				h.tgl_request ,	h.jenis , mjr.nama_dokumen ,

				CASE h.jenis
				WHEN 'PUM' THEN
						(SELECT h1.tgl_berangkat
								FROM gl_mim.trn_request_h h1
								WHERE h1.no_request = h.no_um
								AND h1.jenis = 'UMPD'
						)
				WHEN 'UMPD' THEN h.tgl_berangkat
				END tgl_berangkat ,
				CASE h.jenis
				WHEN 'PUM' THEN
						(SELECT h1.tgl_pulang
								FROM gl_mim.trn_request_h h1
								WHERE h1.no_request = h.no_um
								AND h1.jenis = 'UMPD'
						)
				WHEN 'UMPD' THEN h.tgl_pulang
				END tgl_pulang ,
				CONCAT(h.no_um,IFNULL(( SELECT CASE h1.jenis
				WHEN 'UMPD' THEN ' (PD)'
				ELSE ' (UM)'
				END jenis
				FROM gl_mim.trn_request_h h1
				WHERE h1.no_request = h.no_request
				),'')) no_um ,
				h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
				h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
				h.kode_divisi_req ,
				h.total_biaya ,	h.total_um ,	h.selisih ,
				h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
				h.keterangan ,
				h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
				h.is_kas ,h.reimburse ,h.referenced , h.is_pum,h.wkt_input
			FROM gl_mim.trn_request_h h
			INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
			WHERE
			h.jenis ='PUM'
			AND (h.total_biaya > h.total_um)
			AND h.is_dept 	= 1
			AND h.is_fc 	= 1
			AND h.is_gm 	= 1
			AND h.is_kas 	= 0
			AND h.is_reject = 0
			UNION ALL
			SELECT
				h.request_h_id ,	h.no_request ,
				h.tgl_request ,
				CASE h.jenis
				WHEN 'UMPD' THEN 'UM PERJALANAN DINAS'
				ELSE h.jenis
				END jenis,
				mjr.nama_dokumen,
				CASE h.jenis
				WHEN 'PUM' THEN
						(SELECT h1.tgl_berangkat
								FROM gl_mim.trn_request_h h1
								WHERE h1.no_request = h.no_um
						)
				WHEN 'UMPD' THEN h.tgl_berangkat
				END tgl_berangkat ,
				CASE h.jenis
				WHEN 'PUM' THEN
						(SELECT h1.tgl_pulang
								FROM gl_mim.trn_request_h h1
								WHERE h1.no_request = h.no_um
						)
				WHEN 'UMPD' THEN h.tgl_pulang
				END tgl_pulang ,
				h.no_um ,
				h.biodata_req_id ,	h.nip_req ,	h.nama_req ,
				h.dept_id_req ,	h.kode_dept_req ,	h.nama_dept_req ,
				h.kode_divisi_req ,
				h.total_biaya ,	h.total_um ,	h.selisih ,
				h.supplier_id ,	h.kode_supplier ,	h.nama_supplier ,
				h.keterangan ,
				h.is_approve ,h.is_dept ,h.is_fc ,h.is_gm ,h.is_fa ,
				h.is_kas ,h.reimburse ,h.referenced , h.is_pum,h.wkt_input
			FROM gl_mim.trn_request_h h
			INNER JOIN gl_mim.mst_jenis_request mjr ON mjr.kode = h.jenis
			WHERE
			h.jenis IN ('UM','UMPD','KLAIM')
			AND h.is_dept 	= 1
			AND h.is_fc 	= 1
			AND h.is_gm 	= 1
			AND h.is_kas 	= 0
			AND h.is_reject = 0
		";
		$jum= $this->hrd->query($sql);
		return $jum->num_rows();
	}

}