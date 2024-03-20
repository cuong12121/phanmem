<!-- HEAD -->
	<?php 
	
	$title = FSText :: _('Edit'); 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('cancel',FSText :: _('Cancel'),'','cancel.png');  
	?>
<!-- END HEAD-->


<!-- BODY-->
<div class="form_body">
	<div id="msg_error"></div>
    <div class="form-contents">
	<form action="index.php?module=users&view=myself" name="adminForm" method="post">
		<fieldset>
			<legend><?php echo FSText :: _("user info");?></legend>
		
			<table cellspacing="1" class="admintable">
				
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Username'); ?>
					</td>
					<td>
						<strong><?php echo @$data->username; ?></strong>
					</td>
				</tr>
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Email'); ?>
					</td>
					<td>
						<strong><?php echo @$data->email; ?></strong>
					</td>
				</tr>
			</table>
			</fieldset>
			<fieldset>
				<legend><?php echo FSText :: _("Password");?></legend>
				<table cellspacing="1" class="admintable">
					<?php if(@$data){?>
					<tr>
						<td class="label1"><span><?php echo FSText::_('Sửa password')?></span></td>
						<td class="value1">
							<input type="radio" name="edit_pass" id="edit_pass1" class='edit_pass' value="1" /> Có
							<input type="radio" name="edit_pass" id="edit_pass0" class='edit_pass'  value="0" checked="checked"/> Không
						</td>
					</tr>
					<?php }?>
					<tr class='password_area <?php echo @$data -> id?"hide":""?>'>
						<td class='label1'><font>*</font><?php echo FSText::_("Password")?></td>
						<td class='value1'>
							<input type="password" name="password1" id="password" />
						</td>
					</tr>
					<tr class='password_area <?php echo @$data -> id?"hide":""?>'>
						<td class='label1'><font>*</font><?php echo FSText::_("Re-Password")?></td>
						<td class='value1'>
							<input type="password" name="re-password1" id="re-password" />
						</td>
					</tr>
				</table>
			</fieldset>
			<fieldset>
				<legend><?php echo FSText :: _("Other information");?></legend>
				<table cellspacing="1" class="admintable">
					
					<tr>
						<td valign="top" class="key">
							<?php echo FSText :: _('First name'); ?>
						</td>
						<td>
							<input type="text" name='fname' value="<?php echo @$data->fname; ?>" >
							
						</td>
					</tr>
					<tr>
						<td valign="top" class="key">
							<?php echo FSText :: _('Middle-last name'); ?>
						</td>
						<td>
							<input type="text" name='lname' value="<?php echo @$data->lname; ?>" >
							
						</td>
					</tr>
					<tr>
						<td valign="top" class="key">
							<?php echo FSText :: _('Phone'); ?>
						</td>
						<td>
							<input type="text" name='phone' value="<?php echo @$data->phone; ?>" >
							
						</td>
					</tr>
					<tr>
						<td valign="top" class="key">
							<?php echo FSText :: _('Address'); ?>
						</td>
						<td>
							<input type="text" name='address' value="<?php echo @$data->address; ?>" >
							
						</td>
					</tr>
					<tr>
						<td valign="top" class="key">
							<?php echo FSText :: _('Country'); ?>
						</td>
						<td>
							<input type="text" name='country' value="<?php echo @$data->country; ?>" >
							
						</td>
					</tr>
				</table>
			</fieldset>
			
		
		<?php if(@$data->id) { ?>
		<input type="hidden" value="<?php echo $data->id; ?>" name="id">
		<?php }?>
		<input type="hidden" value="myself" name="view">
		<input type="hidden" value="users" name="module">
		<input type="hidden" value="" name="task">
		<input type="hidden" value="0" name="boxchecked">
	</form>
    </div><!--end: .form-contents-->
</div>
<!-- END BODY-->

<script type="text/javascript">
	function formValidator()
	{
		
		if(!notEmpty('username','T&#234;n &#273;&#259;ng nh&#7853;p kh&#244;ng &#273;&#432;&#7907;c &#273;&#7875; tr&#7889;ng'))
			return false;
		if(!checkMatchPass('M&#7853;t kh&#7849;u nh&#7853;p l&#7841;i kh&#244;ng &#273;&#250;ng'))
			return false;
		if(!emailValidator('email','B&#7841;n ph&#7843;i nh&#7853;p &#273;&#7883;a ch&#7881; Email'))
			return false;
		if(!madeSelection('groups','B&#7841;n ph&#7843;i ch&#7885;n nh&#243;m cho th&#224;nh vi&#234;n n&#224;y'))
			return false;
		return true;
	}
	$('#edit_pass0').click(function(){
		$('.password_area').addClass('hide');
	});
	$('#edit_pass1').click(function(){
		$('.password_area').removeClass('hide');
	});
</script>

