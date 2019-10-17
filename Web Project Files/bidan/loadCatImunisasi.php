<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/main.css" />
	<script src="scripts/sweetalert2/dist/sweetalert2.js"></script>
	<link rel="stylesheet" href="scripts/sweetalert2/dist/sweetalert2.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
	<style type="text/css">
		.no-js #loader { display: none;  }
		.js #loader { display: block; position: absolute; left: 100px; top: 0; }
		.se-pre-con {
			position: fixed;
			left: 0px;
			top: 0px;
			width: 100%;
			height: 100%;
			z-index: 9999;
			background: url(img/loadingAndroid.gif) center no-repeat #fff;
		}
	</style>
	<script type="text/javascript">
		$(window).load(function() {
			// Animate loader off screen
			$(".se-pre-con").fadeOut("slow");;
		});
	</script>
</head>
<body>
<div class="se-pre-con"></div>
<?php

include_once 'conn.php';
$sql = "
	SELECT
	tb_reg_anak.no_ket_lahir,
	tb_reg_anak.nama,
	tb_reg_anak.tgl_lahir,
	tb_reg_ibu.nama as nama_ibu,
	tb_reg_ibu.nama_suami as nama_ayah,
	tb_reg_ibu.alamat_rumah
	FROM
	tb_reg_anak
	INNER JOIN tb_reg_ibu ON tb_reg_anak.no_reg_ibu = tb_reg_ibu.no_reg
	WHERE
	tb_reg_anak.no_ket_lahir = ? or tb_reg_anak.id_anak = ?
";
$ps = $conn->stmt_init();
$ps->prepare($sql);
$ps->bind_param("ss", $p1, $p1);
$p1 = $_POST["noKetLahir"];
$ps->execute();
$hasil = $ps->get_result();
if ($hasil->num_rows > 0){
	$row = $hasil->fetch_assoc();
}
else{
	echo "<script> location.replace('index.php'); </script>";
	exit();
}
?>

<div class="divMain" style="border: initial; box-shadow: initial; background-color: transparent;">
	<div>
		<form id="formCari">
			<div class="baris">
				<div class="mergeKolom">
					<label style="font-weight: bold; font-size: 150%; text-align: center;">CATATAN IMUNISASI ANAK</label>
				</div>
			</div>
			<div class="baris">
				<div class="kolom1">
					<label>No. Keterangan Lahir</label>
				</div>
				<div class="kolom2">
					<input class="styleInput hurufBesar" type="text" readonly="readonly" value="<?php echo $row["no_ket_lahir"];?>">
				</div>
			</div>
			<div class="baris">
				<div class="kolom1">
					<label>Nama Anak</label>
				</div>
				<div class="kolom2">
					<input class="styleInput" type="text" readonly="readonly" value="<?php echo $row["nama"];?>">
				</div>
			</div>
			<div class="baris">
				<div class="kolom1">
					<label>Tgl Lahir</label>
				</div>
				<div class="kolom2">
					<input class="styleInput" type="text" readonly="readonly" value="<?php echo $row["tgl_lahir"];?>">
				</div>
			</div>
			<div class="baris">
				<div class="kolom1">
					<label>Nama Ibu</label>
				</div>
				<div class="kolom2">
					<input class="styleInput" type="text" readonly="readonly" value="<?php echo $row["nama_ibu"];?>">
				</div>
			</div>
			<div class="baris">
				<div class="kolom1">
					<label>Nama Ayah</label>
				</div>
				<div class="kolom2">
					<input class="styleInput" type="text" readonly="readonly" value="<?php echo $row["nama_ayah"];?>">
				</div>
			</div>
			<div class="baris">
				<div class="kolom1">
					<label>Alamat</label>
				</div>
				<div class="kolom2">
					<input class="styleInput" type="text" readonly="readonly" value="<?php echo $row["alamat_rumah"];?>">
				</div>
			</div>
		</form>
	</div>
	<div id="divTabel" style="margin-top: 20px;">

<?php

$sql = "
	SELECT
	tb_cat_imunisasi.no_ket_lahir,
	tb_reg_anak.nama,
	tb_cat_imunisasi.vaksin,
	tb_cat_imunisasi.tgl_vaksin,
	tb_reg_ibu.nama AS nama_ibu,
	tb_reg_ibu.nama_suami as nama_ayah,
	tb_reg_ibu.alamat_rumah
	FROM
	tb_cat_imunisasi
	INNER JOIN tb_reg_anak ON tb_cat_imunisasi.no_ket_lahir = tb_reg_anak.no_ket_lahir
	INNER JOIN tb_reg_ibu ON tb_reg_anak.no_reg_ibu = tb_reg_ibu.no_reg
	WHERE
	tb_cat_imunisasi.no_ket_lahir = ? or tb_reg_anak.id_anak = ?
	ORDER BY tb_cat_imunisasi.tgl_vaksin
";
$ps = $conn->stmt_init();
$ps->prepare($sql);
$ps->bind_param("ss", $p1, $p1);
$p1 = $_POST["noKetLahir"];
$ps->execute();
$i=1;
$hasil = $ps->get_result();
if ($hasil->num_rows > 0){
	echo "
		<table border='1' id='tblDataBayi' class='styleTable'>
		<thead>
		<tr>
			<th>No.</th>
			<th>Vaksin</th>
			<th>Tgl Pemberian Vaksin</th>
		</tr>
		</thead>
		<tbody>
	";
	while($row = $hasil->fetch_assoc()){
		echo "<tr>";
		echo "<td>".$i."</td>";
		echo "<td>".$row["vaksin"]."</td>";
		echo "<td>".$row["tgl_vaksin"]."</td>";
		echo "</tr>";
		$i++;
	}
	$conn->close();
}
else{
	echo "
		<table border='1' id='tblDataBayi' class='styleTable'>
		<tbody>
		<tr>
			<th>Anak belum melakukan imunisasi</th>
		</tr>
	";
}
echo "</tbody></table>";

?>

		
	</div>
</div>
</body>
</html>