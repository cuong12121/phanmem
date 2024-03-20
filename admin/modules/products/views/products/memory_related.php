<div class="products_related">
	<table width="100%" bordercolor="#AAA" border="1">
		<tr valign="top">
			<td width="0%" id='products_related_l_pb' style="display:none" >
				<div class='products_related_search'>
					<span>Tìm kiếm: </span>
					<input type="text" name='products_related_keyword_pb' value='' id='products_related_keyword_pb' />
					<select name="products_related_category_id_pb"  id="products_related_category_id_pb">
						<option value="">Danh mục</option>
						<?php 
						foreach ($categories as $item) {
						?>
							<option value="<?php echo $item->id; ?>" ><?php echo $item->treename;  ?> </option>	
						<?php }?>
					</select>
					<input type="button" name='products_related_search_pb' value='Tìm kiếm' id='products_related_search_pb' />
				</div>
				<div id='products_related_search_pb_list'>
				</div>
			</td>
			<td width="100%" id='products_related_r_pb'>
				<!--	LIST RELATE			-->
				<div class='title'>Phiên bản sản phẩm</div>
					<ul id='products_sortable_related_pb'>	
						<?php
						$i = 0; 
						if(isset($memory_related))
						foreach ($memory_related as $item) { 
							// echo '<pre>';
							// print_r($item);

						?>
							<input type="hidden" name="id_memory_<?php echo $item->id; ?>">
							<li id='memory_record_related_<?php echo $item ->product_relate?>'><?php echo $item -> name_relate; ?><input type="text" placeholder="Nhập tên hiển thị" name="name_show_<?php echo $item->product_relate; ?>" value="<?php echo $item->name; ?>"/> <a class='memory_remove_relate_bt'  onclick="javascript: remove_products_related(<?php echo $item->product_relate?>)" href="javascript: void(0)" title='Xóa'><img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png"></a> <input type="hidden" name='memory_record_related[]' value="<?php echo $item -> product_relate;?>" /></li>
						<?php }?>
					</ul>
				<!--	end LIST RELATE			-->
				<div id='memory_record_related_continue'></div>
			</td>
		</tr>
	</table>
	<div class='products_close_related_pb' style="display:none">
		<a href="javascript:products_close_related_pb()"><strong class='red'>Đóng</strong></a>
	</div>
	<div class='products_add_related_pb'>
		<a href="javascript:products_add_related_pb()"><strong class='red'>Thêm sản phẩm là phiên bản khác</strong></a>
	</div>
	<input type="hidden" name="product_manu" value="<?php echo @$data->manufactory ?>" id="manufactory_id">
</div>
<script type="text/javascript" >
search_products_related();
$( "#products_sortable_related" ).sortable();
function products_add_related_pb(){
	$('#products_related_l_pb').show();
	$('#products_related_l_pb').attr('width','50%');
	$('#products_related_r_pb').attr('width','50%');		
	$('.products_close_related_pb').show();
	$('.products_add_related_pb').hide();
}
function products_close_related_pb(){
	$('#products_related_l_pb').hide();
	$('#products_related_l_pb').attr('width','0%');
	$('#products_related_r_pb').attr('width','100%');		
	$('.products_add_related_pb').show();
	$('.products_close_related_pb').hide();
}
function search_products_related(){
	$('#products_related_search_pb').click(function(){
		var keyword = $('#products_related_keyword_pb').val();
		var category_id = $('#products_related_category_id_pb').val();
		var manu_id = $('#manufactory_id').val();
		var product_id = <?php echo @$data -> id?$data -> id:0?>;
		var str_exist = '';
		$( "#products_sortable_related_pb li input" ).each(function( index ) {
			if(str_exist != '')
				str_exist += ',';
			str_exist += 	$( this ).val();
		});
		$.get("index2.php?module=products&view=products&task=ajax_get_memory_related&raw=1",{product_id:product_id,category_id:category_id,keyword:keyword,str_exist:str_exist,manu:manu_id}, function(html){
			$('#products_related_search_pb_list').html(html);
		});
	});
}

function set_products_related_pb(id){
	// alert('111');
	var max_related = 10;
	var length_children = $( "#products_sortable_related_pb li" ).length;
	if(length_children >= max_related ){
		alert('Tối đa chỉ có '+max_related+' sản phẩm phiên bản'	);
		return;
	}
	var title = $('.products_related_item_'+id).html(); 
	var regex = /\d+(\s)*[g|G][b|B]/g;
	var matches_memory = title.match(regex);  // creates array from matches
	

	var html = '<li id="record_related_'+id+'">'+title+'<input type="hidden" name="memory_record_related[]" value="'+id+'" />';
	// alert(matches_memory);
	if(matches_memory == null){
		html += '<input type="text" placeholder="Nhập tên hiển thị" name="name_show_'+id+'"/>';
	}else{
		html += '<input type="text" value = "'+matches_memory+'" name="name_show_'+id+'"/>';
	}
	
	html += '<a class="products_remove_relate_bt"  onclick="javascript: remove_products_related('+id+')" href="javascript: void(0)" title="Xóa"><img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png"></a>';
	html += '</li>';
	$('#products_sortable_related_pb').append(html);
	$('.products_related_item_'+id).hide();	
}

function remove_products_related(id){

	$('#record_related_'+id).remove();
	$('#memory_record_related_'+id).remove();
	$('.products_related_item_'+id).show().addClass('red');	
}
</script>
<style>
.products_related_search, #products_related_r_pb .title{
	 background: none repeat scroll 0 0 #F0F1F5;
    font-weight: bold;
    margin-bottom: 4px;
    padding: 2px 0 4px;
    text-align: center;
}
#products_related_search_pb_list{
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
#products_sortable_related_pb li{
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