<?php // $link_del_all = FSRoute::_('index.php?module=products&view=compare&cid='.$cat_id.'&task=delete_all_compare&table_name='.$tablename); ?>
<table class='compare_table compare_from' border="0" bordercolor="#E2E2E2" cellspacing="0" cellpadding="0" width="100%"  id="scroll-tab">
	<tr >
		<td class='title' width="25%" align="center">
			<div  class="compare-all abutton" table_name="<?php echo $tablename;?>">So sánh</div>
			<div class="button_back abutton " style="display:none">
				<a href="<?php echo FSRoute::_('index.php?module=products&view=cat&ccode='.$cat->alias);?>" >Trở lại</a>
			</div>
            <div class="delete-all abutton"> <a href="<?php  echo $link_del_all; ?>">Xóa hết</a></div>
           <?php if($total_cpm < 3){?>
            <div class="button_add abutton" > <a href="#" onclick="search_product_cmp(this); " value="<?php echo $tablename ?>"">Thêm</a></div>
            <?php } ?>
            <input id="root_id" type="hidden" value="<?php echo $cat_id?>" />
		</td>
		<?php 
			for($i  = 0;$i < 3; $i++ ){
				$item = @$data[$i]; 
				$link_detail = FSRoute::_('index.php?module=products&view=product&code='.@$item -> alias.'&id='.@$item -> record_id.'&ccode='.@$item->category_alias.'&Itemid=31');
				if(isset($product_cmp[$i]) && !empty($product_cmp[$i])){
				 $list_cmp_id_2[] = $product_cmp[$i]->id;
			?>
				<td class='cp_content <?php echo  $i;?>' width='25%' align="center">
						<div class=" picture_small one-product cmp_prd_order_<?php echo  $i;?>" id='cmp_prd_<?php echo $product_cmp[$i]->id; ?>'>
			            	<img  id="compare-<?php echo $i;?>" src="<?php if(isset($product_cmp[$i]->image) && !empty($product_cmp[$i]->image)){?><?php echo URL_ROOT.str_replace('/original/', '/resized/', $product_cmp[$i]->image); ?><?php	}else{?><?php echo URL_ROOT.'images/no-img-prd.png'; ?><?php }?> " alt="compare-product" />
			            	
		            		<?php if(isset($product_cmp[$i]->name) && !empty($product_cmp[$i]->name)){?>
		            			<div class="cmp_prd_name"><a href="<?php echo $link_detail;?>"><?php echo $product_cmp[$i]-> name;?></a></div>
		            			<div class='del-product-cmp' id=del_prd_<?php echo $product_cmp[$i]->id; ?> table_name="<?php echo $tablename;?>">xóa</div>
	            			<?php }else{?>
		            				<div class="cmp_prd_name"></div>
		            				<div class='del-product-cmp' style="display: none;" table_name="<?php echo $cat -> tablename;?>"> xóa</div>
	            			<?php }?>
		            	
			            </div>
				</td>
				<?php 
				}else{?>
					<td class='cp_content <?php echo  $i;?>' width='25%' align="center" >
						<div class=" picture_small one-product  cmp_prd_order_<?php echo  $i;?>">
			            	<img id="compare-<?php echo $i;?>" src="<?php echo URL_ROOT.'templates/'.TEMPLATE.'/images/noavatar.jpg'; ?>" alt="" />
			            	<div class="cmp_prd_name">&nbsp;</div>
			            	<div class='del-product-cmp' style="display: none;" table_name="<?php echo $cat -> tablename;?>"> xóa</div>
			            </div>
					</td>
				<?php }?>		
			<?php }?>
			 <?php $list_cmp_id_2=(isset($list_cmp_id_2) && !empty($list_cmp_id_2))?$list_cmp_id_2:array();?>
	</tr>
</table>