<div class="products_add">
	<table width="100%" bordercolor="#AAA" border="1">
		<tr valign="top">
			<td width="0%" id='products_add_l' style="display:none" >
				<div class='products_add_search'>
					<span>Tìm kiếm: </span>
					<input type="text" name='products_add_keyword' value='' id='products_add_keyword' />
					<select name="products_add_category_id"  id="products_add_category_id">
						<option value="">Danh mục</option>
						<?php 
						foreach ($products_categories as $item) {
						?>
							<option value="<?php echo $item->id; ?>" ><?php echo $item->treename;  ?> </option>	
						<?php }?>
					</select>
					<input type="button" name='products_add_search' value='Tìm kiếm' id='products_add_search' />
				</div>
				<div id='products_add_search_list'>
				</div>
			</td>
			<td width="100%" id='products_add_r'>
				<!--	LIST RELATE			-->
				<div class='title'>Chọn combo</div>
					<ul id='products_add_sortable'>	
						<?php
						$i = 0; 
						if(isset($products_in_sale))
						foreach ($products_in_sale as $item) { 
						?>
							<li id='add_products_item_selected_<?php echo $item ->id?>'>
								<span class="item_title"><?php echo $item -> name ?></span>
								<span class="item_price_old">Giá cũ: <input type="text" name="price_old_value_<?php echo $item ->id?>" disabled="disabled" value="<?php echo format_money($item -> price_old,'','0'); ?>"/></span>
								<a class='news_remove_relate_bt'  onclick="javascript: remove_products_add(<?php echo $item->id?>)" href="javascript: void(0)" title='Xóa'><img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png"></a> <input type="hidden" name='add_products[]' value="<?php echo $item -> id;?>" />
								<input type="hidden" name='add_products[]' value="<?php echo $item -> id;?>" />
							</li>
						<?php }?>
					</ul>
				<!--	end LIST RELATE			-->
				<div id='add_products_continue'></div>
			</td>
		</tr>
	</table>
	<div class='news_close_related' style="display:none">
		<a href="javascript:news_close_related()"><strong class='red'>Đóng</strong></a>
	</div>
	<div class='news_add_related'>
		<a href="javascript:news_add_related()"><strong class='red'>Thêm combo</strong></a>
	</div>
</div>
<script type="text/javascript" >
search_products_add();
$( "#products_add_sortable" ).sortable();
function news_add_related(){
	$('#products_add_l').show();
	$('#products_add_l').attr('width','50%');
	$('#products_add_r').attr('width','50%');		
	$('.news_close_related').show();
	$('.news_add_related').hide();
}
function news_close_related(){
	$('#products_add_l').hide();
	$('#products_add_l').attr('width','0%');
	$('#products_add_r').attr('width','100%');		
	$('.news_add_related').show();
	$('.news_close_related').hide();
}
function search_products_add(){
	$('#products_add_search').click(function(){
		var keyword = $('#products_add_keyword').val();
		var category_id = $('#products_add_category_id').val();
		var str_exist = '';
		$( "#products_add_sortable li input" ).each(function( index ) {
			if(str_exist != '')
				str_exist += ',';
			str_exist += 	$( this ).val();
		});
		$.get("index2.php?module=sales&view=sales&task=ajax_get_products_comboselectgift&raw=1",{category_id:category_id,keyword:keyword,str_exist:str_exist}, function(html){
			$('#products_add_search_list').html(html);
		});
	});
}
function set_products_add(id){
	var max_related = 100;
	var length_children = $( "#products_add_sortable li" ).length;
	if(length_children >= max_related ){
		alert('Tối đa chỉ có '+max_related+' tin liên quan'	);
		return;
	}
	var title = $('.products_add_item_'+id).html();                                     
	var price = $('#price_add_'+id).html();                                     
	var html = '<li id="add_products_item_selected_'+id+'">';
	html += '<span class="item_title">'+title+'<input type="hidden" name="add_products[]" value="'+id+'" /></span>';
	html += '<span class="item_price_old">Giá cũ: <input type="text" name="price_old_value_'+id+'" disabled="disabled" value="'+price+'"/></span>';
	html += '<a class="news_remove_relate_bt"  onclick="javascript: remove_products_add('+id+')" href="javascript: void(0)" title="Xóa"><img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png"></a>';
	html += '</li>';
	$('#products_add_sortable').append(html);
	$('.products_add_item_'+id).hide();	
}
function remove_products_add(id){
	$('#add_products_item_selected_'+id).remove();
	$('.products_add_item_'+id).show().addClass('red');	
}
</script>
<style>
.products_add_search, #products_add_r .title{
	 background: none repeat scroll 0 0 #F0F1F5;
    font-weight: bold;
    margin-bottom: 4px;
    padding: 2px 0 4px;
    text-align: center;
}
#products_add_search_list{
	height: 400px;
    overflow: scroll;
}
.products_add_item{
	background: url("/admin/images/page_next.gif") no-repeat scroll right center transparent;
    border-bottom: 1px solid #EEEEEE;
    cursor: pointer;
    margin: 2px 10px;
    padding: 5px;
}
#products_add_sortable li{
	cursor: move;
    list-style: decimal outside none;
    margin-bottom: 8px;
    border-bottom: 1px solid #EEE;
    padding-bottom: 6px;
}
#products_add_sortable li .red{
	display: none;
}
#products_add_sortable li .item_title{
    display: inline-block;
    width: 40%;
}
#products_add_sortable li .item_price_old,
#products_add_sortable li .item_price{
    display: inline-block;
    width: 20%;
}
#products_add_sortable li input[type="text"]{
	width: 85px;
}
.news_remove_relate_bt{
	padding-left: 10px;
}
.products_add table{
	margin-bottom: 5px;
}
</style>