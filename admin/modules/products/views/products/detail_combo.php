<div class="products_combo">
	<table width="100%" bordercolor="#AAA" border="1">
		<tr valign="top">
			<td width="0%" id='products_combo_l' style="display:none" >
				<div class='products_combo_search'>
					<span>Tìm kiếm: </span>
					<input type="text" name='products_combo_keyword' value='' id='products_combo_keyword' />
					<select style="display: none" name="products_combo_category_id"  id="products_combo_category_id">
						<option value="">Danh mục</option>
						<?php 
						foreach ($categories as $item) {
						?>
							<option value="<?php echo $item->id; ?>" ><?php echo $item->treename;  ?> </option>	
						<?php }?>
					</select>
					<input type="button" name='products_combo_search' value='Tìm kiếm' id='products_combo_search' />
				</div>
				<div id='products_combo_search_list'>
				</div>
			</td>
			<td width="100%" id='products_combo_r'>
				<!--	LIST RELATE			-->
				<div class='title'>Sản phẩm combo</div>
					<ul id='products_sortable_combo'>	
						<?php
						$i = 0; 
						if(isset($products_combo))
						foreach ($products_combo as $item) { 
						?>
							<li id='products_record_combo_<?php echo $item ->id?>'><?php echo $item -> name; ?> <a class='products_remove_relate_bt'  onclick="javascript: remove_products_combo(<?php echo $item->id?>)" href="javascript: void(0)" title='Xóa'><img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png"></a> <input type="hidden" name='products_record_combo[]' value="<?php echo $item -> id;?>" /></li>
						<?php }?>
					</ul>
				<!--	end LIST RELATE			-->
				<div id='products_record_combo_continue'></div>
			</td>
		</tr>
	</table>
	<div class='products_close_combo' style="display:none">
		<a href="javascript:products_close_combo()"><strong class='red'>Đóng</strong></a>
	</div>
	<div class='products_add_combo'>
		<a href="javascript:products_add_combo()"><strong class='red'>Thêm sản phẩm combo</strong></a>
	</div>
</div>
<script type="text/javascript" >
search_products_combo();
$( "#products_sortable_combo" ).sortable();
function products_add_combo(){
	$('#products_combo_l').show();
	$('#products_combo_l').attr('width','50%');
	$('#products_combo_r').attr('width','50%');		
	$('.products_close_combo').show();
	$('.products_add_combo').hide();
}
function products_close_combo(){
	$('#products_combo_l').hide();
	$('#products_combo_l').attr('width','0%');
	$('#products_combo_r').attr('width','100%');		
	$('.products_add_combo').show();
	$('.products_close_combo').hide();
}
function search_products_combo(){
	$('#products_combo_search').click(function(){
		var keyword = $('#products_combo_keyword').val();
		var category_id = $('#products_combo_category_id').val();
		var product_id = <?php echo @$data -> id?$data -> id:0?>;
		var str_exist = '';
		$( "#products_sortable_combo li input" ).each(function( index ) {
			if(str_exist != '')
				str_exist += ',';
			str_exist += 	$( this ).val();
		});
		$.get("index2.php?module=products&view=products&task=ajax_get_products_combo&raw=1",{product_id:product_id,category_id:category_id,keyword:keyword,str_exist:str_exist}, function(html){
			$('#products_combo_search_list').html(html);
		});
	});
}
function set_products_combo(id){
	var max_combo = 10;
	var length_children = $( "#products_sortable_combo li" ).length;
	if(length_children >= max_combo ){
		alert('Tối đa chỉ có '+max_combo+' sản phẩm liên quan'	);
		return;
	}
	var title = $('.products_combo_item_'+id).html();                                     
	var html = '<li id="record_combo_'+id+'">'+title+'<input type="hidden" name="products_record_combo[]" value="'+id+'" />';
	html += '<a class="products_remove_relate_bt"  onclick="javascript: remove_products_combo('+id+')" href="javascript: void(0)" title="Xóa"><img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png"></a>';
	html += '</li>';
	$('#products_sortable_combo').append(html);
	$('.products_combo_item_'+id).hide();	
}
function remove_products_combo(id){
	$('#products_record_combo_'+id).remove();
	$('.products_combo_item_'+id).show().addClass('red');	
}
</script>
<style>
.products_combo_search, #products_combo_r .title{
	background: none repeat scroll 0 0 #F0F1F5;
    font-weight: bold;
    margin-bottom: 4px;
    padding: 2px 0 4px;
    text-align: center;
}
#products_combo_search_list{
	height: 400px;
    overflow: scroll;
}
.products_combo_item{
	background: url("/admin/images/page_next.gif") no-repeat scroll right center transparent;
    border-bottom: 1px solid #EEEEEE;
    cursor: pointer;
    margin: 2px 10px;
    padding: 5px;
}
#products_sortable_combo li{
	cursor: move;
    list-style: decimal outside none;
    margin-bottom: 8px;
}
.products_remove_relate_bt{
	padding-left: 10px;
}
.products_combo table{
	margin-bottom: 5px;
}
</style>