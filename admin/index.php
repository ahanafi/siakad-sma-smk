<?php
include_once '../function/core.php';
$lv = @$_SESSION['adm']['super'];

if (empty($_SESSION['adm']['user']) && empty($_SESSION['adm']['pass'])) {
  redirect(base('admin/login'));
}
$page = @$_GET['page'];

$guru = hitung('tbl_guru');
$siswa = hitung('tbl_siswa');
$kelas = hitung('tbl_kelas');
$mapel = hitung('tbl_mapel');

$jum_guru = mysqli_num_rows($guru);
$jum_siswa = mysqli_num_rows($siswa);
$jum_kelas = mysqli_num_rows($kelas);
$jum_mapel = mysqli_num_rows($mapel);

$guru_lk = gabung("tbl_guru", "detail_guru", "tbl_guru.id = detail_guru.id_guru", "jk = 'L'");
$guru_pr = gabung("tbl_guru", "detail_guru", "tbl_guru.id = detail_guru.id_guru", "jk = 'P'");

$jurm_guru_lk = mysqli_num_rows($guru_lk);
$jurm_guru_pr = mysqli_num_rows($guru_pr);

$ssw_lk = select("*", "tbl_siswa", "jk = 'L'");
$ssw_pr = select("*", "tbl_siswa", "jk = 'P'");

$jum_ssw_lk = mysqli_num_rows($ssw_lk);
$jum_ssw_pr = mysqli_num_rows($ssw_pr);

$sms = select('*', 'tbl_semester', "id=1 LIMIT 1");
$o = mysqli_fetch_object($sms);
$angka = 1;

$jur_ak = select("*", "tbl_kelas", "paket = 'Akuntansi'");
$jur_ap = select("*", "tbl_kelas", "paket = 'Administrasi Perkantoran'");
$jur_mm = select("*", "tbl_kelas", "paket = 'Multimedia'");
$jur_pm = select("*", "tbl_kelas", "paket = 'Pemasaran'");
$jur_pb = select("*", "tbl_kelas", "paket = 'Perbankan'");
$jur_up = select("*", "tbl_kelas", "paket = 'Usaha Perjalanan Wisata'");

$ak = mysqli_num_rows($jur_ak);
$ap = mysqli_num_rows($jur_ap);
$mm = mysqli_num_rows($jur_mm);
$pm = mysqli_num_rows($jur_pm);
$pb = mysqli_num_rows($jur_pb);
$up = mysqli_num_rows($jur_up);
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Admin Dashboard Page</title>
  </head>
  <link rel="stylesheet" href="<?= base('assets/css/admin.css'); ?>" media="screen" title="no title">
  <link rel="stylesheet" href="<?= base('assets/css/bootstrap.css'); ?>" media="screen" title="no title">
  <link rel="stylesheet" href="<?= base('assets/css/sweetalert.css'); ?>" media="screen" title="no title">
  <link rel="stylesheet" href="<?= base('assets/dataTables/css/dataTables.bootstrap.css'); ?>" media="screen" title="no title">
  <link rel="shrotcut icon" href="<?= base('images/favicon.png'); ?>">
  <script type="text/javascript" src="<?= base('assets/js/jquery.js'); ?>"></script>
  <script type="text/javascript" src="<?= base('assets/js/bootstrap.min.js'); ?>"></script>
  <script type="text/javascript" src="<?= base('assets/js/sweetalert.min.js'); ?>"></script>
  <script type="text/javascript" src="<?= base('assets/dataTables/js/jquery.dataTables.min.js'); ?>"></script>
  <script type="text/javascript" src="<?= base('assets/dataTables/js/dataTables.bootstrap.js'); ?>"></script>
  <script type="text/javascript" src="<?= base('assets/js/loader.js'); ?>"></script>
  
  <script type="text/javascript">
    $(document).ready(function() {
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Data',     'Jumlah'],
          ['Guru',           <?= $jum_guru; ?>],
          ['Siswa',           <?= $jum_siswa; ?>],
          ['Kelas',           <?= $jum_kelas; ?>],
          ['Mata Pelajaran',  <?= $jum_mapel; ?>]
        ]);

        var options = {
          title: 'Data Grafik',
          is3D : true
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }

      google.charts.load('current', {packages:['corechart']});
      google.charts.setOnLoadCallback(TeacherChart);
      function TeacherChart() {
        var data = google.visualization.arrayToDataTable([
          ['Data',        'Jumlah'],
          ['Laki-Laki',     <?= $jurm_guru_lk; ?>],
          ['Perempuan',     <?= $jurm_guru_pr; ?>]
        ]);

        var options = {
          title : 'Grafik Data Guru/PTK',
          is3D : true
        };

        var chart = new google.visualization.PieChart(document.getElementById('TeacherChart'));
        chart.draw(data, options);
      }

      google.charts.load('current', {packages:['corechart']});
      google.charts.setOnLoadCallback(StudentChart);
      function StudentChart(){
        var data = google.visualization.arrayToDataTable([
          ['Data',    'Jumlah'],
          ['Laki-Laki',     <?= $jum_ssw_lk; ?>],
          ['Perempuan',     <?= $jum_ssw_pr; ?>]
        ]);

        var options = {
          title : 'Grafik Data Siswa',
          is3D : true
        }

        var chart = new google.visualization.PieChart(document.getElementById('StudentChart'));
        chart.draw(data,  options);
      }

      google.charts.load('current', {packages:['corechart']});
      google.charts.setOnLoadCallback(PackageChart);
      function PackageChart(){
        var data = google.visualization.arrayToDataTable([
          ['Paket Keahlian',    'Jumlah'],
          ['Akuntansi',   <?= $ak; ?>],
          ['Administrasi Perkantoran',  <?= $ap; ?>],
          ['Multimedia',   <?= $mm; ?>],
          ['Pemasaran',    <?= $pm; ?>],
          ['Perbankan',  <?= $pb; ?>],
          ['Usaha Perjalanan Wisata',   <?= $up; ?>]
        ]);

        var options = {
          title : 'Grafik Data Paket Keahlian',
          colors : ['#f29ba2', '#c182f2', '#ef2b34', '#b7b0b0', '#e89820', '#f2e160'],
          is3D : true
        }

        var chart = new google.visualization.PieChart(document.getElementById('PackageChart'));
        chart.draw(data, options);
      }
      $("#list-data").dataTable({
        'pageLength' : 5,
        'oLanguage':{
          "sZeroRecords":'Tidak ada data!'
        }
      });
      $(".data-utama").mouseenter(function(){
        $(".menu-data").css({
          'display':'block'
        });
      });
      $(".data-nilai").mouseenter(function(){
        $(".menu-nilai").css({
          'display':'block'
        });
      });
      $(".data-mapel").mouseenter(function(){
        $(".menu-mapel").css({
          'display':'block'
        });
      });
      $(".dropdown").mouseleave(function(){
        $(".dropdown-menu").slideUp(800);
      });
      $(".dropdown-menu > li > a").mouseenter(function(){
        $(this).css({'background':'#337ab7','color':'#fff'});
      });
      $(".dropdown-menu > li > a").mouseleave(function(){
        $(this).css({'background':'#fff','color':'#111'});
      });
    });

    function konfirmasi() {
      var tanya = confirm("Apakah Anda yakin akan menghapus data ini ?");

      if (tanya == true) {
        return true;
      } else {
        return false;
      }
    }
  </script>
  <body>
    <?php include_once '../templates/header.php'; ?>
    <nav class="navbar navbar-second navbar-fixed-top" style="margin-top:50px;">
      <div class="container">
        <div class="row">
          <div class="collapse navbar-collapse navbar-left">
            <ul class="nav navbar-nav">
              <li class="active"><a href="<?= base('admin/dashboard'); ?>">Dashboard</a></li>
              <li class="dropdown data-utama">
                <a class="dropdown-toggle" id="dropdown" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Master Data <span class="caret"></span> </a>
                <ul class="dropdown-menu menu-data">
                  <li><a href="<?= base('admin/jadwal'); ?>">Data Jadwal</a></li>
                  <li><a href="<?= base('admin/guru'); ?>">Data Guru</a></li>
                  <li><a href="<?= base('admin/siswa'); ?>">Data Siswa</a></li>
                </ul>
              </li>
              <li class="dropdown data-nilai">
                <a class="dropdown-toggle" id="dropdown" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Nilai <span class="caret"></span></a>
                <ul class="dropdown-menu menu-nilai">
                  <li><a href="<?= base('admin/nilai'); ?>">Lihat Nilai</a></li>
                  <li><a href="<?= base('admin/entry-nilai'); ?>">Entry Nilai</a></li>
                </ul>
              </li>
              <li><a href="<?= base('admin/kelas'); ?>">Kelas</a></li>
              <li class="dropdown data-mapel">
                <a href="<?= base('admin/mata-pelajaran'); ?>">Mata Pelajaran  <span class="caret"></span></a>
                <ul class="dropdown-menu menu-mapel">
                  <li><a href="<?= base('admin/data-deskripsi'); ?>">Deskripsi</a></li>
                  <li><a href="<?= base('admin/data-kkm'); ?>">KKM</a></li>
                </ul>
              </li>
              <li><a href="<?= base('admin/absensi-harian'); ?>">Absensi Harian</a></li>
              <li><a href="<?= base('admin/rekap-absensi'); ?>">Rekap Absen</a></li>
              <li><a href="<?= base('admin/pesan'); ?>">Pesan</a></li>
              <li><a href="<?= base('admin/pengumuman'); ?>">Pengumuman</a></li>
              <li><a href="<?= base('admin/pengaturan'); ?>">Pengaturan</a></li>
            </ul>
          </div>
        </div> <!-- end of class row -->
      </div> <!-- end of class container -->
    </nav>

    <div class="container" id="content">
      <div class="row">
        <div class="panel panel-default">
          <div class="panel-heading">

            <?php
              if ($page == "") {
                echo "Dashboard";
              } else {

                $head = ucfirst($page);

                $txt = str_replace('-', ' ', $head);
                $txt = ucwords($txt);

                echo $txt;
              }
            ?>
          </div>
          <div class="panel-body">
            <?php
              if ($page == "") {

                if ($angka == 1) {
            ?>

                <div class="col-md-12">
                  <div class="alert alert-info" role="alert">
                    <strong>Catatan :</strong>
                    Semester saat ini adalah <strong>Semester <?= $o->semester; ?></strong> Tahun Ajaran <strong><?= $o->tahun_ajaran; ?></strong>, Anda dapat merubah semester di menu
                    <a href="<?= base('admin/pengaturan'); ?>">Pengaturan</a>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  </div>
                </div>

                <?php
                  $angka == 2;
                  @$_SESSION['semester'] = $o->semester;
                } else { } ?>

                <div class="col-md-6 graphic">
                  <h3>Rincian Data</h3>
                  <hr>
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th width="30px;">No.</th>
                        <th>Data</th>
                        <th>Jumlah</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>Guru</td>
                        <td><?= $jum_guru; ?></td>
                      </tr>
                      <tr>
                        <td>2</td>
                        <td>Siswa</td>
                        <td><?= $jum_siswa; ?></td>
                      </tr>
                      <tr>
                        <td>3</td>
                        <td>Kelas</td>
                        <td><?= $jum_kelas; ?></td>
                      </tr>
                      <tr>
                        <td>5</td>
                        <td>Mata Pelajaran</td>
                        <td><?= $jum_mapel; ?></td>
                      </tr>
                    </tbody>
                  </table>
                  <div class="panel panel-default">
                    <div class="panel-heading">Grafik Data PTK</div>
                    <div class="panel-body">
                      <div id="TeacherChart"></div>
                    </div>
                  </div>
                </div> <!-- end of class col-md-6 -->

                <div class="col-md-6 graphic">
                  <div class="panel panel-default" style="border:1px solid #efefe;">
                    <div class="panel-heading" style="font-size: 15px;">
                      Data Grafik
                    </div>
                    <div class="panel-body">
                      <div id="donutchart" style="width: auto; height: 500px;">
                      </div>
                    </div>
                  </div>
                </div> <!-- end of class col md 6 -->

                <div class="col-md-6 graphic">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      Grafik Data Siswa
                    </div>
                    <div class="panel-body">
                      <div id="StudentChart"></div>
                    </div>
                  </div>
                </div>

                <div class="col-md-6 graphic">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      Grafik Data Paket Keahlian (Kelas)
                    </div>
                    <div class="panel-body">
                      <div id="PackageChart"></div>
                    </div>
                  </div>
                </div>

            <?php
              //Routing halaman jadwal
              } else if($page == "jadwal") {
                include_once 'inc/jadwal.php';
              } else if($page == "tambah-jadwal") {
                include_once 'inc/tambah-jadwal.php';
              } else if($page == "hapus-jadwal") {
                include_once 'inc/delete-jadwal.php';
              } else if($page == "edit-jadwal") {
                include_once 'inc/edit-jadwal.php';


              //Routing halaman guru
              } else if($page == "guru") {
                include_once 'inc/guru.php';
              } else if($page == "edit-guru") {
                include_once 'inc/edit-guru.php';
              } else if($page == "ubah-foto") {
                include_once 'inc/ubah-foto.php';
              } else if ($page == "delete-guru") {
                include_once 'inc/delete-guru.php';
              } else if($page == "tambah-guru") {
                include_once 'inc/tambah-guru.php';

              //Routing halaman siswa
              } else if($page == "siswa") {
                include_once 'inc/siswa.php';
              } else if($page == "detail-siswa") {
                include_once 'inc/detail-siswa.php';
              } else if($page == "hapus-siswa") {
                include_once 'inc/delete-siswa.php';
              } else if($page == "tambah-siswa") {
                include_once 'inc/tambah-siswa.php';
              } else if($page == "edit-siswa") {
                include_once 'inc/edit-siswa.php';

              //Routing Nilai
              } else if($page == "nilai") {
                include_once 'inc/nilai.php';
              } else if($page == "entry-nilai") {
                include_once 'inc/entry-nilai.php';
              } else if($page == "entry-nilai-rapot") {
                include_once 'inc/entry-rapot.php';

              //Routing Mata Pelajaran
              } else if($page == "mata-pelajaran") {
                include_once 'inc/mapel.php';
              } else if($page == "tambah-mata-pelajaran") {
                include_once 'inc/tambah-mapel.php';
              } else if($page == "edit-mata-pelajaran") {
                include_once 'inc/edit-mapel.php';
              } else if($page == "delete-mapel") {
                include_once 'inc/delete-mapel.php';

              //Routing halaman kelas
              } else if($page == "kelas") {
                include_once 'inc/kelas.php';
              } else if($page == "detail-kelas") {
                include_once 'inc/detail-kelas.php';
              } else if($page == "tambah-kelas") {
                include_once 'inc/tambah-kelas.php';
              } else if($page == "edit-kelas") {
                include_once 'inc/edit-kelas.php';
              } else if($page == "hapus-kelas") {
                include_once 'inc/delete-kelas.php';

              //Routing import
              } else if($page == "import-siswa") {
                include_once 'inc/import-siswa.php';
              } else if($page == "import-guru") {
                include_once 'inc/import-guru.php';
              } else if($page == "import-kelas") {
                include_once 'inc/import-kelas.php';
              } else if($page == "import-kkm") {
                include_once 'inc/import-kkm.php';
              } else if($page == "import-mapel") {
                include_once 'inc/import-mapel.php';
              } elseif ($page == "import-deskripsi") {
                include_once 'inc/import-deskripsi.php';

              //Routing Deskripsi & KKM
              } elseif ($page == "deskripsi") {
                include_once 'inc/deskripsi.php';
              } elseif ($page == "edit-deskripsi") {
                include_once 'inc/edit-deskripsi.php';
              } elseif ($page == "data-kkm") {
                include_once 'inc/kkm.php';
              } elseif ($page == "edit-kkm") {
                include_once 'inc/edit-kkm.php';


              } else if($page == "absensi-harian") {
                include_once 'inc/absensi-harian.php';
              } else if($page == "rekap-harian") {
                include_once 'inc/rekap-harian.php';
              } else if($page == "rekap-absensi") {
                include_once 'inc/rekap-absensi.php';
              } else if($page == "absensi-kelas") {
                include_once 'inc/absen-kelas.php';
              } else if($page == "absensi-mata-pelajaran") {
                include_once 'inc/absen-mapel.php';

              //Routing Deskripsi
              } else if($page == "deskripsi"){
                include_once 'inc/deskripsi.php';

              //Routing lainnuya
              } else if($page == "pesan") {
                include_once 'inc/pesan.php';
              } else if($page == "delete-pesan") {
                include_once 'inc/delete-pesan.php';
              } else if($page == "hasil-nilai") {
                include_once 'inc/result-nilai.php';
              } else if($page == "tambah-admin") {
                include_once 'inc/tambah-admin.php';
              } else if($page == "pengumuman") {
                include_once 'inc/pengumuman.php';
              } else if($page == "pengaturan") {
                include_once 'inc/pengaturan.php';
              } else if($page == "delete-admin") {
                include_once 'inc/delete-admin.php';
              } else if($page == "edit-admin") {
                include_once 'inc/edit-admin.php';
              } else if($page == "edit-sekolah") {
                include_once 'inc/edit-sekolah.php';
              } else {
                echo "<script>sweetAlert('Oops!', 'Halaman tidak ditemukan!', 'error');</script>";
                echo location(base('admin/dashboard'));
              }
            ?>
          </div> <!-- end of class panel-body -->
        </div> <!-- end of class panel -->
      </div> <!-- end of class row -->
    </div> <!-- end of class container && id content -->

    <?php include_once '../templates/footer.php'; ?>
