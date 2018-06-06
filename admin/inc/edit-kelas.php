<?php
$id = anti_inject(@$_GET['id']);
$id = abs((int) $id);
$kelas = select('*', 'tbl_kelas', "id = '$id'");
$k = mysqli_fetch_object($kelas);
$wk = select('*', 'tbl_guru');
$paket = select('DISTINCT paket', 'tbl_kelas ORDER BY nama_kelas ASC');

?>

<div class="col-md-12">
  <h3>Edit Data Kelas</h3>
  <hr>
  <div class="col-md-6">
    <?php
      echo open_form('', 'post', "class='form-group'");
      echo label('nama_kelas', 'Nama Kelas');
      echo input('text', 'nama_kelas', "class='form-control' value='$k->nama_kelas'")."<br>";

      echo label('wali_kelas', 'Wali Kelas');
      echo select_open('wali_kelas', "class='form-control'");
      echo option('', '', '-- Pilih Wali Kelas --');
      while ($w = mysqli_fetch_object($wk)) :
        if($k->wali_kelas == $w->nama_guru){
          echo option("$w->nama_guru",  'selected', "$w->nama_guru");
        } else {
          echo option("$w->nama_guru",  '', "$w->nama_guru");
        }
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
        if($pkt->paket == $k->paket){
          echo option("$pkt->paket", 'selected', "$pkt->paket");
        } else {
          echo option("$pkt->paket", '', "$pkt->paket");
        }
      endwhile;
      echo select_close()."<br> <br>";

      echo input('submit', 'submit', "value='Simpan' class='btn btn-primary'")." &nbsp; ";
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

    $cekwal = select('*', 'tbl_kelas', "wali_kelas = '$wali_kelas'");
    $cek = mysqli_num_rows($cekwal);

    if ($cek > 0) {
      echo "<script>sweetAlert('Oops!', 'Guru tersebut sudah memiliki kelas!', 'error');</script>";
      echo notice(0);
    } else {

      $upd_guru = update("tbl_guru", "wali_kelas = 1", "nama_guru = '$wali_kelas'");

      $insert = update('tbl_kelas', "nama_kelas = '$nama_kelas', paket = '$paket', wali_kelas = '$wali_kelas'", "id = '$id'" );

      if($insert === TRUE) {
        echo "<script>swal('Yosh!', 'Berhasil memperbarui data kelas!', 'success');</script>";
        echo notice(1);
        echo location(base('admin/kelas'));
      } else {
        echo "<script>sweetAlert('Oops!', 'Gagal memperbarui data kelas!', 'error');</script>";
        echo notice(0);
        echo location(base('admin/kelas'));
      }

    }

  }

}

?>
<script type="text/javascript">
  $("#back").click(function() {
    window.location='<?= base("admin/kelas");?>';
  });
</script>
