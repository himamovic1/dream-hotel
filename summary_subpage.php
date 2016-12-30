<?php 
	require('fpdf1.81/fpdf.php');
	include('aditionalScripts.php');
	session_start();
	
	if( !accessControl() ) {
		accessError();
		exit;
	}

	$msg = '';

	/**
	*  Klasa za kreiranje PDF izvještaja
	*/
	class PDF extends FPDF
	{
		// Header
		function header() {
			// Logo
			$this->SetFont('Arial', 'B', 20);
			$this->Cell(70, 10, 'The Dream Hotel', 0, 0);
			$this->SetX(170);

			// Datum
			$this->SetFont('Arial', 'I', 18);
			$this->Cell(30, 10, date('d.m.Y'), 0, 1, 'R');
			$this->Line(10, 22, 200, 22);
			$this->Ln();
		}

		// Footer
		function footer() {
			// Linija koja odvaja footer
			$this->Line(10, 277, 200, 277);

			// contact data
			$this->SetY(278);
			$this->SetFont('Arial', 'I', 10);
			$this->Cell(0, 10, 'Email: info@thedream.com | booking@thedream.com', 0, 0, 'L');

			$this->putHiperlink(155, 278, 'http://dream-hotel-dream-hotel.44fs.preview.openshiftapps.com/',
				'thedreamhotel.com');

			$this->SetXY(80, 278);
			$this->SetFont('Arial', 'I', 10);
			$this->Cell(0,10, $this->PageNo().' / {nb}',0,0, 'C');
		}

		// Funkcija koja upisuje hiperlink u dokument
		function putHiperlink($x, $y, $URL, $txt) {
			$this->SetXY($x, $y);
		    $this->SetTextColor(0,0,255);
		    $this->Write(10, $txt, $URL);
		    $this->SetTextColor(0);
		}

		// Funkcija koja kreira naslov na stranici
		function createHeading($x, $y, $heading) {
			$this->SetXY($x, $y);
			$this->SetFont('Arial', 'B', 20);
			$this->Cell(190, 20, strtoupper($heading), 0, 1, 'C');
		}

		// Funkcija koja ispisuje podatke o sobi
		function putRoom($name, $price, $desc) {
			$x = 20;
			$y = $this->GetY();
			$this->SetXY($x, $y);
			$this->SetFont('Arial', '', 12);

			$this->Cell(190, 10, strtoupper($name), 0, 0);

			$this->SetX(170);
			$this->Cell(0, 10, 'Cijena: '.$price.'KM / noc', 0, 1, 'R');
			$this->Line(20, $y+8, 190, $y+8);

			// Opis
			$this->MultiCell(170, 5, $desc, 0);
			$this->Ln();
		}

		// Funkcija koja prepisuje podatke iz datog XML fajla u PDF
		function generateFromXML($xmlPath) {
			$this->AliasNbPages();
			$this->AddPage();
			$this->createHeading(10, 30, 'The Dream hotelske sobe');
			$this->Ln(3);
			$this->SetMargins(20, 5);

			// Ucitavanje XML datoteke
			if(file_exists($xmlPath)) {
				$roomsXml = simplexml_load_file($xmlPath);
				if(!$roomsXml) 
					$this->Cell(50, 10, 'Arhiva nedostupna... Pokusajte kasnije...', 1, 1, 'C');
				else {
					// Upisemo sve sobe u PDF
					foreach ($roomsXml->Room as $room)
						$this->putRoom(htmlentities($room->Name), htmlentities($room->Price), htmlentities($room->Description));
				}
			}
		}

	} // End of class "PDF";

	if(isset($_POST['generate'])) {
		$report = new PDF();
		$report->generateFromXML('private/xml/hotelRooms.xml');
		$report->Output('I', 'sobeIzvjestaj.pdf', true);
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
<form action="summary_subpage.php" method="POST">
	<div class="row">
		<div class="col-d-4 noDisp"></div>
		<input type="submit" name="generate" class="button col-d-4" value="Generiši izvještaj">
		<div class="col-d-4 noDisp"></div>
	</div>
	<div class="row">
		<div class="col-d-4 noDisp"></div>
		<p class="errorProv "><?php echo $msg; ?></p>
		<div class="col-d-4 noDisp"></div>
	</div>
</form>