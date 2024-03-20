$(function(){
	$("#fragment-1 #name").keyup(function(){
		var name = $(this).val();
		var data_id = $('#data_id').val();
		$.ajax({url: "index.php?module=products&view=products&task=ajax_check_name&raw=1",
			data: {name: name,data_id: data_id},
			dataType: "text",
			success: function(data) {
				if(data == 1){
					$("#fragment-1 #name").css('border','red 1px solid');
					$("#fragment-1 #help-block-name").html('Tên này đã tồn tại !');
					$("#fragment-1 #help-block-name").css('color','red');
				}else{
					$("#fragment-1 #name").css('border','#ccc 1px solid');
					$("#fragment-1 #help-block-name").html('Tên này được chấp nhận');
					$("#fragment-1 #help-block-name").css('color','#a0a0a0');
				}
			}
		});
	});

	$("#fragment-1 #code").keyup(function(){
		var code = $(this).val();
		var data_id = $('#data_id').val()
		$.ajax({url: "index.php?module=products&view=products&task=ajax_check_code&raw=1",
			data: {code: code,data_id: data_id},
			dataType: "text",
			success: function(data) {
				if(data == 1){
					$("#fragment-1 #code").css('border','red 1px solid');
					$("#fragment-1 #help-block-code").html('Mã này đã tồn tại !');
					$("#fragment-1 #help-block-code").css('color','red');
				}else{
					$("#fragment-1 #code").css('border','#ccc 1px solid');
					$("#fragment-1 #help-block-code").html('Mã này được chấp nhận');
					$("#fragment-1 #help-block-code").css('color','#a0a0a0');
				}
			}
		});
	});



	$(".input-product-parent-id input").keyup(function(){
		var name = $(this).val();
		var id = $('#data_id').val();
		// console.log(id);
		$.ajax({url: "/admin/index.php?module=products&view=products&task=ajax_get_product_name&raw=1",
			data: {name:name,id:id},
			dataType: "html",
			success: function(html) {
				if(html && html != ''){
					$('.html-product-search').html(html);
					$('.html-product-search').show();
				}else{
					$('.html-product-search').html('');
					$('.html-product-search').hide();
				}
			}
		});
	});
});

function set_parent_id(e) {
	id = $(e).attr('data-id');
	name = $(e).html();
	$('#parent_id_name').val(name);
	$('#product-parent-id').val(id);
	$('.html-product-search').hide();
}