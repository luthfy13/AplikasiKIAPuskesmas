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

<div class="divMain" style="border: initial; box-shadow: initial; background-color: transparent;">
	<div>
		<form id="formCari">
			<input type="text" name="txtCari" id="txtCari" class="styleInput" style="width: 300px;" placeholder="Masukkan No. Reg"><br><br>
			<input type="button" name="btnTampil1" id="btnTampil1" class="styleButton" style="width: initial;" value="Identitas Ibu Hamil">
			<input type="button" name="btnTampil2" id="btnTampil2" class="styleButton" style="width: initial;" value="Catatan Kesehatan">
			<input type="button" name="btnTampil3" id="btnTampil3" class="styleButton" style="width: initial;" value="Persiapan Persalinan">
		</form>
	</div>
	<div id="divTabel">

<?php
	include_once 'conn.php';
	$sql = "
		SELECT
		tb_reg_ibu.no_reg,
		tb_reg_ibu.nik,
		tb_reg_ibu.nama,
		tb_reg_ibu.tempat_lahir,
		DATE_FORMAT(tb_reg_ibu.tgl_lahir, ' %d-%m-%Y') as tgl_lahir,
		tb_reg_ibu.agama,
		tb_reg_ibu.kehamilan_ke,
		tb_reg_ibu.umur_anak_terakhir,
		tb_reg_ibu.pendidikan,
		tb_reg_ibu.gol_darah,
		tb_reg_ibu.pekerjaan,
		tb_reg_ibu.no_jkn,
		tb_reg_ibu.nik_suami,
		tb_reg_ibu.nama_suami,
		tb_reg_ibu.tempat_lahir_suami,
		DATE_FORMAT(tb_reg_ibu.tgl_lahir_suami, ' %d-%m-%Y') as tgl_lahir_suami,
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
		tb_reg_ibu.username = ?
	";
	$ps = $conn->stmt_init();
	$ps->prepare($sql);
	$ps->bind_param("s", $p1);
	$p1 = $_SESSION["usernyaTawwa"];
	$ps->execute();
	$hasil = $ps->get_result();
	if ($hasil->num_rows > 0){
		echo "
			<table border='1' id='tblDataIbu' class='styleTable'>
			<thead>
			<tr>
				<th>No. Registrasi</th>
				<th>Nama</th>
				<th>Tgl Lahir</th>
				<th>Hamil ke-</th>
				<th>Umur Anak Terakhir</th>
				<th>Gol. Darah</th>
				<th>Nama Suami</th>
				<th>Tgl Lahir Suami</th>
				<th>Gol. Darah Suami</th>
				<th>Alamat Rumah</th>
				<th>No. Telp</th>
			</tr>
			</thead>
			<tbody>
		";
		while($row = $hasil->fetch_assoc()){
			echo "<tr>";
			echo "<td>"; echo empty($row["no_reg"]) ? "Belum terisi" : $row["no_reg"]; echo "</td>";
			echo "<td>"; echo empty($row["nama"]) ? "Belum terisi" : $row["nama"]; echo "</td>";
			echo "<td>"; echo empty($row["tgl_lahir"]) ? "Belum terisi" : $row["tgl_lahir"]; echo "</td>";
			echo "<td>"; echo empty($row["kehamilan_ke"]) ? "Belum terisi" : $row["kehamilan_ke"]; echo "</td>";
			echo "<td>"; echo empty($row["umur_anak_terakhir"]) ? "Belum terisi" : $row["umur_anak_terakhir"]; echo "</td>";
			echo "<td>"; echo empty($row["gol_darah"]) ? "Belum terisi" : $row["gol_darah"]; echo "</td>";
			echo "<td>"; echo empty($row["nama_suami"]) ? "Belum terisi" : $row["nama_suami"]; echo "</td>";
			echo "<td>"; echo empty($row["tgl_lahir_suami"]) ? "Belum terisi" : $row["tgl_lahir_suami"]; echo "</td>";
			echo "<td>"; echo empty($row["gol_darah_suami"]) ? "Belum terisi" : $row["gol_darah_suami"]; echo "</td>";
			echo "<td>"; echo empty($row["alamat_rumah"]) ? "Belum terisi" : $row["alamat_rumah"]; echo "</td>";
			echo "<td>"; echo empty($row["telp"]) ? "Belum terisi" : $row["telp"]; echo "</td>";
			echo "</tr>";
		}
		$conn->close();
	}
	else{
		echo "
			<table border='1' id='tblDataIbu' class='styleTable'>
			<tbody>
			<tr>
				<th>Belum ada data untuk diverifikasi</th>
			</tr>
		";
	}
	echo "</tbody></table>";
?>
		
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		var noReg = "";

		$(document).on("click").unbind();

		$("input[type=button]").css({
			'width': '200px',
			'margin-bottom': '10px'
		});


		$(document).on("click", "#tblDataIbu tr", function(){
			$(".styleTable tr:nth-child(even)").css('background-color', '#f2f2f2');
			$(".styleTable tr:nth-child(odd)").css('background-color', 'white');
			$(this).css('background-color', '#62E3FF');
			noReg = $(this).find("td").eq(0).html();
			$("#txtCari").val(noReg);
		});

		$(document).on("click", "#btnTampil1", function(){
			$(this).addClass('loading');
			$(this).val("");
			if ($("#txtCari").val() == ""){
				$(this).removeClass('loading');
				$(this).val("Identitas Ibu Hamil");
				return;
			}
			noReg = $("#txtCari").val();
			$(".content").empty();
			$(".content").addClass('loadingHalaman');
			$(".content").load("identitasIbu.php", {noReg: noReg}, function(){
				$(".content").removeClass('loadingHalaman');
			});
		});	

		$(document).on("click", "#btnTampil2", function(){
			$(this).addClass('loading');
			$(this).val("");
			if ($("#txtCari").val() == ""){
				$(this).removeClass('loading');
				$(this).val("Catatan Kesehatan");
				return;
			}
			if (cariDataCatatanKesehatan() != "Ada"){
				swal(
				  'Data belum dimasukkan! ',
				  'Silakan masukkan data melalui menu Input Catatan Kesehatan.',
				  'error'
				);
				$(this).removeClass('loading');
				$(this).val("Catatan Kesehatan");
				return;
			}
			noReg = $("#txtCari").val();
			$(this).removeClass('loading');
			$(this).val("Catatan Kesehatan");
			$(".content").empty();
			$(".content").addClass('loadingHalaman');
			$(".content").load("editCatKesehatanIbuHamil.php", {noReg: noReg}, function(){
				$(".content").removeClass('loadingHalaman');
			});
		});

		$(document).on("click", "#btnTampil3", function(){
			$(this).addClass('loading');
			$(this).val("");
			if ($("#txtCari").val() == ""){
				$(this).removeClass('loading');
				$(this).val("Persiapan Persalinan");
				return;
			}
			if (cariDataPersiapan() != "Ada"){
				swal(
				  'Data belum dimasukkan! ',
				  'Silakan masukkan data melalui menu Input Persiapan Persalinan.',
				  'error'
				);
				$(this).removeClass('loading');
				$(this).val("Persiapan Persalinan");
				return;
			}
			noReg = $("#txtCari").val();
			$(this).removeClass('loading');
			$(this).val("Persiapan Persalinan");
			$(".content").empty();
			$(".content").addClass('loadingHalaman');
			$(".content").load("editMenyambutPersalinan.php", {noReg: noReg}, function(){
				$(".content").removeClass('loadingHalaman');
			});
		});

		function cariNmr(){
			var input, filter, table, tr, td, i;
				input = document.getElementById("txtCari");
				filter = input.value.toUpperCase();
				table = document.getElementById("tblDataIbu");
				tr = table.getElementsByTagName("tr");
				for (i = 0; i < tr.length; i++) {
					td = tr[i].getElementsByTagName("td")[0];
					if (td) {
						if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
							tr[i].style.display = "";
						} else {
							tr[i].style.display = "none";
						}
					}			 
				}
		}

		function cariDataCatatanKesehatan(){
			var formData = $("#formCari").serialize();
			return $.ajax({
				url: 'cariDataCatatanKesehatan.php',
				type: 'POST',
				data: formData, //'{"noReg": "$("#txtCari").val()"}',
				async: false
			}).responseText;
		}

		function cariDataPersiapan(){
			var formData = $("#formCari").serialize();
			return $.ajax({
				url: 'cariDataPersiapan.php',
				type: 'POST',
				data: formData, //'{"noReg": "$("#txtCari").val()"}',
				async: false
			}).responseText;
		}


		// //setup before functions
		// var typingTimer;                //timer identifier
		// var doneTypingInterval = 2000;  //time in ms, 5 second for example
		// var $input = $('#txtCari');

		// //on keyup, start the countdown
		// $input.on('keyup', function () {
		// 	clearTimeout(typingTimer);
		// 	typingTimer = setTimeout(doneTyping, doneTypingInterval);
		// });

		// //on keydown, clear the countdown 
		// $input.on('keydown', function () {
		// 	clearTimeout(typingTimer);
		// });

		// //user is "finished typing," do something
		// function doneTyping () {
		// 	$("#txtCari").val($("#txtCari").val().toUpperCase());
		// 	cariDataCatatanKesehatan();
		// }

		$(document).on("input", "#txtCari", function(){
			if (noReg != ""){
				$(".styleTable tr:nth-child(even)").css('background-color', '#f2f2f2');
				$(".styleTable tr:nth-child(odd)").css('background-color', 'white');
				noReg = "";
			}
		});

		$(document).on("input", "#txtCari", function(){
			cariNmr();
		});

	});
</script>