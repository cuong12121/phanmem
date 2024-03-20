<!-- HEAD -->
	<?php 
	
	$title = @$data ? FSText::_('Edit'): FSText::_('Add'); 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('apply',FSText::_('Apply'),'','apply.png'); 
	$toolbar->addButton('save',FSText::_('Save'),'','save.png'); 
	$toolbar->addButton('cancel',FSText::_('Cancel'),'','cancel.png');   
	?>
<!-- END HEAD-->

<!-- BODY-->
<div class="form_body">
	<form action="<?php echo "index.php?module=".$this -> module."&view=".$this -> view; ?>" name="adminForm" method="post" enctype="multipart/form-data">
		<table cellspacing="1" class="admintable">
			<tr>
				<td valign="top" class="key">
					<?php echo FSText::_('Name'); ?>
				</td>
				<td>
					<input type="text" name='name' value="<?php echo @$data->name; ?>" class='text' />
				</td>
			</tr>
			<tr>
				<td valign="top" class="key">
					Link
				</td>
				<td>
					<input type="text" id="link" name='link' class='text' value="<?php echo @$data->link; ?>" />
				</td>
			</tr>
			<tr>
				<td valign="top" class="key">
					<?php echo FSText::_('Parent'); ?>
				</td>
				<td>
					<select name="parent_id" id='parent_id'>
						
						<option value="0">--Chọn menu cha--</option>
						<?
						foreach($categories as $row){
						?>
						<option value="<?=$row['id']?>"><?=$row['name']?></option>
						<?
						}
						?>
					</select>
				</td>
			</tr>
			
			<tr>
				<td valign="top" class="key">
					<?php echo FSText::_('Published'); ?>
				</td>
				<td>
					<input type="radio" name="published" value="1" checked="checked" />
					<?php echo FSText::_('Yes'); ?>
					<input type="radio" name="published" value="0" />
					<?php echo FSText::_('No'); ?>
				</td>
			</tr>
			
			<tr>
				<td valign="top" class="key">
					<?php echo FSText::_('Ordering'); ?>
				</td>
				<td>
					<input type="text" name='ordering' value="<?php echo (isset($data->ordering)) ? @$data->ordering : @$maxOrdering; ?>"/>
				</td>
			</tr>			
		</table>
		<?php if(@$data->id) { ?>
		<input type="hidden" value="<?php echo $data->id; ?>" name="id">
		<?php }?>
		<input type="hidden" value="<?php echo $this -> view;?>" name="view">
		<input type="hidden" value="<?php echo $this -> module;?>" name="module">
		<input type="hidden" value="" name="task">
		<input type="hidden" value="0" name="boxchecked">
	</form>
</div>
<!-- END BODY-->

