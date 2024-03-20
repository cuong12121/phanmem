<?php 
    global $tmpl;
    $tmpl->setTitle("Trang quản trị");
    $tmpl -> addStylesheet("users_logged","modules/users/assets/css");
    $tmpl -> addScript('users_logged','modules/users/assets/js');
    
?>  
<div id="login-form" class ="frame_large mt40" >
    <div class="frame_head">
			<h1>Quản lý tài khoản</h1>
	</div>
    <div class="frame_body row" >
   		<div class='col-lg-3'>
    		<div class='frame_tabs'>
		    	<span class="username"><?php echo $data->full_name;?></span>
		        <ul class='users_tabs'>
		        	<li id='tab1' class='users_tabs_name'><i></i><span>Thông tin tài khoản</span></li>
		        	<li id='tab2' class='users_tabs_name'><i></i><span>Sổ địa chỉ</span></li>
		            <li id='tab3' class="users_tabs_name"><i></i><span>Lịch sử giao dịch</span></li>
<!--		            <li id='tab4' class="users_tabs_name"><i></i><span>Thông tin bảo hành</span></li>-->
<!--		            <li id='tab5' class="users_tabs_name"><i></i><span>Nhận bản tin</span></li>-->
		            <li id='tab6' class="users_tabs_name"><i></i><span>List sản phẩm yêu thích</span></li>
		            <li id='tab7' class="users_tabs_name"><i></i> <a class='logout exit' href="<?php echo FSRoute::_('index.php?module=users&task=logout');?>">Thoát</a></li>
		        </ul>
		    </div>
        </div>
        <div class='col-lg-9'>
			<div id='tab_content' class='tab_content'>
			    <h2 class='head_content'>
            		Trang quản trị
            	</h2>
            	<div class="tab_content_inner">
	             Chào mừng các bạn đã đăng nhập vào hệ thống.
	            </div>
	       	</div>
         </div>
    </div>
</div>    
        
        