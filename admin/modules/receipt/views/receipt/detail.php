<link rel="stylesheet" href="<?php echo URL_ROOT.'libraries/jquery/google_map/gg_map.css'?>" />
<style>
#gmap {
  height: 400px;
  margin: 20px 0px;
  width: 100% !important;
}

.controls {
  margin-top: 16px;
  border: 1px solid transparent;
  border-radius: 2px 0 0 2px;
  box-sizing: border-box;
  -moz-box-sizing: border-box;
  height: 32px;
  outline: none;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
}

#pac-input {
  background-color: #fff;
  font-family: Roboto;
  font-size: 15px;
  font-weight: 300;
  margin-left: 12px;
  padding: 15px;
  text-overflow: ellipsis;
  width: 400px;
}

#pac-input:focus {
  border-color: #4d90fe;
}

.pac-container {
  font-family: Roboto;
}

#type-selector {
  color: #fff;
  background-color: #4d90fe;
  padding: 5px 11px 0px 11px;
}

#type-selector label {
  font-family: Roboto;
  font-size: 13px;
  font-weight: 300;
}
</style>
<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>

<!-- FOR TAB -->	
<script>
  $(document).ready(function() {
    // $("#tabs").tabs();
  });
</script>
<?php
$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
// $toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');   

$this -> dt_form_begin(0);
?>
<!--	BASE FIELDS    -->

<div class="frame cls">
  <div class="frame_left">
    <div id="fragment1">
      <a class="title" href="#fragment-1"><span><?php echo FSText::_("Thông tin khách hàng"); ?></span></a>
      <?php include_once 'detail_customer.php';?>
    </div>
    <div id="fragment2">
      <a class="title" href="#fragment-2"><span><?php echo FSText::_("Thông tin sửa chữa"); ?></span></a>
      <?php include_once 'detail_base.php';?>
    </div>
  </div>

<!--   <div class="frame_right">
    <div id="fragment3">
     <a class="title" href="#fragment-3"><span><?php echo FSText::_("Tình trạng máy"); ?></span></a>
     <?php // include_once 'detail_status.php';?>
   </div>
 </div> -->
</div>

<?php 

$this -> dt_form_end(@$data,0);

?>
<style>
.action {
  margin-bottom: 30px;
}
.action a {
  display: inline-block;
  float: left;
  margin-right: 100px;
  padding: 8px 15px;
  border-radius: 6px;
  color: #fff !important;
  font-size: 18px;
}
.xu_ly {
  background: #00bb06;
}
.in_phieu {
  background: #005992;
}
#fragment2 {
  margin-top: 20px;
}
.frame_left {
/*  width: calc(50% - 20px);
  float: left;
  margin-right: 40px;*/
}
.frame_right {
  width: calc(50% - 20px);
  float: right;
}
.frame .col-md-2 {
  width: 30%;
}
.frame .col-md-10 {
  width: 70%;
}
.frame .title {
  display: block;
  padding: 10px;
  background: #3da6ea57;
  margin-bottom: 20px;
  color: #000 !important;
  font-size: 15px;
  border-radius: 4px;
}
</style>
<script type="text/javascript" src="<?php // echo URL_ROOT.'libraries/jquery/google_map/gg_map.js'?>"></script>	
<script>
  function changeCity22($city_id,$id){
    $.ajax({
      type : 'get',
      url : 'index.php?module=address&view=address&raw=1&task=loadDistricts',
      dataType : 'html',
      data: {city_id:$city_id},
      success : function(data){
        $('#'+$id).html(data);
      },
      error : function(XMLHttpRequest, textStatus, errorThrown) {}
    });
    return false;
  }
</script>