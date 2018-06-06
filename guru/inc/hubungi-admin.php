<?php $id_guru = @$_SESSION['guru']['id']; ?>
<div class="col-md-8">
  <h4>Kontak Admin</h4>
  <hr>
  <?php
    echo open_form('', 'post', "class='form-group'");
    echo label('judul', 'Judul');
    echo input('text', 'judul', "class='form-control'")."<br>";

    echo label('keterangan', 'Keterangan');
  ?>
  <textarea name="keterangan" class="form-control" rows="3" cols="40"></textarea>
  <br>

  <?php
    echo input('submit', 'submit', "class='btn btn-primary' value='Kirim!'");
    echo close_form();
  ?>
</div>
<div class="col-md-4">
  <div class="panel panel-primary">
    <div class="panel-heading">
      Petunjuk Kontak Admin
    </div>
    <div class="panel-body">
      <ul class="list-group">
        <li class="list-group-item">1. Isi judul dengan masalah yang Anda temukan pada aplikasi ini</li>
        <li class="list-group-item">2. Jelaskan sedetail mungkin masalah Anda, kebingungan anda di kolom Ketereangan</li>
        <li class="list-group-item">3. Setelah itu klik <strong>Kirim!</strong> dan tunggu konfirmasi Administrator</li>
      </ul>
    </div>
  </div>
</div>

<?php
if (isset($_POST['submit'])) {
  $judul      = anti_inject($_POST['judul']);
  $keterangan = anti_inject($_POST['keterangan']);

  if (empty(trim($judul)) || empty(trim($keterangan))) {
    echo "<script>sweetAlert('Oops!', 'Form kontak Admin harus disi!', 'error');</script>";
  } else {
    $insert = insert('tbl_pesan', "id, id_guru, judul, isi", "NULL, '$id_guru', '$judul', '$keterangan' ");

    if ($insert === TRUE) {
      echo "<script>swal('Yosh!', 'Keluhan berhasil terkirim!', 'success');</script>";
    } else {
      echo "<script>sweetAlert('Oops!', 'Gagal mengirim informasi masalah!', 'error');</script>";
    }

  }

}

?>

<script type="text/javascript">
  $(document).ready(function(){
    $("button.confirm").click(function(){
      window.location="hubungi-admin";
    });
  });
</script>
