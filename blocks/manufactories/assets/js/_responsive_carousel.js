$(function() {

//	create carousel
$('#carousel').carouFredSel({
	responsive: true,
	items: {
		width: 200,
		height: '60%',
		visible: 7
	},
	auto: {
		items: 0
	},
	prev: '#prev',
	next: '#next'
});

//	re-position the carousel, vertically centered
var $elems = $('#wrapper, #prev, #next'),
	$image = $('#carousel img:first')

$(window).bind( 'resize.example', function() {
	var height = $image.outerHeight( true );

	$elems
		.height( height )
		.css( 'marginTop', -( height/2 ) );

}).trigger( 'resize.example' );

});