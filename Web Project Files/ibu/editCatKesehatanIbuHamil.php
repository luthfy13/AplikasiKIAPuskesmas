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

$bulanTT = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
$caraBersalin = array("Spontan/Normal","Tindakan");

$sql = "
	SELECT
	tb_cat_ibu_hamil.no_reg,
	tb_cat_ibu_hamil.hamil_ke,
	tb_cat_ibu_hamil.jml_persalinan,
	tb_cat_ibu_hamil.jml_keguguran,
	tb_cat_ibu_hamil.jml_gravida,
	tb_cat_ibu_hamil.jml_paritas,
	tb_cat_ibu_hamil.jml_abortus,
	tb_cat_ibu_hamil.jml_anak_hidup,
	tb_cat_ibu_hamil.jml_lhr_mati,
	tb_cat_ibu_hamil.jml_anak_lhr_krg_bln,
	tb_cat_ibu_hamil.jarak_kehamilan,
	tb_cat_ibu_hamil.bulan_tt,
	tb_cat_ibu_hamil.tahun_tt,
	tb_cat_ibu_hamil.penolong_persalinan,
	tb_cat_ibu_hamil.cara_persalinan,
	tb_reg_ibu.nama
	FROM
	tb_cat_ibu_hamil
	INNER JOIN tb_reg_ibu ON tb_cat_ibu_hamil.no_reg = tb_reg_ibu.no_reg
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

$ps->close();
$conn->close();

?>

<div id="divEditCatKesehatanIbuHamil" class="divMain">
	<form id="formEditCatKesehatanIbuHamil">
		<div class="baris">
			<div class="mergeKolom">
				<label style="font-weight: bold; font-size: 150%; text-align: center;">EDIT CATATAN KESEHATAN IBU HAMIL</label>
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
				<label>Hamil ke-</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="number" name="txtHamilKe" id="txtHamilKe" value="<?php echo $rowHasil["hamil_ke"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Jumlah Persalinan</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="number" name="txtJmlPersalinan" id="txtJmlPersalinan" value="<?php echo $rowHasil["jml_persalinan"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Jumlah Keguguran</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="number" name="txtJmlKeguguran" id="txtJmlKeguguran" value="<?php echo $rowHasil["jml_keguguran"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Jumlah Gravida</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="number" name="txtJmlGravida" id="txtJmlGravida" value="<?php echo $rowHasil["jml_gravida"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Jumlah Paritas</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="number" name="txtJmlParitas" id="txtJmlParitas" value="<?php echo $rowHasil["jml_paritas"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Jumlah Abortus</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="number" name="txtJmlAbortus" id="txtJmlAbortus" value="<?php echo $rowHasil["jml_abortus"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Jumlah Anak Hidup</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="number" name="txtJmlAnakHidup" id="txtJmlAnakHidup" value="<?php echo $rowHasil["jml_anak_hidup"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Jumlah Lahir Mati</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="number" name="txtJmlLahirMati" id="txtJmlLahirMati" value="<?php echo $rowHasil["jml_lhr_mati"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Jumlah Anak Lahir Kurang Bulan</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="number" name="txtJmlAnakLhrKrgBln" id="txtJmlAnakLhrKrgBln" value="<?php echo $rowHasil["jml_anak_lhr_krg_bln"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Jarak Kehamilan Ini dengan Persalinan Terakhir</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtJarakKehamilan" id="txtJarakKehamilan" value="<?php echo $rowHasil["jarak_kehamilan"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Status Imunisasi TT Terakhir</label>
			</div>
			<div class="kolom2" style="box-sizing: border-box;">
				<select name="cmbStatusTT" id="cmbStatusTT" class="styleInput" style="width: 120px; margin-right: 5px;">
					<option value="0">-BULAN-</option>
					<?php 
						foreach($bulanTT as $val){
							if ($val == $rowHasil["bulan_tt"])
								echo "<option value='".$val."' selected='selected'>".$val."</option>";
							else
								echo "<option value='".$val."'>".$val."</option>";
						}
					?>
				</select>
				<input class="styleInput" type="number" name="txtStatusTT" id="txtStatusTT" placeholder="Tahun" style="width: 120px;" value="<?php echo $rowHasil["tahun_tt"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Penolong Persalinan Terakhir</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtPnlgPersalinan" id="txtPnlgPersalinan" value="<?php echo $rowHasil["penolong_persalinan"];?>">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Cara Persalinan Terakhir</label>
			</div>
			<div class="kolom2">
				<select name="cmbCaraPersalinan" id="cmbCaraPersalinan" class="styleInput">
					<option value="0">-PILIH-</option>
					<?php 
						foreach($caraBersalin as $val){
							if ($val == $rowHasil["cara_persalinan"])
								echo "<option value='".$val."' selected='selected'>".$val."</option>";
							else
								echo "<option value='".$val."'>".$val."</option>";
						}
					?>
				</select>
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