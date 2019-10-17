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

include_once "conn.php";

$bidan = array();
$hasil = $conn->query("select id_bidan, nama from tb_bidan order by nama");
while($row = $hasil->fetch_assoc()) $bidan[$row["id_bidan"]] = $row["nama"];

?>

<div id="divEntriPersiapan" class="divMain">
	<form id="formEntriPersiapan" method="post" action="prosesEntriPersiapan.php">
		<div class="baris">
			<div class="mergeKolom">
				<label style="font-weight: bold; font-size: 150%; text-align: center;">ENTRI DATA PERSIAPAN MENYAMBUT PERSALINAN</label>
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
				<label>Alamat</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtAlamat" id="txtAlamat" readonly="readonly">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Perkiraan waktu persalinan</label>
			</div>
			<div class="kolom2">
				<select name="cmbPerkiraan" id="cmbPerkiraan" class="styleInput" style="width: 120px; margin-right: 5px;">
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
				<input class="styleInput" type="number" name="txtPerkiraan" id="txtPerkiraan" placeholder="Tahun" style="width: 120px;">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Metode KB Setelah Melahirkan</label>
			</div>
			<div class="kolom2">
				<select name="cmbMetodeKB" id="cmbMetodeKB" class="styleInput">
					<option value="0">-PILIH-</option>
					<option value="Metode Operasi Wanita">Metode Operasi Wanita</option>
					<option value="Metode Operasi Pria">Metode Operasi Pria</option>
					<option value="Spiral/AKDR">Spiral/AKDR</option>
					<option value="Implan">Implan</option>
					<option value="Suntikan">Suntikan</option>
					<option value="Pil KB">Pil KB</option>
					<option value="Kondom">Kondom</option>
				</select>
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Dana Persalinan</label>
			</div>
			<div class="kolom2">
				<select name="cmbDana" id="cmbDana" class="styleInput">
					<option value="0">-PILIH-</option>
					<option value="Disiapkan Sendiri">Disiapkan Sendiri</option>
					<option value="Ditanggung JKN">Ditanggung JKN</option>
					<option value="Dibantu Oleh">Dibantu Oleh</option>
				</select>
				<input class="styleInput" type="text" name="txtDana" id="txtDana" style="display: none;" placeholder="Masukkan Nama" value="0">
			</div>
		</div>
		<div class="baris">
			<div class="mergeKolom">
				<label style="font-weight: bold;">Penolong Persalinan:</label>
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Petugas Kesehatan I</label>
			</div>
			<div class="kolom2">
				<select name="cmbPetugas1" id="cmbPetugas1" class="styleInput">
					<option value="0">-PILIH-</option>
					<?php 
						foreach($bidan as $key => $keyVal){
							echo "<option value='".$key."'>".$keyVal."</option>";
						}
					?>
				</select>
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Petugas Kesehatan II</label>
			</div>
			<div class="kolom2">
				<select name="cmbPetugas2" id="cmbPetugas2" class="styleInput">
					<option value="0">-PILIH-</option>
					<?php 
						foreach($bidan as $key => $keyVal){
							echo "<option value='".$key."'>".$keyVal."</option>";
						}
					?>
				</select>
			</div>
		</div>
		<div class="baris">
			<div class="mergeKolom">
				<label style="font-weight: bold;">Kendaraan/ambulance desa oleh:</label>
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Kendaraan I</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtNamaAmbulan1" id="txtNamaAmbulan1" placeholder="Masukkan Nama Pemilik Kendaraan" style="width: 300px; margin-right: 5px;">
				<input class="styleInput" type="text" name="txtTelpAmbulan1" id="txtTelpAmbulan1" placeholder="Masukkan Nomor Telp/HP" style="width: 300px;">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Kendaraan II</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtNamaAmbulan2" id="txtNamaAmbulan2" placeholder="Masukkan Nama Pemilik Kendaraan" style="width: 300px; margin-right: 5px;">
				<input class="styleInput" type="text" name="txtTelpAmbulan2" id="txtTelpAmbulan2" placeholder="Masukkan Nomor Telp/HP" style="width: 300px;">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Kendaraan III</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtNamaAmbulan3" id="txtNamaAmbulan3" placeholder="Masukkan Nama Pemilik Kendaraan" style="width: 300px; margin-right: 5px;">
				<input class="styleInput" type="text" name="txtTelpAmbulan3" id="txtTelpAmbulan3" placeholder="Masukkan Nomor Telp/HP" style="width: 300px;">
			</div>
		</div>

		<div class="baris">
			<div class="mergeKolom">
				<label style="font-weight: bold;">Sumbangan darah oleh:</label>
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Pendonor I</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtNamaPendonor1" id="txtNamaPendonor1" placeholder="Masukkan Nama Pendonor" style="width: 300px; margin-right: 5px;">
				<input class="styleInput" type="text" name="txtTelpPendonor1" id="txtTelpPendonor1" placeholder="Masukkan Nomor Telp/HP" style="width: 300px;">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Pendonor II</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtNamaPendonor2" id="txtNamaPendonor2" placeholder="Masukkan Nama Pendonor" style="width: 300px; margin-right: 5px;">
				<input class="styleInput" type="text" name="txtTelpPendonor2" id="txtTelpPendonor2" placeholder="Masukkan Nomor Telp/HP" style="width: 300px;">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Pendonor III</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtNamaPendonor3" id="txtNamaPendonor3" placeholder="Masukkan Nama Pendonor" style="width: 300px; margin-right: 5px;">
				<input class="styleInput" type="text" name="txtTelpPendonor3" id="txtTelpPendonor3" placeholder="Masukkan Nomor Telp/HP" style="width: 300px;">
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

		$(document).on("change", "#cmbDana", function(){
			$("#txtDana").val($(this).val());
			if ($(this).val() == "Dibantu Oleh"){
				$(this).css({
					"width": '300px',
					"margin-right": '5px'
				});
				$("#txtDana").css({
					"display": 'inline',
					"width": '300px'
				});
				$("#txtDana").val("");
				$("#txtDana").focus();
			}
			else{
				$(this).css({
					"width": '100%',
					"margin-right": 'initial'
				});
				$("#txtDana").css({
					"display": 'none',
					"width": '100%'
				});
			}
		});

		function cariData(){
			statsuNoReg = false;
			if($("#txtNoReg").val() == "") return;
			$("#txtNoReg").val($("#txtNoReg").val().toUpperCase());
			var xmlhttp = new XMLHttpRequest();
			$("#txtNamaIbu").addClass('loading');
			$("#txtAlamat").addClass('loading');
			xmlhttp.onreadystatechange = function() {
			    if (this.readyState == 4 && this.status == 200) {
			    	statsuNoReg = true;
			    	if (this.responseText == "Data Sudah Ada"){
			    		swal("Data sudah ada, masukkan nomor registrasi yang lain!!!").then(function(){
			    			$("#txtNoReg").val("");
			    			$("#txtNamaIbu").val("");
			    			$("#cmbPerkiraan").focus();
			    		});
			    	}
			    	else if (this.responseText == "Data Tidak Ditemukan"){
			    		swal("Nomor registrasi tidak ada pada database sistem!!!").then(function(){
			    			$("#txtNoReg").val("");
			    			$("#txtNamaIbu").val("");
			    			$("#cmbPerkiraan").focus();
			    		});
			    	}
			    	else{
			    		var isi = JSON.parse(xmlhttp.responseText);
			    		$("#txtNamaIbu").val(isi[0]);
			    		if (isi[1] == null) $("#txtAlamat").val("");
			    		$("#txtAlamat").val(isi[1]);
			    		$("#cmbPerkiraan").focus();
			    	}
			    	$("#txtNamaIbu").removeClass('loading');
			    	$("#txtAlamat").removeClass('loading');
			    }
			};
			xmlhttp.open("POST", "cariNoRegPersiapan.php", false);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.send("txtNoReg=" + $("#txtNoReg").val());
		}

		function simpanData(){
			var formData = $("#formEntriPersiapan").serialize();

			$.ajax({
				url: 'prosesEntriPersiapan.php',
				type: 'POST',
				data: formData
			})
			.done(function() {
				console.log("success");
				swal({
						title: "Input Data Berhasil!",
						type: "success",
						allowOutsideClick: false,
						showConfirmButton: false,
						timer: 1000,
						heightAuto: false
					}).then(function(){
						$("#txtNoReg").focus();
					});
				$("#formEntriPersiapan").trigger('reset');
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

		$(document).on("focusin", "#txtNamaIbu, #txtAlamat", function(){
			if ($(this).val() == "")
				$("#cmbPerkiraan").focus();
		});

		$(document).on("submit", "#formEntriCatKesehatanIbuHamil", function(event){
			event.preventDefault();
		});

		$(document).on("click", "#btnSimpan", function(){
			if ($("#txtNamaIbu").val() == "" || $("#txtNamaIbu").val() == "Data Tidak Ditemukan"){
				swal("Masukkan Nomor Registrasi yang Benar!!!");
				return;
			}
			else if(
					$("#cmbPerkiraan").val() == "0" ||
					($("#cmbPetugas1").val() == "0" && $("#cmbPetugas2").val() == "0")
				){
				swal("Data Belum Lengkap!!!");
				return;
			}
			else if(
					($("#txtNamaAmbulan1").val() != "" && $("#txtTelpAmbulan1").val() == "") ||
					($("#txtNamaAmbulan1").val() == "" && $("#txtTelpAmbulan1").val() != "") ||
					($("#txtNamaAmbulan2").val() != "" && $("#txtTelpAmbulan2").val() == "") ||
					($("#txtNamaAmbulan2").val() == "" && $("#txtTelpAmbulan2").val() != "") ||
					($("#txtNamaAmbulan3").val() != "" && $("#txtTelpAmbulan3").val() == "") ||
					($("#txtNamaAmbulan3").val() == "" && $("#txtTelpAmbulan3").val() != "")
				){
				swal("Data Belum Lengkap!!!");
				return;
			}
			else if(
					($("#txtNamaPendonor1").val() != "" && $("#txtTelpPendonor1").val() == "") ||
					($("#txtNamaPendonor1").val() == "" && $("#txtTelpPendonor1").val() != "") ||
					($("#txtNamaPendonor2").val() != "" && $("#txtTelpPendonor2").val() == "") ||
					($("#txtNamaPendonor2").val() == "" && $("#txtTelpPendonor2").val() != "") ||
					($("#txtNamaPendonor3").val() != "" && $("#txtTelpPendonor3").val() == "") ||
					($("#txtNamaPendonor3").val() == "" && $("#txtTelpPendonor3").val() != "")
				){
				swal("Data Belum Lengkap!!!");
				return;
			}
			simpanData();
		});

	});
</script>