$(document).ready(function(){

	$('.morecate').click(function(e){
		$('.filter-manufactory a').removeClass('hidden');
		$('.morecate').addClass('hidden');

	});

		$('.fewcate').click(function(e){
		$('.filter-manufactory .limit').addClass('hidden');
		$('.fewcate').addClass('hidden');
		$('.morecate').removeClass('hidden');
	});


	$('.filter-manufactory .icon').click(function(e){
		$('.filter-manufactory .link_filter').slideToggle('hidden');
		$(this).toggleClass('rotateam90deg');
	});



});	