<?php
include_once '../function/core.php';

$id_card    = anti_inject($_POST['id_card']);
$nama_guru  = anti_inject($_POST['nama_guru']);

$sql = select("*", 'tbl_guru', "id_card = '$id_card' OR nama_guru LIKE '%$nama_guru%'");
$cek = mysqli_num_rows($sql);
$data = mysqli_fetch_object($sql);

if ($cek > 0) {

  $req  = "Hallo Admin! Saya mengalami lupa password untuk akun saya";
  $req .= "Mohon reset-kan password akun saya. Terima Kasih! :)";

  $sqlin = insert('tbl_pesan',"id, id_guru, judul, isi", "NULL, '$data->id', 'Lupa Password', '$req'" );
  die('1');
} else {
  die('0');
}

?>
