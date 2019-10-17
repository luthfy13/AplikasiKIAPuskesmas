<?php

if (session_status() == PHP_SESSION_NONE)
	session_start();


if (isset($_SESSION["loginStat"])){
	if ($_SESSION["loginStat"] != "ibu lagi login"){
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

$sql = "update tb_bidan set id_bidan=?, nama=?, alamat=?, telp=?, username=? where username=?";
$ps = $conn->stmt_init();
$ps->prepare($sql);
$ps->bind_param("ssssss", $p1, $p2, $p3, $p4, $p5, $p6);
$p1 = $_POST["txtId"];
$p2 = $_POST["txtNama"];
$p3 = $_POST["txtAlamat"];
$p4 = $_POST["txtTelp"];
$p5 = $_POST["txtUser"];
$p6 = $_SESSION["userLogin"];
$ps->execute();

if ($_POST["txtPwd"] != ""){
	$sql = "update tb_user set username=?, password=password(?) where username=?";
	$ps = $conn->stmt_init();
	$ps->prepare($sql);
	$ps->bind_param("sss", $p1, $p2, $p3);
	$p1 = $_POST["txtUser"];
	$p2 = $_POST["txtPwd"];
	$p3 = $_SESSION["userLogin"];
}
else{
	$sql = "update tb_user set username=? where username=?";
	$ps = $conn->stmt_init();
	$ps->prepare($sql);
	$ps->bind_param("ss", $p1, $p2);
	$p1 = $_POST["txtUser"];
	$p2 = $_SESSION["userLogin"];
}


$ps->execute();

$_SESSION["userLogin"] = $_POST["txtUser"];

$ps->close();
$conn->close();

?>