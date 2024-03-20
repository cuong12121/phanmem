click_tab_detail(1);
function click_tab_detail(){
	$('.news_list_hot_viewest_content li').click(function(){
		var id=$(this).attr('id');
		$('.news_list_hot_viewest_content').find('.activated').removeClass('activated');
		$('#'+id).addClass('activated');
		$('.newslist_tab_content').find('.selected').removeClass('selected').addClass('hiden');
		$('#'+id+'_content').removeClass('hiden').addClass('selected');
	});
}