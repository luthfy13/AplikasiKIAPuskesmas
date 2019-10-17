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

$sql = "update tb_cat_ibu_hamil set hamil_ke=?, jml_persalinan=?, jml_keguguran=?, jml_gravida=?, jml_paritas=?, jml_abortus=?, jml_anak_hidup=?, jml_lhr_mati=?, jml_anak_lhr_krg_bln=?, jarak_kehamilan=?, bulan_tt=?, tahun_tt=?, penolong_persalinan=?, cara_persalinan=? where no_reg=?";
$ps = $conn->stmt_init();
$ps->prepare($sql);
$ps->bind_param("sssssssssssssss", $p1, $p2, $p3, $p4, $p5, $p6, $p7, $p8, $p9, $p10, $p11, $p12, $p13, $p14, $p15);
$p1 = $_POST["txtHamilKe"];
$p2 = $_POST["txtJmlPersalinan"];
$p3 = $_POST["txtJmlKeguguran"];
$p4 = $_POST["txtJmlGravida"];
$p5 = $_POST["txtJmlParitas"];
$p6 = $_POST["txtJmlAbortus"];
$p7 = $_POST["txtJmlAnakHidup"];
$p8 = $_POST["txtJmlLahirMati"];
$p9 = $_POST["txtJmlAnakLhrKrgBln"];
$p10= $_POST["txtJarakKehamilan"];
$p11= $_POST["cmbStatusTT"]; 
$p12= $_POST["txtStatusTT"];
$p13= $_POST["txtPnlgPersalinan"];
$p14= $_POST["cmbCaraPersalinan"];
$p15= $_POST["txtNoReg"];
$ps->execute();

$ps->close();
$conn->close();

?>