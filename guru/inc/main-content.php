<?php
$page = @$_GET['page'];

  if ($page == "") {
?>

<script type="text/javascript">
  $(document).ready(function(){
    $("#list-data").dataTable({
      'pageLength':5
    });

    $(".dataTables_length, #list-data_info").css({'display':'none'});

    $("#list-data_wrapper > .row:last > .col-sm-5").remove();
    $("#list-data_wrapper > .row:last > .col-sm-7").attr({
      'class':'col-sm-12'
    });

    $(".dataTables_filter").css({'float':'right'});
    $("footer").css({'bottom':'0px'});
  });
</script>
<div class="col-md-6">
  <h4>Hallo, <?= $x->nama_guru; ?>!</h4>
  <p>
    Apa kabar hari ini ?
  </p>
  <hr>
  <?php
    if ($cekyo != 0) {
      echo "Anda adalah Wali Kelas dari <b>".$k->nama_kelas."</b><br>";
      echo "Klik <a class='btn-link' href='".base('guru/data-siswa')."'>Di sini</a> untuk melihat Data Siswa";
    }

  ?>
</div> <!-- end of class col-md-6 -->
<div class="col-md-6">
  <h4>Kehadiran Anda :</h4>
  <table class="table table-bordered" id="list-data">
    <thead>
      <tr>
        <th>No.</th>
        <th>Hari</th>
        <th>Tanggal</th>
        <th>Jam Masuk</th>
        <th>Jam Pulang</th>
      </tr>
    </thead>
    <tbody>

    <?php while ($g = mysqli_fetch_object($data)) : ?>

      <tr>
        <td><?= $no++; ?></td>
        <td><?= $g->hari; ?></td>
        <td><?= $g->tanggal; ?></td>
        <td><?= $g->jam_msk; ?></td>
        <td><?= $g->jam_plg; ?></td>
      </tr>

    <?php endwhile; ?>

    </tbody>
  </table>
</div> <!-- end of claa col md 6 -->

<?php
  } else if($page == "data-jadwal") {
    include_once 'inc/data-jadwal.php';
    echo active('data-jadwal');

  } else if($page == "data-siswa") {
    include_once 'inc/data-siswa.php';
    echo active('data-siswa');

  } else if($page == "data-kelas") {
    include_once 'inc/data-kelas.php';
    echo active('data-kelas');

  } else if($page == "detail-kelas") {
    include_once 'inc/detail-kelas.php';
    echo active('data-kelas');

  } else if($page == "data-kehadiran") {
    include_once 'inc/data-kehadiran.php';
    echo active('data-kehadiran');

  } else if($page == "opsi-entry-nilai") {
    include_once 'inc/opsi-entry_bak.php';
    echo active('entry-nilai');

  } else if($page == "entry-nilai") {
    include_once 'inc/entry-nilai.php';
    echo active('entry-nilai');

  } else if($page == "lihat-nilai") {
    include_once 'inc/lihat-nilai.php';
    echo active('lihat-nilai');

  } else if($page == "hasil-nilai") {
    include_once 'inc/hasil-nilai.php';
    echo active('lihat-nilai');

  } else if($page == "entry-nilai&kelas") {
    include_once 'inc/nilai-kelas.php';
    echo active('entry-nilai');

  } else if($page == "entry-nilai-kelas") {
    include_once 'inc/entry-nilai-kelas.php';
    echo active('entry-nilai');

  } else if($page == "pengaturan") {
    include_once 'inc/pengaturan.php';
    echo active('pengaturan');

  } else if($page == "upload") {
    include_once 'inc/upload.php';

  } else if($page == "hubungi-admin") {
    include_once 'inc/hubungi-admin.php';
    echo active('hub-admin');

  } else if($page == "nilai-rapot") {
    include_once 'inc/nilai-rapot.php';
    echo active('nilai-rapot');

  } else if($page == "data-rapot") {
    include_once 'inc/data-rapot.php';
    echo active('data-rapot');

  } else if($page == "entry-nilai-rapot") {
    include_once 'inc/entry-rapot.php';

  } else if($page == "input-sikap") {
    include_once 'inc/sikap.php';

  } else if($page == "input-prestasi") {
    include_once 'inc/prestasi.php';

  } else if($page == "input-absensi") {
    include_once 'inc/absensi.php';

  } else if($page == "input-prakerin") {
    include_once 'inc/prakerin.php';

  } else if($page == "input-ekskul") {
    include_once 'inc/ekstrakurikuler.php';

  } else if($page == "input-pep") {
    include_once 'inc/pep.php';

  } else if($page == "entry-pep") {
    include_once 'inc/entry-pep.php';

  } else if($page == "act") {
    include_once 'inc/act.php';

  } else if($page == "detail-siswa") {
    include_once 'inc/detail-siswa.php';

  } else if($page == "export-kelas") {
    include_once 'inc/export-kelas.php';
    
  } else {
    echo "<script>sweetAlert('Oops!', 'Halaman tidak ditemukan!', 'error');</script>";
    echo location(base('guru'));
  }
?>
