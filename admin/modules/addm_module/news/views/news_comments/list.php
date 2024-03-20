<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Comment tin tức') );
//	$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
	$toolbar->addButton('edit',FSText :: _('Xem'),FSText :: _('You must select at least one record'),'edit.png'); 
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
	$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
?>
<div class="form_body">
	<form action="index.php?module=<?php echo $this -> module;?>&view=<?php echo $this -> view;?>" name="adminForm" method="post">
		
		<!--	FILTER	-->
		<?php 
			$filter_config  = array();
			$fitler_config['search'] = 1; 
			$fitler_config['filter_count'] = 2;
			
//			$filter_owner = array();
//			$filter_owner['title'] = FSText::_('Tin của sàn'); 
//			$filter_owner['type'] = 'yesno'; 
			
			$filter_estore = array();
			$filter_estore['title'] = FSText::_('Tin thuộc gian hàng'); 
			$filter_estore['list'] = @$estores; 
			$filter_estore['field'] = 'estore_name';
			 
			$filter_categories = array();
			$filter_categories['title'] = FSText::_('Danh mục'); 
			$filter_categories['list'] = @$categories; 
			$filter_categories['field'] = 'treename'; 
			
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
			$fitler_config['filter'][] = $filter_estore;
			$fitler_config['filter'][] = $filter_categories;
//			$fitler_config['filter'][] = $filter_pr;
//			$fitler_config['filter'][] = $filter_hot;
//			$fitler_config['filter'][] = $filter_slideshow;
			
			echo $this -> create_filter($fitler_config);
		?>
		<!--	END FILTER	-->
		
		<div class="form-contents">
			<table border="1" class="tbl_form_contents" cellpadding="5" bordercolor="#CCCCCC">
				<thead>
					<tr>
					<th width="3%">
						#
					</th>
					<th width="3%">
						<input type="checkbox" onclick="checkAll(<?php echo count($list); ?>);" value="" name="toggle">
					</th>
					<th class="title">
						<?php echo FSText :: _('Comment'); ?>
					</th>
					<th class="title">
						<?php echo  TemplateHelper::orderTable(FSText::_('Tiêu đề bài viết'), 'd.title',@$sort_field,@$sort_direct) ; ?>
					</th>
					<th class="title">
						<?php echo  TemplateHelper::orderTable(FSText::_('Danh mục tin'), 'b.name',@$sort_field,@$sort_direct) ; ?>
					</th>
					<th class="title">
						<?php echo  TemplateHelper::orderTable(FSText::_('Gian hàng'), 'c.estore_name',@$sort_field,@$sort_direct) ; ?>
					</th>
					<th class="title" width="3%">
						<?php echo  TemplateHelper::orderTable(FSText :: _('Published'), 'a.published',@$sort_field,@$sort_direct) ; ?>
					</th>
					<th class="title" width="3%">
						<?php echo FSText :: _('Xem'); ?>
					</th>
					<th class="title" width="7%">
						<?php echo  TemplateHelper::orderTable(FSText :: _('Created time'), 'created_time',@$sort_field,@$sort_direct) ; ?>
					</th>
					<th class="title" width="3%">
						<?php echo  TemplateHelper::orderTable(FSText :: _('Id'), 'id',@$sort_field,@$sort_direct) ; ?>
					</th>
				</thead>
				<tbody>
					
					<?php $i = 0; ?>
					<?php if(@$list){?>
						<?php foreach ($list as $row) { ?>
							<?php $link_view = "index.php?module=".$this -> module."&view=".$this -> view."&task=edit&id=".$row->id; ?>
							<tr class="row<?php echo $i%2; ?>">
								<td><?php echo $i+1; ?></td>
								<td>
									<input type="checkbox" onclick="isChecked(this.checked);" value="<?php echo $row->id; ?>"  name="id[]" id="cb<?php echo $i; ?>">
								</td>
								<td align="left">
									<a href="<?php echo $link_view;?>"  /> <?php echo $row -> comment; ?></a>
								</td>
								<td align="left">
									<?php echo $row -> title; ?>
								</td>
								<td align="left">
									<?php echo $row -> category_name; ?>
								</td>
								<td align="left">
									<?php echo $row -> estore_name; ?>
								</td>
								<td><?php echo TemplateHelper::published("cb".($i),$row->published?"unpublished":"published"); ?></td>
								<td> <?php echo TemplateHelper::edit($link_view); ?></td>
								<td> <?php echo date('d/m/Y H:i',strtotime($row->created_time))?></td>
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
		
		<input type="hidden" value="<?php echo @$sort_field; ?>" name="sort_field">
		<input type="hidden" value="<?php echo @$sort_direct; ?>" name="sort_direct">
		<input type="hidden" value="<?php echo $this -> module;?>" name="module">
		<input type="hidden" value="<?php echo $this -> view;?>" name="view">
		<input type="hidden" value="" name="task">
		<input type="hidden" value="0" name="boxchecked">
	</form>
</div>