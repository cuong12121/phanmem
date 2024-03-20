click_tab_detail(1);

function click_tab_detail(){
	$('.users_tabs li').click(function(){
		var id=$(this).attr('id');
		$('.users_tabs').find('.activated').removeClass('activated');
		$('#'+id).addClass('activated');
		if(id == "tab1"){
			$('.tab_content').load("/index.php?module=users&task=edit&raw=1");
		}
		if(id == "tab2"){
			$('.tab_content').load("/index.php?module=users&task=address_book&raw=1");
		}
		if(id == "tab3"){
			$('.tab_content').load("/index.php?module=products&view=order&raw=1");
		}
		if(id == "tab4"){
		}
		if(id == "tab5"){
			$('.tab_content').load("/index.php?module=messages&task=inbox&raw=1");
		}
		if(id == "tab6"){
			$('.tab_content').load("/index.php?module=products&view=favourites&raw=1");
		}
	});
}
