<?php
if (isset($_POST['result'])) {
  $mapel = anti_inject($_POST['mapel']);
  $kelas = anti_inject($_POST['nama_kelas']);

  if (empty(trim($mapel)) || empty(trim($kelas))) {
    echo "<script>sweetAlert('Oops!', 'Form tidak boleh ada yang kosong!', 'error');</script>";
    echo location(base('guru/lihat-nilai'));
  } else {
    $sqlkelas = select('*', 'tbl_kelas', "nama_kelas='$kelas'");
    $exkelas = mysqli_fetch_object($sqlkelas);

    //Daftar Siswa
    $sqlrapot = select("*", "tbl_siswa", "rombel = '$exkelas->nama_kelas'");

    //Nama Mapel
    $sqlmapel = select('nama_mapel', 'tbl_mapel', "id = '$mapel'");
    $_SESSION['mapel_id'] = $mapel;
    $_SESSION['kelas_id'] = $exkelas->id;
    $exmapel = mysqli_fetch_object($sqlmapel);
    $no=1;
?>
<script type="text/javascript">
  $(document).ready(function(){
    $("#masterTable").DataTable({
      'pageLength' : 50
    });

    $(".row > .col-sm-6:first").append(' <a href="<?= base('guru/lihat-nilai'); ?>" class="btn btn-primary">Kembali</a>');
    $(".row > .col-sm-6:first").append(' <a href="javascript:document.location.reload(true)" class="btn btn-primary">Refresh  <span class="glyphicon glyphicon-refresh"></span></a>');

    $(".dataTables_length, #table-data_info").css({'display':'none'});
    $("#tmasterTable_info").remove();
    $("#tmasterTable_wrapper > .row:last > .col-sm-5").remove();
    $("#tmasterTable_wrapper > .row:last > .col-sm-7").attr({
      'class':'col-sm-12'
    });

    $(".dataTables_filter").css({'float':'right'});
    $("footer").css({'bottom':'0px'});
    $(".btn_edit").on("click", function(){
      var id = $(this).attr('data-id');
      var elementRow = $('.row_'+id);

      //Create temporary value
      var temp_pth_angka = $(".row_"+id+" > td:nth-child(3)").text();
      var temp_pth_predikat = $(".row_"+id+" > td:nth-child(4)").text();
      var temp_ktr_angka = $(".row_"+id+" > td:nth-child(5)").text();
      var temp_ktr_predikat = $(".row_"+id+" > td:nth-child(6)").text();

      temp_pth_angka = temp_pth_angka.replace(/\s/g, '');
      temp_pth_predikat = temp_pth_predikat.replace(/\s/g, '');
      temp_ktr_angka = temp_ktr_angka.replace(/\s/g, '');
      temp_ktr_predikat = temp_ktr_predikat.replace(/\s/g, '');

      //Hide the text in the field table row
      $(".row_"+id+" > td:nth-child(3)").text('');
      $(".row_"+id+" > td:nth-child(4)").text('');
      $(".row_"+id+" > td:nth-child(5)").text('');
      $(".row_"+id+" > td:nth-child(6)").text('');
      $(".btn_click_"+id).hide();

      //Show the input text
      $(".row_"+id+" > td:nth-child(3)").append("<input type='text' value='"+temp_pth_angka+"' oninput='maxChars(this, 2)' maxlength='2' class='form-control pth_agk_"+id+"'>");
      $(".row_"+id+" > td:nth-child(4)").append("<input type='text' value='"+temp_pth_predikat+"' class='form-control pth_pred_"+id+"' disabled>");
      $(".row_"+id+" > td:nth-child(5)").append("<input type='text' value='"+temp_ktr_angka+"' oninput='maxChars(this, 2)' maxlength='2' class='form-control ktr_agk_"+id+"'>");
      $(".row_"+id+" > td:nth-child(6)").append("<input type='text' value='"+temp_ktr_predikat+"' class='form-control ktr_pred_"+id+"' disabled>");
      $(".row_"+id+" > td:last-child").append("<button type='button' class='btn btn-primary btn_save btn_smpn_"+id+"' data-ids='"+id+"'><span class='glyphicon glyphicon-floppy-disk'></span></button>");
      $(".row_"+id+" > td:last-child").append("  <button type='button' class='btn btn-default btn_close btn_cls_"+id+"' data-ids='"+id+"'><span class='glyphicon glyphicon-remove'></span></button>");
      $(".row_"+id+" > td > input").css({
        'width':'50px'
      });

      $(".btn_cls_"+id).click(function(){
        $(".row_"+id+" td > input").remove();
        $(".row_"+id+" td:nth-child(3)").text(temp_pth_angka);
        $(".row_"+id+" td:nth-child(4)").text(temp_pth_predikat);
        $(".row_"+id+" td:nth-child(5)").text(temp_ktr_angka);
        $(".row_"+id+" td:nth-child(6)").text(temp_ktr_predikat);
        $(".row_"+id+" td:last-child > .btn_cls_"+id).remove();
        $(".row_"+id+" td:last-child > .btn_smpn_"+id).remove();
        $(".btn_click_"+id).show();
      }); //end of event click class btn_close

      $('input.pth_agk_'+id).keyup(function(){
        var pth_angka = $(this).val();

        if (pth_angka.length == 2) {
          if (pth_angka < 75) {
            //Starting ajax proccessing
            $.ajax({
              method  : "POST",
              url     : "cek.php?q=otr",
              cache   : false,
              data    : {
                core : "pth"
              },
              success : function(x){
                var result = jQuery.parseJSON(x);

                $.each(result, function(a,b){
                  if (b.predikat == "C") {
                    $(".row_"+id+" > td:nth-child(4) > input").val(b.predikat);
                  }
                });
              }
            });
          }else{
            $.ajax({
              method  : "POST",
              url     : "cek.php?q=pth",
              cache   : false,
              data    : {
                p_angka : pth_angka
              },
              success : function(msg){
                var data = jQuery.parseJSON(msg);
                $.each(data, function(u,v){
                  if (v.predikat == "A" || v.predikat == "B" || v.predikat == "C") {
                    $(".row_"+id+" > td:nth-child(4) > input").val(v.predikat);
                  }
                })
              }

            })
          }
        }
        if (pth_angka == "" || pth_angka.length == 1) {
          $(".row_"+id+" > td:nth-child(4) > input").val('');
        }
      }); //end of keyup event input

      $('input.ktr_agk_'+id).keyup(function(){
        var ktr_angka = $(this).val();
        if (ktr_angka.length == 2) {
          if (ktr_angka < 75) {
            $.ajax({
              method  : "POST",
              url     : "cek.php?q=otr",
              cache   : false,
              data    : {core : "ktr"},
              success : function(psn){
                var hasil = jQuery.parseJSON(psn);
                $.each(hasil, function(e,f){
                  if (f.predikat == "C") {
                    $(".row_"+id+" > td:nth-child(6) > input").val(f.predikat);
                  }
                })
              }
            })
          } else {
            $.ajax({
              method  : "POST",
              url     : "cek.php?q=ktr",
              cache   : false,
              data    : {
                k_angka : ktr_angka
              },
              success : function(sms){
                var hsl = jQuery.parseJSON(sms);
                $.each(hsl, function(m,n){
                  if (n.predikat == "A" || n.predikat == "B" || n.predikat == "C") {
                    $(".row_"+id+" > td:nth-child(6) > input").val(n.predikat);
                  }
                })
              }
            })
          }
        }
        if (ktr_angka == "" || ktr_angka.length == 1) {
          $(".row_"+id+" > td:nth-child(6) > input").val('');
        }
      }); //end of keyup event input

      $(".btn_save").click(function(){
        //Getting value from input
        var pth_agk = $('.pth_agk_'+id).val();
        var pth_pred = $('.pth_pred_'+id).val();
        var ktr_agk = $('.ktr_agk_'+id).val();
        var ktr_pred = $('.ktr_pred_'+id).val();

        var data = {
          jenis : "rapot",
          p_agk : pth_agk,
          p_pre : pth_pred,
          k_agk : ktr_agk,
          k_pre : ktr_pred,
          s_id  : id
        };

        if (pth_agk == "" || pth_pred == "" || ktr_agk == "" || ktr_pred == "") {
          sweetAlert('Oops!', 'Form tidak boleh ada yang kosong!', 'error');
        } else {
          $.ajax({
            method  : "POST",
            url     : "cek.php?q=edit",
            cache   : false,
            data    : data,
            success : function(callback){
              if (callback == "true") {
                $(".row_"+id+" > td > input").hide();
                $(".row_"+id+" > td:nth-child(3)").text(pth_agk);
                $(".row_"+id+" > td:nth-child(4)").text(pth_pred);
                $(".row_"+id+" > td:nth-child(5)").text(ktr_agk);
                $(".row_"+id+" > td:nth-child(6)").text(ktr_pred);
                $(".row_"+id+" > td:last-child > button").remove();
                $(".row_"+id+" > td:last-child").append("<button type='button' class='btn btn-default btn_edit btn_click_"+id+"' data-id='"+id+"'><span class='glyphicon glyphicon-pencil'></span></button>");
                document.location.reload(true);
              }
            }
          });
        }
      }); // end of click even class btn_save
    }); //end of on click event class btn_edit

    $(".btn_add").click(function(){
      var id = $(this).attr('data-id');
      var old_Text = "Belum ada nilai!";

      //Hide the text
      $(".row_"+id+" > td:nth-child(3)").text('');
      $(".row_"+id+" > td:nth-child(4)").text('');
      $(".row_"+id+" > td:nth-child(5)").text('');
      $(".row_"+id+" > td:nth-child(6)").text('');
      $(".row_"+id+" > td:last-child > button").hide();

      $(".row_"+id+" > td:nth-child(3)").append("<input type='text' oninput='maxChars(this, 2)' maxlength='2' class='form-control pth_agk_"+id+"'>");
      $(".row_"+id+" > td:nth-child(4)").append("<input type='text' class='form-control pth_pred_"+id+"' disabled>");
      $(".row_"+id+" > td:nth-child(5)").append("<input type='text' oninput='maxChars(this, 2)' maxlength='2' class='form-control ktr_agk_"+id+"'>");
      $(".row_"+id+" > td:nth-child(6)").append("<input type='text' class='form-control ktr_pred_"+id+"' disabled>");
      $(".row_"+id+" > td:last-child").append("<button type='button' class='btn btn-primary btn_save btn_smpn_"+id+"' data-ids='"+id+"'><span class='glyphicon glyphicon-floppy-disk'></span></button>");
      $(".row_"+id+" > td:last-child").append("  <button type='button' class='btn btn-default btn_close btn_cls_"+id+"' data-ids='"+id+"'><span class='glyphicon glyphicon-remove'></span></button>");

      $('input.pth_agk_'+id).keyup(function(){
        var pth_angka = $(this).val();

        if (pth_angka.length == 2) {
          if (pth_angka < 75) {
            //Starting ajax proccessing
            $.ajax({
              method  : "POST",
              url     : "cek.php?q=otr",
              cache   : false,
              data    : {
                core : "pth"
              },
              success : function(x){
                var result = JSON.parse(x);

                $.each(result, function(a,b){
                  if (b.predikat == "C") {
                    $(".row_"+id+" > td:nth-child(4) > input").val(b.predikat);
                  }
                });
              }
            });
          }else{
            $.ajax({
              method  : "POST",
              url     : "cek.php?q=pth",
              cache   : false,
              data    : {
                p_angka : pth_angka
              },
              success : function(msg){
                var data = JSON.parse(msg);
                $.each(data, function(u,v){
                  if (v.predikat == "A" || v.predikat == "B" || v.predikat == "C") {
                    $(".row_"+id+" > td:nth-child(4) > input").val(v.predikat);
                  }
                })
              }

            });
          }
        }
        if (pth_angka == "") {
          $(".row_"+id+" > td:nth-child(4) > input").val('');
        }
      }); //end of keyup event input

      $('input.ktr_agk_'+id).keyup(function(){
        var ktr_angka = $(this).val();
        if (ktr_angka.length == 2) {
          if (ktr_angka < 75) {
            $.ajax({
              method  : "POST",
              url     : "cek.php?q=otr",
              cache   : false,
              data    : {core : "ktr"},
              success : function(psn){
                var hasil = jQuery.parseJSON(psn);
                $.each(hasil, function(e,f){
                  if (f.predikat == "C") {
                    $(".row_"+id+" > td:nth-child(6) > input").val(f.predikat);
                  }
                })
              }
            })
          } else {
            $.ajax({
              method  : "POST",
              url     : "cek.php?q=ktr",
              cache   : false,
              data    : {
                k_angka : ktr_angka
              },
              success : function(sms){
                var hsl = jQuery.parseJSON(sms);
                $.each(hsl, function(m,n){
                  if (n.predikat == "A" || n.predikat == "B" || n.predikat == "C") {
                    $(".row_"+id+" > td:nth-child(6) > input").val(n.predikat);
                  }
                })
              }
            })
          }
        }
        if (ktr_angka == "") {
          $(".row_"+id+" > td:nth-child(6) > input").val('');
        }
      }); //end of keyup event input

      $(".btn_smpn_"+id).click(function(){
        //Getting value from input
        var pth_agk = $('.pth_agk_'+id).val();
        var pth_pred = $('.pth_pred_'+id).val();
        var ktr_agk = $('.ktr_agk_'+id).val();
        var ktr_pred = $('.ktr_pred_'+id).val();

        var data = {
          jenis : "rapot",
          p_agk : pth_agk,
          p_pre : pth_pred,
          k_agk : ktr_agk,
          k_pre : ktr_pred,
          s_id  : id
        };

        if (pth_agk == "" || pth_pred == "" || ktr_agk == "" || ktr_pred == "") {
          sweetAlert('Oops!', 'Form tidak boleh ada yang kosong!', 'error');
        } else {
          $.ajax({
            method  : "POST",
            url     : "cek.php?q=add",
            cache   : false,
            data    : data,
            success : function(callback){
              if (callback == "true") {
                $(".row_"+id+" > td > input").hide();
                $(".row_"+id+" > td:nth-child(3)").text(pth_agk);
                $(".row_"+id+" > td:nth-child(4)").text(pth_pred);
                $(".row_"+id+" > td:nth-child(5)").text(ktr_agk);
                $(".row_"+id+" > td:nth-child(6)").text(ktr_pred);
                $(".row_"+id+" > td:last-child > button").remove();
                $(".row_"+id+" > td:last-child").append("<button type='button' class='btn btn-default btn_edit btn_click_"+id+"' data-id='"+id+"'><span class='glyphicon glyphicon-pencil'></span></button>");
                //document.location.reload(true);
              }
            }
          });
        }
      }); // end of click even class btn_save
      
      $(".btn_cls_"+id).click(function(){
        //Hide all form
        $(".row_"+id+" > td > input ").remove();
        $(".btn_cls_"+id).remove();
        $(".btn_smpn_"+id).remove();
        $(".row_"+id+" td:nth-child(3)").text(old_Text);
        $(".row_"+id+" > td:nth-child(4) ").text('-');
        $(".row_"+id+" > td:nth-child(5) ").text(old_Text);
        $(".row_"+id+" > td:nth-child(6) ").text('-');
        $(".row_"+id+" > td:last-child > .btn_add ").show();
      })
    });

  });
</script>
<style>
  #masterTable td:nth-child(3){
    text-align: center !important;
  }
  #masterTable td > input, td input{
    width: 50px !important;
    background: #fff !important;
  }
  input[disabled]{
    border:none !important;
    box-shadow: 0px 0px 0px #fff;
  }
</style>
<table class="table">
  <tr>
    <td>Tipe Nilai</td>
    <td>:</td>
    <td>Nilai Rapot</td>
  </tr>
  <tr>
    <td>Kelas</td>
    <td>:</td>
    <td><?= $kelas; ?></td>
  </tr>
  <tr>
    <td>Wali Kelas</td>
    <td>:</td>
    <td><?= $exkelas->wali_kelas; ?></td>
  </tr>
  <tr>
    <td>Mata Pelajaran</td>
    <td>:</td>
    <td><?= $exmapel->nama_mapel; ?></td>
  </tr>
</table>
<table class="table table-bordered" id="masterTable">
  <thead>
    <tr>
      <th rowspan="2" class="ctr" style="width: 30px !important;">No</th>
      <th rowspan="2" style="width: 240px !important;text-align: center;">Nama Siswa</th>
      <th colspan="2" class="ctr">Pengetahuan</th>
      <th colspan="2" class="ctr">Keterampilan</th>
      <th rowspan="2" class="ctr" style="width: 100px !important;">Opsi</th>
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
    while ($x = mysqli_fetch_object($sqlrapot)):
      $sqlnil = select('*', 'tbl_rapot', "id_siswa='$x->id' AND id_mapel = '$mapel'");
      $y = mysqli_fetch_object($sqlnil);
  ?>

    <tr class="row_<?= $x->id; ?>">
      <td class="ctr"><?= $no++; ?></td>
      <td><?= $x->nama; ?></td>
      <td class="ctr">
        <?php if($y->p_angka != NULL) { echo $y->p_angka; } else { echo "Belum ada nilai!"; } ?>
      </td>
      <td class="ctr">
        <?php if($y->p_angka != NULL) { echo $y->p_predikat; } else { echo "-"; } ?>
      </td>
      <td class="ctr">
        <?php if($y->p_angka != NULL) { echo $y->k_angka; } else { echo "Belum ada nilai!"; } ?>
      </td>
      <td class="ctr">
        <?php if($y->p_angka != NULL) { echo $y->k_predikat; } else { echo "-"; } ?>
      </td>
      <td class="ctr">
        <?php if ($y->p_angka != NULL) { ?>
        <button type="button" class="btn btn-default btn_edit btn_click_<?=$x->id;?>" data-id="<?= $x->id; ?>"><span class="glyphicon glyphicon-pencil"></span></button>
        <?php } else { ?>
        <button type="button" class="btn btn-default btn_add btn_simpan_<?=$x->id;?>" data-id="<?=$x->id;?>"><span class="glyphicon glyphicon-plus"></span></button>
        <?php } ?>
      </td>
    </tr>

  <?php endwhile; ?>

  </tbody>
</table>
<?php     
  }

} else {
  redirect(base('guru/lihat-nilai'));
}


?>
