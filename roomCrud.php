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

				// Database connection
				$database = ConnectToDatabase();
				// Prepared statements
				$getRoomIdStmt = $database->prepare('SELECT id FROM rooms WHERE name =?');
				$getRoomByIdStmt = $database->prepare('SELECT * FROM rooms WHERE id =:id');
				$getAllRoomsStmt = $database->prepare('SELECT id, name, price, description FROM rooms');
				$getRoomImageNamesStmt = $database->prepare('SELECT id, name FROM images WHERE room =:id');
				$roomInsertStmt = $database->prepare('INSERT INTO rooms (name, price, description, creator) 
														VALUES (?, ?, ?, 1)'); 
				$imageInsertStmt = $database->prepare('INSERT INTO images (name, content, room) 
														VALUES (?, ?, ?)');
				$updateRoomStmt = $database->prepare('UPDATE rooms SET name = :nameVal, price = :priceVal, description = :descVal 
														WHERE id = :id');
				$updateImageStmt = $database->prepare('UPDATE images SET name = :nameVal, content = :contVal WHERE id = :id');
				$deleteRoomStmt = $database->prepare('DELETE FROM rooms WHERE id =:id');

				$error = true;
				$name = $price = $desc = '';
				$room = null;
				$isCreate = 'save';
				$requestedRoom = 0;
				$pics = array('', '', '');
				$message = '';
				$displayNew = 'inline-block';
				$imageIdList = array(0, 0, 0);

				if(!empty($_POST['create'])) {
					$isCreate = 'create';
					$error = false;
					$displayNew = 'none';

					if(!isset($_POST['name']) || !isset($_POST['price']) || !isset($_POST['description']) 
						|| !isset($_FILES['picNo0']) ||  !isset($_FILES['picNo1']) ||  !isset($_FILES['picNo2'])) {

						$message = "Morate unijeti sve podatke pravilno.";
					}
					else {
						$name = htmlentities($_POST['name'], ENT_QUOTES);
						$price = floatval($_POST['price']);
						$desc = htmlentities($_POST['description'], ENT_QUOTES);
						$pics = array($_FILES['picNo0']['name'], $_FILES['picNo1']['name'], $_FILES['picNo2']['name']);

						if(validateValues($name, $price, $desc, $pics)) {

							$roomInsertStmt->bindParam(1, $name, PDO::PARAM_STR);
							$roomInsertStmt->bindParam(2, $price, PDO::PARAM_STR);
							$roomInsertStmt->bindParam(3, $desc, PDO::PARAM_STR);

							try {
								$roomInsertStmt->execute();

								// Now we insert images
								$getRoomIdStmt->bindParam(1, $name, PDO::PARAM_STR);
								$getRoomIdStmt->execute();
								$id = $getRoomIdStmt->fetch(PDO::FETCH_OBJ)->id;

								// Manage uploaded files if there are any, write data to hidden inputs
								for ($i=0; $i < 3; $i++)
									if(isset($_FILES['picNo'.$i]))
										if(validateImage($_FILES['picNo'.$i]['name'])) {
											$type = pathinfo($_FILES['picNo'.$i]['tmp_name'], PATHINFO_EXTENSION);
											$data = file_get_contents($_FILES['picNo'.$i]['tmp_name']);
											$img = 'data:image/'.$type.';base64,'.base64_encode($data);

											$imageInsertStmt->bindParam(1, $_FILES['picNo'.$i]['name'], PDO::PARAM_STR);
											$imageInsertStmt->bindParam(2, $img, PDO::PARAM_STR);
											$imageInsertStmt->bindParam(3, $id, PDO::PARAM_INT);
											$imageInsertStmt->execute();
										}
										else $message = "Morate unijeti sve podatke pravilno. Upload sve slike ponovno";

								// After insertion return to admin panel
								header('Location: admin_panel.php');	
							}
							catch(PDOException $e) {
								$message = "Već postoji soba sa identičnim nazivom. ";
							}	
						}
						else $message = 'Morate unijeti sve podatke pravilno.';
					}
				}
				elseif($_SERVER['REQUEST_METHOD'] == "GET" && isset($_REQUEST['id']) ) {
					$error = false;
					
					try {
						$requestedRoom = intval($_REQUEST['id']);
						$getRoomByIdStmt->bindParam(':id', $requestedRoom, PDO::PARAM_INT);
						$getRoomByIdStmt->execute();
						$room = $getRoomByIdStmt->fetch(PDO::FETCH_OBJ);
						$name = htmlentities($room->name, ENT_QUOTES);
						$price = floatval($room->price);
						$desc = htmlentities($room->description, ENT_QUOTES);

						// Load associated images
						$pics = array('noImg', 'noImg', 'noImg');
						$getRoomImageNamesStmt->bindParam(':id', $room->id, PDO::PARAM_INT);
						$getRoomImageNamesStmt->execute();
						$tmp = $getRoomImageNamesStmt->fetchAll();

						for ($i=0; $i < 3; $i++) {
							$pics[$i] = $tmp[$i]['name'];
							$imageIdList[$i] = $tmp[$i]['id'];
						}					

					}
					catch(PDOException $e) {
						$error = true;
					}	
				}

				
				if(!empty($_POST['delete'])) {		
					try {
						$requestedRoom = intval($_POST['index']);
						$deleteRoomStmt->bindParam(':id', $requestedRoom, PDO::PARAM_INT);
						$deleteRoomStmt->execute();

						echo '<div style="width=100%; text-align: center;">
								<p class="errorProv" color="#131313">Uspješno ste obrisani sobu.</p>
							  	<a href="admin_panel.php">Povratak na administracijski panel</a>
							  </div>'; 

						exit;
					}
					catch(PDOException $e) {
						$error = true;
					}
				}
				elseif(!empty($_POST['save'])) {
					$error = false;

					if(!isset($_POST['name']) || !isset($_POST['price']) || !isset($_POST['description']) 
						|| !isset($_POST['imgId00']) || !isset($_POST['imgId01']) || !isset($_POST['imgId01'])) {

						$message = "Morate unijeti sve podatke pravilno.";
					}
					else {
						$requestedRoom = intval($_POST['index']);
						$name = htmlentities($_POST['name'], ENT_QUOTES);
						$price = floatval($_POST['price']);
						$desc = htmlentities($_POST['description'], ENT_QUOTES);

						if(validateValues($name, $price, $desc)) {
							$updateRoomStmt->bindParam(':nameVal', $name, PDO::PARAM_STR);
							$updateRoomStmt->bindParam(':priceVal', $price, PDO::PARAM_STR);
							$updateRoomStmt->bindParam(':descVal', $desc, PDO::PARAM_STR);
							$updateRoomStmt->bindParam(':id', $requestedRoom, PDO::PARAM_INT);

							try {
								$updateRoomStmt->execute();

								// if new images uploaded, update matching images in tha table
								for ($i=0; $i < 3; $i++)
									if(isset($_FILES['picNo'.$i]))
										if(validateImage($_FILES['picNo'.$i]['name'])) {
											$type = pathinfo($_FILES['picNo'.$i]['tmp_name'], PATHINFO_EXTENSION);
											$data = file_get_contents($_FILES['picNo'.$i]['tmp_name']);
											$img = 'data:image/'.$type.';base64,'.base64_encode($data);

											$updateImageStmt->bindParam(':nameVal', $_FILES['picNo'.$i]['name'], PDO::PARAM_STR);
											$updateImageStmt->bindParam(':contVal', $img, PDO::PARAM_STR);
											$updateImageStmt->bindParam(':id', $_POST['imgId0'.$i], PDO::PARAM_INT);
											$updateImageStmt->execute();
										}
										else $message = "Morate unijeti sve podatke pravilno.";
								
								// Back to admin panel
								// header("Location: admin_panel.php");
								$message = "Promjene uspješno spašene";
							}
							catch(PDOException $e) {
								print_r($e);
								$error = true;
							}	
						}
						else $message = "Morate unijeti sve podatke pravilno.";
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

		<form action="roomCrud.php" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="index" value="<?php echo $requestedRoom; ?>" >
			<div class="row"><label for="name">Naziv: </label></div>
			<div class="row">
				<input type="text" name="name" value="<?php echo $name; ?>" oninput="validateName(this)">
			</div>

			<div class="row"><label for="price">Cijena: </label></div>
			<div class="row">
				<input type="number" min="0" step="0.01" name="price" value="<?php echo $price; ?>" oninput="validatePrice(this)">
			</div>

			<div class="row"><label for="description">Opis: </label></div>
			<div class="row">
				<textarea name="description" oninput="validateDescription(this)"><?php echo $desc; ?></textarea>
			</div>

			<div class="row"><label>Slike: </label></div>
			<div class="row">
				<div class="col-d-0 noDisp"></div>
				<input class="col-d-3" type="file" name="picNo0">
				<div class="col-d-1 noDisp"></div>
				<input class="col-d-3" type="file" name="picNo1">
				<div class="col-d-1 noDisp"></div>
				<input class="col-d-3" type="file" name="picNo2">
				<div class="col-d-0 noDisp"></div>
			</div>
			<div class="row">
				<div class="col-d-0 noDisp"></div>
				<p class="col-d-3" style="text-align: center;">Trenutna slika: <?php echo $pics[0] ?></p>
				<div class="col-d-1 noDisp"></div>
				<p class="col-d-3" style="text-align: center;">Trenutna slika: <?php echo $pics[1] ?></p>
				<div class="col-d-1 noDisp"></div>
				<p class="col-d-3" style="text-align: center;">Trenutna slika: <?php echo $pics[2] ?></p>
				<div class="col-d-0 noDisp"></div>
			</div>
			<div class="row">
				<div class="col-d-1 noDisp"></div>
				<input class="col-d-4" type="submit" name="<?php echo $isCreate; ?>" value="Spasi izmjene">
				<div class="col-d-2 noDisp"></div>
				<input class="col-d-4" type="submit" name="delete" value="Obriši sobu" style="display: <?php echo $displayNew; ?>">
				<div class="col-d-1 noDisp"></div>
			</div>
			<div class="row" style="text-align: center; margin: 2em;">
				<div class="row"><label><?php echo $message; ?></label></div>
				<a href="admin_panel.php">&lt;&ensp;Povratak na administracijski panel</a>
			</div>
			<input type="hidden" name="id">
			<input type="hidden" name="imgId00" value="<?php echo $imageIdList[0]; ?>">
			<input type="hidden" name="imgId01" value="<?php echo $imageIdList[1]; ?>">
			<input type="hidden" name="imgId02" value="<?php echo $imageIdList[2]; ?>">
		</form>

		<!-- Script for validation -->
		<script type="text/javascript" src="js/validation/crudValidation.js"></script>
	</body>
</html>
