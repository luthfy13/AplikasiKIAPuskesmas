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

$respon=array();
$IdAnak = "";
$jnsKelahiran="";

$ps = $conn->stmt_init();
$ps->prepare("select no_reg_ibu,nama,no_ket_lahir,jns_kelahiran, tgl_lahir, id_anak from tb_reg_anak where no_reg_ibu=? order by id_anak desc");
$ps->bind_param("s", $p1);
$p1 = $_POST["txtNoReg"];
$ps->execute();
$hasil = $ps->get_result();
$row = $hasil->fetch_assoc();
$IdAnak = $row["id_anak"];
$jnsKelahiran = $row["jns_kelahiran"];
if ($row["nama"] != "" or $row["no_ket_lahir"] != "" or $row["tgl_lahir"] != ""){
	echo "Data Sudah Ada";
}
else{
	$sql="
		SELECT
		tb_reg_ibu.nama,
		tb_reg_ibu.pekerjaan,
		tb_reg_ibu.nik,
		year(CURRENT_DATE) - year(tgl_lahir) AS umur_ibu,
		tb_reg_ibu.nama_suami,
		tb_reg_ibu.nik_suami,
		year(CURRENT_DATE) - year(tgl_lahir_suami) AS umur_ayah,
		tb_reg_ibu.pekerjaan_suami,
		tb_reg_ibu.alamat_rumah,
		tb_kecamatan.`name` as kecamatan,
		tb_kabupaten.`name` as kabupaten
		FROM
		tb_reg_ibu
		LEFT JOIN tb_kecamatan ON tb_reg_ibu.id_kec = tb_kecamatan.id
		LEFT JOIN tb_kabupaten ON tb_reg_ibu.id_kab = tb_kabupaten.id
		WHERE tb_reg_ibu.no_reg = ?
	";
	$ps = $conn->stmt_init();
	$ps->prepare($sql);
	$ps->bind_param("s", $p1);
	$p1 = $_POST["txtNoReg"];
	$ps->execute();
	$hasil = $ps->get_result();
	if ($hasil->num_rows > 0){
		$row = $hasil->fetch_assoc();
		$row["id_anak"] = $IdAnak;
		$row["jns_kelahiran"] = $jnsKelahiran;
		echo json_encode($row);
	}
	else{
		echo "Data Tidak Ditemukan";
	}
	$ps->close();
	$conn->close();
}


?>