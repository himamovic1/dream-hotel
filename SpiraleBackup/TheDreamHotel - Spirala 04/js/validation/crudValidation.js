function validatePrice(priceInput) {
	var pattern = /^[0-9]+(\.|,)?[0-9]{0,2}$/;

	if(!pattern.test(priceInput.value)) {
		priceInput.setCustomValidity('Cijena nije validna. Cijena mora biti pozitivan broj sa do dva decimalna mjesta.');
		return false;
	}
	else 
		priceInput.setCustomValidity('');

	return true;
}

function validateName(nameInput) {
	var pattern = /^[a-zA-Z0-9 ]{1,40}$/;

	if(!pattern.test(nameInput.value)) {
		nameInput.setCustomValidity('Naziv nije u ispravnom formatu. Koristite samo slova,brojeve i razmak.');
		return false;
	}
	else 
		nameInput.setCustomValidity('');

	return true;		
}

function validateDescription(descInput) {
	var pattern = /^[a-zA-Z0-9\.,!?\s]{1,1000}$/;

	if(!pattern.test(descInput.value)) {
		descInput.setCustomValidity('Opis sobe nije u ispravnom formatu.'+
			' Koristite samo slova,brojeve, razmak i znakove interpunkcije. Opis ne smije biti prazan string.');
		return false;
	}
	else 
		descInput.setCustomValidity('');

	return true;		
}

function validatePath(pathInput) {
	var pattern = /^([a-zA-Z\-_0-9\/\:\.]*\.(jpg|jpeg|png|gif))$/;

	if(!pattern.test(pathInput.value)) {
		pathInput.setCustomValidity('Putanja nije ispravnog formata. Možete koristiti apsolutne putanje' + 
			' slika sa interneta ili relativne putanje slika koje se nalaze na lokalnom serveru.');
		return false;
	}
	else 
		pathInput.setCustomValidity('');

	return true;	
}