	<div class="product-tab" id="smartTab">
        	<ul class='product_tabs_ul cf clearfix'>
	        	<li class='scroll-nav__item active'>
	        		<a class="scroll-nav__link" href="#prodetails_tab1"><span>Đặc điểm nổi bật</span></a>
	        	</li>
           		<li class='scroll-nav__item'>
           			<a class="scroll-nav__link" href="#prodetails_tab2"><span>Thông số kỹ thuật</span></a>
           		</li>
           	
           		<?php if($data -> tutorial){?>
           		<li class='scroll-nav__item'>
           			<a class="scroll-nav__link" href="#prodetails_tab4"><span>Hướng dẫn sử dụng</span></a>
           		</li>
           		<?php }?>
            </ul>
            <div class="clearfix"></div>
    </div>    
    <div class='product_tab_content' id="tabs">
   		<div id="prodetails_tab1" class="prodetails_tab">
	   		<div class='tab_label'><span>Đặc điểm nổi bật</span> <strong> của <?php echo $data -> name; ?></strong></div>
        	<div class='tab_content_right'>
        		<div class='description' >
					<?php echo $description;?>
				</div>
				<?php if($data -> summary){?>
        			<?php 	include 'default_tags.php'; ?>
        		<?php }?>
			</div>
   		</div>
		<div id="prodetails_tab2" class="prodetails_tab">
			<div class='tab_label'><span>Thông số kĩ thuật </span><strong>của <?php echo $data -> name; ?></strong></div>
        	<div class='tab_content_right'>
        		<div class='characteristic'>
            <?php 	//include 'default_characteristic.php'; ?>
            	<?php   echo   $data -> specs_copy;  ?>
            	</div>
          </div>
   		</div>
   		
   		<?php if($data -> tutorial){?>
   		<div id="prodetails_tab4" class="prodetails_tab">
	   		<div class='tab_label'><span>Hướng dẫn sử dụng </span></div>
        	<div class='tab_content_right'>
        		<?php 	echo $data -> tutorial; ?>
        	</div>
   		</div>
   		<?php } ?>
   		<div id="prodetails_tab30" class="prodetails_tab">
	   		<div class='tab_label'><span>Nhận xét đánh giá</span> <strong>về <?php echo $data -> name; ?></strong></div>
        	<div class='tab_content_right'>
        		<?php //	include 'comments/comments_tree_mixed_rating.php'; ?>
        		<?php 	include 'comments/default_comments_fb.php'; ?>
        	</div>
   		</div>
   		<div id="prodetails_tab40" class="prodetails_tab">
	   		<?php 	
			$title_relate =  'Sản phẩm cùng khoảng giá';
			$relate_type = 3;
			$list_related = $products_same_price;
			include 'related/default_related.php';
			?>
   		</div>
   		<div id="prodetails_tab50" class="prodetails_tab">
	   		<?php 	
			$title_relate =  'Sản phẩm liên quan';
			$relate_type = 3;
			$list_related = $products_in_cat;
			include 'related/default_related.php';
			?>
   		</div>
   		<div id="prodetails_tab7" class="prodetails_tab">
   		</div>
	</div>
	<? //include_once("comment_facebook.php");?>
