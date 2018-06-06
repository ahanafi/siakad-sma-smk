<?php
require_once '../function/core.php';
require_once '../assets/dompdf/autoload.inc.php';

//Namespace
use Dompdf\Dompdf;

if (isset($_GET['kelas'])) {
	$kelas = anti_inject($_GET['kelas']);
	$rombel = base64_decode($kelas);// kelas

	$sqlsiswa = select("*", "tbl_siswa", "rombel = '$rombel'");
	$cekdata = mysqli_num_rows($sqlsiswa);

	$thn_ajaran = $_SESSION['thn_ajaran'];

	$sqlwk = select('wali_kelas AS wk', 'tbl_kelas', "nama_kelas = '$rombel'");
	$wk = mysqli_fetch_object($sqlwk);

	//Cek kelas
	$kls = substr($rombel, 0,2);
	$jur = substr($rombel, 3,2);
	$agk = substr($rombel, -1,1);

	$no = 1;

	if ($jur == "AK") {
		$cn = $kls. " Akuntansi ".$agk;
	} else if ($jur == "AP") {
		$cn = $kls. " Administrasi Perkantoran ".$agk;
	} elseif ($jur == "MM") {
		$cn = $kls. " Multimedia ".$agk;
	} elseif ($jur == "PM") {
		$cn = $kls. " Pemasaran ".$agk;
	} elseif ($jur == "PB") {
		$cn = $kls. " Perbankan ".$agk;
	} elseif($jur == "UP") {
		$cn = $kls. " Usaha Perjalanan Wisata ";
	} else {
		$cn = $kls. " ";
	}

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
				font-size: 15px;
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
				font-size:12px !important;
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
				padding: 2px 30px 0px 30px;
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
							<td>".$cn."</td>
						</tr>
						<tr>
							<td>SEMESTER</td>
							<td>:</td>
							<td></td>
						</tr>
						<tr>
							<td>WALI KELAS</td>
							<td>:</td>
							<td>".$wk->wk."</td>
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
	$pdf->stream("Absensi Siswa Kelas ".$rombel, array('Attachment'=>0));

	
} else {
	redirect(base('admin/dashboard'));
}

?>