<?php
$id = anti_inject($_GET['id']);
$id = abs((int) $id);
$sqlst = select("*", "tbl_siswa", "id='$id'");
$st = mysqli_fetch_object($sqlst);
$n = $no;
$num = $n;

//Cek prestasi
$sqlcekpres = select("*", "tbl_prestasi", "id_siswa='$id'");
$cekpres = mysqli_num_rows($sqlcekpres);

//Cek ekskul
$sqlcekexk = select("*", "tbl_ekskul", "id_siswa='$id'");
$cekexk = mysqli_num_rows($sqlcekexk);

//Cek pkl
$sqlcekpkl = select("*", "tbl_prakerin", "id_siswa = '$id'");
$cekpkl = mysqli_num_rows($sqlcekpkl);

$rmbl = $k->nama_kelas;
$rmbl = substr($rmbl, 0,2);
?>
<script type="text/javascript">
	$(function(){
		$("input").attr({
			'required':'required'
		});
		$("textarea").attr({
			'required':'required'
		});
		$("select").attr({
			'required':'required'
		});
		$(".form-prestasi").hide();
		$("#btn-add-prestasi").click(function(){
			$(".form-prestasi").fadeIn('slow');
			$(".form-exkul").hide();
			$(".form-pkl").hide();
		});

		$(".form-exkul").hide();
		$("#btn-add-exk").click(function(){
			$(".form-exkul").fadeIn('slow');
			$(".form-prestasi").hide();
			$(".form-pkl").hide();
		});

		$(".form-pkl").hide();
		$("#btn-add-pkl").click(function(){
			$(".form-exkul").hide();
			$(".form-prestasi").hide();
			$(".form-pkl").fadeIn('slow');
		});

		$("#goback").click(function(){
			window.location="<?= base('guru/input-pep'); ?>";
		});
	});
</script>
<style>
	#goback{
		background: #428bca;
		border-top-right-radius: 2.5px !important;
		border-top-left-radius: 2.5px !important;
		color:#fff;
	}
</style>
<div class="col-md-12">
	<div class="row">
		<div class="col-md-9">
			<ul class="nav nav-tabs" role="tablist">
				<li class="active" role="presentation">
					<a href="#prestasi" aria-controls="prestasi" role="tab" data-toggle="tab">Prestasi</a>
				</li>
				<li role="presentation">
					<a href="#exkul" aria-controls="exkul" role="tab" data-toggle="tab">Ekstrakurikuler</a>
				</li>
				<?php if ($rmbl == 12) : ?>
				<li role="presentation">
					<a href="#prakerin" aria-controls="prakerin" role="tab" data-toggle="tab">Prakerin</a>
				</li>
				<?php endif; ?>
				<li role="presentation">
					<a href="" id="goback" aria-controls="#" role="tab" data-toggle="tab">Kembali</a>
				</li>
			</ul>
			<div class="tab-content" style="min-height: 320px;">
				<div class="tab-pane fade in active" id="prestasi">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th class="ctr" width="30px">No.</th>
								<th class="ctr">Jenis Prestasi</th>
								<th class="ctr">Tingkat</th>
								<th class="ctr">Bidang Lomba</th>
							</tr>
						</thead>
						<tbody>
						<?php
							if ($cekpres != 0) {
								while ($prs = mysqli_fetch_object($sqlcekpres)) :
						?>
							<tr>
								<td><?= $no++; ?></td>
								<td><?= $prs->jenis_prestasi; ?></td>
								<td><?= $prs->tingkat; ?></td>
								<td><?= $prs->bid_lomba; ?></td>
							</tr>
						<?php
								endwhile;
							} else {
						?>
							<tr>
								<td colspan="4" class="ctr"><strong>Tidak ada data!</strong></td>
							</tr>
						<?php
							}
						?>
						</tbody>
					</table>
					<button type="button" class="btn btn-primary" id="btn-add-prestasi">Tambah</button>
					<div class="form-prestasi" style="margin-top: 10px;">
						<form action="<?= base('guru/act'); ?>" class="form-group" method="post">
							<label for="jenis">Jenis Prestasi</label>
							<input type="text" name="jenis" class="form form-control">
							<br>

							<label for="tingkat">Tingkat</label>
							<input type="text" name="tingkat" class="form form-control">
							<br>
							<input type="hidden" name="id_siswa" value="<?=$id;?>">

							<label for="bid_lomba">Bidang Lomba</label>
							<input type="text" name="bid_lomba" class="form form-control">
							<br>

							<button type="submit" name="sub_press" class="btn btn-default">Simpan</button>
						</form>
					</div>
				</div>
				<div class="tab-pane fade" id="exkul">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th class="ctr" width="30px">No.</th>
								<th class="ctr">Kegiatan</th>
								<th class="ctr">Nilai</th>
								<th class="ctr">Deskripsi</th>
							</tr>
						</thead>
						<tbody>
						<?php
						if($cekexk != 0){
							while ($xk = mysqli_fetch_object($sqlcekexk)) :
						?>
							<tr>
								<td><?= $n++; ?></td>
								<td><?= $xk->keg_ekskul; ?></td>
								<td><?= $xk->nilai; ?></td>
								<td><?= $xk->deskripsi; ?></td>
							</tr>
						<?php
							endwhile;
						} else {
						?>
							<tr>
								<td colspan="4" class="ctr"><strong>Tidak ada data!</strong></td>
							</tr>
						<?php
							}
						?>
						</tbody>
					</table>
					<button type="button" class="btn btn-primary" id="btn-add-exk">Tambah</button>

					<div class="form-exkul" style="margin-top: 10px;">
						<form action="<?= base('guru/act'); ?>" method="post" class="form-group">
							<label for="kegiatan">Kegiatan</label>
							<input type="text" name="kegiatan" class="form form-control">
							<br>

							<label for="nilai">Nilai</label>
							<select name="nilai" class="form form-control">
								<option value="">-- Pilih Nilai --</option>
								<option value="A">A</option>
								<option value="B">B</option>
								<option value="C">C</option>
							</select>
							<br>

							<input type="hidden" name="ids" value="<?= $id; ?>">

							<label for="deskripsi">Deskripsi</label>
							<textarea name="deskripsi" rows="3" class="form form-control"></textarea>
							<br>

							<button type="submit" name="sub_exk" class="btn btn-default">Simpan</button>
						</form>
					</div>
				</div>
				<?php if ($rmbl == 12) : ?>
				<div class="tab-pane fade" id="prakerin">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th class="ctr" width="30px">No.</th>
								<th class="ctr">Mitra</th>
								<th class="ctr" width="20px">Lamanya (bln)</th>
								<th class="ctr">Alamat</th>
								<th class="ctr">Predikat</th>
								<th class="ctr">Bid. Kerja</th>
							</tr>
						</thead>
						<tbody>
						<?php
						if ($cekpkl != 0) {
							while ($pkl = mysqli_fetch_object($sqlcekpkl)) :
						?>
							<tr>
								<td class="ctr"><?= $num; ?></td>
								<td class="ctr"><?= $pkl->mitra; ?></td>
								<td class="ctr"><?= $pkl->lama; ?></td>
								<td class="ctr"><?= $pkl->alamat; ?></td>
								<td class="ctr"><?= $pkl->predikat; ?></td>
								<td class="ctr"><?= $pkl->bid_kerja; ?></td>
							</tr>
						<?php
							endwhile;
						} else { 
						?>
							<tr>
								<td class="ctr" colspan="6"><strong>Tidak Ada Data!</strong></td>
							</tr>
						<?php
						}
						?>
						</tbody>
					</table>
					<button type="button" class="btn btn-primary" id="btn-add-pkl">Tambah</button>
					<div class="form-pkl" style="margin-top: 10px;">
						<form action="<?= base('guru/act'); ?>" method="post" class="form-group">
							<label for="mitra">Mitra DU/DI</label>
							<input type="text" name="mitra" class="form form-control">
							<br>

							<label for="lama">Lamanya (bln)</label>
							<input type="number" name="lama" oninput="maxChars(this, 1)" maxlength="1" class="form form-control">
							<br>

							<label for="alamat">Alamat</label>
							<textarea name="alamat" rows="3" class="form form-control"></textarea>
							<br>

							<label for="predikat">Predikat</label>
							<select name="predikat" class="form form-control">
								<option value="">-- Pilih Predikat --</option>
								<option value="A (Baik Sekali)">A (Baik Sekali)</option>
								<option value="B (Baik)">B (Baik)</option>
								<option value="C (Cukup)">C (Cukup)</option>
							</select>
							<br>

							<input type="hidden" name="id" value="<?= $id; ?>">

							<label for="bid_kerja">Bidang Kerja</label>
							<input type="text" name="bid_kerja" class="form form-control">
							<br>

							<button type="submit" name="sub_pkl" class="btn btn-default">Simpan</button>

						</form>
					</div>
				</div>
				<?php endif; ?>
			</div>
		</div>
		<div class="col-md-3">
			<div class="panel panel-primary">
				<div class="panel-heading">
					Detail Siwa
				</div>
				<div class="panel-body">
					<table class="table">
						<tr>
							<td>Nama Siswa</td>
							<td>:</td>
							<td><?= ucwords(strtolower($st->nama)); ?></td>
						</tr>
						<tr>
							<td>Nomor Induk</td>
							<td>:</td>
							<td><?= $st->nis; ?></td>
						</tr>
						<tr>
							<td>Kelas</td>
							<td>:</td>
							<td><?= $st->rombel; ?></td>
						</tr>
						<tr>
							<td>Jenis Kelamin</td>
							<td>:</td>
							<td><?= $jk = ($st->jk == "L") ? "Laki-Laki" : "Perempuan";  ?></td>
						</tr>
					</table>
				</div> <!-- end of class panel body -->
			</div> <!-- end of class panel -->
		</div> <!-- end of class col md4 -->
	</div> <!-- end of class row -->
</div> <!-- end of class col md  12 -->