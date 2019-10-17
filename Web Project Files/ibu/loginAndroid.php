<?php

include_once "conn.php";

$sql = "
		SELECT
			tb_user.username,
			tb_user.password,
			tb_user.jenis
		FROM
			tb_user
		WHERE
			tb_user.username = ? 
			AND `password` = PASSWORD ( ? )
		";
$ps = $conn->stmt_init();
$ps->prepare($sql);
$ps->bind_param("ss", $user, $pwd);
$user = $_POST["txtUser"];
$pwd = $_POST["txtPwd"];
$ps->execute();
$hasil = $ps->get_result();

$respon = array();

if ($hasil->num_rows > 0){
	$respon["isEmpty"] = "false";

	$sql = "
		SELECT
		Count(tb_reg_anak.id_anak) as jml_anak
		FROM
		tb_reg_anak
		INNER JOIN tb_reg_ibu ON tb_reg_anak.no_reg_ibu = tb_reg_ibu.no_reg
		WHERE
		tb_reg_ibu.username = ?
		GROUP BY
		tb_reg_ibu.username
		";
	$ps = $conn->stmt_init();
	$ps->prepare($sql);
	$ps->bind_param("s", $user);
	$user = $_POST["txtUser"];
	$ps->execute();
	$hasil = $ps->get_result();
	$row = $hasil->fetch_assoc();
	$respon["jmlAnak"] = $row["jml_anak"];

	$sql = "
		SELECT
		tb_reg_anak.id_anak
		FROM
		tb_reg_anak
		INNER JOIN tb_reg_ibu ON tb_reg_anak.no_reg_ibu = tb_reg_ibu.no_reg
		WHERE
		tb_reg_ibu.username = ?
		ORDER BY tb_reg_anak.id_anak
		";
	$ps = $conn->stmt_init();
	$ps->prepare($sql);
	$ps->bind_param("s", $user);
	$user = $_POST["txtUser"];
	$ps->execute();
	$hasil = $ps->get_result();
	$i=0;
	$idAnak = array();
	while($row = $hasil->fetch_assoc()){
		$idAnak[$i] = $row["id_anak"];
		$i++;
	}
	$respon["idAnak"] = $idAnak;
}
else{
	$respon["isEmpty"] = "true";
}
$ps->close();
$conn->close();
echo json_encode($respon);


?>