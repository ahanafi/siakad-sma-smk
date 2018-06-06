<div id="form">
  <?php

  $sqlkelas = select('*', 'tbl_kelas ORDER BY nama_kelas ASC');
  $sqlmapel = select('*', 'tbl_mapel');
  $no = 1;

//  echo open_form('', 'post', "class='form-group'");
  echo label('kelas', 'Pilih Kelas');
  echo select_open('kelas', "class='form-control'");
  echo option('', '', '-- Pilih Kelas --');
  while ($x = mysqli_fetch_object($sqlkelas)) :
    echo option($x->id, '', $x->nama_kelas);
  endwhile;
  echo select_close()."<br>";

  echo label('mapel', 'Pilih Mata Pelajaran');
  echo select_open('mapel', "class='form-control'");
  echo option('', '', '-- Pilih Mata Pelajaran --');
  while ($m = mysqli_fetch_object($sqlmapel)) :
    echo option($m->id, '', $m->nama_mapel);
  endwhile;
  echo select_close()."<br>";
  echo input('button', 'lihat', "class='btn btn-primary' value='Lihat Nilai' id='click-nilai'");
  ?>
</div>

<div id="show-nilai">
  <h4>Nilai </h4>
  <hr>
  <table class="table table-bordered" id="list-data">
    <thead>
      <tr>
        <th rowspan="2" class="ctr">No.</th>
        <th rowspan="2" class="ctr">Nama Siswa</th>
        <th colspan="2" class="ctr">Pengetahuan</th>
        <th colspan="2" class="ctr">Keterampilan</th>
      </tr>
      <tr>
        <th class="ctr">Angka</th>
        <th class="ctr">Predikat</th>
        <th class="ctr">Angka</th>
        <th class="ctr">Predikat</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>1</td>
        <td>Nama</td>
        <td>1</td>
        <td>1</td>
        <td>1</td>
        <td>1</td>
      </tr>
    </tbody>
  </table>
</div>
