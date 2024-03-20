<table cellspacing="1" class="admintable" width="100%" border="1" bordercolor="#CCC" cellpadding="5">
	<tr>
			<td valign="top" class="label1 " width="20%" align="center">Trường</td>
			<td width="40%" align="center">Bản ghi cũ</td>
			<td width="40%" align="center">So sánh</td>
		</tr>
<?php
//	$this -> dt_form_begin();
//	print_r($data_older -> $field);
	foreach($fields_in_compare as $field=>$field_title){
		if($data->$field != $data_older -> $field){
			if($field == 'image'){
				?>
				<tr>
					<td valign="top" class="label key"><strong><?php echo $field_title;?></strong></td>
					<td><?php echo $data_older->$field; ?></td>
					<td><strong>Up ảnh mới lên</strong></td>
				</tr>
				<?php 
				continue;
			}
			
			
			$diff = new FineDiff($data_older -> $field,$data->$field, $granularityStacks[3]);
			$edits = $diff->getOps();
			$rendered_diff = $diff->renderDiffToHTML();
			
	?>
		<tr>
			<td valign="top" class="label1 key"><strong><?php echo $field_title;?></strong></td>
			<td><?php echo $data_older->$field; ?></td>
			<td><?php echo $rendered_diff; ?></td>
		</tr>
	<?php 		
		}
	}
?>
</table>
<div> Người sửa: <?php echo $data -> action_username; ?></div>

<style type="text/css">
ins {
    color: green;
    background: #dfd;
    text-decoration: none;
}
del {
    color: #CCCCCC;
    text-decoration: line-through;
}
</style>