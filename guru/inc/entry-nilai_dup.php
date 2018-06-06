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
        }, // end of data
        success : function(data){
          if (data == 'true') {

            //Make hidden all for input text
            // $(".p_angka_"+id_siswa).hide();
            // $(".p_predikat_"+id_siswa).hide();
            // $(".k_angka_"+id_siswa).hide();
            // $(".k_predikat_"+id_siswa).hide();
            //
            // $(".p_a_"+id_siswa).append(p_angka);
            // $(".p_p_"+id_siswa).append(p_predikat);
            // $(".k_a_"+id_siswa).append(k_angka);
            // $(".k_p_"+id_siswa).append(k_predikat);
            //
            // $("#submit-"id_siswa+).attr({
            //   'disabled':'disabled'
            // });

          } else {
            alert('gagal!');
          }
          //console.log(data);
        }); // end of success
      }); // end of ajax method


    }); //end of event click button
  }); //end of document ready function
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
            echo input('hidden', 'id_siswa', "value='$sis->id' id='id_siswa'");
            echo input('hidden', 'id_mapel', "value='$mapel_id' id='id_mapel'");
            echo input('hidden', 'id_guru', "value='$guru_id' id='id_guru'");
            echo input('hidden', 'id_sms', "value='$sms' id='id_sms'");
          ?>
          <div class="p_a_<?= $sis->id ?>">

          </div>
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
          <div class="p_p_<?= $sis->id ?>">

          </div>
        </td>
        <td class="ctr">
          <?php
            echo input('number', 'k_angka', "class='form-control k_angka_$sis->id'  style='width:70px !important;'");
          ?>
          <div class="k_a_<?= $sis->id ?>">

          </div>
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
          <div class="k_p_<?= $sis->id ?>">

          </div>
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
