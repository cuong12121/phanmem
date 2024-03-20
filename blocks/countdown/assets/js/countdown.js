var time = $('#deal_time').val();
var austDay = new Date(time);
	$('#countdown_here').countdown({until: austDay, compact: true, description: ''});