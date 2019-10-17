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

$bulanTT = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
$caraBersalin = array("Spontan/Normal","Tindakan");

$sql = "
	SELECT
	tb_reg_ibu.no_reg,
	tb_reg_ibu.nik,
	tb_reg_ibu.nama,
	tb_reg_ibu.tempat_lahir,
	DATE_FORMAT(tb_reg_ibu.tgl_lahir, '%Y/%m/%d') as tgl_lahir,
	tb_reg_ibu.agama,
	tb_reg_ibu.pendidikan,
	tb_reg_ibu.gol_darah,
	tb_reg_ibu.pekerjaan,
	tb_reg_ibu.no_jkn,
	tb_reg_ibu.nik_suami,
	tb_reg_ibu.nama_suami,
	tb_reg_ibu.tempat_lahir_suami,
	DATE_FORMAT(tb_reg_ibu.tgl_lahir_suami, '%Y/%m/%d') as tgl_lahir_suami,
	tb_reg_ibu.agama_suami,
	tb_reg_ibu.pendidikan_suami,
	tb_reg_ibu.gol_darah_suami,
	tb_reg_ibu.pekerjaan_suami,
	tb_reg_ibu.alamat_rumah,
	tb_reg_ibu.telp,
	tb_reg_ibu.username,
	tb_bidan.nama as nama_bidan,
	tb_kabupaten.`name` as kabupaten,
	tb_kecamatan.`name` as kecamatan
	FROM
	tb_reg_ibu
	LEFT JOIN tb_bidan ON tb_reg_ibu.id_bidan = tb_bidan.id_bidan
	LEFT JOIN tb_kabupaten ON tb_reg_ibu.id_kab = tb_kabupaten.id
	LEFT JOIN tb_kecamatan ON tb_reg_ibu.id_kec = tb_kecamatan.id
	WHERE
	tb_reg_ibu.no_reg = ?
";
$ps = $conn->stmt_init();
$ps->prepare($sql);
$ps->bind_param("s", $p1);
$p1 = $_POST["noReg"];
$ps->execute();

$hasil = $ps->get_result();
if ($hasil->num_rows > 0){
	$rowHasil = $hasil->fetch_assoc();
}
else{
	echo "<script> location.replace('index.php'); </script>";
	exit();
}

$ps->close();
$conn->close();

?>

<div id="divEditCatKesehatanIbuHamil" class="divMain">
	<form id="formEditCatKesehatanIbuHamil">
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
				<input class="styleInput" type="text" readonly="readonly" value="<?php echo $rowHasil["nama_bidan"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>NIK</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" readonly="readonly" value="<?php echo $rowHasil["nik"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Nama</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" readonly="readonly" value="<?php echo $rowHasil["nama"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Tempat, Tgl Lahir</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" readonly="readonly" value="<?php echo $rowHasil["tempat_lahir"].", ".$rowHasil["tgl_lahir"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Agama</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" readonly="readonly" value="<?php echo $rowHasil["agama"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Pendidikan</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" readonly="readonly" value="<?php echo $rowHasil["pendidikan"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Golongan Darah</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" readonly="readonly" value="<?php echo $rowHasil["gol_darah"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Pekerjaan</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" readonly="readonly" value="<?php echo $rowHasil["pekerjaan"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>No. JKN</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" readonly="readonly" value="<?php echo $rowHasil["no_jkn"];?>">
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
				<input class="styleInput" type="text" readonly="readonly" value="<?php echo $rowHasil["nik_suami"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Nama</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" readonly="readonly" value="<?php echo $rowHasil["nama_suami"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Tempat, Tgl Lahir</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" readonly="readonly" value="<?php echo $rowHasil["tempat_lahir_suami"].", ".$rowHasil["tgl_lahir_suami"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Agama</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" readonly="readonly" value="<?php echo $rowHasil["agama_suami"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Pendidikan</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" readonly="readonly" value="<?php echo $rowHasil["pendidikan_suami"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Golongan Darah</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" readonly="readonly" value="<?php echo $rowHasil["gol_darah_suami"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Pekerjaan</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" readonly="readonly" value="<?php echo $rowHasil["pekerjaan_suami"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Alamat Rumah</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" readonly="readonly" value="<?php echo $rowHasil["alamat_rumah"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>No. Telpon</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" readonly="readonly" value="<?php echo $rowHasil["telp"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Kecamatan</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" readonly="readonly" value="<?php echo $rowHasil["kecamatan"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Kabupaten</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" readonly="readonly" value="<?php echo $rowHasil["kabupaten"];?>">
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

		$(document).on("click").unbind();

		$(document).on("focus", "input[type=text], input[type=number]", function(){
			$(this).select();
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