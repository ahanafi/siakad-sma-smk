<?php
$rmbl = $k->nama_kelas;
$sqlnya = select("*","tbl_siswa","rombel='$rmbl'");
?>

<script>
	$(function(){
		$("#list-data").DataTable();
		$("#list-data_length").remove();
		$("#list-data_info").remove();
		$("#list-data_wrapper > .row > .col-sm-6:first-child").append("<h4>Input Prestasi, Ekstrakurikuler, & PKL</h4>");
	});
</script>
<div class="col-md-12">
	<div class="row">
		<table class="table table-bordered table-responsive" id="list-data">
			<thead>
				<tr>
					<th class="ctr" width="30px">No.</th>
					<th class="ctr">NIS</th>
					<th class="ctr" width="180px">Nama Siswa</th>
					<th class="ctr">Status</th>
					<th class="ctr">Aksi</th>
				</tr>
			</thead>
			<tbody>
			<?php while ($ls = mysqli_fetch_object($sqlnya)): ?>
				<tr>
					<td class="ctr"><?=$no++;?></td>
					<td class="ctr"><?= $ls->nis; ?></td>
					<td><?= ucwords(strtolower($ls->nama)); ?></td>
					<td class="ctr">Belum terisi</td>
					<td class="ctr">
						<a href="<?= base('guru/entry-pep/'.$ls->id); ?>" class="btn btn-primary">Entry</a>
					</td>
				</tr>
			<?php endwhile; ?>
			</tbody>
		</table>
	</div>
</div>