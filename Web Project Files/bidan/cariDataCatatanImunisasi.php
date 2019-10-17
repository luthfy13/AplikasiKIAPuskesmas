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

$sql = "
	SELECT
	tb_cat_imunisasi.no_ket_lahir,
	tb_reg_anak.id_anak
	FROM
	tb_cat_imunisasi
	INNER JOIN tb_reg_anak ON tb_cat_imunisasi.no_ket_lahir = tb_reg_anak.no_ket_lahir
	where tb_reg_anak.id_anak = ? or tb_cat_imunisasi.no_ket_lahir = ?
";
$ps = $conn->stmt_init();
$ps->prepare($sql);
$ps->bind_param("ss", $p1, $p1);
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