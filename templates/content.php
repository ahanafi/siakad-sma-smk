<?php
$hari = date('w');
$waktu = date('H');
$waktu = $waktu.":".date("i:s");
$jsql = select('*', 'tbl_jadwal', "ds= '0' AND hari = '$hari' AND '$waktu' BETWEEN jam_mulai AND jam_selesai");
$cekdata = mysqli_num_rows($jsql);
$sqlcek = select("*", "tbl_jadwal");
$cekjadwal = mysqli_num_rows($sqlcek);
?>

<table class="table table-striped table-bordered">

  <?php
  if ($cekjadwal > 0) {

    if ($cekdata > 0) {
        while ($j = mysqli_fetch_assoc($jsql)) :

          //Pecah jam mulai
          $j['jam_mulai'] = explode(":", $j['jam_mulai']);
          $j['jam_mulai'] = $j['jam_mulai'][0].":".$j['jam_mulai'][1];

          //Pecah jam selesai
          $j['jam_selesai'] = explode(":", $j['jam_selesai']);
          $j['jam_selesai'] = $j['jam_selesai'][0].":".$j['jam_selesai'][1];

          //Table Guru
          $gsql = select('nama_guru', 'tbl_guru', "id = '$j[guru]'");
          $g = mysqli_fetch_assoc($gsql);

          //Table Mapel
          $msql = select('nama_mapel', 'tbl_mapel', "id = '$j[mapel]'");
          $m = mysqli_fetch_assoc($msql);

          //Table Kelas
          $ksql = select('nama_kelas', 'tbl_kelas', "id = '$j[kelas]'");
          $k = mysqli_fetch_assoc($ksql);

          //Table Kehadiran
          $khdsql = select('nama_kehadiran, warna', 'tbl_kehadiran', "id = '$j[kehadiran]'");
          $khd = mysqli_fetch_assoc($khdsql);
    ?>
    <tr>
      <td><?= $j['jam_mulai']." - ".$j['jam_selesai']; ?></td>
      <td><?= $g['nama_guru']; ?></td>
      <td><?= $m['nama_mapel']; ?></td>
      <td><?= $k['nama_kelas']; ?></td>
      <td>
        <div style="margin-left:20px;width:30px;height:30px;background:#<?= $khd['warna'];?>"></div>
      </td>
    </tr>

    <?php
        endwhile;
      } else {
        echo "<td colspan='5' style='background:#fff;text-align:center;font-weight:bold;font-size:18px;'>Tidak ada data!</td>";
      }

    } else {
      echo "
      <td colspan='5' style='background:#fff;text-align:center;font-weight:bold;font-size:18px;'>
        Data jadwal belum terisi! Silahkan input untuk menampilkan jadwal
      </td>";
    }
  ?>

</table>
