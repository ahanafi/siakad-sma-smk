<?php
include_once '../function/core.php';
//Getting id siswa
$id_siswa = anti_inject(@$_GET['id']);

//Handle error
error_reporting(0);

//Getting student data
$sqlsis = select("*", "tbl_siswa", "id = '$id_siswa' LIMIT 1");
$xs = mysqli_fetch_object($sqlsis);

$ns = strtolower($xs->nama);
$nama = ucwords($ns);

$nama_kls = $xs->rombel;
//Selecting
$qwe = substr($nama_kls, 0,2); //Buat cek kelasnya antara kelas 10, 11, atau 12
$cekjur = substr($nama_kls, 3,2); //Buat cek jurusannya (AP, AK, MM, PM, PB, UPW)

$no =1;
$numb = $no;
$n = $numb;
$nomer = $n;
$numer = $n;
$number = $numer;

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

//Count SUM and AVERAGE
$sqljump = select("SUM(p_angka) AS pjum", "tbl_rapot", "id_siswa = '$id_siswa'");
$jum_p = mysqli_fetch_object($sqljump);

$sqljumk = select("SUM(k_angka) AS kjum", "tbl_rapot", "id_siswa = '$id_siswa'");
$jum_k = mysqli_fetch_object($sqljumk);

$sqlavgp = select("AVG(p_angka) AS avgp", "tbl_rapot", "id_siswa = '$id_siswa'");
$avgp = mysqli_fetch_object($sqlavgp);

$sqlavgk = select("AVG(k_angka) AS avgk", "tbl_rapot", "id_siswa = '$id_siswa'");
$avgk = mysqli_fetch_object($sqlavgk);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Preview Rapot :  <?= $nama." - ".$xs->rombel; ?></title>
	<style>
		*{
			font-size: 13px !important;
		}
		thead{
			background: #428bca;
			color: #fff;
		}

		#mapel_name{
			width: 550px !important;
		}
		.btn-print{
			right: 30px;
			bottom: 40px;
			position: fixed;
		}
		table{
			width: 100%;
			border:1px;
		}
		table > tbody > tr > td, table > thead > tr > th{
			vertical-align: middle !important;
		}
	</style>
</head>
	<link rel="stylesheet" href="<?= base('assets/css/admin.css'); ?>" media="screen" title="no title">
	<link rel="stylesheet" href="<?= base('assets/css/guru.css'); ?>" media="screen" title="no title">
	<link rel="stylesheet" href="<?= base('assets/css/bootstrap.css'); ?>" media="screen" title="no title">
	<link rel="stylesheet" href="<?= base('assets/css/sweetalert.css'); ?>" media="screen" title="no title">
	<link rel="stylesheet" href="<?= base('assets/dataTables/css/dataTables.bootstrap.css'); ?>" media="screen" title="no title">
	<link rel="shortcut icon" href="<?= base('images/favicon.png'); ?>">
	<script type="text/javascript" src="<?= base('assets/js/jquery.js'); ?>"></script>
	<script type="text/javascript" src="<?= base('assets/js/bootstrap.min.js'); ?>"></script>
	<script type="text/javascript" src="<?= base('assets/js/sweetalert.min.js'); ?>"></script>
	<body style="background: #fff !important;">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<table class="table table-bordered">
						<tr>
							<td>Nama Sekolah</td>
							<td>:</td>
							<td>SMK NEGERI 1 KEDAWUNG</td>
						</tr>
						<tr>
							<td>Alamat Sekolah</td>
							<td>:</td>
							<td>Jl. Tuparev No. 12</td>
						</tr>
						<tr>
							<td>Nama Peserta Didik</td>
							<td>:</td>
							<td><?= $nama; ?></td>
						</tr>
						<tr>
							<td>Nomor Induk/NISN</td>
							<td>:</td>
							<td><?= $xs->nis; ?></td>
						</tr>
					</table>
				</div>
				<div class="col-md-6">
					<table class="table table-bordered" width="50%">
						<tbody>
							<tr>
								<td>Kelas</td>
								<td>:</td>
								<td><?= $xs->rombel; ?></td>
							</tr>
							<tr>
								<td>Semester</td>
								<td>:</td>
								<td>
									<?php
										$sms = @$_SESSION['semester'];
										if ($sms == "Ganjil") {
											echo " I ".$sms;
										} else {
											echo " II ".$sms;
										}
									?>
								</td>
							</tr>
							<tr>
								<td>Tahun Pelajaran</td>
								<td>:</td>
								<td><?= @$_SESSION['thn_ajaran']; ?></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
						</tbody>
					</table>
				</div> <!-- end of class of md-6 -->
				<h5><b>CAPAIAN HASIL BELAJAR</b></h5>
				<h5><b>A. Sikap</b></h5>
				<table class="table table-bordered" border="1">
					<tr>
						<td>Deskripsi :</td>
					</tr>
					<tr>
						<td height="130px">
							<?= $dr->deskripsi_sikap; ?>
						</td>
					</tr>
				</table>
				<h5><b>B. Pengetahuan &amp; Keterampilan</b></h5>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th colspan="2" rowspan="2" class="ctr" id="mapel_name">MATA PELAJARAN</th>
							<th rowspan="2" class="ctr">KKM</th>
							<th colspan="3" class="ctr">Pengetahuan</th>
							<th colspan="3" class="ctr">Keterampilan</th>
						</tr>
						<tr>
							<th class="ctr">Angka</th>
							<th class="ctr">Predikat</th>
							<th class="ctr">Deskripsi</th>
							<th class="ctr">Angka</th>
							<th class="ctr">Predikat</th>
							<th class="ctr">Deskripsi</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="9" style="text-align: left;background: #ccc;font-weight: bold;">
								Kelompok A
							</td>
						</tr>
					<?php
						while ($a = mysqli_fetch_object($wja)) :
							$sqlkkma = select("*", "tbl_kkm", "kode_mapel = '$a->kode_mapel'");
							$kkma = mysqli_fetch_object($sqlkkma);

							$sqlrap = select("*", "tbl_rapot", "id_siswa = '$id_siswa' AND id_mapel = '$a->id' LIMIT 1");
							$rap = mysqli_fetch_object($sqlrap);

							//For knowledge description
							$sqldesp = select("*", "tbl_deskripsi_pth", "kode_mapel = '$a->kode_mapel' AND predikat = '$rap->p_predikat' AND semester = '$sms'");
							$desp = mysqli_fetch_object($sqldesp);

							//For skill description
							$sqldesk = select("*", "tbl_deskripsi_ktr", "kode_mapel = '$a->kode_mapel' AND predikat = '$rap->p_predikat' AND semester = '$sms'");
							$desk = mysqli_fetch_object($sqldesk);
					?>
						<tr>
							<td width="30px" style="text-align: center;vertical-align: middle;"><?= $no++; ?></td>
							<td><?= $a->nama_mapel; ?></td>
							<td style="text-align: center;"><?= $kkma->kkm; ?></td>
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
						<?php
							while ($b = mysqli_fetch_object($wjb)) :
								$sqlkkmb = select("*", "tbl_kkm", "kode_mapel = '$b->kode_mapel'");
								$kkmb = mysqli_fetch_object($sqlkkmb);

								$sqlrapb = select("*", "tbl_rapot", "id_siswa = '$id_siswa' AND id_mapel = '$b->id' LIMIT 1");
								$rapb = mysqli_fetch_object($sqlrapb);

								//For knowledge description
								$sqldespb = select("*", "tbl_deskripsi_pth_ganjil", "kode_mapel = '$b->kode_mapel' AND predikat = '$rapb->p_predikat'");
								$despb = mysqli_fetch_object($sqldespb);

								//For skill description
								$sqldeskb = select("*", "tbl_deskripsi_ktr_ganjil", "kode_mapel = '$b->kode_mapel' AND predikat = '$rapb->p_predikat'");
								$deskb = mysqli_fetch_object($sqldeskb);
						?>
						<tr>
							<td width="30px" style="text-align: center;vertical-align: middle;"><?= $n++; ?></td>
							<td><?= $b->nama_mapel; ?></td>
							<td style="text-align: center;"><?= $kkmb->kkm; ?></td>
							<td style="text-align: center;"><?= $rapb->p_angka; ?></td>
							<td style="text-align: center;"><?= $rapb->p_predikat; ?></td>
							<td style="font-size: 14px;">
								<?= $despb->deskripsi; ?>
							</td>
							<td style="text-align: center;"><?= $rapb->k_angka; ?></td>
							<td style="text-align: center;"><?= $rapb->k_predikat; ?></td>
							<td style="font-size: 14px;">
								<?= $deskb->deskripsi; ?>
							</td>
						</tr>
					<?php endwhile; ?>
						<tr>
							<td colspan="9" style="text-align: left;background: #ccc;font-weight: bold;">
								Kelompok C
							</td>
						</tr>
						<?php
							while ($c = mysqli_fetch_object($plc)) :
								$sqlkkmc = select("*", "tbl_kkm", "kode_mapel = '$c->kode_mapel'");
								$kkmc = mysqli_fetch_object($sqlkkmc);

								$sqlrapc = select("*", "tbl_rapot", "id_siswa = '$id_siswa' AND id_mapel = '$c->id' LIMIT 1");
								$rapc = mysqli_fetch_object($sqlrapc);

								//For knowledge description
								$sqldespc = select("*", "tbl_deskripsi_pth_ganjil", "kode_mapel = '$c->kode_mapel' AND predikat = '$rapc->p_predikat'");
								$despc = mysqli_fetch_object($sqldespc);

								//For skill description
								$sqldeskc = select("*", "tbl_deskripsi_ktr_ganjil", "kode_mapel = '$c->kode_mapel' AND predikat = '$rapc->p_predikat'");
								$deskc = mysqli_fetch_object($sqldeskc);
						?>
						<tr>
							<td width="30px" style="text-align: center;vertical-align: middle;"><?= $numb++; ?></td>
							<td><?= $c->nama_mapel; ?></td>
							<td style="text-align: center;"><?= $kkmc->kkm; ?></td>
							<td style="text-align: center;"><?= $rapc->p_angka; ?></td>
							<td style="text-align: center;"><?= $rapc->p_predikat; ?></td>
							<td style="font-size: 14px;">
								<?= $despc->deskripsi; ?>
							</td>
							<td style="text-align: center;"><?= $rapc->k_angka; ?></td>
							<td style="text-align: center;"><?= $rapc->k_predikat; ?></td>
							<td style="font-size: 14px;">
								<?= $deskc->deskripsi; ?>
							</td>
						</tr>
					<?php endwhile; ?>
						<tr>
							<td colspan="2" style="font-weight: bold;text-align: center;">Jumlah Nilai</td>
							<td>&nbsp;</td>
							<td style="font-weight: bold;text-align: center;"><?= $jum_p->pjum; ?></td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td style="font-weight: bold;text-align: center;"><?= $jum_k->kjum; ?></td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td colspan="2" style="font-weight: bold;text-align: center;">Rata-rata</td>
							<td>&nbsp;</td>
							<td style="font-weight: bold;text-align: center;"><?= number_format($avgp->avgp); ?></td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td style="font-weight: bold;text-align: center;"><?= number_format($avgk->avgk); ?></td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
					</tbody>
				</table>
				<h5><b>C. Praktik Kerja Lapangan</b></h5>
				<table class="table table-bordered" border="1">
					<thead>
						<tr>
							<th class="ctr" style="width: 50px !important;">No.</th>
							<th class="ctr" style="width: 230px;">Mitra DU/DI</th>
							<th class="ct" width="30px">Lamanya (bln)</th>
							<th class="ctr" style="width: 230px;">Alamat</th>
							<th class="ctr">Predikat</th>
							<th class="ctr">Bidang Kerja</th>
						</tr>
					</thead>
					<tbody>
					<?php
					if ($cekpkl > 0) {
						while ($pkl = mysqli_fetch_object($sqlpkl)):
					?>
						<tr>
							<td class="ctr"><?= $nomer++; ?></td>
							<td><?= $pkl->mitra; ?></td>
							<td class="ctr"><?= $pkl->lama; ?></td>
							<td class="ctr"><?= $pkl->alamat; ?></td>
							<td class="ctr"><?= $pkl->predikat; ?></td>
							<td class="ctr"><?= $pkl->bid_kerja; ?></td>
						</tr>
					<?php
						endwhile;
						if ($cekpkl == 1) {
					?>
						<tr>
							<td class="ctr">2</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td class="ctr">3</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					<?php		
						} elseif($cekpkl == 2) {
					?>
						<tr>
							<td class="ctr">3</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					<?php
						}
					} else {

						for ($i=1; $i <= 3 ; $i++) : ?>
						<tr>
							<th class="ctr"><?= $i; ?></th>
							<th class="ctr"></th>
							<th class="ctr"></th>
							<th class="ctr"></th>
							<th class="ctr"></th>
							<th class="ctr"></th>
						</tr>								
					<?php
						endfor;
					}
					?>
					</tbody>
				</table>
				<h5><b>D. Ekstra Kurikuler</b></h5>
				<table class="table table-bordered" border="1">
					<thead>
						<tr>
							<th class="ctr" style="width: 50px !important;">No.</th>
							<th class="ctr" style="width: 350px;">Kegiatan Ekstrakurikuler</th>
							<th class="ctr">Nilai</th>
							<th class="ctr">Deskripsi</th>
						</tr>
					</thead>
					<tbody>
					<?php
					if ($cekexk > 0) {
						while ($ex = mysqli_fetch_object($sqlexk)) :
					?>
						<tr>
							<td class="ctr"><?= $numer++; ?></td>
							<td class="ctr"><?= $ex->keg_ekskul; ?></td>
							<td class="ctr"><?= $ex->nilai; ?></td>
							<td class="ctr"><?= $ex->deskripsi; ?></td>
						</tr>
					<?php
						endwhile;
						if ($cekexk == 1) {
					?>
						<tr>
							<td class="ctr">2</td>
							<td class="ctr"></td>
							<td class="ctr"></td>
							<td class="ctr"></td>
						</tr>
						<tr>
							<td class="ctr">3</td>
							<td class="ctr"></td>
							<td class="ctr"></td>
							<td class="ctr"></td>
						</tr>
					<?php
						} elseif ($cekexk == 2) {
					?>
						<tr>
							<td class="ctr">3</td>
							<td class="ctr"></td>
							<td class="ctr"></td>
							<td class="ctr"></td>
						</tr>
					<?php
						}
					} else {
						for ($i=1; $i <= 3 ; $i++) : ?>
						<tr>
							<th class="ctr"><?= $i; ?></th>
							<th class="ctr"></th>
							<th class="ctr"></th>
							<th class="ctr"></th>
						</tr>								
					<?php
						endfor;
					}
						?>
					</tbody>
				</table>
				<h5><b>E. Prestasi</b></h5>
				<table class="table table-bordered" border="1">
					<thead>
						<tr>
							<th class="ctr" style="width: 50px !important;">No.</th>
							<th class="ctr" style="width: 350px;">Jenis Prestasi</th>
							<th class="ctr">Tingkat</th>
							<th class="ctr">Bidang Lomba</th>
						</tr>
					</thead>
					<tbody>
					<?php
					if ($cekpres > 0) {
						while ($prs = mysqli_fetch_object($sqlpres)) :
					?>
						<tr>
							<td class="ctr"><?= $number++; ?></td>
							<td class="ctr"><?= $prs->jenis_prestasi; ?></td>
							<td class="ctr"><?= $prs->tingkat; ?></td>
							<td class="ctr"><?= $prs->bid_lomba; ?></td>
						</tr>
					<?php
						endwhile;
						if ($cekpres == 1) {
					?>
						<tr>
							<td class="ctr">2</td>
							<td class="ctr"></td>
							<td class="ctr"></td>
							<td class="ctr"></td>
						</tr>
						<tr>
							<td class="ctr">3</td>
							<td class="ctr"></td>
							<td class="ctr"></td>
							<td class="ctr"></td>
						</tr>
					<?php
						} elseif ($cekpres == 2) {
					?>
						<tr>
							<td class="ctr">3</td>
							<td class="ctr"></td>
							<td class="ctr"></td>
							<td class="ctr"></td>
						</tr>
					<?php
						}
					} else {
						for ($i=1; $i <= 3 ; $i++) : ?>
						<tr>
							<th class="ctr"><?= $i; ?></th>
							<th class="ctr"></th>
							<th class="ctr"></th>
							<th class="ctr"></th>
						</tr>
					<?php
						endfor;
					}
					?>
					</tbody>
				</table>
				<h5><b>F. Ketidakhadiran</b></h5>
				<table class="table table-bordered" border="1" style="width: 400px !important;">
					<tr>
						<td>Sakit</td>
						<td style="width: 100px;"><?= $abs->sakit; ?></td>
						<td>hari</td>
					</tr>
					<tr>
						<td>Izin</td>
						<td><?= $abs->izin; ?></td>
						<td>hari</td>
					</tr>
					<tr>
						<td>Tanpa Keterangan</td>
						<td><?= $abs->tnp_ket; ?></td>
						<td>hari</td>
					</tr>
				</table>
				<h5><b>G. Catatan Wali Kelas</b></h5>
				<table class="table table-bordered" border="1">
					<tr>
						<td height="60px">
							<?= $dr->catatan; ?>
						</td>
					</tr>
				</table>
				<h5><b>H. Tanggapan Orang Tua/Wali</b></h5>
				<table class="table table-bordered" border="1">
					<tr>
						<td height="60px"></td>
					</tr>
				</table>
			</div>
		</div>
		<a href="<?= base('guru/print/'.$id_siswa); ?>" class="btn btn-lg btn-primary btn-print"><span class="glyphicon glyphicon-print"></span></a>
	</body>
</html>