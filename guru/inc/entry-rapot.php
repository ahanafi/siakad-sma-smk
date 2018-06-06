<?php
$nama_kelas = @$_SESSION['nama_kelas'];
$mapel_id   = @$_SESSION['mapel_id'];
$guru_id    = @$_SESSION['guru']['id'];

$sqlkls = select("*", "tbl_kelas", "nama_kelas = '$nama_kelas'");
$kls = mysqli_fetch_object($sqlkls);

$select_mpl = select('*', 'tbl_mapel', "id='$mapel_id'");
$mpl = mysqli_fetch_object($select_mpl);

$tampilsiswa = select('*', 'tbl_siswa', "rombel = '$nama_kelas'");

$sms = @$_SESSION['semester'];
?>
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
          success   : function(e){
            if (e == "A") {
              $(".k_predikat_"+ids+" option:nth-child(2)").attr({
                'selected':'selected'
              });
            } else if (e == "B") {
              $(".k_predikat_"+ids+" option:nth-child(3)").attr({
                'selected':'selected'
              });
            } else if (e == "C") {
              $(".k_predikat_"+ids+" option:nth-child(4)").attr({
                'selected':'selected'
              });
            }
          }
        });
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
            if (e == "A") {
              $(".p_predikat_"+ids+" option:nth-child(2)").attr({
                'selected':'selected'
              });
            } else if (e == "B") {
              $(".p_predikat_"+ids+" option:nth-child(3)").attr({
                'selected':'selected'
              });
            } else if (e == "C") {
              $(".p_predikat_"+ids+" option:nth-child(4)").attr({
                'selected':'selected'
              });
            } else if (e == "D") {
              $(".p_predikat_"+ids+" option:last-child").attr({
                'selected':'selected'
              });
            }
          }
        });
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
          //console.log(data);
          }
        });
      }
    });

    $("#list-data").dataTable({
      'pageLength' : 50
    });
  });
</script>

<div class="col-md-12">
  <h4>Opsi Nilai</h4>
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
  </table>
  <table class="table table-bordered" id="list-data">
    <thead>
      <tr>
        <th rowspan="2" class="ctr">No.</th>
        <th rowspan="2" class="ctr">Nama Siswa</th>
        <th colspan="2" class="ctr">Pengetahuan</th>
        <th colspan="2" class="ctr">Keterampilan</th>
        <th rowspan="2" class="ctr">Aksi</th>
      </tr>
      <tr>
        <th class="ctr">Angka</th>
        <th class="ctr">Predikat</th>
        <th class="ctr">Angka</th>
        <th class="ctr">Predikat</th>
      </tr>
    </thead>
    <tbody>

    <?php while ($sis = mysqli_fetch_object($tampilsiswa)) : ?>

      <tr class="<?= $sis->id; ?>">
        <td class="ctr"><?= $no++; ?></td>
        <td>
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
