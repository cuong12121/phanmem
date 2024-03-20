 $(document).ready(function() {
        //Init the carousel
        $("#owl-demo2").owlCarousel({
            slideSpeed : 500,
            paginationSpeed : 800,
            navigation:true,
            navigationText:[" "," "],
            items : 5,
            itemsCustom : false,
            itemsDesktop : [1199,4],
            itemsDesktopSmall : [980,4],
            itemsTablet: [768,3],
            itemsTabletSmall: false,
            itemsMobile : [400,2],
            pagination:false
        });
    });