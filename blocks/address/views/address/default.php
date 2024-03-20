<?php 
global $tmpl;
$tmpl -> addStylesheet('default','blocks/address/assets/css');
$cols = 2;
$total = count($list);
$i = 0;
?>
<!-- <div class="address_title">Hệ thống cửa hàng</div> -->
<div class='block_content address_content'>
	<?php foreach ($list as $item) {?>
		<?php //$link = FSRoute::_("index.php?module=contact&view=contact&id=".$item->id."&code=".$item->alias);	
		$link = URL_ROOT.'he-thong-cua-hang-dd'.$item-> id.'.html' ;?>
		<div class="item cls">
			<div class="item_1">
				<figure class="new_image">
					<a href="<?php echo $link; ?>" title="<?php echo htmlspecialchars(@$item->name); ?>"  class="image">
						<?php echo set_image_webp($item->image,'resized',@$item->name,'lazy',1,''); ?>
					</a>
				</figure>
			</div>
			<div class="item_1">
				<figure class="new_image">
					<a href="<?php echo $link; ?>" title="<?php echo htmlspecialchars(@$item->name); ?>"  class="image">
						<?php echo set_image_webp($item->image1,'resized',@$item->name,'lazy',1,''); ?>
					</a>
				</figure>
			</div>
			<div class="item_1">
				<ul class="info">
					<?php if($item->address) { ?>
						<li class="phone">
							<svg x="0px" y="0px"
							viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
							<g>
								<g>
									<path d="M256,0C161.896,0,85.333,76.563,85.333,170.667c0,28.25,7.063,56.26,20.49,81.104L246.667,506.5
									c1.875,3.396,5.448,5.5,9.333,5.5s7.458-2.104,9.333-5.5l140.896-254.813c13.375-24.76,20.438-52.771,20.438-81.021
									C426.667,76.563,350.104,0,256,0z M256,256c-47.052,0-85.333-38.281-85.333-85.333c0-47.052,38.281-85.333,85.333-85.333
									s85.333,38.281,85.333,85.333C341.333,217.719,303.052,256,256,256z"/>
								</g>
							</g>
						</svg>
						<?php echo $item-> address; ?></li>
					<?php } ?>
					<?php if($item->phone) { ?>
						<li class="phone"><svg x="0px" y="0px"
							viewBox="0 0 480.56 480.56" style="enable-background:new 0 0 480.56 480.56;" xml:space="preserve">
							<g>
								<g>
									<path d="M365.354,317.9c-15.7-15.5-35.3-15.5-50.9,0c-11.9,11.8-23.8,23.6-35.5,35.6c-3.2,3.3-5.9,4-9.8,1.8
									c-7.7-4.2-15.9-7.6-23.3-12.2c-34.5-21.7-63.4-49.6-89-81c-12.7-15.6-24-32.3-31.9-51.1c-1.6-3.8-1.3-6.3,1.8-9.4
									c11.9-11.5,23.5-23.3,35.2-35.1c16.3-16.4,16.3-35.6-0.1-52.1c-9.3-9.4-18.6-18.6-27.9-28c-9.6-9.6-19.1-19.3-28.8-28.8
									c-15.7-15.3-35.3-15.3-50.9,0.1c-12,11.8-23.5,23.9-35.7,35.5c-11.3,10.7-17,23.8-18.2,39.1c-1.9,24.9,4.2,48.4,12.8,71.3
									c17.6,47.4,44.4,89.5,76.9,128.1c43.9,52.2,96.3,93.5,157.6,123.3c27.6,13.4,56.2,23.7,87.3,25.4c21.4,1.2,40-4.2,54.9-20.9
									c10.2-11.4,21.7-21.8,32.5-32.7c16-16.2,16.1-35.8,0.2-51.8C403.554,355.9,384.454,336.9,365.354,317.9z"/>
									<path d="M346.254,238.2l36.9-6.3c-5.8-33.9-21.8-64.6-46.1-89c-25.7-25.7-58.2-41.9-94-46.9l-5.2,37.1
									c27.7,3.9,52.9,16.4,72.8,36.3C329.454,188.2,341.754,212,346.254,238.2z"/>
									<path d="M403.954,77.8c-42.6-42.6-96.5-69.5-156-77.8l-5.2,37.1c51.4,7.2,98,30.5,134.8,67.2c34.9,34.9,57.8,79,66.1,127.5
									l36.9-6.3C470.854,169.3,444.354,118.3,403.954,77.8z"/>
								</g>
							</g>
						</svg>
						Number Phone: <br><a href="tel:<?php echo $item-> phone; ?>"><?php echo $item-> phone; ?></a></li>
					<?php } ?>
					<?php if($item-> fax) { ?>
						<li class="phone">
							<svg enable-background="new 0 0 512 512"  viewBox="0 0 512 512"><g><path d="m467 211h-76v-105c0-41.355-33.645-75-75-75h-180c-8.284 0-15 6.716-15 15v165h-76c-24.813 0-45 20.187-45 45v90c0 24.813 20.187 45 45 45h76v75c0 8.284 6.716 15 15 15h240c8.284 0 15-6.716 15-15v-75h76c24.813 0 45-20.187 45-45v-90c0-24.813-20.187-45-45-45zm-108.58-120h-27.42v-27.42c12.764 4.527 22.893 14.656 27.42 27.42zm-207.42-30h150v45c0 8.284 6.716 15 15 15h45v90h-210zm210 390h-210v-90h210zm121-105c0 8.271-6.729 15-15 15h-76v-15c0-8.284-6.716-15-15-15h-240c-8.284 0-15 6.716-15 15v15h-76c-8.271 0-15-6.729-15-15v-90c0-8.271 6.729-15 15-15h422c8.271 0 15 6.729 15 15z"/><circle cx="376" cy="286" r="15"/><circle cx="316" cy="286" r="15"/><path d="m316 391h-120c-8.284 0-15 6.716-15 15s6.716 15 15 15h120c8.284 0 15-6.716 15-15s-6.716-15-15-15z"/></g></svg>
							Fax Phone: <br><a href="fax:<?php echo $item-> fax; ?>"><?php echo $item-> fax; ?></a></li>
						<?php } ?>
					</ul>

				</div>
				<div class="item_1">
					<figure class="new_image">
						<a href="<?php echo $link; ?>" title="<?php echo htmlspecialchars(@$item->name); ?>"  class="image">
							<?php echo set_image_webp($item->image2,'resized',@$item->name,'lazy',1,''); ?>
						</a>
					</figure>
				</div>
			</div>	
		<?php }//end: foreach ?>
	</div>