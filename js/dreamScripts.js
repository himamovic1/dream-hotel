// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
// ------------------------------------------------>
//          window-onload event functions
// ------------------------------------------------>
// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
window.onload = function() {
	closeDropdownMenu();	
	setSliderClickEvents();
	setGalleryItemsClickEvents();
}

// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
// ------------------------------------------------>
//      Function for main slider on home page
// ------------------------------------------------>
// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
function setInitialZIndex() {
	var items = document.getElementById('sliderList').getElementsByTagName('li');

	for (var i = 0; i < items.length; i++) {
		items[i].style.zIndex = (items.length-i-1).toString();
	}
}

/* next image just floats up the stack */
function nextSlide() {
	var items = document.getElementById('sliderList').getElementsByTagName('li');

	for (var i = 0; i < items.length; i++) {
		items[i].style.zIndex = ((items[i].style.zIndex + 1)%items.length).toString();
	}
}

function previousSlide() {
	var items = document.getElementById('sliderList').getElementsByTagName('li');

	for (var i = 0; i < items.length; i++) {
		var z = items[i].style.zIndex - 1;
		z = (z < 0) ? items.length-1 : z;
		items[i].style.zIndex = (z).toString();
	}
}

function setSliderClickEvents(argument) {
	setInitialZIndex();

	document.getElementById('nextSlide').addEventListener('click', function() {
		nextSlide();
	});

	document.getElementById('prevSlide').addEventListener('click', function() {
		previousSlide();
	});
}

// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
// ------------------------------------------------>
//    Function for gallery items on gallery page
// ------------------------------------------------>
// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
function openGallery(item) {
	var imgSource = item.childNodes[1].src;
	document.querySelector('#imgFrame img').src = imgSource;
	fadeIn(document.getElementById('imgFrameWrapper'));
}

function closeGallery() {
	fadeOut(document.getElementById('imgFrameWrapper'));
}

function fadeIn(item) {
	setTimeout(function() { item.style.opacity = '1'; }, 100);
	item.style.display = 'block';
}

function fadeOut(item) {
	item.style.opacity = '0';
	setTimeout(function(){ item.style.display = 'none'; }, 800);
}

function setGalleryItemsClickEvents() {
	
	/*
	var galleryItems = document.getElementsByTagName('figure');

	for (var i = 0; i < galleryItems.length; i++) {
		var item = galleryItems[i];

		item.addEventListener('click', function() {
			openGallery(item);
		});
	}
	*/

	// For closing full screen view on 'esc' button click
	document.onkeydown = function(arg) {
		if(arg.keyCode == 27)
			fadeOut(document.getElementById('imgFrameWrapper'));
	};
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