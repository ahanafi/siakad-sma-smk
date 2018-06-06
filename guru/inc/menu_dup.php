<?php

$page = @$_GET['page'];

?>

<ul class="nav nav-pills nav-stacked">
  <li role="presentation" class="active">
    <a href="dashboard"><span class="glyphicon glyphicon-dashboard"></span>&nbsp; Dashboard</a>
  </li>
  <li role="presentation" class="data-jadwal">
    <a href="data-jadwal"><span class="glyphicon glyphicon-calendar"></span>&nbsp; Data Jadwal</a>
  </li>
  <li role="presentation" class="data-siswa">
    <a href="data-siswa"><span class="glyphicon glyphicon-user"></span>&nbsp; Data Siswa</a>
  </li>
  <li role="presentation" class="data-kelas">
    <a href="data-kelas"><span class="glyphicon glyphicon-home"></span>&nbsp; Data Kelas</a>
  </li>
  <li role="presentation" class="data-kehadiran">
    <a href="data-kehadiran"><span class="glyphicon glyphicon-signal"></span>&nbsp; Data Kehadiran</a>
  </li>
  <li role="presentation" class="lihat-nilai dropdown">
    <a href="lihat-nilai" class=""><span class="glyphicon glyphicon-file"></span>&nbsp; Lihat Nilai</a>
  </li>
  
  <?php if($cekyo != 0){ ?>

  <li role="presentation" class="dropdown">
    <a href="nilai-rapot"><span class="glyphicon glyphicon-book"></span>&nbsp; Nilai Rapot</a>
  </li>

  <?php } else { } ?>

  <li role="presentation" class="entry-nilai">
    <a href="#" data-toggle="modal" data-target="#entry-nilai"><span class="glyphicon glyphicon-pencil"></span>&nbsp; Entry Nilai Rapot</a>
  </li>
  <li role="presentation" class="pengaturan">
    <a href="pengaturan"><span class="glyphicon glyphicon-cog"></span>&nbsp; Pengaturan</a>
  </li>
  <li role="presentation" class="hub-admin">
    <a href="hubungi-admin"><span class="glyphicon glyphicon-earphone"></span>&nbsp; Hub. Admin</a>
  </li>
  <li role="presentation">&nbsp;</li>
</ul>
