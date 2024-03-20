//$(document).ready(function() {

$(function() {
	$('#fs-slider .item').removeClass('hide');
	$('#sync2 .item').removeClass('hide');
	
	var sync1 = $("#fs-slider");

	var flag = false;
    var duration = 300;
    
	sync1.owlCarousel({

		
		items : 1, 
		nav : true,
		navText : ["‹","›"],
		autoplay:true,
		autoplayTimeout:4000,
		loop: false,
		lazyLoad : true,
      		pagination:true,
      		dots: true
		
	}).on('changed.owl.carousel', function (e) {
        var syncedPosition = syncPosition(e.item.index);

        if ( syncedPosition != "stayStill" ) {
           sync2.trigger('to.owl.carousel', [syncedPosition, duration, true]);
        }
    });
	

	var sync2 = $("#sync2");
	sync2.on('initialized.owl.carousel', function() { //must go before owl carousel initialization
        addClassCurrent( 0 );
    }).owlCarousel({
		items : 8,
		itemsDesktop      : [1199,1],
		itemsDesktopSmall     : [979,1],
		itemsTablet       : [768,1],
		itemsMobile       : [479,1],
		pagination:false,
		dots: false,
		navText : ["‹","›"],
		loop: false,
		autoplay:false,
		

		responsive:{
	        0:{
	            items:3,
	        },
	        400:{
	            items:4,
	        },
	        500:{
	            items:5,
	        },
	        600:{
	            items:3,
	        },
	        700:{
	            items:4,
	        },
	        800:{
	            items:5,
	        },
	        900:{
	            items:5,
	        },
	        1000:{
	            items:5,
	        },
	        1100:{
	            items:5,
	        }
	    }
//		responsiveRefreshRate : 100,
//		afterInit : function(el){
//			el.find(".owl-item").eq(0).addClass("synced");
//		}
	}).on("click", ".owl-item", function(e){
		e.preventDefault();
		var number = $(this).index();
		 addClassCurrent( number );
		sync1.trigger("to.owl.carousel", [number, 1, true]);
		
		var img_current = sync2.find(".owl-item").eq(number).find("img").attr('src');
		img_current = img_current.replace('/small/','/large/');
		 $("#Zoomer img").fadeTo(300,0.30, function() {
		      $("#Zoomer img").attr("src",img_current);
		      
		      
		  }).fadeTo(300,1);
		 $("#Zoomer").attr("href",img_current);
		 $("#Zoomer").attr("data-image",img_current);
		 
//		 MagicZoom.update('#Zoomer', img_current,img_current, 'show-title: false');
		 MagicZoom.refresh();
	})
	;
	
	
	 //syncs positions. argument 'index' represents absolute position of the element
    function syncPosition( index ) {

        //PART 1 (adds 'current' class to thumbnail)
        addClassCurrent( index );

        //PART 2 (counts position)

        var itemsNo = sync2.find(".owl-item").length; //total items
        var visibleItemsNo = sync2.find(".owl-item.active").length; //visible items

        //if all items are visible
        if (itemsNo === visibleItemsNo) {
            return "stayStill";
        }

        //relative index (if 4 elements are visible and the 2nd of them has class 'current', returns index = 1)
        var visibleCurrentIndex = sync2.find(".owl-item.active").index( sync2.find(".owl-item.current") );

        //if it's first visible element and if there is hidden element before it
        if (visibleCurrentIndex == 0 && index != 0) {
                return index - 1;
        }

        //if it's last visible element and if there is hidden element after it
        if (visibleCurrentIndex == (visibleItemsNo - 1) && index != (itemsNo - 1)) {
                return index - visibleItemsNo + 2;
        }

        return "stayStill";
    }
    // ./SYNCED OWL CAROUSEL
	    
	
	
	
	 //adds 'current' class to the thumbnail
    function addClassCurrent( index ) {
        sync2
                .find(".owl-item")
                .removeClass("current")
                .eq( index ).addClass("current");
    }
	
    				
//    	$(".cb-image-inner-content").colorbox({maxHeight:"640px"});
    	$(window).resize(function(){
    		if(window.innerWidth  <= 768){
    			sync1.trigger('next.owl.carousel');
    			sync1.trigger('prev.owl.carousel');
    		}
    	});
});

