<?php
if (isset($_POST['submit'])) {
	$nama_sekolah = addslashes($_POST['nama_sekolah']);
	$npsn = anti_inject($_POST['npsn']);
	$nis = anti_inject($_POST['nis']);
	$alamat = anti_inject($_POST['alamat']);
	$kelurahan = anti_inject($_POST['kelurahan']);
	$kecamatan = anti_inject($_POST['kecamatan']);
	$kota_kab = anti_inject($_POST['kota_kab']);
	$provinsi = anti_inject($_POST['provinsi']);
	$website = anti_inject($_POST['website']);
	$email = anti_inject($_POST['email']);

	$update = update('profil_sekolah', "nama_sekolah = '$nama_sekolah', npsn = '$npsn', nis = '$nis', alamat = '$alamat', kelurahan = '$kelurahan', kecamatan = '$kecamatan', kota_kab = '$kota_kab', provinsi = '$provinsi', website = '$website', email = '$email'", "id = '1'");

	if ($update === TRUE) {
		echo "<script>swal('Yosh!', 'Profil Sekolah berhasil diperbarui!', 'success');</script>";
		echo notice(1);
		echo location(base('admin/pengaturan'));
	} else {
		echo "<script>sweetAlert('Oops!', 'Profil Sekolah gagal diperbarui!', 'error');</script>";
		echo notice(0);
		echo location('window.history.go(-1)');
	}

} else {
	redirect(base('admin/pengaturan'));
}

?>