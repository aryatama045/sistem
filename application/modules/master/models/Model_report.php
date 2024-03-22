<?php

class Model_report extends CI_Model
{
	private $hrd;
	function __construct()
	{
		parent::__construct();
		$this->hrd = $this->load->database('hrd',TRUE);
		$this->hrdsave = $this->load->database('hrd_save',TRUE);
		$this->hrd_web_master = $this->load->database('hrd_web_master',TRUE);
	}

	public function getStatusAbsensi(){
		$sql = "SELECT kode_status_absensi,ket_status_absensi FROM hrd_all.mst_status_absensi WHERE aktif=1 AND kode_status_absensi<>''"; 
		$query 	= $this->hrd->query($sql);
		// die(json_encode($sql));
		return 	$query;
	}

	public	function getAbsenHistory($nip, $tgl_absen){

		$sql = "SELECT checkdate,
				CASE WHEN checktype = 1 THEN 'IN'
				WHEN checktype = 2 THEN 'OUT'
				ELSE 'LINTAS HARI' END jenis,
				checktime, sensor_id lokasi
			FROM hrd_all.inoutdata_hist
			WHERE nip='$nip' AND DATE(checkdate)='$tgl_absen' ORDER BY checktype, checktime";
		$query 	= $this->hrd->query($sql);
		return 	$query->result_array();

	}

	public function getDataKaryawan(){
		$sql = "SELECT biodata_id, nip, nama_lengkap FROM hrd_all.mst_biodata
				ORDER BY nama_lengkap ASC";
		$query 	= $this->hrd->query($sql);
		// die(json_encode($sql));
		return 	$query;
	}

	public function getDataDivisi(){
		$sql = "SELECT divisi_id,kode_divisi,nama_divisi FROM hrd_all.mst_divisi"; 
		$query 	= $this->hrd->query($sql);
		// die(json_encode($sql));
		return 	$query;
	}

	public function getDataDepartement($divisi_id){
		$sql = "SELECT dept_id,kode_dept,nama_dept 
		FROM hrd_all.mst_dept 
		WHERE divisi_id='".$divisi_id."' 
		ORDER BY nama_dept ASC";
		$query 	= $this->hrd->query($sql);
		return 	$query;
	}

	public function getDataStore($divisi_id,$dept_id){
		$this->hrd->select('kd_store,b.nama_store');
		$this->hrd->from('hrd_all.biodata_pekerjaan_d a');
		$this->hrd->join('hrd_all.mst_store b','a.kd_store=b.kode_store');
		$this->hrd->where_in('dept_id',$dept_id);
		$this->hrd->where('b.aktif=1');
		$this->hrd->where('divisi_id',$divisi_id);
		$this->hrd->group_by('kd_store');
		$this->hrd->order_by('b.nama_store', 'ASC');
		$query=$this->hrd->get();
		// die(nl2br($this->hrd->last_query()));
		return $query;

	}

	public function getDataAbsen($no_dok,$tanggal1,$tanggal2,$divisi_id="",$dept_id="",$kd_store="",$nip, $nama,$search_no = "", $length = "", $start = "", $column = "", $order = "")
	{
		$where = "";
		if($search_no != ""){ $where .= " AND c.nip = $search_no";}
		if($no_dok != ""){ $where .= " AND no_dok_tdk_masuk LIKE '%$no_dok%'";}
		if($nip != ""){ $where .= " AND c.nip = $nip";}
		if($nama != ""){ $where .= " AND c.nama_lengkap LIKE '%$nama%'";}
		if($divisi_id !=""){ $where .= " AND d.divisi_id = $divisi_id";}
		if($dept_id !=""){ $where .= " AND d.dept_id = $dept_id";}
		if($kd_store !=""){ $where .= " AND d.kd_store = '".$kd_store."'";}

		$sql = "SELECT * FROM(
				SELECT * FROM(SELECT 'CUTI',no_dok_tdk_masuk, nip, nama_lengkap, b.tgl_tdk_masuk, j.nama_jabatan, e.nama_dept, f.nama_divisi, d.kd_store, h.nama_store,
					CASE WHEN IFNULL(p.tgl_absensi, '')='' THEN 'SEDANG PROSES' ELSE 'FIXED' END status_absen
					FROM hrd_all.trn_tidak_masuk_h a
					LEFT JOIN hrd_all.trn_tidak_masuk_d b ON a.tdk_masuk_h_id=b.tdk_masuk_h_id
					LEFT JOIN hrd_all.trn_absensi p ON a.biodata_id=p.biodata_id AND b.tgl_tdk_masuk=p.tgl_absensi
					LEFT JOIN hrd_all.mst_biodata c ON a.biodata_id=c.biodata_id
					LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
					LEFT JOIN hrd_all.mst_dept e ON d.dept_id = e.dept_id
					LEFT JOIN hrd_all.mst_divisi f ON d.divisi_id = f.divisi_id
					LEFT JOIN hrd_all.trn_posting t ON a.tdk_masuk_h_id=t.tdk_masuk_h_id
					LEFT JOIN hrd_all.mst_jabatan j ON d.jabatan_id = j.jabatan_id
					LEFT JOIN hrd_all.mst_store h ON d.kd_store = h.kode_store
					WHERE b.tgl_tdk_masuk BETWEEN '$tanggal1' AND '$tanggal2'
					$where
					AND (b.is_batal =0 OR a.is_batal =0)
					AND (t.status_dokumen <> 'R' OR IFNULL(t.status_dokumen,'') = '')
				AND LEFT(a.no_dok_tdk_masuk,3)='HRC')a
			UNION ALL
				SELECT * FROM (SELECT 'IJIN',
					no_dok_tdk_masuk, nip, nama_lengkap, b.tgl_tdk_masuk, j.nama_jabatan, e.nama_dept, f.nama_divisi, d.kd_store, h.nama_store,
					CASE WHEN t.status_dokumen='R' THEN 'REJECT'
					WHEN t.status_dokumen='O' THEN 'OPEN'
					WHEN t.status_dokumen='P' THEN 'SEDANG PROSES'
					ELSE 'FIXED' END status_absen
					FROM hrd_all.trn_tidak_masuk_h a
					LEFT JOIN hrd_all.trn_tidak_masuk_d b ON a.tdk_masuk_h_id=b.tdk_masuk_h_id
					LEFT JOIN hrd_all.mst_biodata c ON a.biodata_id=c.biodata_id
					LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
					LEFT JOIN hrd_all.mst_dept e ON d.dept_id = e.dept_id
					LEFT JOIN hrd_all.mst_divisi f ON d.divisi_id = f.divisi_id
					LEFT JOIN hrd_all.trn_posting t ON a.tdk_masuk_h_id=t.tdk_masuk_h_id
					LEFT JOIN hrd_all.mst_jabatan j ON d.jabatan_id = j.jabatan_id
					LEFT JOIN hrd_all.mst_store h ON d.kd_store = h.kode_store
					WHERE b.tgl_tdk_masuk BETWEEN '$tanggal1' AND '$tanggal2'
					$where
					AND (b.is_batal =0 OR a.is_batal =0)
					AND (t.status_dokumen <> 'R' OR IFNULL(t.status_dokumen,'') = '')
					AND (LEFT(a.no_dok_tdk_masuk,3)='HRI' AND a.status_absensi_id <>'000000000009')
					ORDER BY tgl_tdk_masuk ASC, c.nip ASC)a
			UNION ALL
				SELECT * FROM(SELECT 'SAKIT',no_dok_tdk_masuk, nip, nama_lengkap, b.tgl_tdk_masuk, j.nama_jabatan, e.nama_dept, f.nama_divisi, d.kd_store, h.nama_store,
					CASE
					WHEN t.status_dokumen='R' THEN 'REJECT'
					WHEN t.status_dokumen='O' THEN 'OPEN'
					WHEN t.status_dokumen='P' THEN 'SEDANG PROSES'
					WHEN (t.status_dokumen='C') AND (IFNULL(r.no_dok,'')='') AND(IFNULL(r.pic_reject,'')='')  THEN 'SEDANG VERIFIKASI HRD'
					WHEN (t.status_dokumen='C') AND (IFNULL(r.no_dok,'')<>'') AND(IFNULL(r.pic_reject,'')<>'')  THEN 'REJECT VERIFIKASI HRD'
					ELSE 'FIXED' END status_absen
					FROM hrd_all.trn_tidak_masuk_h a
					LEFT JOIN hrd_all.trn_tidak_masuk_d b ON a.tdk_masuk_h_id=b.tdk_masuk_h_id
					LEFT JOIN hrd_all.mst_biodata c ON a.biodata_id=c.biodata_id
					LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
					LEFT JOIN hrd_all.mst_dept e ON d.dept_id = e.dept_id
					LEFT JOIN hrd_all.mst_divisi f ON d.divisi_id = f.divisi_id
					LEFT JOIN hrd_all.trn_posting t ON a.tdk_masuk_h_id=t.tdk_masuk_h_id
					LEFT JOIN hrd_all.mst_jabatan j ON d.jabatan_id = j.jabatan_id
					LEFT JOIN hrd_all.trn_app_3rd r ON a.tdk_masuk_h_id = r.no_dok
					LEFT JOIN hrd_all.mst_store h ON d.kd_store = h.kode_store
					WHERE b.tgl_tdk_masuk BETWEEN '$tanggal1' AND '$tanggal2'
					$where
					AND (b.is_batal = 0 OR a.is_batal =0)
					AND (t.status_dokumen <> 'R' OR IFNULL(t.status_dokumen,'') = '')
					AND (LEFT(a.no_dok_tdk_masuk,3)='HRI' AND a.status_absensi_id ='000000000009')
					ORDER BY tgl_tdk_masuk ASC, c.nip ASC
					)a
				)a
			ORDER BY tgl_tdk_masuk,nip
			LIMIT $start,$length";
		// die(nl2br($this->hrd->last_query()));

		$query = $this->hrd->query($sql);
		// die(nl2br($this->hrd->last_query()));
		return $query->result_array();
	}

	public function getJumlahDataAbsen($no_dok,$tanggal1,$tanggal2,$divisi_id="",$dept_id="",$kd_store="",$nip, $nama, $search_no="")
	{
		$where = "";
		if($search_no != ""){ $where .= " AND c.nip = $search_no";}
		if($no_dok != ""){ $where .= " AND no_dok_tdk_masuk LIKE '%$no_dok%'";}
		if($nip != ""){ $where .= " AND c.nip = $nip";}
		if($nama != ""){ $where .= " AND c.nama_lengkap LIKE '%$nama%'";}
		if($divisi_id !=""){ $where .= " AND d.divisi_id = $divisi_id";}
		if($dept_id !=""){ $where .= " AND d.dept_id = $dept_id";}
		if($kd_store !=""){ $where .= " AND d.kd_store = '".$kd_store."'";}

		$sql = "SELECT * FROM(
			SELECT * FROM(SELECT 'CUTI',no_dok_tdk_masuk, nip, nama_lengkap, b.tgl_tdk_masuk, j.nama_jabatan, e.nama_dept, f.nama_divisi, d.kd_store, h.nama_store,
				CASE WHEN IFNULL(p.tgl_absensi, '')='' THEN 'SEDANG PROSES' ELSE 'FIXED' END status_absen
				FROM hrd_all.trn_tidak_masuk_h a
				LEFT JOIN hrd_all.trn_tidak_masuk_d b ON a.tdk_masuk_h_id=b.tdk_masuk_h_id
				LEFT JOIN hrd_all.trn_absensi p ON a.biodata_id=p.biodata_id AND b.tgl_tdk_masuk=p.tgl_absensi
				LEFT JOIN hrd_all.mst_biodata c ON a.biodata_id=c.biodata_id
				LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
				LEFT JOIN hrd_all.mst_dept e ON d.dept_id = e.dept_id
				LEFT JOIN hrd_all.mst_divisi f ON d.divisi_id = f.divisi_id
				LEFT JOIN hrd_all.trn_posting t ON a.tdk_masuk_h_id=t.tdk_masuk_h_id
				LEFT JOIN hrd_all.mst_jabatan j ON d.jabatan_id = j.jabatan_id
				LEFT JOIN hrd_all.mst_store h ON d.kd_store = h.kode_store
				WHERE b.tgl_tdk_masuk BETWEEN '$tanggal1' AND '$tanggal2'
				$where
				AND (b.is_batal =0 OR a.is_batal =0)
				AND (t.status_dokumen <> 'R' OR IFNULL(t.status_dokumen,'') = '')
			AND LEFT(a.no_dok_tdk_masuk,3)='HRC')a
		UNION ALL
			SELECT * FROM (SELECT 'IJIN',
				no_dok_tdk_masuk, nip, nama_lengkap, b.tgl_tdk_masuk, j.nama_jabatan, e.nama_dept, f.nama_divisi, d.kd_store, h.nama_store,
				CASE WHEN t.status_dokumen='R' THEN 'REJECT'
				WHEN t.status_dokumen='O' THEN 'OPEN'
				WHEN t.status_dokumen='P' THEN 'SEDANG PROSES'
				ELSE 'FIXED' END status_absen
				FROM hrd_all.trn_tidak_masuk_h a
				LEFT JOIN hrd_all.trn_tidak_masuk_d b ON a.tdk_masuk_h_id=b.tdk_masuk_h_id
				LEFT JOIN hrd_all.mst_biodata c ON a.biodata_id=c.biodata_id
				LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
				LEFT JOIN hrd_all.mst_dept e ON d.dept_id = e.dept_id
				LEFT JOIN hrd_all.mst_divisi f ON d.divisi_id = f.divisi_id
				LEFT JOIN hrd_all.trn_posting t ON a.tdk_masuk_h_id=t.tdk_masuk_h_id
				LEFT JOIN hrd_all.mst_jabatan j ON d.jabatan_id = j.jabatan_id
				LEFT JOIN hrd_all.mst_store h ON d.kd_store = h.kode_store
				WHERE b.tgl_tdk_masuk BETWEEN '$tanggal1' AND '$tanggal2'
				$where
				AND (b.is_batal =0 OR a.is_batal =0)
				AND (t.status_dokumen <> 'R' OR IFNULL(t.status_dokumen,'') = '')
				AND (LEFT(a.no_dok_tdk_masuk,3)='HRI' AND a.status_absensi_id <>'000000000009')
				ORDER BY tgl_tdk_masuk ASC, c.nip ASC)a
		UNION ALL
			SELECT * FROM(SELECT 'SAKIT',no_dok_tdk_masuk, nip, nama_lengkap, b.tgl_tdk_masuk, j.nama_jabatan, e.nama_dept, f.nama_divisi, d.kd_store, h.nama_store,
				CASE
				WHEN t.status_dokumen='R' THEN 'REJECT'
				WHEN t.status_dokumen='O' THEN 'OPEN'
				WHEN t.status_dokumen='P' THEN 'SEDANG PROSES'
				WHEN (t.status_dokumen='C') AND (IFNULL(r.no_dok,'')='') AND(IFNULL(r.pic_reject,'')='')  THEN 'SEDANG VERIFIKASI HRD'
				WHEN (t.status_dokumen='C') AND (IFNULL(r.no_dok,'')<>'') AND(IFNULL(r.pic_reject,'')<>'')  THEN 'REJECT VERIFIKASI HRD'
				ELSE 'FIXED' END status_absen
				FROM hrd_all.trn_tidak_masuk_h a
				LEFT JOIN hrd_all.trn_tidak_masuk_d b ON a.tdk_masuk_h_id=b.tdk_masuk_h_id
				LEFT JOIN hrd_all.mst_biodata c ON a.biodata_id=c.biodata_id
				LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
				LEFT JOIN hrd_all.mst_dept e ON d.dept_id = e.dept_id
				LEFT JOIN hrd_all.mst_divisi f ON d.divisi_id = f.divisi_id
				LEFT JOIN hrd_all.trn_posting t ON a.tdk_masuk_h_id=t.tdk_masuk_h_id
				LEFT JOIN hrd_all.mst_jabatan j ON d.jabatan_id = j.jabatan_id
				LEFT JOIN hrd_all.trn_app_3rd r ON a.tdk_masuk_h_id = r.no_dok
				LEFT JOIN hrd_all.mst_store h ON d.kd_store = h.kode_store
				WHERE b.tgl_tdk_masuk BETWEEN '$tanggal1' AND '$tanggal2'
				$where
				AND (b.is_batal = 0 OR a.is_batal =0)
				AND (t.status_dokumen <> 'R' OR IFNULL(t.status_dokumen,'') = '')
				AND (LEFT(a.no_dok_tdk_masuk,3)='HRI' AND a.status_absensi_id ='000000000009')
				ORDER BY tgl_tdk_masuk ASC, c.nip ASC
				)a
			)a";
		$query = $this->hrd->query($sql);
		return $query->num_rows();
	}

	public function getDataAbsenPDF($tanggal1,$tanggal2,$divisi_id,$dept_id,$kd_store)
	{
		$this->hrd->select('no_dok_tdk_masuk,nip,nama_lengkap,b.tgl_tdk_masuk,j.nama_jabatan,e.nama_dept,f.nama_divisi,
		kd_store,CASE WHEN IFNULL(p.tgl_absensi,"")="" THEN "MASIH PROSES" ELSE "FIXED" END status_absen');
		$this->hrd->from('hrd_all.trn_tidak_masuk_h a');
		$this->hrd->join('hrd_all.trn_tidak_masuk_d b','a.tdk_masuk_h_id=b.tdk_masuk_h_id', 'left');
		$this->hrd->join('hrd_all.trn_absensi p','a.biodata_id=p.biodata_id AND b.tgl_tdk_masuk=p.tgl_absensi', 'left');
		$this->hrd->join('hrd_all.mst_biodata c','a.biodata_id=c.biodata_id', 'left');
		$this->hrd->join('hrd_all.biodata_pekerjaan_d d','a.biodata_id = d.biodata_id', 'left');
		$this->hrd->join('hrd_all.mst_dept e','d.dept_id = e.dept_id', 'left');
		$this->hrd->join('hrd_all.mst_divisi f','d.divisi_id = f.divisi_id', 'left');
		$this->hrd->join('hrd_all.trn_posting t','a.tdk_masuk_h_id=t.tdk_masuk_h_id', 'left');
		$this->hrd->join('hrd_all.mst_jabatan j','d.jabatan_id = j.jabatan_id', 'left');
		$this->hrd->where('b.tgl_tdk_masuk BETWEEN "'.$tanggal1.'" AND "'.$tanggal2.'"');
		$this->hrd->where('(b.is_batal=0 OR a.is_batal=0)');
		$this->hrd->where('(t.status_dokumen<>"R" OR IFNULL(t.status_dokumen,"")="")');
		$this->hrd->where('LEFT(a.no_dok_tdk_masuk,3)="HRC"');
		if($divisi_id !="") $this->hrd->where('d.divisi_id',$divisi_id);
		if($dept_id !="") $this->hrd->where_in('d.dept_id',$dept_id);
		if($kd_store !="") $this->hrd->where('d.kd_store',$kd_store);

		$this->hrd->order_by('tgl_tdk_masuk,d.divisi_id,d.dept_id,c.nip', 'ASC');
		// $this->hrd->order_by('divisi_id', ASC);
		// $this->hrd->order_by('c.nip',ASC);
		$query=$this->hrd->get();
		// die(nl2br($this->hrd->last_query()));
		return $query->result_array();
	}

	public function exportExcelCuti($data){
		// Load plugin PHPExcel nya
		include APPPATH.'libraries/PHPExcel.php';

		// Panggil class PHPExcel nya
		$excel = new PHPExcel();
		$tanggal1 = $data['header']['tanggal1'];
		$tanggal2 = $data['header']['tanggal2'];

		// Settingan awal fil excel
		$excel->getProperties()->setCreator('Report Cuti')
				->setLastModifiedBy('Report Cuti')
				->setTitle("Report Cuti")
				->setSubject("ReportCuti")
				->setDescription("Report Cuti")
				->setKeywords("Report Cuti");

		// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
		$style_col = array(
		'font' => array('bold' => true),
			 // Set font nya jadi bold
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				 // Set text jadi ditengah secara horizontal (center)
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);
		// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		$style_row = array(
		 	'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
			'borders' => array(
			 	'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "PT. Optik Tunggal Sempurna"); 
		$excel->getActiveSheet()->mergeCells('A1:H1'); // Set Merge Cell pada kolom A1 sampai E1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); // Set text center untuk kolom A1

		$excel->setActiveSheetIndex(0)->setCellValue('A2', "Jl. Pintu Air Raya No. 36 KL"); 
		$excel->getActiveSheet()->mergeCells('A2:H2'); // Set Merge Cell pada kolom A1 sampai E1
		// $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(10); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); // Set text center untuk kolom A1

		$excel->setActiveSheetIndex(0)->setCellValue('A3', "Jakarta Pusat 10710"); // Set kolom A1 dengan tulisan "DATA SISWA"
		$excel->getActiveSheet()->mergeCells('A3:H3'); // Set Merge Cell pada kolom A1 sampai E1
		// $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(10); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); // Set text center untuk kolom A1

		$excel->setActiveSheetIndex(0)->setCellValue('A4', "REPORT CUTI"); // Set kolom A1 dengan tulisan "DATA SISWA"
		$excel->getActiveSheet()->mergeCells('A4:H4'); // Set Merge Cell pada kolom A1 sampai E1
		$excel->getActiveSheet()->getStyle('A4')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A4')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

		$excel->setActiveSheetIndex(0)->setCellValue('A6', "PERIODE : ".substr($tanggal1,8,2)."-".substr($tanggal1,5,2)."-".substr($tanggal1,0,4)." S/D ".substr($tanggal2,8,2)."-".substr($tanggal2,5,2)."-".substr($tanggal2,0,4)); // Set kolom A1 dengan tulisan "DATA SISWA"
		$excel->getActiveSheet()->mergeCells('A6:H6'); // Set Merge Cell pada kolom A1 sampai E1
		$excel->getActiveSheet()->getStyle('A6')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A6')->getFont()->setSize(10); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); // Set text center untuk kolom A1

		$excel->setActiveSheetIndex(0)->setCellValue('A7', "WAKTU CETAK : " .date("Y-M-d (H:i:s)")); // Set kolom A1 dengan tulisan "DATA SISWA"
		$excel->getActiveSheet()->mergeCells('A7:H7'); // Set Merge Cell pada kolom A1 sampai E1
		$excel->getActiveSheet()->getStyle('A7')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A7')->getFont()->setSize(10); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); // Set text center untuk kolom A1

		 // Buat header tabel nya pada baris ke 3
		$excel->setActiveSheetIndex(0)->setCellValue('A8', "NIP"); // Set kolom A4 dengan tulisan "NO"
		$excel->setActiveSheetIndex(0)->setCellValue('B8', "NAMA LENGKAP"); // Set kolom B3 dengan tulisan "KD.BRG.SUPP"
		$excel->setActiveSheetIndex(0)->setCellValue('C8', "TGL. TIDAK MASUK"); // Set kolom C3 dengan tulisan "KD.BARANG"
		$excel->setActiveSheetIndex(0)->setCellValue('D8', "JABATAN"); // Set kolom D3 dengan tulisan "NM.BARANG"
		$excel->setActiveSheetIndex(0)->setCellValue('E8', "DEPARTEMENT"); // Set kolom E3 dengan tulisan "SALDO AWAL"
		$excel->setActiveSheetIndex(0)->setCellValue('F8', "DIVISI"); // Set kolom D3 dengan tulisan "QTY.IN"
		$excel->setActiveSheetIndex(0)->setCellValue('G8', "STORE"); // Set kolom D3 dengan tulisan "QTY.OUT"
		$excel->setActiveSheetIndex(0)->setCellValue('H8', "STATUS"); // Set kolom D3 dengan tulisan "BTL.IN"
	
		// Apply style header yang telah kita buat tadi ke masing-masing kolom header
		$excel->getActiveSheet()->getStyle('A8')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('A8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
		$excel->getActiveSheet()->getStyle('B8')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C8')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D8')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E8')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('F8')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('G8')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('H8')->applyFromArray($style_col);
	
		// Panggil function view yang ada di master stok normal model untuk menampilkan semua data siswanya
		$no = 1; // Untuk penomoran tabel, di awal set dengan 1
		$numrow = 9; // Set baris pertama untuk isi tabel adalah baris ke 4
		//  die(json_encode($data));
		foreach($data['detail'] as $data){ // Lakukan looping pada variabel siswa
		 	$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $data['nip']);
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data['nama_lengkap']);
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data['tgl_tdk_masuk']);
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data['nama_jabatan']);
			$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data['nama_dept']);
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data['nama_divisi']);
			$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $data['kd_store']);
			$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $data['status_absen']);
	
			// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('A'.$numrow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
			$no++; // Tambah 1 setiap kali looping
			$numrow++; // Tambah 1 setiap kali looping
		}
			 // Set width kolom
		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);  // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(40); // Set width kolom B
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(20); // Set width kolom C
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Set width kolom D
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(40); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('F')->setWidth(30); // Set width kolom F
		$excel->getActiveSheet()->getColumnDimension('G')->setWidth(10); // Set width kolom G
		$excel->getActiveSheet()->getColumnDimension('H')->setWidth(10); // Set width kolom H
		// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("Report Cuti");
		// $excel->setActiveSheetIndex(0)->getHighestRow();
		$excel->setActiveSheetIndex(0);
	
		// Proses file excel
		$filename = "ReportCuti". date("Y-m-d (H-i-s)").".xls"; //Setting penamaan dokumen excel dengan tanggal cetak
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="'.$filename.'"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
		ob_end_clean();
		$write->save('php://output');
		exit;
	}

	public function getDataAbensiStatus($tanggal1,$tanggal2,$divisi_id,$dept_id,$kd_store,$status_absensi,$karyawan,$nip,$nama, $search_no = "", $length = "", $start = "", $column = "", $order = "")
	{
		if($karyawan != "") $this->hrd->where('nip',$karyawan);

		$this->hrd->select('nip,nama_lengkap,nama_dept,tgl_absensi,jam_masuk,jam_keluar,CONCAT(ket_status_absensi," (",a.keterangan,")") ket_status_absensi, keterangan2');
		$this->hrd->from('hrd_all.trn_absensi a');
		$this->hrd->join('hrd_all.mst_biodata b','a.biodata_id=b.biodata_id');
		$this->hrd->join('hrd_all.biodata_pekerjaan_d c','a.biodata_id=c.biodata_id');
		$this->hrd->join('hrd_all.mst_dept d','c.dept_id = d.dept_id');
		$this->hrd->join('hrd_all.mst_status_absensi e','a.keterangan=e.kode_status_absensi');
		$this->hrd->where('tgl_absensi BETWEEN "'.$tanggal1.'" AND "'.$tanggal2.'"');
		if($status_absensi !="") $this->hrd->where_in('a.keterangan',$status_absensi);
		if($divisi_id !="") $this->hrd->where('c.divisi_id',$divisi_id);
		if($dept_id !="") $this->hrd->where_in('c.dept_id',$dept_id);
		if($kd_store !="") $this->hrd->where('kd_store',$kd_store);
		if($nip !="") $this->hrd->where('nip',$nip);
		if($nama !="") $this->hrd->like('nama_lengkap',$nama,'both');

		if($column == 0){
			$this->hrd->order_by('tgl_absensi', $order);
			$this->hrd->order_by('nip', $order);
		}
		$this->hrd->limit($length,$start);
		$query=$this->hrd->get();
		// die(nl2br($this->hrd->last_query()));
		return $query->result_array();
	}

	public function getJumlahDataAbsensiStatus($tanggal1,$tanggal2,$divisi_id,$dept_id,$kd_store,$status_absensi,$karyawan,$nip,$nama)
	{
		$this->hrd->select('nip,nama_lengkap,nama_dept,tgl_absensi,jam_masuk,jam_keluar,ket_status_absensi, keterangan2');
		$this->hrd->from('hrd_all.trn_absensi a');
		$this->hrd->join('hrd_all.mst_biodata b','a.biodata_id=b.biodata_id');
		$this->hrd->join('hrd_all.biodata_pekerjaan_d c','a.biodata_id=c.biodata_id');
		$this->hrd->join('hrd_all.mst_dept d','c.dept_id = d.dept_id');
		$this->hrd->join('hrd_all.mst_status_absensi e','a.keterangan=e.kode_status_absensi');
		$this->hrd->where('tgl_absensi BETWEEN "'.$tanggal1.'" AND "'.$tanggal2.'"');
		if($status_absensi !="") $this->hrd->where_in('a.keterangan',$status_absensi);
		if($divisi_id !="") $this->hrd->where('c.divisi_id',$divisi_id);
		if($dept_id !="") $this->hrd->where_in('c.dept_id',$dept_id);
		if($kd_store !="") $this->hrd->where('kd_store',$kd_store);
		if($karyawan != "") $this->hrd->where('nip',$karyawan);
		if($nip !="") $this->hrd->where('nip',$nip);
		if($nama !="") $this->hrd->like('nama_lengkap',$nama,'both');

		$this->hrd->order_by('tgl_absensi', 'DESC');
		$jum=$this->hrd->get();
		return $jum->num_rows();
	}

	public function getDataAbsensiStatusPDF($tanggal1,$tanggal2,$divisi_id,$dept_id,$kd_store,$status_absensi)
	{
		$this->hrd->select('nip,nama_lengkap,nama_dept,tgl_absensi,jam_masuk,jam_keluar,CONCAT(ket_status_absensi," (",a.keterangan,")") ket_status_absensi, keterangan2');
		$this->hrd->from('hrd_all.trn_absensi a');
		$this->hrd->join('hrd_all.mst_biodata b','a.biodata_id=b.biodata_id');
		$this->hrd->join('hrd_all.biodata_pekerjaan_d c','a.biodata_id=c.biodata_id');
		$this->hrd->join('hrd_all.mst_dept d','c.dept_id = d.dept_id');
		$this->hrd->join('hrd_all.mst_status_absensi e','a.keterangan=e.kode_status_absensi');
		$this->hrd->where('tgl_absensi BETWEEN "'.$tanggal1.'" AND "'.$tanggal2.'"');
		if($status_absensi !="") $this->hrd->where_in('a.keterangan',$status_absensi);
		if($divisi_id !="") $this->hrd->where('c.divisi_id',$divisi_id);
		if($dept_id !="") $this->hrd->where_in('c.dept_id',$dept_id);
		if($kd_store !="") $this->hrd->where('kd_store',$kd_store);

		$this->hrd->order_by('a.tgl_absensi,c.divisi_id,c.dept_id,b.nip', 'ASC');
		$query=$this->hrd->get();
		return $query->result_array();
	}

	public function exportExcelAbsensi($data){
		// Load plugin PHPExcel nya
		include APPPATH.'libraries/PHPExcel.php';

		// Panggil class PHPExcel nya
		$excel = new PHPExcel();
		$tanggal1 = $data['header']['tanggal1'];
		$tanggal2 = $data['header']['tanggal2'];

		// Settingan awal fil excel
		$excel->getProperties()->setCreator('Report Absensi')
				->setLastModifiedBy('Report Absensi')
				->setTitle("Report Absensi")
				->setSubject("ReportAbsensi")
				->setDescription("Report Absensi")
				->setKeywords("Report Absensi");

		// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
		$style_col = array(
		'font' => array('bold' => true),
			 // Set font nya jadi bold
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				 // Set text jadi ditengah secara horizontal (center)
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);
		// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		$style_row = array(
		 	'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
			'borders' => array(
			 	'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "PT. Optik Tunggal Sempurna"); 
		$excel->getActiveSheet()->mergeCells('A1:H1'); // Set Merge Cell pada kolom A1 sampai E1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); // Set text center untuk kolom A1

		$excel->setActiveSheetIndex(0)->setCellValue('A2', "Jl. Pintu Air Raya No. 36 KL"); 
		$excel->getActiveSheet()->mergeCells('A2:H2'); // Set Merge Cell pada kolom A1 sampai E1
		// $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(10); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); // Set text center untuk kolom A1

		$excel->setActiveSheetIndex(0)->setCellValue('A3', "Jakarta Pusat 10710"); // Set kolom A1 dengan tulisan "DATA SISWA"
		$excel->getActiveSheet()->mergeCells('A3:H3'); // Set Merge Cell pada kolom A1 sampai E1
		// $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(10); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); // Set text center untuk kolom A1

		$excel->setActiveSheetIndex(0)->setCellValue('A4', "REPORT ABSENSI"); // Set kolom A1 dengan tulisan "DATA SISWA"
		$excel->getActiveSheet()->mergeCells('A4:H4'); // Set Merge Cell pada kolom A1 sampai E1
		$excel->getActiveSheet()->getStyle('A4')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A4')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

		$excel->setActiveSheetIndex(0)->setCellValue('A6', "PERIODE : ".substr($tanggal1,8,2)."-".substr($tanggal1,5,2)."-".substr($tanggal1,0,4)." S/D ".substr($tanggal2,8,2)."-".substr($tanggal2,5,2)."-".substr($tanggal2,0,4)); // Set kolom A1 dengan tulisan "DATA SISWA"
		$excel->getActiveSheet()->mergeCells('A6:H6'); // Set Merge Cell pada kolom A1 sampai E1
		$excel->getActiveSheet()->getStyle('A6')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A6')->getFont()->setSize(10); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); // Set text center untuk kolom A1

		$excel->setActiveSheetIndex(0)->setCellValue('A7', "WAKTU CETAK : " .date("Y-M-d (H:i:s)")); // Set kolom A1 dengan tulisan "DATA SISWA"
		$excel->getActiveSheet()->mergeCells('A7:H7'); // Set Merge Cell pada kolom A1 sampai E1
		$excel->getActiveSheet()->getStyle('A7')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A7')->getFont()->setSize(10); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); // Set text center untuk kolom A1

		 // Buat header tabel nya pada baris ke 3
		$excel->setActiveSheetIndex(0)->setCellValue('A8', "NIP"); // Set kolom A4 dengan tulisan "NO"
		$excel->setActiveSheetIndex(0)->setCellValue('B8', "NAMA LENGKAP"); // Set kolom B3 dengan tulisan "KD.BRG.SUPP"
		$excel->setActiveSheetIndex(0)->setCellValue('C8', "DEPARTEMENT"); // Set kolom C3 dengan tulisan "KD.BARANG"
		$excel->setActiveSheetIndex(0)->setCellValue('D8', "TGL. ABSENSI"); // Set kolom D3 dengan tulisan "NM.BARANG"
		$excel->setActiveSheetIndex(0)->setCellValue('E8', "JAM MASUK"); // Set kolom E3 dengan tulisan "SALDO AWAL"
		$excel->setActiveSheetIndex(0)->setCellValue('F8', "JAM KELUAR"); // Set kolom D3 dengan tulisan "QTY.IN"
		$excel->setActiveSheetIndex(0)->setCellValue('G8', "STATUS ABSENSI"); // Set kolom D3 dengan tulisan "QTY.OUT"
		$excel->setActiveSheetIndex(0)->setCellValue('H8', "KETERANGAN"); // Set kolom D3 dengan tulisan "BTL.IN"
	
		// Apply style header yang telah kita buat tadi ke masing-masing kolom header
		$excel->getActiveSheet()->getStyle('A8')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('A8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
		$excel->getActiveSheet()->getStyle('B8')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C8')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D8')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E8')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('F8')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('G8')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('H8')->applyFromArray($style_col);
	
		// Panggil function view yang ada di master stok normal model untuk menampilkan semua data siswanya
		$no = 1; // Untuk penomoran tabel, di awal set dengan 1
		$numrow = 9; // Set baris pertama untuk isi tabel adalah baris ke 4
		//  die(json_encode($data));
		foreach($data['detail'] as $data){ // Lakukan looping pada variabel siswa
		 	$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $data['nip']);
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data['nama_lengkap']);
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data['nama_dept']);
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data['tgl_absensi']);
			$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data['jam_masuk']);
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data['jam_keluar']);
			$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $data['ket_status_absensi']);
			$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $data['keterangan2']);
	
			// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('A'.$numrow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
			$no++; // Tambah 1 setiap kali looping
			$numrow++; // Tambah 1 setiap kali looping
		}
			 // Set width kolom
		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);  // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(40); // Set width kolom B
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(40); // Set width kolom C
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(15); // Set width kolom D
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(15); // Set width kolom E
		$excel->getActiveSheet()->getColumnDimension('F')->setWidth(15); // Set width kolom F
		$excel->getActiveSheet()->getColumnDimension('G')->setWidth(40); // Set width kolom G
		$excel->getActiveSheet()->getColumnDimension('H')->setWidth(50); // Set width kolom H
		// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("Report Absensi");
		// $excel->setActiveSheetIndex(0)->getHighestRow();
		$excel->setActiveSheetIndex(0);
	
		// Proses file excel
		$filename = "ReportAbsensi". date("Y-m-d (H-i-s)").".xls"; //Setting penamaan dokumen excel dengan tanggal cetak
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="'.$filename.'"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
		ob_end_clean();
		$write->save('php://output');
		exit;
	}

	//tambahan handri 07 02 2022
	public function getDataApprovalPersonil($divisi_id, $dept_id, $nip, $length = "", $start = ""){
		$where = "";
		if($divisi_id !== ""){ $where .= "AND h.divisi_id = '$divisi_id'"; }
		if($dept_id !== ""){ $where .= "AND f.dept_id= '$dept_id'"; }
		if($nip !== ""){ $where .= "AND e.nip= '$nip'"; }

		$sql = "SELECT
		e.nip, e.nama_lengkap, c.nip cnip ,c.nama_lengkap cnama_lengkap,urutan_approval,f.nama,divisi_user,dept_user,h.divisi_id, f.dept_id ,i.kd_store
		FROM hrd_web_master.mst_user_approval_detail a
		LEFT JOIN hrd_web_master.mst_karyawan_01 b ON a.karyawan_id = b.karyawan_id
		LEFT JOIN hrd_all.mst_biodata c ON b.biodata = c.biodata_id
		LEFT JOIN hrd_web_master.mst_karyawan_01 d ON a.approved_user = d.karyawan_id
		LEFT JOIN hrd_all.mst_biodata e ON d.biodata = e.biodata_id
		LEFT JOIN hrd_web_master.mst_departemen f ON a.dept_user = f.hash
		LEFT JOIN hrd_web_master.mst_divisi g ON f.divisi =g.hash
		LEFT JOIN hrd_all.mst_divisi h ON g.kode = h.kode_divisi
		LEFT JOIN hrd_all.biodata_pekerjaan_d i ON e.biodata_id = i.biodata_id
		WHERE IFNULL(e.nama_lengkap,'')<>''
		$where
		ORDER BY nama,e.nip, urutan_approval
		limit ".$start.",".$length." ";

		$query=$this->hrd->query($sql);
		// die(nl2br($this->hrd->last_query()));
		return $query->result_array();
	}

	public function getJumlahDataApprovalPersonil($divisi_id, $dept_id, $nip){
		$where = "";
		if($divisi_id !== ""){ $where .= "AND h.divisi_id = '$divisi_id'"; }
		if($dept_id !== ""){ $where .= "AND f.dept_id= '$dept_id'"; }
		if($nip !== ""){ $where .= "AND e.nip= '$nip'"; }
		$sql = "SELECT
		e.nip, e.nama_lengkap, c.nip cnip ,c.nama_lengkap cnama_lengkap,urutan_approval,f.nama,divisi_user,dept_user,h.divisi_id, f.dept_id ,i.kd_store
		FROM hrd_web_master.mst_user_approval_detail a
		LEFT JOIN hrd_web_master.mst_karyawan_01 b ON a.karyawan_id = b.karyawan_id
		LEFT JOIN hrd_all.mst_biodata c ON b.biodata = c.biodata_id
		LEFT JOIN hrd_web_master.mst_karyawan_01 d ON a.approved_user = d.karyawan_id
		LEFT JOIN hrd_all.mst_biodata e ON d.biodata = e.biodata_id
		LEFT JOIN hrd_web_master.mst_departemen f ON a.dept_user = f.hash
		LEFT JOIN hrd_web_master.mst_divisi g ON f.divisi =g.hash
		LEFT JOIN hrd_all.mst_divisi h ON g.kode = h.kode_divisi
		LEFT JOIN hrd_all.biodata_pekerjaan_d i ON e.biodata_id = i.biodata_id
		WHERE IFNULL(e.nama_lengkap,'')<>''
		$where
		ORDER BY nama,e.nip, urutan_approval";
		$jum=$this->hrd->query($sql);
		return $jum->num_rows();
	}


	public function getDataPic($length = "", $start = ""){
		$sql = "SELECT a.nip, a.nama_lengkap, a.nama_dept, a.kd_store FROM hrd_web_master.mst_pic_app a
		LEFT JOIN hrd_web_master.mst_karyawan_01 b ON a.nip = b.nip
		LEFT JOIN hrd_web_master.mst_user_approval c ON b.karyawan_id = c.karyawan_id
		WHERE IFNULL(a.nama_lengkap,'')<>''
		ORDER BY a.nama_dept, a.nip, a.nama_lengkap
		limit ".$start.",".$length." ";
		$query=$this->hrd->query($sql);
		return $query->result_array();
	}

	public function getJumlahDataPic(){
		$sql = "SELECT a.nip, a.nama_lengkap, a.nama_dept, a.kd_store FROM hrd_web_master.mst_pic_app a
		LEFT JOIN hrd_web_master.mst_karyawan_01 b ON a.nip = b.nip
		LEFT JOIN hrd_web_master.mst_user_approval c ON b.karyawan_id = c.karyawan_id
		WHERE IFNULL(a.nama_lengkap,'')<>''
		ORDER BY a.nama_dept, a.nip, a.nama_lengkap";
		$jum=$this->hrd->query($sql);
		return $jum->num_rows();
	}


	public function getDataListCP($nip, $length = "", $start = ""){
		$where_nip = "";
		if($nip !== ""){
			$where_nip = "AND a.nip_user = '$nip'";
		}
		$sql = "SELECT a.nip_approval nip_app, b.nama_lengkap nama_app, a.nip_user,
		c.nama_lengkap nama_user, a.urutan_app, a.email
		FROM hrd_all.trn_app_cp a
		LEFT JOIN hrd_all.mst_biodata b ON a.nip_approval = b.nip
		LEFT JOIN hrd_all.mst_biodata c ON a.nip_user = c.nip
		WHERE IFNULL(b.nama_lengkap,'')<>''
		$where_nip
		ORDER BY c.nama_lengkap, a.urutan_app
		limit ".$start.",".$length." ";
		$query=$this->hrd->query($sql);
		// die($this->hrd->last_query());
		return $query->result_array();
	}

	public function getCountListCP($nip){
		$where_nip = "";
		if($nip !== ""){
			$where_nip = "AND a.nip_user = '$nip'";
		}

		$sql = "SELECT a.nip_approval nip_app, b.nama_lengkap nama_app, a.nip_user,
		c.nama_lengkap nama_user, a.urutan_app, a.email
		FROM hrd_all.trn_app_cp a
		LEFT JOIN hrd_all.mst_biodata b ON a.nip_approval = b.nip
		LEFT JOIN hrd_all.mst_biodata c ON a.nip_user = c.nip
		WHERE IFNULL(b.nama_lengkap,'')<>''
		$where_nip";
		$jum=$this->hrd->query($sql);
		return $jum->num_rows();
	}

	//Laporan Cuti Pengganti
	public function getCutiPengganti($result=null,$karyawan,$tanggal1,$tanggal2,$divisi_id,$dept_id,$kd_store,$search_no = "", $length = "", $start = "", $column = "", $order = "")
	{
		$result_limit="";
		if($result == 'result'){
			$result_limit = "ORDER BY no_doc limit ".$start.",".$length."";
		}

		$where_karyawan = "";
		if($karyawan !== ""){
			$where_karyawan = "AND a.nip = '$karyawan'";
		}

		$where_divisi_id = "";
		if($divisi_id !== ""){
			$where_divisi_id = "AND d.divisi_id = '$divisi_id' ";
		}

		$where_dept_id = "";
		if($dept_id !== ""){
			$where_dept_id = "AND d.dept_id = '$dept_id' ";
		}

		$where_kd_store = "";
		if($kd_store !== ""){
			$where_kd_store = "AND d.kd_store LIKE '%".$kd_store."%'";
		}

		$sql = "SELECT
			no_doc, a.nip,c.nama_lengkap, d.kd_store, e.nama_dept, tgl_awal,
			DATE_ADD(tgl_awal,INTERVAL 6 MONTH)tgl_akhir , a.keterangan
			,app_1, tgl_app_1,app_2, tgl_app_2,app_3, tgl_app_3
			,rej_1, tgl_rej_1,rej_2, tgl_rej_2,rej_3, tgl_rej_3,
			CASE
			WHEN status_dokumen = 'O' THEN 'OPEN'
			WHEN status_dokumen = 'P' THEN 'SEDANG PROSES'
			WHEN status_dokumen = 'C' THEN 'APPROVED' ELSE 'REJECT'
			END status_dokumen
			FROM hrd_all.trn_pengajuan_cuti_tambahan a
			LEFT JOIN hrd_all.trn_posting b ON a.no_doc = b.tdk_masuk_h_id
			INNER JOIN hrd_all.mst_biodata c ON a.nip = c.nip
			INNER JOIN hrd_all.biodata_pekerjaan_d d ON c.biodata_id = d.biodata_id
			INNER JOIN hrd_all.mst_dept e ON d.dept_id = e.dept_id
			WHERE IFNULL(c.nama_lengkap,'')<>''
			AND DATE(tgl_awal) BETWEEN '$tanggal1' AND '$tanggal2'
			$where_karyawan
			$where_divisi_id
			$where_dept_id
			$where_kd_store
			".$result_limit."
		";

		if($result == 'count'){
			$query = $this->hrd->query($sql)->num_rows();
		}else{
			$query = $this->hrd->query($sql)->result_array();
		}
		// die(nl2br($this->hrd->last_query()));
		return $query;
	}

	public function getCutiPenggantiCount($query,$tanggal1,$tanggal2,$divisi_id,$dept_id,$kd_store,$search_no = "", $length = "", $start = "", $column = "", $order = "")
	{
		$sql = "SELECT
			no_doc, a.nip,c.nama_lengkap, d.kd_store, e.nama_dept, tgl_awal,
			DATE_ADD(tgl_awal,INTERVAL 6 MONTH)tgl_akhir , a.keterangan
			,app_1, tgl_app_1
			,app_2, tgl_app_2
			,app_3, tgl_app_3
			,rej_1, tgl_rej_1
			,rej_2, tgl_rej_2
			,rej_3, tgl_rej_3,
			CASE
			WHEN status_dokumen = 'O' THEN 'OPEN'
			WHEN status_dokumen = 'P' THEN 'SEDANG PROSES'
			WHEN status_dokumen = 'C' THEN 'APPROVED' ELSE 'REJECT'
			END status_dokumen
			FROM hrd_all.trn_pengajuan_cuti_tambahan a
			LEFT JOIN hrd_all.trn_posting b ON a.no_doc = b.tdk_masuk_h_id
			INNER JOIN hrd_all.mst_biodata c ON a.nip = c.nip
			INNER JOIN hrd_all.biodata_pekerjaan_d d ON c.biodata_id = d.biodata_id
			INNER JOIN hrd_all.mst_dept e ON d.dept_id = e.dept_id";
		$query = $this->hrd->query($sql);
		return $query->num_rows();
	}

	public function HeaderDoc($no_dok_h = null)
	{
		if($no_dok_h) {
			$sql = "SELECT a.*, b.ket_status_absensi, b.kode_status_absensi, c.nip, c.nama_lengkap
			FROM hrd_all.trn_tidak_masuk_h a
			LEFT JOIN hrd_all.mst_status_absensi b ON a.status_absensi_id  = b.status_absensi_id
			LEFT JOIN hrd_all.mst_biodata c ON a.biodata_id = c.biodata_id
			WHERE no_dok_tdk_masuk = ?";
			$query = $this->hrd->query($sql, array($no_dok_h));
			// die(nl2br($this->hrd->last_query()));
			return $query->row_array();
		}
		$sql = "SELECT * FROM hrd_all.trn_tidak_masuk_h ORDER BY tdk_masuk_h_id DESC";
		$query = $this->hrd->query($sql);
		return $query->result_array();
	}

	public function DetailDoc($no_dok_h = null)
	{
		if(!$no_dok_h) {
			return false;
		}

		$sql = "SELECT a.tdk_masuk_h_id,a.tgl_tdk_masuk,a.tgl_tdk_masuk, a.nama_hari, a.keterangan,
			a.potong_cuti_dari , a.tgl_input, b.no_dok_tdk_masuk
			FROM hrd_all.trn_tidak_masuk_d a
			LEFT JOIN hrd_all.trn_tidak_masuk_h b ON b.tdk_masuk_h_id = a.tdk_masuk_h_id
			WHERE b.no_dok_tdk_masuk = '$no_dok_h'
			ORDER BY a.tgl_tdk_masuk ASC;
		";
		$query = $this->hrd->query($sql);
		// die(nl2br($this->hrd->last_query()));
		return $query->result_array();
	}

	//Laporan Cuti Dispensasi
	public function getCutiDispensasi($tanggal1,$tanggal2,$divisi_id="",$dept_id="",$kd_store="",$search_no = "", $length = "", $start = "", $column = "", $order = "")
	{
		$where = "";
		if($search_no != ""){ $where .= " AND c.nip = $search_no";}
		if($divisi_id !=""){ $where .= " AND d.divisi_id = $divisi_id";}
		if($dept_id !=""){ $where .= " AND d.dept_id = $dept_id";}
		if($kd_store !=""){ $where .= " AND d.kd_store = '".$kd_store."'";}

		$sql = "SELECT *, s.ket_status_absensi FROM hrd_all.trn_cuti_dispensasi_h a
			LEFT JOIN hrd_all.trn_cuti_dispensasi_d b ON a.cuti_dispensasi_h_id=b.cuti_dispensasi_h_id
			LEFT JOIN hrd_all.mst_status_absensi s ON a.status_absensi_id  = s.status_absensi_id
			LEFT JOIN hrd_all.trn_absensi p ON a.biodata_id=p.biodata_id AND b.tgl_cuti=p.tgl_absensi
			LEFT JOIN hrd_all.mst_biodata c ON a.biodata_id=c.biodata_id
			LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
			LEFT JOIN hrd_all.mst_dept e ON d.dept_id = e.dept_id
			LEFT JOIN hrd_all.mst_divisi f ON d.divisi_id = f.divisi_id
			LEFT JOIN hrd_all.trn_posting t ON a.cuti_dispensasi_h_id=t.tdk_masuk_h_id
			LEFT JOIN hrd_all.mst_jabatan j ON d.jabatan_id = j.jabatan_id
			LEFT JOIN hrd_all.mst_store h ON d.kd_store = h.kode_store
			WHERE a.tgl_mulai_cuti BETWEEN '$tanggal1' AND '$tanggal2'
			$where
			GROUP BY a.no_dok_cuti
			ORDER BY tgl_mulai_cuti,nip
			LIMIT $start,$length";

		$query = $this->hrd->query($sql);
		// die(nl2br($this->hrd->last_query()));
		return $query->result_array();
	}

	public function getCutiDispensasiCount($tanggal1,$tanggal2,$divisi_id="",$dept_id="",$kd_store="",$search_no = "", $length = "", $start = "", $column = "", $order = "")
	{
		$where = "";
		if($search_no != ""){ $where .= " AND c.nip = $search_no";}
		if($divisi_id !=""){ $where .= " AND d.divisi_id = $divisi_id";}
		if($dept_id !=""){ $where .= " AND d.dept_id = $dept_id";}
		if($kd_store !=""){ $where .= " AND d.kd_store = '".$kd_store."'";}

		$sql = "SELECT *, s.ket_status_absensi FROM hrd_all.trn_cuti_dispensasi_h a
			LEFT JOIN hrd_all.trn_cuti_dispensasi_d b ON a.cuti_dispensasi_h_id=b.cuti_dispensasi_h_id
			LEFT JOIN hrd_all.mst_status_absensi s ON a.status_absensi_id  = s.status_absensi_id
			LEFT JOIN hrd_all.trn_absensi p ON a.biodata_id=p.biodata_id AND b.tgl_cuti=p.tgl_absensi
			LEFT JOIN hrd_all.mst_biodata c ON a.biodata_id=c.biodata_id
			LEFT JOIN hrd_all.biodata_pekerjaan_d d ON a.biodata_id = d.biodata_id
			LEFT JOIN hrd_all.mst_dept e ON d.dept_id = e.dept_id
			LEFT JOIN hrd_all.mst_divisi f ON d.divisi_id = f.divisi_id
			LEFT JOIN hrd_all.trn_posting t ON a.cuti_dispensasi_h_id=t.tdk_masuk_h_id
			LEFT JOIN hrd_all.mst_jabatan j ON d.jabatan_id = j.jabatan_id
			LEFT JOIN hrd_all.mst_store h ON d.kd_store = h.kode_store
			WHERE a.tgl_mulai_cuti BETWEEN '$tanggal1' AND '$tanggal2'
			$where
			GROUP BY a.no_dok_cuti
			ORDER BY tgl_mulai_cuti,nip
		";

		$query = $this->hrd->query($sql);
		// die(nl2br($this->hrd->last_query()));
		return $query->num_rows();
	}

	public function HeaderDispensasi($no_dok_h = null)
	{
		if($no_dok_h) {
			$sql = "SELECT a.*, b.ket_status_absensi, b.kode_status_absensi, c.nip, c.nama_lengkap,
			CASE
			WHEN status_dokumen = 'O' THEN 'OPEN'
			WHEN status_dokumen = 'P' THEN 'SEDANG PROSES'
			WHEN status_dokumen = 'C' THEN 'APPROVED' ELSE 'REJECT'
			END status_dokumen
			FROM hrd_all.trn_cuti_dispensasi_h a
			LEFT JOIN hrd_all.mst_status_absensi b ON a.status_absensi_id  = b.status_absensi_id
			LEFT JOIN hrd_all.trn_posting t ON a.cuti_dispensasi_h_id=t.tdk_masuk_h_id
			LEFT JOIN hrd_all.mst_biodata c ON a.biodata_id = c.biodata_id
			WHERE no_dok_cuti = ?";
			$query = $this->hrd->query($sql, array($no_dok_h));
			// die(nl2br($this->hrd->last_query()));
			return $query->row_array();
		}
		$sql = "SELECT * FROM hrd_all.trn_cuti_dispensasi_h ORDER BY cuti_dispensasi_h_id DESC";
		$query = $this->hrd->query($sql);
		return $query->result_array();
	}

	public function DetailDispensasi($no_dok_h = null)
	{
		if(!$no_dok_h) {
			return false;
		}

		$sql = "SELECT *
			FROM hrd_all.trn_cuti_dispensasi_d a
			LEFT JOIN hrd_all.trn_cuti_dispensasi_h b ON b.cuti_dispensasi_h_id = a.cuti_dispensasi_h_id
			WHERE b.no_dok_cuti = '$no_dok_h'
			ORDER BY a.tgl_cuti ASC;
		";
		$query = $this->hrd->query($sql);
		// die(nl2br($this->hrd->last_query()));
		return $query->result_array();
	}

	public function getDataLampiran($no_dok_h = null)
	{
		if(!$no_dok_h) {
			return false;
		}

		$sql = "SELECT *
			FROM hrd_all.trn_dokumen_ijin
			WHERE no_dok = '$no_dok_h';
		";
		$query = $this->hrd->query($sql);
		return $query->result_array();
	}

}