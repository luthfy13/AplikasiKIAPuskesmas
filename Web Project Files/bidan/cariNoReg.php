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

include_once "conn.php";

$ps = $conn->stmt_init();
$ps->prepare("select no_reg from tb_cat_ibu_hamil where no_reg=?");
$ps->bind_param("s", $p1);
$p1 = $_POST["txtNoReg"];
$ps->execute();
$hasil = $ps->get_result();
if ($hasil->num_rows > 0){
	echo "Data Sudah Ada";
}
else{
	$ps = $conn->stmt_init();
	$ps->prepare("select nama from tb_reg_ibu where no_reg=?");
	$ps->bind_param("s", $p1);
	$p1 = $_POST["txtNoReg"];
	$ps->execute();
	$hasil = $ps->get_result();
	if ($hasil->num_rows > 0){
		$row = $hasil->fetch_assoc();
		echo $row["nama"];
	}
	else{
		echo "Data Tidak Ditemukan";
	}
	$ps->close();
	$conn->close();
}


?>