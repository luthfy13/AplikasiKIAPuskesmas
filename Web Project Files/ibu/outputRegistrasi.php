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

?>

<!DOCTYPE html>
<html>
<head>
	<title>Login Aplikasi Kesehatan Ibu dan Anak</title>
	<link rel="shortcut icon" href="img/icon.png">
	<link rel="stylesheet" type="text/css" href="css/main.css" />
	<script src="js/jquery-3.3.1.js"></script>
	<style type="text/css">
		body, html {
			height: 100%;
			margin: 0;
		}
		
		.divTengah{
			box-sizing: border-box;
			width:600px;
			height: 240px;
			overflow: hidden;
			margin: auto;
			position: absolute;
			left: 0; right: 0;
			top: 0; bottom: 0;
			border: 1px solid black;
			border-radius: 10px;
			padding: 20px;
		}

		*{
			font-family: Arial;
		}

	</style>
</head>
<body>
	<div class="divTengah">
		<label id="txtNoReg" style="display: block; width: 100%; text-align: center;margin-bottom: 15px; font-size: 32px; font-weight: bold; color:black;">
			No. Registrasi: 
		</label>
		<label id="txtUsername" style="display: block; width: 100%; text-align: center;margin-bottom: 15px; font-size: 32px; font-weight: bold; color:black;">
			USERNAME: 
		</label>
		<label style="display: block; width: 100%; text-align: center;margin-bottom: 15px; font-size: 32px; font-weight: bold; color:black;">
			PASSWORD: aplikasiKIA
		</label>
	</div>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#txtNoReg").html("NO. REGISTRASI: " + '<?php echo $_GET["noReg"]; ?>');
			$("#txtUsername").html("USERNAME: " + '<?php echo $_GET["username"]; ?>');
		});
	</script>
</body>
</html>