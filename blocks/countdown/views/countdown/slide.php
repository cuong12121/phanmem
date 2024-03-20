<?php
global $tmpl; 
$tmpl -> addStylesheet('slide','blocks/products_list/assets/css');
$i = 0;
?>	
<?php if(isset($list) && !empty($list)){?>
	 <div id="myCarousel" class="bannercontainer carousel slide product_hot" data-interval="3000" data-ride="carousel">
		<h2>
            <span>Sản phẩm <strong>hot</strong></span> 
        </h2>
        <div class="clear"></div>	
        <div class="carousel-inner">
			<?php foreach($list as $item){?>
			<?php 
			if($item -> is_hotdeal){
				if($item -> date_end >  date('Y-m-d H:i:s') && $item->date_start <  date('Y-m-d H:i:s')){
					$price = $item->price;
					$price_old = $item->price_old;
				}else{
					$price = $item->price_old;
					$price_old = '';
				}
			}else{
				$price= $item->price;
				$price_old = $item->price_old;
			}
			?>	
			<?php $link = FSRoute::_('index.php?module=products&view=product&code='.$item -> alias.'&id='.$item -> id.'&ccode='.$item->category_alias); ?>
        		<div class="item <?php echo ($i==0)?'active':''?>">
                    <a href="" class="pull-left" title = "<?php echo $item -> name ; ?>" >
	        		     <img  width="120px" class="product_img" src='<?php echo URL_ROOT.str_replace('/original/', '/resized/', $item->image); ?>' alt='<?php echo $item->name;?>' />
	        		</a>
                    <div class="media-body">
                        <h2><a href="<?php echo $link;?>" title = "<?php echo $item -> name ; ?>" class="name" ><?php echo get_word_by_length(50,$item -> name); ?></a> </h2>	
                        <span>Bảo hành: <?php echo $item->warranty;?></span>
                        <div class="price "> 
                           		<span class="price"><?php echo format_money($price,'đ'); ?>	</span>
                        </div>
               		</div>
                    <div class="clear"></div>
                    <div class="product_info">
                      <?php echo nl2br($item->summary);?>
                    </div>
	        	</div>	
	       	 <?php $i++;?>				
			<?php }?>
		</div>
        <div class="clear"></div>
		<!-- Carousel nav -->
		<a class="carousel-control left " href="#myCarousel" data-slide="prev">
		</a>
		<a class="carousel-control right" href="#myCarousel" data-slide="next">
		</a>
	</div>
<?php }?>
