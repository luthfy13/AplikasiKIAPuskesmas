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

$sql = "insert into tb_bidan values (?,?,?,?,?)";
$ps = $conn->stmt_init();
$ps->prepare($sql);
$ps->bind_param("sssss", $p1, $p2, $p3, $p4, $p5);
$p1 = $_POST["txtId"];
$p2 = $_POST["txtNama"];
$p3 = $_POST["txtAlamat"];
$p4 = $_POST["txtTelp"];
$p5 = $_POST["txtUser"];
$ps->execute();

$sql = "insert into tb_user values (?,?,password(?))";
$ps = $conn->stmt_init();
$ps->prepare($sql);
$ps->bind_param("sss", $p1, $p2, $p3);
$p1 = $_POST["txtUser"];
$p2 = "Bidan";
$p3 = $_POST["txtPwd"];
$ps->execute();

$ps->close();
$conn->close();

?>