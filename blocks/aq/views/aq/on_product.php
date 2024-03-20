<?php
global $tmpl,$config; 
$tmpl -> addStylesheet('on_product','blocks/aq/assets/css');
$tmpl -> addScript('on_product','blocks/aq/assets/js');
?>

<div class="title_aq">
  <?php echo FSText::_("Nếu bạn có bất kỳ yêu cầu nào liên quan đến giao hàng, đặt hàng (hủy / trao đổi / hoàn tiền), vui lòng để lại yêu cầu."); ?>
  
</div>
<div class="list_aq_on_products">
  <div class="dhead cls item">
    <div class="col1"><?php echo FSText::_("STT"); ?></div>
    <div class="col2"><?php echo FSText::_("Tiêu đề"); ?></div>
    <div class="col3"><?php echo FSText::_("Người đăng"); ?></div>
    <div class="col4"><?php echo FSText::_("Ngày đăng"); ?></div>
  </div>
  <?php $i=0; foreach ($list as $item) { $i++;?>
    <div class="item" data-id="<?php echo $item-> id; ?>">
      <div class="item_top cls" data-id="<?php echo $item-> id; ?>">
        <div class="col1"><?php echo $i<10?'0'.$i:$i; ?></div>
        <div class="col2"><?php echo $item-> question; ?></div>
        <div class="col3"><?php echo $item-> asker; ?></div>
        <div class="col4"><?php echo date('d/m/Y',strtotime($item -> created_time)); ?></div>
      </div>
      <div class="col5" style="display: <?php echo $i>1?'none':'block';?>;" id="col5_<?php echo $item-> id; ?>"><?php echo $item-> content; ?></div>
    </div>
  <?php } ?>
  <div class="send_question">
    <a href="<?php echo URL_ROOT.FSText::_("gui-cau-hoi.html"); ?>" title="<?php echo FSText::_("Đặt yêu cầu"); ?>" target="_blank"><?php echo FSText::_("Đặt yêu cầu"); ?></a>
  </div>
</div>
