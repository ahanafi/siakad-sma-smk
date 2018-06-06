<?php

$sqlrom = select('*', 'tbl_kelas');

?>

<style media="screen">
  .col-md-6{
    padding-bottom: 30px;
  }
</style>
<div class="col-md-12">
  <h3>Tambah Data Siswa</h3>
  <hr>
  <div class="col-md-6">
    <?php
      echo open_form('', 'post', "class='form-group' enctype='multipart/form-data'");
      echo label('nama', 'Nama Siswa');
      echo input('text', 'nama', "class='form-control'")."<br>";

      echo label('nisn', 'Nomor Induk Siswa Nasional');
      echo input('number', 'nisn', "class='form-control'")."<br>";

      echo label('nis', 'Nomor Induk Siswa');
      echo input('number', 'nis', "class='form-control'")."<br>";

      echo label('kelas', 'Kelas');
      ?>
      <select class="form-control" name="kelas">
        <option value="">-- Pilih Kelas --</option>
        <option value="10">X</option>
        <option value="11">XI</option>
        <option value="12">XII</option>
      </select>
    </div> <!-- end of class col-md-6 -->
    <div class="col-md-6">
      <?php
      echo label('rombel', 'Anggota Rombel');
      echo "
        <select name='rombel' class='form-control'>
          <option value=''>-- Pilih Rombongan Belajar --</option>";
          while ($rom = mysqli_fetch_object($sqlrom)) :
      echo "<option value='$rom->nama_kelas'>$rom->nama_kelas</option>";
          endwhile;
      echo "
        </select> <br>
      ";

      echo label('jk', 'Jenis Kelamin');
      echo "
        <select name='jk' class='form-control'>
          <option value=''>-- Pilih Jenis Kelamin --</option>
          <option value='L'>Laki-Laki</option>
          <option value='P'>Perempuan</option>
        </select> <br>
      ";

      echo label('foto', 'Foto');
      echo input('file', 'foto', "class='form-control'")." <br> <br>";

      echo input('submit', 'submit', "class='btn btn-primary' value='Tambahkan'")." &nbsp; ";
      echo input('button', 'back', "class='btn btn-default' id='back' value='Kembali'");

      echo close_form();
      ?>
    </div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    $("#back").click(function() {
      window.location='siswa';
    });
  });
</script>

<?php

if (isset($_POST['submit'])) {
  $nama   = addslashes($_POST['nama']);
  $nisn   = anti_inject($_POST['nisn']);
  $nis    = anti_inject($_POST['nis']);
  $kelas  = anti_inject($_POST['kelas']);
  $rombel = anti_inject($_POST['rombel']);
  $jk     = anti_inject($_POST['jk']);

  $source = $_FILES['foto']['tmp_name'];
  $target = "../images/siswa/";
  $namaft = $nis;

  if (empty(trim($nama)) || empty(trim($kelas)) || empty(trim($nama)) || empty(trim($rombel)) || empty(trim($jk)) ) {
    echo "
    <script>
        sweetAlert('Oops!', 'Form tidak boleh ada yang kosong!', 'error');

        $('button.confirm').click(function() {
          window.history.go(-1);
        });
    </script>";
    echo notice(0);
  } else {

    move_uploaded_file($source, $target.$namaft);
    $insert = insert('tbl_siswa', "id, nis, nisn, nama, kelas, rombel, jk", "NULL, '$nis', '$nisn', '$nama', '$kelas', '$rombel', '$jk'");

    if ($insert === TRUE) {
      echo "
        <script>
          swal('Yosh!', 'Tambah data siswa baru berhasil', 'success');

          $('button.confirm').click(function() {
            window.location='siswa';
          });
        </script>";
        echo notice(1);
    } else {
      echo "
      <script>
          sweetAlert('Oops!', 'Tambah Data siswa baru gagal!', 'error');

          $('button.confirm').click(function() {
            window.history.go(-1);
          });
      </script>";
      echo notice(0);
    }

  }

}

?>
