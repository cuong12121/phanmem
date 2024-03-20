<?php
global $tmpl,$config; 
	$tmpl -> addStylesheet('hexagon','blocks/strengths/assets/css');
	FSFactory::include_class('fsstring');
	?>
<div class='strengths_block cls block_body'>



	<ul>	
		<?php foreach($list as $item){ ?>
		<li>
			<div class="img_and_content">
					<div class="img">
						<a href="#" class="a_img" title="Thiết kế web đẹp và hiệu quả">
							<div class="svg-container service-icon-svg"	>
								<svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 80 70">
									<g transform="translate(0,-982.3622)">
										<path d="m 41.863512,49.0007 -35.2397037,-2e-6 -17.6198503,-30.51848 17.6198533,-30.518478 35.2397037,2e-6 17.619851,30.518479 z" transform="matrix(1.1191385,0,0,1.1284347,12.867983,996.50622)"></path>
									</g>
								</svg>
								<i class="fa fa-<?php echo trim($item -> icon); ?>"></i>
							</div>
								<span><?php echo $item -> title; ?></span>			
								<div><?php echo $item -> summary; ?></div>
						</a>
								 
					</div>

			

			</div>
		</li>
	<?php } ?>
	</ul>
</div>
	