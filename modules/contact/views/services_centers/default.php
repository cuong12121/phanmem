<?php
global $config,$tmpl; 
$tmpl->addStylesheet('services_center','modules/contact/assets/css'); 
$tmpl -> addScript('services_centers','modules/contact/assets/js');
$tmpl -> addTitle('Trung tâm bảo hành');
?>

<div class="services_center_page">
	<h1 class="page_title">
		<span><?php echo FSText::_("Trung tâm bảo hành");?></span>
	</h1>

	<div class="wrapper-select-add cls">
		<form name="services_center">
			<div class="text-left">
	            Nhập vị trí của bạn
	        </div>
			<select name="manufactories" id="manufactories_sl" >
	            <option value="">Chọn hãng</option>
	            <?php  foreach($manufactories as $manu){ 
	                ?>
	                <option value="<?php echo $manu->id;?>">
	                    <?php  echo $manu->name;?>
	                </option>
	            <?php }?>
	        </select>
			
	        <select name="province" id="province_sl" >
	            <option value="">Chọn khu vực</option>
	            <?php  foreach($regions as $province){ 
	                ?>
	                <option value="<?php echo $province->id;?>">
	                    <?php  echo $province->name;?>
	                </option>
	            <?php }?>
	        </select>
	        <a href="javascript:void(0)" class="btn_search_add" title="Tìm kiếm">Tìm kiếm</a>
		</form>
    </div>

    <div class="clear"></div>

    <div class="wrapper-list-sv cls">
    	<div class="wrapper-list-all">
		
		</div>
    </div>


</div>
