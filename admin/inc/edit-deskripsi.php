<?php

if (isset($_GET['kode']) && isset($_GET['q'])) {
	$kode = anti_inject(@$_GET['kode']);
	$kode = base64_decode($kode);

	$q = anti_inject(@$_GET['q']);
	$q = base64_decode($q);

	$type = substr($q, 0,3);
	$sms = explode("_", $q);

	$sqlmap = select('nama_mapel', "tbl_mapel", "kode_mapel = '$kode'");
	$map = mysqli_fetch_object($sqlmap);

	$smstr = ucfirst($sms[1]);

	$sqldes = select("*", "tbl_deskripsi_".$sms[0], "kode_mapel = '$kode' AND semester = '$smstr' ");
	$cek = mysqli_num_rows($sqldes);
?>
<div class="col-md-12">
	<table class="table">
		<tr>
			<td>Kode Mata Pelajaran</td>
			<td>:</td>
			<td><?= $kode; ?></td>
		</tr>
		<tr>
			<td>Nama Mata Pelajaran</td>
			<td>:</td>
			<td><?= $map->nama_mapel; ?></td>
		</tr>
		<tr>
			<td>Tipe</td>
			<td>:</td>
			<td><?= $t = ($type == "pth") ? "Pengetahuan" : "Keterampilan";  ?></td>
		</tr>
		<tr>
			<td>Semester</td>
			<td>:</td>
			<td><?= ucfirst($sms[1]); ?></td>
		</tr>
	</table>
	<?php
		echo open_form('', 'post', "class='form-group'");
		while ($d = mysqli_fetch_object($sqldes)) :
			
			echo label('predikat', 'Predikat '.$d->predikat)."</br>";
			echo text('des_'.$d->predikat, "class='form-control'", $d->deskripsi)."</br>";

		endwhile;
		echo input('submit', "submit", "class='btn btn-primary' value='Simpan'");
		echo " <a href='javascript:window.history.go(-1);' class='btn btn-default'>Kembali</a>";
		echo close_form();
	?>
</div>

<?php
	if (isset($_POST['submit'])) {
		$des_A = addslashes($_POST['des_A']);
		$des_B = addslashes($_POST['des_B']);
		$des_C = addslashes($_POST['des_C']);

		$upd_A = update('tbl_deskripsi_'.$sms[0], "deskripsi = '$des_A'", "kode_mapel = '$kode' AND semester = '$smstr' AND predikat = 'A'");
		$upd_B = update('tbl_deskripsi_'.$sms[0], "deskripsi = '$des_B'", "kode_mapel = '$kode' AND semester = '$smstr' AND predikat = 'B'");
		$upd_C = update('tbl_deskripsi_'.$sms[0], "deskripsi = '$des_C'", "kode_mapel = '$kode' AND semester = '$smstr' AND predikat = 'C'");

		if ($upd_A === TRUE && $upd_B === TRUE && $upd_C === TRUE) {
			echo "<script>swal('Yosh!', 'Berhasil memperbarui deskripsi mata pelajaran', 'success');</script>";
			echo location(base('admin/data-deskripsi'));
		} else {
			echo "<script>sweetAlert('Oops!', 'Gagal memperbarui deskripsi mata pelajaran','error');</script>";
			echo location(base('admin/data-deskripsi'));
		}

	}

} else {
	redirect(base('admin/data-deskripsi'));
}

?>