<div class="aq_related">
	<table width="100%" bordercolor="#AAA" border="1">
		<tr valign="top">
			<td width="0%" id='aq_related_l' style="display:none" >
				<div class='aq_related_search'>
					<span>Tìm kiếm: </span>
					<input type="text" name='aq_related_keyword' value='' id='aq_related_keyword' />
					<select name="aq_related_category_id"  id="aq_related_category_id">
						<option value="">Danh mục</option>
						<?php 
						foreach ($aq_categories as $item) {
						?>
							<option value="<?php echo $item->id; ?>" ><?php echo $item->treename;  ?> </option>	
						<?php }?>
					</select>
					<input type="button" name='aq_related_search' value='Tìm kiếm' id='aq_related_search' />
				</div>
				<div id='aq_related_search_list'>
				</div>
			</td>
			<td width="100%" id='aq_related_r'>
				<!--	LIST RELATE			-->
				<div class='title'>Câu hỏi liên quan</div>
					<ul id='aq_sortable_related'>	
						<?php
						$i = 0; 
						if(isset($aq_related))
						foreach ($aq_related as $item) { 
						?>
							<li id='aq_record_related_<?php echo $item ->id?>'><?php echo $item -> title; ?> <a class='aq_remove_relate_bt'  onclick="javascript: remove_aq_related(<?php echo $item->id?>)" href="javascript: void(0)" title='Xóa'><img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png"></a> <input type="hidden" name='aq_record_related[]' value="<?php echo $item -> id;?>" /></li>
						<?php }?>
					</ul>
				<!--	end LIST RELATE			-->
				<div id='aq_record_related_continue'></div>
			</td>
		</tr>
	</table>
	<div class='aq_close_related' style="display:none">
		<a href="javascript:aq_close_related()"><strong class='red'>Đóng</strong></a>
	</div>
	<div class='aq_add_related'>
		<a href="javascript:aq_add_related()"><strong class='red'>Thêm câu hỏi liên quan</strong></a>
	</div>
</div>
<script type="text/javascript" >
search_aq_related();
$( "#aq_sortable_related" ).sortable();
function aq_add_related(){
	$('#aq_related_l').show();
	$('#aq_related_l').attr('width','50%');
	$('#aq_related_r').attr('width','50%');		
	$('.aq_close_related').show();
	$('.aq_add_related').hide();
}
function aq_close_related(){
	$('#aq_related_l').hide();
	$('#aq_related_l').attr('width','0%');
	$('#aq_related_r').attr('width','100%');		
	$('.aq_add_related').show();
	$('.aq_close_related').hide();
}
function search_aq_related(){
	$('#aq_related_search').click(function(){
		var keyword = $('#aq_related_keyword').val();
		var category_id = $('#aq_related_category_id').val();
		var str_exist = '';
		$( "#aq_sortable_related li input" ).each(function( index ) {
			if(str_exist != '')
				str_exist += ',';
			str_exist += 	$( this ).val();
		});
		$.get("index2.php?module=landingpages&view=landingpages&task=ajax_get_aq_related&raw=1",{category_id:category_id,keyword:keyword,str_exist:str_exist}, function(html){
			$('#aq_related_search_list').html(html);
		});
	});
}
function set_aq_related(id){
	var max_related = 10;
	var length_children = $( "#aq_sortable_related li" ).length;
	if(length_children >= max_related ){
		alert('Tối đa chỉ có '+max_related+' câu hỏi liên quan'	);
		return;
	}
	var title = $('.aq_related_item_'+id).html();                                     
	var html = '<li id="aq_record_related_'+id+'">'+title+'<input type="hidden" name="aq_record_related[]" value="'+id+'" />';
	html += '<a class="aq_remove_relate_bt"  onclick="javascript: remove_aq_related('+id+')" href="javascript: void(0)" title="Xóa"><img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png"></a>';
	html += '</li>';
	$('#aq_sortable_related').append(html);
	$('.aq_related_item_'+id).hide();	
}
function remove_aq_related(id){
	$('#aq_record_related_'+id).remove();
	$('.aq_related_item_'+id).show().addClass('red');	
}
</script>
<style>
.aq_related_search, #aq_related_r .title{
	 background: none repeat scroll 0 0 #F0F1F5;
    font-weight: bold;
    margin-bottom: 4px;
    padding: 2px 0 4px;
    text-align: center;
}
#aq_related_search_list{
	height: 400px;
    overflow: scroll;
}
.aq_related_item{
	background: url("/admin/images/page_next.gif") no-repeat scroll right center transparent;
    border-bottom: 1px solid #EEEEEE;
    cursor: pointer;
    margin: 2px 10px;
    padding: 5px;
}
#aq_sortable_related li{
	cursor: move;
    list-style: decimal outside none;
    margin-bottom: 8px;
}
.aq_remove_relate_bt{
	padding-left: 10px;
}
.aq_related table{
	margin-bottom: 5px;
}
</style>