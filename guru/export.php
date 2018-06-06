<?php
include_once '../function/core.php';

if (isset($_GET['data'])) {

	$data = anti_inject(@$_GET['data']);

	header("Content-Type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Data_".$data."_".date('Y_m_d').".xls");

	if ($data == "jadwal") {
	  include_once 'inc/data-jadwal.php';
	} else if($data == "siswa") {
	  include_once 'inc/data-siswa.php';
	} else if($data == "kelas") {
	  include_once 'inc/data-kelas.php';
	} else if($data == "detail-kelas") {
	  include_once 'inc/detail-kelas.php';
	}

} else {
	redirect(base('admin/dashboard'));
}
?>
