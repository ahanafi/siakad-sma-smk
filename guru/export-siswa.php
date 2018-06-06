<?php
require_once '../function/core.php';
require_once '../assets/dompdf/autoload.inc.php';

if (empty($_SESSION['guru']['nama']) || empty($_SESSION['guru']['id_card'])) {
	redirect(base('guru/login'));
}

//Namespace
use Dompdf\Dompdf;

$nmgr = @$_SESSION['guru']['nama'];
$sqlcekwali = select("*", "tbl_kelas", "wali_kelas = '$nmgr'");
$wali = mysqli_fetch_object($sqlcekwali);
$nmkls = $wali->nama_kelas;
$sqlsiswa = select("*", "tbl_siswa", "rombel = '$nmkls'");

//$sqlall = select("*", "tbl_siswa");
$thn_ajaran = @$_SESSION['thn_ajaran'];
$no = 1;

$html = "
	<style>
		#main-content{
			margin: 0 auto;
			width: 700px;
			font-family: Times;
		}
		#header{
			text-align: center;
		}
		#header img{
			float:left;
		}
		#main-header{
			text-align: center;
			font-family: Times;
			font-weight: bold;
			font-size: 15px;
			margin-top:10px;
		}
		#detail table{
			margin:5px auto 0px auto;
			border-collapse: collapse;
			width: 450px;
			font-size: 13px;
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
				<img src='../images/kab_crb.png' alt='' style='height: 100px !important;'>
				<b style='font-size:15px;'>PEMERINTAH KABUPATEN CIREBON</b>
				<br>
				<b style='font-size:15px;'>DINAS PENDIDIKAN</b>
				<br>
				<b style='font-size:20px;'>SMK NEGERI 1 KEDAWUNG</b>
				<br>
				<div style='font-size:13px';>
					Jln. Tuparev No. 12 Telp (0231) 203795 Fax. (0231) 203795, 200653
				</div>
				<br>
				<b>KABUPATEN CIREBON</b>
				<br>
				http://www.http://smkn1-kedawung.sch.id - E-Mail: kampus@smkn1-kedawung.sch.id
				<div style='margin-bottom:2px;border-bottom:1px solid #000;'></div>
				<div style='border-bottom:2px solid #000;'></div>
			</div>
			<div id='main-header'>
				DAFTAR NILAI
				<br>";
	
$html .= "
				TAHUN PELAJARAN ".$thn_ajaran."
			</div>
			<div id='detail'>
				<table border='0' cellspacing='0'>
					<tr>
						<td>MATA PELAJARAN</td>
						<td>:</td>
						<td></td>
					</tr>
					<tr>
						<td>KELAS</td>
						<td>:</td>
						<td>".$nmkls."</td>
					</tr>
					<tr>
						<td>SEMESTER</td>
						<td>:</td>
						<td></td>
					</tr>
					<tr>
						<td>WALI KELAS</td>
						<td>:</td>
						<td>".$nmgr."</td>
					</tr>
				</table>
			</div>
			<div id='main-data'>
				<table border='1' cellspacing='0'>
					<thead>
						<tr>
							<th rowspan='3'>No</th>
							<th rowspan='3'>NIS</th>
							<th rowspan='3' style='width: 220px;'>Nama</th>
							<th rowspan='3'>L/P</th>
							<th colspan='5'>Nilai</th>
							<th rowspan='3'>Keterangan</th>
						</tr>
						<tr>
							<th colspan='2'>Pengetahuan</th>
							<th colspan='2'>Keterampilan</th>
							<th rowspan='2'>Sikap</th>
						</tr>
						<tr>
							<th>Nilai</th>
							<th>Predikat</th>
							<th>Nilai</th>
							<th>Predikat</th>
						</tr>
					</thead>
					<tbody>";
					while ($std = mysqli_fetch_object($sqlsiswa)) :
$html .= "
						<tr>
							<td class='ctr'>".$no++."</td>
							<td class='ctr'>$std->nis</td>
							<td>$std->nama</td>
							<td class='ctr'>$std->jk</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
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
					Kedawung, ................
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
$pdf->stream("Data Daftar Siswa", array('Attachment'=>1));

?>