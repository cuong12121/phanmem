<?php
global $tmpl; 
$tmpl -> addStylesheet('owl.carousel','libraries/jquery/owl.carousel.2/assets');
$tmpl -> addScript('owl.carousel.min','libraries/jquery/owl.carousel.2');
$tmpl -> addScript('slideshow_highlights','blocks/products/assets/js');
$tmpl -> addStylesheet('slideshow_highlights','blocks/products/assets/css');
FSFactory::include_class('fsstring');
?>
<?php if(isset($list) && !empty($list)){?>
	<div class="products_blocks_wrapper  block slideshow-highlights">
		<h3 class="slideshow-highlights-title">Sản phẩm <span>nổi bật nhất</span></h3>
        <div class="clear"></div>
		<div class="slideshow_highlights products_blocks_slideshow_hot"  id="<?php echo "products_blocks_slideshow_hot_".$identity; ?>">
					<?php foreach($list as $item){

					?>

					<?php
	$link_buy = FSRoute::_("index.php?module=products&view=cart&task=buy&id=".$item->id."&Itemid=94");
// $link_buy = "";	
// $link = "";
		$link = FSRoute::_('index.php?module=products&view=product&code='.$item -> alias.'&ccode='.$item->category_alias.'&id='.$item->id.'&cid='.$item->category_id);
?>
<div  class="item item_special">					


	<div class="cls item_special_t">
    <div class="frame_inner item_special_l ">
	    <figure class="product_image ">
	        <?php $image_small = str_replace('/original/', '/large/', $item->image); ?>
			<a href="<?php echo $link;?>" title='<?php echo $item->name;?>'>
				<img alt="<?php echo $item->name;?>" src="<?php echo URL_ROOT.$image_small;?>"  onerror="javascript:this.src='<?php echo URL_ROOT.'images/NA240x240.png';?>'" class=""/>

				<img alt="<?php echo $item->name;?>" src="<?php echo URL_ROOT.$image_small;?>"  onerror="javascript:this.src='<?php echo URL_ROOT.'images/NA240x240.png';?>'" class=" shadow"/>
			</a>
    	</figure>

						
    </div>   <!-- end .frame_inner -->


    <div class="item_special_r">                
		<div class="main_info">
			<h2><a href="<?php echo $link; ?>" title = "<?php echo $item -> name ; ?>" class="name" >
  				<div class="name_core"><?php echo FSString::getWord(15,$item -> name_core); ?></div>
  				<div class="name_display"><?php echo FSString::getWord(15,$item -> name_display); ?></div>
        	</a> </h2>

        	<div class='price_arae'>
        		<div class="price-txt"><a class="cl_white" href="<?php echo $link; ?>">Giá chỉ</a></div>
		  		<div class='price_current'><span class="bf"></span><?php echo format_money($item -> price).''?><span class="af"></span></div>
            	<?php if( $item -> price_old && $item -> price_old > $item -> price){?>
            		<div class='price_old'><span><?php echo format_money($item -> price_old).''?></span></div>
            	<?php }?>
        	</div>

		
			<div class="clear"></div> 
    	</div> 
	          
	</div>

	</div>
	

	<div class="clear"></div>


	<div class="item_special_bt">
		<div class="main_info">
			<h2><a href="<?php echo $link; ?>" title = "<?php echo $item -> name ; ?>" class="name" >
  				<?php echo FSString::getWord(15,$item -> name); ?>
        	</a> </h2>	
        	<div class='price_arae'>
		  		<div class='price_current'><?php echo format_money($item -> price).''?></div>
	        
            	<?php if( $item -> price_old && $item -> price_old > $item -> price){?>
            		<div class='price_old'><span><?php echo format_money($item -> price_old).''?></span></div>
            	<?php }?>

		    	<?php if(@$item -> is_new){ ?>
						<div class="new_icon"></div>
					<?php }?>
					<?php if(@$item -> is_hot){ ?>
						<div class="hot_icon"></div>
					<?php }?>
					<?php if(@$item -> is_sale){ ?>
						<div class="sale_icon"></div>
				<?php }?>
				<?php if($item -> style_types){ ?>
					<?php $arr_style_type = explode(',', $item -> style_types); ?>

						<?php foreach( $arr_style_type as $st){ ?>
							<?php if($st){ ?>
								<div class= '<?php echo $st; ?> style_types'><?php echo $style_types_rule[$st]; ?></div>
							<?php } ?>
						<?php } ?>
					
				<?php } ?>

        	</div>
        	<div class="gift">
        		<?php echo $item-> gift ?>
        	</div>
		
			<div class="clear"></div> 
    	</div> 
	</div> 
		

                    			
	
</div>

				


			        	












					<?php }?>
					
			</div>
	</div>		
 <?php }?>
