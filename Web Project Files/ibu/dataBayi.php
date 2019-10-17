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
			<input type="text" name="txtCari" id="txtCari" class="styleInput" style="width: 50%;" placeholder="Cari Nomor Regitrasi Bayi atau Nomor Keterangan Lahir">
			<input type="button" name="btnTampil1" id="btnTampil1" class="styleButton" style="width: initial;" value="Keterangan Lahir">
			<input type="button" name="btnTampil2" id="btnTampil2" class="styleButton" style="width: initial;" value="Catatan Imunisasi">
		</form>
	</div>
	<div id="divTabel">

<?php
	include_once 'conn.php';
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
		tb_reg_anak.umur_ayah,
		tb_reg_anak.id_anak
		FROM
		tb_reg_ibu
		LEFT JOIN tb_kecamatan ON tb_reg_ibu.id_kec = tb_kecamatan.id
		LEFT JOIN tb_kabupaten ON tb_reg_ibu.id_kab = tb_kabupaten.id
		INNER JOIN tb_reg_anak ON tb_reg_anak.no_reg_ibu = tb_reg_ibu.no_reg
		WHERE tb_reg_anak.tgl_lahir is not null and
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
			<table border='1' id='tblDataBayi' class='styleTable'>
			<thead>
			<tr>
				<th>No. ID</th>
				<th>No. Ket. Lahir</th>
				<th>Nama</th>
				<th>Tgl Lahir</th>
				<th>Jenis Kelamin</th>
				<th>Jenis Kelahiran</th>
				<th>Berat Lahir</th>
				<th>Panjang Badan</th>
				<th>Nama Ibu</th>
				<th>Nama Ayah</th>
			</tr>
			</thead>
			<tbody>
		";
		while($row = $hasil->fetch_assoc()){
			echo "<tr>";
			echo "<td>"; echo empty($row["id_anak"]) ? "Belum terisi" : $row["id_anak"]; echo "</td>";
			echo "<td>"; echo empty($row["no_ket_lahir"]) ? "Belum terisi" : $row["no_ket_lahir"]; echo "</td>";
			echo "<td>"; echo empty($row["nama_anak"]) ? "Belum terisi" : $row["nama_anak"]; echo "</td>";
			echo "<td>"; echo empty($row["tgl_lahir"]) ? "Belum terisi" : $row["tgl_lahir"]; echo "</td>";
			echo "<td>"; echo empty($row["jk"]) ? "Belum terisi" : $row["jk"]; echo "</td>";
			echo "<td>"; echo empty($row["jns_kelahiran"]) ? "Belum terisi" : $row["jns_kelahiran"]; echo "</td>";
			echo "<td>"; echo empty($row["berat_lahir"]) ? "Belum terisi" : $row["berat_lahir"]; echo "</td>";
			echo "<td>"; echo empty($row["panjang_badan"]) ? "Belum terisi" : $row["panjang_badan"]; echo "</td>";
			echo "<td>"; echo empty($row["nama"]) ? "Belum terisi" : $row["nama"]; echo "</td>";
			echo "<td>"; echo empty($row["nama_suami"]) ? "Belum terisi" : $row["nama_suami"]; echo "</td>";
			
			echo "</tr>";
		}
		$conn->close();
	}
	else{
		echo "
			<table border='1' id='tblDataBayi' class='styleTable'>
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


		$(document).on("click", "#tblDataBayi tr", function(){
			$(".styleTable tr:nth-child(even)").css('background-color', '#f2f2f2');
			$(".styleTable tr:nth-child(odd)").css('background-color', 'white');
			$(this).css('background-color', '#62E3FF');
			noReg = $(this).find("td").eq(0).html();
			$("#txtCari").val(noReg);
		});

		$(document).on("click", "#btnTampil1", function(){
			$(this).val("");
			if ($("#txtCari").val() == ""){
				$(this).val("Keterangan Lahir");
				return;
			}
			noReg = $("#txtCari").val();
			$(".content").empty();
			$(".content").addClass('loadingHalaman');
			$(".content").load("editKetLahir.php", {noReg: noReg}, function(){
				$(".content").removeClass('loadingHalaman');
			});
		});	

		$(document).on("click", "#btnTampil2", function(){
			$(this).addClass('loading');
			$(this).val("");
			if ($("#txtCari").val() == ""){
				$(this).removeClass('loading');
				$(this).val("Catatan Imunisasi");
				return;
			}
			if (cariDataCatatanImunisasi() != "Ada"){
				swal(
				  'Data belum dimasukkan! ',
				  'Silakan masukkan data melalui menu Input Catatan Imunisasi.',
				  'error'
				);
				$(this).removeClass('loading');
				$(this).val("Catatan Imunisasi");
				return;
			}
			noReg = $("#txtCari").val();
			$(this).removeClass('loading');
			$(this).val("Catatan Imunisasi");
			$(".content").empty();
			$(".content").addClass('loadingHalaman');
			$(".content").load("dataCatImunisasi.php", {noKetLahir: noReg}, function(){
				$(".content").removeClass('loadingHalaman');
			});
		});

		function cariNmr(){
			var input, filter, table, tr, td, i;
				input = document.getElementById("txtCari");
				filter = input.value.toUpperCase();
				table = document.getElementById("tblDataBayi");
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

		function cariNoKetLahir(){
			var input, filter, table, tr, td, i, j=0;
				input = document.getElementById("txtCari");
				filter = input.value.toUpperCase();
				table = document.getElementById("tblDataBayi");
				tr = table.getElementsByTagName("tr");
				for (i = 0; i < tr.length; i++) {
				
					td = tr[i].getElementsByTagName("td")[1];
					if (td) {
						if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
							tr[i].style.display = "";
						} else {
							tr[i].style.display = "none";
							j++;
						}
						
					}			 
				}
				//edited by luthfy13 for multiple search
				if (i==j+1) cariNmr();
		}

		function cariDataCatatanImunisasi(){
			var formData = $("#formCari").serialize();
			return $.ajax({
				url: 'cariDataCatatanImunisasi.php',
				type: 'POST',
				data: formData, //'{"noReg": "$("#txtCari").val()"}',
				async: false
			}).responseText;
		}

		$(document).on("input", "#txtCari", function(){
			if (noReg != ""){
				$(".styleTable tr:nth-child(even)").css('background-color', '#f2f2f2');
				$(".styleTable tr:nth-child(odd)").css('background-color', 'white');
				noReg = "";
			}
		});

		$(document).on("input", "#txtCari", function(){
			cariNoKetLahir();
		});

	});
</script>