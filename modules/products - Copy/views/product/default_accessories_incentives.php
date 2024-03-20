<h3>Phụ kiện ưu đãi <span>(chỉ áp dụng đối với khách hàng mua kèm sản phẩm)</span></h3>
<?php $total_money_incentives = $price;?>
<?php $total_money_incentives_old = $price;?>
<?php if(count($products_incentives)){?>
<?php  // print_r($products_incentives);?>
<div class='product_inventives_item'>
	<input type="hidden" id="product_price" name="product_price" value="<?php echo $price;?>">
	<div class="top"></div>
	<div class="center">
	<?php foreach($products_incentives as $item){?>
		<?php $product_item = @$array_products_incentives[$item -> product_incenty_id]; ?>
		<?php if($product_item){?>
			<?php $total_money_incentives += ($item -> price_new); ?>
			<?php $total_money_incentives_old += ($product_item -> price); ?>
			<?php $link  = FSRoute::_('index.php?module=products&view=product&code='.$product_item -> alias.'&id='.$product_item -> id.'&ccode='.$product_item -> category_alias.'&Itemid=37');?>
			
                        <div class="check"><input type="checkbox" checked="checked" name='product_incentives[]' value='<?php echo $item -> product_incenty_id; ?>' class='product_incentives' rel1="<?php echo $product_item -> price?>" rel = "<?php echo $item -> price_new; ?>" /></div>
                        <div class="left-product_inventives">
                        <?php if($product_item -> image){ ?>
                            <img src="<?php echo URL_ROOT.'images/products/small/'.$product_item->image; ?>" alt="<?php echo htmlspecialchars ($product_item -> name); ?>"  width="70" height="70" />
                        <?php } else {?>
                            <img src="<?php echo URL_ROOT.'images/no-img.gif'; ?>" alt="<?php echo htmlspecialchars ($product_item -> name); ?>"  />
                        <?php }?>
                        </div>
                        <div class="right-product_inventives">
                            <h4><a href="<?php echo $link; ?>"  title="<?php echo htmlspecialchars ($product_item -> name); ?>"> <?php echo $product_item -> name; ?></a></h4>
                            <div class='status'>
                                <?php echo $product_item -> quantity ? 'còn hàng':'hết hàng'; ?>
                            </div>
                            <div class='price'>
                                <span class='price_old'><?php echo format_money($product_item -> price); ?></span>&nbsp;
                                <span class='price_new'><?php echo format_money($item -> price_new); ?></span>
                            </div>
                            <a href="<?php echo $link; ?>"  title="<?php echo htmlspecialchars ($product_item -> name); ?>"><span class="button-detail"></span></a>
                        </div>
                        <div class="clear"></div>
                
		<?php }?>
	<?php }?>
	</div>
	<?php if($total_money_incentives){?>
		<div class='total_money_incentives' ><span class='label'>Tổng: </span><strong id="total_money_incentives"><?php echo format_money($total_money_incentives);?></strong><span class='total_money_incentives_old'><?php echo format_money($total_money_incentives_old);?></span></div>
	<?php }?>
	<div class="bottom"></div>
	<div class="clear"></div>
</div>	
<?php } else {?>
	Không có phụ kiện khuyến mãi nào đối với sản phẩm này
<?php }?>