<?php
global $tmpl; 
$tmpl -> addScript('categories_cmp','modules/products/assets/js');
?>	
<h1 class="title-category"><span><?php echo $cat -> name; ?></span></h1>
<div class="compare-product">
	<div class="text-title">Chọn sản phẩm phía dưới để so sánh (tối đa 4 sản phẩm)</div>
    <div class="form-product">
    	<div class="left-compare">
    		<?php if(isset($product_cmp) && !empty($product_cmp)){?>
	    		<?php $list_id=array();?>
	    		<?php for($i=0;$i<4;$i++){?>
	    			<?php if(isset($product_cmp[$i]) && !empty($product_cmp[$i])){?>
	    				<?php $list_id[] = $product_cmp[$i]->id;?>
		    			<div class="one-product">
			            	<div class="avatar-product-compare"><img width="130px" height="130px" id="compare-<?php echo $i;?>" src="<?php if(isset($product_cmp[$i]->image) && !empty($product_cmp[$i]->image)){ ?><?php echo URL_ROOT.'images/products/resized/'.$product_cmp[$i]->image; ?><?php }else{?><?php echo URL_ROOT.'templates/default/images/apple-avatar.jpg'; ?><?php }?> " alt="compare-product" /></div>
			                <div id="button-del-<?php echo $i;?>" class="button-del" ><span table_name="<?php echo $cat -> tablename;?>" class="del-product" pos="<?php echo $i?>" lang="<?php echo $product_cmp[$i]->id;?>">Xóa</span></div>
			            </div>
	    			<?php }else{?>
	    				<div class="one-product">
			            	<div class="avatar-product-compare"><img width="130px" height="130px" id="compare-<?php echo $i;?>" src="<?php echo URL_ROOT.'templates/default/images/apple-avatar.jpg'; ?>" alt="" /></div>
			            	<div id="button-del-<?php echo $i;?>" class="button-del" ><span class="del-product" style="display:none;">Xóa</span></div>
			            </div>
	    			<?php }?>
	            <?php }?>
            <?php }else{?>
            	<?php for($i=0;$i<4;$i++){?>
            		<div class="one-product">
		            	<div class="avatar-product-compare"><img width="130px" height="130px" id="compare-<?php echo $i;?>" src="<?php echo URL_ROOT.'templates/default/images/apple-avatar.jpg'; ?>" alt="" /></div>
		            	<div id="button-del-<?php echo $i;?>" class="button-del" ><span class="del-product" style="display:none;">Xóa</span></div>
		            </div>
            	<?php }?>
            <?php }?>
            <?php $list_id=(isset($list_id) && !empty($list_id))?$list_id:array();?>
        </div>
    	<div class="right-compare">
        	<div class="compare-all" table_name="<?php echo $cat -> tablename;?>"></div>
            <div class="delete-all" table_name="<?php echo $cat -> tablename;?>">Xóa hết</div>
            <input id="root_id" type="hidden" value="<?php echo $cat->id?>" />
        </div>        
    </div>
    <div class="clear"></div>
</div>