$(document).ready(function(){
  var width = $(window).width();
  $(window).resize(function() {
    width = $(window).width();
  });

  if( width < 1025){
    $('.sb-toggle-left').click(function(){
      //$('#megamenu').slideToggle('display_open');
      
    });

    // $('.field_item').click(function(){
    //   $(this).find('.filters_in_field').slideToggle('display_open');
    // });
    
    $('.drop_down').click(function(){
      //$(this).parent().find('.highlight').slideToggle('display_open');
    });
  }

});



