<?php
include_once '../function/core.php';

if (isset($_POST['add_admin'])) {
  $username = anti_inject($_POST['username']);
  $password = anti_inject($_POST['password']);
  $level = anti_inject($_POST['super']);

  if (empty(trim($username)) || empty(trim($password)) || empty(trim($level))) {
    echo "<script>sweetAlert('Oops!', 'Form tidak boleh ada yang kosong!', 'error');</script>";
    echo notice(0);
    echo location(base('admin/pengaturan'));
  } else {

    $uname = select('*', 'tbl_admin', "username = '$username'");
    $cekuname = mysqli_num_rows($uname);

    if ($cekuname > 0) {
      echo "<script>sweetAlert('Oops!', 'Username telah dipakai! Mohon ganti yang lain!', 'error');</script>";
      echo notice(0);
      echo location(base('admin/pengaturan'));
    } else {

      $createpass = password_hash($password, PASSWORD_DEFAULT, ['cost'=>12]);

      $sql = insert('tbl_admin','id, username, password, super', "NULL, '$username', '$createpass', '$level'");

      if ($sql === TRUE) {
        echo "<script>swal('Yosh!', 'Berhasil menambah pengguna baru!', 'success');</script>";
        echo notice(1);
        echo location(base('admin/pengaturan'));
      } else {
      echo "<script>sweetAlert('Oops!', 'Gagal menambahkan pengguna baru!', 'error');</script>";
      echo notice(0);
      echo location(base('admin/pengaturan'));
      }
    }
  }
} else {
  redirect(base('admin/dashboard'));
}

?>
