<?php 

// Funkcija za sredjivanje ulaznih tekstualnih podataka
function clearInput($input) {
	return htmlspecialchars(stripslashes(trim($input)));
}

// Funkcija za provjeru ispravnosti pristupnih podataka
function checkCredentialsAndLogin($usr, $pass) {
	if( !validateCredentials($usr) || !validateCredentials($pass))
		return false;

	$usersXmlPath = 'private/xml/registeredUsers.xml';

	if( file_exists($usersXmlPath) ) {
		$userCollection = simplexml_load_file($usersXmlPath);

		if($userCollection) {
			$usr = clearInput($usr);
			$pass = clearInput($pass);

			// maybe check for validitiy of credentials

			foreach ($userCollection as $singleUser) {
				if ($singleUser->Username == $usr && $singleUser->Password == $pass) {
					$_SESSION['username'] = $usr;
					$_SESSION['role'] = strtolower($singleUser->Role);
					return true;
				}		
			}
		}
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
function validateValues($name, $price, $desc, $picArray) {
	$regOne = preg_match('/^[a-zA-Z0-9 ]{1,40}$/', $name);
	$regTwo = preg_match('/^[0-9]+(\.|,)?[0-9]{0,2}$/', $price);
	$regThree = preg_match('/^[a-zA-Z0-9\.,!?\s]{1,1000}$/', $desc);

	$pics = validateLink($picArray[0]) && validateLink($picArray[1]) && validateLink($picArray[2]);
	return ($regOne && $regTwo && $regThree && $pics);
}

function validateLink($link) {
	return preg_match('/^([a-zA-Z\-_0-9\/\:\.]*\.(jpg|jpeg|png|gif))$/', $link);
}

// Funkcija za validaciju passworda
function validateCredentials($pass) {
	return preg_match('/^[A-Za-z0-9_\-]{3,30}$/', $pass);
}

?>