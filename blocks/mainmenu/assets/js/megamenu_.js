$( document ).ready(function() {
	$('.navbar-toggle').click(function(){
		$('#megamenu').slideToggle( "slow");

	    if($('#megamenu').css('display') == 'none'){
	      $('#navbar-toggle-mask').hide();
	    }else{
	      $('#navbar-toggle-mask').show();
	    }	
	});
  $('#navbar-toggle-mask').click(function(){
    $('#megamenu').slideToggle( "slow", function(){
       if($('#megamenu').css('display') == 'none'){
        $('#navbar-toggle-mask').hide();
      }else{
        $('#navbar-toggle-mask').show();
      }  
    });
  });
});