<div class="gallery_tabs">
	<ul>
		<li>
			<div class='item_content compare' id='compare_button'>So sánh </div>
		</li>
		
		<li id="v360z">
			<?php if($data->link_360){ ?>
				<div class="view-360 item_content" data-id="popup_v360">Xoay 360</div>
			<?php }else{ ?>
				<div class="view-360 item_content no_v360" >Xoay 360</div>
			<?php } ?>
			<div id="popup_v360" class="popup popup_v360">
				<div class="content-popup">
					<img class="button-close" src="<?php echo URL_ROOT.'images/button-close.png'; ?> " alt="">
					<embed  wmode="opaque" quality="high" name="<?php echo @$data->name;?>"  src="<?php echo URL_ROOT.'images/products/360/'.$data->link_360; ?>" type="application/x-shockwave-flash">
				</div>
			</div>
		</li>
		<li>
			<?php if($data->video){ ?>
				<div id="fullscreeniframe"  class="item_content video" data-id="popup_video">Video</div>
			<?php }else{ ?>
				<div class="item_content video no_video" >Video</div>
			<?php } ?>
				<div id="popup_video" class="popup ">
					<div class="content-popup">
						<img class="button-close" src="<?php echo URL_ROOT.'images/button-close.png'; ?> " alt=""/>
							<?php echo  $data -> video;?>
					</div>
				</div>
		</li>
		<li>
			 <div class='item_content slideshow'>Slide</div>
		</li>
	</ul>
	<div class="clear"></div>
</div>