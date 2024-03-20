<link rel="stylesheet" href="<?php  echo URL_ROOT.'/libraries/themes/ui-lightness/ui.all.css';?>" />
<link rel="stylesheet" href="<?php  echo URL_ROOT.'/libraries/themes/ui-lightness/ui.theme.css';?>" />
<?php  
	global $toolbar;
	$toolbar->setTitle(FSText::_('Item List') );
	$toolbar->addButton('add',FSText::_('Add'),'','add.png'); 
	$toolbar->addButton('edit',FSText::_('Edit'),FSText::_('B&#7841;n ch&#432;a ch&#7885;n ph&#7847;n t&#7917; n&#224;o'),'edit.png'); 
	$toolbar->addButton('remove',FSText::_('Remove'),FSText::_('B&#7841;n ch&#432;a ch&#7885;n ph&#7847;n t&#7917; n&#224;o'),'remove.png'); 
//	$toolbar->addButton('import',FSText::_('Import'),'','import.png');
	$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
	$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
	$toolbar->addButton('',FSText :: _('Export'),FSText :: _(''),'Excel-icon.png','','1');
?>
<div class="form_body">
	<form action="index.php?module=members&view=members" name="adminForm" method="post" >
		
		<!--	FILTER	-->
		<?php 
			$filter_config  = array();
			$fitler_config['search'] = 1; 
			$fitler_config['filter_count'] = 1;
			
			$filter_status = array();
			$filter_status['title'] = FSText::_('Trạng thái'); 
			$filter_status['type'] = 'yesno'; 
			
//			$filter_estore = array();
//			$filter_estore['title'] = FSText::_('Tin thuộc gian hàng'); 
//			$filter_estore['list'] = @$estores; 
//			$filter_estore['field'] = 'estore_name';
//			 
//			$filter_categories = array();
//			$filter_categories['title'] = FSText::_('Danh mục'); 
//			$filter_categories['list'] = @$categories; 
//			$filter_categories['field'] = 'treename'; 
			
//			$filter_pr = array();
//			$filter_pr['title'] = FSText::_('Tin đăng trên address'); 
//			$filter_pr['type'] = 'yesno'; 
//			
//			$filter_hot = array();
//			$filter_hot['title'] = FSText::_('Mua vị trí tin hot'); 
//			$filter_hot['type'] = 'yesno'; 
//
//			$filter_slideshow = array();
//			$filter_slideshow['title'] = FSText::_('Mua vị trí Slideshow'); 
//			$filter_slideshow['type'] = 'yesno'; 
			
//			$fitler_config['filter'][] = $filter_owner;
			$fitler_config['filter'][] = $filter_status;
//			$fitler_config['filter'][] = $filter_categories;
//			$fitler_config['filter'][] = $filter_pr;
//			$fitler_config['filter'][] = $filter_hot;
//			$fitler_config['filter'][] = $filter_slideshow;
			
			echo $this -> create_filter($fitler_config);
		?>
		<!--	END FILTER	-->
		<div class="form-contents">
			<table border="1" class="tbl_form_contents" cellpadding="3" bordercolor="#CCC">
				<thead>
					<tr>
					<th width="3%">
						#
					</th>
					<th width="3%">
						<input type="checkbox" onclick="checkAll(<?php echo count($list); ?>);" value="" name="toggle">
					</th>
					<th class="title" >
						<?php echo  TemplateHelper::orderTable(FSText::_('Username'), 'a.username',$sort_field,$sort_direct) ; ?>
					</th>
					<th class="title">
						<?php echo  TemplateHelper::orderTable(FSText::_('Họ tên'), 'a.fullname',$sort_field,$sort_direct) ; ?>
					</th>
					<th class="title">
						<?php echo  TemplateHelper::orderTable(FSText::_('Ngày tạo'), 'a.created_time',$sort_field,$sort_direct) ; ?>
					</th>
					<th class="title">
						<?php echo  TemplateHelper::orderTable(FSText::_('Điểm'), 'a.point',$sort_field,$sort_direct) ; ?>
					</th>
					<th class="title">
						<?php echo  TemplateHelper::orderTable(FSText::_('Cấp thành viên'), 'a.level',$sort_field,$sort_direct) ; ?>
					</th>
					
					<th class="title">
						<?php echo  TemplateHelper::orderTable(FSText::_('Published'), 'a.published',$sort_field,$sort_direct) ; ?>
					</th>
					<th class="title">
						<?php echo  FSText::_('Edit'); ?>
					</th>
					<th class="title" width="7%">
						<?php echo  TemplateHelper::orderTable(FSText::_('Id'), 'id',$sort_field,$sort_direct) ; ?>
					</th>
				</thead>
				<tbody>
					
					<?php $i = 0; ?>
					<?php if(@$list){?>
						<?php foreach ($list as $row) { ?>
							<?php $link_view = "index.php?module=members&view=members&task=edit&id=".$row->id.""; ?>
							<tr class="row<?php echo $i%2; ?>">
								<td><?php echo $i+1; ?></td>
								<td>
									<input type="checkbox" onclick="isChecked(this.checked);" value="<?php echo $row->id; ?>"  name="id[]" id="cb<?php echo $i; ?>">
								</td>
								<td><a href='<?php echo $link_view;?>' ><?php echo $row->username; ?></a></td>
								<td><a href='<?php echo $link_view;?>' ><?php echo $row->full_name; ?></a></td>
								<td><?php echo date("m-d-Y",strtotime($row->created_time)); ?></td>
								<td>
									<?php echo $row->point; ?>
								</td>
								<td>
									<?php echo isset($arr_level[$row -> level])?$arr_level[$row -> level] -> name:''; ?>
								</td>
								<td><?php echo TemplateHelper::published("cb".($i),$row->published?"unpublished":"published"); ?></td>
								<td> <a href='<?php echo $link_view; ?>' >Edit</a></td>
								<td><?php echo $row->id; ?></td>
							</tr>
							<?php $i++; ?>
						<?php }?>
					<?php }?>
					
				</tbody>
			</table>
		</div>
		<div class="footer_form">
			<?php if(@$pagination) {?>
			<?php echo $pagination->showPagination();?>
			<?php } ?>
		</div>
		
		<input type="hidden" value="<?php echo $sort_field; ?>" name="sort_field">
		<input type="hidden" value="<?php echo $sort_direct; ?>" name="sort_direct">
		<input type="hidden" value="members" name="module">
		<input type="hidden" value="members" name="view">
		<input type="hidden" value="" name="task">
		<input type="hidden" value="0" name="boxchecked">
	</form>
</div>
<script  type="text/javascript" language="javascript">
configOpenPopup(1);
	function configOpenPopup(){
		$('.Export').click(function(){
			$.get('index.php?module=members&view=members&task=quality_export&raw=1',function(response){
					Dialog.insertDom('zone-reason-new-detail','Số bản ghi muốn export',response);
					$("#zone-reason-new-detail").dialog({open: function() {$(".ui-dialog").css({width: '620px', left: '400px',top: '200px'});},modal:true,shadow:false,close:function(){$('#zone-reason-new-detail').remove();}});
			});
		});
	}
configClickExport(1);
function configClickExport(){
	$('#submit_quality').click(function(){
		var start=$('#start_at').val();
		var end=$('#end_at').val();
		$.get('index.php?module=members&view=members&task=export_excel&raw=1&start='+start+'&end='+end,function(response){
			if(response != "error"){
				window.open(response);	
			}else{	
				alert("Không có thành viên nào");
			}
		});
		alert("Export thành công");
	});
}
</script>
<script type="text/javascript" language="javascript" src="<?php  echo URL_ROOT.'/libraries/jquery.ui/ui.core.js';?>"></script>
<script type="text/javascript" language="javascript" src="<?php  echo URL_ROOT.'/libraries/jsobj/Dialog.js';?>"></script>
<script type="text/javascript" language="javascript" src="<?php  echo URL_ROOT.'/libraries/jquery.ui/ui.draggable.js';?>"></script>
<script type="text/javascript" language="javascript" src="<?php  echo URL_ROOT.'/libraries/jquery.ui/ui.dialog.js';?>"></script>