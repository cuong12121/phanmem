<?php $url_current =  $_SERVER['REQUEST_URI'];?>
<div class="subcat filter">
	<div class="subcat-title">
		<B><?php echo "DANH M&#7908;C C&#7844;P CON"; ?> </B>
	</div>
	<div class="subcat-boder">
		<div class="subcat-boder-inner">
			<ul>
			
				<!--	FILTER		-->
				<?php
					echo $htmt_filter;
				?>
				<!--	FILTER		-->
				
			</ul>
		</div>
	</div>
	<div class="subcat-footer"></div>
</div>

<script type="text/javascript">
$('#prd_search_form_button').click(function(){
	cid = <?php echo CInput::get('cid',0,'int'); ?>;
	Itemid = <?php echo CInput::get('Itemid',0,'int'); ?>;
	is_rewrite = <?php echo IS_REWRITE; ?>;
	url_root = '<?php echo URL_ROOT; ?>';
	price_from = $('#price_from').val();
	price_to = $('#price_to').val();
	
	
	if(is_rewrite){
		url = url_root+'product_list/' + cid + ',new,horizontal/search.html';
		if(price_from)
			url = url+'&pricef='+price_from;
		if(price_to)
			url = url+'&pricet='+price_to;	
		
		window.location.href = url;
		
	} else {
		url = url_root+'index.php?module=products&view=cats&cid=' + cid + '&Itemid=' +Itemid; 
		if(price_from)
			url = url+'&pricef='+price_from;
		if(price_to)
			url = url+'&pricet='+price_to;	
		window.location.href = url;
	}
	
	
});
function formatCurrency(div_id, str_number){
	$('#'+div_id).html(addCommas(str_number));
}
function addCommas(nStr){

	nStr += ''; x = nStr.split(',');	x1 = x[0]; x2 = ""; x2 = x.length > 1 ? ',' + x[1] : ''; var rgx = /(\d+)(\d{3})/; while (rgx.test(x1)) { x1 = x1.replace(rgx, '$1' + '.' + '$2'); } return x1 + x2;

}


</script>