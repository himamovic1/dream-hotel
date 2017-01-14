<?php 
	include('aditionalScripts.php');
	session_start();
	
	if( !accessControl() ) {
		accessError();
		exit;
	}

	$database = ConnectToDatabase();
	$roomInsertStmt = $database->prepare('INSERT INTO rooms (name, price, description, creator) 
											VALUES (?, ?, ?, 1)'); 
	$imageInsertStmt = $database->prepare('INSERT INTO images (name, content, room) 
											VALUES (?, ?, ?)');
	$getRoomIdStmt = $database->prepare('SELECT id FROM rooms WHERE name =?');

	// Load the XML archive
	$roomsXml = simplexml_load_file('private/xml/hotelRooms.xml');
	
	if($roomsXml && isset($_POST['xmlMigrate'])) {
		foreach ($roomsXml->Room as $room) {
			$name = htmlentities($room->Name);
			$price = floatval($room->Price);
			$desc = htmlentities($room->Description);
			$pics = $room->Pictures->Picture;

			try {
				$roomInsertStmt->bindParam(1, $name, PDO::PARAM_STR);
				$roomInsertStmt->bindParam(2, $price, PDO::PARAM_STR);
				$roomInsertStmt->bindParam(3, $desc, PDO::PARAM_STR);
				$roomInsertStmt->execute();

				// If Unique Constraint didn't throw an exception room is inserted
				$getRoomIdStmt->bindParam(1, $name, PDO::PARAM_STR);
				$getRoomIdStmt->execute();
				$roomId = $getRoomIdStmt->fetch(PDO::FETCH_OBJ)->id;

				foreach ($pics as $image) {
					$imgName = htmlentities($image['title']);
					
					// If an image is not of valid format it's not loaded
					if(validateImage($imgName)) {
						$imageInsertStmt->bindParam(1, $imgName, PDO::PARAM_STR);
						$imageInsertStmt->bindParam(2, $image, PDO::PARAM_STR);
						$imageInsertStmt->bindParam(3, $roomId, PDO::PARAM_INT);
						$imageInsertStmt->execute();
					} 
				}
			}
			catch(PDOException $e) {
				// ERROR REPORT
			}

		} // end of xml foreach loop
	}

	// Return to the admin panel
	header('Location: admin_panel.php');
?>