<!DOCTYPE html>

<html lang="hr">
	<head>
		<title>The Dream Hotel</title>
		
		<meta name="author" content="Haris Imamovic">
		<meta name="description" content="Website for The Dream Hotel">

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link href="https://fonts.googleapis.com/css?family=Lato%7CLobster" rel="stylesheet">
		<link rel="stylesheet" href="css/style.css">
	</head>

	<body>

		<?php 
			include('aditionalScripts.php');
			session_start();

			if(!accessControl()) {
				header("Location: login.php");
			}
		?>
		
		<!-- Page Header -->
		<header class="whiteOnBlack">
			<!-- Logo Headline -->		
			<a href="index.html" title="Home page" id="logo">The Dream Hotel</a>

			<!-- Burger Navigation Icon -->
			<img id="burgerNav" src="img/icons/menu.png" alt="Menu" onclick="toggleMenu()" >

			<!-- Site Navigation -->
			<nav id="navbar" class="hideNav">
				<ul>
                    <li>
                        <a href="index.html" title="Home page">Početna</a>
                    </li><li>
            			<a href="rooms.php" title="Hotel Rooms">Sobe</a>
            		</li><li>
                        <a href="gallery.html" title="Gallery">Galerija</a>
                    </li><li>
                    	<a href="booking.html" title="Booking">Rezervacija</a>
                    </li><li>
                        <a href="contact.html" title="Contact us">Kontakt</a>
                    </li><li>
            			<a href="login.php" title="Restaurant & Bar">Administracija</a>
                    </li>
                </ul>
			</nav>
		</header>

		<!-- Main Content Wrapper -->
		<div class="blackOnWhite belowHeader" style="margin-bottom: 8em;">
			
			<div class="row contentSection">
				<div class="col-d-0 noDisp"></div>

				<!-- Tab content -->
				<div id="mainContent" class="tabContent whiteOnBlack col-d-7">
					<!-- ALL THINGS GO HERE -->										
				</div>

				<div class="col-d-1 noDisp"></div>

				<!-- Tab control bar -->
				<div class="tabHead whiteOnBlack col-d-3">

					<div class="currRole">
						<h3>Trenutno ste prijavljeni kao:</h3>
						<h2>Administrator</h2>
					</div>

					<!-- Controls -->
					<ul class="tabControls">
						<li><a href="#" onclick="return load('search')">Pretraga</a></li>
						<li><a href="#" onclick="return load('rooms')">Ažuriranje podataka</a></li>
						<li><a href="#" onclick="return load('download')">Download podataka</a></li>
						<li><a href="#" onclick="return load('summary')">Izvještaj</a></li>
					</ul>

					<form id="logoutForm" method="post" action="admin_panel.php">
						
						<!-- Processing form data -->
						<?php 
							if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_SESSION['username'])) {
								session_unset();

								// Redirect to login
								header("Location: login.php");
							}
						?>
						
						<input class="button" type="submit" name="logout" id="logout" value="Odjavi se">
					</form>
				</div>

				<div class="col-d-0 noDisp"></div>
			</div>

			

			<!-- Page Footer -->
			<footer class="whiteOnBlack stickyFooter">
				<small>&copy; The Dream Hotel 2016.</small>
				<small>Because life is beautiful.</small>
				
				<a href="#">
					<img src="img/icons/up.png" alt="To Top">
				</a>
			</footer>
		</div>

		<!-- Script for loading subpages -->
		<script src="js/ajaxScript.js"></script>

		<!-- Script for searchbox -->
		<script src="js/searchScript.js"></script>
	</body>
</html>