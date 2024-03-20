			<table cellspacing="1" class="admintable">
				
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Title'); ?>
					</td>
					<td>
						<input type="text" name='title' value="<?php echo htmlspecialchars(@$data->title); ?>"  id="title" class='text'>
						<?php if(isset($data)){?>
						<?php $link_view_font_end = URL_ROOT.'tin-thoi-trang-tre/'.$data-> category_alias.'/'.$data-> alias.'-'.$data->id.'.html';	?>
						<br/>
<!--						 <p><a href="<?php echo $link_view_font_end; ?>" target="_blink" title="Xem tin bài ngoài font-end" >Xem</a></p>-->
						 <?php }?>
					</td>
				</tr>
				<!--<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Tiêu đề sẽ hiển thị'); ?>
					</td>
					<td>
						<input type="text" name='title_display' value="<?php echo htmlspecialchars(@$data->title_display); ?>"  id="title_display" class='text'>
					</td>
				</tr>
				--><tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Alias'); ?>
					</td>
					<td>
						<input type="text" name='alias' value="<?php echo @$data->alias; ?>"  id="alias" class='text'>
					</td>
				</tr>
				<!--<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Display title'); ?>
					</td>
					<td>
						<input type="radio" name="display_title" value="1" <?php if(@$data->display_title) echo "checked=\"checked\"" ;?> />
						<?php echo FSText :: _('Yes'); ?>
						<input type="radio" name="display_title" value="0" <?php if(!@$data->display_title) echo "checked=\"checked\"" ;?> />
						<?php echo FSText :: _('No'); ?>
					</td>
				</tr>
				--><!--<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Display column'); ?>
					</td>
					<td>
						<select name="display_column" id="display_column" >
							<?php 
							// selected category
							$compare  = 1;
							if(@$data->display_column)
							{
								$compare = $data->display_column;
							} 
							for($i = 1; $i < 3; $i ++){
								$checked = "";
								if($compare == $i){
									$checked = "selected=\"selected\"";
								} 
								echo '<option value="'.$i.'" '. $checked.' >'.$i.'</option>';
							}
							?>
						</select>
					</td>
				</tr>
				-->
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Categories'); ?>
					</td>
					<td>
						<select name="category_id" id="category_id" size="10">
							<?php 
							// selected category
							$cat_compare  = 0;
							if(@$data->category_id)
							{
								$cat_compare = $data->category_id;
							} 
							$i = 0;
							foreach ($categories as $cat_item) {
								$checked = "";
								if(!$cat_compare && !$i){
									$checked = "selected=\"selected\"";
								} else {
									if($cat_compare == $cat_item->id)
										$checked = "selected=\"selected\"";
								}
									
							?>
								<option value="<?php echo $cat_item->id; ?>" <?php echo $checked; ?> ><?php echo $cat_item->treename;  ?> </option>	
							<?php 
								$i ++;
							}?>
						</select>
					</td>
				</tr>
				
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Image'); ?>
					</td>
					<td>
						<?php if(@$data->image){?>
						<img alt="<?php echo $data->title?>" src="<?php echo URL_ROOT.str_replace('/original/','/resized/',$data->image); ?>" /><br/>
						<?php }?>
						<input type="file" name="image"  />
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
						<?php echo FSText :: _('Tin nhanh'); ?>
					</td>
					<td>
						<input type="radio" name="news_fast" value="1" <?php if(@$data->news_fast) echo "checked=\"checked\"" ;?> />
						<?php echo FSText :: _('Yes'); ?>
						<input type="radio" name="news_fast" value="0" <?php if(!@$data->news_fast) echo "checked=\"checked\"" ;?> />
						<?php echo FSText :: _('No'); ?>
					</td>
				</tr>
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Tin tiêu điểm'); ?>
					</td>
					<td>
						<input type="radio" name="news_focus" value="1" <?php if(@$data->news_focus) echo "checked=\"checked\"" ;?> />
						<?php echo FSText :: _('Yes'); ?>
						<input type="radio" name="news_focus" value="0" <?php if(!@$data->news_focus) echo "checked=\"checked\"" ;?> />
						<?php echo FSText :: _('No'); ?>
					</td>
				</tr>
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Tin slideshow'); ?>
					</td>
					<td>
						<input type="radio" name="news_slide" value="1" <?php if(@$data->news_slide) echo "checked=\"checked\"" ;?> />
						<?php echo FSText :: _('Yes'); ?>
						<input type="radio" name="news_slide" value="0" <?php if(!@$data->news_slide) echo "checked=\"checked\"" ;?> />
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
						<?php echo FSText :: _('Summary'); ?>
					</td>
					<td>
						<textarea rows="9" cols="100" name="summary"><?php echo @$data->summary; ?></textarea>
					</td>
	
				</tr>
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Content'); ?>
					</td>
					<td>
						<?php
						$oFCKeditor1 = new FCKeditor('content') ;
						$oFCKeditor1->BasePath	=  '../libraries/wysiwyg_editor/' ;
						$oFCKeditor1->Value		= stripslashes(@$data->content);
						$oFCKeditor1->Width = 650;
						$oFCKeditor1->Height = 450;
						$oFCKeditor1->Create() ;
						?>
					</td>
	
				</tr>
			<tr>
                    <td valign="top" class="key">
                        <?php echo FSText :: _('Tags'); ?>
                    </td>
                    <td>
                    	<textarea rows="4" cols="100" name="tags" ><?php echo @$data->tags; ?></textarea>
                    </td>
                </tr><!--
            <tr>
				 <td valign="top" class="key">
					  <?php echo FSText :: _('Từ khóa chính'); ?>
				 </td>
				 <td>
						<input type="text" name='main_key'  value="<?php echo @$data->main_key; ?>" class='text'>
						<font>(Giúp việc tìm kiếm sản phẩm viết liên quan)</font>
				 </td>
			</tr>
			--></table>
		