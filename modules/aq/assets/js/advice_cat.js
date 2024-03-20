$(document).ready( function(){
		
		$(".famous_item_head").click(function () {
			famous_body = $(this).next();
			famous_body.slideToggle(600);
			
			tag_parent = $(this).parent();
			if(tag_parent.hasClass('famous_openned'))
				tag_parent.removeClass('famous_openned').addClass('famous_closed');
			else 
				tag_parent.removeClass('famous_closed').addClass('famous_openned');
		})
	});