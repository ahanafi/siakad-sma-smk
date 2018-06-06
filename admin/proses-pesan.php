<?php
include_once '../function/core.php';

$act = @$_GET['act'];

if ($act == "detail") {

  $id_pesan = anti_inject($_POST['id']);
  //$sqlpesan = gabung('tbl_pesan', 'tbl_guru', "tbl_pesan.id_guru = tbl_guru.id", "tbl_pesan.id='$id_pesan'");

  $sqlpesan = select('*', 'tbl_pesan', "id='$id_pesan'");
  $exc = mysqli_fetch_object($sqlpesan);

  $sqlguru = select('*', 'tbl_guru', "id='$exc->id_guru'");
  $gr = mysqli_fetch_object($sqlguru);

  if ($exc) {
    echo "
      <table class='table'>
        <tr>
          <td>Nama Pengirim</td>
          <td>:</td>
          <td>$gr->nama_guru</td>
        </tr>
        <tr>
          <td>No. ID Card</td>
          <td>:</td>
          <td>$gr->id_card</td>
        </tr>
        <tr>
          <td>Jenis Keluhan</td>
          <td>:</td>
          <td>$exc->judul</td>
        </tr>
        <tr>
          <td>Keterangan</td>
          <td>:</td>
          <td>$exc->isi</td>
        </tr>
      </table>
    ";
  } else {
    die('0');
  }

} else if($act == "reset") {
  $id_pesan = anti_inject($_POST['id']);

  $sqlpesan = select('*', 'tbl_pesan', "id='$id_pesan'");
  $exc = mysqli_fetch_object($sqlpesan);

  $defaultpass = "123456";
  $pass_hash = password_hash($defaultpass, PASSWORD_DEFAULT, ['cost'=>12]);

  $update = update('tbl_guru', "password = '$pass_hash'", "id = '$exc->id_guru'");

  if ($update) {
    die("1");
  } else {
    die("0");
  }

} else {
  redirect(base('admin/dashboard'));
}
?>
