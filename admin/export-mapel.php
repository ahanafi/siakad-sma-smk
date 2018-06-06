<?php
require_once '../function/core.php';
require_once '../assets/dompdf/autoload.inc.php';

//Namespace
use Dompdf\Dompdf;

$sqlmapel = select("*", "tbl_mapel");
$no = 1;
$html = "
	<style>
		table thead tr th, table tbody tr td{
			vertical-align:middle !important;
		}
		#main-content{
			margin: 0 auto;
			width: 700px;
			font-family: Arial;
		}
		#header{
			text-align: center;
			margin-bottom: 10px;
		}
		#main-header{
			text-align: center;
			font-family: Arial;
			font-weight: bold;
			font-size: 17px;
		}
		#detail table{
			margin:5px auto 0px auto;
			border-collapse: collapse;
			width: 450px;
			font-size: 14px;
			font-weight: bolder;
		}
		#main-data table{
			margin:10px auto 0px auto;
			width: 700px;
			border-collapse: collapse;
		}
		.ctr{
			text-align: center;
		}
		#main-data table thead{
			font-size: 14px;
		}
		#main-data table tbody{
			font-size: 14px;
		}
		#footer{
			padding: 10px 30px 0px 30px;
		}
		.dua{
			width: 50%;
			float: left;
			box-sizing: border-box;
		}
	</style>
	<body>
		<div id='main-content'>
			<div id='header'>
				<img src='../images/header.png' alt='' style='height: 125px !important;'>
			</div>
			<div id='main-header'>
				DAFTAR MATA PELAJARAN
				<br>
			</div>";
	
$html .= "	<div id='main-data'>
				<table border='1' cellspacing='0' cellpadding='3'>
					<thead>
						<tr>
							<th>No</th>
							<th>Kode</th>
							<th style='width:300px;'>Nama Mata Pelajaran</th>
							<th>Kelompok</th>
							<th>Kelas</th>
							<th>Paket Keahlian</th>
							<th>Keterangan</th>
						</tr>
					</thead>
					<tbody>";
					while ($mp = mysqli_fetch_object($sqlmapel)) :
						if ($mp->paket == "Akuntansi") {
							$pkt = "AK";
						} elseif ($mp->paket == "Administrasi Perkantoran") {
							$pkt = "AP";
						} elseif ($mp->paket == "Multimedia") {
							$pkt = "MM";
						} elseif ($mp->paket == "Pemasaran") {
							$pkt = "PM";
						} elseif ($mp->paket == "Perbankan") {
							$pkt = "PB";
						} elseif($mp->paket == "Usaha Perjalanan Wisata") {
							$pkt = "UPW";
						} else {
							$pkt = "Semua";
						}

$html .= "
						<tr>
							<td class='ctr'>".$no++."</td>
							<td class='ctr'>".$mp->kode_mapel."</td>
							<td>$mp->nama_mapel</td>
							<td class='ctr'>$mp->kelompok</td>
							<td class='ctr'>$mp->kelas</td>
							<td class='ctr'>$pkt</td>
							<td></td>
						</tr>";
					endwhile;

$html .= "
					</tbody>
				</table>
			</div>
			<div id='footer'>
				<div class='dua'>
					Mengetahui,
					<br>
					Kepala Sekolah,
					<br>
					<br>
					<br>
					<br>
					<u>H. Fuad, S.Pd., M.Pd.</u>
					<br>
					NIP : 19640705 198902 1 003
				</div>
				<div class='dua' style='padding-left: 200px;'>
					Kedawung, .......
					<br>
					<br>
					<br>
					<br>
					<br>
					<u>.....................................</u>
					<br>
					NIP : 
				</div>
			</div>
		</div>
	</body>
	</html>
";

$pdf = new Dompdf();

//Load an HTML Script
$pdf->loadHtml($html);

$pdf->setPaper('Legal', 'Potrait');
$pdf->render();
$pdf->stream("Data Daftar Mata Pelajaran", array('Attachment'=>0));

?>