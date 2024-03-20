<div class="all-wapper-page clearfix">
		<p><span class="blue fsnjg futmc ttu">Tất cả thương hiệu</span> Chọn chữ cái đầu tiên của thương hiệu bạn muốn tìm</p>
		<div class="tabs">
			<ul class="nav nav-tabs">
		        	
		        <?php foreach ($arr_manu_by_key as $key => $item){?>
		        	<li class="<?php echo (!$i)?'active':''; ?>"><a class="blue fsnjg futmc ttu" data-toggle="tab" href="#section_<?php echo $key;?>"><?php echo $key; ?></a></li>
		        	<?php $i++; ?>
		        <?php } ?>
		    </ul>
		    <div class="tab-content ">
		    
			    	<?php foreach ($arr_manu_by_key as $key => $content_item){?>
		        		<div id="section_<?php echo $key;?>" class="tab-pane fade in <?php echo (!$j)?'active':''; ?> clearfix">
		        			<div class="pull-left   futmc blue label ttu">
					    		<?php echo $key ; ?>
					    	</div>
		        			<div class="pull-right ">

			        			 <?php $ii=1; foreach ($content_item as $child){?>
			        			 <?php $manu = $list[$child]; ?>

			        			 <?php  $link_child = FSRoute::_('index.php?module=manufactories&view=manufactory&mcode='.$manu->alias.'&mid='.$manu->id);?>
			        			 	<h3 class="blue <?php echo($ii % 3 == 0 )?'end_row':'' ?>">
			        			 		<a class="blue" href="<?php echo $link_child; ?>" title="<?php echo $manu->name; ?>"><?php echo $manu->name ?></a>
			        			 	</h3>
			        			 	<?php $ii++; ?>
			        			 <?php }?>
		        			 </div>
						</div>	
						<?php $j++; ?>
					<?php } ?>
				
			</div>		        			
		</div>	
	</div>