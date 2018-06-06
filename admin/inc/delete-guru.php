<?php
$id = anti_inject(@$_GET['id']);
$id = abs((int) $id);

$del_guru = delete('tbl_guru', $id);
$del_detail = delete('detail_guru', '', "id_guru = '$id'");

if ($del_guru === TRUE && $del_detail) {
  echo "<script>swal('Yosh!', 'Data berhasil di hapus!', 'success');</script>";
  echo notice(1);
} else {
  echo "<script>sweetAlert('Oops!', 'Data gagal dihapus!', 'error');</script>";
  echo notice(0);
}
?>

<script type="text/javascript">
  $(document).ready(function() {
    $('button.confirm').on("click", function() {
      window.location='<?= base("admin/guru"); ?>';
    });
  });
</script>
