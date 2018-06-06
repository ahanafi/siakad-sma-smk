<?php
$id = @$_SESSION['guru']['id'];
$setting = select('*', 'tbl_guru', "id = '$id'");
$s = mysqli_fetch_object($setting);

?>

<div class="col-md-12">
  <h4>Ubah Password</h4>
  <hr>
  <div class="row">
    <div class="col-md-8">
      <?php
        echo open_form('', 'post', "class='form-group'");
        echo label('id_card', 'Nomor ID Card');
        echo input('number', 'id_card', "class='form-control' value='$s->id_card' disabled")."<br>";

        echo label('password', 'Password Lama');
        echo input('password', 'old_pass', "class='form-control'")."<br>";

        echo label('password', 'Password Baru');
        echo input('password', 'new_pass', "class='form-control'")."<br>";

        echo label('password', 'Konfirmasi Password');
        echo input('password', 'pass_conf', "class='form-control'")."<br>";

        echo input('submit', 'submit', "class='btn btn-primary' value='Simpan'");
        echo close_form();
      ?>
    </div>
    <div class="col-md-4">
      <div class="panel panel-primary">
        <div class="panel-heading">
          Petunjuk
        </div>
        <div class="panel-body">
          <ul class="list-group">
            <li class="list-group-item">1. Isikan password lama Anda</li>
            <li class="list-group-item">2. Jika tidak tahu, harap hubungi Administrator</li>
            <li class="list-group-item">3. Masukkan password baru</li>
            <li class="list-group-item">4. Masukkan konfirmasi password baru</li>
            <li class="list-group-item">5. Klik tombol <strong>Simpan</strong></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
if (isset($_POST['submit'])) {
  $old_pass = anti_inject($_POST['old_pass']);
  $new_pass = anti_inject($_POST['new_pass']);
  $pass_conf = anti_inject($_POST['pass_conf']);

  if (empty(trim($old_pass)) || empty(trim($new_pass)) || empty(trim($pass_conf))) {
    echo "<script>sweetAlert('Oops!', 'Form password tidak boleh ada yang kosong!', 'error');</script>";
  } else {

    $passdb = $s->password;

    $verify = password_verify($old_pass, $passdb);

    //Validasi kesamaan password lama dengan password yg diinputkan
    if ($verify === TRUE) {

      //Mebuat hashing password
      $newpass = password_hash($new_pass, PASSWORD_DEFAULT, ['cost'=>12]);

      //Cek kesamaan password baru dengan konfirmasi password
      $confpass = password_verify($pass_conf, $newpass);

      if ($confpass === TRUE) {

        $update = update('tbl_guru', "password = '$newpass'", "id = '$id'");

        if ($update === TRUE) {
          echo "<script>swal('Yosh!', 'Password berhasil diperbarui!', 'success');</script>";
          echo location('pengaturan');
        } else {
          echo "<script>sweetAlert('Oops!', 'Password tidak sama! Gagal diperbarui!', 'error');</script>";
        }

      } else {
        echo "
          <script>
            sweetAlert('Oops!', 'Password tidak sama!', 'error');
            $('button.confirm').click(function() {
              window.history.go(-1);
            });
          </script>";
      }

    } else {
      echo "<script>sweetAlert('Oops!', 'Password lama tidak terdaftar!', 'error');</script>";
    }

  }

}

?>
