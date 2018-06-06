<?php
$rombel = $k->nama_kelas;
$sqls = select("*", "tbl_siswa", "rombel='$rombel'");
?>
<script>
	$(function(){
		$("#list-data").DataTable();
		$("#list-data_length").remove();
		$("#list-data_info").remove();
		$("#list-data_wrapper > .row > .col-sm-6:first-child").append("<h4>Input Deskripsi Sikap dan Catatan</h4>");
	});
</script>
<style>
	textarea.form{
		width: 100% !important;
		border:none !important;
		box-shadow: none !important;
		margin:0px !important;
		padding: 5px;
	}
	tr > td:nth-child(3), tr > td:nth-child(4),{
		padding: 0px !important;
	}
</style>
<div class="col-md-12">
	<div class="row">
		<table class="table table-bordered" id="list-data">
			<thead>
				<tr>
					<th class="ctr" width="15px">No.</th>
					<th class="ctr" width="180px">Nama Siswa</th>
					<th class="ctr">Deskripsi Sikap</th>
					<th class="ctr">Catatan Wali Kelas</th>
					<th class="ctr">Aksi</th>
				</tr>
			</thead>
			<tbody>
			<?php while ($st = mysqli_fetch_object($sqls)) : ?>
				<tr>
					<td class="ctr"><?= $no++; ?></td>
					<td><?= ucwords(strtolower($st->nama)); ?></td>
					<?php
					$sqlcek = select("*", "data_rapot", "id_siswa = '$st->id'");
					$cek = mysqli_num_rows($sqlcek);
					if ($cek > 0) { 
						$dr = mysqli_fetch_object($sqlcek);
					?>
					<td class="ctr"><?= $dr->deskripsi_sikap; ?></td>
					<td class="ctr"><?= $dr->catatan; ?></td>
					<td class="ctr">
						<span class="glyphicon glyphicon-ok"></span>
					</td>
					<?php
					} else {
					?>
					<td class="ctr">
						<textarea name="desk" rows="2" class="form form-control desk_<?= $st->id; ?>"></textarea>
						<div class="ds_<?= $st->id; ?>"></div>
					</td>
					<td class="ctr">
						<textarea rows="2" class="form form-control cat_<?= $st->id; ?>"></textarea>
						<div class="ct_<?= $st->id; ?>"></div>
					</td>
					<td class="ctr ctr_<?= $st->id; ?>">
						<button class="btn btn-default btn-click btn_<?= $st->id; ?>" data-ids="<?= $st->id; ?>"><span class="glyphicon glyphicon-floppy-disk"></span></button>
					</td>
					<?php } ?>
				</tr>
			<?php endwhile; ?>
			</tbody>
		</table>
	</div>
</div>