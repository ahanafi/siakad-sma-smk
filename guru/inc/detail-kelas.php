<?php
$id = @$_GET['id'];
$sqlkelas = select('*', 'tbl_kelas', "id = '$id'");
$kls = mysqli_fetch_object($sqlkelas);
$no = 1;

//hitung
$hitsql = hitung('tbl_siswa', "rombel = '$kls->nama_kelas'");
$total = mysqli_num_rows($hitsql);
?>

<script type="text/javascript">
  $(document).ready(function() {
    $("#list-data").dataTable({
      'pageLength' : 5
    });
    $(".dataTables_length").css({
      'display':'none'
    });
    $(".row > .col-sm-6:first").append('<a href="<?= base('guru/data-kelas'); ?>" class="btn btn-primary">Kembali</a> ');
    $(".row > .col-sm-6:first").append(' <a href="<?=base('guru/export-kelas/kelas/'.base64_encode($kls->nama_kelas));?>" target="_blank" class="btn btn-default">Export PDF</a>');
    $(".row > .col-sm-6:first").append(' <a href="<?=base('guru/export.php?data=detail-kelas&id='.$id);?>" class="btn btn-success">Export Ms. Excel</a>');
  });
</script>
<div class="col-md-12">
  <h3>Detail Kelas</h3>
  <table class="table">
    <tr>
      <td>Nama Kelas</td>
      <td>:</td>
      <td><?= $kls->nama_kelas; ?></td>
    </tr>
    <tr>
      <td>Paket Keahlian</td>
      <td>:</td>
      <td><?= $kls->paket; ?></td>
    </tr>
    <tr>
      <td>Nama Wali Kelas</td>
      <td>:</td>
      <td><?= $kls->wali_kelas; ?></td>
    </tr>
    <tr>
      <td>Jumlah Siswa</td>
      <td>:</td>
      <td><?= $total; ?></td>
    </tr>
  </table>
  <br>

  <table class="table table-bordered table-striped" id="list-data" border="1">
    <thead>
      <tr>
        <th>No.</th>
        <th>Nama Siswa</th>
        <th>NISN</th>
        <th>NIS</th>
        <th>Jenis Kelamin</th>
      </tr>
    </thead>
    <tbody>

      <?php while ($sis = mysqli_fetch_object($hitsql)) : ?>

      <tr>
        <td><?= $no++; ?></td>
        <td><?= ucwords(strtolower($sis->nama)); ?></td>
        <td><?= $sis->nisn; ?></td>
        <td><?= $sis->nis; ?></td>
        <td><?= $jk = ($sis->jk == "L") ? "Laki-Laki" : "Perempuan"; ?></td>
      </tr>

    <?php endwhile; ?>

    </tbody>
  </table>
</div>
