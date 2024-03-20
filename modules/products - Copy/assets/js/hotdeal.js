$(document).ready(function() {
	$('.view-more-cat span').click(function(){
		var id = $(this).attr('data-id');
		$('.product_grid .item-'+id).removeClass('display-off').addClass('display-open');
	});
});	