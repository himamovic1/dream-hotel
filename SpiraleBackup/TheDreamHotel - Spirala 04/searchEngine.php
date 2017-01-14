<?php 
	include('aditionalScripts.php');
	session_start();
	
	if( !accessControl() ) {
		accessError();
		exit;
	}

	if( isset($_GET['query']) && isset($_GET['max']) ) {
		$queryStr = htmlentities($_GET['query']);
		$resCount = intval($_GET['max']);
		$results = array('');
		$hits = 0;

		// To prevent some leftover results 
		if(strlen($queryStr) < 1) {
			echo '';
			exit;
		}

		try {
			// Database connection and query statement
			$database = ConnectToDatabase();
			$queryStmt = 'nope';

			if($resCount > 0) {		// Limited search
				$queryStmt = $database->prepare('SELECT id, name, description 
															FROM rooms 
															WHERE 
																name LIKE :queryStr
																OR
																description LIKE :queryStr
															ORDER BY 2 ASC
															LIMIT :maxLimit');

				$queryStmt->bindParam(':maxLimit', $resCount, PDO::PARAM_INT);
			}
			else {					// Unlimited search
				$queryStmt = $database->prepare('SELECT id, name, description 
													FROM rooms 
													WHERE 
														name LIKE :queryStr
														OR
														description LIKE :queryStr
													ORDER BY 2 ASC');
			}

			$queryStr = '%'.$queryStr.'%';
			$queryStmt->bindParam(':queryStr', $queryStr, PDO::PARAM_STR);
			$queryStmt->execute();
			$rooms = $queryStmt->fetchAll();

			$hits = 0;
			foreach ($rooms as $room) {
				array_push($results, '<p class="blackOnWhite searchHint">'.htmlentities($room['name']).'</p>');
				$hits = $hits + 1;
			}

			if( $hits > 0 )
				echo '<p class="whiteOnBlack searchHeadline">Sobe koje odgovaraju pretrazi:</p>'.implode('', $results);
			else
				echo '<p class="whiteOnBlack searchHeadline">Nema rezultata</p>';
			
		}
		catch(PDOException $e) {
			echo '<p class="whiteOnBlack searchHeadline">Servis nije trenutno dostupan'.$e.'</p>';
		}

	}
	

?>