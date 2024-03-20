<?php  	global $tmpl;
$tmpl -> addStylesheet('detail_amp','modules/contents/assets/css');
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
            
            <div class='description'>

                <?php 
                $description = $data-> content;
                $description = preg_replace ( '#style\=\"(.*?)\"#is', '', $description );
                $description = preg_replace ( '#style\=\'(.*?)\'#is', '', $description );
                $description = preg_replace ( '#<style>(.*?)</style>#is', '', $description );
                $description = preg_replace ( '#layout\=\"(.*?)\"#is', '', $description );
                $description = preg_replace ( '# h\=\"(.*?)\"#is', '', $description );
                $description = preg_replace ( '# w\=\"(.*?)\"#is', '', $description );
                $description = preg_replace ( '#photoid\=\"(.*?)\"#is', '', $description );
                $description = preg_replace ( '#rel\=\"(.*?)\"#is', '', $description );
                $description = preg_replace ( '#type\=\"(.*?)\"#is', '', $description );
                $description = preg_replace ( '#align\=\"(.*?)\"#is', '', $description );
                $description = preg_replace ( '#longdesc\=\"(.*?)\"#is', '', $description );


                $description = preg_replace ( '#onclick\=\"(.*?)\"#is', '', $description );
                $description = preg_replace ( '#onclick\=\'(.*?)\'#is', '', $description );
                $description = preg_replace ( '#onmouseover\=\"(.*?)\"#is', '', $description );
                $description = preg_replace ( '#onmouseover\=\'(.*?)\'#is', '', $description );
                $description = preg_replace ( '#color\=\'(.*?)\'#is', '', $description );
                $description = preg_replace ( '#color\=\"(.*?)\"#is', '', $description );
                $description = preg_replace ( '#face\=\'(.*?)\'#is', '', $description );
                $description = preg_replace ( '#face\=\"(.*?)\"#is', '', $description );
                $description = preg_replace ( '#frameborder\=\'(.*?)\'#is', '', $description );
                $description = preg_replace ( '#frameborder\=\"(.*?)\"#is', '', $description );
                $description = preg_replace ( '#border\=\'(.*?)\'#is', '', $description );
                $description = preg_replace ( '#border\=\"(.*?)\"#is', '', $description );
                $description = preg_replace ( '#<iframe(.*?)</iframe>#is', '', $description );
                $description = preg_replace ( '#dofollow"(.*?)"#is', '', $description );
                $description = preg_replace ( '#noreferrer="(.*?)"#is', '', $description );
                $description = preg_replace ( '#data-sheets-value(.*?)\"[\s]*>#is', '>', $description );


                $description = str_replace('dofollow=""','',$description);
                $description = str_replace('noopener=""','',$description);
                $description = str_replace('dofollow','',$description);
                $description = str_replace('noopener','',$description);
                $description = str_replace('noreferrer"','',$description);
                $description = str_replace('ch=""','',$description);

                $description = str_replace('<font','<span',$description);
                $description = str_replace('</font','</span',$description);
                $description = str_replace('data-height','height',$description);
                $description = str_replace('data-width','width',$description);
                $description = str_replace('target="null"','',$description);
                $description = str_replace('new=""','',$description);
                $description = str_replace('roman=""','',$description);
                $description = str_replace('times=""','',$description);
                $description = str_replace('Times New Roman";"','',$description);
                $description = str_replace('Times New Roman','',$description);

                 $description = str_replace('!important','',$description);


                $description = $this -> amp_add_size_into_img($description);
                $description = str_replace('<img','<amp-img  layout="responsive"',$description);
                $description = str_replace('</img','</amp-img',$description);

                $description = str_replace('<iframe','<amp-iframe layout="responsive" sandbox="allow-scripts allow-same-origin allow-popups" ',$description);
                $description = str_replace('</iframe','</amp-iframe',$description);
                $description = preg_replace('/[\r\n]+/', '</p><p>', $description) . '</p>';
                $description = html_entity_decode($description);
                echo $description;
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
    
    <input type="hidden" value="<?php echo $data->id; ?>" name='news_id' id='news_id'  />

    <div class="clear"></div>
</div>