<?php
$id = @$_SESSION['guru']['id'];

$sql  = "SELECT DISTINCT nama_mapel FROM tbl_mapel JOIN tbl_jadwal  ON tbl_jadwal.mapel = tbl_mapel.id ";
$sql .= "JOIN tbl_guru ON tbl_jadwal.guru = tbl_guru.id ";
$sql .= "WHERE tbl_jadwal.guru = '$id'";
$joined = mysqli_query($link, $sql);

?>
<div class="col-md-12">
  <h4>Entry Nilai</h4>
  <hr>
  <div class="row">
    <div class="col-md-5">
      <?php
        echo open_form('', 'post', "form-group");
        echo select_open('mapel', "class='form-control' id='setmpl'");
        while ($m = mysqli_fetch_object($joined)) :
          echo option($m->id, '', $m->nama_mapel);
          echo $m->id;
        endwhile;
        echo select_close();
      ?>
    </div>
    <div class='col-md-1'>
      <?php
        echo input('submit', 'set_mapel', "value='Set' class='btn btn-primary form-control'");
        echo close_form();
      ?>
    </div>
    <div class="col-md-6">
      <div class="alert alert-info" style="padding:8px;">
        <strong>Note :</strong>
        Harap <strong>Set</strong> Mata pelajaran terlebih dahulu!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
    </div>
  </div>
</div>
