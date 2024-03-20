<div id="products-tab">
				<div class="products-tab-left">
	                <div class="products-tab-name">
	    				<div class="detail_product_tab_first detail_product_tab_select" id="detail_tab_1">
	    					<a href="#detail_content_1">Tổng quan</a>
	    				</div>
	    				<div class="detail_product_tab" id="detail_tab_2">
	    					<a href="#detail_content_2">Thông số kỹ thuật</a>
	    				</div>
	    				<div class="detail_product_tab" id="detail_tab_3">
	    					<a href="#detail_content_3">Tin tức liên quan</a>
	    				</div>
	    				<?php if($videos_relate_tags){?>
	    				<div class="detail_product_tab" id="detail_tab_4">
	    					<a href="#detail_content_4">Video</a>
	    				</div>
	    				<?php }?>
	    				<div class="clear"></div>
	    			</div>
	    			<div class="detail_product_content">
	    				<div id="detail_content_1" class="detail_content">
	    					<?php echo $data -> description; ?>
							<div class="clear"></div>
	                    </div>
	                    <div class="clear"></div>
	    				<div id="detail_content_2" class="detail_content">
	                        <h3>Thông số kỹ thuật</h3>
	                        <?php include_once 'default_characteristic.php'; ?>
	                        <div class="clear"></div>
	    				</div>
	    				<div class="clear"></div>
	    				<div id="detail_content_3" class="detail_content">
	                        <h3>Tin tức liên quan</h3>
	                        <?php include_once 'default_news_related.php'; ?>
	                        <div class="clear"></div>
	                       
	    				</div>
	    				<div class="clear"></div>
	    				<?php if($videos_relate_tags){?>
	    				<div id="detail_content_4" class="detail_content">
	                        <h3>Video</h3>
	                        <?php  include_once 'default_videos_related.php'; ?>
							<div class="clear"></div>
	    				</div>
	    				<?php }?>
	    				
	    				<div class="clear"></div>
	    			</div>
	    		</div>
	    		<div class="products-tab-right">
	    			 <?php include_once 'default_manufactory.php'; ?>
	    			 <?php include_once 'related/default_related.php'; ?>
	    			  <?php if($tmpl->count_block('detail_right')) {?>
				        <div class="detail_right">
				            <?php  echo $tmpl->load_position( 'detail_right', 'XHTML'); ?>
				        </div><!--end: .detail_right-->
				      <?php }?>
	    		</div>
	    		<div class="clear"></div>
			</div>