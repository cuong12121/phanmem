function submit_form_search_news(){
	itemid = 10; 
	url = '';
	var keyword = $('.keyword_news').val();
	keyword = keyword.replace(' ','-'); 
	// keyword = encodeURIComponent(encodeURIComponent(keyword));
	keyword = encodeURIComponent(keyword);
	var link_search = $('#link_search_news').val();
	if( keyword != '')	{
		url += 	'&keyword='+keyword;
		var check = 1;
	}else{
		var check =0;
	}
	if(check == 0){
		alert('Bạn phải nhập tham số tìm kiếm');
		return false;
	}
	link = link_search	+'/'+keyword+'.html';
    window.location.href=link;
    return false;
}	


// $(document).ready(function() {
// 	$('.searchbt_news').click(function(){
// 		itemid = 10; 
// 		url = '';
// 		var keyword = $(this).prev('.keyword_news').val();
// 		// keyword = encodeURIComponent(encodeURIComponent(keyword));
// 		var link_search = $('#link_search_news').val();
// 		if( keyword != '')	{
// 			url += 	'&keyword='+keyword;
// 			var check = 1;
// 		}else{
// 			var check =0;
// 		}
// 		if(check == 0){
// 			alert('Bạn phải nhập tham số tìm kiếm');
// 			return false;
// 		}
// 			var link = link_search+'/'+keyword+'.html';
	
 
// 	    window.location.href=link;
// 	    return false;
// 		});
// 	$(".keyword_news").bind("keyword_news", {}, keypressInBox2);
// });



function keypressInBox2(e) {
    var code = (e.keyCode ? e.keyCode : e.which);
    if (code == 13) { //Enter keycode                        
        e.preventDefault();
        itemid = 10; 
		url = '';
        var keyword  = $(this).val();
    	keyword = encodeURIComponent(encodeURIComponent(keyword));
		var link_search = $('#link_search_news').val();
		if( keyword != '')	{
			url += 	'&keyword='+keyword;
			var check = 1;
		}else{
			var check =0;
		}
		if(check == 0){
			alert('Bạn phải nhập tham số tìm kiếm');
			return false;
		}
			var link = link_search+'/'+keyword+'.html';

 
	    window.location.href=link;
	    return false;
    }
};
