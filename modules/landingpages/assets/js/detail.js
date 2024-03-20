run_tab_landing();
function run_tab_landing(){
	$('#tab_item_1').addClass('tab_title_active');
	$('.tab_content').addClass('hide');
	$('#tab_content_1').removeClass('hide');
	$('.tab_item').click(function(){
		var id = $(this).attr('id');
		$('.tab_item').removeClass('tab_title_active');
		$(this).addClass('tab_title_active');
		content_id = id.replace('tab_item_','tab_content_');
		$('.tab_content').addClass('hide');
		$('#'+content_id).removeClass('hide');
	})
}

function GetURLParameter(sParam) {
	var sPageURL = window.location.search.substring(1);
	var sURLVariables = sPageURL.split('&');
	for (var i = 0; i < sURLVariables.length; i++){
		var sParameterName = sURLVariables[i].split('=');
		if (sParameterName[0] == sParam)
		{
			return sParameterName[1];
		}
	}
}

var tab_item = GetURLParameter('tab_item');
if(tab_item) {
	$('.tab_item').removeClass('tab_title_active');
$('#tab_item_'+tab_item).addClass('tab_title_active');
$('.tab_content').addClass('hide');
$('#tab_content_'+tab_item).removeClass('hide');
}

