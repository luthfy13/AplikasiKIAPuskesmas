<?php
	if (session_status() == PHP_SESSION_NONE)
		session_start();
	
	function login() {
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
		$_SESSION["usernyaTawwa"] = $user;
		
		if ($hasil->num_rows > 0){
			$_SESSION["loginStat"] = "login berhasil";
			$row = $hasil->fetch_assoc();
			$_SESSION["userLogin"] = $row["username"];
			$level = $row["jenis"];
			if($level == "Bidan"){
				$_SESSION["loginStat"] = "bidan lagi login";
				echo "suksesbidan";
			}
			else if($level == "Ibu"){
				$_SESSION["loginStat"] = "ibu lagi login";

				echo "suksesibu";
			}
			
		}
		else{
			$ps->close();
			$conn->close();
			$_SESSION["loginStat"] = "login gagal";
			echo "gagal";
		}
	}

	login();
 ?>