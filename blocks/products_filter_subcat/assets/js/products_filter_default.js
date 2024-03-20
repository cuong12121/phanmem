$(document).ready(function(){	
	$('.field_name, .cat_title').click(function(e){
		var id = $(this).attr('data-id');
			$( this ).toggleClass( "active" );
			$('#'+id).toggle();
		
	});
});	