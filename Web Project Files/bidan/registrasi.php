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

?>

<div id="divRegistrasi" class="divMain">
	<div class="baris">
		<div class="kolom1">
			<label>No KTP</label>
		</div>
		<div class="kolom2">
			<input class="styleInput" type="text" name="txtNoKTP" id="txtNoKTP">
		</div>
	</div>
	<div class="baris">
		<div class="kolom1">
			<label>Nama Lengkap</label>
		</div>
		<div class="kolom2">
			<input class="styleInput" type="text" name="txtNamaIbu" id="txtNamaIbu">
		</div>
	</div>
	<div class="baris">
		<div class="kolom1">
			<label>Username</label>
		</div>
		<div class="kolom2">
			<input class="styleInput" type="text" name="txtUsername" id="txtUsername">
		</div>
	</div>
	<div class="baris">
		<div class="mergeKolom">
			<input type="button" name="btnCreate" id="btnCreate" class="styleButton" value="Buat Akun">
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {

		$(document).on("click").unbind();

		function simpan(){
			if ($("#txtNoKTP").val() == "") return;
			else if ($("#txtNamaIbu").val() == "") return;
			else if ($("#txtUsername").val() == "") return;
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
			    if (this.readyState == 4 && this.status == 200) {
			    	var kode = this.responseText;
			        swal({
						title: "Registrasi Berhasil!",
						type: "success",
						allowOutsideClick: false,
						showConfirmButton: false,
						timer: 1000,
						heightAuto: false
					}).then(function(){
						window.open("outputRegistrasi.php?username=" + $("#txtUsername").val() + "&noReg=" + kode,'_blank');
					});
			    }
			};
			xmlhttp.open("POST", "prosesRegistrasi.php", false);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.send("txtNoKTP=" + $("#txtNoKTP").val() + "&txtNamaIbu=" + $("#txtNamaIbu").val() + "&txtUsername=" + $("#txtUsername").val());
		}

		function cekUsername(uname){
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
			    if (this.readyState == 4 && this.status == 200) {
			    	if (this.responseText == "ada"){
			    		$("#txtUsername").val("");
			    		swal({
							title: "Username telah digunakan, masukkan username yang lain!",
							type: "error",
							allowOutsideClick: false,
							showConfirmButton: true,
							heightAuto: false
						}).then(function(){
							$("#txtUsername").focus();
						});
			    	}
			    }
			};
			xmlhttp.open("POST", "cekUsername.php", false);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.send("txtUsername=" + uname);
		}

		$(document).on("focusout", "#txtUsername", function(){
			if ($(this).val() == "") return;
			cekUsername($(this).val());
		});


		$(document).on("click", "#btnCreate", function(){
			simpan();
		});
	});
</script>