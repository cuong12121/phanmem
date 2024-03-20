on_change_select(1);
function on_change_select(){
	$('.breadcrumb_item').change(function() {
		var value=$(this).val();
		if(value){
			location.href=value;
		}
	});
}