<div class="products_compare">
	<table width="100%" bordercolor="#AAA" border="1">
		<tr valign="top">
			<td width="0%" id='products_compare_l' style="display:none" >
				<div class='products_compare_search'>
					<span>Tìm kiếm: </span>
					<input type="text" name='products_compare_keyword' value='' id='products_compare_keyword' />
					<select name="products_compare_category_id"  id="products_compare_category_id">
						<option value="">Danh mục</option>
						<?php 
						foreach ($categories as $item) {
						?>
							<option value="<?php echo $item->id; ?>" ><?php echo $item->treename;  ?> </option>	
						<?php }?>
					</select>
					<input type="button" name='products_compare_search' value='Tìm kiếm' id='products_compare_search' />
				</div>
				<div id='products_compare_search_list'>
				</div>
			</td>
			<td width="100%" id='products_compare_r'>
				<!--	LIST RELATE			-->
				<div class='title'>Sản phẩm so sánh</div>
					<ul id='products_sortable_compare'>	
						<?php
						$i = 0; 
						if(isset($products_compare))
						foreach ($products_compare as $item) { 
						?>
							<li id='products_record_compare_<?php echo $item ->id?>'><?php echo $item -> name; ?> <a class='products_remove_relate_bt'  onclick="javascript: remove_products_compare(<?php echo $item->id?>)" href="javascript: void(0)" title='Xóa'><img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png"></a> <input type="hidden" name='products_record_compare[]' value="<?php echo $item -> id;?>" /></li>
						<?php }?>
					</ul>
				<!--	end LIST RELATE			-->
				<div id='products_record_compare_continue'></div>
			</td>
		</tr>
	</table>
	<div class='products_close_compare' style="display:none">
		<a href="javascript:products_close_compare()"><strong class='red'>Đóng</strong></a>
	</div>
	<div class='products_add_compare'>
		<a href="javascript:products_add_compare()"><strong class='red'>Thêm Sp để so sánh</strong></a>
	</div>
</div>
<script type="text/javascript" >
search_products_compare();
$( "#products_sortable_compare" ).sortable();
function products_add_compare(){
	$('#products_compare_l').show();
	$('#products_compare_l').attr('width','50%');
	$('#products_compare_r').attr('width','50%');		
	$('.products_close_compare').show();
	$('.products_add_compare').hide();
}
function products_close_compare(){
	$('#products_compare_l').hide();
	$('#products_compare_l').attr('width','0%');
	$('#products_compare_r').attr('width','100%');		
	$('.products_add_compare').show();
	$('.products_close_compare').hide();
}
function search_products_compare(){
	$('#products_compare_search').click(function(){
		var keyword = $('#products_compare_keyword').val();
		var category_id = $('#products_compare_category_id').val();
		var product_id = <?php echo @$data -> id?$data -> id:0?>;
		var str_exist = '';
		$( "#products_sortable_compare li input" ).each(function( index ) {
			if(str_exist != '')
				str_exist += ',';
			str_exist += 	$( this ).val();
		});
		$.get("index2.php?module=products&view=products&task=ajax_get_products_compare&raw=1",{product_id:product_id,category_id:category_id,keyword:keyword,str_exist:str_exist}, function(html){
			$('#products_compare_search_list').html(html);
		});
	});
}
function set_products_compare(id){
	var max_compare = 10;
	var length_children = $( "#products_sortable_compare li" ).length;
	if(length_children >= max_compare ){
		alert('Tối đa chỉ có '+max_compare+' sản phẩm liên quan'	);
		return;
	}
	var title = $('.products_compare_item_'+id).html();                                     
	var html = '<li id="products_record_compare_'+id+'">'+title+'<input type="hidden" name="products_record_compare[]" value="'+id+'" />';
	html += '<a class="products_remove_relate_bt"  onclick="javascript: remove_products_compare('+id+')" href="javascript: void(0)" title="Xóa"><img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png"></a>';
	html += '</li>';
	$('#products_sortable_compare').append(html);
	$('.products_compare_item_'+id).hide();	
}
function remove_products_compare(id){
	$('#products_record_compare_'+id).remove();
	$('.products_compare_item_'+id).show().addClass('red');	
}
</script>
<style>
.products_compare_search, #products_compare_r .title{
	 background: none repeat scroll 0 0 #F0F1F5;
    font-weight: bold;
    margin-bottom: 4px;
    padding: 2px 0 4px;
    text-align: center;
}
#products_compare_search_list{
	height: 400px;
    overflow: scroll;
}
.products_compare_item{
	background: url("/admin/images/page_next.gif") no-repeat scroll right center transparent;
    border-bottom: 1px solid #EEEEEE;
    cursor: pointer;
    margin: 2px 10px;
    padding: 5px;
}
#products_sortable_compare li{
	cursor: move;
    list-style: decimal outside none;
    margin-bottom: 8px;
}
.products_remove_relate_bt{
	padding-left: 10px;
}
.products_compare table{
	margin-bottom: 5px;
}
</style>