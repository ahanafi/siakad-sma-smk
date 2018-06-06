<?php
include_once '../function/core.php';
require_once 'style.html';
$id_siswa = anti_inject($_GET['id']);

$sqlsis = select("*", "tbl_siswa", "id = '$id_siswa'");
$xs = mysqli_fetch_object($sqlsis);

$nama = strtolower($xs->nama);
$nama_siswa = ucwords($nama);

$nama_kls = $xs->rombel;
//Selecting
$qwe = substr($nama_kls, 0,2); //Buat cek kelasnya antara kelas 10, 11, atau 12
$cekjur = substr($nama_kls, 3,2); //Buat cek jurusannya (AP, AK, MM, PM, PB, UPW)

$no = 1;
$numb = $no;
$n = $numb;

if ($qwe == 10) {
  $wja = select("*", "tbl_mapel", "kode_mapel LIKE '%AX0%' ");
  $wjb = select("*", "tbl_mapel", "kode_mapel LIKE '%BX0%' AND kelompok = 'B' ");

  if ($cekjur == "MM") {
    $plc = select("*", "tbl_mapel", "kode_mapel LIKE '%MMX0%' AND kelompok = 'C' ");
  } else if($cekjur == "AK") {
    $plc = select("*", "tbl_mapel", "kode_mapel LIKE '%AKX0%' AND kelompok = 'C' ");
  } else if($cekjur == "AP") {
    $plc = select("*", "tbl_mapel", "kode_mapel LIKE '%APX0%' AND kelompok = 'C' ");
  } else if($cekjur == "PM") {
    $plc = select("*", "tbl_mapel", "kode_mapel LIKE '%PMX0%' AND kelompok = 'C' ");
  } else if($cekjur == "PB") {
    $plc = select("*", "tbl_mapel", "kode_mapel LIKE '%PBX0%' AND kelompok = 'C' ");
  } else {
    $plc = select("*", "tbl_mapel", "kode_mapel LIKE '%UPX0%' AND kelompok = 'C' ");
  }

} else if($qwe == 11) {
  $wja = select("*", "tbl_mapel", "kode_mapel LIKE '%AXI0%' ");
  $wjb = select("*", "tbl_mapel", "kode_mapel LIKE '%BXI0%' AND kelompok = 'B' ");

  if ($cekjur == "MM") {
    $plc = select("*", "tbl_mapel", "kode_mapel LIKE '%MMXI0%' AND kelompok = 'C' ");
  } else if($cekjur == "AK") {
    $plc = select("*", "tbl_mapel", "kode_mapel LIKE '%AKXI0%' AND kelompok = 'C' ");
  } else if($cekjur == "AP") {
    $plc = select("*", "tbl_mapel", "kode_mapel LIKE '%APXI0%' AND kelompok = 'C' ");
  } else if($cekjur == "PM") {
    $plc = select("*", "tbl_mapel", "kode_mapel LIKE '%PMXI0%' AND kelompok = 'C' ");
  } else if($cekjur == "PB") {
    $plc = select("*", "tbl_mapel", "kode_mapel LIKE '%PBXI0%' AND kelompok = 'C' ");
  } else {
    $plc = select("*", "tbl_mapel", "kode_mapel LIKE '%UPXI0%' AND kelompok = 'C' ");
  }

} else if($qwe == 12) {
  $wja = select("*", "tbl_mapel", "kode_mapel LIKE '%AXII%' ");
  $wjb = select("*", "tbl_mapel", "kode_mapel LIKE '%BXII%' AND kelompok = 'B' ");

  if ($cekjur == "MM") {
    $plc = select("*", "tbl_mapel", "kode_mapel LIKE '%MMXII%' AND kelompok = 'C' ");
  } else if($cekjur == "AK") {
    $plc = select("*", "tbl_mapel", "kode_mapel LIKE '%AKXII%' AND kelompok = 'C' ");
  } else if($cekjur == "AP") {
    $plc = select("*", "tbl_mapel", "kode_mapel LIKE '%APXII%' AND kelompok = 'C' ");
  } else if($cekjur == "PM") {
    $plc = select("*", "tbl_mapel", "kode_mapel LIKE '%PMXII%' AND kelompok = 'C' ");
  } else if($cekjur == "PB") {
    $plc = select("*", "tbl_mapel", "kode_mapel LIKE '%PBXII%' AND kelompok = 'C' ");
  } else {
    $plc = select("*", "tbl_mapel", "kode_mapel LIKE '%UPXII%' AND kelompok = 'C' ");
  }

} else {
  echo "Error!";
}


?>

<div id="rapot_revisi_10268" align=center x:publishsource="Excel">

<table border=0 cellpadding=0 cellspacing=0 width=1550 class=xl6310268
 style='border-collapse:collapse;table-layout:fixed;width:1163pt'>
 <col class=xl6310268 width=35 style='mso-width-source:userset;mso-width-alt:
 1280;width:26pt'>
 <col class=xl6310268 width=239 style='mso-width-source:userset;mso-width-alt:
 8740;width:179pt'>
 <col class=xl6310268 width=40 span=3 style='mso-width-source:userset;
 mso-width-alt:1462;width:30pt'>
 <col class=xl6310268 width=250 style='mso-width-source:userset;mso-width-alt:
 9142;width:188pt'>
 <col class=xl6310268 width=40 span=2 style='mso-width-source:userset;
 mso-width-alt:1462;width:30pt'>
 <col class=xl6310268 width=250 style='mso-width-source:userset;mso-width-alt:
 9142;width:188pt'>
 <col class=xl6310268 width=64 span=9 style='width:48pt'>
 <tr height=20 style='height:15.0pt'>
  <td colspan=2 height=20 class=xl9510268 width=274 style='height:15.0pt;
  width:205pt'>Nama Sekolah</td>
  <td class=xl6510268 colspan=4 width=370 style='width:278pt'>:<span
  style='mso-spacerun:yes'>  </span>SMK Negeri 1 Kedawung</td>
  <td colspan=3 class=xl9510268 width=330 style='width:248pt'>Kelas<span
  style='mso-spacerun:yes'>                    </span>: <?= $xs->rombel; ?></td>
  <td class=xl6310268 width=64 style='width:48pt'></td>
  <td class=xl6310268 width=64 style='width:48pt'></td>
  <td class=xl6310268 width=64 style='width:48pt'></td>
  <td class=xl6310268 width=64 style='width:48pt'></td>
  <td class=xl6310268 width=64 style='width:48pt'></td>
  <td class=xl6310268 width=64 style='width:48pt'></td>
  <td class=xl6310268 width=64 style='width:48pt'></td>
  <td class=xl6310268 width=64 style='width:48pt'></td>
  <td class=xl6310268 width=64 style='width:48pt'></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6510268 colspan=2 style='height:15.0pt'>Alamat Sekolah</td>
  <td class=xl6510268 colspan=4>:<span style='mso-spacerun:yes'>  </span>Jl.
  Tuparev No. 12 Cirebon</td>
  <td colspan=3 class=xl9510268>Semester<span
  style='mso-spacerun:yes'>               </span>:
    <?php
      if(@$_SESSION['semester'] == "Ganjil") {
        echo "I ".@$_SESSION['semester'];
      } else {
        echo "II ".@$_SESSION['semester'];
      } ?>
  </td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6510268 colspan=2 style='height:15.0pt'>Nama Peserta
  Didik</td>
  <td class=xl6510268 colspan=3>:<span style='mso-spacerun:yes'>  </span><?= $nama_siswa; ?></td>
  <td class=xl6510268></td>
  <td colspan=3 class=xl9510268>Tahun Pelajaran<span
  style='mso-spacerun:yes'>    </span>: <?= @$_SESSION['thn_ajaran']; ?></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td colspan=2 height=20 class=xl9510268 style='height:15.0pt'>Nomor
  Induk/NISN</td>
  <td colspan=3 class=xl9510268>:<span style='mso-spacerun:yes'> 
  </span><?= $xs->nis; ?></td>
  <td class=xl6310268></td>
  <td colspan=3 class=xl9510268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
 </tr>
 <tr height=11 style='mso-height-source:userset;height:8.25pt'>
  <td height=11 class=xl6310268 style='height:8.25pt'></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
 </tr>
 <tr height=26 style='mso-height-source:userset;height:19.5pt'>
  <td height=26 class=xl7610268 colspan=2 style='height:19.5pt'>CAPAIAN HASIL
  BELAJAR</td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6410268 colspan=2 style='height:15.0pt'>A. Sikap</td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td colspan=9 rowspan=6 height=120 class=xl9710268 style='height:90.0pt'>Deskripsi:<span
  style='mso-spacerun:yes'> </span></td>
  <td class=xl6510268></td>
  <td class=xl6510268></td>
  <td class=xl6510268></td>
  <td class=xl6510268></td>
  <td class=xl6510268></td>
  <td class=xl6510268></td>
  <td class=xl6510268></td>
  <td class=xl6510268></td>
  <td class=xl6510268></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6510268 style='height:15.0pt'></td>
  <td class=xl6510268></td>
  <td class=xl6510268></td>
  <td class=xl6510268></td>
  <td class=xl6510268></td>
  <td class=xl6510268></td>
  <td class=xl6510268></td>
  <td class=xl6510268></td>
  <td class=xl6510268></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6510268 style='height:15.0pt'></td>
  <td class=xl6510268></td>
  <td class=xl6510268></td>
  <td class=xl6510268></td>
  <td class=xl6510268></td>
  <td class=xl6510268></td>
  <td class=xl6510268></td>
  <td class=xl6510268></td>
  <td class=xl6510268></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6510268 style='height:15.0pt'></td>
  <td class=xl6510268></td>
  <td class=xl6510268></td>
  <td class=xl6510268></td>
  <td class=xl6510268></td>
  <td class=xl6510268></td>
  <td class=xl6510268></td>
  <td class=xl6510268></td>
  <td class=xl6510268></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6510268 style='height:15.0pt'></td>
  <td class=xl6510268></td>
  <td class=xl6510268></td>
  <td class=xl6510268></td>
  <td class=xl6510268></td>
  <td class=xl6510268></td>
  <td class=xl6510268></td>
  <td class=xl6510268></td>
  <td class=xl6510268></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6510268 style='height:15.0pt'></td>
  <td class=xl6510268></td>
  <td class=xl6510268></td>
  <td class=xl6510268></td>
  <td class=xl6510268></td>
  <td class=xl6510268></td>
  <td class=xl6510268></td>
  <td class=xl6510268></td>
  <td class=xl6510268></td>
 </tr>
 <tr height=12 style='mso-height-source:userset;height:9.0pt'>
  <td height=12 class=xl6310268 style='height:9.0pt'></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6410268 colspan=2 style='height:15.0pt'>B. Pengetahuan
  &amp; Keterampilan</td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td colspan=2 rowspan=2 height=40 class=xl6810268 style='height:30.0pt'>MATA
  PELAJARAN</td>
  <td rowspan=2 class=xl6810268>KB</td>
  <td colspan=3 class=xl6810268 style='border-left:none'>Pengetahuan</td>
  <td colspan=3 class=xl6810268 style='border-left:none'>Keterampilan</td>
  <td class=xl6610268></td>
  <td class=xl6610268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6710268 style='height:15.0pt;border-top:none;
  border-left:none'>Angka</td>
  <td class=xl6710268 style='border-top:none;border-left:none'>Pred</td>
  <td class=xl6810268 style='border-top:none;border-left:none'>Deskripsi</td>
  <td class=xl6910268 style='border-top:none;border-left:none'>Angka</td>
  <td class=xl6710268 style='border-top:none;border-left:none'>Pred</td>
  <td class=xl6810268 style='border-top:none;border-left:none'>Deskripsi</td>
  <td class=xl6610268></td>
  <td class=xl6610268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td colspan=9 height=20 class=xl9610268 style='height:15.0pt'>Kelompok A</td>
  <td class=xl6510268></td>
  <td class=xl6510268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
 </tr>

<?php
  while ($a = mysqli_fetch_object($wja)) :
?>

 <tr height=60 style='mso-height-source:userset;height:45.0pt'>
  <td height=60 class=xl7010268 style='height:45.0pt;border-top:none'><?= $no++; ?></td>
  <td class=xl7110268 style='border-top:none;border-left:none'><?= $a->nama_mapel; ?></td>
  <td class=xl7210268 style='border-top:none;border-left:none'>60</td>
  <td class=xl7210268 style='border-top:none;border-left:none'>70</td>
  <td class=xl7210268 style='border-top:none;border-left:none'>B</td>
  <td class=xl7310268 width=250 style='border-top:none;border-left:none;
  width:188pt'>Mampu memahami al qur'an dan hadits yang berkaitan dengan
  mujahadah an nafsjujur dengan baik</td>
  <td class=xl7210268 style='border-top:none;border-left:none'>78</td>
  <td class=xl7210268 style='border-top:none;border-left:none'>B</td>
  <td class=xl7310268 width=250 style='border-top:none;border-left:none;
  width:188pt'>Terampil menghafal alqur'an surat al anfal:72, al hujurat: 12
  dan 10, al isra: 32 dan an nur:2 dengan baik</td>
  <td class=xl7410268></td>
  <td class=xl7410268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
 </tr>

<?php endwhile; ?>

 <tr height=20 style='height:15.0pt'>
  <td colspan=9 height=20 class=xl9610268 style='height:15.0pt'>Kelompok B</td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
 </tr>

<?php while($b = mysqli_fetch_object($wjb)) : ?>

 <tr height=59 style='mso-height-source:userset;height:44.25pt'>
  <td height=59 class=xl7010268 style='height:44.25pt;border-top:none'><?= $numb++; ?></td>
  <td class=xl7110268 style='border-top:none;border-left:none'><?= $b->nama_mapel; ?></td>
  <td class=xl7210268 style='border-top:none;border-left:none'>60</td>
  <td class=xl7210268 style='border-top:none;border-left:none'>70</td>
  <td class=xl7210268 style='border-top:none;border-left:none'>B</td>
  <td class=xl7310268 width=250 style='border-top:none;border-left:none;
  width:188pt'>Mampu memahami al qur'an dan hadits yang berkaitan dengan
  mujahadah an nafsjujur dengan baik</td>
  <td class=xl7210268 style='border-top:none;border-left:none'>78</td>
  <td class=xl7210268 style='border-top:none;border-left:none'>B</td>
  <td class=xl7310268 width=250 style='border-top:none;border-left:none;
  width:188pt'>Terampil menghafal alqur'an surat al anfal:72, al hujurat: 12
  dan 10, al isra: 32 dan an nur:2 dengan baik</td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
 </tr>

<?php endwhile; ?>

 <tr height=20 style='height:15.0pt'>
  <td colspan=9 height=20 class=xl9610268 style='height:15.0pt'>Kelompok C</td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
 </tr>

<?php while ($c = mysqli_fetch_object($plc)) : ?>

 <tr height=59 style='mso-height-source:userset;height:44.25pt'>
  <td height=59 class=xl7010268 style='height:44.25pt;border-top:none'><?= $n++; ?></td>
  <td class=xl7110268 style='border-top:none;border-left:none'><?= $c->nama_mapel; ?></td>
  <td class=xl7210268 style='border-top:none;border-left:none'>60</td>
  <td class=xl7210268 style='border-top:none;border-left:none'>70</td>
  <td class=xl7210268 style='border-top:none;border-left:none'>B</td>
  <td class=xl7310268 width=250 style='border-top:none;border-left:none;
  width:188pt'>Mampu memahami al qur'an dan hadits yang berkaitan dengan
  mujahadah an nafsjujur dengan baik</td>
  <td class=xl7210268 style='border-top:none;border-left:none'>78</td>
  <td class=xl7210268 style='border-top:none;border-left:none'>B</td>
  <td class=xl7310268 width=250 style='border-top:none;border-left:none;
  width:188pt'>Terampil menghafal alqur'an surat al anfal:72, al hujurat: 12
  dan 10, al isra: 32 dan an nur:2 dengan baik</td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
 </tr>

<?php endwhile; ?>

 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6310268 style='height:15.0pt'></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl8110268 colspan=2 style='height:15.0pt'>B. Praktik
  Kerja Lapangan</td>
  <td class=xl6610268></td>
  <td class=xl6610268></td>
  <td class=xl6610268></td>
  <td class=xl6610268></td>
  <td class=xl6610268></td>
  <td class=xl6610268></td>
  <td class=xl6610268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl8210268 style='height:15.0pt'>No.</td>
  <td class=xl8210268 style='border-left:none'>Mitra DU/DI</td>
  <td colspan=3 class=xl8210268 style='border-left:none'>Lokasi</td>
  <td class=xl8210268 style='border-left:none'>Lamanya (Bulan)</td>
  <td colspan=3 class=xl8210268 style='border-left:none'>KEGIATAN YANG TELAH
  DILAKUKAN</td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
 </tr>
 <tr height=40 style='mso-height-source:userset;height:30.0pt'>
  <td height=40 class=xl7210268 style='height:30.0pt;border-top:none'>1</td>
  <td class=xl7210268 style='border-top:none;border-left:none'>&nbsp;</td>
  <td colspan=3 class=xl7210268 style='border-left:none'>&nbsp;</td>
  <td class=xl7210268 style='border-top:none;border-left:none'>&nbsp;</td>
  <td colspan=3 class=xl7210268 style='border-left:none'>&nbsp;</td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl8110268 colspan=2 style='height:15.0pt'>D. Ekstra
  Kurikuler</td>
  <td class=xl6610268></td>
  <td class=xl6610268></td>
  <td class=xl6610268></td>
  <td class=xl6610268></td>
  <td class=xl6610268></td>
  <td class=xl6610268></td>
  <td class=xl6610268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl8210268 style='height:15.0pt'>No.</td>
  <td class=xl8210268 style='border-left:none'>Kegiatan Ekstrakurikuler</td>
  <td colspan=7 class=xl8210268 style='border-left:none'>Keterangan</td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
 </tr>
 <tr height=39 style='mso-height-source:userset;height:29.25pt'>
  <td height=39 class=xl7210268 style='height:29.25pt;border-top:none'>1</td>
  <td class=xl7710268 style='border-top:none;border-left:none'>Praja Muda
  Karana (PRAMUKA)</td>
  <td colspan=7 class=xl7710268 style='border-left:none'>Sangat kurang
  diberbagai kegiatan baik di Sekolah maupun di luar Sekolah</td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
 </tr>
 <tr height=38 style='mso-height-source:userset;height:28.5pt'>
  <td height=38 class=xl7210268 style='height:28.5pt;border-top:none'>2</td>
  <td class=xl7710268 style='border-top:none;border-left:none'>Rohani Islam
  (ROHIS)</td>
  <td colspan=7 class=xl7710268 style='border-left:none'>Sangat kurang
  diberbagai kegiatan baik di Sekolah maupun di luar Sekolah</td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
 </tr>
 <tr height=40 style='mso-height-source:userset;height:30.0pt'>
  <td height=40 class=xl7210268 style='height:30.0pt;border-top:none'>3</td>
  <td class=xl7710268 style='border-top:none;border-left:none'>&nbsp;</td>
  <td colspan=7 class=xl7710268 style='border-left:none'>&nbsp;</td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6310268 style='height:15.0pt'></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl8110268 colspan=2 style='height:15.0pt'>E. Prestasi</td>
  <td class=xl6410268></td>
  <td class=xl6410268></td>
  <td class=xl6410268></td>
  <td class=xl6410268></td>
  <td class=xl6410268></td>
  <td class=xl6410268></td>
  <td class=xl6410268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl8210268 style='height:15.0pt'>No.</td>
  <td class=xl8210268 style='border-left:none'>Jenis Prestasi</td>
  <td colspan=7 class=xl8210268 style='border-left:none'>Keterangan</td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
 </tr>
 <tr height=37 style='mso-height-source:userset;height:27.75pt'>
  <td height=37 class=xl7210268 style='height:27.75pt;border-top:none'>1</td>
  <td class=xl7710268 style='border-top:none;border-left:none'>&nbsp;</td>
  <td colspan=7 class=xl7710268 style='border-left:none'>&nbsp;</td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6310268 style='height:15.0pt'></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6410268 colspan=2 style='height:15.0pt'>F.
  Ketidakhadiran</td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td colspan=2 height=20 class=xl9110268 style='height:15.0pt'>Sakit</td>
  <td colspan=2 class=xl9310268><span
  style='mso-spacerun:yes'>                </span></td>
  <td class=xl7910268>hari</td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td colspan=2 height=20 class=xl9110268 style='height:15.0pt'>Izin</td>
  <td colspan=2 class=xl8610268><span
  style='mso-spacerun:yes'>                </span></td>
  <td class=xl7810268>hari</td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td colspan=2 height=20 class=xl9110268 style='height:15.0pt'>Tanpa
  Keterangan</td>
  <td colspan=2 class=xl8810268><span
  style='mso-spacerun:yes'>                </span></td>
  <td class=xl8010268>hari</td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6310268 style='height:15.0pt'></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6410268 colspan=2 style='height:15.0pt'>G. Catatan Wali
  Kelas</td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td colspan=9 rowspan=3 height=60 class=xl9010268 style='height:45.0pt'>&nbsp;</td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6310268 style='height:15.0pt'></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6310268 style='height:15.0pt'></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6310268 style='height:15.0pt'></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6410268 colspan=2 style='height:15.0pt'>H. Tanggapan
  Orang Tua/Wali</td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td colspan=9 rowspan=3 height=60 class=xl9010268 style='height:45.0pt'>&nbsp;</td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6310268 style='height:15.0pt'></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6310268 style='height:15.0pt'></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6310268 style='height:15.0pt'></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
  <td class=xl6310268></td>
 </tr>
</table>

</div>