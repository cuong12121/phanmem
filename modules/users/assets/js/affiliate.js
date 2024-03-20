$(document).ready( function(){

})

function copy_link_affilate(){
	/* Get the text field */
	var copyText = document.getElementById("link_affilate");
	/* Select the text field */
	copyText.select();
	copyText.setSelectionRange(0, 99999); /*For mobile devices*/

	/* Copy the text inside the text field */
	document.execCommand("copy");
  // alert("Đã copy link: " + copyText.value);
  showEror('link_affilate','Đã copy link');


}

function copy_link_pro(product_id){
	/* Get the text field */
	var copyText = document.getElementById("link_"+product_id);
	/* Select the text field */
	copyText.select();
	copyText.setSelectionRange(0, 99999); /*For mobile devices*/
	/* Copy the text inside the text field */
	document.execCommand("copy");
  // alert("Đã copy link: " + copyText.value);
  showEror("link_"+product_id,'Đã copy link');
  


}




function get_cats(id){
	$('.acat').removeClass('active');
	$('#acat_'+id).addClass('active');

}

function search_products(page){
	var name = $('#name_search').val();
	var cid = $('#cat_search').val();
	$.ajax({
		type: "POST",
		url: "/index.php?module=users&task=search_products&raw=1",
		data: {name: name, cid:cid,page: page },
		cache: false,
		success: function(html){
			$(".list_prducts").html(html);
			$('html, body').animate({ scrollTop: $('#title_head_content').offset().top }, 500);
		}
	});
}


function filter_orders_affi(user_id){
	var month = $('#ofmonth').val();
	var year = $('#ofyear').val();
	$.ajax({
		type : 'get',
		url : '/index.php?module=users&raw=1&task=load_orderaffi_monthyear',
		dataType : 'html',
		data: {month:month,year:year,user_id:user_id},
		success : function(data){
			$('.list_history_order').html(data);
		},
		error : function(XMLHttpRequest, textStatus, errorThrown) {}
	});
}