<?php global $is_mobile; ?>
<?php if(1==1){?>
  <?php include 'default_tags.php'; ?>
  <div class="tab-title cls tab-title_description" >
    <h3><span>Điểm nổi bật <span title="tt_main_color"><?php echo !$is_mobile?$data-> name: ' sản phấm';?></span></span></h3>
  </div>
<?php }?>
<?php if($data-> description){ ?>
  <div class='product_tab_content' id="c_tabs_description">
    <div id="prodetails_tab1" class="prodetails_tab prodetails_tab_content">
     <div class=''>
      <div class='description boxdesc'  id="boxdesc">
                <div class="model_text description">
          <?php echo $data-> model_text; ?>
        </div>
       <div id="box_conten_linfo">
        <div class="box_conten_linfo_inner" itemprop="description">
          <?php 
          $description_new = '';
          $description = $data-> description;
          $description = add_content_webp($description);
          ?>
          <?php if($description) echo $description; else echo "Sản phẩm"?>
        </div>
      </div>
      <?php if($description){ ?>
        <div class="readmore " id="readmore_desc" onclick="open_popup_content(2)"><span class="closed">Xem thêm<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 494.148 494.148" style="enable-background:new 0 0 494.148 494.148;" xml:space="preserve">
          <g>
            <g>
              <path d="M405.284,201.188L130.804,13.28C118.128,4.596,105.356,0,94.74,0C74.216,0,61.52,16.472,61.52,44.044v406.124    c0,27.54,12.68,43.98,33.156,43.98c10.632,0,23.2-4.6,35.904-13.308l274.608-187.904c17.66-12.104,27.44-28.392,27.44-45.884    C432.632,229.572,422.964,213.288,405.284,201.188z"/>
            </g>
          </g>
        </svg></span></div>
        <div class="readmore hide" id="readany_desc"><span class="closed">Rút gọn</span></div>
      <?php } ?>

    </div>
  </div>
</div>

</div>
<?php }else{ ?>
 <div class='product_tab_content' id="c_tabs_description">
  <?php 
  echo "Đang cập nhập"; ?>
</div>
<?php }?>


