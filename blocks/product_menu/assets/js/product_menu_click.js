$(document).ready(function(){
	click_menu();
});	

// function click_menu(){
// 	$('.level_0').click(function(){
// 		//alert('fdfd');
// 		$( this ).toggleClass( "active" );
// 		var wrapper_child = $(this).next('ul');
// 		if(wrapper_child.hasClass('hidden')){
// 			wrapper_child.slideToggle();
// 		}else{
// 			wrapper_child.slideToggle();
// 		}
// 	});
// }

function click_menu(){
	$('.product_menu-click .level_0').mouseover(function(){
		var id = $(this).attr('id');
		var id_ul = id.replace("pr_","c_");
		// $( this ).toggleClass( "parent_active");
		$("#"+id_ul).removeClass('hide');
		//alert(id_ul);
		//alert('fdfd');
	});
		$('.product_menu-click .level_0').mouseout(function(){
		var id = $(this).attr('id');
		var id_ul = id.replace("pr_","c_");
		// $( this ).toggleClass( "parent_active");
		$("#"+id_ul).addClass('hide');
		//alert(id_ul);
		//alert('fdfd');
	});
}
