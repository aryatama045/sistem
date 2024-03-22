<?php

class Model_karyawan extends CI_Model
{
	private $hrd;
	function __construct()
	{
		parent::__construct();
		$this->hrd = $this->load->database('hrd',TRUE);
		$this->hrdsave = $this->load->database('hrd_save',TRUE);
		$this->hrd_web_master = $this->load->database('hrd_web_master',TRUE);
	}

	/*-- DataTables -- */
		public function getListKaryawan1($search_no,$search_nama,$divisi,$dept,$store, $length = "", $start = "", $column = "", $order = "")
		{

			$this->hrd->select('nip, nama_lengkap, d.kode_divisi, c.nama_dept,kd_store');
			$this->hrd->from('hrd_all.mst_biodata a');
			$this->hrd->join('hrd_all.biodata_pekerjaan_d b','a.biodata_id=b.biodata_id');
			$this->hrd->join('hrd_all.mst_dept c','b.dept_id = c.dept_id');
			$this->hrd->join('hrd_all.mst_divisi d','b.divisi_id = d.divisi_id');
			$this->hrd->where('b.aktif = 1');
			$this->hrd->where_not_in('nip', '17030023');
			$this->hrd->order_by('kode_divisi,nama_dept,kd_store, nama_lengkap');

			if($search_nama !="") $this->hrd->like('nama_lengkap',$search_nama);
			if($search_no !="") $this->hrd->like('nip',$search_no);
			if($divisi !="") $this->hrd->where('d.divisi_id',$divisi);
			if($dept !="") $this->hrd->where('c.dept_id',$dept);
			if($store !="") $this->hrd->where('kd_store',$store);

			$this->hrd->limit($length,$start);
			$query=$this->hrd->get();
			// die(nl2br($this->hrd->last_query()));
			return $query->result_array();
		}

		public function getListKaryawan2($search_no,$search_nama,$divisi,$dept,$store)
		{
			$this->hrd->select('nip, nama_lengkap, d.kode_divisi, c.nama_dept,kd_store');
			$this->hrd->from('hrd_all.mst_biodata a');
			$this->hrd->join('hrd_all.biodata_pekerjaan_d b','a.biodata_id=b.biodata_id');
			$this->hrd->join('hrd_all.mst_dept c','b.dept_id = c.dept_id');
			$this->hrd->join('hrd_all.mst_divisi d','b.divisi_id = d.divisi_id');
			$this->hrd->where('b.aktif = 1');
			$this->hrd->where_not_in('nip', '17030023');
			$this->hrd->order_by('kode_divisi,nama_dept,kd_store, nama_lengkap');

			if($search_nama !="") $this->hrd->like('nama_lengkap',$search_nama);
			if($search_no !="") $this->hrd->like('nip',$search_no);
			if($divisi !="") $this->hrd->where('d.divisi_id',$divisi);
			if($dept !="") $this->hrd->where('c.dept_id',$dept);
			if($store !="") $this->hrd->where('kd_store',$store);

			$jum=$this->hrd->get();
			return $jum->num_rows();
		}
	/*-- DataTables -- */



	/*-- Get Data -- */
		public function getBiodata($nip)
		{
			$this->hrd->select('a.*, d.kode_divisi, c.nama_dept,kd_store');
			$this->hrd->from('hrd_all.mst_biodata a');
			$this->hrd->join('hrd_all.biodata_pekerjaan_d b','a.biodata_id=b.biodata_id');
			$this->hrd->join('hrd_all.mst_dept c','b.dept_id = c.dept_id');
			$this->hrd->join('hrd_all.mst_divisi d','b.divisi_id = d.divisi_id');
			$this->hrd->where('a.nip', $nip);
			$this->hrd->where('b.aktif = 1');
			$query=$this->hrd->get();
			// die(nl2br($this->hrd->last_query()));
			return $query->row_array();
		}

		public function getKeluarga($biodata_id)
		{
			#keluarga
			$sql = "SELECT nama,hubungan,tgl_lahir,alamat
					FROM hrd_all.biodata_famili_d
					WHERE biodata_id='$biodata_id' ORDER BY tgl_lahir";
			$query	= $this->hrd->query($sql);
			// die(nl2br($this->hrd->last_query()));
			return $query->result_array();
		}

		public function getPendidikan($biodata_id)
		{
			#data pendidikan
			$sql = "SELECT lembaga,jurusan,thn_lulus
			FROM hrd_all.biodata_pendidikan_d
			WHERE biodata_id='$biodata_id' ORDER BY thn_lulus";
			$query	= $this->hrd->query($sql);
			// die(nl2br($this->hrd->last_query()));
			return $query->result_array();
		}

		public function getPengalaman($biodata_id)
		{
			#pengalaman kerja/data perusahaan lama
			$sql = "SELECT nama_perusahaan,jabatan,lama_krj_thn,bagian,penghargaan,keterangan
			FROM hrd_all.biodata_hist_krj_ext_d WHERE biodata_id='$biodata_id' ";
			$query	= $this->hrd->query($sql);
			// die(nl2br($this->hrd->last_query()));
			return $query->result_array();
		}

		public function getKepemilikan($biodata_id)
		{
			#data kepemilikan
			$sql ="SELECT jenis_materi, identitas_materi
			FROM hrd_all.biodata_kepemilikan_d WHERE biodata_id='$biodata_id' ";
			$query	= $this->hrd->query($sql);
			// die(nl2br($this->hrd->last_query()));
			return $query->result_array();
		}

		public function getDataOt($biodata_id)
		{
			#data di OT
			$sql = "SELECT bagian, lama_krj_thn FROM hrd_all.biodata_hist_krj_int_d WHERE biodata_id='$biodata_id' ";
			$query	= $this->hrd->query($sql);
			// die(nl2br($this->hrd->last_query()));
			return $query->result_array();
		}

		public function getDokumen($biodata_id)
		{
			#dokumen pendukung
			$sql = "SELECT kode_dok,no_dok,tgl_dok,status_dok,keterangan
			FROM hrd_all.biodata_dokumen_d WHERE biodata_id='$biodata_id'";
			$query	= $this->hrd->query($sql);
			// die(nl2br($this->hrd->last_query()));
			return $query->result_array();
		}

		public function getSurat($biodata_id)
		{
			#data surat karyawan
			$sql = "SELECT kode_jenis_surat,no_surat,tgl_surat,isi_surat
			FROM hrd_all.biodata_surat_kyw_d WHERE biodata_id='$biodata_id' ORDER BY tgl_surat";
			$query	= $this->hrd->query($sql);
			// die(nl2br($this->hrd->last_query()));
			return $query->result_array();
		}

		public function saldoNormatif($biodata_id)
		{
			$sql 	= 	"SELECT  IFNULL(cn.sisa_cuti,0) sisa_normatif,
						saldo_awal,saldo_tahunan,saldo_cuti_normatif_id,tgl_mulai_berlaku,tgl_akhir_berlaku
						FROM hrd_all.trn_saldo_cuti_normatif cn
						WHERE cn.biodata_id = '$biodata_id'
						AND NOW() >= DATE(tgl_mulai_berlaku)
						AND NOW() <= DATE(tgl_akhir_berlaku)
						";
			$query 	= $this->hrd->query($sql);
			// die($this->hrd->last_query());
			return 	$query->row_array();
		}

		public function saldoTambahan($biodata_id){
			$sql 	=	"SELECT no_dok_cuti_tambahan,ct.biodata_id,saldo_cuti_tambahan_id, saldo_tambahan,
						ct.saldo_awal, sisa_cuti,ct.tgl_mulai_berlaku, ct.tgl_akhir_berlaku
						FROM hrd_all.trn_saldo_cuti_tambahan ct
						WHERE ct.biodata_id = '$biodata_id'
						AND ct.is_batal <> 1
						AND ct.sisa_cuti > 0
						AND NOW() >= DATE(tgl_mulai_berlaku)
						AND NOW() <= DATE(tgl_akhir_berlaku)
						ORDER BY tgl_akhir_berlaku ASC
						";
			$query 	= $this->hrd->query($sql);
			// die($this->hrd->last_query());
			return 	$query->result_array();
		}

	/*-- Get Data -- */



}