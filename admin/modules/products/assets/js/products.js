$(function(){
	$("#fragment-1 #name").keyup(function(){
		var name = $(this).val();
		var data_id = $('#data_id').val();
		$.ajax({url: "/admin/index.php?module=products&view=products&task=ajax_check_name&raw=1",
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
		$.ajax({url: "/admin/index.php?module=products&view=products&task=ajax_check_code&raw=1",
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
		$.ajax({
			url: "/admin/index.php?module=products&view=products&task=ajax_get_product_name&raw=1",
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

	$("#fragment-1 #type_id").change(function(){
		var id = $(this).val();
		if(id == 9){
			$('.row-code-combo').removeClass('hide');
		}else{
			$('.row-code-combo').addClass('hide');
		}
	});
	
});

function set_parent_id(e) {
	id = $(e).attr('data-id');
	name = $(e).html();
	$('#parent_id_name').val(name);
	$('#product-parent-id').val(id);
	$('.html-product-search').hide();
}


function show_all_image(id){
	$.ajax({
		url: "/admin/index.php?module=products&view=products&task=ajax_show_all_image&raw=1",
		data: {id:id},
		dataType: "json",
		success: function(data) {
			if(data.error == false){
				$('#popup-image .show-html').html(data.html);
				$('#popup-image').show();
				$('.modal-menu-full-screen').show();
			}
		}
	});
}


function close_popup(){
	$('.popup-page-list').hide();
	$('.modal-menu-full-screen').hide();
}

$('.modal-menu-full-screen').click(function(){
	$('.popup-page-list').hide();
	$('.modal-menu-full-screen').hide();
});

function show_info_product(id){
	$('.tabs-info .tab').removeClass('active_tab');
	$('.tabs-info .tab1').addClass('active_tab');
	$.ajax({
		url: "/admin/index.php?module=products&view=products&task=ajax_show_info_product&raw=1",
		data: {id:id},
		dataType: "html",
		success: function(html) {
			if(html){
				$('#show_info_product .contents-info').html(html);
				$('#show_info_product').show();
				$('.modal-menu-full-screen').show();
			}
		}
	});
}

function show_tab_content(e){
	var id = $(e).attr('data-id');
	$('.content-t').addClass('hide');
	$('#content-t'+id).removeClass('hide');
	$('.tabs-info .tab').removeClass('active_tab');
	$(e).addClass('active_tab');
}

function export_barcode_ajax(){
	var module_page = $('#module-page').val();
	var view_page = $('#view-page').val();
    var str_id =$("#str_id_checkbox").val();
    var model_print = 'ExportBarCode';
    var url_h = window.location.hostname;
    if(!str_id || str_id == ','){
    	$('.popup-notification').html('Chưa chọn quyển nào để in !');
    	$('.popup-notification').css({"background-color": "red", "display": "block"});
    	setTimeout(function(){ 
    		$('.popup-notification').css({"display": "none"});;
    	},3000);
    	
    	return false;
    }
    $.ajax({
        type : 'post',
        url: "index.php?module="+module_page+"&view="+view_page+"&task=save_pdf&raw=1",
        dataType : 'html',
        data: {str_id:str_id,model_print:model_print},
	    success: function (data) {
	        window.open( "http://"+url_h+"/export-print.html", "_blank");
	    },
	    error: function (response) {
	    }
	});
}