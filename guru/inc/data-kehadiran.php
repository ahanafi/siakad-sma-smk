<?php
$id = @$_SESSION['guru']['id'];
$kelas = select("DISTINCT nama_guru, kelas, idg", "tbl_rekap", "idg = '$id'");
$mapel = select("DISTINCT nama_guru, mapel, idg", "tbl_rekap", "idg = '$id'");
$no = 1;
$numb = $no;
$nomor = $numb;
?>

<div class="col-md-12">
  <div class="row">
    <ul class="nav nav-tabs" role="tablist">
      <li role="presentation" class="active">
        <a href="#harian" aria-controls="home" role="tab" data-toggle="tab">Absensi Harian</a>
      </li>
      <li role="presentation">
        <a href="#kelas" aria-controls="home" role="tab" data-toggle="tab">Absensi Kelas</a>
      </li>
      <li role="presentation">
        <a href="#mapel" aria-controls="home" role="tab" data-toggle="tab">Absensi Mata Pelajaran</a>
      </li>
    </ul>

    <div class="tab-content">
      <!-- for ID harian -->
      <div role="tabpanel" class="tab-pane active" id="harian">
        <table class="table table-bordered" id="list-data">
          <thead>
            <tr>
              <th>No.</th>
              <th>Hari</th>
              <th>Tanggal</th>
              <th>Jam Masuk</th>
              <th>Jam Pulang</th>
            </tr>
          </thead>
          <tbody>

          <?php while ($g = mysqli_fetch_object($data)) : ?>

            <tr>
              <td><?= $no++; ?></td>
              <td><?= $g->hari; ?></td>
              <td><?= $g->tanggal; ?></td>
              <td><?= $g->jam_msk; ?></td>
              <td><?= $g->jam_plg; ?></td>
            </tr>

          <?php endwhile; ?>

          </tbody>
        </table>

      </div>

      <!-- for ID kelas -->
      <div role="tabpanel" class="tab-pane" id="kelas">
        <table class="table table-bordered" id="list-data" border="1">
          <thead>
            <tr>
              <th rowspan="2" class="ctr">No.</th>
              <th rowspan="2" class="ctr">Kelas</th>
              <th colspan="5" class="ctr">Kehadiran</th>
            </tr>
            <tr>
              <th class="ctr">Hadir</th>
              <th class="ctr">Izin</th>
              <th class="ctr">Sakit</th>
              <th class="ctr">Tugas</th>
              <th class="ctr">Lain</th>
            </tr>
          </thead>
          <tbody>

          <?php
            while ($x = mysqli_fetch_object($kelas)):

              //Menghitung jumlah absen
              $c_hdr = hitung_absen("kehadiran", "tbl_rekap", "kelas='$x->kelas' AND idg = '$x->idg' AND kehadiran = 1");
              $thdr = mysqli_fetch_object($c_hdr);

              $c_izn = hitung_absen("kehadiran", "tbl_rekap", "kelas='$x->kelas' AND idg = '$x->idg' AND kehadiran = 2");
              $tizn = mysqli_fetch_object($c_izn);

              $c_tgs = hitung_absen("kehadiran", "tbl_rekap", "kelas='$x->kelas' AND idg = '$x->idg' AND kehadiran = 3");
              $ttgs = mysqli_fetch_object($c_tgs);

              $c_skt = hitung_absen("kehadiran", "tbl_rekap", "kelas='$x->kelas' AND idg = '$x->idg' AND kehadiran = 4");
              $tskt = mysqli_fetch_object($c_skt);

              $c_ln = hitung_absen("kehadiran", "tbl_rekap", "kelas='$x->kelas' AND idg = '$x->idg' AND kehadiran = 5");
              $tln = mysqli_fetch_object($c_ln);

          ?>

            <tr>
              <td class="ctr"><?= $numb++; ?></td>
              <td class="ctr"><?= $x->kelas; ?></td>
              <td class="ctr"><?= $thdr->jumlah; ?></td>
              <td class="ctr"><?= $tizn->jumlah; ?></td>
              <td class="ctr"><?= $tskt->jumlah; ?></td>
              <td class="ctr"><?= $ttgs->jumlah; ?></td>
              <td class="ctr"><?= $tln->jumlah; ?></td>
            </tr>

          <?php endwhile; ?>

          </tbody>
        </table>
      </div>

      <!-- for ID mapel -->
      <div role="tabpanel" class="tab-pane" id="mapel">
        <table class="table table-bordered" id="list-data">
          <thead>
            <tr>
              <th rowspan="2" class="ctr">No.</th>
              <th rowspan="2" class="ctr">Mata Pelajaran</th>
              <th colspan="5" class="ctr">Kehadiran</th>
            </tr>
            <tr>
              <th class="ctr">Hadir</th>
              <th class="ctr">Izin</th>
              <th class="ctr">Sakit</th>
              <th class="ctr">Tugas</th>
              <th class="ctr">Lain</th>
            </tr>
          </thead>
          <tbody>

          <?php
            while ($x = mysqli_fetch_object($mapel)):

              //Menghitung jumlah absen
              $c_hdr = hitung_absen("kehadiran", "tbl_rekap", "mapel='$x->mapel' AND idg = '$x->idg' AND kehadiran = 1");
              $thdr = mysqli_fetch_object($c_hdr);

              $c_izn = hitung_absen("kehadiran", "tbl_rekap", "mapel='$x->mapel' AND idg = '$x->idg' AND kehadiran = 2");
              $tizn = mysqli_fetch_object($c_izn);

              $c_tgs = hitung_absen("kehadiran", "tbl_rekap", "mapel='$x->mapel' AND idg = '$x->idg' AND kehadiran = 3");
              $ttgs = mysqli_fetch_object($c_tgs);

              $c_skt = hitung_absen("kehadiran", "tbl_rekap", "mapel='$x->mapel' AND idg = '$x->idg' AND kehadiran = 4");
              $tskt = mysqli_fetch_object($c_skt);

              $c_ln = hitung_absen("kehadiran", "tbl_rekap", "mapel='$x->mapel' AND idg = '$x->idg' AND kehadiran = 5");
              $tln = mysqli_fetch_object($c_ln);

          ?>

            <tr>
              <td class="ctr"><?= $nomor++; ?></td>
              <td class="ctr"><?= $x->mapel; ?></td>
              <td class="ctr"><?= $thdr->jumlah; ?></td>
              <td class="ctr"><?= $tizn->jumlah; ?></td>
              <td class="ctr"><?= $tskt->jumlah; ?></td>
              <td class="ctr"><?= $ttgs->jumlah; ?></td>
              <td class="ctr"><?= $tln->jumlah; ?></td>
            </tr>

          <?php endwhile; ?>

          </tbody>
        </table>

      </div>
    </div>
  </div>
</div>
