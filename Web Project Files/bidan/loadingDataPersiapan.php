<?php

include_once "conn.php";

$respon = array();
$noReg = "";
$sql = "
	SELECT
	tb_persiapan.no_reg,
	tb_reg_ibu.nama,
	tb_reg_ibu.alamat_rumah,
	tb_persiapan.bulan_perkiraan,
	tb_persiapan.tahun_perkiraan,
	tb_persiapan.dana_persalinan,
	tb_persiapan.metode_kb,
	tb_persiapan.id_bidan1,
	tb_persiapan.id_bidan2,
	a.nama AS nama_bidan1,
	b.nama AS nama_bidan2
	FROM
	tb_persiapan
	INNER JOIN tb_reg_ibu ON tb_persiapan.no_reg = tb_reg_ibu.no_reg
	LEFT JOIN tb_bidan AS a ON tb_persiapan.id_bidan1 = a.id_bidan
	LEFT JOIN tb_bidan AS b ON tb_persiapan.id_bidan2 = b.id_bidan
	WHERE
		tb_reg_ibu.username = ?
";
$ps = $conn->stmt_init();
$ps->prepare($sql);
$ps->bind_param("s", $user);
$user = $_POST["txtUser"];
$ps->execute();
$hasil = $ps->get_result();
if ($hasil->num_rows > 0){
	$row = $hasil->fetch_assoc();
	$respon = $row;
	$respon["adaji"] = "ada";
	$noReg = $row["no_reg"];
}
else{
	$respon["adaji"] = "tidak ada";
}

$ambulanceNama = array();
$ambulanceTelp = array();
$sql = "select * from tb_kendaraan where no_reg = ?";
$ps = $conn->stmt_init();
$ps->prepare($sql);
$ps->bind_param("s", $p1);
$p1 = $noReg;
$ps->execute();
$hasil = $ps->get_result();
if ($hasil->num_rows > 0){
	$i=0;
	while($row = $hasil->fetch_assoc()){
		$ambulanceNama[$i] = $row["pemilik_ambulance"];
		$ambulanceTelp[$i] = $row["telp"];
		$i++;
	}
}
$respon["ambulanceNama"] = $ambulanceNama;
$respon["ambulanceTelp"] = $ambulanceTelp;

$pendonorNama = array();
$pendonorTelp = array();
$sql = "select * from tb_donor where no_reg = ?";
$ps = $conn->stmt_init();
$ps->prepare($sql);
$ps->bind_param("s", $p1);
$p1 = $noReg;
$ps->execute();
$hasil = $ps->get_result();
if ($hasil->num_rows > 0){
	$i=0;
	while($row = $hasil->fetch_assoc()){
		$pendonorNama[$i] = $row["nama_donor"];
		$pendonorTelp[$i] = $row["telp"];
		$i++;
	}
}
$respon["pendonorNama"] = $pendonorNama;
$respon["pendonorTelp"] = $pendonorTelp;


$ps->close();
$conn->close();

echo json_encode($respon);

?>