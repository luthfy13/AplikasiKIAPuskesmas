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
$ps->prepare("select username from tb_user where username=?");
$ps->bind_param("s", $p1);
$p1 = $_POST["txtUsername"];
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