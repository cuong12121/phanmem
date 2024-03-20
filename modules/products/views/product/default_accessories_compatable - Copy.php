<?php $i=0;
$arr_compatable = explode (',', $data->products_compatable );
if(!empty($array_products_compatable)) {
	$total_compatable = count($array_products_compatable);	
}
else $total_compatable = 0;

if($arr_compatable && $array_products_compatable){
	?>
	<div class="accessories_incentives">
		<div class="tab-title">
			<span>Phụ kiện đi kèm</span>
		</div>
		<div class="advantage_content">
			
			<ul class="clearfix">
				<?php 
				// echo "<pre>";
				// 	print_r($array_products_compatable);

				for($i = 0; $i < $total_compatable; $i ++) {
					$item = trim ( $arr_compatable [$i] );
					$product_item = @$array_products_compatable[$item]; 
					
					if(!$product_item)
						continue;
					$link = FSRoute::_('index.php?module=products&view=product&code='.$product_item -> alias.'&id='.$product_item -> id.'&ccode='.$product_item -> category_alias);
					$price_compatable = calculator_price($product_item->price,$product_item->price_old,$product_item->h_price,$product_item -> is_hotdeal,$product_item->date_start,$product_item->date_end);
					?>	
					
					<li class="item cls">
						<a rel="nofollow" href="<?php echo $link; ?>" title = "<?php echo $product_item -> name ; ?>" >
							<img class="img-responsive lazy" data-src="<?php echo URL_ROOT.str_replace('/original/', '/small/', $product_item->image); ?>" alt="<?php echo htmlspecialchars ($product_item -> name); ?>"  />
						</a>
						<div class="name"><a rel="nofollow" href="<?php echo $link; ?>" title = "<?php echo $product_item -> name ; ?>" ><?php echo get_word_by_length(80,$product_item -> name); ?></a></div>
						<span class="price"><?php echo format_money($price_compatable['price'],'đ')?></span>
						
					</li>  
					
					<?php 
				}
				?>
			</ul>
		</div>
	</div>
<?php }?>
