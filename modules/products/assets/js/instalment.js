$(document).ready(function(){
	var slpercent = $( "#slpercent option:selected" ).val();
	var slmonth = $( "#slmonth option:selected" ).val();
	var product_id = $( "#product-id" ).val();
	var product_price = $( "#product-price" ).val();

	$.ajax({url: '/index.php?module=products&view=instalment&task=calculator&raw=1&slpercent='+slpercent+'&slmonth='+slmonth+'&product_id='+product_id+'&product_price='+product_price,
        type : 'POST',
        dataType: 'json',  
		 
		  success : function(data){
		  	
			  	var instalment_money_before = data.instalment_money_before;
				var instalment_money_per_month = data.instalment_money_per_month;
				var instalment_money_total = data.instalment_money_total;				
				var html = data.html;

				$('#instalment_money_before').val(instalment_money_before);
				$('#instalment_money_per_month').val(instalment_money_per_month);
				$('#instalment_money_total').val(instalment_money_total);
				$('#result').html(html);
				$('.table-instalment-procedures').css("display", "table");
			  
		  }
	});


	if(product_id){
		// $.get("/index.php?module=products&view=instalment&task=load_data&raw=1",{product_id:product_id}, function(html){ 
		// 	$('#product-content').html(html);
		// });
	}
}); 

function CalculateInstallmentByMonth(){
	var slpercent = $( "#slpercent option:selected" ).val();
	var slmonth = $( "#slmonth option:selected" ).val();
	var product_id = $( "#product-id" ).val();
	var product_price = $( "#product-price" ).val();
	$.ajax({url: '/index.php?module=products&view=instalment&task=calculator&raw=1&slpercent='+slpercent+'&slmonth='+slmonth+'&product_id='+product_id+'&product_price='+product_price,
	
        type : 'POST',
        dataType: 'json',         
	
		  success : function(data){
		  	
			  	var instalment_money_before = data.instalment_money_before;
				var instalment_money_per_month = data.instalment_money_per_month;
				var instalment_money_total = data.instalment_money_total;				
				var html = data.html;

			
				
				$('#instalment_money_before').val(instalment_money_before);
				$('#instalment_money_per_month').val(instalment_money_per_month);
				$('#instalment_money_total').val(instalment_money_total);
				$('#result').html(html);
				$('.table-instalment-procedures').css("display", "table");
			  
		  },
       
	});
}


$('.box_extend').change(function(){

	// $("#price_extend").val(0);
	var box_id = $(this).attr('id');
	var va_box_id = $(this).val();
	var box_id_m = box_id.replace('box_extend_','box_extendm_');
	$("#"+box_id_m).val(va_box_id);

	var input_id = box_id.replace('box_extend_','input_price_extend_');

	$('#'+input_id).val(va_box_id);
	var basic_price = $('#basic_price').val();
	var price_extend = 0;
	$('.box_extend').each(function(index) { 
		var va = $(this).val();
		var price_extend_item = $('.price_extend_id_'+va).attr('data-price');
		if (isNaN(price_extend_item) == true) {
			price_extend_item = 0;		}
			price_extend = parseInt(price_extend) + parseInt(price_extend_item);
		})
	
	$("#price_extend").val(price_extend) ;
	//var basic_price = $('#basic_price').val();
	var memory_curent = $('#memory_curent').val();
	var usage_states_curent = $('#usage_states_curent').val();
	var color_curent = $('#color_curent').val();
	var warranty_curent = $('#warranty_curent').val();
	var origin_curent = $('#origin_curent').val();
	var species_curent = $('#species_curent').val();
	var region_curent = $('#region_curent').val();
	var number = parseInt(price_extend) + parseInt(basic_price) + parseInt(memory_curent) + parseInt(usage_states_curent) + parseInt(memory_curent) + parseInt(color_curent)  + parseInt(origin_curent) + parseInt(species_curent)  + parseInt(region_curent) ;

		//Định dạng lại giá
		// var number = number.toString();
		// var format_money = "";
		// while (parseInt(number) > 999) {
		// 	format_money = "." + number.slice(-3) + format_money;
		// 	number = number.slice(0, -3);
		// } 

	$('#product-price').val(number); 

	
	result = format_money(number);

	$('.price_modal').html(result+'₫</span>');
	$('#price').html(result+'₫</span>');
	 CalculateInstallmentByMonth();
	 recal_after_change_attribute();

	})

function load_quick(element){
	var basic_price = $('#basic_price').val();
	var memory_curent = $('#memory_curent').val();
	var usage_states_curent = $('#usage_states_curent').val();
	var color_curent = $('#color_curent').val();
	var warranty_curent = $('#warranty_curent').val();
	var origin_curent = $('#origin_curent').val();
	var species_curent = $('#species_curent').val();
	var region_curent = $('#region_curent').val();

		var price_extend = $("#price_extend").val() ;

	basic_price = parseInt(price_extend) + parseInt(basic_price);
	
	// var price =  $(element).find("option:selected").data("price");
	// var type  =  $(element).find("option:selected").data("type");

	var price =  $(element).find("option:selected").data("price");



	if(!price){
		price =  $(element).data('price');   
		if(!price)
			price =  0;   
	}
	var type  =  $(element).find("option:selected").data("type");
	if(!type)
		type =  $(element).data('type');
	

	var price =  $(element).find("option:selected").data("price");

	if(!price){
		price =  $(element).data('price');   
		if(!price)
			price =  0;   
	}

	var type  =  $(element).find("option:selected").data("type");
	if(!type)
		type =  $(element).data('type');
	
	var color_id_h = $(element).data('color');
	var f = $( ".color_thump_"+color_id_h ).first();
	var order = f.data('order');
	order = parseInt(order);
	$( ".color_thump_"+color_id_h ).first().trigger( "click" );
//	var owlNumber = $('#sync1').find('.color_owl_'+color_id_h).index();

//	$( ".color_owl_"+color_id_sh ).first().trigger( "click" );

	if (type == 'memory'){
		var number = parseInt(basic_price) + parseInt(price) + parseInt(color_curent) + parseInt(warranty_curent) + parseInt(origin_curent) + parseInt(species_curent)  + parseInt(usage_states_curent) + parseInt(region_curent) ;
		$('#memory_curent').val(price);
		$("#boxmemory").val($(element).find("option:selected").val());
	}else if (type == 'color'){
		var number = parseInt(basic_price) + parseInt(price) + parseInt(memory_curent) + parseInt(warranty_curent)  + parseInt(origin_curent) + parseInt(species_curent)  + parseInt(usage_states_curent) + parseInt(region_curent) ;
		$('#color_curent').val(price);
		// Khi click  vaof  icon ma u sac
		if($(element).data('id')){
			$(".boxcolor").val($(element).data('id'));	
			$("#color").val($(element).data('id'));	
		}

	}else if (type == 'warranty'){
		var number = parseInt(basic_price) + parseInt(price) + parseInt(memory_curent) + parseInt(color_curent)  + parseInt(origin_curent) + parseInt(species_curent)   + parseInt(usage_states_curent) + parseInt(region_curent) ;
		$('#warranty_curent').val(price);
		$(".boxwarranty").val($(element).find("option:selected").val());
	}else if (type == 'origin'){
		var number = parseInt(basic_price) + parseInt(price) + parseInt(memory_curent) + parseInt(warranty_curent) + parseInt(color_curent)   +  parseInt(species_curent)  + parseInt(usage_states_curent) + parseInt(region_curent) ;
		$('#origin_curent').val(price);
		$(".boxorigin").val($(element).find("option:selected").val());
	}else if (type == 'species'){
		var number = parseInt(basic_price) + parseInt(price) + parseInt(memory_curent)  + parseInt(warranty_curent) + parseInt(color_curent)   + parseInt(origin_curent)   + parseInt(usage_states_curent) + parseInt(region_curent) ;
		$('#species_curent').val(price);
		$(".boxspecies").val($(element).find("option:selected").val());
	}else if (type == 'usage_states'){
		var number = parseInt(basic_price) + parseInt(price) + parseInt(memory_curent) + parseInt(warranty_curent) + parseInt(color_curent)  + parseInt(origin_curent) + parseInt(species_curent) + parseInt(region_curent)  ;
		$('#usage_states_curent').val(price);
		$(".boxusage_states").val($(element).find("option:selected").val());
	}else if (type == 'region'){
		var number = parseInt(basic_price) + parseInt(price) + parseInt(memory_curent) + parseInt(warranty_curent) + parseInt(color_curent)  + parseInt(origin_curent) + parseInt(species_curent) + parseInt(usage_states_curent) ;
		$('#region_curent').val(price);
		$(".box_region").val($(element).find("option:selected").val());
		

		$.ajax({
			url: '/index.php?module=users&view=users&task=ajax_city_save&city_id='+$(".box_region").val()+'&raw=1',		

			success: function(json){
					
			}
		});
	}
	


	$('#product-price').val(number); 

	
	result = format_money(number);

	$('.price_modal').html(result+'₫</span>');
	$('#price').html(result+'₫</span>');
	 CalculateInstallmentByMonth();
	 recal_after_change_attribute();
	
}


function format_money(money){
	//Định dạng lại giá
	var number = money.toString();
	var format_money = "";
	while (parseInt(number) > 999) {
		format_money = "." + number.slice(-3) + format_money;
		number = number.slice(0, -3);
	} 
	result = number + format_money;
	return result;
}


//show_tooltip();
//function show_tooltip(){
//	 $('.color_item').tooltip({
//	        placement : 'top'
//	    });
//}

click_color();
function  click_color(){
	$('.Selector').click(function(){
		$('.Selector').removeClass('active');
		$(this).addClass('active');

	})
}



/************** ALEPAY****************/
select_installment_method();
change_money_before();
function select_installment_method(){
	
	$('.method_instalment_wrapper > div').click(function(){
		$('#table_main').show();
		$('.method_instalment_wrapper > div').removeClass('selected');
		$(this).addClass('selected');
		$('.installment_type').hide();
		$('.payment_note').hide();
		
		var method = $(this).attr('id');		
		wrapper = method.replace('_method','_wrapper');		
		note = method.replace('_method','_note');	

		$('#'+wrapper).show();
		$('#'+note).show();

	})
}
function change_money_before(){
	$('#ale_payment_before').keyup(function(){

		var ale_payment_before = $('#ale_payment_before').val();			
		
		ale_payment_before = (ale_payment_before.replace(/[^\d]/, ''));
		ale_payment_before = parseFloat(ale_payment_before.replace(/[^\d]/, ''));
		
		
		$('#ale_payment_before').val(format_money(ale_payment_before));
		recal_after_change_attribute();
	});

}

function recal_after_change_attribute(){
	var product_price = parseInt($('#product-price').val());
	$('#ale_payment_total').val(format_money(product_price));
	var ale_payment_before = get_money_from_string($('#ale_payment_before').val());	
	
	var amount = product_price - ale_payment_before;
	if(amount < 0){
		alert('Tiền trả trước không được lớn hơn giá trị sản phẩm');
		$('#ale_payment_before').val(0);
		recal_after_change_attribute();
		return;
	}
	$('#ale_payment_after').val(format_money(amount));
}

/* Loại các dấu . , đi */

function get_money_from_string(string_money){
	string_money = (string_money.replace(/[^\d]/, ''));
	return parseFloat(string_money.replace(/[^\d]/, ''));
}

function ale_payment(){
	var price = $('#product-price').val();
	var ale_payment_before= $('#ale_payment_before').val();// tiền trả trước
	var amount = parseInt(price) - parseInt(ale_payment_before);
	if(amount < 0){
		alert('Tiền trả trước không được lớn hơn giá trị sản phẩm');
		return;
	}

	$('label.label_error').prev().remove();
	$('label.label_error').remove();
	// sender
	if(!notEmpty("ale_sender_name","Nhập đầy đủ họ và tên"))
		return false;
	if(!notEmpty("ale_sender_telephone","Nhập số điện thoại"))
		return false;
	if(!isPhone("ale_sender_telephone","Số điện thoại chưa chính xác"))
		return false;
	if(!notEmpty("ale_sender_email","Nhập email"))
		return false;
	if(!emailValidator("ale_sender_email","Email chưa đúng định dạng"))
		return false;
    $.ajax({
        type: "POST",
        url: '/index.php?module=products&view=instalment&task=alepay_save_installment&raw=1',
        data: $("#eshopcart_info").find('input[class!=alepay_not_submit]').serialize(), // serializes the form's elements.

        success: function (data) {
        	// console.log(data.data);
        	 // console.log('111');
            console.log(data);
            if (data.error != 'OK') {
                $('#alert').html('<div class="alert alert-danger">' + data.message + '</div>');
                return false;
            } else {
                $('#frame').prop('src', data.data);
                $('#sendOrderToAlepayInstallment').show();
                $('#alert').html('');
            }

        }
    });

    
}


