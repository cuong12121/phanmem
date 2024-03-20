<?php 
global $tmpl;
$tmpl -> addScript('jquery.ezpz_tooltip','libraries/jquery/tip/EZPZ');
$tmpl -> addScript('home','modules/products/assets/js');
$tmpl -> addStylesheet('ezpz_tooltip','libraries/jquery/tip/EZPZ');
$tmpl -> addStylesheet("home","modules/products/assets/css");
$tmpl -> addStylesheet("product","modules/products/assets/css");

$Itemid = 30;
$Itemid_detail = 31;
$cols = 5;
FSFactory::include_class('fsstring');
?>
<div class='breadcrumb'>
	<?php echo $tmpl -> load_direct_blocks('breadcrumbs',array('style'=>'default','data'=>$array_breadcrumb)); ?>
</div>

<div class="title-product-hot">
	<div class="left"></div>
	<div class="center">
		<div class="img-title-cate"><img width="29px" height="29px" src="<?php echo URL_ROOT.'images/products/categories/icons/resized/'.'store-icon.jpg';?>" alt="Store" />ione Store</div>
	</div>
	<div class="right"></div> 
	<div class="clear"></div>   
</div>
<div class="wapper-content-page">
	<?php 
	for($i = 0 ; $i < count( $array_cats) ; $i ++)
	{
		$cat = $array_cats[$i];
		if(!count($array_products[$cat->id])){
			continue;
		}
		$Itemid_cat = $cat -> is_accessories ? 36:34;
		$link_cat = FSRoute::_("index.php?module=products&view=categories&ccode=".$cat -> alias."&Itemid=".$Itemid_cat);
		?>
		
		<div class="cat_item_store">
			<div class='cat-title'>
				<?php  if(file_exists(PATH_IMG_PRORUCT.'categories'.DS.'icons'.DS.'resized'.DS.$cat->icon) && $cat->icon) {?>
					<img alt="<?php echo $cat->name?>" src="<?php echo URL_IMG_PRORUCT.'categories/icons/resized/'.$cat->icon; ?>" />
				<?php  }?>
				<h2><?php echo $cat->name;?></h2>
				<a class="cat_readmore" href="<?php echo $link_cat; ?>"></a>
				<div class="clear"></div>
			</div>
			<div class="row">
				<!--	EACH PRODUCT				-->
				<?php 
				$products = $array_products[$cat->id];

				for($j = 0 ; $j < count($products); $j ++)
				{
					$item = $products[$j];
					$link_buy = FSRoute::_("index.php?module=products&view=cart&task=buy&id=".$item->id."&Itemid=94");
					$Itemid = $item -> is_accessories ? 37: 35;
					$link = FSRoute::_('index.php?module=products&view=product&code='.$item -> alias.'&id='.$item -> id.'&ccode='.$item->category_alias.'&Itemid='.$Itemid);
					?>
					<div class="<?php echo 'col_'.($j%$cols).' cat_item frame'; ?> ">
						<div class="frame_inner">
							<div class="product_image ">
								<a href="<?php echo $link; ?>" title = "<?php echo $item -> name ; ?>" >
									<img width="130" height="130" src="<?php echo URL_ROOT.'images/products/resized/'.$item->image; ?>" alt="<?php echo htmlspecialchars ($item -> name); ?>"  />
								</a>
							</div>
							<?php if(@$item -> is_new){ ?>
								<div class="new_icon"></div>
							<?php }?>
							<?php if(@$item -> is_hot){ ?>
								<div class="hot_icon"></div>
							<?php }?>
							<?php if(@$item -> is_sale){ ?>
								<div class="sale_icon"></div>
							<?php }?>
							<h2>
								<a href="<?php echo $link; ?>" title = "<?php echo $item -> name ; ?>" class="name" >
									<?php echo FSString::getWord(5,$item -> name); ?>
								</a>
							</h2>	
							<?php if(!@$item -> price_old){ ?>
								<p class="price"> <?php echo format_money($item -> price).''; ?> </p>
							<?php } else { ?>
								<p class="old_price"> <span> <?php echo format_money($item -> price_old). ''; ?></span></p>
								<p class="price"> <span><?php echo format_money($item -> price). ''; ?></span></p>
							<?php }?>

							<a href="<?php echo $link_buy;?>"><span class="button-cart"></span></a>
							<a href="<?php echo $link;?>"><span class="button-detail"></span></a>
							<div class="clear"></div> 
						</div>   <!-- end .frame_inner -->
						<?php if($item -> promotion_info ):?>
							<div id="tool-tip-prd-<?php echo $item -> id; ?>" class="tooltip-content">
								<div class="tool-top-title"><?php echo $item -> name; ?></div>
								<div class="tool-top-content">
									<div class="promotion_info"><strong class="promotion_label">Khuyến mãi: </strong><?php echo $item -> promotion_info; ?></div>
								</div>
							</div>
						<?php endif;?>				
						<div class="clear"></div> 
					</div> 	
					<?php 
				}
				?>		
				<!--	end EACH PRODUCT				-->		
			</div>
			<div class="clear"></div>
		</div>
		<?php 	
	} 
	?>
	<div class='clear'></div>
</div><div class="wapper-content-page-bottom">&nbsp;</div>