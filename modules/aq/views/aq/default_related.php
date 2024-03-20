<!--	RELATE CONTENT		-->
<?php
	if($category -> display_related){
		$total_content_relate = count($relate_aq_list);
		if($total_content_relate){
		echo '<div class="aq-related">';
		echo '<h3 class="relate_title">'.FSText::_('Câu hỏi khác').'</h3>';
			for($i = 0; $i < $total_content_relate; $i ++){
				$item = $relate_aq_list[$i];
				$link_aq = FSRoute::_("index.php?module=aq&view=aq&code=".$item->alias."&id=".$item->id."&Itemid=$Itemid");
			?>
			
			<?php $link = FSRoute::_("index.php?module=aq&view=aq&id=".$item->id."&code=".$item->alias);    ?>
<div class="item">
  <div class="aq_title">
  	<span class="icon_ap"></span>
	<a href="<?php echo $link; ?>" title="<?php echo htmlspecialchars(@$item->title); ?>"><?php echo $item->title; ?></a>
	</div>
  <?php if($item -> asker){ ?>
    <div class='item-asker'>  <?php echo $item->asker; ?> 
      <?php if($item -> email){ ?>
        - <span class="email">(<?php echo '***'.substr($item -> email, 3); ?>)</span>

      <?php } ?>
    </div>
  <?php } ?>
	<div class='item-content'>	<?php echo $item->question; ?>	</div>
  <div class='item-readmore'> <a href="<?php echo $link; ?>" title="<?php echo htmlspecialchars(@$item->title); ?>"><?php echo FSText::_('Xem trả lời'); ?> <i class="fa fa-angle-double-right"></i></a>  </div>
</div>

			<?php
			}
		echo '</div>';
		}
	}
?>
<!--	end RELATE CONTENT		-->