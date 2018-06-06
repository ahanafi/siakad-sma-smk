<?php
include_once '../function/core.php';

if (empty($_SESSION['guru']['id_card'])) {
	redirect(base('guru/login'));
}

$nama_kelas = @$_SESSION['nama_kelas'];
$mapel_id 	= @$_SESSION['mapel_id'];
$guru_id    = @$_SESSION['guru']['id'];
$sms 		= @$_SESSION['semester'];

//Selecting data mapel
$sqlmapel = select("*", "tbl_mapel", "id = '$mapel_id'");
$mpl = mysqli_fetch_object($sqlmapel);

//KKM
$kkmsql = select("*", "tbl_kkm", "kode_mapel = '$mpl->kode_mapel'");
$exkkm = mysqli_fetch_object($kkmsql);

//Selecting data kelas
$sqlkls = select("*","tbl_kelas", "nama_kelas = '$nama_kelas'");
$kls = mysqli_fetch_object($sqlkls);

//Selecting student
$sqlsis = select("*", "tbl_siswa", "rombel = '$nama_kelas'");

$no = 1;

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Entry Nilai Rapot</title>
</head>
  <link rel="stylesheet" href="<?= base('assets/css/admin.css'); ?>" media="screen" title="no title">
  <link rel="stylesheet" href="<?= base('assets/css/guru.css'); ?>" media="screen" title="no title">
  <link rel="stylesheet" href="<?= base('assets/css/bootstrap.css'); ?>" media="screen" title="no title">
  <link rel="stylesheet" href="<?= base('assets/css/sweetalert.css'); ?>" media="screen" title="no title">
  <link rel="stylesheet" href="<?= base('assets/dataTables/css/dataTables.bootstrap.css'); ?>" media="screen" title="no title">
  <link rel="shortcut icon" href="<?= base('images/favicon.png'); ?>">
  <script type="text/javascript" src="<?= base('assets/js/jquery.js'); ?>"></script>
  <script type="text/javascript" src="<?= base('assets/js/bootstrap.min.js'); ?>"></script>
  <script type="text/javascript" src="<?= base('assets/js/sweetalert.min.js'); ?>"></script>
  <script type="text/javascript" src="<?= base('assets/dataTables/js/jquery.dataTables.min.js'); ?>"></script>
  <script type="text/javascript" src="<?= base('assets/dataTables/js/dataTables.bootstrap.js'); ?>"></script>
  <style>
  	#list-data > tbody > tr > td{
  		vertical-align: middle !important;
  	}

  	textarea{
  		resize: none !important; 
  	}
  </style>
  <script type="text/javascript">
  	$(document).ready(function(){
  		$("thead > tr > th").addClass("ctr");
  		$("#list-data").dataTable({
	      'pageLength' : 50
	    });
  		$("#main-data").DataTable({
  			'pageLength':8
  		});
  		$("#list-data_paginate > ul").remove();

  		var btn_end = "<a href='<?= base('guru/dashboard'); ?>' class='btn btn-lg btn-success'>SELESAI  &nbsp; <span class='glyphicon glyphicon-ok'></span></a>";
  		$("#list-data_paginate").append(btn_end);
  	});
	function maxChars(el, max){
		if (el.value.length > el.maxLength) {
			el.value = el.value.slice(0, el.maxLength);
		}
	}
  </script>
	<script type="text/javascript">
	  $(document).ready(function() {
	    //Auto select p_angka with p_predikat
	    $("input[name=p_angka]").keyup(function(){
	    	var ids = $(this).attr('data-ids');
	    	var p_agk = $(this).val();

	    	if (p_agk.length == 2) {
	    		if (p_agk < 75) {
	        		$.ajax({
	        			method 	: "POST",
	        			url 	: "cek.php?q=otr",
	        			async 	: true,
	        			cache	: false,
	        			data 	: {core : "pth"},
	        			success : function(sms){
	        				var hsl = jQuery.parseJSON(sms);
	        				$.each(hsl, function(u,v){
	        					if (v.predikat == "C") {
	        						$(".p_predikat_"+ids).val(v.predikat);
	        						$(".pth_des_"+ids).val(v.deskripsi);
	        					}
	        				});
	        			}
	        		});
	    		} else {
			        $.ajax({
			          method    : "POST",
			          url       : "cek.php?q=pth",
			          cache     : false,
			          data      : {
			            p_angka : p_agk
			          },
			          success   : function(e){
			          	console.log(e);
						var dta = JSON.parse(e);
						
						$.each(dta, function(a, b){
				            if (b.predikat == "A") {
				              $(".p_predikat_"+ids).val("A");
				              $(".pth_des_"+ids).val(b.deskripsi);
				            } else if (b.predikat == "B") {
				              $(".p_predikat_"+ids).val("B");
				              $(".pth_des_"+ids).val(b.deskripsi);
				            } else if (b.predikat== "C") {
				              $(".p_predikat_"+ids).val("C");
				              $(".pth_des_"+ids).val(b.deskripsi);
				            }
						});
			          }
			        });// end of ajax
	    		}
	    	}
			if($(".p_angka_"+ids).val() == "" || p_agk.length < 2){
				$(".pth_des_"+ids).val("");
				$(".p_predikat_"+ids).val("");
			}
	    });
	    //Auto select k_angka with k_predikat
	    $("input[name=k_angka]").on("keyup", function(){
	      	var ids = $(this).attr('data-ids');
	        var k_agk = $(this).val();

	        if (k_agk.length == 2) {
	        	if (k_agk < 75) {
	        		$.ajax({
	        			method 	: "POST",
	        			url 	: "cek.php?q=otr",
	        			async 	: true,
	        			cache 	: false,
	        			data 	: {
	        				core : "ktr"
	        			},
	        			success : function(cb){
	        				var rslt = jQuery.parseJSON(cb);
	        				
	        				$.each(rslt, function(p,q){
	        					if (q.predikat == "C") {
	        						$(".k_predikat_"+ids).val(q.predikat);
	        						$(".ktr_des_"+ids).val(q.deskripsi);
	        					}
	        				});
	        			}
	        		});
	        	} else {
			        $.ajax({
			          method    : "POST",
			          url       : "cek.php?q=ktr",
			          cache     : false,
			          data      : {
			            k_angka : k_agk
			          },
			          success   : function(ef){
			          	var dta = JSON.parse(ef);

			          	$.each(dta, function(x, y){
				            if (y.predikat == "A") {
				              $(".k_predikat_"+ids).val(y.predikat);
				              $(".ktr_des_"+ids).val(y.deskripsi);
				            } else if (y.predikat == "B") {
				              $(".k_predikat_"+ids).val(y.predikat);
				              $(".ktr_des_"+ids).val(y.deskripsi);
				            } else if (y.predikat == "C") {
				              $(".k_predikat_"+ids).val(y.predikat);
				              $(".ktr_des_"+ids).val(y.deskripsi);
				            }
				        });
			          }
			        });//end of ajax
				}
		    }
			if($(".k_angka_"+ids).val() == ""){
				$(".ktr_des_"+ids).val("");
				$(".k_predikat_"+ids).val("");
			}
	    }); // end of input k_angka keyup event
	    $(".btn-act").on("click", function() {
	      //Mengambil data pengenal
	      var id_siswa = $(this).attr('data-id');
	      var sukses = "<span class='glyphicon glyphicon-ok' style='font-size:15px;font-weight:bold'></span>";

	      //Mengambil nilai dari form nilai
	      var p_angka = $(".p_angka_"+id_siswa).val();
	      var p_predikat = $(".p_predikat_"+id_siswa).val();
	      var k_angka = $(".k_angka_"+id_siswa).val();
	      var k_predikat = $(".k_predikat_"+id_siswa).val();
	      var rapot = "rapot";

	      if(p_angka == "" || p_predikat == "" || k_angka == "" || k_predikat == ""){
	        sweetAlert('Oops!', 'Form nilai harus diisi!', 'error');
	      } else {

			$.ajax({
				method : "POST",
				url    : "aksi.php",
				cache  : false,
				data   : {
					jenis : rapot,
					p_agk : p_angka,
					p_pre : p_predikat,
					k_agk : k_angka,
					k_pre : k_predikat,
					s_id  : id_siswa
				},
				success : function(data){
					if (data == 'true') {
						$(".p_angka_"+id_siswa).hide();
						$(".p_predikat_"+id_siswa).hide();
						$(".k_angka_"+id_siswa).hide();
						$(".k_predikat_"+id_siswa).hide();
						$("#submit-"+id_siswa).hide();

						//Div
						$(".pa_"+id_siswa).append(p_angka);
						$(".pp_"+id_siswa).append(p_predikat);
						$(".ka_"+id_siswa).append(k_angka);
						$(".kp_"+id_siswa).append(k_predikat);
						$("#act_"+id_siswa).append(sukses);

					} else {
						sweetAlert('Oops!', 'Proses input nilai ke system gagal!', 'error');
					}
				}
			});
	      }
	    });
	  });
	</script>
<body>
	<?php include_once '../templates/header.php'; ?>
	<div class="container-fluid" style="margin-top: 60px;">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<b>Entry Nilai Rapot</b>
					</div>
					<div class="panel-body">
						<a href="<?= base('guru/dashboard'); ?>" class="btn btn-primary">Kembali ke Menu utama</a>
						<br> <br>
					  <table class="table table-striped">
					    <tr>
					      <td>Tipe Nilai</td>
					      <td>:</td>
					      <td>Nilai Rapot</td>
					    </tr>
					    <tr>
					      <td>Kelas</td>
					      <td>:</td>
					      <td><?= $nama_kelas; ?></td>
					    </tr>
					    <tr>
					    	<td>Wali Kelas</td>
					    	<td>:</td>
					    	<td><?= $kls->wali_kelas; ?></td>
					    </tr>
					    <tr>
					      <td>Mata Pelajaran</td>
					      <td>:</td>
					      <td><?= $mpl->nama_mapel; ?></td>
					    </tr>
					    <tr>
					    	<td>KKM</td>
					    	<td>:</td>
					    	<td><?= $exkkm->kkm; ?></td>
					    </tr>
					  </table>
					  <table class="table table-bordered" id="list-data">
					    <thead style="background: #428bca;color: #fff;">
					      <tr>
					        <th rowspan="2" class="ctr" style="vertical-align: middle;">No.</th>
					        <th rowspan="2" class="ctr" style="vertical-align: middle;">Nama Siswa</th>
					        <th colspan="3" class="ctr">Pengetahuan</th>
					        <th colspan="3" class="ctr">Keterampilan</th>
					        <th rowspan="2" class="ctr" style="vertical-align: middle;">Aksi</th>
					      </tr>
					      <tr>
					        <th class="ctr">Angka</th>
					        <th class="ctr">Predikat</th>
					        <th class="ctr">Deskripsi</th>
					        <th class="ctr">Angka</th>
					        <th class="ctr">Predikat</th>
					        <th class="ctr">Deskripsi</th>
					      </tr>
					    </thead>
					    <tbody>

					    <?php while ($sis = mysqli_fetch_object($sqlsis)) : ?>

					      <tr class="row_<?= $sis->id; ?>">
					        <td class="ctr"><?= $no++; ?></td>
					        <td style="width: 200px;">
					          <?php
					            $namasiswa = strtolower($sis->nama);
					            $ns = ucwords($namasiswa);
					            echo $ns;

					            $sqlcek = select("*", "tbl_rapot", "id_mapel = '$mapel_id' AND id_siswa = '$sis->id'");
					            $cek = mysqli_num_rows($sqlcek);
					            ?>
					        </td>
					        <?php if ($cek > 0) {
					        	$data = mysqli_fetch_object($sqlcek);
					        ?>
					        <td class="ctr">
					        	<?= $data->p_angka; ?>
					        </td>
					        <td class="ctr">
					        	<?= $data->p_predikat; ?>
					        </td>
					        <td style="font-size: 11px;">
					        	<?php
					        		//Selecting mapel data
					        		$sqlmp = select("*", "tbl_mapel", "id = '$mapel_id'");
					        		$mp = mysqli_fetch_object($sqlmp);

					        		//Selecting description
					        		$sqldp = select("*", "tbl_deskripsi_pth", "kode_mapel = '$mp->kode_mapel' AND predikat = '$data->p_predikat' AND semester = '$sms'");
					        		$dp = mysqli_fetch_object($sqldp);

					        		echo $dp->deskripsi;
					        	?>
					        </td>
					        <td class="ctr">
					        	<?= $data->k_angka; ?>
					        </td>
					        <td class="ctr">
					        	<?= $data->k_predikat; ?>
					        </td>
					        <td style="font-size: 11px;">
					        	<?php
					        		//Selecting description
					        		$sqldk = select("*", "tbl_deskripsi_ktr", "kode_mapel = '$mp->kode_mapel' AND predikat = '$data->k_predikat' AND semester = '$sms'");
					        		$dk = mysqli_fetch_object($sqldk);

					        		echo $dk->deskripsi;
					        	?>
					        </td>
					        <td class="ctr" style="font-weight: bold;font-size: 16px;">
					        	<span class="glyphicon glyphicon-ok"></span>
					        </td>
						
						<?php } else { ?>

					        <td class="ctr">
					          <?php
					            echo input('number', 'p_angka', "maxlength='2' oninput='maxChars(this, 2);' class='form-control p_angka_$sis->id' style='width:50px !important;' data-ids='$sis->id'");

					            //input type hidden
					            echo input('hidden', 'id_siswa', "value='$sis->id' class='id_siswa'");
					            echo input('hidden', 'id_mapel', "value='$mapel_id' id='id_mapel'");
					            echo input('hidden', 'id_guru', "value='$guru_id' id='id_guru'");
					            echo input('hidden', 'id_sms', "value='$sms' id='id_sms'");
					          ?>
					          <div class="pa_<?= $sis->id; ?>"></div>

					        </td>
					        <td class="ctr">
					          <?php
					            echo input('text', 'p_predikat', "class='form-control p_predikat_$sis->id' style='width:50px !important;background:#fff;border:none;' disabled");
					          ?>

					          <div class="pp_<?= $sis->id; ?>"></div>

					        </td>
					        <td style="min-width: 200px;">
					        	<textarea style="font-size:11px !important;background: #fff;border:none !important;" cols="30" rows="5" name="pth_des_" class="form-control pth_des_<?= $sis->id; ?>" disabled></textarea>
					        </td>
					        <td class="ctr">
					          <?php
					            echo input('number', 'k_angka', "class='form-control k_angka_$sis->id'  style='width:50px !important;' data-ids='$sis->id' ");
					          ?>

					          <div class="ka_<?= $sis->id; ?>"></div>

					        </td>
					        <td class="ctr">
					          <?php
					            echo input('text', 'k_predikat', "class='form-control k_predikat_$sis->id' style='width:50px;background:#fff;border:none;' disabled");
					          ?>
					          <div class="kp_<?= $sis->id; ?>"></div>

					        </td>
					        <td style="min-width: 200px;">
					        	<textarea style="font-size:11px !important;background: #fff;border:none !important;" cols="30" rows="5" name="pth_des_" class="form-control ktr_des_<?= $sis->id; ?>" disabled></textarea>
					        </td>
					        <td class="ctr" id="act_<?= $sis->id; ?>">
					          <button type="submit" name="submit" data-id="<?= $sis->id; ?>" class="btn btn-default btn-act" id="submit-<?= $sis->id; ?>" data-toggle="tooltip" data-placement="top" title="Simpan">
					            <span class="glyphicon glyphicon-floppy-disk"></span>
					          </button>
					          <?php //echo close_form(); ?>
					        </td>
					      </tr>

					    <?php
					    	}
					    endwhile;
					    ?>

					    </tbody>
					  </table>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>