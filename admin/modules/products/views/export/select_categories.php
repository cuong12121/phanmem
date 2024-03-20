<!-- HEAD -->
<?php 
	$title = FSText::_('L&#7921;a ch&#7885;n c&#225;c danh m&#7909;c'); 
	global $toolbar;
	$toolbar->setTitle($title);
	//$toolbar->addButton('add',FSText::_('Th&#234;m m&#7899;i'),'','add.png'); 
	//$toolbar->addButton('cancel',FSText::_('Tho&#225;t'),'','cancel.png'); 
?>
<!-- END HEAD-->

<!-- BODY-->
<div class="form_body">
	<div id="msg_error"></div>
	<form action="index.php?module=products&view=products" name="adminForm" method="post">		
		<table cellspacing="1" class="admintable">
			
			<tr>
				<td valign="top" class="key">
					<?php echo FSText::_('Danh m&#7909;c s&#7843;n ph&#7849;m'); ?>
				</td>
				<td>
					<select name="cid" id="cat_select" size="10">
						<?php 
						if($categories){
							foreach ($categories as $item){
							?>
								<option value="<?php echo $item->id; ?>" onclick="javascript: submitbutton('add')"><?php echo $item->treename;  ?> </option>	
							<?php }?>
						<?php }?>
					</select>
				</td>
			</tr>
		</table>
		<input type="hidden" value="products" name="module">
		<input type="hidden" value="products" name="view">
		<input type="hidden" value="" name="task">
		<input type="hidden" value="0" name="boxchecked">
	</form>		
</div>
<!-- END BODY-->


