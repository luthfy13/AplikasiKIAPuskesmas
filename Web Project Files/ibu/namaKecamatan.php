<?php
	if (session_status() == PHP_SESSION_NONE)
		session_start();
	
	if (isset($_SESSION["loginStat"])){
		if ($_SESSION["loginStat"] != "ibu lagi login")
			exit();
	}
	else{
		echo "Kacian deh lu";
		exit();
	}
	
	include_once "conn.php";
	
	$ps = $conn->stmt_init();
	$ps->prepare("select * from tb_kecamatan where id_kab=?  order by name");
	$ps->bind_param("s", $idKec);
	$idKec = $_POST["idKab"];
	$ps->execute();
	$hasil = $ps->get_result();
	echo "<option value='0'>PILIH</option>";
	while($row = $hasil->fetch_assoc()){
		echo "<option value='".$row["id"]."'>".$row["name"]."</option>";
	}
	$ps->close();
	$conn->close();
?>