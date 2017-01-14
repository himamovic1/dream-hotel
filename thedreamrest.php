<?php 
	include('aditionalScripts.php');

	// Implementation of REST web service
	function head() {
		header("{$_SERVER['SERVER_PROTOCOL']} 200 OK");
   		header('Content-Type: application/json');
    	header('Access-Control-Allow-Origin: *');
	}

	// REST methods
	function rest_get($request, $data) { 
		$roomsArray = array();
		$database = ConnectToDatabase();
		$getRoomsStmt = $database->prepare('SELECT id, name, price, description FROM rooms');
		$limitedRoomsStmt = $database->prepare('SELECT id, name, price, description FROM rooms WHERE name LIKE ?');

		$name = 'none';
		if(empty($data)) $name = 'all';
		elseif(isset($data['name'])) $name = '%'.htmlentities($data['name']).'%';
		else rest_error($request);

		$rooms = null;

		if($name === 'all') {		// GET all rooms
			$getRoomsStmt->execute();
			$rooms = $getRoomsStmt->fetchAll();
		}
		else {					// GET specified room
			$limitedRoomsStmt->bindParam(1, $name, PDO::PARAM_STR);
			$limitedRoomsStmt->execute();
			$rooms = $limitedRoomsStmt->fetchAll();
		}

		foreach ($rooms as $room) {
			$tmp = array( 
				'room' => array(
					'roomID' => htmlentities($room['id']),
					'name' => htmlentities($room['name']),
					'price' => htmlentities($room['price']),
					'description' => htmlentities($room['description'])
				)
			);

			array_push($roomsArray, $tmp);
		}

		// JSON encode and return
		$result = json_encode(array('theDreamRooms' => $roomsArray));
		print $result;
	}
	
	function rest_error($request) {
		echo '<div style="width=100%; text-align: center;">
				<p class="errorProv">Došlo je do greške!</p>
			  	<a href="index.html">Povratak na početnu stranicu</a>
			  </div>'; 
		exit;	
	}

	function rest_post($request, $data) { }
	function rest_delete($request) { }
	function rest_put($request, $data) { }

	// Method used and request submited
	$method = $_SERVER['REQUEST_METHOD'];
	$request = $_SERVER['REQUEST_URI'];

	switch ($method) {

		case 'GET':
			head();
			$data = $_GET;
			rest_get($request, $data);
			break;
		
		default:
			header("{$_SERVER['SERVER_PROTOCOL']} 404 Not Found");
			rest_error($request);
			break;
	}
?>