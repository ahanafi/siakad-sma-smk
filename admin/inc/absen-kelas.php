<?php
$idg = anti_inject(@$_GET['id']);
$idg = abs((int) $idg);
$kelas = select("DISTINCT nama_guru, kelas, idg", "tbl_rekap", "idg = '$idg'");
$no = 1;

$data = select('*', 'tbl_guru', "id='$idg'");
$detail = mysqli_fetch_object($data);

?>

<script type="text/javascript">
  $(document).ready(function() {
    $(".row > .col-sm-6:first").append('<a href="<?= base('admin/rekap-absensi'); ?>" class="btn btn-primary">Kembali</a>  ');
    $(".row > .col-sm-6:first").append('   <a href="export.php?data=absensi-kelas&id=<?= $idg; ?>" class="btn btn-default">Export Ms. Excel</a>');
  });
</script>
<div class="col-md-8">
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
        <td class="ctr"><?= $no++; ?></td>
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
<div class="col-md-4">
  <div class="panel panel-primary">
    <div class="panel-heading">
      Detal Guru
    </div>
    <div class="panel-body">
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
    </div> <!-- end of class panel-body -->
  </div> <!-- end of class panel -->
</div>
