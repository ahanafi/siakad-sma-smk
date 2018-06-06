<style>
	h5{
		font-weight: bold;
	}
	form{
		padding-top: 10px;
	}

</style>
<div class="col-md-12">
	<div class="col-md-8">
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active">
				<a href="#pengetahuan" controls="pengetahuan" role="tab" data-toggle="tab">Pengetahuan</a>
			</li>
			<li role="presentation">
				<a href="#keterampilan" controls="keterampilan" role="tab" data-toggle="tab">Keterampilan</a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane fade in active" id="pengetahuan">
				<div class="row">
					<h5>Import Deskripsi Pengetahuan</h5>
					<hr>
					<div class="panel panel-default">
						<div class="panel-body">
							<center>
								<a href="<?=base('admin/download/file/sample_desk.xlsx');?>" class="btn btn-success">Download Template</a>
								<a href="<?=base('admin/data-deskripsi');?>" class="btn btn-primary">Kembali</a>
							</center>
							<br>
							<form action="" class="form form-group" method="post" enctype="multipart/form-data">
							<div class="col-sm-10">
								<input type="file" name="file" class="form form-control">
							</div>
							<div class="col-sm-2">
								<label for=""></label>
								<input type="submit" name="submit_pth" class="btn btn-default" value="Import">
							</div> <!-- end of class col-sm-2 -->
							</form>
						</div> <!-- end of class panel body -->
					</div> <!-- end of clas panel -->
				</div> <!-- end of class row -->
			</div> <!-- end of class tab pane -->
			<div class="tab-pane fade" id="keterampilan">
				<div class="row">
					<h5>Import Deskripsi Keterampilan</h5>
					<hr>
					<div class="panel panel-default">
						<div class="panel-body">
							<center>
								<a href="<?=base('admin/download/file/sample_desk.xlsx');?>" class="btn btn-success">Download Template</a>
								<a href="<?=base('admin/data-deskripsi');?>" class="btn btn-primary">Kembali</a>
							</center>
							<br>
							<form action="" class="form form-group" method="post" enctype="multipart/form-data">
							<div class="col-sm-10">
								<input type="file" name="file" class="form form-control">
							</div>
							<div class="col-sm-2">
								<label for=""></label>
								<input type="submit" name="submit_ktr" class="btn btn-default" value="Import">
							</div>
							</form>
						</div>
					</div> <!-- end of class panel -->
				</div> <!-- end of class row -->
			</div> <!-- end of class tab pane -->
		</div> <!-- end of class tab content -->
	</div> <!-- end of class col md 8 -->
	<div class="col-md-4">
		<div class="panel panel-primary">
			<div class="panel-heading">
				Petunjuk
			</div>
			<div class="panel-body">
				<ul class="list-group">
					<li class="list-group-item">1. Silahkan downlod contoh file terlebih dahulu</li>
					<li class="list-group-item">2. Ikuti format data seperti pada template/contoh</li>
					<li class="list-group-item">3. Setelah file data sudah disiapkan, pilih file yang akan diimport</li>
					<li class="list-group-item">4. Klik Import  dan tunggu hingga data selesai di load</li>
					<li class="list-group-item">5. Selesai</li>
				</ul>
			</div> <!-- end of class panel body -->
		</div> <!-- end of class panel -->
	</div> <!-- end of class col md 4 -->
</div> <!-- end of class col md 12 -->

<?php
if (isset($_POST['submit_pth'])) {
	$filename = @$_FILES['file']['name'];
	$tempname = @$_FILES['file']['tmp_name'];
	$filetype = @$_FILES['file']['type'];
	$folder = "../upload/";

	if (empty($filename) || $filename == "") {
		echo "<script>sweetAlert('Oops!', 'Mohon pilih file terlebih dahulu!', 'error');</script>";
		echo notice(0);
	} else {
		$type = strtolower($filename);
		$type = explode(".", $filename);
		$realtype = end($type);
		$listext = array("xls", "xlsx", "XLS", "XLSX");

		if (in_array($realtype, $listext)) {
			$move = move_uploaded_file($tempname, $folder.$filename);

			if ($move) {
				$excelfile = $folder.$filename;

				$excelReader	= PHPExcel_IOFactory::createReaderForFile($excelfile);
				$excelObj		= $excelReader->load($excelfile);
				$worksheet		= $excelObj->getActiveSheet();
				$lastRow		= $worksheet->getHighestRow();

				for ($i=2; $i <= $lastRow; $i++) :
					$kode 		= anti_inject($worksheet->getCell('B'.$i)->getValue());
					$predikat	= addslashes($worksheet->getCell('C'.$i)->getValue());
					$deskripsi 	= anti_inject($worksheet->getCell('D'.$i)->getValue());
					$smstr 		= anti_inject($worksheet->getCell('E'.$i)->getValue());

					$ins_pth = insert('tbl_deskripsi_pth', "id, kode_mapel, predikat, deskripsi, semester", "NULL, '$kode', '$predikat', '$deskripsi', '$smstr'");
				endfor;

				if ($ins_pth) {
					echo "<script>swal('Yosh!', 'Data Deskripsi berhasil diimport!', 'success');</script>";
					echo notice(1);
				} else {
					echo "<script>sweetAlert('Oops!', 'Data Deskripsi gagal diimport!', 'error');</script>";
					echo location(base('admin/data-deskripsi'));
					echo notice(0);
				}

			} else {
				echo "<script>sweetAlert('Oops!', 'File tidak dapat diupload ke System!', 'error');</script>";
				echo notice(0);
			}
		} else {
			echo "<script>sweetAlert('Oops!', 'Type file harus XLS/XLSX!', 'error');</script>";	
			echo notice(0);
		}
	}
} else if (isset($_POST['submit_ktr'])) {
	$filename = @$_FILES['file']['name'];
	$tempname = @$_FILES['file']['tmp_name'];
	$filetype = @$_FILES['file']['type'];
	$folder = "../upload/";

	if (empty($filename) || $filename == "") {
		echo "<script>sweetAlert('Oops!', 'Mohon pilih file terlebih dahulu!', 'error');</script>";
		echo notice(0);
	} else {
		$type = strtolower($filename);
		$type = explode(".", $filename);
		$realtype = end($type);
		$listext = array("xls", "xlsx", "XLS", "XLSX");

		if (in_array($realtype, $listext)) {
			$move = move_uploaded_file($tempname, $folder.$filename);

			if ($move) {
				$excelfile = $folder.$filename;

				$excelReader	= PHPExcel_IOFactory::createReaderForFile($excelfile);
				$excelObj		= $excelReader->load($excelfile);
				$worksheet		= $excelObj->getActiveSheet();
				$lastRow		= $worksheet->getHighestRow();

				for ($i=2; $i <= $lastRow; $i++) :
					$kode 		= anti_inject($worksheet->getCell('B'.$i)->getValue());
					$predikat	= addslashes($worksheet->getCell('C'.$i)->getValue());
					$deskripsi 	= anti_inject($worksheet->getCell('D'.$i)->getValue());
					$smstr 		= anti_inject($worksheet->getCell('E'.$i)->getValue());

					$ins_pth = insert('tbl_deskripsi_ktr', "id, kode_mapel, predikat, deskripsi, semester", "NULL, '$kode', '$predikat', '$deskripsi', '$smstr'");
				endfor;

				if ($ins_pth) {
					echo "<script>swal('Yosh!', 'Data Deskripsi berhasil diimport!', 'success');</script>";
					echo notice(1);
				} else {
					echo "<script>sweetAlert('Oops!', 'Data Deskripsi gagal diimport!', 'error');</script>";
					echo location(base('admin/data-deskripsi'));
					echo notice(0);
				}

			} else {
				echo "<script>sweetAlert('Oops!', 'File tidak dapat diupload ke System!', 'error');</script>";
				echo notice(0);
			}
		} else {
			echo "<script>sweetAlert('Oops!', 'Type file harus XLS/XLSX!', 'error');</script>";	
			echo notice(0);
		}
	}
}



?>