function toggleMenu() {
	var nav = document.getElementById('navbar');

	if(nav.className == 'hideNav')
		nav.className = 'showNav';
	else
		nav.className = 'hideNav';
}