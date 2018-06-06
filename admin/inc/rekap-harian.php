<?php
$id = @$_GET['id'];
$data = gabung('tbl_harian','tbl_guru', 'tbl_harian.idg = tbl_guru.id', "tbl_harian.idg='$id'");
$lv = @$_SESSION['adm']['super'];
$detail = mysqli_fetch_object($data);
$no =1;
?>

<script type="text/javascript">
  $(document).ready(function() {
    $(".row > .col-sm-6:first").append('<a href="<?= base("admin/absensi-harian"); ?>" class="btn btn-primary">Kembali</a> ');
    $(".row > .col-sm-6:first").append('   <a href="<?= base("admin/export.php?data=rekap-harian&id=$id");?>" class="btn btn-default">Export Ms. Excel</a>');
  });
</script>
<div class="col-md-12">
  <h3>Rekap Data Absen Harian</h3>
  <hr>
  <div class="row">
    <div class="col-md-8">
      <table class="table table-bordered table-striped" id="list-data">
        <thead>
          <tr>
            <th>No</th>
            <th>Hari</th>
            <th>Tanggal</th>
            <th>Jam Masuk</th>
            <th>Jam Pulang</th>
          </tr>
        </thead>
        <tbody>

        <?php while ($hr = mysqli_fetch_object($data)) : ?>

          <tr>
            <td><?= $no++; ?></td>
            <td><?= $hr->hari; ?></td>
            <td><?= $hr->tanggal; ?></td>
            <td><?= $hr->jam_msk; ?></td>
            <td><?= $hr->jam_plg; ?></td>
          </tr>

        <?php endwhile; ?>

        </tbody>
      </table>
    </div> <!-- end of class col md 8 -->
    <div class="col-md-4">
      <div class="panel panel-primary">
        <div class="panel-heading">
          Detail Guru
        </div>
        <div class="panel-body">
          <table class="table">
            <tr>
              <td>Nama</td>
              <td>:</td>
              <td><?= $detail->nama_guru; ?></td>
            </tr>
            <tr>
              <td>NIP</td>
              <td>:</td>
              <td><?= $detail->nip; ?></td>
            </tr>
            <tr>
              <td>No. ID Card</td>
              <td>:</td>
              <td><?= $detail->id_card; ?></td>
            </tr>
          </table>
        </div> <!-- end of class panel-body -->
      </div> <!-- end of class panel -->
    </div> <!-- end of class col-md-4 -->
  </div> <!-- end of class row -->
</div> <!-- end of class col md 12 -->
