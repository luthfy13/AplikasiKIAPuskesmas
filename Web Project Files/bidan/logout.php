<?php
	include_once 'fungsi.php';
	
	if (session_status() == PHP_SESSION_NONE)
		session_start();
	$_SESSION["loginStat"] = "habis";
	session_unset();
	session_destroy();
	menuju("../login.php");
?>