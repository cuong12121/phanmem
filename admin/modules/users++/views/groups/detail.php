<!-- HEAD -->
	<?php 
	
	$title = @$data ? FSText :: _('Edit user groups'): FSText :: _('New user groups'); 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
	$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('cancel',FSText :: _('Cancel'),'','cancel.png'); 
	?>
<!-- END HEAD-->

<!-- BODY-->
<div class="form_body">
	<form action="index.php?module=users&view=groups" name="adminForm" method="post">
		<table cellspacing="1" class="admintable">
			<tr>
				<td valign="top" class="key">
					<?php echo FSText :: _('Name'); ?>
				</td>
				<td>
					<input type="text" name='group_name' value="<?php echo @$data->group_name; ?>">
				</td>
			</tr>
			<tr>
				<td valign="top" class="key">
					<?php echo FSText::_('Published'); ?>
					
				</td>
				<td>
					<?php $published = isset($data->published)?$data->published:1;?>
					<input type="radio" name="published" value="1" <?php if($published) echo "checked=\"checked\"" ;?> />
					<?php echo FSText::_('Yes'); ?>
					<input type="radio" name="published" value="0" <?php if(!$published) echo "checked=\"checked\"" ;?> />
					<?php echo FSText::_('No'); ?>
				</td>
			</tr>
			<tr>
				<td valign="top" class="key">
					<?php echo FSText :: _('Ordering'); ?>
				</td>
				<td>
					<input type="text" name='ordering' value="<?php echo @$data->ordering; ?>">
				</td>
			</tr>
			<tr>
				<td valign="top" class="key">
					<?php echo FSText :: _('Permission'); ?>
				</td>
				<td>
					<table border="1" class="tbl_permisson">
						<tr>
							<th><?php echo FSText :: _('Module'); ?> </th>
							<th><?php echo FSText :: _('View'); ?> </th>
							<th><?php echo FSText :: _('Edit'); ?> </th>
							<th><?php echo FSText :: _('Remove'); ?> </th>
						</tr>
						<?php
						$array_module_type = array();
						for($i = 0 ; $i < count(@$permissions); $i ++ ) 
						{
							$item = $permissions[$i];
							$array_module_type[] = $item->module_typeid; 
							$name_box = "per_";
							$name_box .= $item -> module_typeid ?  ($item -> module_typeid): "0";
							$id_box = $name_box;
							$name_box .= "[]";
						?>
						<tr>
							<td>	<?php echo FSText::_($item->module_type_name); ?></td>
							<td>
								<input  type="checkbox" value="3"  name="<?php echo $name_box; ?>" <?php echo @$item->permission >= 3 ?"checked=\"checked\"":""; ?> id="<?php echo $id_box."_v"; ?>"/>
							</td>
							<td>
								<input type="checkbox" value="5"  name="<?php echo $name_box; ?>" <?php echo @$item->permission >= 5 ?"checked=\"checked\"":""; ?> id="<?php echo $id_box."_v"; ?>" />
							</td>
							<td>
								<input type="checkbox" value="7"  name="<?php echo $name_box; ?>" <?php echo @$item->permission >= 7 ?"checked=\"checked\"":""; ?> id="<?php echo $id_box."_v"; ?>" />	
							</td>
							
						</tr>	
						<?php } ?>
					</table>
				</td>
			</tr>
		</table>
		<?php if(@$data->id) { ?>
		<input type="hidden" value="<?php echo $data->id; ?>" name="cid">
		<?php }?>
		<?php $str_module_type = implode(",",$array_module_type); ?>
		<input type="hidden" value="<?php echo $str_module_type;?>" name="modulelist">
		<input type="hidden" value="users" name="module">
		<input type="hidden" value="groups" name="view">
		<input type="hidden" value="" name="task">
		<input type="hidden" value="0" name="boxchecked">
	</form>
</div>
<!-- END BODY-->
