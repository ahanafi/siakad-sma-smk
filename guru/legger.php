<?php
require_once '../function/core.php';

if (empty($_SESSION['guru']['nama'])) {
	redirect(base('guru/login'));
}

$wk = @$_SESSION['guru']['nama'];
$sql = select("nama_kelas", "tbl_kelas", "wali_kelas = '$wk' LIMIT 1");
$nk = mysqli_fetch_object($sql);
error_reporting(0);
$rombel = $nk->nama_kelas;

$siswa = select("*", "tbl_siswa", "rombel = '$rombel'");
$ceksiswa = mysqli_num_rows($siswa);

//Cek kelas dan kejuruan
$kls = substr($rombel, 0,2);
$jur = substr($rombel, 3,2);
$pkt = substr($rombel, 3,3);

$no =1;

$mpa = select("*",  "tbl_mapel", "paket = 'Semua' AND kelas = '$kls' AND kelompok = 'A' ");
$mpb = select("*",  "tbl_mapel", "paket = 'Semua' AND kelas = '$kls' AND kelompok = 'B' ");

$total_mpa = mysqli_num_rows($mpa);
$total_mpb = mysqli_num_rows($mpb);

if ($jur == "AK") {
	$mpc = select("*", "tbl_mapel", "paket = 'Akuntansi' AND kelas = '$kls' AND kelompok = 'C'");
} elseif ($jur == "AP") {
	$mpc = select("*", "tbl_mapel", "paket = 'Administrasi Perkantoran' AND kelas = '$kls' AND kelompok = 'C'");
} elseif ($jur == "MM") {
	$mpc = select("*", "tbl_mapel", "paket = 'Multimedia' AND kelas = '$kls' AND kelompok = 'C'");
} elseif ($jur == "PM") {
	$mpc = select("*", "tbl_mapel", "paket = 'Pemasaran' AND kelas = '$kls' AND kelompok = 'C'");
} elseif ($jur == "PB") {
	$mpc = select("*", "tbl_mapel", "paket = 'Perbankan' AND kelas = '$kls' AND kelompok = 'C'");
} elseif ($jur == "UP") {
	$mpc = select("*", "tbl_mapel", "paket = 'Usaha Perjalanan Wisata' AND kelas = '$kls' AND kelompok = 'C'");
}

$total_mpc = mysqli_num_rows($mpc);

$tot_nama_mpl = $total_mpa+$total_mpb+$total_mpc;
$tot_ket = $tot_nama_mpl;

$smstr = @$_SESSION['semester'];

if ($kls == 10) {
	if ($smstr == "Ganjil") {
		$sms = "1";
	} elseif ($smstr == "Genap") {
		$sms = "2";
	}
} elseif ($kls == 11) {
	if ($smstr == "Ganjil") {
		$sms = "3";
	} elseif ($smstr == "Genap") {
		$sms = "4";
	}
} elseif ($kls == 12) {
	if ($smstr == "Ganjil") {
		$sms = "5";
	} elseif ($smstr == "Genap") {
		$sms = "6";
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Preview Legger Nilai</title>
	<link rel="stylesheet" href="<?= base('assets/css/admin.css'); ?>" media="screen" title="no title">
	<link rel="stylesheet" href="<?= base('assets/css/guru.css'); ?>" media="screen" title="no title">
	<link rel="stylesheet" href="<?= base('assets/css/bootstrap.css'); ?>" media="screen" title="no title">
	<link rel="stylesheet" href="<?= base('assets/css/sweetalert.css'); ?>" media="screen" title="no title">
	<link rel="stylesheet" href="<?= base('assets/dataTables/css/dataTables.bootstrap.css'); ?>" media="screen" title="no title">
	<link rel="shortcut icon" href="<?= base('images/favicon.png'); ?>">
	<script type="text/javascript" src="<?= base('assets/js/jquery.js'); ?>"></script>
	<script type="text/javascript" src="<?= base('assets/js/bootstrap.min.js'); ?>"></script>
	<script type="text/javascript" src="<?= base('assets/js/sweetalert.min.js'); ?>"></script>
</head>
<style>
	main{
		margin:60px auto !important;
	}
	.table > thead{
		font-size: 12px !important;
		font-weight: normal !important;
		font-family: Arial !important;
	}
	#data > tbody > tr:hover{
		background: #34495E !important;
		color: #fff !important;
		border-color: #34495E !important;	
	}
</style>
<body>
	<?php include_once '../templates/header.php'; ?>
	<main>
		<div class="container-fluid">
			<div class="panel panel-default"  style="width: 3800px !important;">
				<div class="panel-heading">
					<strong>PREVIEW LEGGER NILAI </strong>
				</div>
				<div class="panel-body">
					<table class="table" style="width: 720px !important;">
						<tr>
							<td>Nama Kelas</td>
							<td>:</td>
							<td>
							<?php
								if($kls==10){
									echo "X ";
								} elseif($kls==11){
									echo "XI ";
								} elseif($kls==12){
									echo "XII ";
								}
								echo $pkt;
							?>
							</td>
							<td>&nbsp;</td>
							<td>Tahun Ajaran</td>
							<td>:</td>
							<td><?= @$_SESSION['thn_ajaran']; ?></td>
							<td>&nbsp;</td>
							<td style="border:none !important;">&nbsp;</td>
							<td style="border:none !important;">
								<a href="excel-legger.php" target="_blank" class="btn btn-success">Export Ms. Excel</a>
							</td>
						</tr>
						<tr>
							<td>Wali Kelas</td>
							<td>:</td>
							<td><?= $wk; ?></td>
							<td>&nbsp;</td>
							<td>Semester</td>
							<td>:</td>
							<td>
								<?= $sms; ?>
							</td>
							<td>&nbsp;</td>
							<td style="border:none !important;">&nbsp;</td>
							<td style="border:none !important;">
								<a href="<?= base('guru/dashboard'); ?>" class="btn btn-primary">Kembali</a>
							</td>
						</tr>
					</table>
					<table id="data" class="table table-responsive table-hover table-bordered" style="width:3700px !important;font-size: 14px;font-family: Arial !important;border-collapse: collapse;" border="1" cellspacing="0">
						<thead  style="font-size: 14px;font-family: Arial !important;">
							<tr>
								<th rowspan="4" style="width: 20px;">No.</th>
								<th rowspan="4" class="ctr">NIS</th>
								<th rowspan="4" class="ctr" style="width: 280px !important;">Nama Siswa</th>
								<th colspan="<?=$total_mpa*4;?>" class="ctr">Kelompok A (Wajib)</th>
								<th colspan="<?=$total_mpb*4;?>" class="ctr">Kelompok B (Wajib)</th>
								<th colspan="<?=$total_mpc*4;?>" class="ctr">Kelompok C (Kejuruan)</th>
							</tr>
							<tr>
								<?php while ($ma = mysqli_fetch_object($mpa)) : ?>
								<th class="ctr" colspan="4">
									<?php
										echo $ma->nama_mapel;
										$id_pla[] = $ma->id;
									?>
								</th>
								<?php endwhile; ?>
								<?php while ($mb = mysqli_fetch_object($mpb)) : ?>
								<th class="ctr" colspan="4">
									<?php
										echo $mb->nama_mapel;
										$id_plb[] = $mb->id;
									?>
								</th>
								<?php endwhile; ?>
								<?php while ($mc = mysqli_fetch_object($mpc)) : ?>
								<th class="ctr" colspan="4">
									<?php
										echo $mc->nama_mapel;
										$id_plc[] = $mc->id;
									?>
								</th>
								<?php endwhile; ?>
							</tr>
							<tr>
							<?php for ($i=1; $i <= $tot_nama_mpl; $i++) : ?>
								<th class="ctr" colspan="2">PTH</th>
								<th class="ctr" colspan="2">KTR</th>
							<?php endfor; ?>
							</tr>
							<tr>
							<?php for ($i=1; $i <= $tot_ket; $i++) :?>
								<th class="ctr">Agk</th>
								<th class="ctr">Pred</th>
								<th class="ctr">Agk</th>
								<th class="ctr">Pred</th>
							<?php endfor; ?>
							</tr>
						</thead>
						<tbody>
							<?php while ($sis = mysqli_fetch_object($siswa)) : ?>
							<tr data-toggle="tooltip" data-placement="top" title="<?=$sis->nama;?>">
								<td class="ctr"><?= $no++; ?></td>
								<td class="ctr"><?= $sis->nis; ?></td>
								<td style="width: 300px !important;"><?= $sis->nama; ?></td>
								<?php
								foreach ($id_pla as $pla) :
									$sqlrapa = select('*', "tbl_rapot", "id_mapel = '$pla' AND id_siswa = '$sis->id'");
									$rapa = mysqli_fetch_object($sqlrapa);
								?>
								<td class="ctr"><?php if($rapa->p_angka != NULL) echo $rapa->p_angka; else echo "0"; ?></td> <!-- angka pth -->
								<td class="ctr"><?php if($rapa->p_predikat != NULL) echo $rapa->p_predikat; else echo "0"; ?></td> <!-- pred pth -->
								<td class="ctr"><?php if($rapa->k_angka != NULL) echo $rapa->k_angka; else echo "0"; ?></td> <!-- angka pth -->
								<td class="ctr"><?php if($rapa->k_predikat != NULL) echo $rapa->k_predikat; else echo "0"; ?></td> <!-- pred pth -->
								<?php endforeach; ?>
								<?php
								foreach ($id_plb as $plb) :
									$sqlrapb = select('*', "tbl_rapot", "id_mapel = '$plb' AND id_siswa = '$sis->id'");
									$rapb = mysqli_fetch_object($sqlrapb);
								?>
								<td class="ctr"><?php if($rapb->p_angka != NULL) echo $rapb->p_angka; else echo "0"; ?></td> <!-- angka pth -->
								<td class="ctr"><?php if($rapb->p_predikat != NULL) echo $rapb->p_predikat; else echo "0"; ?></td> <!-- pred pth -->
								<td class="ctr"><?php if($rapb->k_angka != NULL) echo $rapb->k_angka; else echo "0"; ?></td> <!-- angka pth -->
								<td class="ctr"><?php if($rapb->k_predikat != NULL) echo $rapb->k_predikat; else echo "0"; ?></td> <!-- pred pth -->
								<?php endforeach; ?>
								<?php
								foreach ($id_plc as $plc) :
									$sqlrapc = select('*', "tbl_rapot", "id_mapel = '$plc' AND id_siswa = '$sis->id'");
									$rapc = mysqli_fetch_object($sqlrapc);
								?>
								<td class="ctr"><?php if($rapc->p_angka != NULL) echo $rapb->p_angka; else echo "0"; ?></td> <!-- angka pth -->
								<td class="ctr"><?php if($rapc->p_predikat != NULL) echo $rapb->p_predikat; else echo "0"; ?></td> <!-- pred pth -->
								<td class="ctr"><?php if($rapc->k_angka != NULL) echo $rapb->k_angka; else echo "0"; ?></td> <!-- angka pth -->
								<td class="ctr"><?php if($rapc->k_predikat != NULL) echo $rapb->k_predikat; else echo "0"; ?></td> <!-- pred pth -->
								<?php endforeach; ?>
							</tr>
							<?php endwhile; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</main>
</body>
</html>