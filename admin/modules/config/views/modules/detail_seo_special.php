<?php if(isset($config['seo_special'])): ?>
	<tr>
		<td valign="top" width="109">
			SEO Title
		</td>
		<td   valign="top">
			<input type="text" name='value_seo_title' value="<?php echo $data -> value_seo_title;?>" size="70"  >
		</td>
		<td  width="30">
				<div class="help_area fa fa-th-list">	
					<div style="display: none;" class="help">Title hiển thị trên toolbar của trình duyệt</div>
				</div>
		</td>
	</tr>
	<tr>
		<td valign="top" width="109">
			Meta keyword
		</td>
		<td   valign="top">
			<input type="text" name='value_seo_keyword' value="<?php echo $data -> value_seo_keyword;?>" size="170"  >
		</td>
		<td  width="30">
				<div class="help_area fa fa-exclamation-circle">	
					
					<div style="display: none;" class="help">Giá trị hiển thị trong thẻ Meta keyword, nó chứa các từ khóa để SEO, tối đa 170 ký tự</div>
				</div>
		</td>
	</tr>
	<tr>
		<td valign="top" width="109">
			Meta description
		</td>
		<td   valign="top">
			<input type="text" name='value_seo_description' value="<?php echo $data -> value_seo_description;?>" size="170"  >
		</td>
		<td  width="30">
			<div class="help_area fa fa-exclamation-circle" >	
				
				<div style="display: none;" class="help">Giá trị hiển thị trong thẻ Meta description (thẻ mô tả), tối đa 170 ký tự</div>
			</div>
		</td>
	</tr>
<?php endif;?>
	