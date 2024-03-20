<?php
global $tmpl; 
$tmpl -> addStylesheet('column2','blocks/newslist/assets/css');
?>

<a href="<?php echo URL_ROOT.'tin-tuc.html' ?>" title = "<?php echo $title; ?>" class="block_title">
    <?php echo $title; ?>
</a>


<?php if(1==2){?>
<div class="cat-viewmore">
    <div class="cats">
        <?php foreach ($list_cats as $item_cat) {
            $link_cat = FSRoute::_('index.php?module=news&view=cat&ccode='.$item_cat->alias.'&cid='.$item_cat->id);
        ?>
            <a href="<?php echo $link_cat; ?>" title="<?php echo $item_cat->name ?>"><?php echo $item_cat->name ?></a>

        <?php } ?>
             <a href="<?php echo $link_more; ?>" title="Xem thêm">Xem thêm ›</a>
    </div>
</div>

<div class="clear"></div>
<?php }?>
<div class='news_list_body cls '>
	<?php 
		$Itemid = 4;
		for($i = 0; $i < count($list); $i ++ ){
			$item = $list[$i];
			$link = FSRoute::_("index.php?module=news&view=news&id=".$item->id."&code=".$item->alias."&ccode=".$item-> category_alias."&Itemid=$Itemid");			
			?>
			<div class='news-item'>
                <div class="img">
                    <a href='<?php echo $link;?>' title="<?php echo $item->title;?>">
                        <?php echo set_image_webp($item->image,'resized',$item->title,' lazy',1,'',0); ?>
                       
                    </a>
                
                </div>
                <div class="box_content_new">
                    <div class="title">
                        <a href='<?php echo $link;?>' title="<?php echo $item->title;?>"><?php echo get_word_by_length(80,$item->title);?>
                        </a> 
                    </div>
                    <div class="summary">
                     <?php echo get_word_by_length(110,$item->summary);?>
                    </div>
                </div>	
                <?php if(1==2){?>
                    <div class="date-create">
                        <?php if(!empty($authors[$item-> author_id])){ ?>
                            <div class="create">
                                <?php echo $authors[$item-> author_id]->name ; ?>
                            </div>
                        <?php }else{ ?>
                            <div class="create">Admin</div>
                        <?php } ?>
                        
                        <div class="date"><?php echo date('d/m/Y',strtotime($item -> created_time)); ?></div>
                    </div>
                <?php }?>
            </div>   
	<?php }	?>
    <div class="clear"></div>
    <div class="view_all">
        <a href="<?php echo URL_ROOT.'tin-tuc.html' ?>" title = "Xem thêm <?php echo $title; ?>" class="">
            Xem tất cả
        </a>
    </div>
</div>



    