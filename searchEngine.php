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

		// Ucitamo xml datoteku
		$roomsXml = simplexml_load_file('private/xml/hotelRooms.xml');
		if($roomsXml && strlen($queryStr) > 0)	
			foreach ($roomsXml->Room as $room)
				if( stristr(htmlentities($room->Name), $queryStr) || stristr(htmlentities($room->Description), $queryStr) ) {
					$hits = $hits + 1;
					array_push($results, '<p class="blackOnWhite searchHint">'.htmlentities($room->Name).'</p>');
					if($hits == $resCount) break;
				}
		
		if( $hits > 0 )
			echo '<p class="whiteOnBlack searchHeadline">Sobe koje odgovaraju pretrazi:</p>'.implode('', $results);
		else
			echo '<p class="whiteOnBlack searchHeadline">Nema rezultata</p>';

	}
	

?>