  setTimeout( function () {
  	$('.popup').removeClass('hidetime');
  }, 5000);

  if($.cookie('popup_cookie') == null) {
  	$('.popup').removeClass('hide');
  }

  $(function(){
  	var date = new Date();
  	var minutes = 60;
  	date.setTime(date.getTime() + (minutes * 60 * 24));
  	$("#close_form").click(function() {
  		$.cookie('popup_cookie', 'Popup Cookie', { expires: date});
  		$('.popup').addClass('hide');
  	});
  });