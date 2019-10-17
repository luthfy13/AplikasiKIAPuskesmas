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
			<div class="kolom1">
				<label>Kaki Bengkak</label>
			</div>
			<div class="kolom2" style="color: black;">
				<input type="radio" name="optKakiBengkak" value="Ya" style="width: initial; text-align: left; margin-top: 10px;">Ya
				<input type="radio" name="optKakiBengkak" value="Tidak" style="width: initial; text-align: left;">Tidak
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Hasil Pemeriksaan Laboratorium</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtHslPeriksa" id="txtHslPeriksa">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Tindakan (pemberian TT, Fe, terapi, rujukan, umpan balik)</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtTindakan" id="txtTindakan">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Nasihat yang Disampaikan</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtNasihat" id="txtNasihat">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Tempat Pelayanan</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtTempat" id="txtTempat">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Nama Pemeriksa</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtNamaPemeriksa" id="txtNamaPemeriksa">
			</div>
		</div>
		<div class="baris">
			<div class="kolom1">
				<label>Kapan Harus Kembali</label>
			</div>
			<div class="kolom2">
				<input class="styleInput" type="text" name="txtTglKembali" id="txtTglKembali">
			</div>
		</div>

		<div class="baris">
			<div class="mergeKolom">
				<input type="button" class="styleButton" value="Simpan Data" id="btnSimpan">
			</div>
		</div>
	</div>
</form>

<script type="text/javascript">
	$(document).ready(function() {
		$("#txtTglKembali").pickadate({
			format: 'dd-mm-yyyy',
			formatSubmit: 'yyyymmdd',
			hiddenName: true,
			today: 'Tanggal Sekarang',
			clear: 'Hapus',
			close: 'Tutup',
			selectMonths: true,
			selectYears: true,
			selectYears: 25,
			min: new Date()
		});

	});
</script>