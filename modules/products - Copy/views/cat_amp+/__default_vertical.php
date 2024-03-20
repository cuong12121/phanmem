<div class='vertical' id="vertical">
			<?php 
				$page =FSInput::get('page',0,'int');
				global $tmpl,$config; 
				$j = 0; 
				$total = count($list_new);
				$total_row_lg =(int)($total/6);
				$class='';
			?>
   	 	
			<?php foreach($list_new as $key=>$item){
		
			
				$discount ='';		
				if($item -> is_hotdeal){
					if($item -> date_end >  date('Y-m-d H:i:s') && $item->date_start <  date('Y-m-d H:i:s')){
						$price = $item->price;
						$price_old = $item->price_old;
					}else{
						$price = $item->price_old;
						$price_old = '';
					}
				}else{
					$price= $item->price;
					$price_old = $item->price_old;
				}
				 $link = FSRoute::_('index.php?module='.$this -> module.'&view=product&code='.$item->alias.'&id='.$item -> id.'&ccode='.$item->category_alias.'&Itemid=5');
		        ?>
				<?php if($item -> published_double == 1 && ($key+1)%6 != 0){?>
						<div class="item w2  <?php echo $class;?> hidden-xs  hidden-sm hidden-md ">
							<a href="<?php echo $link; ?>" title = "<?php echo $item -> name ; ?>" >
								<img class="img-responsive" src="<?php echo URL_ROOT.str_replace('/original/', '/resized/', $item->image_double); ?>" alt="<?php echo htmlspecialchars ($item -> name); ?>"  />
							</a>
							<div class="media-body ">
                            	<div class="frame_title">
									<h2 class="name" ><a href="<?php echo $link; ?>" title = "<?php echo $item -> name ; ?>" ><?php echo get_word_by_length(26,$item -> name); ?></a> </h2>	
			                	</div>
			                	<div class="frame_price">
			                		<span class="price "> 
                           				<?php echo format_money($price,'đ'); ?>
		                            </span>
		                            <span class="price_old"> 
		                            	<?php if($item-> discount ){?>
		                            		<?php echo ($price_old)?format_money($price_old,'đ'):''; ?>
		                            	<?php }?>	
		                            </span>
	                       		</div>
	                         </div>
                       	</div>
                        <div class="item <?php echo $class;?> visible-xs visible-sm  visible-md">
                			<div class="frame_inner">
	                            <div class="frame_img_cat ">
	                                <a href="<?php echo $link; ?>" title = "<?php echo $item -> name ; ?>" >
	                                		<img class="img-responsive" src="<?php echo URL_ROOT.str_replace('/original/', '/resized/', $item->image); ?>" alt="<?php echo htmlspecialchars ($item -> name); ?>"  />
	                                </a>
	                            </div>
	                            <div class="frame_title">
									 <h2 class="name" ><a href="<?php echo $link; ?>" title = "<?php echo $item -> name ; ?>" ><?php echo get_word_by_length(26,$item -> name); ?></a> </h2>	
	                    		</div>
	                    		<div class="frame_price">
	                           		<span class="price "> 
			                           			<?php echo format_money($price,'đ'); ?>
		                            </span>
		                            <span class="price_old"> 
		                            	<?php if($item-> discount ){?>
		                            		<?php echo ($price_old)?format_money($price_old,'đ'):''; ?>
		                            	<?php }?>	
		                            </span>
	                       		</div>
                            </div>   
                		</div>
					<?php }else{?>
                		<div class="item <?php echo $class;?>">
                			<div class="frame_inner">
	                            <div class="frame_img_cat ">
	                                <a href="<?php echo $link; ?>" title = "<?php echo $item -> name ; ?>" >
	                                		<img class="img-responsive" src="<?php echo URL_ROOT.str_replace('/original/', '/resized/', $item->image); ?>" alt="<?php echo htmlspecialchars ($item -> name); ?>"  />
	                                </a>
	                            </div>
	                            <div class="frame_title">
									 <h2 class="name" ><a href="<?php echo $link; ?>" title = "<?php echo $item -> name ; ?>" ><?php echo get_word_by_length(26,$item -> name); ?></a> </h2>	
	                    		</div>
	                    		<div class="frame_price">
	                           		<span class="price "> 
			                           			<?php echo format_money($price,'đ'); ?>
		                            </span>
		                            <span class="price_old"> 
		                            	<?php if($item-> discount ){?>
		                            		<?php echo ($price_old)?format_money($price_old,'đ'):''; ?>
		                            	<?php }?>	
		                            </span>
	                       		</div>
                            </div>  
                		</div>
				    <?php }?>
			<?php }//end: foreach($list as $item) ?>
			  <div class="clearfix"></div>
</div><!--end: .vertical-->
<div id="append"></div>
<?php if($pagination) echo $pagination->showPagination(3);?>
<input type="hidden" value="<?php echo $page?>" id="page" name="page">