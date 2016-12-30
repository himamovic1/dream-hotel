window.onload = function() {
	document.getElementById('burgerNav').addEventListener('click', toggleMenu);
}

function toggleMenu() {
	var nav = document.getElementById('navbar');
	console.log(nav.className);

	if(nav.className == 'hideNav')
		nav.className = 'showNav';
	else
		nav.className = 'hideNav';
}