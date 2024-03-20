<div class="news_related">
	<table width="100%" bordercolor="#AAA" border="1">
		<tr valign="top">
			<td width="0%" id='news_related_l' style="display:none" >
				<div class='news_related_search'>
					<span>Tìm kiếm: </span>
					<input type="text" name='news_related_keyword' value='' id='news_related_keyword' />
					<select name="news_related_category_id"  id="news_related_category_id">
						<option value="">Danh mục</option>
						<?php 
						foreach ($news_categories as $item) {
						?>
							<option value="<?php echo $item->id; ?>" ><?php echo $item->treename;  ?> </option>	
						<?php }?>
					</select>
					<input type="button" name='news_related_search' value='Tìm kiếm' id='news_related_search' />
				</div>
				<div id='news_related_search_list'>
				</div>
			</td>
			<td width="100%" id='news_related_r'>
				<!--	LIST RELATE			-->
				<div class='title'>Tin liên quan</div>
					<ul id='news_sortable_related'>	
						<?php
						$i = 0; 
						if(isset($news_related))
						foreach ($news_related as $item) { 
						?>
							<li id='news_record_related_<?php echo $item ->id?>'><?php echo $item -> title; ?> <a class='news_remove_relate_bt'  onclick="javascript: remove_news_related(<?php echo $item->id?>)" href="javascript: void(0)" title='Xóa'><img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png"></a> <input type="hidden" name='news_record_related[]' value="<?php echo $item -> id;?>" /></li>
						<?php }?>
					</ul>
				<!--	end LIST RELATE			-->
				<div id='news_record_related_continue'></div>
			</td>
		</tr>
	</table>
	<div class='news_close_related' style="display:none">
		<a href="javascript:news_close_related()"><strong class='red'>Đóng</strong></a>
	</div>
	<div class='news_add_related'>
		<a href="javascript:news_add_related()"><strong class='red'>Thêm tin liên quan</strong></a>
	</div>
</div>
<script type="text/javascript" >
search_news_related();
$( "#news_sortable_related" ).sortable();
function news_add_related(){
	$('#news_related_l').show();
	$('#news_related_l').attr('width','50%');
	$('#news_related_r').attr('width','50%');		
	$('.news_close_related').show();
	$('.news_add_related').hide();
}
function news_close_related(){
	$('#news_related_l').hide();
	$('#news_related_l').attr('width','0%');
	$('#news_related_r').attr('width','100%');		
	$('.news_add_related').show();
	$('.news_close_related').hide();
}
function search_news_related(){
	$('#news_related_search').click(function(){
		var keyword = $('#news_related_keyword').val();
		var category_id = $('#news_related_category_id').val();
		var str_exist = '';
		$( "#news_sortable_related li input" ).each(function( index ) {
			if(str_exist != '')
				str_exist += ',';
			str_exist += 	$( this ).val();
		});
		$.get("index2.php?module=news&view=news&task=ajax_get_news_related&raw=1",{category_id:category_id,keyword:keyword,str_exist:str_exist}, function(html){
			$('#news_related_search_list').html(html);
		});
	});
}
function set_news_related(id){
	var max_related = 10;
	var length_children = $( "#news_sortable_related li" ).length;
	if(length_children >= max_related ){
		alert('Tối đa chỉ có '+max_related+' tin liên quan'	);
		return;
	}
	var title = $('.news_related_item_'+id).html();                                     
	var html = '<li id="record_related_'+id+'">'+title+'<input type="hidden" name="news_record_related[]" value="'+id+'" />';
	html += '<a class="news_remove_relate_bt"  onclick="javascript: remove_news_related('+id+')" href="javascript: void(0)" title="Xóa"><img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png"></a>';
	html += '</li>';
	$('#news_sortable_related').append(html);
	$('.news_related_item_'+id).hide();	
}
function remove_news_related(id){
	$('#news_record_related_'+id).remove();
	$('.news_related_item_'+id).show().addClass('red');	
}
</script>
<style>
.news_related_search, #news_related_r .title{
	 background: none repeat scroll 0 0 #F0F1F5;
    font-weight: bold;
    margin-bottom: 4px;
    padding: 2px 0 4px;
    text-align: center;
}
#news_related_search_list{
	height: 400px;
    overflow: scroll;
}
.news_related_item{
	background: url("/admin/images/page_next.gif") no-repeat scroll right center transparent;
    border-bottom: 1px solid #EEEEEE;
    cursor: pointer;
    margin: 2px 10px;
    padding: 5px;
}
#news_sortable_related li{
	cursor: move;
    list-style: decimal outside none;
    margin-bottom: 8px;
}
.news_remove_relate_bt{
	padding-left: 10px;
}
.news_related table{
	margin-bottom: 5px;
}
</style>