<?php

$wk = select('*', 'tbl_guru');
$paket = select('DISTINCT paket', 'tbl_kelas ORDER BY nama_kelas ASC');

?>

<div class="col-md-12">
  <h3>Tambah Data Kelas</h3>
  <hr>
  <div class="col-md-6">
    <?php
      echo open_form('', 'post', "class='form-group'");
      echo label('nama_kelas', 'Nama Kelas');
      echo input('text', 'nama_kelas', "class='form-control'")."<br>";

      echo label('wali_kelas', 'Wali Kelas');
      echo select_open('wali_kelas', "class='form-control'");
      echo option('', '', '-- Pilih Wali Kelas --');
      while ($w = mysqli_fetch_object($wk)) :
        echo option("$w->nama_guru",  '', "$w->nama_guru");
      endwhile;
      echo select_close()."<br>";
    ?>
  </div>
  <div class="col-md-6">
    <?php
      echo label('paket', 'Paket Keahlian');
      echo select_open('paket', "class='form-control'");
      echo option('',  '', '-- Pilih Paket Keahlian --');
      while ($pkt = mysqli_fetch_object($paket)) :
        echo option("$pkt->paket", '', "$pkt->paket");
      endwhile;
      echo select_close()."<br> <br>";

      echo input('submit', 'submit', "value='Tambahkan' class='btn btn-primary'")." &nbsp; ";
      echo input('button', 'button', "value='Kembali' class='btn btn-default' id='back'");

    ?>
  </div>
</div>

<?php
if (isset($_POST['submit'])) {
  $nama_kelas = anti_inject($_POST['nama_kelas']);
  $paket      = anti_inject($_POST['paket']);
  $wali_kelas = addslashes($_POST['wali_kelas']);

  if (empty(trim($nama_kelas)) || empty(trim($paket))) {
    echo "<script>sweetAlert('Oops!', 'Form tidak boleh ada yang kosong!');</script>";
  } else {

    $cekwal = select('*', 'tbl_kelas', "wali_kelas = '$wali_kelas' AND nama_kelas = '$nama_kelas'");
    $cek = mysqli_num_rows($cekwal);

    if ($cek > 0) {
      echo "
        <script>
          sweetAlert('Oops!', 'Guru tersebut sudah memiliki kelas atau Kelas sudah tersedia!', 'error');
          $('button.confirm').click(function() {
            window.history.go(-1);
          });
        </script>";
        echo notice(0);
    } else {

      $insert = insert('tbl_kelas', "id, nama_kelas, paket, wali_kelas", "null, '$nama_kelas', '$paket', '$wali_kelas'");

      if($insert === TRUE) {
        echo "<script>swal('Yosh!', 'Berhasil menambahkan kelas baru!', 'success');</script>";
        echo notice(1);
        echo location('kelas');
      } else {
        echo "<script>sweetAlert('Oops!', 'Gagal menambahkan kelas baru!', 'error');</script>";
        echo notice(0);
        echo location(base('admin/kelas'));
      }

    }

  }

}

?>
<script type="text/javascript">
  $("#back").click(function() {
    window.location='kelas';
  });
</script>
