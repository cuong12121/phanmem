<?php $i=0;
$arr_service = explode (',', $data->products_service );
$total_service = count($arr_service);
?>
	<ul  class=" clearfix">
			<?php 
				for($i = 0; $i < $total_service; $i ++) {
					$item = trim ( $arr_service [$i] );
					$product_item = @$array_products_service[$item]; 
					if(!$product_item)
						continue;
					$link = FSRoute::_('index.php?module=products&view=product&code='.$product_item -> alias.'&id='.$product_item -> id.'&ccode='.$product_item -> category_alias);
					$price_service = calculator_price($product_item->price,$product_item->price_old,$product_item->h_price,$product_item -> is_hotdeal,$product_item->date_start,$product_item->date_end);
					?>	
				
		            <li class="item">
						<div class="_content">
							 <a  rel="nofollow" href="<?php echo $link; ?>" title = "<?php echo $product_item -> name ; ?>" >
		                		<img class="img-responsive" src="<?php echo URL_ROOT.str_replace('/original/', '/resized/', $product_item->image); ?>" alt="<?php echo htmlspecialchars ($product_item -> name); ?>"  />
		                		<h3><?php echo get_word_by_length(80,$product_item -> name); ?></h3>
		                		<strong><?php echo format_money($price_service['price'],'đ')?></strong>
			                </a>
			      		<a  rel="nofollow" href="<?php echo $link; ?>" class="viewdetail">Xem chi tiết</a>
						</div>
		               
		             </li>  

					<?php 
				}
	?>
	</ul>
