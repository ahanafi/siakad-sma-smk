<?php
require_once '../function/core.php';

if (isset($_POST)) {
	$p_angka = anti_inject($_POST['p_angka']);
	//$p_angka = anti_inject($_POST['p_angka']);
	
	echo $p_angka;
}


?>