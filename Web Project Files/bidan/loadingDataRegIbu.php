<?php

	include_once "conn.php";
	$respon = array();
	$sql = "
		SELECT
		tb_reg_ibu.no_reg,
		tb_reg_ibu.nik,
		tb_reg_ibu.nama,
		tb_reg_ibu.tempat_lahir,
		DATE_FORMAT(tb_reg_ibu.tgl_lahir, '%Y/%m/%d') as tgl_lahir,
		tb_reg_ibu.kehamilan_ke,
		tb_reg_ibu.umur_anak_terakhir,
		tb_reg_ibu.agama,
		tb_reg_ibu.pendidikan,
		tb_reg_ibu.gol_darah,
		tb_reg_ibu.pekerjaan,
		tb_reg_ibu.no_jkn,
		tb_reg_ibu.nik_suami,
		tb_reg_ibu.nama_suami,
		tb_reg_ibu.tempat_lahir_suami,
		DATE_FORMAT(tb_reg_ibu.tgl_lahir_suami, '%Y/%m/%d') as tgl_lahir_suami,
		tb_reg_ibu.agama_suami,
		tb_reg_ibu.pendidikan_suami,
		tb_reg_ibu.gol_darah_suami,
		tb_reg_ibu.pekerjaan_suami,
		tb_reg_ibu.alamat_rumah,
		tb_reg_ibu.telp,
		tb_reg_ibu.username,
		tb_bidan.nama as nama_bidan,
		tb_kabupaten.`name` as kabupaten,
		tb_kecamatan.`name` as kecamatan,
		tb_kabupaten.id as id_kab,
		tb_kecamatan.id as id_kec
		FROM
		tb_reg_ibu
		LEFT JOIN tb_bidan ON tb_reg_ibu.id_bidan = tb_bidan.id_bidan
		LEFT JOIN tb_kabupaten ON tb_reg_ibu.id_kab = tb_kabupaten.id
		LEFT JOIN tb_kecamatan ON tb_reg_ibu.id_kec = tb_kecamatan.id
		WHERE
		tb_reg_ibu.username = ?
	";
	$ps = $conn->stmt_init();
	$ps->prepare($sql);
	$ps->bind_param("s", $user);
	$user = $_POST["txtUser"];
	$ps->execute();
	$hasil = $ps->get_result();
	while ($row = $hasil->fetch_assoc()) {
		$respon["no_reg"] = $row["no_reg"];
		$respon["nik"] = $row["nik"];
		$respon["nama"] = $row["nama"];
		$respon["tempat_lahir"] = $row["tempat_lahir"];
		$respon["tgl_lahir"] = $row["tgl_lahir"];
		$respon["agama"] = $row["agama"];
		$respon["pendidikan"] = $row["pendidikan"];
		$respon["gol_darah"] = $row["gol_darah"];
		$respon["pekerjaan"] = $row["pekerjaan"];
		$respon["no_jkn"] = $row["no_jkn"];
		$respon["nik_suami"] = $row["nik_suami"];
		$respon["nama_suami"] = $row["nama_suami"];
		$respon["tempat_lahir_suami"] = $row["tempat_lahir_suami"];
		$respon["tgl_lahir_suami"] = $row["tgl_lahir_suami"];
		$respon["agama_suami"] = $row["agama_suami"];
		$respon["pendidikan_suami"] = $row["pendidikan_suami"];
		$respon["gol_darah_suami"] = $row["gol_darah_suami"];
		$respon["pekerjaan_suami"] = $row["pekerjaan_suami"];
		$respon["alamat_rumah"] = $row["alamat_rumah"];
		$respon["telp"] = $row["telp"];
		$respon["username"] = $row["username"];
		$respon["nama_bidan"] = $row["nama_bidan"];
		$respon["kabupaten"] = $row["kabupaten"];
		$respon["kecamatan"] = $row["kecamatan"];
		$respon["id_kab"] = $row["id_kab"];
		$respon["id_kec"] = $row["id_kec"];
		$respon["kehamilan_ke"] = $row["kehamilan_ke"];
		$respon["umur_anak_terakhir"] = $row["umur_anak_terakhir"];
	}

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

    $id_kab = array();
	$nama_kab = array();
	$i=0;
	$sql = "select * from tb_kabupaten";
    $hasil = $conn->query($sql);
    while($row = $hasil->fetch_assoc()){
    	$id_kab[$i] = $row["id"];
		$nama_kab[$i] = $row["name"];
		$i++;
    }
    $respon["id_kab_array"] = $id_kab;
    $respon["nama_kab_array"] = $nama_kab;

	$id_kec = array();
	$nama_kec = array();
	$i=0;
	$sql = "select * from tb_kecamatan";
    $hasil = $conn->query($sql);
    while($row = $hasil->fetch_assoc()){
    	$id_kec[$i] = $row["id"];
		$nama_kec[$i] = $row["name"];
		$i++;
    }
    $respon["id_kec_array"] = $id_kec;
    $respon["nama_kec_array"] = $nama_kec;    

	$ps->close();
	$conn->close();

	echo json_encode($respon);
 ?>