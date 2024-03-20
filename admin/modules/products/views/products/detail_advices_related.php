<div class="advices_related">
	<table width="100%" bordercolor="#AAA" border="1">
		<tr valign="top">
			<td width="0%" id='advices_related_l' style="display:none" >
				<div class='advices_related_search'>
					<span>Tìm kiếm: </span>
					<input type="text" name='advices_related_keyword' value='' id='advices_related_keyword' />
					<select name="advices_related_category_id"  id="advices_related_category_id">
						<option value="">Danh mục</option>
						<?php 
						foreach ($advices_categories as $item) {
						?>
							<option value="<?php echo $item->id; ?>" ><?php echo $item->treename;  ?> </option>	
						<?php }?>
					</select>
					<input type="button" name='advices_related_search' value='Tìm kiếm' id='advices_related_search' />
				</div>
				<div id='advices_related_search_list'>
				</div>
			</td>
			<td width="100%" id='advices_related_r'>
				<!--	LIST RELATE			-->
				<div class='title'>Tin liên quan</div>
					<ul id='advices_sortable_related'>	
						<?php
						$i = 0; 
						if(isset($advices_related))
						foreach ($advices_related as $item) { 
						?>
							<li id='advices_record_related_<?php echo $item ->id?>'><?php echo $item -> title; ?> <a class='advices_remove_relate_bt'  onclick="javascript: remove_advices_related(<?php echo $item->id?>)" href="javascript: void(0)" title='Xóa'><img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png"></a> <input type="hidden" name='advices_record_related[]' value="<?php echo $item -> id;?>" /></li>
						<?php }?>
					</ul>
				<!--	end LIST RELATE			-->
				<div id='advices_record_related_continue'></div>
			</td>
		</tr>
	</table>
	<div class='advices_close_related' style="display:none">
		<a href="javascript:advices_close_related()"><strong class='red'>Đóng</strong></a>
	</div>
	<div class='advices_add_related'>
		<a href="javascript:advices_add_related()"><strong class='red'>Thêm tin liên quan</strong></a>
	</div>
</div>
<script type="text/javascript" >
search_advices_related();
$( "#advices_sortable_related" ).sortable();
function advices_add_related(){
	$('#advices_related_l').show();
	$('#advices_related_l').attr('width','50%');
	$('#advices_related_r').attr('width','50%');		
	$('.advices_close_related').show();
	$('.advices_add_related').hide();
}
function advices_close_related(){
	$('#advices_related_l').hide();
	$('#advices_related_l').attr('width','0%');
	$('#advices_related_r').attr('width','100%');		
	$('.advices_add_related').show();
	$('.advices_close_related').hide();
}
function search_advices_related(){
	$('#advices_related_search').click(function(){
		var keyword = $('#advices_related_keyword').val();
		var category_id = $('#advices_related_category_id').val();
		var str_exist = '';
		$( "#advices_sortable_related li input" ).each(function( index ) {
			if(str_exist != '')
				str_exist += ',';
			str_exist += 	$( this ).val();
		});
		$.get("index2.php?module=products&view=products&task=ajax_get_advices_related&raw=1",{category_id:category_id,keyword:keyword,str_exist:str_exist}, function(html){
			$('#advices_related_search_list').html(html);
		});
	});
}
function set_advices_related(id){
	var max_related = 10;
	var length_children = $( "#advices_sortable_related li" ).length;
	if(length_children >= max_related ){
		alert('Tối đa chỉ có '+max_related+' tin liên quan'	);
		return;
	}
	var title = $('.advices_related_item_'+id).html();                                     
	var html = '<li id="record_related_'+id+'">'+title+'<input type="hidden" name="advices_record_related[]" value="'+id+'" />';
	html += '<a class="advices_remove_relate_bt"  onclick="javascript: remove_advices_related('+id+')" href="javascript: void(0)" title="Xóa"><img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png"></a>';
	html += '</li>';
	$('#advices_sortable_related').append(html);
	$('.advices_related_item_'+id).hide();	
}
function remove_advices_related(id){
	$('#advices_record_related_'+id).remove();
	$('.advices_related_item_'+id).show().addClass('red');	
}
</script>
<style>
.advices_related_search, #advices_related_r .title{
	 background: none repeat scroll 0 0 #F0F1F5;
    font-weight: bold;
    margin-bottom: 4px;
    padding: 2px 0 4px;
    text-align: center;
}
#advices_related_search_list{
	height: 400px;
    overflow: scroll;
}
.advices_related_item{
	background: url("/admin/images/page_next.gif") no-repeat scroll right center transparent;
    border-bottom: 1px solid #EEEEEE;
    cursor: pointer;
    margin: 2px 10px;
    padding: 5px;
}
#advices_sortable_related li{
	cursor: move;
    list-style: decimal outside none;
    margin-bottom: 8px;
}
.advices_remove_relate_bt{
	padding-left: 10px;
}
.advices_related table{
	margin-bottom: 5px;
}
</style>