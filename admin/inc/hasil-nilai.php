<?php

if (isset($_POST['submit'])) {
  $nilai = anti_inject($_POST['nilai']);
  $kelas = anti_inject($_POST['kelas']);
  $mapel = anti_inject($_POST['mapel']);

  if (empty(trim($nilai)) || empty(trim($kelas)) || empty(trim($mapel))) {
    echo "<script>sweetAlert('Oops!', 'Form tidak boleh kosong!', 'error');</script>";
    echo location('nilai');
  } else {

    $sqlkelas = select('*', 'tbl_kelas', "id = $kelas");
    $sqlmapel = select('*', 'tbl_mapel', "id = $mapel");
    $kls = mysqli_fetch_object($sqlkelas);
    $mpl = mysqli_fetch_object($sqlmapel);

    if ($nilai == "harian") {
      $sql  = "SELECT * FROM tbl_nilai_harian JOIN tbl_kelas ON tbl_nilai_harian.id_kelas = tbl_kelas.id WHERE id_kelas = '$kelas' AND id_mapel = '$mapel' ";
    } else if($nilai == "uas") {
      $sql  = "SELECT * FROM tbl_nilai_uas JOIN tbl_kelas ON tbl_nilai_uas.id_kelas = tbl_kelas.id WHERE id_kelas = '$kelas' AND id_mapel = '$mapel' ";
    } else if($nilai == "uts") {
      $sql  = "SELECT * FROM tbl_nilai_uts JOIN tbl_kelas ON tbl_nilai_uts.id_kelas = tbl_kelas.id WHERE id_kelas = '$kelas' AND id_mapel = '$mapel' ";
    } else {
      redirect('nilai');
    } //end if nilai

      $exc = mysqli_query($link, $sql);
      $no = 1;

?>

<div class="col-md-12">
  <a href="nilai" class="btn btn-primary">Kembali</a>
  <br> <br>
  <table class="table table-striped">
    <tr>
      <td>Tipe Nilai</td>
      <td>:</td>
      <td><?= "NILAI ".strtoupper($nilai); ?></td>
    </tr>
    <tr>
      <td>Kelas</td>
      <td>:</td>
      <td><?= $kls->nama_kelas; ?></td>
    </tr>
    <tr>
      <td>Wali Kelas</td>
      <td>:</td>
      <td><?= $kls->wali_kelas; ?></td>
    </tr>
    <tr>
      <td>Mata Pelajaran</td>
      <td>:</td>
      <td><?= $mpl->nama_mapel; ?></td>
    </tr>
  </table>
  <br>

  <?php  if (mysqli_num_rows($exc) > 0) {

      if($nilai == "uas" || $nilai == "uts"){ ?>

  <table class="table table-bordered" id="list-data">
    <thead>
      <tr>
        <th rowspan="2" class="ctr">No.</th>
        <th rowspan="2" class="ctr">Nama Siswa</th>
        <th colspan="2" class="ctr">Pengetahuan</th>
        <th colspan="2" class="ctr">Keterampilan</th>
        <th rowspan="2" class="ctr">Aksi</th>
      </tr>
      <tr>
        <th class="ctr">Angka</th>
        <th class="ctr">Predikat</th>
        <th class="ctr">Angka</th>
        <th class="ctr">Predikat</th>
      </tr>
    </thead>
    <tbody>

      <?php
        while ($nh = mysqli_fetch_object($exc)):

          $sqlsiswa = select('*', 'tbl_siswa', "id = '$nh->id_siswa'");
          $sis = mysqli_fetch_object($sqlsiswa);

        ?>

      <tr>
        <td class="ctr"><?= $no++; ?></td>
        <td><?= $sis->nama; ?></td>
        <td class="ctr"><?= $nh->p_angka; ?></td>
        <td class="ctr"><?= $nh->p_predikat; ?></td>
        <td class="ctr"><?= $nh->k_angka; ?></td>
        <td class="ctr"><?= $nh->k_predikat; ?></td>
        <td class="ctr">
          <a href="#" class="btn btn-default">
            <span class="glyphicon glyphicon-pencil"></span>
          </a>
        </td>
      </tr>

    <?php endwhile; ?>

    </tbody>
  </table>

  <?php } else { ?>

    <table class="table table-bordered" id="list-data">
      <thead>
        <tr>
          <th rowspan="2" class="ctr">No.</th>
          <th rowspan="2" class="ctr">Nama Siswa</th>
          <th colspan="6" class="ctr">Nilai</th>
          <th rowspan="2" class="ctr">Aksi</th>
        </tr>
        <tr>
          <th class="ctr">Nilai 1</th>
          <th class="ctr">Nilai 2</th>
          <th class="ctr">Nilai 3</th>
          <th class="ctr">Nilai 4</th>
          <th class="ctr">Nilai 5</th>
          <th class="ctr">Nilai 6</th>
        </tr>
      </thead>
      <tbody>

        <?php
          while ($nh = mysqli_fetch_object($sql)) :
            $sqlsiswa = select('*', 'tbl_siswa', "id = '$nh->id_siswa'");
            $sis = mysqli_fetch_object($sqlsiswa);
        ?>

        <tr>
          <td class="ctr"><?= $no++; ?></td>
          <td><?= $sis->nama; ?></td>
          <td class="ctr"><?= $nh->nilai1; ?></td>
          <td class="ctr"><?= $nh->nilai2; ?></td>
          <td class="ctr"><?= $nh->nilai3; ?></td>
          <td class="ctr"><?= $nh->nilai4; ?></td>
          <td class="ctr"><?= $nh->nilai5; ?></td>
          <td class="ctr"><?= $nh->nilai6; ?></td>
          <td class="ctr">
            <a href="#" class="btn btn-default">
              <span class="glyphicon glyphicon-pencil"></span>
            </a>
          </td>
        </tr>

      <?php endwhile; ?>

      </tbody>
    </table>

  <?php } ?>

<?php
      } else {
        echo "
          <div class='alert alert-danger'>
            <strong>Oops!. . . </strong> Tidak ada data nilai yang ditampilkan!
            Klik <strong class='redirect'>Disini</strong> untuk entry nilai
          </div>";
      }
    } //end if empty

} else {
    redirect('nilai');
} //end if isset

?>

</div>
<script type="text/javascript">
  $(document).ready(function() {
    $(".redirect").css({
      'cursor':'pointer'
    });
    $(".redirect").click(function() {
      window.location='entry-nilai'
    });
  });
</script>
