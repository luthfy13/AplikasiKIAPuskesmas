<?php
if (session_status() == PHP_SESSION_NONE)
	session_start();

if (isset($_SESSION["loginStat"])){
	if ($_SESSION["loginStat"] == "bidan lagi login"){
		ob_start();
		header('Location: bidan/index.php');
		ob_end_flush();
		die();
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login Aplikasi Kesehatan Ibu dan Anak</title>
	<link rel="shortcut icon" href="img/icon.png">
	<link rel="stylesheet" type="text/css" href="css/main.css" />
	<script src="js/jquery-3.3.1.js"></script>
	<script src="scripts/sweetalert2/dist/sweetalert2.js"></script>
	<link rel="stylesheet" href="scripts/sweetalert2/dist/sweetalert2.css">
	<style type="text/css">
		body, html {
			height: 100%;
			margin: 0;
			background-color: #ff00d8;
			background: linear-gradient(to bottom right, #ff00d8, lightgray);
		}
		
		.divTengah{
			box-sizing: border-box;
			width: 60%;
			height: 85%;
			min-width: 800px;
			min-height: 600px;
			overflow: hidden;
			margin: auto;
			position: absolute;
			left: 0; right: 0;
			top: 0; bottom: 0;
			box-shadow: 3px 3px 4px gray;
		}

		.divKanan, .divKiri{
			box-sizing: border-box;
			width: 50%;
			height:100%;
			float: left;
		}

		.divKanan{
			background-color: white;
			position: relative;
		}

		.divKiri{
			background-image: url("img/front.jpg");
			background-attachment: all;
			background-position: center;
			background-repeat: no-repeat;
			background-size: cover;
		}

		.divLogin{
			width: 95%;
			height: 185px;
			margin: auto;
			position: absolute;
			left: 0; right: 0;
			top: 0; bottom: 0;
			border-radius: 10px;
		}

		*{
			font-family: Arial;
		}

		.divLogin input{
			box-shadow: initial!important;
			text-align: center;
		}

	</style>
</head>
<body>
	<div class="divTengah">
		<div class="divKiri"></div>
		<div class="divKanan">
			<div class="divLogin">
				<label style="display: block; width: 100%; text-align: center;margin-bottom: 15px; font-size: large; font-weight: bold; color:#ff00d8;">
					LOGIN PETUGAS KESEHATAN / IBU HAMIL
				</label>
				<form id="formLogin">
					<input type="text" id="txtUser" name="txtUser" autocomplete="off"  class="styleInput" placeholder="Username" style="margin-bottom: 15px;">
					<input type="password" name="txtPwd" id="txtPwd" class="styleInput" placeholder="Password" style="margin-bottom: 15px;">
					<button id="btnLogin" type="submit" class="styleButton">
						LOGIN
					</button>
				</form>
			</div>
		</div>
	</div>
	<script type="text/javascript">
	$(document).ready(function() {
		$("#txtUser").focus();

		function login(){
			if ($("#txtUser").val() == "") return;
			else if ($("#txtPwd").val() == "") return;
			var isi = $("#btnLogin").html();
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
			    if (this.readyState == 4 && this.status == 200) {
			        if (this.responseText == "suksesbidan"){
			        	swal({
							title: "Login berhasil!",
							type: "success",
							allowOutsideClick: false,
							showConfirmButton: false,
							timer: 1000,
							heightAuto: false
						}).then(function(){
							location.href = "./bidan/index.php";
						});
				    }
				    else if (this.responseText == "suksesibu"){
			        	swal({
							title: "Login berhasil!",
							type: "success",
							allowOutsideClick: false,
							showConfirmButton: false,
							timer: 1000,
							heightAuto: false
						}).then(function(){
							location.href = "./ibu/index.php";
						});
				    }
				    else{
				    	swal({
							title: "Login gagal!",
							text: "Username atau Password salah!",
							type: "error",
							allowOutsideClick: false,
							heightAuto: false
						}).then(function(){
							setTimeout(function() {
								$("#txtUser").val("");
								$("#txtPwd").val("");
								$("#txtUser").focus();
							}, 500);
						});
				    }
			    }
			};
			xmlhttp.open("POST", "prosesLogin.php", true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.send("txtUser=" + $("#txtUser").val() + "&txtPwd=" + $("#txtPwd").val());
		}

		$(document).on("click", "#btnLogin", function(e){
			e.preventDefault();
			login();
		});

		
	});
	</script>
</body>
</html>