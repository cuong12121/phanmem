<div class="gifts_add">
	<table width="100%" bordercolor="#AAA" border="1">
		<tr valign="top">
			<td width="0%" id='gifts_add_l' style="display:none" >
				<div class='gifts_add_search'>
					<span>Tìm kiếm: </span>
					<input type="text" name='gifts_add_keyword' value='' id='gifts_add_keyword' />
					<select name="gifts_add_category_id"  id="gifts_add_category_id">
						<option value="">Danh mục</option>
						<?php 
						foreach ($gifts_categories as $item) {
						?>
							<option value="<?php echo $item->id; ?>" ><?php echo $item->treename;  ?> </option>	
						<?php }?>
					</select>
					<input type="button" name='gifts_add_search' value='Tìm kiếm' id='gifts_add_search' />
				</div>
				<div id='gifts_add_search_list'>
				</div>
			</td>
			<td width="100%" id='gifts_add_r'>
				<!--	LIST RELATE			-->
				<div class='title'>Chọn quà</div>
					<ul id='gifts_add_sortable'>	
						<?php
						$i = 0; 
						if(isset($gifts))
						foreach ($gifts as $item) { 
						?>
							<li id='add_gifts_item_selected_<?php echo $item ->id?>'>
								<span class="item_title"><?php echo $item -> name.' <strong>('.$item->unit.')</strong> ' ?></span>
								<span class="item_price_old">Giá cũ: <input type="text" name="price_old_value_<?php echo $item ->id?>" disabled="disabled" value="<?php echo format_money($item -> price_old,'','0'); ?>"/></span>
								<a class='news_remove_relate_bt'  onclick="javascript: remove_gifts_add(<?php echo $item->id?>)" href="javascript: void(0)" title='Xóa'><img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png"></a> <input type="hidden" name='add_gifts[]' value="<?php echo $item -> id;?>" />
							</li>
						<?php }?>
					</ul>
				<!--	end LIST RELATE			-->
				<div id='add_gifts_continue'></div>
			</td>
		</tr>
	</table>
	<div class='news_close_related' style="display:none">
		<a href="javascript:news_close_related()"><strong class='red'>Đóng</strong></a>
	</div>
	<div class='news_add_related'>
		<a href="javascript:news_add_related()"><strong class='red'>Thêm quà</strong></a>
	</div>
</div>
<script type="text/javascript" >
search_gifts_add();
$( "#gifts_add_sortable" ).sortable();
function news_add_related(){
	$('#gifts_add_l').show();
	$('#gifts_add_l').attr('width','50%');
	$('#gifts_add_r').attr('width','50%');		
	$('.news_close_related').show();
	$('.news_add_related').hide();
}
function news_close_related(){
	$('#gifts_add_l').hide();
	$('#gifts_add_l').attr('width','0%');
	$('#gifts_add_r').attr('width','100%');		
	$('.news_add_related').show();
	$('.news_close_related').hide();
}
function search_gifts_add(){
	$('#gifts_add_search').click(function(){
		var keyword = $('#gifts_add_keyword').val();
		var category_id = $('#gifts_add_category_id').val();
		var str_exist = '';
		$( "#gifts_add_sortable li input" ).each(function( index ) {
			if(str_exist != '')
				str_exist += ',';
			str_exist += 	$( this ).val();
		});
		$.get("index2.php?module=sales&view=sales&task=ajax_get_gifts_comboselectgift&raw=1",{category_id:category_id,keyword:keyword,str_exist:str_exist}, function(html){
			$('#gifts_add_search_list').html(html);
		});
	});
}
function set_gifts_add(id){
	var max_related = 100;
	var length_children = $( "#gifts_add_sortable li" ).length;
	if(length_children >= max_related ){
		alert('Tối đa chỉ có '+max_related+' tin liên quan'	);
		return;
	}
	var title = $('.gifts_add_item_'+id).html();                                     
	var price = $('#price_add_'+id).html();                                     
	var html = '<li id="add_gifts_item_selected_'+id+'">';
	html += '<span class="item_title">'+title+'<input type="hidden" name="add_gifts[]" value="'+id+'" /></span>';
	html += '<span class="item_price_old">Giá cũ: <input type="text" name="price_old_value_'+id+'" disabled="disabled" value="'+price+'"/></span>';
	html += '<a class="news_remove_relate_bt"  onclick="javascript: remove_gifts_add('+id+')" href="javascript: void(0)" title="Xóa"><img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png"></a>';
	html += '</li>';
	$('#gifts_add_sortable').append(html);
	$('.gifts_add_item_'+id).hide();	
}
function remove_gifts_add(id){
	$('#add_gifts_item_selected_'+id).remove();
	$('.gifts_add_item_'+id).show().addClass('red');	
}
</script>
<style>
.gifts_add_search, #gifts_add_r .title{
	 background: none repeat scroll 0 0 #F0F1F5;
    font-weight: bold;
    margin-bottom: 4px;
    padding: 2px 0 4px;
    text-align: center;
}
#gifts_add_search_list{
	height: 400px;
    overflow: scroll;
}
.gifts_add_item{
	background: url("/admin/images/page_next.gif") no-repeat scroll right center transparent;
    border-bottom: 1px solid #EEEEEE;
    cursor: pointer;
    margin: 2px 10px;
    padding: 5px;
}
#gifts_add_sortable li{
	cursor: move;
    list-style: decimal outside none;
    margin-bottom: 8px;
    border-bottom: 1px solid #EEE;
    padding-bottom: 6px;
}
#gifts_add_sortable li .red{
	display: none;
}
#gifts_add_sortable li .item_title{
    display: inline-block;
    width: 40%;
}
#gifts_add_sortable li .item_price_old,
#gifts_add_sortable li .item_price{
    display: inline-block;
    width: 20%;
}
#gifts_add_sortable li input[type="text"]{
	width: 85px;
}
.news_remove_relate_bt{
	padding-left: 10px;
}
.gifts_add table{
	margin-bottom: 5px;
}
</style>