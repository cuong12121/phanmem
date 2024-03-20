<div class="products_gift">
	<table width="100%" bordercolor="#AAA" border="1">
		<tr valign="top">
			<td width="0%" id='products_gift_l' style="display:none" >
				<div class='products_gift_search'>
					<span>Tìm kiếm: </span>
					<input type="text" name='products_gift_keyword' value='' id='products_gift_keyword' />
					
					<input type="button" name='products_gift_search' value='Tìm kiếm' id='products_gift_search' />
				</div>
				<div id='products_gift_search_list'>
				</div>
			</td>
			<td width="100%" id='products_gift_r'>
				<!--	LIST RELATE			-->
				<div class='title'>Quà tặng</div>
					<ul id='products_sortable_gift'>	
						<?php
						$i = 0; 
						if(isset($products_gift))
						foreach ($products_gift as $item) { 
						?>
							<li id='products_record_gift_<?php echo $item ->id?>'><?php echo $item -> name; ?> <a class='products_remove_relate_bt'  onclick="javascript: remove_products_gift(<?php echo $item->id?>)" href="javascript: void(0)" title='Xóa'><img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png"></a> <input type="hidden" name='products_record_gift[]' value="<?php echo $item -> id;?>" /></li>
						<?php }?>
					</ul>
				<!--	end LIST RELATE			-->
				<div id='products_record_gift_continue'></div>
			</td>
		</tr>
	</table>
	<div class='products_close_gift' style="display:none">
		<a href="javascript:products_close_gift()"><strong class='red'>Đóng</strong></a>
	</div>
	<div class='products_add_gift'>
		<a href="javascript:products_add_gift()"><strong class='red'>Thêm quà tặng</strong></a>
	</div>
</div>
<script type="text/javascript" >
search_products_gift();
$( "#products_sortable_gift" ).sortable();
function products_add_gift(){
	$('#products_gift_l').show();
	$('#products_gift_l').attr('width','50%');
	$('#products_gift_r').attr('width','50%');		
	$('.products_close_gift').show();
	$('.products_add_gift').hide();
}
function products_close_gift(){
	$('#products_gift_l').hide();
	$('#products_gift_l').attr('width','0%');
	$('#products_gift_r').attr('width','100%');		
	$('.products_add_gift').show();
	$('.products_close_gift').hide();
}
function search_products_gift(){
	$('#products_gift_search').click(function(){
		var keyword = $('#products_gift_keyword').val();
		var category_id = $('#products_gift_category_id').val();
		var str_exist = '';
		$( "#products_sortable_gift li input" ).each(function( index ) {
			if(str_exist != '')
				str_exist += ',';
			str_exist += 	$( this ).val();
		});
		$.get("index2.php?module=products&view=gift&task=ajax_get_products_gift&raw=1",{category_id:category_id,keyword:keyword,str_exist:str_exist}, function(html){
			$('#products_gift_search_list').html(html);
		});
	});
}
function set_products_gift(id){
	var max_gift = 10;
	var length_children = $( "#products_sortable_gift li" ).length;
	if(length_children >= max_gift ){
		alert('Tối đa chỉ có '+max_gift+' tin liên quan'	);
		return;
	}
	var title = $('.products_gift_item_'+id).html();                                     
	var html = '<li id="record_gift_'+id+'">'+title+'<input type="hidden" name="products_record_gift[]" value="'+id+'" />';
	html += '<a class="products_remove_relate_bt"  onclick="javascript: remove_products_gift('+id+')" href="javascript: void(0)" title="Xóa"><img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png"></a>';
	html += '</li>';
	$('#products_sortable_gift').append(html);
	$('.products_gift_item_'+id).hide();	
}
function remove_products_gift(id){
	$('#products_record_gift_'+id).remove();
	$('.products_gift_item_'+id).show().addClass('red');	
}
</script>
<style>
.products_gift_search, #products_gift_r .title{
	 background: none repeat scroll 0 0 #F0F1F5;
    font-weight: bold;
    margin-bottom: 4px;
    padding: 2px 0 4px;
    text-align: center;
}
#products_gift_search_list{
	height: 400px;
    overflow: scroll;
}
.products_gift_item{
	background: url("/admin/images/page_next.gif") no-repeat scroll right center transparent;
    border-bottom: 1px solid #EEEEEE;
    cursor: pointer;
    margin: 2px 10px;
    padding: 5px;
}
#products_sortable_gift li{
	cursor: move;
    list-style: decimal outside none;
    margin-bottom: 8px;
}
.products_remove_relate_bt{
	padding-left: 10px;
}
.products_gift table{
	margin-bottom: 5px;
}
</style>