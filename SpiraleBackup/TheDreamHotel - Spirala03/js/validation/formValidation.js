// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
// ------------------------------------------------>
// 			 General validation function
// ------------------------------------------------>
// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
function validateName(nameInput) {
	var pattern = /^[a-zA-Z]{2,25} [a-zA-Z]{2,30}$/;

	if(!pattern.test(nameInput.value)) {
		nameInput.setCustomValidity('Ime i prezime nije u ispravnom formatu. Koristite samo slova i razmak.');
		return false;
	}
	else 
		nameInput.setCustomValidity('');

	return true;		
}

function validateTelephone(phoneInput) {
	var pattern = /^[0-9]{3,5}\/[0-9]{3}-[0-9]{3}$/;

	if(!pattern.test(phoneInput.value)) {
		phoneInput.setCustomValidity('Broj telefona nije validan. Unesite broj u formatu "00000/000-000".');
		return false;
	}
	else 
		phoneInput.setCustomValidity('');

	return true;
}

// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
// ------------------------------------------------>
// 			   Date validation functions
// ------------------------------------------------>
// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
function checkDate(dateString) {
	var daysPerMonth = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
	var date = dateString.split('-'); // 0 - year 1 - month 2 - day

	var year = parseInt(date[0]);
	var month = parseInt(date[1]) - 1;
	var day = parseInt(date[2]);
	var today = new Date();

	return !(year < today.getFullYear() || year > 2100 
			|| month < today.getMonth() || month > 12 
			|| day < today.getDate() || day > daysPerMonth[month]);
}

function validateDate(dateInput) {
	if(!checkDate(dateInput.value)) {
		dateInput.setCustomValidity('Datum nije validan.');
		return false;
	}
	else 
		dateInput.setCustomValidity('');

	return true;
}

function validateDateLocal(dateInput) {
	var dateTime = dateInput.value.split('T');

	if(!checkDate(dateTime[0])) {
		dateInput.setCustomValidity('Uneseni termin rezervacije nije validan. Molimo unesite ponovo.');
		return false;
	}
	else 
		dateInput.setCustomValidity('');

	// working hours 09:00 - 23:00
	var time = dateTime[1].split(':');
	var hours = parseInt(time[0]);
	var minutes = parseInt(time[1]);

	if(hours < 9 || hours > 23 || minutes < 0 || minutes > 59) {
		dateInput.setCustomValidity('Vrijeme rezervacije nije validno. Radno vrijeme je od 9h do 23h.');
		return false;
	}
	else 
		dateInput.setCustomValidity('');
}

// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
// ------------------------------------------------>
//  Special validation function for "booking" form
// ------------------------------------------------>
// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
function validateBooking() {
	var bookingForm = document.getElementById('bookingForm');

	// projvera da li je datum odlaska nakon datuma dolaska
	var arrival = new Date(bookingForm.arrivalDate.value);
	var departure = new Date(bookingForm.departureDate.value);

	if(!(departure > arrival)) {
		bookingForm.departureDate.setCustomValidity('Datum odlaska mora biti nakon datuma dolaska!');
		return false;
	}
	else 
		bookingForm.departureDate.setCustomValidity('');
		
	return true;
}