<?php
include '../function/core.php';

$x = @$_GET['x'];
$idg = @$_GET['idg'];
$idj = @$_GET['idj'];
$tgl = date('Y-m-d');

$sql = "SELECT * FROM tbl_guru JOIN tbl_jadwal ON tbl_guru.id = tbl_jadwal.guru JOIN tbl_kelas ON tbl_jadwal.kelas = tbl_kelas.id JOIN tbl_mapel ON tbl_jadwal.mapel = tbl_mapel.id WHERE tbl_jadwal.id = '$idj' ";
$exec  = mysqli_query($link, $sql);

while ($d = mysqli_fetch_assoc($exec)) :

  if ($x == "hadir") {
  	$sql = update(
  		"tbl_jadwal",
  		"kehadiran = 1",
  		"id = '$idj' "
  		);

    $hdr = 1;
  	$hadir = $d['hadir'];
  	$hit = $hadir+1;

  } else if($x == "izin"){
  	$sql = update(
  		"tbl_jadwal",
  		"kehadiran = 2",
  		"id = '$idj' "
  		);

    $hdr = 2;
  	$izin = $d['izin'];
  	$hit = $izin+1;

  } else if($x == "tugas"){
  	$sql = update(
  		"tbl_jadwal",
  		"kehadiran = 3",
  		"id = '$idj' "
  		);

    $hdr = 3;
  	$tugas = $d['tugas'];
  	$hit = $tugas+1;

  } else if($x == "sakit"){
  	$sql = update(
  		"tbl_jadwal",
  		"kehadiran = 4",
  		"id = '$idj' "
  		);

    $hdr = 4;
  	$sakit = $d['sakit'];
  	$hit = $sakit+1;

  } else if($x == "lain"){
  	$sql = update(
  		"tbl_jadwal",
  		"kehadiran = 5",
  		"id = '$idj' "
  		);

    $hdr = 5;
  	$lain = $d['lain'];
  	$hit = $lain+1;

} else {
	redirect('jadwal');
}

$upd = update('tbl_guru', "$x = '$hit'", "id = '$idg'");
$ins = insert('tbl_rekap', 'id, idg, nama_guru, kelas, mapel, tanggal, kehadiran, ds, ket', "NULL, '$d[guru]', '$d[nama_guru]', '$d[nama_kelas]', '$d[nama_mapel]', '$tgl', '$hdr', '0', ''");

if ($upd === TRUE && $ins === TRUE) {
  //echo "<script>swal('Yosh!', 'Berhasil mengisi absensi !', 'success');</script>";
  echo redirect('jadwal');
} else {
  //echo "<script>sweetAlert('Yosh!', 'Berhasil mengisi absensi !', 'error');</script>";
  echo redirect('jadwal');
}
endwhile;
?>
