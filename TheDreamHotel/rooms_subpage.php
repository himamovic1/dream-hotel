<?php 
	include('aditionalScripts.php');
	session_start();
	
	if( !accessControl() ) {
		accessError();
		exit;
	}
?>

<div class="row">
	<div class="col-d-1 noDisp"></div>
	<h2 class="col-d-10 sectionHeading">Podaci o registrovanim sobama</h2>
	<div class="col-d-1 noDisp"></div>
</div>
<div class="row">
	<div class="col-d-2 noDisp"></div>
	<p class="sectionParagraph col-d-8">
		U narednoj tabeli se nalazi podaci o sobama koje mozete ažurirati,
		te možete brisati i dodavati nove sobe. Ut enim ad minim veniam,
		quis nostrud exercitation ullamco laboris nisi ut aliquip.
	</p>
	<div class="col-d-2 noDisp"></div>
</div>

<div class="row">
	<div class="col-d-0 noDisp"></div>
	<form id="editDataForm" class="col-d-11">
		<table class="roomsTable col-d-11 blackOnWhite">
			<thead>
				<tr>
					<th><p>Naziv</p></th>
					<th><p>Cijena</p></th>
					<th><p>Opis</p></th>
					<th><p>Slike</p></th>
					<th><p>Izmjene</p></th>
				</tr>
			</thead>
			<tbody>
				<!-- Script for loading room data -->
				<?php 

					$roomsXml = simplexml_load_file('private/xml/hotelRooms.xml');

					if($roomsXml) {
						$count = 0;

						// Povucemo sve sobe i odgovaracuje podatke iz xml fajla
						foreach ($roomsXml->Room as $room) {
							$name = htmlentities($room->Name);
							$price = htmlentities($room->Price);
							$desc = htmlentities($room->Description);
							$pics = $room->Pictures->Picture;

							// Ispisujemo podatke u tabelu
							echo '<tr>
										<td rowspan="3"><p>'.$name.'</p></td>
										<td rowspan="3"><p>'.$price.'</p></td>
										<td rowspan="3"><p>'.$desc.'</p></td>
										<td><p>'.$pics[0].'</p></td>
										<td style="border-bottom: none;">&nbsp;</td>
									</tr>
									<tr>
										<td><p>'.$pics[1].'</p></td>
										<td rowspan="2"><a class="button" href="roomCrud.php?id='.$count.'">Edit</a></td>
									</tr>
									<tr><td><p>'.$pics[2].'</p></td></tr>';

							$count = $count + 1;
						}
					}
					else {
							echo '<tr><td colspan=5><h2 style="color: red;">Greska pri ucitavanju podataka</h2></td></tr>';
					}
				?>
			</tbody>
		</table>
	</form>
	<div class="col-d-0 noDisp"></div>
</div>

<form class="row" action="roomCrud.php" method="POST">
	<div class="col-d-3 noDisp"></div>
	<input class="button col-d-6" type="submit" name="create" value="Dodaj novu sobu">
	<div class="col-d-3 noDisp"></div>
</form>