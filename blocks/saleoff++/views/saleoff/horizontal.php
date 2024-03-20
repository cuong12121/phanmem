<?php
global $tmpl; 
$tmpl -> addStylesheet('products'); 
$tmpl -> addStylesheet('horizontal','blocks/products/assets/css');

FSFactory::include_class('fsstring');
$total = count($list);
$j = 0;
$cols = 5;
?>	
 <?php if(isset($list) && !empty($list)){ ?>
	<ul class="product_grid clearfix">
<?php 	foreach($list as $item){
  		$Itemid = $item -> is_accessories ? 37: 35;
  		$link = FSRoute::_('index.php?module=products&view=product&code='.$item -> alias.'&id='.$item -> id.'&ccode='.$item->category_alias.'&Itemid='.$Itemid);
  		$link_buy = FSRoute::_("index.php?module=products&view=cart&task=buy&id=".$item->id."&Itemid=94");
	    $starNumber = $item -> rating_count ? round($item -> rating_sum /$item -> rating_count): 0 ; 
     	$starNumber = 0; 
  		?>
  		<li>
  			<a href="<?php echo $link; ?>" title = "<?php echo $item -> name ; ?>" >
            	
            	<figure>
            		<picture>
            			<img class="img-responsive" src="<?php echo URL_ROOT.str_replace('/original/', '/resized/', $item->image); ?>" alt="<?php echo htmlspecialchars ($item -> name); ?>"  />
            		</picture>
            		<div class="sbtn cpr" ><span><i class="fa fa-shopping-cart" aria-hidden="true"></i>Add to cart</span></div>
            	</figure>
		    	<h2><?php echo get_word_by_length(30,$item -> name); ?></h2>
	    	    <div class="rev" itemprop="aggregateRating" itemscope="" itemtype="http://schema.org/AggregateRating">
		            <meta itemprop="ratingValue" content="<?php echo $starNumber; ?>">
		            <meta itemprop="reviewCount" content="<?php echo  $item -> rating_count; ?>">
		            <meta itemprop="bestRating" content="5">
		            <meta itemprop="worstRating" content="1">
		             <div class="stars">
	                <?php 
	                      
	                      for($x=1;$x<=$starNumber;$x++) {
	                          echo '<i class="fa fa-star"></i>';
	                      }
	                      while ($x<=5) {
	                          echo '<i class="fa fa-star-o"></i>';
	                          $x++;
	                      }

	                    ?>
	              </div>
		        </div>
	    	  	<div class="br ">
		          <dl itemprop="offers" itemscope="" itemtype="http://schema.org/Offer">
		           	<?php echo ($item -> price_old)?' <dd class="col">'.format_money($item -> price_old,'đ').'</dd>':''; ?>
		            <dt class="col">
		              <meta itemprop="priceCurrency" content="VND">
		              <meta itemprop="price" content="<?php echo $item -> price; ?>">
		              <link itemprop="availability" href="http://schema.org/InStock">
		              <span class="prv"><?php echo format_money($item -> price,'đ'); ?></span>
		            </dt>
		          </dl>
		        </div> 
		        <!-- <div class="pc saving">-16%</div> -->
		         <?php 
		        if(count($types)){
		           foreach($types as $type){
		             if(strpos($item -> types,','.$type->id.',') !== false || $item -> types == $type->id){
		               echo  '<div class="theme" style="background:#'.$type -> code.'"><span>'.$type -> name.'</span></div>';
		             break;  
		              }
		           }
		         } 
        		 ?> 
	        </a>
      	</li>
      	<?php $j ++;?> 	
    <?php } ?>

</ul>
<a href="<?php echo FSRoute::_('index.php?module=products&view=home') ?>" class="btn"><?php echo FSText::_('More Products');?></a>
        
<?php } ?>
