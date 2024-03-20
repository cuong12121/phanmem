			<table border="1" class="tbl_form_contents" width="100%" cellpadding="5" bordercolor="#cccccc">
				<tr>
							<td valign="top" class="key">
								<?php echo FSText :: _('Quyền trên danh mục tin tức'); ?>
								<br/>
							</td>
							<td>
								<div>
									<input type="radio" id = 'check_news_categories_none' name='area_news_categories_select' value='none' <?php echo (!@$data->news_categories||@$data->news_categories == 'none')? 'checked="checked"':'';?> /> Kh&#244;ng n&#417;i n&#224;o
									<input type="radio" id = 'check_news_categories_select' name='area_news_categories_select' value='select' <?php echo (@$data->news_categories && @$data->news_categories != 'none' && @$data->news_categories != 'all')? 'checked="checked"':'';?> /> L&#7921;a ch&#7885;n
									<input type="radio" id = 'check_news_categories_all' name='area_news_categories_select'  value='all' <?php echo (@$data->news_categories == 'all')? 'checked="checked"':'';?> /> T&#7845;t c&#7843;
								</div>
<!--								-->
								<?php 
									$checked = 0;
									$checked_all = 0;
									
									if((!@$data->news_categories) || @$data->news_categories === 'none' || @$data->news_categories === '0'){
										$checked = 0;
									} else if(@$data->news_categories === 'all'){
										$checked_all = 1;
									} else {
										$checked = 1;
										$checked_all = 0;
										$arr_news_categories = explode(',',@$data->news_categories);
									}?>
<!--								-->
								<select name ="news_categories[]" size="20" multiple="multiple" class='news_categories' >
									<?php 
									
									foreach($news_categories as $item) {
										$html_check = "";
										if($checked_all){
											$html_check = "' selected='selected' ";
										} else {
											if($checked){
												if(in_array($item->id,$arr_news_categories)) {
													$html_check = "' selected='selected' ";
												}
											}
										}
									?>
										<option value="<?php echo $item->id; ?>" <?php echo $html_check; ?>><?php echo $item -> treename; ?></option>
									<?php } ?>
								</select>
							</td>
						</tr>
				<tr>
							<td valign="top" class="key">
								<?php echo FSText :: _('Quyền trên danh mục sản phẩm'); ?>
								<br/>
							</td>
							<td>
								<div>
									<input type="radio" id = 'check_products_categories_none' name='area_products_categories_select' value='none' <?php echo (!@$data->news_categories||@$data->products_categories == 'none')? 'checked="checked"':'';?> /> Kh&#244;ng n&#417;i n&#224;o
									<input type="radio" id = 'check_products_categories_select' name='area_products_categories_select' value='select' <?php echo (@$data->news_categories && @$data->products_categories != 'none' && @$data->news_categories != 'all')? 'checked="checked"':'';?> /> L&#7921;a ch&#7885;n
									<input type="radio" id = 'check_products_categories_all' name='area_products_categories_select'  value='all' <?php echo (@$data->products_categories == 'all')? 'checked="checked"':'';?> /> T&#7845;t c&#7843;
								</div>
								
								<?php 
									$checked = 0;
									$checked_all = 0;
									
									if((!@$data->products_categories) || @$data->products_categories === 'none' || @$data->products_categories === '0'){
										$checked = 0;
									} else if(@$data->products_categories === 'all'){
										$checked_all = 1;
									} else {
										$checked = 1;
										$checked_all = 0;
										$arr_products_categories = explode(',',@$data->products_categories);
									}?>
								<select name ="products_categories[]" size="20" multiple="multiple" class='products_categories' >
									<?php 
									
									foreach($products_categories as $item) {
										
										$html_check = "";
										if($checked_all){
											$html_check = "' selected='selected' ";
										} else {
											if($checked){
												if(in_array($item->id,$arr_products_categories)) {
													$html_check = "' selected='selected' ";
												}
											}
										}
									?>
										<option value="<?php echo $item->id; ?>" <?php echo $html_check; ?>><?php echo $item -> treename; ?></option>
									<?php } ?>
								</select>
							</td>
						</tr>
			</table>
			
<script type="text/javascript">
	$(document).ready(function() {
		// news
		$('#check_news_categories_none').click(function(){
			$('.news_categories option').each(function(){
				$(this).attr('selected', '');
			});
			$('.news_categories').attr('disabled','disabled');
		});
		$('#check_news_categories_all').click(function(){
			$('.news_categories option').each(function(){
				$(this).attr('selected', 'selected');
			});
			$('.news_categories').attr('disabled','disabled');
		});
		$('#check_news_categories_select').click(function(){
			$('.news_categories').removeAttr('disabled');
		});
		
		// products
		$('#check_products_categories_none').click(function(){
			$('.products_categories option').each(function(){
				$(this).attr('selected', '');
			});
			$('.products_categories').attr('disabled','disabled');
		});
		$('#check_products_categories_all').click(function(){
			$('.products_categories option').each(function(){
				$(this).attr('selected', 'selected');
			});
			$('.products_categories').attr('disabled','disabled');
		});
		$('#check_products_categories_select').click(function(){
			$('.products_categories').removeAttr('disabled');
		});
	});
</script>
