$(function() {
	$( "#text0" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy'});
	$( "#text1" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy'});
});


function is_shoot(id){
	if(confirm('Bạn có chắc chắn muốn bắn ra kho ?')){
		$.ajax({
			url: "/admin/index.php?module=order_items&view=items&task=ajax_add_shoot&raw=1",
			data: {id:id},
			dataType: "json",
			success: function(data) {
				if(data.error==false){
					$('.btn-row-shoot-'+id).addClass('hide');
					$('.content-shoot-'+id).removeClass('hide');
				}else{
					alert(data.message);
				}
			}
		});
	}
}

function is_refund(id){
	if(confirm('Bạn có chắc chắn muốn hoàn hàng ?')){
		$.ajax({
			url: "/admin/index.php?module=order_items&view=items&task=ajax_add_refund&raw=1",
			data: {id:id},
			dataType: "json",
			success: function(data) {
				console.log(data);
				if(data.error==false){
					$('.btn-row-refund-'+id).addClass('hide');
					$('.content-refund-'+id).removeClass('hide');
					$('.btn-row-shoot-'+id).addClass('hide');
				}else{
					alert(data.message);
				}
			}
		});
	}
}
	
