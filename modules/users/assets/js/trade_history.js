//click_view_detail(1);
//function click_view_detail(){
//	$('.view-detail-order').click(function(){
//		var link=$(this).attr('rev');
//		alert(link);
//		$('#print_icon').attr('rel',link);
//		var wd_width=$(window).width();
//		$.get(link+'&raw=1',function(response){
//			Dialog.insertDom('zone-view-detail-order','Chi tiết đơn hàng',response);
//			$("#zone-view-detail-order").dialog({open: function() {$(".ui-dialog").css({'width': 'auto','padding':'0px 30px','min-width':'550px','left':'300px;'});},modal:true,shadow:false,close:function(){$('#zone-view-detail-order').remove();}});
//			var dom_width=$('.ui-dialog').width();
//			var dom_left=(wd_width-dom_width)/2;
//			$('.ui-dialog').css({'left':dom_left,'width':dom_width});
//			
//		});
//	});
//}
function OpenPrintOrder()
{
	var link_print=$('#print_icon').attr('rel');
	window.open(link_print+"&print=1");
	return false;
}
change_page_ajax(1);
function change_page_ajax(){
	$('.other-page').click(function(){
		var url=$(this).attr('rev');
		$('.tab_content').load(url);
	});
	$('.first-page').click(function(){
		var url=$(this).attr('rev');
		$('.tab_content').load(url);
	});
	$('.pre-page').click(function(){
		var url=$(this).attr('rev');
		$('.tab_content').load(url);
	});
	$('.next-page').click(function(){
		var url=$(this).attr('rev');
		$('.tab_content').load(url);
	});
	$('.last-page').click(function(){
		var url=$(this).attr('rev');
		$('.tab_content').load(url);
	});
}
load_search_form(1);
function load_search_form(){
	$('.search-order-button').click(function(){
		var url=$(this).attr('lang');
		var date_from=$('#date_from').val();
		var date_to=$('#date_to').val();
		$('.tab_content').load(url+'&date_from='+date_from+'&date_to='+date_to+'&raw=1');
	})
}