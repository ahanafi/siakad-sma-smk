<script type='text/javascript'>
	$(function(){
		$(".row > .col-sm-6:first-child").append('<a href="<?= base('admin/data-deskripsi'); ?>" class="btn btn-primary">Pth. Ganjil</a>');
		$(".row > .col-sm-6:first-child").append(' <a href="<?= base('admin/deskripsi/pth_genap'); ?>" class="btn btn-primary">Pth. Genap</a>');
		$(".row > .col-sm-6:first-child").append(' <a href="<?= base('admin/deskripsi/ktr_ganjil'); ?>" class="btn btn-primary">Ktr. Ganjil</a>');
		$(".row > .col-sm-6:first-child").append(' <a href="<?= base('admin/deskripsi/ktr_genap'); ?>" class="btn btn-primary">Ktr. Genap</a>');
		$(".row > .col-sm-6:first-child").append(' <a href="<?= base('admin/import-deskripsi'); ?>" class="btn btn-info">Import Data</a>');
	})
</script>
<style>
	td:nth-child(5), td:nth-child(6), td:nth-child(7){
		font-size: 10px !important;
	}
</style>
<?php
$sqlmapel = select("*", "tbl_mapel");
$no = 1;

$data = anti_inject($_GET['data']);
if ($data == "") {
	$ket = "Pengetahuan Semester Ganjil";
} elseif ($data == "pth_genap") {
	$ket = "Pengetahuan Semester Genap";
} elseif ($data == "ktr_ganjil") {
	$ket = "Keterampilan Semester Ganjil";
} elseif ($data == "ktr_genap") {
	$ket = "Keterampilan Semester Genap";
}

if ($data == "") {
?>
<div class="col-md-12">
	<h4>Data Deskripsi : <?= $ket; ?></h4>
	<hr>
	<table class="table table-bordered" id="list-data">
		<thead>
			<tr>
				<th class="ctr" rowspan="2" width="30px;">No.</th>
				<th class="ctr" rowspan="2" width="30px;">Kode</th>
				<th class="ctr" rowspan="2" width="150px">Nama Mata Pelajaran</th>
				<th class="ctr" rowspan="2" width="80px">Kelas (Paket)</th>
				<th class="ctr" colspan="3">Predikat</th>
				<th class="ctr" rowspan="2" width="20px;">Opsi</th>
			</tr>
			<tr>
				<th class="ctr">A</th>
				<th class="ctr">B</th>
				<th class="ctr">C</th>
			</tr>
		</thead>
		<tbody>
		<?php
			while ($m = mysqli_fetch_object($sqlmapel)):
				if ($m->paket == "Administrasi Perkantoran") {
					$pkt = "AP";
				} elseif ($m->paket == "Akuntansi") {
					$pkt = "AK";
				} elseif ($m->paket == "Multimedia") {
					$pkt = "MM";
				} elseif ($m->paket == "Pemasaran") {
					$pkt = "PM";
				} elseif ($m->paket == "Perbankan") {
					$pkt = "PB";
				} elseif ($m->paket == "Usaha Perjalanan Wisata") {
					$pkt = "UPW";
				} else {
					$pkt = "Semua";
				}
		?>
			<tr>
				<td class="ctr"><?= $no++; ?></td>
				<td width="30px"><?= $m->kode_mapel; ?></td>
				<td width="150px"><?= $m->nama_mapel; ?></td>
				<td class="ctr"><?= $m->kelas." ( $pkt )"; ?></td>
				<?php
					$sqlpa = select("deskripsi", "tbl_deskripsi_pth", "kode_mapel = '$m->kode_mapel' AND semester = 'Ganjil'");
					while ($pa = mysqli_fetch_object($sqlpa)):
				?>
				<td>
					<?= $pa->deskripsi; ?>
				</td>
				<?php endwhile; ?>
				<td class="ctr" width="20px;">
					<a href="<?= base('admin/edit-deskripsi/'.base64_encode($m->kode_mapel).'/'.base64_encode('pth_ganjil')); ?>" class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
				</td>
			</tr>
		<?php endwhile; ?>
		</tbody>
	</table>
</div>
<?php
} else if($data == "pth_genap") {
?>
<div class="col-md-12">
	<h4>Data Deskripsi : <?= $ket; ?></h4>
	<hr>
	<table class="table table-bordered" id="list-data">
		<thead>
			<tr>
				<th class="ctr" rowspan="2" width="30px;">No.</th>
				<th class="ctr" rowspan="2" width="30px;">Kode</th>
				<th class="ctr" rowspan="2" width="150px">Nama Mata Pelajaran</th>
				<th class="ctr" rowspan="2" width="80px">Kelas (Paket)</th>
				<th class="ctr" colspan="3">Predikat</th>
				<th class="ctr" rowspan="2" width="20px;">Opsi</th>
			</tr>
			<tr>
				<th class="ctr">A</th>
				<th class="ctr">B</th>
				<th class="ctr">C</th>
			</tr>
		</thead>
		<tbody>
		<?php
			while ($m = mysqli_fetch_object($sqlmapel)):
				if ($m->paket == "Administrasi Perkantoran") {
					$pkt = "AP";
				} elseif ($m->paket == "Akuntansi") {
					$pkt = "AK";
				} elseif ($m->paket == "Multimedia") {
					$pkt = "MM";
				} elseif ($m->paket == "Pemasaran") {
					$pkt = "PM";
				} elseif ($m->paket == "Perbankan") {
					$pkt = "PB";
				} elseif ($m->paket == "Usaha Perjalanan Wisata") {
					$pkt = "UPW";
				} else {
					$pkt = "Semua";
				}
		?>
			<tr>
				<td class="ctr"><?= $no++; ?></td>
				<td width="30px"><?= $m->kode_mapel; ?></td>
				<td width="150px"><?= $m->nama_mapel; ?></td>
				<td class="ctr"><?= $m->kelas." ( $pkt )"; ?></td>
				<?php
					$sqlpa = select("deskripsi", "tbl_deskripsi_pth", "kode_mapel = '$m->kode_mapel' AND semester = 'Genap'");
					while ($pa = mysqli_fetch_object($sqlpa)):
				?>
				<td>
					<?= $pa->deskripsi; ?>
				</td>
				<?php endwhile; ?>
				<td class="ctr" width="20px;">
					<a href="<?= base('admin/edit-deskripsi/'.base64_encode($m->kode_mapel).'/'.base64_encode($data)); ?>" class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
				</td>
			</tr>
		<?php endwhile; ?>
		</tbody>
	</table>
</div>
<?php	
} else if($data == "ktr_ganjil") {
?>
<div class="col-md-12">
	<h4>Data Deskripsi : <?= $ket; ?></h4>
	<hr>
	<table class="table table-bordered" id="list-data">
		<thead>
			<tr>
				<th class="ctr" rowspan="2" width="30px;">No.</th>
				<th class="ctr" rowspan="2" width="30px;">Kode</th>
				<th class="ctr" rowspan="2" width="150px">Nama Mata Pelajaran</th>
				<th class="ctr" rowspan="2" width="80px">Kelas (Paket)</th>
				<th class="ctr" colspan="3">Predikat</th>
				<th class="ctr" rowspan="2" width="20px;">Opsi</th>
			</tr>
			<tr>
				<th class="ctr">A</th>
				<th class="ctr">B</th>
				<th class="ctr">C</th>
			</tr>
		</thead>
		<tbody>
		<?php
			while ($m = mysqli_fetch_object($sqlmapel)):
				if ($m->paket == "Administrasi Perkantoran") {
					$pkt = "AP";
				} elseif ($m->paket == "Akuntansi") {
					$pkt = "AK";
				} elseif ($m->paket == "Multimedia") {
					$pkt = "MM";
				} elseif ($m->paket == "Pemasaran") {
					$pkt = "PM";
				} elseif ($m->paket == "Perbankan") {
					$pkt = "PB";
				} elseif ($m->paket == "Usaha Perjalanan Wisata") {
					$pkt = "UPW";
				} else {
					$pkt = "Semua";
				}
		?>
			<tr>
				<td class="ctr"><?= $no++; ?></td>
				<td width="30px"><?= $m->kode_mapel; ?></td>
				<td width="150px"><?= $m->nama_mapel; ?></td>
				<td class="ctr"><?= $m->kelas." ( $pkt )"; ?></td>
				<?php
					$sqlpa = select("deskripsi", "tbl_deskripsi_ktr", "kode_mapel = '$m->kode_mapel' AND semester = 'Ganjil'");
					while ($pa = mysqli_fetch_object($sqlpa)):
				?>
				<td>
					<?= $pa->deskripsi; ?>
				</td>
				<?php endwhile; ?>
				<td class="ctr" width="20px;">
					<a href="<?= base('admin/edit-deskripsi/'.base64_encode($m->kode_mapel).'/'.base64_encode($data)); ?>" class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
				</td>
			</tr>
		<?php endwhile; ?>
		</tbody>
	</table>
</div>
<?php	
} else if($data == "ktr_genap") {
?>
<div class="col-md-12">
	<h4>Data Deskripsi : <?= $ket; ?></h4>
	<hr>
	<table class="table table-bordered" id="list-data">
		<thead>
			<tr>
				<th class="ctr" rowspan="2" width="30px;">No.</th>
				<th class="ctr" rowspan="2" width="30px;">Kode</th>
				<th class="ctr" rowspan="2" width="150px">Nama Mata Pelajaran</th>
				<th class="ctr" rowspan="2" width="80px">Kelas (Paket)</th>
				<th class="ctr" colspan="3">Predikat</th>
				<th class="ctr" rowspan="2" width="20px;">Opsi</th>
			</tr>
			<tr>
				<th class="ctr">A</th>
				<th class="ctr">B</th>
				<th class="ctr">C</th>
			</tr>
		</thead>
		<tbody>
		<?php
			while ($m = mysqli_fetch_object($sqlmapel)):
				if ($m->paket == "Administrasi Perkantoran") {
					$pkt = "AP";
				} elseif ($m->paket == "Akuntansi") {
					$pkt = "AK";
				} elseif ($m->paket == "Multimedia") {
					$pkt = "MM";
				} elseif ($m->paket == "Pemasaran") {
					$pkt = "PM";
				} elseif ($m->paket == "Perbankan") {
					$pkt = "PB";
				} elseif ($m->paket == "Usaha Perjalanan Wisata") {
					$pkt = "UPW";
				} else {
					$pkt = "Semua";
				}
		?>
			<tr>
				<td class="ctr"><?= $no++; ?></td>
				<td width="30px"><?= $m->kode_mapel; ?></td>
				<td width="150px"><?= $m->nama_mapel; ?></td>
				<td class="ctr"><?= $m->kelas." ( $pkt )"; ?></td>
				<?php
					$sqlpa = select("deskripsi", "tbl_deskripsi_ktr", "kode_mapel = '$m->kode_mapel' AND semester = 'Genap'");
					while ($pa = mysqli_fetch_object($sqlpa)):
				?>
				<td>
					<?= $pa->deskripsi; ?>
				</td>
				<?php endwhile; ?>
				<td class="ctr" width="20px;">
					<a href="<?= base('admin/edit-deskripsi/'.base64_encode($m->kode_mapel).'/'.base64_encode($data)); ?>" class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
				</td>
			</tr>
		<?php endwhile; ?>
		</tbody>
	</table>
</div>
<?php } ?>