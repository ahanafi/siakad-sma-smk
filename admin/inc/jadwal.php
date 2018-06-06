<?php
include_once '../function/core.php';
$hari = date('N');
$no = 1;
$lv = @$_SESSION['adm']['super'];

//Queries
$jadwal = select('*', 'tbl_jadwal', "ds = 0 ORDER BY hari DESC");
?>
 <style media="screen">
   table.dataTable{
     width: 110% !important;
  }
 </style>
 <script type="text/javascript">
   $(document).ready(function() {
     $(".row > .col-sm-6:first").append(
       '<a href="tambah-jadwal" class="btn btn-primary">Tambah Jadwal Baru</a>'
     );

     $(".row > .col-sm-6:first").append(' <a href="export.php?data=jadwal" class="btn btn-default">Export Ms. Excel</a>');
   });
 </script>
<div class="col-md-12">
    <h3>Data Jadwal</h3>
  <hr>
  <div class="scroll">
    <table class="table table-striped table-bordered" id="list-data" border="1px">
    <thead>
      <tr>
        <th class="ctr">No.</th>
        <th class="ctr">Hari</th>
        <th class="ctr">Kelas</th>
        <th>Mapel</th>
        <th>Guru</th>
        <th>Jam Mulai</th>
        <th>Jam Selesai</th>
        <th>Kehadiran</th>
        <th width="280px;" class="ctr">Opsi</th>
        <th width="100px;" class="ctr">Aksi</th>
      </tr>
    </thead>
    <tbody>

      <?php
      if (mysqli_num_rows($jadwal) != 0):

        while ($j = mysqli_fetch_assoc($jadwal)) :

          //Query Hari
          $sqlhari  = select('nama_hari', 'tbl_hari', "id=".$j["hari"]);
          $h        = mysqli_fetch_assoc($sqlhari);

          //Query Guru
          $sqlguru  = select('*', 'tbl_guru', "id = ".$j["guru"]);
          $g        = mysqli_fetch_assoc($sqlguru);

          //Query Mapel
          $sqlmapel  = select('nama_mapel', 'tbl_mapel', "id = ".$j["mapel"]);
          $m        = mysqli_fetch_assoc($sqlmapel);

          //Query Kelas
          $sqlkelas  = select('nama_kelas', 'tbl_kelas', "id = ".$j["kelas"]);
          $k        = mysqli_fetch_assoc($sqlkelas);

          //Query Kehadiran
          $sqlabsen  = select('nama_kehadiran', 'tbl_kehadiran', "id = ".$j["kehadiran"]);
          $hdr        = mysqli_fetch_assoc($sqlabsen);

      ?>

      <tr>
        <td><?= $no++; ?></td>
        <td><?= $h['nama_hari']; ?></td>
        <td><?= $k['nama_kelas']; ?></td>
        <td><?= $m['nama_mapel']; ?></td>
        <td><?= $g['nama_guru']; ?></td>
        <td><?= $j['jam_mulai']; ?></td>
        <td><?= $j['jam_selesai']; ?></td>

        <?php if ($hdr['nama_kehadiran'] == NULL) { ?>

          <td class="ctr">&nbsp;</td>
          <td class="ctr">
            <div class="btn-group" role="group">
              <a href="absen.php?x=hadir&idg=<?= $g['id']; ?>&idj=<?= $j['id']; ?>" class="btn btn-sm btn-default">Hadir</a>
              <a href="absen.php?x=izin&idg=<?= $g['id']; ?>&idj=<?= $j['id']; ?>" class="btn btn-sm btn-primary">Izin</a>
              <a href="absen.php?x=tugas&idg=<?= $g['id']; ?>&idj=<?= $j['id']; ?>" class="btn btn-sm btn-success">Tugas</a>
              <a href="absen.php?x=sakit&idg=<?= $g['id']; ?>&idj=<?= $j['id']; ?>" class="btn btn-sm btn-warning">Sakit</a>
              <a href="absen.php?x=lain&idg=<?= $g['id']; ?>&idj=<?= $j['id']; ?>" class="btn btn-sm btn-danger">Lain</a>
            </div>
          </td>

        <?php } else { ?>

        <td class="ctr"><?= $hdr['nama_kehadiran']; ?></td>
        <td class="ctr">Tidak ada opsi</td>

      <?php } ?>

        <td class="ctr">
          <div class="btn-group" role="group">
            <a href="edit-jadwal/<?= $j['id']; ?>" class="btn btn-sm btn-success">Edit</a>
            <?php if($lv == "1"){ ?>
            <a onclick="return konfirmasi();" href="delete-jadwal/<?= $j['id']; ?>" class="btn btn-sm btn-danger">Hapus</a>
            <?php } else { } ?>
          </div>
        </td>
      </tr>

    <?php endwhile; ?>

  <?php endif; ?>

      </tbody>
    </table>
  </div>
</div>
