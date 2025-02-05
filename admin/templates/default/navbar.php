<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0; background: var(--main-color); border: 0;">
    <div class="navbar-header">
        <div class="logo">
            <a class="navbar-brand" href="<?php echo URL_ADMIN; ?>" title="CMS Admin - Delectech">
                <!-- <h4 style="color:#fff">Thông báo: Bảo trì phần mềm lúc 20h45 </h4> -->
                <img src="<?php echo URL_ADMIN; ?>templates/default/images/logo_ttp.png" />
            </a>
        </div>
        <!-- <button type="button" class="navbar-toggle">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar" style="background: #fff;"></span>
            <span class="icon-bar" style="background: #fff;"></span>
            <span class="icon-bar" style="background: #fff;"></span>
        </button> -->
    </div>
    
    <style>
        .form-horizontal {
/*            height: 700px;*/
            overflow-y: auto;
        }

        /* body .navbar-header .logo {
            width: 400px;
            height: 63px;
            /*float: left;*/
            /*text-align: center;*/
            /*background: #313e4b;*/
        }*/
    </style>
    <!-- /.navbar-header -->

    <?php 
        global $db;

            $sql = "SELECT *
            FROM fs_users
            WHERE id = ".$_SESSION['ad_userid'];;
            global $db;
            $db->query ( $sql );
            $user = $db->getObject();

            $noti = 0;
            if($user->view_noti_id){
                $noti = $user->view_noti_id;
            }

        
            $sql = "SELECT id
            FROM fs_messages
            WHERE id > ".$noti;
            global $db;
            $db->query ( $sql );
            $notis = $db->getObjectList();
    ?>

    <ul class="nav navbar-top-links navbar-right">
        <li>
            <a class="dropdown-toggle add-menu-product"  href="<?php echo URL_ADMIN.'users/messages' ?>">
            <i class="fa fa-bell-o  fa-fw" style="font-size: 22px;line-height: 10px;transform: translate(0px, 1px);"></i> Thông báo <?php echo !empty($notis) ? "(".count($notis).")" : "" ?>
            </a>
        </li>
        <li class="dropdown">
        <a class="dropdown-toggle add-menu-product" data-toggle="dropdown" href="#">
            <i class="fa fa-plus-circle  fa-fw" style="font-size: 22px;line-height: 10px;transform: translate(0px, 1px);"></i> Thêm mới <i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-add dropdown-user">
            <?php 
            global $db;
            $sql = "SELECT *
            FROM fs_menus_admin_add
            WHERE published = 1 ORDER BY ordering ASC";
            global $db;
            $db->query ( $sql );
            $list_menu_add = $db->getObjectList();

            foreach ($list_menu_add  as $item_add) { ?>
              <li><a href="<?php echo FSRoute::_($item_add-> link); ?>"><i class="<?php echo $item_add-> icon; ?>" style="font-size: 15px;"></i><?php echo $item_add-> name; ?> </a></li>
            <?php } ?>
        </ul>
        </li>
    <!-- /.dropdown -->
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa fa-user fa-fw" style="font-size: 22px;line-height: 10px;transform: translate(0px, 1px);"></i>  <?php echo @$_SESSION['ad_username']; ?>&nbsp; <i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-user">
            <!-- <li><a href="<?php echo URL_ROOT; ?>" target="_blank"><i class="fa fa-home fa-3x fa-fw" style="font-size: 15px;"></i> Website</a></li> -->
            <!-- <li><a href="index.php?module=members2&view=members&task=edit"><i class="fa fa-cog fa-3x fa-fw" style="font-size: 15px;"></i> Sửa thông tin</a></li>
            <li><a href="index.php?module=members2&view=members&task=changepass"><i class="fa fa-refresh" style="font-size: 15px;"></i>Đổi mật khẩu</a></li> -->
            <li><a href="<?php echo URL_ROOT.'admin/index.php?module=users&view=log&task=logout' ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
        </ul>
        <!-- /.dropdown-user -->
    </li>
    <!-- /.dropdown -->
</ul>
<div class="clearfix"></div>
<!-- <div class="lang"> -->
    <?php
    $language = $_SESSION['ad_lang'];
    $url_current  = $_SERVER['REQUEST_URI'];
    $sort_admin = $_SERVER['SCRIPT_NAME'];
    $sort_admin = str_replace('/index.php','',$sort_admin);
    $pos = strripos($sort_admin,'/');
    $sort_admin = substr($sort_admin,($pos+1));
    $url_current = substr($url_current,strlen(URL_ROOT_REDUCE));
    $url_current =  trim(preg_replace('/[&?]ad_lang=[a-z]+/i', '', $url_current));

//                      echo $url_current;
    function create_url_for_lang($url,$lang,$sort_admin){
        if(!$url)
            return URL_ROOT.$sort_admin.'/index.php?ad_lang='.$lang;
        if(strpos($url, 'index.php') === false)
            return URL_ROOT.$sort_admin.'/index.php?ad_lang='.$lang;
        if(substr($url,-9) == 'index.php')
            return URL_ROOT.$sort_admin.'/index.php?ad_lang='.$lang;
        if($url == 'index.php')
            return URL_ROOT.$sort_admin.'index.php?ad_lang='.$lang;
        return URL_ROOT.$url.'&ad_lang='.$lang;
    }
    $lang_arr = array('en'=>'English','vi'=>'Viet Nam');
    foreach ($lang_arr as $key => $value){
        $class = $key;
        $class .= ($key == $language)?' current ':'';
                            // echo "<a href='". create_url_for_lang($url_current,$key,$sort_admin)."' class='".$class."' title='".$value."' ><img src='".URL_ROOT.$folder_admin.'/templates/default/images/'.$key.".jpg' alt='".$value."' /></a>";
    }
    ?>

    <!-- </div>end: .lang -->

    <!-- /.navbar-top-links -->
    <!-- <div class="full_screen"></div> -->

    <!-- /.navbar-static-side -->
</nav>
<div class="clear"></div>
<div class="navbar-default sidebar <?php if($module != 'home') echo 'navbar-small'; ?>" role="navigation">
    <div class="box-menu-admin" >
        <?php require('modules/menus/admin.php');?>
    </div>
    <!-- /.sidebar-collapse -->
</div>
