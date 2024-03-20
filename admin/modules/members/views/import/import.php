<!-- HEAD -->
<div class="form_head">
	<?php $title = FSText::_('Import Danh sách thành viên để kích hoạt')?>
	<?php echo ToolbarHelper::setTitle($title); ?>
	<table>
		<tr>
			<td>
				<a href="index.php?module=members&view=import&task=sample" target="_blank"  title="download sample" class="toolbar"><span style="background: url(images/toolbar/download.png) no-repeat scroll center top transparent;" title="download sample">
				</span>
				Download sample</a>
				<a href="index.php?module=members&view=members"  class="toolbar"><span style="background: url(images/toolbar/cancel.png) no-repeat scroll center top transparent;" title="Cancel">
				</span>
				Cancel</a>
				
	
		</tr>
	</table>
</div>

<!-- END HEAD-->

<!-- BODY-->
<div class="form_body">
	<div id="msg_error"></div>
	<form action="index.php?module=members" name="adminForm" method="post" enctype="multipart/form-data">
			
			<!--	BASE FIELDS    -->
			<table cellspacing="1" class="admintable">
				
				<tr>
					<td valign="top" class="key">
						<?php echo FSText::_('Upload File'); ?>
					</td>
					<td>
						<input type="file" name="file_upload" />
					</td>
					<td>
						<input  type="submit" name="submit" value="Import" onclick="javascript:saveForm();"/> 
					</td>
				</tr>
				
			</table>
			
		<?php if(@$data->id) { ?>
		<input type="hidden" value="<?php echo $data->id; ?>" name="aid">
		<?php }?>
		<input type="hidden" value="import_save" name="task">
		<input type="hidden" value="members" name="module">
		<input type="hidden" value="import" name="view">
		<input type="hidden" value="0" name="boxchecked">
	</form>
</div>
<!-- END BODY-->

<script  type="text/javascript" language="javascript">
	function 	saveForm()
	{
		document.adminForm.onsubmit();
	}
		
</script>


