<?php

if (session_status() == PHP_SESSION_NONE)
	session_start();


if (isset($_SESSION["loginStat"])){
	if ($_SESSION["loginStat"] != "bidan lagi login"){
		ob_start();
		header('Location: ../login.php');
		ob_end_flush();
		die();
	}
}
else{
	ob_start();
	header('Location: ../login.php');
	ob_end_flush();
	die();
}

include_once 'conn.php';

$sql = "insert into tb_cat_imunisasi values(?,?,?)";
$ps = $conn->stmt_init();
$ps->prepare($sql);
$ps->bind_param("sss", $p1, $p2, $p3);
$p1 = $_POST["txtNoKetLahir"];
$p2 = $_POST["cmbVaksin"];
$p3 = $_POST["txtTglVaksin"];
$ps->execute();

$ps->close();
$conn->close();

?>