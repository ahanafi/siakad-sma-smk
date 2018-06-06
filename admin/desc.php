<?php
require_once '../function/core.php';

$s = anti_inject(@$_GET['s']);
if (isset($_GET['s'])) {
	if (isset($_POST['sub_pth_gjl'])) {
		echo $_POST['kode'];
	}
} else {
	redirect(base('admin/data-deskripsi'));
}


?>