<?php if(!empty($list_related)){ ?>
<?php $tmpl -> addStylesheet('related','modules/'.$this -> module.'/assets/css');?>
<?php
$total_relate = count($list_related);
$class = '';
$tmpl -> addStylesheet('related_mb','modules/'.$this -> module.'/assets/css');
?>
<?php if($relate_products_list && count($relate_products_list)){?>
		<div class='product_related_title'>Có thể bạn sẽ thích</div>
		


        <div class='product_related_mb clearfix' >
	<?php foreach($relate_products_list as $item){
		$price =  calculator_price($item->price,$item->price_old,$item -> is_hotdeal,$item->date_start,$item->date_end,$item->manufactory_discount,$item->price_km,$item->discount_km);
                $link = FSRoute::_('index.php?module='.$this -> module.'&view=product&code='.$item->alias.'&ccode='.$item->category_alias);
		$link_buy = FSRoute::_('index.php?module=products&view=cart&task=buy&id='.$item -> id);
        ?>
				
        <div class="item <?php echo $class;?>">
        	<div class="inner_item">
	         	<div class="frame_img_cat ">
	             	<a href="<?php echo $link; ?>" title = "<?php echo $item -> name ; ?>" >
	             		<img class="" src="<?php echo URL_ROOT.str_replace('/original/', '/resized/', $item->image); ?>" alt="<?php echo htmlspecialchars ($item -> name); ?>"  />
	                </a>
	            </div>
		        <div class="frame_title">
					<h2 class="name" >
						<a href="<?php echo $link; ?>" title = "<?php echo $item -> name ; ?>" >
							<?php echo $item->name; ?>
						</a> 
					</h2>	
		        </div>
				<div class="frame_price">
            		<div class="clearfix">
                		 <div class="discount pull-right"> 
                            <span class="percent "> 
                                                
                                
                                    <?php //echo $item->discount_unit.'ss';
                                                if($item->gift){
                                                ?>
                                                <span class="percent icon-gift "><img src="<?php echo URL_ROOT."images/gift.png"; ?>" />
	                            		</span>
                                                <?php }
										 
										
							
										echo 'Giá <span class="percent_val "> <span>'.format_money($price['price_old']).'</span></span>';                                  
										
										
									?>
                                	                            		
                            </span>
                        </div>
                		<div class="price pull-left"> 
                			<?php if($price['percent']){ ?>
                            Giá KM	<span><?php echo format_money($price['price']); ?></span>
                            <?php } ?>
                        </div>
                    </div>    
           		</div>
           		     		
		 	</div>    	
         </div>
			<?php } ?>
</div><!--end: .vertical-->                    
	    </div>
<?php } ?>
<?php } ?>