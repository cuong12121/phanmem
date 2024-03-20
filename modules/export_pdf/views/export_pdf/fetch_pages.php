
<?php FSFactory::include_class('fsstring'); ?>
<div class="products_item_content">
	<?php $i=0;foreach ($list as $item) {
		if($cat_id>0){
			$link_cat = FSRoute::_('index.php?module=products&view=cat&cid='.@$cat_id.'&ccode='.@$item -> category_alias);
			// $link_cat = URL_ROOT.$item -> category_alias.'-dc'.$cat_id.'/sap-xep-ban-chay-nhat.html';
			
		}
		else {
			$link_cat = FSRoute::_('index.php?module=products&view=home');	
		}

		
		$link = FSRoute::_('index.php?module=products&view=product&code='.@$item -> alias.'&id='.@$item -> id.'&ccode='.@$item->category_alias);
	
		?>
		<?php include 'default_item.php';?>     
		<?php $i++;?>
	<?php }?>
</div>
<div class="clear"></div>
<div class="xemthemhome">
	<a href="<?php echo $link_cat; ?>"><span>Xem thêm <?php echo $cat_name->name ?></span></a>
</div>	
