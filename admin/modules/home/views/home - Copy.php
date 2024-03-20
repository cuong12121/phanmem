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
            <div class="hi-title">Hệ thống quản lý nội dung (CMS) – Website <strong><?php echo $site_name;?></strong></div>
            <div>
                <table>
                    <tr class="title">
                        <td class="label">Tên miền</td>
                        <td><a target="_blank" href="<?php echo 'http://'.$_SERVER['HTTP_HOST'];?>"><?php echo $_SERVER['SERVER_NAME'];?></a></td>
                    </tr>
                    <tr>
                        <td class="label">IP Host</td>
                        <td><?php echo $_SERVER['REMOTE_ADDR'];?></td>
                    </tr>
                    <tr>
                        <td class="label">Tài khoản đăng nhập</td>
                        <td><?php echo $_SESSION['ad_username']; ?></td>
                    </tr>
                    <tr>
                        <td class="label">Email</td>
                        <td><?php echo $_SESSION['ad_useremail']; ?></td>
                    </tr>
                </table>
            </div>
        </div><!--end: .home-main-->
    </div><!--end: .home-info-->    
</div><!--end: .content-home-->