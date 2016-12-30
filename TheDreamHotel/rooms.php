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
			<!-- About Rooms -->
			<section id="roomSection" class="contentSection blackOnWhite belowHeader">
				<div class="row">
					<div class="col-d-4"></div>
					<h2 class="col-d-4 sectionHeading">Sobe i apartmani</h2>
					<div class="col-d-4"></div>
				</div>
				
				<div class="row">
					<div class="col-d-3">&nbsp;</div>
					<div class="col-d-6">
						<p class="sectionParagraph">
							Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
							quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
							consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
							cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
							proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
						</p>	
						<br>
						<p class="sectionParagraph">
							Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
							quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
							consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
							cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
							proident, sunt in culpa qui officia deserunt mollit anim id est laborum.					
						</p>
					</div>
					<div class="col-d-3">&nbsp;</div>
				</div>
			</section>

			<!-- Script for loading room data -->
			<?php 

				function loadRooms() {
					return simplexml_load_file("private/xml/hotelRooms.xml");
				}

				function validateValues($name, $price, $desc, $picArray) {
					return true;
				}

				function validateLink($link) {
					return true;
				}

				$rooms = loadRooms();

				if($rooms) {
					$counter = 0;
					foreach ($rooms->Room as $room) {
						$name = htmlentities($room->Name, ENT_QUOTES);
						$price = doubleval($room->Price);
						$desc = htmlentities($room->Description, ENT_QUOTES);
						$pics = $room->Pictures->Picture;

						$validData = validateValues($name, $price, $desc, $pics);
						if($validData && fmod($counter, 2) == 0) {
							echo '<div class="row whiteOnBlack contentSection vCenter">
									<div class="slideshow col-d-7">
										<ul class="vCenter">
											<li><img src="'.$pics[0].'" alt="Room image"></li>
											<li><img src="'.$pics[1].'" alt="Room image"></li>
											<li><img src="'.$pics[2].'" alt="Room image"></li>
										</ul>		
									</div>
									<div class="contentSection col-d-5 vCenter">
										<h1 class="sectionHeading">'.$name.'</h1>
										<p class="sectionParagraph">'.$desc.'</p>
										<a class="button resBtt" href="booking.html" title="Rezervacija">
											Rezerviši sobu
										</a>
									</div>
								</div>';
						}
						else {
							echo '<div class="row blackOnWhite contentSection vCenter">
									<div class="contentSection col-d-5 vCenter">
										<h1 class="sectionHeading">'.$name.'</h1>
										<p class="sectionParagraph">'.$desc.'</p>
										<a class="button resBtt" href="booking.html" title="Rezervacija">
											Rezerviši sobu
										</a>
									</div>
									<div class="slideshow col-d-7">
										<ul class="vCenter">
											<li><img src="'.$pics[0].'" alt="Room image"></li>
											<li><img src="'.$pics[1].'" alt="Room image"></li>
											<li><img src="'.$pics[2].'" alt="Room image"></li>
										</ul>			
									</div>
								</div>';
						}
						
						$counter = $counter + 1;
					}
				}
				else {
					echo '<section class="contentSection whiteOnBlack">
							<div class="row">
								<div class="col-d-4"></div>
								<h2 class="col-d-4 sectionHeading">Greška pri učitavanju</h2>
								<div class="col-d-4"></div>
							</div>
							
							<div class="row">
								<div class="col-d-3">&nbsp;</div>
								<div class="col-d-6">
									<p class="sectionParagraph">
										We apologize for lack of service, we will be back with you in a moment.
										Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
										tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
										quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
										consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
										cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
										proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
									</p>
								</div>
								<div class="col-d-3">&nbsp;</div>
							</div>
						</section>';
				}
			?>

			<!-- Page Footer -->
			<footer class="whiteOnBlack">
				<small>&copy; The Dream Hotel 2016.</small>
				<small>Because life is beautiful.</small>
				
				<a href="#">
					<img src="img/icons/up.png" alt="To Top">
				</a>
			</footer>
		</div>

		<!-- Script for form validation -->
		<script src="js/validation/formValidation.js"></script>

		<!-- Script for loading subpages, dropdown menu, gallery, ... -->
		<script src="js/dreamScripts.js"></script>
	</body>
</html>