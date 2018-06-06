<?php
ob_start();
error_reporting(0);
include_once '../function/core.php';
if (empty($_SESSION['guru']['id_card']) && empty($_SESSION['guru']['pass']) && empty($_SESSION['token'])) {
  redirect(base('guru/login'));
}
$id = @$_SESSION['guru']['id'];
$guru = gabung('tbl_guru', 'detail_guru', 'tbl_guru.id = detail_guru.id_guru', "tbl_guru.id = '$id'");
$x = mysqli_fetch_object($guru);
$no =1;
$data = gabung('tbl_harian','tbl_guru', 'tbl_harian.idg = tbl_guru.id', "tbl_harian.idg='$id' ORDER BY tbl_harian.id DESC");
$page = @$_GET['page'];

$wk = @$_SESSION['guru']['nama'];
$cekwk = select('*', "tbl_kelas", "wali_kelas =  '$wk'");
$cekyo = mysqli_num_rows($cekwk);
$k = mysqli_fetch_object($cekwk);
$id_card = @$_SESSION['guru']['id_card'];
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Halaman Dashboard Guru</title>
  </head>
  <link rel="stylesheet" href="<?= base('assets/css/admin.css'); ?>" media="screen" title="no title">
  <link rel="stylesheet" href="<?= base('assets/css/guru.css'); ?>" media="screen" title="no title">
  <link rel="stylesheet" href="<?= base('assets/css/bootstrap.css'); ?>" media="screen" title="no title">
  <link rel="stylesheet" href="<?= base('assets/css/sweetalert.css'); ?>" media="screen" title="no title">
  <link rel="stylesheet" href="<?= base('assets/dataTables/css/dataTables.bootstrap.css'); ?>" media="screen" title="no title">
  <link rel="shrotcut icon" href="<?= base('images/favicon.png'); ?>">
  <script type="text/javascript" src="<?= base('assets/js/jquery.js'); ?>"></script>
  <script type="text/javascript" src="<?= base('assets/js/bootstrap.min.js'); ?>"></script>
  <script type="text/javascript" src="<?= base('assets/js/sweetalert.min.js'); ?>"></script>
  <script type="text/javascript" src="<?= base('assets/dataTables/js/jquery.dataTables.min.js'); ?>"></script>
  <script type="text/javascript" src="<?= base('assets/dataTables/js/dataTables.bootstrap.js'); ?>"></script>
  <script type="text/javascript" src="<?= base('assets/tinymce/tinymce.min.js'); ?>"></script>
  <script type="text/javascript" src="<?= base('assets/js/my-script.js'); ?>"></script>
  <script type="text/javascript" src="<?= base('assets/js/result.js'); ?>"></script>
  <script type="text/javascript" async="true">
    $(document).ready(function() {
      $(".navbar > .container").attr({
        'class':'container-fluid'
      });
      $(".navbar > .container-fluid").css({
        'padding-left':'35px',
        'padding-right':'35px'
      });
      $("#okay").click(function() {
        window.location='opsi-entry';
      });
      $(".dataTables_length, #list-data_info").css({'display':'none'});
      $("#list-data_wrapper > .row:last > .col-sm-5").remove();
      $("#list-data_wrapper > .row:last > .col-sm-7").attr({
        'class':'col-sm-12'
      });
      $(".dataTables_filter").css({'float':'right'});
      $("footer").css({'bottom':'0px'});
    });

    function konfirmasi(){
      var tanya = confirm("Apakah Anda yakin akan menghapus data ini ?");
      if (tanya == tre) {
        return true;
      } else {
        return false;
      }
    }
  </script>
  <body>
    <?php include_once '../templates/header.php'; ?>
    <div id="main-content">
      <div class="col-md-2">
        <div class="panel panel-default">
          <div class="panel-heading" style="text-align:center;">
              <img src="<?= base('images/guru/'.$id_card); ?>.jpg" width="80px" class="img img-responsive" style="margin-left:55px;margin-top:15px;" alt=""  data-toggle="modal" data-target="#ubah-foto" />
              <p>
                <strong><?= $x->nama_guru; ?></strong>
              </p>
              <p style="font-size: 12px;">* Klik untuk mengubah foto</p>
          </div>
          <div class="panel-body">
            <?php include_once 'inc/menu.php'; ?>
          </div>
        </div>
      </div> <!-- end of class col md 2 -->
      <div class="col-md-10">
        <div class="panel panel-default">
          <div class="panel-heading" style="font-weight:bold;">
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
          <div class="panel-body" style="min-height:500px;">
            <?php include_once 'inc/main-content.php'; ?>
          </div> <!-- end of class -panel-body -->
        </div> <!-- end of class panel panel-default -->
      </div> <!-- end of class col md 10 -->
    </div>

    <!-- modal for entry nilai -->
    <div class="modal fade" id="prepare-entry" tabindex="-1" role="dialog" aria-labelledby="prepare-entry">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="prepare-entry">Petunjuk Pengisian Nilai</h4>
          </div>
          <div class="modal-body">
            <ul class="list-group">
              <li class="list-group-item">1. Pilih terlebih <b>Paket Keahlian</b></li>
              <li class="list-group-item">2. Pilih <b>Kelas</b> yang akan diisi nilainya </li>
              <li class="list-group-item">3. Kemudian, pilih <strong>Mata pelajaran</strong> yang akan diisi nilainya</li>
              <li class="list-group-item">4. Isilah nilai sesuai dengan format yang ada</li>
              <li class="list-group-item">5. Klik <strong>Selesai</strong> jika sudah terisi semua</li>
            </ul>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="button" class="btn btn-primary" id="okay">Mengerti &nbsp; <span class="glyphicon glyphicon-ok"></span></button>
          </div> <!-- end of class modal footer -->
        </div> <!-- end of class modal content -->
      </div> <!-- end of class modal dialog -->
    </div> <!-- div class modal  fade -->
    <div class="modal fade" id="ubah-foto" tabindex="-1" role="dialog" aria-labelledby="ubah-foto">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="ubah-foto">Ubah Foto</h4>
          </div>

          <form class="form-group" action="upload" method="post" enctype="multipart/form-data">

          <div class="modal-body">
            <?php
              echo label('', 'Pilih foto :');
              echo input('file', 'foto', "class='form-control'");
            ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" name="upload" class="btn btn-primary">Simpan</button>
          </div>

          </form>

      </div> <!-- end of modal content -->
    </div> <!-- end of modal dialog -->
  </div> <!-- end of class modal fade -->