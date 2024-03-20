$(function() {

    $('.block_address_tab .tab button').click(function(){
        $('.block_address_tab .tab button').removeClass('active');
        $(this).addClass('active');
        var id = $(this).attr('data-id');
        $('.tabcontent .regions').removeClass('active');
        $('.tabcontent .region_'+id).addClass('active');
        $('.regions_slide_item').removeClass('active');
        $('.regions_slide_item_'+id).addClass('active');
    });


    
});

$('.regions_slide').owlCarousel({
      loop:true,
      nav:true,
      navText: [
        "‹",
        "›"
        ],
      dots:false,
      pagination:true,
      dots: false,
      autoplay: true,
      autoplayTimeout:3000,
      items:1,
      lazyLoad : true
});

