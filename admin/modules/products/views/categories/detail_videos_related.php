<div class="videos_related">
	<table width="100%" bordercolor="#AAA" border="1">
		<tr valign="top">
			<td width="0%" id='videos_related_l' style="display:none" >
				<div class='videos_related_search'>
					<span>Tìm kiếm: </span>
					<input type="text" name='videos_related_keyword' value='' id='videos_related_keyword' />
					<select name="videos_related_category_id"  id="videos_related_category_id">
						<option value="">Danh mục</option>
						<?php 
						foreach ($videos_categories as $item) {
						?>
							<option value="<?php echo $item->id; ?>" ><?php echo $item->name;  ?> </option>	
						<?php }?>
					</select>
					<input type="button" name='videos_related_search' value='Tìm kiếm' id='videos_related_search' />
				</div>
				<div id='videos_related_search_list'>
				</div>
			</td>
			<td width="100%" id='videos_related_r'>
				<!--	LIST RELATE			-->
				<div class='title'>Video liên quan</div>
					<ul id='videos_sortable_related'>	
						<?php
						$i = 0; 
						if(isset($videos_related))
						foreach ($videos_related as $item) { 
						?>
							<li id='videos_record_related_<?php echo $item ->id?>'><?php echo $item -> title; ?> <a class='videos_remove_relate_bt'  onclick="javascript: remove_videos_related(<?php echo $item->id?>)" href="javascript: void(0)" title='Xóa'><img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png"></a> <input type="hidden" name='videos_record_related[]' value="<?php echo $item -> id;?>" /></li>
						<?php }?>
					</ul>
				<!--	end LIST RELATE			-->
				<div id='videos_record_related_continue'></div>
			</td>
		</tr>
	</table>
	<div class='videos_close_related' style="display:none">
		<a href="javascript:videos_close_related()"><strong class='red'>Đóng</strong></a>
	</div>
	<div class='videos_add_related'>
		<a href="javascript:videos_add_related()"><strong class='red'>Thêm video liên quan</strong></a>
	</div>
</div>
<script type="text/javascript" >
search_videos_related();
$( "#videos_sortable_related" ).sortable();
function videos_add_related(){
	$('#videos_related_l').show();
	$('#videos_related_l').attr('width','50%');
	$('#videos_related_r').attr('width','50%');		
	$('.videos_close_related').show();
	$('.videos_add_related').hide();
}
function videos_close_related(){
	$('#videos_related_l').hide();
	$('#videos_related_l').attr('width','0%');
	$('#videos_related_r').attr('width','100%');		
	$('.videos_add_related').show();
	$('.videos_close_related').hide();
}
function search_videos_related(){
	$('#videos_related_search').click(function(){
		var keyword = $('#videos_related_keyword').val();
		var category_id = $('#videos_related_category_id').val();
		var str_exist = '';
		$( "#videos_sortable_related li input" ).each(function( index ) {
			if(str_exist != '')
				str_exist += ',';
			str_exist += 	$( this ).val();
		});
		$.get("index2.php?module=products&view=categories&task=ajax_get_videos_related&raw=1",{category_id:category_id,keyword:keyword,str_exist:str_exist}, function(html){
			$('#videos_related_search_list').html(html);
		});
	});
}
function set_videos_related(id){
	var max_related = 10;
	var length_children = $( "#videos_sortable_related li" ).length;
	if(length_children >= max_related ){
		alert('Tối đa chỉ có '+max_related+' tin liên quan'	);
		return;
	}
	var title = $('.videos_related_item_'+id).html();                                     
	var html = '<li id="record_related_'+id+'">'+title+'<input type="hidden" name="videos_record_related[]" value="'+id+'" />';
	html += '<a class="videos_remove_relate_bt"  onclick="javascript: remove_videos_related('+id+')" href="javascript: void(0)" title="Xóa"><img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png"></a>';
	html += '</li>';
	$('#videos_sortable_related').append(html);
	$('.videos_related_item_'+id).hide();	
}
function remove_videos_related(id){
	$('#videos_record_related_'+id).remove();
	$('.videos_related_item_'+id).show().addClass('red');	
}
</script>
<style>
.videos_related_search, #videos_related_r .title{
	 background: none repeat scroll 0 0 #F0F1F5;
    font-weight: bold;
    margin-bottom: 4px;
    padding: 2px 0 4px;
    text-align: center;
}
#videos_related_search_list{
	height: 400px;
    overflow: scroll;
}
.videos_related_item{
	background: url("/admin/images/page_next.gif") no-repeat scroll right center transparent;
    border-bottom: 1px solid #EEEEEE;
    cursor: pointer;
    margin: 2px 10px;
    padding: 5px;
}
#videos_sortable_related li{
	cursor: move;
    list-style: decimal outside none;
    margin-bottom: 8px;
}
.videos_remove_relate_bt{
	padding-left: 10px;
}
.videos_related table{
	margin-bottom: 5px;
}
</style>