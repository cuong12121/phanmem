function edit(){
	$('.tab_content').load("/index.php?module=users&task=edit&raw=1");
}
function add_address(){
	$('.tab_content_address').html('');
	$('.tab_content').load("/index.php?module=users&task=add_address&raw=1");
	$('.button_add_address').addClass('hide');
}
function edit_add_other(id){
	$('.tab_content_address').html('');
	$('.tab_content').html('');
	$('.button_add_address').removeClass('hide');
	$('.tab_content_'+id).load("/index.php?module=users&task=edit_address&id="+id+"&raw=1");
}
function remove_address(id){
	var result = confirm("Bạn có chắc muốn xóa địa chỉ này?"); 
	if (result == true) { 
		$.ajax({url: "index.php?module=users&task=remove_address&raw=1",
		data: {id:id},
		dataType: "html",
		success: function(html) {
			window.location.href = "user_address_book.html";
		}
	});
}
}