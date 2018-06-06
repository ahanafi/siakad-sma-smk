<?php
include_once "../function/core.php";
//logout();
//
unset($_SESSION['token']);
unset($_SESSION['semester']);
unset($_SESSION['thn_ajaran']);
unset($_SESSION['guru']['pass']);
unset($_SESSION['guru']['id_card']);
unset($_SESSION['guru']['nama']);
unset($_SESSION['guru']['id']);
unset($_SESSION['guru']['nip']);
unset($_SESSION['guru']['user']);
unset($_SESSION['guru']['pass']);
redirect('login');
?>
