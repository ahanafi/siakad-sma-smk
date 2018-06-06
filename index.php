<?php
include_once 'function/core.php';
$hdr = select('nama_kehadiran, warna', 'tbl_kehadiran');

$cekmgg = date("d");
$xyz = $cekmgg%2;
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Jadwal Hari ini</title>
  </head>
  <link rel="stylesheet" href="<?= base('assets/css/style.css'); ?>" media="screen" title="no title">
  <link rel="stylesheet" href="<?= base('assets/css/bootstrap.css'); ?>" media="screen" title="no title">
  <link rel="stylesheet" href="<?= base('assets/jquery.simplyscroll/jquery.simplyscroll.css'); ?>" media="screen" title="no title">
  <link rel="shrotcut icon" href="<?= base('images/favicon.png'); ?>">
  <script type="text/javascript" src="<?= base('assets/js/jquery.js'); ?>"></script>
  <script type="text/javascript" src="<?= base('assets/js/bootstrap.min.js'); ?>"></script>
  <script type="text/javascript" src="<?= base('assets/jquery.simplyscroll/jquery.simplyscroll.min.js'); ?>"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $("#scroller").simplyScroll({
        customClass: 'simply-scroll',
        frameRate: 15,
        speed: 10,
        pauseOnHover: false,
        orientation:'vertical',
        customClass:'vert'
      });
    });
  </script>
  <body style="background:url('images/pattern.png');background-attachment:fixed;">
    <nav class="navbar navbar-default navbar-fixed-top" style="background:#428bca !important;color:#fff !important;box-shadow: 0px 0px 5px #222;">
      <div class="container">
        <div class="navbar-header">
          <a href="#" class="navbar-brand"><img src="<?= base('images/main-logo.png'); ?>" width="175px" alt="" class="img img-responsive"></a>
        </div> <!-- end of class navbar-header -->
        <div class="collapse navbar-collapse navbar-right">
          <ul class="nav navbar-nav">
            <li>
              <h4 style="padding-top:7px;margin-right:280px;">
                <?php
                $hari = date('w');
                $tgl	= date('Y-m-d');
                echo hari($hari).', '.tglskrg($tgl); ?>
              </h4>
            </li>
          </ul>
        </div> <!-- end of class collapse -->
      </div> <!-- end of class container -->
    </nav>

    <div class="container-fluid" id="main-content">
        <div class="row">
          <?php
            if ($xyz == 1) {
              echo "<audio loop autoplay><source src='music/mars.mp3'></audio>";
            } else {
              echo "<audio loop autoplay><source src='music/hymne.mp3'></audio>";
            }
          ?>
          <div class="col-md-9" style="background-image: url('images/pattern.png') !important;padding-right: 0px;padding-left: 5px;">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th class="ctr" width="120px">Jam</th>
                  <th class="ctr" width="275px">Guru</th>
                  <th class="ctr" width="400px">Mata Pelajaran</th>
                  <th class="ctr">Kelas</th>
                  <th class="ctr">Ket.</th>
                </tr>
              </thead>
            </table>
            <hr>
            <ul id="scroller">
              <li>
                <?php include 'templates/content.php'; ?>
              </li>
            </ul>
          </div>
          <div class="col-md-3" style="padding-right: 5px;">
            <div class="panel panel-primary">
              <div class="panel-heading">
                Pengumuman
              </div>
              <div class="panel-body">
                <?php
                  $annc = select('*','tbl_lain', "id=1 LIMIT 1");
                  $p = mysqli_fetch_assoc($annc);
                  echo $p['isi'];
                ?>
              </div> <!-- end of class panel-body -->
            </div> <!-- end of class panel-primary -->
            <hr>

            <div class="panel panel-primary">
              <div class="panel-heading">
                Keterangan :
              </div>
              <div class="panel-body">
                <table class="table">

                <?php while ($hd = mysqli_fetch_assoc($hdr)) : ?>

                  <tr>
                    <td>
                      <div style="width:30px;height:30px;background:#<?= $hd['warna'];?>"></div>
                    </td>
                    <td>:</td>
                    <td><?= $hd['nama_kehadiran']; ?></td>
                  </tr>

                <?php endwhile; ?>

                </table>
              </div>
            </div>
          </div> <!-- end of class col-md-3 -->
        </div> <!-- end of class row -->
    </div> <!-- end of class container or ID main-content -->

<?php include_once 'templates/footer.php'; ?>
