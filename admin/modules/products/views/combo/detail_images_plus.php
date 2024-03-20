<div class="product_images">
	<div class='images_exist'>
		<table border="1" class="tbl_form_contents" width="100%" cellspacing="4" cellpadding="4" bordercolor="#CCC">
			<thead>
				<tr>
					<th align="center" >
						Ảnh
					</th>
					<th align="center" >
						Mô tả
					</th>
					<th align="center" >
						Remove
					</th>
				</tr>
			</thead>
			<tbody>
			<?php
				$i = 0; 
				if(isset($images_plus))
				foreach ($images_plus as $item) { 
			?>
				<tr>
					<td>
						<?php $link_img = str_replace('/original','/small/', $item->image);?>
						<img alt="" src="<?php echo URL_ROOT.$link_img; ?>" />
						<input type="file" name="image_plus_exit_<?php echo $item->id; ?>"  />
						<input type="hidden" name="name_image_plus_exist_<?php echo $item->id;?>"  value="<?php echo @$item->image;?>">
					</td>
					<td>
						<textarea rows="3" cols="60" name="content_plus_exit_<?php echo $item->id;?>" id="content_plus_exit_<?php echo $item->id;?>"><?php echo @$item->content;?></textarea>
					</td>
					<td>
						<input type="checkbox" onclick="remove_image(this.checked);" value="<?php echo $item->id; ?>"  name="other_image_plus[]" id="other_image_<?php echo $i; ?>" />
						<input type="hidden" value="<?php echo $item->id; ?>" name="image_plus_exist_total[]"  />
					</td>
				</tr>
			
					<?php
						$i++; 
				}
				?>
			</tbody>		
		</table>
	</div>
	<div class='upload' style="clear: both;">
		<table>
			<?php for($i = 0; $i < 5; $i ++ ) { ?>
				<tr>
					<td>
					 	<label> <?php echo FSText::_('Image'); ?> <?php echo $i+1; ?></label>
					 	<input type="file" name="new_image_plus_<?php echo $i; ?>"  />
					</td>
					<td>
					 	<textarea rows="3" cols="60" name="new_content_plus_<?php echo $i;?>" id="new_content_plus_<?php echo $i;?>"></textarea>
					</td>
				</tr>
		<?php } ?>
		</table>
	
	</div>
</div>
<script type="text/javascript" >
function remove_image(isitchecked){
	if (isitchecked == true){
		document.adminForm.otherimage_remove.value++;
	}
	else {
		document.adminForm.otherimage_remove.value--;
	}
}

</script>