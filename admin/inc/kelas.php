<?php
$sqlkelas = select('*', 'tbl_kelas');
$no = 1;
$lv = @$_SESSION['adm']['super'];
?>
<script type="text/javascript">
  $(document).ready(function() {
    $(".row > .col-sm-6:first").append(
      '<a href="tambah-kelas" class="btn btn-primary">Tambah Data Kelas</a>'
    );
    var btn_pdf = "<a href='<?= base('admin/export-kelas-pdf') ?>' target='_blank' class='btn btn-default'>Export PDF</a></div>";
    var btn_excel = "<a href='export.php?data=kelas' class='btn btn-success'>Export Ms. Excel</a></div>";

    $(".row > .col-sm-6:first").append(' <a href="<?= base('admin/import-kelas'); ?>" class="btn btn-info">Import Kelas</a>');
    $(".row > .col-sm-6:first").append(' '+btn_pdf+' '+btn_excel);
    $(".close").click(function() {
      $('.col-md-12 > .col-md-3').attr({
        'class':'col-md-12'
      });
    });
  });
</script>
<div class="col-md-12">
  <div class="row">
    <div class="col-md-3">
      <h3>Data Kelas</h3>
    </div>
    <div class="col-md-9">
      <div class="alert alert-info" style="padding:10px !important;">
        <strong>Note : </strong>Klik jumlah siswa untuk melihat siswa yang ada di dalam kelas tersebut
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div> <!-- end of class alert -->
    </div> <!-- end of class col-md-9 -->
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
          <a href="detail-kelas/<?= $k['id']; ?>"><?= $tot_siswa; ?></a>
        </td>
        <td class="ctr">
          <a href="edit-kelas/<?= $k['id']; ?>" class="btn btn-success">Edit</a>
          <?php if($lv == "1"): ?>
          <a onclick="return konfirmasi()" href="delete-kelas/<?= $k['id']; ?>" class="btn btn-danger">Hapus</a>
        <?php endif; ?>
        </td>
      </tr>

    <?php endwhile; ?>

    </tbody>
  </table>
</div>
