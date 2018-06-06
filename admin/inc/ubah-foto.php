<?php
$id = @$_GET['id'];
$sqlg = select('nama_guru, id, id_card', 'tbl_guru', "id = '$id'");
$ge = mysqli_fetch_assoc($sqlg);
?>

<div class="col-md-6">
  <h4>Form ubah foto</h4>
  <hr>
  <?php
    echo open_form('', 'post', "class='form-group' enctype='multipart/form-data'");

    echo label('nama_guru', 'Nama Guru');
    echo input('text', 'nama_guru', "class='form-control' value='$ge[nama_guru]' disabled")."<br>";

    echo label('foto', 'Foto');
    echo input('file', 'foto', 'class="form-control"')."<br>";

    echo input('submit', 'upload', "class='btn btn-primary' value='Upload'");
  ?>
    <a href="<?= base("admin/guru"); ?>" class="btn btn-default">Kembali</a>
  <?php echo close_form(); ?>
</div>
<div class="col-md-6">
  <h4>Foto Saat ini</h4>
  <hr>
  <img src="<?= base("/images/guru/".$ge['id_card']); ?>.jpg" class="img img-responsive" alt="" width="30%" />
</div>

<?php

if (isset($_POST['upload'])) {
  $source = $_FILES['foto']['tmp_name'];
  $target = "../images/guru/";
  $namaft = $ge['id_card'].".jpg";

  $moving = move_uploaded_file($source, $target.$namaft);

  if ($moving === TRUE) {
    echo "<script>swal('Yosh!', 'Berhasil merubah foto!', 'success');</script>";
    echo notice(1);
    echo location(base('admin/guru'));
  } else {
    echo "<script>sweetAlert('Oops!', 'Gagal merubah foto!', 'error');</script>";
    echo notice(0);
  }
}
?>
