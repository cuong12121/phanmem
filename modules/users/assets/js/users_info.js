click_tab_detail(1);

function click_tab_detail(){
	$('.tab_content').load("/index.php?module=users&task=edit&Itemid=40&raw=1");
	$('.users_tabs li').click(function(){
		var id=$(this).attr('id');
		$('.users_tabs').find('.activated').removeClass('activated');
		$('#'+id).addClass('activated');
		if(id == "tab1"){
		$('.tab_content').load("/index.php?module=users&task=edit&Itemid=40&raw=1");
		}
		if(id == "tab2"){
		$('.tab_content').load("/index.php?module=products&view=favourites&Itemid=94&raw=1");
		}
		if(id == "tab3"){
		$('.tab_content').load("/index.php?module=products&view=order&Itemid=45&raw=1");
		}
		if(id == "tab4"){
		$('.tab_content').load("/index.php?module=users&view=point&Itemid=40&raw=1");
		}
		if(id == "tab5"){
		$('.tab_content').load("/index.php?module=users&task=changepass&Itemid=40&raw=1");
		}
		if(id == "tab6"){
		$('.tab_content').load("/index.php?module=messages&task=inbox&Itemid=25&raw=1");
		}
//		$('.users_tab_content').find('.selected').removeClass('selected').addClass('hiden');
//		$('#'+id+'_content').removeClass('hiden').addClass('selected');
	});
}
