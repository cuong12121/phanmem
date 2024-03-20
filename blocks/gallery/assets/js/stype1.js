$('.slider').slick({
  slidesToShow: 3,
  slidesToScroll: 1,
  arrows: true,
  autoplaySpeed: 2000,
  dots: false,
  centerMode: true,
  draggable: true,
  autoplay:true,
  
    prevArrow:'<button class="slick-prev"> ‹ </button>',
  nextArrow:'<button class="slick-next"> › </button>',
    infinite: true,
  variableWidth: true,
  focusOnSelect: true,
  cssEase: 'linear',

  
  responsive: [{
            breakpoint: 960,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2,

            }


        }, {
            breakpoint: 600,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2,
           
            }
        }]


});


var imgs = $('.slider img');
imgs.each(function(){
  var item = $(this).closest('.item');
  item.css({
    'background': '#fff', 
  });
  
});
$('.slider').removeClass('slider_11');
