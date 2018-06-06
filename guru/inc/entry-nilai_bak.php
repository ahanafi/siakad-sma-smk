<?php
$sqlkelas = select('*', 'tbl_kelas');
$no = 1;

?>

<div class="col-md-8">
  <table class="table table-bordered" id="list-data" border="1">
    <thead>
      <tr>
        <th>No.</th>
        <th class="ctr">Nama Kelas/Rombel</th>
        <th class="ctr">Peket Keahlian</th>
        <th class="ctr">Jumlah Siswa</th>
        <th class="ctr">Opsi</th>
      </tr>
    </thead>
    <tbody>

      <?php
        while ($k = mysqli_fetch_assoc($sqlkelas)):
          $hit = hitung('tbl_siswa', "rombel = '$k[nama_kelas]'");
          $tot_siswa = mysqli_num_rows($hit);
      ?>

      <tr>
        <td><?= $no++; ?></td>
        <td class="ctr"><?= $k['nama_kelas']; ?></td>
        <td class="ctr"><?= $k['paket']; ?></td>
        <td class="ctr"><?= $tot_siswa; ?></td>
        <td>
          <a href="entry-nilai-kelas-<?= $k['id']; ?>" class="btn btn-default">Entry Nilai</a>
        </td>
      </tr>

    <?php endwhile; ?>

    </tbody>
  </table>
</div>
<div class="col-md-4">
  <div class="panel panel-primary">
    <div class="panel-heading">
      Petunjuk pengisian nilai Siswa
    </div>
    <div class="panel-body">
      <ul class="list-group">
        <li class="list-group-item">1. Pilih terlebih dahulu kelas yang akan diisi nilainya</li>
        <li class="list-group-item">2. Cari nama siswa yang akan diisi nilainya</li>
        <li class="list-group-item">3. Kemudian <strong>klik nama</strong> siswa yang akan diisi nilainya</li>
        <li class="list-group-item">4. Pilih jenis nilai yang akan diisi</li>
        <li class="list-group-item">5. Isilah nilai sesuai dengan format yang ada</li>
        <li class="list-group-item">6. Klik <strong>Simpan</strong> jika sudah selesai</li>
      </ul>
    </div>
  </div>
</div>
