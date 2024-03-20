			<?php
			$point_seo = @$list_point_seo;
			$point_seos = explode(",", $point_seo);
			if($main_keyword) {
				$main_keywords = explode(",", $main_keyword);
				if(!empty($main_keywords)) {
					$i=0;
					foreach ($main_keywords as $keyword) { 
						$class_name = '';
						if(@$point_seos[$i]) {
							if(@$point_seos[$i] >= 80) {
								$class_name  = 'text_success';
							} else if (@$point_seos[$i] >= 50) {
								$class_name  = 'text_warning';
							} else {
								$class_name  = 'text_danger';
							}
						}?>

						<span class="item keyword_item <?php if($i == $stt_active) echo 'item_active';?> <?php echo $class_name; ?>" id="keyword_<?php echo $i; ?>" data-stt="<?php echo $i; ?>" keyword="<?php echo trim($keyword,' ');?>" onclick="click_keyword_item(<?php echo $i; ?>);"><?php echo trim($keyword,' ');?></span>
						<?php $i++; }
					}
				}?>