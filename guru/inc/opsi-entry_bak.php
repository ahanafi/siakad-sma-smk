<?php
$id = @$_SESSION['guru']['id'];

$sql  = "SELECT DISTINCT nama_mapel, tbl_jadwal.kelas, nama_kelas, mapel FROM tbl_jadwal ";
$sql .= " JOIN tbl_mapel ON tbl_jadwal.mapel = tbl_mapel.id ";
$sql .= " JOIN tbl_guru ON tbl_jadwal.guru = tbl_guru.id ";
$sql .= " JOIN tbl_kelas ON tbl_jadwal.kelas = tbl_kelas.id WHERE tbl_jadwal.guru = '$id' ";

$sqlkelas = $sql;
$joined = mysqli_query($link, $sql);
$kelas = mysqli_query($link, $sqlkelas);
?>

<div class="col-md-12">
  <h4>Persiapan sebelum entry nilai</h4>
  <hr>
  <div class="row">
    <div class="col-md-8">
      <?php
        echo open_form('', 'post', "class='form-group'");
        echo label('type', 'Tipe Nilai');
        echo select_open('type', "class='form-control' disabled");
        echo option('', '', '-- Pilih Tipe Nilai --');        
        echo option('harian', '', 'Nilai Harian');
        echo option('uts', '', 'Nilai Ujian Tengah Semester (UTS)');
        echo option('uas', '', 'Nilai Ujian Akhir Semester (UAS)');
        echo option('rapot','selected', 'Nilai Rapot');
        echo select_close()."<br>";

        echo label('mapel', 'Mata Pelajaran');
        echo select_open('pil_mapel', "class='form-control' id='setmpl'");
        echo option('','', '-- Pilih Mata Pelajaran --');
        while ($m = mysqli_fetch_object($joined)) :
          echo option($m->mapel, '', $m->nama_mapel);
        endwhile;
        echo select_close()."<br>";

        echo label('kelas', 'Kelas');
        echo select_open('pil_kelas', "class='form-control'");
        echo option('','', '-- Pilih Kelas --');
        while ($k = mysqli_fetch_object($kelas)) :
          echo option($k->nama_kelas, '', $k->nama_kelas);
        endwhile;
        echo select_close()."<br>";

        echo input('submit', 'submit', "class='btn btn-primary' value='Entry Sekarang!'");
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
            <li class="list-group-item"><strong>1.</strong> Tentukan terlebih dahulu <strong>Tipe</strong> nilai yang akan diisi</li>
            <li class="list-group-item"><strong>2.</strong> Kemudian pilih <strong>Mata Pelajaran</strong></li>
            <li class="list-group-item"><strong>3.</strong> Selanjutnya pilih <strong>Kelas</strong> mana yang akan diisi nialinya</li>
            <li class="list-group-item"><strong>4.</strong> Klik tombol <strong>Entry Sekarang</strong></li>
            <li class="list-group-item"><strong>5.</strong> Mulailah mengisi nilai </li>
          </ul>
        </div>
      </div>
    </div> <!-- end of class col-md-4 -->
  </div> <!-- end of class row -->
</div> <!-- end of class col-md-12 -->

<?php
if (isset($_POST['submit'])) {
  $mapel  = addslashes($_POST['pil_mapel']);
  $kelas  = anti_inject($_POST['pil_kelas']);

  if (empty(trim($mapel)) || empty(trim($kelas))) {
    echo "<script>sweetAlert('Oops!', 'Form harus diisi semua!', 'error')</script>";
    echo location('opsi-entry');
  } else {

    //Membuat session kelas, dan mapel
    //@$_SESSION['kelas_id']   = $kelas;
    @$_SESSION['nama_kelas']   = $kelas;
    @$_SESSION['mapel_id']   = $mapel;
    //@$_SESSION['type_nilai'] = $type;
    redirect('input-nilai-rapot');
  }
}


?>
