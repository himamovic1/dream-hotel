window.onload = function() {
	closeDropdownMenu();
	load('rooms');
}

// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
// ------------------------------------------------>
//           Function for loading subpages
// ------------------------------------------------>
// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
function load(page) {
	var pageID = page;
	var pageRequest;

	if(window.XMLHttpRequest)
		pageRequest = new XMLHttpRequest();
	else
		pageRequest = new ActiveXObject('Microsoft.XMLHTTP');

	page = page + '_subpage.php';
	pageRequest.open('GET', page, true);

	pageRequest.onreadystatechange = function() {
		if(this.readyState == 4 && this.status == 200) {
			document.getElementById('mainContent').innerHTML = this.responseText;
		}
	};

	pageRequest.send();
	return false;
}

function loadScript(path) {
	var container = document.getElementById('scriptContainer');
	var script = document.createElement('script');

	var request = new XMLHttpRequest();

	request.onreadystatechange = function() {
		if(this.readyState == 4 && this.status == 200) {
			script.innerHTML = this.responseText;
			container.appendChild(script);
		}
	};

	path = 'js/' + path + '.js';
	request.open('GET', path, true);
	request.send();
}

function loadPageScripts(page) {
	switch(page) {
		case 'home':
			setSliderClickEvents();
			break;
		case 'about':
			break;
		case 'rooms':
			break;
		case 'restaurant':
			break;
		case 'booking':
			break;
		case 'gallery':
			setGalleryItemsClickEvents();
			break;
		case 'contact':
			break;
	}
}

// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
// ------------------------------------------------>
//           Functions for dropdown menu
// ------------------------------------------------>
// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
function toggleMenu() {
	var nav = document.getElementById('navbar');

	if(nav.className == 'hideNav')
		nav.className = 'showNav';
	else
		nav.className = 'hideNav';
}

function closeDropdownMenu(argument) {
	document.getElementById('navbar').className = 'hideNav';
}