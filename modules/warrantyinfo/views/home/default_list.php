<div class="tesimonials_home">
		<?php 
			$i = 0;
			foreach($list as $item){
				$class='';	
			?>
				<div class="customer cls">
			         <div class="image fl">
				         	<?php if($item -> image){?>
								 <img class="lazy" data-src="<?php echo URL_ROOT.str_replace('/original/','/resized/', $item->image); ?>" alt='<?php echo $item -> name; ?>' />
							<?php }else{?>
								<img class="lazy" data-src="<?php echo URL_ROOT.'images/avatar.jpg'?>" alt='<?php echo $item -> name; ?>' />
							<?php }?>
			         </div>
			         <div class="summary">
			                 <div class="name">
			                 		<?php echo $item->name; ?>
			                 </div>
			                 <div class="description">
			                 	&#8220; <?php echo $item->description;?>&#8221;
			                 </div>
			         </div>
			 </div>
		<?php 
			}
		?>
</div>