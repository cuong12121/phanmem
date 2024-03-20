$( document ).ready(function() {
	$('#product_menu_top').click(function(){
		$('#product_menu_ul').slideToggle( "slow");
    // alert(123);

	   
	});
  

$('.bt_after').click(function(){
    var parent = $(this).parent();
   
    $(this).prev(".cat_filters_home_wrapper").slideToggle(300);
     if($(this).parent().hasClass('closed') == true){
         parent.removeClass('closed').addClass('opened');
      }else{
        parent.removeClass('opened').addClass('closed');
      } 

    
  });
$('.bt_after_child').click(function(){
    var parent = $(this).parent();
    parent.removeClass('closed').addClass('opened');
    $(this).prev(".cat_filters_home_wrapper_sub_level2").slideToggle(300);
   
  });

});