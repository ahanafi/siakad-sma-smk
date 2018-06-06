<?php
$no = 1;
$rombel = $k->nama_kelas;
$siswa = select("*", "tbl_siswa", "rombel = '$rombel'");
$ceksiswa = mysqli_num_rows($siswa);

?>

<script type="text/javascript">
  $(document).ready(function() {
    $("#list-data").dataTable({
      'pageLength' : 5
    });
    $(".dataTables_length").css({
      'display':'none'
    });
    $(".row > .col-sm-6:first").append('<a href="<?= base('guru/export-kelas/kelas/'.base64_encode($k->nama_kelas)); ?>" target="_blank" class="btn btn-default">Export PDF</a>  ');
    $(".row > .col-sm-6:first").append('<a href="export-siswa-excel" target="_blank" class="btn btn-success">Export Ms. Excel</a>  ');
  });
</script>

<div class="col-md-12">
  <h4>Data Siswa</h4>
  <hr>
  <table class="table table-bordered table-striped" id="list-data" border="1">
    <thead>
      <tr>
        <th class="ctr">No.</th>
        <th class="ctr">NIS</th>
        <th class="ctr">Nama Siswa</th>
        <th class="ctr">NISN</th>
        <th class="ctr">Jenis Kelamin</th>
        <th class="ctr">Opsi</th>
      </tr>
    </thead>
    <tbody>

    <?php
      if ($ceksiswa > 0) {
        while ($s = mysqli_fetch_object($siswa)) : ?>

        <tr>
          <td class="ctr"><?= $no++; ?></td>
          <td class="ctr"><?= $s->nis; ?></td>
          <td><?= ucwords(strtolower($s->nama)); ?></td>
          <td><?= $s->nisn; ?></td>
          <td class="ctr"><?= $jk = ($s->jk == "L") ? "Laki-Laki" : "Perempuan"; ?></td>
          <td class="ctr">
            <a href="<?= base('guru/detail-siswa/'.$s->id); ?>" class="btn btn-default">Lihat Detail</a>
          </td>
        </tr>

    <?php endwhile;
      } else {
        echo "<tr><td colspan='6' class='ctr'>Tidak ada data!</td></tr>";
      } ?>

    </tbody>
  </table>
</div>
