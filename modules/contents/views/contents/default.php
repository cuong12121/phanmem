<?php  	global $tmpl;
$tmpl -> addStylesheet('detail','modules/contents/assets/css');
FSFactory::include_class('fsstring');
$print = FSInput::get('print',0);
?>

<div class="detail_page_top">
    <div class="">
        <div class="news_detail ">
            <!-- NEWS NAME-->   
            <h1 class='title' >
                <?php   echo $data -> title; ?>
            </h1>
            <?php if($data -> summary){?>
                <div class="summary"><?php echo $data -> summary; ?></div>
            <?php }?>
            
            <div class='description' >    
                <?php 
                    // insert quảng cáo
                    
                        echo $data -> content;          
                ?>
            </div>
                          
            <br />
            <!--    TAGS    -->
                <?php include_once 'default_tags.php'; ?>
           
            <!--    RELATED -->
            
                <div class="mbl tab_content_right">
                </div>
            
        </div>
    </div>
<!--     <div class="detail_page_r">
        <?php if ($tmpl->count_block('right_b')) { ?>
             <?php echo $tmpl->load_position('right_b'); ?>
        <?php } ?>
        
    </div> -->
    <input type="hidden" value="<?php echo $data->id; ?>" name='news_id' id='news_id'  />

    <div class="clear"></div>
</div>