<?php
	if (session_status() == PHP_SESSION_NONE)
		session_start();


	if (isset($_SESSION["loginStat"])){
		if ($_SESSION["loginStat"] != "bidan lagi login"){
			ob_start();
			header('Location: login.php');
			ob_end_flush();
			die();
		}
		else{
			ob_start();
			header('Location: bidan/index.php');
			ob_end_flush();
			die();
		}
	}
	else{
		ob_start();
		header('Location: login.php');
		ob_end_flush();
		die();
	}
?>