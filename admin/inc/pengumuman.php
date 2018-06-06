<?php

$sql = select('*', 'tbl_lain', 'ds=0 LIMIT 1');
$ann = mysqli_fetch_assoc($sql);

?>
<script type="text/javascript" src="<?= base('assets/tinymce/tinymce.min.js'); ?>"></script>
<script type="text/javascript">
  $(document).ready(function() {
    tinymce.init({
      selector: 'textarea',
      height: 500,
      plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table contextmenu paste code'
      ],
      toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',

    });
  });
</script>
<div class="col-md-12">
  <form class="form-group" action="" method="post">
    <button type="submit" name="submit" class="btn btn-default">
      Simpan
      &nbsp;
      <span class="glyphicon glyphicon-floppy-save"></span>
    </button>
    <br> <br>
    <textarea name="isi" rows="3">
      <?= $ann['isi']; ?>
    </textarea>
  </form>
</div>

<?php

if (isset($_POST['submit'])) {
  $isi = $_POST['isi'];

  if (empty(trim($isi))) {
    echo "<script>sweetAlert('Oops!', 'Form pengumuman harus diisi!', 'error');</script>";
    echo notice(0);
  } else {
    $save = update("tbl_lain", "isi = '$isi'", "id = 1");

    if ($save === TRUE) {
      echo "
        <script>
          swal('Yosh!', 'Pengumuman berhasil di perbarui!', 'success');
          $('button.confirm').on('click', function() {
            window.location='pengumuman'
          });
        </script>";
        echo notice(1);
    } else {
      echo "<script>swal('Oops!', 'Pengumuman gagal di perbarui!', 'error');</script>";
      echo notice(0);
    }
  }
}

?>
