<?php
require_once '../function/core.php';
if (empty($_SESSION['guru']['nama']) || empty($_SESSION['guru']['id_card'])) {
	redirect(base('guru/login'));
}

$nmgr = @$_SESSION['guru']['nama'];
$sqlcekwali = select("*", "tbl_kelas", "wali_kelas = '$nmgr'");
$wali = mysqli_fetch_object($sqlcekwali);
$nmkls = $wali->nama_kelas;
$sqlsiswa = select("*", "tbl_siswa", "rombel = '$nmkls'");

$kls_rmw = substr($nmkls, 0,2);
$jur = substr($nmkls, 3,2);
$pkt = substr($nmkls, -1,1);

if ($kls_rmw == 12) {
	$kls = "XII";
} elseif ($kls_rmw == 11) {
	$kls = "XI";
} else {
	$kls = "X";
}

if ($jur == "AK") {
	$kelas = $kls." Akuntansi ".$pkt;
} elseif ($jur == "AP") {
	$kelas = $kls." Administrasi Perkantoran ".$pkt;
} elseif ($jur == "MM") {
	$kelas = $kls." Multimedia ".$pkt;
} elseif ($jur == "PM") {
	$kelas = $kls." Pemasaran ".$pkt;
} elseif ($jur == "PB") {
	$kelas = $kls." Perbankan ".$pkt;
} elseif ($jur == "UP") {
	$kelas = $kls." Usaha Perjalanan Wisata";
}

$thn_ajaran = @$_SESSION['thn_ajaran'];
$no = 1;

$total_siswa = mysqli_num_rows($sqlsiswa);

$masterObj = new PHPExcel();
$imageHanlder = new PHPExcel_Worksheet_Drawing();

$activeSheet = $masterObj->getActiveSheet();
$imageHanlder->setWorksheet($activeSheet);

$imageFile = "../images/header.png";

$imageHanlder->setPath($imageFile);
$imageHanlder->setHeight(150);
$imageHanlder->setCoordinates('A1');

//Formatting
$activeSheet->mergeCells('A9:J9');
$activeSheet->mergeCells('A10:J10');
$activeSheet->getColumnDimension('A')->setWidth(4.3);
$activeSheet->getColumnDimension('B')->setAutoSize(true);
//$activeSheet->getColumnDimension('C')->setAutoSize(true);
$activeSheet->getColumnDimension('C')->setWidth(28);
$activeSheet->getColumnDimension('D')->setWidth(5);
$activeSheet->getColumnDimension('J')->setWidth(16.5);
//$activeSheet->getColumnDimension('J')->setAutoSize(true);

//Font
$masterObj->getDefaultStyle()->getFont()->setName('Times');
//Font-size
//$masterObj->getDefaultStyle()->getFont()->setSize('Times');

//Alignment
$centerAlign = array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
	);

$activeSheet->getStyle('A9')->getAlignment()->applyFromArray($centerAlign);
$activeSheet->getStyle('A10')->getAlignment()->applyFromArray($centerAlign);
$activeSheet->getStyle('A9:J9')->getFont()->setBold(true);
$activeSheet->getStyle('A10:J10')->getFont()->setBold(true);
$activeSheet->getStyle('J15')->getFont()->setBold(true);
//Starting to give a text to column
$activeSheet->setCellValue('A9', "DAFTAR NILAI");
$activeSheet->setCellValue('A10', "TAHUN PELAJARAN ". $thn_ajaran);

$activeSheet->setCellValue('C11', "MATA PELAJARAN ");
$activeSheet->setCellValue('D11', ": ");
$activeSheet->setCellValue('C12', "KELAS ");
$activeSheet->setCellValue('D12', ": ".$kelas);
$activeSheet->setCellValue('C13', "SEMESTER ");
$activeSheet->setCellValue('D13', ": ");
$activeSheet->setCellValue('C14', "WALI KELAS ");
$activeSheet->setCellValue('D14', ": ".$nmgr);

//Merge Cells
$activeSheet->mergeCells('A15:A17');
$activeSheet->mergeCells('B15:B17');
$activeSheet->mergeCells('C15:C17');
$activeSheet->mergeCells('D15:D17');
$activeSheet->mergeCells('E15:I15');
$activeSheet->mergeCells('E16:F16');
$activeSheet->mergeCells('G16:H16');
$activeSheet->mergeCells('I16:I17');
$activeSheet->mergeCells('J15:j17');

//Alignment
$activeSheet->getStyle('A15')->getAlignment()->applyFromArray($centerAlign);
$activeSheet->getStyle('B15')->getAlignment()->applyFromArray($centerAlign);
$activeSheet->getStyle('C15')->getAlignment()->applyFromArray($centerAlign);
$activeSheet->getStyle('D15')->getAlignment()->applyFromArray($centerAlign);
$activeSheet->getStyle('E15')->getAlignment()->applyFromArray($centerAlign);
$activeSheet->getStyle('E16')->getAlignment()->applyFromArray($centerAlign);
$activeSheet->getStyle('G16')->getAlignment()->applyFromArray($centerAlign);
$activeSheet->getStyle('E17')->getAlignment()->applyFromArray($centerAlign);
$activeSheet->getStyle('F17')->getAlignment()->applyFromArray($centerAlign);
$activeSheet->getStyle('G17')->getAlignment()->applyFromArray($centerAlign);
$activeSheet->getStyle('H17')->getAlignment()->applyFromArray($centerAlign);
$activeSheet->getStyle('I16')->getAlignment()->applyFromArray($centerAlign);
$activeSheet->getStyle('J15')->getAlignment()->applyFromArray($centerAlign);

//Bold
$activeSheet->getStyle('A15:H17')->getFont()->setBold(true);
$activeSheet->getStyle('I16')->getFont()->setBold(true);

$arrayStyle = array(
		'borders' => array(
			'outline' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN,
				'color' => array('rgb'=>'000000')
			),
			'top' =>  array(
				'style' => PHPExcel_Style_Border::BORDER_THIN,
				'color' => array('rgb'=>'000000')
			),
			'bottom' =>  array(
				'style' => PHPExcel_Style_Border::BORDER_THIN,
				'color' => array('rgb'=>'000000')
			),
			'left' =>  array(
				'style' => PHPExcel_Style_Border::BORDER_THIN,
				'color' => array('rgb'=>'000000')
			),
			'right' =>  array(
				'style' => PHPExcel_Style_Border::BORDER_THIN,
				'color' => array('rgb'=>'000000')
			),
			'vertical' =>  array(
				'style' => PHPExcel_Style_Border::BORDER_THIN,
				'color' => array('rgb'=>'000000')
			),
			'horizontal' =>  array(
				'style' => PHPExcel_Style_Border::BORDER_THIN,
				'color' => array('rgb'=>'000000')
			),
			'allborders' =>  array(
				'style' => PHPExcel_Style_Border::BORDER_THIN,
				'color' => array('rgb'=>'000000')
			),
		)
	);

$activeSheet->setCellValue('A15', "No. ");
$activeSheet->setCellValue('B15', "NIS ");
$activeSheet->setCellValue('C15', "NAMA ");
$activeSheet->setCellValue('D15', "L/P ");
$activeSheet->setCellValue('E15', "NILAI ");
$activeSheet->setCellValue('E16', "Pengetahuan ");
$activeSheet->setCellValue('G16', "Keterampilan ");
$activeSheet->setCellValue('I16', "Sikap ");
$activeSheet->setCellValue('J15', "KETERANGAN");
$activeSheet->setCellValue('E17', "Nilai ");
$activeSheet->setCellValue('F17', "Predikat ");
$activeSheet->setCellValue('G17', "Nilai ");
$activeSheet->setCellValue('H17', "Predikat ");
$activeSheet->getStyle('A15:J17')->applyFromArray($arrayStyle);
$activeSheet->getStyle('A16:I16')->applyFromArray($arrayStyle);
$activeSheet->getStyle('A17:I17')->applyFromArray($arrayStyle);

$total = 18+$total_siswa-1;

/*== Start Looping Data ==*/
for ($i=18; $i <= $total; $i++) { 
	$st= mysqli_fetch_object($sqlsiswa);
	$activeSheet->setCellValue('A'.$i, $no++);
	$activeSheet->setCellValue('B'.$i, $st->nis);
	$activeSheet->setCellValue('C'.$i, $st->nama);
	$activeSheet->setCellValue('D'.$i, $st->jk);
	$activeSheet->getStyle('A'.$i.':J'.$i)->applyFromArray($arrayStyle);
	$activeSheet->getStyle('A'.$i)->getAlignment()->applyFromArray($centerAlign);
	$activeSheet->getStyle('B'.$i)->getAlignment()->applyFromArray($centerAlign);
	$activeSheet->getStyle('D'.$i)->getAlignment()->applyFromArray($centerAlign);
}

$known = $total+2;
$headmaster = $total+3;
$namehead = $total+6;
$nip = $total+7;

$activeSheet->mergeCells('B'.$headmaster.':C'.$headmaster);
$activeSheet->mergeCells('B'.$namehead.':C'.$namehead);
$activeSheet->mergeCells('B'.$nip.':C'.$nip);

$activeSheet->mergeCells('I'.$known.':J'.$known);
$activeSheet->mergeCells('I'.$namehead.':J'.$namehead);
$activeSheet->mergeCells('I'.$nip.':J'.$nip);


$activeSheet->setCellValue('B'.$known, "Mengetahui,");
$activeSheet->setCellValue('B'.$headmaster, "Kepala Sekolah");
$activeSheet->setCellValue('B'.$namehead, "H. Fuad, S.Pd., M.Pd");
$activeSheet->getStyle('B'.$namehead)->getFont()->setBold(true);
$activeSheet->getStyle('B'.$namehead)->getFont()->setUnderline(true);
$activeSheet->setCellValue('B'.$nip, "NIP : 19640705 198902 1 003");

$activeSheet->setCellValue('I'.$known, "Kedawung, ");
$activeSheet->setCellValue('I'.$namehead, "                                          ");
$activeSheet->getStyle('I'.$namehead)->getFont()->setUnderline(true);
$activeSheet->setCellValue('I'.$nip, "NIP : ");

$activeSheet->getPageSetup()->setFitToWidth(1);
$activeSheet->getPageSetup()->setFitToHeight(1);

/*== End Looping Data ==*/
//Execute to export
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment;filename=Data Siswa ".$nmkls.".xlsx");
header("Cache-Control: max-age=0");

$objWriter = PHPExcel_IOFactory::createWriter($masterObj, 'Excel2007');
$objWriter->save('php://output');

?>