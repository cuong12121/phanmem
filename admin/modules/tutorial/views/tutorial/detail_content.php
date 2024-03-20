<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/colorpicker/css/colorpicker.css" />
<script type="text/javascript" src="../libraries/jquery/colorpicker/js/colorpicker.js"></script>
<script type="text/javascript" src="../libraries/jquery/colorpicker/js/eye.js"></script>
<?php 
  $max_ordering = 0; 
  //$array_types = array( '0' => 'Text',1 => 'Hình ảnh',2=>'Video',3=>'Container');
  $array_types = array( '0' => 'Text',1 => 'Hình ảnh',2=>'Video',3=>'Container',4=>'Hình ảnh + Text');

  $array_obj_types = array();
  foreach($array_types  as $key => $name){
    $array_obj_types[] = (object)array('id'=>($key+1),'name'=>$name);
  }

  $array_range = array( '0' => 'Mặc định',1 => 'Padding-top');

  $array_obj_range = array();
  foreach($array_range  as $key => $name){
    $array_obj_range[] = (object)array('id'=>($key+1),'name'=>$name);
  }

  // echo '<pre>';
  // print_r($array_obj_types);
  // die;

?>

<div class="yy">
  Chú ý: 
  <ul>
    <li> Cấu trúc câu hỏi thường gặp: <span>{{aq:all}}</span></li>
    <li> Cấu trúcTin tức: <span>{{news:all}}</span></li>
    <li> Cấu trúc Video : <span> {{videos:id}}</span> id: là id của video</li>
    <li> Cấu trúc Điểm mạnh : <span> {{cstrength:cid}}</span> cid: là id của danh mục</li>
    <li> Cấu trúc Vật liệu,chất liệu : <span> {{cmaterial:cid}}</span> cid: là id của danh mục</li>
    <li> Cấu trúc Chứng nhận, giải thưởng : <span> {{certifications:cid}}</span> cid: là id của danh mục</li>
    <li> Cấu trúc Nguyên nhân tác động : <span> {{creason:cid}}</span> cid: là id của danh mục</li>
    <li> Cấu trúc Con số thống kê : <span> {{cstatistics:cid}}</span> cid: là id của danh mục</li>
    <li> Tạo nút đặt class : <span>bottom_content</span></li>  
  </ul> 
</div>

<div class="form-horizontal">
<table cellspacing="1" class="admintable">
  <table cellpadding="5" class="field_tbl" width="100%" border="1" bordercolor="red" style="margin-top: 5px;">
    <tr>
     
      <th width="15%">Tiêu đề</th>
      
      <th width="50%">Nội dung</th>
      <th width="20%">Màu sắc</th>
      <th width="5%">Thứ tự</th>
      <th width="5%">Kích hoạt</th> 
      <th width="5%" class="delete"> Xóa</th>
    </tr>
    <?php if(!empty($data_details)) {?>

      <?php $k = 0; foreach ($data_details as $detail) { ?>
        <tr id="ctr<?php echo $k; ?>">
      
          <td>

              <label>Tên chính</label>
              <textarea class = 'form-control' rows='3' cols='25' name='ctitle_<?php echo $k; ?>' id='ctitle_<?php echo $k; ?>' ><?php echo $detail-> title; ?>
              </textarea>


             <label>Tên mô tả</label>
             <textarea rows='3' class = 'form-control' cols='25' name='ctitle_core_<?php echo $k; ?>' id='ctitle_core_<?php echo $k; ?>' ><?php echo $detail-> title_core; ?></textarea>
             
             <label for='cis_title_<?php echo $k; ?>'>Hiển thị tên: </label>
              <input type="checkbox" <?php echo (($detail -> is_title) == '1' )?'checked="checked"':''?> class='is_checkbox' name='cis_title_<?php echo $k; ?>' id='cis_title_<?php echo $k; ?>' />
              <div class="clear"></div>

              <label for='cis_menu_<?php echo $k; ?>'>Hiển thị menu: </label>
              <input type="checkbox" <?php echo (($detail -> is_menu) == '1' )?'checked="checked"':''?> class='is_checkbox' name='cis_menu_<?php echo $k; ?>' id='cis_menu_<?php echo $k; ?>' />

              <div class = 'check_is_menu' id = 'ccheck_is_menu_<?php echo $k; ?>'>
              <label>Tên menu</label>
              <textarea class = 'form-control' rows='3' cols='25' name='ctitle_menu_<?php echo $k; ?>' id='ctitle_menu_<?php echo $k; ?>' ><?php echo $detail-> title_menu; ?></textarea>

                <label>Ảnh menu</label>
                  <?php $uploadConfig = base64_encode('edit|'.$detail->id);  ?>
                    <div id="feedsContent_<?php echo $detail->id;  ?>">
                        <div id="sort_<?php echo $detail->id;?>">
                          <?php if($detail -> img_menu) { ?>
                            <div class="image-area-single">
                              <p class="img">

                                <img width="90px" height="90px" src="<?php echo URL_ROOT.str_replace('/original/','/small/', $detail -> img_menu)?>" alt="Ảnh">
                              </p>
                              <p class="del" align="center"><span onclick="removeElementimageContent('sort_<?php echo $detail->id;?>','<?php echo $detail->id; ?>')"><img src="../libraries/uploadify/delete.png"/></span></p>
                            </div>
                          <?php } ?>
                        </div>
                    </div>  

                    <input type="file" id="update_img_<?php echo $detail->id; ?>" name="files" onchange="changeElementImageContent('sort_<?php echo $detail->id;?>','<?php echo $detail->id; ?>','<?php echo $uploadConfig; ?>')"/>
             
              </div>     
          </td>
        
          <td><?php
          $t_des =  str_replace("\\r\\n",'',$detail-> description);
          $t_des =  str_replace("<li>rn</li>",'',$t_des);
          $t_des =  str_replace("rn",'',$t_des);
          $name = "cdes_".$k;
          $value =  $t_des;
          $kc = 'oFCKeditor_'.$name;
          $oFCKeditor[$kc] = new FCKeditor($name) ;
          $oFCKeditor[$kc]->BasePath  =  '../libraries/wysiwyg_editor/' ;
          $oFCKeditor[$kc]->Value   = stripslashes(@$value);
          $oFCKeditor[$kc]->Width = 60;
          $oFCKeditor[$kc]->Height = 1;
          echo $oFCKeditor[$kc]->Create() ;
          ?></td>
            

            <td>
              
                <label>Loại </label>
                  <select name='ctypes_<?php echo $k; ?>' class='select_class form-control '>";
                  <?php foreach ($array_obj_types as $type){ ?>
                     <option <?php echo $type->id == $detail->types ? "selected" : ""  ?>  value='<?php echo $type->id ?>'><?php echo $type->name ?></option>
                  <?php } ?>
                 </select>

                <label>Khoảng cách</label>
                  <select name='crange_<?php echo $k; ?>' class='select_class form-control '>";
                  <?php foreach ($array_obj_range as $range){ ?>
                     <option <?php echo $range->id == $detail-> range ? "selected" : ""  ?>  value='<?php echo $range->id ?>'><?php echo $range->name ?></option>
                  <?php } ?>
                 </select>


                <label>Màu text </label>                           
                <div class="control_color">
                  <input type="text" class = 'form-control' value="<?php echo $detail-> color; ?>" name='ccolor_<?php echo $k; ?>' id='ccolor_<?php echo $k; ?>'  />
                                                             
                  <div class="form-control_color" id="cl_color_<?php echo $k; ?>">
                    <div style="background-color:<?php echo ($detail -> color)?$detail -> color:'#0000ff';?>"></div>
                  </div>
                </div>

                <div class="clear"></div>

                <label>Background </label>
                <div class="control_color">
                  <input type="text" class = 'form-control' value="<?php echo $detail-> background; ?>" name='cbackground_<?php echo $k; ?>' id='cbackground_<?php echo $k; ?>'  />

                  <div class="form-control_color" id="cl_background_<?php echo $k; ?>">
                    <div style="background-color:<?php echo ($detail -> background)?$detail -> background:'#0000ff';?>"></div>
                  </div>
                </div>
                <div class="clear"></div>
             
                <label for='cis_curved_<?php echo $k; ?>'>Hiển thị viền cong </label>

                <input type="checkbox" <?php echo (($detail -> is_curved) == '1' )?'checked="checked"':''?>  class = 'is_checkbox'  name='cis_curved_<?php echo $k; ?>' id='cis_curved_<?php echo $k; ?>'  />

                <label >Màu viền cong </label>
               

                <div class="control_color">
                   <input type="text" class = 'form-control' value="<?php echo $detail-> color_curved; ?>"  name='ccolor_curved_<?php echo $k; ?>' id='ccolor_curved_<?php echo $k; ?>'  />
                                                             
                  <div class="form-control_color" id="cl_color_curved_<?php echo $k; ?>">
                    <div style="background-color:<?php echo ($detail -> color_curved)?$detail -> color_curved:'#0000ff';?>"></div>
                  </div>
                </div>
                
                <div class="clear"></div>

            </td>

          <td >
            <input class = 'form-control form-control_ordering' type="number" min="0" value="<?php echo $detail-> ordering; ?>" name="cordering_<?php echo $k; ?>" id="cordering_<?php echo $k; ?>"></td>    
          <td >  

            <input type="checkbox" <?php echo (($detail -> published) == '1' )?'checked="checked"':''?> class='' name='cpublished_<?php echo $k ;?>' id='cpublished_<?php echo $k ;?>'  />
          </td>
          
        
          
          <td class="delete">
            <input type="button" value="Xóa" onclick="cdelecte(<?php echo $detail-> id; ?> , <?php echo $k; ?>)" id="cdelete_<?php echo $detail-> id; ?>">
          </td>
          <input type="hidden" value="<?php echo $detail-> id; ?>" name="cid_<?php echo $k; ?>" id="cid_<?php echo $k; ?>">
        </tr>
        <?php $k++; } ?>
        <input type="hidden" value="<?php echo $k; ?>" name="sumc">
      <?php } ?>
      <?php for( $i = 0 ; $i< 10; $i ++ ) {?>
        <tr id="tr<?php echo $i; ?>" ></tr>
      <?php }?>
      <input type="hidden" value="<?php echo $max_ordering;?>" name="max_ordering" id = "max_ordering" />
    </table>
    <a class='add_schedule' href="javascript:void(0);" onclick="addSchedule()" > <?php echo FSText :: _("+ Thêm"); ?> </a>
  </table>

</div>

  <script>
    var i = 0;

    function addSchedule()
    {
      max_ordering = $('#max_ordering').val();
      area_id = "#tr"+i;
      ordering = parseInt(max_ordering) + i + 1;
      var htmlString = '';

      //Tên
        htmlString += "<td width='15%'>" ;
        htmlString += "<label>Tên chính</label>";
        htmlString += " <textarea class = 'form-control' rows='3' cols='25' name='title_"+i+"' id='title_"+i+"' ></textarea>";
        htmlString += "<label>Tên mô tả</label>";
        htmlString += "<textarea rows='3' class = 'form-control' cols='25' name='title_core_"+i+"' id='title_core_"+i+"' ></textarea>";

         

        //htmlString += "<label for='cis_title_<?php //echo $k; ?>'>Hiển thị tên: </label>"; 
        htmlString += "<label for='is_title_"+i+"'>Hiển thị tên: </label>";
              
              
         htmlString += "<input type='checkbox' checked='checked' class='is_checkbox' name='is_title_"+i+"' id='is_title_"+i+"' />";
         htmlString += "<div class='clear'></div>";

        htmlString += "<label for='is_menu_"+i+"'>Hiển thị menu: </label>";
        htmlString += "<input type=\"checkbox\"  class='is_checkbox' name='is_menu_"+i+"' id='is_menu_"+i+"'  />";

        htmlString += "<div class = 'check_is_menu' id = 'check_is_menu_"+i+"'>";
          htmlString += "<label>Tên menu</label>";
          htmlString += "<textarea class = 'form-control' rows='3' cols='25' name='title_menu_"+i+"' id='title_menu_"+i+"' ></textarea>";
          htmlString += "Vui lòng chọn và nhấn Apply trước khi thêm ảnh";
        htmlString +="</div>";       
        htmlString += "</td>";


        

        // Nội dung
        htmlString += "<td width='60%' id='editor_des_"+i+"'>" ;
        htmlString += "</td>";

        // màu sắc và loại
        htmlString += "<td width='5%'> ";
              //Loại
            htmlString += "<label>Loại </label>";
            htmlString += "<select name='types_"+i+"' class='select_class form-control '>";
            <?php foreach ($array_obj_types as $type){ ?>
               htmlString += "<option value='<?php echo $type->id ?>'><?php echo $type->name ?></option>";
            <?php } ?>
            htmlString += "</select>"; 
            // khoảng cách 
            htmlString += "<label>Khoảng cách </label>";
            htmlString += "<select name='range_"+i+"' class='select_class form-control '>";
            <?php foreach ($array_obj_range as $range){ ?>
               htmlString += "<option value='<?php echo $range->id ?>'><?php echo $range->name ?></option>";
            <?php } ?>
            htmlString += "</select>";   
        
          //màu
          htmlString += "<label>Màu text </label>";
          htmlString += "<input type=\"text\" class = 'form-control' name='color_"+i+"' id='color_"+i+"'  />";
          htmlString += "<label>Background </label>";
          htmlString += "<input type=\"text\" class = 'form-control' name='background_"+i+"' id='background_"+i+"'  />";

          htmlString += "<label for='is_curved_"+i+"'>Hiển thị viền cong </label>";
          htmlString += "<input type=\"checkbox\" class = 'is_checkbox'  name='is_curved_"+i+"' id='is_curved_"+i+"'  />";

          htmlString += "<label >Màu viền cong </label>";
          htmlString += "<input type=\"text\" class = 'form-control'  name='color_curved_"+i+"' id='color_curved_"+i+"'  />";

        htmlString += "</td>";

        //Thứ tự
        htmlString += "<td width='5%'>";
        htmlString +=  "<input class = 'form-control form-control_ordering' type=\"number\" min='0' class='number' name='ordering_"+i+"' id='ordering_"+i+"'  />";
        htmlString += "</td>";
        //kích hoạt
         htmlString += "<td width='5%' >";
        htmlString +=  "<input type=\"checkbox\"  class='' name='published_"+i+"' id='published_"+i+"'  />";
        htmlString += "</td>";

        htmlString += "<td width='5%' class='delete'>" ;
        htmlString +=  "<input type=\"button\" value='Xóa' onclick='deletetr(\""+i+"\")' id='delete_"+i+"'/>";
        htmlString += "</td>";

      //  alert(htmlString);
      $(area_id).html(htmlString); 
      $.ajax({
        type : 'get',
        url : 'index.php?module=tutorial&view=tutorial&raw=1&task=editor',
        dataType : 'html',
        data: {stt:i},
        success : function(data){
          $('#editor_des_'+i).html(data);
        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {}
      });    
      setTimeout(function(){ i++; }, 2000);
      $("#new_field_total").val(i);
  }

  function deletetr(i){
    $('#tr'+i).remove();
  }

  function cdelecte(i,k) {
    var r = confirm("Bạn có chắc muốn xóa bản ghi này?!");
    if (r == true) {
      $('#ctr'+k).remove();
      $.ajax({
        type : 'get',
        url : 'index.php?module=tutorial&view=tutorial&raw=1&task=cdelete',
        dataType : 'html',
        data: {id:i},
        success : function(data){
          //$('#editor_des_'+i).html(data);
        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {}
      });   
    } else {
    }

  }
</script>

<style>
.add_schedule{
  cursor: pointer;
  background: gray;
  color: #fff !important;
  padding: 6px 10px;
  border-radius: 5px;
  margin-top: 10px !important;
  display: inline-block;
}
th {
  padding: 3px 0px;
  text-align: center;
}
.ipordering {
  width: 50px;
}
.ipname {
  width: 100px;
}
.control_color input {
   width: calc(100% - 40px)!important;
   float: left;
}
</style>



<script type="text/javascript">
  $(document).ready(function (e) {
        $('.label_up_Reality').on('click', function(){
            var id = $(this).attr('data_id');
            // alert(1111);
            $('#msgReality_'+id).html('');           
      });

      $('.form-control_color').on('click', function () {
          var idd = $(this).attr('id');
          //alert(color);                    
          if(idd.indexOf('cl_background_') == 0){
            icd = idd.replace('cl_background_','cbackground_');

          }else if(idd.indexOf('cl_color_') == 0){
            icd = idd.replace('cl_color_','ccolor_');

          }else if(idd.indexOf('cl_color_curved_') == 0){
            idd.indexOf('ccolor_curved_') == 0
          }

          $('#'+idd).ColorPicker({
            color: '#0000ff',
            onShow: function (colpkr) {
              $(colpkr).fadeIn(500);
              return false;
            },
            onHide: function (colpkr) {
              $(colpkr).fadeOut(500);
              return false;
            },
            onChange: function (hsb, hex, rgb) {
              $('#'+idd+' div').css('backgroundColor', '#' + hex);
              $('#'+icd).val( '#' + hex );
            }
          });
      });
  });


  function changeElementImageContent(divNum,data,uploadConfig) {

      var fileInput = document.getElementById('update_img_'+data);
      var form_data = new FormData();
      var ins = fileInput.files.length;
      //alert(ins);
      for (var x = 0; x < ins; x++) {
        form_data.append("file_change[]", fileInput.files[x]);
      }
           // alert(divNum);
           $.ajax({
            url: "index2.php?module=tutorial&view=tutorial&raw=1&task=change_other_image_content&data="+data,
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (response) {
                $('#fileQueueContent').html(response); // display success response from the PHP script
                $("#feedsContent_"+data).load("index.php?module=tutorial&view=tutorial&raw=1&task=getAjaxImagespnContent&data="+uploadConfig);
                // $('#msgReality').html('Đã upload xong !');
                
            },
            error: function(){
              alert("Không thay được ảnh(-.-)");
              $("#feedsContent_"+data).load("index.php?module=tutorial&view=tutorial&raw=1&task=getAjaxImagespnContent&data="+uploadConfig);
            }
        });
       }

    function removeElementimageContent(divNum,data) {
    if (confirm('Bạn chắc chắn muốn xóa ảnh này?')){
      var d = document.getElementById('feedsContent_'+data);
      var olddiv = document.getElementById(divNum);
      $.ajax({
        url: "index.php?module=tutorial&view=tutorial&raw=1&task=delete_other_image_Content",
        type: "get",
        data: "data="+data,
        error: function(){
          alert("Lỗi xoa dữ liệu");
        },
        success: function(){

          d.removeChild(olddiv);
        }
      });
    }else{
      return false;
    }
  }



</script>
<style>
    .msgReality {
        color: #3da6ea;
        font-size: 15px;
    }
    .multiFilesReality {
        width: 0.1px;
        height: 0.1px;
        opacity: 0;
        overflow: hidden;
        position: absolute;
        z-index: -1;
    }
    .label_up_Reality{
        font-size: 1.25em;
        font-weight: 700;
        color: white;
        background-color: black;
        display: inline-block;
        cursor: pointer;
        padding: 10px 20px;
        box-sizing: border-box;
        border-radius: 20px;
        transition: 0.5s;
    }
    .is_checkbox {
           margin-left: 10px !important;
    }
    label {
       margin-top: 15px !important;
    }
    .select_class {
      width: 100% !important;
    }
    .form-control_ordering {
          width: 70px !important;
    }
    /*.form-control_color {
      width: 70px !important;
      padding: 0 !important;
    }*/

   /* #multiFilesReality:focus + label,
    #multiFilesReality + label:hover {
        background-color: red;
    }*/
</style>

<style>

.form-control_color {
    background: url("templates/default/images/select_color.png");
    height: 36px;
    position: relative;
    width: 36px;
    float: right;
}
.form-control_color div {
    background: url("templates/default/images/select_color.png") repeat scroll center center;
    height: 30px;
    left: 3px;
    position: absolute;
    top: 3px;
    width: 30px;
}
  .yy li span{
    color: red;
  }
</style>