<?php
$id = anti_inject(@$_GET['id']);
$id = abs((int) $id);
$siswa = gabung('tbl_kelas', 'tbl_siswa', 'tbl_kelas.nama_kelas = tbl_siswa.rombel', "tbl_siswa.id = '$id'");
$s = mysqli_fetch_assoc($siswa);
?>

<style media="screen">
  .col-md-6{
    padding-bottom: 30px;
  }
</style>
<div class="col-md-6">
  <table class="table">
    <tr>
      <td>Nama Lengkap</td>
      <td>:</td>
      <td><?= $s['nama']; ?></td>
    </tr>
    <tr>
      <td>NISN</td>
      <td>:</td>
      <td><?= $s['nisn']; ?></td>
    </tr>
    <tr>
      <td>NIS</td>
      <td>:</td>
      <td><?= $s['nis']; ?></td>
    </tr>
    <tr>
      <td>Kelas</td>
      <td>:</td>
      <td><?= $s['kelas']; ?></td>
    </tr>
    <tr>
      <td>Rombel</td>
      <td>:</td>
      <td><?= $s['rombel']; ?></td>
    </tr>
    <tr>
      <td>Jenis Kelamin</td>
      <td>:</td>
      <td><?= $s['jk']; ?></td>
    </tr>
  </table>
  <br>
  <a href="<?= base('guru/data-siswa');?>" class="btn btn-primary">Kembali</a>
</div>
<div class="col-md-6">

  <?php if($s['jk'] == "L"){ ?>
    <img src="<?= base('images/siswa/male.jpg'); ?>" width="300px" class="img img-responsive" alt="" />
  <?php } else {  ?>
  <img src="<?= base('images/siswa/female.jpg'); ?>" width="300px" class="img img-responsive" alt="" />
  <?php } ?>
</div>
