<?php
require_once '../function/core.php';
require_once '../assets/dompdf/autoload.inc.php';

if (empty($_SESSION['guru']['nama']) || empty($_SESSION['guru']['id_card'])) {
	redirect(base('guru/login'));
}

use Dompdf\Dompdf;

$x = new Dompdf();

if (!isset($_GET['id'])) {
	redirect(base('guru/nilai-rapot'));
}
$id_siswa = anti_inject($_GET['id']);

$sqlsiswa = select("nama, nisn", "tbl_siswa", "id = '$id_siswa' LIMIT 1");
$cek = mysqli_num_rows($sqlsiswa);
if ($cek == 0) {
	redirect(base('guru/nilai-rapot'));
} else {
	$s = mysqli_fetch_object($sqlsiswa);

	$html = "
	<!DOCTYPE html>
	<html lang='en'>
	<style>
		body{
			text-align: center !important;
			marign:0 auto !important;
		}
		header{
			font-weight:bold;
			font-size:20px !important;
			margin-top:40px;
		}
		img{
			margin-top:100px;
			margin-bottom:100px;
			width:25%;
		}
		.kotak{
			border:1px solid #000;
			padding:10px;
			width:33.3%;
			margin:10px auto 0px auto;
			text-align:center;
		}
		.mentri{
			text-align:center;
			margin-top:100px;
			font-weight:bold;
			font-size:16px !important;
		}
	</style>
	<body>
		<main>
			<header>
				RAPOR SISWA
				<br>
				SEKOLAH MENENGAH KEJURUAN
				<br>
				(SMK)
			</header>
			<img src='../images/logo_dikbud.png' alt=''>
			<div id='profil'>
				<br>
				<b>Nama Siswa :</b>
				<div class='kotak'>".
				strtoupper($s->nama)
				."</div>
				<br>
				<br>
				<br>
				<br>
				<b>NISN : </b>
				<div class='kotak'>"
				.$s->nisn.
				"</div>
			</div>
			<div class='mentri'>
				KEMENTRIAN PENDIDIKAN DAN KEBUDAYAAN
				<br>
				REPUBLIK INDONESIA
			</div>
		</main>
	</body>
	</html>";

	$x->loadHtml($html);

	$x->setPaper('A4', 'Potrait');
	$x->render();
	$x->stream('cover_rapot', array('Attachment'=>0));
}

?>