<?php

	include_once "conn.php";
	$respon = array();
	$sql = "
		SELECT
		tb_cat_ibu_hamil.no_reg,
		tb_cat_ibu_hamil.hamil_ke,
		tb_cat_ibu_hamil.jml_persalinan,
		tb_cat_ibu_hamil.jml_keguguran,
		tb_cat_ibu_hamil.jml_gravida,
		tb_cat_ibu_hamil.jml_paritas,
		tb_cat_ibu_hamil.jml_abortus,
		tb_cat_ibu_hamil.jml_anak_hidup,
		tb_cat_ibu_hamil.jml_lhr_mati,
		tb_cat_ibu_hamil.jml_anak_lhr_krg_bln,
		tb_cat_ibu_hamil.jarak_kehamilan,
		tb_cat_ibu_hamil.bulan_tt,
		tb_cat_ibu_hamil.tahun_tt,
		tb_cat_ibu_hamil.penolong_persalinan,
		tb_cat_ibu_hamil.cara_persalinan,
		tb_reg_ibu.nama
		FROM
		tb_cat_ibu_hamil
		INNER JOIN tb_reg_ibu ON tb_cat_ibu_hamil.no_reg = tb_reg_ibu.no_reg
		where tb_reg_ibu.username = ?
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
	}
	else{
		$respon["adaji"] = "tidak ada";
	}
	

	$ps->close();
	$conn->close();

	echo json_encode($respon);
 ?>