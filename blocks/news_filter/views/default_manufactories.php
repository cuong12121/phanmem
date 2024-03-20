<div id='cssmenu'>

   <ul><!-- leve 0 -->
      <li class='active begin'><h2>Danh mục sản phẩm</h2></li>
      <?php foreach ($product_category as $item) { ?> 

     <!--  index.php?module=products&view=cat&ccode=son-dung-moi -->
         <li class='has-sub'>
            <a  href='#' title=""><span><?php echo $item->name ?></span></a>

            <ul><!-- leve 1 -->
               <?php foreach ($category_level1 as $cate_leve1) { ?> 
                   <?php if($cate_leve1-> parent_id ==  $item-> id){ ?>
                  <li class="has-sub">
                     <a href='#' title=""><?php echo $cate_leve1->name ?></a>

                     <ul><!-- leve 2 -->
                        <?php foreach ($category_level2 as $cate_leve2) { ?> 
                           <?php if($cate_leve2-> parent_id ==  $cate_leve1-> id){ ?>
                              <li>
                                 <a href='#' title=""><?php echo $cate_leve2->name ?></a>
                              </li>
                           <?php } ?>
                        <?php } ?>
                     </ul>

                  </li>
                  <?php } ?>
               <?php } ?>
            </ul>
         </li>

     <?php } ?>
   </ul>
</div>