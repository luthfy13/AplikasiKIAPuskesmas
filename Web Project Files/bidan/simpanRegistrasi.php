<?php
	include_once "conn.php";
	$respon["isOk"] = "false";
		
	// $sql = "SELECT tb_user.username, tb_user.password, tb_user.jenis
	// 		FROM tb_user
	// 		WHERE tb_user.username = ? AND password = PASSWORD ( ? ) AND jenis = 'Ibu'";
	// $ps = $conn->stmt_init();
	// $ps->prepare($sql);
	// $ps->bind_param("ss", $user, $pwd);
	// $user = $_POST["txtUser"];
	// $pwd = $_POST["txtPwd"];
	// $ps->execute();
	// $hasil = $ps->get_result();
	
	$respon = array();

	// if ($hasil->num_rows > 0){
		$sql = "update tb_reg_ibu set id_bidan=?, nama=?, tempat_lahir=?, tgl_lahir=?, kehamilan_ke=?, umur_anak_terakhir=?, agama=?, pendidikan=?, gol_darah=?, pekerjaan=?, no_jkn=?, nik_suami=?, nama_suami=?, tempat_lahir_suami=?, tgl_lahir_suami=?, agama_suami=?, pendidikan_suami=?, gol_darah_suami=?, pekerjaan_suami=?, alamat_rumah=?, id_kab=?, id_kec=?, telp=?  where username=?";
		$ps = $conn->stmt_init();
		$ps->prepare($sql);
		$ps->bind_param("ssssssssssssssssssssssss", $id_bidan, $nama, $tempat_lahir, $tgl_lahir, $kehamilan_ke, $umur_anak_terakhir, $agama, $pendidikan, $gol_darah, $pekerjaan, $no_jkn, $nik_suami, $nama_suami, $tempat_lahir_suami, $tgl_lahir_suami, $agama_suami, $pendidikan_suami, $gol_darah_suami, $pekerjaan_suami, $alamat_rumah, $id_kab, $id_kec, $telp,  $username);

		$id_bidan           = $_POST["id_bidan"];
		$nama               = $_POST["nama"];
		$tempat_lahir       = $_POST["tempat_lahir"];
		if ($_POST["tgl_lahir"] != "")
			$tgl_lahir = $_POST["tgl_lahir"];
		else
			$tgl_lahir = null;
		
		if ($_POST["agama"] != "-PILIH-")
			$agama = $_POST["agama"];
		else
			$agama = null;

		if ($_POST["kehamilan_ke"] != "")
			$kehamilan_ke = $_POST["kehamilan_ke"];
		else
			$kehamilan_ke = null;

		if ($_POST["umur_anak_terakhir"] != "")
			$umur_anak_terakhir = $_POST["umur_anak_terakhir"];
		else
			$umur_anak_terakhir = null;

		if ($_POST["pendidikan"] != "-PILIH-")
			$pendidikan = $_POST["pendidikan"];
		else
			$pendidikan = null;

		if ($_POST["gol_darah"] != "-PILIH-")
			$gol_darah = $_POST["gol_darah"];
		else
			$gol_darah = null;

		$pekerjaan          = $_POST["pekerjaan"];
		$no_jkn             = $_POST["no_jkn"];
		$nik_suami          = $_POST["nik_suami"];
		$nama_suami         = $_POST["nama_suami"];
		$tempat_lahir_suami = $_POST["tempat_lahir_suami"];
		if ($_POST["tgl_lahir_suami"] != "")
			$tgl_lahir_suami = $_POST["tgl_lahir_suami"];
		else
			$tgl_lahir_suami = null;

		if ($_POST["agama_suami"] != "-PILIH-")
			$agama_suami = $_POST["agama_suami"];
		else
			$agama_suami = null;

		if ($_POST["pendidikan_suami"] != "-PILIH-")
			$pendidikan_suami = $_POST["pendidikan_suami"];
		else
			$pendidikan_suami = null;

		if ($_POST["gol_darah_suami"] != "-PILIH-")
			$gol_darah_suami = $_POST["gol_darah_suami"];
		else
			$gol_darah_suami = null;

		$pekerjaan_suami    = $_POST["pekerjaan_suami"];
		$alamat_rumah       = $_POST["alamat_rumah"];
		$id_kab             = $_POST["id_kab"];
		$id_kec             = $_POST["id_kec"];
		$telp               = $_POST["telp"];
		$username           = $_POST["username"];

		if($ps->execute())
			$respon["isOk"] = "true";
		else
			$respon["isOk"] = "false";

	// }
	
	$ps->close();
	$conn->close();
	echo json_encode($respon);
 ?>