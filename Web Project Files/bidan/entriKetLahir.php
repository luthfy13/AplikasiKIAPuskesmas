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

$bidan = array();
$hasil = $conn->query("select id_bidan, nama from tb_bidan order by nama");
while($row = $hasil->fetch_assoc()) $bidan[$row["id_bidan"]] = $row["nama"];

?>

<div id="divEntriKetLahir" class="divMain">
	<form id="formEntriKetLahir" method="post" action="prosesEntriKetLahir.php">
		<div class="baris">
			<div class="mergeKolom">
				<label style="font-weight: bold; font-size: 150%; text-align: center;">ENTRI DATA REGISTRASI BAYI</label>
				<input class="styleInput hurufBesar" type="text" name="txtIdAnak" id="txtIdAnak" style="display: none;">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>No. Registrasi Ibu</label>
			</div>
			<div class="kolom2">
				<input class="styleInput hurufBesar" type="text" name="txtNoReg" id="txtNoReg">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>No. Keterangan Lahir</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtNoKetLhr" id="txtNoKetLhr">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Tgl. Lahir</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtTglLhr" id="txtTglLhr">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Pukul</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtJam" id="txtJam">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Jenis Kelamin</label>
			</div>
			<div class="kolom2">
				<select name="cmbJK" id="cmbJK" class="styleInput">
					<option value="0">-PILIH-</option>
					<option value="Laki-laki">Laki-laki</option>
					<option value="Perempuan">Perempuan</option>
				</select>
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Jenis Kelahiran</label>
			</div>
			<div class="kolom2">
				<select name="cmbJnsKelahiran" id="cmbJnsKelahiran" class="styleInput">
					<option value="0">-PILIH-</option>
					<option value="Tunggal">Tunggal</option>
					<option value="Kembar 2">Kembar 2</option>
					<option value="Kembar 3">Kembar 3</option>
					<option value="Kembar 4">Kembar 4</option>
					<option value="Kembar 5">Kembar 5</option>
					<option value="Lainnya">Lainnya</option>
				</select>
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Kelahiran ke</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="number" name="txtKelahiranKe" id="txtKelahiranKe">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Berat Lahir (gram)</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="number" name="txtBerat" id="txtBerat">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Panjang Badan (cm)</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="number" name="txtTinggi" id="txtTinggi">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Lahir Di</label>
			</div>
			<div class="kolom2">
				<select name="cmbBersalin" id="cmbBersalin" class="styleInput">
					<option value="0">-PILIH-</option>
					<option value="Rumah Sakit">Rumah Sakit</option>
					<option value="Puskesmas">Puskesmas</option>
					<option value="Rumah Bersalin">Rumah Bersalin</option>
					<option value="Polindes">Polindes</option>
					<option value="Rumah Bidan">Rumah Bidan</option>
				</select>
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label id="lblNamaTempatPersalinan">Nama Tempat Persalinan</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtNamaTempatPersalinan" id="txtNamaTempatPersalinan">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label id="lblAlamatTempatPersalinan">Alamat Tempat Persalinan</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtAlamatTempatPersalinan" id="txtAlamatTempatPersalinan">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Nama Anak</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtNamaAnak" id="txtNamaAnak">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Nama Saksi I</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtSaksi1" id="txtSaksi1">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Nama Saksi II</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtSaksi2" id="txtSaksi2">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Nama Penolong Persalinan</label>
			</div>
			<div class="kolom2">
				<select name="cmbPenolongPersalinan" id="cmbPenolongPersalinan" class="styleInput">
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
				<label style="font-weight: bold;">Identitas IBU</label>
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Nama</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtNamaIbu" id="txtNamaIbu">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Umur (tahun)</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtUmurIbu" id="txtUmurIbu">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Pekerjaan</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtPekerjaanIbu" id="txtPekerjaanIbu">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>No. KTP</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtNIKIbu" id="txtNIKIbu">
			</div>
		</div>
		<div class="baris">
			<div class="mergeKolom">
				<label style="font-weight: bold;">Identitas AYAH</label>
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Nama</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtNamaAyah" id="txtNamaAyah">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Umur (tahun)</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtUmurAyah" id="txtUmurAyah">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Pekerjaan</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtPekerjaanAyah" id="txtPekerjaanAyah">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>No. KTP</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtNIKAyah" id="txtNIKAyah">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Alamat</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtAlamatRumah" id="txtAlamatRumah">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Kecamatan</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtKecamatan" id="txtKecamatan">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Kabupaten/Kota</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtKabupaten" id="txtKabupaten">
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

		$(document).on("change", "#cmbBersalin", function(){
			if ($("#cmbBersalin").val() != "0"){
				$("#lblNamaTempatPersalinan").html("Nama " + $("#cmbBersalin").val());
				$("#lblAlamatTempatPersalinan").html("Alamat " + $("#cmbBersalin").val());
			}
			else{
				$("#lblNamaTempatPersalinan").html("Nama Tempat Persalinan");
				$("#lblAlamatTempatPersalinan").html("Alamat Tempat Persalinan");
			}		
		});

		$("#txtTglLhr").pickadate({
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

		$("#txtJam").wickedpicker({
			title: "Waktu Kelahiran",
			twentyFour: true
		});

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
			$("#txtNamaIbu").addClass('loading');
			$("#txtPekerjaanIbu").addClass('loading');
			$("#txtNIKIbu").addClass('loading');
			$("#txtUmurIbu").addClass('loading');
			$("#txtNamaAyah").addClass('loading');
			$("#txtNIKAyah").addClass('loading');
			$("#txtUmurAyah").addClass('loading');
			$("#txtPekerjaanAyah").addClass('loading');
			$("#txtKecamatan").addClass('loading');
			$("#txtKabupaten").addClass('loading');
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
			    if (this.readyState == 4 && this.status == 200) {
			    	statsuNoReg = true;
			    	if (this.responseText == "Data Sudah Ada"){
			    		swal("Data sudah ada, masukkan nomor registrasi yang lain!!!").then(function(){
			    			$("#txtNoReg").val("");
			    			$("#txtNoReg").focus();
			    		});
			    	}
			    	else if (this.responseText == "Data Tidak Ditemukan"){
			    		swal("Nomor registrasi tidak ada pada database sistem!!!").then(function(){
			    			$("#txtNoReg").val("");
			    			$("#txtNoReg").focus();
			    		});
			    	}
			    	else{
			    		//swal(this.responseText);
			    		var isi = JSON.parse(xmlhttp.responseText);
			    		$("#txtNamaIbu").val(isi["nama"]);
						$("#txtPekerjaanIbu").val(isi["pekerjaan"]);
						$("#txtNIKIbu").val(isi["nik"]);
						$("#txtUmurIbu").val(isi["umur_ibu"]);
						$("#txtNamaAyah").val(isi["nama_suami"]);
						$("#txtNIKAyah").val(isi["nik_suami"]);
						$("#txtUmurAyah").val(isi["umur_ayah"]);
						$("#txtPekerjaanAyah").val(isi["pekerjaan_suami"]);
						$("#txtAlamatRumah").val(isi["alamat_rumah"]);
						$("#txtKecamatan").val(isi["kecamatan"]);
						$("#txtKabupaten").val(isi["kabupaten"]);
						$("#txtIdAnak").val(isi["id_anak"]);
						if (isi["jns_kelahiran"] != null){
							$("#cmbJnsKelahiran").val(isi["jns_kelahiran"]);
							$("#cmbJnsKelahiran").attr('disabled', 'disabled');
						}
						
			    	}
			    	$("#txtNamaIbu").removeClass('loading');
					$("#txtPekerjaanIbu").removeClass('loading');
					$("#txtNIKIbu").removeClass('loading');
					$("#txtUmurIbu").removeClass('loading');
					$("#txtNamaAyah").removeClass('loading');
					$("#txtNIKAyah").removeClass('loading');
					$("#txtUmurAyah").removeClass('loading');
					$("#txtPekerjaanAyah").removeClass('loading');
					$("#txtKecamatan").removeClass('loading');
					$("#txtKabupaten").removeClass('loading');
			    }
			};
			xmlhttp.open("POST", "cariNoRegDataBayi.php", false);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.send("txtNoReg=" + $("#txtNoReg").val());
		}

		function simpanData(){
			$("#cmbJnsKelahiran").removeAttr('disabled');
			var formData = $("#formEntriKetLahir").serialize();

			$.ajax({
				url: 'prosesEntriKetLahir.php',
				type: 'POST',
				data: formData
			})
			.done(function(e) {
				console.log("success");
				swal({
						title: "Registrasi Anak Berhasil!",
						type: "success",
						allowOutsideClick: false,
						showConfirmButton: false,
						timer: 1000,
						heightAuto: false
					}).then(function(){
						$("#txtNoReg").focus();
					});
				$("#formEntriKetLahir").trigger('reset');
			});
		}

		//event key enter---------------------------------
		$("#txtNoReg").bind("enterKey",function(e){
			cariData();
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

		$(document).on("submit", "#formEntriKetLahir", function(event){
			event.preventDefault();
		});

		$(document).on("click", "#btnSimpan", function(){
			if ($("#txtNamaIbu").val() == "" || $("#txtNamaIbu").val() == "Data Tidak Ditemukan"){
				swal("Masukkan Nomor Registrasi yang Benar!!!");
				return;
			}
			else if(
					$("#txtTglLhr").val() == "" ||
					 $("#cmbJnsKelahiran").val() == "0"
				){
				swal("Silakan masukkan tanggal lahir dan jenis kelahiran terlebih dahulu!");
				return;
			}
			simpanData();
		});

	});
</script>