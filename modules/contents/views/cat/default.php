<?php
	global $tmpl;
	$tmpl -> addStylesheet('cat','modules/contents/assets/css');
	$tmpl -> addScript('cat','modules/contents/assets/js');

	$total_list = count($list);
        $Itemid = 7;
	$class = '';	
?>	




	<?php  	global $tmpl;
$tmpl -> addStylesheet('detail','modules/contents/assets/css');
$tmpl -> addScript('mb-menu','blocks/aq_menu/assets/js');
FSFactory::include_class('fsstring');

$print = FSInput::get('print',0);
?>

<div class="wrapper_news_home cf">
    <?php echo $tmpl -> load_direct_blocks('banners',array('style'=>'default','category_id'=>53)); ?>
    <div class="news_home_right">
         <?php if($tmpl->count_block('right')) {
                               ?>
                                   <?php  echo $tmpl -> load_position('right','type3Block'); ?>
                           <?php }?>
    </div>
    <div class="news_home_left">
		<div class="bt-menu-ct-mb">
			<span></span>
			<span></span>
			<span></span>
		</div>
		<div class="menu-ct-mb">
		
		<?php echo $tmpl -> load_direct_blocks('aq_menu',array('category_id'=>'20')); ?>
		</div>
        <div class="news_detail ">
		<!-- NEWS NAME-->	
		<h1 class='content_title'>
			<span><?php 	echo $cat->name;?></span>
		</h1>
	        <div class="clear"></div>
	            <div class='description cf'>
	                    <?php 
		if($cat_sub){
			$i=1;

			foreach ($cat_sub as $item) {
				$link = FSRoute::_("index.php?module=contents&view=contents&id=".$item->id."&code=".$item->alias."&ccode=".$item->category_alias."&Itemid=$Itemid");
		?>
		<div class="item-cat <?php if($i==1) echo 'item-ac'; ?>">
			<div class="title-cat">
				<?php echo romanic_number($i).' - '.$item->name; ?>
				<a href="javascript:void(0)" title="" class="view-plus"></a>
			</div>
			<div class="list-question">
				<?php 
					$j=1;
					foreach ($list as $item_sub) {
						if($item_sub->category_id==$item->id){

						?>
						<div class="item-question <?php if($i==1 && $j==1) echo 'title-ac'; ?>">
							<div class="title-question">
								<?php echo $item_sub->title; ?>
							</div>
							<div class="reply-question reply-question-<?php echo $j; ?>">
								<?php echo $item_sub->content; ?>
							</div>
						</div>
						<?php
						$j++;
						}
					}
				 ?>
			</div>
		</div>
		
		<?php 
		$i++;
			}
			//if($pagination) echo $pagination->showPagination(3);
		} else {
			echo FSText::_('Không có bài viết nào trong chuyên mục')." : <strong>".$cat->name."</strong>";
		 }
		?>
	            </div>
	    </div>
    </div>
    
</div>
