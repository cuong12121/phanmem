<?php
global $tmpl; 
$tmpl -> addScript('categories_cmp','modules/products/assets/js');
$tmpl -> addStylesheet('compare','modules/products/assets/css');
?>	
<div class="compare-product">
	
    <div class="form-product">
    	<div class="text-title">Chọn sản phẩm</div>
    	<div class="left-compare">
	    		<?php $list_id=array();?>
	    		<?php for($i=0;$i<3;$i++){?>
	    			<?php if(isset($product_cmp[$i]) && !empty($product_cmp[$i])){?>
	    				<?php $list_cmp_id[] = $product_cmp[$i]->id;?>
		    			<div class="one-product cmp_prd_order_<?php echo  $i;?> cmp_prd_<?php echo $product_cmp[$i]->id; ?>" id='cmp_prd_<?php echo $product_cmp[$i]->id; ?>'>
			            	<img width="35px" height="35px" id="compare-<?php echo $i;?>" src="<?php if(isset($product_cmp[$i]->image) && !empty($product_cmp[$i]->image)){ ?><?php echo URL_ROOT.str_replace('/original/', '/resized/', $product_cmp[$i]->image); ?><?php }else{?><?php echo URL_ROOT.'images/no-img-prd.png'; ?><?php }?> " alt="compare-product" />
			            	<div class="cmp_prd_name arrow_box" ><span class='txt_name' ><?php echo $product_cmp[$i]-> name; ?></span><span class='del-product-cmp' table_name="<?php echo $cat -> tablename;?>">xóa</span></div>
			            </div>
	    			<?php }else{?>
	    				<div class="one-product  cmp_prd_order_<?php echo  $i;?>">
			            	<img width="35px" height="35px" id="compare-<?php echo $i;?>" src="<?php echo URL_ROOT.'templates/'.TEMPLATE.'/images/noavatar.jpg'; ?>" alt="" />
			            	<div class="cmp_prd_name arrow_box" style="display:none"><span class='txt_name'></span><span class='del-product-cmp' table_name="<?php echo $cat -> tablename;?>">xóa</span></div>
			            </div>
	    			<?php }?>
	            <?php }?>
	            <div class="clear"></div>
            <?php $list_cmp_id=(isset($list_cmp_id) && !empty($list_cmp_id))?$list_cmp_id:array();?>
        </div>
    	<div class="right-compare">
        	<div class="compare-all" table_name="<?php echo $cat -> tablename;?>"></div>
            <div class="delete-all" table_name="<?php echo $cat -> tablename;?>">Xóa hết</div>
            <input id="root_id" type="hidden" value="<?php echo $cat->id?>" />
        </div>        
    </div>
    <div class="clear"></div>
</div>