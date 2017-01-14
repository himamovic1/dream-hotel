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
		<div id="mainContent">
			
			<!-- Login form -->
			<div class="contentSection blackOnWhite belowHeader">
				<div class="row">
					<div class="col-d-4"></div>
					<h2 class="col-d-4 sectionHeading">The Dream Hotel Administracija</h2>
					<div class="col-d-4"></div>
				</div>

				<form id="loginForm" method="post" action="login.php">
					<!-- Processing form data -->
					<?php 
						include('aditionalScripts.php');
						session_start();
						
						$username = $password = $errorMsg = '';
						$loginFailed = true;

						if( accessControl() ) {	
							header("Location: admin_panel.php");	// Redirect to admin panel	
						}
						elseif ( isset($_POST['username']) && isset($_POST['password']) ) {
							$username = clearInput($_POST['username']);
							$password = clearInput($_POST['password']);

							if( checkCredentialsAndLogin($username, $password) ) {
								header("Location: admin_panel.php");
							}
							else {
								$errorMsg = "Pogrešni pristupni podaci";
							}
						}

					?>

					<div class="row">
						<div class="col-d-3 noDisp"></div>
						<p class="col-d-6 sectionParagraph vCenter formTip"><span>*</span>&ensp;su označena obavezna polja.</p>
						<div class="col-d-3 noDisp"></div>
					</div>	

					<!-- User name -->
					<div class="row">
						<div class="col-d-4 noDisp"></div>
						<div class="inputField col-d-4">
							<label>Korisničko ime: <span>*</span></label>
							<input type="text" name="username" id="username" tabindex="1"
								placeholder="Korisničko ime" oninput="validateCredentials(this)" required>
						</div>
						<div class="col-d-4 noDisp"></div>
					</div>

					<!-- Password -->
					<div class="row">
						<div class="col-d-4 noDisp"></div>
						<div class="inputField col-d-4">
							<label>Šifra: <span>*</span></label>
							<input type="password" name="password" id="password" tabindex="2"
								placeholder="Šifra" oninput="validateCredentials(this)" required>
						</div>
						<div class="col-d-4 noDisp"></div>
					</div>

					<!-- Login button -->
					<div class="row">
						<div class="col-d-5 noDisp"></div>
						<input class="col-d-2 button" type="submit" name="login" id="login" tabindex="3" value="Prijava">
						<div class="col-d-5 noDisp"></div>
					</div>

					<!-- Error provider -->
					<div class="row">
						<div class="col-d-4"></div>
						<h2 class="col-d-4 sectionHeading" style="color: red"><?php echo $errorMsg; ?></h2>
						<div class="col-d-4"></div>
					</div>

				</form>
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

		<!-- Script for loading subpages, dropdown menu, gallery, ... -->
		<script src="js/dreamScripts.js"></script>
		<script src="js/validation/loginValidation.js"></script>
	</body>
</html>