<?php
require_once '../function/core.php';
error_reporting(0);
$id_siswa = anti_inject($_GET['id']);

$sqlsis = select("*", "tbl_siswa", "id = '$id_siswa' LIMIT 1");
$exs = mysqli_fetch_object($sqlsis);

$nama = strtolower($exs->nama);
$nama = ucwords($nama);

$nama_kls = $exs->rombel;
//Selecting
$qwe = substr($nama_kls, 0,2); //Buat cek kelasnya antara kelas 10, 11, atau 12
$cekjur = substr($nama_kls, 3,2); //Buat cek jurusannya (AP, AK, MM, PM, PB, UPW)

$no =1;
$numb = $no;
$n = $numb;

if ($qwe == 10) {
  $wja = select("*", "tbl_mapel", "kode_mapel LIKE '%AX0%' ");
  $wjb = select("*", "tbl_mapel", "kode_mapel LIKE '%BX0%' AND kelompok = 'B' ");

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


?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Rapot Kurikulum 2013</title>
</head>
<style>
	*{
		margin: 0;
		font-family: "Times New Roman" !important;
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
		font-family: "Times New Roman";
		vertical-align: middle !important;
	}
</style>
<body style="font-family:Times;vertical-align: middle;">
	<div id="identitas">
		<table border="0" cellspacing="0"  style="font-size:13.5px !important;">
			<tr>
				<td colspan="2">Nama Sekolah</td>
				<td colspan="4">: SMK Negeri 1 Kedawung</td>
				<td colspan="2">Kelas</td>
				<td>: <?= $exs->rombel; ?></td>
			</tr>
			<tr>
				<td colspan="2">Alamat Sekolah</td>
				<td colspan="4">: Jl. Tuparev No.12 Cirebon</td>
				<td colspan="2">Semester</td>
				<td>
				: 
					<?php
						if (@$_SESSION['semester'] == "Ganjil") {
							echo " I ".@$_SESSION['semester'];
						} else {
							echo " II ".@$_SESSION['semester'];
						}

					?>
				</td>
			</tr>
			<tr>
				<td colspan="2">Nama Peserta Didik</td>
				<td colspan="4">: <?= $nama; ?></td>
				<td colspan="2">Tahun Pelajaran</td>
				<td>: <?= @$_SESSION['thn_ajaran']; ?></td>
			</tr>
			<tr>
				<td colspan="2">Nomor Induk/NISN</td>
				<td colspan="4">: <?= $exs->nis; ?></td>
				<td colspan="2">&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		</table>
	</div>
	<br>
	<table cellspacing="0" >
		<tr>
			<td colspan="9" style="font-size: 14.5px;font-weight: bold;">
				CAPAIAN HASIL BELAJAR
			</td>
		</tr>
		<tr>
			<td colspan="9" style="font-size: 14px !important !important;font-weight: bold;">
				A. Sikap
			</td>
		</tr>
	</table>
	<table border="1"  cellspacing="0">
		<tr>
			<td colspan="9" style="border-bottom: 0px !important;">
				Deskripsi :
			</td>
		</tr>
		<tr>
			<td colspan="9" style="border-top: 0px !important;height: 50px !important;">
				&nbsp;
			</td>
		</tr>
	</table>
	<br>
	<table cellspacing="0" >
		<tr>
			<td colspan="9" style="font-size: 14px !important;font-weight: bold;">
				B. Pengetahuan &amp; Keterampilan
			</td>
		</tr>
	</table>
	<table border="1" cellspacing="0"  style="font-family: Times;font-size: 12.5px;">
		<thead>
			<tr>
				<th colspan="2" rowspan="2">MATA PELAJARAN</th>
				<th rowspan="2" style="width: 40px !important">KKM</th>
				<th colspan="3">Pengetahuan</th>
				<th colspan="3">Keterampilan</th>
			</tr>
			<tr>
				<th width="40px">Angka</th>
				<th width="40px">Pred</th>
				<th style="min-width: 150px;">Deskripsi</th>
				<th width="40px">Angka</th>
				<th width="40px">Pred</th>
				<th style="min-width: 150px;">Deskripsi</th>
			</tr>
			<tr>
				<th colspan="9" style="text-align: left;background: #ccc;">
					Kelompok A
				</th>
			</tr>
		</thead>
		<tbody>
		<?php
			while ($a = mysqli_fetch_object($wja)) :
				$sqlkkma = select("*", "tbl_kkm", "kode_mapel = '$a->kode_mapel'");
				$kkma = mysqli_fetch_object($sqlkkma);

				$sqlrap = select("*", "tbl_rapot", "id_siswa = '$id_siswa' AND id_mapel = '$a->id' LIMIT 1");
				$rap = mysqli_fetch_object($sqlrap);

				//For knowledge description
				$sqldesp = select("*", "tbl_deskripsi_pth_ganjil", "kode_mapel = '$a->kode_mapel' AND predikat = '$rap->p_predikat'");
				$desp = mysqli_fetch_object($sqldesp);

				//For skill description
				$sqldesk = select("*", "tbl_deskripsi_ktr_ganjil", "kode_mapel = '$a->kode_mapel' AND predikat = '$rap->p_predikat'");
				$desk = mysqli_fetch_object($sqldesk);
		?>
			<tr>
				<td style="text-align: center;vertical-align: middle;width:25px !important;"><?= $no++; ?></td>
				<td><?= $a->nama_mapel; ?></td>
				<td style="text-align: center;width: 40px !important"><?= $kkma->kkm; ?></td>
				<td style="text-align: center;"><?= $rap->p_angka; ?></td>
				<td style="text-align: center;"><?= $rap->p_predikat; ?></td>
				<td style="font-size: 12px !important;">
					<?= $desp->deskripsi; ?>
				</td>
				<td style="text-align: center;"><?= $rap->k_angka; ?></td>
				<td style="text-align: center;"><?= $rap->k_predikat; ?></td>
				<td style="font-size: 12px !important;">
					<?= $desk->deskripsi; ?>
				</td>
			</tr>
		<?php endwhile; ?>
			<tr>
				<td colspan="9" style="text-align: left;background: #ccc;font-weight: bold;">
					Kelompok B
				</td>
			</tr>
			<tr>
				<td style="text-align: center;vertical-align: middle;width:25px !important;">1</td>
				<td>Pendidikan Agama &amp; Budi Pekerti</td>
				<td style="text-align: center;width: 40px !important">75</td>
				<td style="text-align: center;">80</td>
				<td style="text-align: center;">C</td>
				<td style="font-size: 12px !important;">
					Lorem ipsum dolor sit amet, consectetur adipisicing elit.
				</td>
				<td style="text-align: center;">80</td>
				<td style="text-align: center;">C</td>
				<td style="font-size: 12px !important;">
					Lorem ipsum dolor sit amet, consectetur adipisicing elit.
				</td>
			</tr>
			<tr>
				<td colspan="9" style="text-align: left;background: #ccc;font-weight: bold;">
					Kelompok C
				</td>
			</tr>
			<tr>
				<td style="text-align: center;vertical-align: middle;width:25px !important;">1</td>
				<td>Pendidikan Agama &amp; Budi Pekerti</td>
				<td style="text-align: center;width: 40px !important">75</td>
				<td style="text-align: center;">80</td>
				<td style="text-align: center;">C</td>
				<td style="font-size: 12px !important;">
					Lorem ipsum dolor sit amet, consectetur adipisicing elit.
				</td>
				<td style="text-align: center;">80</td>
				<td style="text-align: center;">C</td>
				<td style="font-size: 12px !important;">
					Lorem ipsum dolor sit amet, consectetur adipisicing elit.
				</td>
			</tr>
		</tbody>
	</table>
	<br>
	<table cellspacing="0" >
		<tr>
			<td colspan="9" style="font-size: 14px !important;font-weight: bold;">
				C. Praktik Kerja Lapangan
			</td>
		</tr>
	</table>
	<table border="1"  cellspacing="0">
		<thead>
			<tr  style="background: #ccc !important;font-size: 13px !important;">
				<th width="25">No</th>
				<th style="width: 240px !important;">Mitra DU/DI</th>
				<th colspan="3">Lokasi</th>
				<th>Lamanya (Bulan)</th>
				<th colspan="3">Kegiatan yang dilakukan</th>
			</tr>
		</thead>
		<tbody>
			<tr style="font-size: 14px !important;">
				<td style="text-align: center;vertical-align: middle;">1</td>
				<td>PT. Data Utama Dinamika</td>
				<td colspan="3">Jl. Tuparev No. 12 Cirebon</td>
				<td>3 Bulan</td>
				<td colspan="3">Yaaa praktik kerja lapangan alias PKL atuh :3</td>
			</tr>
		</tbody>
	</table>
	<br>
	<table cellspacing="0" >
		<tr>
			<td colspan="9" style="font-size: 13px !important;font-weight: bold;">
				D. Ekstrakurikuler
			</td>
		</tr>
	</table>
	<table border="1" cellspacing="0" >
		<thead>
			<tr style="background: #ccc;font-size: 13px !important;">
				<th width="30px" style="text-align: center;">No.</th>
				<th width="300px">Kegiatan Ekstrakurikuler</th>
				<th colspan="7">Keterangan</th>
			</tr>
		</thead>
		<tbody>
			<tr style="font-size: 14px !important;">
				<td style="text-align: center;vertical-align: middle;">1</td>
				<td>Pramuka (Praja Muda Karana)</td>
				<td colspan="7"></td>
			</tr>
		</tbody>
	</table>
	<br>
	<table cellspacing="0" >
		<tr>
			<td colspan="9" style="font-size: 14px !important;font-weight: bold;">
				E. Prestasi
			</td>
		</tr>
	</table>
	<table border="1" cellspacing="0" >
		<thead>
			<tr style="background: #ccc;font-size: 14px !important;">
				<th width="30px" style="text-align: center;">No.</th>
				<th width="300px">Jenis Prestasi</th>
				<th colspan="7">Keterangan</th>
			</tr>
		</thead>
		<tbody>
			<tr style="font-size: 14px !important;">
				<td style="text-align: center;vertical-align: middle;">1</td>
				<td>Lomba Makan kerupuk </td>
				<td colspan="7"></td>
			</tr>
		</tbody>
	</table>
	<br>
	<table cellspacing="0" >
		<tr>
			<td colspan="9" style="font-size: 14px !important;font-weight: bold;">
				F. Ketidakhadiran
			</td>
		</tr>
	</table>
	<table border="1"  cellspacing="0" style="width: 41% !important;">
		<tr>
			<td colspan="2">Sakit</td>
			<td style="border-right: 0px;border-bottom: 0px;"><u>&nbsp;</u></td>
			<td style="border-left: 0px;border-bottom: 0px;text-align: right !important;">hari</td>
		</tr>
		<tr>
			<td colspan="2">Izin</td>
			<td style="border-right: 0px;border-bottom: 0px;border-top: 0px;"><u>&nbsp;</u></td>
			<td style="border-top:0px;border-bottom: 0px;border-left: 0px;text-align: right !important;">hari</td>
		</tr>
		<tr>
			<td colspan="2">Tanpa Keterangan</td>
			<td style="border-right: 0px;border-top: 0px;"><u>&nbsp;</u></td>
			<td style="border-top:0px;border-left: 0px;text-align: right !important;">hari</td>
		</tr>
	</table>
	<br>
	<table cellspacing="0" >
		<tr>
			<td colspan="9" style="font-size: 14px !important;font-weight: bold;">
				G. Catatan Wali Kelas
			</td>
		</tr>
	</table>
	<table border="1"  cellspacing="0">
		<tr>
			<td colspan="9" style="border-bottom: 0px !important;height: 40px !important;">
				&nbsp;
			</td>
		</tr>
		<tr>
			<td colspan="9" style="border-top: 0px !important;">
				&nbsp;
			</td>
		</tr>
	</table>
	<br>
	<table cellspacing="0" >
		<tr>
			<td colspan="9" style="font-size: 14px !important;font-weight: bold;">
				H. Tanggapan Orang Tua/Wali
			</td>
		</tr>
	</table>
	<table border="1"  cellspacing="0">
		<tr>
			<td colspan="9" style="border-bottom: 0px !important;height: 40px !important;">
				&nbsp;
			</td>
		</tr>
		<tr>
			<td colspan="9" style="border-top: 0px !important;">
				&nbsp;
			</td>
		</tr>
	</table>
	<br>
	<table  cellspacing="0" style="font-size: 15px;font-family:Times;">
		<tr>
			<td>&nbsp;</td>
			<td style="text-align: center;">Mengetahui,</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan="2" style="text-align: center;">Cirebon, 20 November 2012</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td style="text-align: center;">Orang Tua/Wali,</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan="2" style="text-align: center;">Wali Kelas,</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan="2" style="text-align: center;">Mengetahui,</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan="2" style="text-align: center;">Kepala Sekolah,</td>
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
			<td style="text-align: center;">(..........................)</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan="2" style="text-align: center;"><u><b>LUKMANUL HAKIM</b></u></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan="2" style="text-align: center;">NIP :</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan="2" style="text-align: center;"><u><b>H. FUAD, S.PD.,M.PD</b></u></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan="2" style="text-align: center;">NIP :</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</table>
</body>
</html>