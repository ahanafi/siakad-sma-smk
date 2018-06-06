<?php
include_once '../function/core.php';

$q = anti_inject(@$_GET['q']);

if ($q == "kls") {

	$paket = anti_inject($_POST['paket']);

	$selectjur = select('*', 'tbl_kelas', "paket = '$paket'");
	$jurusan = array();
	while ($j = mysqli_fetch_object($selectjur)) :
		$jurusan[] = $j;
	endwhile;

	echo json_encode($jurusan);

} else if($q == "mpl") {

	$nama_kelas = anti_inject($_POST['kelas']);
	$kelas = substr($nama_kelas, 0,2);
	$jur = substr($nama_kelas, 3,2);

	if ($kelas == 10) {
		if ($jur == "MM") {
			$sqlkls = select("*", "tbl_mapel", "kelas = 10 AND paket = 'Semua' OR paket = 'Multimedia' ORDER BY kode_mapel ASC");
		} else if($jur == "AK") {
			$sqlkls = select("*", "tbl_mapel", "kelas = 10 AND paket = 'Semua' OR paket = 'Akuntansi' ORDER BY kode_mapel ASC");
		} else if($jur == "AP") {
			$sqlkls = select("*", "tbl_mapel", "kelas = 10 AND paket = 'Semua' OR paket = 'Administrasi Perkantoran' ORDER BY kode_mapel ASC");
		} else if($jur == "PM") {
			$sqlkls = select("*", "tbl_mapel", "kelas = 10 AND paket = 'Semua' OR paket = 'Pemasaran' ORDER BY kode_mapel ASC");
		} else if($jur == "PB") {
			$sqlkls = select("*", "tbl_mapel", "kelas = 10 AND paket = 'Semua' OR paket = 'Perbankan' ORDER BY kode_mapel ASC");
		} else if($jur == "UP") {
			$sqlkls = select("*", "tbl_mapel", "kelas = 10 AND paket = 'Semua' OR paket = 'Usaha Perjalanan Wisata' ORDER BY kode_mapel ASC");
		}
		

	} else if($kelas == 11) {
		if ($jur == "MM") {
			$sqlkls = select("*", "tbl_mapel", "kelas = 11 AND paket = 'Semua' OR paket = 'Multimedia' ORDER BY kode_mapel ASC");
		} else if($jur == "AK") {
			$sqlkls = select("*", "tbl_mapel", "kelas = 11 AND paket = 'Semua' OR paket = 'Akuntansi' ORDER BY kode_mapel ASC");
		} else if($jur == "AP") {
			$sqlkls = select("*", "tbl_mapel", "kelas = 11 AND paket = 'Semua' OR paket = 'Administrasi Perkantoran' ORDER BY kode_mapel ASC");
		} else if($jur == "PM") {
			$sqlkls = select("*", "tbl_mapel", "kelas = 11 AND paket = 'Semua' OR paket = 'Pemasaran' ORDER BY kode_mapel ASC");
		} else if($jur == "PB") {
			$sqlkls = select("*", "tbl_mapel", "kelas = 11 AND paket = 'Semua' OR paket = 'Perbankan' ORDER BY kode_mapel ASC");
		} else if($jur == "UP") {
			$sqlkls = select("*", "tbl_mapel", "kelas = 11 AND paket = 'Semua' OR paket = 'Usaha Perjalanan Wisata' ORDER BY kode_mapel ASC");
		}
	} else if($kelas == 12) {
		if ($jur == "MM") {
			$sqlkls = select("*", "tbl_mapel", "kelas = 12 AND paket = 'Semua' OR paket = 'Multimedia' ORDER BY kode_mapel ASC");
		} else if($jur == "AK") {
			$sqlkls = select("*", "tbl_mapel", "kelas = 12 AND paket = 'Semua' OR paket = 'Akuntansi' ORDER BY kode_mapel ASC");
		} else if($jur == "AP") {
			$sqlkls = select("*", "tbl_mapel", "kelas = 12 AND paket = 'Semua' OR paket = 'Administrasi Perkantoran' ORDER BY kode_mapel ASC");
		} else if($jur == "PM") {
			$sqlkls = select("*", "tbl_mapel", "kelas = 12 AND paket = 'Semua' OR paket = 'Pemasaran' ORDER BY kode_mapel ASC");
		} else if($jur == "PB") {
			$sqlkls = select("*", "tbl_mapel", "kelas = 12 AND paket = 'Semua' OR paket = 'Perbankan' ORDER BY kode_mapel ASC");
		} else if($jur == "UP") {
			$sqlkls = select("*", "tbl_mapel", "kelas = 12 AND paket = 'Semua' OR paket = 'Usaha Perjalanan Wisata' ORDER BY kode_mapel ASC");
		}
	}

	$class = array();
	while ($c = mysqli_fetch_object($sqlkls)) {
		$class[] = $c;
	}

	echo json_encode($class);

}
?>