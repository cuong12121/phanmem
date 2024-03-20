<div class="content-home">
    <?php
    if($list){
    ?>
        <div class="list-module fl">
        <?php
        $tmp = 0;
        foreach($list as $item){
            $tmp++;
            $title = htmlspecialchars($item->name);
        ?>
            <div class="module-item fl">
                <a class="thumb" href="<?php echo $item->link?>" title="<?php echo $title;?>">
                    <span><img alt="<?php echo $title;?>" src="templates/default/images/module/<?php echo $item->image;?>" onerror="templates/default/images/module/no-image.png" /></span>
                </a><!--end: .thumb-->
                <div class="title">
                    <a href="<?php echo $item->link?>" title="<?php echo $title;?>"><?php echo $title;?></a>
                </div>
            </div><!--end: .module-item-->
            <?php if($tmp%3==0){?><div class="clearfix"></div><?php }?>
        <?php
        }//end: foreach($list as $item)
        ?>
        </div><!--end: .list-module-->
    <?php
    }//end: if($list)
    ?>
    <div class="home-info">
        <div class="home-main">
            
            <h3><?=$_SESSION['ad_username'] ?></h3>
            <div class="hi-title">Hệ thống quản lý nội dung (CMS) – Website</div>
        </div><!--end: .home-main-->
    </div><!--end: .home-info-->    
</div><!--end: .content-home-->