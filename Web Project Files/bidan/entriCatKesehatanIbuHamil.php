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

<div id="divEntriCatKesehatanIbuHamil" class="divMain">
	<form id="formEntriCatKesehatanIbuHamil" method="post" action="prosesEntriCatIbuHamil.php">
		<div class="baris">
			<div class="mergeKolom">
				<label style="font-weight: bold; font-size: 150%; text-align: center;">ENTRI CATATAN KESEHATAN IBU HAMIL</label>
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>No. Registrasi</label>
			</div>
			<div class="kolom2">
				<input class="styleInput hurufBesar" type="text" name="txtNoReg" id="txtNoReg">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Nama Lengkap</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtNamaIbu" id="txtNamaIbu" readonly="readonly">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Hamil ke-</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="number" name="txtHamilKe" id="txtHamilKe" value="0">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Jumlah Persalinan</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="number" name="txtJmlPersalinan" id="txtJmlPersalinan" value="0">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Jumlah Keguguran</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="number" name="txtJmlKeguguran" id="txtJmlKeguguran" value="0">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Jumlah Gravida</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="number" name="txtJmlGravida" id="txtJmlGravida" value="0">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Jumlah Paritas</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="number" name="txtJmlParitas" id="txtJmlParitas" value="0">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Jumlah Abortus</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="number" name="txtJmlAbortus" id="txtJmlAbortus" value="0">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Jumlah Anak Hidup</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="number" name="txtJmlAnakHidup" id="txtJmlAnakHidup" value="0">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Jumlah Lahir Mati</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="number" name="txtJmlLahirMati" id="txtJmlLahirMati" value="0">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Jumlah Anak Lahir Kurang Bulan</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="number" name="txtJmlAnakLhrKrgBln" id="txtJmlAnakLhrKrgBln" value="0">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Jarak Kehamilan Ini dengan Persalinan Terakhir</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtJarakKehamilan" id="txtJarakKehamilan">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Status Imunisasi TT Terakhir</label>
			</div>
			<div class="kolom2" style="box-sizing: border-box;">
				<select name="cmbStatusTT" id="cmbStatusTT" class="styleInput" style="width: 120px; margin-right: 5px;">
					<option value="0">-BULAN-</option>
					<option value="Januari">Januari</option>
					<option value="Februari">Februari</option>
					<option value="Maret">Maret</option>
					<option value="April">April</option>
					<option value="Mei">Mei</option>
					<option value="Juni">Juni</option>
					<option value="Juli">Juli</option>
					<option value="Agustus">Agustus</option>
					<option value="September">September</option>
					<option value="Oktober">Oktober</option>
					<option value="November">November</option>
					<option value="Desember">Desember</option>
				</select>
				<input class="styleInput" type="number" name="txtStatusTT" id="txtStatusTT" placeholder="Tahun" style="width: 120px;">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Penolong Persalinan Terakhir</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtPnlgPersalinan" id="txtPnlgPersalinan">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Cara Persalinan Terakhir</label>
			</div>
			<div class="kolom2">
				<select name="cmbCaraPersalinan" id="cmbCaraPersalinan" class="styleInput">
					<option value="0">-PILIH-</option>
					<option value="Spontan/Normal">Spontan/Normal</option>
					<option value="Tindakan">Tindakan</option>
				</select>
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

		var statsuNoReg=false;

		$(document).on("click").unbind();

		$("#txtNoReg").focus();

		$(document).on("focus", "input[type=text], input[type=number]", function(){
			$(this).select();
		});

		$(document).on("keydown", "input[type=number]", function(e){
			// Allow: backspace, delete, tab, escape, enter and .
			if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
				// Allow: Ctrl/cmd+A
				(e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
				// Allow: Ctrl/cmd+C
				(e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
				// Allow: Ctrl/cmd+X
				(e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
				// Allow: home, end, left, right
				(e.keyCode >= 35 && e.keyCode <= 39)) {
				// let it happen, don't do anything
				return;
			}
			// Ensure that it is a number and stop the keypress
			if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
				e.preventDefault();
			}
		});

		function cariData(){
			statsuNoReg = false;
			if($("#txtNoReg").val() == "") return;
			$("#txtNoReg").val($("#txtNoReg").val().toUpperCase());
			var xmlhttp = new XMLHttpRequest();
			$("#txtNamaIbu").addClass('loading');
			xmlhttp.onreadystatechange = function() {
			    if (this.readyState == 4 && this.status == 200) {
			    	statsuNoReg = true;
			    	if (this.responseText == "Data Sudah Ada"){
			    		swal("Data sudah ada, masukkan nomor registrasi yang lain!!!").then(function(){
			    			$("#txtNoReg").val("");
			    			$("#txtNamaIbu").val("");
			    			$("#txtNoReg").focus();
			    		});
			    	}
			    	else if (this.responseText == "Data Tidak Ditemukan"){
			    		swal("Nomor registrasi tidak ada pada database sistem!!!").then(function(){
			    			$("#txtNoReg").val("");
			    			$("#txtNamaIbu").val("");
			    			$("#txtNoReg").focus();
			    		});
			    	}
			    	else{
			    		$("#txtNamaIbu").val(this.responseText);
			    		$("#txtHamilKe").focus();
			    	}
			    	$("#txtNamaIbu").removeClass('loading');
			    }
			};
			xmlhttp.open("POST", "cariNoReg.php", false);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.send("txtNoReg=" + $("#txtNoReg").val());
		}

		function simpanData(){
			var formData = $("#formEntriCatKesehatanIbuHamil").serialize();

			$.ajax({
				url: 'prosesEntriCatIbuHamil.php',
				type: 'POST',
				data: formData
			})
			.done(function() {
				console.log("success");
				swal({
						title: "Input Catatan Kesehatan Berhasil!",
						type: "success",
						allowOutsideClick: false,
						showConfirmButton: false,
						timer: 1000,
						heightAuto: false
					}).then(function(){
						$("#txtNoReg").focus();
					});
				$("#formEntriCatKesehatanIbuHamil").trigger('reset');
			});
		}

		//event key enter---------------------------------
		$("#txtNoReg").bind("enterKey",function(e){
			cariData();
			//alert("wtf");
		});
		$("#txtNoReg").keyup(function(e){
			if(e.keyCode == 13) {
				$(this).trigger("enterKey");
			}
		});
		//------------------------------------------------

		$(document).on("focusout", "#txtNoReg", function(){
			if ($("#txtNamaIbu").val() != "" || $("#txtNoReg").val() == "" || statsuNoReg == true) return;
			cariData();
		});

		$(document).on("input", "#txtNoReg", function(){
			statsuNoReg = false;
			$("#txtNamaIbu").val("");
			$("#txtNamaIbu").removeClass('loading');
		});

		$(document).on("focusin", "#txtNamaIbu", function(){
			if ($("#txtNamaIbu").val() == "")
				$("#txtHamilKe").focus();
		});

		$(document).on("submit", "#formEntriCatKesehatanIbuHamil", function(event){
			event.preventDefault();
		});

		$(document).on("click", "#btnSimpan", function(){
			if ($("#txtNamaIbu").val() == "" || $("#txtNamaIbu").val() == "Data Tidak Ditemukan"){
				swal("Masukkan Nomor Registrasi yang Benar!!!");
				return;
			}
			simpanData();
		});

	});
</script>