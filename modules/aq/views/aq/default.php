<?php  	global $tmpl;
$tmpl -> addStylesheet('aq_detail','modules/aq/assets/css');

$tmpl -> addScript('form');
$tmpl -> addScript('main');
//$tmpl -> addScript('aq_detail','modules/aq/assets/js');
FSFactory::include_class('fsstring');

$print = FSInput::get('print',0);
?>
<div class="aq_detail wapper-page wapper-page-detail">

	<div class="page_head">
	 	<h1 class="home_title">

	     	<span><?php	echo $data -> title; ?> </span>
	    </h1>
    	<a href="<?php echo FSRoute::_('index.php?module=aq&view=aq&task=send_question'); ?>" class="send_requirement"><?php echo FSText::_('Gửi câu hỏi'); ?>i</a>
	    <div class="clear"></div>
    </div>
	    
	<!-- DATETIME -->
	<?php if($data -> asker){ ?>
    <div class='item-asker'><?php echo FSText::_('Gửi bởi'); ?>:  <?php echo $data->asker; ?> 
      <?php if($data -> email){ ?>
        - <span class="email">(<?php echo '***'.substr($data -> email, 3); ?>)</span>

      <?php } ?>
    </div>
  <?php } ?>

	
	<!-- end DATETIME-->
		
		<!-- SUMMARY -->
	<div class='question'>
		<?php   echo $data -> question; ?>
	</div>
	<div class="reply-label"><?php echo FSText::_('Trả lời'); ?></div>
	<div class='description'>
		<?php   echo $data -> content; ?>
	</div>
	<br />
	<?php  //include PATH_BASE.'modules/aq/views/common/send_request.php';?>
	<?php echo $tmpl -> load_direct_blocks('aq',array('style'=>'form_question')); ?>
	<!--	RELATED	-->
	<?php include_once 'default_related.php'; ?>
				
</div>
