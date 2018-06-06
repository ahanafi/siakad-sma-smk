<?php
require_once '../function/core.php';

$kelompok = anti_inject(@$_POST['kelompok']);
$jur = anti_inject(@$_POST['jur']);
$q = anti_inject(@$_GET['q']);

if ($q == "mapel") {

	if ($kelompok == "C") {
		if ($jur == "AK") {
			$sqlmap = select("id,nama_mapel,kode_mapel,kelas", "tbl_mapel","kelompok='$kelompok' AND paket = 'Akuntansi'");
		} else if($jur == "AP") {
			$sqlmap = select("id,nama_mapel,kode_mapel,kelas", "tbl_mapel","kelompok='$kelompok' AND paket = 'Administrasi Perkantoran'");
		} else if($jur == "MM") {
			$sqlmap = select("id,nama_mapel,kode_mapel,kelas", "tbl_mapel","kelompok='$kelompok' AND paket = 'Multimedia'");
		} else if($jur == "PM") {
			$sqlmap = select("id,nama_mapel,kode_mapel,kelas", "tbl_mapel","kelompok='$kelompok' AND paket = 'Pemasaran'");
		} else if($jur == "PB") {
			$sqlmap = select("id,nama_mapel,kode_mapel,kelas", "tbl_mapel","kelompok='$kelompok' AND paket = 'Perbankan'");
		} else {
			$sqlmap = select("id,nama_mapel,kode_mapel,kelas", "tbl_mapel","kelompok='$kelompok' AND paket = 'Usaha Perjalanan Wisata'");
		}
	} else {
		$sqlmap = select("id,nama_mapel,kode_mapel,kelas", "tbl_mapel","kelompok='$kelompok'");
	}

	$mapel = array();
	while ($x = mysqli_fetch_object($sqlmap)):
		$mapel[] = $x;
	endwhile;

	echo json_encode($mapel);

} else if($q == "id_mapel") {
	$id = (@$_POST['id']);

	$ex = implode("-", $id);
	echo $ex;
	//explode("-", string)
	

} else {
	redirect(base('admin/dashboard'));
}

?>