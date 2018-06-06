<?php
$id = anti_inject(@$_GET['id']);
$id = abs((int) $id);
$admin = select('*', 'tbl_admin', "id = '$id'");
$adm = mysqli_fetch_object($admin);
?>

<div class="col-md-12">
  <h3>Edit Data Admin</h3>
  <hr>

  <div class="col-md-6">
    <?php
      echo open_form('', 'post', "class='form-group'");
      echo label('username', 'Username');
      echo input('text', 'Username', "class='form-control' value='$adm->username' disabled")."<br>";

      echo label('old_pass', 'Password Lama');
      echo input('password', 'old_pass', "class='form-control'")."<br>";

      echo label('new_pass', 'Password Baru');
      echo input('password', 'new_pass', "class='form-control'")."<br>";
    ?>
  </div>
  <div class="col-md-6">
    <?php
      echo label('pass_conf', 'Konfirmasi Password');
      echo input('password', 'pass_conf', "class='form-control'")."<br>";

      echo label('super', 'Hak Akses');
      echo select_open('super', "class='form-control'");
      if ($adm->super == 1) {
        echo option('', '', '-- Pilih Hak Akses --');
        echo option("1", "selected", 'Administrator');
        echo option('2', '', 'Operator');
      } else {
        echo option('',  '', '-- Pilih Hak Akses --');
        echo option('1',  '', 'Administrator');
        echo option('2', 'selected', 'Operator');
      }
      echo select_close()."<br> <br>";

      echo input('submit', 'submit', "class='btn btn-primary' value='Simpan'")." &nbsp; ";
      echo input('button', 'button', "class='btn btn-default' id='back' value='Kembali'");
    ?>
  </div>
</div>
<script type="text/javascript">
  $("#back").click(function() {
    window.location='<?= base("admin/pengaturan"); ?>';
  });
</script>

<?php

if (isset($_POST['submit'])) {
  $old_pass   = anti_inject($_POST['old_pass']);
  $new_pass   = anti_inject($_POST['new_pass']);
  $pass_conf  = anti_inject($_POST['pass_conf']);
  $super      = anti_inject($_POST['super']);

  // echo $old_pass." ".$new_pass." ".$pass_conf." ".$super;
  //
  // die();

  if (empty(trim($old_pass)) || empty(trim($new_pass)) || empty(trim($pass_conf)) || empty(trim($super))) {
    echo "<script>sweetAlert('Oops!', 'Form password tidak boleh ada yang kosong!', 'error');</script>";
    echo notice(0);
  } else {

    $passdb = $adm->password;

    $verify = password_verify($old_pass, $passdb);

    //Validasi kesamaan password lama dengan password yg diinputkan
    if ($verify === TRUE) {

      //Mebuat hashing password
      $newpass = password_hash($new_pass, PASSWORD_DEFAULT, ['cost'=>12]);

      //Cek kesamaan password baru dengan konfirmasi password
      $confpass = password_verify($pass_conf, $newpass);

      if ($confpass === TRUE) {

        $update = update('tbl_admin', "password = '$newpass', super = '$super'", "id = '$id'");

        if ($update  === TRUE) {
          echo "<script>swal('Yosh!', 'Data Admin berhasil diperbarui!', 'success');</script>";
          echo notice(1);
          echo location('pengaturan');
        } else {
          echo "<script>sweetAlert('Oops!', 'Data Admin Gagal diperbarui!', 'error');</script>";
          echo notice(0);
          echo location('window.history.go(-1)');
        }

      } else {
        echo "<script>sweetAlert('Oops!', 'Password tidak sama!', 'error');</script>";
        echo notice(0);
      }

    } else {
      echo "<script>sweetAlert('Oops!', 'Password lama tidak terdaftar!', 'error');</script>";
      echo notice(0);
    }

  }

}

?>
