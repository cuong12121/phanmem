<?php 
/*
 * Tuan write
 */
    global $tmpl;
    $tmpl->setTitle("Nạp tiền qua tài khoản");
    //$tmpl -> addStylesheet("users_logged","modules/users/assets/css");
    $Itemid = FSInput::get('Itemid',1);
    //$redirect = FSInput::get('redirect');
    
?>  
<div id="login-form" class ="frame_large" >
    <div class="frame_large_head">
        <div class="frame_large_head_l">
            <h1>Nạp tiền qua tài khoản</h1>
        </div>
        <div class="frame_large_head_r">&nbsp;
        </div>
    </div>
    <div class="frame_large_body">
           
            <!--   FRAME COLOR        -->
            <div class='frame_color'>
                <div class='frame_color_t'>
                    <div class='frame_color_t_r'>&nbsp; </div>
                </div>
                <div class='frame_color_m'>
                    <div class='frame_color_m_c'>

                        <?php echo $data; ?>
                    
                   <!--  end CONTENT IN FRAME      -->
           
                    </div>
                </div>
                <div class='frame_color_b'>
                    <div class='frame_color_b_r'>&nbsp; </div>
                </div>
            </div>
            <!--   end FRAME COLOR        -->
            
           
           
        
    </div>
    <div class="frame_large_footer">
        <div class="frame_large_footer_l">&nbsp;</div>
        <div class="frame_large_footer_r">&nbsp;</div>
    </div>
</div>    
        