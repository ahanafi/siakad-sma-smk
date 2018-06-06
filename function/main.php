<?php
ob_start();

function base($folder)
{
	$url = "http://localhost/siakad/".$folder;

	return $url;
}

function anti_inject($text)
{
	$string = stripslashes(strip_tags(htmlentities(htmlspecialchars($text, ENT_QUOTES))));

	return $string;
}

function hari($hariini)
{
	$semingu = array(
		"Minggu",
		"Senin",
		"Selasa",
		"Rabu",
		"Kamis",
		"Jum'at",
		"Sabtu"
	);

	return $semingu[$hariini];
}

function tglskrg($tgl)
{
	$tanggal	= substr($tgl, 8, 2);
	$bulan		= bulan(substr($tgl, 5, 2));
	$tahun 		= substr($tgl, 0, 4);

	return $tanggal. ' '.$bulan.' '.$tahun;
}

function bulan($bln)
{
	if ($bln == "01") {
		return "Januari";
	} else if ($bln == "0") {

	} else if ($bln == "02") {
		return "Februari";
	} else if ($bln == "03") {
		return "Maret";
	} else if ($bln == "04") {
		return "April";
	} else if ($bln == "05") {
		return "Mei";
	} else if ($bln == "06") {
		return "Juni";
	} else if ($bln == "07") {
		return "Juli";
	} else if ($bln == "08") {
		return "Agustus";
	} else if ($bln == "09") {
		return "September";
	} else if ($bln == "10") {
		return "Oktober";
	} else if ($bln == "11") {
		return "November";
	} else if ($bln == "12") {
		return "Desember";
	}
}

function get($sql)
{
	global $link;

	if ($x = mysqli_query($link, $sql) or die(mysqli_error($link))) {
		return $x;
	}
}

function run($sql)
{
	global $link;

	if (mysqli_query($link, $sql) or die("Query failed to Execute! : ".mysqli_error($link))) {
		return TRUE;
	} else {
		return FALSE;
	}
}

function redirect($location)
{
	return header("Location: $location");
}

function logout($session)
{
	return session_destroy();
}

function hitung($table, $params=Null)
{
	if ($params == NUll) {
		$sql = "SELECT * FROM $table ";
	} else {
		$sql = "SELECT * FROM $table WHERE $params ";
	}

	return get($sql);
}

function hitung_absen($column, $table, $params=Null)
{
	if ($params == NUll) {
		$sql = "SELECT COUNT($column) AS jumlah FROM $table";
	} else {
		$sql = "SELECT COUNT($column) AS jumlah FROM $table WHERE $params ";
	}

	return get($sql);
}

function select($column, $table, $params=NULL)
{
	if ($params != NULL) {
		$sql = "SELECT $column FROM $table WHERE $params ";
	} else {
		$sql = "SELECT $column FROM $table ";
	}

	return get($sql);
}

function insert($table, $column, $values)
{
	$sql = "INSERT INTO $table ($column) VALUES ($values)";

	return run($sql);
}

function update($table, $data, $params)
{
	$sql = "UPDATE $table SET $data WHERE $params ";

	return run($sql);
}

function delete($table, $id=NULL, $params = NULL)
{
	if ($params != NULL) {
		$sql = "DELETE FROM $table WHERE $params ";
	}
	if ($id != NULL) {
		$sql = "DELETE FROM $table WHERE id = '$id' ";
	}

	return run($sql);
}

function gabung($table1, $table2, $condition, $params=NULL)
{
	if ($params != NULL) {
		$sql = "SELECT * FROM $table1 JOIN $table2 ON $condition WHERE $params ";
	} else {
		$sql = "SELECT * FROM $table1 JOIN $table2 ON $condition ";
	}

	return get($sql);
}

function open_form($act, $method, $attr)
{
	return "<form action='$act' method='$method' $attr >";
}

function close_form()
{
	return "</form>";
}

function input($type, $name, $attr)
{
		return "<input type='$type' name='$name' $attr>";
}

function label($for, $text)
{
	return "<label for='$for'>$text</label>";
}

function select_open($name, $attr)
{
	return "<select name='$name' $attr>";
}

function select_close()
{
	return "</select>";
}

function option($value, $attr=null, $name)
{
	return "<option value='$value' $attr>$name</option>";
}

function text($name, $attr, $value)
{
	return "<textarea name='$name' $attr>$value</textarea>";
}

function img($src, $alt=Null, $attr)
{
	return "<img scr='$src' alt='$alt' $attr />";
}

function location($locate)
{
	return "
		<script>
			$('button.confirm').click(function() {
				window.location='$locate';
			});
		</script>";
}

function active($change)
{
	return "
		<script type='text/javascript'>
			$(document).ready(function(){
				$('ul.nav-pills > li.$change').addClass('active');
				$('ul.nav-pills > li:first').attr({
					'class':'dashboard'
				});
			});
		</script>
	";
}

function notice($type)
{
	if ($type == 1) {
		return "<audio autoplay><source src='".base('music/success.wav')."'></audio>";
	} elseif($type == 0) {
		return "<audio autoplay><source src='".base('music/error.wav')."'></audio>";
	}
}

?>
