$(document).ready(function() {

	var listLength = $('#sliderWrapper ul li').length;

	/* setting the base z-index */
	$('#sliderWrapper ul li').each(function(i, li) {
		$(li).css('z-index', listLength-i-1);
	});

	/* next image just floats up the stack */
	function nextSlide() {
		$('#sliderWrapper ul li').each(function(i, li) {
			var item = $(li);
			var z = (item.css('zIndex') + 1) % listLength;
			item.css({zIndex: z});
		});
	};

	function previousSlide() {
		$('#sliderWrapper ul li').each(function(i, li) {
			var item = $(li);
			var z = item.css('zIndex') - 1;
			z = (z < 0) ? listLength-1 : z; 
			item.css({zIndex: z});
		})
	};

	/* setting up the event handlers */
	$('#nextSlide').click(function() {
		nextSlide();
	});

	$('#prevSlide').click(function() {
		previousSlide();
	});

});