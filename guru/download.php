<?php
require_once '../function/core.php';

if (empty($_SESSION['guru']['id_card'])) {
	redirect(base('guru/login'));
}

require_once '../assets/dompdf/autoload.inc.php';
use Dompdf\Dompdf;

error_reporting(0);
$id_siswa = anti_inject(@$_GET['id']);
$id_siswa = abs((int) $id_siswa);
$dom = new Dompdf();

//Getting data of Student
$sqlsis = select("*", "tbl_siswa", "id = '$id_siswa' LIMIT 1");
$exs = mysqli_fetch_object($sqlsis);

$nama = strtolower($exs->nama);
$nama = ucwords($nama);

/*======== OPEN KHUSUSON ========*/

$nama_kls = $exs->rombel;
//Selecting
$qwe = substr($nama_kls, 0,2); //Buat cek kelasnya antara kelas 10, 11, atau 12
$cekjur = substr($nama_kls, 3,2); //Buat cek jurusannya (AP, AK, MM, PM, PB, UPW)

//Numeric
$no =1;
$numb = $no;
$n = $numb;
$nomer = $n;
$numer = $n;
$number = $numer;

$date = date('Y-m-d');
$tgl = tglskrg($date);

if ($qwe == 10) {
  $wja = select("*", "tbl_mapel", "kode_mapel LIKE '%AX0%' ");
  $wjb = select("*", "tbl_mapel", "kode_mapel LIKE '%BX0%' AND kelompok = 'B' AND nama_mapel != 'Bahasa Sunda' ");

  if ($cekjur == "MM") {
    $plc = select("*", "tbl_mapel", "kode_mapel LIKE '%MMX0%' AND kelompok = 'C' ");
  } else if($cekjur == "AK") {
    $plc = select("*", "tbl_mapel", "kode_mapel LIKE '%AKX0%' AND kelompok = 'C' ");
  } else if($cekjur == "AP") {
    $plc = select("*", "tbl_mapel", "kode_mapel LIKE '%APX0%' AND kelompok = 'C' ");
  } else if($cekjur == "PM") {
    $plc = select("*", "tbl_mapel", "kode_mapel LIKE '%PMX0%' AND kelompok = 'C' ");
  } else if($cekjur == "PB") {
    $plc = select("*", "tbl_mapel", "kode_mapel LIKE '%PBX0%' AND kelompok = 'C' ");
  } else {
    $plc = select("*", "tbl_mapel", "kode_mapel LIKE '%UPX0%' AND kelompok = 'C' ");
  }

} else if($qwe == 11) {
  $wja = select("*", "tbl_mapel", "kode_mapel LIKE '%AXI0%' ");
  $wjb = select("*", "tbl_mapel", "kode_mapel LIKE '%BXI0%' AND kelompok = 'B' ");

  if ($cekjur == "MM") {
    $plc = select("*", "tbl_mapel", "kode_mapel LIKE '%MMXI0%' AND kelompok = 'C' ");
  } else if($cekjur == "AK") {
    $plc = select("*", "tbl_mapel", "kode_mapel LIKE '%AKXI0%' AND kelompok = 'C' ");
  } else if($cekjur == "AP") {
    $plc = select("*", "tbl_mapel", "kode_mapel LIKE '%APXI0%' AND kelompok = 'C' ");
  } else if($cekjur == "PM") {
    $plc = select("*", "tbl_mapel", "kode_mapel LIKE '%PMXI0%' AND kelompok = 'C' ");
  } else if($cekjur == "PB") {
    $plc = select("*", "tbl_mapel", "kode_mapel LIKE '%PBXI0%' AND kelompok = 'C' ");
  } else {
    $plc = select("*", "tbl_mapel", "kode_mapel LIKE '%UPXI0%' AND kelompok = 'C' ");
  }

} else if($qwe == 12) {
  $wja = select("*", "tbl_mapel", "kode_mapel LIKE '%AXII%' ");
  $wjb = select("*", "tbl_mapel", "kode_mapel LIKE '%BXII%' AND kelompok = 'B' ");

  if ($cekjur == "MM") {
    $plc = select("*", "tbl_mapel", "kode_mapel LIKE '%MMXII%' AND kelompok = 'C' ");
  } else if($cekjur == "AK") {
    $plc = select("*", "tbl_mapel", "kode_mapel LIKE '%AKXII%' AND kelompok = 'C' ");
  } else if($cekjur == "AP") {
    $plc = select("*", "tbl_mapel", "kode_mapel LIKE '%APXII%' AND kelompok = 'C' ");
  } else if($cekjur == "PM") {
    $plc = select("*", "tbl_mapel", "kode_mapel LIKE '%PMXII%' AND kelompok = 'C' ");
  } else if($cekjur == "PB") {
    $plc = select("*", "tbl_mapel", "kode_mapel LIKE '%PBXII%' AND kelompok = 'C' ");
  } else {
    $plc = select("*", "tbl_mapel", "kode_mapel LIKE '%UPXII%' AND kelompok = 'C' ");
  }

} else {
  echo "Error!";
}

//Semester
$semester = @$_SESSION['semester'];
if ($semester == "Ganjil") {
	$sms =  "I ($semester)";
} else {
	$sms =  "II ($semester)";
}

/*======== CLOSE KHUSUSON ========*/

/*== Bagian data rapot ==*/

//Queries for Prestasi, Ekskul, Prakerin
$sqlpres = select("*", "tbl_prestasi", "id_siswa = '$id_siswa'");
$sqlexk = select("*", "tbl_ekskul", "id_siswa = '$id_siswa'");
$sqlpkl = select("*", "tbl_prakerin", "id_siswa = '$id_siswa'");

//Checking rows
$cekpres = mysqli_num_rows($sqlpres);
$cekexk = mysqli_num_rows($sqlexk);
$cekpkl = mysqli_num_rows($sqlpkl);

$sqlabs = select("*", "absensi_siswa", "id_siswa = '$id_siswa'");
$abs = mysqli_fetch_object($sqlabs);

$sqldrp = select("*", "data_rapot", "id_siswa='$id_siswa'");
$dr = mysqli_fetch_object($sqldrp);

/*== Close data rapot ==*/

/* HITUNG JUMLAH DAN RATA-RATA */
$sqlpjum = select("SUM(p_angka) AS pjum", "tbl_rapot", "id_siswa = '$id_siswa'");
$pjum = mysqli_fetch_object($sqlpjum);

$sqlkjum = select("SUM(k_angka) AS kjum", "tbl_rapot", "id_siswa = '$id_siswa'");
$kjum = mysqli_fetch_object($sqlkjum);

$sqlavgp = select("AVG(p_angka) AS avgp", "tbl_rapot", "id_siswa = '$id_siswa'");
$avgp = mysqli_fetch_object($sqlavgp);

$sqlavgk = select("AVG(k_angka) AS avgk", "tbl_rapot", "id_siswa = '$id_siswa'");
$avgk = mysqli_fetch_object($sqlavgk);

$sqlps = select("*", "profil_sekolah", "id=1 LIMIT 1");
$ps = mysqli_fetch_object($sqlps);

//Batas script html untuk rapot
$main_content = "
<!DOCTYPE html>
<html>
  <head>
    <meta charset='utf-8'>
  </head>
<link rel='shortcut icon' href='".base('images/favicon.png')."'>
<style>
	*{
		margin: 0;
		font-family: 'Times New Roman' !important;
	}
	.ctr{
		text-align: center !important;
	}
	body{
		width: 87.5%;
		margin: 1.9cm 1.8cm !important;
	}
	table{
		width: 100% !important;
		font-family: 'Times New Roman';
		vertical-align: middle !important;
	}
	#cover{
		margin:0 auto !important;
		text-align:center;
	}
	.header{
		text-align:center;
		font-weight:bold;
		font-size:16px;
	}
	.logo_dikbud{
		width:40% !important;
		margin:0px auto !important;
		margin-top:70px;
		margin-bottom:50px;
		text-align:center;
	}
	img{
		width:50% !important;
	}
	.kotak{
		width:30%;
		margin:0 auto;
		margin-top:5px;
		border:1px solid #000;
		padding:5px;
	}
	.dikbud{
		margin-top:50px;
		text-align:center;
		font-weight:bold;
		font-size:17px;
		margin-bottom:20px;
	}
	#detail_sekolah{
		padding:0px 30px;
	}
	.data-sekolah{
		margin-top:60px;
		width:100%;
		margin-bottom:160px;
	}
</style>
<body style='font-family:Times;vertical-align: middle;'>
	<div id='cover'>
		<div class='header'>
			RAPOR SISWA
			<br>
			SEKOLAH MENENGAH KEJURUAN
			<br>
			(SMK)
		</div>
		<div class='logo_dikbud'>
			<img src='../images/logo_dikbud.png' alt=''>
		</div>
		<div class='nama_siswa'>
			<b>Nama Siswa : </b>
			<div class='kotak'>
				$exs->nama
			</div>
			<br>
			<b>NISN : </b>
			<div class='kotak'>
				$exs->nisn
			</div>
		</div>
		<div class='dikbud'>
			KEMENTRIAN PENDIDIKAN DAN KEBUDAYAAN
			<br>
			REPUBLIK INDONESIA
		</div>
	</div>
	<br>
	<div id='detail_sekolah'>
		<div class='header'>
			RAPOR SISWA
			<br>
			SEKOLAH MENENGAH KEJURUAN
			<br>
			(SMK)
		</div>
		<table class='data-sekolah' border='0px' cellpadding='5'>
			<tr>
				<td>Nama Sekolah</td>
				<td>:</td>
				<td>  $ps->nama_sekolah </td>
			</tr>
			<tr>
				<td>NPSN</td>
				<td>:</td>
				<td>  $ps->npsn </td>
			</tr>
			<tr>
				<td>NIS/NSS/NDS</td>
				<td>:</td>
				<td>  $ps->nis </td>
			</tr>
			<tr>
				<td>Alamat</td>
				<td>:</td>
				<td>  $ps->alamat </td>
			</tr>
			<tr>
				<td>Kelurahan</td>
				<td>:</td>
				<td>  $ps->kelurahan </td>
			</tr>
			<tr>
				<td>Kecamatan</td>
				<td>:</td>
				<td>  $ps->kecamatan </td>
			</tr>
			<tr>
				<td>Kota/Kabupaten</td>
				<td>:</td>
				<td>  $ps->kota_kab </td>
			</tr>
			<tr>
				<td>Provinsi</td>
				<td>:</td>
				<td>  $ps->provinsi </td>
			</tr>
			<tr>
				<td>Website</td>
				<td>:</td>
				<td>  <a href='$ps->website'>$ps->website</a> </td>
			</tr>
			<tr>
				<td>E-mail</td>
				<td>:</td>
				<td>  $ps->email </td>
			</tr>
		</table>
	</div>
	<br>
	<br>
	<div id='identitas' style='padding-top:20px;'>
		<table border='0' cellspacing='0'  style='font-size:13.5px !important;'>
			<tr>
				<td colspan='2'>Nama Sekolah</td>
				<td colspan='4'>: SMK Negeri 1 Kedawung</td>
				<td colspan='2'>Kelas</td>
				<td>: $exs->rombel </td>
			</tr>
			<tr>
				<td colspan='2'>Alamat Sekolah</td>
				<td colspan='4'>: Jl. Tuparev No.12 Cirebon</td>
				<td colspan='2'>Semester</td>
				<td>: $sms </td>
			</tr>
			<tr>
				<td colspan='2'>Nama Peserta Didik</td>
				<td colspan='4'>: $nama </td>
				<td colspan='2'>Tahun Pelajaran</td>
				<td>: &nbsp;". @$_SESSION['thn_ajaran'] ."</td>
			</tr>
			<tr>
				<td colspan='2'>Nomor Induk/NISN</td>
				<td colspan='4'>: 141510043</td>
				<td colspan='2'>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		</table>
	</div>
	<br>
	<table cellspacing='0' >
		<tr>
			<td colspan='9' style='font-size: 14.5px;font-weight: bold;'>
				CAPAIAN HASIL BELAJAR
			</td>
		</tr>
		<tr>
			<td colspan='9' style='font-size: 14px !important !important;font-weight: bold;'>
				A. Sikap
			</td>
		</tr>
	</table>
	<table border='1'  cellspacing='0'>
		<tr>
			<td colspan='9' style='border-bottom: 0px !important;'>
				Deskripsi :
			</td>
		</tr>
		<tr>
			<td colspan='9' style='font-size:13px;height:50px;border-top:0px !important;vertical-align:middle;'>
				$dr->deskripsi_sikap
			</td>
		</tr>
	</table>
	<br>
	<table cellspacing='0' >
		<tr>
			<td colspan='9' style='font-size: 14px !important;font-weight: bold;'>
				B. Pengetahuan &amp; Keterampilan
			</td>
		</tr>
	</table>
	<table border='1' cellspacing='0'  style='font-family: Times;font-size: 12.5px;'>
		<tbody>
			<tr>
				<th colspan='2' rowspan='2'>MATA PELAJARAN</th>
				<th rowspan='2' style='width: 40px !important'>KKM</th>
				<th colspan='3'>Pengetahuan</th>
				<th colspan='3'>Keterampilan</th>
			</tr>
			<tr>
				<th width='40px'>Angka</th>
				<th width='40px'>Pred</th>
				<th style='min-width: 150px;'>Deskripsi</th>
				<th width='40px'>Angka</th>
				<th width='40px'>Pred</th>
				<th style='min-width: 150px;'>Deskripsi</th>
			</tr>
			<tr>
				<th colspan='9' style='text-align: left;background: #ccc;'>
					Kelompok A
				</th>
			</tr>";
			//Start looping study type A
			while ($a = mysqli_fetch_object($wja)) :
				$sqlkkma = select("*", "tbl_kkm", "kode_mapel = '$a->kode_mapel'");
				$kkma = mysqli_fetch_object($sqlkkma);

				$sqlrap = select("*", "tbl_rapot", "id_siswa = '$id_siswa' AND id_mapel = '$a->id' LIMIT 1");
				$rap = mysqli_fetch_object($sqlrap);

				//For knowledge description
				$sqldesp = select("*", "tbl_deskripsi_pth", "kode_mapel = '$a->kode_mapel' AND predikat = '$rap->p_predikat' AND semester = '$semester' ");
				$desp = mysqli_fetch_object($sqldesp);

				//For skill description
				$sqldesk = select("*", "tbl_deskripsi_ktr", "kode_mapel = '$a->kode_mapel' AND predikat = '$rap->p_predikat' AND semester = '$semester' ");
				$desk = mysqli_fetch_object($sqldesk);
$main_content .= "<tr>
				<td style='text-align: center;vertical-align: middle;width:25px !important;'>".$no++."</td>
				<td> $a->nama_mapel </td>
				<td style='text-align: center;width: 40px !important'> $kkma->kkm </td>
				<td style='text-align: center;'> $rap->p_angka </td>
				<td style='text-align: center;'> $rap->p_predikat </td>
				<td style='font-size: 12px !important;'>
					$desp->deskripsi
				</td>
				<td style='text-align: center;'> $rap->k_angka </td>
				<td style='text-align: center;'> $rap->k_predikat </td>
				<td style='font-size: 12px !important;'>
					$desk->deskripsi
				</td>
			</tr>";
			endwhile;
$main_content .="<tr>
				<td colspan='9' style='text-align: left;background: #ccc;font-weight: bold;'>
					Kelompok B
				</td>
			</tr>";
				while ($b = mysqli_fetch_object($wjb)) :
					$sqlkkmb = select("*", "tbl_kkm", "kode_mapel = '$b->kode_mapel'");
					$kkmb = mysqli_fetch_object($sqlkkmb);

					$sqlrapb = select("*", "tbl_rapot", "id_siswa = '$id_siswa' AND id_mapel = '$b->id' LIMIT 1");
					$rapb = mysqli_fetch_object($sqlrapb);

					//For knowledge description
					$sqldespb = select("*", "tbl_deskripsi_pth", "kode_mapel = '$b->kode_mapel' AND predikat = '$rapb->p_predikat' AND semester = '$semester'");
					$despb = mysqli_fetch_object($sqldespb);

					//For skill description
					$sqldeskb = select("*", "tbl_deskripsi_ktr", "kode_mapel = '$b->kode_mapel' AND predikat = '$rapb->p_predikat' AND semester = '$semester'");
					$deskb = mysqli_fetch_object($sqldeskb);
$main_content .= "<tr>
				<td style='text-align: center;vertical-align: middle;width:25px !important;'>".$numb++."</td>
				<td> $b->nama_mapel </td>
				<td style='text-align: center;width: 40px !important'> $kkmb->kkm </td>
				<td style='text-align: center;'> $rapb->p_angka </td>
				<td style='text-align: center;'> $rapb->p_predikat </td>
				<td style='font-size: 12px !important;'>
					$despb->deskripsi
				</td>
				<td style='text-align: center;'> $rapb->k_angka </td>
				<td style='text-align: center;'> $rapb->k_predikat </td>
				<td style='font-size: 12px !important;'>
					$deskb->deskripsi
				</td>
			</tr>";
			endwhile;
$main_content .= "<tr>
				<td colspan='9' style='text-align: left;background: #ccc;font-weight: bold;'>
					Kelompok C
				</td>
			</tr>";
				while ($c = mysqli_fetch_object($plc)) :
					$sqlkkmc = select("*", "tbl_kkm", "kode_mapel = '$c->kode_mapel'");
					$kkmc = mysqli_fetch_object($sqlkkmc);

					$sqlrapc = select("*", "tbl_rapot", "id_siswa = '$id_siswa' AND id_mapel = '$c->id' LIMIT 1");
					$rapc = mysqli_fetch_object($sqlrapc);

					//For knowledge description
					$sqldespc = select("*", "tbl_deskripsi_pth", "kode_mapel = '$c->kode_mapel' AND predikat = '$rapc->p_predikat' AND semester = '$semester' ");
					$despc = mysqli_fetch_object($sqldespc);

					//For skill description
					$sqldeskc = select("*", "tbl_deskripsi_ktr", "kode_mapel = '$c->kode_mapel' AND predikat = '$rapc->p_predikat' AND semester = '$semester'");
					$deskc = mysqli_fetch_object($sqldeskc);
$main_content .= "<tr>
				<td style='text-align: center;vertical-align: middle;width:25px !important;'>".$n++."</td>
				<td> $c->nama_mapel </td>
				<td style='text-align: center;width: 40px !important'> $kkmc->kkm </td>
				<td style='text-align: center;'> $rapc->p_angka </td>
				<td style='text-align: center;'> $rapc->p_predikat </td>
				<td style='font-size: 12px !important;'>
					$despc->deskripsi
				</td>
				<td style='text-align: center;'> $rapc->k_angka </td>
				<td style='text-align: center;'> $rapc->k_predikat </td>
				<td style='font-size: 12px !important;'>
					$deskc->deskripsi
				</td>
			</tr>";
			endwhile;
$main_content .="
			<tr>
				<td colspan='2' style='font-weight:bold;text-align:center;'>Jumlah Nilai</td>
				<td></td>
				<td style='font-weight:bold;text-align:center;'> $pjum->pjum </td>
				<td></td>
				<td></td>
				<td style='font-weight:bold;text-align:center;'> $kjum->kjum </td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td colspan='2' style='font-weight:bold;text-align:center;'>Rata-Rata</td>
				<td></td>
				<td style='font-weight:bold;text-align:center;'>".number_format($avgp->avgp)."</td>
				<td></td>
				<td></td>
				<td style='font-weight:bold;text-align:center;'>".number_format($avgk->avgk)."</td>
				<td></td>
				<td></td>
			</tr>
		</tbody>
	</table>
	<br>
	<table cellspacing='0' >
		<tr>
			<td colspan='9' style='font-size: 14px !important;font-weight: bold;'>
				C. Praktik Kerja Lapangan
			</td>
		</tr>
	</table>
	<table border='1'  cellspacing='0'>
		<thead>
			<tr style='background: #ccc !important;font-size: 13px !important;'>
				<th width='25'>No</th>
				<th style='width: 300px !important;'>Mitra DU/DI</th>
				<th width='150px'>Lamanya (Bulan)</th>
				<th class'ctr'>Alamat</th>
				<th class'ctr' width='120px'>Predikat</th>
				<th class'ctr'>Bidang Kerja</th>
			</tr>
		</thead>
		<tbody style='font-size:13px;text-align:center;'>";
		if ($cekpkl > 0) {
			while ($pkl = mysqli_fetch_object($sqlpkl)) :
$main_content .= "
				<tr style='font-size:13px;'>
					<td class='ctr'>".$nomer++."</td>
					<td class='ctr'> $pkl->mitra </td>
					<td class='ctr'> $pkl->lama </td>
					<td class='ctr'> $pkl->alamat </td>
					<td class='ctr'> $pkl->predikat </td>
					<td class='ctr'> $pkl->bid_kerja </td>
				</tr>
				";
			endwhile;
			if ($cekpkl == 1) {
$main_content .= "
				<tr>
					<td class'ctr'>2</td>
					<td class'ctr'></td>
					<td class'ctr'></td>
					<td class'ctr'></td>
					<td class'ctr'></td>
					<td class'ctr'></td>
				</tr>
				<tr>
					<td class'ctr'>3</td>
					<td class'ctr'></td>
					<td class'ctr'></td>
					<td class'ctr'></td>
					<td class'ctr'></td>
					<td class'ctr'></td>
				</tr>
				";
			} elseif($cekpkl == 2) {
$main_content .= "
				<tr>
					<td class'ctr'>3</td>
					<td class'ctr'></td>
					<td class'ctr'></td>
					<td class'ctr'></td>
					<td class'ctr'></td>
					<td class'ctr'></td>
				</tr>
				";
			}
		} else {
			for ($i=1; $i <= 3; $i++) :
$main_content .= "<tr style='font-size: 14px !important;'>
					<td style='text-align: center;vertical-align: middle;'>".$i."</td>
					<td></td>
					<td></td>
					<td colspan='3'></td>
					<td></td>
					<td colspan='3'></td>
				</tr>";
			endfor;
		}
$main_content .="</tbody>
	</table>
	<br>
	<table cellspacing='0' >
		<tr>
			<td colspan='9' style='font-size: 13px !important;font-weight: bold;'>
				D. Ekstrakurikuler
			</td>
		</tr>
	</table>
	<table border='1' cellspacing='0' >
		<thead>
			<tr style='background: #ccc;font-size: 13px !important;'>
				<th width='30px' style='text-align: center;'>No.</th>
				<th width='300px'>Kegiatan Ekstrakurikuler</th>
				<th width='150px'>Nilai</th>
				<th>Deskripsi</th>
			</tr>
		</thead>
		<tbody>";
		if ($cekexk > 0) {
			while ($xk = mysqli_fetch_object($sqlexk)) :
$main_content .= "
			<tr style='font-size:13px;'>
				<td style='text-align:center;'>".$numer++."</td>
				<td> $xk->keg_ekskul </td>
				<td style='text-align:center;'> $xk->nilai </td>
				<td class'ctr'> $xk->deskripsi </td>
			</tr>";
			endwhile;
			if ($cekexk == 1) {
$main_content .= "
			<tr>
				<td class'ctr'>2</td>
				<td class'ctr'></td>
				<td class'ctr'></td>
				<td class'ctr'></td>
			</tr>
			<tr>
				<td class'ctr'>3</td>
				<td class'ctr'></td>
				<td class'ctr'></td>
				<td class'ctr'></td>
			</tr>";
			} elseif ($cekexk == 2) {
$main_content .= "
			<tr>
				<td class'ctr'>3</td>
				<td class'ctr'></td>
				<td class'ctr'></td>
				<td class'ctr'></td>
			</tr>";
			}
		} else {
			for ($i=2; $i <= 3; $i++) :
$main_content .= "
			<tr style='font-size: 14px !important;'>
				<td style='text-align: center;vertical-align: middle;'> $i </td>
				<td> </td>
				<td> </td>
				<td colspan='7'></td>
			</tr>";
			endfor;
		}
$main_content .=			
		"</tbody>
	</table>
	<br>
	<table cellspacing='0' >
		<tr>
			<td colspan='9' style='font-size: 14px !important;font-weight: bold;'>
				E. Prestasi
			</td>
		</tr>
	</table>
	<table border='1' cellspacing='0' >
		<thead>
			<tr style='background: #ccc;font-size: 14px !important;'>
				<th width='30px' style='text-align: center;'>No.</th>
				<th width='300px'>Jenis Prestasi</th>
				<th>Tingkat</th>
				<th>Bidang Lomba</th>
			</tr>
		</thead>
		<tbody style='font-size:13px;'>";
		if ($cekpres > 0) {
			while ($prs = mysqli_fetch_object($sqlpres)) :
$main_content .= "
			<tr>
				<td width='30px' style='text-align:center;'>".$number++."</td>
				<td> $prs->jenis_prestasi </td>
				<td style='text-align:center;'> $prs->tingkat </td>
				<td style='text-align:center;'> $prs->bid_lomba </td>
			</tr>";
			endwhile;
			if ($cekpres == 1) {
$main_content .= "
			<tr style='text-align:center;'>
				<td>2</td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr  style='text-align:center;'>
				<td>3</td>
				<td></td>
				<td></td>
				<td></td>
			</tr>";
			} elseif ($cekpres == 2) {
$main_content .= "
			<tr  style='text-align:center;'>
				<td>3</td>
				<td></td>
				<td></td>
				<td></td>
			</tr>";
			}
		} else {
			for ($i=1; $i <= 3; $i++) :
$main_content .= "
			<tr style='font-size: 14px !important;'>
				<td style='text-align: center;vertical-align: middle;'> $i </td>
				<td> </td>
				<td> </td>
				<td colspan='7'></td>
			</tr>";
			endfor;
	}
$main_content .=
		"</tbody>
	</table>
	<br>
	<table cellspacing='0' >
		<tr>
			<td colspan='9' style='font-size: 14px !important;font-weight: bold;'>
				F. Ketidakhadiran
			</td>
		</tr>
	</table>
	<table border='1'  cellspacing='0' style='width: 330px !important;font-size:13px;text-align:center;'>
		<tr>
			<td colspan='4'>Ketidakhadiran</td>
		</tr>
		<tr>
			<td colspan='2'>Sakit</td>
			<td> $abs->sakit </td>
			<td> hari</td>
		</tr>
		<tr>
			<td colspan='2'>Izin</td>
			<td> $abs->izin </td>
			<td>hari</td>
		</tr>
		<tr>
			<td colspan='2'>Tanpa Keterangan</td>
			<td> $asb->tnp_ket </td>
			<td>hari</td>
		</tr>
	</table>
	<br>
	<table cellspacing='0' >
		<tr>
			<td colspan='9' style='font-size: 14px !important;font-weight: bold;'>
				G. Catatan Wali Kelas
			</td>
		</tr>
	</table>
	<table border='1'  cellspacing='0'>
		<tr>
			<td colspan='9' style='height:50px;text-align:center;vertical-align:middle;font-weight:bold;'>
				<i>$dr->catatan</i>
			</td>
		</tr>
	</table>
	<br>
	<table cellspacing='0' >
		<tr>
			<td colspan='9' style='font-size: 14px !important;font-weight: bold;'>
				H. Tanggapan Orang Tua/Wali
			</td>
		</tr>
	</table>
	<table border='1'  cellspacing='0'>
		<tr>
			<td colspan='9' style='border-bottom: 0px !important;height: 40px !important;'>
				&nbsp;
			</td>
		</tr>
		<tr>
			<td colspan='9' style='border-top: 0px !important;'>
				&nbsp;
			</td>
		</tr>
	</table>
	<br>
	<table  cellspacing='0' style='font-size: 15px;font-family:Times;'>
		<tr>
			<td>&nbsp;</td>
			<td style='text-align: center;'>Mengetahui,</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan='2' style='text-align: center;'>Cirebon, $tgl</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td style='text-align: center;'>Orang Tua/Wali,</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan='2' style='text-align: center;'>Wali Kelas,</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan='2' style='text-align: center;'>Mengetahui,</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan='2' style='text-align: center;'>Kepala Sekolah,</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td style='text-align: center;'>(..........................)</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan='2' style='text-align: center;'><u><b>".@$_SESSION['guru']['nama']."</b></u></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan='2' style='text-align: center;'>NIP :</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan='2' style='text-align: center;'><u><b>H. FUAD, S.PD.,M.PD</b></u></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan='2' style='text-align: center;'>NIP : 19640705 198902 1 003</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</table>
</body>
";

//Batas
$dom->loadHtml($main_content);

$dom->setPaper('A4', 'landscape');
$dom->render();
$dom->stream($nama."-".$exs->rombel, array('Attachment'=>0));
?>