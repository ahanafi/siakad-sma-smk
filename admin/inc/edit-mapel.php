<?php
$id = anti_inject(@$_GET['id']);
$id = abs((int) $id);
$kel = select('*', 'kelompok_mapel');
$mpl = select('*', 'tbl_mapel', "id='$id'");
$kls = select('DISTINCT(kelas)', 'tbl_mapel');
$jur = select("DISTINCT(paket)", "tbl_kelas ORDER BY paket");
$map = mysqli_fetch_object($mpl);
?>

<div class="col-md-12">
  <?php
    echo open_form('', 'post', "class='form-group'");
    echo label('kode_mapel', "Kode Mata Pelajaran");
    echo input('text', 'kode_mapel', "class='form-control' value='$map->kode_mapel'")."<br>";

    echo label('nama_mapel', 'Nama Mata Pelajaran');
    echo input('text', 'nama_mapel', "class='form-control' value='$map->nama_mapel'")."<br>";

    echo label('kelas', 'Kelas');
    echo select_open('kelas', "class='form-control'");
    echo option('','','-- Pilih Kelas --');
    while ($cls = mysqli_fetch_object($kls)) :
      if ($map->kelas == $cls->kelas) {
        echo option($cls->kelas, 'selected', $cls->kelas);
      } else {
        echo option($cls->kelas, '', $cls->kelas);
      }
    endwhile;
    echo select_close()."</br>";

    echo label('kelompok', 'Kelompok Mata Pelajaran');
    echo select_open('kelompok_mapel', "class='form-control'");
    echo option('', '', '-- Pilih Kelompok Mata Pelajaran --');
    while ($km = mysqli_fetch_assoc($kel)) :
      if ($km['kelompok'] == $map->kelompok) {
        echo option($km['kelompok'], 'selected', $km['nama_kelompok']);
      } else {
        echo option($km['kelompok'], '', $km['nama_kelompok']);
      }
    endwhile;
    echo select_close()."<br>";

    echo label('jurusan', 'Paket Keahlian');
    echo select_open('paket', "class='form-control'");
    echo option('','','-- Pilih Paket Keahlian --');
    while ($j = mysqli_fetch_assoc($jur)) :
      if ($map->paket == $j['paket']) {
        echo option($j['paket'], 'selected', $j['paket']);
      } else {
        echo option($j['paket'], '', $j['paket']);
      }
    endwhile;
    echo option('Semua', '', 'Semua Paket Keahlian');
    echo select_close()."<br>";

    echo input('submit', 'submit', "class='btn btn-primary' value='Simpan'")." &nbsp; ";
    echo input('button', 'button', "class='btn btn-default' value='Kembali' id='back'")."<br>";

    echo close_form();
  ?>
</div>
<script type="text/javascript">
  $('#back').click(function() {
    window.location='<?= base("admin/mata-pelajaran"); ?>';
  });
</script>

<?php
if (isset($_POST['submit'])) {
  $kode_mapel     = anti_inject($_POST['kode_mapel']);
  $nama_mapel     = addslashes($_POST['nama_mapel']);
  $kelas          = anti_inject($_POST['kelas']);
  $kelompok_mapel = anti_inject($_POST['kelompok_mapel']);
  $paket          = anti_inject($_POST['paket']);

  if (empty(trim($nama_mapel)) || empty(trim($kelompok_mapel))) {
    echo "<script>sweetAlert('Oops!', 'Form tidak boleh ada yang kosong!', 'error');</script>";
    echo notice(0);
  } else {
    $mapel = select('*', 'tbl_mapel', "nama_mapel = '$nama_mapel'");
    $ceknama = mysqli_num_rows($mapel);

    $update = update('tbl_mapel', "kode_mapel = '$kode_mapel', nama_mapel = '$nama_mapel', kelas = '$kelas', paket = '$paket', kelompok = '$kelompok_mapel'", "id='$id'");

    if ($update == TRUE) {
      echo "<script>sweetAlert('Yosh!', 'Berhasil mengubah data mata pelajaran!', 'success');</script>";
      echo notice(1);
      echo location(base('admin/mata-pelajaran'));
    } else {
      echo "<script>sweetAlert('Oops!', 'Gagal mengubah mata pelajaran!', 'error');</script>";
      echo notice(0);
    }
  }

}

?>
