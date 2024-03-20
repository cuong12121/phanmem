$('#user_point').change(function(){
	var user_point = $(this).val();
	if(parseInt(user_point) > parseInt($('#max_point').val())){
		showEror("user_point","Số điểm vượt quá số điểm hiện có!");
	} else {
		var price_tongcong = $('#price_tongcong').val();
		var price_ship = $('#price_ship').val();
		var price_thanhtoan = price_tongcong - user_point*1000 + parseInt(price_ship);
		var price_thanhtoan = price_thanhtoan.toString();
		var format_money = "";
		while (parseInt(price_thanhtoan) > 999) {
			format_money = "." + price_thanhtoan.slice(-3) + format_money;
			price_thanhtoan = price_thanhtoan.slice(0, -3);
		} 
		result = price_thanhtoan + format_money + 'đ';
		$('.price_thanhtoan').text(result);
	}
})



click_pay(1);

function click_pay(){
	$("#sub-pro-liquidate").click(function () {
		$(".button-step").trigger('click');
	});
}
$('#copy_send_to_receive').click(function(){
	$('#recipients_name').val($('#sender_name').val());
	$('#recipients_email').val($('#sender_email').val());
	$('#recipients_address').val($('#sender_address').val());
	$('#recipients_telephone').val($('#sender_telephone').val());
	$('#recipients_comments').val($('#sender_comments').val());

});


function submitForm()
{

	if(checkFormsubmit1())
	{
		$('#task_buyer_form').val('shopcart_save');
		$('#eshopcart_info').submit();
	}
	
}

function resubmit_form(){
	$('label.label_error').prev().remove();
	$('label.label_error').remove();
	if(!notEmpty("card_code","Bạn phải nhập mã thẻ"))
		return false;
	$('#task_buyer_form').val('resubmit_form');
	$('#eshopcart_info').submit();
}

function checkFormsubmit1()
{
	$('label.label_error').prev().remove();
	$('label.label_error').remove();
	// sender
	if(!notEmpty("name_user","B&#7841;n ch&#432;a nh&#7853;p t&#234;n ng&#432;&#7901;i g&#7917;i"))
	return false;
	if(!notEmpty("telephone_user","B&#7841;n ch&#432;a nh&#7853;p s&#7889; phone ng&#432;&#7901;i nh&#7853;n"))
	return false;
	if(!isPhone("telephone_user","B&#7841;n nh&#7853;p kh&#244;ng &#273;&#250;ng &#273;&#7883;nh d&#7841;ng c&#7911;a tr&#432;&#7901;ng &#273;i&#7879;n tho&#7841;i"))
	return false;

	var vnf_regex = /((09|03|07|08|05)+([0-9]{8})\b)/g;
    var mobile = $('#telephone_user').val();
    var length_phone = $('#telephone_user').vlength;
    

    if(mobile !==''){
        if (vnf_regex.test(mobile) == false) 
        {
            alert('Số điện thoại của bạn không đúng định dạng!');
            return false;
        }else{
            // alert('Số điện thoại của bạn hợp lệ!');
            // return false;
        }
    }else{
        alert('Bạn chưa điền số điện thoại!');
        return false;
    }

	// if(!notEmpty("sender_email","B&#7841;n ch&#432;a nh&#7853;p email ng&#432;&#7901;i g&#7917;i"))
		// return false;
	var sender_email = $('#sender_email').val();
	if(sender_email !=''){
		if(!emailValidator("sender_email","Email ng&#432;&#7901;i &#273;&#7863;t h&#224;ng kh&#244;ng &#273;&#250;ng &#273;&#7883;nh d&#7841;ng"))
		return false;
	}

	
	


	// if(!notEmpty("city_id","Chọn Tỉnh Thành"))
	// 	return false;
	// if(!notEmpty("district_id","Chọn Quận huyện"))
	// 	return false;
	// if(!notEmpty("ward_id","Chọn Xã phường"))
	// 	return false;

	// if(!notEmpty("address_user","Bạn phải nhập thông tin địa chỉ"))
	// return false;


	if($('#invoice-ip').is(":checked")){
		if(!notEmpty("txtTaxName","Bạn phải nhập tên công ty"))
		return false;

		if(!notEmpty("txtTaxAddress","Bạn phải nhập địa chỉ"))
		return false;

		if(!notEmpty("txtTaxEmail","Bạn phải nhập email"))
		return false;

		if(!emailValidator("txtTaxEmail","Email nhập không đúng định dạng"))
		return false;

		if(!notEmpty("txtTaxCode","Bạn phải nhập mã số thuế"))
		return false;

		
	}


	$('.loader').addClass('display_open');
	$('.modal-menu-full-screen').addClass('display_open');

	return true;
}


/*
 * Sale type: 'none','combo_money','combo_product','discount..."
 */
 function select_gift_4_total(element,product_id,price_id,sale_id){


 	var data_send = {
 		product_id:product_id,price_id:price_id,sale_id:sale_id

 	};


 	var data_send_json = JSON.stringify(data_send);
 	$.ajax({url: '/index.php?module=products&view=cart&task=ajax_add_gift_4_total&raw=1',
 		type : 'POST',
 		dataType: 'json',  
 		data: {data: data_send_json},
 		success : function(data){
 			alert('Quý khách đã chọn quà')	;
 			window.location.href = '/gio-hang.html';			
 		}
		// alert('Quý khách đã chọn lại qu1à')	;
	});

	// 	var gift_prd_product_id = $(element).find('.gift_prd_product_id').val();
	// var gift_prd_price_id = $(element).find('.gift_prd_price_id').val();
	// var gift_prd_name = $(element).find('.gift_prd_name').val();
	// var selected = $(element).parent().parent().hasClass('selected');
	// $('.combo_gifts .gift').removeClass('selected');
//	if(selected == true){
	$(element).parent().parent().addClass('selected');
//	}


	// $('#gift_prd_price_id_selected_'+sale_product_id).val(gift_prd_price_id);
	// $('#gift_prd_product_id_selected_'+sale_product_id).val(gift_prd_product_id);
	// $('#gift_prd_selected_name_'+sale_product_id+' span').html(gift_prd_name);

	
//	var buy_count = parseInt($('#buy_count').val());
//	if(!buy_count || buy_count == 0)
//		return;
//	add_cart(product_id,buy_count);
}

// Lấy thông tin từ mã thẻ để đẩy vào
function load_info_from_card_code(){
	$('#card_code').blur(function(){
		
		var card_code = $('#card_code').val();
		if(card_code.length > 5){
			$.ajax({url: '/index.php?module=products&view=cart&task=ajax_get_user_from_card&raw=1',
				type : 'POST',
				dataType: 'json',  
				data: {card_code: card_code},
				success : function(data){
					var message = data.message;
					if(message != ''){
						// invalid('card_code',message);
						$("#card_code").parent().find('.label_error').prev().remove();
						$("#card_code").parent().find('.label_error').remove();
						$("#card_code").parent().find('.label_success').prev().remove();
						$("#card_code").parent().find('.label_success').remove();
						$('<br/><div class=\'label_error\'>'+message+'</div>').insertAfter($('#card_code').parent().children(':last'));
					}
					if($('#sender_name').val() == '' ){
						$('#sender_name').val(data.full_name);
					}
					if($('#sender_telephone').val() == '' ){
						$('#sender_telephone').val(data.mobilephone);
					}
					if($('#sender_address').val() == '' ){
						$('#sender_address').val(data.address);
					}
					if($('#sender_email').val() == '' ){
						$('#sender_email').val(data.email);
					}
					if(message == '' && $('#sender_telephone').val() != ''){
						$('#task_buyer_form').val('resubmit_form');
						$('#eshopcart_info').submit();		
					}


					
				}
			});
		}

	})
}



function edit_name_address(){
	$('.text_name').addClass('hide');
	$('.text_address').addClass('hide');
	$('#name_user').removeClass('hide');
	$('#address_user').removeClass('hide');
	$('.apply_name_address').removeClass('hide');
	$('.edit_name_address').addClass('hide');
}

function apply_name_address(){
	var name = $('#name_user').val();
	var text_name = name+'<br>';
	$('.text_name').html(text_name);
	var address = $('#address_user').val();
	var text_address = '<strong>Địa chỉ: </strong>'+address;
	$('.text_address ').html(text_address);
	$('.text_name').removeClass('hide');
	$('.text_address').removeClass('hide');
	$('#name_user').addClass('hide');
	$('#address_user').addClass('hide');
	$('.apply_name_address').addClass('hide');
	$('.edit_name_address').removeClass('hide');
}

function edit_telephone(){
	$('.text_telephone').addClass('hide');
	$('#telephone_user').removeClass('hide');
	$('.apply_telephone').removeClass('hide');
	$('.edit_telephone').addClass('hide');
}

function apply_telephone(){
	var telephone = $('#telephone_user').val();
	var text_telephone = telephone;
	$('.text_telephone').html(text_telephone);
	$('.text_telephone').removeClass('hide');
	$('#telephone_user').addClass('hide');
	$('.apply_telephone').addClass('hide');
	$('.edit_telephone').removeClass('hide');
}


function edit_email(){
	$('.text_email').addClass('hide');
	$('#email_user').removeClass('hide');
	$('.apply_email').removeClass('hide');
	$('.edit_email').addClass('hide');
}

function apply_email(){
	var email = $('#email_user').val();
	var text_email = email;
	$('.text_email').html(text_email);
	$('.text_email').removeClass('hide');
	$('#email_user').addClass('hide');
	$('.apply_email').addClass('hide');
	$('.edit_email').removeClass('hide');
}


function onchange_number(sid){
	if(!sid){
		return false;
	}
	var get_number = $('#quantity_'+sid).val();
	// alert(type);
	// alert(get_number);

	if(!get_number || Number(get_number) < 1){
		// alert("Số lượng phải số và > 11");
		$('#quantity_'+sid).focus();
		$('.error_'+sid).html("Phải nhập số và > 0");

		// $('#quantity_'+sid).val(1);
		return false;
	}

	q_sid = Number(get_number);
	var config_total_vnpay = $('#config_total_vnpay').val();
	var is_vnpay = $('#is_vnpay').val();
	$.ajax({
		type: "POST",
		url: "/index.php?module=products&view=cart&task=recal_ajax&raw=1",
		data: {sid:sid,q_sid:q_sid},
		cache: false,
		success: function(html){
			$("div.shopcart").load(location.hrsef+" div.shopcart>*","");
			$("#product_cart_load_ajax").html(html);
			$.ajax({
				type: "POST",
				url: "/index.php?module=products&view=cart&task=check_show_vnpay&raw=1",
				cache: false,
				success: function(data){
					
					if(data && parseInt(data) > parseInt(config_total_vnpay)){

						$('#ajax-method-vnpay').addClass('display-off');

						if(parseInt(is_vnpay) == 1){
							$('#method-cod').trigger('click');
						}
						
						
					}else{
						$('#ajax-method-vnpay').removeClass('display-off');
						
					}
				}
			});
			
		}
	});
}



function load_ajax_cart(sid,type){
	if(!sid){
		return false;
	}
	// alert(sid);
	var get_number = $('#quantity_'+sid).val();
	// alert(type);
	// alert(get_number);

	if(!get_number && Number(get_number) < 1){
		// alert("Số lượng phải số và > 1")
		$('.error_'+sid).html("Phải nhập số và > 0");
		return false;
	}
	get_number = Number(get_number);
	if(type  == 'minus' && get_number > 1){
		q_sid = get_number - 1;
	}else if(type  == 'plus' && get_number > 0){

		q_sid = get_number + 1;
	}else{
		// alert("Số lượssng thấp nhất là 1")
		$('.error_'+sid).html("Phải nhập số và > 0");
		return false;
	}

	var config_total_vnpay = $('#config_total_vnpay').val();
	var is_vnpay = $('#is_vnpay').val();
	$.ajax({
		type: "POST",
		url: "/index.php?module=products&view=cart&task=recal_ajax&raw=1",
		data: {sid:sid,q_sid:q_sid},
		cache: false,
		success: function(html){
			// console.log(html);
			$("div.shopcart").load(location.hrsef+" div.shopcart>*","");
			$("#product_cart_load_ajax").html(html);
			$.ajax({
				type: "POST",
				url: "/index.php?module=products&view=cart&task=check_show_vnpay&raw=1",
				cache: false,
				success: function(data){
					
					if(data && parseInt(data) > parseInt(config_total_vnpay)){

						$('#ajax-method-vnpay').addClass('display-off');

						if(parseInt(is_vnpay) == 1){
							$('#method-cod').trigger('click');
						}
						
						
					}else{
						$('#ajax-method-vnpay').removeClass('display-off');
						
					}

					
				}
			});
		}
	});


}



function pay_mothod(id){
	$('#is_vnpay').val(id);
	if(id == 2){
		$('.list_bankings').addClass('display-flex');
	}else{
		$('.list_bankings').removeClass('display-flex');
	}	

}

$('#bank_code').change(function(){
	var bank = $(this).val();
	$('#bank_code_ip').val(bank);
});

$('#buy-type a').click(function(){
	$('#buy-type a').removeClass('active');
	$(this).addClass('active');
	var show = $(this).attr('data-show');
	if(show == '#form-login'){
		$('#form-login').show();
		$('.buyer_info').hide();
	}else{
		$('#form-login').hide();
		$('.buyer_info').show();
	}
});

$('.js-select-tax-invoice').click(function(){
	if($('#invoice-ip').is(":checked")){
		$('#tax-form table').show();
	}else{
		$('#tax-form table').hide();
	}
});

$('.payment-type .container-rd').click(function(){
	$('.payment-type .container-rd').removeClass('active');
	$(this).addClass('active');
	var pay_method = $(this).attr("data-pay-method");
	$.ajax({url: '/index.php?module=products&view=cart&task=ajax_set_seetion_pay_method&raw=1',
			type : 'POST',
			dataType: 'json',  
			data: {pay_method: pay_method},
			success : function(data){
				if(data == 1){
					$.ajax({
						type: "POST",
						url: "/index.php?module=products&view=cart&task=recal_ajax_map&raw=1",
						cache: false,
						success: function(html){
							$("#product_cart_load_ajax").html(html);
						}
					});
				}
			}
		});

});




$("#city_id").change(function(){
	ajax_unset_sesstion_km_ship();
	$('.ship-mn .price_ship').html('');
	cid = $(this).val();
	if(!cid){
 		$('#district_id').html('<option value="">Chọn Quận huyện</option>');
 		$('#ward_id').html('<option value="">Chọn Xã phường</option>');
 		return false;
	}

	$.ajax({url: "index.php?module=products&view=cart&task=get_district&raw=1",
		data: {cid: $(this).val()},
		dataType: "json",
		success: function(data) {
			$('#district_id').html(data.html);
			elemnent_fisrt = $('#district_id option:first').val();
		}
	});


	$.ajax({url: "index.php?module=products&view=cart&task=get_ward&raw=1",
		data: {cid: $(this).val()},
		dataType: "json",
		success: function(data) {
			$('#ward_id').html(data.html);
			elemnent_fisrt = $('#ward_id option:first').val();
			set_session_address(elemnent_fisrt);
		}
	});
});



if(! $("#district_id").val()){
	ajax_unset_sesstion_km_ship();
	$('.ship-mn .price_ship').html('Chưa tính được!');
}

$("#district_id").change(function(){
	ajax_unset_sesstion_km_ship();
	$('.ship-mn .price_ship').html('Chưa tính được!');
	cid = $(this).val();
	if(!cid){
 		$('#ward_id').html('<option value="">Chọn Xã phường</option>');
 		return false;
	}

	$.ajax({url: "index.php?module=products&view=cart&task=get_ward&raw=1",
		data: {cid: $(this).val()},
		dataType: "json",
		success: function(data) {
			$('#ward_id').html(data.html);
			elemnent_fisrt = $('#ward_id option:first').val();
			// set_session_address(elemnent_fisrt);
		}
	});
});








$(document).ready( function(){
	$('.signin-submit-cart').click(function(){
		if(checkFormsubmit_login_cart())
			document.login_form_cart.submit();
	})
});


function checkFormsubmit_login_cart()
{

	$('label.label_error').prev().remove();
	$('label.label_error').remove();

	if(!notEmpty("email_login_cart","Bạn chưa nhập email")){
		return false;
	}
	if(!emailValidator("email_login_cart","Email nhập không hợp lệ")){
		return false;
	}
	if(!notEmpty("password_login_cart","Bạn chưa nhập mật khẩu"))
	{
		return false;
	}
	return true;
}



$(document).ready( function(){
    var origin, destination, map;
    // add input listeners
    google.maps.event.addDomListener(window, 'load', function (listener) {
        setDestination();
        initMap();
    });
    // init or load map
    function initMap() {
        var myLatLng = {
            lat: 21.059518,
            lng: 105.764771
        };
        map = new google.maps.Map(document.getElementById('map'), {zoom: 16, center: myLatLng,});
    }

    function setDestination(e) {
        var from_places = new google.maps.places.Autocomplete(document.getElementById('from_places'));
        var to_places = new google.maps.places.Autocomplete(document.getElementById('to_places'));

        // google.maps.event.addListener(from_places, 'place_changed', function () {
        //     var from_place = from_places.getPlace();
        //     console.log(from_place.formatted_address);
        //     var from_address = from_place.formatted_address;
        //     $('#origin').val(from_address);
        // });

        google.maps.event.addListener(to_places, 'place_changed', function () {
            var to_place = to_places.getPlace();
            var to_address = to_place.formatted_address;
            $('#destination').val(to_address);
        });

       

    }

    function displayRoute(travel_mode, origin, destination, directionsService, directionsDisplay) {
        directionsService.route({
            origin: origin,
            destination: destination,
            travelMode: travel_mode,
            avoidTolls: true
        }, function (response, status) {
            if (status === 'OK') {
                directionsDisplay.setMap(map);
                directionsDisplay.setDirections(response);
            } else {
                directionsDisplay.setMap(null);
                directionsDisplay.setDirections(null);
                alert('Không thể hiển thị chỉ đường do: ' + status);
            }
        });
    }

    // calculate distance , after finish send result to callback function
    function calculateDistance(travel_mode, origin, destination) {
        // console.log(origin);
        // console.log(destination);
        var DistanceMatrixService = new google.maps.DistanceMatrixService();
        DistanceMatrixService.getDistanceMatrix(
        {
            origins: [origin],
            destinations: [destination],
            travelMode: google.maps.TravelMode[travel_mode],
            unitSystem: google.maps.UnitSystem.IMPERIAL, // miles and feet.
            // unitSystem: google.maps.UnitSystem.metric, // kilometers and meters.
            avoidHighways: false,
            avoidTolls: false
        }, save_results);
    }

    // save distance results
    function save_results(response, status) {
        if (status != google.maps.DistanceMatrixStatus.OK) {
        	ajax_unset_sesstion_km_ship();
            
        } else {
            var origin = response.originAddresses[0];
            var destination = response.destinationAddresses[0];
            if (response.rows[0].elements[0].status === "ZERO_RESULTS") {
                // $('#result').html("Xin lỗi, không có sẵn để sử dụng chế độ di chuyển này giữa " + origin + " và " + destination);
               	ajax_unset_sesstion_km_ship();
               
            } else {
                var distance = response.rows[0].elements[0].distance;
                var duration = response.rows[0].elements[0].duration;
                var distance_in_kilo = distance.value / 1000; // the kilo meter
                var distance_in_mile = distance.value / 1609.34; // the mile
                var duration_text = duration.text;
                appendResults(distance_in_kilo, distance_in_mile, duration_text);
              
            }
        }
    }

    // append html results
    function appendResults(distance_in_kilo, distance_in_mile, duration_text) {
        $("#result").removeClass("hide");
        $('#in_kilo').val(distance_in_kilo.toFixed(2));
    }

    
    // thay đổi xã phường
    $('#ward_id').change(function () {
    	var ward_id = $(this).val();
		set_session_address(ward_id);

		if(!notEmpty("city_id","Chọn Tỉnh Thành"))
			return false;
		if(!notEmpty("district_id","Chọn Quận huyện"))
			return false;
		if(!notEmpty("ward_id","Chọn Xã phường"))
			return false;
		var ship_HL = $('#check_ship_HL').val();
		if(ship_HL == 0){
			return false;
		}
	    var is_district_free = 0;
	    var district_id = $('#district_id').val();

		var lat_warehouse = $('#city_id option:selected').attr('latitude_warehouse');
		var lng_warehouse = $('#city_id option:selected').attr('longitude_warehouse');
		var lat_ward = $('#ward_id option:selected').attr('latitude');
		var lng_ward = $('#ward_id option:selected').attr('longitude');
		if(!lat_warehouse || !lng_warehouse || !lat_ward || !lng_ward){
			ajax_unset_sesstion_km_ship();
			
		}


		lat_warehouse = parseFloat(lat_warehouse);
		lng_warehouse = parseFloat(lng_warehouse);
		lat_ward = parseFloat(lat_ward);
		lng_ward = parseFloat(lng_ward);

		console.log(lat_warehouse);
		console.log(lng_warehouse);
		console.log(lat_ward);
		console.log(lng_ward);
		

		
	    var travel_mode = 'DRIVING';
	    const origin = { lat: lat_warehouse, lng: lng_warehouse };
	   	const destination = { lat: lat_ward, lng: lng_ward };

	    calculateDistance(travel_mode, origin, destination);

	    $.ajax({url: '/index.php?module=products&view=cart&task=ajax_check_is_district_free&raw=1',
			type : 'POST',
			dataType: 'json',  
			data: {district_id: district_id},
			success : function(data){
				if(data == 1){
					is_district_free = 1;
					$.ajax({
						type: "POST",
						url: "/index.php?module=products&view=cart&task=recal_ajax_map&raw=1",
						cache: false,
						success: function(html){
							$("#product_cart_load_ajax").html(html);
						}
					});
				}
			}
		});
		

	    setTimeout(function(){
	    	var in_kilo = $('#in_kilo').val();
	        console.log(in_kilo);
	        if(in_kilo && destination){
		        $.ajax({url: '/index.php?module=products&view=cart&task=ajax_set_sesstion_km_ship&raw=1',
					type : 'POST',
					dataType: 'json',  
					data: {in_kilo: in_kilo,destination:destination,is_district_free:is_district_free},
					success : function(data){
						if(data == 1){
							$.ajax({
								type: "POST",
								url: "/index.php?module=products&view=cart&task=recal_ajax_map&raw=1",
								cache: false,
								success: function(html){
									$("#product_cart_load_ajax").html(html);
								}
							});
						}
					}
				});
			}
	    }, 1000);
    });

 	//thay đổi sổ địa chỉ
	$('#change_addess_books').change(function(){
		var id = $(this).val();
		$.ajax({url: '/index.php?module=products&view=cart&task=ajax_get_addess_book&raw=1',
			type : 'POST',
			dataType: 'json',  
			data: {id: id},
			success : function(data){
				if(data){
					$('#name_user').val(data.full_name);
					$('#telephone_user').val(data.telephone);
					$('#address_user').val(data.address);
					$('#city_id').html(data.city_id);
					$('#district_id').html(data.district_id)
					$('#ward_id').html(data.ward_id);
					$.ajax({
						type: "POST",
						url: "/index.php?module=products&view=cart&task=recal_ajax_map&raw=1",
						cache: false,
						success: function(html){
							$("#product_cart_load_ajax").html(html);
							selected_ward_user();
						}
					});

				}
			}
		});
	});
	
	// dành cho user đã có sổ địa chỉ mặc đinh
    selected_ward_user();

    function selected_ward_user(){

    	var ward_id = $('#ward_id option:selected').val();

    	if(!ward_id){
    		return false;
    	}
		set_session_address(ward_id);

		if(!notEmpty("city_id","Chọn Tỉnh Thành"))
			return false;
		if(!notEmpty("district_id","Chọn Quận huyện"))
			return false;
		if(!notEmpty("ward_id","Chọn Xã phường"))
			return false;
		var ship_HL = $('#check_ship_HL').val();
		if(ship_HL == 0){
			return false;
		}
	    var is_district_free = 0;
	    var district_id = $('#district_id').val();
	    
		var lat_warehouse = $('#city_id option:selected').attr('latitude_warehouse');
		var lng_warehouse = $('#city_id option:selected').attr('longitude_warehouse');
		var lat_ward = $('#ward_id option:selected').attr('latitude');
		var lng_ward = $('#ward_id option:selected').attr('longitude');
		if(!lat_warehouse || !lng_warehouse || !lat_ward || !lng_ward){
			ajax_unset_sesstion_km_ship();
		}

		lat_warehouse = parseFloat(lat_warehouse);
		lng_warehouse = parseFloat(lng_warehouse);
		lat_ward = parseFloat(lat_ward);
		lng_ward = parseFloat(lng_ward);

		console.log(lat_warehouse);
		console.log(lng_warehouse);
		console.log(lat_ward);
		console.log(lng_ward)

		
	    var travel_mode = 'DRIVING';
	    const origin = { lat: lat_warehouse, lng: lng_warehouse };
	   	const destination = { lat: lat_ward, lng: lng_ward };

	    calculateDistance(travel_mode, origin, destination);

	    $.ajax({url: '/index.php?module=products&view=cart&task=ajax_check_is_district_free&raw=1',
			type : 'POST',
			dataType: 'json',  
			data: {district_id: district_id},
			success : function(data){
				if(data == 1){
					is_district_free = 1;
					$.ajax({
						type: "POST",
						url: "/index.php?module=products&view=cart&task=recal_ajax_map&raw=1",
						cache: false,
						success: function(html){
							$("#product_cart_load_ajax").html(html);
						}
					});
				}
			}
		});
		

	    setTimeout(function(){
	    	var in_kilo = $('#in_kilo').val();
	        console.log(in_kilo);
	        if(in_kilo && destination){
		        $.ajax({url: '/index.php?module=products&view=cart&task=ajax_set_sesstion_km_ship&raw=1',
					type : 'POST',
					dataType: 'json',  
					data: {in_kilo: in_kilo,destination:destination,is_district_free:is_district_free},
					success : function(data){
						if(data == 1){
							$.ajax({
								type: "POST",
								url: "/index.php?module=products&view=cart&task=recal_ajax_map&raw=1",
								cache: false,
								success: function(html){
									$("#product_cart_load_ajax").html(html);
								}
							});
						}
					}
				});
			}
	    }, 1000);
    }

    function ajax_unset_sesstion_km_ship(){
    	$('#in_kilo').val('');
    	$('.ship-mn .price_ship').html('Chưa tính được !');
		$.ajax({url: '/index.php?module=products&view=cart&task=ajax_unset_sesstion_km_ship&raw=1',
			type : 'POST',
			dataType: 'json', 
			success : function(data){
			}
		});
		return false;
    }
});


function ajax_unset_sesstion_km_ship(){
	$('#in_kilo').val('');
	$('.ship-mn .price_ship').html('Chưa tính được !');
	$.ajax({url: '/index.php?module=products&view=cart&task=ajax_unset_sesstion_km_ship&raw=1',
		type : 'POST',
		dataType: 'json', 
		success : function(data){
		}
	});
	return false;
}




$('#address_user').keyup(function(){
	var ward_id = $('#ward_id').val();
	set_session_address(ward_id);
});


function set_session_address(ward_id){
	var address_user = $('#address_user').val();
	$.ajax({url: '/index.php?module=products&view=cart&task=set_session_address&raw=1',
		type : 'POST',
		dataType: 'json',  
		data: {ward_id: ward_id, address_user: address_user},
		success : function(data){
			if(data == 1){
				$.ajax({
					type: "POST",
					url: "/index.php?module=products&view=cart&task=recal_ajax_map&raw=1",
					cache: false,
					success: function(html){
						$("#product_cart_load_ajax").html(html);
					}
				});
				// console.log(88888888);
			}
		}
	});
}