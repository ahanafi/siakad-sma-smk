<?php
include_once '../function/core.php';
ob_start();
$file =  basename($_SERVER['SCRIPT_FILENAME']);
$server = $_SERVER['SCRIPT_NAME'];
$hasil = substr($server, 8);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Absensi Harian Guru</title>
</head>
<link rel="stylesheet" href="<?= base('assets/css/style.css'); ?>" media="screen" title="no title">
<link rel="stylesheet" href="<?= base('assets/css/bootstrap.css'); ?>" media="screen" title="no title">
<link rel="stylesheet" href="<?= base('assets/css/sweetalert.css'); ?>" media="screen" title="no title">
<link rel="stylesheet" href="<?= base('assets/dataTables/css/dataTables.bootstrap.css'); ?>" media="screen" title="no title">
<link rel="shrotcut icon" href="<?= base('images/favicon.png'); ?>">
<script type="text/javascript" src="<?= base('assets/js/jquery.js'); ?>"></script>
<script type="text/javascript" src="<?= base('assets/js/bootstrap.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base('assets/js/sweetalert.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base('assets/dataTables/js/jquery.dataTables.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base('assets/dataTables/js/dataTables.bootstrap.js'); ?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$("#table-data").DataTable();

		$(".dataTables_length, #table-data_info").css({'display':'none'});

		$("#table-data_wrapper > .row:last > .col-sm-5").remove();
		$("#table-data_wrapper > .row:last > .col-sm-7").attr({
			'class':'col-sm-12'
		});

		$(".dataTables_filter").css({'float':'right'});
		$("footer").css({'bottom':'0px'});

	});

    function maxChars(el, max){
      if (el.value.length > el.maxLength) {
        el.value = el.value.slice(0, el.maxLength);
      }
    }
</script>
<body>
	<nav class="navbar navbar-default navbar-fixed-top">
	    <div class="container">
	      <div class="navbar-header">
	        <a href="" class="navbar-brand"><img src="<?= base('images/main-logo.png'); ?>" width="200px" alt="" class="img img-responsive"></a>
	      </div> <!-- end of class navbar-header -->
				<div class="collapse navbar-collapse navbar-right">
					<ul class="nav navbar-nav">
						<li>
							<h4 style="padding-top:7px;margin-right:280px;">
							<?php
							$hari = date('w');
							$tgl	= date('Y-m-d');
							echo hari($hari).', '.tglskrg($tgl); ?>
						</h4>
						</li>

						<?php
							if ($hasil == "admin/index.php" || $hasil == "guru/index.php"){
								$potong = substr($hasil, 0, -10);
								if ($potong == "admin") { ?>

						<li class="active"><a href="<?= base('admin/logout'); ?>">Logout &nbsp; <span class="glyphicon glyphicon-log-out"></span></a></li>

						<?php	} else if ($potong == "guru") { ?>

						<li class="active"><a href="<?= base('guru/logout'); ?>">Logout &nbsp; <span class="glyphicon glyphicon-log-out"></span></a></li>

						<?php 	}						
							} else { ?>

							<?php if($file == "index.php") { ?>

								<li class="active"><a href="<?= base('harian/absen-masuk'); ?>">Absen Masuk</a></li>
								<li><a href="<?= base('harian/absen-pulang'); ?>">Absen Pulang</a></li>

							<?php } else if($file == "pulang.php") { ?>

								<li><a href="<?= base('harian/absen-masuk'); ?>">Absen Masuk</a></li>
								<li  class="active"><a href="<?= base('harian/absen-pulang'); ?>">Absen Pulang</a></li>

							<?php } ?>

						<?php } ?>

					</ul>
				</div> <!-- end of class collapse -->
	    </div> <!-- end of class container -->
	</nav>
