<?php
require_once '../function/core.php';
require_once '../assets/dompdf/autoload.inc.php';

//Namespace
use Dompdf\Dompdf;

$sqlkls = select("*", "tbl_kelas");
$thn_ajaran = @$_SESSION['thn_ajaran'];
$no = 1;
$html = "
	<style>
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
				DAFTAR KELAS
				<br>";
	
$html .= "
				TAHUN PELAJARAN ".$thn_ajaran."
			</div>
			<div id='main-data'>
				<table border='1' cellspacing='0' cellpadding='1'>
					<thead>
						<tr>
							<th>No</th>
							<th>Nama Kelas/Rombel</th>
							<th style='width:200px'>Wali Kelas</th>
							<th style='width:200px;'>Paket Keahlian</th>
							<th>Jumlah Siswa</th>
							<th>Keterangan</th>
						</tr>
					</thead>
					<tbody>";
					while ($kls = mysqli_fetch_object($sqlkls)) :
						$sqlhitung = select("*", "tbl_siswa", "rombel = '$kls->nama_kelas'");
						$hitung = mysqli_num_rows($sqlhitung);
$html .= "
						<tr>
							<td class='ctr'>".$no++."</td>
							<td class='ctr'>$kls->nama_kelas</td>
							<td>$kls->wali_kelas</td>
							<td>$kls->paket</td>
							<td class='ctr'>$hitung</td>
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
$pdf->stream("Data Daftar Kelas", array('Attachment'=>0));

?>