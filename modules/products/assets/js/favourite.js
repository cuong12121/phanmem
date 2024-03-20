function buy_add(product_id){
	var  price = parseInt($('#price_calculator').val());
	link = root + 'index.php?module=products&view=cart&task=buy&id='+product_id;
	id_add  = '';
	i = 0;

	var warranty =parseInt($('#warranty').val());
	if(!warranty){
		warranty = 1;
	}
	link += '&warranty='+warranty; 
	if(id_add){
		link += '&add='+id_add
	}
	window.location = link;
}
