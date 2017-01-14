function validateCredentials(credInput) {
	var pattern = /^[A-Za-z0-9_\-*]{3,30}$/;

	if(!pattern.test(credInput.value)) {
		credInput.setCustomValidity('Neispravan format. Podatak mora biti dužine između 3 i 30 znakova.'+
			' Smijete koristi velika i mala slova, brojeve, te dodatne znakove -, _, i *.');
		return false;
	}
	else 
		credInput.setCustomValidity('');

	return true;
}
