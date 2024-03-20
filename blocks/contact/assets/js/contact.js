$(document).ready( function(){
	/* FORM CONTACT */
	$('#submitbt').click(function(){
		if(checkFormsubmit())
			document.contact.submit();
	})
	$('#resetbt').click(function(){
		document.contact.reset();
	})
});   
click_view_map(1);
function click_view_map(){
	$('.directCallData').click(function(){
		var add_id=$(this).attr("lang");
		load_map(add_id);
	});
}
function load_map(add_id){
	jQuery.fn.modalBox({ 
		directCall : {
			data : '<iframe src="index.php?module=contact&task=map&id='+add_id+'&raw=1" height="350" width="900">	</iframe>',
		},
		setWidthOfModalLayer : 1000,
	});
}
configAngleNews(1);
function configAngleNews(){
	if($('.image-share').length){
		$("a[rel='example3']").colorbox({transition:"none", width:"800px", height:"550px"});
	}
}