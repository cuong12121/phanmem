expand_filter();	
function expand_filter(){
	$('.click-mobile').click(function(e){
		var id = $(this).attr('data-id');
			$( this ).toggleClass( "active" );
			$('#'+id).toggle("slow");
	});
}
