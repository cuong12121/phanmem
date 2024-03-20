function submit_form_search(){
	itemid = 10; 
	url = '';
	var keyword = $('#keyword').val();
	keyword = keyword.replace(' ','+'); 
	keyword = encodeURIComponent(encodeURIComponent(keyword));
	var link_search = $('#link_search').val();
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
	link = link_search.replace('keyword',keyword);
    window.location.href=link;
    return false;
}	
$(document).ready(function(){
	$('#keyword').autocomplete({
		serviceUrl:"/index.php?module=products&view=search&raw=1&task=get_ajax_search",
		groupBy:"brand",
		minChars:2,
		formatResult:function(n,t){
			t=t.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g,"\\$&");
			var i=n.data.text.split(" "),r="";
			for(j=0;j<i.length;j++)
				r+=t.toLowerCase().indexOf(i[j].toLowerCase())>=0?"<strong>"+i[j]+"</strong> ":i[j]+" ";
			return' <a href = "'+n.value+'" > <img src = "'+n.data.image+'" /> <label> <span> '+r+' </span> <span class = "price"> '+n.data.price+"</span></label></a>"
		},
		onSelect:function(n){
			$(".control input[name=kwd]").val(n.data.text)
		}
		});
});
