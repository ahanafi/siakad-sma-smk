<?php

if (isset($_POST['sub_press'])) {
	$id_siswa = anti_inject($_POST['id_siswa']);
	$jenis = anti_inject($_POST['jenis']);
	$tingkat = anti_inject($_POST['tingkat']);
	$bid_lomba = anti_inject($_POST['bid_lomba']);

	$ins = insert('tbl_prestasi', "id, id_siswa, jenis_prestasi, tingkat, bid_lomba", "NULL, '$id_siswa', '$jenis', '$tingkat', '$bid_lomba'");

	if ($ins === TRUE) {
		echo "<script>sweetAlert('Yosh!', 'Data berhasil di Simpan!', 'success');</script>";
		echo location(base('guru/entry-pep/'.$id_siswa));
	} else {
		echo "<script>swal('Oops!', 'Data gagal di Simpan!', 'error');</script>";
		echo location(base('guru/entry-pep/'.$id_siswa));
	}
} elseif (isset($_POST['sub_exk'])) {
	$id_siswa = anti_inject($_POST['ids']);
	$kegiatan = anti_inject($_POST['kegiatan']);
	$nilai = anti_inject($_POST['nilai']);
	$deskripsi = anti_inject($_POST['deskripsi']);

	$ins = insert('tbl_ekskul', 'id, id_siswa, keg_ekskul, nilai, deskripsi', "NULL, '$id_siswa', '$kegiatan', '$nilai', '$deskripsi'");

	if ($ins === TRUE) {
		echo "<script>sweetAlert('Yosh!', 'Data berhasil di Simpan!', 'success');</script>";
		echo location(base('guru/entry-pep/'.$id_siswa));
	} else {
		echo "<script>swal('Oops!', 'Data gagal di Simpan!', 'error');</script>";
		echo location(base('guru/entry-pep/'.$id_siswa));
	}

} elseif (isset($_POST['sub_pkl'])) {
	$id_siswa = anti_inject($_POST['id']);
	$mitra = anti_inject($_POST['mitra']);
	$lama = anti_inject($_POST['lama']);
	$alamat = anti_inject($_POST['alamat']);
	$predikat = anti_inject($_POST['predikat']);
	$bid_kerja = anti_inject($_POST['bid_kerja']);

	$ins = insert('tbl_prakerin', "id, id_siswa, mitra, lama, alamat, predikat, bid_kerja", "NULL, '$id_siswa', '$mitra', '$lama', '$alamat', '$predikat', '$bid_kerja'");

	if ($ins === TRUE) {
		echo "<script>sweetAlert('Yosh!', 'Data berhasil di Simpan!', 'success');</script>";
		echo location(base('guru/entry-pep/'.$id_siswa));
	} else {
		echo "<script>swal('Oops!', 'Data gagal di Simpan!', 'error');</script>";
		echo location(base('guru/entry-pep/'.$id_siswa));
	}
} else {
	echo "<script>window.history.go(-1);</script>";
}

?>