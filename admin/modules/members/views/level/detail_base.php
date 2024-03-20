<table cellspacing="1" class="admintable">
			
	<tr>
		<td valign="top" class="key">
					<?php echo  FSText::_('Name'); ?>
				</td>
				<td>
					<input type="text" name='name' value="<?php echo @$data->name; ?>"  id="name" class="text">
					
				</td>
	</tr>
	<tr>
		<td valign="top" class="key">
			<?php echo  FSText::_('Image'); ?>
		</td>
		<td>
			<?php if(@$data->image){?>
			<img alt="<?php echo $data->name?>" src="<?php echo URL_ROOT.'images/training/w254_h166'."/".$data->image; ?>" /><br/>
			<?php }?>
			<input type="file" name="image"  />
		</td>
	</tr>
	<!--
	<tr>
		<td valign="top" class="key">
			<?php echo FSText :: _('Summary'); ?>
		</td>
		<td>
			<textarea rows="9" cols="60" name="summary"><?php echo @$data->summary; ?></textarea>
		</td>
	</tr>
		-->
	<tr>
		<td valign="top" class="key">
			<?php echo FSText :: _('Địa chỉ'); ?>
		</td>
		<td>
			<textarea rows="9" cols="60" name="address"><?php echo @$data->address; ?></textarea>
		</td>
	</tr>
	<tr>
		<td valign="top" class="key">
			<?php echo FSText :: _('Tóm tắt nội dung'); ?>
		</td>
		<td>
			<?php
			$oFCKeditor1 = new FCKeditor('description') ;
			$oFCKeditor1->BasePath	=  '../libraries/wysiwyg_editor/' ;
			$oFCKeditor1->Value		= @$data->description;
			$oFCKeditor1->Width = 650;
			$oFCKeditor1->Height = 450;
			$oFCKeditor1->Create() ;
			?>
		</td>

	</tr>
	<tr>
		<td valign="top" class="key">
			<?php echo FSText :: _('Nội dung chi tiết'); ?>
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
			<?php echo FSText::_('Kích hoạt buổi sáng'); ?>
		</td>
		<td>
			<input type="radio" name="published" value="1" <?php if(@$data->published) echo "checked=\"checked\"" ;?> />
			<?php echo FSText::_('Yes'); ?>
			<input type="radio" name="published" value="0" <?php if(!@$data->published) echo "checked=\"checked\"" ;?> />
			<?php echo FSText::_('No'); ?>
		</td>
	</tr>
	<tr>
		<td valign="top" class="key">
			<?php echo FSText::_('Kích hoạt buổi chiều'); ?>
		</td>
		<td>
			<input type="radio" name="sc_published" value="1" <?php if(@$data->sc_published) echo "checked=\"checked\"" ;?> />
			<?php echo FSText::_('Yes'); ?>
			<input type="radio" name="sc_published" value="0" <?php if(!@$data->sc_published) echo "checked=\"checked\"" ;?> />
			<?php echo FSText::_('No'); ?>
		</td>
	</tr>
	<tr>
		<td valign="top" class="key">
			<?php echo FSText :: _('Ngày tổ chức'); ?>
		</td>
		<td>
			<input type="text" name='started_date' id='started_date' value="<?php echo (isset($data->started_time)) ? date('d-m-Y',strtotime($data->started_time)) : ''; ?>"/>
		</td>
	</tr>
	<tr>
		<td valign="top" class="key">
			<?php echo FSText :: _('Thời gian bắt đầu sáng'); ?>
		</td>
		<td>
			Giờ:<input type="text" name='started_hour' id='started_hour' value="<?php echo (isset($data->started_time)) ? date('H',strtotime($data->started_time)) : '0'; ?>"/>&nbsp;
			Phút:<input type="text" name='started_minute' id='started_minute' value="<?php echo (isset($data->started_time)) ? date('i',strtotime($data->started_time)) : '0'; ?>"/>
		</td>
	</tr>
	<tr>
		<td valign="top" class="key">
			<?php echo FSText :: _('Thời gian kết thúc sáng'); ?>
		</td>
		<td>
			Giờ:<input type="text" name='finished_hour' id='finished_hour' value="<?php echo (isset($data->finished_time)) ? date('H',strtotime($data->finished_time)) : '0'; ?>"/>&nbsp;
			Phút:<input type="text" name='finished_minute' id='finished_minute' value="<?php echo (isset($data->finished_time)) ? date('i',strtotime($data->finished_time)) : '0'; ?>"/>
		</td>
	</tr>
	<tr>
		<td valign="top" class="key">
			<?php echo FSText :: _('Thời gian bắt đầu chiều'); ?>
		</td>
		<td>
			Giờ:<input type="text" name='sc_started_hour' id='sc_started_hour' value="<?php echo (isset($data->second_started_time)) ? date('H',strtotime($data->second_started_time)) : '0'; ?>"/>&nbsp;
			Phút:<input type="text" name='sc_started_minute' id='sc_started_minute' value="<?php echo (isset($data->second_started_time)) ? date('i',strtotime($data->second_started_time)) : '0'; ?>"/>
		</td>
	</tr>
	<tr>
		<td valign="top" class="key">
			<?php echo FSText :: _('Thời gian kết thúc chiều'); ?>
		</td>
		<td>
			Giờ:<input type="text" name='sc_finished_hour' id='sc_finished_hour' value="<?php echo (isset($data->second_finished_time)) ? date('H',strtotime($data->second_finished_time)) : '0'; ?>"/>&nbsp;
			Phút:<input type="text" name='sc_finished_minute' id='sc_finished_minute' value="<?php echo (isset($data->second_finished_time)) ? date('i',strtotime($data->second_finished_time)) : '0'; ?>"/>
		</td>
	</tr>
	<tr>
		<td valign="top" class="key">
			<?php echo FSText :: _('Số lượng người tham gia'); ?>
		</td>
		<td>
			<input type="text" name='quantity' value="<?php echo (isset($data->quantity)) ? @$data->quantity : 10; ?>"/>
		</td>
	</tr>
	<tr>
		<td valign="top" class="key">
			<?php echo FSText::_('Hiển thị bên cột trái'); ?>
		</td>
		<td>
			<input type="radio" name="show_left" value="1" <?php if(@$data->show_left) echo "checked=\"checked\"" ;?> />
			<?php echo FSText::_('Yes'); ?>
			<input type="radio" name="show_left" value="0" <?php if(!@$data->show_left) echo "checked=\"checked\"" ;?> />
			<?php echo FSText::_('No'); ?>
		</td>
	</tr>
	<!--<tr>
		<td valign="top" class="key">
			<?php echo FSText::_('Display in contact page'); ?>
		</td>
		<td>
			<input type="radio" name="is_contact" value="1" <?php if(@$data->is_contact) echo "checked=\"checked\"" ;?> />
			<?php echo FSText::_('Yes'); ?>
			<input type="radio" name="is_contact" value="0" <?php if(!@$data->is_contact) echo "checked=\"checked\"" ;?> />
			<?php echo FSText::_('No'); ?>
		</td>
	</tr>
	--><tr>
		<td valign="top" class="key">
			<?php echo FSText :: _('Ordering'); ?>
		</td>
		<td>
			<input type="text" name='ordering' value="<?php echo (isset($data->ordering)) ? @$data->ordering : @$maxOrdering; ?>"/>
		</td>
	</tr>
</table>
<script type="text/javascript" >
	$(function() {
		$( "#started_date" ).datepicker({clickInput:true,dateFormat: 'dd-mm-yy'});
		$( "#started_date").change(function() {
			document.formSearch.submit();
		});
	});
</script>
