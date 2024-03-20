<?php
global $tmpl; 
$tmpl -> addStylesheet('vertical','blocks/products/assets/css');
FSFactory::include_class('fsstring');
$total = count($list);
$j = 0;
$cols = 5;
?>	
        <?php if(isset($list) && !empty($list)){ ?>
        <div class="block-products block-products-vertical blocks">
        <h2 class="block_title">
			<span><?php echo $title;?></span>
		</h2>
			<div class='container'>
		<?php 	foreach($list as $item){
			  		$Itemid = $item -> is_accessories ? 37: 35;
			  		$link = FSRoute::_('index.php?module=products&view=product&code='.$item -> alias.'&id='.$item -> id.'&ccode='.$item->category_alias.'&Itemid='.$Itemid);
			  		$link_buy = FSRoute::_("index.php?module=products&view=cart&task=buy&id=".$item->id."&Itemid=94");
				
			  		?>
			  		<div class="row row_<?php echo $j%$cols;?>">
                            <div class="frame_img_cat ">
                                <a href="<?php echo $link; ?>" title = "<?php echo $item -> name ; ?>" >
                                    <img class="img-responsive" src="<?php echo URL_ROOT.str_replace('/original/', '/small/', $item->image); ?>" alt="<?php echo htmlspecialchars ($item -> name); ?>"  />
                                </a>
                            </div>
                            <div class="frame_title">
								 <a href="<?php echo $link; ?>" title = "<?php echo $item -> name ; ?>" class="name" ><?php echo get_word_by_length(40,$item -> name); ?>
								 	<?php if($item -> is_tested && $item->tested_content){?>
                    						<img src="<?php echo URL_ROOT.'blocks/products/assets/images/tested.png'?>" alt="Tested" />
                    				<?php }?>
                    			</a>	
                    		</div>
                    		<div class='clear'></div>
			      </div>
			      	<?php $j ++;?> 	
                <?php } ?>
                </div>
		    <div class="clear"></div>
		</div>
                
    	<?php } ?>
	