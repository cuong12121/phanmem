$(function() {
	$('.is_default_color').trigger( "click" );
	$('.trigger_is_default_price_extend').trigger( "click" );
	$("iframe").Lazy();
	$('.title_click').click(function(){
		var id = $(this).attr('id');
		var content_id = id.replace('boxcontent','prodetails_tab');
		$('.title_click').removeClass('active');
		$(this).addClass('active');
		$('.prodetails_tab_content').addClass('hide');
		$('#'+content_id).removeClass('hide');
	});

	// $('.color_thump_item').click(function(e){
	// 	var id_color = $(this).attr('data_color_thump');
	// 	if(id_color){
	// 		$('.data_color_'+id_color).trigger( "click" );
	// 	}
	// 	else{
	// 		return false;
	// 	}
	// });

	$('.button2_wrap #buy-now-2').click(function(){
		$('.wrap-btm-buy #buy-now-222').trigger( "click" );
	});

	$('.button2_wrap .btn-tragop').click(function(){
		$('.wrap-btm-buy .btn-dathang').trigger( "click" );
	});
});


function file_upload_product(){
	$('html, body').animate({
		scrollTop: $("#file_upload_product").offset().top - 80
	}, 1000);
};

function rate_product(){
	$('html, body').animate({
		scrollTop: $("#prodetails_tab3").offset().bottom
	}, 1000);
};

function color_thump(element){
	// var id_color = $(element).attr('data_color_thump');
	// if(id_color){
	// 	$('.data_color_'+id_color).trigger( "click" );
	// }
	// else{
	// 	return false;
	// }
}

function click_check_product_compatable(compatable_id){
	var str_id_compatables = $('#str_id_compatables').val();
	if( $('#check_product_compatable_'+compatable_id).is(':checked') ) {
		if(str_id_compatables){
			str_id_compatables = str_id_compatables+'_'+compatable_id;
		}else {
			str_id_compatables = compatable_id;
		}
	} else {
		str_id_compatables = str_id_compatables.replace(compatable_id+'_','');
		str_id_compatables = str_id_compatables.replace('_'+compatable_id,'');
		str_id_compatables = str_id_compatables.replace(compatable_id,'');
	}
	$('#str_id_compatables').val(str_id_compatables);
	update_total_money_compatable();
}
var smartTab = jQuery("#smartTab");
var fixedTop = 0;
var headerTabTop = fixedTop + 80;
var clickNum = -1;
$(document).ready(function(){
    // $("#sticker").sticky({ topSpacing: 10 ,bottomSpacing:600});
    //  $("ul.nav li a[href^='#']").click(function(){
    //     $("html, body").stop().animate({
    //         scrollTop: $($(this).attr("href")).offset().top
    //     }, 400);
    // });
    $('#progress_bar_plus').owlCarousel({
    	items:1,
    	nav:true,
    	dots:true,

    });

    $('.show_reply_form').click(function(){
    	$('.form_comment_reply').css({"display":"none"});
    	$(this).parent().parent().parent().find('.form_comment_reply').first().css({"display":"block"});
    });


    $('.rate_count').click(function(){
    	$('html, body').animate({ scrollTop: $('#comment_add_form').offset().top }, 500);
    });
	// Add new comment 
	
	$('#commentbt').click(function(){
		var name = $("#comment_name").val().trim();
		var email = $("#comment_email").val().trim(); 
		var textcomment = $("#comment_text").val().trim();
		if(name == "" || email == "" || textcomment == "") {
			alert("Bạn cần nhập đầy đủ thông tin trước khi comment");
			return false;
		} 

		var commentForm = $('#comment_add_form');
		$.ajax({
			method: "POST",
			url:"",  
			data: commentForm.serialize(),
			success : function(result){
				var resultObj = jQuery.parseJSON(result);
				if(resultObj.success == 1) { 
				 // hide form and clear data 
				 $("#comment_name").val("");
				 $("#comment_email").val("");
				 $("#comment_text").val("");
				 // Display new comment 
				 var commentTempl = $("#commentTempl").clone(); 
				 commentTempl.css({"display":"block"});
				 commentTempl.removeClass("item-reply");
				 commentTempl.find("span.name > strong").html(resultObj.name);
				 commentTempl.find("div.comment_content").html(resultObj.textContent);
				 commentTempl.find("p.commemn_ff > span.date").html('<i class="fa fa-calendar" aria-hidden="true"></i>'+resultObj.save_time);
				 $("#commem_lindo").prepend("<div class='clear'></div>");
				 $("#commem_lindo").prepend(commentTempl);
				} else {
					alert(resultObj.msg);
				}
			}
		});
		return false;
	});
	
	// Reply comment 
	$('.btnSendComment').click(function(){
		var name = $(this).parent().parent().parent().find(".name_comment").val().trim();
		var email = $(this).parent().parent().parent().find(".email_comment").val().trim(); 
		var textcomment = $(this).parent().parent().parent().find(".text_comment").val().trim();
		if(name == "" || email == "" || textcomment == "") {
			alert("Bạn cần nhập đầy đủ thông tin trước khi comment");
			return false;
		}
		var record_id = $("#record_id").val();
		var parent_id = $(this).parent().find(".comment_parrent").val();
		var parentComment = $(this).parent().parent().parent().parent().parent();
		$.ajax({
			method: "POST",
			url:"",
			context:parentComment, 
			data: {name: name,email:email,text:textcomment,ajax:1,record_id:record_id,parent_id:parent_id,module:"products",view:"product",task:"save_reply"},
			success : function(result){
				var resultObj = jQuery.parseJSON(result);
				if(resultObj.success == 1) { 
				 // hide form and clear data 
				 $(".form_comment_reply").css({"display":"none"});
				 parentComment.find(".name_comment").val("");
				 parentComment.find(".email_comment").val("");
				 parentComment.find(".text_comment").val("");
				 
				 // Display new comment 
				 var commentTempl = $("#commentTempl").clone(); 
				 commentTempl.css({"display":"block"});
				 commentTempl.addClass("item-reply");
				 commentTempl.find("span.name > strong").html(resultObj.name);
				 commentTempl.find("div.comment_content").html(resultObj.textContent);
				 commentTempl.find("p.commemn_ff > span.date").html('<i class="fa fa-calendar" aria-hidden="true"></i>'+resultObj.save_time);
				 parentComment.after("<div class='clear'></div>");
				 parentComment.after(commentTempl);
				} else {
					alert(resultObj.msg);
				}
			}
		});
	});
	// owl_article();
	toogle_desc();
	// open_popup_charactestic();
	// open_popup_quick_order();
	close_modal();
	search_compare();
	
	click_tab();
	animate_icon();
	
	slideshow_ordercart();
	products_slideshow_hightlight();
	boxmemory_relate_slide();

	if ( smartTab ) {processScrollDetails();}
	jQuery(window).scroll(function(){
		processScrollDetails();
	});
});  

function click_tab(){
	jQuery("#smartTab li a").click(function(){
		var target = jQuery(jQuery(this).attr("href"));
		clickNum = parseInt(jQuery(this).attr("href").replace("#prodetails_tab", ""), 10);
		jQuery(smartTab).find("li").removeClass("active");
		jQuery(smartTab).find("li:eq(" + (clickNum - 1) + ")").addClass("active");
		jQuery("html:not(:animated), body:not(:animated)").animate({scrollTop : (jQuery(target).offset().top - (jQuery(this).attr("href") == "#prodetails_tab2" ? 45 : 45))}, function(){
			clickNum = -1;
		});
		return false;
	});
}

function processScrollDetails() {
	// var no_tab =  $('.product_tabs_ul li').length;
	// var minTop = jQuery("#prodetails_tab1").offset().top-45;
	// var last_element = jQuery('.product_tab_content').find(".prodetails_tab:eq(" + (no_tab - 1) + ")");
	// var maxTop = last_element.offset().top + last_element.height() - 45;
	// var scrollTop = jQuery(window).scrollTop();
	// if(scrollTop >= minTop && scrollTop <= maxTop){
	// 	jQuery(smartTab).find("li").removeClass("active");
	// 	jQuery(smartTab).css({'position' : 'fixed', 'top' : fixedTop + 'px', 'margin-top' : '0px'});
	// 	for(var i = 1; i <= no_tab; i ++){
	// 		element = $('#prodetails_tab'+i);

	// 		if( scrollTop >= (element.offset().top - 45) && scrollTop <= ((element.offset().top + element.height()) -45)){
	// 			jQuery(smartTab).find("li:eq(" + (i - 1) + ")").addClass("active");
	// 			break;
	// 		}


	// 	}

	// }else{
	// 	jQuery(smartTab).css({'position' : '', 'top' : '', 'margin-top' : ''});
	// }
}

// $('._zoomimg').click(function(){
// 	$( "#_zoomimg" ).remove();
// 	var id = $('#product_id').val();
// 	$.get('/index.php?module=products&view=product&task=show_image&raw=1',{id:id}, function(data,this_element){
// 		$('<div class="modal  fade" id="_zoomimg">' + data + '</div>').modal();
// 	});

// });

// function buy_add(id){
// 	var color_id    = $('#color_id').val();
// 	var	memory_id   = $('#memory').val();
// 	var	usage_states_id   = $('#usage_states').val();
// 	var	warranty_id = $('#warranty').val();
// 	var	region_id = $('#region_id').val();
// 	$.get("/index.php?module=products&view=product&task=buy&raw=1",{id:id,color_id:color_id,memory_id:memory_id,usage_states_id:usage_states_id,warranty_id:warranty_id,region_id:region_id}, function(data) {
// 		$('<div class="modal  fade"  id="modal_order">' + data + '</div>').modal();
// 	}).success(function() {
// 		$('input:text:visible:first').focus(); 
// 	});
// }

/* FORM CONTACT */
$('#submitbt').click(function(){
	//var sender_telephone = $('#sender_telephone').val();
	//var sender_telephone_arr = sender_telephone.split("");
	//alert(sender_telephone_arr[0]);
	//alert(sender_telephone_arr.length);

	alert('Đơn hàng đang được gửi đi!');
	document.eshopcart_info.submit();
})
$('#resetbt').click(function(){
	document.eshopcart_info.reset();
})

function checkFormsubmit()
{
	// return 1;
	var sender_telephone = $('#sender_telephone').val();
	var sender_telephone_arr = sender_telephone.split("");
	if(sender_telephone_arr[0] != '0') {
		invalid('sender_telephone','Số điện thoại bắt đầu bằng số 0 !');
		$('#sender_telephone').focus();
		return false;
	}
	if(sender_telephone_arr.length != 10) {
		invalid('sender_telephone','Số điện thoại phải có 10 số !');
		$('#sender_telephone').focus();
		return false;
	}

	$('label.label_error').prev().prev().remove();
	$('label.label_error').prev().remove();
	if(!notEmpty("quantity_modal","Bạn phải nhập số lượng"))	{
		return false;
	}
	if(!isPhone("quantity_modal","Bạn phải nhập số"))
		return false;
	if(!notEmpty("sender_name","Bạn phải nhập họ tên"))	{
		return false;
	}
	if(!notEmpty("sender_telephone","Bạn phải nhập số phone")){
		return false;
	}

	if(!isPhone("sender_telephone","Bạn nhập số điện thoại không hợp lệ"))
		return false;
	if(!notEmpty("sender_address","Bạn phải nhập địa chỉ gửi về"))
		return false;
//	if(!notEmpty("sender_email","Hãy nhập email"))
//		return false;
//	if(!emailValidator("sender_email","Email nhập không hợp lệ")){
//		return false;
//	}	
//	if(!notEmpty("received_time","Bạn phải nhập thời gian nhận hàng"))
//		return false;
return true;
}
function submit_form_buy_fast()
{
	$('label.label_error').prev().prev().remove();
	$('label.label_error').prev().remove();
	
	if(!notEmpty("telephone_buy_fast","Bạn phải nhập số điện thoại")){
		return false;
	}
	if(!isPhone("telephone_buy_fast","Bạn nhập số điện thoại không hợp lệ"))
		return false;
	
	return true;
}

$(window).load(function(){

});


//function favourite(id){
//	$.ajax({
//	  url: root+"index.php?module=products&view=favourites&task=add&raw=1&data="+id,
//	  cache: false,
//	  
//	  success: function(json){
//	  		json = jQuery.trim(json);
//	    	if(json == '1')
//	    	{
//	    		alert("Bạn đã lưu thành công vào danh mục yêu thích");
//	    		return 0;
//	    	}
//	    	else if(json == '2')
//	    	{
//	    		alert("Sản phẩm này đã tồn tại trong danh mục yêu thích của bạn");
//	    		return true;
//	    	}
//	    	else 
//	    	{
//	    		alert("Không lưu vào danh mục yêu thích");
//				return true;
//	    	}
//	  },
//	  error: function()
//	  {
//		 console.log('error');
//		 return false;
//	  }
//	});
//}

$('.box_extendm').change(function(){
	// $("#price_extend").val(0);
	var box_id = $(this).attr('id');
	var va_box_id = $(this).val();
	var box_id_m = box_id.replace('box_extendm_','box_extend_');
	$("#"+box_id_m).val(va_box_id);
	var input_id = box_id.replace('box_extendm_','input_price_extend_');
	$('#'+input_id).val(va_box_id);
	var basic_price = $('#basic_price').val();
	var price_extend = 0;
	$('.box_extendm').each(function(index) { 
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
		var number = number.toString();
		var format_money = "";
		while (parseInt(number) > 999) {
			format_money = "." + number.slice(-3) + format_money;
			number = number.slice(0, -3);
		} 
		result = number + format_money;
		$('.price_modal').html(result+'₫</span>');
		$('#price').html(result+'₫</span>');
		$('#price_2').html(result+'₫</span>');

	})



$('.box_extend').change(function(){
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
			price_extend_item = 0;
		}
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
	var number = number.toString();
	var format_money = "";
	while (parseInt(number) > 999) {
		format_money = "." + number.slice(-3) + format_money;
		number = number.slice(0, -3);
	} 
	result = number + format_money;
	$('.price_modal').html(result+'₫</span>');
	$('#price').html(result+'₫</span>');
	$('#price_2').html(result+'₫</span>');

})


click_color();
function  click_color(){
	$('.Selector').click(function(){
		$('.Selector').removeClass('active');
		$(this).addClass('active');
	})
}

click_memory();
function  click_memory(){
	$('.Selectorm').click(function(){
		$('.Selectorm').removeClass('active');
		$(this).addClass('active');

	})
}
//function owl_article(){
//
//	$('.relate_products').owlCarousel({
//	  items:4,
//	   margin:10,
//	  loop:false,
//	   nav:true,
//	    autoplay:false,
//	     responsive:{
//          0:{
//              items:1
//          },
//          480:{
//              items:2
//          },
//          720:{
//              items:3
//          },
//          900:{
//              items:4
//          }
//
//      }
//	});
//}
function toogle_desc(){
	var expandedHeight = $('.box_conten_linfo_inner').height();
	$('#readmore_desc span').click(function(){
//			$('#box_conten_linfo').animate({max-height:'400px'},3000);
$('#box_conten_linfo').css('max-height','none');
$('#readmore_desc').addClass('hide');
$('#readany_desc').removeClass('hide');
})

	$('#readany_desc span').click(function(){
//			$('#box_conten_linfo').animate({max-height:'400px'},3000);
$('#box_conten_linfo').css('max-height','400px');
$('#readany_desc').addClass('hide');
$('#readmore_desc').removeClass('hide');

$('html, body').animate({ scrollTop: $('#tabs').offset().top }, 500);

})
}
// function open_popup_charactestic(){
// 		open_popup_content(1);
// 		// $('#charactestic_detail').toggleClass('modal');
// }

function open_popup_content(type){
	$('.menu-tab .item').removeClass('active');
	$('.menu-tab .item_'+type).addClass('active');
	$('.tabs-popup').removeClass('hide');
	$('body').addClass('overflow-hidden');
	$('.tab-popup-content').removeClass('hide');
	$('.popup-content').addClass('hide');
	$('.popup-content-'+type).removeClass('hide');
	if (type == 3) {
		$('.list_video_popup').owlCarousel({
			pagination:false,
			navText : ["‹","›"],
			nav : true,
			dots: false,
			center: 1,
			loop: false,
			autoplay:false,
			margin:20,
			responsive:{
				0:{
					items:3,
				},
				400:{
					items:3,
				},
				500:{
					items:3,
				},
				600:{
					items:3,
				},
				700:{
					items:3,
				},
				1200:{
					items:5
				}
			}
		})
	} else {
		close_popup_video();
	}
	$("body").removeClass('fullscreen');
	$("html").removeClass('fullscreen');
	$(".fotorama").hide();
}


$('.video_popup .video_item_inner_has_img').click(function(){
	height = $(this).height();
	var img_video = $(this).find('img');
	var link_video = img_video.attr('link-video');
	var param = img_video.attr('param-video'); 
	var video = '<iframe src="'+ link_video +'"></iframe>';
	$('.video_item_inner_has_yt').html('<iframe src="'+link_video+'?rel=0&autoplay=1&enable_js=1&'+param+'" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" width="100%" height="'+height+'" frameborder="0" allowfullscreen="false">');
	$('.video_item_inner_has_yt').removeClass('hide');
	$(this).addClass('hide');
});

$('.list_video_popup .video_item_inner_has_img').click(function(){
	$('.list_video_popup .video_item_inner_has_img').removeClass('active');
	$(this).addClass('active');
	height = $('.video_popup .video_item_inner_has_yt').height() || $('.video_popup .video_item_inner_has_img').height();
	// alert(height);
	// alert();
	var img_video = $(this).find('img');
	var link_video = img_video.attr('link-video');
	var param = img_video.attr('param-video'); 
	var video = '<iframe src="'+ link_video +'"></iframe>';
	$('.video_popup .video_item_inner_has_yt').html('<iframe src="'+link_video+'?rel=0&autoplay=1&enable_js=1&'+param+'" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" width="100%" height="'+height+'" frameborder="0" allowfullscreen="false">');
	$('.video_item_inner_has_yt').removeClass('hide');
	$('.video_popup .video_item_inner_has_img').addClass('hide');
});

// function open_popup_quick_order(){
// 	$('#buy-now').click(function(){
// 		$('#modal_buy_now').show();
// 	});
// 	$('#buy-now-2').click(function(){
// 		$('#modal_buy_now').show();
// 	})
// }

function close_modal(){
	$('.modal-header button').click(function(){
		$('.modal').hide();
	});
	$('.modal-full-screen').click(function(){
		$('.modal').hide();
	});
}
function search_compare(){
	var table_name = $('#table_name').val();
	var id = $('#record_id').val();
	var code = $('#record_alias').val();
	$('#compare_name').autocomplete({
		serviceUrl:"/index.php?module=products&view=search&raw=1&task=get_ajax_search_compare&table_name="+table_name+"&codes="+code+"&ids="+id,
		groupBy:"",
		minChars:2,
		containerClass: 'autocomplete-suggestions-compare',
		width: '300',
		formatResult:function(n,t){
			t=t.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g,"\\$&");
			var i=n.data.text.split(" "),r="";
			for(j=0;j<i.length;j++)
				r+=t.toLowerCase().indexOf(i[j].toLowerCase())>=0?"<strong>"+i[j]+"</strong> ":i[j]+" ";
			return' <a href = "'+n.value+'" > <img src = "'+n.data.image+'" /> <label> <span> '+r+' </span> <span class = "price"> '+n.data.price+"</span></label></a>"
		},
		onSelect:function(n){
			$(".control input[name=kwd]").val(n.data.text)
		}
	});
	$('#compare_name2').autocomplete({
		serviceUrl:"/index.php?module=products&view=search&raw=1&task=get_ajax_search_compare&table_name="+table_name+"&codes="+code+"&ids="+id,
		groupBy:"",
		minChars:2,
		containerClass: 'autocomplete-suggestions-compare2',
		width: '300',
		formatResult:function(n,t){
			t=t.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g,"\\$&");
			var i=n.data.text.split(" "),r="";
			for(j=0;j<i.length;j++)
				r+=t.toLowerCase().indexOf(i[j].toLowerCase())>=0?"<strong>"+i[j]+"</strong> ":i[j]+" ";
			return' <a href = "'+n.value+'" > <img src = "'+n.data.image+'" /> <label> <span> '+r+' </span> <span class = "price"> '+n.data.price+"</span></label></a>"
		},
		onSelect:function(n){
			$(".control input[name=kwd]").val(n.data.text)
		}
	});
}



function slideshow_ordercart(){
	$('#products_orders .item').removeClass('hide');
	$('#products_orders').owlCarousel({
		loop: true,
		autoplay: true,
		items: 1,
		nav: false,

		autoplayHoverPause: true,
		animateOut: 'slideOutUp',
		animateIn: 'slideInUp',
		pagination:false,
		dots: false	
	});
}

function boxmemory_relate_slide(){
	// console.log('vvv');
	if ($(".boxmemory_relate_slide").length > 0){
		$('.boxmemory_relate_item').removeClass('hide');
		$('.boxmemory_relate_item').removeClass('relate_item-block');

		$('.boxmemory_relate_slide').owlCarousel({
			loop:false,
			nav:true,
			navText: [
			"‹",
			"›"
			],
			dots:false,
			pagination:true,
			dots: false,
			autoplay: false,
			slideSpeed:50,
			autoplayTimeout:4000,
			items:2,
			margin: 10,
			lazyLoad : true,
			singleItem: 1
		});
		

	}
}




/**** SLIDESHOW cho phần đặc điểm nổi bật ******/
function products_slideshow_hightlight(){
	// console.log('vvv');
	if ($("#products_slideshow_hightlight").length > 0){

		$('#products_slideshow_hightlight .item').removeClass('hide');
		$('#products_slideshow_hightlight').owlCarousel({
			loop:true,
			nav:true,
			nav:true,
			navText: [
			"‹",
			"›"
			],
			dots:false,
			pagination:true,
			dots: true,
			autoplay: true,
			slideSpeed:50,
			autoplayTimeout:4000,
			items:1,
			lazyLoad : true,
			singleItem: 1
		});
		

	}
}

function animate_icon(){
	setTimeout(function() {
		$('.frame_left').addClass('frame_left_animate');
    // 3000 for 3 seconds
}, 1000)
	
}

function buy_add_compatables(product_id){
	var str_id_compatables = $('#str_id_compatables').val();
	$.ajax({
		url: '/index.php?module=products&view=cart&task=ajax_buy_compatables&raw=1',
		type : 'POST',
		dataType: 'text',  
		data: {product_id: product_id,str_id_compatables:str_id_compatables },
		success : function(data){
			window.location.href = '/gio-hang.html';
		}
	})
}

function add_to_cart(product_id){
	// var str_id_compatables = $('#str_id_compatables').val();
	var buy_count = $('#buy_count').val();
	var color_curent_id = $('#color_curent_id').val();
	var box_extend_string =''; 

	var numItems = $('.box_extend_arr').length;

	var no_services = $('#no_services').val();
	
	if(numItems == 1){
		$(".box_extend_arr").each(function( index ) {
			box_extend_string += $( this ).val();
		});	
	}else{
		$(".box_extend_arr").each(function( index ) {
			box_extend_string += $( this ).val() + ',' ;
		});	
	}
	txt_services=',';
	if($('.iservices').length) {
		$(".iservices").each(function( index ) {
			if ($(this).is(":checked"))
			{
				txt_services += $( this ).val()+',';
			}
		});	
	}

	
	// console.log(box_extend_string);



	$.ajax({
		url: '/index.php?module=products&view=cart&task=ajax_buy_product&raw=1',
		type : 'POST',
		dataType: 'text', 
		data: {txt_services:txt_services,no_services: no_services, product_id: product_id, buy_count: buy_count , color_curent_id: color_curent_id,box_extend_string:box_extend_string,is_ajax:1 },
		success : function(data){
			
			$("div.shopcart").load(location.href+" div.shopcart>*","");
			$("div.shopcart-fixed-right").load(location.href+" div.shopcart-fixed-right>*","");
			alert("Đã thêm sản phẩm vào giỏ hàng");
			$("div.shopcart-fixed-right").addClass('w193px');
			setTimeout(function(){ 
				$("div.shopcart-fixed-right").removeClass('w193px');
			}, 3000);
			
			
			// var modal_alert = '<div class="modal_alert_2"><div class="modal_alert_inner"><div class="modal_alert_title">Thông báo<a class="close" href="javascript:void()" onclick="javascript:close_modal_alert_2()">X</a></div><div class="modal_alert_body">Đã thêm sản phẩm vào giỏ hàng</div></div></div>';
			// window.location.href = '/gio-hang.html';
			// $('.wrapper_modal_alert_2').html(modal_alert);
			
		}
	})
}

function add_to_cart2(product_id){
	// var str_id_compatables = $('#str_id_compatables').val();
	var buy_count = $('#buy_count').val();
	// var color_curent_id = $('#color_curent_id').val();
	
	$.ajax({
		url: '/index.php?module=products&view=cart&task=ajax_buy_product&raw=1',
		type : 'POST',
		dataType: 'text',  
		data: {product_id: product_id, buy_count: buy_count },
		success : function(data){
			window.location.href = '/gio-hang.html';
		}
	})
}

function add_mutil_to_cart(product_id,buy_count){
	// var str_id_compatables = $('#str_id_compatables').val();
	// var buy_count = $('#buy_count').val();
	$.ajax({
		url: '/index.php?module=products&view=cart&task=ajax_buy_product&raw=1',
		type : 'POST',
		dataType: 'text',  
		data: {product_id: product_id, buy_count: buy_count },
		success : function(data){
			window.location.href = '/gio-hang.html';
		}
	})
}


function close_modal_alert_2(){
  // $('#modal_alert').hide();
  $('.wrapper_modal_alert_2').html('');
}


function update_wishlist(product_id){
	var check_wishlist = $('#check_wishlist').val();
	if(check_wishlist == 0) {
		$.ajax({
			url: '/index.php?module=products&view=product&task=add_wishlist&raw=1',
			type : 'POST',
			dataType: 'text',  
			data: {product_id: product_id },
			success : function(data){
				$('#check_wishlist').val(1);
				$('#wishlist').addClass('wishlist_active');
			}
		})
	} else {
		if(check_wishlist == 1) {
			$.ajax({
				url: '/index.php?module=products&view=product&task=remove_wishlist&raw=1',
				type : 'POST',
				dataType: 'text',  
				data: {product_id: product_id },
				success : function(data){
					$('#check_wishlist').val(0);
					$('#wishlist').removeClass('wishlist_active');
				}
			})
		}
	}
}


function buy_combo(id_combo){
	// var str_id_combo = $('#str_id_combo_'+id_combo).val();
	$.ajax({
		url: '/index.php?module=products&view=cart&task=ajax_buy_combo&raw=1',
		type : 'POST',
		dataType: 'text',  
		data: {id_combo: id_combo },
		success : function(data){
			window.location.href = '/gio-hang.html';
		}
	})
}


function buy_add_product(product_id){
	var str_id_compatables = '';
	$.ajax({
		url: '/index.php?module=products&view=cart&task=ajax_buy_compatables&raw=1',
		type : 'POST',
		dataType: 'text',  
		data: {product_id: product_id,str_id_compatables:str_id_compatables },
		success : function(data){
			window.location.href = '/gio-hang.html';
		}
	})
}

$('#sender_codesale').change(function(){
	var code_input = $('#sender_codesale').val();
	var total_noshipping = $("input[name=price]").val();
	// $('manhhhhhhhhhhhh').appendTo('.price_modal');
	$.ajax({
		type: "POST",
		url: "/index.php?module=products&view=cart&task=check_code&raw=1&buy_fast=1&code_input="+code_input+"&total_noshipping="+total_noshipping,
		data: {code_input:code_input,total_noshipping:total_noshipping},
		dataType: 'json',
		success: function(data) {
			if(data.error == false){
				// console.log(data);
				$('#code_sale').val(data.code_card_send);
				if(data.type_down == 1) {
					text_sale = 'Mã giảm giá <b>'+data.code_card_send+'</b>: Giảm '+data.price_send+'%';
					new_price = total_noshipping * (1 - data.price_send / 100);
						// $("input[name=price]").val(new_price);
						$('.price_modal_new').html(data.html2);

					} else {
						text_sale = 'Mã giảm giá <b>'+data.code_card_send+'</b>: Giảm '+data.price_send+'₫';
						new_price = total_noshipping * (1 - data.price_send / 100);
						// $("input[name=price]").val(new_price);
						$('.price_modal_new').html(data.html2);
					}
					// $('#total-price').html(data.html);
					// $('#price_send_h').val(data.price_send);
					// $('#code_card_send_h').val(data.code_card_send);
					// $('#type_down_h').val(data.type_down);
				} else {
					$('.price_modal_new').html('Mã không hợp lệ!');
				}
			}
		});

})

$('.close_popup_chose_other_compatables').click(function(){
	$('.popup_chose_other_compatables').addClass('hide');
})

function chose_other_compatables(group_id){
	$('.popup_products_other_compatables').addClass('hide');
	$('#popup_products_other_compatables_'+group_id).removeClass('hide');
	$('.popup_chose_other_compatables').removeClass('hide');
}

function chose_product_other_compatables(product_id, product_compatable_id,group_id){
	$.ajax({
		url: '/index.php?module=products&view=product&task=chose_product_other_compatables&raw=1',
		type : 'POST',
		dataType: 'json',  
		data: {product_id:product_id,product_compatable_id:product_compatable_id,group_id:group_id},
		success : function(data){
			if(data.error == false){
				old_product_compatable_id = $('#active_product_compatables_item_'+group_id).val();
				old_str_id_compatables = $('#str_id_compatables').val();
				new_str_id_compatables = old_str_id_compatables.replace(old_product_compatable_id,product_compatable_id);
				$('#active_product_compatables_item_'+group_id).val(product_compatable_id);
				$('#str_id_compatables').val(new_str_id_compatables);
				$('.popup_chose_other_compatables').addClass('hide');
				$('#popup_products_other_compatables_'+group_id).addClass('hide');
				$('#product_compatables_item_'+group_id+' .frame_inner').html(data.html);

				update_total_money_compatable();

			}else{
				alert('Có lỗi xảy ra');
			}
		}, 
		error : function(XMLHttpRequest, textStatus, errorThrown) {
			alert('Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lại kết nối.');
		}
	});
	
}

function update_total_money_compatable() {
	product_id = $('#record_id').val();
	str_id_compatables = $('#str_id_compatables').val();
	$.ajax({
		url: '/index.php?module=products&view=product&task=update_total_money_compatable&raw=1',
		type : 'POST',
		dataType: 'json',  
		data: {product_id:product_id,str_id_compatables:str_id_compatables},
		success : function(data){
			if(data.error == false){
				$('.total_money_compatable').html(data.html);
			}else{
				alert('Có lỗi xảy ra');
			}
		}, 
		error : function(XMLHttpRequest, textStatus, errorThrown) {
			alert('Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lại kết nối.');
		}
	});
}








$(document).ready(function(){

	$(".numbers-row .button").on("click", function() {
		var $button = $(this);
		var oldValue = $('#buy_count').val();

		if ($button.attr('data') == "inc") {
			var newVal = parseFloat(oldValue) + 1;
		} else {
		   // Don't allow decrementing below zero
		   if (oldValue > 0) {
		   	var newVal = parseFloat(oldValue) - 1;
		   } else {
		   	newVal = 0;
		   }
		}

		$('#buy_count').val(newVal);

	});



	$('.list_video_review .video_item .video_item_inner_has_img').click(function(){
		var img_video = $(this).find('img');
		var link_video = img_video.attr('link-video');
		var video = '<iframe src="'+ link_video +'"></iframe>';
		$(this).html('<iframe src="'+link_video+'?rel=0&autoplay=1" allow="autoplay" width="100%" height="236px" frameborder="0" allowfullscreen="false">');
		$(this).removeClass('video_item_inner_has_img');

	});


	$('.product_grid_slide .item').removeClass('hide');
	$('.product_grid_slide .item').removeClass('item-block');
	var sync1 = $(".detail-slide-pro .product_grid_slide");
	var flag = false;
	var duration = 300;
	sync1.owlCarousel({
		loop:true,
		nav:true,
		navText: [
		"‹",
		"›"
		],
		margin:0,
		dots:false,
		pagination:false,		      
		autoplay: true,
		responsiveClass:true,
		lazyLoad : true,
		responsive:{
			0:{
				items:2,
			},
			500:{
				items:3,
			},
			800:{
				items:3,
			},
			1170:{
				items:4,
			}
		}
	})
});
click_color();
function  click_color(){
	$('.Selector').click(function(){
		$('.Selector').removeClass('active');
		$(this).addClass('active');
		var data_color =$(this).attr('data-id');
		
		$('#color_curent').attr('data-id',data_color);
		
		$('#color_curent_id').val(data_color);
		var data_color_name =$(this).attr('data-name');
		// alert(data_color_name);
		$('.image_color span').html(data_color_name);
		
	})
}

$('.item_extend').click(function() {
	var box_id = $(this).attr('data-attributes');
	var data_id =$(this).attr('data-id');

	var box_id_m = 'box_extendm_'+box_id;
	// alert(data_id);
	$(".item_extend_"+box_id).removeClass('active');
	$(this).addClass('active');
	var va_box_id =parseInt($(this).attr('data-price'));

	$("#"+box_id_m).val(data_id);

	//var box_id_m = box_id.replace('box_extend_','box_extendm_');
	//$("#"+box_id_m).val(va_box_id);

	var input_id = 'input_price_extend_'+box_id;
	$('#'+input_id).val(va_box_id);
	$('#'+input_id).attr('data-id',data_id)
	var basic_price = $('#basic_price').val();

	var price_extend = 0;
	$('.group_price .active').each(function(index) { 
		var price_extend_item = $(this).attr('data-price');
		if (isNaN(price_extend_item) == true) {
			price_extend_item = 0;		}
			price_extend = parseInt(price_extend) + parseInt(price_extend_item);
		});
	
	$("#price_extend").val(price_extend) ;


	//var basic_price = $('#basic_price').val();
	//alert(parseInt(price_extend));
	var number = parseInt(price_extend) + parseInt(basic_price) ;
	//alert(number);
	//Định dạng lại giá
	var number = number.toString();
	var format_money = "";
	while (parseInt(number) > 999) {
		format_money = "." + number.slice(-3) + format_money;
		number = number.slice(0, -3);
	} 
	result = number + format_money;
	$('.price_modal').html(result+'₫</span>');
	$('#price').html(result+'₫</span>');
	$('#price_2').html(result+'₫</span>');

})





toogle_desc();
function toogle_desc(){
	var expandedHeight = $('.box_conten_linfo_inner').height();
	// $('#readmore_desc span').click(function(){
	// 	$('#box_conten_linfo').css('max-height','none');
	// 	$('#readmore_desc').addClass('hide');
	// 	$('#readany_desc').removeClass('hide');
	// })

	$('#readany_desc span').click(function(){
		$('#box_conten_linfo').css('max-height','400px');
		$('#readany_desc').addClass('hide');
		$('#readmore_desc').removeClass('hide');
	})
}



$('.onchange_trigger').change(function(){
	var data_id = $(this).val();
	var group_id =  $('.data-style-select-'+data_id).attr('data-group-id');
	$('.item-' + group_id + '-' + data_id ).trigger( "click" );
});



$('#form-status').click(function(){
	$('.popup-form-status').show();
	$('.modal-menu-full-screen').show();
});

$('.popup-form-status .close').click(function(){
	$('.popup-form-status').hide();
	$('.modal-menu-full-screen').hide();
});

click_item_extend_name();
function click_item_extend_name(){
	$('.item_extend_name .item').click(function(){
		var class_group_item =  $(this).attr('data-group');
		$('.'+ class_group_item).removeClass('active');
		$(this).addClass('active');
		var item_id =  $(this).attr('data-id');
		var item_group_id =  $(this).attr('data-group-id');
		var class_ip_item = 'ip_item_extend_id_' + item_group_id;
		$('#' + class_ip_item).val(item_id);
		
		var price_extend = 0;
		$('.all_ground_extend .active').each(function(index) { 
			var price_extend_item = $(this).attr('data-price');
			if (isNaN(price_extend_item) == true) {
				price_extend_item = 0;
			}
			price_extend = parseInt(price_extend) + parseInt(price_extend_item);
		});
		var color_curent = $('#color_curent').val();
		var price_product_before = $('#price').attr('content');
		var price_product_after =  parseInt(price_product_before) + parseInt(price_extend) +  parseInt(color_curent);
		
		//Định dạng lại giá
		var number = price_product_after.toString();
		var format_money = "";
		while (parseInt(number) > 999) {
			format_money = "." + number.slice(-3) + format_money;
			number = number.slice(0, -3);
		} 
		result = number + format_money;
		$('#price').html(result+'₫</span>');


		//price_old
		var color_curent_old = $('#color_curent_old').val();
		var price_old_product_before = $('#price_old').attr('content');
		var price_old_product_after =  parseInt(price_old_product_before) + parseInt(price_extend) + parseInt(color_curent_old) ;
		//Định dạng lại giá
		var number = price_old_product_after.toString();
		var format_money = "";
		while (parseInt(number) > 999) {
			format_money = "." + number.slice(-3) + format_money;
			number = number.slice(0, -3);
		} 
		result = number + format_money;
		$('#price_old').html(result+'₫</span>');

		var discount = 0;
		discount = ((parseInt(price_product_after) - parseInt(price_old_product_after) )* 100)  / parseInt(price_old_product_after);

		// console.log(Math.ceil(discount)); 
		$('.discount #discount').html(Math.ceil(discount));

	})
}
function load_quick2(element) { //
	
	var basic_price = $('#basic_price').val();

	var basic_price_old = $('#basic_price_old').val();

	var color_curent = $('#color_curent').val();

	var price_extend = $("#price_extend").val() ;

	basic_price = parseInt(price_extend) + parseInt(basic_price);

	basic_price_old = parseInt(price_extend) + parseInt(basic_price_old);
	
	var price =  $(element).find("option:selected").data("price");
	if(!price){
		price =  $(element).data('price');   
		if(!price)
			price =  0;   
	}

	var price_old =  $(element).find("option:selected").data("price-old");
	if(!price_old){
		price_old =  $(element).data('price-old');   
		if(!price_old)
			price_old =  0;   
	}


	var type  =  $(element).find("option:selected").data("type");
	if(!type)
		type =  $(element).data('type');
	
	var color_id_h = $(element).data('color');
	var f = $( ".color_thump_"+color_id_h ).first();
	var order = f.data('order');
	order = parseInt(order);
	// $( ".color_thump_"+color_id_h ).first().trigger( "click" );
	
	$(".data_color_item").removeClass( "active" );
	$( ".data_color_"+color_id_h ).addClass( "active" );


	
	var data_id_color = $(element).attr('data-id');

	$('#color_curent_id').val(data_id_color);

	if (type == 'color'){
		var number = parseInt(basic_price) + parseInt(price);
		var number_old = parseInt(basic_price_old) + parseInt(price_old);
		$('#color_curent').val(price);
		$('#color_curent_old').val(price_old);
		// Khi click  vaof  icon ma u sac
		if($(element).data('id')){
			$(".boxcolor").val($(element).data('id'));	
		}
	}

	var price_extend = 0;
	$('.all_ground_extend .active').each(function(index) { 
		var price_extend_item = $(this).attr('data-price');
		if (isNaN(price_extend_item) == true) {
			price_extend_item = 0;
		}
		price_extend = parseInt(price_extend) + parseInt(price_extend_item);
	});

	number = parseInt(number) + parseInt(price_extend);
	number_old = parseInt(number_old) + parseInt(price_extend);
	var discount = 0;
	discount = ((parseInt(number) - parseInt(number_old) )* 100)  / parseInt(number_old);

	// console.log(Math.ceil(discount)); 
	$('.discount #discount').html(Math.ceil(discount));
	// alert($(element).data('price'));   

	//Định dạng lại giá
	var number = number.toString();
	var format_money = "";
	while (parseInt(number) > 999) {
		format_money = "." + number.slice(-3) + format_money;
		number = number.slice(0, -3);
	} 
	result = number + format_money;

	//Định dạng lại giá cũ
	var number_old = number_old.toString();
	var format_money = "";
	while (parseInt(number_old) > 999) {
		format_money = "." + number_old.slice(-3) + format_money;
		number_old = number_old.slice(0, -3);
	} 
	result_old = number_old + format_money;

	// $('.price_modal').html(result+'₫</span>');
	$('#price').html(result+'₫</span>');
	// $('#price_2').html(result+'₫</span>');
	$('#price_old').html(result_old+'₫</span>');



}

function load_quick(element) { //
	
	var basic_price = $('#basic_price').val();

	var basic_price_old = $('#basic_price_old').val();

	var color_curent = $('#color_curent').val();

	var price_extend = $("#price_extend").val() ;

	var price2 = $('#price2').val();

	basic_price2 = parseInt(price_extend) + parseInt(price2);

	basic_price = parseInt(price_extend) + parseInt(basic_price);

	basic_price_old = parseInt(price_extend) + parseInt(basic_price_old);
	

	var price =  $(element).find("option:selected").data("price");
	if(!price){
		price =  $(element).data('price');   
		if(!price)
			price =  0;   
	}

	var price_old =  $(element).find("option:selected").data("price-old");
	if(!price_old){
		price_old =  $(element).data('price-old');   
		if(!price_old)
			price_old =  0;   
	}


	var type  =  $(element).find("option:selected").data("type");
	if(!type)
		type =  $(element).data('type');
	
	var color_id_h = $(element).data('color');
	var f = $( ".color_thump_"+color_id_h ).first();
	var order = f.data('order');
	order = parseInt(order);
	$( ".color_thump_"+color_id_h ).first().trigger( "click" );
	
	if (type == 'color'){
		var number = parseInt(basic_price) + parseInt(price);
		var number2 = parseInt(basic_price2) + parseInt(price);
		var number_old = parseInt(basic_price_old) + parseInt(price_old);
		$('#color_curent').val(price);
		$('#color_curent_old').val(price_old);
		// Khi click  vaof  icon ma u sac
		if($(element).data('id')){
			$(".boxcolor").val($(element).data('id'));	
		}
	}

	var price_extend = 0;
	$('.all_ground_extend .active').each(function(index) { 
		var price_extend_item = $(this).attr('data-price');
		if (isNaN(price_extend_item) == true) {
			price_extend_item = 0;
		}
		price_extend = parseInt(price_extend) + parseInt(price_extend_item);
	});

	number2 = parseInt(number2) + parseInt(price_extend);

	number = parseInt(number) + parseInt(price_extend);
	number_old = parseInt(number_old) + parseInt(price_extend);
	var discount = 0;
	discount = ((parseInt(number) - parseInt(number_old) )* 100)  / parseInt(number_old);

	// console.log(Math.ceil(discount)); 
	$('.discount #discount').html(Math.ceil(discount));
	// alert($(element).data('price'));   

	//Định dạng lại giá
	var number = number.toString();
	var format_money = "";
	while (parseInt(number) > 999) {
		format_money = "." + number.slice(-3) + format_money;
		number = number.slice(0, -3);
	} 
	result = number + format_money;

		//Định dạng lại giá
		var number2 = number2.toString();
		var format_money2 = "";
		while (parseInt(number2) > 999) {
			format_money2 = "." + number2.slice(-3) + format_money2;
			number2 = number2.slice(0, -3);
		} 
		result2 = number2 + format_money2;

	//Định dạng lại giá cũ
	var number_old = number_old.toString();
	var format_money = "";
	while (parseInt(number_old) > 999) {
		format_money = "." + number_old.slice(-3) + format_money;
		number_old = number_old.slice(0, -3);
	} 
	result_old = number_old + format_money;

	// $('.price_modal').html(result+'₫</span>');
	$('#price').html(result+'₫</span>');
	$('.price_text').html(result2+'₫</span>');
	// $('#price_2').html(result+'₫</span>');
	$('#price_old').html(result_old+'₫</span>');
	$('.price_old_nb').html(result_old+'₫</span>');
	



}


$(".description table").each(function( index ) {

	if(index == 0){
		$(this).addClass('table_special');
	}


});

$( document ).ready(function() {
	$('.prodetails_tab_lable .tab_pro_title').click(function(){
		var height = $('.header_wrapper_wrap').height();
		height = height + 0;
		var id = $(this).attr('id');
		content_id = id.replace('b_','c_');
		$('html, body').animate({
			scrollTop: $("#"+content_id).offset().top - height
		}, 1000);
	});

	$('.price_wrapper .price2').click(function(){
		$(this).addClass('price_active');
		$('.price_wrapper .price1').removeClass('price_active');
		$('.promotion1').addClass('hide');
		$('.promotion2').removeClass('hide');
		$('.products_sets1').addClass('hide');
		$('.products_sets2').removeClass('hide');
		$('.promotion_more1').addClass('hide');
		$('.promotion_more2').removeClass('hide');
		$('.services').addClass('hide');
		$('#no_services').val(1);
	})

	$('.price_wrapper .price1').click(function(){
		$(this).addClass('price_active');
		$('.price_wrapper .price2').removeClass('price_active');
		$('.promotion2').addClass('hide');
		$('.promotion1').removeClass('hide');
		$('.products_sets2').addClass('hide');
		$('.products_sets1').removeClass('hide');
		$('.promotion_more2').addClass('hide');
		$('.promotion_more1').removeClass('hide');
		$('.services').addClass('hide');
		$('#no_services').val(0);
	})


});