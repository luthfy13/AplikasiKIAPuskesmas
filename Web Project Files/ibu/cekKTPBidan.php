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

$ps = $conn->stmt_init();
$ps->prepare("select id_bidan from tb_bidan where id_bidan=?");
$ps->bind_param("s", $p1);
$p1 = $_POST["idBidan"];
$ps->execute();
$hasil = $ps->get_result();
if ($hasil->num_rows > 0){
	echo "ada";
}
else{
	echo "belum ada";
}
$ps->close();
$conn->close();

?>