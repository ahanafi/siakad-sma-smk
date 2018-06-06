<?php

$id_card = @$_SESSION['guru']['id_card'];

if (isset($_POST['upload'])) {
  $source   = $_FILES['foto']['tmp_name'];
  $type     = $_FILES['foto']['type'];
  $target   = "../images/guru/";
  $namafoto = $id_card.".jpg";
  $ext      = array("image/jpg", "image/png", "image/jpeg");

  if (empty($source)) {
    echo "<script>sweetAlert('Oops!', 'Mohon pilih file foto dulu!', 'error');</script>";
    echo location(base('guru/dashboard'));
  } else {

    $prs = in_array($type, $ext);

    if ($prs === TRUE) {
      
      $delete = unlink("../images/guru/".$id_card.".jpg");

      if ($delete === TRUE) {

        $upload = move_uploaded_file($source, $target.$namafoto);

        if ($upload === TRUE) {
          echo "<script>swal('Yosh!', 'Foto berhasil di ubah!', 'success');</script>";
          echo location(base('guru/dashboard'));
        } else {
          echo "<script>sweetAlert('Oops!', 'Gagal saat mengubah foto!', 'error');</script>";
          echo location(base('guru/dashboard'));
        }

      } else {
        echo "<script>sweetAlert('Oops!', 'Gagal mengganti foto!', 'error');</script>";
        echo location(base('guru/dashboard'));
      }
    } else {
      echo "<script>sweetAlert('Oops!', 'Format foto yang Anda upload tidak valid!', 'error');</script>";
      echo location(base('guru/dashboard'));
    }

  }
} else {
  redirect(base('guru/dashboard'));
}
?>