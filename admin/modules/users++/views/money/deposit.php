<!-- HEAD -->
	<?php 
	
	$title = 'Nạp tiền vào tài khoản'; 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
	$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('cancel',FSText :: _('Cancel'),'','cancel.png'); 
	?>
<!-- END HEAD-->

<!-- BODY-->
<div class="form_body">
	<form action="index.php?module=<?php echo $this -> module;?>&view=<?php echo $this -> view;?>" name="adminForm" method="post" enctype="multipart/form-data">
		<table cellspacing="1" class="admintable">
			<tr>
				<td valign="top" class="key">
					<?php echo FSText :: _('Username'); ?>
				</td>
				<td>
					<?php echo $data -> username;?>
				</td>
			</tr>
			<tr>
				<td valign="top" class="key">
					<?php echo FSText :: _('Số dư hiện tại'); ?>
				</td>
				<td>
					<strong><?php echo format_money($data -> money);?></strong> VNĐ
				</td>
			</tr>
			<tr>
				<td valign="top" class="key">
					<?php echo FSText :: _('Số tiền nạp cho thành viên này'); ?>
				</td>
				<td>
					<input type="text" name='deposit_money' value=""  id="deposit_money"> VNĐ
				</td>
			</tr>
			<tr>
				<td valign="top" class="key">
					<?php echo FSText :: _('Nhập lại số tiền'); ?>
				</td>
				<td>
					<input type="text" name='re_deposit_money' value=""  id="re_deposit_money"> VNĐ
				</td>
			</tr>
		</table>
		<?php if(@$data->id) { ?>
		<input type="hidden" value="<?php echo FSInput::get('uid',0,'int'); ?>" name="uid">
		<?php }?>
		<input type="hidden" value="<?php echo $data -> username;?>" name="username">
		<input type="hidden" value="<?php echo $this -> module;?>" name="module">
		<input type="hidden" value="<?php echo $this -> view;?>" name="view">
		<input type="hidden" value="" name="task">
		<input type="hidden" value="0" name="boxchecked">
	</form>
</div>
<!-- END BODY-->
