<!-- HEAD -->
	<?php 
	
	$title = @$data ? FSText :: _('Edit user'): FSText :: _('New user'); 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
	$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('cancel',FSText :: _('Save'),'','cancel.png'); 
	?>
<!-- END HEAD-->


<!-- BODY-->
<div class="form_body">
	<div id="msg_error"></div>
	<form action="index.php?module=users&view=users" name="adminForm" method="post">
		<fieldset>
			<legend><?php echo FSText :: _("User information");?></legend>
		
			<table cellspacing="1" class="admintable">
				
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Username'); ?>
					</td>
					<td>
						<input type="text" name='username' value="<?php echo @$data->username; ?>"  id="username">
						
					</td>
				</tr>
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Password'); ?>
					</td>
					<td>
						<input type="password" name='password' value="" id="password">
						
					</td>
				</tr>
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Re-password'); ?>
					</td>
					<td>
						<input type="password" name='repass' value="" id="repass">
						
					</td>
				</tr>
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Email'); ?>
					</td>
					<td>
						<input type="text" name='email' value="<?php echo @$data->email; ?>" id="email" >
						
					</td>
				</tr>
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Groups'); ?>
					</td>
					<td>
						<select name="group_ids[]" multiple="multiple" id="groups">
							<option value=""><?php echo FSText :: _('Group'); ?>
							<?php for ($i = 0 ; $i< count($groups_all) ;$i ++ ){?>
								<?php 
								if(isset($groups_contain_user) && (in_array($groups_all[$i]->id,@$groups_contain_user)))
									$checked = "selected=\"selected\"";
								else
									$checked = "";
								?>
								<option value="<?php echo $groups_all[$i]->id; ?>" <?php echo $checked; ?> ><?php echo $groups_all[$i]->group_name;  ?> </option>	
							<?php }?>
						</select>
					</td>
				</tr>
	
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Published'); ?>
					</td>
					<td>
						<input type="radio" name="published" value="1" <?php if(@$data->published) echo "checked=\"checked\"" ;?> />
						<?php echo FSText :: _('Yes'); ?>
						<input type="radio" name="published" value="0" <?php if(!@$data->published) echo "checked=\"checked\"" ;?> />
						<?php echo FSText :: _('No'); ?>
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
			</table>
			</fieldset>
			<fieldset>
				<legend><?php echo FSText :: _("Other information");?></legend>
				<table cellspacing="1" class="admintable">
					
					<tr>
						<td valign="top" class="key">
							<?php echo FSText :: _('Fisrt Name'); ?>
						</td>
						<td>
							<input type="text" name='fname' value="<?php echo @$data->fname; ?>" >
							
						</td>
					</tr>
					<tr>
						<td valign="top" class="key">
							<?php echo FSText :: _('Last - Middle Name'); ?>
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
		<input type="hidden" value="users" name="view">
		<input type="hidden" value="users" name="module">
		<input type="hidden" value="" name="task">
		<input type="hidden" value="0" name="boxchecked">
	</form>
</div>
<!-- END BODY-->

<script language="javascript">
	function formValidator()
	{
		
		if(!notEmpty('username','Username is not empty '))
			return false;
		if(!checkMatchPass('Repassword does not match password'))
			return false;
		if(!emailValidator('email','You must enter a valid email address'))
			return false;
		if(!madeSelection('groups','You must select a group'))
			return false;
		return true;
		
	}
</script>

