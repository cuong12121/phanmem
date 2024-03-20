<?php
global $tmpl; 
$tmpl -> addStylesheet('newslist_tabs','blocks/newslist/assets/css');
FSFactory::include_class('fsstring');
$Itemid = 4;
$i = 0;$j=0;
?>
<div class="block_content newslist_tabs">
	<ul class="nav nav-tabs">
		<?php 
		foreach ($array_cats as $cat) {
			if(!count($array_news_by_cat[$cat->id])){
				continue;
			}
			?>
			
			 <li class="<?php echo ($i==0)?'active':'';?>"><a data-toggle="tab" href="#section<?php echo $i;?>" title="<?php echo $cat->name;?>"><?php echo $cat->name;?></a></li>
			<?php 
			$i++;
		}
		?>
	</ul>
	<div class="clear"></div>
	<div class="tab-content">
		<?php 
		foreach ($array_cats as $cat) {
			if(!count($array_news_by_cat[$cat->id])){
				continue;
			}
			?>
			<div id="section<?php echo $j;?>" class="tab-pane fade <?php echo ($j==0)?'in active':'';?>">
                	<?php $news = $array_news_by_cat[$cat->id];?>
                	<?php $total = count($news);?>
	                	<?php 	foreach ($news as $new){?>
                			<?php $class = '';?>
			                		<?php $link = FSRoute::_("index.php?module=news&view=news&id=".$new->id."&code=".$new->alias."&ccode=".$new-> category_alias);?>
			                		<?php $w140h105 = URL_ROOT.str_replace('/original/', '/small/',$new -> image);?>
			                			<div class="media-box">
				                			<a class="pull-left" href="<?php echo $link; ?>"><img  onerror="javascript:this.src='<?php echo URL_ROOT?>images/Na90x64.png';" width="95" height="72" alt="<?php echo $new->title?>" src="<?php echo $w140h105; ?>"  /></a>
										  	<div class="media-body">
												<h4 class="media-heading">
													<a href="<?php echo $link; ?>" title="<?php echo $new->title?>"><?php echo get_word_by_length(70,$new->title);?></a>
												</h4>
												<p><?php echo get_word_by_length(70,$new->summary);?></p>
											</div>
											<div class="clear"></div>
										</div>
	                	<?php }?>
               
			</div>
			<?php 
			$j++;
		}
		?>
	</div>
</div>
            		
