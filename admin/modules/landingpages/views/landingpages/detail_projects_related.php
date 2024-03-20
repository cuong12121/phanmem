<div class="projects_related">
	<table width="100%" bordercolor="#AAA" border="1">
		<tr valign="top">
			<td width="0%" id='projects_related_l' style="display:none" >
				<div class='projects_related_search'>
					<span>Tìm kiếm: </span>
					<input type="text" name='projects_related_keyword' value='' id='projects_related_keyword' />
					<select name="projects_related_category_id"  id="projects_related_category_id">
						<option value="">Danh mục</option>
						<?php 
						foreach ($projects_categories as $item) {
						?>
							<option value="<?php echo $item->id; ?>" ><?php echo $item->treename;  ?> </option>	
						<?php }?>
					</select>
					<input type="button" name='projects_related_search' value='Tìm kiếm' id='projects_related_search' />
				</div>
				<div id='projects_related_search_list'>
				</div>
			</td>
			<td width="100%" id='projects_related_r'>
				<!--	LIST RELATE			-->
				<div class='title'>Dự án liên quan</div>
					<ul id='projects_sortable_related'>	
						<?php
						$i = 0; 
						if(isset($projects_related))
						foreach ($projects_related as $item) { 
						?>
							<li id='projects_record_related_<?php echo $item ->id?>'><?php echo $item -> name; ?> <a class='projects_remove_relate_bt'  onclick="javascript: remove_projects_related(<?php echo $item->id?>)" href="javascript: void(0)" title='Xóa'><img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png"></a> <input type="hidden" name='projects_record_related[]' value="<?php echo $item -> id;?>" /></li>
						<?php }?>
					</ul>
				<!--	end LIST RELATE			-->
				<div id='projects_record_related_continue'></div>
			</td>
		</tr>
	</table>
	<div class='projects_close_related' style="display:none">
		<a href="javascript:projects_close_related()"><strong class='red'>Đóng</strong></a>
	</div>
	<div class='projects_add_related'>
		<a href="javascript:projects_add_related()"><strong class='red'>Thêm dự án liên quan</strong></a>
	</div>
</div>
<script type="text/javascript" >
search_projects_related();
$( "#projects_sortable_related" ).sortable();
function projects_add_related(){
	$('#projects_related_l').show();
	$('#projects_related_l').attr('width','50%');
	$('#projects_related_r').attr('width','50%');		
	$('.projects_close_related').show();
	$('.projects_add_related').hide();
}
function projects_close_related(){
	$('#projects_related_l').hide();
	$('#projects_related_l').attr('width','0%');
	$('#projects_related_r').attr('width','100%');		
	$('.projects_add_related').show();
	$('.projects_close_related').hide();
}
function search_projects_related(){
	$('#projects_related_search').click(function(){
		var keyword = $('#projects_related_keyword').val();
		var category_id = $('#projects_related_category_id').val();
		var str_exist = '';
		$( "#projects_sortable_related li input" ).each(function( index ) {
			if(str_exist != '')
				str_exist += ',';
			str_exist += 	$( this ).val();
		});
		$.get("index2.php?module=products&view=products&task=ajax_get_projects_related&raw=1",{category_id:category_id,keyword:keyword,str_exist:str_exist}, function(html){
			$('#projects_related_search_list').html(html);
		});
	});
}
function set_projects_related(id){
	var max_related = 10;
	var length_children = $( "#projects_sortable_related li" ).length;
	if(length_children >= max_related ){
		alert('Tối đa chỉ có '+max_related+' dự án liên quan'	);
		return;
	}
	var title = $('.projects_related_item_'+id).html();                                     
	var html = '<li id="projects_record_related_'+id+'">'+title+'<input type="hidden" name="projects_record_related[]" value="'+id+'" />';
	html += '<a class="projects_remove_relate_bt"  onclick="javascript: remove_projects_related('+id+')" href="javascript: void(0)" title="Xóa"><img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png"></a>';
	html += '</li>';
	$('#projects_sortable_related').append(html);
	$('.projects_related_item_'+id).hide();	
}
function remove_projects_related(id){
	$('#projects_record_related_'+id).remove();
	$('.projects_related_item_'+id).show().addClass('red');	
}
</script>
<style>
.projects_related_search, #projects_related_r .title{
	 background: none repeat scroll 0 0 #F0F1F5;
    font-weight: bold;
    margin-bottom: 4px;
    padding: 2px 0 4px;
    text-align: center;
}
#projects_related_search_list{
	height: 400px;
    overflow: scroll;
}
.projects_related_item{
	background: url("/admin/images/page_next.gif") no-repeat scroll right center transparent;
    border-bottom: 1px solid #EEEEEE;
    cursor: pointer;
    margin: 2px 10px;
    padding: 5px;
}
#projects_sortable_related li{
	cursor: move;
    list-style: decimal outside none;
    margin-bottom: 8px;
}
.projects_remove_relate_bt{
	padding-left: 10px;
}
.projects_related table{
	margin-bottom: 5px;
}
</style>