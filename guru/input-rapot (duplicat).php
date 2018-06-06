<?php
include_once '../function/core.php';

$nama_kelas = @$_SESSION['nama_kelas'];
$mapel_id 	= @$_SESSION['mapel_id'];
$guru_id    = @$_SESSION['guru']['id'];
$sms 		= @$_SESSION['semester'];

//Selecting data mapel
$sqlmapel = select("*", "tbl_mapel", "id = '$mapel_id'");
$mpl = mysqli_fetch_object($sqlmapel);

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
  <script type="text/javascript" src="<?= base('assets/js/jquery.js'); ?>"></script>
  <script type="text/javascript" src="<?= base('assets/js/bootstrap.min.js'); ?>"></script>
  <script type="text/javascript" src="<?= base('assets/js/sweetalert.min.js'); ?>"></script>
  <script type="text/javascript" src="<?= base('assets/dataTables/js/jquery.dataTables.min.js'); ?>"></script>
  <script type="text/javascript" src="<?= base('assets/dataTables/js/dataTables.bootstrap.js'); ?>"></script>
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
  </script>
	<script type="text/javascript">
	  $(document).ready(function() {
	    //Auto select p_angka with p_predikat
	    $("input[name=k_angka]").on("click", function(){
	      var ids = $(this).attr('data-ids');

	      $(this).on("keyup", function(){
	        var k_agk = $(this).val();

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
		              $(".k_predikat_"+ids+" option:nth-child(2)").attr({
		                'selected':'selected'
		              });
		            } else if (y.predikat == "B") {
		              $(".k_predikat_"+ids+" option:nth-child(3)").attr({
		                'selected':'selected'
		              });
		            } else if (y.predikat == "C") {
		              $(".k_predikat_"+ids+" option:nth-child(4)").attr({
		                'selected':'selected'
		              });
		            }

					var coba = $(".pth_des_"+ids).text();

		            if (coba == y.deskripsi) {
		            	$(".ktr_des_"+ids).append("");	
		            } else {
		            	$(".ktr_des_"+ids).append(y.deskripsi);
		            }
		        });
	          }
	        });//end of ajax

			if($(".k_angka_"+ids).val() == ""){
				$(".ktr_des_"+ids).text("");
				
				$(".k_predikat_"+ids+" option:nth-child(2)").attr({});
				$(".k_predikat_"+ids+" option:nth-child(3)").attr({});
				$(".k_predikat_"+ids+" option:nth-child(4)").attr({});
				$(".k_predikat_"+ids+" option:first-child").attr({
					'selected':'selected'
				});
			}


	      });
	    });


	    //Auto select p_angka with p_predikat
	    $("input[name=p_angka]").on("click", function(){
	      var ids = $(this).attr('data-ids');

	      $(this).on("keyup", function(){
	        var p_agk = $(this).val();

	        $.ajax({
	          method    : "POST",
	          url       : "cek.php?q=pth",
	          cache     : false,
	          data      : {
	            p_angka : p_agk
	          },
	          success   : function(e){
				var dta = JSON.parse(e);
				
				$.each(dta, function(a, b){
		            if (b.predikat == "A") {
		              $(".p_predikat_"+ids+" option:nth-child(2)").attr({
		                'selected':'selected'
		              });
		            } else if (b.predikat == "B") {
		              $(".p_predikat_"+ids+" option:nth-child(3)").attr({
		                'selected':'selected'
		              });
		            } else if (b.predikat== "C") {
		              $(".p_predikat_"+ids+" option:nth-child(4)").attr({
		                'selected':'selected'
		              });
		            }

					var test = $(".pth_des_"+ids).text();

		            if (test == b.deskripsi) {
		            	$(".pth_des_"+ids).append("");	
		            } else {
		            	$(".pth_des_"+ids).append(b.deskripsi);
		            }
		            
				});
	          }
	        });// end of ajax

			if($(".p_angka_"+ids).val() == ""){
				$(".pth_des_"+ids).text("");
				
				$(".p_predikat_"+ids+" option:nth-child(2)").attr({});
				$(".p_predikat_"+ids+" option:nth-child(3)").attr({});
				$(".p_predikat_"+ids+" option:nth-child(4)").attr({});
				$(".p_predikat_"+ids+" option:first-child").attr({
					'selected':'selected'
				});
			}

	      });
	    });


	    $(".btn-act").on("click", function() {
	      //Mengambil data pengenal
	      var id_siswa = $(this).attr('data-id');

	      //Mengambil nilai dari form nilai
	      var p_angka = $(".p_angka_"+id_siswa).val();
	      var p_predikat = $(".p_predikat_"+id_siswa).val();
	      var k_angka = $(".k_angka_"+id_siswa).val();
	      var k_predikat = $(".k_predikat_"+id_siswa).val();
	      var rapot = "rapot";

	      if(p_angka == "" || p_predikat == "" || k_angka == "" || k_predikat == ""){
	        sweetAlert('Oops!', 'Form nilai harus diisi!', 'error');
	        $("button.confirm").click(function() {
	          window.history.go(-0);
	        });
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
	              // $(".xx_"+id_siswa).slideUp();
	              // console.log(data);
	              $(".p_angka_"+id_siswa).hide();
	              $(".p_predikat_"+id_siswa).hide();
	              $(".k_angka_"+id_siswa).hide();
	              $(".k_predikat_"+id_siswa).hide();
	              $("#submit-"+id_siswa).attr({
	                'class':'btn btn-default btn-act disabled'
	              });

	              //Div
	              $(".pa_"+id_siswa).append(p_angka);
	              $(".pp_"+id_siswa).append(p_predikat);
	              $(".ka_"+id_siswa).append(k_angka);
	              $(".kp_"+id_siswa).append(k_predikat);

	            } else {
	              alert("Gagal memasukkan nilai ke system!");
	            }
	          }
	        });
	      }
	    });
	  });
	</script>
<body>
	<div class="container-fluid">
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
					        <th rowspan="2" class="ctr">No.</th>
					        <th rowspan="2" class="ctr">Nama Siswa</th>
					        <th colspan="3" class="ctr">Pengetahuan</th>
					        <th colspan="3" class="ctr">Keterampilan</th>
					        <th rowspan="2" class="ctr">Aksi</th>
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

					      <tr class="<?= $sis->id; ?>">
					        <td class="ctr"><?= $no++; ?></td>
					        <td style="width: 200px;">
					          <?php
					            $namasiswa = strtolower($sis->nama);
					            $ns = ucwords($namasiswa);
					            echo $ns;
					            ?>          
					        </td>
					        <td class="ctr">
					          <?php
					            //echo open_form('', 'post', "class='form-group'");
					            echo input('number', 'p_angka', "class='form-control p_angka_$sis->id' style='width:70px !important;' data-ids='$sis->id'");

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
					            echo select_open('p_predikat', "class='form-control p_predikat_$sis->id'");
					            echo option('', '', '');
					            echo option('A', '', 'A');
					            echo option('B', '', 'B');
					            echo option('C', '', 'C');
					            echo select_close();
					          ?>

					          <div class="pp_<?= $sis->id; ?>"></div>

					        </td>
					        <td class="pth_des_<?= $sis->id; ?>" style="font-size: 12px !important;min-width: 200px;">
					        </td>
					        <td class="ctr">
					          <?php
					            echo input('number', 'k_angka', "class='form-control k_angka_$sis->id'  style='width:70px !important;' data-ids='$sis->id' ");
					          ?>

					          <div class="ka_<?= $sis->id; ?>"></div>

					        </td>
					        <td class="ctr">
					          <?php
					            echo select_open('k_predikat', "class='form-control k_predikat_$sis->id'");
					            echo option('', '', '');
					            echo option('A', '', 'A');
					            echo option('B', '', 'B');
					            echo option('C', '', 'C');
					            echo option('D', '', 'D');
					            echo select_close();
					          ?>
					          <div class="kp_<?= $sis->id; ?>"></div>

					        </td>
					        <td class="ktr_des_<?= $sis->id; ?>" style="font-size: 12px !important;min-width: 200px;">
					        </td>
					        <td class="ctr" id="act">
					          <button type="submit" name="submit" data-id="<?= $sis->id; ?>" class="btn btn-default btn-act" id="submit-<?= $sis->id; ?>">
					            <span class="glyphicon glyphicon-floppy-disk"></span>
					          </button>
					          <?php //echo close_form(); ?>
					        </td>
					      </tr>

					    <?php endwhile; ?>

					    </tbody>
					  </table>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>