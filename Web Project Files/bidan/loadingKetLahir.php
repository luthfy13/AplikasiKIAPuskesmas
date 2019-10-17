<?php

	include_once "conn.php";
	$respon = array();
	$sql = "
		SELECT
			tb_reg_ibu.no_reg,
			tb_reg_ibu.nama,
			tb_reg_ibu.pekerjaan,
			tb_reg_ibu.nik,
			tb_reg_ibu.nama_suami,
			tb_reg_ibu.nik_suami,
			tb_reg_ibu.pekerjaan_suami,
			tb_reg_ibu.alamat_rumah,
			tb_kecamatan.`name` AS kecamatan,
			tb_kabupaten.`name` AS kabupaten,
			tb_reg_anak.no_ket_lahir,
			tb_reg_anak.jk,
			tb_reg_anak.tgl_lahir,
			TIME_FORMAT( tb_reg_anak.waktu_lahir, '%H:%i' ) AS waktu_lahir,
			tb_reg_anak.jns_kelahiran,
			tb_reg_anak.kelahiran_ke,
			tb_reg_anak.berat_lahir,
			tb_reg_anak.panjang_badan,
			tb_reg_anak.tempat_lahir,
			tb_reg_anak.nama_tempat_lahir,
			tb_reg_anak.alamat_tempat_lahir,
			tb_reg_anak.nama AS nama_anak,
			tb_reg_anak.nama_saksi1,
			tb_reg_anak.nama_saksi2,
			tb_reg_anak.id_penolong_persalinan,
			tb_reg_anak.umur_ibu,
			tb_reg_anak.umur_ayah,
			tb_bidan.nama as nama_bidan
		FROM
			tb_reg_anak
			INNER JOIN tb_reg_ibu ON tb_reg_anak.no_reg_ibu = tb_reg_ibu.no_reg
			LEFT JOIN tb_bidan on tb_bidan.id_bidan = tb_reg_anak.id_penolong_persalinan
			LEFT JOIN tb_kecamatan ON tb_reg_ibu.id_kec = tb_kecamatan.id
			LEFT JOIN tb_kabupaten ON tb_reg_ibu.id_kab = tb_kabupaten.id
		WHERE tb_reg_anak.id_anak = ?
	";
	$ps = $conn->stmt_init();
	$ps->prepare($sql);
	$ps->bind_param("s", $user);
	$user = $_POST["idAnak"];
	$ps->execute();
	$hasil = $ps->get_result();
	$row = $hasil->fetch_assoc();
	$respon = $row;

	$id_bidan = array();
	$nama_bidan = array();
	$i=0;
	$sql = "select * from tb_bidan";
    $hasil = $conn->query($sql);
    while($row = $hasil->fetch_assoc()){
    	$id_bidan[$i] = $row["id_bidan"];
		$nama_bidan[$i] = $row["nama"];
		$i++;
    }
    $respon["id_bidan_array"] = $id_bidan;
    $respon["nama_bidan_array"] = $nama_bidan;

	$ps->close();
	$conn->close();

	echo json_encode($respon);
 ?>