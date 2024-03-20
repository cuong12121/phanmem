			<table cellspacing="1" class="admintable">
				
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Bài viết'); ?>
					</td>
					<td>
						<input type="text" name='news_title' value="<?php echo @$news->title; ?>"  id="title">
					</td>
				</tr>
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Danh mục tin'); ?>
					</td>
					<td>
						<input type="text" name='category_name' value="<?php echo @$category_name; ?>"  id="title">
					</td>
				</tr>
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Published'); ?>
					</td>
					<td>
						<input type="radio" name="published" value="1" <?php if(@$data->published) echo "checked=\"checked\"" ;?> />
						<?php echo FSText :: _('Yes'); ?>
						<input type="radio" name="published" value="0" <?php if(!@$data->published) echo "checked=\"checked\"" ;?> />
						<?php echo FSText :: _('No'); ?>
					</td>
				</tr>
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Ordering'); ?>
					</td>
					<td>
						<input type="text" name='ordering' value="<?php echo (isset($data->ordering)) ? @$data->ordering : @$maxOrdering+1; ?>">
					</td>
				</tr>
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Nội dung '); ?>
					</td>
					<td>
						<?php
						$oFCKeditor1 = new FCKeditor('comment') ;
						$oFCKeditor1->BasePath	=  '../libraries/wysiwyg_editor/' ;
						$oFCKeditor1->Value		= stripslashes(@$data->comment);
						$oFCKeditor1->Width = 650;
						$oFCKeditor1->Height = 450;
						$oFCKeditor1->Create() ;
						?>
					</td>
	
				</tr>
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Người gửi'); ?>
					</td>
					<td>
						<input type="text" name='ordering' value="<?php echo (isset($data->name)) ? @$data->name :''; ?>" size="60">
					</td>
				</tr>
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Email'); ?>
					</td>
					<td>
						<input type="text" name='email' value="<?php echo (isset($data->email)) ? @$data->email :''; ?>" size="60">
					</td>
				</tr>
			</table>
		