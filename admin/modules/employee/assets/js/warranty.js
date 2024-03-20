$(function() {
	$( "#text0" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy'});
	$( "#text1" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy'});
	$(".close_pu").click(function(){
		$(".popup_change").hide();
	});

	$("#btn_change_warehouses").click(function(){
		if(confirm('Bạn có chắc chắn duyệt đổi sản phẩm cho khách ?')){
			var id = $("#id_change_warehouses").val();
			var warehouses_id = $("#change_warehouses").val();
			$.ajax({
				url: "/admin/index.php?module=warranty&view=warranty&task=ajax_warranty_change&raw=1",
				data: {id:id,warehouses_id:warehouses_id},
				dataType: "json",
				success: function(data) {
					if(data.error==false){
						$('.btn-change-'+id).addClass('hide');
						$('.ct-change-'+id).html(data.message);
						$(".popup_change").hide();
					}else{
						alert(data.message);
						$(".popup_change").hide();
					}
				}
			});
		}
	});

	$("#btn_change_return").click(function(){
		if(confirm('Bạn có chắc chắn duyệt trả sản phẩm ("Đồng ý" thì số lượng sẽ được cộng cho kho chọn) ?')){
			var id = $("#id_change_warehouses").val();
			var warehouses_id = $("#change_warehouses").val();
			$.ajax({
				url: "/admin/index.php?module=warranty&view=warranty&task=ajax_return&raw=1",
				data: {id:id,warehouses_id:warehouses_id},
				dataType: "json",
				success: function(data) {
					if(data.error==false){
						$('.btn-return-'+id).addClass('hide');
						$('.ct-return-'+id).html(data.message);
						$(".popup_change").hide();
					}else{
						alert(data.message);
						$(".popup_change").hide();
					}
				}
			});
		}
	});
});

function is_change(id){
	$(".popup_change").show();
	$("#id_change_warehouses").val(id);
	$("#btn_change_warehouses").show();
	$("#btn_change_return").hide();
}

function is_return(id){
	$(".popup_change").show();
	$("#id_change_warehouses").val(id);
	$("#btn_change_warehouses").hide();
	$("#btn_change_return").show();
}


function is_warranty_accept(id){
	if(confirm('Bạn có chắc chắn mang đi sửa ?')){
		$.ajax({
			url: "/admin/index.php?module=warranty&view=warranty&task=ajax_warranty_accept&raw=1",
			data: {id:id},
			dataType: "json",
			success: function(data) {
				if(data.error==false){
					$('.btn-warranty-accept-'+id).addClass('hide');
					$('.ct-warranty-'+id).html(data.message);
				}else{
					alert(data.message);
				}
			}
		});
	}
}


function is_warranty_return(id){
	if(confirm('Bạn có chắc chắn đã sửa xong ?')){
		$.ajax({
			url: "/admin/index.php?module=warranty&view=warranty&task=ajax_warranty_return&raw=1",
			data: {id:id},
			dataType: "json",
			success: function(data) {
				if(data.error==false){
					$('.btn-warranty-return-'+id).addClass('hide');
					$('.ct-warranty-'+id).html(data.message);
				}else{
					alert(data.message);
				}
			}
		});
	}
}
	
