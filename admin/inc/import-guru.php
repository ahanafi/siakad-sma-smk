<div class="col-md-12">
	<div class="row">
		<div class="col-md-8">
			<h4>Import Data Guru</h4>
			<hr>
			<br>
			<div class="panel panel-default">
				<div class="panel-body">
					<center>
						<a href="<?=base('admin/download/file/sample_guru.xlsx');?>" class="btn btn-success">Download Template</a>
						<a href="<?=base('admin/guru');?>" class="btn btn-primary">Kembali</a>
					</center>
					<br>
					<form action="" class="form form-group" method="post" enctype="multipart/form-data">
					<div class="col-sm-10">
						<input type="file" name="file" class="form form-control">
					</div>
					<div class="col-sm-2">
						<label for=""></label>
						<input type="submit" name="submit" class="btn btn-default" value="Import">
					</div>
					</form>
				</div>
			</div>
		</div>
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
				</div>
			</div>
		</div>
	</div>
</div>

<?php
if (isset($_POST['submit'])) {
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
				
				$excelReader  = PHPExcel_IOFactory::createReaderForFile($excelfile);
				$excelObj     = $excelReader->load($excelfile);
				$worksheet    = $excelObj->getActiveSheet();
				$lastRow      = $worksheet->getHighestRow();

				//$sql = "INSERT INTO tbl_guru (id, id_card, password, nip, nama_guru, jenis_ptk) VALUES ";
				//$ins = mysqli_query($link , )

				for ($i=2; $i <= $lastRow; $i++) :
					$id_card = anti_inject($worksheet->getCell('B'.$i)->getValue());
					$nip = anti_inject($worksheet->getCell('C'.$i)->getValue());
					$nip = number_format($nip, 0, ",", " ");
					$nama = addslashes($worksheet->getCell('D'.$i)->getValue());
					$nama = ucwords($nama);
					$jenis_ptk = anti_inject($worksheet->getCell('E'.$i)->getValue());
					$tmp_lahir = anti_inject($worksheet->getCell('F'.$i)->getValue());
					$tgl_lahir = anti_inject($worksheet->getCell('G'.$i)->getValue());
					$jk = anti_inject($worksheet->getCell('H'.$i)->getValue());
					$telp = anti_inject($worksheet->getCell('I'.$i)->getValue());

					$length = strlen($id_card);

					if ($length == 1) {
						$jdkd = "0000".$id_card;
					} elseif ($length == 2) {
						$jdkd = "000".$id_card;
					} elseif ($length == 3) {
						$jdkd = "00".$id_card;
					} elseif ($length == 4) {
						$jdkd = "0".$id_card;
					} elseif ($length == 5) {
						$jdkd = $id_card;
					}
					$pass = password_hash("123456", PASSWORD_DEFAULT, ['cost'=>12]);

					//$sql .= " (NULL, '$jdkd', '$pass', '$nip', '$nama', '$jenis_ptk') ";
					$ins = insert('tbl_guru', "id, id_card, password, nip, nama_guru, jenis_ptk", "NULL, '$jdkd', '$pass', '$nip', '$nama', '$jenis_ptk'");
					$last_id = mysqli_insert_id($link);
					$indetail = insert('detail_guru', "id, id_guru, jk, tmp_lahir, tgl_lahir", "NULL, '$last_id', '$jk', '$tmp_lahir', '$tgl_lahir'");

					var_dump("INSERT INTO tbl_guru VALUES (NULL, '$jdkd', '$pass', '$nip', '$nama', '$jenis_ptk') ");
					var_dump("INSERT INTO detail_guru VALUES (NULL, '$last_id', '$jk', '$tmp_lahir', '$tgl_lahir')");

				endfor;

				if ($ins && $indetail) {
					echo "<script>swal('Yosh!', 'Data Guru berhasil diimport!', 'success');</script>";
					echo notice(1);
					die();
					//echo location(base('admin/guru'));
				} else {
					echo "<script>sweetAlert('Oops!', 'Data Guru Gagal diimport!', 'error');</script>";	
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