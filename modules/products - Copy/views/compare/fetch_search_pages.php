<link href="/modules/products/assets/css/cat.css" media="screen" type="text/css" rel="stylesheet">
<?php

 $cols = 4;
 $tmp = 0;
?>
<div class='product_cat'>
	<div class='vertical'>
		<?php if (isset ( $_SESSION [$table_name] )) {
			$list_cmp_id = $_SESSION [$table_name];
		}?>
		<?php if(count($list_cmp)){?>
			<?php foreach($list_cmp as $item){ ?>
		        <?php $tmp++; ?>
				<?php $link = FSRoute::_('index.php?module='.$this -> module.'&view=product&code='.$item->alias.'&ccode='.$item->category_alias.'&id='.$item->record_id.'&Itemid=5'); ?>
		        <div class="item">		
		      	  <div class="item_inner">
		      	  		<div class="item_inner_bg">	
		      	  			<div class="button_compare_2">
							<!-- COMPARE   -->
						        <?php if(isset($list_cmp_id) && !empty($list_cmp_id) && in_array($item->record_id, $list_cmp_id)){?>
						        	<input data-id="del_prd_<?php echo $item->record_id; ?>" data-tab="scroll-tab" type="checkbox" class='check_compare' id='<?php echo $item -> record_id; ?>'  table_name="<?php echo $table_name;?>" checked="checked"  /> So sánh
						        <?php }else{ ?>
						       	 <input data-id="del_prd_<?php echo $item->record_id; ?>"  data-tab="scroll-tab" type="checkbox" class='check_compare' id='<?php echo $item -> record_id; ?>'  table_name="<?php echo $table_name; ?>"  /> So sánh
						        <?php }?>
					        </div>
				            <?php if($item->image){?>
								<?php $image_small = str_replace('/original/', '/resized/', $item->image); ?>
								<div class="frame_img_prd">
									<a href="<?php echo $link;?>" title='<?php echo $item->name;?>'>
										<img class="img_prd"  alt="<?php echo $item->name;?>" src="<?php echo URL_ROOT.$image_small;?>" />
									</a>
								</div>
							<?php }else{?>
								<div class="frame_img_prd">
				            		<a href="<?php echo $link;?>" title='<?php echo $item->name;?>'>
				            			<img class="img_prd"  src='<?php echo URL_ROOT.'images/no-img-prd.png'; ?>' alt="<?php echo $item->name;?>" />
				            		</a>
				            	</div>
							<?php } ?>
				            <h3 class="name"><a  href="<?php echo $link;?>" title='<?php echo $item->name;?>'><?php echo $item->name;?></a></h3>
				            <div class="price_area">
				            	<span>Giá bán</span>
				            	<?php if($item -> discount && $item -> price_old){?>
				            		<div class='discount'>
				            			<?php echo '-<span>'.round((($item -> price_old - $item -> price)/$item -> price_old)*100).'</span><font>%</font>'?>
				            		</div>
				            		<div class='price_old'><?php echo format_money($item -> price_old).''?></div>
				            	<?php }else{?>
				            		<div class='price_old'>&nbsp;</div>
				            	<?php }?>
				            	<?php $vat= $item -> price+$item -> price*$cat->vat/100; ?>
				            	<div class='price_current'><?php echo format_money($vat).''?></div>
				            </div>
				            <div class='prd_detail'>
						 		<a  href="<?php echo $link;?>">Chi tiết</a>
						 	</div><!--  end: .prd_detail -->
							<?php if(count($types)){?>
								<?php foreach($types as $type){?>
								<?php if(strpos($item -> types,','.$type->id.',') !== false || $item -> types == $type->id){?>
										<div class='product_type product_type_<?php echo $type -> alias; ?>'><img src="<?php echo URL_ROOT.str_replace('/original/', '/resized/', $type->image); ?>" alt="<?php //echo $type -> name; ?>" /></div>
								<?php break;?>		
							<?php }?>
								<?php }?>
							<?php }?>
				       </div>     
					</div>
		        </div><!--end: .item-->
			<?php }//end: foreach($list as $item) ?>
			<div class="clear"></div>
			<?php if($pagination) echo $pagination->showPagination(1); ?>
	    <?php }else{
	    	echo "Không tồn tại sản phẩm nào!";
	    }?>
	    <div class="clear"></div>
	</div><!--end: .vertical-->
</div>
<script src="/modules/products/assets/js/compare.js" type="text/javascript" language="javascript"></script>
