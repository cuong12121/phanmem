<?php 
global $tmpl, $config;
$tmpl -> addStylesheet('list','blocks/address/assets/css');
$total = count($list);
?>

<div class="block_address_tab">
	<?php $link = FSRoute::_("index.php?module=department&view=department");	?>
	<div class="tabcontent">
	<?php $j= 1; foreach ($list as $item) {?>
		<div class="region_<?php echo $j;?> regions <?php echo $j==1 ? 'active' : ''  ?>">
			<div class="name">
				Showroom <?php echo $j ?>
			</div>
			<div class="address">
				Địa chỉ: <?php echo $item->address?>
			</div>
			<div class="other">
				<?php if(1==2){ ?>
				<div>
					Kd: <?php echo $item->more_info?>
				</div>
				<div>
					Email: <?php echo $item->email?>
				</div>
				<div>
					Giờ làm việc: <?php echo $item->time_wk?>
				</div>
				<?php } ?>
				<div>
					Điện thoại: <?php echo $item->phone?>
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

				
			</div>
		</div>	
	<?php $j++; }?>

		<div class="regions regions_last">
			<div class="colum_4_it">
				VPGD: <?php echo $config['address'] ?>
			</div>
			<div class="colum_4_it">
				Kho hàng: <?php echo $config['dc_kho_hang'] ?>
			</div>
			<div class="colum_4_it">
				Hotline: <?php echo $config['hotline'] ?>
			</div>
			<div class="colum_4_it">
				Email: <?php echo $config['email'] ?>
			</div>
			<div class="colum_4_it">
				Thời gian làm việc: <?php echo $config['time_work'] ?>
			</div>
		
		</div>	
	</div>
</div>
