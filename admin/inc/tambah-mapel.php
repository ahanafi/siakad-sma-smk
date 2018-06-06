<?php
$kel = select("*", 'kelompok_mapel');
$jur = select("DISTINCT(paket)", "tbl_kelas ORDER BY paket");
?>

<div class="col-md-12">
  <?php
    echo open_form('', 'post', "class='form-group'");
    echo label('kode_mapel', "Kode Mata Pelajaran");
    echo input('text', 'kode_mapel', "class='form-control'")."<br>";

    echo label('nama_mapel', 'Nama Mata Pelajaran');
    echo input('text', 'nama_mapel', "class='form-control'")."<br>";

    echo label('kelas', 'Kelas');
    echo select_open('kelas', "class='form-control'");
    echo option('', '', '-- Pilih Kelas --');
    echo option('10', '', '10');
    echo option('11', '', '11');
    echo option('12', '', '12');
    echo select_close()."</br>";

    echo label('kelompok', 'Kelompok Mata Pelajaran');
    echo select_open('kelompok_mapel', "class='form-control'");
    echo option('', '', '-- Pilih Kelompok Mata Pelajaran --');
    while ($km = mysqli_fetch_assoc($kel)) :
      echo option($km['kelompok'], '', $km['nama_kelompok']);
    endwhile;
    echo "</select>
    <br>";

    echo label('jurusan', 'Paket Keahlian');
    echo select_open('paket', "class='form-control'");
    echo option('','','-- Pilih Paket Keahlian --');
    while ($j = mysqli_fetch_assoc($jur)) :
      echo option($j['[paket'], '', $j['paket']);
    endwhile;
    echo option('Semua', '', 'Semua Paket Keahlian');
    echo select_close()."<br>";

    echo input('submit', 'submit', "class='btn btn-primary' value='Tambahkan'")." &nbsp; ";
    echo input('button', 'button', "class='btn btn-default' value='Kembali' id='back'")."<br>";

    echo close_form();
  ?>
</div>
<script type="text/javascript">
  $('#back').click(function() {
    window.location='mata-pelajaran';
  });
</script>

<?php
if (isset($_POST['submit'])) {
  $kode_mapel     = anti_inject($_POST['kode_mapel']);
  $nama_mapel     = addslashes($_POST['nama_mapel']);
  $kelas          = anti_inject($_POST['kelas']);
  $paket          = anti_inject($_POST['paket']);
  $kelompok_mapel = anti_inject($_POST['kelompok_mapel']);

  if (empty(trim($nama_mapel)) || empty(trim($kelompok_mapel)) || empty(trim($paket)) || empty(trim($kode_mapel))) {
    echo "<script>sweetAlert('Oops!', 'Form tidak boleh ada yang kosong!', 'error');</script>";
    echo notice(0);
  } else {
    $mapel = select('*', 'tbl_mapel', "kode_mapel = '$kode_mapel'");
    $cekkode = mysqli_num_rows($mapel);

    if ($cekkode > 0) {
      echo "<script>sweetAlert('Oops!', 'Kode Mata Pelajaran sudah tersedia di database!', 'error');</script>";
      echo notice(0);
    } else {

      $insert = insert('tbl_mapel', 'id, kode_mapel, nama_mapel, kelas, paket, kelompok', "NULL, '$kode_mapel', '$nama_mapel', '$kelas', '$paket', '$kelompok_mapel'");

      if ($insert == TRUE) {
        echo "<script>sweetAlert('Yosh!', 'Berhasil menambahkan mata pelajaran baru!', 'success');</script>";
        echo notice(1);
        echo location(base('admin/mata-pelajaran'));
      } else {
        echo "<script>sweetAlert('Oops!', 'Gagal menambahkan mata pelajaran baru!', 'error');</script>";
        echo notice(0);
      }

    }

  }

}

?>
