<?php

class Model_hrd_cuti extends CI_Model
{
	private $hrd;
	function __construct()
	{
		parent::__construct();
		$this->hrd = $this->load->database('hrd',TRUE);
		$this->hrdsave = $this->load->database('hrd_save',TRUE);
		$this->hrd_web_master = $this->load->database('hrd_web_master',TRUE);
        $this->load->model('Model_cuti');
	}

    public function create()
	{
		$docCode	 ='HRC';
		$date		 = date('ym');
		$jumlah_hari = $this->input->post('jumlah_hari');
		$potong_cuti = $this->input->post('potong_cuti_dari');
		$biodataids  = $this->input->post('biodata_id');

		/* Condition */
			#jumlah hari detail
			if($this->input->post('jumlah_hari')=='0.5'){
				$count_d = count($this->input->post('tgl_tdk_masuk'))*0.5;
			}else{
				$count_d = count($this->input->post('tgl_tdk_masuk'));
			}

			#sisa saldo
			if($potong_cuti =='NORMATIF'){
				$jml_normatif = $count_d;
			} else{ $jml_normatif ='0'; }
			if($potong_cuti =='BONUS'){
				$jml_bonus = $count_d;
			}else{ $jml_bonus ='0'; }
			if($potong_cuti =='TAMBAHAN'){
				$jml_tambahan = $count_d;
			}else{ $jml_tambahan ='0'; }

			#potong cuti normatif
			if($potong_cuti =='NORMATIF'){
				if($jumlah_hari =='1'){
					$status_absen 		= 'CN';
				}else{
					$status_absen 		= 'CH';
				}

				$tgl_cuti_potong = $this->input->post('tgl_tdk_masuk');
				rsort($tgl_cuti_potong);

				foreach($tgl_cuti_potong as $k => $v){
					// tesx(' oke boleh sipppp  ');

					$tgl_cuti_desc = $this->input->post('tgl_tdk_masuk');
					rsort($tgl_cuti_desc);
					$tgl_cuti_desc = $tgl_cuti_desc[array_key_last($tgl_cuti_desc)];

					/* Cek Saldo Normatif */
						$cek_cuti 			= $this->Model_cuti->getAppDataNormatif($biodataids, $v);

						$tgl_akhir_berlaku 	= $cek_cuti['tgl_akhir_berlaku'];
						$tgl_awal_berlaku 	= $cek_cuti['tgl_mulai_berlaku'];
						#get Saldo Normatif Normal & 1/2 Hari
						$normatif 		= $cek_cuti['sisa_normatif'];
						$normatifst 	= $cek_cuti['sisa_normatif'];
					/* Cek Saldo Normatif */

					# Generate Saldo Normatif if Null
					if(empty($cek_cuti['sisa_normatif']) || $cek_cuti['sisa_normatif'] == null ){
						$generate_saldo = array(
							'saldo_cuti_normatif_id' 	=> $this->uuid->v4(),
							'biodata_id'				=> $biodataids,
							'tgl_ambil_terakhir'		=> $v,
							'pic_input'					=> $biodataids,
							'keterangan'				=> 'GENERATE SALDO CUTI MINUS',
							'tgl_mulai_berlaku' 		=> $tgl_cuti_desc,
							'tgl_akhir_berlaku' 		=> $v,
							'tgl_input'    				=> date('Y-m-d H:i:s'),
						);
						$insert = $this->hrd->insert('hrd_all.trn_saldo_cuti_normatif', $generate_saldo);
						// tesx($insert);
					}

				}

			}
			#potong cuti bonus
			if($potong_cuti =='BONUS'){
				$urutBonus 			= $this->input->post('urut_bonus');
				$biodata_id        	= $this->input->post('biodata_id');
				$dates		 		= date('y-m-d');
				$cek_saldo_bonus	= $this->Model_cuti->getSaldoBonus($biodata_id, $dates);
				$tgl_akhir_berlaku 		= $cek_saldo_bonus['tgl_akhir_berlaku'];
				$tgl_awal_berlaku 		= $cek_saldo_bonus['tgl_mulai_berlaku'];
				if($jumlah_hari =='1'){
					$status_absen 		= 'CL';
					// $status_absen_id 	= '000000000013';
				}else{
					$status_absen 		= 'CH';
					// $status_absen_id 	= '000000000020';
				}
			}else{
				$urutBonus = '0';
			}

			#potong cuti tambahan
			if($potong_cuti =='TAMBAHAN'){
				if($jumlah_hari =='1'){
						$status_absen 		= 'CT';
						// $status_absen_id 	= '000000000017';
				}else{
						$status_absen 		= 'CH';
						// $status_absen_id 	= '000000000020';
				}
				#get Saldo Normatif Normal & 1/2 Hari
				$cek_saldo_tambahan = $this->Model_cuti->getDataTambahan($biodataids, $date);
				$sisa_saldo_cuti		= $cek_saldo_tambahan['sisa_cuti_tambahan'];
				$sisa_saldo_cutist		= $cek_saldo_tambahan['sisa_cuti_tambahan'];
			}

			//get status_absensi_id, keterangan
			$search_status 		= $this->Model_cuti->getKetAbsen($status_absen);
			$status_absen_id 	= $search_status['status_absensi_id'];
			$keterangan_d 		= 'AMBIL '.$search_status['ket_status_absensi'];


		/* End Condition */

		/* INSERT DATA */
			$data_header = array(
				'tdk_masuk_h_id'			=> $this->uuid->v4(),
				'biodata_id'				=> $this->input->post('biodata_id'),
				'pic_input'    				=> $this->input->post('biodata_id'),
				'no_dok_tdk_masuk'  		=> $this->Model_cuti->getDataNoDoc($docCode, $date),
				'potong_cuti_dari'  		=> $potong_cuti,
				'status_absensi_id' 		=> $status_absen_id,
				'jml_ambil' 				=> $count_d,
				'jml_ambil_normatif'		=> $jml_normatif,
				'jml_ambil_bonus'   		=> $jml_bonus,
				'jml_ambil_tambahan'		=> $jml_tambahan,
				'sisa_saldo_normatif' 		=> $this->input->post('sisa_normatif'),
				'sisa_saldo_bonus' 			=> $this->input->post('sisa_bonus'),
				'sisa_saldo_tambahan' 		=> $this->input->post('sisa_tambahan'),
				'mulai_berlaku_normatif' 	=> $this->input->post('mulai_berlaku_normatif'),
				'akhir_berlaku_normatif' 	=> $this->input->post('akhir_berlaku_normatif'),
				'mulai_berlaku_bonus' 		=> $this->input->post('mulai_berlaku_bonus'),
				'akhir_berlaku_bonus' 		=> $this->input->post('akhir_berlaku_bonus'),
				'mulai_berlaku_tambahan' 	=> $this->input->post('mulai_berlaku_tambahan'),
				'akhir_berlaku_tambahan' 	=> $this->input->post('akhir_berlaku_tambahan'),
				'keterangan'	  			=> $this->input->post('keterangan'),
				'is_posting'	  			=> '0',
				'is_batal'	  				=> '0',
				'tgl_dok_tdk_masuk'			=> date('Y-m-d'),
				'tgl_input'    				=> date('Y-m-d H:i:s'),
			);

			// tesx($data_header);

			$sno_doc        = $data_header['no_dok_tdk_masuk'];
			$log_detail = array();
			$count_tgl_tdk_masuk = count($this->input->post('tgl_tdk_masuk'));

			for($x = 0; $x < $count_tgl_tdk_masuk ; $x++) {

				$uuid_d = $this->uuid->v4($x);

				#sort tanggal
				$dataTanggals	 	= $this->input->post('tgl_tdk_masuk');
				usort($dataTanggals, array($this,'sortByGrade'));
				$tgl_tdk_masuks 	=  $dataTanggals[$x];

				if($potong_cuti =='TAMBAHAN'){
					#cek saldo cuti tambahan per tanggal cuti
					$cek_awal_tambahan = $this->Model_cuti->getAwalTambahan($biodataids, $tgl_tdk_masuks);
					$cek_akhir_tambahan = $this->Model_cuti->getAkhirTambahan($biodataids, $tgl_tdk_masuks);
					$tgl_awal_berlaku 	= $cek_awal_tambahan['tgl_mulai_berlaku'];
					$tgl_akhir_berlaku 	= $cek_akhir_tambahan['tgl_akhir_berlaku'];

					if($jumlah_hari == '1'){

						if($sisa_saldo_cuti <= 0 ){
								$status_absen_d 	= 'CG';
						} else {

							if($sisa_saldo_cutist == 0.5 || $sisa_saldo_cuti == 0.5){
								$status_absen_d 		= 'CS';
							} else {
								$status_absen_d 		= 'CT';
							}
						}
						$sisa_saldo_cuti--;
						$sisa_saldo_cutist-= 0.5;

					}else{
						if($sisa_saldo_cuti < 0.5 ){
								$status_absen_d 	= 'CS';
						}else{
							$status_absen_d 		= 'CH';
						}
						$sisa_saldo_cuti-= 0.5;

					}
				}

				if($potong_cuti =='BONUS'){
					if($jumlah_hari =='1'){
						$status_absen_d		= 'CL';
					}else{
						$status_absen_d		= 'CH';
					}
				}

				if($potong_cuti =='NORMATIF'){

					$cek_cuti_detail  = $this->Model_cuti->getAppDataNormatif($biodataids, $this->input->post('tgl_tdk_masuk')[$x]);

					$tgl_awal_berlaku = $cek_cuti_detail['tgl_mulai_berlaku'];

					$tgl_akhir_berlaku = $cek_cuti_detail['tgl_akhir_berlaku'];


					if($jumlah_hari == '1'){

						#// Pengecekan status saldo kurang lintas tahun
						if($normatif <= 0){
							$cek_cuti_ny 		= $this->Model_cuti->getDataNormatifny($biodataids);
							$normatif			= $cek_cuti_ny['sisa_normatif'];
						}

						if($normatif <= 0 ){
								$status_absen_d 	= 'CG';
						} else {

							if($normatifst == 0.5 || $normatif == 0.5){
								$status_absen_d 		= 'CS';
							} else {
								$status_absen_d 		= 'CN';
							}
						}
						$normatif--;
						$normatifst-= 0.5;

					}else{
						if($normatif < 0.5 ){
								$status_absen_d 	= 'CS';
						}else{
							$status_absen_d 		= 'CH';
						}
						$normatif-= 0.5;

					}

				}

				#get keterangan status detail
				$search_status_d 		= $this->Model_cuti->getKetAbsen($status_absen_d);
				$keterangan_d 			= 'AMBIL '.$search_status_d['ket_status_absensi'];
				#str nama hari
				$namahari = format_indo(date('D', strtotime($tgl_tdk_masuks)));

				#Data Detail
				$items = array(
					'tdk_masuk_h_id'	=> $data_header['tdk_masuk_h_id'],
					'tdk_masuk_d_id' 	=> $uuid_d,
					'potong_cuti_dari'	=> $potong_cuti,
					'keterangan' 		=> $keterangan_d,
					'is_potong_cuti'	=> '1',
					'urut_bonus'		=> $urutBonus,
					'nilai_hari' 	    => $jumlah_hari,
					'nama_hari' 	    => $namahari,
					'status_absen' 	    => $status_absen_d,
					'tgl_tdk_masuk' 	=> $tgl_tdk_masuks,
					'pic_input'         => $this->input->post('biodata_id'),
					'tgl_input'    		=> date('Y-m-d H:i:s'),
					// 'urut' 				=> $sisa_cuti_normatif,
				);

				#condition cek tanggal berlaku cuti
				if($this->input->post('tgl_tdk_masuk')[$x] >= $tgl_awal_berlaku && $this->input->post('tgl_tdk_masuk')[$x] <= $tgl_akhir_berlaku ){
					array_push($log_detail,$items);
					#insert data header & detail
					// $this->hrd->insert('hrd_all.trn_tidak_masuk_h', $data_header);
					// $this->hrd->insert('hrd_all.trn_tidak_masuk_d', $items);
				}else{
					$this->session->set_flashdata('error', $this->input->post('tgl_tdk_masuk')[$x].' Tidak sesuai dengan masa berlaku cuti!!');
					redirect('leaves/hrd_cuti/create', 'refresh');
				}
			}


			$data_posting = array(
				'tdk_masuk_h_id'	=> $data_header['tdk_masuk_h_id'],
                'app_1'             => $this->session->userdata('nama_login'),
                'tgl_app_1'         => date('Y-m-d H:i:s'),
				'status' 			=> '1',
				'status_dokumen' 	=> 'C'
			);
			// $this->hrd->set($data_posting);
			// $this->hrd->insert('hrd_all.trn_posting');

            tesx($data_header,$log_detail, $data_posting);

		/* END INSERT DATA */

		$this->Model_cuti->send_mail_create($data_header, $log_detail);
		return ($sno_doc) ? $sno_doc : false;
	}

    function sortByGrade($a, $b)
	{
		// tesx($a, $b);
		if ($a == $b) {
			return $a - $b;
		}
		return strcmp($a, $b);
	}

}