<?php
$sqlkode  = select('MAX(id_card)', 'tbl_guru');
$exkode   = mysqli_fetch_assoc($sqlkode);

$kode     = $exkode['MAX(id_card)']+1;

if (strlen($kode) == 1) {
  $jadikode = "0000".$kode;
} else if(strlen($kode) == 2) {
  $jadikode = "000".$kode;
} else if(strlen($kode) == 3) {
  $jadikode = "00".$kode;
} else if(strlen($kode) == 4) {
  $jadikode = "0".$kode;
} else if(strlen($kode) == 5) {
  $jadikode = $kode;
}

?>
<style>
  table > tbody > tr > td, table > thead > tr > th{
    vertical-align: middle !important;
  }
</style>
<div class="col-md-12">
  <h3>Tambah Data Guru</h3>
  <hr>

  <?php
    echo open_form('', 'post', "class='form-group' enctype='multipart/form-data'");
    echo "<div class='col-md-6'>";
    echo label('nama_guru', 'Nama Guru');
    echo input('text', 'nama_guru', "class='form-control'")."<br>";

    echo label('tmp_lahir', 'Tempat Lahir');
    echo input('text', 'tmp_lahir', "class='form-control'")."</br>";

    echo label('tgl_lahir', 'Tanggal Lahir');
    echo input('date', 'tgl_lahir', "class='form-control'")."</br>";

    echo label('jk', 'Jenis Kelamin');
    echo select_open('jk', "class='form-control'");
    echo option('','','-- Pilih Jenis Kelamin --');
    echo option("L", '', 'Laki-Laki');
    echo option("P", '', 'Perempuan');
    echo select_close()."</br>";

    echo label('telp', 'Nomor Telpon/HP');
    echo input('number', 'telp', "class='form-control'")."</br>";
    echo "</div>";

    echo "<div class='col-md-6'>";
    echo label('nip', 'NIP');
    echo input('number', 'nip', "class='form-control'")."<br>";

    echo label('jenis_ptk', 'Jenis PTK');
    echo select_open('jenis_ptk',"class='form-control ptk'");
    echo option('','','-- Pilih Jenis --');
    echo option('Guru Mapel','','Guru Mapel');
    echo option('Guru','','Guru');
    echo option('Tata Usaha','','Tata Usaha');
    echo option('Tim IT', '', 'Tim IT');
    echo option('Lainnya','','Lainnya');
    echo select_close()."<br>";

    echo label('id_card', 'Nomor ID Card');
    echo input('number', 'id_card', "class='form-control' value='$jadikode' disabled")."<br>";

    echo label('foto', 'Foto');
    echo input('file', 'foto', "class='form-control'")."<br>";

    echo input('hidden', 'id_mapel', "class='form-control' id='mapel_id'")."</br> ";
    echo input('submit', 'submit', "class='btn btn-primary' value='Tambahkan'"). " &nbsp; ";
    echo input('button', 'kembali', "class='btn btn-default' id='back' value='Kembali'");

    echo "</div>";
  ?>
</div>
<!-- Modal -->
<div class="modal fade" id="GuruMapel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Pilih Mata Pelajaran</h4>
      </div>
      <div class="modal-body">
        <select name="kelompok_mapel" id="kelmap" class="form-control">
          <option value="">-- Pilih Kelompok Mata Pelajaran --</option>
          <option value="A">Kelompok A (Wajib)</option>
          <option value="B">Kelompok B (Wajib)</option>
          <option value="C">Kelompok C (Peminatan)</option>
        </select>
        <br>
        <div class="piljur">
          <select name="jurusan" id="pilih_jurusan" class='form-control'>
            <option value="">-- Pilih Jurusan --</option>
            <option value="AK">Akuntansi</option>
            <option value="AP">Administrasi Perkantoran</option>
            <option value="MM">Multimedia</option>
            <option value="PM">Pemasaran</option>
            <option value="PB">Perbankan</option>
            <option value="UPW">Usaha Perjalanan Wisata</option>
          </select>
        </div>
        <br>
        <div class="chexbox_mapel">
          <table class="table table-bordered" id="table_mapel">
            <thead>
              <tr>
                <th>Check</th>
                <th>Kode Mapel</th>
                <th>Nama Mapel</th>
                <th>Kelas</th>
              </tr>
            </thead>
            <tbody id="table-body">
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <button type="button" id="save" class="btn btn-primary">Simpan</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    $(".piljur").hide();
    $("#table_mapel").hide();
    $("#list-kelas").hide();

    $(".ptk").change(function(){
      var ptk = $(this).val();

      if (ptk == "Guru Mapel") {
        $("#GuruMapel").modal('show');
      }
    });//end of PTK

    $("#kelmap").change(function(){
      var kel = $(this).val();

      if (kel == "C") {
        $(".piljur").fadeIn(1000);
        $("#table_mapel").hide();

        $("#pilih_jurusan").on("change", function(){
          var jurusan = $(this).val();

          $.ajax({
            method  : "POST",
            url     : "proses-mapel.php?q=mapel",
            cache   : false,
            data    : {
              kelompok : kel,
              jur      : jurusan
            },
            success  : function(x){
              var data = JSON.parse(x);
              $("#table-body > tr").remove();

              $("#table_mapel").fadeIn(500);
              $.each(data, function(i, n){
                $("#table-body").append("<tr><td class='ctr'><input type='checkbox' name='id_mapel' data-id='"+n.id+"' value='"+n.id+"'></td><td>"+n.kode_mapel+"</td><td>"+n.nama_mapel+"</td><td class='ctr'>"+n.kelas+"</td></tr>");
              }); // enf of each
            }
          }); // end of ajax
        }); // end of #pilih_jurusan

      } else if(kel == "A" || kel == "B") {

        $.ajax({
          method  : "POST",
          url     : "proses-mapel.php?q=mapel",
          cache   : false,
          data    : {
            kelompok : kel
          },
          success : function(e){
            var back = JSON.parse(e);
            $("#table-body > tr").remove();
            $("#table_mapel").fadeIn(1000);
            $.each(back, function(a, b){

              $("#table-body").append("<tr><td class='ctr'><input type='checkbox' name='id_mapel' data-id='"+b.id+"' value='"+b.id+"'></td><td>"+b.kode_mapel+"</td><td>"+b.nama_mapel+"</td><td class='ctr'>"+b.kelas+"</td></tr>");

            });// end of each
          } // end of success
        }); // end of ajax open
      } // end of else 

      else {
        $("#table_mapel").hide();
        $("#table-body > tr").remove();
      }
    }); // end of kelmap

    $("#save").on("click", function(){
      $("#GuruMapel").modal('hide');
      var id = [];
      var cb = $('input:checked');

      $.each(cb, function(i,  el){
        var dt = $(this).data('id');

        if (dt)
          id.push(dt);

        var str = id.join(", ");
        //console.log(str);
        if (id.length == str.split(",").length) {
          $("#mapel_id").val(str);
        }
      });
    });

    $('#back').click(function() {
      window.location='<?= base("admin/guru"); ?>';
    });
  });
</script>

<?php
if (isset($_POST['submit'])) {
  $nama_guru  = addslashes($_POST['nama_guru']);
  $tmp_lahir  = anti_inject($_POST['tmp_lahir']);
  $tgl_lahir  = anti_inject($_POST['tgl_lahir']);
  $jk         = anti_inject($_POST['jk']);
  $jenis_ptk  = anti_inject($_POST['jenis_ptk']);
  $telp       = anti_inject($_POST['telp']);
  $nip        = anti_inject($_POST['nip']);
  $pass       = password_hash("123456", PASSWORD_DEFAULT, ['cost'=>12]);
  $id_card    = $jadikode;
  $source     = $_FILES['foto']['tmp_name'];
  $target     = "../images/guru/";
  $namafoto   = $jadikode.".jpg";

  if (empty(trim($nama_guru)) || empty(trim($tmp_lahir)) || empty(trim($tgl_lahir)) || empty(trim($jk)) || empty(trim($jenis_ptk))) {
    echo "<script>sweetAlert('Oops!', 'Form tidak boleh kosong!', 'error');</script>";
    echo notice(0);
  } else {

    move_uploaded_file($source, $target.$namafoto);
    
    if ($jenis_ptk == "Guru Mapel") {

      $idm = anti_inject($_POST['id_mapel']);
      $idm = explode(",", $idm);

      $ins = insert('tbl_guru', 'id, nama_guru, password, nip, jenis_ptk, id_card', "NULL, '$nama_guru', '$pass', '$nip', '$jenis_ptk', '$id_card'");
      $last_id = mysqli_insert_id($link);

      $in_detail = insert('detail_guru', 'id, id_guru, jk, telp, tmp_lahir, tgl_lahir', "NULL, '$last_id', '$jk', '$telp', '$tmp_lahir', '$tgl_lahir'");

      foreach ($idm as $id_mapel) :        
        $insert = insert('tbl_guru_mapel', "id, id_guru, id_mapel", "NULL, '$last_id', '$id_mapel'");
      endforeach;

    } else {

      $insert = insert('tbl_guru', 'id, nama_guru, password, nip, jenis_ptk, id_card', "NULL, '$nama_guru', '$pass', '$nip', '$jenis_ptk', '$id_card'");
      $last_id = mysqli_insert_id($link);
      
      $in_detail = insert('detail_guru', 'id, id_guru, jk, telp, tmp_lahir, tgl_lahir', "NULL, '$last_id', '$jk', '$telp', '$tmp_lahir', '$tgl_lahir'");

    }

      if ($insert === TRUE) {
        echo "
        <script>
          swal('Yosh!', 'Berhasil menambahkan data guru baru!', 'success');
        </script>";
        echo notice(1);
        echo location('guru');
      } else {
        echo "<script>sweetAlert('Oops!', 'Gagal menambahkan data guru baru!', 'error');</script>";
        echo notice(0);
      }

  }

}

?>
