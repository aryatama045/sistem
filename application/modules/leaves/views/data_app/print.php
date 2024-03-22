
<?php
 ini_set("session.auto_start", 0);
 ini_set('memory_limit', '2048M');
// use Fpdf\Fpdf;

class PDF extends Pdf_javascript
{
  function setData($data){
    $this->data     = $data;
    $this->header   = $this->data['header'];
    $this->detail   = $this->data['detail'];
  }

	function Header(){
    // die(json_encode($this->data));
    $this->Ln(1);
    $this->setFont('Arial','B',10);
    $this->cell(100,1,'PT. Optik Tunggal Sempurna',0,0,'L');
    $this->setFont('Arial','B',16);
    $this->Ln(4);
    $this->setFont('Arial','',8);
    $this->cell(0,2,'Jl. Pintu Air Raya No. 36 KL',0,0,'L');
    $this->Ln(4);
    $this->cell(0,2,'Jakarta Pusat 10710',0,0,'L');
    $this->Ln(4);
    $this->Line(11,$this->GetY(),269.4,$this->GetY());
    $this->Ln(0.8);
    $this->Line(11,$this->GetY(),269.4,$this->GetY());
    $this->setFont('Arial','BU',12);
    $this->cell(0,10,'REPORT CUTI',0,0,'C');
    $this->Ln(14);
    $this->setFont('Arial','',8);
    // $this->cell(20,1,'PERIODE',0,0,'L');
    // $this->cell(2,1,': '.date('d M Y', strtotime($this->header['tanggal1'])).' S/D '.date('d M Y', strtotime($this->header['tanggal2'])),0,0,'L');
    // $this->cell(187,1,': '.$this->header['divisi'],0,0,'L');
    // $this->cell(122,1,'Dicetak Oleh',0,0,'L');
    // $this->cell(2,1,': '.$this->header['oleh'],0,0,'L');
    $this->Ln(1);
    $this->cell(20,1,'PERIODE',0,0,'L');
    $this->cell(2,1,': '.date('d M Y', strtotime($this->header['tanggal1'])).' S/D '.date('d M Y', strtotime($this->header['tanggal2'])),0,0,'L');

    $this->cell(185,1,'',0,0,'L');
    $this->cell(22,1,'Tgl. Print',0,0,'L');
    $this->cell(20,1,': '.date('d M Y H:i:s'),0,0,'L');
    // $this->Ln(0.1);
    $this->Ln(4);
    $this->cell(207,1,'',0,0,'L');
    $this->cell(22,1,'Halaman',0,0,'L');
    $this->cell(2,1,': '.$this->PageNo(),0,0,'L');
    $this->HeaderList();
  }

  function HeaderList(){
    $this->Ln(4);
    $this->Line(11,$this->GetY(),269.4,$this->GetY());
    $this->Ln(2);
    $this->setFont('Arial','B',7);
    $this->cell(212,1,'',0,0,'R');
    // $this->cell(24,1,'BATAL',0,0,'C');
    $this->Ln(2);
    // $this->Line(224,$this->GetY(),246,$this->GetY());
    $this->cell(20,1,'NIP.',0,0,'L');
    $this->cell(55,1,'NAMA LENGKAP',0,0,'L');
    $this->cell(35,1,'TGL. TIDAK MASUK',0,0,'L');
    $this->cell(35,1,'JABATAN',0,0,'L');
    $this->cell(50,1,'DEPARTEMENT',0,0,'L');
    $this->cell(30,1,'DIVISI',0,0,'L');
    $this->cell(16,1,'STORE',0,0,'L');
    $this->cell(20,1,'STATUS',0,0,'L');
    $this->Ln(2);
    $this->Ln(3);
    $this->Line(11,$this->GetY(),269.4,$this->GetY());
    $this->Ln(4);
  }

  function Data(){
    foreach ($this->detail as $key => $value) {
      if($this->GetY() > 204.80125){
          $this->AddPage();
      }
      $this->setFont('Arial','',7);
      $this->cell(20,1,$value['nip'],0,0,'L');
      $this->cell(60,1,$value['nama_lengkap'],0,0,'L');
      $this->cell(25,1,$value['tgl_tdk_masuk'],0,0,'L');
      $this->cell(30,1,$value['nama_jabatan'],0,0,'L');
      $this->cell(50,1,$value['nama_dept'],0,0,'L');
      $this->cell(40,1,$value['nama_divisi'],0,0,'L');
      $this->cell(16,1,$value['kd_store'],0,0,'L');
      $this->cell(20,1,$value['status_absen'],0,0,'L');
      $this->Ln(4);
    }
    $this->setFont('Arial','B',7);
    $this->Line(11,$this->GetY(),269.4,$this->GetY());
    $this->Ln(4);
    // $this->Line(11,$this->GetY(),269.4,$this->GetY());
  }

  function AutoPrint($printer='')
  {
    // Open the print dialog
    if($printer)
    {
      $printer = str_replace('\\', '\\\\', $printer);
      $script = "var pp = getPrintParams();";
      $script .= "pp.interactive = pp.constants.interactionLevel.full;";
      $script .= "pp.printerName = '$printer'";
      $script .= "print(pp);";
    }
    else
      $script = 'print(true);';
    $this->IncludeJS($script);
  }

}
$pdf = new PDF ('L','mm','Letter');
$pdf->SetTitle('Report Cuti',true);

$pdf->SetAutoPageBreak(true);
// die(json_encode($data));
$pdf->setData($data);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Data();

$pdf->AutoPrint(true);
$pdf->Output();

?>
