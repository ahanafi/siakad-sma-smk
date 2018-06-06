<?php
include_once '../function/core.php';

if (isset($_GET['q'])) {
  $q = anti_inject(@$_GET['q']);

  if ($q == "kelas") {
    $kelas = anti_inject($_POST['kelas']);
    $mapela = array();
    $mapelc = array();
    $maindata = array();

    $kls = substr($kelas, 0,2);
    $jur = substr($kelas, 3,2);

    if ($kls == 10) {

      $sqlmpa = select("*", "tbl_mapel", "paket = 'Semua' AND kelas = 10");

      if ($jur == "AK") {
        $sqlmapel = select("*", "tbl_mapel", "paket = 'Akuntansi' AND kelas = '$kls'");
      } elseif ($jur == "AP") {
        $sqlmapel = select("*", "tbl_mapel", "paket = 'Administrasi Perkantoran' AND kelas = '$kls'");
      } elseif ($jur == "MM") {
        $sqlmapel = select("*", "tbl_mapel", "paket = 'Multimedia' AND kelas = '$kls'");
      } elseif ($jur == "PM") {
        $sqlmapel = select("*", "tbl_mapel", "paket = 'Pemasaran' AND kelas = '$kls'");
      } elseif ($jur == "PB") {
        $sqlmapel = select("*", "tbl_mapel", "paket = 'Perbankan' AND kelas = '$kls'");
      } elseif ($jur == "UP") {
        $sqlmapel = select("*", "tbl_mapel", "paket = 'Usaha Perjalanan Wisata' AND kelas = '$kls'");
      }

    } elseif($kls == 11) {

      $sqlmpa = select("*", "tbl_mapel", "paket = 'Semua' AND kelas = 11");

      if ($jur == "AK") {
        $sqlmapel = select("*", "tbl_mapel", "paket = 'Akuntansi' AND kelas = '$kls'");
      } elseif ($jur == "AP") {
        $sqlmapel = select("*", "tbl_mapel", "paket = 'Administrasi Perkantoran' AND kelas = '$kls'");
      } elseif ($jur == "MM") {
        $sqlmapel = select("*", "tbl_mapel", "paket = 'Multimedia' AND kelas = '$kls'");
      } elseif ($jur == "PM") {
        $sqlmapel = select("*", "tbl_mapel", "paket = 'Pemasaran' AND kelas = '$kls'");
      } elseif ($jur == "PB") {
        $sqlmapel = select("*", "tbl_mapel", "paket = 'Perbankan' AND kelas = '$kls'");
      } elseif ($jur == "UP") {
        $sqlmapel = select("*", "tbl_mapel", "paket = 'Usaha Perjalanan Wisata' AND kelas = '$kls'");
      }

    } elseif ($kls == 12) {

      $sqlmpa = select("*", "tbl_mapel", "paket = 'Semua' AND kelas = 12");

      if ($jur == "AK") {
        $sqlmapel = select("*", "tbl_mapel", "paket = 'Akuntansi' AND kelas = '$kls'");
      } elseif ($jur == "AP") {
        $sqlmapel = select("*", "tbl_mapel", "paket = 'Administrasi Perkantoran' AND kelas = '$kls'");
      } elseif ($jur == "MM") {
        $sqlmapel = select("*", "tbl_mapel", "paket = 'Multimedia' AND kelas = '$kls'");
      } elseif ($jur == "PM") {
        $sqlmapel = select("*", "tbl_mapel", "paket = 'Pemasaran' AND kelas = '$kls'");
      } elseif ($jur == "PB") {
        $sqlmapel = select("*", "tbl_mapel", "paket = 'Perbankan' AND kelas = '$kls'");
      } elseif ($jur == "UP") {
        $sqlmapel = select("*", "tbl_mapel", "paket = 'Usaha Perjalanan Wisata' AND kelas = '$kls'");
      }

    }

  }

  while ($mpa = mysqli_fetch_object($sqlmpa)) {
   $mapela[] =  $mpa;
  }

  while ($mpc = mysqli_fetch_object($sqlmapel)) {
    $mapelc[] = $mpc;
  }

  $maindata = array_merge($mapela, $mapelc);

  echo json_encode($maindata);


} else {
  redirect(base('admin/dashboard'));
}
?>
