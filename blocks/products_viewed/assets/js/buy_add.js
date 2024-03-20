function buy_add(id){
	var buy_count    = $('#buy_count').val();
	
	var link = '/index.php?module=products&view=cart&task=buy_multi&raw=1&id='+id+'&buy_count='+buy_count;
	window.location.href = link;

}