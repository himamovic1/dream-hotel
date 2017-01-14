<?php 
	include('aditionalScripts.php');
	session_start();
	
	if( !accessControl() ) {
		accessError();
		exit;
	}

	$msg = '';

	if(isset($_POST['download'])) {

		try {
			$database = ConnectToDatabase();
			$getAllRoomsStmt = $database->prepare('SELECT id, name, price, description FROM rooms');
			$getAllRoomsStmt->execute();

			// Load the rooms
			$rooms = $getAllRoomsStmt->fetchAll();

			// Open the .csv file and write to it
			$csvRooms = fopen("SobeTheDreamHotel.csv", 'w');

			foreach ($rooms as $room)
				fputcsv($csvRooms, array(str_replace(',', ';', htmlentities($room['name'])),
					str_replace(',', ';', htmlentities($room['price'])),
					str_replace(',', ';', htmlentities($room['description']))));

			fclose($csvRooms);
			header('Content-Type: text/csv');
		    header('Content-Disposition: attachment; filename="SobeTheDreamHotel.csv"');
		    header('Expires: 0');
		    header('Cache-Control: must-revalidate');
		    header('Pragma: public');
		    ob_clean();
		    flush();
		    readfile("SobeTheDreamHotel.csv");
		    unlink("SobeTheDreamHotel.csv");
		    exit;	
		}
		catch(PDOException $e) {
			$msg = 'Izvinjavamo se, došlo je do neočekivane greške';
		}
	}

?>

<div class="row">
		<div class="col-d-4 noDisp"></div>
		<p class="errorProv noDisp">&nbsp;</p>
		<div class="col-d-4 noDisp"></div>
	</div>
<div class="row">
	<div class="col-d-1 noDisp"></div>
	<h2 class="col-d-10 sectionHeading">Preuzimanje podataka</h2>
	<div class="col-d-1 noDisp"></div>
</div>
<div class="row">
	<div class="col-d-2 noDisp"></div>
	<p class="sectionParagraph col-d-8">
		Na ovoj stranici možete preuzeti osnovne podatke o registrovanim sobama u obliku CSV datoteke.
	</p>
	<div class="col-d-2 noDisp"></div>
</div>
<form action="download_subpage.php" method="POST">
	<div class="row">
		<div class="col-d-4 noDisp"></div>
		<input type="submit" name="download" class="button col-d-4" value="Preuzmi podatke">
		<div class="col-d-4 noDisp"></div>
	</div>
	<div class="row">
		<div class="col-d-4 noDisp"></div>
		<p class="errorProv "><?php echo $msg; ?></p>
		<div class="col-d-4 noDisp"></div>
	</div>
</form>