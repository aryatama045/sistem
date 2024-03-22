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
		$sql = "SELECT kode_status_absensi,ket_status_absensi 
		FROM hrd_all.mst_status_absensi 
		WHERE aktif=1 AND kode_status_absensi<>''
		ORDER BY ket_status_absensi ASC"; 
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
		$sql = "SELECT dept_id,kode_dept,nama_dept FROM hrd_all.mst_dept WHERE divisi_id='".$divisi_id."' "; 
		$query 	= $this->hrd->query($sql);
		return 	$query;
	}

	public function getDataStore($divisi_id,$dept_id){
		$sql = "SELECT DISTINCT kd_store,b.nama_store
						FROM hrd_all.biodata_pekerjaan_d a
						INNER JOIN hrd_all.mst_store b ON a.kd_store=b.kode_store
						WHERE b.aktif=1 AND divisi_id='".$divisi_id."' AND dept_id='".$dept_id."'"; 
		$query 	= $this->hrd->query($sql);
		return 	$query;
	}

	public function getDataAbsen($tanggal1,$tanggal2,$divisi_id,$dept_id,$kd_store,$search_no = "", $length = "", $start = "", $column = "", $order = "")
	{
		if($search_no != "") $this->hrd->like('c.nip',$search_no);

		$this->hrd->select('nip,nama_lengkap,b.tgl_tdk_masuk,j.nama_jabatan,e.nama_dept,f.nama_divisi,
			kd_store,CASE WHEN IFNULL(p.tgl_absensi,"")="" THEN "MASIH PROSES" ELSE "FIXED" END status_absen');
		$this->hrd->from('hrd_all.trn_tidak_masuk_h a');
		$this->hrd->join('hrd_all.trn_tidak_masuk_d b','a.tdk_masuk_h_id=b.tdk_masuk_h_id');
		$this->hrd->join('hrd_all.trn_absensi p','a.biodata_id=p.biodata_id AND b.tgl_tdk_masuk=p.tgl_absensi');
		$this->hrd->join('hrd_all.mst_biodata c','a.biodata_id=c.biodata_id');
		$this->hrd->join('hrd_all.biodata_pekerjaan_d d','a.biodata_id = d.biodata_id');
		$this->hrd->join('hrd_all.mst_dept e','d.dept_id = e.dept_id');
		$this->hrd->join('hrd_all.mst_divisi f','d.divisi_id = f.divisi_id');
		$this->hrd->join('hrd_all.trn_posting t','a.tdk_masuk_h_id=t.tdk_masuk_h_id');
		$this->hrd->join('hrd_all.mst_jabatan j','d.jabatan_id = j.jabatan_id');
		$this->hrd->where('b.tgl_tdk_masuk BETWEEN "'.$tanggal1.'" AND "'.$tanggal2.'"');
		// $this->hrd->where('b.tgl_tdk_masuk BETWEEN "2021-12-01" AND "2021-12-31"');
		$this->hrd->where('(b.is_batal=0 OR a.is_batal=0)');
		$this->hrd->where('(t.status_dokumen<>"R" OR IFNULL(t.status_dokumen,"")="")');
		if($divisi_id !="") $this->hrd->where('d.divisi_id',$divisi_id);
		if($dept_id !="") $this->hrd->where('d.dept_id',$dept_id);
		if($kd_store !="") $this->hrd->where('d.kd_store',$kd_store);

		if($column == 0){
			$this->hrd->order_by('tgl_tdk_masuk', $order);
			$this->hrd->order_by('c.nip', $order);
		}
		$this->hrd->limit($length,$start);
		$query=$this->hrd->get();
		return $query->result_array();
	}

	public function getDataAbsenPDF($tanggal1,$tanggal2,$divisi_id,$dept_id,$kd_store)
	{
		$this->hrd->select('nip,nama_lengkap,b.tgl_tdk_masuk,j.nama_jabatan,e.nama_dept,f.nama_divisi,
		 	kd_store,CASE WHEN IFNULL(p.tgl_absensi,"")="" THEN "MASIH PROSES" ELSE "FIXED" END status_absen');
		$this->hrd->from('hrd_all.trn_tidak_masuk_h a');
		$this->hrd->join('hrd_all.trn_tidak_masuk_d b','a.tdk_masuk_h_id=b.tdk_masuk_h_id');
		$this->hrd->join('hrd_all.trn_absensi p','a.biodata_id=p.biodata_id AND b.tgl_tdk_masuk=p.tgl_absensi');
		$this->hrd->join('hrd_all.mst_biodata c','a.biodata_id=c.biodata_id');
		$this->hrd->join('hrd_all.biodata_pekerjaan_d d','a.biodata_id = d.biodata_id');
		$this->hrd->join('hrd_all.mst_dept e','d.dept_id = e.dept_id');
		$this->hrd->join('hrd_all.mst_divisi f','d.divisi_id = f.divisi_id');
		$this->hrd->join('hrd_all.trn_posting t','a.tdk_masuk_h_id=t.tdk_masuk_h_id');
		$this->hrd->join('hrd_all.mst_jabatan j','d.jabatan_id = j.jabatan_id');
		$this->hrd->where('b.tgl_tdk_masuk BETWEEN "'.$tanggal1.'" AND "'.$tanggal2.'"');
		// $this->hrd->where('b.tgl_tdk_masuk BETWEEN "2021-12-01" AND "2021-12-31"');
		$this->hrd->where('(b.is_batal=0 OR a.is_batal=0)');
		$this->hrd->where('(t.status_dokumen<>"R" OR IFNULL(t.status_dokumen,"")="")');
		if($divisi_id !="") $this->hrd->where('d.divisi_id',$divisi_id);
		if($dept_id !="") $this->hrd->where('d.dept_id',$dept_id);
		if($kd_store !="") $this->hrd->where('d.kd_store',$kd_store);

		$this->hrd->order_by('tgl_tdk_masuk,d.divisi_id,d.dept_id,c.nip', 'ASC');
		// $this->hrd->order_by('divisi_id', ASC);
		// $this->hrd->order_by('c.nip',ASC);
		$query=$this->hrd->get();
		// die(nl2br($this->hrd->last_query()));
		return $query->result_array();
	}

	public function getJumlahDataAbsen($tanggal1,$tanggal2,$divisi_id,$dept_id,$kd_store)
	{
		$this->hrd->select('nip,nama_lengkap,b.tgl_tdk_masuk,j.nama_jabatan,e.nama_dept,f.nama_divisi,
		 	kd_store,CASE WHEN IFNULL(p.tgl_absensi,"")="" THEN "MASIH PROSES" ELSE "FIXED" END status_absen');
		$this->hrd->from('hrd_all.trn_tidak_masuk_h a');
		$this->hrd->join('hrd_all.trn_tidak_masuk_d b','a.tdk_masuk_h_id=b.tdk_masuk_h_id');
		$this->hrd->join('hrd_all.trn_absensi p','a.biodata_id=p.biodata_id AND b.tgl_tdk_masuk=p.tgl_absensi');
		$this->hrd->join('hrd_all.mst_biodata c','a.biodata_id=c.biodata_id');
		$this->hrd->join('hrd_all.biodata_pekerjaan_d d','a.biodata_id = d.biodata_id');
		$this->hrd->join('hrd_all.mst_dept e','d.dept_id = e.dept_id');
		$this->hrd->join('hrd_all.mst_divisi f','d.divisi_id = f.divisi_id');
		$this->hrd->join('hrd_all.trn_posting t','a.tdk_masuk_h_id=t.tdk_masuk_h_id');
		$this->hrd->join('hrd_all.mst_jabatan j','d.jabatan_id = j.jabatan_id');
		$this->hrd->where('b.tgl_tdk_masuk BETWEEN "'.$tanggal1.'" AND "'.$tanggal2.'"');
		// $this->hrd->where('b.tgl_tdk_masuk BETWEEN "2021-12-01" AND "2021-12-31"');
		$this->hrd->where('(b.is_batal=0 OR a.is_batal=0)');
		$this->hrd->where('(t.status_dokumen<>"R" OR IFNULL(t.status_dokumen,"")="")');
		if($divisi_id !="") $this->hrd->where('d.divisi_id',$divisi_id);
		if($dept_id !="") $this->hrd->where('d.dept_id',$dept_id);
		if($kd_store !="") $this->hrd->where('d.kd_store',$kd_store);

		$this->hrd->order_by('tgl_tdk_masuk', 'DESC');
		$jum=$this->hrd->get();
		return $jum->num_rows();
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

	public function getDataAbensiStatus($tanggal1,$tanggal2,$divisi_id,$dept_id,$kd_store,$status_absensi,$search_no = "", $length = "", $start = "", $column = "", $order = "")
	{
		if($search_no != "") $this->hrd->like('nip',$search_no);

		$this->hrd->select('nip,nama_lengkap,nama_dept,tgl_absensi,jam_masuk,jam_keluar,ket_status_absensi, keterangan2');
		$this->hrd->from('hrd_all.trn_absensi a');
		$this->hrd->join('hrd_all.mst_biodata b','a.biodata_id=b.biodata_id');
		$this->hrd->join('hrd_all.biodata_pekerjaan_d c','a.biodata_id=c.biodata_id');
		$this->hrd->join('hrd_all.mst_dept d','c.dept_id = d.dept_id');
		$this->hrd->join('hrd_all.mst_status_absensi e','a.keterangan=e.kode_status_absensi');
		$this->hrd->where('tgl_absensi BETWEEN "'.$tanggal1.'" AND "'.$tanggal2.'"');
		if($status_absensi !="") $this->hrd->where_in('a.keterangan',$status_absensi);
		if($divisi_id !="") $this->hrd->where('c.divisi_id',$divisi_id);
		if($dept_id !="") $this->hrd->where('c.dept_id',$dept_id);
		if($kd_store !="") $this->hrd->where('kd_store',$kd_store);

		if($column == 0){
			$this->hrd->order_by('tgl_absensi', $order);
			$this->hrd->order_by('nip', $order);
		}
		$this->hrd->limit($length,$start);
		$query=$this->hrd->get();
		// die(nl2br($this->hrd->last_query()));
		return $query->result_array();
	}

	public function getJumlahDataAbsensiStatus($tanggal1,$tanggal2,$divisi_id,$dept_id,$kd_store,$status_absensi)
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
		if($dept_id !="") $this->hrd->where('c.dept_id',$dept_id);
		if($kd_store !="") $this->hrd->where('kd_store',$kd_store);

		$this->hrd->order_by('tgl_absensi', 'DESC');
		$jum=$this->hrd->get();
		return $jum->num_rows();
	}

	public function getDataAbsensiStatusPDF($tanggal1,$tanggal2,$divisi_id,$dept_id,$kd_store,$status_absensi)
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
		if($dept_id !="") $this->hrd->where('c.dept_id',$dept_id);
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


}
