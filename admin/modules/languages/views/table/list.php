<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Item List') );
	$toolbar->addButton('back',FSText :: _('Back'),'','back.png');
?>
	<?php if($table->table_name == 'fs_menus_items'){ ?>
	
	<?php } ?>
	<?php 
	$id =  FSInput::get('id',0,'int');
	$page = FSInput::get('page',0,'int');
	?>
<div class="form_body">
	<form action="index.php?module=languages&view=tables" name="adminForm" method="post" >
		
		<div class="form-contents">
			<table border="1" class="tbl_form_contents">
				<thead>
					<tr>
						<th width="3%">
							#
						</th>
						<th class="title" >
							<?php echo ucfirst($main_field); ?>
						</th>
						<?php for($i = 0; $i < count($language_not_default);  $i ++ ){?>
						<th class="title" colspan="2" >
							<?php echo ucfirst($language_not_default[$i] -> language); ?>
						</th>
						<?php }?>
						<th class="title">
							<?php echo FSText :: _("Id")?>
						</th>
						<?php if($table->table_name == 'fs_menus_items'){ ?>
							<th class="group">
								<?php echo FSText :: _("Group")?>
							</th>
						<?php } ?>
					</tr>
				</thead>
				<tbody>
					
					<?php $i = 0; ?>
					<?php if(@$list){?>
						<?php foreach ($list as $row) {?>

							<?php $link_change_language = "index.php?module=languages&view=table&cid=".$row->id.""; ?>
							<tr class="row<?php echo $i%2; ?>">
								<td><?php echo ($i+1); ?></td>
								<td align="left">
									<?php echo $row -> $main_field; ?>
								</td>
								<?php for($j = 0; $j < count($language_not_default);  $j ++ ){?>
									<?php 
										$link_translate = 'index.php?module=languages&view=table&task=translate&id='.$row->id.'&language='.$language_not_default[$j]->id.'&table='.$table_id.'&before_id='.$id.'&before_page='.$page; 
										$field = $main_field.'_'.$language_not_default[$j]->lang_sort;
										if($row -> $main_field != $row -> $field){
									?>
									<td align="left"><?php echo $row -> $field; ?></td>
									<td>	
										<?php 
										if($row -> $field){
											echo "<a title='ok' href='".$link_translate."' >".FSText::_('Translate')."</a>";	
										} else {
											echo "<a title='not ok' href='".$link_translate."' >".FSText::_('No translate')."</a>";		
										}
										?>
									</td>
									<?php } else {?>
										<td align="left"><strong class="un_translate"><?php echo $row -> $field; ?></strong></td>
										<td><strong class="un_translate">	
											<?php 
											if($row -> $field){
												echo "<a title='ok' href='".$link_translate."' >".FSText::_('Translate')."</a>";	
											} else {
												echo "<a title='not ok' href='".$link_translate."' >".FSText::_('No translate')."</a>";		
											}
											?>
											</strong>
										</td>
									<?php }?>
								<?php }?>
								<td><?php echo $row->id; ?></td>
								<?php if(isset($row->group_id)){ ?>
									<td><?php echo $row->group_id; ?></td>
								<?php } ?>
							</tr>
							<?php $i++; ?>
						<?php }?>
					<?php }?>
					
				</tbody>
			</table>
		</div>
		<div class="footer_form">
			<?php if(@$pagination) {?>
			<?php echo $pagination->showPagination();?>
			<?php } ?>
		</div>
		<input type="hidden" value="languages" name="module">
		<input type="hidden" value="table" name="view">
		<input type="hidden" value="" name="task">
		<input type="hidden" value="0" name="boxchecked">
	</form>
</div>
<style>
.tbl_form_contents td, .tbl_form_contents td a {
    color: #000;
}
.tbl_form_contents td .un_translate a,.tbl_form_contents td .un_translate {
    color: #025A8D;
}
</style>
