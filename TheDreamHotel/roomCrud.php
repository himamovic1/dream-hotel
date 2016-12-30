<!DOCTYPE html>
<html>
	<head>
		<title>Izmjena sobe</title>
		<meta name="author" content="Haris Imamovic">
		<meta name="description" content="Website for The Dream Hotel">

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/roomCrudStyle.css">
	</head>

	<body class="blackOnWhite">
		<div style="display: block;">
			<?php

				include('aditionalScripts.php');
				session_start();
				
				if( !accessControl() ) {
					accessError();
					exit;
				}

				$error = true;
				$name = $price = $desc = '';
				$room = null;
				$isCreate = 'save';
				$requestedRoom = 0;
				$pics = array('', '', '');
				$message = '';
				$displayNew = 'inline-block';

				if(!empty($_POST['create'])) {

					$isCreate = 'create';
					$error = false;
					$displayNew = 'none';
					$roomsXml = simplexml_load_file('private/xml/hotelRooms.xml');

					if(!isset($_POST['name']) || !isset($_POST['price']) || !isset($_POST['description']) 
						|| !isset($_POST['picNo0']) || !isset($_POST['picNo1']) || !isset($_POST['picNo2']) ) {
						
						$message = "Morate unijeti sve podatke pravilno.";
					}
					else {
						$name = htmlentities($_POST['name'], ENT_QUOTES);
						$price = doubleval($_POST['price']);
						$desc = htmlentities($_POST['description'], ENT_QUOTES);
						$pics = array($_POST['picNo0'], $_POST['picNo1'], $_POST['picNo2']);

						if($roomsXml && validateValues($name, $price, $desc, $pics)) {
							$exists = false;
							foreach ($roomsXml->Room as $r)
								if( strtoupper(htmlentities($r->Name)) === strtoupper($name) ) {
									$exists = true;
									break;
								}

							if($exists) $message = 'Već postoji soba sa identicnim nazivom.';
							else {
								// Dodajemo nove podatke u xml
								$newRoom = $roomsXml->addChild('Room');
								$newRoom->addChild('Name', $name);
								$newRoom->addChild('Price', $price);
								$newRoom->addChild('Description', $desc);
								$photos = $newRoom->addChild('Pictures');
								$photos->addChild('Picture', $pics[0]);
								$photos->addChild('Picture', $pics[1]);
								$photos->addChild('Picture', $pics[2]);
								$roomsXml->asXml("private/xml/hotelRooms.xml");

								// Vracamo se na admin panel
								header("Location: admin_panel.php");
							}

						}
						else
							$message = "Morate unijeti sve podatke pravilno.";
					}	
				}
				elseif($_SERVER['REQUEST_METHOD'] == "GET" && isset($_REQUEST['id']) ) {
					$roomsXml = simplexml_load_file('private/xml/hotelRooms.xml');
					$requestedRoom = intval($_REQUEST['id']);

					if( $requestedRoom < count($roomsXml->children()) && $requestedRoom >= 0 && $roomsXml) {
						$error = false;

						// Povucemo podatke samo za odabranu sobu
						$room = $roomsXml->Room[$requestedRoom];

						$name = htmlentities($room->Name, ENT_QUOTES);
						$price = doubleval($room->Price);
						$desc = htmlentities($room->Description, ENT_QUOTES);
						$pics = $room->Pictures->Picture;
					}
				}
				
				if(!empty($_POST['delete'])) {
					$roomsXml = simplexml_load_file('private/xml/hotelRooms.xml');
					$requestedRoom = intval($_REQUEST['id']);

					if( $requestedRoom < count($roomsXml->children()) && $requestedRoom >= 0 ) {
						$error = false;
						$xmlNode = dom_import_simplexml($roomsXml->Room[$requestedRoom]);
						$xmlNode->parentNode->removeChild($xmlNode);
						$roomsXml->asXml("private/xml/hotelRooms.xml");

						echo '<div style="width=100%; text-align: center;">
								<p class="errorProv" color="#131313">Uspješno ste obrisani sobu.</p>
							  	<a href="admin_panel.php">Povratak na administracijski panel</a>
							  </div>'; 
						exit;
					}
				}
				elseif(!empty($_POST['save'])) {
					$roomsXml = simplexml_load_file('private/xml/hotelRooms.xml');
					$requestedRoom = intval($_REQUEST['id']);

					if( $requestedRoom < count($roomsXml->children()) && $requestedRoom >= 0 ) {
						$error = false;

						if(!isset($_POST['name']) || !isset($_POST['price']) || !isset($_POST['description']) 
							|| !isset($_POST['picNo0']) || !isset($_POST['picNo1']) || !isset($_POST['picNo2']) ) {
							
							$message = "Sve podatke morate unijeti ispravno";
						}	

						$name = htmlentities($_POST['name'], ENT_QUOTES);
						$price = doubleval($_POST['price']);
						$desc = htmlentities($_POST['description'], ENT_QUOTES);
						$pics = array($_POST['picNo0'], $_POST['picNo1'], $_POST['picNo2']);

						if(validateValues($name, $price, $desc, $pics)) {
							$exists = false;
							$count = 0;
							foreach ($roomsXml->Room as $r) {
								if( $count != $requestedRoom && strtoupper(htmlentities($r->Name)) === strtoupper($name) ) {
									$exists = true;
									break;
								}
								$count = $count + 1;
							}

							if($exists) {
								$message = "Već postoji soba sa identicnim imenom.";
							}
							else
							{
								$editedRoom = $roomsXml->Room[$requestedRoom];
								$editedRoom->Name = $name;
								$editedRoom->Price = $price;
								$editedRoom->Description = $desc;

								for ($i=0; $i < 3; $i++)
									$editedRoom->Pictures->Picture[$i] = $pics[$i];

								// Upisujemo ponovno sve u xml  i vratimo se na admin panel
								$roomsXml->asXml("private/xml/hotelRooms.xml");
								$message = "Promjene spašene";
							}
						}
						else $message = "Sve podatke morate unijeti pravilno";					
					}
				} // End of if/else block

				if($error) {
					echo '<div style="width=100%; text-align: center;">
							<p class="errorProv">Došlo je do greške!</p>
						  	<a href="admin_panel.php">Povratak na administracijski panel</a>
						  </div>'; 
					exit;	
				}
			?>
		</div>

		<form action="roomCrud.php<?php echo '?id='.$requestedRoom; ?>" method="POST">
			<input type="hidden" name="id" value="<?php echo $requestedRoom; ?>">
			<div class="row"><label for="name">Naziv: </label></div>
			<div class="row">
				<input type="text" name="name" value="<?php echo $name; ?>">
			</div>

			<div class="row"><label for="price">Cijena: </label></div>
			<div class="row"><input type="text" name="price" value="<?php echo $price; ?>"></div>

			<div class="row"><label for="description">Opis: </label></div>
			<div class="row">
				<textarea name="description"><?php echo $desc; ?></textarea>
			</div>

			<div class="row"><label>Linkovi slika: </label></div>
			<div class="row">
				<input type="text" name="picNo0" value="<?php echo $pics[0]; ?>">
				<input type="text" name="picNo1" value="<?php echo $pics[1]; ?>">
				<input type="text" name="picNo2" value="<?php echo $pics[2]; ?>">
			</div>
			<div class="row">
				<input type="submit" name="<?php echo $isCreate; ?>" value="Spasi izmjene">
				<input type="submit" name="delete" value="Obriši sobu" style="display: <?php echo $displayNew; ?>">
			</div>
			<div class="row" style="text-align: center; margin: 2em;">
				<div class="row"><label><?php echo $message; ?></label></div>
				<a href="admin_panel.php">&lt;&ensp;Povratak na administracijski panel</a>
			</div>
			<input type="hidden" name="id">
		</form>
	</body>
</html>
