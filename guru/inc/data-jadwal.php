<?php
$id = @$_SESSION['guru']['id'];
$jadwal = select('*', 'tbl_jadwal', "guru = '$id' ORDER BY hari");
$no = 1;
error_reporting(0);
?>
<script type="text/javascript">
  $(document).ready(function(){
    $("#list-data").DataTable({
      'pageLength' : 5
    });

    $(".row > .col-sm-6:first").append(' <a href="export.php?data=jadwal" class="btn btn-default">Export Ms. Excel</a>');

    $(".dataTables_length, #table-data_info").css({'display':'none'});

		$("#table-data_wrapper > .row:last > .col-sm-5").remove();
		$("#table-data_wrapper > .row:last > .col-sm-7").attr({
			'class':'col-sm-12'
		});

		$(".dataTables_filter").css({'float':'right'});
		$("footer").css({'bottom':'0px'});
  });
</script>
<div class="col-md-12">
  <h4>Data Jadwal Anda</h4>
  <hr>
  <table class="table table-bordered" id="list-data" border="1">
    <thead>
      <tr>
        <th>No.</th>
        <th>Hari</th>
        <th>Kelas</th>
        <th>Mata Pelajaran</th>
        <th>Waktu</th>
      </tr>
    </thead>
    <tbody>

    <?php
      while ($jd = mysqli_fetch_object($jadwal)) :
        $hari = select('nama_hari', 'tbl_hari', "id=$jd->hari");
        $h    = mysqli_fetch_object($hari);

        $mapel = select('nama_mapel', 'tbl_mapel', "id=$jd->mapel");
        $m     = mysqli_fetch_object($mapel);

        $kelas = select('nama_kelas', 'tbl_kelas', "id=$jd->kelas");
        $k     = mysqli_fetch_object($kelas);

        //Pecah jam mulai
        $jd->jam_mulai = explode(":", $jd->jam_mulai);
        $jd->jam_mulai = $jd->jam_mulai[0].":".$jd->jam_mulai[1];

        //Pecah jam selesai
        $jd->jam_selesai = explode(":", $jd->jam_selesai);
        $jd->jam_selesai = $jd->jam_selesai[0].":".$jd->jam_selesai[1];
    ?>

      <tr>
        <td class="ctr"><?= $no++; ?></td>
        <td><?= $k->nama_kelas; ?></td>
        <td><?= $h->nama_hari; ?></td>
        <td><?= $m->nama_mapel; ?></td>
        <td class="ctr"><?= $jd->jam_mulai." - ".$jd->jam_selesai; ?></td>
      </tr>

    <?php endwhile; ?>

    </tbody>
  </table>
</div>
