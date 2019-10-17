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

function updateTbRegIbu(){
	$sql = "update tb_reg_ibu set id_bidan=?, nik=?, nama=?, tempat_lahir=?, tgl_lahir=?, agama=?, pendidikan=?, gol_darah=?, pekerjaan=?, no_jkn=?, nik_suami=?, nama_suami=?, tempat_lahir_suami=?, tgl_lahir_suami=?, agama_suami=?, pendidikan_suami=?, gol_darah_suami=?, pekerjaan_suami=?, alamat_rumah=?, telp=?, id_kab=?, id_kec=? where username=?";
	$ps = $GLOBALS["conn"]->stmt_init();
	$ps->prepare($sql);
	$ps->bind_param("sssssssssssssssssssssss", $p1, $p2, $p3, $p4, $p5, $p6, $p7, $p8, $p9, $p10, $p11, $p12, $p13, $p14, $p15, $p16, $p17, $p18, $p19, $p20, $p21, $p22, $p23);

	$p1 = ($_POST["cmbBidan"] != "0") ? $_POST["cmbBidan"] : null;
	$p2 = $_POST["txtNik"];
	$p3 = $_POST["txtNama"];
	$p4 = $_POST["txtTempatLhr"];
	$p5 = $_POST["txtTglLhr"];
	$p6 = ($_POST["cmbAgama"] != "0") ? $_POST["cmbAgama"] : null;
	$p7 = ($_POST["cmbPendidikan"] != "0") ? $_POST["cmbPendidikan"] : null;
	$p8 = ($_POST["cmbGolDarah"] != "0") ? $_POST["cmbGolDarah"] : null;
	$p9 = $_POST["txtPekerjaan"];
	$p10= $_POST["txtNoJkn"];
	$p11= $_POST["txtNikSuami"];
	$p12= $_POST["txtNamaSuami"];
	$p13= $_POST["txtTempatLhrSuami"];
	$p14= $_POST["txtTglLhrSuami"];
	$p15= ($_POST["cmbAgamaSuami"] != "0") ? $_POST["cmbAgamaSuami"] : null;
	$p16= ($_POST["cmbPendidikanSuami"] != "0") ? $_POST["cmbPendidikanSuami"] : null;
	$p17= ($_POST["cmbGolDarahSuami"] != "0") ? $_POST["cmbGolDarahSuami"] : null;
	$p18= $_POST["txtPekerjaanSuami"];
	$p19= $_POST["txtAlamat"];
	$p20= $_POST["txtNoTelp"];
	$p21= $_POST["cmbKab"];
	$p22= $_POST["cmbKec"];
	$p23= $_SESSION["usernyaTawwa"];
	if(!$ps->execute())
		echo $ps->error;
	$ps->close();
}
updateTbRegIbu();
$conn->close();

?>