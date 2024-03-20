<?php
$cols = 3;
?>
<div class='vertical'>
    <?php $tmp = 0; ?>
    <?php if(count($list)){?>
	<?php foreach($list as $item){?>
        <?php $tmp++; ?>
  		<?php $link_buy = FSRoute::_("index.php?module=products&view=cart&task=buy&id=".$item->id."&Itemid=94"); ?>
        <?php $link = FSRoute::_('index.php?module='.$this -> module.'&view=product&code='.$item->alias.'&ccode='.$item->category_alias.'&cid='.$item->id.'&Itemid=5'); ?>
        <div class="item <?php echo ($tmp)% $cols ? 'item-r':'item-l';?> ">
       	 <div class="inner_item">							
            <?php if($item->image){?>
				<?php $image_small = str_replace('/original/', '/resized/', $item->image); ?>
				<a href="<?php echo $link;?>" title='<?php echo $item->name;?>'>
					<img alt="<?php echo $item->name;?>" src="<?php echo URL_ROOT.$image_small;?>" />
				</a>
			<?php }?>
            <h3 class="name"><a  href="<?php echo $link;?>" title='<?php echo $item->name;?>'><?php echo $item->name;?></a></h3>
              <div class="price_area">
            	<?php if(@$item -> discount && @$item -> price_old){?>
            		<div class='discount'>
            			<?php echo '-<span>'.round((($item -> price_old - $item -> price)/$item -> price_old)*100).'</span><font>%</font>'?>
            		</div>
            		<div class='price_old'><?php echo format_money($item -> price_old).''?></div>
            	<?php }?>
            	<div class='price'><?php echo format_money(@$item -> price).''?></div>
            </div>
            <div class='detail_button'>
				<div class="buy-now">
					<a href="<?php echo $link_buy; ?>"><span class="button-cart">Mua sản phẩm</span></a>
				</div>
			</div><!--  end: .detail_button -->
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
        
        <?php if( $tmp%$cols == 0){ ?>
            <div class="clear"></div>
        <?php }else{ ?>
            <div class="slash"></div>
        <?php }//end: if( $tmp%$cols == 0) ?>
        
	<?php }//end: foreach($list as $item) ?>
    <?php }?>
    <div class="clear"></div>
</div><!--end: .vertical-->

