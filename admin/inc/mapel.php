<?php
$sqlmapel = select('*', 'tbl_mapel', 'ds=0 ORDER BY id ASC');
$no = 1;
$lv = @$_SESSION['adm']['super'];
$cek = mysqli_num_rows($sqlmapel);
?>


<script type="text/javascript">
  $(document).ready(function() {
    $(".row > .col-sm-6:first").append(
      '<a href="tambah-mata-pelajaran" class="btn btn-primary">Tambah Data</a>'
    );
    $(".row > .col-sm-6:first").append(' <a href="<?= base('admin/import-mapel'); ?>" class="btn btn-info">Import Mapel</a>');
    $(".row > .col-sm-6:first").append(' <a href="export.php?data=mapel" class="btn btn-success">Export Ms. Excel</a>');
    $(".row > .col-sm-6:first").append(' <a href="<?= base('admin/export-mapel-pdf'); ?>" target="_blank" class="btn btn-default">Export PDF</a>');
  });
</script>
<div class="col-md-12">
  <h3>Data Mata Pelajaran</h3>
  <hr>
  <table class="table table-bordered" id="list-data" border="1">
    <thead>
      <tr>
        <th class="ctr">No.</th>
        <th class="ctr">Kode Mapel</th>
        <th width="250px">Nama Mata Pelajaran</th>
        <th class="ctr">Paket Keahlian</th>
        <th width="10" class="ctr">Kelompok</th>
        <th class="ctr">Kelas</th>
        <th class="ctr">Aksi</th>
      </tr>
    </thead>
    <tbody>

      <?php while ($m = mysqli_fetch_assoc($sqlmapel)): ?>

      <tr>
        <td class="ctr"><?= $no++; ?></td>
        <td class="ctr"><?= $m['kode_mapel']; ?></td>
        <td><?= $m['nama_mapel']; ?></td>
        <td class="ctr"><?= $m['paket']; ?></td>
        <td class="ctr"><?= $m['kelompok']; ?></td>
        <td class="ctr"><?= $m['kelas']; ?></td>
        <td class="ctr">
          <a href="edit-mapel/<?= $m['id']; ?>" class="btn btn-success">Edit</a>
          <?php if($lv == "1"): ?>
          <a onclick="return konfirmasi()" href="delete-mapel/<?= $m['id']; ?>" class="btn btn-danger">Hapus</a>
        <?php endif; ?>
        </td>
      </tr>

    <?php endwhile; ?>

    </tbody>
  </table>
</div>
