<?php
include_once '../function/core.php';

$tanggal = date('Y-m-d');

$no = 1;
$sql  = "SELECT `tbl_harian`.`jam_msk`, `tbl_guru`.`nama_guru` FROM `tbl_harian` ";
$sql .= " JOIN `tbl_guru` ON `tbl_harian`.`idg` = `tbl_guru`.`id`";
$sql .= " WHERE `tanggal` = '$tanggal' ORDER BY `jam_msk` DESC ";
$exc = mysqli_query($link, $sql);

?>
<link rel="stylesheet" href="<?= base('assets/css/bootstrap.css'); ?>" media="screen" title="no title">
<link rel="stylesheet" href="<?= base('assets/css/sweetalert.css'); ?>" media="screen" title="no title">
<link rel="stylesheet" href="<?= base('assets/dataTables/css/dataTables.bootstrap.css'); ?>" media="screen" title="no title">
<script type="text/javascript" src="<?= base('assets/dataTables/js/jquery.dataTables.min.js'); ?>"></script>
<script type="text/javascript" src="<?= base('assets/dataTables/js/dataTables.bootstrap.min.js'); ?>"></script>
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
</script>
<table class="table table-bordered" id="table-data" style="background:#fff;">
  <thead style="background:#f44754 !important;">
    <tr>
      <th>No.</th>
      <th>Nama Guru</th>
      <th>Jam Masuk</th>
    </tr>
  </thead>
  <tbody>

    <?php while ($g = mysqli_fetch_array($exc)) { ?>

    <tr>
      <td><?= $no++; ?></td>
      <td><?= $g['nama_guru']; ?></td>
      <td><?= $g['jam_msk']; ?></td>
    </tr>

    <?php } ?>

  </tbody>
</table>
