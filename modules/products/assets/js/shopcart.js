function add_cart(product_id,quantity){
	$.ajax({url: '/index.php?module=products&view=cart&task=ajax_buy&raw=1',
        type : 'POST',
        dataType: 'json',  
		  data: {id: product_id,quantity:quantity},
		  success : function(data){
			  	var total_price = data.total_price;
				var quantity = data.quantity;
				var html = data.html;
				$('.shopcart_popup_total .price_area .price').html(total_price);
				$('.shopcart_popup_total .quantity_area .quantity').html(quantity);
				$('.shopcart_popup_items_inner').html(html);
				$('.shopcart .count font').html(quantity);
				$('.shopcart_alert').slideToggle( "slow");
			  
		  }
	});
}
function close_shopcart_popup(){
	$('.shopcart_alert').slideToggle( "slow");
}