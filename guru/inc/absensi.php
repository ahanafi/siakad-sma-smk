<?php
$rombel = $k->nama_kelas;
$sqls = select("*", "tbl_siswa", "rombel='$rombel'");
?>
<script>
	$(function(){
		$("#list-data").DataTable();
		$("#list-data_info").remove();
		$("#list-data_length").remove();
	});
</script>
<style>
	td > .form ,td > .form-control, td > .form:focus, td > .form-control:focus{
		max-width: 120px;
		text-align: center;
		border:none;
		box-shadow: none;
	}
</style>
<div class="col-md-12">
	<div class="row">
		<table class="table table-bordered" id="list-data">
			<thead>
				<tr>
					<th rowspan="2" class="ctr" width="25px">No.</th>
					<th rowspan="2" class="ctr">NIS</th>
					<th rowspan="2" class="ctr" width="200px">Nama Siswa</th>
					<th colspan="3" class="ctr">Jumlah Kehadiran</th>
					<th rowspan="2" class="ctr">Aksi</th>
				</tr>
				<tr>
					<th class="ctr">Sakit</th>
					<th class="ctr">Izin</th>
					<th class="ctr">Alfa</th>
				</tr>
			</thead>
			<tbody>
				<?php while ($mr = mysqli_fetch_object($sqls)) : ?>
				<tr>
					<td class="ctr"><?= $no++; ?></td>
					<td class="ctr"><?=$mr->nis;?></td>
					<td><?= ucwords(strtolower($mr->nama)); ?></td>
					<?php
						$sqlcek = select("*", "absensi_siswa", "id_siswa = '$mr->id'");
						$cek = mysqli_num_rows($sqlcek);
						$abs = mysqli_fetch_object($sqlcek);
						if ($cek > 0) { ?>
					<td class="ctr"><?= $abs->sakit; ?></td>
					<td class="ctr"><?= $abs->izin; ?></td>
					<td class="ctr"><?= $abs->tnp_ket; ?></td>
					<td class="ctr">
						<span class="glyphicon glyphicon-ok"></span>
					</td>
					<?php							
						} else {
					?>
					<td class="ctr">
						<input type="number" maxlength="2" oninput="maxChars(this, 2)" class="form-control skt_<?= $mr->id; ?>">
						<div class="s_<?= $mr->id; ?>"></div>
					</td>
					<td class="ctr">
						<input type="number" maxlength="2" oninput="maxChars(this, 2)" class="form-control izn_<?= $mr->id; ?>">
						<div class="i_<?= $mr->id; ?>"></div>
					</td>
					<td class="ctr">
						<input type="number" maxlength="2" oninput="maxChars(this, 2)" class="form-control alf_<?= $mr->id; ?>">
						<div class="a_<?= $mr->id; ?>"></div>
					</td>
					<td class="ctr ss_<?= $mr->id; ?>">
						<button type="button" class="btn btn-default btn_abs b_<?=$mr->id;?>" data-st="<?= $mr->id; ?>"><span class="glyphicon glyphicon-floppy-disk"></span></button>
					</td>
					<?php } ?>
				</tr>
				<?php endwhile; ?>
			</tbody>
		</table>
	</div>
</div>