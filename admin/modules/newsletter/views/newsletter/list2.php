<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Newsletter') );
//	$toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
//	$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
	$toolbar->addButton('cancel',FSText::_('Cancel'),'','cancel.png'); 
//	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
//	$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
//	$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
?>
<div class="form_body">
	<form action="index.php?module=<?php echo $this -> module;?>&view=<?php echo $this -> view;?>" name="adminForm" method="post">
		<table width="100%">
			<tr align="center" >
				<td align="center" valign="top">
					<?php if(@$list){ $i = 0;?>

						<?php 	foreach ($list as $row) { ?>
							<?php echo $row-> name .' &lt;'.$row -> email .'&gt;,'?>
								<img border="0" style="cursor:pointer" onclick="if (confirm('You certain remove this item?')){ window.location.href='index.php?module=newsletter&view=newsletter&task=remove&id=<?php echo $row ->id?>'}" alt="" src="templates/default/images/toolbar/remove_2.gif"><br/>
						<?php 	}?>
					<?php }?>
				</td>
			</tr>
		</table>
		
		<input type="hidden" value="<?php echo @$sort_field; ?>" name="sort_field">
		<input type="hidden" value="<?php echo @$sort_direct; ?>" name="sort_direct">
		<input type="hidden" value="<?php echo $this -> module;?>" name="module">
		<input type="hidden" value="<?php echo $this -> view;?>" name="view">
		<input type="hidden" value="<?php echo ($i+1);?>" name="total">
		<input type="hidden" value="<?php echo FSInput::get('page',0,'int');?>" name="page">
		<input type="hidden" value="<?php echo 'name,email,ordering';?>" name="field_change">
		<input type="hidden" value="" name="task">
		<input type="hidden" value="0" name="boxchecked">
	</form>
</div>