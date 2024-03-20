window.onload = function () {
	var container = $('div.sliderGallery');
	var ul = $('ul', container);
	var width_ul=0;
	var itemsWidth = ul.innerWidth() - container.outerWidth();
	$('.slider', container).slider({
		min: 0,
		max: itemsWidth,
		handle: '.handle',
		stop: function (event, ui) {
			ul.animate({'left' : ui.value * -1}, 500);
		},
		slide: function (event, ui) {
			ul.css('left', ui.value * -1);
		}
	});
};
