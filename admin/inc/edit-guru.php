<?php
$id = anti_inject(@$_GET['id']);
$id = abs((int) $id);
$sel_gid = gabung('tbl_guru', 'detail_guru', 'tbl_guru.id = detail_guru.id_guru', "tbl_guru.id = $id");
$g = mysqli_fetch_assoc($sel_gid);

?>

<div class="col-md-12">
  <div class="row">
    <div class="col-md-6">
      <?php
        echo open_form('', 'post', "class='form-group'");
        echo label('nama_guru', 'Nama Guru');
        echo input('text', 'nama_guru', "class='form-control' value='$g[nama_guru]'")."</br>";

        echo label('tmp_lahir', 'Tempat Lahir');
        echo input('text', 'tmp_lahir', "class='form-control' value='$g[tmp_lahir]'")."</br>";

        echo label('jenis_ptk', 'Jenis');
        echo select_open('jenis_ptk',"class='form-control'");
        echo option($g['jenis_ptk'], 'selected', $g['jenis_ptk']);
        echo option('','','-- Pilih Jenis --');
        echo option('Guru Mapel','','Guru Mapel');
        echo option('Guru','','Guru');
        echo option('Tata Usaha','','Tata Usaha');
        echo option('Tim IT', '', 'Tim IT');
        echo option('Lainnya','','Lainnya');
        echo select_close()."<br>";

        echo label('id_card', 'No. ID Card');
        echo input('number', 'id_card', "class='form-control' value='$g[id_card]' disabled")."</br>";

        echo input('submit', 'submit', "class='btn btn-primary' value='Simpan'")." &nbsp; ";
        echo "<a href=".base("admin/guru")." class='btn btn-default'>Kembali</a>";
      ?>
    </div>
    <div class="col-md-6">
      <?php
        echo label('nip', 'NIP');
        echo input('number', 'nip', "class='form-control' value='$g[nip]'")."</br>";

        echo label('tgl_lahir', 'Tanggal Lahir');
        echo input('date', 'tgl_lahir', "class='form-control'")."</br>";

        echo label('jk', 'Jenis Kelamin');
        echo select_open('jk', "class='form-control'");
        echo option('','','-- Pilih Jenis Kelamin --');
        
        if ($g[jk] == "L") {
          echo option("L", 'selected', 'Laki-Laki');
          echo option("P", '', 'Perempuan');          
        } else {
          echo option("L", '', 'Laki-Laki');
          echo option("P", 'selected', 'Perempuan');
        }
        echo select_close()."</br>";

        echo label("telp", 'Telp/No. HP');
        echo input('number','telp', "class='form-control' value='$g[telp]'");

      ?>
    </div>
  </div>

</div>

<?php

if (isset($_POST['submit'])) {
  $nama_guru = addslashes($_POST['nama_guru']);
  $nip       = anti_inject($_POST['nip']);
  $jk        = anti_inject($_POST['jk']);
  $telp      = anti_inject($_POST['telp']);
  $tmp_lahir = anti_inject($_POST['tmp_lahir']);
  $tgl_lahir = @$_POST['tgl_lahir'];
  $jenis_ptk = anti_inject($_POST['jenis_ptk']);

  if (empty(trim($nama_guru))) {
    echo "<script>sweetAlert('Oops!', 'Form tidak boleh ada yang kosong!', 'error');</script>";
  } else {
    $upd_guru = update('tbl_guru', "nama_guru = '$nama_guru', jenis_ptk = '$jenis_ptk', nip = '$nip'", "id = '$id'");
    $upd_dtl  = update('detail_guru', "jk = '$jk', telp = '$telp', tmp_lahir = '$tmp_lahir', tgl_lahir = '$tgl_lahir'", "id_guru='$id'");

    if ($upd_guru === TRUE && $upd_dtl === TRUE) {
      echo "<script>swal('Yosh!', 'Data guru berhasil diperbarui!', 'success');</script>";
      echo notice(1);
    } else {
      echo "<script>sweetAlert('Oops!', 'Gagal memperbarui data guru!', 'error');</script>";
      echo notice(0);
    }
  }
}

?>
<script>
    $('button.confirm').on('click', function() {
      window.location='<?= base("admin/guru"); ?>'
    });
</script>
