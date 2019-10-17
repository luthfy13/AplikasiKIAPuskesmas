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

<!DOCTYPE html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Aplikasi Pelayanan Kesehatan Ibu dan Anak</title>
	<meta name="description" content="Blueprint: A basic template for a responsive multi-level menu" />
	<meta name="keywords" content="blueprint, template, html, css, menu, responsive, mobile-friendly" />
	<meta name="author" content="Codrops" />
	<link rel="shortcut icon" href="img/icon.png">
	<!-- food icons -->
	<link rel="stylesheet" type="text/css" href="css/organicfoodicons.css" />
	<!-- demo styles -->
	<link rel="stylesheet" type="text/css" href="css/demo.css" />
	<!-- menu styles -->
	<link rel="stylesheet" type="text/css" href="css/component.css" />
	<link rel="stylesheet" type="text/css" href="css/main.css" />
	<script src="scripts/sweetalert2/dist/sweetalert2.js"></script>
	<link rel="stylesheet" href="scripts/sweetalert2/dist/sweetalert2.css">
	<script src="js/modernizr-custom.js"></script>
	<script src="js/jquery-3.3.1.js"></script>
	<script src="scripts/pickadate/lib/picker.js"></script>
	<script src="scripts/pickadate/lib/picker.date.js"></script>
	<link rel="stylesheet" href="scripts/pickadate/lib/themes/default.css">
	<link rel="stylesheet" href="scripts/pickadate/lib/themes/default.date.css">

	<link rel="stylesheet" href="scripts/picktime/dist/wickedpicker.min.css">
	<script src="scripts/picktime/dist/wickedpicker.min.js"></script>
	<!-- <script src="scripts/pickadate/lib/translations/id_ID.js"></script> -->
</head>

<body>
	<!-- Main container -->
	<div class="container">
		<!-- Blueprint header -->
		<header class="bp-header cf">
			<div class="dummy-logo">
				<div class="dummy-icon foodicon foodicon--coconut"></div>
				<h2 class="dummy-heading">Sistem Pelayanan Kesehatan Ibu dan Anak</h2>
			</div>
			<div class="bp-header__main">
				<!-- <span class="bp-header__present">Blueprint <span class="bp-tooltip bp-icon bp-icon--about" data-content="The Blueprints are a collection of basic and minimal website concepts, components, plugins and layouts with minimal style for easy adaption and usage, or simply for inspiration."></span></span>
				<h1 class="bp-header__title">Multi-Level Menu</h1>
				<nav class="bp-nav">
					<a class="bp-nav__item bp-icon bp-icon--prev" href="http://tympanus.net/Blueprints/PageStackNavigation/" data-info="previous Blueprint"><span>Previous Blueprint</span></a>
					<a class="bp-nav__item bp-icon bp-icon--next" href="" data-info="next Blueprint"><span>Next Blueprint</span></a>
					<a class="bp-nav__item bp-icon bp-icon--drop" href="http://tympanus.net/codrops/?p=25521" data-info="back to the Codrops article"><span>back to the Codrops article</span></a>
					<a class="bp-nav__item bp-icon bp-icon--archive" href="http://tympanus.net/codrops/category/blueprints/" data-info="Blueprints archive"><span>Go to the archive</span></a>
				</nav> -->
			</div>
		</header>
		<button class="action action--open" aria-label="Open Menu"><span class="icon icon--menu"></span></button>
		<nav id="ml-menu" class="menu">
			<button class="action action--close" aria-label="Close Menu"><span class="icon icon--cross"></span></button>
			<div class="menu__wrap">
				<ul data-menu="main" class="menu__level" tabindex="-1" role="menu" aria-label="All">
					<li class="menu__item" role="menuitem"><a class="menu__link" data-submenu="submenu-1" aria-owns="submenu-1" href="#">Data Ibu</a></li>
					<li class="menu__item" role="menuitem"><a class="menu__link" data-submenu="submenu-2" aria-owns="submenu-2" href="#">Data Bayi</a></li>
					<li class="menu__item" role="menuitem"><a class="menu__link" data-submenu="submenu-3" aria-owns="submenu-3" href="#">Data Bidan</a></li>
					<li class="menu__item" role="menuitem"><a class="menu__link" href="#">Logout</a></li>
				</ul>
				<!-- Submenu 1 -->
				<ul data-menu="submenu-1" id="submenu-1" class="menu__level" tabindex="-1" role="menu" aria-label="Data Ibu">
					<li class="menu__item" role="menuitem"><a class="menu__link" href="#">Registrasi Ibu Hamil</a></li>
					<li class="menu__item" role="menuitem"><a class="menu__link" href="#">Input Catatan Kesehatan</a></li>
					<li class="menu__item" role="menuitem"><a class="menu__link" href="#">Input Persiapan Persalinan</a></li>
					<li class="menu__item" role="menuitem"><a class="menu__link" href="#">Tampilkan Data</a></li>
					<!-- <li class="menu__item" role="menuitem"><a class="menu__link" data-submenu="submenu-1-1" aria-owns="submenu-1-1" href="#">Catatan Kesehatan Ibu Hamil</a></li> -->
				</ul>
				<!-- Submenu 1-1 -->
				<!-- <ul data-menu="submenu-1-1" id="submenu-1-1" class="menu__level" tabindex="-1" role="menu" aria-label="Catatan Kesehatan Ibu Hamil">
					<li class="menu__item" role="menuitem"><a class="menu__link" href="#">Input Catatan Kesehatan</a></li>
					<li class="menu__item" role="menuitem"><a class="menu__link" href="#">Edit Catatan Kesehatan</a></li>
					<li class="menu__item" role="menuitem"><a class="menu__link" href="#">Input Data Kaki Bengkak</a></li>
					<li class="menu__item" role="menuitem"><a class="menu__link" href="#">Tampil Data</a></li>
				</ul> -->
				<!-- Submenu 2 -->
				<ul data-menu="submenu-2" id="submenu-2" class="menu__level" tabindex="-1" role="menu" aria-label="Data Bayi">
					<li class="menu__item" role="menuitem"><a class="menu__link" href="#">Input Keterangan Lahir</a></li>
					<li class="menu__item" role="menuitem"><a class="menu__link" href="#">Input Catatan Imunisasi</a></li>
					<li class="menu__item" role="menuitem"><a class="menu__link" href="#">Tampil Data Bayi</a></li>
				</ul>
				<!-- Submenu 2-1 -->
				<!-- <ul data-menu="submenu-2-1" id="submenu-2-1" class="menu__level" tabindex="-1" role="menu" aria-label="Catatan Imunisasi Anak">
					<li class="menu__item" role="menuitem"><a class="menu__link" href="#">Input Catatan Imunisasi</a></li>
					<li class="menu__item" role="menuitem"><a class="menu__link" href="#">Tampil Data</a></li>
				</ul> -->
				<!-- Submenu 3 -->
				<ul data-menu="submenu-3" id="submenu-3" class="menu__level" tabindex="-1" role="menu" aria-label="Data Bidan">
					<li class="menu__item" role="menuitem"><a class="menu__link" href="#">Edit Akun</a></li>
					<li class="menu__item" role="menuitem"><a class="menu__link" href="#">Tambah Akun Bidan/Dokter</a></li>
					<li class="menu__item" role="menuitem"><a class="menu__link" href="#">Tampil Data Bidan</a></li>
					<!-- <li class="menu__item" role="menuitem"><a class="menu__link" data-submenu="submenu-2-1" aria-owns="submenu-2-1" href="#">Catatan Imunisasi Anak</a></li> -->
				</ul>
			</div>
		</nav>
		<div class="content">
			<p class="info">Please choose a category</p>
			<!-- Ajax loaded content here -->
		</div>
	</div>
	<!-- /view -->
	<script src="js/classie.js"></script>
	<script src="js/main.js"></script>
	<script>
	$(document).ready(function() {
		(function() {
			var menuEl = document.getElementById('ml-menu'),
				mlmenu = new MLMenu(menuEl, {
					// breadcrumbsCtrl : true, // show breadcrumbs
					initialBreadcrumb : 'Menu Utama', // initial breadcrumb text
					backCtrl : true, // show back button
					itemsDelayInterval : 10, // delay between each menu item sliding animation
					onItemClick: loadDummyData // callback: item that doesn´t have a submenu gets clicked - onItemClick([event], [inner HTML of the clicked item])
				});

			// mobile menu toggle
			var openMenuCtrl = document.querySelector('.action--open'),
				closeMenuCtrl = document.querySelector('.action--close');

			openMenuCtrl.addEventListener('click', openMenu);
			closeMenuCtrl.addEventListener('click', closeMenu);

			function openMenu() {
				classie.add(menuEl, 'menu--open');
				closeMenuCtrl.focus();
			}

			function closeMenu() {
				classie.remove(menuEl, 'menu--open');
				openMenuCtrl.focus();
			}

			// simulate grid content loading
			var gridWrapper = document.querySelector('.content');

			function loadDummyData(ev, itemName) {
				ev.preventDefault();
				$(".content").empty();
				closeMenu();
				gridWrapper.innerHTML = '';
				classie.add(gridWrapper, 'content--loading');
				setTimeout(function() {
					classie.remove(gridWrapper, 'content--loading');
					switch(itemName){
						case "Input Keterangan Lahir":
							$(".content").addClass('loadingHalaman');
							$(".content").load("entriKetLahir.php", function(){
								$(".content").removeClass('loadingHalaman');
							});
							break;
						case "Registrasi Ibu Hamil":
							$(".content").load("registrasi.php");
							break;
						case "Tampilkan Data":
							$(".content").addClass('loadingHalaman');
							$(".content").load("dataIbuHamil.php", function(){
								$(".content").removeClass('loadingHalaman');
							});
							break;
						case "Input Catatan Kesehatan":
							$(".content").load("entriCatKesehatanIbuHamil.php");
							break;
						case "Input Persiapan Persalinan":
							$(".content").addClass('loadingHalaman');
							$(".content").load("entriMenyambutPersalinan.php", function(){
								$(".content").removeClass('loadingHalaman');
							});
							break;
						case "Tampil Data Bayi":
							$(".content").addClass('loadingHalaman');
							$(".content").load("dataBayi.php", function(){
								$(".content").removeClass('loadingHalaman');
							});
							break;
						case "Edit Akun":
							$(".content").addClass('loadingHalaman');
							$(".content").load("editAkunBidan.php", function(){
								$(".content").removeClass('loadingHalaman');
							});
							break;
						case "Tambah Akun Bidan/Dokter":
							$(".content").addClass('loadingHalaman');
							$(".content").load("tambahBidan.php", function(){
								$(".content").removeClass('loadingHalaman');
							});
							break;
						case "Tampil Data Bidan":
							$(".content").addClass('loadingHalaman');
							$(".content").load("dataBidan.php", function(){
								$(".content").removeClass('loadingHalaman');
							});
							break;
						case "Input Catatan Imunisasi":
							$(".content").addClass('loadingHalaman');
							$(".content").load("entriCatImunisasi.php", function(){
								$(".content").removeClass('loadingHalaman');
							});
							break;
						case "Logout":
							location.href = "logout.php";
							break;
					}
					
					//gridWrapper.innerHTML = '<object type="text/html" data="test.php" ></object>';
				}, 100);
			}
		})();
	});
	
	</script>
</body>

</html>
