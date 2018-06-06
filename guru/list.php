<?php
include_once '../function/core.php';
$id_siswa = $_POST['id'];

error_reporting(0);

//Cek detail siswa
$sqlsis = select('*', 'tbl_siswa', "id = '$id_siswa' LIMIT 1");
$exsis = mysqli_fetch_object($sqlsis);

//Selecting ID Class
$sqlcek = select('*', "tbl_kelas", "nama_kelas = '$exsis->rombel' LIMIT 1");
$excek = mysqli_fetch_object($sqlcek);

$id_kelas = $excek->id;

$wjbA = select('*', 'tbl_mapel', "kelompok = 'A (Wajib)' ORDER BY urutan ");

$no = 1;
$numb = $no;

$nama_kls = @$_SESSION['nama_kls'];

//Selecting
$qwe = substr($nama_kls, 0,2);
$cekjur = substr($nama_kls, 3,2);

if ($qwe == 10){
	$wjbB = select('*', 'tbl_mapel', "kelompok = 'B (Wajib)' AND nama_mapel != 'Bahasa Sunda' ORDER BY urutan ");

	if ($cekjur == "MM") {
		$idm = array(150, 81, 90, 87, 124, 57, 91, 89);
	} else if($cekjur == "AK") {
		$idm = array(13, 149, 42, 87, 101, 125, 93, 164);
	} else if($cekjur == "AP") {
		$idm = array(13, 149, 42, 87, 101, 88, 112, 67);
	} else if($cekjur == "PM") {
		$idm = array(13, 149, 42, 87, 47, 23, 151, 64, 28);
	} else if($cekjur == "PB") {
		$idm = array(13, 149, 42, 87, 101, 125, 93, 164);
	} else {
		$idm = array(92, 60, 87, 99, 61, 52);
	}


} else if ($qwe == 11){
	$wjbB = select('*', 'tbl_mapel', "kelompok = 'B (Wajib)' AND nama_mapel != 'Bahasa Sunda' ORDER BY urutan ");

	if ($cekjur == "MM") {
		$idm = array(150, 81, 90,  94, 129, 77,  95, 116);
	} else if($cekjur == "AK") {
		$idm = array(13, 149, 42, 118, 111, 30, 113);
	} else if($cekjur == "AP") {
		$idm = array(13, 149, 42, 102, 43, 126, 73);
	} else if($cekjur == "PM") {
		$idm = array(13, 149, 42, 104, 115, 114, 119, 106, 100, 122);
	} else if($cekjur == "PB") {
		$idm = array(13, 149, 42, 70, 160, 161, 162);
	} else {
		$idm = array(92, 60, 155, 156, 157, 158, 159);
	}

} else if($qwe == 12){
	$wjbB = select('*', 'tbl_mapel', "kelompok = 'B (Wajib)' AND nama_mapel != 'Bahasa Jepang' ORDER BY urutan ");

	if ($cekjur == "MM") {
		$idm = array(77, 95, 154, 132, 133, 94, 153);
	} else if($cekjur == "AK") {
		$idm = array(118, 40, 130, 30, 113);
	} else if($cekjur == "AP") {
		$idm = array(102, 43, 126, 72);
	} else if($cekjur == "PM") {
		$idm = array(104, 115, 114, 119, 106, 100, 122);
	} else if($cekjur == "PB") {
		$idm = array(160, 161, 162, 163, 113);
	} else {
		$idm = array(155, 156, 157, 158, 159);
	}

} else {
	echo "error!";
}

?>

<script>
	$(document).ready(function(){
		$("table").addClass('table');
	});
</script>
<style>
	*{
		margin:0;
		box-sizing: border-box;
		font-family: "Roboto slab";
	}
	#body{
		background: #fff;
		box-sizing: border-box;
		padding: 20px;
	}
	table{
		width: 100%;
		border:0.2px;
		border-collapse: collapse;
		align-content: top;
	}

	table:first-child{
		text-align: left;
	}

	.b{
		font-weight: bold;
	}

	.ctr{
		text-align: center;
	}

	#nilai td{
		text-align: center !important;
	}

	#nilai td:nth-child(2){
		text-align: left !important;
	}

	#nilai td:only-child{
		text-align: left !important;
	}

	#std td{
		text-align: left !important;
	}

	#eskul tr:first-child{
		font-weight: bold;
	}

	table#absen{
		width: auto;
		min-width: 400px;
	}

	#bottom{
		width: 100%;
		box-sizing: border-box;
		padding: 10px 20px;
	}

	.second{
		width: 50%;
		float: left;
	}
</style>
	<div id="body">
		<!-- this is table for identify student -->
		<table border="0" cellpadding="5" cellspacing="0" id="std">
			<tbody>
				<tr>
					<td>Nama</td>
					<td>:</td>
					<td><?= $exsis->nama; ?></td>
				</tr>
				<tr>
					<td>Kelas</td>
					<td>:</td>
					<td>
						<?= $exsis->rombel; ?>
					</td>
				</tr>
				<tr>
					<td>Nomor Induk</td>
					<td>:</td>
					<td><?= $exsis->nis; ?></td>
				</tr>
				<tr>
					<td>Semester</td>
					<td>:</td>
					<td><?= @$_SESSION['semester']; ?></td>
				</tr>
			</tbody>
		</table>
		<b>CAPAIAN</b>
		<br>
		<!-- this is table for nilai -->
		<table border="1" cellpadding="5" cellspacing="0" id="nilai">
			<thead>
				<tr>
					<th rowspan="3" style="font-weight: bold;">No.</th>
					<th rowspan="3" style="font-weight: bold;">Mata Pelajaran</th>
					<th colspan="2" style="font-weight: bold;">Pengetahuan</th>
					<th colspan="2" style="font-weight: bold;">Keterampilan</th>
					<th colspan="2" style="font-weight: bold;">Sikap Sosial & Spiritual</th>
				</tr>
				<tr>
					<th>Angka</th>
					<th>Predikat</th>
					<th>Angka</th>
					<th>Predikat</th>
					<th>Dalam Mapel</th>
					<th rowspan="2">Antar mapel</th>
				</tr>
				<tr>
					<th>1-100</th>
					<th>&nbsp;</th>
					<th>1-100</th>
					<th>&nbsp;</th>
					<th>SB/B/C/K</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="7" class="b" style="font-weight: bold;text-align: left !important;">Kelompok A (Wajib)</td>
					<td rowspan="28">da</td>
				</tr>

			<?php
				while ($wA = mysqli_fetch_object($wjbA)) :
					$sqlres = select("*", "tbl_rapot", "id_mapel = '$wA->id' AND id_kelas = '$id_kelas'");
					$res = mysqli_fetch_object($sqlres);
			?>

				<tr>
					<td style="text-align: center;"><?= $no++; ?></td>
					<td><?= $wA->nama_mapel; ?></td>
					<td class="ctr">
						<?php
							if($res->p_angka != NULL){
								echo $res->p_angka;
							} else {
								echo "0";
							} ?>
					</td>
					<td class="ctr">
						<?php
							if($res->p_predikat != NULL){
								echo $res->p_predikat;
							} else {
								echo "0";
							} ?>
					</td>
					<td class="ctr">
						<?php
							if($res->k_angka != NULL){
								echo $res->k_angka;
							} else {
								echo "0";
							} ?>
					</td>
					<td class="ctr">
						<?php
							if($res->k_predikat != NULL){
								echo $res->k_predikat;
							} else {
								echo "0";
							} ?>
					</td>
					<td class="ctr"></td>
				</tr>

			<?php endwhile; ?>

				<tr>
					<td colspan="7" class="b" style="font-weight: bold;">Kelompok B (Wajib)</td>
				</tr>

			<?php
				while ($wb = mysqli_fetch_object($wjbB)) :
					$sqlresb = select("*", "tbl_rapot", "id_mapel = '$wb->id' AND id_kelas = '$id_kelas'");
					$resb = mysqli_fetch_object($sqlresb);
			?>

				<tr>
					<td><?= $numb++; ?></td>
					<td><?= $wb->nama_mapel; ?></td>
					<td class="ctr">
						<?php
							if($resb->p_angka != NULL){
								echo $resb->p_angka;
							} else {
								echo "0";
							} ?>
					</td>
					<td class="ctr">
						<?php
							if($resb->p_predikat != NULL){
								echo $resb->p_predikat;
							} else {
								echo "0";
							} ?>
					</td>
					<td class="ctr">
						<?php
							if($resb->k_angka != NULL){
								echo $resb->k_angka;
							} else {
								echo "0";
							} ?>
					</td>
					<td class="ctr">
						<?php
							if($resb->k_predikat != NULL){
								echo $resb->k_predikat;
							} else {
								echo "0";
							} ?>
					</td>
					<td class="ctr"></td>
				</tr>

			<?php endwhile; ?>

				<tr>
					<td colspan="7" class="b" style="font-weight: bold;">Kelompok C : Teknologi Komputer & Informatika</td>
				</tr>
				<!--tr>
					<td class="b">I</td>
					<td colspan="6" class="b" style="font-weight: bold;">Dasar Bidang Keahlian</td>
				</tr>
				<tr>
					<td class="b">III</td>
					<td colspan="6" class="b" style="font-weight: bold;">Paket Keahlian</td>
				</tr-->

			<?php
				foreach ($idm as $i) :
					//Selecting mapel name
					$sqlmp = select("*", "tbl_mapel", "id = '$i' LIMIT 1");
					$exmp = mysqli_fetch_object($sqlmp);

					//Selecting result from tbl rapot
					$sqlrpt = select("*", "tbl_rapot", "id_mapel = '$i' AND id_kelas = '$id_kelas'");
					$rpt = mysqli_fetch_object($sqlrpt);

			?>

				<tr>
					<td><?= $numb++; ?></td>
					<td><?= $exmp->nama_mapel; ?></td>
					<td class="ctr">
						<?php
							if($rpt->p_angka != NULL){
								echo $rpt->p_angka;
							} else {
								echo "0";
							} ?>
					</td>
					<td class="ctr">
						<?php
							if($rpt->p_predikat != NULL){
								echo $rpt->p_predikat;
							} else {
								echo "0";
							} ?>
					</td>
					<td class="ctr">
						<?php
							if($rpt->k_angka != NULL){
								echo $rpt->k_angka;
							} else {
								echo "0";
							} ?>
					</td>
					<td class="ctr">
						<?php
							if($rpt->k_predikat != NULL){
								echo $rpt->k_predikat;
							} else {
								echo "0";
							} ?>
					</td>
					<td class="ctr"></td>
				</tr>

			<?php
				endforeach;
			?>
			<?php
				$sqlsum = select("SUM(p_angka) AS p_total", "tbl_rapot", "id_kelas = '$id_kelas' AND id_siswa = '$id_siswa'");
				$psum = mysqli_fetch_object($sqlsum);

				$sqlhit = select("SUM(k_angka) AS k_total", "tbl_rapot", "id_kelas = '$id_kelas' AND id_siswa = '$id_siswa'");
				$ksum = mysqli_fetch_object($sqlhit);


				//COUNT AVERAGE ALL RESULT FROM table
				$sqlrtp = select("AVG(p_angka) AS p_rata", "tbl_rapot", "id_kelas = '$id_kelas' AND id_siswa = '$id_siswa'");
				$rtp = mysqli_fetch_object($sqlrtp);

				$sqlrtk = select("AVG(k_angka) AS k_rata", "tbl_rapot", "id_kelas = '$id_kelas' AND id_siswa = '$id_siswa'");
				$rtk = mysqli_fetch_object($sqlrtk);
			?>

				<tr>
					<td>&nbsp;</td>
					<td class="b ctr">Jumlah Nilai</td>
					<td class="ctr"><?= $psum->p_total; ?></td>
					<td class="ctr">&nbsp;</td>
					<td class="ctr"><?= $ksum->k_total; ?></td>
					<td class="ctr">&nbsp;</td>
					<td class="ctr">&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td class="b ctr">Rata-rata</td>
					<td class="ctr"><?= number_format($rtp->p_rata); ?></td>
					<td class="ctr">&nbsp;</td>
					<td class="ctr"><?= number_format($rtk->k_rata); ?></td>
					<td class="ctr">&nbsp;</td>
					<td class="ctr">&nbsp;</td>
				</tr>
			</tbody>
		</table>
	</div>