$(document).ready(function(){
	$(".title-question").click(function(){
		$(this).parent(".item-question").addClass("title-ac");
		$(this).parent(".item-question").siblings('.item-question').removeClass("title-ac");
		$(this).parent(".item-question").siblings('.item-question').children('.reply-question').hide();
		$(this).siblings('.reply-question').show();
	});

	$(".view-plus").click(function(){
		$(this).parent(".title-cat").parent(".item-cat").addClass("item-ac");
		$(this).parent(".title-cat").parent(".item-cat").siblings('.item-cat').removeClass("item-ac");
		// $(this).parent(".title-cat").parent(".item-cat").addClass("title-ac");
		// $(this).parent(".title-cat").parent(".item-cat").siblings('.item-cat').removeClass("item-ac");
		// $(this).parent(".title-cat").parent(".item-cat").siblings('.item-cat').children('.list-question').children('.item-question').children('.title-question').removeClass("title-ac").hide();
		// $(this).parent(".title-cat").parent(".item-cat").siblings('.item-cat').children('.list-question').children('.item-question').children('.reply-question').hide();
	});
});