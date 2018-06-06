<?php
$sqlkelas = select('*', 'tbl_kelas');
$no = 1;

?>
<script type="text/javascript">
$(document).ready(function(){
  $("#list-data").DataTable({
    'pageLength' : 5
  });

  $(".row > .col-sm-6:first").append(' <a href="<?=base('guru/export-kelas-pdf');?>" target="_blank" class="btn btn-default">Export PDF</a>');
  $(".row > .col-sm-6:first").append(' <a href="<?=base('guru/export.php?data=kelas');?>" class="btn btn-success">Export Ms. Excel</a>');

  $(".dataTables_length, #table-data_info").css({'display':'none'});

  $("#list-data_info").remove();

  $(".dataTables_filter").css({'float':'right'});
  $("footer").css({'bottom':'0px'});
});
</script>
<div class="col-md-12">
  <div class="row">
    <div class="col-md-3">
      <h4>Data Kelas</h4>
    </div>
  </div> <!-- end of class row -->
  <hr>
  <table class="table table-bordered" id="list-data" border="1">
    <thead>
      <tr>
        <th>No.</th>
        <th class="ctr">Nama Kelas/Rombel</th>
        <th class="ctr">Peket Keahlian</th>
        <th>Wali Kelas</th>
        <th class="ctr">Jumlah Siswa</th>
        <th class="ctr">Aksi</th>
      </tr>
    </thead>
    <tbody>

      <?php
        while ($k = mysqli_fetch_assoc($sqlkelas)):
          $hit = hitung('tbl_siswa', "rombel = '$k[nama_kelas]'");
          $tot_siswa = mysqli_num_rows($hit);
      ?>

      <tr>
        <td><?= $no++; ?></td>
        <td class="ctr"><?= $k['nama_kelas']; ?></td>
        <td class="ctr"><?= $k['paket']; ?></td>
        <td><?= $k['wali_kelas']; ?></td>
        <td class="ctr">
          <?= $tot_siswa; ?>
        </td>
        <td class="ctr">
          <a href="<?= base('guru/detail-kelas/'.$k[id]); ?>" class="btn btn-success">Lihat Siswa</a>
        </td>
      </tr>

    <?php endwhile; ?>

    </tbody>
  </table>
</div>
