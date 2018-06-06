<?php
$sqlkkm = gabung("tbl_mapel", "tbl_kkm", "tbl_mapel.kode_mapel = tbl_kkm.kode_mapel");
$cek = mysqli_num_rows($sqlkkm);
$no = 1;
?>
<script type="text/javascript">
	$(function(){
		$(".row > .col-sm-6:first-child").append("<a href='<?= base("admin/import-kkm"); ?>' class='btn btn-info'>Import KKM</a>");
	});
</script>
<div class="col-md-12">
	<h4>Kriteria Ketuntasan Minimal</h4>
	<hr>
	<table class="table table-bordered table-responsive" id="list-data">
		<thead>
			<tr>
				<th class="ctr">No</th>
				<th class="ctr">Kode Mapel</th>
				<th class="ctr">Nama Mapel</th>
				<th class="ctr">Kelas</th>
				<th class="ctr">KKm</th>
				<th class="ctr">Opsi</th>
			</tr>
		</thead>
		<tbody>
		<?php while ($kkm = mysqli_fetch_object($sqlkkm)) : ?>
			<tr>
				<td class="ctr"><?= $no++; ?></td>
				<td class="ctr"><?= $kkm->kode_mapel; ?></td>
				<td><?= $kkm->nama_mapel; ?></td>
				<td class="ctr"><?= $kkm->kelas; ?></td>
				<td class="ctr"><?= $kkm->kkm; ?></td>
				<td class="ctr">
					<a href="<?= base('admin/edit-kkm/'.base64_encode($kkm->kode_mapel)); ?>" class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
				</td>
			</tr>
		<?php endwhile; ?>
		</tbody>
	</table>
</div>