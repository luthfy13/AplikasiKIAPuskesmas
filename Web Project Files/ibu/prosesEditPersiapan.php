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

function updateTbPersiapan(){
	$sql = "update tb_persiapan set bulan_perkiraan=?, tahun_perkiraan=?, id_bidan1=?, id_bidan2=?, dana_persalinan=?, metode_kb=? where no_reg=?";
	$ps = $GLOBALS["conn"]->stmt_init();
	$ps->prepare($sql);
	$ps->bind_param("sssssss", $p1, $p2, $p3, $p4, $p5, $p6, $p7);
	$p1 = $_POST["cmbPerkiraan"];
	$p2 = $_POST["txtPerkiraan"];
	$p3 = $_POST["cmbPetugas1"];
	$p4 = $_POST["cmbPetugas2"];
	if ($_POST["txtDana"] != "Disiapkan Sendiri" && $_POST["txtDana"] != "Ditanggung JKN" && $_POST["txtDana"] != "0")
		$p5 = "Dibantu Oleh ".$_POST["txtDana"];
	else
		$p5 = $_POST["txtDana"];
	$p6 = $_POST["cmbMetodeKB"];
	$p7 = $_POST["txtNoReg"];
	$ps->execute();
	$ps->close();
}

function updateTbKendaraan(){
	$sql = "delete from tb_kendaraan where no_reg = ?";
	$ps = $GLOBALS["conn"]->stmt_init();
	$ps->prepare($sql);
	$ps->bind_param("s", $p1);
	$p1 = $_POST["txtNoReg"];
	$ps->execute();
	$ps->close();
	if ($_POST["txtNamaAmbulan1"] != ""){
		$sql = "insert into tb_kendaraan values(?,?,?)";
		$ps = $GLOBALS["conn"]->stmt_init();
		$ps->prepare($sql);
		$ps->bind_param("sss", $p1, $p2, $p3);
		$p1 = $_POST["txtNoReg"];
		$p2 = $_POST["txtNamaAmbulan1"];
		$p3 = $_POST["txtTelpAmbulan1"];
		$ps->execute();
		$ps->close();
	}
	if ($_POST["txtNamaAmbulan2"] != ""){
		$sql = "insert into tb_kendaraan values(?,?,?)";
		$ps = $GLOBALS["conn"]->stmt_init();
		$ps->prepare($sql);
		$ps->bind_param("sss", $p1, $p2, $p3);
		$p1 = $_POST["txtNoReg"];
		$p2 = $_POST["txtNamaAmbulan2"];
		$p3 = $_POST["txtTelpAmbulan2"];
		$ps->execute();
		$ps->close();
	}
	if ($_POST["txtNamaAmbulan3"] != ""){
		$sql = "insert into tb_kendaraan values(?,?,?)";
		$ps = $GLOBALS["conn"]->stmt_init();
		$ps->prepare($sql);
		$ps->bind_param("sss", $p1, $p2, $p3);
		$p1 = $_POST["txtNoReg"];
		$p2 = $_POST["txtNamaAmbulan3"];
		$p3 = $_POST["txtTelpAmbulan3"];
		$ps->execute();
		$ps->close();
	}
}

function updateTbDonor(){
	$sql = "delete from tb_donor where no_reg = ?";
	$ps = $GLOBALS["conn"]->stmt_init();
	$ps->prepare($sql);
	$ps->bind_param("s", $p1);
	$p1 = $_POST["txtNoReg"];
	$ps->execute();
	$ps->close();
	if ($_POST["txtNamaPendonor1"] != ""){
		$sql = "insert into tb_donor values(?,?,?)";
		$ps = $GLOBALS["conn"]->stmt_init();
		$ps->prepare($sql);
		$ps->bind_param("sss", $p1, $p2, $p3);
		$p1 = $_POST["txtNoReg"];
		$p2 = $_POST["txtNamaPendonor1"];
		$p3 = $_POST["txtTelpPendonor1"];
		$ps->execute();
		$ps->close();
	}
	if ($_POST["txtNamaPendonor2"] != ""){
		$sql = "insert into tb_donor values(?,?,?)";
		$ps = $GLOBALS["conn"]->stmt_init();
		$ps->prepare($sql);
		$ps->bind_param("sss", $p1, $p2, $p3);
		$p1 = $_POST["txtNoReg"];
		$p2 = $_POST["txtNamaPendonor2"];
		$p3 = $_POST["txtTelpPendonor2"];
		$ps->execute();
		$ps->close();
	}
	if ($_POST["txtNamaPendonor3"] != ""){
		$sql = "insert into tb_donor values(?,?,?)";
		$ps = $GLOBALS["conn"]->stmt_init();
		$ps->prepare($sql);
		$ps->bind_param("sss", $p1, $p2, $p3);
		$p1 = $_POST["txtNoReg"];
		$p2 = $_POST["txtNamaPendonor3"];
		$p3 = $_POST["txtTelpPendonor3"];
		$ps->execute();
		$ps->close();
	}
}

updateTbPersiapan();
updateTbKendaraan();
updateTbDonor();
$conn->close();

?>