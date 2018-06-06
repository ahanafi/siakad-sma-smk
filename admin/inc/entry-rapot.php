<?php

if (isset($_POST['submit'])) {

	$kelas = anti_inject(@$_POST['kelas']);
	$sqljum = select('*', 'tbl_siswa', "rombel = '$kelas'");
	$jumsis = mysqli_num_rows($sqljum);

	$sqlkls = select("id, wali_kelas", "tbl_kelas", "nama_kelas = '$kelas' LIMIT 1");
	$kls = mysqli_fetch_object($sqlkls);

	$sms = @$_SESSION['semester'];

	$id_mapel = anti_inject(@$_POST['mapel']);
	$sqlmpl = select("*", "tbl_mapel", "id = '$id_mapel' LIMIT 1");
	$mpl = mysqli_fetch_object($sqlmpl);
	$no = 1;
	@$_SESSION['id_mapel'] = $id_mapel;
?>


<script type='text/javascript' language="javascript">
$(document).ready(function(){
	$("button.btn_click").click(function(){
		var id = $(this).attr('data-id');

		//Mengambil nilai dari form
		var p_angka = $(".p_angka_"+id).val();
		var p_predikat = $(".p_predikat_"+id).val();
		var k_angka = $(".k_angka_"+id).val();
		var k_predikat = $(".k_predikat_"+id).val();

		//Data lainnya
		var id_mapel = $("input[name=id_mapel]").val();
		var ok = ("<span class='glyphicon glyphicon-ok' style='font-weight:bold;'></span>")

		//Cek isi data
		if (p_angka == "" || p_predikat == "" || k_angka == "" || k_predikat == "") {
			sweetAlert('Oops!', 'Form tidak boleh ada yang kosong!', 'error');
		} else {
			$.ajax({
				method 	: "POST",
				url 	: "cek.php?q=input",
				async 	: true,
				cache 	: false,
				data 	: {
					jenis : "rapot",
					id_mapel : id_mapel,
					p_agk : p_angka,
					p_pre : p_predikat,
					k_agk : k_angka,
					k_pre : k_predikat,
					id_siswa : id,
					id_kelas : <?= $kls->id; ?>
				},
				success	: function(mx){
					if (mx == 'true') {
						//Hide/remove
						$(".p_angka_"+id).remove();
						$(".p_predikat_"+id).remove();
						$(".k_angka_"+id).remove();
						$(".k_predikat_"+id).remove();
						$("#submit-"+id).remove();

						//Div
						$(".pa_"+id).append(p_angka);
						$(".pp_"+id).append(p_predikat);
						$(".ka_"+id).append(k_angka);
						$(".kp_"+id).append(k_predikat);
						$(".sub_"+id).append(ok);
					} else {
						sweetAlert('Oops!', 'Gagal memasukkan nilai rapot ke dalam System!', 'error');
						console.log(mx);
					}
				}
			});
		}
	});

	$("input[name=p_angka]").keyup(function(){
		var id = $(this).attr('data-ids');
		var id_mapel = $("input[name=id_mapel]").val();
				var p_akg = $(".p_angka_"+id).val();

		if (p_akg.length == 2){
			if (p_akg < 75) {
				$.ajax({
					method	: "POST",
					url 	: "cek.php?q=otr",
					async	: true,
					cache 	: false,
					data 	: {
						id_mapel : id_mapel,
						core 	 : "pth"
					},
					success : function(sms){
						var result = jQuery.parseJSON(sms);

						$.each(result, function(m,n){
							if (n.predikat == "C") {
								$(".p_predikat_"+id).val(n.predikat);
								$(".pth_des_"+id).val(n.deskripsi);
							}
						});
					}
				});
			} else {
				$.ajax({
					method	: "POST",
					url		: "cek.php?q=pth",
					async 	: true,
					cache 	: false,
					data 	: {
						id_mapel : id_mapel,
						p_angka : p_akg
					},
					success : function(e){
						//var data = JSON.parse(e);
						var data = jQuery.parseJSON(e);

						$.each(data, function(a,b){
							if (b.predikat == "A" || b.predikat == "B" || b.predikat == "C" ) {
								$(".p_predikat_"+id).val(b.predikat);
								$(".pth_des_"+id).val(b.deskripsi);
							}
						});
					}
				});
			}
		}
		if ($(".p_angka_"+id).val() == "") {
			$(".p_predikat_"+id).val("");
			$(".pth_des_"+id).val("");
		}
	});

	$("input[name=k_angka]").keyup(function(){
		var id = $(this).attr('data-ids');
		var id_mapel = $("input[name=id_mapel]").val();
		var k_akg = $(".k_angka_"+id).val();

		if (k_akg.length == 2) {
			if (k_akg < 75) {
				$.ajax({
					method 	: "POST",
					url 	: "cek.php?q=otr",
					async	: true,
					cache 	: false,
					data 	: {
						id_mapel : id_mapel,
						core 	 : 'ktr' 
					},
					success	: function(msg){
						var hasil = jQuery.parseJSON(msg);

						console.log(hasil);

						$.each(hasil, function(x,y){
							if (y.predikat == "C") {
								$(".k_predikat_"+id).val(y.predikat);
								$(".ktr_des_"+id).val(y.deskripsi);								
							}
						});
					}
				});
			} else {
				$.ajax({
					method	: "POST",
					url		: "cek.php?q=ktr",
					async 	: true,
					cache 	: false,
					data 	: {
						id_mapel : id_mapel,
						k_angka : k_akg
					},
					success : function(back){
						var data = jQuery.parseJSON(back);

						$.each(data, function(i,n){
							if (n.predikat == "A" || n.predikat == "B" || n.predikat == "C" ) {
								$(".k_predikat_"+id).val(n.predikat);
								$(".ktr_des_"+id).val(n.deskripsi);
							}
						});
					}
				});
			}
		}
		if ($(".k_angka_"+id).val() == "") {
			$(".k_predikat_"+id).val("");
			$(".ktr_des_"+id).val("");
		}
	});

	$("td > input").css({
		'text-align':'center',
		'margin':'0 auto'
	});
	(".ctr").css({
		'text-align':'center'
	})
});
</script>
<style>
	thead > tr > th, tbody > tr > td{
		vertical-align: middle !important;
	}
	td> input.form-control{
		width: 35px !important;
		padding: 8px !important;
		box-shadow: none !important;
	}
	input[name=p_predikat], input[name=k_predikat]{
		width:35px !important;
		background:#fff !important;
		box-shadow: none !important;
	}
	input[disabled],input[disabled]:hover{
		cursor: default !important;
		border:none !important;
	}
	textarea{
		font-size:11px !important;
		background: #fff !important;
		border:none !important;
		font-size: 11px !important;
		cursor: default !important;
	}
</style>
<div class="col-md-12">
	<div class="row">
		<table class="table">
			<tr>
				<td>Nama Kelas</td>
				<td>:</td>
				<td><?= $kelas; ?></td>
			</tr>
			<tr>
				<td>Wali Kelas</td>
				<td>:</td>
				<td><?= $kls->wali_kelas; ?></td>
			</tr>
			<tr>
				<td>Jumlah Siswa</td>
				<td>:</td>
				<td><?= $jumsis; ?></td>
			</tr>
			<tr>
				<td>Mata Pelajaran</td>
				<td>:</td>
				<td><?= $mpl->nama_mapel; ?></td>
			</tr>
		</table>
		<hr>
		<table class="table table-bordered table-responsive">
			<thead>
				<tr>
					<th class="ctr" rowspan="2">No.</th>
					<th rowspan="2">Nama Siswa</th>
					<th class="ctr" colspan="3">Pengetahuan</th>
					<th class="ctr" colspan="3">Keterampilan</th>
					<th class="ctr" rowspan="2">Aksi</th>
				</tr>
				<tr>
					<th class="ctr" style="width: 20px;">Angka</th>
					<th class="ctr">Predikat</th>
					<th class="ctr" style="width:200px; ">Deskripsi</th>
					<th class="ctr">Angka</th>
					<th class="ctr">Predikat</th>
					<th class="ctr" style="width:200px; ">Deskripsi</th>
				</tr>
			</thead>
			<tbody>
			<?php while ($s = mysqli_fetch_object($sqljum)) : ?>
				<tr>
					<td class="ctr"><?= $no++; ?></td>
					<td width="200px">
						<?php
							$nama = ucwords(strtolower($s->nama));
							echo $nama;

				            $sqlcek = select("*", "tbl_rapot", "id_mapel = '$id_mapel' AND id_siswa = '$s->id'");
				            $cek = mysqli_num_rows($sqlcek);
						?>
							
					</td>
					<?php
						if ($cek > 0) {
							$nils = mysqli_fetch_object($sqlcek);
					?>
					<td class="ctr">
						<?= $nils->p_angka; ?>
					</td>
					<td class="ctr">
						<?= $nils->p_predikat; ?>
					</td>
					<td style="font-size: 11px;">
						<?php
						$sqlmp = select("kode_mapel", "tbl_mapel", "id = '$id_mapel'");
						$mp = mysqli_fetch_object($sqlmp);
						$sqldp = select("*", "tbl_deskripsi_pth", "kode_mapel = '$mp->kode_mapel' AND predikat = '$nils->p_predikat' AND semester = '$sms'");
						$dp = mysqli_fetch_object($sqldp);
						echo $dp->deskripsi;
						?>
					</td>
					<td class="ctr">
						<?= $nils->k_angka; ?>
					</td>
					<td class="ctr">
						<?= $nils->k_predikat; ?>
					</td>
					<td style="font-size:11px;">
						<?php
						$sqldk = select("*", "tbl_deskripsi_ktr", "kode_mapel = '$mp->kode_mapel' AND predikat = '$nils->k_predikat' AND semester = '$sms'");
						$dk = mysqli_fetch_object($sqldk);
						echo $dk->deskripsi;
						?>
					</td>
					<td class="ctr" style="font-weight: bolder;">
						<span class="glyphicon glyphicon-ok"></span>
					</td>
					<?php } else { ?>
					<td class="ctr">
						<input type="number" name="p_angka" maxlength="2" oninput="maxChars(this, 2)" class="form form-control p_angka_<?=$s->id;?>" data-ids="<?=$s->id;?>">
						<input type="hidden" name="id_mapel" value="<?= $id_mapel; ?>">
						<div class="pa_<?=$s->id;?>"></div>
					</td>
					<td class="ctr">
						<input type="text" name="p_predikat" class="form form-control p_predikat_<?=$s->id;?>" disabled>
						<div class="pp_<?=$s->id;?>"></div>
					</td>
					<td class="ctr">
						<textarea class="form-control pth_des_<?=$s->id;?>" cols="30" rows="5" disabled></textarea>
					</td>
					<td class="ctr">
						<input type="number" name="k_angka" maxlength="2" oninput="maxChars(this, 2)" class="form form-control k_angka_<?=$s->id;?>" data-ids="<?=$s->id;?>">
						<div class="ka_<?=$s->id;?>"></div>
					</td>
					<td class="ctr">
						<input type="text" name="k_predikat" class="form form-control k_predikat_<?=$s->id;?>" disabled>
						<div class="kp_<?=$s->id;?>"></div>
					</td>
					<td class="ctr">
						<textarea class="form-control ktr_des_<?=$s->id;?>" cols="30" rows="5" disabled></textarea>
					</td>
					<td class="ctr sub_<?=$s->id;?>">
						<button type="button" id="submit-<?=$s->id;?>" class="btn btn-default btn_click" data-id="<?=$s->id;?>"><span class="glyphicon glyphicon-floppy-disk"></span></button>
					</td>
					<?php } ?>
				</tr>
			<?php endwhile; ?>
			</tbody>
		</table>
	</div>
</div>

<?php

} else {
	redirect(base('admin/entry-nilai'));
}
?>