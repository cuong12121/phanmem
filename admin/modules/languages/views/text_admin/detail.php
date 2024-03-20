<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Translate to').' '.$lang-> language) ;
	$toolbar->addButton('back',FSText :: _('Back'),'','back.png');
?>
<form action="index.php?module=languages&view=text_admin&type=backend" name="adminForm" method="post" >
	<input type="hidden" value="languages" name="module">
	<input type="hidden" value="text_admin" name="view">
	<input type="hidden" value="" name="task">
	<input type="hidden" value="0" name="boxchecked">
</form>

<div class="form_body">
	
		
		<div class="form-contents">
			<table border="1" class="tbl_form_contents">
				<thead>
					<tr>
						<th width="3%">
							#
						</th>
						<th class="title" >
							Key
						</th>
						<th class="title" >
							<?php echo FSText::_('Value')?>
						</th>
						<th class="title">
							<?php echo FSText :: _("Translate")?>
						</th>
						<th class="title">
							<?php echo FSText :: _("Id")?>
						</th>
					</tr>
				</thead>
				<tbody>
					
					<?php $i = 0; ?>
					<?php if(@$list){?>
						<?php foreach ($list as $row) { ?>
							<form action="index.php?module=languages&view=text_admin&type=backend" name="item" method="post" onsubmit="javascript: return confirm('Bạn có chắc chắn muốn thay đổi'); " >
								<tr class="row<?php echo $i%2; ?>">
									<td><?php echo ($i+1); ?></td>
									<td>
										<?php echo $row -> lang_key; ?>
									</td>
									<td>
										<input type="text" name='value' value='<?php echo @$row -> lang_value?>' size="56" />
									</td>
									<td>
										<input type="submit" name='change' value='Change' />
									</td>
									
									<td><?php echo $row->id; ?></td>
								</tr>
								<input type="hidden" value="languages" name="module">
								<input type="hidden" value="text_admin" name="view">
								<input type="hidden" value="<?php echo $row -> id ?>" name="id">
								<input type="hidden" value="<?php echo $lang_sort; ?>" name="language">
								<input type="hidden" value="save" name="task">
								<input type="hidden" value="0" name="boxchecked">
							</form>
							<?php $i++; ?>
						<?php }?>
					<?php }?>
				</tbody>
			</table>
		</div>
		
</div>
