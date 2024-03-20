<div class="row">
			<?php 
			if($total_news_list){
				for($i = 0; $i < 4 && $i < $total_news_list; $i ++){
					$news = @$news_list[$i];
					$link_news = FSRoute::_("index.php?module=news&view=news&id=".@$news->id."&code=".@$news->alias."&ccode=".@$news-> category_alias."&Itemid=$Itemid");
			?>
    			<?php if($i == 0){ ?>
                <div class="col-lg-8 item-column column-l">
                    <div class="inner-item">
                    	<div>
        					<a href="<?php echo $link_news; ?>" >
        						<img class="img-responsive" onerror="javascript:this.src='<?php echo URL_ROOT?>images/Na290x220.png';" src="<?php echo URL_ROOT.str_replace('/original/','/large/', $news->image); ?>" alt="<?php echo htmlspecialchars(@$news->title); ?>" />
        					</a>
        				</div>
                        <div class="frame_title">
            				<h3><a  href="<?php echo $link_news; ?>" ><?php echo $news -> title; ?></a></h3>
            				<span class="date_time"><?php echo date('H:s   d/m/Y',strtotime($news -> created_time)); ?></span>				
            				<p class="summary"><?php echo getWord(50,$news -> summary);?></p>
        			    </div>
        			    <div class="clear"> </div>  
                    </div>
                </div>
                <?php }?>
                <?php if($i != 0){ ?>
                    <div class="col-lg-4 item-column column-r">
                   	 	<div class="frame_img">
	    					<a  href="<?php echo $link_news; ?>" >
	    						<img onerror="javascript:this.src='<?php echo URL_ROOT?>images/Na90x64.png';" src="<?php echo URL_ROOT.str_replace('/original/','/small/', $news->image); ?>" alt="<?php echo htmlspecialchars(@$news->title); ?>" />
	    					</a>
    					</div>
    					<div class="frame_title">
    				   	 <a  href="<?php echo $link_news; ?>" ><?php echo @$news -> title; ?></a>   
    				    </div>
    				     <div class="clear">  </div>  
                    </div>      
                <?php }?>
			<?php 
				}
				
			}
			?>
		</div>	
