<!DOCTYPE html>
<html>
<head>
	<script src="js/jquery-3.3.1.js"></script>
	<script src="scripts/sweetalert2/dist/sweetalert2.js"></script>
	<link rel="stylesheet" href="scripts/sweetalert2/dist/sweetalert2.css">
	<title></title>
</head>
<body>
	<form id="form1">
		<input type="text" id="NamaApp" name="NamaApp">
		<input type="button" id="btn1" value="OK">
	</form>
	<table id="tblHasil">
		
	</table>
<script type="text/javascript">
	$(document).ready(function() {
		var hasilPencarian;

		function tampil(){
			var formData = $("#form1").serialize();
			var data;
			$.ajax({
				url: 'http://192.168.1.101:5000/AppSearch',
				crossOrigin: true,
				headers: {'Content-Type': 'application/x-www-form-urlencoded'},
	            contentType: 'application/x-www-form-urlencoded; charset=utf-8',
				type: 'POST',
				data: formData,
				async: false
			})
			.done(function(e) {
				hasilPencarian = e;
			});
		}

		$(document).on("click", "#btn1", function(){
			tampil();
			var i=0;
			var tableHeader = "<tr><th>No.</th><th>nama app</th><th>nama package</th><th>Developer</th><th>Rating</th><th>icon</th></tr>"
			var hasil = "", iconPath="";
			for (i=0; i<hasilPencarian.length;i++){
				iconPath = hasilPencarian[i]["Icon Path"];
				if (iconPath.substring(0, 5) != "https")
					iconPath = "https:" + iconPath;
				hasil = hasil + "<tr>" + 
				"<td>" + (i+1) + "</td>" + 
				"<td>" + hasilPencarian[i]["Nama App"] + "</td>" + 
				"<td> " + hasilPencarian[i]["Nama Package"] + "</td>" + 
				"<td> " + hasilPencarian[i]["Developer"] + "</td>" + 
				"<td> " + hasilPencarian[i]["Rating"] + "</td>" + 
				"<td><img src='"+ iconPath +"' alt='icon' height='40'></td>" + 
				"</tr>"
			}
			$("#tblHasil").html(tableHeader + hasil);
			$("#tblHasil").attr('border', '1');
			$("#tblHasil").css({
				'border-collapse': 'collapse',
				'margin-top': '20px'
			});
			$("#tblHasil td").css('padding', '10px');
		});
	});
</script>
</body>
</html>