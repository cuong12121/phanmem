
$(document).ready(function(){
	search_compare();
}); 
function search_compare(){
	var table_name = $('#table_name').val();
	var ids = $('#records_id').val();
	var codes = $('#records_alias').val();
	$('#compare_name').autocomplete({
		serviceUrl:"/index.php?module=products&view=search&raw=1&task=get_ajax_search_compare&table_name="+table_name+"&codes="+codes+"&ids="+ids,
		groupBy:"",
		minChars:2,
		containerClass: 'autocomplete-suggestions-compare',
		width: '300',
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
}


function export_file(){

  var str_ids_product = $('#str_ids_product').val();
  var url = window.location.hostname
  $.ajax({
    type : 'POST',
    url : 'index.php?module=products&view=compare&raw=1&task=save_pdf',
    dataType : 'text',
    data: {
     	str_ids_product:str_ids_product
    },
    success : function(data){
     	window.open( "http://"+url+"/export-pdf.html", "_blank");
    },
    error : function(XMLHttpRequest, textStatus, errorThrown) {
     	alert('Vui long thu lai.');
    }
  });
}