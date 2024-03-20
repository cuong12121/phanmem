$(document).ready(function(){
	var i_ab =0;
	setInterval(function(){ 
		i_ab++;
		stt_ab = (i_ab%6);
		stt_ab_e = 11 - stt_ab;
		$('.item_album').removeClass('active');
		$('.item_album_'+stt_ab).addClass('active');
		$('.item_album_'+stt_ab_e).addClass('active');
	}, 1500);
});

