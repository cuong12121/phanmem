function show_vat(stt){
	$('.boxViewVAT-'+stt).toggleClass('hide');
};

function ShowInfoPayments(stt){
	$('.boxViewInfoPayments-'+stt).toggleClass('hide');
};


function SubTotal(stt,type=0){
	if(type == 1){
		$('.creditAccountIdContainer-'+stt).toggleClass('hide');
	}
};


$(document).ready(function(){
	// duration of scroll animation
	var scrollDuration = 30;
	// paddles
	var leftPaddle = $('#moveLeft');
	var rightPaddle = $('#moveRight');
	// get items dimensions
	var itemsLength = $('.listTabs .tabInvoice-show').length;
	// alert(itemsLength);
	if(itemsLength == 5){
		$('#moveRight').removeClass('opacity_0');
	}

	if(itemsLength > 5){
		$('.moveTab').removeClass('opacity_0');
	}

	var itemSize = $('.listTabs .tabInvoice-show').outerWidth(true);
	// get some relevant size for the paddle triggering point
	var paddleMargin = 0;

	// get wrapper width
	var getMenuWrapperSize = function() {
	  return $('#contentTabs').outerWidth();
	}
	var menuWrapperSize = getMenuWrapperSize();
	// the wrapper is responsive
	$(window).on('resize', function() {
	  menuWrapperSize = getMenuWrapperSize();
	});
	// size of the visible part of the menu is equal as the wrapper size 
	var menuVisibleSize = menuWrapperSize;

	// get total width of all menu items
	var getMenuSize = function() {
	  return itemsLength * itemSize;
	};
	var menuSize = getMenuSize();
	// get how much of menu is invisible
	var menuInvisibleSize = menuSize - menuWrapperSize;

	// get how much have we scrolled to the left
	var getMenuPosition = function() {
	  return $('.listTabs').scrollLeft();
	};

	// finally, what happens when we are actually scrolling the menu
	$('.listTabs').on('scroll', function() {
	  // get how much of menu is invisible
	  menuInvisibleSize = menuSize - menuWrapperSize;
	  // get how much have we scrolled so far
	  var menuPosition = getMenuPosition();

	  var menuEndOffset = menuInvisibleSize - paddleMargin;

	  // show & hide the paddles 
	  // depending on scroll position
	  // if (menuPosition <= paddleMargin) {
	  //   $(leftPaddle).addClass('opacity_0');
	  //   $(rightPaddle).removeClass('opacity_0');
	  // } else if (menuPosition < menuEndOffset) {
	  //   // show both paddles in the middle
	  //   $(leftPaddle).removeClass('opacity_0');
	  //   $(rightPaddle).removeClass('opacity_0');
	  // } else if (menuPosition >= menuEndOffset) {
	  //   $(leftPaddle).removeClass('opacity_0');
	  //   $(rightPaddle).addClass('opacity_0');
	  // }
	});

	// scroll to left
	$(rightPaddle).on('click', function() {
	  $('.listTabs').animate({
	    scrollLeft: getMenuPosition() + 120
	  }, scrollDuration);
	});

	// scroll to right
	$(leftPaddle).on('click', function() {
	  $('.listTabs').animate({
	    scrollLeft: getMenuPosition() - 120
	  }, scrollDuration);
	});

	

	

	$('#tabAdd').click(function(){
		var stt = $('#count-tab-show').val();
		var stt_next = parseInt(stt) + 1;
		$('#count-tab-show').val(stt_next);
		$('.tabInvoice').removeClass('active');
		$(".listTabs").append('<li data-tab="'+stt_next+'" class="tabInvoice tabInvoice-'+stt_next+' active tabInvoice-show"><a onclick="tabInvoice(this)" href="javascript:;" data-tab="'+stt_next+'">Hóa đơn '+stt_next+'</a><span onclick="closeTab(this)" class="closeTab" title="Đóng" data-tab="'+stt_next+'">x</span></li>');
		
		$('.listTabs').animate({
	    	scrollLeft: getMenuPosition() + 120
	 	}, 30);

		var itemsLength = $('.listTabs .tabInvoice-show').length;
		if(parseInt(itemsLength) == 4){
			$('#moveRight').removeClass('opacity_0');
		}

		if(parseInt(itemsLength) > 5){
			$('.moveTab').removeClass('opacity_0');
		}
		// console.log(itemsLength);

		//add boxContentTab
		$.ajax({
			url: "/admin/index.php?module=sells&view=retail&task=ajax_add_boxContentTab&raw=1",
			data: {stt_next: stt_next},
			dataType: "html",
			success: function(html){
				$('.boxContentTab').addClass('hide');
				$("#boxContent").append(html);
			}
		});



	});


	$('#tbLoadProduct').keyup(function(){
		var key = $('#tbLoadProduct').val();
		if(key){
			$.ajax({
				url: "/admin/index.php?module=sells&view=retail&task=ajax_search_products&raw=1",
				data: {key: key},
				dataType: "html",
				success: function(html){
					$('.wrap-product-search').show();
					$('.wrap-product-search').html(html);
				}
			});
		}else{
			$('.wrap-product-search').hide();
		}
		
	});
});

function set_product_search(e){
	var id = $(e).attr('data-id');
	var stt_tab = $('.listTabs .active').attr('data-tab');
	
	$.ajax({
		url: "/admin/index.php?module=sells&view=retail&task=ajax_set_product_search&raw=1",
		data: {id: id},
		dataType: "html",
		success: function(html){
			$('.boxContentTab-'+stt_tab + ' tbody').append(html);
		}
	});


	$('.wrap-product-search').hide();
}

function tabInvoice(e){
	var stt_tab = $(e).attr('data-tab');
	$('.tabInvoice').removeClass('active');
	$('.tabInvoice-'+stt_tab).addClass('active');
	$('.boxContentTab').addClass('hide');
	$('.boxContentTab-'+stt_tab).removeClass('hide');
}

function closeTab(e){
	var stt_tab = $(e).attr('data-tab');
	$('.tabInvoice-'+stt_tab).removeClass('tabInvoice-show');

	if($('.tabInvoice-'+stt_tab).hasClass("active")){
		var find_active = 0;
	  	$('.tabInvoice-show').each(function( index ){
	  		find_active = $(this).attr('data-tab');
		});

		if(Number(find_active) > 0 ){
			$('.tabInvoice-'+find_active).addClass('active');
		}	
	}
}

