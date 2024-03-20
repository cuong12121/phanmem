<!-- HEAD -->
	<?php 
	
	$title = FSText::_('Đổi mật khẩu'); 
	global $toolbar;
	$toolbar->setTitle($title);
//	$toolbar->addButton('apply',FSText::_('Apply'),'','apply.png'); 
	$toolbar->addButton('save',FSText::_('Save'),'','save.png'); 
	?>
<!-- END HEAD-->
<!-- BODY-->
<div class="form_body">
	<div id="msg_error"></div>
<form action="index.php?module=<?php echo $this -> module;?>&view=<?php echo $this -> view;?>" name="adminForm" method="post" enctype="multipart/form-data">
			
			<!--	BASE FIELDS    -->
			<table cellpadding="6" cellspacing="0">
				<tr>
					<td class="label1"><span>Username </span></td>
					<td class="value1">
							<?php echo @$data->username; ?>
					</td>
				</tr>
				<tr>
					<td class="label1"><span>Họ tên </span></td>
					<td class="value1">
							<?php echo @$data->lname; ?>
					</td>
				</tr>
				<tr>
					<td class="label1"><span>&#272;&#7883;a ch&#7881;</span></td>
					<td class="value1">
						<?php echo @$data->address; ?>
					</td>
				</tr>
				<tr>
					<td class="label1"><span>&#272;i&#7879;n tho&#7841;i</span></td>
					<td class="value1">
						<?php echo @$data-> phone; ?>
				</tr>
				<tr>
					<td class="label1"><span>Email</span></td>
					<td class="value1">
						<?php echo @$data-> email; ?>
					</td>
				</tr>
				<tr class='password_area'>
					<td class='label1'><font>*</font><?php echo FSText::_("Mật khẩu cũ")?></td>
					<td class='value1'>
						<input type="password" name="old_password" id="old_password"  autocomplete='off' />
					</td>
				</tr>
				<tr class='password_area'>
					<td class='label1'><font>*</font><?php echo FSText::_("Password")?></td>
					<td class='value1'>
						<input type="password" name="password1" id="password"  autocomplete='off' />
					</td>
				</tr>
				<tr class='password_area'>
					<td class='label1'><font>*</font><?php echo FSText::_("Re-Password")?></td>
					<td class='value1'>
						<input type="password" name="re-password1" id="re-password" />
					</td>
				</tr>
			</table>	
			
		<?php if(@$data->id) { ?>
		<input type="hidden" value="<?php echo @$data->id; ?>" name="id">
		<?php }?>
		<input type="hidden" value="add" name="view">
		<input type="hidden" value="addm_module" name="module">
		<input type="hidden" value="" name="task">
		<input type="hidden" value="0" name="boxchecked">
	</form>
</div>
<!-- END BODY-->
