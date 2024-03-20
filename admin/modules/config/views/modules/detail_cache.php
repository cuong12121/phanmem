<?php if(isset($config['cache']) && $config['cache']): ?>
<fieldset>
	<legend>Cache</legend>
	<table cellspacing="1" class="admintable" width="100%">
		<tr>
			<td valign="top" width="109">
				<?php echo FSText::_('Thời lượng cache'); ?>
			</td>
			<td   valign="top">
				<?php $value = $data -> cache ?  $data -> cache : $config['cache'];  ?>
				<input name="cache" value="<?php echo $value; ?>" /> <?php echo FSText::_('Second')?>
			</td>
			<td  width="30">
				&nbsp;
			</td>
		</tr>
	</table>
</fieldset>
<?php endif;?>