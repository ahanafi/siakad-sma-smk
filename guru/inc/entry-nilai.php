<?php
$kelas_id   = @$_SESSION['kelas_id'];
$mapel_id   = @$_SESSION['mapel_id'];
$guru_id    = @$_SESSION['guru']['id'];
$type_nilai = @$_SESSION['type_nilai'];

$select_kls = select('*', 'tbl_kelas', "id='$kelas_id'");
$data_kls = mysqli_fetch_object($select_kls);

$select_mpl = select('*', 'tbl_mapel', "id='$mapel_id'");
$mpl = mysqli_fetch_object($select_mpl);

$tampilsiswa = select('*', 'tbl_siswa', "rombel = '$data_kls->nama_kelas'");

$sms = @$_SESSION['semester'];
?>
<script type="text/javascript">
  $(document).ready(function() {
    $(".btn-act").on("click", function() {
      //Mengambil data pengenal
      var id_siswa = $(this).attr('data-id');

      //Mengambil nilai dari form nilai
      var p_angka = $(".p_angka_"+id_siswa).val();
      var p_predikat = $(".p_predikat_"+id_siswa).val();
      var k_angka = $(".k_angka_"+id_siswa).val();
      var k_predikat = $(".k_predikat_"+id_siswa).val();

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
            alert('gagal!');
          }
          //console.log(data);
        }
      });
    }
    });

    $(".btn-send").on("click", function() {
      var id_s = $(this).attr('data-id');

      //Mengambil nilai1 - nilai6
      var nil1 = $(".nilai1_"+id_s).val();
      var nil2 = $(".nilai2_"+id_s).val();
      var nil3 = $(".nilai3_"+id_s).val();
      var nil4 = $(".nilai4_"+id_s).val();
      var nil5 = $(".nilai5_"+id_s).val();
      var nil6 = $(".nilai6_"+id_s).val();

      if (nil1 == "" || nil2 == "" || nil3 == "" || nil4 == "" || nil5 == "" || nil6 == "") {
        sweetAlert('Oops!', 'Form nilai harus diisi!', 'error');
        $("button.confirm").click(function() {
          window.history.go(-0);
        });
      } else {
        $.ajax({
          method    : "POST",
          url       : "aksi.php",
          cache     : false,
          data      : {
            nilai1 : nil1,
            nilai2 : nil2,
            nilai3 : nil3,
            nilai4 : nil4,
            nilai5 : nil5,
            nilai6 : nil6,
            siswaid: id_s
          },
          success   : function(notice){
            if (notice == "true") {

              //Menghilangkan element
              $(".nilai1_"+id_s).hide();
              $(".nilai2_"+id_s).hide();
              $(".nilai3_"+id_s).hide();
              $(".nilai4_"+id_s).hide();
              $(".nilai5_"+id_s).hide();
              $(".nilai6_"+id_s).hide();
              $("#subnilhar-"+id_s).hide();

              //Memunculka nilai
              $(".nil1_"+id_s).append(nil1);
              $(".nil2_"+id_s).append(nil2);
              $(".nil3_"+id_s).append(nil3);
              $(".nil4_"+id_s).append(nil4);
              $(".nil5_"+id_s).append(nil5);
              $(".nil6_"+id_s).append(nil6);
              $(".ket_"+id_s).append("Sukses!");

            } else {
              sweetAlert('Oops!', 'Gagal mengisi nilai harian!', 'error');
            }
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
      <td><?= strtoupper($type_nilai); ?></td>
    </tr>
    <tr>
      <td>Kelas</td>
      <td>:</td>
      <td><?= $data_kls->nama_kelas; ?></td>
    </tr>
    <tr>
      <td>Mata Pelajaran</td>
      <td>:</td>
      <td><?= $mpl->nama_mapel; ?></td>
    </tr>
  </table>

<?php if ($type_nilai == "harian") { ?>

  <table class="table table-bordered" id="list-data">
    <thead>
      <tr>
        <th rowspan="2" class="ctr">No.</th>
        <th rowspan="2" class="ctr">Nama Siswa</th>
        <th colspan="6" class="ctr">Nilai</th>
        <th rowspan="2" class="ctr">Aksi</th>
      </tr>
      <tr>
        <th class="ctr">Nilai 1</th>
        <th class="ctr">Nilai 2</th>
        <th class="ctr">Nilai 3</th>
        <th class="ctr">Nilai 4</th>
        <th class="ctr">Nilai 5</th>
        <th class="ctr">Nilai 6</th>
      </tr>
    </thead>
    <tbody>

    <?php while ($ss = mysqli_fetch_object($tampilsiswa)) :  ?>

      <tr>
        <td class="ctr"><?= $no++; ?></td>
        <td><?= $ss->nama++; ?></td>
        <td class="ctr">
          <?php echo input('number', 'nilai1', "class='form-control nilai1_$ss->id' style='width:70px;'"); ?>
          <div class="nil1_<?= $ss->id; ?>"></div>
        </td>
        <td class="ctr">
          <?php echo input('number', 'nilai2', "class='form-control nilai2_$ss->id' style='width:70px;'"); ?>
          <div class="nil2_<?= $ss->id; ?>"></div>
        </td>
        <td class="ctr">
          <?php echo input('number', 'nilai3', "class='form-control nilai3_$ss->id' style='width:70px;'"); ?>
          <div class="nil3_<?= $ss->id; ?>"></div>
        </td>
        <td class="ctr">
          <?php echo input('number', 'nilai4', "class='form-control nilai4_$ss->id' style='width:70px;'"); ?>
          <div class="nil4_<?= $ss->id; ?>"></div>
        </td>
        <td class="ctr">
          <?php echo input('number', 'nilai5', "class='form-control nilai5_$ss->id' style='width:70px;'"); ?>
          <div class="nil5_<?= $ss->id; ?>"></div>
        </td>
        <td class="ctr">
          <?php echo input('number', 'nilai6', "class='form-control nilai6_$ss->id' style='width:70px;'"); ?>
          <div class="nil6_<?= $ss->id; ?>"></div>
        </td>
        <td class="ctr">
          <a href="#" class="btn btn-default btn-send" id="subnilhar-<?= $ss->id; ?>" data-id="<?= $ss->id; ?>">
            <span class="glyphicon glyphicon-floppy-disk"></span>
          </a>
          <div class="ket_<?= $ss->id; ?>"></div>
        </td>
      </tr>

    <?php endwhile; ?>

    </tbody>
  </table>

<?php } else { ?>

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

      <tr class="xx_<?= $sis->id; ?>">
        <td class="ctr"><?= $no++; ?></td>
        <td><?= $sis->nama; ?></td>
        <td class="ctr">
          <?php
            //echo open_form('', 'post', "class='form-group'");
            echo input('number', 'p_angka', "class='form-control p_angka_$sis->id' style='width:70px !important;'  ");

            //input type hidden
            echo input('hidden', 'id_siswa', "value='$sis->id' id='id_siswa'");
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
            echo option('D', '', 'D');
            echo select_close();
          ?>

          <div class="pp_<?= $sis->id; ?>"></div>

        </td>
        <td class="ctr">
          <?php
            echo input('number', 'k_angka', "class='form-control k_angka_$sis->id'  style='width:70px !important;'");
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

<?php }  ?>

</div>
