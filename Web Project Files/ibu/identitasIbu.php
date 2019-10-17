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

$agama = array("Islam", "Kristen Protestan", "Kristen Katolik", "Kristen Ortodoks", "Hindu", "Buddha", "Konghucu");
$pendidikan = array("Tidak Sekolah", "SD", "SMP", "SMU", "Akademi", "Perguruan Tinggi");
$golDarah = array("0", "A", "B", "AB");

$bidan = array();
$hasil = $conn->query("select id_bidan, nama from tb_bidan order by nama");
while($row = $hasil->fetch_assoc()) $bidan[$row["id_bidan"]] = $row["nama"];

$kab = array();
$hasil = $conn->query("select id, name from tb_kabupaten order by name");
while($row = $hasil->fetch_assoc()) $kab[$row["id"]] = $row["name"];

$bulanTT = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
$caraBersalin = array("Spontan/Normal","Tindakan");

$sql = "
	SELECT
	tb_reg_ibu.no_reg,
	tb_reg_ibu.nik,
	tb_reg_ibu.nama,
	tb_reg_ibu.tempat_lahir,
	DATE_FORMAT(tb_reg_ibu.tgl_lahir, '%d-%m-%Y') as tgl_lahir,
	tb_reg_ibu.agama,
	tb_reg_ibu.pendidikan,
	tb_reg_ibu.gol_darah,
	tb_reg_ibu.pekerjaan,
	tb_reg_ibu.no_jkn,
	tb_reg_ibu.nik_suami,
	tb_reg_ibu.nama_suami,
	tb_reg_ibu.tempat_lahir_suami,
	DATE_FORMAT(tb_reg_ibu.tgl_lahir_suami, '%d-%m-%Y') as tgl_lahir_suami,
	tb_reg_ibu.agama_suami,
	tb_reg_ibu.pendidikan_suami,
	tb_reg_ibu.gol_darah_suami,
	tb_reg_ibu.pekerjaan_suami,
	tb_reg_ibu.alamat_rumah,
	tb_reg_ibu.telp,
	tb_reg_ibu.username,
	tb_reg_ibu.id_bidan,
	tb_bidan.nama as nama_bidan,
	tb_reg_ibu.id_kab,
	tb_kabupaten.name as kabupaten,
	tb_reg_ibu.id_kec,
	tb_kecamatan.name as kecamatan
	FROM
	tb_reg_ibu
	LEFT JOIN tb_bidan ON tb_reg_ibu.id_bidan = tb_bidan.id_bidan
	LEFT JOIN tb_kabupaten ON tb_reg_ibu.id_kab = tb_kabupaten.id
	LEFT JOIN tb_kecamatan ON tb_reg_ibu.id_kec = tb_kecamatan.id
	WHERE
	tb_reg_ibu.username = ?
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
	echo "<script> location.replace('index.php'); </script>";
	exit();
}

$kec = array();
$ps = $conn->stmt_init();
$ps->prepare("select id, name from tb_kecamatan where id_kab = ?  order by name");
$ps->bind_param("s", $id);
$id = $rowHasil["id_kab"];
$ps->execute();
$hasil = $ps->get_result();
while($row = $hasil->fetch_assoc()) $kec[$row["id"]] = $row["name"];

$ps->close();
$conn->close();

?>

<div id="divEditCatKesehatanIbuHamil" class="divMain">
	<form id="formEditIdentitasIbu">
		<div class="baris">
			<div class="mergeKolom">
				<label style="font-weight: bold;">Identitas Ibu Hamil:</label>
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>No. Registrasi</label>
			</div>
			<div class="kolom2">
				<input class="styleInput hurufBesar" type="text" readonly="readonly" value="<?php echo $rowHasil["no_reg"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Nama Tenaga Kesehatan</label>
			</div>
			<div class="kolom2">
				<select name="cmbBidan" id="cmbBidan" class="styleInput">
					<option value="0">-PILIH-</option>
					<?php 
						foreach($bidan as $key => $keyVal){
							if ($key == $rowHasil["id_bidan"])
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
				<label>NIK</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtNik" id="txtNik" value="<?php echo $rowHasil["nik"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Nama</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtNama" id="txtNama" value="<?php echo $rowHasil["nama"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Tempat, Tgl Lahir</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtTempatLhr" id="txtTempatLhr" value="<?php echo $rowHasil["tempat_lahir"];?>" style='width: 30%'>
				<input class="styleInput" type="text" name="txtTglLhr" id="txtTglLhr" value="<?php echo $rowHasil["tgl_lahir"];?>" style='width: 69%'>
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Agama</label>
			</div>
			<div class="kolom2">
				<select name="cmbAgama" id="cmbAgama" class="styleInput">
					<option value="0">-PILIH-</option>
					<?php 
						foreach($agama as $val){
							if ($val == $rowHasil["agama"])
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
				<label>Pendidikan</label>
			</div>
			<div class="kolom2">
				<select name="cmbPendidikan" id="cmbPendidikan" class="styleInput">
					<option value="0">-PILIH-</option>
					<?php 
						foreach($pendidikan as $val){
							if ($val == $rowHasil["pendidikan"])
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
				<label>Golongan Darah</label>
			</div>
			<div class="kolom2">
				<select name="cmbGolDarah" id="cmbGolDarah" class="styleInput">
					<option value="0">-PILIH-</option>
					<?php 
						foreach($golDarah as $val){
							if ($val == $rowHasil["gol_darah"])
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
				<label>Pekerjaan</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtPekerjaan" id="txtPekerjaan" value="<?php echo $rowHasil["pekerjaan"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>No. JKN</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtNoJkn" id="txtNoJkn" value="<?php echo $rowHasil["no_jkn"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="mergeKolom">
				<label style="font-weight: bold;">Identitas Suami:</label>
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>NIK</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtNikSuami" id="txtNikSuami" value="<?php echo $rowHasil["nik_suami"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Nama</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtNamaSuami" id="txtNamaSuami" value="<?php echo $rowHasil["nama_suami"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Tempat, Tgl Lahir</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtTempatLhrSuami" id="txtTempatLhr" value="<?php echo $rowHasil["tempat_lahir"];?>" style='width: 30%'>
				<input class="styleInput" type="text" name="txtTglLhrSuami" id="txtTglLhr" value="<?php echo $rowHasil["tgl_lahir"];?>" style='width: 69%'>
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Agama</label>
			</div>
			<div class="kolom2">
				<select name="cmbAgamaSuami" id="cmbAgamaSuami" class="styleInput">
					<option value="0">-PILIH-</option>
					<?php 
						foreach($agama as $val){
							if ($val == $rowHasil["agama_suami"])
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
				<label>Pendidikan</label>
			</div>
			<div class="kolom2">
				<select name="cmbPendidikanSuami" id="cmbPendidikanSuami" class="styleInput">
					<option value="0">-PILIH-</option>
					<?php 
						foreach($pendidikan as $val){
							if ($val == $rowHasil["pendidikan_suami"])
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
				<label>Golongan Darah</label>
			</div>
			<div class="kolom2">
				<select name="cmbGolDarahSuami" id="cmbGolDarahSuami" class="styleInput">
					<option value="0">-PILIH-</option>
					<?php 
						foreach($golDarah as $val){
							if ($val == $rowHasil["gol_darah_suami"])
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
				<label>Pekerjaan</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtPekerjaanSuami" id="txtPekerjaanSuami" value="<?php echo $rowHasil["pekerjaan_suami"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Alamat Rumah</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtAlamat" id="txtAlamat" value="<?php echo $rowHasil["alamat_rumah"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>No. Telpon</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtNoTelp" id="txtNoTelp" value="<?php echo $rowHasil["telp"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Kabupaten</label>
			</div>
			<div class="kolom2">
				<select name="cmbKab" id="cmbKab" class="styleInput">
					<option value="0">-PILIH-</option>
					<?php 
						foreach($kab as $key => $keyVal){
							if ($key == $rowHasil["id_kab"])
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
				<label>Kecamatan</label>
			</div>
			<div class="kolom2">
				<select name="cmbKec" id="cmbKec" class="styleInput">
					<option value="0">-PILIH-</option>
					<?php 
						foreach($kec as $key => $keyVal){
							if ($key == $rowHasil["id_kec"])
								echo "<option value='".$key."' selected='selected'>".$keyVal."</option>";
							else
								echo "<option value='".$key."'>".$keyVal."</option>";
						}
					?>
				</select>
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

		$("#txtTglLhr, #txtTglLhrSuami").pickadate({
			format: 'dd-mm-yyyy',
			formatSubmit: 'yyyymmdd',
			hiddenName: true,
			today: 'Tanggal Sekarang',
			clear: 'Hapus',
			close: 'Tutup',
			selectMonths: true,
			selectYears: true,
			selectYears: 100,
			max: true
		});

		function simpanData(){
			var formData = $("#formEditIdentitasIbu").serialize();

			$.ajax({
				url: 'prosesEntriIdentitasIbu.php',
				type: 'POST',
				data: formData
			})
			.done(function(e) {
				console.log(e);
				swal({
						title: "Data Berhasil Tersimpan!",
						type: "success",
						allowOutsideClick: false,
						showConfirmButton: false,
						timer: 1000,
						heightAuto: false
					}).then(function(){
						$("#txtNik").focus();
					});
			});
		}

		$(document).on("click", "#btnTutup", function(){
			$(".content").empty();
		});

		$(document).on('change', '#cmbKab', function(event) {
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
			    if (this.readyState == 4 && this.status == 200) {
			        $("#cmbKec").html(this.responseText);
			    }
			};
			xmlhttp.open("POST", "namaKecamatan.php", false);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.send("idKab=" + $("#cmbKab").val());
		});

		$(document).on("click", "#btnSimpan", function(){
			simpanData();
		});

		$(document).on("click", "#btnTutup", function(){
			$(".content").empty();
			$(".content").addClass('loadingHalaman');
			$(".content").load("dataIbuHamil.php", function(){
				$(".content").removeClass('loadingHalaman');
			});
		});

		$(document).on("click", "#btnReload", function(){
			var nmr = $("#txtNoReg").val();
			$(".content").empty();
			$(".content").addClass('loadingHalaman');
			$(".content").load("identitasIbu.php", function(){
				$(".content").removeClass('loadingHalaman');
			});
		});

	});
</script>