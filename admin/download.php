<?php
require_once '../function/core.php';

$folder = "../files/";
$filename = addslashes(@$_GET['file']);
if (!file_exists($folder.$filename)) {
	echo "<script>sweetAlert('Oops!', 'File tidak ditemukan!', 'error');</script>";
	echo location(base('admin/dashboard'));
} else {
	header("Content-Type: octet/stream");
	header("Content-Disposition: attachment; filename=$filename");
	$fp = fopen($folder.$filename, "r");
	$size = filesize($folder.$filename);
	$data = fread($fp, $size);
	fclose($fp);
	print $data;
}

?>