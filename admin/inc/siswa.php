<?php
$lv = @$_SESSION['adm']['super'];
$siswa = gabung('tbl_kelas', 'tbl_siswa', 'tbl_kelas.nama_kelas = tbl_siswa.rombel');
$no = 1;
?>

<div class="col-md-12">
  <h3>Data Siswa</h3>
  <hr>
  <script type="text/javascript">
    $(document).ready(function() {
      $(".row > .col-sm-6:first").append(
        '<a href="tambah-siswa" class="btn btn-primary">Tambah Siswa Baru</a>'
      );
      $(".row > .col-sm-6:first").append(' <a href="export.php?data=siswa" class="btn btn-default">Export Ms. Excel</a>');
      $(".row > .col-sm-6:first").append(' <a href="<?= base('admin/import-siswa'); ?>" class="btn btn-success">Import Siswa</a>');
    });
  </script>

  <table class="table table-bordered table-hover" id="list-data" border="1px">
    <thead>
      <tr>
        <th class="ctr">No.</th>
        <th>Nama Siswa</th>
        <th class="ctr">NISN</th>
        <th class="ctr">NIS</th>
        <th class="ctr">Kelas</th>
        <th class="ctr">Rombel</th>
        <th class="ctr">L/P</th>
        <th class="ctr">Opsi</th>
      </tr>
    </thead>
    <tbody>

      <?php while ($s = mysqli_fetch_assoc($siswa)) : ?>

      <tr>
        <td class="ctr"><?= $no++; ?></td>
        <td><?= ucwords(strtolower($s['nama'])); ?></td>
        <td class="ctr"><?= $s['nisn'] ?></td>
        <td class="ctr"><?= $s['nis']; ?></td>
        <td class="ctr"><?= $s['kelas']; ?></td>
        <td class="ctr"><?= $s['rombel']; ?></td>
        <td class="ctr"><?= $s['jk']; ?></td>
        <td  class="ctr">
          <a href="detail-siswa/<?= $s['id']; ?>" class="btn btn-primary">Detail</a>
          <a href="edit-siswa/<?= $s['id']; ?>" class="btn btn-success">Edit</a>
          <?php if($lv == "1"): ?>
          <a onclick="return konfirmasi()" href="delete-siswa/<?= $s['id']; ?>" class="btn btn-danger">Hapus</a>
        <?php endif; ?>
        </td>
      </tr>

    <?php endwhile; ?>

    </tbody>
  </table>
</div>
