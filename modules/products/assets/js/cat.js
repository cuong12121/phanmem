on_change_order(1);
function on_change_order(){
	$('.order-select').change(function() {
		var value=$(this).val();
		if(value){
			location.href=value;
		}
	});
}


function open_close_filter(){
	$('.icon-filter').click(function(){
		if($('.filter_inner').css('display') == 'none'){
			$('.filter_inner').css('display','block');	
		}else{
			$('.filter_inner').css('display','none');
		}
	});
}

$(document).ready(function(){

	$('.readmore_subcat').click(function(){
		$('.item_readmore_subcat').addClass('hide');
		$('.item_scat_more').removeClass('hide');
		$('.item_readany_subcat').removeClass('hide');
	})

	$('.item_readany_subcat').click(function(){
		$('.item_readmore_subcat').removeClass('hide');
		$('.item_scat_more').addClass('hide');
		$('.item_readany_subcat').addClass('hide');
	})



	$('.list_cat_soon .item_cat_s ').removeClass('hide');
	$('.list_cat_soon .item_cat_s ').removeClass('item-block');
	// var sync1 = $(".product_list_slide");
	var flag = false;
	var duration = 300;
	$(".list_cat_soon").owlCarousel({
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
				margin: 10,
			},
			500:{
				items:3,
				margin: 10,
			},
			800:{
				items:3,
				margin: 10,
			},
			1170:{
				items:7,
				margin: 10,
			}
		}
	})
});

$('.popup-video-full').click(function(){
	$('.popup-video-full').hide();
	$('.popup-video-full .video').html('');
});

$('.filter_icon').click(function(){
	$('.filter_products_cat').show();
	$('.modal-menu-full-screen').show();
});

$('.filter-mobile-click').click(function(){
	$('.filter_products_cat').show();
	$('.modal-menu-full-screen').show();
});

$('.modal-menu-full-screen').click(function(){
	$('.filter_products_cat').hide();
	$('.modal-menu-full-screen').hide();
});

$('.order-select-pc .type-icon').click(function(){
	$('.order-select-pc').toggleClass('display-open');
	$(this).toggleClass('rotate180');
});

$('.order-select-mb .order-text').click(function(){
	$('.order-select-mb .order-select').toggleClass('display-open');
	$('.order-select-mb .type-icon').toggleClass('rotate180');
	//$(this).toggleClass('rotate180');
});

$('#readmore_desc').click(function(){
	$('.cat_description_detail').removeClass('cat_description_any');
	$(this).addClass('hide');
	$('#readany_desc').removeClass('hide');
}) 

$('#readany_desc').click(function(){
	$('.cat_description_detail').addClass('cat_description_any');
	$(this).addClass('hide');
	$('#readmore_desc').removeClass('hide');
}) 




function popup_video_full(link_video) {
	console.log(link_video);
	$('.popup-video-full').show();
	var video = '<iframe src="'+ link_video +'"></iframe>';
	$('.popup-video-full .video').html('<iframe allow="autoplay" src="'+link_video+'?rel=0&autoplay=1" width="854px" height="480px" frameborder="0" allowfullscreen="false">');
}

function close_popup_video_full(){
	$('.popup-video-full').hide();
	$('.popup-video-full .video').html('');
}

$('.filter_select_name').click(function(){
	id = $(this).attr('id');
	//alert(id);
	data = id.replace('cl_','b_');

	if($('#'+data).is(":hidden")){
		$('.filter_select_it').css('display','none');
		$('#'+data).slideToggle();
	}else{
		$('#'+data).slideToggle();
	}

});

$('.closs_filter').click(function(){
	$('.filter_select_it').hide();
});