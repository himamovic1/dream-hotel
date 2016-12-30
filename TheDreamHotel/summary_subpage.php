<?php 
	include('aditionalScripts.php');
	session_start();
	
	if( !accessControl() ) {
		accessError();
		exit;
	}

	$msg = '';

	if(isset($_POST['download'])) {
		$roomsXml = simplexml_load_file("private/xml/hotelRooms.xml");

		if(!$roomsXml) $msg = 'Izvinjavamo se, došlo je do neočekivane greške';
		else
		{
			// Otvaramo novi csv fajl
			$csvRooms = fopen("SobeTheDreamHotel.csv", 'w');

			if(!$csvRooms) $msg = "CSV datoteka ne moze biti kreirana";
			else {
				// Prepisujemo sadrzaj i zatvorimo csv fajl
				foreach ($roomsXml->Room as $room)
					fputcsv($csvRooms, array($room->Name, $room->Price, str_replace(',', ';', $room->Description)));

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
	<h2 class="col-d-10 sectionHeading">Trenutna ponuda smještaja</h2>
	<div class="col-d-1 noDisp"></div>
</div>
<div class="row">
	<div class="col-d-2 noDisp"></div>
	<p class="sectionParagraph col-d-8">
		Na ovoj stranici možete generisati trenutnu ponudu smještaja u hotelski sobama u obliku PDF datoteke.
	</p>
	<div class="col-d-2 noDisp"></div>
</div>
<form action="download_subpage.php" method="POST">
	<div class="row">
		<div class="col-d-4 noDisp"></div>
		<input type="submit" name="generate" class="button col-d-4" value="Generiši ponudu">
		<div class="col-d-4 noDisp"></div>
	</div>
	<div class="row">
		<div class="col-d-4 noDisp"></div>
		<p class="errorProv "><?php echo $msg; ?></p>
		<div class="col-d-4 noDisp"></div>
	</div>
</form>