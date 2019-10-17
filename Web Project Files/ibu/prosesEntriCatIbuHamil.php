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

$sql = "insert into tb_cat_ibu_hamil values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
$ps = $conn->stmt_init();
$ps->prepare($sql);
$ps->bind_param("sssssssssssssss", $p1, $p2, $p3, $p4, $p5, $p6, $p7, $p8, $p9, $p10, $p11, $p12, $p13, $p14, $p15);
$p1 = $_POST["txtNoReg"];
$p2 = $_POST["txtHamilKe"];
$p3 = $_POST["txtJmlPersalinan"];
$p4 = $_POST["txtJmlKeguguran"];
$p5 = $_POST["txtJmlGravida"];
$p6 = $_POST["txtJmlParitas"];
$p7 = $_POST["txtJmlAbortus"];
$p8 = $_POST["txtJmlAnakHidup"];
$p9 = $_POST["txtJmlLahirMati"];
$p10= $_POST["txtJmlAnakLhrKrgBln"];
$p11= $_POST["txtJarakKehamilan"];
$p12= $_POST["cmbStatusTT"]; 
$p13= $_POST["txtStatusTT"];
$p14= $_POST["txtPnlgPersalinan"];
$p15= $_POST["cmbCaraPersalinan"];
$ps->execute();

$ps->close();
$conn->close();

echo $kode;

?>