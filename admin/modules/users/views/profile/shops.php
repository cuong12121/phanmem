<div class="shops_related">
	<table width="100%" bordercolor="#AAA" border="1">
		<tr valign="top">
			<td width="0%" id='shops_related_l' style="display:none" >
				<div class='shops_related_search'>
					<span>Tìm kiếm: </span>
					<input type="text" name='shops_related_keyword' value='' id='shops_related_keyword' />
					<input type="button" name='shops_related_search' value='Tìm kiếm' id='shops_related_search' />
				</div>
				<div id='shops_related_search_list'>
				</div>
			</td>
			<td width="100%" id='shops_related_r'>
				<!--	LIST RELATE			-->
				<div class='title'>Shops</div>
					<ul id='shops_sortable_related'>	
						<?php
						$i = 0; 
						if(!empty($shops_related))
						foreach ($shops_related as $item) { 
						?>
							<li id='shops_record_related_<?php echo $item ->id?>'><?php echo $item -> name; ?> <a class='shops_remove_relate_bt'  onclick="javascript: remove_shops_related(<?php echo $item->id?>)" href="javascript: void(0)" title='Xóa'>
								<img border="0" alt="Remove" src="<?php echo URL_ADMIN ?>templates/default/images/toolbar/remove_2.png"></a> <input type="hidden" name='shops_record_related[]' value="<?php echo $item -> id;?>" /></li>
						<?php }?>
					</ul>
				<!--	end LIST RELATE			-->
				<div id='shops_record_related_continue'></div>
			</td>
		</tr>
	</table>
	<div class='shops_close_related' style="display:none">
		<a href="javascript:shops_close_related()"><strong class='red'>Đóng</strong></a>
	</div>
	<div class='shops_add_related'>
		<a href="javascript:shops_add_related()"><strong class='red'>Thêm shop</strong></a>
	</div>
</div>
<script type="text/javascript" >
search_shops_related();
$( "#shops_sortable_related" ).sortable();
function shops_add_related(){
	$('#shops_related_l').show();
	$('#shops_related_l').attr('width','50%');
	$('#shops_related_r').attr('width','50%');		
	$('.shops_close_related').show();
	$('.shops_add_related').hide();
}
function shops_close_related(){
	$('#shops_related_l').hide();
	$('#shops_related_l').attr('width','0%');
	$('#shops_related_r').attr('width','100%');		
	$('.shops_add_related').show();
	$('.shops_close_related').hide();
}
function search_shops_related(){
	var parent_id = $('#fragment-1 #parent_id').val();

	$('#shops_related_search').click(function(){
		var keyword = $('#shops_related_keyword').val();
		// var category_id = $('#shops_related_category_id').val();
		var str_exist = '';
		$( "#shops_sortable_related li input" ).each(function( index ) {
			if(str_exist != '')
				str_exist += ',';
			str_exist += 	$( this ).val();
		});
		$.get("/admin/index.php?module=users&view=profile&task=ajax_get_shops_related&raw=1",{keyword:keyword,str_exist:str_exist,parent_id:parent_id}, function(html){
			$('#shops_related_search_list').html(html);
		});
	});
}
function set_shops_related(id){
	var max_related = 1000;
	var length_children = $( "#shops_sortable_related li" ).length;
	if(length_children >= max_related ){
		alert('Tối đa chỉ có '+max_related+' tin liên quan'	);
		return;
	}
	var title = $('.shops_related_item_'+id).html();                                     
	var html = '<li id="record_related_'+id+'">'+title+'<input type="hidden" name="shops_record_related[]" value="'+id+'" />';
	html += '<a class="shops_remove_relate_bt"  onclick="javascript: remove_shops_related('+id+')" href="javascript: void(0)" title="Xóa"><img border="0" alt="Remove" src="<?php echo URL_ADMIN ?>templates/default/images/toolbar/remove_2.png"></a>';
	html += '</li>';
	$('#shops_sortable_related').append(html);
	$('.shops_related_item_'+id).hide();	
}
function remove_shops_related(id){
	$('#shops_record_related_'+id).remove();
	$('.shops_related_item_'+id).show().addClass('red');	
}
</script>
<style>
.shops_related_search, #shops_related_r .title{
	 background: none repeat scroll 0 0 #F0F1F5;
    font-weight: bold;
    margin-bottom: 4px;
    padding: 2px 0 4px;
    text-align: center;
}
#shops_related_search_list{
	height: 400px;
    overflow: scroll;
}
.shops_related_item{
	background: url("/admin/images/page_next.gif") no-repeat scroll right center transparent;
    border-bottom: 1px solid #EEEEEE;
    cursor: pointer;
    margin: 2px 10px;
    padding: 5px;
}
#shops_sortable_related li{
	cursor: move;
    list-style: decimal outside none;
    margin-bottom: 8px;
}
.shops_remove_relate_bt{
	padding-left: 10px;
}
.shops_related table{
	margin-bottom: 5px;
}
</style>