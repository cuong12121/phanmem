<?php 
global $tmpl, $config;
$tmpl -> addStylesheet('owl.carousel','libraries/jquery/owl.carousel.2/assets');
$tmpl -> addScript('owl.carousel.min','libraries/jquery/owl.carousel.2');
$tmpl -> addStylesheet('tab','blocks/address/assets/css');
$tmpl -> addScript('tab','blocks/address/assets/js');
$total = count($list);
?>

<div class="block_address_tab">
	<div class="tab">
		<?php for ($i=1; $i <= count($list); $i++){ ?>
			<button class="<?php echo $i==1 ? 'active' : ''  ?> tablinks tab-boder" data-id=<?php echo $i ?> > <span class="text">Chi nhánh <?php echo $i; ?></span></button>
		<?php } ?>
	</div>
	<?php $link = FSRoute::_("index.php?module=department&view=department");	?>
	<div class="tabcontent">
	<?php $j= 1; foreach ($list as $item) {?>
		<div class="region_<?php echo $j;?> regions <?php echo $j==1 ? 'active' : ''  ?>">
			<div class="name">
				<?php echo $item->name?>
			</div>
			<div class="address">
				Địa chỉ: <?php echo $item->address?>
			</div>
			<div class="other">
				<div>
					Cung cấp: <?php echo $item->more_info?>
				</div>
				<div>
					Email: <?php echo $item->email?>
				</div>
				<div>
					Giờ làm việc: <?php echo $item->time_wk?>
				</div>
			</div>
			<div class="bt-buttom">
				<a href="<?php echo $link ?>" title="Bản đồ">
					<svg x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
					<g>
						<g>
							<path d="M256,0C161.896,0,85.333,76.563,85.333,170.667c0,28.25,7.063,56.26,20.49,81.104L246.667,506.5    c1.875,3.396,5.448,5.5,9.333,5.5s7.458-2.104,9.333-5.5l140.896-254.813c13.375-24.76,20.438-52.771,20.438-81.021    C426.667,76.563,350.104,0,256,0z M256,256c-47.052,0-85.333-38.281-85.333-85.333c0-47.052,38.281-85.333,85.333-85.333    s85.333,38.281,85.333,85.333C341.333,217.719,303.052,256,256,256z"/>
						</g>
					</g>
					</svg>
					Bản đồ
				</a>

				<a href="<?php echo $item->link_map ?>" title="Chỉ đường">
					<svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="512" viewBox="0 0 24 24" width="512"><path d="m8.75 17.612v4.638c0 .324.208.611.516.713.077.025.156.037.234.037.234 0 .46-.11.604-.306l2.713-3.692z"/><path d="m23.685.139c-.23-.163-.532-.185-.782-.054l-22.5 11.75c-.266.139-.423.423-.401.722.023.3.222.556.505.653l6.255 2.138 13.321-11.39-10.308 12.419 10.483 3.583c.078.026.16.04.242.04.136 0 .271-.037.39-.109.19-.116.319-.311.352-.53l2.75-18.5c.041-.28-.077-.558-.307-.722z"/></svg>
					Chỉ đường
				</a>

				<a href="tel:<?php echo $config['hotline'] ?>" title="Hotline">
					<span><svg x="0px" y="0px" viewBox="0 0 512.006 512.006" style="enable-background:new 0 0 512.006 512.006;" xml:space="preserve">
					<g>
						<g>
							<g>
								<path d="M502.05,407.127l-56.761-37.844L394.83,335.65c-9.738-6.479-22.825-4.355-30.014,4.873l-31.223,40.139     c-6.707,8.71-18.772,11.213-28.39,5.888c-21.186-11.785-46.239-22.881-101.517-78.23c-55.278-55.349-66.445-80.331-78.23-101.517     c-5.325-9.618-2.822-21.683,5.888-28.389l40.139-31.223c9.227-7.188,11.352-20.275,4.873-30.014l-32.6-48.905L104.879,9.956     C98.262,0.03,85.016-2.95,74.786,3.185L29.95,30.083C17.833,37.222,8.926,48.75,5.074,62.277     C-7.187,106.98-9.659,205.593,148.381,363.633s256.644,155.56,301.347,143.298c13.527-3.851,25.055-12.758,32.194-24.876     l26.898-44.835C514.956,426.989,511.976,413.744,502.05,407.127z"/>
								<path d="M291.309,79.447c82.842,0.092,149.977,67.226,150.069,150.069c0,4.875,3.952,8.828,8.828,8.828     c4.875,0,8.828-3.952,8.828-8.828c-0.102-92.589-75.135-167.622-167.724-167.724c-4.875,0-8.828,3.952-8.828,8.828     C282.481,75.494,286.433,79.447,291.309,79.447z"/>
								<path d="M291.309,132.412c53.603,0.063,97.04,43.501,97.103,97.103c0,4.875,3.952,8.828,8.828,8.828     c4.875,0,8.828-3.952,8.828-8.828c-0.073-63.349-51.409-114.686-114.759-114.759c-4.875,0-8.828,3.952-8.828,8.828     C282.481,128.46,286.433,132.412,291.309,132.412z"/>
								<path d="M291.309,185.378c24.365,0.029,44.109,19.773,44.138,44.138c0,4.875,3.952,8.828,8.828,8.828     c4.875,0,8.828-3.952,8.828-8.828c-0.039-34.111-27.682-61.754-61.793-61.793c-4.875,0-8.828,3.952-8.828,8.828     C282.481,181.426,286.433,185.378,291.309,185.378z"/>
							</g>
						</g>
					</g>
					</svg></span>
					<?php echo $config['hotline'] ?>
				</a>
			</div>
		</div>	
	<?php $j++; }?>
	</div>
</div>


<div class="slide-image-address">
	<?php $k=1; foreach ($list as $item) {?>
			<div class="">
				<div class="owl-carousel regions_slide_item regions_slide regions_slide_item_<?php echo $k ?> <?php echo $k==1 ? ' active' : ''  ?>">
					<div class="item">
						<?php echo set_image_webp($item->image,'large',@$item->name,'',0,''); ?>
					</div>
					<div class="item">
						<?php echo set_image_webp($item->image1,'large',@$item->name,'',0,''); ?>
					</div>
					<div class="item">
						<?php echo set_image_webp($item->image2,'large',@$item->name,'',0,''); ?>
					</div>
				</div>
			</div>		
	<?php $k++; }?>
</div>