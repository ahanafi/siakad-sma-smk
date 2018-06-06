<?php
if (isset($_GET['id'])) {
	$id = anti_inject(@$_GET['id']);
	$id = abs((int) $id);

	if (delete('tbl_pesan', $id) === TRUE) {
	  echo "<script>swal('Yosh!', 'Data berhasil di hapus!', 'success');</script>";
	  echo notice(1);
	  echo location(base('admin/pesan'));
	} else {
	  echo "<script>sweetAlert('Oops!', 'Data gagal dihapus!', 'error');</script>";
	  echo notice(0);
	  echo location(base('admin/pesan'));
	}
} else {
	redirect(base('admin/pesan'));
}
?>