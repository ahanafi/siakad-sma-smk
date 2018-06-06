<?php

$sqlmpl = select('*', 'tbl_mapel');
$sqlkls = select('*', 'tbl_kelas ORDER BY nama_kelas ASC');

?>
<script type="text/javascript">
  $(function(){
    $("select[name=kelas]").change(function(){
      var kelas = $("select[name=kelas] option:selected").val();
      var element = $("select[name=mapel]");

      $("select[name=mapel] > option").remove();
      element.append("<option value=''>-- Pilih Mata Pelajaran -- </option>");

      if (kelas == "") {
        sweetAlert('Oops!', 'Mohon pilih kelas terlebih dahulu!', 'error');
      } else {
        $.ajax({
          method    : "POST",
          url       : "result.php?q=kelas",
          cache     : false,
          async     : true,
          data      : {
            kelas : kelas
          },
          success   : function(cb){
            var mapel = JSON.parse(cb);

            $.each(mapel, function(i,n){
              element.append("<option value='"+n.id+"'>"+n.nama_mapel+"</option>");
            });
          }
        });
      }
    });

    $("select[name=mapel]").click(function(){
      var kelas = $("select[name=kelas] option:selected").val();

      if (kelas == "") {
        sweetAlert('Oops!', 'Mohon pilih kelas terlebih dahulu!', 'error');
      }
    });
  });
</script>
<div class="col-md-12">
  <div class="row">
    <div class="col-md-8">
      <div id="select">
        <form class="form-group" action="<?= base('admin/result-nilai'); ?>" method="post">
          <label for="nilai">Pilih Jenis Nilai</label>
          <select class="form-control" name="nilai" disabled>
            <option value="">-- Pilih Jenis Nilai --</option>
            <option value="harian">Nilai Harian</option>
            <option value="uas">Nilai UAS</option>
            <option value="uts">Nilai UTS</option>
            <option value="rapot" selected>Nilai Rapot</option>
          </select>
          <br>

          <label for="kelas">Kelas</label>
          <select class="form-control" name="kelas" id="kelas">
            <option value="">-- Pilih Kelas --</option>
            <?php while ($kls = mysqli_fetch_object($sqlkls)) : ?>
            <option value="<?= $kls->nama_kelas; ?>"><?= $kls->nama_kelas; ?></option>
          <?php endwhile; ?>

          </select>
          <br>

          <label for="mapel">Mata Pelajaran</label>
          <select class="form-control" name="mapel" id="mapel">
            <option value="">-- Pilih Mata Pelajaran --</option>
          </select>
          <br>

          <input type="submit" name="submit" value="Lihat Nilai" class="btn btn-primary">
        </form>
      </div>
    </div> <!-- end of class col md 8 -->
    <div class="col-md-4">
      <div class="panel panel-primary">
        <div class="panel-heading" style="font-weight:normal;font-size:15px;">
          Petunjuk
        </div>
        <div class="panel-body">
          <ul class="list-group">
            <li class="list-group-item">1. Pilih jenis nilai yang akan dilihat</li>
            <li class="list-group-item">2. Pilih kelas dan mata pelajaran</li>
            <li class="list-group-item">3. Kemudian <strong>Klik</strong> tombol  <strong>Lihat Nilai</strong></li>
            <li class="list-group-item">4. Setelah itu nilai akan muncul otomatis dibawah</li>
          </ul>
        </div>
      </div>
    </div>
  </div> <!-- end of class row -->
</div> <!-- end of class col md 12 -->
