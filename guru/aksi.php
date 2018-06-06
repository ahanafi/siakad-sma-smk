<?php
include_once '../function/core.php';

$nama_kelas  = @$_SESSION['nama_kelas'];
$sqlkls = select("*", "tbl_kelas", "nama_kelas = '$nama_kelas'");
$kls = mysqli_fetch_object($sqlkls);
$kelas_id = $kls->id;
$mapel_id   = @$_SESSION['mapel_id'];
$guru_id    = @$_SESSION['guru']['id'];
//$type_nilai = @$_SESSION['type_nilai'];
$semester   = @$_SESSION['semester'];
$jenis      = @$_POST['jenis'];

    $p_angka    = $_POST['p_agk'];
    $p_predikat = $_POST['p_pre'];
    $k_angka    = $_POST['k_agk'];
    $k_predikat = $_POST['k_pre'];

    //Id siswa
    $id_siswa        = $_POST['s_id'];

    $insert = insert('tbl_rapot', 'id, id_siswa, id_kelas, id_guru, id_mapel, semester, p_angka, p_predikat, k_angka, k_predikat', "NULL, '$id_siswa', '$kelas_id', '$guru_id', '$mapel_id', '$semester', '$p_angka', '$p_predikat', '$k_angka', '$k_predikat'");


  if ($insert === TRUE) {
    echo "true";
  } else {
    echo "false";
  }

?>
