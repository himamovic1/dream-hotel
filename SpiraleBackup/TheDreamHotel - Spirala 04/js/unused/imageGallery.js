// jQuery varijanta
$(document).ready(function() {
	// click na sliku otvara istu preko cijelog ekrana 
	$('.galleryItem').click(function() {
		var imgSource = $(this).find('img').attr('src');
		$('#imgFrame img').attr('src', imgSource);
		$('#imgFrameWrapper').fadeIn();
	});
	
	// zatvaranje na klik
	$('#imgFrameWrapper').click(function() {
		$(this).fadeOut();
	})

	// zatvaranje na esc
	document.onkeydown = function(arg) {
		if(arg.keyCode == 27)
			$('#imgFrameWrapper').fadeOut();
	};
});