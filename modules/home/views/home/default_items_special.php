<?php
	$link_buy = FSRoute::_("index.php?module=products&view=cart&task=buy&id=".$item->id."&Itemid=94");
	$link = FSRoute::_('index.php?module=products&view=product&code='.$item -> alias.'&ccode='.$item->category_alias.'&id='.$item->id.'&cid='.$item->category_id.'&Itemid='.$Itemid);
?>
<div  class="item item_special">					


	<div id="item_special_<?php echo $cat->alias;?>" class="cls item_special_t">
    <div class="frame_inner item_special_l ">
	    <figure class="product_image ">
	        <?php $image_small = str_replace('/original/', '/large/', $item->image); ?>
			<a href="<?php echo $link;?>" title='<?php echo $item->name;?>'>
				<img alt="<?php echo $item->name;?>" data-src="<?php echo URL_ROOT.$image_small;?>"  onerror="javascript:this.src='<?php echo URL_ROOT.'images/NA240x240.png';?>'" class="lazy"/>
				<img alt="<?php echo $item->name;?>" data-src="<?php echo URL_ROOT.$image_small;?>"  onerror="javascript:this.src='<?php echo URL_ROOT.'images/NA240x240.png';?>'" class="lazy shadow"/>
			</a>
    	</figure>

						
    </div>   <!-- end .frame_inner -->


    <div class="item_special_r">                
		<div class="main_info">
			<h2><a href="<?php echo $link; ?>" title = "<?php echo $item -> name ; ?>" class="name" >
  				<div class="name_core"><?php echo FSString::getWord(15,$item -> name_special); ?></div>
  				<div class="name_display"><?php echo FSString::getWord(15,$item -> status_special); ?></div>
        	</a> </h2>

        	<div class='price_arae'>
        		<div class="price-txt">Giá chỉ</div>
		  		<div class='price_current'><span class="bf"></span><?php echo format_money($item -> price).''?><span class="af"></span></div>
            	<?php if( $item -> price_old && $item -> price_old > $item -> price){?>
            		<div class='price_old'><span><?php echo format_money($item -> price_old).''?></span></div>
            	<?php }?>
        	</div>

        	<div class="special_gifts">
        		<span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
<path style="fill:#F7434C;" d="M469.162,227.716H42.838c-4.466,0-8.084,3.62-8.084,8.084v250.833c0,4.465,3.618,8.084,8.084,8.084  h426.325c4.466,0,8.084-3.62,8.084-8.084V235.801C477.246,231.335,473.627,227.716,469.162,227.716z"/>
<path style="fill:#DB2E37;" d="M469.162,227.716H42.838c-4.466,0-8.084,3.62-8.084,8.084v32.337h442.493v-32.337  C477.246,231.335,473.627,227.716,469.162,227.716z"/>
<path style="fill:#FFDB57;" d="M297.3,227.716h-82.598c-4.466,0-8.084,3.62-8.084,8.084v250.833c0,4.465,3.618,8.084,8.084,8.084  H297.3c4.465,0,8.084-3.62,8.084-8.084V235.801C305.384,231.335,301.764,227.716,297.3,227.716z"/>
<path style="fill:#F5BA3D;" d="M297.3,227.716h-82.598c-4.466,0-8.084,3.62-8.084,8.084v32.164h98.766v-32.164  C305.384,231.335,301.764,227.716,297.3,227.716z"/>
<path style="fill:#FFDB57;" d="M453.413,78.378c-7.927-20.661-20.434-40.84-33.457-53.981c-4.779-4.821-11.214-7.265-18.539-7.108  c-24.272,0.565-63.824,31.028-117.557,90.542c-1.342,1.485-2.085,3.416-2.085,5.418v42.761c0,4.465,3.618,8.084,8.084,8.084h124.353  c27.708,0,39.144-13.48,43.857-24.789C464.357,124.23,462.702,102.591,453.413,78.378z"/>
<path style="fill:#EF9325;" d="M458.041,92.464c-0.226-0.83-0.583-1.619-1.058-2.336c-12.207-18.457-38.584-11.551-58.561-2.508  c-58.039,26.272-82.007,62.461-82.999,63.988c-1.615,2.487-1.739,5.656-0.324,8.261c1.414,2.605,4.14,4.226,7.104,4.226h92.012  c17.631,0,30.706-5.412,38.862-16.085C462.766,135.33,464.482,116.122,458.041,92.464z"/>
<path style="fill:#FFDB57;" d="M228.139,107.832c-53.733-59.514-93.285-89.977-117.557-90.542  c-7.344-0.158-13.761,2.287-18.539,7.108c-13.022,13.14-25.53,33.32-33.456,53.981c-9.289,24.213-10.944,45.851-4.66,60.928  c4.714,11.309,16.149,24.789,43.858,24.789h124.353c4.466,0,8.084-3.62,8.084-8.084V113.25  C230.223,111.248,229.482,109.317,228.139,107.832z"/>
<path style="fill:#EF9325;" d="M196.578,151.608c-0.992-1.527-24.96-37.717-82.999-63.988C93.6,78.577,67.224,71.674,55.017,90.127  c-0.474,0.718-0.831,1.506-1.057,2.337c-6.443,23.658-4.725,42.866,4.964,55.545c8.155,10.673,21.23,16.085,38.862,16.085h92.012  c2.964,0,5.69-1.621,7.104-4.226C198.316,157.264,198.192,154.095,196.578,151.608z"/>
<path style="fill:#F5BA3D;" d="M289.861,97.175h-67.722c-4.466,0-8.084,3.62-8.084,8.084v50.753c0,4.465,3.618,8.084,8.084,8.084  h67.722c4.466,0,8.084-3.62,8.084-8.084v-50.753C297.945,100.794,294.327,97.175,289.861,97.175z"/>
<path style="fill:#F7434C;" d="M503.916,147.943H8.084c-4.466,0-8.084,3.62-8.084,8.084V235.8c0,4.465,3.618,8.084,8.084,8.084  h495.832c4.466,0,8.084-3.62,8.084-8.084v-79.773C512,151.562,508.382,147.943,503.916,147.943z"/>
<rect x="193.902" y="147.94" style="fill:#FFDB57;" width="124.195" height="95.943"/>
<g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg></span>
        		<?php echo $item-> gift_accessories ?>
        	</div>
		
			<div class="clear"></div> 
    	</div> 
	          
	</div>

	</div>
	

	<div class="clear"></div>


	<div class="item_special_bt">
		<div class="main_info">
			<h2><a href="<?php echo $link; ?>" title = "<?php echo $item -> name ; ?>" class="name" >
  				<?php echo FSString::getWord(15,$item -> name); ?>
        	</a> </h2>	
        	<div class='price_arae'>
		  		<div class='price_current'><?php echo format_money($item -> price).''?></div>
	        
            	<?php if( $item -> price_old && $item -> price_old > $item -> price){?>
            		<div class='price_old'><span><?php echo format_money($item -> price_old).''?></span></div>
            	<?php }?>

		    	<?php if(@$item -> is_new){ ?>
						<div class="new_icon"></div>
					<?php }?>
					<?php if(@$item -> is_hot){ ?>
						<div class="hot_icon"></div>
					<?php }?>
					<?php if(@$item -> is_sale){ ?>
						<div class="sale_icon"></div>
				<?php }?>
				<?php if($item -> style_types){ ?>
					<?php $arr_style_type = explode(',', $item -> style_types); ?>

						<?php foreach( $arr_style_type as $st){ ?>
							<?php if($st){ ?>
								<div class= '<?php echo $st; ?> style_types'><?php echo $style_types_rule[$st]; ?></div>
							<?php } ?>
						<?php } ?>
					
				<?php } ?>

        	</div>
        	<div class="gift">
        		<?php echo $item-> gift ?>
        	</div>
		
			<div class="clear"></div> 
    	</div> 
	</div> 
		

                    			
	
</div>

		