    <?php if(count($list)){?>
	<?php foreach($list as $item){?>
  		<?php $link_buy = FSRoute::_("index.php?module=products&view=cart&task=buy&id=".$item->id."&Itemid=94"); ?>
        <?php $link = FSRoute::_('index.php?module='.$this -> module.'&view=product&code='.$item->alias.'&ccode='.$item->category_alias.'&id='.$item->id.'&Itemid=5'); ?>
        <div class="item">
       	 <div class="inner_item">							
            <?php if($item->image){?>
				<?php $image_small = str_replace('/original/', '/resized/', $item->image); ?>
				<a href="<?php echo $link;?>" title='<?php echo $item->name;?>'>
					<img alt="<?php echo $item->name;?>" src="<?php echo URL_ROOT.$image_small;?>" />
				</a>
			<?php }?>
            
              <div class="price_area">
                <div class='price'><?php echo format_money(@$item -> price).''?></div>
            	<?php if($item -> price_old){?>
            		<div class='price_old'><?php echo format_money($item -> price_old).''?></div>
            	<?php }?>
            	<div class='clear'></div>
            </div>
            <h3 class="name"><a  href="<?php echo $link;?>" title='<?php echo $item->name;?>'><?php echo $item->name;?></a></h3>
            <div class='info_other'>
            	<?php if($item->size_name){?>
            		<span class='size'><?php echo $item -> size_name; ?></span>	
            	<?php }?>
            	<span class='like'><?php echo $item -> like; ?></span>
            	<span class='comments_no'><?php echo $item -> comments_published; ?></span>
             </div>
            <div class='info_owner'>
            	<a class='full_name' href="<?php echo FSRoute::_('index.php?module=members&view=member&task=edit&id='.$item -> user_id.'&username='.$item -> username); ?>">
            		<?php if($item -> user_image){?>
            		<img alt="Thông tin người đăng" src="<?php echo URL_ROOT.$item -> user_image; ?>" width="27" height="27"/>	
	            	<?php }else{?>
	            		<img alt="Thông tin người đăng" src="<?php echo URL_ROOT.'images/no-avatar.jpg'; ?>" width="27" height="27"/>
	            	<?php }?>
            		<font><?php echo $item -> user_full_name; ?></font>
            	</a>
            	<?php if($item -> user_city){?>
            		<span class='user_city'><?php echo $item -> user_city; ?></span>
            	<?php }?>
            	<div class="clear"></div>
             </div>
<!--            <div class='detail_button'>-->
<!--				<div class="buy-now">-->
<!--					<a href="<?php echo $link_buy; ?>"><span class="button-cart">Mua sản phẩm</span></a>-->
<!--				</div>-->
<!--			</div>-->
			<!--  end: .detail_button -->
					<?php if(count($types)){?>
						<?php foreach($types as $type){?>						
							<?php if($type->id == $item -> types){?>
								<div class='product_type product_type_<?php echo $type -> alias; ?>'><img src="<?php echo URL_ROOT.$image_small = str_replace('/original/', '/resized/', $type->image); ?>" alt="<?php //echo $type -> name; ?>" /></div>
								<?php break;?>		
							<?php }?>
						<?php }?>
			<?php }?>
	    </div>
        </div><!--end: .item-->
        
	<?php }//end: foreach($list as $item) ?>
    <?php }?>

