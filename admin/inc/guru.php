<?php

$sqlguru = select('*', 'tbl_guru', "ds = 0 ORDER BY id_card");
$no = 1;
$lv = @$_SESSION['adm']['super'];
?>
<script type="text/javascript">
  $(document).ready(function() {
    $(".row > .col-sm-6:first").append(
      '<a href="tambah-guru" class="btn btn-primary">Tambah Data Guru</a>'
    );
    $(".row > .col-sm-6:first").append(' <a href="<?= base('admin/import-guru'); ?>" class="btn btn-info">Import Guru</a>');
    $(".row > .col-sm-6:first").append(' <a href="<?=base('admin/export-guru-pdf');?>" target="_blank" class="btn btn-default">Export PDF</a>');
    $(".row > .col-sm-6:first").append(' <a href="export.php?data=guru" class="btn btn-success">Export Ms. Excel</a>');
  });
</script>
<div class="col-md-12">
  <h3>Data Guru</h3>
  <hr>

  <table class="table table-bordered" id="list-data" border="1">
    <thead>
      <tr>
        <th class="ctr">No.</th>
        <th>Nama Guru</th>
        <th class="ctr">NIP</th>
        <th class="ctr">Jenis PTK</th>
        <th class="ctr">No. ID Card</th>
        <th class="ctr">Foto</th>
        <th class="ctr">Aksi</th>
      </tr>
    </thead>
    <tbody>

      <?php while ($g = mysqli_fetch_assoc($sqlguru)) : ?>

      <tr>
        <td class="ctr"><?= $no++; ?></td>
        <td><?= $g['nama_guru']; ?></td>
        <td class="ctr"><?= $g['nip']; ?></td>
        <td class="ctr"><?= $g['jenis_ptk']; ?></td>
        <td class="ctr"><?= $g['id_card']; ?></td>
        <td class="ctr">
          <img src="../images/guru/<?= $g['id_card']; ?>.jpg" width="100px" alt="" />
        </td>
        <td class="ctr">
          <a href="ubah-foto/<?= $g['id']; ?>" class="btn btn-primary">Ubah Foto</a>
          <a href="edit-guru/<?= $g['id']; ?>" class="btn btn-success">Edit</a>
          <?php if($lv == "1"){ ?>
          <a onclick="return konfirmasi()" href="delete-guru/<?= $g['id']; ?>" class="btn btn-danger">Hapus</a>
          <?php } ?>
        </td>
      </tr>

    <?php endwhile; ?>

    </tbody>
  </table>
</div>
