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

$jk = array("Laki-laki","Perempuan");
$jnsLahir = array("Tunggal","Kembar 2","Kembar 3","Kembar 4","Kembar 5","Lainnya");
$tempatLahir = array("Rumah Sakit","Puskesmas","Rumah Bersalin","Polindes","Rumah Bidan");

$sql = "
		SELECT
		tb_reg_ibu.no_reg,
		tb_reg_ibu.nama,
		tb_reg_ibu.pekerjaan,
		tb_reg_ibu.nik,
		tb_reg_ibu.nama_suami,
		tb_reg_ibu.nik_suami,
		tb_reg_ibu.pekerjaan_suami,
		tb_reg_ibu.alamat_rumah,
		tb_kecamatan.`name` AS kecamatan,
		tb_kabupaten.`name` AS kabupaten,
		tb_reg_anak.no_ket_lahir,
		tb_reg_anak.jk,
		tb_reg_anak.tgl_lahir,
		TIME_FORMAT(tb_reg_anak.waktu_lahir, '%H:%i') as waktu_lahir,
		tb_reg_anak.jns_kelahiran,
		tb_reg_anak.kelahiran_ke,
		tb_reg_anak.berat_lahir,
		tb_reg_anak.panjang_badan,
		tb_reg_anak.tempat_lahir,
		tb_reg_anak.nama_tempat_lahir,
		tb_reg_anak.alamat_tempat_lahir,
		tb_reg_anak.nama as nama_anak,
		tb_reg_anak.nama_saksi1,
		tb_reg_anak.nama_saksi2,
		tb_reg_anak.id_penolong_persalinan,
		tb_reg_anak.umur_ibu,
		tb_reg_anak.umur_ayah
		FROM
		tb_reg_ibu
		LEFT JOIN tb_kecamatan ON tb_reg_ibu.id_kec = tb_kecamatan.id
		LEFT JOIN tb_kabupaten ON tb_reg_ibu.id_kab = tb_kabupaten.id
		INNER JOIN tb_reg_anak ON tb_reg_anak.no_reg_ibu = tb_reg_ibu.no_reg
		WHERE tb_reg_anak.id_anak = ? or tb_reg_anak.no_ket_lahir = ?
	";
$ps = $conn->stmt_init();
$ps->prepare($sql);
$ps->bind_param("ss", $p1, $p2);
$p1 = $_POST["noReg"];
$p2 = $_POST["noReg"];
$ps->execute();
$hasil = $ps->get_result();
if ($hasil->num_rows > 0){
	$rowHasil = $hasil->fetch_assoc();
}
else{
	echo"
		<script>
			swal('Data tidak ditemukan!!!', null, 'error').then(function(){
				$('.content').empty();
				$('.content').addClass('loadingHalaman');
				$('.content').load('dataBayi.php', function(){
					$('.content').removeClass('loadingHalaman');
				});
			});
		</script>
	";
	exit();
}



?>

<div id="divEntriKetLahir" class="divMain">
	<form id="formEditKetLahir" method="post" action="prosesEntriCatIbuHamil.php">
		<div class="baris">
			<div class="mergeKolom">
				<label style="font-weight: bold; font-size: 150%; text-align: center;">ENTRI DATA REGISTRASI BAYI</label>
				<input class="styleInput hurufBesar" type="text" name="txtIdAnak" id="txtIdAnak" style="display: none;" value="<?php echo $_POST["noReg"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>No. Registrasi Ibu</label>
			</div>
			<div class="kolom2">
				<input class="styleInput hurufBesar" type="text" name="txtNoReg" id="txtNoReg" readonly="readonly" value="<?php echo $rowHasil["no_reg"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>No. Keterangan Lahir</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtNoKetLhr" id="txtNoKetLhr" value="<?php echo $rowHasil["no_ket_lahir"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Tgl. Lahir</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtTglLhr" id="txtTglLhr" value="<?php echo $rowHasil["tgl_lahir"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Pukul</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtJam" id="txtJam" value="<?php echo $rowHasil["waktu_lahir"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Jenis Kelamin</label>
			</div>
			<div class="kolom2">
				<select name="cmbJK" id="cmbJK" class="styleInput">
					<option value="0">-PILIH-</option>
					<?php 
						foreach($jk as $val){
							if ($val == $rowHasil["jk"])
								echo "<option value='".$val."' selected='selected'>".$val."</option>";
							else
								echo "<option value='".$val."'>".$val."</option>";
						}
					?>
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
					<?php 
						foreach($jnsLahir as $val){
							if ($val == $rowHasil["jns_kelahiran"])
								echo "<option value='".$val."' selected='selected'>".$val."</option>";
							else
								echo "<option value='".$val."'>".$val."</option>";
						}
					?>
				</select>
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Kelahiran ke</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="number" name="txtKelahiranKe" id="txtKelahiranKe" value="<?php echo $rowHasil["kelahiran_ke"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Berat Lahir (gram)</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="number" name="txtBerat" id="txtBerat" value="<?php echo $rowHasil["berat_lahir"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Panjang Badan (cm)</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="number" name="txtTinggi" id="txtTinggi" value="<?php echo $rowHasil["panjang_badan"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Lahir Di</label>
			</div>
			<div class="kolom2">
				<select name="cmbBersalin" id="cmbBersalin" class="styleInput">
					<option value="0">-PILIH-</option>
					<?php 
						foreach($tempatLahir as $val){
							if ($val == $rowHasil["tempat_lahir"])
								echo "<option value='".$val."' selected='selected'>".$val."</option>";
							else
								echo "<option value='".$val."'>".$val."</option>";
						}
					?>
				</select>
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label id="lblNamaTempatPersalinan">Nama Tempat Persalinan</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtNamaTempatPersalinan" id="txtNamaTempatPersalinan" value="<?php echo $rowHasil["nama_tempat_lahir"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label id="lblAlamatTempatPersalinan">Alamat Tempat Persalinan</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtAlamatTempatPersalinan" id="txtAlamatTempatPersalinan" value="<?php echo $rowHasil["alamat_tempat_lahir"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Nama Anak</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtNamaAnak" id="txtNamaAnak" value="<?php echo $rowHasil["nama_anak"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Nama Saksi I</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtSaksi1" id="txtSaksi1" value="<?php echo $rowHasil["nama_saksi1"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Nama Saksi II</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtSaksi2" id="txtSaksi2" value="<?php echo $rowHasil["nama_saksi2"];?>">
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
							if ($key == $rowHasil["id_penolong_persalinan"])
								echo "<option value='".$key."' selected='selected'>".$keyVal."</option>";
							else
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
				<input class="styleInput" type="text" name="txtNamaIbu" id="txtNamaIbu" readonly="readonly" value="<?php echo $rowHasil["nama"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Umur (tahun)</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtUmurIbu" id="txtUmurIbu" value="<?php echo $rowHasil["umur_ibu"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Pekerjaan</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtPekerjaanIbu" id="txtPekerjaanIbu" readonly="readonly" value="<?php echo $rowHasil["pekerjaan"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>No. KTP</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtNIKIbu" id="txtNIKIbu" readonly="readonly" value="<?php echo $rowHasil["nik"];?>">
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
				<input class="styleInput" type="text" name="txtNamaAyah" id="txtNamaAyah" readonly="readonly" value="<?php echo $rowHasil["nama_suami"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Umur (tahun)</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtUmurAyah" id="txtUmurAyah" value="<?php echo $rowHasil["umur_ayah"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Pekerjaan</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtPekerjaanAyah" id="txtPekerjaanAyah" readonly="readonly" value="<?php echo $rowHasil["pekerjaan_suami"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>No. KTP</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtNIKAyah" id="txtNIKAyah" readonly="readonly" value="<?php echo $rowHasil["nik_suami"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Alamat</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtAlamatRumah" id="txtAlamatRumah" readonly="readonly" value="<?php echo $rowHasil["alamat_rumah"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Kecamatan</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtKecamatan" id="txtKecamatan" readonly="readonly" value="<?php echo $rowHasil["kecamatan"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Kabupaten/Kota</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtKabupaten" id="txtKabupaten" readonly="readonly" value="<?php echo $rowHasil["kabupaten"];?>">
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
			twentyFour: true,
			now: '<?php echo $rowHasil["waktu_lahir"] ?>'
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


		function simpanData(){
			var formData = $("#formEditKetLahir").serialize();

			$.ajax({
				url: 'prosesEntriKetLahir.php',
				type: 'POST',
				data: formData
			})
			.done(function() {
				console.log("success");
				swal({
						title: "Data Registrasi Anak Berhasil Diperbaharui!",
						type: "success",
						allowOutsideClick: false,
						showConfirmButton: false,
						timer: 1000,
						heightAuto: false
					}).then(function(){
						$("#txtNoReg").focus();
					});
			});
		}

		$(document).on("submit", "#formEditKetLahir", function(event){
			event.preventDefault();
		});

		$(document).on("click", "#btnSimpan", function(){
			if ($("#txtNamaIbu").val() == "" || $("#txtNamaIbu").val() == "Data Tidak Ditemukan"){
				swal("Masukkan Nomor Registrasi yang Benar!!!");
				return;
			}
			else if(
					$("#txtJarakKehamilan").val() == "" || 
					$("#txtStatusTT").val() == "" || 
					$("#txtPnlgPersalinan").val() == "" ||
					$("#cmbCaraPersalinan").val() == "0" ||
					$("#cmbStatusTT").val() == "0"
				){
				swal("Data Belum Lengkap!!!");
				return;
			}
			simpanData();
		});

		$(document).on("focusin", "#cmbJnsKelahiran", function(){
			$("#txtKelahiranKe").focus();
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