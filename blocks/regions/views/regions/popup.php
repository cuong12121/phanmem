<?php 
 global $tmpl; 
 $city_id_cookie = isset($_COOKIE['city_id'])?$_COOKIE['city_id']:0; 
 $url = $_SERVER['REQUEST_URI'];
	$return = base64_encode($url);
 ?>
<?php // if(isset($_COOKIE['city_id'])){?>
	<?php $tmpl -> addStylesheet('popup','blocks/regions/assets/css'); ?>
        <div id="modal_city"  class="modal fade ">
            <div class="modal-dialog">
                <div class="modal-content">
                    
                    
                        <div class="modal-body">
                            <div class="welcome-city">Vui lòng chọn khu vực</div>
                            <div class="popupmiddle">
                                <div class="pupzbutton">

                                	<?php foreach ($regions as $item) {?>
                                		  <a class="button" href="<?php echo FSRoute::_('index.php?module=users&task=city_save&city_id='.$item ->id.'&return='.$return);?>"  />
	                                        <span><?php echo $item -> name; ?></span>
	                                    </a>

									<?php  } ?>
                                   
                                </div>
                                <div class="puzinfo">Chọn địa điểm sẽ giúp bạn có thông tin chính xác nhất về giá và tình trạng hàng tại khu vực đó.</div>
                            </div>
                                                    
                        </div>
                    
                    
                </div>
            </div>
        </div>
    <?php  // }?>