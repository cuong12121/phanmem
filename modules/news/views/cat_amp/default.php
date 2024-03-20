<?php
	global $tmpl, $config, $is_mobile;
	$tmpl -> addStylesheet('home_amp','modules/news/assets/css');
	$total_news_list = count($list);
  $Itemid = 7;
	FSFactory::include_class('fsstring');	
?>	

<?php 
  $tmpl -> load_direct_blocks('mainmenu',array('style'=>'submenunew','group'=>'2'));
?>

<div class="news_home news_cat news_page">
	  <h1 class="img-title-cat page_title">
      <span><?php echo $cat -> name; ?></span>
       <?php if(!$is_mobile && 1==2){ ?>
          <?php if($tmpl->count_block('right_page_title')) {?>
            <?php  echo $tmpl -> load_position('right_page_title', 'XHTML'); ?>              
          <?php }?>
        <?php } ?>
    </h1>
    
    <div class="bg_white">
      <?php if($total_news_list){?>
        	<?php include 'default_header.php'; ?>
        	
  	    
	    <div class="news_bottom cls" >
        <div class="news_bottom_l">
          <?php  include 'default_list.php'; ?>

           <div class="clear"></div>
            <?php 
              if($pagination) echo $pagination->showPagination(3);
            ?>
        </div>

        <div class="news_bottom_r right_b">
          <?php if($tmpl->count_block('right_b')) {?>
                  
                <?php  //echo $tmpl -> load_position('right_b', 'XHTML'); ?>              
            
         <?php }?>
         
        </div>
      </div>  
     <?php }else{?>
     	<div><?php echo FSText::_('Không có bài viết nào'); ?></div>
     <?php }?>
     </div>
</div>


