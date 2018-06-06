<?php
//Selecting all data
$sqlhari  = select('*', 'tbl_hari');
$sqlkelas = select('*', 'tbl_kelas');
//$sqlmapel = select('*', 'tbl_mapel');
$sqlguru  = select('*', 'tbl_guru', "jenis_ptk = 'Guru' OR jenis_ptk = 'Guru Mapel'");
$sqlhadir  = select('*', 'tbl_kehadiran');
?>
<style media="screen">
  .col-md-6{
    padding-bottom: 30px;
  }
</style>
<script type='text/javascript'>
  $(function(){
    $("select[name=kelas]").change(function(){
      var kelas = $("select[name=kelas] option:selected").val();
      var elemn = $("select[name=mapel]");
      $("select[name=mapel] > option").remove();
      $("select[name=mapel]").append("<option value=''>-- Pilih Mata Pelajaran -- </option>");

      if (kelas == "") {
        sweetAlert('Oops!', 'Mohon pilih kelas terlebih dahulu!', 'error');
      } else {
        $.ajax({
          method  : "POST",
          url     : "result.php?q=kelas",
          cache   : false,
          async   : true,
          data    : {
            kelas : kelas
          },
          success : function(psn){
            var data = JSON.parse(psn);
            //elemn.append("<option value=''>-- Pilih Mata Pelajaran --</option>");
            $.each(data, function(i,n){
              elemn.append("<option value='"+n.id+"'>"+n.nama_mapel+"</option>");
            });
          }
        });
      }
    });

    $("select[name=mapel]").click(function(){
      var kelas = $("select[name=kelas] option:selected").val();
      if (kelas == "") {
        sweetAlert('Oops!', 'Mohon pilih kelas terlebih dulu!', 'error');
      }
    });
  });
</script>
<div class="col-md-12">
  <h3>Tambah Jadwal Baru</h3>
  <hr>

  <?php echo open_form('', 'post', "class='form-group'"); ?>

    <div class="col-md-6">
      <?php echo label('hari', 'Hari');  ?>

      <select class="form-control" name="hari">
        <option value="">-- Pilih Hari --</option>

        <?php while ($h = mysqli_fetch_assoc($sqlhari)) : ?>

          <option value="<?= $h['id']; ?>"><?= $h['nama_hari']; ?></option>

        <?php endwhile; ?>
      </select>
      <br>

      <label for="kelas">Kelas</label>
      <select class="form-control" name="kelas">
        <option value="">-- Pilih Kelas --</option>

        <?php while ($k = mysqli_fetch_assoc($sqlkelas)): ?>

        <option value="<?= $k['nama_kelas']; ?>"><?= $k['nama_kelas']; ?></option>

        <?php endwhile; ?>

      </select>
      <br>

      <label for="jam_mulai">Jam Mulai</label>
      <?php echo input('time', 'jam_mulai', "class='form-control' placeholder='JJ:mm:dd'"); ?>
      <br>

      <label for="kehadiran">Kehadiran</label>
      <select class="form-control" name="kehadiran" disabled>
        <option value="">-- Pilih Kehadiran --</option>
      </select>
    </div> <!-- end of class col-md-6 -->
    <div class="col-md-6">
      <label for="mapel">Mata Pelajaran</label>
      <select class="form-control" name="mapel">
        <option value="">-- Pilih Mata Pelajaran --</option>
      </select>
      <br>

      <label for="guru">Guru</label>
      <select class="form-control" name="guru">
        <option value="">-- Pilih Guru --</option>

        <?php while ($g = mysqli_fetch_assoc($sqlguru)): ?>

        <option value="<?= $g['id']; ?>"><?= $g['nama_guru']; ?></option>

        <?php endwhile; ?>

      </select>
      <br>

      <label for="jam_selesai">Jam Selesai</label>
      <?php echo input('time', 'jam_selesai', "class='form-control' placeholder='JJ:mm:dd'"); ?>
      <br>
      <br>

      <div class="row">
        <div class="col-sm-6">
          <?php echo input('submit', 'submit', "class='btn btn-primary form-control' value='Tambahkan'") ?>
        </div>
        <div class="col-sm-6">
          <a href="jadwal" class="btn btn-default form-control">Batalkan</a>
        </div>
      </div>
    </div>
</div>

<?php

if (isset($_POST['submit'])) {
  $hari   = anti_inject($_POST['hari']);
  $mapel  = anti_inject($_POST['mapel']);
  $kelas  = anti_inject($_POST['kelas']);
  $guru   = anti_inject($_POST['guru']);
  $jam_mli= anti_inject($_POST['jam_mulai']);
  $jam_sls= anti_inject($_POST['jam_selesai']);

  if (empty(trim($hari)) || empty(trim($mapel)) || empty(trim($kelas)) || empty(trim($guru)) || empty(trim($jam_mli)) || empty(trim($jam_sls))) {
    echo "<script>sweetAlert('Oops!', 'Form tidak boleh ada yang kosong!', 'error');</script>";
    echo notice(0);
  } else {
    $sqlidkls = select("id", "tbl_kelas", "nama_kelas = '$kelas'");
    $idkls = mysqli_fetch_object($sqlidkls);
    $id_kelas = $idkls->id;

    $insert = insert('tbl_jadwal', 'id, hari, mapel, kelas, guru, jam_mulai, jam_selesai', "NULL, '$hari', '$mapel', '$id_kelas', '$guru', '$jam_mli', '$jam_sls'");

    if ($insert === TRUE) {
      echo "<script>swal('Yosh!', 'Berhasil menambahkan jadwal baru!', 'success');</script>";
      echo notice(1);
      echo location(base('admin/jadwal'));
    } else {
      echo "<script>sweetAlert('Oops!', 'Gagal menambahkan jadwal baru!', 'error');</script>";
      echo notice(0);
    }

  }

}

?>
