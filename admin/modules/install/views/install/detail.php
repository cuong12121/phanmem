<!-- HEAD -->
	
	<?php
	
	global $toolbar;
//	$toolbar->setTitle($title);
	$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');   
	?>
<!-- END HEAD-->

<!-- BODY-->
<div class="form_body">
	<form action="index.php?module=<?php echo $this -> module;?>&view=<?php echo $this -> view;?>" name="adminForm" method="post" enctype="multipart/form-data">
		<table cellspacing="1" class="admintable">
			<tr>
				<td valign="top" class="key">
					<?php echo FSText :: _('Họ và tên'); ?>
				</td>
				<td>
					<input type="text" name='fullname' value="<?php echo @$data->fullname; ?>" />
				</td>
			</tr>
			<tr>
				<td valign="top" class="key">
					<?php echo FSText :: _('Email'); ?>
				</td>
				<td>
					<input type="text" name='email' value="<?php echo @$data->email; ?>" />
				</td>
			</tr>
			<tr>
				<td valign="top" class="key">
					<?php echo FSText :: _('Address'); ?>
				</td>
				<td>
					<input type="text" name='address' value="<?php echo @$data->address; ?>" />
				</td>
			</tr>
			<tr>
				<td valign="top" class="key">
					<?php echo FSText :: _('Telephone'); ?>
				</td>
				<td>
					<input type="text" name='telephone' value="<?php echo @$data->telephone; ?>" />
				</td>
			</tr>
			<tr>
				<td valign="top" class="key">
					<?php echo FSText :: _('Dịch vụ'); ?>
				</td>
				<td>
					<?php echo $service -> name; ?>
				</td>
			</tr>
			<tr>
				<td valign="top" class="key">
					<?php echo FSText :: _('Ngày đăng ký'); ?>
				</td>
				<td>
					<?php echo date('d/m/Y H:i',strtotime($data -> created_time))?>
				</td>
			</tr>
			<tr>
				<td valign="top" class="key">
					<?php echo FSText :: _('Ghi chú'); ?>
				</td>
				<td>
					<?php
					$oFCKeditor1 = new FCKeditor('content') ;
					$oFCKeditor1->BasePath	=  '../libraries/wysiwyg_editor/' ;
					$oFCKeditor1->Value		= @$data->content;
					$oFCKeditor1->Width = 650;
					$oFCKeditor1->Height = 450;
					$oFCKeditor1->Create() ;
					?>
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
		</table>
		<?php if(@$data->id) { ?>
		<input type="hidden" value="<?php echo $data->id; ?>" name="id">
		<?php }?>
		<input type="hidden" value="<?php echo $this -> module;?>" name="module">
		<input type="hidden" value="<?php echo $this -> view;?>" name="view">
		<input type="hidden" value="" name="task">
		<input type="hidden" value="0" name="boxchecked">
	</form>
</div>
<!-- END BODY-->
