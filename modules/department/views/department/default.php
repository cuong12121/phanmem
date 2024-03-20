<?php
global $tmpl, $config;
$tmpl -> addStylesheet('owl.carousel','libraries/jquery/owl.carousel.2/assets');
$tmpl -> addScript('owl.carousel.min','libraries/jquery/owl.carousel.2');
// $tmpl -> addScript('jquery-1.11.0.min','libraries/jquery/','top');
$tmpl -> addStylesheet('cat','modules/department/assets/css');
$tmpl -> addScript('cat','modules/department/assets/js','bottom');
$total = count($list);
$i=0;
$tmpl -> addTitle('Hệ thống cửa hàng');
?>	

<div class="wraper-department">
    <div class="title-page">
        Hệ thống cửa hàng
    </div>

    <div class="wrapper-select-add cls">
        <div class="text-left">
            Nhập vị trí của bạn
        </div>
        <select name="province" id="province"  onchange="changeCity22(this.value,'district');" >
            <option value="">Chọn tỉnh / thành phố</option>
            <?php  foreach($regions as $province){ 
                ?>
                <option <?php if(@$_SESSION["city"]==$province->id) echo 'selected="selected"';?> value="<?php echo $province->id;?>">
                    <?php  echo $province->name;?>
                </option>
            <?php }?>
        </select> 
    </div>
    <div class="clear"></div>

    <div class="frame_head clearfix">
        <h1>Hệ thống 
            <span class="change-povince-sp">
            <?php echo @$region_active->name ?>
            </span>
            - <?php echo count($list) ?> cửa hàng
        </h1>
    </div>

    

    <div class="wrapper-ct-depart cf">
        <?php 
            foreach($list as $value){
        ?>
            <div class="wrapper-info-agency cls">
                <div class="info-l">
                    <div class="name">
                        <?php echo $value->name; ?>
                    </div>
                    <h2 class="name-agency" onclick="initialize('<?php echo $value->name;?>',<?php  echo  $value->latitude; ?>,<?php  echo $value->longitude ?>,<?php echo $value->id; ?>,19)"> 
                        Địa chỉ: <?php echo $value->address; ?>
                    </h2>
                    <div class="more_info">
                        <div>Kd: <?php echo $value->more_info; ?></div>
                        <div class="phone">
                            Điện thoại: <?php echo $value->phone?>
                        </div>
                        <div class="email">
                            Email: <?php echo $value->email?>
                        </div>
                    </div>
                
                   

                    <div class="time_wk">
                        Giờ làm việc: <?php echo $value->time_wk?>
                    </div>
                    <a class="link-map" href="<?php echo $value->link_map ?>" title="Chỉ đường">
                        <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="512" viewBox="0 0 24 24" width="512"><path d="m8.75 17.612v4.638c0 .324.208.611.516.713.077.025.156.037.234.037.234 0 .46-.11.604-.306l2.713-3.692z"/><path d="m23.685.139c-.23-.163-.532-.185-.782-.054l-22.5 11.75c-.266.139-.423.423-.401.722.023.3.222.556.505.653l6.255 2.138 13.321-11.39-10.308 12.419 10.483 3.583c.078.026.16.04.242.04.136 0 .271-.037.39-.109.19-.116.319-.311.352-.53l2.75-18.5c.041-.28-.077-.558-.307-.722z"/></svg>
                        Chỉ đường
                    </a>
                </div>

                <div class="list-image-r cls">
                    <div class="owl-carousel">
                        <div class="item">
                            <?php echo set_image_webp($value->image,'large',@$value->name,'owl-lazy',1,''); ?>
                        </div>
                        <div class="item">
                            <?php echo set_image_webp($value->image1,'large',@$value->name,'owl-lazy',1,''); ?>
                        </div>
                        <div class="item">
                            <?php echo set_image_webp($value->image2,'large',@$value->name,'owl-lazy',1,''); ?>
                        </div>
                    </div>
                </div>
                    
            </div>

                
            
        <?php } ?>
    </div>
</div>




