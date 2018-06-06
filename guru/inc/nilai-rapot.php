<?php
//$x = mysqli_fetch_object($cekwk2);
$nama_kls = $k->nama_kelas;
@$_SESSION['nama_kls'] = $nama_kls;
$ls = select('*', 'tbl_siswa', "rombel = '$nama_kls'");
$n = 1;
?>
<script type="text/javascript">
   $(document).ready(function() {
   	 $("#list-data").DataTable({
   	 	'pageLength' : 5
   	 });
     $(".dataTables_length, #list-data_info").remove();
     $("#list-data_wrapper > .row:last > .col-sm-5").remove();
     $("#list-data_wrapper > .row:last > .col-sm-7").attr({
       'class':'col-sm-12'
     });
     $(".dataTables_filter").css({'float':'right'});
     $("footer").css({'bottom':'0px'});
     $("#list-data_wrapper > .row:first-child > .col-sm-6:first-child").append('<a href="<?=base('guru/download-legger');?>" class="btn btn-primary">Preview Legger</a>');
   });
</script>
<div class="col-md-12">
  <h4>Lihat Nilai Rapot Siswa</h4>
  <hr>
  <table class="table table-bordered" id="list-data">
  	<thead>
  		<tr>
  			<th class="ctr" rowspan="2">No.</th>
  			<th rowspan="2">Nama Siswa</th>
  			<th class="ctr" rowspan="2">NIS</th>
  			<th class="ctr" rowspan="2">Jenis Kelamin</th>
  			<th colspan="3" class="ctr">Aksi</th>
  		</tr>
  		<tr>
  			<th>&nbsp;</th>
  			<th>&nbsp;</th>
  			<th>&nbsp;</th>
  		</tr>
  	</thead>
  	<tbody>

  	<?php while ($xyz = mysqli_fetch_object($ls)) : ?>
  		<tr>
  			<td class="ctr"><?= $n++; ?></td>
  			<td><?= ucwords(strtolower($xyz->nama)); ?></td>
  			<td class="ctr"><?= $xyz->nis; ?></td>
  			<td class="ctr"><?= $xyz->jk; ?></td>
  			<td class="ctr">
          <a href="<?= base('guru/preview/'.$xyz->id); ?>" class="btn btn-primary" target="_blank">Lihat Nilai</a>
  			</td>
  			<td class="ctr">
  				<a href="<?= base('guru/print/'.$xyz->id); ?>" onclick="window.open(<?= base('guru/cover-siswa/'.$xzy->id); ?>)" target="_blank" data-id="<?= $xyz->id; ?>" class="btn btn-success btn-export">Export</a>
  			</td>
  			<td class="ctr">
  				<a href="#" class="btn btn-danger" disabled>Hapus</a>
  			</td>
  		</tr>

	<?php endwhile; ?>

  	</tbody>
  </table>
</div>