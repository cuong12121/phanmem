<div class="new_cat wapper-page  wapper-page-cat">
	    <div class="wapper-content-page">
			<?php 
			if($total_news_list){
				for($i = 0; $i < 4; $i ++){
					$news = $news_list[$i];
					$link_news = FSRoute::_("index.php?module=news&view=news&id=".$news->id."&code=".$news->alias."&ccode=".$news-> category_alias."&Itemid=$Itemid");
			?>
    			<?php if($i == 0){ ?>
                <div class="cat-item">
                    <div class="frame_img_news">
        				<?php if($news->image){?>
        					<a href="<?php echo $link_news; ?>" >
        						<img width="290" height="220" src="<?php echo URL_ROOT.str_replace('/original/','/resized/', $news->image); ?>" alt="<?php echo htmlspecialchars(@$news->title); ?>" />
        					</a>
        				<?php }?>
                        <div class="cat_title">
            				<h3><a href="<?php echo $link_news; ?>" ><?php echo $news -> title; ?></a></h3>
            				<span><?php echo date('H:s   d/m/Y',strtotime($news -> created_time)); ?></span>				
            				<p><?php echo getWord(50,$news -> summary);?></p>
        			    </div> 
                    </div>
                </div>
                <?php }?>
                <?php if($i != 0){ ?>
                    <div class="cat-orther">
                    <?php if($news->image){?>
    					<a class="orther-img" href="<?php echo $link_news; ?>" >
    						<img width="90" height="67" src="<?php echo URL_ROOT.str_replace('/original/','/resized/', $news->image); ?>" alt="<?php echo htmlspecialchars(@$news->title); ?>" />
    					</a>
    				<?php }?>
    				    <a class="orther-title" href="<?php echo $link_news; ?>" ><?php echo $news -> title; ?></a>   
                    </div>      
                <?php }?>
			<?php 
				}
				if($pagination) echo $pagination->showPagination(3);
			};
			?>
			<div class='clearfix'></div>
		</div>	
	</div>