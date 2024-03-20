<!-- HEAD -->
	<?php 
	
	$title = @$data ? FSText::_('Edit'): FSText::_('Add'); 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('apply',FSText::_('Apply'),'','apply.png'); 
	$toolbar->addButton('save',FSText::_('Save'),'','save.png'); 
	$toolbar->addButton('cancel',FSText::_('Cancel'),'','cancel.png');   
	?>
<!-- END HEAD-->

<!-- BODY-->
<div class="form_body">
	<form action="<?php echo "index.php?module=".$this -> module."&view=".$this -> view; ?>" name="adminForm" method="post" enctype="multipart/form-data">
		<table cellspacing="1" class="admintable">
			<tr>
				<td valign="top" class="key">
					<?php echo FSText::_('Name'); ?>
				</td>
				<td>
					<input type="text" name='name' value="<?php echo @$data->name; ?>" class='text' />
				</td>
			</tr>
			<!--<tr>
				<td valign="top" class="key">
					<?php echo FSText::_('Tên hiển thị'); ?>
				</td>
				<td>
					<input type="text" name='name_display' value="<?php echo @$data->name_display; ?>" class='text' />
				</td>
			</tr>
			--><tr>
				<td valign="top" class="key">
					<?php echo FSText::_('Alias'); ?>
				</td>
				<td>
					<input type="text" name='alias' class='text' value="<?php echo @$data->alias; ?>" /><font> (<?php echo FSText::_("Can auto generate");?> )</font>
				</td>
			</tr>
			<tr>
				<td valign="top" class="key">
					<?php echo FSText::_('Parent'); ?>
				</td>
				<td>
					<select name="parent_id" size="10" id='parent_id'>
						
						<?php 
						$compare = isset($data->parent_id)?$data->parent_id : 0;
						?>
						<option  value="0" <?php if(!$compare) echo "selected=\"selected\""; ?>  ><?php echo FSText::_("Parent");?></option>
						<?php foreach($categories as $cat ) { ?>
						<option  value="<?php echo $cat->id; ?>" <?php if($cat->id == $compare) echo "selected=\"selected\""; ?> ><?php echo $cat->treename; ?></option>
						<?php }?>
					</select>
				</td>
			</tr><!--
			<tr>
                    <td valign="top" class="key">
                        <?php echo FSText :: _('Nhóm tags'); ?>
                    </td>
                    <td>
                        <select name="tags_group" size="10" id="tags_group" >
                            <?php 
                                    $tags_group = @$data -> tags_group;
                                    $i = 0; 
                                    foreach ($tags_categories as $item)
                                    {
                                        $checked = "";
                                        if(($item->id == $tags_group))
                                            $checked = "selected=\"selected\"";
                                            
                                    ?>
                                <option value="<?php echo $item->id; ?>" <?php echo $checked; ?> ><?php echo $item->name;  ?> </option>
                            <?php 
                                $i ++;
                            }?>
                        </select>
                    </td>
                </tr>
			--><!--<tr>
				<td valign="top" class="key">
					<?php echo FSText::_('Hi&#7875;n th&#7883; trong trang ch&#237;nh'); ?>
				</td>
				<td>
					<input type="radio" name="show_in_homepage" value="1" <?php if(@$data->show_in_homepage) echo "checked=\"checked\"" ;?> />
					<?php echo FSText::_('Yes'); ?>
					<input type="radio" name="show_in_homepage" value="0" <?php if(!@$data->show_in_homepage) echo "checked=\"checked\"" ;?> />
					<?php echo FSText::_('No'); ?>
				</td>
			</tr>
			-->
			<tr>
				<td valign="top" class="key">
					<?php echo FSText::_('Hi&#7875;n th&#7883; d&#432;&#7899;i footer'); ?>
				</td>
				<td>
					<input type="radio" name="show_in_footer" value="1" <?php if(@$data->show_in_footer) echo "checked=\"checked\"" ;?> />
					<?php echo FSText::_('Yes'); ?>
					<input type="radio" name="show_in_footer" value="0" <?php if(!@$data->show_in_footer) echo "checked=\"checked\"" ;?> />
					<?php echo FSText::_('No'); ?>
				</td>
			</tr>
			<tr>
				<td valign="top" class="key">
					<?php echo FSText::_('Published'); ?>
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
					<?php echo FSText::_('Hiển thị title cho bài viết'); ?>
				</td>
				<td>
					<input type="radio" name="display_title" value="1" <?php if(@$data->display_title) echo "checked=\"checked\"" ;?> />
					<?php echo FSText::_('Yes'); ?>
					<input type="radio" name="display_title" value="0" <?php if(!@$data->display_title) echo "checked=\"checked\"" ;?> />
					<?php echo FSText::_('No'); ?>
				</td>
			</tr>
			<tr>
				<td valign="top" class="key">
					<?php echo FSText::_('Hiển thị tên category trong bài viết'); ?>
				</td>
				<td>
					<input type="radio" name="display_category" value="1" <?php if(@$data->display_category) echo "checked=\"checked\"" ;?> />
					<?php echo FSText::_('Yes'); ?>
					<input type="radio" name="display_category" value="0" <?php if(!@$data->display_category) echo "checked=\"checked\"" ;?> />
					<?php echo FSText::_('No'); ?>
				</td>
			</tr>
			<tr>
				<td valign="top" class="key">
					<?php echo FSText::_('Hiển thị comment trong bài viết'); ?>
				</td>
				<td>
					<input type="radio" name="display_comment" value="1" <?php if(@$data->display_comment) echo "checked=\"checked\"" ;?> />
					<?php echo FSText::_('Yes'); ?>
					<input type="radio" name="display_comment" value="0" <?php if(!@$data->display_comment) echo "checked=\"checked\"" ;?> />
					<?php echo FSText::_('No'); ?>
				</td>
			</tr>
			<tr>
				<td valign="top" class="key">
					<?php echo FSText::_('Hiển thị tags cho bài viết'); ?>
				</td>
				<td>
					<input type="radio" name="display_tags" value="1" <?php if(@$data->display_tags) echo "checked=\"checked\"" ;?> />
					<?php echo FSText::_('Yes'); ?>
					<input type="radio" name="display_tags" value="0" <?php if(!@$data->display_tags) echo "checked=\"checked\"" ;?> />
					<?php echo FSText::_('No'); ?>
				</td>
			</tr>
			<tr>
				<td valign="top" class="key">
					<?php echo FSText::_('Hiển thị tin liên quan cho bài viết'); ?>
				</td>
				<td>
					<input type="radio" name="display_related" value="1" <?php if(@$data->display_related) echo "checked=\"checked\"" ;?> />
					<?php echo FSText::_('Yes'); ?>
					<input type="radio" name="display_related" value="0" <?php if(!@$data->display_related) echo "checked=\"checked\"" ;?> />
					<?php echo FSText::_('No'); ?>
				</td>
			</tr>
			<tr>
				<td valign="top" class="key">
					<?php echo FSText::_('Hiển thị ngày tạo cho bài viết'); ?>
				</td>
				<td>
					<input type="radio" name="display_created_time" value="1" <?php if(@$data->display_created_time) echo "checked=\"checked\"" ;?> />
					<?php echo FSText::_('Yes'); ?>
					<input type="radio" name="display_created_time" value="0" <?php if(!@$data->display_created_time) echo "checked=\"checked\"" ;?> />
					<?php echo FSText::_('No'); ?>
				</td>
			</tr>
			<tr>
				<td valign="top" class="key">
					<?php echo FSText::_('Hiển thị tóm tắt bài viết'); ?>
				</td>
				<td>
					<input type="radio" name="display_summary" value="1" <?php if(@$data->display_summary) echo "checked=\"checked\"" ;?> />
					<?php echo FSText::_('Yes'); ?>
					<input type="radio" name="display_summary" value="0" <?php if(!@$data->display_summary) echo "checked=\"checked\"" ;?> />
					<?php echo FSText::_('No'); ?>
				</td>
			</tr>
			<tr>
				<td valign="top" class="key">
					<?php echo FSText::_('Ordering'); ?>
				</td>
				<td>
					<input type="text" name='ordering' value="<?php echo (isset($data->ordering)) ? @$data->ordering : @$maxOrdering; ?>"/>
				</td>
			</tr>
			<!--<tr>
				<td valign="top" class="key">
					<?php echo FSText::_('Images'); ?>
				</td>
				<td>
					<?php if(@$data->image){?>
					<img alt="<?php echo $data->name?>" src="<?php echo URL_IMG_ESTORE.'categories'.DS.'images'.DS.$data->image; ?>" /><br/>
					<?php }?>
					<input type="file" name="image" />
				</td>
			</tr>
			--><!--<tr>
				<td valign="top" class="key">
					<?php echo FSText::_('Icon'); ?>
				</td>
				<td>
					<?php if(@$data->icon){?>				
					<img alt="<?php echo $data->icon?>" src="<?php echo URL_IMG_NEWS.'categories/icons/original/'.$data->icon; ?>" /><br/>
					<?php }?>
					<input type="file" name="icon" />
				</td>
			</tr>-->
		</table>
		<?php if(@$data->id) { ?>
		<input type="hidden" value="<?php echo $data->id; ?>" name="id">
		<?php }?>
		<input type="hidden" value="<?php echo $this -> view;?>" name="view">
		<input type="hidden" value="<?php echo $this -> module;?>" name="module">
		<input type="hidden" value="" name="task">
		<input type="hidden" value="0" name="boxchecked">
	</form>
</div>
<!-- END BODY-->

