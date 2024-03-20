<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Translate phrase') );
?>
<form action="index.php?module=languages&view=text&type=fontend" name="adminForm" method="post" >
	<input type="hidden" value="languages" name="module">
	<input type="hidden" value="text" name="view">
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
						<?php foreach($list_lang as $lang_item){?>
						<th class="title" >
							<?php echo ucfirst($lang_item -> language); ?>
						</th>
						<?php }?>
									
						<th class="title">
							Lưu
						</th>
						<th class="title">
							Xóa
						</th>
						<th class="title">
							<?php echo FSText :: _("Id")?>
						</th>
					</tr>
				</thead>
				<tbody>
				
					<!--	Thêm mới				-->
					<form action="index.php?module=languages&view=text&type=fontend" name="item" method="post" id="form_0">
							<tr class="row1">
								<td></td>
								<td>
									<input type="text" name='lang_key' value='<?php echo @$row -> lang_key?>' size="36" />
								</td>
								<?php foreach($list_lang as $lang_item){?>	
									<?php $field_lang_name = 'lang_'.$lang_item -> lang_sort; ?>
								<td>
									<input type="text" name='lang_value_<?php echo $lang_item -> lang_sort; ?>' value='' size="36" />
								</td>
								<?php }?>
								<td>
									<a href='javascript:void(0)' onclick="javascript:save_record(0)" >
										<img src="templates/default/images/toolbar/save_add.png" alt="Lưu" />
									</a>
								</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<input type="hidden" value="languages" name="module">
							<input type="hidden" value="text" name="view">
							<input type="hidden" value="" name="id">
							<input type="hidden" value="save" name="task" id='task_0'>
							<input type="hidden" value="0" name="boxchecked">
						</form>					
					<!--	end Thêm mới				-->
					
					<!--	Sửa				-->
					<?php $i = 0; ?>
					<?php if(@$list){?>
						<?php foreach ($list as $row) { ?>

							<form action="index.php?module=languages&view=text&type=fontend" name="item" method="post" id="form_<?php echo $row -> id; ?>">
								<tr class="row<?php echo $i%2; ?>">
									<td><?php echo ($i+1); ?></td>
									<td>
										<input type="text" name='lang_key' value='<?php echo @$row -> lang_key?>' size="36" />
									</td>
									<?php foreach($list_lang as $lang_item){?>	
										<?php $field_lang_name = 'lang_'.$lang_item -> lang_sort; ?>
									<td>
										<input type="text" name='lang_value_<?php echo $lang_item -> lang_sort; ?>' value='<?php echo $row -> $field_lang_name; ?>' size="36" />
									</td>
									<?php }?>
									<td>
										<a href='javascript:void(0)' onclick="javascript:save_record(<?php echo $row -> id; ?>)" >
											<img src="templates/default/images/toolbar/save.png" alt="Lưu" />
										</a>
									</td>
									<td>
										<a href='javascript:void(0)' onclick="javascript:remove_record(<?php echo $row -> id; ?>)" title='Xóa'>
											<img src="templates/default/images/toolbar/remove.png" alt="Xóa" />
										</a>
									</td>
									
									<td><?php echo $row->id; ?></td>
								</tr>
								<input type="hidden" value="languages" name="module">
								<input type="hidden" value="text" name="view">
								<input type="hidden" value="<?php echo $row -> id ?>" name="id">
								<input type="hidden" value="save" name="task" id='task_<?php echo $row -> id; ?>'>
								<input type="hidden" value="0" name="boxchecked">
							</form>
							<?php $i++; ?>
						<?php }?>
					<?php }?>
				</tbody>
			</table>
		</div>
		
</div>
<script>
function save_record(id){
	$('#task_'+id).val('save');
	$('#form_'+id).submit();
}
function remove_record(id){
	if(confirm('Bạn có chắc chắn muốn xóa')){
		$('#task_'+id).val('remove');
		$('#form_'+id).submit();
	}	
}
</script>