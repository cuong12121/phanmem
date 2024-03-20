<div class="products_related">
	<table width="100%" bordercolor="#AAA" border="1">
		<tr valign="top">
			<td width="0%" id='products_related_l' style="display:none" >
				<div class='products_related_search'>
					<span>Tìm kiếm: </span>
					<input type="text" name='products_related_keyword' value='' id='products_related_keyword' />
					<select name="products_related_category_id"  id="products_related_category_id">
						<option value="">Danh mục</option>
						<?php 
						foreach ($products_categories as $item) {
						?>
							<option value="<?php echo $item->id; ?>" ><?php echo $item->treename;  ?> </option>	
						<?php }?>
					</select>
					<input type="button" name='products_related_search' value='Tìm kiếm' id='products_related_search' />
				</div>
				<div id='products_related_search_list'>
				</div>
			</td>
			<td width="100%" id='products_related_r'>
				<!--	LIST RELATE			-->
				<div class='title'>Sản phẩm liên quan</div>
					<ul id='products_sortable_related'>	
						<?php
						$i = 0; 
						if(isset($products_related))
						foreach ($products_related as $item) { 
						?>
							<li id='products_record_related_<?php echo $item ->id?>'><?php echo $item -> name; ?> <a class='products_remove_relate_bt'  onclick="javascript: remove_products_related(<?php echo $item->id?>)" href="javascript: void(0)" title='Xóa'><img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png"></a> <input type="hidden" name='products_record_related[]' value="<?php echo $item -> id;?>" /></li>
						<?php }?>
					</ul>
				<!--	end LIST RELATE			-->
				<div id='products_record_related_continue'></div>
			</td>
		</tr>
	</table>
	<div class='products_close_related' style="display:none">
		<a href="javascript:products_close_related()"><strong class='red'>Đóng</strong></a>
	</div>
	<div class='products_add_related'>
		<a href="javascript:products_add_related()"><strong class='red'>Thêm sản phẩm liên quan</strong></a>
	</div>
</div>
<script type="text/javascript" >
search_products_related();
$( "#products_sortable_related" ).sortable();
function products_add_related(){
	$('#products_related_l').show();
	$('#products_related_l').attr('width','50%');
	$('#products_related_r').attr('width','50%');		
	$('.products_close_related').show();
	$('.products_add_related').hide();
}
function products_close_related(){
	$('#products_related_l').hide();
	$('#products_related_l').attr('width','0%');
	$('#products_related_r').attr('width','100%');		
	$('.products_add_related').show();
	$('.products_close_related').hide();
}
function search_products_related(){
	$('#products_related_search').click(function(){
		var keyword = $('#products_related_keyword').val();
		var category_id = $('#products_related_category_id').val();
		var str_exist = '';
		$( "#products_sortable_related li input" ).each(function( index ) {
			if(str_exist != '')
				str_exist += ',';
			str_exist += 	$( this ).val();
		});
		$.get("index2.php?module=products&view=products&task=ajax_get_products_related&raw=1",{category_id:category_id,keyword:keyword,str_exist:str_exist}, function(html){
			$('#products_related_search_list').html(html);
		});
	});
}
function set_products_related(id){
	var max_related = 10;
	var length_children = $( "#products_sortable_related li" ).length;
	if(length_children >= max_related ){
		alert('Tối đa chỉ có '+max_related+' sản phẩm liên quan'	);
		return;
	}
	var title = $('.products_related_item_'+id).html();                                     
	var html = '<li id="record_related_'+id+'">'+title+'<input type="hidden" name="products_record_related[]" value="'+id+'" />';
	html += '<a class="products_remove_relate_bt"  onclick="javascript: remove_products_related('+id+')" href="javascript: void(0)" title="Xóa"><img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png"></a>';
	html += '</li>';
	$('#products_sortable_related').append(html);
	$('.products_related_item_'+id).hide();	
}
function remove_products_related(id){
	$('#products_record_related_'+id).remove();
	$('.products_related_item_'+id).show().addClass('red');	
}
</script>
<style>
.products_related_search, #products_related_r .title{
	 background: none repeat scroll 0 0 #F0F1F5;
    font-weight: bold;
    margin-bottom: 4px;
    padding: 2px 0 4px;
    text-align: center;
}
#products_related_search_list{
	height: 400px;
    overflow: scroll;
}
.products_related_item{
	background: url("/admin/images/page_next.gif") no-repeat scroll right center transparent;
    border-bottom: 1px solid #EEEEEE;
    cursor: pointer;
    margin: 2px 10px;
    padding: 5px;
}
#products_sortable_related li{
	cursor: move;
    list-style: decimal outside none;
    margin-bottom: 8px;
}
.products_remove_relate_bt{
	padding-left: 10px;
}
.products_related table{
	margin-bottom: 5px;
}
</style>