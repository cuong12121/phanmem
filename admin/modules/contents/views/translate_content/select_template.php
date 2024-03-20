<!-- HEAD -->
<?php 
	$title = FSText::_('L&#7921;a ch&#7885;n c&#225;c danh m&#7909;c'); 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('add',FSText::_('Tiếp tục'),'','next.jpg'); 
	$toolbar->addButton('cancel',FSText::_('Thoát'),'','cancel.png'); 
?>
<!-- END HEAD-->

<!-- BODY-->
<div class="form_body">
	<div id="msg_error"></div>
	<form action="index.php?module=contents&view=translate_content" name="adminForm" method="post">		
		<table cellspacing="1" class="admintable">
			
			<tr>
				<td valign="top" class="key">
					<?php echo FSText::_('Chọn template'); ?>
				</td>
				<td>
					<select name="etemplate_id" id="template_select" size="10">
						<?php 
						if($template){
							foreach ($template as $item){
							?>
								<option value="<?php echo $item->id; ?>"  ><?php echo $item->name;  ?> </option>	
							<?php }?>
						<?php }?>
					</select>
				</td>
			</tr>
		</table>
		<input type="hidden" value="contents" name="module">
		<input type="hidden" value="translate_content" name="view">
		<input type="hidden" value="" name="task">
		<input type="hidden" value="0" name="boxchecked">
	</form>		
</div>
<!-- END BODY-->
