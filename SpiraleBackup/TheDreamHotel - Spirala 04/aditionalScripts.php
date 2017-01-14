<?php 

// 											DATABASE
// --------------------------------------------------------------------------------------------->
// Funkcija koja kreira konekciju sa bazom
function ConnectToDatabase() {
	$db = new PDO("mysql:dbname=thedreambase;host=localhost;charset=utf8", "admin", "admin");
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->exec("set names utf8");

	return $db;
}
// --------------------------------------------------------------------------------------------->

// Funkcija za sredjivanje ulaznih tekstualnih podataka
function clearInput($input) {
	return htmlentities(stripslashes(trim($input)));
}

// Funkcija za provjeru ispravnosti pristupnih podataka
function checkCredentialsAndLogin($usr, $pass) {
	if( !validateCredentials($usr) || !validateCredentials($pass))
		return false;

	// DB Connection
	$database = ConnectToDatabase();
	$loginStmt = $database->prepare('SELECT password FROM users WHERE username = :uname LIMIT 1');

	$loginStmt->bindParam(':uname', $usr);
	$loginStmt->execute();
	$result = $loginStmt->fetch(PDO::FETCH_OBJ);

	// Ako su podaci ispracni prijavljujemo administratora
	if(password_verify($pass, $result->password)) {
		$_SESSION['username'] = $usr;
		$_SESSION['role'] = 'administrator';
		return true;
	}

	return false;
}

// Funkcija koja prikazuje error provider 
function accessError() {
	echo '<div style="width=100%; text-align: center;">
			<p class="errorProv">Nemate odgovarajuca prava pristupa</p>
		  	<a href="login.php" style="font-size: 1.6em;">Povratak na stranicu za prijavu</a>
		  </div>'; 
}

// Funkcija za provjeru prava pristupa
function accessControl() {
	return isset($_SESSION['username']) && isset($_SESSION['role']) && strtolower($_SESSION['role']) == 'administrator';
}

// Funkcije za validaciju podataka koji se unose za sobe
function validateValues($name, $price, $desc, $picArray = null) {
	$regOne = preg_match('/^[a-zA-Z0-9 ]{1,40}$/', $name);
	$regTwo = preg_match('/^[0-9]+(\.|,)?[0-9]{0,2}$/', $price);
	$regThree = preg_match('/^[a-zA-Z0-9\.,!?\s]{1,1000}$/', $desc);

	$pics = false;
	if($picArray === null) $pics = true;
	else $pics = validateImage($picArray[0]) && validateImage($picArray[1]) && validateImage($picArray[2]);
	
	return ($regOne && $regTwo && $regThree && $pics);
}

function validateImage($imageName) {
	return preg_match('/^([a-zA-Z\-_0-9\/\:\.]*\.(jpg|jpeg|png))$/', $imageName);
}

// Funkcija za validaciju passworda
function validateCredentials($pass) {
	return preg_match('/^[A-Za-z0-9_\-]{3,30}$/', $pass);
}

// Funkcija za validaciju
function validateQuery($queryStr) {
	return preg_match('/^[a-zA-Z0-9\.\/-_*]+[a-zA-Z0-9\.\/-_*\s]*$/', $queryStr);
}

?>