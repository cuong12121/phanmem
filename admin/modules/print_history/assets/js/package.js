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
				console.log(data);
				if(data.error==false){
					$('.btn-row-shoot-'+id).addClass('hide');
					$('.content-shoot-'+id).removeClass('hide');
				}
			}
		});
	}
}

function is_package(id){
	if(confirm('Bạn có chắc chắn xác nhận đóng hàng ?')){
		$.ajax({
			url: "/admin/index.php?module=packages&view=package&task=ajax_package&raw=1",
			data: {id:id},
			dataType: "json",
			success: function(data) {
				console.log(data);
				if(data.error==false){
					$('.btn-row-package-'+id).addClass('hide');
					$('.content-package-'+id).removeClass('hide');
				}
			}
		});
	}
}
	
