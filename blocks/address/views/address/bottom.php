<?php 
 	global $tmpl;
 	//$tmpl -> addStylesheet('bottommenu','blocks/mainmenu/assets/css');
?>
<div class="address_bottom cls">
	<label class="title_bottom">Hệ thống cửa hàng</label>
	<div class="box_add_full" >
		<?php foreach ($list as $item) {
			//echo '<pre>';
			//print_r($item);

			?>
			<div class="item">
				<div class="name"><?php echo $item-> name;?>: <strong><?php echo $item-> address;?></strong></div>
				<div class="phone">Hotline: <strong><a href="tel:<?php echo $item-> phone;?>" title = "Gọi <?php echo $item-> phone;?>"><?php echo $item-> phone;?></a></strong></div>
			</div>
				
		<?php }?>
	</div>
</div>