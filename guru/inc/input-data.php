<?php
$id = (int) anti_inject($_GET['id']);

if ($id == 0 || $id == '') {
	redirect(base('guru/input-data-rapot'));
} else {

	$sqlsis = select("*","tbl_siswa", "id='$id' LIMIT 1");
	$s = mysqli_fetch_object($sqlsis);
?>

<div class="row">
	<div class="col-md-12">
		<h4>Input Data Rapot</h4>
		<button class="btn btn-primary" id="btn-prestasi">Input Prestasi</button>
		<button class="btn btn-primary" id="btn-exkul">Input Ekstrakurikuler</button>
		<button class="btn btn-primary" id="btn-prakerin">Input Prakerin</button>
		<hr>
		<div class="row">
			<div class="col-md-8" id="masterElement">
				<form action="" method="post" method="post" id="form-data-rapot">
					<label for="deskripsi">Deskripsi Sikap</label>
					<textarea name="deskripsi" rows="3" class="form-control" required></textarea>
					<br>

					<label for="kehadiran">Kehadiran</label>
					<table class="table">
						<tr>
							<td>Sakit</td>
							<td>:</td>
							<td><input name="sakit" type="text" class="form-control" required></td>
						</tr>
						<tr>
							<td>Izin</td>
							<td>:</td>
							<td><input name="izin" type="text" class="form-control" required></td>
						</tr>
						<tr>
							<td>Tanpa Keterangan</td>
							<td>:</td>
							<td><input name="tnp_ket" type="text" class="form-control" required></td>
						</tr>
					</table>
					<br>

					<label for="catatan">Catatan Wali Kelas</label>
					<textarea name="catatan" rows="3" class="form-control" required></textarea>
					<br>

					<input type="submit" name="submit_data" class="btn btn-primary" value="Simpan">
				</form>
				<!--form action="" method="post" class="form-group" id="form-prestasi"-->
				<div id="form-prestasi">
					<label for="jenis">Jenis Prestasi</label>
					<input type="text" name="jenis" class="form form-control">
					<br>

					<label for="ket_prestasi">Keterangan</label>
					<textarea name="ket_prestasi" rows="3" class="form-control"></textarea>
					<br>

					<input type="submit" name="submit_prestasi" id="sub-pres" class="btn btn-primary" value="Simpan">
				</div>
				<!--/form-->
				<form action="" method="post" class="form-group" id="form-exkul">
					<label for="kegiatan">Kegiatan Ekstrakurikuler</label>
					<input type="text" name="kegiatan" class="form-control">
					<br>

					<label for="ket_exkul">Keterangan</label>
					<textarea name="ket_exkul" rows="3" class="form-control"></textarea>
					<br>

					<input type="submit" name="submit_exkul" class="btn btn-primary">
				</form>
				<form action="" method="post" class="form-group" id="form-prakerin">
					<label for="mitra">Mitra DU/DI</label>
					<input type="text" name="mitra" class="form-control">
					<br>

					<label for="lokasi">Lokasi</label>
					<textarea name="lokasi" rows="3" class="form-control"></textarea>
					<br>

					<label for="lama">Lama Praktik</label>
					<div class="input-group">
						<input type="number" pattern="[0-9]" oninput="maxChars(this, 1)" maxlength="1" name="lokasi" class="form-control">
						<span class="input-group-addon">bulan</span>
					</div>
					<br>

					<label for="kegiatan">Kegiatan yang dilakukan</label>
					<textarea name="kegiatan" rows="3" class="form-control"></textarea>
					<br>

					<input type="submit" name="submit_prakerin" class="btn btn-primary" value="Simpan">
				</form>
			</div>
			<div class="col-md-4">
				<div class="panel panel-primary">
					<div class="panel-heading">
						Detail Siswa
					</div>
					<div class="panel-body">
						<table class="table">
							<tr>
								<td>Nama Siswa</td>
								<td>:</td>
								<td><?= ucwords(strtolower($s->nama)); ?></td>
							</tr>
							<tr>
								<td>Kelas</td>
								<td>:</td>
								<td><?= $s->rombel; ?></td>
							</tr>
							<tr>
								<td>NIS</td>
								<td>:</td>
								<td><?= $s->nis; ?></td>
							</tr>
							<tr>
								<td>Jenis Kelamin</td>
								<td>:</td>
								<td><?= $s->jk; ?></td>
							</tr>
						</table>
					</div> <!-- end of panel body -->
				</div> <!-- end of class panel -->
			</div> <!-- end of class col md 4 -->
		</div> <!-- end of class of row -->
	</div> <!-- end of class of col md 12 -->
</div> <!-- end of row -->
<?php 
	
	if (isset($_POST['submit_data'])) {
		$deskripsi 	= addslashes($_POST['deskripsi']);
		$deskripsi 	= mysqli_real_escape_string($link, $deskripsi);
		$sakit 		= anti_inject($_POST['sakit']);
		$izin 		= anti_inject($_POST['izin']);
		$tnp_ket 	= anti_inject($_POST['tnp_ket']);
		$catatan 	= addslashes($_POST['catatan']);
		$catatan 	= mysqli_real_escape_string($link, $catatan);

		$ins_data = insert('data_rapot', 'id,id_siswa,deskripsi_sikap,catatan',"NULL,'$id','$deskripsi','$catatan'");

		$ins_abs = insert('absensi_siswa','id,id_siswa,sakit,izin,tnp_ket',"NULL,'$id','$sakit','$izin','$tnp_ket'");

		if ($ins_data === TRUE && $ins_data === TRUE) {
			echo "<script>swal('Yosh!', 'Data rapot berhasil disimpan', 'success');</script>";
			echo location(base('guru/input-data/'.$id));
		} else {
			echo "<script>swal('Oops!', 'Data rapot gagal disimpan', 'error');</script>";
			echo location('window.history.go(-1)');
		}

	}



} ?>