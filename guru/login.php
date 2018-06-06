<?php
include_once '../function/core.php';
if (isset($_SESSION['guru']['id_card']) && isset($_SESSION['guru']['pass']) && isset($_SESSION['token'])) {
  redirect(base('guru/dashboard'));
} else {
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login Guru</title>
  </head>
  <link rel="stylesheet" href="<?= base('assets/css/guru.css'); ?>" media="screen" title="no title">
  <link rel="stylesheet" href="<?= base('assets/css/bootstrap.css'); ?>" media="screen" title="no title">
  <link rel="stylesheet" href="<?= base('assets/css/sweetalert.css'); ?>" media="screen" title="no title">
  <link rel="stylesheet" href="<?= base('assets/css/animate.css'); ?>" media="screen" title="no title">
  <link rel="stylesheet" href="<?= base('assets/dataTables/css/dataTables.bootstrap.css'); ?>" media="screen" title="no title">
  <link rel="shrotcut icon" href="<?= base('images/favicon.png'); ?>">
  <script type="text/javascript" src="<?= base('assets/js/jquery.js'); ?>"></script>
  <script type="text/javascript" src="<?= base('assets/js/bootstrap.min.js'); ?>"></script>
  <script type="text/javascript" src="<?= base('assets/js/sweetalert.min.js'); ?>"></script>
  <script type="text/javascript" src="<?= base('assets/dataTables/js/jquery.dataTables.min.js'); ?>"></script>
  <script type="text/javascript" src="<?= base('assets/dataTables/js/dataTables.bootstrap.js'); ?>"></script>
  <script type="text/javascript">
    $(document).ready(function(){
      var lost  = $("#lost");
      var modal = $("#lost-password");
      var error = $(".error");

      lost.click(function(){
        var id_card = $("#id_card").val();
        var nama    = $("#nama").val();
        var button  = $("button.confirm");

        if(id_card == "" || nama == ""){
          //sweetAlert('Oops!', 'Form harus diisi!', 'error');
          error.append("<div class='alert alert-danger'><strong>Oops!...</strong> Form tidak boleh ada yang kosong...</div>");
          $(".alert").fadeOut(3000);
        } else {

          //Make Ajax processing
          $.ajax({
            method  : "POST",
            url     : "lost-pass.php",
            cache   : false,
            data    : {
              id_card   : id_card,
              nama_guru : nama
            },
            success : function(result){
              if (result == "1") {
                // swal('Yosh!', 'Permintaan reset password sudah terkirim!', 'success');
                // button.on("click", function(){
                //   window.location='dashboard';
                // });
                error.append("<div class='alert alert-success'><strong>Yosh!...</strong> Permintaan reset password sudah terkirim!</div>");
                $(".alert").fadeOut(3000);
                $("#id_card").val('');
                $("#nama").val('');
              } else {
                error.append("<div class='alert alert-danger'><strong>Oops!...</strong> Akun tidak ditemukan di dalam sistem...</div>");
                $(".alert").fadeOut(3000);
              }
            }
          });
        }
      });

      //$("#login-box").hide();
    });

    function load(){
      $(".login").addClass('animated flipInX');
    }

    function maxChars(el, max){
      if (el.value.length > el.maxLength) {
        el.value = el.value.slice(0, el.maxLength);
      }
    }
  </script>
  <body onload="load();" style="background-size: cover;">

    <div class="container">
      <div id="login-box" class="login">
        <div class="box-heading">
          Halaman Login Guru
        </div>
        <div class="box-content">
          <?php
            echo open_form('', 'post', "class='form-group'");
            echo input('number', 'id_card', "class='form-control' placeholder='Nomor ID Card' autofocus oninput='maxChars(this, 5)' maxLength='5' max='99999' min='00000'")."<br>";
            echo input('password', 'password', "class='form-control' placeholder='Password'")."<br>";
            echo input('submit', 'submit', "class='btn btn-primary form-control' value='Login'")."<br>";
            echo close_form();
          ?>
          <p>
            <a href="#" data-toggle="modal" data-target="#lost-password">Saya Lupa Password </a>
          </p>
        </div>
      </div>
    </div>
    <div class="modal fade" id="lost-password" tabindex="-1" role="dialog" aria-labelledby="lost-password">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="lost-password">
              Lupa Password ?
            </h4>
          </div>
          <?php //echo open_form('', 'post', "class='form-group' id='form-lost'"); ?>
          <div class="modal-body">
            <?php
              echo "<div class='error'></div>";
              echo label('id', "Nomor ID Card");
              echo input('number', "id", "class='form-control' id='id_card'")."<br>";

              echo label('nama', "Atas Nama");
              echo input('nama', "nama", "class='form-control' id='nama'")."<br>";

            ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" name="lost" class="btn btn-primary" id="lost">Kirim</button>
          </div>
          <?php //echo close_form(); ?>
        </div>
      </div>
    </div>
  </body>
</html>

<?php
if (isset($_POST['submit'])) {
  $id_card   = anti_inject($_POST['id_card']);
  $password   = anti_inject($_POST['password']);

  if (empty(trim($id_card)) || empty(trim($password))) {
    echo "<script>sweetAlert('Oops!', 'Kolom ID Card dan Password harus diisi!', 'error');</script>";
    echo notice(0);
  } else {

    $cek_id = cek_idcard($id_card);
    $ceknow   = mysqli_num_rows($cek_id);

    if ($ceknow != 0) {
      $data = mysqli_fetch_object($cek_id);

      //Checking password match
      $cekpass = password_verify($password, $data->password);

      if ($cekpass === TRUE) {
        $smstr  = select('*', 'tbl_semester', "id=1 LIMIT 1");
        $sms    = mysqli_fetch_object($smstr);

        $jenis = $data->jenis_ptk;
        $wk    = $data->wali_kelas;

        if ($jenis == "Guru Mapel" || $jenis == "Guru" && $wk == 1) {

          $token                       = md5(sha1($data->id_card));
          @$_SESSION['token']          = $token;
          @$_SESSION['semester']       = $sms->semester;
          @$_SESSION['thn_ajaran']     = $sms->tahun_ajaran;
          @$_SESSION['guru']['pass']   = $data->password;
          @$_SESSION['guru']['id_card']= $data->id_card;
          @$_SESSION['guru']['nama']   = $data->nama_guru;
          @$_SESSION['guru']['id']     = $data->id;
          @$_SESSION['guru']['nip']    = $data->nip;

          redirect('dashboard');

        } else {
          echo "<script>sweetAlert('Oops!', 'Maaf! Hanya Guru/Pengajar saja yang diperbolehkan login!', 'error');</script>";
          echo notice(0);
        }

      } else {
        echo "<script>sweetAlert('Oops!', 'ID Card atau Password tidak cocok!', 'error');</script>";
        echo notice(0);
      }

    } else {
        echo "<script>sweetAlert('Oops!', 'ID Card atau Password salah!', 'error');</script>";
        echo notice(0);
    }
  }

}
}
?>
