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


include_once "conn.php";

$sql = "SELECT * FROM tb_persiapan WHERE no_reg = ?";
$ps = $conn->stmt_init();
$ps->prepare($sql);
$ps->bind_param("s", $p1);
$p1 = $_POST["txtCari"];
$ps->execute();

$hasil = $ps->get_result();
$nilai = "";
if ($hasil->num_rows > 0){
	$nilai = "Ada";
}
else{
	$nilai = "Tidak Ada";
}
$ps->close();
$conn->close();

echo $nilai;
?>