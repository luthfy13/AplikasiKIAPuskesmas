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

$bulanPerkiraan = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
$metodeKB = array("Metode Operasi Wanita","Metode Operasi Pria","Spiral/AKDR","Implan","Suntikan","Pil KB","Kondom");
$biaya = array("Disiapkan Sendiri", "Ditanggung JKN", "Dibantu Oleh");

$ambulanceNama = array("0","0","0");
$ambulanceTelp = array("0","0","0");
$pendonorNama = array("0","0","0");
$pendonorTelp = array("0","0","0");

$sql = "
		SELECT
			tb_persiapan.no_reg,
			tb_reg_ibu.nama,
			tb_reg_ibu.alamat_rumah,
			tb_persiapan.bulan_perkiraan,
			tb_persiapan.tahun_perkiraan,
			tb_persiapan.dana_persalinan,
			tb_persiapan.metode_kb,
			tb_persiapan.id_bidan1,
			tb_persiapan.id_bidan2 
		FROM
			tb_persiapan
			INNER JOIN tb_reg_ibu ON tb_persiapan.no_reg = tb_reg_ibu.no_reg
		WHERE tb_reg_ibu.username = ?
";
$ps = $conn->stmt_init();
$ps->prepare($sql);
$ps->bind_param("s", $p1);
$p1 = $_SESSION["usernyaTawwa"];
$ps->execute();
$hasil = $ps->get_result();
if ($hasil->num_rows > 0){
	$rowHasil = $hasil->fetch_assoc();
}
else{
	echo "
		<script> 
		swal('Gagal Mengambil Data', 'Data belum dimasukkan oleh bidan!!!', 'error').then(function(){
			$('.content').empty();
			$('.content').addClass('loadingHalaman');
			$('.content').load('dataIbuHamil.php', function(){
				$('.content').removeClass('loadingHalaman');
			});
		});
		</script>
	";
	exit();
}

$sql = "select * from tb_kendaraan where no_reg = ?";
$ps = $conn->stmt_init();
$ps->prepare($sql);
$ps->bind_param("s", $p1);
$p1 = $rowHasil['no_reg'];
$ps->execute();
$hasil = $ps->get_result();
if ($hasil->num_rows > 0){
	$i=0;
	while($row = $hasil->fetch_assoc()){
		$ambulanceNama[$i] = $row["pemilik_ambulance"];
		$ambulanceTelp[$i] = $row["telp"];
		$i++;
	}
}

$sql = "select * from tb_donor where no_reg = ?";
$ps = $conn->stmt_init();
$ps->prepare($sql);
$ps->bind_param("s", $p1);
$p1 = $rowHasil['no_reg'];
$ps->execute();
$hasil = $ps->get_result();
if ($hasil->num_rows > 0){
	$i=0;
	while($row = $hasil->fetch_assoc()){
		$pendonorNama[$i] = $row["nama_donor"];
		$pendonorTelp[$i] = $row["telp"];
		$i++;
	}
}

$ps->close();
$conn->close();

?>

<div id="divEditPersiapan" class="divMain">
	<form id="formEditPersiapan">
		<div class="baris">
			<div class="mergeKolom">
				<label style="font-weight: bold; font-size: 150%; text-align: center;">EDIT DATA PERSIAPAN MENYAMBUT PERSALINAN</label>
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>No. Registrasi</label>
			</div>
			<div class="kolom2">
				<input class="styleInput hurufBesar" type="text" name="txtNoReg" id="txtNoReg" readonly="readonly" value="<?php echo $rowHasil["no_reg"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Nama Lengkap</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtNamaIbu" id="txtNamaIbu" readonly="readonly" value="<?php echo $rowHasil["nama"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Alamat</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtAlamat" id="txtAlamat" readonly="readonly" value="<?php echo $rowHasil["alamat_rumah"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Perkiraan waktu persalinan</label>
			</div>
			<div class="kolom2">
				<select name="cmbPerkiraan" id="cmbPerkiraan" class="styleInput" style="width: 120px; margin-right: 5px;">
					<option value="0">-BULAN-</option>
					<?php 
						foreach($bulanPerkiraan as $val){
							if ($val == $rowHasil["bulan_perkiraan"])
								echo "<option value='".$val."' selected='selected'>".$val."</option>";
							else
								echo "<option value='".$val."'>".$val."</option>";
						}
					?>
				</select>
				<input class="styleInput" type="number" name="txtPerkiraan" id="txtPerkiraan" placeholder="Tahun" style="width: 120px;" value="<?php echo $rowHasil["tahun_perkiraan"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Metode KB Setelah Melahirkan</label>
			</div>
			<div class="kolom2">
				<select name="cmbMetodeKB" id="cmbMetodeKB" class="styleInput">
					<option value="0">-PILIH-</option>
					<?php 
						foreach($metodeKB as $val){
							if ($val == $rowHasil["metode_kb"])
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
				<label>Dana Persalinan</label>
			</div>
			<div class="kolom2">
				<select name="cmbDana" id="cmbDana" class="styleInput">
					<option value="0">-PILIH-</option>
					<?php 
						foreach($biaya as $val){
							if (strpos($rowHasil["dana_persalinan"], $val) !== false)
								echo "<option value='".$val."' selected='selected'>".$val."</option>";
							else
								echo "<option value='".$val."'>".$val."</option>";
						}
					?>
				</select>
				<input class="styleInput" type="text" name="txtDana" id="txtDana" style="display: none;" placeholder="Masukkan Nama" value="<?php echo $rowHasil["dana_persalinan"];?>">
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
							if ($key == $rowHasil["id_bidan1"])
								echo "<option value='".$key."' selected='selected'>".$keyVal."</option>";
							else
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
							if ($key == $rowHasil["id_bidan2"])
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
				<label style="font-weight: bold;">Kendaraan/ambulance desa oleh:</label>
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Kendaraan I</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtNamaAmbulan1" id="txtNamaAmbulan1" placeholder="Masukkan Nama Pemilik Kendaraan" style="width: 300px; margin-right: 5px;" value="<?php if($ambulanceNama[0] != "0") echo $ambulanceNama[0]; ?>">
				<input class="styleInput" type="text" name="txtTelpAmbulan1" id="txtTelpAmbulan1" placeholder="Masukkan Nomor Telp/HP" style="width: 300px;" value="<?php if($ambulanceTelp[0] != "0") echo $ambulanceTelp[0]; ?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Kendaraan II</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtNamaAmbulan2" id="txtNamaAmbulan2" placeholder="Masukkan Nama Pemilik Kendaraan" style="width: 300px; margin-right: 5px;" value="<?php if($ambulanceNama[1] != "0") echo $ambulanceNama[1]; ?>">
				<input class="styleInput" type="text" name="txtTelpAmbulan2" id="txtTelpAmbulan2" placeholder="Masukkan Nomor Telp/HP" style="width: 300px;" value="<?php if($ambulanceTelp[1] != "0") echo $ambulanceTelp[1]; ?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Kendaraan III</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtNamaAmbulan3" id="txtNamaAmbulan3" placeholder="Masukkan Nama Pemilik Kendaraan" style="width: 300px; margin-right: 5px;" value="<?php if($ambulanceNama[2] != "0") echo $ambulanceNama[2]; ?>">
				<input class="styleInput" type="text" name="txtTelpAmbulan3" id="txtTelpAmbulan3" placeholder="Masukkan Nomor Telp/HP" style="width: 300px;" value="<?php if($ambulanceTelp[2] != "0") echo $ambulanceTelp[2]; ?>">
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
				<input class="styleInput" type="text" name="txtNamaPendonor1" id="txtNamaPendonor1" placeholder="Masukkan Nama Pendonor" style="width: 300px; margin-right: 5px;" value="<?php if($pendonorNama[0] != "0") echo $pendonorNama[0]; ?>">
				<input class="styleInput" type="text" name="txtTelpPendonor1" id="txtTelpPendonor1" placeholder="Masukkan Nomor Telp/HP" style="width: 300px;" value="<?php if($pendonorTelp[0] != "0") echo $pendonorTelp[0]; ?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Pendonor II</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtNamaPendonor2" id="txtNamaPendonor2" placeholder="Masukkan Nama Pendonor" style="width: 300px; margin-right: 5px;" value="<?php if($pendonorNama[1] != "0") echo $pendonorNama[1]; ?>">
				<input class="styleInput" type="text" name="txtTelpPendonor2" id="txtTelpPendonor2" placeholder="Masukkan Nomor Telp/HP" style="width: 300px;" value="<?php if($pendonorTelp[1] != "0") echo $pendonorTelp[1]; ?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Pendonor III</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtNamaPendonor3" id="txtNamaPendonor3" placeholder="Masukkan Nama Pendonor" style="width: 300px; margin-right: 5px;" value="<?php if($pendonorNama[2] != "0") echo $pendonorNama[2]; ?>">
				<input class="styleInput" type="text" name="txtTelpPendonor3" id="txtTelpPendonor3" placeholder="Masukkan Nomor Telp/HP" style="width: 300px;" value="<?php if($pendonorTelp[2] != "0") echo $pendonorTelp[2]; ?>">
			</div>
		</div>
		
		<div class="baris">
			<div class="mergeKolom">
				<input type="button" class="styleButton" value="Tutup" id="btnTutup">
			</div>
		</div>
	</div>
</form>
<div style="height: 40px;"></div>

<script type="text/javascript">
	$(document).ready(function() {

		var statsuNoReg=false;

		$(document).on("click").unbind();

		//inisialisasi----------------------------------------------------------------------------
		if ($("#cmbDana").val() == "Dibantu Oleh"){
			$("#cmbDana").css({
					"width": '300px',
					"margin-right": '5px'
			});
			$("#txtDana").css({
				"display": 'inline',
				"width": '300px'
			});
			var dana = "<?php echo $rowHasil['dana_persalinan'] ?>";
			$("#txtDana").val(dana.substring(13));
		}
		//akhir inisialisasi-----------------------------------------------------------------------

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

		$(document).on("click", "#btnTutup", function(){
			$(".content").empty();
			$(".content").addClass('loadingHalaman');
			$(".content").load("dataIbuHamil.php", function(){
				$(".content").removeClass('loadingHalaman');
			});
		});

	});
</script>