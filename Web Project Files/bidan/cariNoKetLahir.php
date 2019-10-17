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

$respon  = array();
$vaksin = array();
$ps = $conn->stmt_init();
$ps->prepare("select vaksin from tb_cat_imunisasi where no_ket_lahir=?");
$ps->bind_param("s", $p1);
$p1 = $_POST["txtNoKetLahir"];
$ps->execute();
$hasil = $ps->get_result();
$i=0;
if ($hasil->num_rows > 0){
	while ($row = $hasil->fetch_assoc()){
		$vaksin[$i] = $row["vaksin"];
		$i++;
	}
}
$respon["vaksin"] = $vaksin;

$ps = $conn->stmt_init();
$ps->prepare("select nama from tb_reg_anak where no_ket_lahir=?");
$ps->bind_param("s", $p1);
$p1 = $_POST["txtNoKetLahir"];
$ps->execute();
$hasil = $ps->get_result();
$row = $hasil->fetch_assoc();
$respon["nama"] = $row["nama"];
$ps->close();
$conn->close();
echo json_encode($respon);


?>