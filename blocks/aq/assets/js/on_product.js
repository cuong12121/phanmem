$('.item_top').click(function(){
	data_id = $(this).attr('data-id');
	$('.col5').addClass('hide');
	$('#col5_'+data_id).slideToggle();
})