select_city();
expand_filter();
action_filter();
open_close_manu();
// SubmitFrm ();

function price_filter(){
	var price_link_rewrite = $('#price_link_rewrite').val();
	var price_f = $('#price_f').val();
	var price_t = $('#price_t').val();
	if(price_link_rewrite == '' || (price_t == '' && price_f == '')){
		return false;
	}
	if(price_f == '')price_f = 0;
	if(price_t == '')price_t = 0;
	price_f = price_f.replace(/([\.\,\s]*)/g,'');
	price_t = price_t.replace(/([\.\,\s]*)/g,'');
	price_link_rewrite = price_link_rewrite.replace(/gia-([0-9\-]+)/, "gia-"+price_f+'-'+price_t);
//	console.log(price_link_rewrite);
	window.location.href=price_link_rewrite;
	return false;
}
// function  SubmitFrm (){ 

//         var  Searchtxt  = document . getElementById ( "txtSearch" ). value ; 
//         window . location =  "http://www.de"  +  Searchtxt ; 
//    } 

function select_city(){
	$('#select_city_id').change(function(){
		var link = this.value;
		window.location.href=link;
	});
}

function open_close_manu(){
	$('.manu_item_inner').click(function(e){
		var pmodel = $(this).next('.pmodels_sub');
		if(pmodel.hasClass('hiden')){
			pmodel.removeClass('hiden');
		}else{
			pmodel.addClass('hiden');
		}
	});
}
function expand_filter(){
	$('.sub_block_title').click(function(e){
		var id = $(this).attr('data-id');
			$( this ).children().toggleClass( "active" );
			$('#'+id).toggle();
	});
}
function action_filter(){
	$('.expand_bt').click(function(){
		lang_subtract = $(this).attr('lang_subtract');
		lang_plus = $(this).attr('lang_plus');
		if($(this).hasClass('plus')){
			$(this).removeClass('plus').addClass('subtract');
			$(this).html(lang_subtract);
			$(this).parent().prev().css('max-height', "none");
		}else{
			$(this).parent().prev().css('max-height', "162px");
			$(this).addClass('plus').removeClass('subtract');
			$(this).html(lang_plus);
		}
	});
}