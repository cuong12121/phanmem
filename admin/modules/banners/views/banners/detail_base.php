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
					<?php echo  FSText::_('Link'); ?>
				</td>
				<td>
					<input type="text" name='link' value="<?php echo @$data->link; ?>"  id="link" class="text">
					
				</td>
	</tr>
	<tr>
		<td valign="top" class="key">
			Loại banner
		</td>
		<td>
			<select name="type" id="type" >
				<?php 
				// selected category
				$cat_compare  = 0;
				if(@$data->type)
				{
					$cat_compare = $data->type;
				} 
				$i = 0;
				foreach ($array_type as $key => $name) {
					$checked = "";
					if(!$cat_compare && !$i){
						$checked = "selected=\"selected\"";
					} else {
						if($cat_compare == $key)
							$checked = "selected=\"selected\"";
					}
						
				?>
					<option value="<?php echo $key; ?>" <?php echo $checked; ?> ><?php echo $name;  ?> </option>	
				<?php 
					$i ++;
				}?> 
			</select>
		</td>
	</tr>
	<tr>
		<td valign="top" class="key">
			<?php echo FSText :: _('Width'); ?>
		</td>
		<td>
			<input type="text" name='width' value="<?php echo (isset($data->width)) ? @$data->width : 0; ?>"/>
		</td>
	</tr>
	<tr>
		<td valign="top" class="key">
			<?php echo FSText :: _('Height'); ?>
		</td>
		<td>
			<input type="text" name='height' value="<?php echo (isset($data->height)) ? @$data->height : 0; ?>"/>
		</td>
	</tr>
	<tr>
		<td valign="top" class="key">
			Danh mục
		</td>
		<td>
			<select name="category_id" id="category_id">
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
					<option value="<?php echo $cat_item->id; ?>" <?php echo $checked; ?> ><?php echo $cat_item->name;  ?> </option>	
				<?php 
					$i ++;
				}?>
			</select>
		</td>
	</tr>
	
	<tr>
		<td valign="top" class="key">
			<?php echo  FSText::_('Image'); ?> (Nếu bạn chọn loại banner là ảnh)
		</td>
		<td>
			<?php if(@$data->image){?>
			<img alt="<?php echo $data->name?>" src="<?php echo URL_ROOT.$data->image; ?>" width="200" /><br/>
			<?php }?>
			<br/>
			<input type="file" name="image"  />
		</td>
	</tr>
	<tr>
		<td valign="top" class="key">
			<?php echo  FSText::_('Flash'); ?> (Nếu bạn chọn loại banner là flash)
		</td>
		<td>
			<?php if(@$data->flash){?>
			<embed height="117" width="221" menu="true" loop="true" play="true" src="<?php echo URL_ROOT.$data->flash?>" 
			pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash">
			<?php }?>
			<br/>
			<input type="file" name="flash"  />
		</td>
	</tr>
	<tr>
		<td valign="top" class="key">
			<?php echo FSText :: _('Nội dung'); ?>  (Nếu bạn chọn loại banner là HTML)
		</td>
		<td>
			<?php
			$oFCKeditor1 = new FCKeditor('content') ;
			
			$oFCKeditor1->Value		= @$data->content;
			$oFCKeditor1->Width = 650;
			$oFCKeditor1->Height = 450;
			$oFCKeditor1->Create() ;
			?>
		</td>

	</tr>
	<tr>
							<td valign="top" class="key">
								<?php echo FSText :: _('N&#417;i xu&#7845;t hi&#7879;n'); ?>
							</td>
							<td>
								<div>
									<input type="radio" id = 'check_none' name='area_select' value='none' <?php echo (!@$data->listItemid||@$data->listItemid == 'none')? 'checked="checked"':'';?> /> Kh&#244;ng n&#417;i n&#224;o
									<input type="radio" id = 'check_select' name='area_select' value='select' <?php echo (@$data->listItemid && @$data->listItemid != 'none' && @$data->listItemid != 'all')? 'checked="checked"':'';?> /> L&#7921;a ch&#7885;n
									<input type="radio" id = 'check_all' name='area_select'  value='all' <?php echo (@$data->listItemid == 'all')? 'checked="checked"':'';?> /> T&#7845;t c&#7843;
								</div>
								<?php 
									$listItemid = @$data->listItemid;
									$checked = 0;
									$checked_all = 0;
									
									if((!@$data->listItemid) || @$data->listItemid === 'none' || @$data->listItemid === '0'){
										$checked = 0;
									} else if(@$data->listItemid === 'all'){
										$checked_all = 1;
									} else {
										$checked = 1;
										$checked_all = 0;
										$arr_menu_item = explode(',',@$data->listItemid);
									}
								?>
								<select name ="menus_items[]" size="8" multiple="multiple" class='listItem' <?php echo (!@$data->listItemid || @$data->listItemid == 'none' || @$data->listItemid == 'all')? 'disabled="disabled"':'';?> >
									<?php 
									
									foreach($menus_items_all as $item) {
										
										$html_check = "";
										if($checked_all){
											$html_check = "' selected='selected' ";
										} else {
											if($checked){
												if(in_array($item->id,$arr_menu_item)) {
													$html_check = "' selected='selected' ";
												}
											}
										}
									?>
										<option value="<?php echo $item->id?>" <?php echo $html_check; ?>><?php echo $item -> name; ?></option>
									<?php } ?>
								</select>
							</td>
						</tr>
						
	<!--	Bổ sung thêm categories sản phẩm để khách hàng lựa chọn nếu lọc theo categories					-->
	<tr>
		<td valign="top" class="key">
			<?php echo FSText :: _('Danh mục tin tức'); ?>
		</td>
		<td>
			<?php 
				$data_news_categories = @$data->news_categories;
			?>
			<select name ="news_categories[]" size="8" multiple="multiple" class='news_categories' >
				<?php 
				
				foreach($news_categories as $item) {
					
					$html_check = "";
					if(strpos($data_news_categories,','.$item->id.',') !== false) {
						$html_check = "' selected='selected' ";
					}
				?>
					<option value="<?php echo $item->id?>" <?php echo $html_check; ?>><?php echo $item -> treename; ?></option>
				<?php } ?>
			</select>
		</td>
	</tr>
	<tr>
		<td valign="top" class="key">
			<?php echo FSText :: _('Danh mục sản phẩm'); ?>
		</td>
		<td>
			<?php 
				$data_products_categories = @$data->products_categories;
				// echo "<pre>";
				// print_r($data);
			?>
			<select name ="products_categories[]" size="8" multiple="multiple" class='products_categories' >
				<?php 
				
				foreach($products_categories as $item) {
					
					$html_check = "";
					if(strpos($data_products_categories,','.$item->id.',') !== false) {
						$html_check = "' selected='selected' ";
					}
				?>
					<option value="<?php echo $item->id?>" <?php echo $html_check; ?>><?php echo $item -> treename; ?></option>
				<?php } ?>
			</select>
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
			<?php echo FSText :: _('Ordering'); ?>
		</td>
		<td>
			<input type="text" name='ordering' value="<?php echo (isset($data->ordering)) ? @$data->ordering : @$maxOrdering; ?>"/>
		</td>
	</tr>
</table>
