<?php
$no = 1;
$sqlg = select('*', "tbl_guru");

?>

<div class="col-md-8">
  <table class="table table-bordered table-striped" id="list-data">
    <thead>
      <tr>
        <th class="ctr">No.</th>
        <th class="ctr">Nama Guru</th>
        <th class="ctr">NIP</th>
        <th class="ctr">Absen Kelas</th>
        <th class="ctr">Absen Mapel</th>
      </tr>
    </thead>
    <tbody>

    <?php while ($g = mysqli_fetch_object($sqlg)) : ?>

      <tr>
        <td class="ctr"><?= $no++; ?></td>
        <td><?= $g->nama_guru; ?></td>
        <td class="ctr">
          <?php
            if(empty($g->nip)){
              echo "Belum ada NIP";
            } else {
              echo $g->nip;
            }
           ?>
        </td>
        <td class="ctr">
          <a href="absensi-kelas/<?= $g->id; ?>" class="btn btn-default">Lihat</a>
        </td>
        <td class="ctr">
          <a href="absensi-mata-pelajaran/<?= $g->id; ?>" class="btn btn-default">Lihat</a>
        </td>

      </tr>

    <?php endwhile;  ?>

    </tbody>
  </table>
</div>
<div class="col-md-4">
  <div class="panel panel-primary">
    <div class="panel-heading">
      Petunjuk
    </div>
    <div class="panel-body">
      <ul class="list-group">
        <li class="list-group-item">1. Pilih Nama guru yang akan dilihat absensi</li>
        <li class="list-group-item">2. Klik tombol <b>Lihat</b></li>
        <li class="list-group-item">3. Setelah itu akan di <i>redirect</i> ke halaman data absen harian sesuai nama guru yang dipilih </li>
        <li class="list-group-item">4. Selesai </li>
        <li class="list-group-item">
          <strong>Keterangan : </strong>
          <p>
          Absen kelas : Melihat berapa kali guru masuk ke dalam kelas yang terjadwalkan <br>
          Absen mapel : Melihat berapa kali guru masuk dalam mata pelajaran yang terjadwalkan <br>
        </p>
        </li>
      </ul>
    </div>
  </div>
</div>
