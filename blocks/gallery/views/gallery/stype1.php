<?php
global $tmpl,$is_mobile,$config; 

$tmpl -> addScript('carousel','blocks/gallery/assets/js');
$tmpl -> addStylesheet('stype1','blocks/gallery/assets/css');
$tmpl -> addScript('stype1','blocks/gallery/assets/js');
$page =2;
FSFactory::include_class('fsstring');
?>



<div class="wrap">  
  <div class="slider slider_11">
  		
 		<?php  $j=0; foreach($list as $item){
 			$link = FSRoute::_("index.php?module=images&view=images&id=".$item->id."&code=".$item->alias."&ccode=".$item-> category_alias);
 			?>
 			
 		<div class="item" id="id_item_<?php echo $j; ?>">
 			
 			
			
			         <div class="image ">
			         	
			         	<div class="info-left">
			         		<a href="<?php echo $link; ?>" title="<?php echo $item -> name; ?>">			         	
				         	<?php if($item -> image){?>
				         		<?php if(!$is_mobile){ ?>
								 <img data-src="<?php echo URL_ROOT.str_replace('/original/','/large/', $item->image); ?>" alt='<?php echo $item -> name; ?>' class="lazy"/>
								<?php } else{ ?>
									<img data-src="<?php echo URL_ROOT.str_replace('/original/','/resized/', $item->image); ?>" alt='<?php echo $item -> name; ?>' class="lazy"/>
								<?php } ?>
							<?php }else{?>
								<img data-src="<?php echo URL_ROOT.'images/avatar.jpg'?>" alt='<?php echo $item -> name; ?>' class="lazy"/>
							<?php }?>
						</a>
			         	</div>
			        
			    		
			         </div>
			<div class="link_detail">
			<a href="<?php echo $link; ?>" title="Xem album">
				<?php echo $config['icon_link']; ?>
			</a>
			</div>                      	
			                 
 		</div> <!-- .item -->
 			
              <?php $j++;?>
			
        <?php }?>
        
    </div>	
   </div> 				

