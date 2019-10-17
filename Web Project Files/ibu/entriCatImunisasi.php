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

<div id="divEntriCatImunisasi" class="divMain">
	<form id="formEntriCatImunisasi">
		<div class="baris">
			<div class="mergeKolom">
				<label style="font-weight: bold; font-size: 150%; text-align: center;">ENTRI CATATAN IMUNISASI ANAK</label>
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>No. Keterangan Lahir</label>
			</div>
			<div class="kolom2">
				<input class="styleInput hurufBesar" type="text" name="txtNoKetLahir" id="txtNoKetLahir">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Nama Lengkap</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtNama" id="txtNama" readonly="readonly">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Vaksin</label>
			</div>
			<div class="kolom2">
				<select name="cmbVaksin" id="cmbVaksin" class="styleInput">
					<option value="0">-PILIH-</option>
					<option value="HB-0">HB-0</option>
					<option value="Polio">Polio</option>
					<option value="DPT-HB-Hib 1">DPT-HB-Hib 1</option>
					<option value="Polio 2">Polio 2</option>
					<option value="DPT-HB-Hib 2">DPT-HB-Hib 2</option>
					<option value="Polio 3">Polio 3</option>
					<option value="DPT-HB-Hib 3">DPT-HB-Hib 3</option>
					<option value="Polio 4">Polio 4</option>
					<option value="IPV">IPV</option>
					<option value="Campak">Campak</option>
					<option value="DPT-HB-Hib Lanjutan">DPT-HB-Hib Lanjutan</option>
					<option value="Campak Lanjutan">Campak Lanjutan</option>
				</select>
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Tgl Pemberian Vaksin</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtTglVaksin" id="txtTglVaksin">
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

		$("#txtTglVaksin").pickadate({
			format: 'dd-mm-yyyy',
			formatSubmit: 'yyyymmdd',
			hiddenName: true,
			today: 'Tanggal Sekarang',
			clear: 'Hapus',
			close: 'Tutup',
			selectMonths: true,
			selectYears: true,
			selectYears: 25
		});

		$("#txtNoReg").focus();

		$(document).on("focus", "input[type=text], input[type=number]", function(){
			$(this).select();
		});

		function cariData(){
			var i=0;
			$("#cmbVaksin option").show();
			$("#txtNoKetLahir").val($("#txtNoKetLahir").val().toUpperCase());
			var xmlhttp = new XMLHttpRequest();
			$("#txtNama").addClass('loading');
			xmlhttp.onreadystatechange = function() {
			    if (this.readyState == 4 && this.status == 200) {
			    	var isi = JSON.parse(xmlhttp.responseText);
			    	if (isi["vaksin"].length != 0){
			    		for (i=0; i<isi["vaksin"].length; i++){
			    			$('option[value="'+isi['vaksin'][i]+'"]').hide();
			    		}
			    	}
			    	$("#txtNama").removeClass('loading');
			    	$("#txtNama").val(isi["nama"]);
			    }
			};
			xmlhttp.open("POST", "cariNoKetLahir.php", false);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.send("txtNoKetLahir=" + $("#txtNoKetLahir").val());
		}

		function simpanData(){
			var formData = $("#formEntriCatImunisasi").serialize();

			$.ajax({
				url: 'prosesEntriCatImunisasi.php',
				type: 'POST',
				data: formData
			})
			.done(function() {
				console.log("success");
				swal({
						title: "Input Catatan Imunisasi Berhasil!",
						type: "success",
						allowOutsideClick: false,
						showConfirmButton: false,
						timer: 1000,
						heightAuto: false
					}).then(function(){
						$("#txtNoReg").focus();
					});
				$("#formEntriCatImunisasi").trigger('reset');
			});
		}

		//event key enter---------------------------------
		$("#txtNoKetLahir").bind("enterKey",function(e){
			cariData();
			//alert("wtf");
		});
		$("#txtNoKetLahir").keyup(function(e){
			if(e.keyCode == 13) {
				$(this).trigger("enterKey");
			}
		});
		//------------------------------------------------

		$(document).on("focusout", "#txtNoKetLahir", function(){
			if ($("#txtNama").val() != "" || $("#txtNoKetLahir").val() == "") return;
			cariData();
		});

		$(document).on("input", "#txtNoKetLahir", function(){
			$("#txtNama").val("");
			$("#txtNama").removeClass('loading');
		});

		$(document).on("focusin", "#txtNamaIbu", function(){
			if ($("#txtNamaIbu").val() == "")
				$("#txtHamilKe").focus();
		});

		$(document).on("submit", "#formEntriCatImunisasi", function(event){
			event.preventDefault();
		});

		$(document).on("click", "#btnSimpan", function(){
			if ($("#txtNama").val() == "" || $("#txtNoKetLahir").val() == "" || $("#cmbVaksin").val() == "0"){
				swal("Data belum lengkap!!!", null, "error");
				return;
			}
			simpanData();
		});

	});
</script>