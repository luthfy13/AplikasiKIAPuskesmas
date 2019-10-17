<?php
	function menuju($alamat){
		ob_start();
		header('Location: '.$alamat);
		ob_end_flush();
		die();
	}
?>