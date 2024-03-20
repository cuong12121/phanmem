// ( function( $ ) {
// $( document ).ready(function() {
// $('#cssmenu > ul > li > a').click(function() {
//   $('#cssmenu li').removeClass('active');
//   $(this).closest('li').addClass('active');	
//   var checkElement = $(this).next();
//   if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
//     $(this).closest('li').removeClass('active');
//     checkElement.slideUp('normal');
//   }
//   if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
//     $('#cssmenu ul ul:visible').slideUp('normal');
//     checkElement.slideDown('normal');
//   }
//   if($(this).closest('li').find('ul').children().length == 0) {
//     return true;
//   } else {
//     return false;	
//   }		
// });
// });
// } )( jQuery );


$( document ).ready(function() {
$('#cssmenu li.has-sub > span').on('click', function(){
    $(this).removeAttr('href');
    var element = $(this).parent('li');
    if (element.hasClass('active')) {
      element.removeClass('active');
      element.find('li').removeClass('active');
      element.find('ul').slideUp();
    }
    else {
      element.addClass('active');
      element.children('ul').slideDown();
      element.siblings('li').children('ul').slideUp();
      element.siblings('li').removeClass('active');
      element.siblings('li').find('li').removeClass('active');
      element.siblings('li').find('ul').slideUp();
    }
  });


  $('#cssmenu .has-sub').click(function(){

        var $child =  $(this).parent().next('ul:first');

        if($($child).css("display") == "none")

            $($child).css("display", "block");

        else

          $($child).css("display", "none");

    });

  current = $('.selected').parent('font').parent('span').parent('li').parent('ul');

    if(current){

      current.slideDown(1000);

      parrent_current = $('.selected').parent('font').parent('span').parent('li').parent('ul').parent('li').parent('ul');

      if(parrent_current)

        parrent_current.slideDown(2000);

    }

});

expand_filter_a();

function expand_filter_a(){
	$('.sf-pro').click(function(e){
		var id = $(this).attr('data-id');
			$( this ).toggleClass( "activea" );
			$('#'+id).toggle();
	});
}
