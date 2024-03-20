<?php 
global $tmpl;
 // $tmpl -> addStylesheet('default','blocks/address/assets/css');
$cols = 2;
$total = count($list);
$i = 0;
?>
<div class='address_regions'>
	<div class="footer_title">Hệ thống cửa hàng</div>
	<span>Chọn khu vực: </span>
	<select id="regions_footer">
		<option value="0">Toàn quốc</option>
		<?php foreach ($regions as $item) {?>
			<option value="<?php echo $item -> id?>"><?php echo $item -> name; ?></option>
		<?php }//end: foreach ?>
	</select>
	
	<?php foreach ($list as $item) {?>
		<?php $link = FSRoute::_("index.php?module=contact&view=contact&id=".$item->id."&code=".$item->alias);	?>
		<ul class="regions_<?php echo $item -> region_id;?> regionss">
			<li><i class="icon_v1"></i><a href="<?php echo $link; ?>"  title="<?php echo $item -> name; ?>" ><?php echo $item->address?></a></li>
			<!-- <li> <a href="tel:<?php echo $item->phone; ?>" title="<?php echo 'Điện thoại: '. $item->phone; ?>">  <?php echo $item->phone; ?></a></li> -->
		</ul>		
	<?php }//end: foreach ?>
	
</div>