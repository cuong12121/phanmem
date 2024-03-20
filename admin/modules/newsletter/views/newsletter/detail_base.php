<table cellspacing="1" class="admintable">
			
	<tr>
		<td valign="top" class="key">
			<?php echo  FSText::_('Name'); ?>
		</td>
		<td>
			<input type="text" name='name' value="<?php echo @$data->name; ?>"  id="name" class="text">
			
		</td>
	</tr>
	<tr>
		<td valign="top" class="key">
			<?php echo  FSText::_('Email'); ?>
		</td>
		<td>
			<input type="text" name='email' value="<?php echo @$data->email; ?>"  id="email" class="text">
		</td>
	</tr>
	<!--<tr>
		<td valign="top" class="key">
			<?php echo FSText::_('Published'); ?>
		</td>
		<td>
			<input type="radio" name="published" value="1" <?php if(@$data->published) echo "checked=\"checked\"" ;?> />
			<?php echo FSText::_('Yes'); ?>
			<input type="radio" name="published" value="0" <?php if(!@$data->published) echo "checked=\"checked\"" ;?> />
			<?php echo FSText::_('No'); ?>
		</td>
	</tr>
	--><tr>
		<td valign="top" class="key">
			<?php echo FSText :: _('Ordering'); ?>
		</td>
		<td>
			<input type="text" name='ordering' value="<?php echo (isset($data->ordering)) ? @$data->ordering : @$maxOrdering; ?>"/>
		</td>
	</tr>
</table>
