<?php

	include_once "conn.php";
	$sql = "update tb_user set username=?, password=password(?) where username=?";
	$ps = $conn->stmt_init();
	$ps->prepare($sql);
	$ps->bind_param("sss", $p1, $p2, $p3);
	$p1 = $_POST["txtUser"];
	$p2 = $_POST["txtPwd"];
	$p3 = $_POST["txtCurrentUser"];
	$ps->execute();
	$ps->close();
	$conn->close();

	$sql = "update tb_reg_ibu set username=? where username=?";
	$ps = $conn->stmt_init();
	$ps->prepare($sql);
	$ps->bind_param("ss", $p1, $p2);
	$p1 = $_POST["txtUser"];
	$p2 = $_POST["txtCurrentUser"];
	$ps->execute();
	$ps->close();
	$conn->close();

	echo "OK";
 ?>