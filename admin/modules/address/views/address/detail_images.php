<div class="product_images">
	<div class='images_exist'>
		<table border="1" class="tbl_form_contents" width="100%" cellspacing="4" cellpadding="4">
			<thead>
				<tr>
					<th align="center" >
						Ảnh
					</th>
					<th align="center" >
						Remove
					</th>
				</tr>
			</thead>
			<tbody>
			<?php
				$i = 0; 
				if(isset($images))
				foreach ($images as $item) { 
					if($item -> image) {
			?>
				<tr>
					<td>
						<img alt="<?php echo $item->image?>" src="<?php echo URL_IMG_ADDRESS.'resized'.'/'.$item->image; ?>" />
					</td>
					<td>
						<input type="checkbox" onclick="remove_image(this.checked);" value="<?php echo $item->id; ?>"  name="other_image[]" id="other_image<?php echo $i; ?>" />
					</td>
				</tr>
			
					<?php
						$i++; 
					}
				}
				?>
			</tbody>		
		</table>
	</div>
	<div class='upload' style="clear: both;">
		<table>
			<?php for($i = 0; $i < 5; $i ++ ) { ?>
				<tr>
					 <td><label> <?php echo FSText::_('Image'); ?> <?php echo $i+1; ?></label></td>
					 <td><input type="file" name="other_image_<?php echo $i; ?>"  /></td>
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