<?php
require_once '../function/core.php';
require_once '../templates/header.php';

?>
<style media="screen">
	body{
		background-image:url('../images/pattern.png');
	}
	.navbar-default{
		background: #F44754 !important;
		color: #fff;
		border-color: #eee !important;
		border-bottom: 1px solid #f44754 !important;
	}
	input[type=number]::-webkit-inner-spin-button,
	input[type=number]::-webkit-outer-spin-button {
		-webkit-appearance: none;
		margin: 0;
	}
	.navbar-default a{
		color: #fff !important;
	}

	li.active a{
		color: #333 !important;
	}

	ul.pagination > li.active > a{
		background: #f44754;
		border-color: #f44754;
	}

	.panel{
		border:none !important;
		box-shadow: 1px 1px 3px #333 !important;
	}
	#sidebar{
		box-shadow: 1px 1px 3px #333 !important;	
	}
</style>

<div class="container" style="padding-top:70px !important;">
	<div class="row">
		<div class="col-md-4" id="sidebar" style="min-height:540px;background:#f5f5f5;padding:10px;border:1px solid #ddd;background-color: #efefef">
			<?php include_once 'data-masuk.php'; ?>
		</div>
		<div class="col-md-8">
			<div class="panel panel-danger">
				<div class="panel-heading" style="background:#f44754 !important;color:#fff;">
					Absen Masuk Guru
				</div>
				<div class="panel-body" style="max-height:500px;background-color: #efefef;">
					<form class="form form-group-lg" action="<?= base('harian/absen-masuk'); ?>" method="post">
						<div class="col-sm-10">
							<input type="number" class="form-control" oninput="maxChars(this, 5)" maxlength="5" id="inp-idcard" min="00000" max="99999" name="id_card" placeholder="Masukkan Nomor ID Card Anda disini" autofocus>
						</div>
						<div class="col-sm-2">
							<input type="submit" class="btn btn-lg btn-default" name="submit" value="Cek" style="padding-left:35px;padding-right:35px;">
						</div>
					</form>
					<div class="col-md-12">

<?php
if (isset($_POST['submit'])) {
	global $link;
	$id_card = anti_inject($_POST['id_card']);

	if (empty(trim($id_card))) {
		echo "<script>sweetAlert('Oops!', 'Nomor ID Card harus diisi!', 'error');</script>";
		echo "<audio autoplay><source src='".base('music/error2.wav')."'></audio>";
	} else {
		$sql = "SELECT * FROM tbl_guru WHERE id_card = '$id_card' ";
		$exc = mysqli_query($link, $sql);
		$cek = mysqli_num_rows($exc);
		$hari = date('w');
		$hariini = hari($hari);
		$hariday = addslashes($hariini);
		$tglskrg = date('Y-m-d');

		if ($cek != 0) {

			$data = mysqli_fetch_array($exc);
			$idg	= $data['id'];

			$sqlnow = " SELECT * FROM tbl_harian WHERE idg = '$idg' ";
			$sqlnow .= " AND tanggal = '$tglskrg' ";

			$excnow = mysqli_query($link, $sqlnow);
			$ceknow = mysqli_num_rows($excnow);

			if ($ceknow != 0 ) {
				echo "<script>sweetAlert('Oops!', 'Maaf! Absensi tidak bisa dilakukan 2x!', 'error');</script>";
			} else {

				$jam_msk = date('H:i:s');
				$hariini = addslashes($hariini);
				$sqlin = "INSERT INTO tbl_harian (id, idg, hari, tanggal, jam_msk) ";
				$sqlin .= " VALUES (null, '$idg', '$hariini', '$tglskrg', '$jam_msk')";

				$excin = mysqli_query($link, $sqlin);

				if ($excin === TRUE) {

					$sqlshow = "SELECT * FROM tbl_harian JOIN tbl_guru ON tbl_harian.idg = tbl_guru.id WHERE tanggal = '$tglskrg' AND tbl_harian.idg = '$idg' ";

					$excshow = mysqli_query($link, $sqlshow);
					$show = mysqli_fetch_array($excshow); ?>

					<script type="text/javascript">
						$(function(){
							$('#detail').fadeOut(5000);

							$("#sidebar").load("data-masuk.php");
						});
					</script>

					<br> <br>
					<div id="detail">
						<div class="col-md-6">
							<table class="table">
								<tr>
									<th colspan="3">Selamat Datang, <?php echo $show['nama_guru']; ?></th>
								</tr>
								<tr>
									<td>Nama Guru</td>
									<td>:</td>
									<td><?php echo $show['nama_guru']; ?></td>
								</tr>
								<tr>
									<td>Nomor ID Card</td>
									<td>:</td>
									<td><?php echo $show['id_card']; ?></td>
								</tr>
								<tr>
									<th colspan="4">Masuk pada</th>
								</tr>
								<tr>
									<td>Hari</td>
									<td>:</td>
									<td><?php echo $show['hari']; ?></td>
								</tr>
								<tr>
									<td>Tanggal</td>
									<td>:</td>
									<td><?php echo $show['tanggal']; ?></td>
								</tr>
								<tr>
									<td>Jam</td>
									<td>:</td>
									<td><?php echo $show['jam_msk']; ?></td>
								</tr>
							</table>
						</div>
						<div class="col-md-6">
							<img src="../images/guru/<?= $show['id_card']; ?>.jpg" width="265px" alt="" />
						</div>
					</div> <!-- end of id detail -->

<?php			} else {
					echo "<script>sweetAlert('Oops!', 'Gagal mengisi absen masuk!', 'error');</script>";
					echo "<audio autoplay><source src='".base('music/error2.wav')."'></audio>";
				}

			}

		} else {
			echo "<script>sweetAlert('Oops!', 'Nomor ID Card tidak terdaftar di database!', 'error');</script>";
			echo "<audio autoplay><source src='".base('music/error2.wav')."'></audio>";
		}
	}
}
?>
						</div>
					</div> <!-- end of class panel-body -->
				</div> <!-- end of class panel -->
			</div> <!-- end of class col-md-8 -->
		</div> <!-- end of class row -->
</div> <!-- end of class container -->
<?php
require_once '../templates/footer.php';
?>
