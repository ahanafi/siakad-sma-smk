<?php

function login($username){
	$sql = "SELECT * FROM admin WHERE username = '$username' ";

	return get($sql);
}



?>