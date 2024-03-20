<div class="albums_home cls">
	<?php 
	foreach($list as $item){ ?>
		<div class="item-b" data-id = "<?php if(!empty($array_items[$item->id])){ echo $item->id; }?>">
			<img src="<?php echo URL_ROOT.str_replace('/original/','/large/', $item->image); ?>" alt='<?php echo $item -> title; ?>' />
			<div class="title"><?php echo $item->title ?></div>
			<div class="date"><?php echo date('d/m/Y',strtotime($item -> created_time)); ?></div>
		</div>

		<?php if(!empty($array_items[$item->id]) && count($array_items[$item->id]) > 1 ){ ?>
		<div class="pav-slideShow pav-slideShow-<?php echo $item->id ?>">
			<div class="title-cat">
				<?php //echo $item->title ?>
			</div>
			<div class="close">
				<svg width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"  x="0px" y="0px" viewBox="0 0 512.001 512.001" style="enable-background:new 0 0 512.001 512.001;" xml:space="preserve">
				<g>
					<g>
						<path d="M284.286,256.002L506.143,34.144c7.811-7.811,7.811-20.475,0-28.285c-7.811-7.81-20.475-7.811-28.285,0L256,227.717    L34.143,5.859c-7.811-7.811-20.475-7.811-28.285,0c-7.81,7.811-7.811,20.475,0,28.285l221.857,221.857L5.858,477.859    c-7.811,7.811-7.811,20.475,0,28.285c3.905,3.905,9.024,5.857,14.143,5.857c5.119,0,10.237-1.952,14.143-5.857L256,284.287    l221.857,221.857c3.905,3.905,9.024,5.857,14.143,5.857s10.237-1.952,14.143-5.857c7.811-7.811,7.811-20.475,0-28.285    L284.286,256.002z"/>
					</g>
				</g>
				</svg>
			</div>
			<div class="owl-carousel fs-slider">
				<?php $i = 0; ?>
				<?php foreach($array_items[$item->id] as $it){?>
					<div class="item">	
						<?php echo set_image_webp($it->image,'compress',str_replace('<br>','',$it->title),'',0,''); ?>
					</div>
					<?php $i ++; ?>
				<?php }?>
			</div>

			<?php if(1==2){ ?>
			<div class='thumbs'>
				<div class="sync2"  >
					<?php foreach($array_items[$item->id] as $it){?>	
						<div class="item hide">	
							<?php echo set_image_webp($it->image,'small',str_replace('<br>','',$it->title),'',0,''); ?>
						</div>
					<?php }?>
				</div>
			</div>
			<?php } ?>
		</div>

		<input type="hidden" class="count_item_slideshow" value="<?php echo count($array_items[$item->id]); ?>">
		<?php }elseif(!empty($array_items[$item->id])) { ?>
		<div class="pav-slideShow pav-slideShow-<?php echo $item->id ?>">
			<div class="title-cat">
				<?php echo $item->title ?>
			</div>
			<div class="close">
				<svg width="30px" height="30px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"  x="0px" y="0px" viewBox="0 0 512.001 512.001" style="enable-background:new 0 0 512.001 512.001;" xml:space="preserve">
				<g>
					<g>
						<path d="M284.286,256.002L506.143,34.144c7.811-7.811,7.811-20.475,0-28.285c-7.811-7.81-20.475-7.811-28.285,0L256,227.717    L34.143,5.859c-7.811-7.811-20.475-7.811-28.285,0c-7.81,7.811-7.811,20.475,0,28.285l221.857,221.857L5.858,477.859    c-7.811,7.811-7.811,20.475,0,28.285c3.905,3.905,9.024,5.857,14.143,5.857c5.119,0,10.237-1.952,14.143-5.857L256,284.287    l221.857,221.857c3.905,3.905,9.024,5.857,14.143,5.857s10.237-1.952,14.143-5.857c7.811-7.811,7.811-20.475,0-28.285    L284.286,256.002z"/>
					</g>
				</g>
				</svg>
			</div>
		
				<?php foreach($array_items[$item->id] as $it){?>
					<div class="item">	
						<?php echo set_image_webp($it->image,'large',str_replace('<br>','',$it->title),'',0,''); ?>
					</div>
					<?php $i ++; ?>
				<?php }?>
			

			
		</div>

		<input type="hidden" class="count_item_slideshow" value="<?php echo count($array_items[$item->id]); ?>">	
		<?php } ?>
	<?php } ?>
</div>

