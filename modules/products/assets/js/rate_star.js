$(document).ready( function(){
	rate_star();
});
function rate_star(){
	rating_disable  = $('#rating_disable').val();
	$("#ratings").children().not(":radio").hide();
	if(rating_disable == 0){
		$("#ratings").stars({
			cancelShow: false,
			oneVoteOnly: true,
			callback: function(ui, type, value)
			{
				id = $('#product_id').val();
				$.post("/index.php?module=products&view=product&task=rating&id="+id+"&raw=1", {rate: value}, function(data)
				{
					$("#ajax_response").html(data);
				});
			}
		});
	} else {
		$("#ratings").stars({
			cancelShow: false,
			oneVoteOnly: true,
			disabled: true,
			callback: function(ui, type, value)
			{
				id = $('#product_id').val();
				$.post("/index.php?module=products&view=product&task=rating&id="+id+"&raw=1", {rate: value}, function(data)
				{
					$("#vote_grph").html(data);
				});
			}
		});
	}	
}