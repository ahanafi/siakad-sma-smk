<?php
include_once '../function/core.php';

$id_mapel =  @$_SESSION['mapel_id'];
$sqlmapel = select("*", "tbl_mapel", "id = '$id_mapel'");
$exmap = mysqli_fetch_object($sqlmapel);

$kode = $exmap->kode_mapel;

$type = @$_GET['type'];

if ($type == "pth") {
	$pred = @$_POST['p_pred'];

	$sqlpred = select("*", "tbl_deskripsi_pth_ganjil", "kode_mapel = '$kode' AND predikat = '$pred'");
	$cekpred = mysqli_num_rows($sqlpred);

	if ($cekpred > 0) {
		$pth_db = mysqli_fetch_object($sqlpred);
		
		echo $pth_db->deskripsi;	
	} else {
		echo "&nbsp;";
	}

} else if($type == "ktr") {
	
}


?>