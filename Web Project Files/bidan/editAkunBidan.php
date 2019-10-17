<?php

if (session_status() == PHP_SESSION_NONE)
	session_start();


if (isset($_SESSION["loginStat"])){
	if ($_SESSION["loginStat"] != "bidan lagi login"){
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

$sql = "select * from tb_bidan where username = ?";
$ps = $conn->stmt_init();
$ps->prepare($sql);
$ps->bind_param("s", $p1);
$p1 = $_SESSION["userLogin"];
$ps->execute();
$hasil = $ps->get_result();
if ($hasil->num_rows > 0){
	$rowHasil = $hasil->fetch_assoc();
}
else{
	echo "<script> location.replace('index.php'); </script>";
	exit();
}



?>

<div id="divEditAkunBidan" class="divMain">
	<form id="formEditAkunBidan">
		<div class="baris">
			<div class="mergeKolom">
				<label style="font-weight: bold; font-size: 150%; text-align: center;">EDIT AKUN BIDAN/DOKTER</label>
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>No. KTP / NIK</label>
			</div>
			<div class="kolom2">
				<input class="styleInput hurufBesar" type="text" name="txtId" id="txtId" value="<?php echo $rowHasil["id_bidan"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Nama Lengkap</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtNama" id="txtNama" value="<?php echo $rowHasil["nama"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Alamat</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtAlamat" id="txtAlamat" value="<?php echo $rowHasil["alamat"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>No. Telepon</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtTelp" id="txtTelp" value="<?php echo $rowHasil["telp"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Username</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtUser" id="txtUser" value="<?php echo $rowHasil["username"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Password</label>
			</div>
			<div class="kolom2" style="color: black;">
				<input class="styleInput" type="password" name="txtPwd" id="txtPwd" style="width: 300px;" title="Kosongkan jika password tidak ingin diubah">
				<input type="checkbox" name="chkPwd" id="chkPwd">Perlihatkan Password
			</div>
		</div>
		
		<div class="baris">
			<div class="kolom1" style="width: 30%">
				<input type="button" class="styleButton" value="Reload Data" id="btnReload">
			</div>
			<div class="kolom2" style="width: 30%">
				<input type="button" class="styleButton" value="Tutup" id="btnTutup">
			</div>
			<div class="kolom2" style="width: 40%">
				<input type="button" class="styleButton" value="Simpan Data" id="btnSimpan">
			</div>
		</div>
	</div>
</form>
<div style="height: 40px;"></div>

<script type="text/javascript">
	$(document).ready(function() {

		$(document).on("click").unbind();


		$(document).on("focus", "input[type=text], input[type=number]", function(){
			$(this).select();
		});

		function simpanData(){
			var formData = $("#formEditAkunBidan").serialize();

			$.ajax({
				url: 'prosesEditAkunBidan.php',
				type: 'POST',
				data: formData
			})
			.done(function() {
				console.log("success");
				swal({
						title: "Data Akun Berhasil Diperbaharui!",
						type: "success",
						allowOutsideClick: false,
						showConfirmButton: false,
						timer: 1000,
						heightAuto: false
					});
			});
		}

		function cekUsername(uname){
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
			    if (this.readyState == 4 && this.status == 200) {
			    	if (this.responseText == "ada"){
			    		$("#txtUser").val("<?php echo $_SESSION["userLogin"]; ?>");
			    		swal({
							title: "Username telah digunakan, masukkan username yang lain!",
							type: "error",
							allowOutsideClick: false,
							showConfirmButton: true,
							heightAuto: false
						}).then(function(){
							$("#txtUser").focus();
						});
			    	}
			    }
			};
			xmlhttp.open("POST", "cekUsername.php", false);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.send("txtUsername=" + uname);
		}

		function cekNoKTP(noKTP){
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
			    if (this.readyState == 4 && this.status == 200) {
			    	if (this.responseText == "ada"){
			    		$("#txtId").val("");
			    		swal({
							title: "NIK sudah terdaftar!",
							type: "error",
							allowOutsideClick: false,
							showConfirmButton: true,
							heightAuto: false
						}).then(function(){
							$("#txtId").focus();
						});
			    	}
			    }
			};
			xmlhttp.open("POST", "cekKTPBidan.php", false);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.send("idBidan=" + noKTP);
		}

		$(document).on("focusout", "#txtUser", function(){
			if ($(this).val() == "" || $(this).val() == "<?php echo $_SESSION["userLogin"]; ?>") return;
			cekUsername($(this).val());
		});

		$(document).on("focusout", "#txtId", function(){
			if ($(this).val() == "" || $(this).val() == "<?php echo $rowHasil["id_bidan"]; ?>") return;
			cekNoKTP($(this).val());
		});

		$(document).on("submit", "#formEditAkunBidan", function(event){
			event.preventDefault();
		});

		$(document).on("click", "#btnSimpan", function(){
			if ($("#txtId").val() == "" || $("#txtUser").val() == ""){
				swal("Data belum lengkap!!!", null, "error");
				return;
			}
			simpanData();
		});

		$(document).on("focusin", "#cmbJnsKelahiran", function(){
			$("#txtKelahiranKe").focus();
		});

		$(document).on("click", "#chkPwd", function(){
			if ($("#txtPwd").attr('type') == "password"){
				$("#txtPwd").attr('type', 'text');
			}
			else{
				$("#txtPwd").attr('type', 'password');
			}
		});

		$(document).on("click", "#btnReload", function(){
			var nmr = "<?php echo $_SESSION["userLogin"]; ?>";
			$(".content").empty();
			$(".content").addClass('loadingHalaman');
			$(".content").load("editAkunBidan.php", {noReg: nmr}, function(){
				$(".content").removeClass('loadingHalaman');
			});
		});

		$(document).on("click", "#btnTutup", function(){
			$(".content").empty();
			$(".content").addClass('loadingHalaman');
			$(".content").load("dataBidan.php", function(){
				$(".content").removeClass('loadingHalaman');
			});
		});

	});
</script>