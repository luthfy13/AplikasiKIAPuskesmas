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

<div id="divEntriAkunBidan" class="divMain">
	<form id="formEntriAkunBidan">
		<div class="baris">
			<div class="mergeKolom">
				<label style="font-weight: bold; font-size: 150%; text-align: center;">TAMBAH AKUN BIDAN/DOKTER</label>
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>No. KTP / NIK</label>
			</div>
			<div class="kolom2">
				<input class="styleInput hurufBesar" type="text" name="txtId" id="txtId">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Nama Lengkap</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtNama" id="txtNama">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Alamat</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtAlamat" id="txtAlamat">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>No. Telepon</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtTelp" id="txtTelp">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Username</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtUser" id="txtUser">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Password</label>
			</div>
			<div class="kolom2" style="color: black;">
				<input class="styleInput" type="password" name="txtPwd" id="txtPwd" style="width: 300px;">
				<input type="checkbox" name="chkPwd" id="chkPwd">Perlihatkan Password
			</div>
		</div>
		
		<div class="baris">
			<div class="mergeKolom">
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
			var formData = $("#formEntriAkunBidan").serialize();

			$.ajax({
				url: 'prosesTambahBidan.php',
				type: 'POST',
				data: formData
			})
			.done(function() {
				console.log("success");
				swal({
						title: "Akun baru berhasil ditambahkan!",
						type: "success",
						allowOutsideClick: false,
						showConfirmButton: false,
						timer: 1000,
						heightAuto: false
					});
				$("#formEntriAkunBidan").trigger('reset');
			});
		}

		function cekUsername(uname){
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
			    if (this.readyState == 4 && this.status == 200) {
			    	if (this.responseText == "ada"){
			    		$("#txtUser").val("");
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
			if ($(this).val() == "") return;
			cekUsername($(this).val());
		});

		$(document).on("focusout", "#txtId", function(){
			if ($(this).val() == "") return;
			cekNoKTP($(this).val());
		});

		$(document).on("submit", "#formEntriAkunBidan", function(event){
			event.preventDefault();
		});

		$(document).on("click", "#btnSimpan", function(){
			if ($("#txtId").val() == "" || $("#txtUser").val() == "" || $("#txtPwd").val() == ""){
				swal("Data belum lengkap!!!", null,"error");
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
			var nmr = $("#txtIdAnak").val();
			$(".content").empty();
			$(".content").addClass('loadingHalaman');
			$(".content").load("editKetLahir.php", {noReg: nmr}, function(){
				$(".content").removeClass('loadingHalaman');
			});
		});

		$(document).on("click", "#btnTutup", function(){
			$(".content").empty();
			$(".content").addClass('loadingHalaman');
			$(".content").load("dataBayi.php", function(){
				$(".content").removeClass('loadingHalaman');
			});
		});

	});
</script>