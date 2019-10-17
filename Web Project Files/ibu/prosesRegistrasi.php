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

function generateNoReg(){
	$kode="";
	$hasil = $GLOBALS["conn"]->query("select no_reg from tb_reg_ibu order by no_reg desc limit 1");
	$row = $hasil->fetch_assoc();
	$hsl = $row["no_reg"];
	$hsl = (int) substr($hsl, 3, 4);
	$hsl++;
	if ($hsl < 10)
		$kode = "REG000".$hsl;
	else if ($hsl < 100)
		$kode = "REG00".$hsl;
	else if ($hsl < 1000)
		$kode = "REG0".$hsl;
	else if ($hsl < 10000)
		$kode = "REG".$hsl;
	return $kode;
}

function generateIdAnak(){
	$kode="";
	$hasil = $GLOBALS["conn"]->query("select id_anak from tb_reg_anak order by id_anak desc limit 1");
	$row = $hasil->fetch_assoc();
	$hsl = $row["id_anak"];
	$hsl = (int) substr($hsl, 3, 4);
	$hsl++;
	if ($hsl < 10)
		$kode = "RA000".$hsl;
	else if ($hsl < 100)
		$kode = "RA00".$hsl;
	else if ($hsl < 1000)
		$kode = "RA0".$hsl;
	else if ($hsl < 10000)
		$kode = "RA".$hsl;
	return $kode;
}

$kode = generateNoReg();
$idAnak = generateIdAnak();

$sql = "insert into tb_user values(?,?,password(?))";
$ps = $conn->stmt_init();
$ps->prepare($sql);
$ps->bind_param("sss", $p1, $p2, $p3);
$p1 = $_POST["txtUsername"];
$p2 = "Ibu";
$p3 = "aplikasiKIA";
$ps->execute();

$sql = "insert into tb_reg_ibu (no_reg, nik, nama, username, id_kab) values(?,?,?,?,?)";
$ps = $conn->stmt_init();
$ps->prepare($sql);
$ps->bind_param("sssss", $p1, $p2, $p3, $p4, $p5);
$p1 = $kode;
$p2 = $_POST["txtNoKTP"];
$p3 = $_POST["txtNamaIbu"];
$p4 = $_POST["txtUsername"];
$p5 = "7309";
$ps->execute();

$sql = "insert into tb_reg_anak (id_anak, no_reg_ibu) values(?,?)";
$ps = $conn->stmt_init();
$ps->prepare($sql);
$ps->bind_param("ss", $p1, $p2);
$p1 = $idAnak;
$p2 = $kode;
$ps->execute();

$ps->close();
$conn->close();

echo $kode;

?>