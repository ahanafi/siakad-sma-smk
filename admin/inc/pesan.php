<?php
$sqlpesan = select('*', 'tbl_pesan');
$cekpesan = mysqli_num_rows($sqlpesan);
$no = 1;
?>
<script type="text/javascript">
  $(document).ready(function(){
    $("#close").click(function(){
      var table = $(".detail-pesan > table");
      table.hide();
    });

    $(".modal").click(function(){
      var table = $(".detail-pesan > table");
      table.hide();
    });

    $(".btn-detail").click(function(){
      //Mengambil id tiap pesan 
      var id_pesan = $(this).attr('data-id');
      //Mendefinisikan letak data
      var det_pesan= $(".detail-pesan");

      $.ajax({
          method    : "POST",
          url       : "proses-pesan.php?act=detail",
          cache     : false,
          data      : {id : id_pesan},
          success   : function(e){
            if (e == "0") {
              det_pesan.append("<div class='alert alert-danger'>Error!</div>")
            } else {
              //alert(e);
              det_pesan.append(e);
              $("#btn-reset").click(function(){
                $.ajax({
                  method    : "POST",
                  url       : "proses-pesan.php?act=reset",
                  cache     : false,
                  data      : { id : id_pesan },
                  success   : function(e){
                    if (e == "0") {
                      sweetAlert('Oops!', "Gagal mereset password!", 'error');
                    } else {
                      swal("Yosh!", "Password berhasil direset!", "success");
                    }

                    $("button.confirm").click(function() {
                      window.location='pesan';
                    })
                  }
                });
              });
            }
          }
      });
    });
  });
</script>
<div class="col-md-12">
  <h3>Data Pesan</h3>
  <hr>

  <table class="table table-bordered" id="list-data">
    <thead>
      <tr>
        <th class="ctr">No.</th>
        <th class="ctr">Nama</th>
        <th class="ctr">Jenis Keluhan</th>
        <th class="ctr">Keterangan error</th>
        <th class="ctr">Aksi</th>
      </tr>
    </thead>
    <tbody>

    <?php
      if($cekpesan > 0){
        while ($ps = mysqli_fetch_object($sqlpesan)) :
          $sqlg = select('*', 'tbl_guru', "id = $ps->id_guru");
          $gr = mysqli_fetch_object($sqlg);
    ?>

      <tr>
        <td class="ctr"><?= $no++; ?></td>
        <td><?= $gr->nama_guru; ?></td>
        <td class="ctr"><?= $ps->judul; ?></td>
        <td class="ctr"><?= substr($ps->isi, 0, 30)."..."; ?></td>
        <td class="ctr">
          <a href="#" class="btn btn-primary btn-detail" data-toggle="modal" data-target="#msg" data-id="<?= $ps->id; ?>">Detail</a>
          <a onclick="return konfirmasi()" href="<?= base('admin/delete-pesan/'.$ps->id); ?>" class="btn btn-danger">Hapus</a>
        </td>
      </tr>

    <?php endwhile;
      } else {
        echo "<td colspan='5' class='ctr'>Tidak ada Data!</td>";
      }
     ?>

    </tbody>
  </table>
</div>
<div class="modal fade" id="msg" tabindex="-1" role="dialog" aria-labelledby="msg">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="msg">Detail Pesan</h4>
      </div>
      <div class="modal-body">
        <div class='detail-pesan'></div>
      </div>
      <div class="modal-footer">
        <button type="button" id="close" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <button type="button" id="btn-reset" class="btn btn-primary">Reset Password</button>
      </div>
    </div>
  </div>
</div>
