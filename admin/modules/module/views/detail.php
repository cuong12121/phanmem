<!-- HEAD -->
	<?php 
	$title = @$data ? FSText :: _('S&#7917;a v&#7883; tr&#237; hi&#7875;n th&#7883;'): FSText :: _('T&#7841;o m&#7899;i v&#7883; tr&#237; hi&#7875;n th&#7883;'); 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('cancel',FSText :: _('Cancel'),'','cancel.png'); 
	?>
<!-- END HEAD-->

<!-- BODY-->
<div class="form_body">
    <div class="form-contents">
	<form action="index.php?module=module" name="adminForm" method="post">
					<?php global $position; ?>
					<table cellspacing="1" class="admintable">
						<tr>
							<td valign="top" class="key">
								<?php echo FSText :: _('Title'); ?>
							</td>
							<td>
								<input type="text" name='title' value="<?php echo @$data->title; ?>">
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
								<?php echo FSText :: _('Hiển thị tiêu đề'); ?>
							</td>
							<td>
								<input type="radio" name="showTitle" value="1" <?php if(@$data->showTitle) echo "checked=\"checked\"" ;?> />
								<?php echo FSText :: _('Yes'); ?>
								<input type="radio" name="showTitle" value="0" <?php if(!@$data->showTitle) echo "checked=\"checked\"" ;?> />
								<?php echo FSText :: _('No'); ?>
							</td>
						</tr>
						<tr>
							<td valign="top" class="key">
								<?php echo FSText :: _('Ordering'); ?>
							</td>
							<td>
								<input type="text" name='ordering' value="<?php echo @$data->ordering; ?>">
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
						<!--<tr>
							<td valign="top" class="key">
								<?php echo FSText :: _('Danh mục tin tức'); ?>
								<br/>
								<i><span >Chỉ xuất hiện nếu bạn chọn NƠI XUẤT HIỆN <strong class='red'>(ở trên)</strong> là <strong>danh mục tin tức</strong> hoặc <strong>chi tiết tin</strong></span></i>
							</td>
							<td>
								<?php 
									$data_news_categories = @$data->news_categories;
									if($data_news_categories)
										$arr_data_news_categories = explode(',',$data_news_categories);
									else
										$arr_data_news_categories = array();
								?>
								<select name ="news_categories[]" size="20" multiple="multiple" class='news_categories' >
									<?php 
									
									foreach($news_categories as $item) {
										
										$html_check = "";
										if(in_array($item->alias,$arr_data_news_categories)) {
											$html_check = "' selected='selected' ";
										}
									?>
										<option value="<?php echo $item->alias?>" <?php echo $html_check; ?>><?php echo $item -> treename; ?></option>
									<?php } ?>
								</select>
							</td>
						</tr>
						--><!--<tr>	
							<td valign="top" class="key">
								<?php echo FSText :: _('Ki&#7875;u'); ?>
							</td>
							<td>
								<input type="text" name='type' value="<?php echo @$data->module?$data->module:'contents'; ?>">
								<input type="text" name='type' value="contents" readonly="readonly">
							</td>
						</tr>
						-->
						<tr>
							<td valign="top" class="key">
								<?php echo FSText :: _('Kiểu'); ?>
							</td>
							<td>
								<select name="type" class="type" >
										<?php
										$block_select = isset($data->module)?$data->module:'contents';
										foreach($listmoduletype as $item){
											if( $item->block == $block_select ){
												echo "<option value='" . $item -> block. "' selected='selected'>" . $item->name .' ['.$item -> block.']'. "</option>";
											}
											else{
												echo "<option value='" . $item -> block . "'>" . $item->name .' ['.$item -> block.']'. "</option>";
											}
										} 
										?>
									</select>
							</td>
						</tr>
						
						<tr>
							<td valign="top" class="key">
								<?php echo FSText :: _('V&#7883; tr&#237;'); ?>
							</td>
							<td>
								
								<select name="position" class="pos" >
										<?php
										foreach($positions as $key => $p){
											if( (@$data->position) && $key == @$data->position ){
												echo "<option value='" . $key . "' selected='selected'>" . $p . "</option>";
											}
											else{
												echo "<option value='" . $key . "'>" . $p . "</option>";
											}
										} 
										?>
									</select>
							</td>
						</tr>
						
						<!--<tr>
							<td valign="top" class="key">
								<?php echo FSText :: _('Thu&#7853;n t&#7915;'); ?>
							</td>
							<td>
								<textarea rows="5" cols="30" name="params"><?php echo @$data->params; ?></textarea>
							</td>
						</tr>
						
						-->
							
						
						<?php if( @$data->module == 'contents'){?>
						<tr>	
							<td valign="top" class="key">
									<?php echo FSText :: _('Content'); ?>
							</td>
							<td>
								<?php
			//						echo $data->content;
									$oFCKeditor = new FCKeditor('content') ;
									$oFCKeditor->BasePath	=  '../libraries/wysiwyg_editor/' ;
									$oFCKeditor->Value		= @$data->content;
									$oFCKeditor->Width = 650;
									$oFCKeditor->Height = 450;
									$oFCKeditor->Create() ;
									?>
							</td>
						</tr>
						<?php }?>
						<tr>
							<td valign="top" class="key">
								<?php echo FSText :: _('Parameters'); ?>
							</td>
							<td   valign="top">
								<?php   include_once 'detail_params.php';?>	
							</td>
						</tr>
								
					</table>
		<?php if(@$data->id) { ?>
		<input type="hidden" value="<?php echo $data->id; ?>" name="id">
		<?php }?>
		<input type="hidden" value="module" name="module">
		<input type="hidden" value="" name="task">
		<input type="hidden" value="0" name="boxchecked">
	</form>
    </div><!--end: .form-contents-->
</div>
<!-- END BODY-->
<script type="text/javascript">
	$(document).ready(function() {
		$('#check_none').click(function(){
			$('.listItem option').each(function(){
				$(this).attr('selected', '');
			});
			$('.listItem').attr('disabled','disabled');
		});
		$('#check_all').click(function(){
			$('.listItem option').each(function(){
				$(this).attr('selected', 'selected');
			});
			$('.listItem').attr('disabled','disabled');
		});
		$('#check_select').click(function(){
			$('.listItem').removeAttr('disabled');
		});
	});
</script>