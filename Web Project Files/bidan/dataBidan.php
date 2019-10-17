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

<div class="divMain" style="border: initial; box-shadow: initial; background-color: transparent;">
	<div style="margin-bottom: 15px;">
		<form id="formCari" style="color: white">
			Cari No. KTP / NIK<br>
			<input type="text" name="txtCari" id="txtCari" class="styleInput" style="width: 300px;" placeholder="Masukkan No. KTP">
		</form>
	</div>
	<div id="divTabel">

<?php
	include_once 'conn.php';
	$sql = "select * from tb_bidan";
	$hasil = $conn->query($sql);
	if ($hasil->num_rows > 0){
		echo "
			<table border='1' id='tblDataBidan' class='styleTable'>
			<thead>
			<tr>
				<th>No. KTP</th>
				<th>Nama</th>
				<th>Alamat</th>
				<th>No. Telp.</th>
			</tr>
			</thead>
			<tbody>
		";
		while($row = $hasil->fetch_assoc()){
			echo "<tr>";
			echo "<td>"; echo empty($row["id_bidan"]) ? "Belum terisi" : $row["id_bidan"]; echo "</td>";
			echo "<td>"; echo empty($row["nama"]) ? "Belum terisi" : $row["nama"]; echo "</td>";
			echo "<td>"; echo empty($row["alamat"]) ? "Belum terisi" : $row["alamat"]; echo "</td>";
			echo "<td>"; echo empty($row["telp"]) ? "Belum terisi" : $row["telp"]; echo "</td>";
			echo "</tr>";
		}
		$conn->close();
	}
	else{
		echo "
			<table border='1' id='tblDataBidan' class='styleTable'>
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


		$(document).on("click", "#tblDataBidan tr", function(){
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

		function cariNmr(){
			var input, filter, table, tr, td, i;
				input = document.getElementById("txtCari");
				filter = input.value.toUpperCase();
				table = document.getElementById("tblDataBidan");
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