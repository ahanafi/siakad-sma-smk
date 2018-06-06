<?php

$id = @$_GET['id'];

$sqlj = select('*', 'tbl_jadwal', "id = '$id'");
$j = mysqli_fetch_assoc($sqlj);

$sqlhari  = select('*', 'tbl_hari');
$sqlkelas = select('*', 'tbl_kelas');
$sqlmapel = select('*', 'tbl_mapel');
$sqlguru  = select('*', 'tbl_guru');
$sqlhadir  = select('*', 'tbl_kehadiran');

?>
<style media="screen">
  .col-md-6{
    padding-bottom: 30px;
  }
</style>
<script type="text/javascript" src="<?= base('assets/js/result.js'); ?>"></script>
<div class="col-md-12">
  <h3>Edit Jadwal</h3>
  <hr>

  <?php echo open_form('', 'post', "class='form-group'"); ?>

    <div class="col-md-6">
      <?php echo label('hari', 'Hari');  ?>

      <select class="form-control" name="hari">
        <option value="">-- Pilih Hari --</option>

        <?php
          while ($h = mysqli_fetch_assoc($sqlhari)) :
          if ($j['hari'] == $h['id']) { ?>

          <option value="<?= $h['id']; ?>" selected><?= $h['nama_hari']; ?></option>

          <?php } else { ?>

          <option value="<?= $h['id']; ?>"><?= $h['nama_hari']; ?></option>

          <?php } ?>

        <?php endwhile; ?>
      </select>
      <br>

      <label for="kelas">Kelas</label>
      <select class="form-control" name="kelas">
        <option value="">-- Pilih Kelas --</option>

        <?php
        while ($k = mysqli_fetch_assoc($sqlkelas)):
          if ($j['kelas'] == $k['id']) { ?>
            <option value="<?= $k['nama_kelas']; ?>" selected><?= $k['nama_kelas']; ?></option>
          <?php } else { ?>
            <option value="<?= $k['nama_kelas']; ?>"><?= $k['nama_kelas']; ?></option>
        <?php } endwhile; ?>

      </select>
      <br>

      <label for="jam_mulai">Jam Mulai</label>
      <?php echo input('time', 'jam_mulai', "class='form-control' placeholder='JJ:mm:dd' value='$j[jam_mulai]'"); ?>
      <br>

      <label for="kehadiran">Kehadiran</label>
      <select class="form-control" name="kehadiran">
        <option value="">-- Pilih Kehadiran --</option>

        <?php
          while ($hd = mysqli_fetch_assoc($sqlhadir)):
            if ($j['kehadiran'] == $hd['id']) {
              echo "<option value='$hd[id]' selected>$hd[nama_kehadiran]</option>";
            } else {
              echo "<option value='$hd[id]'>$hd[nama_kehadiran]</option>";
            }
        endwhile; ?>

      </select>
    </div> <!-- end of class col-md-6 -->
    <div class="col-md-6">
      <label for="mapel">Mata Pelajaran</label>
      <select class="form-control" name="mapel">
        <option value="">-- Pilih Mata Pelajaran --</option>

        <?php
          while ($m = mysqli_fetch_assoc($sqlmapel)):
            if ($j['mapel'] == $m['id']) {
              echo "<option value='$m[id]' selected>$m[nama_mapel]             ($m[kode_mapel])</option>";
            } else {
              echo "<option value='$m[id]'>$m[nama_mapel]             ($m[kode_mapel])</option>";
            }
        ?>
      <?php endwhile; ?>

      </select>
      <br>

      <label for="guru">Guru</label>
      <select class="form-control" name="guru">
        <option value="">-- Pilih Guru --</option>

        <?php
          while ($g = mysqli_fetch_assoc($sqlguru)):
            if ($j['guru'] == $g['id'] ) {
              echo "<option value='$g[id]' selected>$g[nama_guru]</option>";
            } else {
              echo "<option value='$g[id]'>$g[nama_guru]</option>";
            }
        ?>
        <?php endwhile; ?>

      </select>
      <br>

      <label for="jam_selesai">Jam Selesai</label>
      <?php echo input('time', 'jam_selesai', "class='form-control' placeholder='JJ:mm:dd' value='$j[jam_selesai]'"); ?>
      <br>
      <br>

      <div class="row">
        <div class="col-sm-6">
          <?php echo input('submit', 'submit', "class='btn btn-primary form-control' value='Simpan'") ?>
        </div>
        <div class="col-sm-6">
          <a href="<?= base('admin/jadwal'); ?>" class="btn btn-default form-control">Batalkan</a>
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

    $sqlcls = select("id", "tbl_kelas", "nama_kelas = '$kelas' LIMIT 1");
    $cls = mysqli_fetch_assoc($sqlcls);
    $clsid = $cls['id'];

    $update = update('tbl_jadwal', "hari = '$hari', mapel = '$mapel', kelas = '$clsid', guru = '$guru', jam_mulai = '$jam_mli', jam_selesai = '$jam_sls'", "id = '$id'");

    if ($update === TRUE) {
      echo "<script>swal('Yosh!', 'Berhasil menyimpan data jadwal!', 'success');</script>";
      echo notice(1);
    } else {
      echo "<script>sweetAlert('Oops!', 'Gagal menyimpan data jadwal!', 'error');</script>";
      echo notice(0);
    }

  }

}

?>

<script type="text/javascript">
  $('button.confirm').click(function() {
    window.location="<?= base('admin/jadwal'); ?>";
  });
</script>
