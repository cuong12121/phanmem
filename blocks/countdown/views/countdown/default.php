<?php
global $tmpl,$config; 
$tmpl -> addStylesheet('char','blocks/countdown/assets/css');
$tmpl -> addStylesheet('countdown','modules/products/assets/css');

 $tmpl -> addScript('jquery.knob','libraries/jquery/classy-countdown/js');
 $tmpl -> addScript('jquery.throttle','libraries/jquery/classy-countdown/js');
 $tmpl -> addScript('jquery.classycountdown.min','libraries/jquery/classy-countdown/js');
 $tmpl -> addScript('char','blocks/countdown/assets/js');
 
?>
<?php if(isset($list) && !empty($list)){ ?>
    <div class="block_countdown">
	      <?php foreach($list as $item){
		      	if($item -> is_hotdeal){
					if($item -> date_end >  date('Y-m-d H:i:s') && $item->date_start <  date('Y-m-d H:i:s')){
						$price = $item->price;
						$price_old = $item->price_old;
					}else{
						$price = $item->price_old;
						$price_old = '';
					}
				}else{
					$price= $item->price;
					$price_old = $item->price_old;
				}
		  		$Itemid = $item -> is_accessories ? 37: 35;
		  		$link = FSRoute::_('index.php?module=products&view=product&code='.$item -> alias.'&id='.$item -> id.'&ccode='.$item->category_alias);
		  		$link_buy = FSRoute::_("index.php?module=products&view=cart&task=buy&id=".$item->id);
		  		?>
		  				<div class="product_top cls">
	                        <div class="frame_img_cat ">
	                            <a href="<?php echo $link; ?>" title = "<?php echo $item -> name ; ?>" >
	                                <img width="150"  class="img-responsive" src="<?php echo URL_ROOT.str_replace('/original/', '/resized/', $item->image); ?>" alt="<?php echo htmlspecialchars ($item -> name); ?>"  />
	                            </a>
	                        </div>
	                        <div class="frame_view">
	                        	<div class="promotion"><i class="icon_v1"></i></div>
	                            <h2><a href="<?php echo $link; ?>" title = "<?php echo $item -> name ; ?>" class="name" ><?php echo get_word_by_length(60,$item -> name); ?></a> </h2>	
	                            <div class="price_area"> 
	                                	<span class="price"> <?php echo format_money($price); ?></span>
	                                	<?php if($item-> discount ){?>
	                            		<span  class="old_price"> <?php echo format_money($price_old); ?></span>
	                            	<?php }?>
	                            </div>
	                            <div class="warranty">Bảo hành: <?php echo $item->warranty;?></div>
	                   		</div> 
                   		</div> 
                   		<?php if($item -> is_hotdeal){
							if($item -> date_end >  date('Y-m-d H:i:s') && $item->date_start <  date('Y-m-d H:i:s')){
						?>
						<div class="downcoun_area">
			  				<div id='countdown_here'></div>
							<input type="hidden" id='deal_time' value="<?php echo strtotime($item->date_end); ?>">
							<input type="hidden" id='now_time' value="<?php echo strtotime("now"); ?>">
						</div>
							<?php 
							}
						}
						?>
						
                <?php } ?>
	    <div class="clearfix"></div>
    </div>
<?php } ?>
	