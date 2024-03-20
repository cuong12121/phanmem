<?php $max_ordering = 0; ?>
<table cellspacing="1" class="admintable">
  <table cellpadding="5" class="field_tbl" width="100%" border="1" bordercolor="red" style="margin-top: 5px;">
    <tr>
     
      <th width="15%">Tiêu đề</th>
      <th width="60%">Nội dung</th>
      <th width="10%">Tác giả</th>
      <th width="5%">Phần trăm</th>
      <th width="5%">Điểm</th> 
      <th width="5%" class="delete"> Xóa</th>
    </tr>
    <?php if(!empty($data_details)) {?>

      <?php $k = 0; foreach ($data_details as $detail) { ?>
        <tr id="ctr<?php echo $k; ?>">
      
          <td>
            <textarea rows='4' cols='25' name='ctitle_<?php echo $k; ?>' id='ctitle_<?php echo $k; ?>' ><?php echo $detail-> title; ?></textarea>
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
                <?php if(!empty($author)){  ?>
                    <select name="cauthor_<?php echo $k; ?>" class="select_class">
                      <option value="0">Tác giả</option>
                      <?php
                      foreach ($author as $author_it) {
                      ?>
                      <option <?php echo $author_it->id == $detail->author_id ? "selected" : ""  ?> value="<?php echo $author_it->id ?>"><?php echo $author_it->name ?></option>
                      <?php
                      }
                      ?>
                    </select>
                <?php } ?>
            </td>

            <td>
                <input type="text" value="<?php echo $detail-> percent; ?>" name="cpercent_<?php echo $k; ?>" id="percent_<?php echo $k; ?>">
            </td>

            


          <?php if($detail-> rating_point > 0){ ?>
          <td><?php echo round($detail-> rating_point,2); ?></td>
          <?php }else{ ?>
          <td><input class="ipordering" type="number" min="0" max="5" value="<?php echo $detail-> rating_point; ?>" name="cpoint_<?php echo $k; ?>" id="point_<?php echo $k; ?>"></td>
          <?php } ?>
          
          <td class="delete"><input type="button" value="Xóa" onclick="cdelecte(<?php echo $detail-> id; ?> , <?php echo $k; ?>)" id="cdelete_<?php echo $detail-> id; ?>"></td>
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



  <script>
    var i = 0;

    function addSchedule()
    {
      max_ordering = $('#max_ordering').val();
      area_id = "#tr"+i;
      ordering = parseInt(max_ordering) + i + 1;
      var htmlString = '';

    

        htmlString += "<td width='15%'>" ;
        htmlString +=  " <textarea rows='4' cols='25' name='title_"+i+"' id='title_"+i+"' ></textarea>";
        htmlString += "</td>";
       
        htmlString += "<td width='60%' id='editor_des_"+i+"'>" ;
        htmlString += "</td>";


        htmlString += "<td>";
        <?php if(!empty($author)){  ?>
        htmlString += "<select name='author_"+i+"' class='select_class'>";
        htmlString += "<option value='0'>Tác giả</option>";
        <?php foreach ($author as $author_it){ ?>
        htmlString += "<option value='<?php echo $author_it->id ?>'><?php echo $author_it->name ?></option>";
        <?php } ?>
        htmlString += "</select>";
        <?php } ?>
        htmlString += "</td>";

        

        htmlString += "<td width='5%' >" ;
        htmlString +=  "<input type=\"text\"  name='percent_"+i+"' id='percent_"+i+"'  />";
        htmlString += "</td>";

        htmlString += "<td width='5%' >" ;
        htmlString +=  "<input type=\"number\" min='0' max='5' class='ipordering' name='point_"+i+"' id='point_"+i+"'  />";

        htmlString += "</td>";
        
        htmlString += "<td width='5%' class='delete'>" ;
        htmlString +=  "<input type=\"button\" value='Xóa' onclick='deletetr(\""+i+"\")' id='delete_"+i+"'/>";
        htmlString += "</td>";

      //  alert(htmlString);
      $(area_id).html(htmlString); 
      $.ajax({
        type : 'get',
        url : 'index.php?module=news&view=news&raw=1&task=editor',
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
        url : 'index.php?module=news&view=news&raw=1&task=cdelete',
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
</style>



<script type="text/javascript">
    $(document).ready(function (e) {
        $('.label_up_Reality').on('click', function(){
            var id = $(this).attr('data_id');
            // alert(1111);
            $('#msgReality_'+id).html('');   

            

      })
        $('.multiFilesReality').on('change', function () {
            // alert(11);
            var id = $(this).attr('data_id');
            var text_id = "multiFilesReality_"+id;
            
            var form_data = new FormData();
            var ins = document.getElementById(text_id).files.length;
            // console.log(ins);
            for (var x = 0; x < ins; x++) {
                form_data.append("files[]", document.getElementById(text_id).files[x]);
            }
            $.ajax({

                        url: 'index.php?module=products&view=products&raw=1&task=uploadAjaxImagesReality&id_upload='+id+'&data=<?php echo $uploadConfig;?>")', // point to server-side PHP script 
                        dataType: 'text', // what to expect back from the PHP script
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,
                        type: 'post',
                        success: function (response) {
                            $('#fileQueueReality_'+id).html(response); // display success response from the PHP script
                            $("#feedsReality_"+id).load("index.php?module=products&view=products&raw=1&task=getAjaxImagespnReality&id_upload="+id+"&data=<?php echo $uploadConfig;?>");
                            $('#msgReality_'+id).html('Đã upload xong !');
                            
                        },
                        error: function (response) {
                            $('#fileQueueReality_'+id).html(response); // display error response from the PHP script
                            $("#feedsReality_"+id).load("index.php?module=products&view=products&raw=1&task=getAjaxImagespnReality&id_upload="+id+"&data=<?php echo $uploadConfig;?>");
                        }
                    });
        });
    });

    <?php if(!empty($data_details)) {?>

  <?php $k = 0; foreach ($data_details as $detail) { ?>

    $("#feedsReality_"+<?php echo $detail->id ?>).load("index.php?module=products&view=products&raw=1&task=getAjaxImagespnReality&id_upload=<?php echo $detail->id ?>&data=<?php echo $uploadConfig;?>");
  <?php }} ?>
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

   /* #multiFilesReality:focus + label,
    #multiFilesReality + label:hover {
        background-color: red;
    }*/
</style>
