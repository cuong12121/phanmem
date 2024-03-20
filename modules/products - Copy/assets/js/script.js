(function($) {
	/* This code is executed after the DOM has been completely loaded */
	$.fn.appleSlide = function(){
		var totWidth=0;
		var positions = new Array();
		$('#slides .slide').each(function(i){
			
			/* Traverse through all the slides and store their accumulative widths in totWidth */
			
			positions[i]= totWidth;
			totWidth += $(this).width();
			
			/* The positions array contains each slide's commulutative offset from the left part of the container */
			
			if(!$(this).width())
			{
				alert("Please, fill in width & height for all your images!");
				return false;
			}
			
		});
		
		$('#slides').width(totWidth);
		var UlWidth=0;
		$('#menu ul > li').each(function(){
				UlWidth=UlWidth + $(this).width() + 10;
		});
		$('#menu ul').css({'width':UlWidth,'margin':'0px auto'});
		$('#accessories-ul').css({'width':'380px'});
		/* Change the cotnainer div's width to the exact width of all the slides combined */
		
		$('#menu ul li.menuItem:first').addClass('act').siblings().addClass('inact');
		/* On page load, mark the first thumbnail as active */
		
		
		
		/*****
		 *
		 *	Enabling auto-advance.
		 *
		 ****/
		 
		$('#menu ul li a').click(function(e,keepScroll){
				/* On a thumbnail click */
				$('li.menuItem').removeClass('act').addClass('inact');
				$(this).parent().addClass('act');
				var pos = $(this).parent().prevAll('.menuItem').length;
				
				$('#slides').stop().animate({marginLeft:-positions[pos]+'px'},450);
				/* Start the sliding animation */
				
				e.preventDefault();
				/* Prevent the default action of the link */
				
				
				// Stopping the auto-advance if an icon has been clicked:
			//	if(!keepScroll) clearInterval(itvl);
		});
		var current=1;
		function autoAdvance()
		{
			if(current==-1) return false;
			$('#menu ul li a').eq(current%$('#menu ul li a').length).trigger('click',[true]);	// [true] will be passed as the keepScroll parameter of the click function on line 28
			current++;
		}
		$('#prev_detail').click(function(){
			var current=$('.act').attr('lang');
			var current=parseInt(current)-2;
			var total=$('.menu-ul').attr('lang');
			if(current==-1) current=parseInt(total);
			$('#menu ul li a').eq(current%$('#menu ul li a').length).trigger('click',[true]);	// [true] will be passed as the keepScroll parameter of the click function on line 28
		});
		$('#next_detail').click(function(){
			var current=$('.act').attr('lang');
			var current=parseInt(current);
			if(current==-1) return false;
			$('#menu ul li a').eq(current%$('#menu ul li a').length).trigger('click',[true]);	// [true] will be passed as the keepScroll parameter of the click function on line 28
		});
		
		// The number of seconds that the slider will auto-advance in:
		
		var changeEvery =5;
	
		var itvl = setInterval(function(){autoAdvance()},changeEvery*1000);
	
		/* End of customizations */
	};
})(jQuery);