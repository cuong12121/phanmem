<?php 
    //print_r($_REQUEST);
    global $tmpl;
    $tmpl-> setTitle("Thành viên");
    $tmpl -> addStylesheet("users_info","modules/users/assets/css");
    $tmpl -> addScript('form');
    $tmpl -> addScript('users_info','modules/users/assets/js');
    $tmpl -> addStylesheet("favourites","modules/products/assets/css");
    $Itemid = FSInput::get('Itemid',1);
?>  
<div class="title-product-hot">
	<!-- <div class="img-title-cate">
	   <h1><?php echo $data->username;?></h1>
	</div> -->
</div>
<div class="clear"></div>       
</div>
<div class="wapper-content-page">    
    <!--   
	<div class="users-tab-title">
        <div class="center">
            <span class="center_name"><?php echo $data->username;?></span>
        	<div class='users_tabs'>
                <div id='tab1' class='activated users_tabs_name'><span>Thông tin cá nhân</span></div>
                <div id='tab5' class="users_tabs_name"><span>Đổi mật khẩu</span></div>
                <li id='tab2'><span>Sản phẩm quan tâm</span></li>
                <div id='tab3' class="users_tabs_name"><span>Lịch sử giao dịch</span></div>
                <li id='tab4'><span>Hạng thành viên</span></li>
               <li id='tab6'><span>Thư từ BQT</span></li>
            </div>
        </div>
    
        <div class='users_tab_content'>
        <div id='tab1_content' class='tab_content selected'>
            
        </div>
    </div>
    </div>   
    --> 
    <div class="clear"></div>
    
</div>

