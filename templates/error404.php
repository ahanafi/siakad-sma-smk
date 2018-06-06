<?php
require_once ("../function/core.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>ERROR 404!</title>
</head>
<link rel="stylesheet" href="<?= base('assets/css/style.css'); ?>" media="screen" title="no title">
<link rel="stylesheet" href="<?= base('assets/css/bootstrap.css'); ?>" media="screen" title="no title">
<link rel="stylesheet" href="<?= base('assets/css/sweetalert.css'); ?>" media="screen" title="no title">
<link rel="shorcut icon" href="<?= base('images/favicon.png'); ?>">
<script type="text/javascript" src="<?= base('assets/js/jquery.js'); ?>"></script>
<script type="text/javascript" src="<?= base('assets/js/bootstrap.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base('assets/js/sweetalert.min.js'); ?>"></script>
<style>
	body{
		background-image: url('<?= base('images/flat-3.jpg'); ?>');
		color: #fff !important;
	}
	.box{
		margin:15% auto !important;
		padding: 20px;
		border-radius: 5px;
		width: 50%;
		background: rgba(255,255,255,0.3);
		text-align: center;
	}
	a{
		color: #fff;
		text-decoration: underline;
	}
</style>
<body>
	<div class="container">
		<div class="row">
			<div class="box">
				<h1>Oops....!!!</h1>
				<h4>Maaf! Halaman yang Anda cari tidak ditemukan!</h4>
				<br>
				Copyright &copy; <?= date('Y'); ?> - SMK Negeri 1 Kedawung - Created by <a target="_blank" href="http://www.facebook.com/ahmaddhanavie">Ahmad Hanafi</a>
			</div>
		</div>
	</div>
</body>
</html>