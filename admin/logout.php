<?php
include_once '../function/core.php';

//logout();
unset($_SESSION['adm']['user']);
unset($_SESSION['adm']['pass']);
unset($_SESSION['semester']);
redirect('login');
?>
