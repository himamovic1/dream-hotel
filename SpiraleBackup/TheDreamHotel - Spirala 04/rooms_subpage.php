<?php 
	include('aditionalScripts.php');
	session_start();
	
	if( !accessControl() ) {
		accessError();
		exit;
	}

	$database = ConnectToDatabase();
	$getAllRoomsStmt = $database->prepare('SELECT id, name, price, description FROM rooms');
	$getRoomImagesStmt = $database->prepare('SELECT name FROM images WHERE room =:id');
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

<!-- Creation Form -->
<form class="row" action="roomCrud.php" method="POST">
	<div class="col-d-3 noDisp"></div>
	<input class="button col-d-6" type="submit" name="create" value="Dodaj novu sobu">
	<div class="col-d-3 noDisp"></div>
</form>

<!-- XML to DB Migration Form -->
<form class="row" action="migrateXML.php" method="POST">
	<div class="col-d-3 noDisp"></div>
	<input class="button col-d-6" type="submit" name="xmlMigrate" value="Učitaj iz XML datoteke">
	<div class="col-d-3 noDisp"></div>
</form>

<!-- Data Display List -->
<div class="row">
	<div class="col-d-0 noDisp"></div>
	<form id="editDataForm" class="col-d-11">
		<table class="roomsTable blackOnWhite">
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

					try {
						$getAllRoomsStmt->execute();
						$rooms = $getAllRoomsStmt->fetchAll();

						foreach ($rooms as $room) {
							$name = htmlentities($room['name']);
							$price = floatval($room['price']);
							$desc = htmlentities($room['description']);
							$photoNames = array();

							$getRoomImagesStmt->bindParam(':id', $room['id'], PDO::PARAM_INT);
							$getRoomImagesStmt->execute();
							$pics = $getRoomImagesStmt->fetchAll();

							foreach ($pics as $image) 
								array_push($photoNames, $image['name']);

							// Print the data on the page
							echo '<tr>
										<td rowspan="3"><p>'.$name.'</p></td>
										<td rowspan="3"><p>'.$price.'</p></td>
										<td rowspan="3"><p>'.$desc.'</p></td>
										<td><p>'.$photoNames[0].'</p></td>
										<td style="border-bottom: none;">&nbsp;</td>
									</tr>
									<tr>
										<td><p>'.$photoNames[1].'</p></td>
										<td rowspan="2"><a class="button" href="roomCrud.php?id='.intval($room['id']).'">Edit</a></td>
									</tr>
									<tr><td><p>'.$photoNames[2].'</p></td></tr>';
						}
					}
					catch(PDOException $e) {
						echo '<tr><td colspan=5><h2 style="color: red;">Greska pri ucitavanju podataka</h2></td></tr>';
					}

				?>
			</tbody>
		</table>
	</form>
	<div class="col-d-0 noDisp"></div>
</div>