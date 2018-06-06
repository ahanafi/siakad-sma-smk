<?php
require_once '../function/core.php';
require_once '../assets/dompdf/autoload.inc.php';

//Namespace
use Dompdf\Dompdf;

$sqlguru = select("*", "tbl_guru");
$thn_ajaran = @$_SESSION['thn_ajaran'];
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
				DAFTAR PTK SMK NEGERI 1 KEDAWUNG
				<br>";
	
$html .= "
				TAHUN PELAJARAN ".$thn_ajaran."
			</div>
			<div id='main-data'>
				<table border='1' cellspacing='0' cellpadding='3'>
					<thead>
						<tr>
							<th>No</th>
							<th style='width:200px;'>Nama Guru</th>
							<th>NIP</th>
							<th>Nomor ID Card</th>
							<th>Foto</th>
							<th>Keterangan</th>
						</tr>
					</thead>
					<tbody>";
					while ($gr = mysqli_fetch_object($sqlguru)) :

$html .= "
						<tr>
							<td class='ctr'>".$no++."</td>
							<td class='ctr'>$gr->nama_guru</td>
							<td class='ctr'>$gr->nip</td>
							<td class='ctr'>$gr->id_card</td>
							<td class='ctr'><img src='../images/guru/".$gr->id_card.".jpg' width='100px'></td>
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
$pdf->stream("Data Daftar PTK", array('Attachment'=>0));

?>