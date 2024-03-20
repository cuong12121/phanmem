$(document).ready( function(){
	rate_star_design();
	rate_star_features();
	rate_star_performance();
});
function rate_star_design(){
	rating_disable  = $('#rating_disable_design').val();
	$("#ratings_design").children().not(":radio").hide();
	if(rating_disable == 0){
		$("#ratings_design").stars({
			cancelShow: false,
			oneVoteOnly: true,
			callback: function(ui, type, value)
			{
				id = $('#record_id').val();
				$.post("/index.php?module=products&view=product&task=rating_design&id="+id+"&raw=1", {rate: value}, function(data)
				{
					$("#ajax_response").html(data);
				});
			}
		});
	} else {
		$("#ratings_design").stars({
			cancelShow: false,
			oneVoteOnly: true,
			disabled: true,
			callback: function(ui, type, value)
			{
				id = $('#record_id').val();
				$.post("/index.php?module=products&view=product&task=rating_design&id="+id+"&raw=1", {rate: value}, function(data)
				{
					$("#vote_grph").html(data);
				});
			}
		});
	}	
}
function rate_star_features(){
	rating_disable  = $('#rating_disable_features').val();
	$("#ratings_features").children().not(":radio").hide();
	if(rating_disable == 0){
		$("#ratings_features").stars({
			cancelShow: false,
			oneVoteOnly: true,
			callback: function(ui, type, value)
			{
				id = $('#record_id').val();
				$.post("/index.php?module=products&view=product&task=rating_features&id="+id+"&raw=1", {rate: value}, function(data)
				{
					$("#ajax_response").html(data);
				});
			}
		});
	} else {
		$("#ratings_features").stars({
			cancelShow: false,
			oneVoteOnly: true,
			disabled: true,
			callback: function(ui, type, value)
			{
				id = $('#record_id').val();
				$.post("/index.php?module=products&view=product&task=rating_features&id="+id+"&raw=1", {rate: value}, function(data)
				{
					$("#vote_grph").html(data);
				});
			}
		});
	}	
}
function rate_star_performance(){
	rating_disable  = $('#rating_disable_performance').val();
	$("#ratings_performance").children().not(":radio").hide();
	if(rating_disable == 0){
		$("#ratings_performance").stars({
			cancelShow: false,
			oneVoteOnly: true,
			callback: function(ui, type, value)
			{
				id = $('#record_id').val();
				$.post("/index.php?module=products&view=product&task=rating_performance&id="+id+"&raw=1", {rate: value}, function(data)
				{
					$("#ajax_response").html(data);
				});
			}
		});
	} else {
		$("#ratings_performance").stars({
			cancelShow: false,
			oneVoteOnly: true,
			disabled: true,
			callback: function(ui, type, value)
			{
				id = $('#record_id').val();
				$.post("/index.php?module=products&view=product&task=rating_performance&id="+id+"&raw=1", {rate: value}, function(data)
				{
					$("#vote_grph").html(data);
				});
			}
		});
	}	
}