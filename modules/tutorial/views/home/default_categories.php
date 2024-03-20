<?php 
	$ii=0;
	$j=0;
	if($total_news_list){
		for($i = 3; $i < $total_news_list; $i ++){
			$news = $news_list[$i];
			$link_news = FSRoute::_("index.php?module=news&view=news&id=".$news->id."&code=".$news->alias."&ccode=".$news-> category_alias."&Itemid=$Itemid");
    
		?>

            
            <?php if( ((!($ii%4) && $i) || !$ii)){?>
				<div class="row">
  			<?php }?>
  				 <?php if($ii%4 ==  0){ ?>
		            <div class="col-l col-lg-8 item-column">
		                <div class="frame-inner">
	    					<a class="img" href="<?php echo $link_news; ?>" >
	    						<img onerror="javascript:this.src='<?php echo URL_ROOT?>images/Na178x135.png';" src="<?php echo URL_ROOT.str_replace('/original/','/resized/', $news->image); ?>" alt="<?php echo htmlspecialchars(@$news->title); ?>" />
	    					</a>
		                    <div class="detail">
		        				<h3 class="item-title" ><a href="<?php echo $link_news; ?>" ><?php echo $news -> title; ?></a></h3>
		        				<span class="datetime"><?php echo date('H:s   d/m/Y',strtotime($news -> created_time)); ?></span>				
		        				<p><?php echo getWord(50,$news -> summary);?></p>
		    			    </div>
		    			    <div class="clear"></div> 
		                </div>
		            </div>
		            <?php }else{?>
			            <?php if( ((!($j%3) && $j) || !$j)){?>
			            	 <div class="sepa"></div>
							 <div class="col-r col-lg-4 item-column">
							 	<ul class="frame-inner">
			  			<?php }?>
			            			<li><a href="<?php echo $link_news; ?>" ><?php echo $news -> title; ?></a></li>
			           <?php if(!(($j+1)%3) || (($j+1) == $total_news_list)){?>
				        		</ul>
				        	</div>
				       <?php }?>
		           <?php $j++; }?>
				        
             <?php if(!(($ii+1)%4) || (($ii+1) == $total_news_list)){?>
	        	</div>
	        <?php }?>
	<?php 
		$ii++;
		}
	}
	?>
    