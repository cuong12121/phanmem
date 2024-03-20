<div class="manufactory_related">
	<table width="100%" bordercolor="#AAA" border="1">
		<tr valign="top">
			<td width="0%" id='manufactory_related_l' style="display:none" >
				<div class='manufactory_related_search'>
					<span>Tìm kiếm: </span>
					<input type="text" name='manufactory_related_keyword' value='' id='manufactory_related_keyword' />
					<input type="button" name='manufactory_related_search' value='Tìm kiếm' id='manufactory_related_search' />
				</div>
				<div id='manufactory_related_search_list'>
				</div>
			</td>
			<td width="100%" id='manufactory_related_r'>
				<!--	LIST RELATE			-->
				<div class='title'>Hãng sản xuất</div>
					<ul id='manufactory_sortable_related'>	
						<?php
						$i = 0; 
						if(isset($manufactory_related))
						foreach ($manufactory_related as $item) { 
						?>
							<li id='manufactory_record_related_<?php echo $item ->id?>'><?php echo $item -> name; ?> <a class='manufactory_remove_relate_bt'  onclick="javascript: remove_manufactory_related(<?php echo $item->id?>)" href="javascript: void(0)" title='Xóa'><img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png"></a> <input type="hidden" name='manufactory_record_related[]' value="<?php echo $item -> id;?>" /></li>
						<?php }?>
					</ul>
				<!--	end LIST RELATE			-->
				<div id='manufactory_record_related_continue'></div>
			</td>
		</tr>
	</table>
	<div class='manufactory_close_related' style="display:none">
		<a href="javascript:manufactory_close_related()"><strong class='red'>Đóng</strong></a>
	</div>
	<div class='manufactory_add_related'>
		<a href="javascript:manufactory_add_related()"><strong class='red'>Thêm hãng</strong></a>
	</div>
</div>
<script type="text/javascript" >
search_manufactory_related();
$( "#manufactory_sortable_related" ).sortable();
function manufactory_add_related(){
	$('#manufactory_related_l').show();
	$('#manufactory_related_l').attr('width','50%');
	$('#manufactory_related_r').attr('width','50%');		
	$('.manufactory_close_related').show();
	$('.manufactory_add_related').hide();
}
function manufactory_close_related(){
	$('#manufactory_related_l').hide();
	$('#manufactory_related_l').attr('width','0%');
	$('#manufactory_related_r').attr('width','100%');		
	$('.manufactory_add_related').show();
	$('.manufactory_close_related').hide();
}
function search_manufactory_related(){
	$('#manufactory_related_search').click(function(){
		var keyword = $('#manufactory_related_keyword').val();
		// var category_id = $('#manufactory_related_category_id').val();
		var str_exist = '';
		$( "#manufactory_sortable_related li input" ).each(function( index ) {
			if(str_exist != '')
				str_exist += ',';
			str_exist += 	$( this ).val();
		});
		$.get("index2.php?module=products&view=categories&task=ajax_get_manufactory_related&raw=1",{keyword:keyword,str_exist:str_exist}, function(html){
			$('#manufactory_related_search_list').html(html);
		});
	});
}
function set_manufactory_related(id){
	var max_related = 40;
	var length_children = $( "#manufactory_sortable_related li" ).length;
	if(length_children >= max_related ){
		alert('Tối đa chỉ có '+max_related+' tin liên quan'	);
		return;
	}
	var title = $('.manufactory_related_item_'+id).html();                                     
	var html = '<li id="record_related_'+id+'">'+title+'<input type="hidden" name="manufactory_record_related[]" value="'+id+'" />';
	html += '<a class="manufactory_remove_relate_bt"  onclick="javascript: remove_manufactory_related('+id+')" href="javascript: void(0)" title="Xóa"><img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png"></a>';
	html += '</li>';
	$('#manufactory_sortable_related').append(html);
	$('.manufactory_related_item_'+id).hide();	
}
function remove_manufactory_related(id){
	$('#manufactory_record_related_'+id).remove();
	$('.manufactory_related_item_'+id).show().addClass('red');	
}
</script>
<style>
.manufactory_related_search, #manufactory_related_r .title{
	 background: none repeat scroll 0 0 #F0F1F5;
    font-weight: bold;
    margin-bottom: 4px;
    padding: 2px 0 4px;
    text-align: center;
}
#manufactory_related_search_list{
	height: 400px;
    overflow: scroll;
}
.manufactory_related_item{
	background: url("/admin/images/page_next.gif") no-repeat scroll right center transparent;
    border-bottom: 1px solid #EEEEEE;
    cursor: pointer;
    margin: 2px 10px;
    padding: 5px;
}
#manufactory_sortable_related li{
	cursor: move;
    list-style: decimal outside none;
    margin-bottom: 8px;
}
.manufactory_remove_relate_bt{
	padding-left: 10px;
}
.manufactory_related table{
	margin-bottom: 5px;
}
</style>