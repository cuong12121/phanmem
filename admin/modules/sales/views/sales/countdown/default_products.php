<div class="products_countdown">
	<table width="100%" bordercolor="#AAA" border="1">
		<tr valign="top">
			<td width="0%" id='products_countdown_l' style="display:none" >
				<div class='products_countdown_search'>
					<span>Tìm kiếm: </span>
					<input type="text" name='products_countdown_keyword' value='' id='products_countdown_keyword' />
					<select style="display: none" name="products_countdown_category_id"  id="products_countdown_category_id">
						<option value="">Danh mục</option>
						<?php 
						foreach ($products_categories as $item) {
						?>
							<option value="<?php echo $item->id; ?>" ><?php echo $item->treename;  ?> </option>	
						<?php }?>
					</select>
					<input type="button" name='products_countdown_search' value='Tìm kiếm' id='products_countdown_search' />
				</div>
				<div id='products_countdown_search_list'>
				</div>
			</td>
			<td width="100%" id='products_countdown_r'>
				<!--	LIST RELATE			-->
				<div class='title'>Chọn sản phẩm</div>
					<ul id='products_countdown_sortable'>	
						<?php
						$i = 0; 
						if(isset($products_countdown))
						foreach ($products_countdown as $item) { 
						?>
							<li id='countdown_products_item_selected_<?php echo $item ->id?>'>
								<span class="item_title"><?php echo $item -> name.' <strong>('.$item->unit.')</strong> ' ?></span>
								<span class="item_price_old">Giá cũ: <input type="text" name="price_old_value_<?php echo $item ->id?>" disabled="disabled" value="<?php echo format_money($item -> price_old,'','0'); ?>"/></span>

								<span class="item_price_old">Giá KM: <input type="text" name="price_value_<?php echo $item ->id?>" value="<?php echo format_money($item -> price,'','0'); ?>"/></span>

								<span class="item_price_old">Số lượng bán: <input type="text" name="total_item_<?php echo $item ->id?>" value="<?php echo $item -> total_item; ?>"/></span>

								<span class="item_price_old">Đã bán: <input type="text" name="total_item_buy_<?php echo $item ->id?>" value="<?php echo $item -> total_item_buy; ?>"/></span>

								<span class="item_price_old">Thứ tự: <input type="text" name="ordering_<?php echo $item ->id?>" value="<?php echo $item -> ordering; ?>"/></span>

								

								<a class='news_remove_relate_bt'  onclick="javascript: remove_products_countdown(<?php echo $item->id?>)" href="javascript: void(0)" title='Xóa'><img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png"></a> <input type="hidden" name='countdown_products[]' value="<?php echo $item -> id;?>" />
							</li>
						<?php }?>
					</ul>
				<!--	end LIST RELATE			-->
				<div id='countdown_products_continue'></div>
			</td>
		</tr>
	</table>
	<div class='news_close_related' style="display:none">
		<a href="javascript:news_close_related()"><strong class='red'>Đóng</strong></a>
	</div>
	<div class='news_add_related'>
		<a href="javascript:news_add_related()"><strong class='red'>Thêm sản phẩm</strong></a>
	</div>
</div>
<script type="text/javascript" >
search_products_countdown();
$( "#products_countdown_sortable" ).sortable();
function news_add_related(){
	$('#products_countdown_l').show();
	$('#products_countdown_l').attr('width','50%');
	$('#products_countdown_r').attr('width','50%');		
	$('.news_close_related').show();
	$('.news_add_related').hide();
}
function news_close_related(){
	$('#products_countdown_l').hide();
	$('#products_countdown_l').attr('width','0%');
	$('#products_countdown_r').attr('width','100%');		
	$('.news_add_related').show();
	$('.news_close_related').hide();
}
function search_products_countdown(){
	$('#products_countdown_search').click(function(){
		var keyword = $('#products_countdown_keyword').val();
		var category_id = $('#products_countdown_category_id').val();
		var str_exist = '';
		$( "#products_countdown_sortable li input" ).each(function( index ) {
			if(str_exist != '')
				str_exist += ',';
			str_exist += 	$( this ).val();
		});
		$.get("index2.php?module=sales&view=sales&task=ajax_get_products_countdown&raw=1",{category_id:category_id,keyword:keyword,str_exist:str_exist}, function(html){
			$('#products_countdown_search_list').html(html);
		});
	});
}
function set_products_countdown(id){
	var max_related = 100;
	var length_children = $( "#products_countdown_sortable li" ).length;
	if(length_children >= max_related ){
		alert('Tối đa chỉ có '+max_related+' tin liên quan'	);
		return;
	}
	var title = $('.products_countdown_item_'+id).html();                                     
	var price = $('#price_countdown_'+id).html();                                     
	var html = '<li id="countdown_products_item_selected_'+id+'">';
	html += '<span class="item_title">'+title+'<input type="hidden" name="countdown_products[]" value="'+id+'" /></span>';
	html += '<span class="item_price_old">Giá cũ: <input type="text" name="price_old_value_'+id+'" disabled="disabled" value="'+price+'"/></span>';
	html += '<span class="item_price">Giá KM: <input type="text" name="price_value_'+id+'" value="" /></span>';
	html += '<span class="item_price">Số lượng bán: <input type="text" name="total_item_'+id+'" value="" /></span>';
	html += '<span class="item_price">Đã bán: <input type="text" name="total_item_buy_'+id+'" value="" /></span>';
	html += '<span class="item_price">Thứ tự: <input type="text" name="ordering_'+id+'" value="" /></span>';

	html += '<a class="news_remove_relate_bt"  onclick="javascript: remove_products_countdown('+id+')" href="javascript: void(0)" title="Xóa"><img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png"></a>';
	html += '</li>';
	$('#products_countdown_sortable').append(html);
	$('.products_countdown_item_'+id).hide();	
}
function remove_products_countdown(id){
	$('#countdown_products_item_selected_'+id).remove();
	$('.products_countdown_item_'+id).show().addClass('red');	
}
</script>
<style>
.products_countdown_search, #products_countdown_r .title{
	 background: none repeat scroll 0 0 #F0F1F5;
    font-weight: bold;
    margin-bottom: 4px;
    padding: 2px 0 4px;
    text-align: center;
}
#products_countdown_search_list{
	height: 400px;
    overflow: scroll;
}
.products_countdown_item{
	background: url("/admin/images/page_next.gif") no-repeat scroll right center transparent;
    border-bottom: 1px solid #EEEEEE;
    cursor: pointer;
    margin: 2px 10px;
    padding: 5px;
}
#products_countdown_sortable li{
	cursor: move;
    list-style: decimal outside none;
    margin-bottom: 8px;
    border-bottom: 1px solid #EEE;
    padding-bottom: 6px;
}
#products_countdown_sortable li .red{
	display: none;
}
#products_countdown_sortable li .item_title{
    display: inline-block;
    width: 40%;
}
#products_countdown_sortable li .item_price_old,
#products_countdown_sortable li .item_price{
    display: inline-block;
    width: 20%;
}
#products_countdown_sortable li input[type="text"]{
	width: 85px;
}
.news_remove_relate_bt{
	padding-left: 10px;
}
.products_countdown table{
	margin-bottom: 5px;
}
</style>