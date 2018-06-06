<?php
error_reporting(0);

if (isset($_POST['submit'])) {
	$kelas = anti_inject(@$_POST['kelas']);
	$mapel = anti_inject(@$_POST['mapel']);

	@$_SESSION['id_mapel'] = $mapel;
	if (empty(trim($kelas)) || empty(trim($mapel))) {
		echo "<script>sweetAlert('Oops!', 'Form tidak boleh ada yang kosong!', 'error');</script>";
		echo location(base('admin/nilai'));
	} else {
		$sqlkls = select("*", 'tbl_kelas', "nama_kelas='$kelas'");
		$kls = mysqli_fetch_object($sqlkls);
		//Data siswa
		$sqlsis = select("*", "tbl_siswa", "rombel = '$kls->nama_kelas'");
		$jumsis = mysqli_num_rows($sqlsis);

		$sqlmpl = select("nama_mapel,kode_mapel", "tbl_mapel", "id = '$mapel'");
		$mpl = mysqli_fetch_object($sqlmpl);

		$sql = "SELECT nama_guru,guru,kelas,mapel,tbl_jadwal.id FROM tbl_jadwal JOIN tbl_guru ON tbl_jadwal.guru = tbl_guru.id WHERE mapel = '$mapel' AND kelas = '$kls->id' LIMIT 1";
		$sqltc = mysqli_query($link, $sql);
		$gr = mysqli_fetch_object($sqltc);

		$no=1;

?>
<script type="text/javascript">
	$(function(){
		$("#main-data").dataTable({
			'pageLength':45
		});
		$("#main-data_info").remove();
		$("#main-data_length").remove();
		$("#main-data_wrapper>.row:first-child >.col-sm-6:first-child").append('<a href="<?= base('admin/nilai');?>" class="btn btn-primary">Kembali</a> ');
		$("#main-data_wrapper>.row:first-child >.col-sm-6:first-child").append(' <a href="javascript:document.location.reload(true);" class="btn btn-primary">Refresh  <span class="glyphicon glyphicon-refresh"></span></a>')

		//Handle for update value
		$(".btn_edit").click(function(){
			var id = $(this).attr('data-id');
			var id_rapot = $(this).attr('data-tbr');

			var temp_pth_angka = $(".row_"+id+" > td:nth-child(3) ").text();
			var temp_pth_predikat = $(".row_"+id+" > td:nth-child(4) ").text();
			var temp_ktr_angka = $(".row_"+id+" > td:nth-child(5) ").text();
			var temp_ktr_predikat = $(".row_"+id+" > td:nth-child(6) ").text();

			//Hide element
			$(".row_"+id+" > td:nth-child(3)").text('');
			$(".row_"+id+" > td:nth-child(4)").text('');
			$(".row_"+id+" > td:nth-child(5)").text('');
			$(".row_"+id+" > td:nth-child(6)").text('');
			$(".row_"+id+" > td:last-child > button").hide();

			var inputForm = "<input type='number' oninput='maxChars(this, 2)' maxlength='2' class='form-control' style='width:60px !important;text-align:center;'>";
			var disForm = "<input type='text' oninput='maxChars(this, 1)' maxlength='1' class='form-control' style='width:60px !important;text-align:center;' disabled>";
			var btnSave = "<button type='button' class='btn btn-primary btn_save'><span class='glyphicon glyphicon-floppy-disk'></span></button> ";
			var btnClose = "<button type='button' class='btn btn-default btn_close'><span class='glyphicon glyphicon-remove'></span></button>";

			//Show the input form
			$(".row_"+id+" > td:nth-child(3)").append(inputForm);
			$(".row_"+id+" > td:nth-child(4)").append(disForm);
			$(".row_"+id+" > td:nth-child(5)").append(inputForm);
			$(".row_"+id+" > td:nth-child(6)").append(disForm);
			$(".row_"+id+" > td:last-child").append(btnSave+" "+btnClose);

			//Add class
			$(".row_"+id+" > td:nth-child(3) > input").addClass('pth_agk_'+id);
			$(".row_"+id+" > td:nth-child(4) > input").addClass('pth_pred_'+id);
			$(".row_"+id+" > td:nth-child(5) > input").addClass('ktr_agk_'+id);
			$(".row_"+id+" > td:nth-child(6) > input").addClass('ktr_pred_'+id);
			$(".btn_save").addClass('btn_smpn_'+id);
			$(".btn_close").addClass('btn_cls_'+id);

			$(".pth_agk_"+id).val(temp_pth_angka);
			$(".pth_pred_"+id).val(temp_pth_predikat);
			$(".ktr_agk_"+id).val(temp_ktr_angka);
			$(".ktr_pred_"+id).val(temp_ktr_predikat);

			$(".pth_agk_"+id).keyup(function(){
				var pth_angka = $(this).val();
				if (pth_angka.length == 2) {
					if (pth_angka < 75) {
						$.ajax({
							method	:"POST",
							url 	: "cek.php?q=otr",
							cache 	: false,
							data 	: {
								core : "pth"
							},
							success	: function(cb){
								var data = jQuery.parseJSON(cb);
								$.each(data, function(i,n){
									if (n.predikat == "C") {
										$(".pth_pred_"+id).val(n.predikat);
									}
								});
							}
						});
					} else {
						$.ajax({
							method	: "POST",
							url 	: "cek.php?q=pth",
							data 	: {
								p_angka : pth_angka
							},
							success	: function(msg){
								var dt = jQuery.parseJSON(msg);
								$.each(dt, function(a,b){
									if (b.predikat == "A" || b.predikat == "B" || b.predikat == "C") {
										$(".pth_pred_"+id).val(b.predikat);	
									}
								})
							}
						})	
					}
				}
				if (pth_angka == "" || pth_angka.length == 1) {
					$(".pth_pred_"+id).val("");
				}
			});

			$(".ktr_agk_"+id).keyup(function(){
				var ktr_angka = $(this).val();

				if (ktr_angka.length == 2) {
					if (ktr_angka < 75) {
						$.ajax({
							method	: "POST",
							url 	: "cek.php?q=otr",
							cache 	: false,
							data 	: {
								core : "ktr"
							}, 
							success	: function(sms){
								var result = jQuery.parseJSON(sms);
								$.each(result, function(x,y){
									if (y.predikat == "C") {
										$(".ktr_pred_"+id).val(y.predikat);
									}
								})
							}
						})
					} else {
						$.ajax({
							method	: "POST",
							url		: "cek.php?q=ktr",
							cache 	: false,
							data 	: {
								k_angka : ktr_angka
							},
							success : function(rspn){
								var rslt = jQuery.parseJSON(rspn);
								$.each(rslt, function(u,v){
									if (v.predikat == "A" || v.predikat == "B" || v.predikat == "C") {
										$(".ktr_pred_"+id).val(v.predikat);
									}
								});
							}
						})
					}
				}
				if (ktr_angka == "" || ktr_angka.length == 1) {
					$(".ktr_pred_"+id).val('');
				}
			})

			$(".btn_smpn_"+id).click(function(){
				var pth_agk = $(".pth_agk_"+id).val();
				var pth_pred = $(".pth_pred_"+id).val();
				var ktr_agk = $(".ktr_agk_"+id).val();
				var ktr_pred = $(".ktr_pred_"+id).val();

				if (pth_agk == "" || pth_pred == "" || ktr_agk == "" || ktr_pred == "") {
					sweetAlert('Oops!', 'Form nilai tidak boleh ada yang kosong!', 'error');
				} else {
					//Starting ajax proccessing
					$.ajax({
						method	: "POST",
						url		: "cek.php?q=upd",
						cache	: false,
						data 	: {
							pth_agk : pth_agk,
							pth_pred : pth_pred,
							ktr_agk : ktr_agk,
							ktr_pred : ktr_pred,
							id_siswa : id,
							id_rpt : id_rapot
						},
						success	: function(ex){
							if (ex == 1) {
								//Hide the input form
								$(".row_"+id+" > td > input").remove();
								//Input the value
								$(".row_"+id+" > td:nth-child(3)").text(pth_agk);
								$(".row_"+id+" > td:nth-child(4)").text(pth_pred);
								$(".row_"+id+" > td:nth-child(5)").text(ktr_agk);
								$(".row_"+id+" > td:nth-child(6)").text(ktr_pred);

								//Hide the button
								$(".row_"+id+" > td:last-child > .btn_smpn_"+id).remove();
								$(".row_"+id+" > td:last-child > .btn_cls_"+id).remove();
								$(".row_"+id+" > td:last-child > .btn_upd_"+id).show();
							} else {
								sweetAlert('Oops!', 'Proses edit nilai tidak berhasil!', 'error');
							}
						}
					})
				}


			});

			$(".btn_cls_"+id).click(function(){
				var btnEdit = "<button type='button' class='btn btn-default btn_edit btn_upd_"+id+"' data-id='"+id +"'><span class='glyphicon glyphicon-pencil'></span></button>";
				//Hide form
				$(".row_"+id+" > input ").remove();
				$(".row_"+id+" > td:last-child > .btn_smpn_"+id).remove();
				$(".row_"+id+" > td:last-child > .btn_cls_"+id).remove();

				//Input old value
				$(".row_"+id+" > td:nth-child(3)").text(temp_pth_angka);
				$(".row_"+id+" > td:nth-child(4)").text(temp_pth_predikat);
				$(".row_"+id+" > td:nth-child(5)").text(temp_ktr_angka);
				$(".row_"+id+" > td:nth-child(6)").text(temp_ktr_predikat);
				$(".row_"+id+" > td:last-child > .btn_upd_"+id).show();
			});
		});

		//Handle for add value (nilai)
		$(".btn_add").click(function(){
			var id = $(this).attr('data-id');

			//Hide the text in the table field
			$(".row_"+id+" > td:nth-child(3)").text('');
			$(".row_"+id+" > td:nth-child(4)").text('');
			$(".row_"+id+" > td:nth-child(5)").text('');
			$(".row_"+id+" > td:nth-child(6)").text('');
			$(".row_"+id+" > td:last-child > button").hide();

			var inputForm = "<input type='number' oninput='maxChars(this, 2)' maxlength='2' class='form-control' style='width:60px !important;text-align:center;'>";
			var disForm = "<input type='text' oninput='maxChars(this, 1)' maxlength='1' class='form-control' style='width:60px !important;text-align:center;' disabled>";
			var btnSave = "<button type='button' class='btn btn-primary btn_save'><span class='glyphicon glyphicon-floppy-disk'></span></button> ";
			var btnClose = "<button type='button' class='btn btn-default btn_close'><span class='glyphicon glyphicon-remove'></span></button>";
			var btnEdit = "<button type='button' class='btn btn-default btn_edit btn_upd_"+id+"' data-id='"+id +"'><span class='glyphicon glyphicon-pencil'></span></button>";


			$(".row_"+id+" > td:nth-child(3)").append(inputForm);
			$(".row_"+id+" > td:nth-child(4)").append(disForm);
			$(".row_"+id+" > td:nth-child(5)").append(inputForm);
			$(".row_"+id+" > td:nth-child(6)").append(disForm);
			$(".row_"+id+" > td:last-child ").append(btnSave+ btnClose);

			//Add class
			$(".row_"+id+" > td:nth-child(3) > input").addClass('pth_agk_'+id);
			$(".row_"+id+" > td:nth-child(4) > input").addClass('pth_pred_'+id);
			$(".row_"+id+" > td:nth-child(5) > input").addClass('ktr_agk_'+id);
			$(".row_"+id+" > td:nth-child(6) > input").addClass('ktr_pred_'+id);
			$(".btn_save").addClass('btn_smpn_'+id);
			$(".btn_close").addClass('btn_cls_'+id);

			$(".pth_agk_"+id).keyup(function(){
				var pth_angka = $(this).val();
				if (pth_angka.length == 2) {
					if (pth_angka < 75) {
						$.ajax({
							method	:"POST",
							url 	: "cek.php?q=otr",
							cache 	: false,
							data 	: {
								core : "pth"
							},
							success	: function(cb){
								var data = jQuery.parseJSON(cb);
								$.each(data, function(i,n){
									if (n.predikat == "C") {
										$(".pth_pred_"+id).val(n.predikat);
									}
								});
							}
						});
					} else {
						$.ajax({
							method	: "POST",
							url 	: "cek.php?q=pth",
							data 	: {
								p_angka : pth_angka
							},
							success	: function(msg){
								var dt = jQuery.parseJSON(msg);
								$.each(dt, function(a,b){
									if (b.predikat == "A" || b.predikat == "B" || b.predikat == "C") {
										$(".pth_pred_"+id).val(b.predikat);	
									}
								})
							}
						})	
					}
				}
				if (pth_angka == "" || pth_angka.length == 1) {
					$(".pth_pred_"+id).val("");
				}
			});

			$(".ktr_agk_"+id).keyup(function(){
				var ktr_angka = $(this).val();

				if (ktr_angka.length == 2) {
					if (ktr_angka < 75) {
						$.ajax({
							method	: "POST",
							url 	: "cek.php?q=otr",
							cache 	: false,
							data 	: {
								core : "ktr"
							}, 
							success	: function(sms){
								var result = jQuery.parseJSON(sms);
								$.each(result, function(x,y){
									if (y.predikat == "C") {
										$(".ktr_pred_"+id).val(y.predikat);
									}
								})
							}
						})
					} else {
						$.ajax({
							method	: "POST",
							url		: "cek.php?q=ktr",
							cache 	: false,
							data 	: {
								k_angka : ktr_angka
							},
							success : function(rspn){
								var rslt = jQuery.parseJSON(rspn);
								$.each(rslt, function(u,v){
									if (v.predikat == "A" || v.predikat == "B" || v.predikat == "C") {
										$(".ktr_pred_"+id).val(v.predikat);
									}
								});
							}
						})
					}
				}
				if (ktr_angka == "" || ktr_angka.length == 1) {
					$(".ktr_pred_"+id).val('');
				}
			});

			$(".btn_cls_"+id).click(function(){
				//Hide form
				$(".row_"+id+" > input ").remove();
				$(".row_"+id+" > td:last-child > .btn_close").remove();
				$(".row_"+id+" > td:last-child > .btn_save").remove();

				//Input old value
				$(".row_"+id+" > td:nth-child(3)").text('0');
				$(".row_"+id+" > td:nth-child(4)").text('-');
				$(".row_"+id+" > td:nth-child(5)").text('0');
				$(".row_"+id+" > td:nth-child(6)").text('-');
				$(".row_"+id+" > td:last-child > .btn_tmbh_"+id).show();
			});

			$(".btn_smpn_"+id).click(function(){
				//Get the data
				var pth_agk = $(".pth_agk_"+id).val();
				var pth_pred = $(".pth_pred_"+id).val();
				var ktr_agk = $(".ktr_agk_"+id).val();
				var ktr_pred = $(".ktr_pred_"+id).val();

				if (pth_agk == "" || pth_pred == "" || ktr_agk == "" || ktr_pred == "") {
					sweetAlert("Oops!", "Form nilai tidak boleh ada yang kosong!", "error");
				} else {
					$.ajax({
						method	: "POST",
						url 	: 'cek.php?q=input',
						cache	: false,
						data 	: {
							p_agk : pth_agk,
							p_pre : pth_pred,
							k_agk : ktr_agk,
							k_pre : ktr_pred,
							id_siswa : id,
							id_mapel : <?= $mapel; ?>,
							id_kelas : <?= $kls->id; ?>
						},
						success	: function(psn){
							if (psn == "true") {
								//hide the form
								$(".row_"+id+" > td > input ").remove();
								$(".row_"+id+" > td:last-child > .btn_smpn_"+id).remove();
								$(".row_"+id+" > td:last-child > .btn_cls_"+id).remove();

								$(".row_"+id+" > td:nth-child(3)").text(pth_agk);
								$(".row_"+id+" > td:nth-child(4)").text(pth_pred);
								$(".row_"+id+" > td:nth-child(5)").text(ktr_agk);
								$(".row_"+id+" > td:nth-child(6)").text(ktr_pred);

								$(".row_"+id+" > td:last-child ").append(btnEdit);
							} else {
								sweetAlert('Oops!', 'Proses input nilai tidak berhasil', 'error');
								console.log(psn);
							}
						}
					});
				}
			});
		});

	});
</script>
<style>
	input[disabled]{
		background: #fff !important;
		border:none;
		box-shadow: none;;
	}

	thead  th {
		vertical-align: middle !important;
	}
</style>
<div class="col-md-12">
	<table class="table">
		<tr>
			<td>Nama Kelas</td>
			<td>:</td>
			<td><?= $kls->nama_kelas; ?></td>
		</tr>
		<tr>
			<td>Paket Keahlian</td>
			<td>:</td>
			<td><?= $kls->paket; ?></td>
		</tr>
		<tr>
			<td>Jumlah Siswa</td>
			<td>:</td>
			<td><?= $jumsis; ?></td>
		</tr>
		<tr>
			<td>Mata Pelajaran (Guru Pengajar)</td>
			<td>:</td>
			<td><?= $mpl->nama_mapel; ?> <strong><b>(<?= $gr->nama_guru; ?>)</b></strong> </td>
		</tr>
		<tr>
			<td>Wali Kelas</td>
			<td>:</td>
			<td><?= $kls->wali_kelas; ?></td>
		</tr>
	</table>
	<hr>
	<table id="main-data" class="table table-bordered">
		<thead>
			<tr>
				<th class="ctr" rowspan="2">No.</th>
				<th class="ctr" rowspan="2" style="width: 200px !important;">Nama Siswa</th>
				<th colspan="2" class="ctr">Pengetahuan</th>
				<th colspan="2" class="ctr">Keterampilan</th>
				<th class="ctr" rowspan="2">Aksi</th>
			</tr>
			<tr>
				<th class="ctr">Angka</th>
				<th class="ctr">Predikat</th>
				<th class="ctr">Angka</th>
				<th class="ctr">Predikat</th>
			</tr>
		</thead>
		<tbody>
		<?php
			while ($st = mysqli_fetch_object($sqlsis)) :
				$sqlrapot = select("*", "tbl_rapot", "id_siswa = '$st->id' AND id_mapel = '$mapel'");
				$ceknil = mysqli_num_rows($sqlrapot);
			?>
			<tr class="row_<?= $st->id; ?>">
				<td class="ctr"><?= $no++; ?></td>
				<td><?= $st->nama; ?></td>
				<?php if ($ceknil != 0) { $n = mysqli_fetch_object($sqlrapot); ?>
				<td class="ctr"><?= $n->p_angka; ?></td>
				<td class="ctr"><?= $n->p_predikat; ?></td>
				<td class="ctr"><?= $n->k_angka; ?></td>
				<td class="ctr"><?= $n->k_predikat; ?></td>
				<td class="ctr">
					<button type="button" class="btn btn-default btn_edit btn_upd_<?= $st->id; ?>" data-id="<?=$st->id;?>" data-tbr="<?= $n->id; ?>"><span class="glyphicon glyphicon-pencil"></span></button>
				</td>
				<?php } else { ?>
				<td class="ctr">0</td>
				<td class="ctr">-</td>
				<td class="ctr">0</td>
				<td class="ctr">-</td>
				<td class="ctr">
					<button class="btn btn-default btn_add btn_tmbh_<?= $st->id; ?>" data-id="<?= $st->id; ?>"><span class="glyphicon glyphicon-plus"></span></button>
				</td>
				<?php } ?>
			</tr>
		<?php endwhile; ?>
		</tbody>
	</table>
</div>


<?php
	}
} else {
	redirect(base('admin/nilai'));
}

?>