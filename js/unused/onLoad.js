// Postavlja sve potrebne funkcije koje se aktiviraju na load prozora
window.onload = function() {
	document.onkeydown = function(arg) {
		if(arg.keyCode == 27)
			document.getElementById('imgFrameWrapper').style.display = 'none';
	};

	// postavlja evente za slider
	document.getElementById('nextSlide').addEventListener('click', function() {
		nextSlide();
	});

	document.getElementById('prevSlide').addEventListener('click', function() {
		previousSlide();
	})
};

// ------------------------------------------->
//    Function for main slider on home page
// ------------------------------------------->
function setInitialZIndex() {
	var items = document.querySelector('#sliderWrapper ul').childNodes;

	for (var i = 0; i < items.length; i++) {
		items[i].style.zIndex = (items.length-i-1).toString();
	}
}

/* next image just floats up the stack */
function nextSlide() {
	var items = document.querySelector('#sliderWrapper ul').childNodes;

	for (var i = 0; i < items.length; i++) {
		items[i].style.zIndex = ((items[i].style.zIndex + 1)%items.length).toString();
	}
}

function previousSlide() {
	var items = document.querySelector('#sliderWrapper ul').childNodes;

	for (var i = 0; i < items.length; i++) {
		var z = items[i].style.zIndex - 1;
		z = (z < 0) ? items.length-1 : z;
		items[i].style.zIndex = (z).toString();
	}
}

// ----------------------------------------------->
//   Functions for image gallery on Gallery page
// ----------------------------------------------->
function openGallery(item) {
	var imgSource = item.childNodes[1].src;
	document.querySelector('#imgFrame img').src = imgSource;
	fadeIn(document.getElementById('imgFrameWrapper'));
}

function closeGallery() {
	fadeOut(document.getElementById('imgFrameWrapper'));
}

function fadeIn(item) {
	setTimeout(function() { item.style.opacity = '1'; }, 400);
	item.style.display = 'block';
}

function fadeOut(item) {
	item.style.opacity = '0';
	setTimeout(function(){ item.style.display = 'none'; }, 800);
}