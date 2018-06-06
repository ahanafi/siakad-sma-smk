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
        <th class="ctr">Opsi</th>
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
          <a href="rekap-harian/<?= $g->id; ?>" class="btn btn-default">Lihat</a>
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
        <li class="list-group-item">1. Pilih Nama guru yang akan dilihat absensi hariannya</li>
        <li class="list-group-item">2. Klik tombol <b>Lihat</b></li>
        <li class="list-group-item">3. Setelah itu akan di <i>redirect</i> ke halaman data absen harian sesuai nama guru yang dipilih </li>
        <li class="list-group-item">4. Selesai </li>
      </ul>
    </div>
  </div>
</div>
