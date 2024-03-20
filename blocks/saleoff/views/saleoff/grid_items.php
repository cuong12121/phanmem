<div class="row product_grid">
<div class="row_inner">
		<!--	EACH PRODUCT				-->
		<?php 
		$products = $array_products[$cat->id];
		for($j = 0 ; $j < count($products); $j ++)
		{
			$item = $products[$j];
			$link_buy = FSRoute::_("index.php?module=products&view=cart&task=buy&id=".$item->id."&Itemid=94");
			$Itemid = 35;
  			$link = FSRoute::_('index.php?module=products&view=product&code='.$item -> alias.'&ccode='.$item->category_alias.'&id='.$item->id.'&cid='.$item->category_id.'&Itemid='.$Itemid);
		?>
                    <div  class="item" itemscope itemtype="http://schema.org/Product">					
                            <div class="frame_inner">
                            	<link itemprop="url" href="<?php echo $link; ?>" />
					        	<figure class="product_image "  >
					        		<?php $image_small = str_replace('/original/', '/resized/', $item->image); ?>
					  				<a href="<?php echo $link;?>" title='<?php echo $item->name;?>'  itemprop="url">
										<img itemprop="image" alt="<?php echo $item->name;?>" src="<?php echo URL_ROOT.$image_small;?>"  onerror="javascript:this.src='<?php echo URL_ROOT.'images/NA240x240.png';?>'"/>
									</a>
									<div class="button_area">
					            		<a href="javascript:void(0)" onclick="add_cart(<?php echo $item -> id; ?>,1)" class="add_cart">
					            			<i ></i>
					            		</a>
					            		<a href="<?php echo $link; ?>"  class="detail_button">
					            			<i ></i>
					            		</a>
					            	</div>
								<!--<div class="summary">
								
									<div class="summary_inner"  itemprop="description">
					            		<?php $summary = trim($item->summary);?>
					            		<?php $summary = str_replace(array("<br>","<br/>","<br />"),'</p><p>', $summary); ?>
					            		<?php $summary = str_replace(array("<p>&nbsp;</p>\n","<p></p>","<p>&nbsp;</p>", "&nbsp;<br />\n"), array('', ''), $summary); ?>
					            		<?php echo $summary; ?>
				            		</div>
		            			</div>
		            		-->
			        	</figure>
			        	 <?php if(@$item -> is_new){ ?>
        						<div class="new_icon"></div>
        					<?php }?>
        					<?php if(@$item -> is_hot){ ?>
        						<div class="hot_icon"></div>
        					<?php }?>
        					<?php if(@$item -> is_sale){ ?>
        						<div class="sale_icon"></div>
        					<?php }?>
						<h2 itemprop="name"><a href="<?php echo $link; ?>" title = "<?php echo $item -> name ; ?>" class="name" >
			  				<?php echo FSString::getWord(15,$item -> name); ?>
			        	</a> </h2>	
			        	<div class='price_arae' itemscope itemtype="http://schema.org/Offer">
					  		<div class='price_current' itemprop="price"><?php echo format_money($item -> price).''?></div>
				        
			            	<?php if( $item -> price_old && $item -> price_old > $item -> price){?>
			            		<div class='price_old'><span><?php echo format_money($item -> price_old).''?></span></div>
			            	<?php }?>
		            	</div>
		            	<?php if( $item -> price_old && $item -> price_old > $item -> price){?>
			            		<div class='discount'><span><?php echo '-'.round((($item -> price_old - $item -> price) /$item -> price_old) * 100).'%'; ?></span></div>
		            	<?php }?>
						<a class="button-detail" href="<?php echo $link;?>"><span >+</span></a>
						<div class="clear"></div> 
						  <?php if(count($types)){?>
		
			<!--<?php foreach($types as $type){?>

				<?php if(strpos($item -> types,','.$type->id.',') !== false || $item -> types == $type->id){?>

					<div class='product_type product_type_<?php echo $type -> alias; ?>'><img src="<?php echo URL_ROOT.$type->image; ?>" alt="<?php echo $type -> name; ?>" /></div>

					<?php break;?>		

				<?php }?>

			<?php }?>
	--><?php }?>  									
                            </div>   <!-- end .frame_inner -->
	                            
                            			
			<div class="clear"></div> 
        </div> 	 
               
		<?php 
		}
		?>		
		<!--	end EACH PRODUCT				-->
                   <div class="clear"></div> 
				</div>
			</div>