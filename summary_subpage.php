<?php 
	require('fpdf.php');
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
			$this->SetFont('Arial', 'B', 20);
			$this->Cell(30,10,'The Dream Hotel',1,0,'C');
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