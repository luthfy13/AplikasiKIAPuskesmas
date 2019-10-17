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

function updateTbRegAnak(){
	$sql = "update tb_reg_anak set no_ket_lahir=?, jk=?, tgl_lahir=?, waktu_lahir=?, jns_kelahiran=?, kelahiran_ke=?, berat_lahir=?, panjang_badan=?, tempat_lahir=?, nama_tempat_lahir=?, alamat_tempat_lahir=?, nama=?, nama_saksi1=?, nama_saksi2=?, id_penolong_persalinan=?, umur_ibu=?, umur_ayah=? where id_anak=?";
	$ps = $GLOBALS["conn"]->stmt_init();
	$ps->prepare($sql);
	$ps->bind_param("ssssssssssssssssss", $p1, $p2, $p3, $p4, $p5, $p6, $p7, $p8, $p9, $p10, $p11, $p12, $p13, $p14, $p15, $p16, $p17, $p18);
	$p1 = $_POST["txtNoKetLhr"];
	$p2 = $_POST["cmbJK"];
	$p3 = $_POST["txtTglLhr"];
	$p4 = str_replace(" ","",$_POST["txtJam"]);//$_POST["txtJam"];
	if ($_POST["cmbJnsKelahiran"] != "0")
		$p5 = $_POST["cmbJnsKelahiran"];
	else
		$p5 = null;
	if ($_POST["txtKelahiranKe"] != "")
		$p6 = $_POST["txtKelahiranKe"];
	else
		$p6 = null;
	if ($_POST["txtBerat"] != "")
		$p7 = $_POST["txtBerat"];
	else
		$p7 = null;
	if ($_POST["txtTinggi"] != "")
		$p8 = $_POST["txtTinggi"];
	else
		$p8 = null;
	if ($_POST["cmbBersalin"] != "0")
		$p9 = $_POST["cmbBersalin"];
	else
		$p9 = null;
	$p10= $_POST["txtNamaTempatPersalinan"];
	$p11= $_POST["txtAlamatTempatPersalinan"];
	$p12= $_POST["txtNamaAnak"];
	$p13= $_POST["txtSaksi1"];
	$p14= $_POST["txtSaksi2"];
	if ($_POST["cmbPenolongPersalinan"] != "0")
		$p15= $_POST["cmbPenolongPersalinan"];
	else
		$p15= null;
	if ($_POST["txtUmurIbu"] != "")
		$p16= $_POST["txtUmurIbu"];
	else
		$p16= null;
	if ($_POST["txtUmurAyah"] != "")
		$p17= $_POST["txtUmurAyah"];
	else
		$p17= null;
	$p18= $_POST["txtIdAnak"];
	if(!$ps->execute())
		echo $ps->error;
	$ps->close();
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

function insertTbRegAnak(){
	$sql = "insert into tb_reg_anak (id_anak, no_reg_ibu, jns_kelahiran) values(?,?,?)";
	$ps = $GLOBALS["conn"]->stmt_init();
	$ps->prepare($sql);
	$ps->bind_param("sss", $p1, $p2, $p3);
	$p1 = generateIdAnak();
	$p2 = $_POST["txtNoReg"];
	$p3 = $_POST["cmbJnsKelahiran"];
	if(!$ps->execute())
		echo $ps->error;
	$ps->close();
}

function jmlAnakDimasukkan(){
	$sql="select count(id_anak) as jml from tb_reg_anak where no_reg_ibu = ?";
	$ps = $GLOBALS["conn"]->stmt_init();
	$ps->prepare($sql);
	$ps->bind_param("s", $p1);
	$p1 = $_POST["txtNoReg"];
	$ps->execute();
	$hasil = $ps->get_result();
	$row = $hasil->fetch_assoc();
	$ps->close();
	return $row["jml"];
}

updateTbRegAnak();

if ($_POST["cmbJnsKelahiran"] == "Kembar 2" and jmlAnakDimasukkan() < 2){
	insertTbRegAnak();
}
else if ($_POST["cmbJnsKelahiran"] == "Kembar 3" and jmlAnakDimasukkan() < 3){
	insertTbRegAnak();
}
else if ($_POST["cmbJnsKelahiran"] == "Kembar 4" and jmlAnakDimasukkan() < 4){
	insertTbRegAnak();
}
else if ($_POST["cmbJnsKelahiran"] == "Kembar 5" and jmlAnakDimasukkan() < 5){
	insertTbRegAnak();
}

$conn->close();

?>