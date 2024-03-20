<?php 
	$ss_usr_keysearch  = isset($_SESSION['ss_usr_keysearch']) ? $_SESSION['ss_usr_keysearch']:'';
	$ss_usr_group   = isset($_SESSION['ss_usr_group']) ? $_SESSION['ss_usr_group']:'';
	
	if(isset($_SESSION['users_users_sort_field']))
	{
		$sort_field = $_SESSION['users_users_sort_field'];
		$sort_direct = $_SESSION['users_users_sort_direct'];
		$sort_direct = $sort_direct?$sort_direct:'asc';
	}
	
	
?>
<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('User list') );
	$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
	$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	// $toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
	// $toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
?>

<div class="form_body">
	<form action="index.php?module=users&view=users" name="adminForm" method="post">
		
		<!--	FILTER	-->
		<div  class="filter_area">
			<table>
				<tr>
					<td align="left" width="100%">
						<?php echo FSText::_( 'Search' ); ?>:
						<input type="text" name="keysearch" id="search" value="<?php echo $ss_usr_keysearch;?>" class="text_area" onchange="document.adminForm.submit();" />
						<button onclick="this.form.submit();"><?php echo FSText::_( 'Search' ); ?></button>
						<button onclick="document.getElementById('search').value='';this.form.getElementById('filter_state').value='';this.form.submit();">
							<?php echo FSText::_( 'Reset' ); ?>
						</button>
					</td>
					<td nowrap="nowrap">
						<select name="select_group" class="type hidden" onChange="this.form.submit()">
							<option value="0"> -- <?php echo FSText::_('User group'); ?> -- </option>
							<?php
							if(isset($all_groups)){
								foreach ($all_groups as $item) { 
									if($item->id == $ss_usr_group){
										echo "<option value='" . $item->id . "' selected='selected'>" . $item->group_name . "</option>";
									}
									else{
										echo "<option value='" . $item->id . "'>" . $item->group_name . "</option>";
									}
								} 
							}
							?>
						</select>
					</td>
				</tr>
			</table>
		</div>
		<!--	END FILTER	-->
		
		
		<div class="form-contents">
			<table border="1" class="tbl_form_contents" bordercolor="#CCC">
				<thead>
					<tr>
					<th width="3%">
						#
					</th>
					<th width="3%">
						<input type="checkbox" onclick="checkAll(<?php echo count($list); ?>);" value="" name="toggle">
					</th>
					<th class="title">
						<?php echo FSText :: _('Username'); ?>
					</th>
					<th class="title">
						<?php echo FSText :: _('Email'); ?>
					</th>
					
					<th class="title" width="7%">
						<?php echo FSText :: _('Ordering'); ?>
					</th>
					<th class="title" width="7%">
						<?php echo FSText :: _('Published'); ?>
					</th>
					<th class="title" width="7%">
						<?php echo FSText :: _('Detail'); ?>
					</th>
					<th class="title" width="7%">
						<?php echo FSText :: _('Phân quyền'); ?>
					</th>
					<th class="title" width="7%">
						<?php echo  TemplateHelper::orderTable(FSText :: _('Id'), 'id',$sort_field,$sort_direct) ; ?>
					</th>
				</thead>
				<tbody>
					
					<?php $i = 0; ?>
					<?php foreach ($list as $row) { ?>
						<?php $link_view_users = "index.php?module=users&view=users&task=edit&cid=".$row->id; ?>
						<?php $link_permission = "index.php?module=users&view=users&task=permission&cid=".$row->id; ?>
						<tr class="row<?php echo $i%2; ?>">
							<td><?php echo $i+1; ?></td>
							<td>
								<input type="checkbox" onclick="isChecked(this.checked);" value="<?php echo $row->id; ?>"  name="cid[]" id="cb<?php echo $i; ?>">
							</td>
							<td><a href="<?php echo $link_view_users; ?>" > <?php echo $row->username; ?></a></td>
							<td><a href="<?php echo $link_view_users; ?>" ><?php echo $row->email; ?></a></td>
							<td><?php echo $row->ordering; ?></td>
							<td>

								<?php
								if($row -> id != 9 AND $row -> id != $_SESSION['ad_userid']){
									echo TemplateHelper::published("cb".($i),$row->published?"unpublished":"published");
								} 
								?>
							</td>
							<td> 
								<?php
									if($row -> id != 9){
									echo TemplateHelper::edit($link_view_users);
									} 
								?>
									
							</td>
							<td> 
								<?php 
									if($row -> id != 9 ){
								?>
									<a href="<?php echo $link_permission; ?>" title="Phân quyền" class="">
										<img src="<?php echo URL_ADMIN;?>templates/default/images/user.png" alt="">
									</a>
								<?php } ?>
							</td>
							<td><?php echo $row->id; ?></td>
						</tr>
						<?php $i++; ?>
					<?php }?>
					
				</tbody>
			</table>
		</div>
		<div class="footer_form">
			<?php echo $pagination->showPagination();?>
		</div>
		<input type="hidden" value="<?php echo $sort_field; ?>" name="sort_field">
		<input type="hidden" value="<?php echo $sort_direct; ?>" name="sort_direct">
		<input type="hidden" value="users" name="module">
		<input type="hidden" value="users" name="view">
		<input type="hidden" value="" name="task">
		<input type="hidden" value="0" name="boxchecked">
	</form>
</div>