			<table cellspacing="1" class="admintable">
				
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Title'); ?>
					</td>
					<td>
						<input type="text" name='name' value="<?php echo htmlspecialchars(@$data->name); ?>"  id="name" class='text'>
						
					</td>
				</tr>
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Alias'); ?>
					</td>
					<td>
						<input type="text" name='alias' value="<?php echo @$data->alias; ?>"  id="alias" class='text'>
					</td>
				</tr>
				<tr>
					<td valign="top" class="key">
						Hãng sản xuất
					</td>
					<td>
						<select name="manufactory_id" id="manufactory_id" size="10">
							<?php 
							// selected category
							$cat_compare  = 0;
							if(@$data->manufactory_id)
							{
								$cat_compare = $data->manufactory_id;
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
								<option value="<?php echo $cat_item->id; ?>" <?php echo $checked; ?> ><?php echo $cat_item->name;  ?> </option>	
							<?php 
								$i ++;
							}?>
						</select>
					</td>
				</tr>
				<?php if(isset($data)) {?>
				<!--<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Editor'); ?>
					</td>
					<td>
						<input type="text" name='editor' value="<?php echo @$data->editor; ?>"  id="editor">
						
					</td>
				</tr>-->
				<?php } ?>
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
				<!--<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Summary'); ?>
					</td>
					<td>
						<textarea rows="9" cols="100" name="summary"><?php echo @$data->summary; ?></textarea>
					</td>
	
				</tr>
			<tr>
                    <td valign="top" class="key">
                        <?php echo FSText :: _('Tags'); ?>
                    </td>
                    <td>
                        <input type="text" name='tags'  value="<?php echo @$data->tags; ?>" class='text'>
                    </td>
                </tr>
                --><!--
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
		