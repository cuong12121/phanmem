	    			<h2 class="title-name">Sơ lược về <span> <?php echo $manu -> name; ?></span></h2>
	    			<div class="product-company">
                    	<a class="title-img-company" href="" title=""><img src="<?php echo URL_ROOT.str_replace('/original/', '/resized/', $manu -> image); ?>" alt="" ></a>
                    	<div class="title-company-right">
                        	<p>Tên công ty:</p>
                        	<p class="manu-name"><a href="" title="<?php echo $manu -> company_name; ?>"><?php echo $manu -> company_name; ?></a></p>
                        	<p><a class="view-product" href="<?php echo FSRoute::_('index.php?module=products&view=manufactory&id='.$manu->id.'&code='.$manu->alias);?>" title="Xem thêm">Xem các sản phẩm của <?php echo $manu -> name; ?> &raquo;</a></p>
                        </div>
                    	<div class="clear"></div>
                    	<div class="company-info">
                    		<?php echo $manu -> description; ?>
                    	</div>
                    	<div class="company-summary">
                    		<?php echo $manu -> summary; ?>
                    	</div>
                    	<div class="clear"></div>
                    </div>