				<!--	Product list and price			-->
				<div class='shopcart_product'>
					<form action="#" method="post" name="shopcart" >
						<table width="100%" border="1" class="table-product-pack mt20" bordercolor="#DCDCDC" cellpadding="6">
							<thead>
							  <tr class="head-tr">
								<th class="th-column" width="6%">STT</th>
								<th class="th-column" width="">T&#234;n s&#7843;n ph&#7849;m</th>
								<th class="th-column" width="12%">S&#7889; l&#432;&#7907;ng</th>
								<th class="th-column" width="18%">Đơn giá(VNĐ)</th>
							
								<th class="th-column" width="18%">T&#7893;ng gi&#225;</th>
								<th class="th-column" width="10%">Xóa</th>
							  </tr>
							</thead>
							<tbody>
							
							<!--  Product list -->
							  <?php
							  $i = 0; 
							  $id_last = 0;
							  $total = 0;
							  $quantity = 0;
							  $cat_id_last = 0;
							  if($product_list) {
							  	foreach ($product_list as $prd) {
							  		$i++;
							  		$product = $this -> getProductById($prd[0]);
							  		$prd_name = $product -> name;
//							  		$prd_name = $this -> getProductName($prd[0]);
							  		
							  		$id_last = $prd[0];
							  		$cat_id_last = $product -> category_id;
//							  		$total +=  $prd[2]* $prd[1];
//							  		if($prd[4] == 1){
										$total +=  $prd[2]* $prd[1];
//									}else if($prd[4] == 2){
//										$total +=  ($prd[2]+300000)* $prd[1];
//									}else{
//										$total +=  ($prd[2]+600000)* $prd[1];
//									}
							  		$quantity += $prd[1];
							  		$link_del_prd =FSRoute::_('index.php?module=products&view=cart&task=edel&id='.$prd[0].'&Itemid=65');
							  		$link_detail_prd =FSRoute::_('index.php?module=products&view=product&code='.$product->alias.'&ccode='.$product -> category_alias.'&id='.$product->id.'&Itemid=6');
										  		
							  ?>	
							   <tr>
									<td class="center-column" align="center"><?php echo $i; ?></td>
							
									<td class="name-product" align="center">
										<a href="<?php echo $link_detail_prd; ?>" > <?php  echo $prd_name;  ?> </a> <br/>
										<a href="<?php echo $link_detail_prd; ?>" > 
											 <?php if($product -> image){ ?>
						                        	<?php $image_small = URL_ROOT.str_replace('/original/', '/resized/', $product->image); ?>
						                        	<img width="80" height="100" src="<?php echo $image_small; ?>" alt="<?php echo htmlspecialchars ($product -> name); ?>"  />
					                        <?php } else {?>
					                            <img  width="80" height="100" src="<?php echo URL_ROOT.'images/no-img.gif'; ?>" alt="<?php echo htmlspecialchars ($product -> name); ?>" />
					                        <?php }?>	 
										</a> 
									</td>
									<td align="center">
										<input class="numbers-pro" type="number" min="0" max="1000" value="<?php echo $prd[1]?>"  name="<?php echo 'quantity_'.$prd[0]; ?>" size="8px"/>
										<input class="" type="submit" name="re_calculate" id="sub-re-cal" value="T&#237;nh l&#7841;i" />
									</td>

									<td class="price-product" align="center">
										<div class="price"><?php  echo format_money($prd[2],''); ?></div>
										<?php if($product -> price_old){?>
										<div class="price_old"><?php  echo format_money($product -> price_old,''); ?></div>
										<?php }?>
									</td>
									
									<td class="total-price" align="center">
										<div class="price">
											<?php 
//									  			if($prd[4] == 1){
													echo format_money($prd[2]* $prd[1],'');
//												}else if($prd[4] == 2){
//													echo format_money(($prd[2]+300000)* $prd[1],'');
//												}else{
//													echo format_money(($prd[2]+600000)* $prd[1],'');
//												}
											?>
										</div>
									</td>
									<td class="center-column"  align="center">
										<a href="<?php echo $link_del_prd; ?>" title="">
											<img src="<?php echo  URL_ROOT.'modules/products/assets/images/del-product-cart.png';?>" alt="" />
											
										</a>
									</td>
									
							  </tr>
										  
							 <?php 
							  	}	
						  	}
						  	$cat_last = $this -> getProductCategoryById($cat_id_last);
						  	if($cat_last)
						  		$link_continue_buy = FSRoute::_('index.php?module=products&view=cat&ccode='.$cat_last->alias.'&cid='.$cat_last->id.'&Itemid=4');
						  	$link_del_all =FSRoute::_('index.php?module=products&view=cart&task=del_all&Itemid=65');
						  	$link_order = '#';
						  	?>		  
						</tbody>
						</table>
						<div class="all-button-cart pull-left">
							<?php if($cat_last){?>
							<input class="button-cart" type="button" name="next_step" id="sub-next-buy" onclick="javascript:window.location = '<?php echo $link_continue_buy; ?>'" value="&#9668; Ti&#7871;p t&#7909;c mua h&#224;ng"/>
							<?php }?>
							<input class="button-cart" type="submit" name="re_calculate" id="sub-re-cal" value="T&#237;nh l&#7841;i" />
							<input class="button-cart" type="button" name="remove"  value="X&#243;a h&#7871;t" onclick="javascript:window.location = '<?php echo $link_del_all; ?>'"/>
							<input class="button-cart" type="button" name="order" id="sub-pro-liquidate" value="Thanh to&#225;n &#9658;" onclick="javascript:window.location = '<?php echo $link_order; ?>'" />
						</div>	
						<div class="total-price pull-right" align="right" >Thành tiền (VNĐ): <span><?php echo format_money($total,' VNĐ');?></span></div>		
						<div class="clearfix"></div>			
						<input type="hidden" name='Itemid' value="<?php echo $Itemid; ?>" />
						<input type="hidden" name='module' value="products" />
						<input type="hidden" name='view' value="cart" />
						<input type="hidden" name='task' value="ere_cal2" id = 'task'/>
					</form>	
				</div>
				