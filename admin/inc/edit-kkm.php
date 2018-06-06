<?php
if (isset($_GET['kode'])) {
	$kode = anti_inject($_GET['kode']);
	$kode = base64_decode($_GET['kode']);

	$sqlmap = gabung("tbl_mapel", "tbl_kkm", "tbl_mapel.kode_mapel = tbl_kkm.kode_mapel", "tbl_kkm.kode_mapel = '$kode'");
	$map = mysqli_fetch_object($sqlmap);
?>

<div class="col-md-12">
	<?php
		echo open_form('', 'post', "class='form-group'")."</br>";
		echo label('kode_mapel', 'Kode Mata Pelajaran');
		echo input('text', 'kode_mapel', "class='form-control' value='$kode' disabled")."</br>";

		echo label("nama_mapel", "Nama Mata Pelajaran");
		echo input('text', 'nama_mapel', "class='form-control' value='$map->nama_mapel' disabled")."</br>";

		echo label("kkm", "KKM");
	?>
	<div class="input-group">
		<div class="input-group-addon">Min : <b>65</b></div>
		<?= input('number', "kkm", "class='form-control' value='$map->kkm' min='65' max='100' oninput='maxChars(this, 2)' maxlength='2'"); ?>
		<div class="input-group-addon">Max : <b>100</b></div>
	</div>
	<br>
	<?php
		echo input('submit', "submit", "class='btn btn-primary' value='Simpan'");
		echo " <a href='".base('admin/data-kkm')."' class='btn btn-default'>Kembali</a>";
		echo close_form();
	?>
</div>

<?php	

	if (isset($_POST['submit'])) {
		$kkm = anti_inject($_POST['kkm']);

		$upd = update('tbl_kkm', "kkm ='$kkm'", "kode_mapel = '$kode'");

		if ($upd === TRUE) {
			echo "<script>swal('Yosh!', 'Data KKM berhasil diperbarui!', 'success');</script>";
			echo notice(1);
			echo location(base('admin/data-kkm'));
		} else {
			echo "<script>sweetAlert('Oops!', 'Data KKM gagal diperbarui', 'error');</script>";
			echo notice(0);
		}
	}

} else {
	redirect(base('admin/data-kkm'));
}

?>