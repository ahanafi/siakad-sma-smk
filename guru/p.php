<?php
require_once '../function/core.php';

$ax = anti_inject($_GET['ax']);
$id_siswa = anti_inject($_POST['id_siswa']);

if ($ax == "sicat") {
	$desk = anti_inject($_POST['deskripsi']);
	$cat = anti_inject($_POST['catatan']);

	$ins = insert('data_rapot','id, id_siswa, deskripsi_sikap, catatan', "NULL, '$id_siswa', '$desk', '$cat'");

} elseif ($ax == "abs") {
	$sakit = anti_inject($_POST['sakit']);
	$izin = anti_inject($_POST['izin']);
	$alfa = anti_inject($_POST['alfa']);

	$ins = insert('absensi_siswa',"id, id_siswa, sakit, izin, tnp_ket", "NULL, '$id_siswa', '$sakit', '$izin', '$alfa'");
}

if ($ins === TRUE) {
	die("1");
} else {
	die("0");
}

?>