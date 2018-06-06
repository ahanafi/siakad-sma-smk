<?php
include_once '../function/core.php';

if (isset($_GET['data'])) {
  
  $data = @$_GET['data'];
  $id = @$_GET['id'];
  header("Content-Type: application/vnd-ms-excel");

  header("Content-Disposition: attachment; filename=Data_".$data."_".date('Y_m_d').".xls");

  if ($data == "jadwal") {
    include_once 'inc/jadwal.php';
  } else if($data == "siswa") {
    include_once 'inc/siswa.php';
  } else if($data == "detail_kelas") {
    include_once 'inc/detail-kelas.php';
  } else if($data == "kelas") {
    include_once 'inc/kelas.php';
  } else if($data == "guru") {
    include_once 'inc/guru.php';
  } else if($data == "mapel") {
    include_once 'inc/mapel.php';
  } else if($data == "rekap-harian") {
    $guru = gabung('tbl_harian','tbl_guru', 'tbl_harian.idg = tbl_guru.id', "tbl_harian.idg='$id'");
    $detail = mysqli_fetch_object($guru);
    $no =1;
  ?>

    <h3>Rekap Data Absen Harian</h3>
    <hr>
    <div class="row">
      <div class="col-md-4">
        <table class="table">
          <tr>
            <td>Nama</td>
            <td>:</td>
            <td><?= $detail->nama_guru; ?></td>
          </tr>
          <tr>
            <td>NIP</td>
            <td>:</td>
            <td><?= $detail->nip; ?></td>
          </tr>
          <tr>
            <td>No. ID Card</td>
            <td>:</td>
            <td><?= $detail->id_card; ?></td>
          </tr>
        </table>
      </div>
      <div class="col-md-8">
        <table class="table table-bordered table-striped" id="list-data" border="1">
          <thead>
            <tr>
              <th>No</th>
              <th>Hari</th>
              <th>Tanggal</th>
              <th>Jam Masuk</th>
              <th>Jam Pulang</th>
            </tr>
          </thead>
          <tbody>

          <?php while ($hr = mysqli_fetch_object($guru)) : ?>

            <tr>
              <td><?= $no++; ?></td>
              <td><?= $hr->hari; ?></td>
              <td><?= $hr->tanggal; ?></td>
              <td><?= $hr->jam_msk; ?></td>
              <td><?= $hr->jam_plg; ?></td>
            </tr>

          <?php endwhile; ?>

          </tbody>
        </table>
      </div>

  <?php
  } else if($data == "absensi-kelas") {
    include_once 'inc/absen-kelas.php';
  } else {
    redirect(base('admin/dashboard'));
  }
} else {
  redirect(base('admin/dashboard'));
}
?>
