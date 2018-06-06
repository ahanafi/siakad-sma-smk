<?php
$id = @$_SESSION['guru']['id'];

$jur = select('DISTINCT(paket)', 'tbl_kelas');
?>
<!--script type="text/javascript">
  $(document).ready(function(){
    $("#setjur").change(function(){
      var jur = $("#setjur option:selected").val();
      $("#setkelas option:selected").hide();
      $("#setkelas option").hide();

      $.ajax({
        method  : "POST",
        url     : "proses.php?q=kls",
        cache   : false,
        data    : {
          paket : jur
        },
        success : function(data){
          var jur = JSON.parse(data);
          var kls = $("#setkelas");
          //i = key, n = val
          $.each(jur, function(i,n){
            //kls.html("<option>-- Pilih Kelas --</option>")
            //var nmkls = n.nama_kelas;
            
            //kls.append("<option value=" +n.nama_kelas+ ">"+n.nama_kelas+"</option>");
            kls.append($("<option>").val(n.nama_kelas).text(n.nama_kelas));
          });
        }
      });
    });

    $("#setkelas").change(function(){
      var kls = $("#setkelas option:selected").val();
      $("#setmpl option:selected").hide();
      $("#setmpl option").hide();

      $.ajax({
        method  : "POST",
        url     : "proses.php?q=mpl",
        cache   : false,
        data    : {
          kelas : kls
        },
        success : function(x){
          //console.log(x);
          var obj = JSON.parse(x);
          var mpl = $("#setmpl");
          //a = key, b = val
          $.each(obj, function(a, b){
            mpl.append("<option value="+b.id+">"+b.nama_mapel+"</option>");
          });
        }
      });

    });

    $("#setkelas").click(function(){
      var jur = $("#setjur option:selected").val();
      if (jur == '') {
        sweetAlert('Oops', 'Maaf Anda belum memilih paket keahlian!', 'error');
      }
    });

    $("#setmpl").click(function(){
      var jur = $("#setjur option:selected").val();
      var kls = $("#setkelas option:selected").val();
      if (jur == '') {
        sweetAlert('Oops', 'Maaf Anda belum memilih paket keahlian!', 'error');
      } else if (kls == '') {
        sweetAlert('Oops', 'Maaf Anda belum memilih kelas!', 'error');
      }
    });
  });
</script-->
<div class="col-md-12">
  <h4>Persiapan sebelum entry nilai</h4>
  <hr>
  <div class="row">
    <div class="col-md-8">
      <?php
        echo open_form('', 'post', "class='form-group'");

        echo label('jurusan', 'Paket Keahlian');
        echo select_open('jurusan', "class='form-control' id='setjur'");
        echo option('','', '-- Pilih Jurusan --');
        while ($j = mysqli_fetch_object($jur)) :
          echo option($j->paket, '', $j->paket);
        endwhile;
        echo select_close()."<br>";

        echo label('kelas', 'Kelas');
        echo select_open('kelas', "class='form-control' id='setkelas'");
        echo option('','', '-- Pilih Kelas --');
        echo select_close()."<br>";

        echo label('mapel', 'Mata Pelajaran');
        echo select_open('mapel', "class='form-control' id='setmpl'");
        echo option('','', '-- Pilih Mata Pelajaran --');
        echo select_close()."<br>";

        echo input('submit', 'submit', "class='btn btn-primary' value='Entry Sekarang!'");
      ?>
    </div>
    <div class="col-md-4">
      <div class="panel panel-primary">
        <div class="panel-heading">
          Petunjuk
        </div>
        <div class="panel-body">
          <ul class="list-group">
            <li class="list-group-item"><strong>1.</strong> Pilih <strong>Paket Keahlian</strong> terlebih dahulu</li>
            <li class="list-group-item"><strong>2.</strong> Setelah itu pilih <strong>Kelas</strong> mana yang akan diisi nilainya</li>
            <li class="list-group-item"><strong>3.</strong> Kemudian pilih mata pelajarannya</li>
            <li class="list-group-item"><strong>4.</strong> Klik tombol <strong>Entry Sekarang</strong></li>
            <li class="list-group-item"><strong>5.</strong> Mulailah mengisi nilai </li>
          </ul>
        </div>
      </div>
    </div> <!-- end of class col-md-4 -->
  </div> <!-- end of class row -->
</div> <!-- end of class col-md-12 -->

<?php
if (isset($_POST['submit'])) {
  $mapel  = addslashes($_POST['mapel']);
  $kelas  = anti_inject($_POST['kelas']);

  if (empty(trim($mapel)) || empty(trim($kelas))) {
    echo "<script>sweetAlert('Oops!', 'Form harus diisi semua!', 'error')</script>";
    //echo location('opsi-entry');
  } else {

    //Membuat session kelas, dan mapel
    @$_SESSION['nama_kelas']   = $kelas;
    @$_SESSION['mapel_id']   = $mapel;
    redirect('input-nilai-rapot');
  }
}


?>
