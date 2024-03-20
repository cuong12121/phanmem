<div class="products_service">
	<table width="100%" bordercolor="#AAA" border="1">
		<tr valign="top">
			<td width="0%" id='products_service_l' style="display:none" >
				<div class='products_service_search'>
					<span>Tìm kiếm: </span>
					<input type="text" name='products_service_keyword' value='' id='products_service_keyword' />
					<select name="products_service_category_id"  id="products_service_category_id">
						<option value="">Danh mục</option>
						<?php 
						foreach ($categories as $item) {
						?>
							<option value="<?php echo $item->id; ?>" ><?php echo $item->treename;  ?> </option>	
						<?php }?>
					</select>
					<input type="button" name='products_service_search' value='Tìm kiếm' id='products_service_search' />
				</div>
				<div id='products_service_search_list'>
				</div>
			</td>
			<td width="100%" id='products_service_r'>
				<!--	LIST RELATE			-->
				<div class='title'>Dịch vụ sửa chữa</div>
					<ul id='products_sortable_service'>	
						<?php
						$i = 0; 
						if(isset($products_service))
						foreach ($products_service as $item) { 
						?>
							<li id='products_record_service_<?php echo $item ->id?>'><?php echo $item -> name; ?> <a class='products_remove_relate_bt'  onclick="javascript: remove_products_service(<?php echo $item->id?>)" href="javascript: void(0)" title='Xóa'><img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png"></a> <input type="hidden" name='products_record_service[]' value="<?php echo $item -> id;?>" /></li>
						<?php }?>
					</ul>
				<!--	end LIST RELATE			-->
				<div id='products_record_service_continue'></div>
			</td>
		</tr>
	</table>
	<div class='products_close_service' style="display:none">
		<a href="javascript:products_close_service()"><strong class='red'>Đóng</strong></a>
	</div>
	<div class='products_add_service'>
		<a href="javascript:products_add_service()"><strong class='red'>Thêm dịch vụ</strong></a>
	</div>
</div>
<script type="text/javascript" >
search_products_service();
$( "#products_sortable_service" ).sortable();
function products_add_service(){
	$('#products_service_l').show();
	$('#products_service_l').attr('width','50%');
	$('#products_service_r').attr('width','50%');		
	$('.products_close_service').show();
	$('.products_add_service').hide();
}
function products_close_service(){
	$('#products_service_l').hide();
	$('#products_service_l').attr('width','0%');
	$('#products_service_r').attr('width','100%');		
	$('.products_add_service').show();
	$('.products_close_service').hide();
}
function search_products_service(){
	$('#products_service_search').click(function(){
		var keyword = $('#products_service_keyword').val();
		var category_id = $('#products_service_category_id').val();
		var product_id = <?php echo @$data -> id?$data -> id:0?>;
		var str_exist = '';
		$( "#products_sortable_service li input" ).each(function( index ) {
			if(str_exist != '')
				str_exist += ',';
			str_exist += 	$( this ).val();
		});
		$.get("index2.php?module=products&view=products&task=ajax_get_products_service&raw=1",{product_id:product_id,category_id:category_id,keyword:keyword,str_exist:str_exist}, function(html){
			$('#products_service_search_list').html(html);
		});
	});
}
function set_products_service(id){
	var max_service = 10;
	var length_children = $( "#products_sortable_service li" ).length;
	if(length_children >= max_service ){
		alert('Tối đa chỉ có '+max_service+' sản phẩm liên quan'	);
		return;
	}
	var title = $('.products_service_item_'+id).html();                                     
	var html = '<li id="products_record_service_'+id+'">'+title+'<input type="hidden" name="products_record_service[]" value="'+id+'" />';
	html += '<a class="products_remove_relate_bt"  onclick="javascript: remove_products_service('+id+')" href="javascript: void(0)" title="Xóa"><img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png"></a>';
	html += '</li>';
	$('#products_sortable_service').append(html);
	$('.products_service_item_'+id).hide();	
}
function remove_products_service(id){
	$('#products_record_service_'+id).remove();
	$('.products_service_item_'+id).show().addClass('red');	
}
</script>
<style>
.products_service_search, #products_service_r .title{
	 background: none repeat scroll 0 0 #F0F1F5;
    font-weight: bold;
    margin-bottom: 4px;
    padding: 2px 0 4px;
    text-align: center;
}
#products_service_search_list{
	height: 400px;
    overflow: scroll;
}
.products_service_item{
	background: url("/admin/images/page_next.gif") no-repeat scroll right center transparent;
    border-bottom: 1px solid #EEEEEE;
    cursor: pointer;
    margin: 2px 10px;
    padding: 5px;
}
#products_sortable_service li{
	cursor: move;
    list-style: decimal outside none;
    margin-bottom: 8px;
}
.products_remove_relate_bt{
	padding-left: 10px;
}
.products_service table{
	margin-bottom: 5px;
}
</style>