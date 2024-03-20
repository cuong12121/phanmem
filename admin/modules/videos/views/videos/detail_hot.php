		<table cellspacing="1" class="admintable">
			<tr>
				<td valign="top" class="key">
					<?php echo FSText :: _('Is Pr'); ?>
				</td>
				<td>
					<input type="radio" name="is_hot" value="1" <?php if(@$data->published) echo "checked=\"checked\"" ;?> />
					<?php echo FSText :: _('Yes'); ?>
					<input type="radio" name="is_hot" value="0" <?php if(!@$data->published) echo "checked=\"checked\"" ;?> />
					<?php echo FSText :: _('No'); ?>
				</td>
			</tr>
			<tr>
				<td valign="top" class="key">
					<?php echo FSText :: _('Th&#7913; t&#7921; PR'); ?>
				</td>
				<td>
					<input type="text" name='hot_ordering' value="<?php echo (isset($data->hot_ordering)) ? @$data->hot_ordering : 0; ?>"/>
				</td>
			</tr>
			<tr>
				<td valign="top" class="key">
					<?php echo FSText :: _('Th&#7901;i gian b&#7855;t &#273;&#7847;u PR'); ?>
				</td>
				<td>
					<input type="text" name='hot_started_time' id='hot_started_time' value="<?php echo isset($data->hot_started_time)?date('m/d/Y',strtotime($data->hot_started_time)):''; ?>"/>
				</td>
			</tr>
			<tr>
				<td valign="top" class="key">
					<?php echo FSText :: _('Th&#7901;i gian b&#7855;t k&#7871;t th&#250;c PR'); ?>
				</td>
				<td>
					<input type="text" name='hot_expired_time' id='hot_expired_time' value="<?php echo @$data->hot_expired_time?date('m/d/Y',strtotime($data->hot_expired_time)):''; ?>"/>
				</td>
			</tr>
		</table>
<script>
	$(function() {
		$( "#hot_started_time" ).datepicker({clickInput:true});
		$( "#hot_started_time").change(function() {
			document.formSearch.submit();
		});
		$( "#hot_expired_time" ).datepicker({clickInput:true});
		$( "#hot_expired_time").change(function() {
			document.formSearch.submit();
		});
	});
</script>