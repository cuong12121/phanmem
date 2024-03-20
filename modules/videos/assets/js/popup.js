/* popup */
$('.item_content').click(function(e){
	var id = $(this).attr('data-id');
	$('#'+id).show();
    e.preventDefault();
});  
$('.button-close').click(function(e){
	$( this ).parent().parent().hide();
    e.preventDefault();
});