<?php  
	global $toolbar;
	$toolbar->setTitle(FSText::_('Danh s&#225;ch c&#225;c b&#7843;ng ') );
	$toolbar->addButton('duplicate',FSText :: _('Duplicate'),'','duplicate.png');
	$toolbar->addButton('table_add',FSText::_('Th&#234;m  b&#7843;ng'),'','add.png');
	$toolbar->addButton('remove',FSText::_('X&#243;a'),FSText::_('B&#7841;n ch&#432;a ch&#7885;n b&#7843;n ghi n&#224;o !'),'remove.png');
	
	$ss_keysearch  = isset($_SESSION[$this->prefix .'keysearch']) ? $_SESSION[$this->prefix.'keysearch']:'';
?>
<div class="form_body">
	<form action="index.php?module=<?php echo $this -> module;?>&view=<?php echo $this -> view;?>" name="adminForm" method="post">
		<div class="filter_area">	
			<table>		
				<tbody>
					<tr>			
						<td align="left">Tìm kiếm: <input type="text" name="keysearch" id="search" value="<?php echo @$ss_keysearch;?>" class="text_area"></td>
						<td>				
							<button onclick="this.form.submit();">Tìm kiếm
							</button>				
							<button onclick="document.getElementById('search').value='';this.form.getElementById('filter_state').value='';this.form.submit();">Reset</button>		
						</td>	
					</tr>	
				</tbody>
			</table>
		</div>
		<div class="form-contents">
			<table border="1" class="tbl_form_contents" width="100%" cellpadding="5" bordercolor="#cccccc">
				<thead>
					<tr>
					<th width="3%">
						#
					</th>
					<th width="3%">
						<input type="checkbox" onclick="checkAll(<?php echo count($list); ?>);" value="" name="toggle">
					</th>
					<th class="title">
						<?php echo FSText :: _('T&#234;n'); ?>
					</th>
					<th class="title">
						<?php echo FSText :: _('Đã tạo bảng'); ?>
					</th>
					<th class="title">
						<?php echo FSText :: _('Sửa bảng'); ?>
					</th>
					<th class="title">
						<?php echo FSText :: _('Tạo bộ lọc'); ?>
					</th>
					
				</thead>
				<tbody>
					<?php $i = 0; ?>
					<?php foreach ($list as $row) { ?>
						<?php $link_view_items = "index.php?module=".$this -> module."&view=".$this -> view."&task=edit&tablename=".str_replace('fs_products_', '', $row->table_name); ?>
						<?php $link_filter = "index.php?module=".$this -> module."&view=filters&tablename=".str_replace('fs_products_', '', $row->table_name); ?>
						<tr class="row<?php echo $i%2; ?>">
							<td><?php echo $i+1; ?></td>
							<td>
								<input type="checkbox" onclick="isChecked(this.checked);" value="<?php echo $row->table_name; ?>"  name="cid[]" id="cb<?php echo $i; ?>">
							</td>
							<td align="left">
								<a href='<?php echo $link_view_items?>' >
									<?php echo str_replace('fs_products_', '', $row->table_name); ?>
								</a>
							</td>
							<td>
								<?php 
									if($row->created_table)
									{
										echo '<img border="0" src="templates/default/images/published.png" alt="Enabled status">';
									}
									else
									{
										echo '<img border="0" src="templates/default/images/unpublished.png" alt="Disable status">';;
									}
								?>
							</td>
							<td align="center">
								<a href='<?php echo $link_view_items?>' >
									<img border="0" src="templates/default/images/edit_icon.png" alt="Views">
								</a>
							</td>
							<td align="center">
								<a href='<?php echo $link_filter; ?>' >
									<img border="0" src="templates/default/images/filter.gif" alt="Views">
								</a>
							</td>
						</tr>
						<?php $i++; ?>
					<?php }?>
					<tr class="row<?php echo $i%2; ?>">
						<?php $link_view_items = "index.php?module=".$this -> module."&view=".$this -> view."&task=edit&tablename=products"; ?>
						<?php $link_filter = "index.php?module=products&view=filters_common"; ?>
						<td><?php echo $i+1; ?></td>
						<td>
							&nbsp;
						</td>
						<td align="left">
								<strong>products</strong> (trường cơ bản)
						</td>
						<td>
							&nbsp;
						</td>
							<td align="center">
								<a href='<?php echo $link_filter; ?>' >
									<img border="0" src="templates/default/images/filter.gif" alt="Views">
								</a>
						</td>
					</tr>
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